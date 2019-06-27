<?php
App::uses('AppController', 'Controller');

class PersonasController extends AppController {

	var $name = 'Personas';
	var $paginate = array('Persona' => array('limit' => 3, 'order' => 'Persona.id DESC'));

	function beforeFilter(){
        parent::beforeFilter();
	    /* ACCESOS SEGÚN ROLES DE USUARIOS (INICIO).
        *Si el usuario tiene un rol de superadmin le damos acceso a todo. Si no es así (se trata de un usuario "admin o usuario") tendrá acceso sólo a las acciones que les correspondan.
        */
        switch($this->Auth->user('role'))
        {
            case 'superadmin':
                if ($this->Auth->user('puesto') === 'Sistemas') {
                    $this->Auth->allow();               
                } else {
                    //En caso de ser ATEI
                    $this->Auth->allow('index', 'add' , 'view', 'edit', 'autocompletePersonas','listarBarrios','listarAsentamientos');    
                }
                break;
            case 'usuario':
            case 'admin':
                $this->Auth->allow('index', 'add' , 'view', 'edit', 'autocompletePersonas','listarBarrios','listarAsentamientos');
                break;
        }
        /* FIN */
		/* FUNCIÓN PRIVADA "LISTS" (INICIO).
        *Si se ejecutan las acciones add/edit activa la función privada "lists".
		*/
		if ($this->ifActionIs(array('add', 'edit'))) {
			$this->__lists();
		}
		/* FIN */
		App::uses('HttpSocket', 'Network/Http');
    }

	public function index() {
		$this->Persona->recursive = 0;
		$this->paginate['Persona']['limit'] = 4;
		$this->paginate['Persona']['order'] = array('Persona.id' => 'ASC');
		/* PAGINACIÓN SEGÚN ROLES DE USUARIOS (INICIO).
		*  Sí es "admin" no muestra alumnos ni familiares.
		*/
		$userCentroId = $this->getUserCentroId();
		$userRole = $this->Auth->user('role');
		if ($userRole === 'admin') {
			$this->paginate['Persona']['conditions'] = array('Persona.id' => 0);
		}
		/* FIN */
		/* PAGINACIÓN SEGÚN CRITERIOS DE BÚSQUEDAS (INICIO).
		*Pagina según búsquedas simultáneas ya sea por NOMBRE COMPLETO y/o DNI.
		*/
		$this->redirectToNamed();
		$conditions = array();
		if(!empty($this->params['named']['nombre_completo_persona']))
		{
			$conditions['Persona.nombre_completo_persona ='] = $this->params['named']['nombre_completo_persona'];
		}
		if(!empty($this->params['named']['documento_nro']))
		{
			$conditions['Persona.documento_nro ='] = $this->params['named']['documento_nro'];
		}
        $personas = $this->paginate('Persona', $conditions);
        /* Evalúa si existe foto (INICIO). */
		if(empty($this->params['named']['foto'])){
			$foto = 0;
		} else {
			$foto = 1;
		}
		/* FIN */
		/* SETS DE DATOS PARA COMBOBOXS DEL FORM SEARCH (INICIO).*/
		$this->loadModel('Ciudad');
        $this->Ciudad->Behaviors->load('Containable');
        $this->Ciudad->recursive=0;
        $ciudades = $this->Ciudad->find('list', array('fields' => array('nombre'),'contain'=>false));
        // Obtiene el nivel del centro para que se muestre o no el botón "AGREGAR" persona.
     	$this->loadModel('Centro');
     	$this->Centro->Behaviors->load('Containable');
        $this->Centro->recursive=0;
		$nivelCentro = $this->Centro->find('list', array(
			'fields'=>array('id','nivel_servicio'), 
			'contain'=>false,
			'conditions'=>array('id'=>$userCentroId)));
		$nivelCentroId = $this->Centro->find('list', array(
			'fields'=>array('id'),
			'contain'=>false,
			'conditions'=>array('nivel_servicio'=>$nivelCentro)));
		$nivelCentroArray = $this->Centro->findById($nivelCentroId, 'nivel_servicio');
		$nivelCentroString = $nivelCentroArray['Centro']['nivel_servicio'];
		/* FIN */
		$this->set(compact('personas', 'foto', 'ciudades', 'nivelCentroString'));
	}

	public function view($id = null) {
		$this->Persona->recursive = 0;
		if (!$id) {
			$this->Session->setFlash('Persona no valida', 'default', array('class' => 'alert alert-danger'));
			$this->redirect(array('action' => 'index'));
		}
		$options = array('conditions' => array('Persona.' . $this->Persona->primaryKey => $id));
		$this->set('persona', $this->Persona->read(null, $id));
        //Evalúa si existe foto.
		if(empty($this->params['named']['foto'])){
			$foto = 0;
		} else {
			$foto = 1;
		}
		// Obtención del perfil de alumno de la persona.
		$personaAlumnoArray = $this->Persona->findById($id,'alumno');
		$personaAlumno = $personaAlumnoArray['Persona']['alumno'];
		// Si la persona es alumno, obtiene sus inscripciones registradas.
		if ($personaAlumno == 1) {
			// Obtención del DNI de la persona.
			$personaDniArray = $this->Persona->findById($id,'documento_nro');
			$personaDni = $personaDniArray['Persona']['documento_nro'];
			$this->loadModel('Inscripcion');
			$this->Inscripcion->recursive = 0;
			$this->Inscripcion->Behaviors->load('Containable');
			$inscripcionesCentrosRelacionados = $this->Inscripcion->find('list',array(
				'contain' => false,
				'conditions' => array(
					'Inscripcion.legajo_nro LIKE' => '%'.$personaDni.'%'),
				'order' => 'Inscripcion.fecha_alta'	
				)
			);
			//Obtención de datos del centro.
			$this->loadModel('Centro');
		    $this->Centro->recursive = 0;
			$this->Centro->Behaviors->load('Containable');
			$centroNombre = $this->Centro->find('list');
			// Visualización de los datos de las inscripciones registradas hasta el momento:
			echo ('<div class="panel panel-default"><div class="panel-heading"><span class="glyphicon glyphicon-education" aria-hidden="true"></span> TRAYECTORIA ESCOLAR ACTUAL: </div>');
			foreach($inscripcionesCentrosRelacionados as $id=>$legajo) {
				$inscripcionDatos = $this->Inscripcion->findById($id, 'legajo_nro, centro_id, estado_inscripcion');
				echo ('<li class="list-group-item list-group-item-info"><span class="glyphicon glyphicon-triangle-right" aria-hidden="true"></span>'
				.' Código de Inscripción Nº: '.$inscripcionDatos['Inscripcion']['legajo_nro'].' | '.' Institución: '
				.$centroNombre[$inscripcionDatos['Inscripcion']['centro_id']].' | '.' Estado: '
				.$inscripcionDatos['Inscripcion']['estado_inscripcion'].'</li>');
			}
			echo ('</div>');
		}	
		//Obtención del nombre de la ciudad del domicilio actual.
		$idPersona = $this->Persona->id;
		$personaCiudadIdArray = $this->Persona->findById($idPersona,'ciudad_id');
		if(isset($personaCiudadIdArray['Persona']['ciudad_id'])) {
			$personaCiudadId = $personaCiudadIdArray['Persona']['ciudad_id'];
			$this->loadModel('Ciudad');
			$this->Ciudad->recursive = 0;
			$this->Ciudad->Behaviors->load('Containable');
			$personaCiudadNombreArray = $this->Ciudad->findById($personaCiudadId,'nombre');
			$personaCiudadNombre = $personaCiudadNombreArray['Ciudad']['nombre'];
			$this->set(compact('personaCiudadNombre'));
		}
		//Obtención del nombre del barrio del domicilio actual.
    	$personaBarrioIdArray = $this->Persona->findById($idPersona,'barrio_id');
		if(isset($personaBarrioIdArray['Persona']['barrio_id'])) {
			$personaBarrioId = $personaBarrioIdArray['Persona']['barrio_id'];
			$this->loadModel('Barrio');
			$this->Barrio->recursive = 0;
			$this->Barrio->Behaviors->load('Containable');
			$personaBarrioNombreArray = $this->Barrio->findById($personaBarrioId,'nombre');
			$personaBarrioNombre = $personaBarrioNombreArray['Barrio']['nombre'];
			$this->set(compact('personaBarrioNombre'));
		}	
		//Obtención del nombre del asentamiento del domicilio actual.
    	$personaAsentamientoIdArray = $this->Persona->findById($idPersona,'asentamiento_id');
		if(isset($personaAsentamientoIdArray['Persona']['asentamiento_id'])) {
			$personaAsentamientoId = $personaAsentamientoIdArray['Persona']['asentamiento_id'];
			$this->loadModel('Asentamiento');
			$this->Asentamiento->recursive = 0;
			$this->Asentamiento->Behaviors->load('Containable');
			$personaAsentamientoNombreArray = $this->Asentamiento->findById($personaAsentamientoId,'nombre');
			$personaAsentamientoNombre = $personaAsentamientoNombreArray['Asentamiento']['nombre'];
			$this->set(compact('personaAsentamientoNombre'));	
		}
		//Envío de datos a la vista.
		$this->set(compact('foto'));
     }

	public function add() {
		$this->Persona->recursive = 0;
		//abort if cancel button was pressed
        if(isset($this->params['data']['cancel'])){
                $this->Session->setFlash('Los cambios no fueron guardados. Agregación cancelada.', 'default', array('class' => 'alert alert-warning'));
                $this->redirect( array( 'action' => 'index' ));
		}
		if (!empty($this->data)) {
			$this->Persona->create();
		    // Antes de guardar pasa a mayúsculas el nombre completo.
			$apellidosMayuscula = strtr(strtoupper($this->request->data['Persona']['apellidos']), "àèìòùáéíóúçñäëïöü","ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ");
		  	$nombresMayuscula = strtr(strtoupper($this->request->data['Persona']['nombres']), "àèìòùáéíóúçñäëïöü","ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ");
			// Genera el nombre completo en mayúsculas y se deja en los datos que se intentaran guardar
			$this->request->data['Persona']['apellidos'] = $apellidosMayuscula;
			$this->request->data['Persona']['nombres'] = $nombresMayuscula;
			// Antes de guardar calcula la edad, por algun motivo no puedo usar en la vista el nombre fecha_nac
			$fechaNacimiento = $this->request->data['Persona']['fecha_nacimiento'];
			if(!empty($fechaNacimiento)) {
			  $fechaNacimiento = explode('/',$fechaNacimiento);
			  $day = $fechaNacimiento[0];
			  $month = $fechaNacimiento[1];
			  $year = $fechaNacimiento[2];
			  $this->request->data['Persona']['fecha_nac'] = [
				  'day' => $day,
				  'month' => $month,
				  'year' => $year
			  ];
			// Calcula la edad y se deja en los datos que se intentaran guardar
			$this->request->data['Persona']['edad'] = $this->__getEdad($day, $month, $year);
			}
			if ($this->Persona->save($this->data)) {
				$this->Session->setFlash('La persona ha sido grabada.', 'default', array('class' => 'alert alert-success'));
				//$inserted_id = $this->Persona->id;
				//$this->redirect(array('action' => 'view', $inserted_id));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('La persona no fué grabada. Intentelo nuevamente.', 'default', array('class' => 'alert alert-danger'));
			}
		}
		$this->set(compact('fechaNacimiento'));
	}

	function edit($id = null) {
	    $this->Persona->recursive = 0;
	    if (!$id && empty($this->data)) {
			$this->Session->setFlash('Persona no válida', 'default', array('class' => 'alert alert-warning'));
			$this->redirect(array('action' => 'index'));
		}
		//Consulta sí es familiar y/o alumno para definir permiso de edición.
		$personaEsFamiliarAlumnoArray = $this->Persona->findById($id,'familiar, alumno');
	    $personaEsFamiliar = $personaEsFamiliarAlumnoArray['Persona']['familiar'];
		$personaEsAlumno = $personaEsFamiliarAlumnoArray['Persona']['alumno'];
		//Sí no es familiar no limita la edición a los "admin" del centro.
		if ($personaEsFamiliar == 0 || $personaEsAlumno == 1) :
			if(!$this->adminCanEdit($id)) {
				$this->Session->setFlash('No tiene permisos para editar a esta persona, no pertenece a su establecimiento', 'default', array('class' => 'alert alert-warning'));
				$this->redirect(array('action' => 'index'));
			}
		endif;
		if (!empty($this->data)) {
		  //abort if cancel button was pressed
        	if(isset($this->params['data']['cancel'])) {
                $this->Session->setFlash('Los cambios no fueron guardados. Edición cancelada.', 'default', array('class' => 'alert alert-warning'));
                $this->redirect( array( 'action' => 'index' ));
		  	}
          	// Antes de guardar pasa a mayúsculas el nombre completo.
		  	$apellidosMayuscula = strtr(strtoupper($this->request->data['Persona']['apellidos']), "àèìòùáéíóúçñäëïöü","ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ");
		  	$nombresMayuscula = strtr(strtoupper($this->request->data['Persona']['nombres']), "àèìòùáéíóúçñäëïöü","ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ");
		  	// Genera el nombre completo en mayúsculas y se deja en los datos que se intentaran guardar
		  	$this->request->data['Persona']['apellidos'] = $apellidosMayuscula;
		  	$this->request->data['Persona']['nombres'] = $nombresMayuscula;
    	  	// Antes de guardar calcula la edad
  		  	$fechaNacimiento = $this->request->data['Persona']['fecha_nacimiento'];
			if(!empty($fechaNacimiento)) {
				$fechaNacimiento = explode('/',$fechaNacimiento);
				$day = $fechaNacimiento[0];
				$month = $fechaNacimiento[1];
				$year = $fechaNacimiento[2];
				// Calcula la edad y se deja en los datos que se intentaran guardar
				$this->request->data['Persona']['edad'] = $this->__getEdad($day, $month, $year);
				// Es necesario para guardar en la DB
				$this->request->data['Persona']['fecha_nac'] = [
					'day' => $day,
					'month' => $month,
					'year' => $year
				];
			}
		  	if ($this->Persona->save($this->data)) {
				$this->Session->setFlash('La persona ha sido grabada', 'default', array('class' => 'alert alert-success'));
				$inserted_id = $this->Persona->id;
				$this->redirect(array('action' => 'view', $inserted_id));
			} else {
				$this->Session->setFlash('La persona no ha sido grabado. Intentelo nuevamente.', 'default', array('class' => 'alert alert-danger'));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Persona->read(null, $id);
			list($año,$mes,$dia) = explode('-',$this->request->data['Persona']['fecha_nac']);
			$fechaNacimiento =  "$dia/$mes/$año";
		}
		// Fuerza guardar datos.
		$idPersona = $this->Persona->id;
		$barrioIdArray = $this->Persona->findById($idPersona, 'barrio_id');
		$barrioId = $barrioIdArray['Persona']['barrio_id'];
		$this->loadModel('Barrio');
        $this->Barrio->recursive = 0;
        $this->Barrio->Behaviors->load('Containable');    
        $barrioNombreArray = $this->Barrio->findById($barrioId, 'nombre');
		$barrioNombre = $barrioNombreArray['Barrio']['nombre'];
		// Esta fecha tiene el formato dia/mes/año
		$this->set(compact('fechaNacimiento', 'barrioNombre'));
	}

	public function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash('Id no válido para la persona', 'default', array('class' => 'alert alert-warning'));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Alumno->delete($id)) {
			$this->Session->setFlash('La persona ha sido borrado', 'default', array('class' => 'alert alert-success'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash('La persona no fue borrado', 'default', array('class' => 'alert alert-danger'));
		$this->redirect(array('action' => 'index'));
	}

	//Métodos privados
	private function __lists(){
	    $this->loadModel('Ciudad');
   		$this->Ciudad->recursive = 0;
        $this->Ciudad->Behaviors->load('Containable');
   		$ciudades = $this->Ciudad->find('list', array('fields' => array('nombre'),'contain'=>false));
   		$this->loadModel('Barrio');
   		$this->Barrio->recursive = 0;
   		$this->Barrio->Behaviors->load('Containable');
       	$barrios = $this->Barrio->find('list', array('fields' => array('nombre'),'contain'=>false));
       	$this->loadModel('PuebloOriginario');
       	$this->PuebloOriginario->recursive = 0;
       	$this->PuebloOriginario->Behaviors->load('Containable');
	 	$nativos = $this->PuebloOriginario->find('list', array('fields' => array('nombre'),'contain'=>false));
	 	$this->loadModel('Asentamiento');
	  	$this->Asentamiento->recursive = 0;
	  	$this->Asentamiento->Behaviors->load('Containable');
	  	$asentamientos = $this->Asentamiento->find('list', array('fields' => array('nombre'),'contain'=>false));
    	$this->set(compact('ciudades', 'barrios', 'nativos', 'asentamientos'));
	}

	public function listarBarrios($id) {
		if (is_numeric($id)) {
			$this->layout = 'ajax';
			$this->loadModel('Barrio');
			$lista_barrios=$this->Barrio->find('list',array('conditions' => array('ciudad_id' => $id)));
			$this->set('lista_barrios',$lista_barrios);
	    }
		echo json_encode($lista_barrios);
		$this->autoRender = false;
	}
	
	public function listarAsentamientos($id) {
		if (is_numeric($id)) {
			$this->layout = 'ajax';
			$this->loadModel('Asentamiento');
			$lista_asentamientos=$this->Asentamiento->find('list',array('conditions' => array('Asentamiento.ciudad_id' => $id)));
			$this->set('lista_asentamientos',$lista_asentamientos);
	    }
		echo json_encode($lista_asentamientos);
		$this->autoRender = false;
	}

	//Métodos Privados
	
	private function __getEdad($day, $month, $year) {
		$from = new DateTime($year . '-' . $month . '-' . $day );
		$to   = new DateTime('today');
		return $from->diff($to)->y;
    }
	
	private function adminCanEdit($personaId) {
		//Se obtiene el rol del usuario
		$userRole = $this->Auth->user('role');
		$userData = $this->Auth->user();
		//  El rol ADMIN puede editar a la persona solo si ésta pertenece a su institucion como alumno
		if($userRole == 'admin') {
			//Obtenemos algunos datos de esa personaId
			$apiPersona = $this->consumeApiPersona($personaId);
			// Si no existe error al consumir el api
			if(!isset($apiPersona['error'])) {
				$userCentroId = (int) $userData['Centro']['id'];
				$ultimaInscripcionCentroId = (int) $apiPersona['inscripcion']['centro_id'];
				// Si la ultima inscripcion de la persona pertenece al establecimiento del usuario admin actual, puede editar
				if($userCentroId == $ultimaInscripcionCentroId) {
					return true;
				} else {
					return false;
				}
			} else {
				// Error al consumir el API
				$this->Session->setFlash($apiPersona['error'], 'default', array('class' => 'alert alert-danger'));
				$this->redirect(array('action' => 'index'));
				return false;
			}
		} else {
			// El resto de los roles puede editar
			return true;
		}
	}

	public function consumeApiPersona($personaId) {
		try 
		{
			$hostApi = getenv('HOSTAPI');
			$httpSocket = new HttpSocket();
			$request = array('header' => array('Content-Type' => 'application/json'));
			$request['header'][getenv('XHOSTCAKE')] = 'do';
			// Datos de la ultima inscripcion de la persona
			$data['ver'] = 'ultima';
			$response = $httpSocket->get("http://$hostApi/api/inscripcion/find/persona/$personaId", $data, $request);
			$response = $response->body;
			$apiResponse = json_decode($response,true);
			return $apiResponse;
		} catch(Exception $ex)
		{
			return ['error'=>$ex->getMessage()];
		}
	}

	public function autocompletePersonas() {
		$conditions = array();
		$term = $this->request->query('term');
		if(!empty($term)) {
			// Si se busca un numero de documento.. se raliza el siguiente filtro
			if(is_numeric($term)) {
				$conditions[] = array(
						'OR' => array(
							array('documento_nro LIKE' => $term . '%')
						)
				);
			} else {
				// Se esta buscando por nombre y/o apellidos
				$terminos = explode(' ', trim($term));
				$terminos = array_diff($terminos,array(''));
				foreach($terminos as $termino) {
					$conditions[] = array(
							'OR' => array(
								array('nombres LIKE' => '%' . $termino . '%'),
								array('apellidos LIKE' => '%' . $termino . '%')
							)
					);
				}
			}
			$personas = $this->Persona->find('all', array(
					'recursive'	=> -1,
					'conditions' => $conditions,
					'fields' 	=> array('id', 'nombres','apellidos','documento_nro'))
			);
		}
		echo json_encode($personas);
		$this->autoRender = false;
	}

	private function __getCodigoOrdinario($ciclo, $personaDocString){
		$legajo = $personaDocString."-".$ciclo;
		return $legajo;
    }

    private function __getCodigoPase($ciclo, $personaDocString, $paseNro){
        $legajo = $personaDocString."-".$ciclo."-"."PASE"."_".$paseNro;
        return $legajo;
	}
	
	private function __getCodigoMaternal($ciclo, $personaDocString){
        $legajo = $personaDocString."-".$ciclo."-"."MATERNAL";
        return $legajo;
	}
	
	private function __getCodigoEspecial($ciclo, $personaDocString){
        $legajo = $personaDocString."-".$ciclo."-"."ESPECIAL";
        return $legajo;
    }
}
?>
