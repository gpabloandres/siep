<?php
App::uses('AppController', 'Controller');

class CiclosController extends AppController {

	var $name = 'Ciclos';
	var $paginate = array('Ciclo' => array('limit' => 4, 'order' => 'Ciclo.nombre ASC'));

	public function beforeFilter() {
        parent::beforeFilter();
        //Si el usuario tiene un rol de superadmin le damos acceso a todo.
        //Si no es así (se trata de un usuario "admin o usuario") tendrá acceso sólo a las acciones que les correspondan.
        if($this->Auth->user('role') === 'superadmin') {
	        $this->Auth->allow();
	    } elseif (($this->Auth->user('role') === 'admin') || ($this->Auth->user('role') === 'usuario')) { 
	        $this->Auth->allow('index', 'view');
	    } 
    }

	function index() {
		$this->Ciclo->recursive = 0;
		$this->set('ciclos', $this->paginate());
		$this->redirectToNamed();
		$conditions = array();
		
		if(!empty($this->params['named']['nombre']))
		{
			$conditions['Ciclo.nombre ='] = $this->params['named']['nombre'];
		}
		
		$ciclos = $this->paginate('Ciclo', $conditions);
		$this->set(compact('ciclos'));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash('Ciclo no valido', 'default', array('class' => 'alert alert-warning'));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('ciclo', $this->Ciclo->read(null, $id));
	}

	function add() {
	  //abort if cancel button was pressed  
		if(isset($this->params['data']['cancel'])){
			  $this->Session->setFlash('Los cambios no fueron guardados. Agregación cancelada.', 'default', array('class' => 'alert alert-warning'));
			  $this->redirect( array( 'action' => 'index' ));
		}
		if (!empty($this->data)) {
			$this->Ciclo->create();
			if ($this->Ciclo->save($this->request->data)) {
				$this->Session->setFlash('El ciclo ha sido grabado.', 'default', array('class' => 'alert alert-success'));
				$inserted_id = $this->Ciclo->id;
				$this->redirect(array('action' => 'view', $inserted_id));
			} else {
				$this->Session->setFlash('El ciclo no ha sido grabado. Intentelo nuevamente.', 'default', array('class' => 'alert alert-danger'));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash('Ciclo no valido', 'default', array('class' => 'alert alert-warning'));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
		  //abort if cancel button was pressed  
          if(isset($this->params['data']['cancel'])){
                $this->Session->setFlash('Los cambios no fueron guardados. Edición cancelada.', 'default', array('class' => 'alert alert-warning'));
                $this->redirect( array( 'action' => 'index' ));
		  }
			if ($this->Ciclo->save($this->data)) {
				$this->Session->setFlash('El ciclo ha sido grabado.', 'default', array('class' => 'alert alert-success'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('El ciclo no ha sido grabado. Intentelo nuevamente.', 'default', array('class' => 'alert alert-danger'));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Ciclo->read(null, $id);
		}
		$cargos = $this->Ciclo->Cargo->find('list');
		$cursos = $this->Ciclo->Curso->find('list');
		$this->set(compact('cargos', 'cursos'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash('Id no valido para ciclo.', 'default', array('class' => 'alert alert-warning'));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Ciclo->delete($id)) {
			$this->Session->setFlash('El ciclo ha sido borrado', 'default', array('class' => 'alert alert-success'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash('El ciclo no fue borrado', 'default', array('class' => 'alert alert-danger'));
		$this->redirect(array('action' => 'index'));
	}
}
?>