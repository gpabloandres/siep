<?php
App::uses('AppController', 'Controller');

class PasesController extends AppController {

	var $name = 'Pases';
    var $paginate = array('Pase' => array('limit' => 4, 'order' => 'Pase.created DESC'));

	function beforeFilter(){
	    parent::beforeFilter();
		/* ACCESOS SEGÚN ROLES DE USUARIOS (INICIO).
        * Si el usuario tiene un rol de superadmin le damos acceso a todo.
        * Si no es así (se trata de un usuario "admin o usuario") tendrá acceso sólo a las acciones que les correspondan.
        */
        if ($this->Auth->user('role') === 'superadmin') {
	        $this->Auth->allow();
	    } elseif (($this->Auth->user('role') === 'usuario') || ($this->Auth->user('role') === 'admin')) {
	        $this->Auth->allow('index', 'add', 'view', 'edit');
	    }
			if ($this->ifActionIs(array('add', 'edit'))) {
				$this->__lists();
			}
	    /* FIN */
    }

	public function index() {
		$this->Pase->recursive = 0;
		$this->paginate['Pase']['limit'] = 4;
		$this->paginate['Pase']['order'] = array('Pase.created' => 'DESC');
		/* PAGINACIÓN SEGÚN ROLES DE USUARIOS (INICIO).
		* Sí el usuario es "admin" muestra los pases emitidos y recibidos del establecimiento. 
		* Sino sí es "usuario" externo muestra los pases del nivel.
		*/
		$userCentroId = $this->getUserCentroId();
		$userRole = $this->Auth->user('role');
		$this->loadModel('Centro');
		$this->Centro->recursive = 0;
        $this->Centro->Behaviors->load('Containable');
		$nivelCentroArrayIf = $this->Centro->findById($userCentroId, 'nivel_servicio');
		$nivelCentroIf = $nivelCentroArrayIf['Centro']['nivel_servicio'];
		$nivelCentroIdIf = $this->Centro->find('list', array(
			'fields'=>array('id'),
			'contain'=>false,
			'conditions'=>array('nivel_servicio'=>$nivelCentroIf)));
		if ($userRole === 'admin') {
			$this->paginate['Pase']['conditions'] = array('or'=> array('Pase.centro_id_origen' => $userCentroId, 'Pase.centro_id_destino' => $userCentroId));
		} else if (($userRole === 'usuario') && ($nivelCentroIf === 'Común - Inicial - Primario')) {
			$nivelCentroId = $this->Centro->find('list', array('fields'=>array('id'), 'conditions'=>array('nivel_servicio'=>array('Común - Inicial', 'Común - Primario')))); 		
			$this->paginate['Pase']['conditions'] = array('or'=> array('Pase.centro_id_origen' => $nivelCentroId, 'Pase.centro_id_destino' => $nivelCentroId));
		} else if ($userRole === 'usuario') {
			$nivelCentro = $this->Centro->find('list', array(
				'fields'=>array('nivel_servicio'),
				'contain'=>false,
				'conditions'=>array('id'=>$userCentroId)));
			$nivelCentroId = $this->Centro->find('list', array(
				'fields'=>array('id'), 
				'contain'=>false,
				'conditions'=>array('nivel_servicio'=>$nivelCentro)));
			$this->paginate['Pase']['conditions'] = array('or'=> array('Pase.centro_id_origen' => $nivelCentroId, 'Pase.centro_id_destino' => $nivelCentroId));
		}
		/* FIN */
    	/* PAGINACIÓN SEGÚN CRITERIOS DE BÚSQUEDAS (INICIO).
		* Pagina según búsquedas simultáneas ya sea por CICLO y/o CENTRO y/o LEGAJO y/o ESTADO.
		*/
		$this->redirectToNamed();
		$conditions = array();
		if (!empty($this->params['named']['ciclo_id'])) {
			$conditions['Pase.ciclo_id ='] = $this->params['named']['ciclo_id'];
		}
		if (!empty($this->params['named']['alumno_id'])) {
			$conditions['Pase.alumno_id ='] = $this->params['named']['alumno_id'];
		}
		if (!empty($this->params['named']['centro_id_origen'])) {
			$conditions['Pase.centro_id_origen ='] = $this->params['named']['centro_id_origen'];
		}
		if (!empty($this->params['named']['centro_id_destino'])) {
			$conditions['Pase.centro_id_destino ='] = $this->params['named']['centro_id_destino'];
		}
		if(!empty($this->params['named']['anio'])) {
			$conditions['Pase.anio ='] = $this->params['named']['anio'];
		}
		if(!empty($this->params['named']['estado_documentación'])) {
			$conditions['Pase.estado_documentación ='] = $this->params['named']['estado_documentacion'];
		}
		if(!empty($this->params['named']['estado_pase'])) {
			$conditions['Pase.estado_pase ='] = $this->params['named']['estado_pase'];
		}
		$pases = $this->paginate('Pase',$conditions);
		/* FIN */
		/* SETS DE DATOS PARA COMBOBOX (INICIO). */
		/* Carga de Ciclos */
		$this->loadModel('Ciclo');
		$this->Ciclo->recursive = 0;
        $this->Ciclo->Behaviors->load('Containable');
		$ciclosNombre = $this->Ciclo->find('list', array('fields'=>array('id', 'nombre'), 'contain'=>false));
		/* Carga de Centros
		*  Sí es superadmin carga todos los centros.
		*  Sino sí es un usuario de Inicial/Primaria, carga los centros de ambos niveles.
		*  Sino sí es un usuario del resto de los niveles, carga los centros del nivel correspondientes.     
		*/
		if ($userRole == 'superadmin') {
			$centrosNombre = $this->Centro->find('list', array('fields'=>array('id', 'sigla'), 'contain'=>false));
		} else if (($userRole === 'usuario') && ($nivelCentroIf === 'Común - Inicial - Primario')) {
			$nivelCentroId = $this->Centro->find('list', array('fields'=>array('id'), 'contain'=>false, 'conditions'=>array('nivel_servicio'=>array('Común - Inicial', 'Común - Primario')))); 		
			$centrosNombre = $this->Centro->find('list', array('fields'=>array('sigla'), 'contain'=>false, 'conditions'=>array('id'=>$nivelCentroId)));
		} else if ($userRole === 'usuario') {
			$nivelCentroId = $this->Centro->find('list', array('fields'=>array('id'), 'contain'=>false, 'conditions'=>array('nivel_servicio'=>$nivelCentro))); 		
			$centrosNombre = $this->Centro->find('list', array('fields'=>array('sigla'), 'contain'=>false, 'conditions'=>array('id'=>$nivelCentroId)));
		} else if ($userRole == 'admin') {
			$centrosNombre = $this->Centro->find('list', array('fields'=>array('id', 'sigla'), 'contain'=>false, 'conditions'=>array('id'=>$nivelCentroIdIf)));
		}
		 /* Carga de Alumnos */
		$this->loadModel('Alumno');
		$this->Alumno->recursive = 0;
        $this->Alumno->Behaviors->load('Containable');
		$personaId = $this->Alumno->find('list', array('fields'=>array('persona_id'), 'contain'=>false));
		$this->loadModel('Persona');
		$this->Persona->recursive = 0;
        $this->Persona->Behaviors->load('Containable');
        $personaNombre = $this->Persona->find('list', array('fields'=>array('nombre_completo_persona'), 'contain'=>false));
		$centrosNombreTarjetas = $this->Centro->find('list', array('fields'=>array('id', 'sigla'), 'contain'=>false));		
		/* FIN */
		$this->set(compact('pases', 'personaId', 'personaNombre', 'centrosNombre', 'ciclosNombre', 'nivelCentroString', 'centrosNombreTarjetas'));
	}

	public function view($id = null) {
		$this->Pase->recursive = 0;
		if (!$id) {
			$this->Session->setFlash('Pase no válido.', 'default', array('class' => 'alert alert-warning'));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('pase', $this->Pase->read(null, $id));

		//Obtención del ciclo.
        $cicloIdArray = $this->Pase->findById($id, 'ciclo_id');
        $cicloId = $cicloIdArray['Pase']['ciclo_id'];
        $this->loadModel('Ciclo');
		$this->Ciclo->recursive = 0;
        $this->Ciclo->Behaviors->load('Containable');
		$cicloIdArray = $this->Ciclo->findById($cicloId, 'nombre');
		$ciclos = $cicloIdArray['Ciclo']['nombre'];

		//Obtención del centro.
		$this->loadModel('Centro');
		$this->Centro->recursive = 0;
        $this->Centro->Behaviors->load('Containable');
		$centros = $this->Centro->find('list', array('fields' => array('nombre'), 'contain'=>false));

		//Obtención del id de alumno.
        $alumnoIdArray = $this->Pase->findById($id, 'alumno_id');
        $alumnosId = $alumnoIdArray['Pase']['alumno_id'];

		//Obtención del id de persona.
        $this->loadModel('Alumno');
        $this->Alumno->recursive = 0;
        $this->Alumno->Behaviors->load('Containable');
        $personaIdArray = $this->Alumno->findById($alumnosId, 'persona_id');
        $personaId = $personaIdArray['Alumno']['persona_id'];

        //Obtención del nombre completo.
        $this->loadModel('Persona');
        $this->Persona->recursive = 0;
        $this->Persona->Behaviors->load('Containable');
        $personaNombreArray = $this->Persona->findById($personaId, 'nombre_completo_persona');
        $personaNombre = $personaNombreArray['Persona']['nombre_completo_persona'];
        $this->set(compact('pases', 'personaNombre', 'ciclos', 'centros', 'alumnosId'));
	}

	public function add() {
		$this->Pase->recursive = 0;
		/* BOTÓN CANCELAR (INICIO).
		*abort if cancel button was pressed.
		*/
        if(isset($this->params['data']['cancel'])){
            $this->Session->setFlash('Los cambios no fueron guardados. Agregación cancelada.', 'default', array('class' => 'alert alert-warning'));
            $this->redirect( array( 'action' => 'index' ));
		 }
		/* FIN */
		if (!empty($this->data)) {
			$this->Pase->create();
 		    // Genera el id del ciclo actual y se deja en los datos que se intentarán guardar.
			$cicloIdActual = $this->getActualCicloId();
			$cicloIdActualArray = $this->Ciclo->findById($cicloIdActual, 'id');
			$cicloIdActualString = $cicloIdActualArray['Ciclo']['id'];
 			$this->request->data['Pase']['ciclo_id'] = $cicloIdActualString;
			// Guarda el alumno_id 
			$personaId = $this->request->data['Pase']['alumno_id'];
			$alumnoIdArray = $this->Alumno->findByPersonaId($personaId,'id');
			$alumnoIdString = $alumnoIdArray['Alumno']['id'];
			$this->request->data['Pase']['alumno_id'] = $alumnoIdString;
			// Genera el id del centro en función del role del usuario.
			//Se obtiene el centro del usuario
        	$userCentroId = $this->getUserCentroId();
        	$this->request->data['Pase']['centro_id_origen'] = $userCentroId;
			// Antes de guardar genera el estado de la documentación
			if ($this->request->data['Pase']['nota_tutor'] == true) {
			    	$estadoDocumentacion = "COMPLETA";
			    } else {
			        $estadoDocumentacion = "PENDIENTE";
			    }
			// Deja el estado de la documentación en los datos que se intentarán guardar.
			$this->request->data['Pase']['estado_documentacion'] = $estadoDocumentacion;
			// Genera el usuario id y se deja en los datos que se intentarán guardar.
			$userId = $this->Auth->user('id');
			$this->request->data['Pase']['usuario_id'] = $userId;
 		    // Antes de guardar genera el estado del pase y lo deja en los datos que se intentarán guardar.
			$estadoPase = 'INICIADO';
			$this->request->data['Pase']['estado_pase'] = $estadoPase;
 		    // Guarda los datos.
			if ($this->Pase->save($this->data)) {
				$this->Session->setFlash('El pase ha sido grabado.', 'default', array('class' => 'alert alert-success'));
				$inserted_id = $this->Pase->id;
				$this->redirect(array('action' => 'view', $inserted_id));
			} else {
				$this->Session->setFlash('El pase no fue grabado. Intente nuevamente.', 'default', array('class' => 'alert alert-danger'));
			}
		}
	}

	public function edit($id = null) {
		$this->Pase->recursive = 0;
		if (!$id && empty($this->data)) {
			$this->Session->setFlash('Pase no válido.', 'default', array('class' => 'alert alert-warning'));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
		    //abort if cancel button was pressed
            if (isset($this->params['data']['cancel'])) {
                $this->Session->setFlash('Los cambios no fueron guardados. Edición cancelada.', 'default', array('class' => 'alert alert-warning'));
                $this->redirect( array( 'action' => 'index' ));
		    }
			//Antes de guardar genera el estado de la inscripción
			if ($this->request->data['Pase']['nota_tutor'] == true) {
			   $estadoDocumentacion = "COMPLETA";
			} else {
			   $estadoDocumentacion = "PENDIENTE";
			}
			//Se genera el estado y se deja en los datos que se intentaran guardar
			$this->request->data['Pase']['estado_documentacion'] = $estadoDocumentacion;
			// Sí se confirma el pase, se modifica el id del centro del alumno. 
			$estadoPase = $this->request->data['Pase']['estado_pase'];
			if ($estadoPase == 'CONFIRMADO') {
				/* ATUALIZA ESTADO DE INSCRIPCIÓN (INICIO).
	            *  Al registrarse CONFIRMADO el pase del alumno, modifica la última inscripción de ese alumno:
	            *  pone el estado de inscripción en 'BAJA' y modifica la matrícula del curso correspondiente. 
	            */
	   			// Obtiene el id del pase.
				$paseId = $this->request->data['Pase']['id'];

	   			// Obtiene el id del alumno relacionado a ese pase.
				$alumnoIdArray = $this->Pase->findById($paseId, 'alumno_id');
				$alumnoIdString = $alumnoIdArray['Pase']['alumno_id'];
				
				// Obtiene el id del ciclo actual.
				$this->loadModel('Ciclo');
				$cicloIdActual = $this->getActualCicloId();
	        	$cicloIdActualArray = $this->Ciclo->findById($cicloIdActual, 'id');
	        	$cicloIdActualString = $cicloIdActualArray['Ciclo']['id'];
	        	
	        	// Obtiene el id de la inscripcion relacionada al alumno del pase y al ciclo actual.
	        	$this->loadModel('Inscripcion');
	        	$lastInscripcionId = $this->Inscripcion->find('list', array(
	                	'fields'=>array('id'), 
	                	'conditions'=>array('alumno_id'=>$alumnoIdString, 'ciclo_id'=>$cicloIdActualString)
	                ));
	        	$lastInscripcionIdArray = $this->Inscripcion->findById($lastInscripcionId, 'id');
	        	$lastInscripcionIdString = $lastInscripcionIdArray['Inscripcion']['id'];
				
				// Cambia a 'BAJA' el estado de esa inscripción.
        		$this->Inscripcion->id=$lastInscripcionId;
                $this->Inscripcion->saveField("estado_inscripcion", 'BAJA');
                
                // Modifica la matrícula de los cursos relacionados a esa inscripción.
                // Identifica los cursos.
                $cursosId = $this->Inscripcion->CursosInscripcion->find('list', array('fields'=>array('curso_id'), 'conditions'=>array('CursosInscripcion.inscripcion_id'=>$lastInscripcionId)));                
                //foreach ($cursosId as $cursosId) {
                	// Para cada curso resta en 1 la matrícula y suma en 1 la vacante.
                	$this->loadModel('Curso');
                	$this->Curso->recursive = 0;
        			$this->Curso->Behaviors->load('Containable');
                	$cursosIdArray = $this->Curso->findById($cursosId, 'id');
                	$cursosIdString = $cursosIdArray['Curso']['id']; 
                	$this->Curso->id=$cursosIdString;
	                $matricula = $this->Curso->findById($cursosId,'id, matricula');
		            $cursoMatricula = $matricula['Curso']['matricula'];
	                $matriculaActual = $cursoMatricula - 1;
	                $this->Curso->saveField("matricula", $matriculaActual);
	                $vacantes = $this->Curso->findById($cursosId,'id, vacantes');
		            $cursoVacantes = $vacantes['Curso']['vacantes'];
	                $vacantesActual = $cursoVacantes + 1;
	                $this->Curso->saveField("vacantes", $vacantesActual);
                //}
                /* FIN */
			}
			if ($this->Pase->save($this->data)) {
				$this->Session->setFlash('El pase ha sido grabado.', 'default', array('class' => 'alert alert-success'));
				$inserted_id = $this->Pase->id;
				$this->redirect(array('action' => 'view', $inserted_id));
			} else {
				$this->Session->setFlash('El pase no fué grabado. Intente nuevamente.', 'default', array('class' => 'alert alert-danger'));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Pase->read(null, $id);
			$this->set('pases', $this->Pase->read(null, $id));
		}
		$this->loadModel('Persona');
    	$this->Persona->recursive = 0;
        $this->Persona->Behaviors->load('Containable');
    	$personaNombres = $this->Persona->find('list', array(
    										'fields'=>array('id', 'nombre_completo_persona'),
    										'contain'=>false));
    	$this->set(compact('pase', 'personaNombres'));
	}

    public function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash('Id no valida para pase.', 'default', array('class' => 'alert alert-warning'));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Pase->delete($id)) {
			$this->Session->setFlash('El pase ha sido borrado.', 'default', array('class' => 'alert alert-success'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash('El pase no fué borrado. Intentelo nuevamente.', 'default', array('class' => 'alert alert-danger'));
		$this->redirect(array('action' => 'index'));
	}

	//Métodos privados
	private function __lists(){
		/* Carga de Centros
		*  Sí es superadmin carga todos los centros.
		*  Sino sí es un usario de Inicial/Primaria, carga los centros de ambos niveles.
		*  Sino sí es un usuario del resto de los niveles, carga los centros del nivel correspondientes.     
		*/
		//Obtención del rol y centro del usuario.
		$this->loadModel('User');
		$userRole = $this->Auth->user('role');
		$userCentroId = $this->getUserCentroId();
		//Obtención de información de los Centros.
		$this->loadModel('Centro');
		$this->Centro->recursive = 0;
        $this->Centro->Behaviors->load('Containable');
		$nivelCentroIf = $this->Centro->find('list', array(
			'fields'=>array('id','nivel_servicio'),
			'contain'=>false,
			'conditions'=>array('id'=>$userCentroId)));
		$nivelCentroIdIf = $this->Centro->find('list', array(
			'fields'=>array('id'),
			'contain'=>false,
			'conditions'=>array('nivel_servicio'=>$nivelCentroIf)));
		$nivelCentroArrayIf = $this->Centro->findById($nivelCentroIdIf, 'nivel_servicio');
		$nivelCentroStringIf = $nivelCentroArrayIf['Centro']['nivel_servicio'];
		if ($userRole == 'superadmin') {
			$centrosNombre = $this->Centro->find('list', array(
				'fields'=>array('id', 'sigla'),
				'contain'=>false));
		} else if (($userRole === 'usuario') && ($nivelCentroIf === 'Común - Inicial - Primario')) {
			$nivelCentroId = $this->Centro->find('list', array(
				'fields'=>array('id'),
				'contain'=>false,
				'conditions'=>array('nivel_servicio'=>array('Común - Inicial', 'Común - Primario'))));
			$centrosNombre = $this->Centro->find('list', array('fields'=>array('sigla'),
				'contain'=>false,
				'conditions'=>array('id'=>$nivelCentroId)));
		} else if ($userRole === 'usuario') {
			$nivelCentroId = $this->Centro->find('list', array(
				'fields'=>array('id'),
				'contain'=>false,
				'conditions'=>array('nivel_servicio'=>$nivelCentroIf))); 		
			$centrosNombre = $this->Centro->find('list', array(
				'fields'=>array('sigla'),
				'contain'=>false,
				'conditions'=>array('id'=>$nivelCentroId)));
		} else if ($userRole == 'admin') {
			$centrosNombre = $this->Centro->find('list', array(
				'fields'=>array('id', 'sigla'),
				'contain'=>false,
				'conditions'=>array('id'=>$nivelCentroIdIf)));
		}
		/* Carga de Alumnos
		*  Sí es un usuario "admin", carga los alumnos del centro correspondiente.     
		*  Sino sí es "usuario" o "superadmin" carga todos los alumnos.
		*/
		//Obtención de los datos de alumnos.
		$this->loadModel('Alumno');
		$this->Alumno->recursive = 0;
        $this->Alumno->Behaviors->load('Containable');
        //Obtención de los datos de alumnos.
		$this->loadModel('Persona');
		$this->Persona->recursive = 0;
        $this->Persona->Behaviors->load('Containable');
		if($userRole == 'admin'){
			$alumnos = $this->Alumno->find('list', array(
				'fields'=>array('persona_id'),
				'contain'=>false,
				'conditions'=>array('centro_id'=>$userCentroId)));
			$PersonaAlumnoId = $this->Persona->find('list', array(
				'fields'=>array('nombre_completo_persona'),
				'contain'=>false,
				'conditions'=>array('id'=>$alumnos)));
		} else {  //Si el rol del usuario es "usuario" o "superadmin"
			$alumnos = $this->Alumno->find('list', array(
				'fields'=>array('persona_id'),
				'contain'=>false));
			$PersonaAlumnoId = $this->Persona->find('list', array(
				'fields'=>array('nombre_completo_persona'),
				'contain'=>false,
				'conditions'=>array('id'=>$alumnos)));
		}
		$this->set(compact('centrosNombre', 'personasNombre', 'PersonaAlumnoId'));
	}
}
?>
