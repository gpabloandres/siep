<?php
App::uses('AppController', 'Controller');

class EmpleadosController extends AppController {

	var $name = 'Empleados';
	var $paginate = array('Empleado' => array('limit' => 3, 'order' => 'Empleado.id DESC'));
	
    public function beforeFilter() {
        parent::beforeFilter();
        //Si el usuario tiene un rol de superadmin le damos acceso a todo.
        if($this->Auth->user('role') === 'superadmin') {
	        $this->Auth->allow();
	    }  
    }

    function index() {
		$this->Empleado->recursive = 0;
		$this->paginate['Empleado']['limit'] = 4;
		$this->paginate['Empleado']['order'] = array('Empleado.id' => 'ASC');
		$this->redirectToNamed();
		$conditions = array();
				
		if(!empty($this->params['named']['nombre_completo_empleado']))
		{
			$conditions['Empleado.nombre_completo_empleado ='] = $this->params['named']['nombre_completo_empleado'];
		}

		if(!empty($this->params['named']['documento_nro']))
		{
			$conditions['Empleado.documento_nro ='] = $this->params['named']['documento_nro'];
		}
        //Evalúa si existe foto.
		if(empty($this->params['named']['foto'])){
			$foto = 0;
		} else {
			$foto = 1;
		}
		$empleados = $this->paginate('Empleado', $conditions);
		$this->set(compact('empleados', 'foto'));
	}
        		
    function view($id = null) {
		if (!$id) {
			$this->Session->setFlash('Empleado no valido.', 'default', array('class' => 'alert alert-danger'));
			$this->redirect(array('action' => 'index'));
		}
		//Evalúa si existe foto.
		if(empty($this->params['named']['foto'])){
			$foto = 0;
		} else {
			$foto = 1;
		}
		$this->set('empleado', $this->Empleado->read(null, $id));
	    $this->set(compact('foto'));
	}

	function add() {
		  //abort if cancel button was pressed  
          if(isset($this->params['data']['cancel'])){
                $this->Session->setFlash('Los cambios no fueron guardados. Agregación cancelada.', 'default', array('class' => 'alert alert-warning'));
                $this->redirect( array( 'action' => 'index' ));
		  }
		  if (!empty($this->data)) {
			$this->Empleado->create();
			
            // Antes de guardar pasa a mayúsculas el nombre completo.
			$apellidosMayuscula = strtoupper($this->request->data['Empleado']['apellidos']);
			$nombresMayuscula = strtoupper($this->request->data['Empleado']['nombres']);
			// Genera el nombre completo en mayúsculas y se deja en los datos que se intentaran guardar
			$this->request->data['Empleado']['apellidos'] = $apellidosMayuscula;
			$this->request->data['Empleado']['nombres'] = $nombresMayuscula;

			if ($this->Empleado->save($this->data)) {
				$this->Session->setFlash('El empleado ha sido grabado.', 'default', array('class' => 'alert alert-success'));
				$inserted_id = $this->Empleado->id;
				$this->redirect(array('action' => 'view', $inserted_id));
			} else {
				$this->Session->setFlash('El empleado no fué grabado. Intentelo nuevamente.', 'default', array('class' => 'alert alert-danger'));
			}
		}
		$cargos = $this->Empleado->Cargo->find('list');
		$centros = $this->Empleado->Centro->find('list');
		$this->set(compact('cargos', 'centros'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash('Empleado no valido.', 'default', array('class' => 'alert alert-warning'));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
		  //abort if cancel button was pressed  
          if(isset($this->params['data']['cancel'])){
                $this->Session->setFlash('Los cambios no fueron guardados. Edición cancelada.', 'default', array('class' => 'alert alert-warning'));
                $this->redirect( array( 'action' => 'index' ));
		  }
		 
		  // Antes de guardar pasa a mayúsculas el nombre completo.
		  $apellidosMayuscula = strtoupper($this->request->data['Empleado']['apellidos']);
		  $nombresMayuscula = strtoupper($this->request->data['Empleado']['nombres']);
		  // Genera el nombre completo en mayúsculas y se deja en los datos que se intentaran guardar
		  $this->request->data['Empleado']['apellidos'] = $apellidosMayuscula;
		  $this->request->data['Empleado']['nombres'] = $nombresMayuscula; 
         
		  if ($this->Empleado->save($this->data)) {
				$this->Session->setFlash('El empleado ha sido grabado.', 'default', array('class' => 'alert alert-success'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('El empleado no ha sido grabado. Intentelo nuevamente.', 'default', array('class' => 'alert alert-danger'));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Empleado->read(null, $id);
		}
		$cargos = $this->Empleado->Cargo->find('list');
		$centros = $this->Empleado->Centro->find('list');
		$this->set(compact('cargos', 'centros'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash('Id no valida para empleado.', 'default', array('class' => 'alert alert-warning'));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Empleado->delete($id)) {
			$this->Session->setFlash('El Empleado ha sido borrado.', 'default', array('class' => 'alert alert-success'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash('El Empleado no fue borrado.', 'default', array('class' => 'alert alert-danger'));
		$this->redirect(array('action' => 'index'));
	}

	public function autocompleteEmpleados() {
		$term = null;

		if(!empty($this->request->query('term'))) {
			$term = $this->request->query('term');
			$terminos = explode(' ', trim($term));
			$terminos = array_diff($terminos,array(''));
			$conditions = array();

			foreach($terminos as $termino) {
				$conditions[] = array(
						'OR' => array(
							array('nombres LIKE' => '%' . $termino . '%'),
							array('apellidos LIKE' => '%' . $termino . '%')
						)
				);
			}

			$emplados = $this->Empleado->find('all', array(
					'recursive'	=> -1,
					'conditions' => $conditions,
					'fields' 	=> array('id', 'nombres','apellidos'))
			);
		}

		echo json_encode($emplados);
		$this->autoRender = false;
	}
}
?>
