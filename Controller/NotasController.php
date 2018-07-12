<?php
class NotasController extends AppController {

	var $name = 'Notas';
    var $paginate = array('Nota' => array('limit' => 4, 'order' => 'Nota.created DESC'));

	function beforeFilter(){
	    parent::beforeFilter();
		if($this->ifActionIs(array('add', 'edit'))){
			$this->__lists();
		}
	}

	public function index() {
		$this->Nota->recursive = -1;
		
        $this->paginate['Nota']['limit'] = 6;
		$this->paginate['Nota']['order'] = array('Nota.ciclo' => 'DESC');
		
		$alumnos = $this->Nota->Persona->find('list', array('fields'=>array('id', 'nombre_completo_persona'), 'order'=>'Persona.apellidos ASC'));
		$materias = $this->Nota->Materia->find('list', array('fields'=>array('materia_id'), 'order'=>'Materia.curso_id ASC'));
		$ciclos = $this->Nota->Ciclo->find('list');
		$this->redirectToNamed();
		$conditions = array();
		
		if(!empty($this->params['named']['persona_id']))
		{
			$conditions['Nota.persona_id ='] = $this->params['named']['persona_id'];
		}
		if(!empty($this->params['named']['ciclo_id']))
		{
			$conditions['Nota.ciclo_id ='] = $this->params['named']['ciclo_id'];
		}
		if(!empty($this->params['named']['materia_id']))
		{
			$conditions['Nota.materia_id ='] = $this->params['named']['materia_id'];
		}
		
		$notas = $this->paginate('Nota',$conditions);
		$this->set(compact('notas', 'alumnos', 'ciclos', 'materias'));

	}

	public function view($id = null) {
		if (!$id) {
			$this->Session->setFlash('Calificación no valida.', 'default', array('class' => 'alert alert-warning'));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('nota', $this->Nota->read(null, $id));
	}

	public function add() {
		  //abort if cancel button was pressed  
          if(isset($this->params['data']['cancel'])){
                $this->Session->setFlash('Los cambios no fueron guardados. Agregación cancelada.', 'default', array('class' => 'alert alert-warning'));
                $this->redirect( array( 'action' => 'index' ));
		  }
		  if (!empty($this->data)) {
			$this->Nota->create();
		
          //Antes de guardar calcula el promedio del primer período.
            $notaUnoPrimero = $this->request->data['Nota']['nota_uno_primer_periodo'];
            $notaDosPrimero = $this->request->data['Nota']['nota_dos_primer_periodo'];
            $notaTresPrimero = $this->request->data['Nota']['nota_tres_primer_periodo'];
            $promedio_primero = $this->__getPromedio($notaUnoPrimero, $notaDosPrimero, $notaTresPrimero);  
            //Genera el promedio del primer período y se deja en los datos que se intentaran guardar
			    $this->request->data['Nota']['promedio_primer_periodo'] = $promedio_primero;

            if ($this->Nota->save($this->data)) {
				$this->Session->setFlash('La calificación ha sido grabada.', 'default', array('class' => 'alert alert-success'));
				$inserted_id = $this->Nota->id;
				$this->redirect(array('action' => 'view', $inserted_id));
			} else {
				$this->Session->setFlash('La calificación no fue grabada. Intente nuevamente.', 'default', array('class' => 'alert alert-danger'));
			}
		}
	}

	public function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash('Calificación no valida.', 'default', array('class' => 'alert alert-warning'));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
		  //abort if cancel button was pressed  
            if(isset($this->params['data']['cancel'])){
                $this->Session->setFlash('Los cambios no fueron guardados. Edición cancelada.', 'default', array('class' => 'alert alert-warning'));
                $this->redirect( array( 'action' => 'index' ));
		  }
			
			//Antes de guardar calcula el promedio del primer período.
            $notaUnoPrimero = $this->request->data['Nota']['nota_uno_primer_periodo'];
            $notaDosPrimero = $this->request->data['Nota']['nota_dos_primer_periodo'];
            $notaTresPrimero = $this->request->data['Nota']['nota_tres_primer_periodo'];
            $promedio_primero = $this->__getPromedio($notaUnoPrimero, $notaDosPrimero, $notaTresPrimero);  
            //Genera el promedio del primer período y se deja en los datos que se intentaran guardar
			    $this->request->data['Nota']['promedio_primer_periodo'] = $promedio_primero;

			if ($this->Nota->save($this->data)) {
				$this->Session->setFlash('La calificación ha sido grabada.', 'default', array('class' => 'alert alert-success'));
				//$this->redirect(array('action' => 'index'));
				$inserted_id = $this->Nota->id;
				$this->redirect(array('action' => 'view', $inserted_id));
			} else {
				$this->Session->setFlash('La calificación no fue grabada. Intente nuevamente.', 'default', array('class' => 'alert alert-danger'));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Nota->read(null, $id);
		}
	}

	public function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash('Id no valida para calificación.', 'default', array('class' => 'alert alert-warning'));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Nota->delete($id)) {
			$this->Session->setFlash('La calificación ha sido borrada.', 'default', array('class' => 'alert alert-success'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash('La calificación no fue borrada.', 'default', array('class' => 'alert alert-danger'));
		$this->redirect(array('action' => 'index'));
	}

	
	//Métodos privados.
	private function __lists(){
		$cicloIdActual = $this->getLastCicloId();
        $cicloInscripcionAlumnoId = $this->getLastCicloInscripcionAlumnoId($cicloIdActual);
        $alumnos = $this->Nota->Persona->find('list', array('fields'=>array('id', 'nombre_completo_persona'), 'order'=>'Persona.apellidos ASC', 'conditions'=>array('Persona.id'=>$cicloInscripcionAlumnoId)));
		$materias = $this->Nota->Materia->find('list', array('fields'=>array(), 'order'=>'Materia.curso_id ASC'));
		$ciclos = $this->Nota->Ciclo->find('list');
		$this->set(compact('alumnos', 'materias', 'ciclos', 'cicloIdActual'));
	}

	/**
	* Devuelve el promedio de tres notas.  
	*/
	private function __getPromedio($nota1, $nota2, $nota3)
	{
	    if(!$nota1 && !$nota2 && !$nota3){
          $promedio = 0; 
	    }
	    else if($nota1 && !$nota2 && !$nota3){
          $promedio = round($nota1);
	    }else if($nota1 && $nota2 && !$nota3){
          $promedio = round(($nota1 + $nota2)/2);  
	    }else if($nota1 && $nota2 && $nota3){ 
	      $promedio = round(($nota1 + $nota2 + $nota3)/3);	
	    }
	    return $promedio;
	}
}
?>