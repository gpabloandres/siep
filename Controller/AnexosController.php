<?php
App::uses('AppController', 'Controller');

class AnexosController extends AppController {

   	var $name = 'Anexos';
	var $paginate = array('Anexo' => array('limit' => 4, 'order' => 'Anexo.anio DESC'));

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
	    $this->Anexo->recursive = -1;
		$this->set('anexos', $this->paginate());
		
		$this->redirectToNamed();
		$conditions = array();
		if(!empty($this->params['named']['numero']))
		{
			$conditions['Anexo.numero ='] = $this->params['named']['numero'];
		}
		if(!empty($this->params['named']['anio']))
		{
			$conditions['Anexo.anio ='] = $this->params['named']['anio'];
		}
		$anexos = $this->paginate('Anexo', $conditions);

		$resolucionId = $this->Anexo->find('list', array('fields'=>array('resolucion_id')));
        $this->loadModel('Resolucion');
        $resolucions = $this->Resolucion->find('list', array('fields'=>array('numero_completo_resolucion'), 'conditions'=>array('id'=>$resolucionId)));
        $this->set(compact('anexos', 'resolucions'));
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Anexo->exists($id)) {
			throw new NotFoundException(__('Invalid mesa examen'));
		}
		$options = array('conditions' => array('Anexo.' . $this->Anexo->primaryKey => $id));
		$this->set('anexo', $this->Anexo->find('first', $options));
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
			$this->Anexo->create();
			if ($this->Anexo->save($this->request->data)) {
				$this->Session->setFlash('El anexo ha sido grabado', 'default', array('class' => 'alert alert-success'));
				$inserted_id = $this->Anexo->id;
				$this->redirect(array('action' => 'view', $inserted_id));
			} else {
				$this->Session->setFlash('El Anexo no fue grabado. Intentelo nuevamente.', 'default', array('class' => 'alert alert-danger'));
			}
		}
		$resolucionId = $this->Anexo->find('list', array('fields'=>array('resolucion_id')));
        $this->loadModel('Resolucion');
        $resolucions = $this->Resolucion->find('list', array('fields'=>array('numero'), 'conditions'=>array('id'=>$resolucionId)));
        $this->set(compact('resolucions'));
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
			$this->Session->setFlash('Anexo no valido', 'default', array('class' => 'alert alert-warning'));
			$inserted_id = $this->Anexo->id;
			$this->redirect(array('action' => 'view', $inserted_id));
		}
		if (!empty($this->data)) {
		  //abort if cancel button was pressed  
          if(isset($this->params['data']['cancel'])){
                $this->Session->setFlash('Los cambios no fueron guardados. Edición cancelada.', 'default', array('class' => 'alert alert-warning'));
                $this->redirect( array( 'action' => 'index' ));
		  }
		  if ($this->Anexo->save($this->data)) {
				$this->Session->setFlash('El Anexo ha sido grabado', 'default', array('class' => 'alert alert-success'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('El Anexo no fue grabado. Intentelo nuevamente.', 'default', array('class' => 'alert alert-danger'));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Anexo->read(null, $id);
		}
		$resolucionId = $this->Anexo->find('list', array('fields'=>array('resolucion_id')));
        $this->loadModel('Resolucion');
        $resolucions = $this->Resolucion->find('list', array('fields'=>array('numero'), 'conditions'=>array('id'=>$resolucionId)));
        $this->set(compact('resolucions'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($iAnexod = null) {
		if (!$id) {
			$this->Session->setFlash('Id no valido para el anexo', 'default', array('class' => 'alert alert-warning'));
			$this->redirect(array('action' => 'index'));
		}
		if ($this->Anexo->delete($id)) {
			$this->Session->setFlash('El Anexo ha sido borrado', 'default', array('class' => 'alert alert-success'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash('El Anexo no fue borrado', 'default', array('class' => 'alert alert-danger'));
		$this->redirect(array('action' => 'index'));
	}
}
