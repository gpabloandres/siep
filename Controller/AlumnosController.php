<?php
App::uses('AppController', 'Controller');

class AlumnosController extends AppController {

	var $name = 'Alumnos';
	public $uses = array('Alumno', 'Familiar');
	var $paginate = array('Alumno' => array('limit' => 4, 'order' => 'Alumno.created DESC'));

    public function beforeFilter() {
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
					$this->Auth->allow('index', 'add' , 'view', 'edit', 'autocompleteNombrePersona', 'autocompleteNombreAlumno');	
				}
				break;
			case 'usuario':
			case 'admin':
				$this->Auth->allow('index', 'add' , 'view', 'edit', 'autocompleteNombrePersona', 'autocompleteNombreAlumno');
				break;
		}
		/* FIN */
    }

    public function index() {
    	$this->paginate['Alumno']['limit'] = 6;
		$this->paginate['Alumno']['order'] = array('Alumno.id' => 'ASC');
		/* PAGINACIÓN SEGÚN ROLES DE USUARIOS (INICIO).
		*Sí el usuario es "admin" muestra los cursos del establecimiento. Sino sí es "usuario" externo muestra los cursos del nivel.
		*/
		$userRole = $this->Auth->user('role');
		$userCentroId = $this->getUserCentroId();
		$this->loadModel('Centro');
		$nivelCentroArray = $this->Centro->findById($userCentroId, 'nivel_servicio');
		$nivelCentro = $nivelCentroArray['Centro']['nivel_servicio'];
		$nivelCentroId = $this->Centro->find('list', array('fields'=>array('id'), 'conditions'=>array('nivel_servicio'=>$nivelCentro)));
		if ($userRole === 'admin') {
		$this->paginate['Alumno']['conditions'] = array('Alumno.centro_id' => $userCentroId);
		} else if (($userRole === 'usuario') && ($nivelCentro === 'Común - Inicial - Primario')) {
			$nivelCentroId = $this->Centro->find('list', array('fields'=>array('id'), 'conditions'=>array('nivel_servicio'=>array('Común - Inicial', 'Común - Primario')))); 		
			$this->paginate['Alumno']['conditions'] = array('Alumno.centro_id' => $nivelCentroId);
		} else if ($userRole === 'usuario') {
			$nivelCentroId = $this->Centro->find('list', array('fields'=>array('id'), 'conditions'=>array('nivel_servicio'=>$nivelCentro)));
			$this->paginate['Alumno']['conditions'] = array('Alumno.centro_id' => $nivelCentroId);
		}
        /* FIN */
        /* PAGINACIÓN SEGÚN CRITERIOS DE BÚSQUEDAS (INICIO).
		*Pagina según búsquedas simultáneas ya sea por NÚMERO DE LEGAJO FÍSICO y/o .
		*/
        $this->redirectToNamed();
		$conditions = array();
        if (!empty($this->params['named']['legajo_fisico_nro'])) {
			$conditions['Alumno.legajo_fisico_nro ='] = $this->params['named']['legajo_fisico_nro'];
		}
		$alumnos = $this->paginate('Alumno', $conditions);
	    $this->set(compact('alumnos'));
	}

	public function view($id = null) {
		//$this->Alumno->recursive = 0;
		if (!$id) {
			$this->Session->setFlash('Alumno no valido', 'default', array('class' => 'alert alert-danger'));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('alumno', $this->Alumno->read(null, $id));
        //Genera datos para el view.
        //Obtención del id de persona del alumno.
        $personaIdArray = $this->Alumno->findById($id, 'persona_id');
        $personaId = $personaIdArray['Alumno']['persona_id'];
        //Obtención de datos personales del alumno.
        $this->loadModel('Persona');
        $this->Persona->recursive = 0;
        $this->Persona->Behaviors->load('Containable');
        $personaNombreArray = $this->Persona->findById($personaId, 'nombre_completo_persona');
        $alumnoNombre = $personaNombreArray['Persona']['nombre_completo_persona'];
        $personaDocumentoTipoArray = $this->Persona->findById($personaId, 'documento_tipo');
        $alumnoDocumentoTipo = $personaDocumentoTipoArray['Persona']['documento_tipo'];
        $personaDocumentoNumeroArray = $this->Persona->findById($personaId, 'documento_nro');
        $alumnoDocumentoNumero = $personaDocumentoNumeroArray['Persona']['documento_nro'];
        $personaEdadNumeroArray = $this->Persona->findById($personaId, 'edad');
        $alumnoEdad = $personaEdadNumeroArray['Persona']['edad'];
    	// Datos relacionados.
    	//Obtención del nombre de para los familiares relacionados.
        //$familiarNombre = $this->Persona->find('list', array('fields'=>array('nombre_completo_persona')));
        $alumnoId = $this->Alumno->primaryKey = $id;
        $familiarVinculo = $this->Persona->Familiar->find('list', array('fields' => array('vinculo'), 'conditions' => array('id' => $alumnoId)));
        /*
        $familiarCuilCuit = $this->Persona->find('list', array('fields' => array('cuil_cuit')));
        $familiarTelefono = $this->Persona->find('list', array('fields' => array('telefono_nro')));
        $familiarEmail = $this->Persona->find('list', array('fields' => array('email')));
		*/
    	//Obtención del nombre del centro para las inscripciones relacionadas.
    	$this->loadModel('Centro');
        $this->Centro->recursive = 0;
        $this->Centro->Behaviors->load('Containable');
        $centroNombre = $this->Centro->find('list', array('fields' => array('sigla'), 'contain'=>false));
        //Obtención del nivel del centro id del usuario.
        $userCentroId = $this->getUserCentroId();
        $nivelCentroArray = $this->Centro->findById($userCentroId, 'nivel_servicio');
        $nivelCentro = $nivelCentroArray['Centro']['nivel_servicio'];
        //Obtención del nombre del ciclo para los pases relacionados.
    	$this->loadModel('Ciclo');
        $this->Ciclo->recursive = 0;
        $this->Ciclo->Behaviors->load('Containable');
        $cicloNombre = $this->Ciclo->find('list', array('fields' => array('nombre'), 'contain'=>false));
		$this->set(compact('alumnoNombre', 'alumnoDocumentoTipo', 'alumnoDocumentoNumero', 'alumnoEdad', 'centroNombre', 'cicloNombre', 'personaId', 'personaNombre', 'foto', 'materiaAlia', 'barrioNombre', 'familiarNombre', 'familiarVinculo', 'nivelCentro'));
    }

	public function add() {
		//abort if cancel button was pressed
  		if(isset($this->params['data']['cancel'])){
			$this->Session->setFlash('Los cambios no fueron guardados. Agregación cancelada.', 'default', array('class' => 'alert alert-warning'));
  		$this->redirect( array( 'action' => 'index' ));
		}
		if (!empty($this->data)) {
			// Si no esta definido la persona_id, no se crea el alumno
			if(empty($this->request->data['Alumno']['persona_id'])){
				$this->Session->setFlash('No se agrego el alumno, la persona no existe!.', 'default', array('class' => 'alert alert-warning'));
				$this->redirect( array( 'action' => 'index' ));
			}
			$this->Alumno->create();
			// Obtiene y asigna el centro al alumno
			$centroId = $this->getUserCentroId();
			$this->request->data['Alumno']['centro_id'] = $centroId;
			if ($this->Alumno->save($this->request->data)) {
				$this->Session->setFlash('El alumno ha sido grabado', 'default', array('class' => 'alert alert-success'));
				$inserted_id = $this->Alumno->id;
				$this->redirect(array('action' => 'view', $inserted_id));
			} else {
				$this->Session->setFlash('El alumno no fue grabado. Intentelo nuevamente.', 'default', array('class' => 'alert alert-danger'));
			}
		}
        $personas = $this->Alumno->Persona->find('list', array('fields'=>array('id', 'nombre_completo_persona')));
        $this->set(compact('alumnos', 'personas'));
    }

	public function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash('Alumno no valido', 'default', array('class' => 'alert alert-warning'));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
	    //abort if cancel button was pressed
	      if(isset($this->params['data']['cancel'])){
            $this->Session->setFlash('Los cambios no fueron guardados. Edición cancelada.', 'default', array('class' => 'alert alert-warning'));
            $this->redirect( array( 'action' => 'index' ));
		  }
		// Si no esta definido la persona_id, no se crea el alumno
			if(empty($this->request->data['Alumno']['persona_id'])){
				$this->Session->setFlash('No se edito al alumno, la persona no existe!.', 'default', array('class' => 'alert alert-warning'));
				$this->redirect( array( 'action' => 'index' ));
			}
		    if ($this->Alumno->save($this->data)) {
				$this->Session->setFlash('El alumno ha sido grabado', 'default', array('class' => 'alert alert-success'));
				$inserted_id = $this->Alumno->id;
				$this->redirect(array('action' => 'view', $inserted_id));
			} else {
				$this->Session->setFlash('El alumno no ha sido grabado. Intentelo nuevamente.', 'default', array('class' => 'alert alert-danger'));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Alumno->read(null, $id);
		}
		$personas = $this->Alumno->Persona->find('list', array('fields'=>array('id', 'nombre_completo_persona')));
		$this->set(compact('alumnos', 'personas'));
	}

	public function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash('Id no valido para el alumno', 'default', array('class' => 'alert alert-warning'));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Alumno->delete($id)) {
			$this->Session->setFlash('El alumno ha sido borrado', 'default', array('class' => 'alert alert-success'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash('El alumno no fue borrado', 'default', array('class' => 'alert alert-danger'));
		$this->redirect(array('action' => 'index'));
	}

	/* AUTOCOMPLETE PARA EL FORMULARIO DE AGREGACIÓN (INICIO).
	*  Sólo muestra las personas con perfíl de alumno.
	*/
	public function autocompleteNombrePersona() {

		$conditions = array();
		$term = $this->request->query('term');

		if(!empty($term))
		{
			// Si se busca un numero de documento.. se raliza el siguiente filtro
			if(is_numeric($term)) {
				$conditions[] = array('Persona.documento_nro LIKE' => $term . '%');
			} else {
				// Se esta buscando por nombre y/o apellidos
				$terminos = explode(' ', trim($term));
				$terminos = array_diff($terminos,array(''));

				// Esto es posible porque nombre_completo_persona esta definido en el modelo como virtual
				foreach($terminos as $termino) {
					$conditions[] = array('nombre_completo_persona LIKE' => '%' . $termino . '%');
				}
			}

			$this->loadModel('Persona');
			$personaId = $this->Persona->find('list', array('fields'=>array('id'), 'conditions'=>array('alumno'=>1)));
			$personas = $this->Alumno->Persona->find('all', array(
					'recursive'	=> -1,
					// Condiciona la búsqueda también por id de persona con perfil de alumno.
					'conditions' => array($conditions, 'id' => $personaId),
					'fields' 	=> array('id', 'nombre_completo_persona','documento_nro'))
			);

			echo json_encode($personas);
		}

		$this->autoRender = false;
	}

	/* AUTOCOMPLETE PARA EL FORMULARIO DE BÚSQUEDA (INICIO).
	*  Sí el usuario es "admin" muestra sólo los alumnos del establecimiento.
	*  Sino sí es "usuario", muestra los alumnos del nivel correspondiente al centro.
	*  Sino sí es "superadmin" muestra todos los alumnos.
	*/
	public function autocompleteNombreAlumno() {
		$conditions = array();
		$term = $this->request->query('term');

		// Primero obtiene el termino a buscar
		if(!empty($term))
		{
			// Si se busca un numero de documento.. se raliza el siguiente filtro
			if(is_numeric($term)) {
				$conditions[] = array('Persona.documento_nro LIKE' => $term . '%');
			} else {
				// Se esta buscando por nombre y/o apellidos
				$terminos = explode(' ', trim($term));
				$terminos = array_diff($terminos,array(''));

				foreach($terminos as $termino) {
					$conditions[] = array(
						'OR' => array(
							array('Persona.apellidos LIKE' => $term . '%'),
							array('Persona.nombres LIKE' => $term . '%')
						)
					);
				}
			}

			$userRole = $this->Auth->user('role');
			$userCentroId = $this->getUserCentroId();
			$this->loadModel('Centro');
			//$nivelCentro = $this->Centro->find('list', array('fields'=>array('nivel_servicio'), 'conditions'=>array('id'=>$userCentroId)));
			$nivelCentroArray = $this->Centro->findById($userCentroId, 'nivel_servicio');
			$nivelCentroString = $nivelCentroArray['Centro']['nivel_servicio'];
			if ($userRole === 'admin') {
				$personas = $this->Alumno->find('all', array(
						'recursive'	=> 0,
						'contain' => 'Persona',
						// Condiciona la búsqueda también por id de persona de los alumnos del centro correspondiente.
						'conditions' => array($conditions, 'centro_id'=>$userCentroId),
						'fields' 	=> array('Alumno.id', 'Persona.nombres', 'Persona.apellidos', 'Persona.documento_nro')
					)
				);
			} else if (($userRole === 'usuario') && ($nivelCentroString === 'Común - Inicial - Primario')) {
				$nivelCentroId = $this->Centro->find('list', array('fields'=>array('id'), 'conditions'=>array('nivel_servicio'=>array('Común - Inicial', 'Común - Primario'))));

				$personas = $this->Alumno->find('all', array(
						'recursive'	=> 0,
						'contain' => 'Persona',
						// Condiciona la búsqueda también por id de persona de los alumnos del centro correspondiente.
						'conditions' => array($conditions, 'centro_id'=>$nivelCentroId),
						'fields' 	=> array('Alumno.id', 'Persona.nombres', 'Persona.apellidos', 'Persona.documento_nro')
					)
				);
			} else if ($userRole === 'usuario') {
				// Obtiene el id de persona del nivel del centro correspondiente.
				$nivelCentroId = $this->Centro->find('list', array('fields'=>array('id'), 'conditions'=>array('nivel_servicio'=>$nivelCentroString)));
				$personas = $this->Alumno->find('all', array(
						'recursive'	=> 0,
						'contain' => 'Persona',
						// Condiciona la búsqueda también por id de persona de los alumnos del centro correspondiente.
						'conditions' => array($conditions, 'centro_id'=>$nivelCentroId),
						'fields' 	=> array('Alumno.id', 'Persona.nombres', 'Persona.apellidos', 'Persona.documento_nro')
					)
				);
			} else if ($userRole === 'superadmin') {
				$personas = $this->Alumno->find('all', array(
					'recursive'	=> 0,
					'contain' => 'Persona',
					// Condiciona la búsqueda también por id de persona de los alumnos del centro correspondiente.
					'conditions' => array($conditions),
					'fields' 	=> array('Alumno.id', 'Persona.nombres', 'Persona.apellidos', 'Persona.documento_nro')
					)
				);
			}
			echo json_encode($personas);
			}
			// No renderiza el layout
			$this->autoRender = false;
		}
		/* FIN */
	}
?>
