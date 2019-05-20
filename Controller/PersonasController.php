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
    	$persona = $this->Persona->findById($id,'alumno');
        $personaAlumno = $persona['Persona']['alumno'];
        if ($personaAlumno == 1) {
        	/*INICIO: Identificación de la inscripción actual y su estado en una persona con perfil de alumno*/
    		//Obtención de DNI de la persona.
	    	$persona = $this->Persona->findById($id,'id, documento_nro');
	        $personaDni = $persona['Persona']['documento_nro'];
	    	//Obtención del ciclo actual.
			$cicloIdActual = $this->getActualCicloId();
			$this->loadModel('Ciclo');
			$this->Ciclo->recursive = 0;
			$this->Ciclo->Behaviors->load('Containable');
			$ciclos = $this->Ciclo->findById($cicloIdActual, 'nombre');
            $ciclo = substr($ciclos['Ciclo']['nombre'], -2);
			//Obtención del tipo y estado de inscripción actual.
	    	$this->loadModel('Inscripcion');
	        $this->Inscripcion->recursive = 0;
	        $this->Inscripcion->Behaviors->load('Containable');
	    	//Obtención de los posibles códigos de inscripción (Ordinario, Pase, Maternal, Especial).
	    	$codigoOrdinarioActualPosible = $this->__getCodigoOrdinario($ciclo, $personaDni);
	    	$paseNro = 1; 
	        $codigoPaseActualPosible = $this->__getCodigoPase($ciclo, $personaDni, $paseNro);
			$codigoMaternalActualPosible = $this->__getCodigoMaternal($ciclo, $personaDni);
			$codigoEspecialActualPosible = $this->__getCodigoEspecial($ciclo, $personaDni);
			//Obtención de datos del centro.
			$this->loadModel('Centro');
		    $this->Centro->recursive = 0;
			$this->Centro->Behaviors->load('Containable');
			//Obtención de datos de la sección.
			$this->loadModel('CursosInscripcions');
		    $this->CursosInscripcions->recursive = 0;
			$this->CursosInscripcions->Behaviors->load('Containable');
			$this->loadModel('Curso');
		    $this->Curso->recursive = 0;
		    $this->Curso->Behaviors->load('Containable');
			//Verificación de existencia de inscripciones con los códigos posibles.
			if($codigoOrdinarioActualPosible) {
				$existeInscripcionOrdinaria = $this->Inscripcion->find('first',array(
					'contain' => false,
					'conditions' => array('Inscripcion.legajo_nro' => $codigoOrdinarioActualPosible)));	
				if(isset($existeInscripcionOrdinaria['Inscripcion']['legajo_nro'])) {
					$codigoOrdinarioActual = $codigoOrdinarioActualPosible;
					//Obtención del id y del estado de esa inscripción.
					$estadoInscripcionOrdinariaArray = $this->Inscripcion->findByLegajoNro($codigoOrdinarioActual,'id, estado_inscripcion');
                	$idInscripcionOrdinaria = $estadoInscripcionOrdinariaArray['Inscripcion']['id'];
                	$estadoInscripcionOrdinaria = $estadoInscripcionOrdinariaArray['Inscripcion']['estado_inscripcion'];
					if($estadoInscripcionOrdinaria != 'BAJA') {
						//Obtención del tipo de inscripción.
						$tipoInscripcionOrdinariaArray = $this->Inscripcion->findByLegajoNro($codigoOrdinarioActual,'tipo_inscripcion');
						$tipoInscripcionOrdinaria = $tipoInscripcionOrdinariaArray['Inscripcion']['tipo_inscripcion'];
						//Obtención del centro de esa inscripción.
						$idCentroInscripcionOrdinariaArray = $this->Inscripcion->findByLegajoNro($codigoOrdinarioActual,'centro_id');
						$idCentroInscripcion = $idCentroInscripcionOrdinariaArray['Inscripcion']['centro_id'];
						$centroInscripcionOrdinariaArray = $this->Centro->findById($idCentroInscripcion,'nombre');
						$centroInscripcionOrdinaria = $centroInscripcionOrdinariaArray['Centro']['nombre'];
						//Obtención de los datos de la sección de esa inscripción.
						$idSeccionInscripcionOrdinariaArray = $this->CursosInscripcions->findByInscripcionId($idInscripcionOrdinaria,'curso_id');
						$idSeccionInscripcionOrdinaria = $idSeccionInscripcionOrdinariaArray['CursosInscripcions']['curso_id'];
						$seccionInscripcionOrdinariaArray = $this->Curso->findById($idSeccionInscripcionOrdinaria,'nombre_completo_curso');
						$seccionInscripcionOrdinaria = $seccionInscripcionOrdinariaArray['Curso']['nombre_completo_curso'];
					}
				}					
			}
			if($codigoPaseActualPosible) {
				//Obtención de números de pases por inscripción.
				do {
					$paseNro +=1;
					$codigoPaseOtroActualPosible = $this->__getCodigoPase($ciclo, $personaDni, $paseNro);
					$existeInscripcionPaseOtro = $this->Inscripcion->find('count',array(
						'contain' => false,
						'conditions' => array(
							'Inscripcion.legajo_nro' => $codigoPaseOtroActualPosible)));
				} while ($existeInscripcionPaseOtro != 0);
				//Obtención del código actual.
				$codigoPaseActual = $this->__getCodigoPase($ciclo, $personaDni, $paseNro-1);
				//Verificación de la existencia de inscripción con código actual.
				$existeInscripcionPase = $this->Inscripcion->find('first',array(
					'contain' => false,
					'conditions' => array('Inscripcion.legajo_nro' => $codigoPaseActual)));
				if(isset($existeInscripcionPase['Inscripcion']['legajo_nro'])) {
					//Obtención del id y del estado de esa inscripción.
					$estadoInscripcionPaseArray = $this->Inscripcion->findByLegajoNro($codigoPaseActual,'id, estado_inscripcion');
					$idInscripcionPase = $estadoInscripcionPaseArray['Inscripcion']['id'];
					$estadoInscripcionPase = $estadoInscripcionPaseArray['Inscripcion']['estado_inscripcion'];
					if($estadoInscripcionPase != 'BAJA') {
						//Obtención del tipo de inscripción.
						$tipoInscripcion = 'Pase';
						//Obtención del centro de esa inscripción.
						$idCentroInscripcionPaseArray = $this->Inscripcion->findByLegajoNro($codigoPaseActual,'centro_id');
						$idCentroInscripcionPase = $idCentroInscripcionPaseArray['Inscripcion']['centro_id'];
						$centroInscripcionPaseArray = $this->Centro->findById($idCentroInscripcionPase,'nombre');
						$centroInscripcionPase = $centroInscripcionPaseArray['Centro']['nombre'];
						//Obtención de los datos de la sección de esa inscripción.
						$idSeccionInscripcionPaseArray = $this->CursosInscripcions->findByInscripcionId($idInscripcionPase,'curso_id');
						$idSeccionInscripcionPase = $idSeccionInscripcionPaseArray['CursosInscripcions']['curso_id'];
						$seccionInscripcionPaseArray = $this->Curso->findById($idSeccionInscripcionPase,'nombre_completo_curso');
						$seccionInscripcionPase = $seccionInscripcionPaseArray['Curso']['nombre_completo_curso'];
					}
				}	
			}
	    	if($codigoMaternalActualPosible) {
				$existeInscripcionMaternal = $this->Inscripcion->find('first',array(
					'contain' => false,
					'conditions' => array('Inscripcion.legajo_nro' => $codigoMaternalActualPosible)));
				if(isset($existeInscripcionMaternal['Inscripcion']['legajo_nro'])) {
					$codigoMaternalActual = $codigoMaternalActualPosible;
					//Obtención del id y del estado de esa inscripción.
					$estadoInscripcionMaternalArray = $this->Inscripcion->findByLegajoNro($codigoMaternalActual,'id, estado_inscripcion');
                	$idInscripcionMaternal = $estadoInscripcionMaternalArray['Inscripcion']['id'];
					$estadoInscripcionMaternal = $estadoInscripcionMaternalArray['Inscripcion']['estado_inscripcion'];
					if($estadoInscripcionMaternal != 'BAJA') {
						//Obtención del tipo de inscripción.
						$tipoInscripcionMaternalArray = $this->Inscripcion->findByLegajoNro($codigoMaternalActual,'tipo_inscripcion');
						$tipoInscripcionMaternal = $tipoInscripcionMaternalArray['Inscripcion']['tipo_inscripcion'];
						//Obtención del centro de esa inscripción.
						$idCentroInscripcionMaternalArray = $this->Inscripcion->findByLegajoNro($codigoMaternalActual,'centro_id');
                		$idCentroInscripcionMaternal = $idCentroInscripcionMaternalArray['Inscripcion']['centro_id'];
                		$centroInscripcionMaternalArray = $this->Centro->findById($idCentroInscripcionMaternal,'nombre');
						$centroInscripcionMaternal = $centroInscripcionMaternalArray['Centro']['nombre'];
						//Obtención de los datos de la sección de esa inscripción.
						$idSeccionInscripcionMaternalArray = $this->CursosInscripcions->findByInscripcionId($idInscripcionMaternal,'curso_id');
						$idSeccionInscripcionMaternal = $idSeccionInscripcionMaternalArray['CursosInscripcions']['curso_id'];
						$seccionInscripcionMaternalArray = $this->Curso->findById($idSeccionInscripcionMaternal,'nombre_completo_curso');
						$seccionInscripcionMaternal = $seccionInscripcionMaternalArray['Curso']['nombre_completo_curso'];
					}
				}			
			}
			if($codigoEspecialActualPosible) {
				$existeInscripcionEspecial = $this->Inscripcion->find('first',array(
					'contain' => false,
					'conditions' => array('Inscripcion.legajo_nro' => $codigoEspecialActualPosible)));
				if(isset($existeInscripcionEspecial['Inscripcion']['legajo_nro'])) {
					$codigoEspecialActual = $codigoEspecialActualPosible;
					//Obtención del id y del estado de esa inscripción.
					$estadoInscripcionEspecialArray = $this->Inscripcion->findByLegajoNro($codigoEspecialActual,'id, estado_inscripcion');
                	$idInscripcionEspecial = $estadoInscripcionEspecialArray['Inscripcion']['id'];
					$estadoInscripcionEspecial = $estadoInscripcionEspecialArray['Inscripcion']['estado_inscripcion'];
					if($estadoInscripcionEspecial != 'BAJA') {
						//Obtención del tipo de inscripción.
						//Obtención del centro de esa inscripción.
						$idCentroInscripcionEspecialArray = $this->Inscripcion->findByLegajoNro($codigoEspecialActual,'centro_id');
                		$idCentroInscripcionEspecial = $idCentroInscripcionEspecialArray['Inscripcion']['centro_id'];
						$centroInscripcionEspecialArray = $this->Centro->findById($idCentroInscripcionEspecial,'nombre');
                		$centroInscripcionEspecial = $centroInscripcionEspecialArray['Centro']['nombre'];
						//Obtención de los datos de la sección de esa inscripción.
						$idSeccionInscripcionEspecialArray = $this->CursosInscripcions->findByInscripcionId($idInscripcionEspecial,'curso_id');
						$idSeccionInscripcionEspecial = $idSeccionInscripcionEspecialArray['CursosInscripcions']['curso_id'];
						$seccionInscripcionEspecialArray = $this->Curso->findById($idSeccionInscripcionEspecial,'nombre_completo_curso');
						$seccionInscripcionEspecial = $seccionInscripcionEspecialArray['Curso']['nombre_completo_curso'];	
					}
				}
			}
			if(!$existeInscripcionPase && !$existeInscripcionOrdinaria && !$existeInscripcionMaternal && !$existeInscripcionEspecial) {
	        	$this->Session->setFlash('No registra inscripción en el ciclo actual', 'default', array('class' => 'alert alert-info'));
	        }
	    	//Visualización del mensaje al usuario de los datos de inscripción en el ciclo actual.
			if($existeInscripcionOrdinaria && $estadoInscripcionOrdinaria != 'BAJA') {
				$this->Session->setFlash("En el ciclo actual registra inscripción en: ".
                '<ul>'.'<li>'.$centroInscripcionOrdinaria.' '.' en '.$seccionInscripcionOrdinaria.' con estado: '.' '.$estadoInscripcionOrdinaria.'</li>'
				.'</ul>', 'default', array('class' => 'alert alert-info'));
			}
			if($existeInscripcionPase && $estadoInscripcionPase != 'BAJA') {
				$this->Session->setFlash("En el ciclo actual registra inscripción $codigoPaseActual en: ".
                '<ul>'.'<li>'.$centroInscripcionPase.' '.' en '.$seccionInscripcionPase.' con estado: '.' '.$estadoInscripcionPase.'</li>'
				.'</ul>', 'default', array('class' => 'alert alert-info'));
			}
			if($existeInscripcionMaternal) {
				$this->Session->setFlash("En el ciclo actual registra inscripción en: ".
                '<ul>'.'<li>'.$centroInscripcionMaternal.' '.' en '.$seccionInscripcionMaternal.' con estado: '.' '.$estadoInscripcionMaternal.'</li>'
				.'</ul>', 'default', array('class' => 'alert alert-info'));
			}
			if($existeInscripcionEspecial) {
				$this->Session->setFlash("En el ciclo actual registra inscripción en: ".
                '<ul>'.'<li>'.$centroInscripcionEspecial.' '.' en '.$seccionInscripcionEspecial.' con estado: '.' '.$estadoInscripcionEspecial.'</li>'
				.'</ul>', 'default', array('class' => 'alert alert-info'));
			}                
	    }
	    /*FIN*/
        //Obtención del nombre de la ciudad del domicilio actual.
    	$personaCiudadIdArray = $this->Persona->findById($id,'ciudad_id');
		if($personaCiudadIdArray) : $personaCiudadId = $personaCiudadIdArray['Persona']['ciudad_id'];
    	endif;
		$this->loadModel('Ciudad');
		$this->Ciudad->recursive = 0;
		$this->Ciudad->Behaviors->load('Containable');
		$personaCiudadNombreArray = $this->Ciudad->findById($personaCiudadId,'nombre');
		if($personaCiudadNombreArray) : $personaCiudadNombre = $personaCiudadNombreArray['Ciudad']['nombre'];
		endif;
		//Obtención del nombre del barrio del domicilio actual.
    	$personaBarrioIdArray = $this->Persona->findById($id,'barrio_id');
		if($personaBarrioIdArray) : $personaBarrioId = $personaBarrioIdArray['Persona']['barrio_id'];
    	endif;
    	$this->loadModel('Barrio');
		$this->Barrio->recursive = 0;
		$this->Barrio->Behaviors->load('Containable');
		$personaBarrioNombreArray = $this->Barrio->findById($personaBarrioId,'nombre');
		if($personaBarrioNombreArray) : $personaBarrioNombre = $personaBarrioNombreArray['Barrio']['nombre'];
		endif;
		//Obtención del nombre del asentamiento del domicilio actual.
    	$personaAsentamientoIdArray = $this->Persona->findById($id,'asentamiento_id');
		if($personaAsentamientoIdArray) : $personaAsentamientoId = $personaAsentamientoIdArray['Persona']['asentamiento_id'];
    	endif;
    	$this->loadModel('Asentamiento');
		$this->Asentamiento->recursive = 0;
		$this->Asentamiento->Behaviors->load('Containable');
		$personaAsentamientoNombreArray = $this->Asentamiento->findById($personaAsentamientoId,'nombre');
		if($personaAsentamientoNombreArray) : $personaAsentamientoNombre = $personaAsentamientoNombreArray['Asentamiento']['nombre'];
		endif;
		//Envío de datos a la vista.
    	$this->set(compact('foto', 'personaCiudadNombre', 'personaBarrioNombre', 'personaAsentamientoNombre'));
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
		// Esta fecha tiene el formato dia/mes/año
		$this->set(compact('fechaNacimiento'));
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
