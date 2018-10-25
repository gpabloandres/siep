<?php
class TitulacionsController extends AppController {

	var $name = 'Titulacions';
    public $uses = array('Titulacion', 'Centro');
	var $paginate = array('Titulacion' => array('limit' => 4, 'order' => 'Titulacion.nombre DESC'));

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
                    $this->Auth->allow('index', 'add', 'view', 'edit', 'autocompleteTitulacions');    
                }
                break;
            case 'usuario':
            case 'admin':
                $this->Auth->allow('index', 'view', 'autocompleteTitulacions');
                break;
        }
        /* FIN */
    }	

	function index() {
		$this->Titulacion->recursive = 1;
		/*
		$titulacions = $this->Titulacion->find('list', array('fields'=>array('id', 'nombre')));
		$userCentroId = $this->getUserCentroId();
		$titulacionsId = $this->Titulacion->CentrosTitulacion->find('list', array('fields'=>array('titulacion_id'), 'conditions'=>array('centro_id'=>$userCentroId)));
		if($this->Auth->user('role') === 'admin') {
			$this->paginate['Titulacion']['conditions'] = array('Titulacion.id' => $titulacionsId);
		}
		*/
		/* PAGINACIÓN SEGÚN ROLES DE USUARIOS (INICIO).
		*  Sí el usuario es "admin" muestra las titulaciones del establecimiento. 
		*  Sino sí es "usuario" externo muestra las titulaciones del nivel.
		*/ 
		$userCentroId = $this->getUserCentroId();
		$userRole = $this->Auth->user('role');
		if ($userRole === 'admin') {
			$titulacionsId = $this->Titulacion->CentrosTitulacion->find('list', array('fields'=>array('titulacion_id'), 'conditions'=>array('centro_id'=>$userCentroId)));
			$this->paginate['Titulacion']['conditions'] = array('Titulacion.id' => $titulacionsId);
		} else if ($userRole === 'usuario') {
			$this->loadModel('Centro');
			$nivelCentro = $this->Centro->find('list', array('fields'=>array('nivel_servicio'), 'conditions'=>array('id'=>$userCentroId)));
			$nivelCentroId = $this->Centro->find('list', array('fields'=>array('id'), 'conditions'=>array('nivel_servicio'=>$nivelCentro))); 		
			$titulacionsId = $this->Titulacion->CentrosTitulacion->find('list', array('fields'=>array('titulacion_id'), 'conditions'=>array('centro_id'=>$nivelCentroId)));
			$this->paginate['Titulacion']['conditions'] = array('Titulacion.id' => $titulacionsId);
		}
		/* FIN */
		$this->redirectToNamed();
		$conditions = array();
		if(!empty($this->params['named']['nombre'])) {
			$conditions['Titulacion.nombre ='] = $this->params['named']['nombre'];
		}
		$titulacions = $this->paginate('Titulacion', $conditions);
		//Obtiene los nombres de los centros.
		$centros = $this->Titulacion->CentrosTitulacion->find('list', array('fields' => array('centro_id'), array('conditions' => array('titulacion_id' => $titulacions))));
		$this->set(compact('titulacions', 'centros', $centros));
	}

	function view($id = null) {
		$this->Titulacion->recursive = 1;
		if (!$id) {
			$this->Session->setFlash(__('Titulación no valida.'));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('titulacion', $this->Titulacion->read(null, $id));
		$resolucionsId = $this->Titulacion->DisenoCurriculars->find('list', array('fields'=>array('resolucion_id')));
        $this->loadModel('Resolucion');
        $this->Resolucion->recursive = 0;
        $this->Resolucion->Behaviors->load('Containable');
        $resolucions = $this->Resolucion->find('list', array('fields'=>array('numero_completo_resolucion'), 'conditions' => array('id' => $resolucionsId)));
		$this->loadModel('Ciudad');
		$this->Ciudad->recursive = 0;
        $this->Ciudad->Behaviors->load('Containable');
		$ciudades = $this->Ciudad->find('list', array('fields'=>array('nombre')));
		$this->set(compact('resolucions', 'ciudades'));	
	}

	function add() {
		$this->Titulacion->recursive = 0;
		//abort if cancel button was pressed  
        if(isset($this->params['data']['cancel'])) {
            $this->Session->setFlash('Los cambios no fueron guardados. Agregación cancelada.', 'default', array('class' => 'alert alert-warning'));
            $this->redirect( array( 'action' => 'index' ));
		}
		if (!empty($this->data)) {
		    $this->Titulacion->create();
			if ($this->Titulacion->save($this->data)) {
				$this->Session->setFlash('La titulacion ha sido grabada.', 'default', array('class' => 'alert alert-success'));
				//$this->redirect(array('action' => 'index'));
				$inserted_id = $this->Titulacion->id;
				$this->redirect(array('action' => 'view', $inserted_id));
			} else {
				$this->Session->setFlash('La titulacion no ha sido grabada. Intentelo nuevamente.', 'default', array('class' => 'alert alert-danger'));
			}
		}
		$centros = $this->Centro->find('list');
		$this->set(compact('centros', $centros));
	}

	function edit($id = null) {
		$this->Titulacion->recursive = 0;
		if (!$id && empty($this->data)) {
			$this->Session->setFlash('Titulacion no valida.', 'default', array('class' => 'alert alert-warning'));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
		  //abort if cancel button was pressed  
            if(isset($this->params['data']['cancel'])){
                $this->Session->setFlash('Los cambios no fueron guardados. Edición cancelada.', 'default', array('class' => 'alert alert-warning'));
                $this->redirect( array( 'action' => 'index' ));
			}
			if ($this->Titulacion->save($this->data)) {
				$this->Session->setFlash('La titulación ha sido grabada.', 'default', array('class' => 'alert alert-success'));
				//$this->redirect(array('action' => 'index'));
				$inserted_id = $this->Titulacion->id;
				$this->redirect(array('action' => 'view', $inserted_id));
			} else {
				$this->Session->setFlash('La titulación no ha sido grabada. Intentelo nuevamente.', 'default', array('class' => 'alert alert-danger'));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Titulacion->read(null, $id);
		}
		$centros = $this->Centro->find('list');
		$this->set(compact('centros', $centros));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash('Id no valido para titulación.', 'default', array('class' => 'alert alert-warning'));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Titulacion->delete($id)) {
			$this->Session->setFlash('La Titulación ha sido borrado', 'default', array('class' => 'alert alert-success'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash('La Titulación no fue borrado', 'default', array('class' => 'alert alert-danger'));
		$this->redirect(array('action' => 'index'));
	}

	/* AUTOCOMPLETE PARA EL FORMULARIO DE BÚSQUEDA (INICIO).
	*  Sí el usuario es "admin" muestra sólo las titulaciones del establecimiento.
	*  Sino sí es "usuario", muestra las titulaciones del nivel correspondiente al centro.
	*  Sino sí es "superadmin" muestra todas las titulaciones.
	*/
	public function autocompleteTitulacions() {
		$term = null;
		// Inicia el Autocomplete.
		if(!empty($this->request->query('term'))) {
			$term = $this->request->query('term');
			$terminos = explode(' ', trim($term));
			$terminos = array_diff($terminos,array(''));
			$conditions = array();
			foreach($terminos as $termino) {
				$conditions[] = array('nombre LIKE' => '%' . $termino . '%');
			}
			$userRole = $this->Auth->user('role');
			$userPuesto = $this->Auth->user('puesto');
			$userCentroId = $this->getUserCentroId();
			if ($userRole === 'admin') {
				// Obtiene el id de titulacion del centro correspondiente.
				$titulacionesId = $this->Titulacion->CentrosTitulacion->find('list', array('fields'=>array('titulacion_id'), 'conditions'=>array('centro_id'=>$userCentroId)));
				// Consulta por esos id de titulaciones.
				$titulaciones = $this->Titulacion->find('all', array(
					'recursive'	=> -1,
					// Condiciona la búsqueda también por id de titulacion del centro correspondiente.
					'conditions' => array($conditions, 'id' => $titulacionesId, 'status' => 1),
					'fields' 	=> array('id', 'nombre')
					)
				);
			} else if ($userRole === 'usuario') {
				// Obtiene el id de titulacion del nivel del centro correspondiente.
				$this->loadModel('Centro');
        		$this->Centro->recursive = 0;
        		$this->Centro->Behaviors->load('Containable');
        		$nivelCentroArray = $this->Centro->findById($userCentroId, 'nivel_servicio');
        		$nivelCentro = $nivelCentroArray['Centro']['nivel_servicio'];
        		$nivelCentroId = $this->Centro->find('list', array('fields'=>array('id'), 'contain'=>false, 'conditions'=>array('nivel_servicio'=>$nivelCentro)));
        		$titulacionesId = $this->Titulacion->CentrosTitulacion->find('list', array('fields'=>array('titulacion_id'), 'conditions'=>array('centro_id'=>$nivelCentroId)));
				// Consulta por esos id de titulaciones.
				$titulaciones = $this->Titulacion->find('all', array(//'recursive'	=> -1, // Condiciona la búsqueda también por id de titulaciones del nivel del centro correspondiente.
					'conditions' => array($conditions, 'id' => $titulacionesId, 'status' => 1),
					'fields' 	=> array('id', 'nombre')
					)
				);
			} else if ($userRole === 'superadmin' && $userPuesto === 'Atei') {
				$titulaciones = $this->Titulacion->find('all', array(
					'recursive'	=> -1,
					// Condiciona la búsqueda también por id de persona de los alumnos del centro correspondiente.
					'conditions' => array($conditions, 'status' => 1),
					'fields' 	=> array('id', 'nombre')
					)
				);
			} else if ($userRole === 'superadmin') {
				$titulaciones = $this->Titulacion->find('all', array(
					'recursive'	=> -1,
					// Condiciona la búsqueda también por id de persona de los alumnos del centro correspondiente.
					'conditions' => $conditions,
					'fields' 	=> array('id', 'nombre')
					)
				);
			}	
			echo json_encode($titulaciones);
			}
			// No renderiza el layout
			$this->autoRender = false;
		}
		/* FIN */
}
?>