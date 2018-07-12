<?php
App::uses('AppController', 'Controller');

class GraficosController extends AppController {
	var $name = 'Graficos';

    var $helpers = array('Session');
	public $components = array('Auth','Session', 'RequestHandler');
	
	function beforeFilter(){
		parent::beforeFilter();
	}

	
	public function index() {
    } 

    public function i_x_curso() {
     	$this->loadModel('Curso');
     	$cursos = $this->Curso->find('list', array('field'=>array('matricula'), 'conditions'=>array('centro_id'=>19)));
		$this->set(compact($cursos));
	}

	public function r_x_curso() {

	}

	public function a_x_curso() {

	}

}
?>