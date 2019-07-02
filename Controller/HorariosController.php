<?php
class HorariosController extends AppController {

	var $name = 'Horarios';
 	var $paginate = array('Horario' => array('limit' => 6, 'order' => 'Horario.dia DESC'));

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
					$this->Auth->allow('index', 'view');	
				}
				break;
			case 'usuario':
			case 'admin':
				$this->Auth->allow('index', 'view');
				break;

			default:
				$this->Session->setFlash('No tiene permisos.', 'default', array('class' => 'alert alert-warning'));
				$this->redirect($this->referer());
				break;
		}
		/* FIN */
    }
	
	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Horario no valido.'));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('horario', $this->Horario->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Horario->create();
			if ($this->Horario->save($this->data)) {
				$this->Session->setFlash(__('EL horario ha sido grabado.'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('EL horario no ha sido grabado. Favor, intente nuevamente.'));
			}
		}
		$materias = $this->Horario->Materia->find('list');
		$this->set(compact('materias'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Horario no valido.'));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Horario->save($this->data)) {
				$this->Session->setFlash(__('EL horario ha sido grabado.'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('EL horario no ha sido grabado. Favor, intente nuevamente.'));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Horario->read(null, $id);
		}
		$materias = $this->Horario->Materia->find('list');
		$this->set(compact('materias'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Id no valido para horario.'));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Horario->delete($id)) {
			$this->Session->setFlash(__('Horario borrado.'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Horario no fue borrado.'));
		$this->redirect(array('action' => 'index'));
	}
}
?>