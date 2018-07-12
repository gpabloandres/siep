<?php
App::uses('AppController', 'Controller');

class DisenoCurricularsController extends AppController {

   	var $name = 'Disenocurriculars';
	var $paginate = array('Disenocurricular' => array('limit' => 4, 'order' => 'Disenocurricular.anio DESC'));

    function beforeFilter(){
	    parent::beforeFilter();
		//Si el usuario tiene un rol de superadmin le damos acceso a todo.
        //Si no es así (se trata de un usuario "admin o usuario") tendrá acceso sólo a las acciones que les correspondan.
        if(($this->Auth->user('role') === 'superadmin')  || ($this->Auth->user('role') === 'admin')) {
	        $this->Auth->allow();
	    } elseif ($this->Auth->user('role') === 'usuario') { 
	        $this->Auth->allow('index', 'view');
	    }
    }

/**
 * index method
 *
 * @return void
 */
	public function index() {
	    //
	    $this->Disenocurricular->recursive = -1;
		$userCentroId = $this->getUserCentroId();
		$titulacionsId = $this->Disenocurricular->Titulacion->CentrosTitulacion->find('list', array('fields'=>array('titulacion_id'), 'conditions'=>array('centro_id'=>$userCentroId)));
		if($this->Auth->user('role') === 'admin') {
			$this->paginate['Disenocurricular']['conditions'] = array('Disenocurricular.titulacion_id' => $titulacionsId);
		}

		$disenocurriculars = $this->paginate('Disenocurricular');
		
        $this->redirectToNamed();
		$conditions = array();
		if(!empty($this->params['named']['titulacion_id']))
		{
			$conditions['Disenocurricular.titulacion_id ='] = $this->params['named']['titulacion_id'];
		}
		if(!empty($this->params['named']['resolucion_id']))
		{
			$conditions['Disenocurricular.resolucion_id ='] = $this->params['named']['resolucion_id'];
		}
		$disenocurriculars = $this->paginate('Disenocurricular', $conditions); 

		$resolucionId = $this->Disenocurricular->find('list', array('fields'=>array('resolucion_id')));
        $this->loadModel('Resolucion');
        $resolucions = $this->Resolucion->find('list', array('fields'=>array('numero_completo_resolucion')));
        
        $titulacionId = $this->Disenocurricular->find('list', array('fields'=>array('titulacion_id')));
        $this->loadModel('Titulacion');
        $titulacions = $this->Titulacion->find('list', array('fields'=>array('nombre')));

        $this->set(compact('disenocurriculars' ,'resolucions', 'titulacions'));
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Disenocurricular->exists($id)) {
			throw new NotFoundException(__('Invalid mesa examen'));
		}
		$options = array('conditions' => array('Disenocurricular.' . $this->Disenocurricular->primaryKey => $id));
		$this->set('disenocurricular', $this->Disenocurricular->find('first', $options));
	
		$resolucionId = $this->Disenocurricular->find('list', array('fields'=>array('resolucion_id')));
        $this->loadModel('Resolucion');
        $resolucions = $this->Resolucion->find('list', array('fields'=>array('numero_completo_resolucion')));
        
        $titulacionId = $this->Disenocurricular->find('list', array('fields'=>array('titulacion_id')));
        $this->loadModel('Titulacion');
        $titulacions = $this->Titulacion->find('list', array('fields'=>array('nombre')));

        $this->set(compact('resolucions', 'titulacions'));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
	  //abort if cancel button was pressed  
        if(isset($this->params['data']['cancel'])){
                $this->Session->setFlash('Los cambios no fueron guardados. Agregación cancelada.', 'default', array('class' => 'alert alert-warning'));
                $this->redirect( array( 'action' => 'index' ));
		  }
		if ($this->request->is('post')) {
			$this->Disenocurricular->create();
			if ($this->Disenocurricular->save($this->request->data)) {
				$this->Session->setFlash('El diseño curricular ha sido grabado', 'default', array('class' => 'alert alert-success'));
				$inserted_id = $this->Disenocurricular->id;
				$this->redirect(array('action' => 'view', $inserted_id));
			} else {
				$this->Session->setFlash('El diseño curricular no fue grabado. Intentelo nuevamente.', 'default', array('class' => 'alert alert-danger'));
			}
		}
		$resolucionId = $this->Disenocurricular->find('list', array('fields'=>array('resolucion_id')));
        $this->loadModel('Resolucion');
        $resolucions = $this->Resolucion->find('list', array('fields'=>array('numero_completo_resolucion')));
		$titulacions = $this->Disenocurricular->Titulacion->find('list');
		$this->set(compact('resolucions', 'titulacions'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash('Diseño curricular no valida', 'default', array('class' => 'alert alert-warning'));
			//$this->redirect(array('action' => 'index'));
			$inserted_id = $this->Disenourricular->id;
			$this->redirect(array('action' => 'view', $inserted_id));
		}
		if (!empty($this->data)) {
		  //abort if cancel button was pressed  
          if(isset($this->params['data']['cancel'])){
                $this->Session->setFlash('Los cambios no fueron guardados. Edición cancelada.', 'default', array('class' => 'alert alert-warning'));
                $this->redirect( array( 'action' => 'index' ));
		  }
		  if ($this->Disenocurricular->save($this->data)) {
				$this->Session->setFlash('El diseño curricular ha sido grabado', 'default', array('class' => 'alert alert-success'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('El diseño no fue grabado. Intentelo nuevamente.', 'default', array('class' => 'alert alert-danger'));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Disenocurricular->read(null, $id);
		}
		$resolucionId = $this->Disenocurricular->find('list', array('fields'=>array('resolucion_id')));
        $this->loadModel('Resolucion');
        $resolucions = $this->Resolucion->find('list', array('fields'=>array('numero_completo_resolucion')));
		$titulacions = $this->Disenocurricular->Titulacion->find('list');
		$this->set(compact('resolucions', 'titulacions'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash('Id no valido para el diseño curricular', 'default', array('class' => 'alert alert-warning'));
			$this->redirect(array('action' => 'index'));
		}
		if ($this->Disenocurricular->delete($id)) {
			$this->Session->setFlash('El diseño curricular ha sido borrado', 'default', array('class' => 'alert alert-success'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash('El diseño curricular no fue borrado', 'default', array('class' => 'alert alert-danger'));
		$this->redirect(array('action' => 'index'));
	}
}

