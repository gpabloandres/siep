<?php
App::uses('AppController', 'Controller');

class ResolucionsController extends AppController {

   	var $name = 'Resolucions';
	var $paginate = array('Resolucion' => array('limit' => 4, 'order' => 'Resolucion.numero DESC'));

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
	    $this->Resolucion->recursive = -1;
		$this->set('resolucions', $this->paginate());
		
		$this->redirectToNamed();
		$conditions = array();
		if(!empty($this->params['named']['numero']))
		{
			$conditions['Resolucion.numero ='] = $this->params['named']['numero'];
		}
		if(!empty($this->params['named']['anio']))
		{
			$conditions['Resolucion.anio ='] = $this->params['named']['anio'];
		}
		if(!empty($this->params['named']['tipo']))
		{
			$conditions['Resolucion.tipo ='] = $this->params['named']['tipo'];
		}
		$resolucions = $this->paginate('Resolucion', $conditions);
		$this->set(compact('resolucions'));
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Resolucion->exists($id)) {
			throw new NotFoundException(__('Invalid mesa examen'));
		}
		$options = array('conditions' => array('Resolucion.' . $this->Resolucion->primaryKey => $id));
		$this->set('resolucion', $this->Resolucion->find('first', $options));
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
			$this->Resolucion->create();
			if ($this->Resolucion->save($this->request->data)) {
				$this->Session->setFlash('La resolución ha sido grabada', 'default', array('class' => 'alert alert-success'));
				$inserted_id = $this->Resolucion->id;
				$this->redirect(array('action' => 'view', $inserted_id));
			} else {
				$this->Session->setFlash('La resolución no fue grabada. Intentelo nuevamente.', 'default', array('class' => 'alert alert-danger'));
			}
		}
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
			$this->Session->setFlash('Resolución no valida', 'default', array('class' => 'alert alert-warning'));
			$inserted_id = $this->Resolucion->id;
			$this->redirect(array('action' => 'view', $inserted_id));
		}
		if (!empty($this->data)) {
		  //abort if cancel button was pressed  
          if(isset($this->params['data']['cancel'])){
                $this->Session->setFlash('Los cambios no fueron guardados. Edición cancelada.', 'default', array('class' => 'alert alert-warning'));
                $this->redirect( array( 'action' => 'index' ));
		  }
		  if ($this->Resolucion->save($this->data)) {
				$this->Session->setFlash('La resolución ha sido grabada', 'default', array('class' => 'alert alert-success'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('La resolución no fue grabada. Intentelo nuevamente.', 'default', array('class' => 'alert alert-danger'));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Resolucion->read(null, $id);
		}
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
			$this->Session->setFlash('Id no valido para la resolución', 'default', array('class' => 'alert alert-warning'));
			$this->redirect(array('action' => 'index'));
		}
		if ($this->Resolucion->delete($id)) {
			$this->Session->setFlash('La resolución ha sido borrada', 'default', array('class' => 'alert alert-success'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash('La resolución no fue borrada', 'default', array('class' => 'alert alert-danger'));
		$this->redirect(array('action' => 'index'));
	}
}
