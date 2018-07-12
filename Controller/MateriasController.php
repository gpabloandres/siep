<?php
class MateriasController extends AppController {

	var $name = 'Materias';
    public $uses = array('Materia', 'Inscripcion');
	var $paginate = array('Materia' => array('limit' => 6, 'order' => 'Materia.alia DESC'));

    public function beforeFilter() {
        parent::beforeFilter();
        //Si el usuario tiene un rol de superadmin le damos acceso a todo.
        //Si no es así (se trata de un usuario "admin o usuario") tendrá acceso sólo a las acciones que les correspondan.
        if(($this->Auth->user('role') === 'superadmin')  || ($this->Auth->user('role') === 'admin')) {
	        $this->Auth->allow();
	    } elseif ($this->Auth->user('role') === 'usuario') { 
	        $this->Auth->allow('index', 'view');
	    } 
    }

    public function sanitize($string, $force_lowercase = true, $anal = false) {
    $strip = array("~", "`", "!", "@", "#", "$", "%", "^", "&", "*", "(", ")", "_", "=", "+", "[", "{", "]","}", "\\", "|", ";", ":", "\"", "'", "&#8216;", "&#8217;", "&#8220;", "&#8221;", "&#8211;", "&#8212;","â€", "â€", ",", "<",">", "/", "?");
    $clean = trim(str_replace($strip, "", strip_tags($string)));
    $clean = preg_replace('/\s+/', "-", $clean);
    $clean = ($anal) ? preg_replace("/[^a-zA-Z0-9]/", "", $clean) : $clean ;
    return ($force_lowercase) ?
        (function_exists('mb_strtolower')) ?
            mb_strtolower($clean, 'UTF-8') :
            strtolower($clean) :
        $clean;
    }

	public function index() {
		$this->Materia->recursive = 1;
		$this->paginate['Materia']['limit'] = 6;
		$this->paginate['Materia']['order'] = $this->Materia->Curso->find('list', array('fields'=>array('id', 'nombre_completo_curso'), 'order'=>'Curso.anio ASC'));
		/* PAGINACIÓN SEGÚN ROLES DE USUARIOS (INICIO).
		*  Sí el usuario es "admin" muestra las materias del establecimiento. 
		*  Sino sí es "usuario" externo muestra los materias del nivel.
		*/ 
		$userCentroId = $this->getUserCentroId();
		$userRole = $this->Auth->user('role');
		if ($userRole === 'admin') {
			$cursosId = $this->Materia->Curso->find('list', array('fields'=>array('id'), 'conditions'=>array('centro_id'=>$userCentroId)));
			$this->paginate['Materia']['conditions'] = array('Materia.curso_id' => $cursosId);
		} else if ($userRole === 'usuario') {
			$nivelCentro = $this->Materia->Curso->Centro->find('list', array('fields'=>array('nivel_servicio'), 'conditions'=>array('id'=>$userCentroId)));
			$nivelCursoId = $this->Materia->Curso->Centro->find('list', array('fields'=>array('id'), 'conditions'=>array('nivel_servicio'=>$nivelCentro))); 		
			$this->paginate['Materia']['conditions'] = array('Materia.curso_id' => $nivelCursoId);
		}
		/* FIN */
		$this->redirectToNamed();
		$conditions = array();
		if(!empty($this->params['named']['centro_id']))
		{
			$conditions['Curso.centro_id ='] = $this->params['named']['centro_id'];
		}
		if(!empty($this->params['named']['curso_id']))
		{
			$conditions['Materia.curso_id ='] = $this->params['named']['curso_id'];
		}
		if(!empty($this->params['named']['alia']))
		{
			$conditions['Materia.alia ='] = $this->params['named']['alia'];
		}
		if(!empty($this->params['named']['pan_de_estudio']))
		{
			$conditions['Materia.plan_de_estudio ='] = $this->params['named']['plan_de_estudio'];
		}
		$materias = $this->paginate('Materia', $conditions);
		$centrosId = $this->Materia->Curso->find('list', array('fields'=>array('centro_id')));
        $this->loadModel('Centro');
        $centrosNombre = $this->Centro->find('list', array('fields'=>array('sigla')));
        $this->set(compact('materias', 'cursos', 'centrosNombre'));
	}

	public function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Unidad no valida.'));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('materia', $this->Materia->read(null, $id));

		//Genera nombres en los datos relacionados.
		$horarioCicloId = $this->Materia->Horario->find('list', array('fields'=>array('ciclo_id')));
		$this->loadModel('Ciclo');
		$cicloNombre = $this->Ciclo->find('list', array('fields'=>array('nombre'), 'conditions'=>array('id'=>$horarioCicloId)));
		
		$horarioMateriaId = $this->Materia->Horario->find('list', array('fields'=>array('materia_id')));
		$this->loadModel('Materia');
		$materiaAlia = $this->Materia->find('list', array('fields'=>array('alia'), 'conditions'=>array('id'=>$horarioMateriaId)));
		
		$inscripcionAlumnoId = $this->Materia->Inscripcion->find('list', array('fields'=>array('persona_id')));
		$this->loadModel('Persona');
		$alumnoNombre = $this->Persona->find('list', array('fields'=>array('nombre_completo_persona'), 'conditions'=>array('id'=>$inscripcionAlumnoId)));
		
		$disenocurricularId = $this->Materia->find('list', array('fields'=>array('disenocurricular_id')));
		$this->loadModel('Disenocurricular');
		$disenocurriculars = $this->Disenocurricular->find('list', array('fields'=>array('anio'), 'conditions'=>array('id'=>$disenocurricularId))); 
		
		$this->set(compact('cicloNombre', 'materiaAlia', 'alumnoNombre', 'disenocurriculars'));
	}

	
	public function add() {
        //abort if cancel button was pressed  
        if(isset($this->params['data']['cancel'])){
                $this->Session->setFlash('Los cambios no fueron guardados. Agregación cancelada.', 'default', array('class' => 'alert alert-warning'));
                $this->redirect( array( 'action' => 'index' ));
		}
		/* Para guardar con contenidos
        if ($this->request->is('post')) {
            $this->Materia->create();
            if(empty($this->data['Materia']['contenido']['name'])){
               unset($this->request->data['Materia']['contenido']);
            }
	        if(!empty($this->data['Materia']['contenido']['name'])){
			   $file=$this->data['Materia']['contenido'];
			   $file['name']=$this->sanitize($file['name']);
			   $this->request->data['Materia']['contenido'] = time().$file['name'];
			   if($this->Materia->save($this->request->data)) {
				  move_uploaded_file($file['tmp_name'], APP . 'webroot/files/materias/' .DS. time().$file['name']);  
				  $this->Session->setFlash(__('Los Contenidos se guardaron.'));
				  //return $this->redirect(array('action' => 'index'));
				  $inserted_id = $this->Materia->id;
				  $this->redirect(array('action' => 'view', $inserted_id));
		       }
	        }
           $this->Session->setFlash(__('Los Contenidos no se guardaron.'));
        }
        */
        if(isset($this->params['data']['cancel'])){
                $this->Session->setFlash('Los cambios no fueron guardados. Agregación cancelada.', 'default', array('class' => 'alert alert-warning'));
                $this->redirect( array( 'action' => 'index' ));
		}
        if (!empty($this->data)) {
			$this->Materia->create();
			
		if ($this->Materia->save($this->request->data)) {
			$this->Session->setFlash('La unidad ha sido grabada', 'default', array('class' => 'alert alert-success'));
			$inserted_id = $this->Materia->id;
			$this->redirect(array('action' => 'view', $inserted_id));
		} else {
			$this->Session->setFlash('La unidad no fue grabada. Intentelo nuevamente.', 'default', array('class' => 'alert alert-danger'));
		}
	}
        $cursos = $this->Materia->Curso->find('list', array('fields'=>array('id','nombre_completo_curso')));
        $this->set(compact('cursos'));
    }
	
	public function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash('Unidad no valida.', 'default', array('class' => 'alert alert-warning'));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
		  //abort if cancel button was pressed  
          if(isset($this->params['data']['cancel'])){
                $this->Session->setFlash('Los cambios no fueron guardados. Edición cancelada.', 'default', array('class' => 'alert alert-warning'));
                $this->redirect( array( 'action' => 'index' ));
		  }
		  if ($this->Materia->save($this->data)) {
				$this->Session->setFlash('La unidad ha sido grabada.', 'default', array('class' => 'alert alert-success'));
				//$this->redirect(array('action' => 'index'));
				$inserted_id = $this->Materia->id;
				$this->redirect(array('action' => 'view', $inserted_id));
			} else {
				$this->Session->setFlash('La unidad no ha sido grabada. Intentelo nuevamente.', 'default', array('class' => 'alert alert-danger'));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Materia->read(null, $id);
		}
		$disenocurricularId = $this->Materia->find('list', array('fields'=>array('disenocurricular_id')));
		$this->loadModel('Disenocurricular');
		$disenocurriculars = $this->Disenocurricular->find('list', array('fields'=>array('anio'), 'conditions'=>array('id'=>$disenocurricularId)));
		$cursos = $this->Materia->Curso->find('list', array('fields'=>array('id','nombre_completo_curso')));
		$this->set(compact('disenocurriculars', 'alumnos'));
	}
   
	public function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash('Id no valido para unidad.', 'default', array('class' => 'alert alert-warning'));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Materia->delete($id)) {
			$this->Session->setFlash('La unidad ha sido borrada.', 'default', array('class' => 'alert alert-success'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash('Unidad no fue borrada.', 'default', array('class' => 'alert alert-danger'));
		$this->redirect(array('action' => 'index'));
	}
}
?>