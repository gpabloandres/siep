<?php
App::uses('AppController', 'Controller');

class InscripcionsController extends AppController {

	var $name = 'Inscripcions';
    var $paginate = array('Inscripcion' => array('limit' => 4, 'order' => 'Inscripcion.fecha_alta DESC'));

	function beforeFilter(){
	    parent::beforeFilter();
		/* ACCESOS SEGÚN ROLES DE USUARIOS (INICIO).
        *Si el usuario tiene un rol de superadmin le damos acceso a todo. Si no es así (se trata de un usuario "admin o usuario") tendrá acceso sólo a las acciones que les correspondan.
        */
        if ($this->Auth->user('role') === 'superadmin') {
	        $this->Auth->allow();
	    } elseif ($this->Auth->user('role') === 'usuario') {
	        $this->Auth->allow('index', 'add', 'view', 'edit', 'constanciaPdf');
	    } else if ($this->Auth->user('role') === 'admin') {
            $this->Auth->allow('index', 'view', 'edit', 'constanciaPdf');
        }
	    /* FIN */
        /* FUNCIÓN PRIVADA "LISTS" (INICIO).
        *Si se ejecutan las acciones add/edit activa la función privada "lists".
		*/
		if ($this->ifActionIs(array('add', 'edit'))) {
			$this->__lists();
		}
		/* FIN */
        App::uses('HttpSocket', 'Network/Http');
    }

	public function index() {
		$this->Inscripcion->recursive = 1;
		$this->paginate['Inscripcion']['limit'] = 4;
		$this->paginate['Inscripcion']['order'] = array('Inscripcion.fecha_alta' => 'DESC');
		/* PAGINACIÓN SEGÚN ROLES DE USUARIOS (INICIO).
		*Sí el usuario es "admin" muestra los cursos del establecimiento. Sino sí es "usuario" externo muestra los cursos del nivel.
		*/
        $userRole = $this->Auth->user('role');
        $userCentroId = $this->getUserCentroId();
        $this->loadModel('Centro');
        $nivelCentroArray = $this->Centro->findById($userCentroId, 'nivel_servicio');
        $nivelCentro = $nivelCentroArray['Centro']['nivel_servicio'];
        $nivelCentroId = $this->Centro->find('list', array('fields'=>array('id'), 'conditions'=>array('nivel_servicio'=>$nivelCentro)));
		if ($this->Auth->user('role') === 'admin') {
        $this->paginate['Inscripcion']['conditions'] = array('Inscripcion.centro_id' => $userCentroId, 'Inscripcion.estado_inscripcion' =>array('CONFIRMADA','NO CONFIRMADA'));    
        } else if (($userRole === 'usuario') && ($nivelCentro === 'Común - Inicial - Primario')) {
			$nivelCentroId = $this->Centro->find('list', array('fields'=>array('id'), 'conditions'=>array('nivel_servicio'=>array('Común - Inicial', 'Común - Primario'))));
			$this->paginate['Inscripcion']['conditions'] = array('Inscripcion.centro_id' => $nivelCentroId, 'Inscripcion.estado_inscripcion' =>array('CONFIRMADA','NO CONFIRMADA'));
		} else if ($userRole === 'usuario') {
			$nivelCentroId = $this->Centro->find('list', array('fields'=>array('id'), 'conditions'=>array('nivel_servicio'=>$nivelCentro)));
			$this->paginate['Inscripcion']['conditions'] = array('Inscripcion.centro_id' => $nivelCentroId, 'Inscripcion.estado_inscripcion' =>array('CONFIRMADA','NO CONFIRMADA'));
		}
		/* FIN */
    	/* PAGINACIÓN SEGÚN CRITERIOS DE BÚSQUEDAS (INICIO).
		*Pagina según búsquedas simultáneas ya sea por CICLO y/o CENTRO y/o LEGAJO y/o ESTADO.
		*/
    	$this->redirectToNamed();
		$conditions = array();
		if (!empty($this->params['named']['ciclo_id'])) {
			$conditions['Inscripcion.ciclo_id ='] = $this->params['named']['ciclo_id'];
		}
		if (!empty($this->params['named']['centro_id'])) {
			$conditions['Inscripcion.centro_id ='] = $this->params['named']['centro_id'];
		}
		if (!empty($this->params['named']['legajo_nro'])) {
			$conditions['Inscripcion.legajo_nro ='] = $this->params['named']['legajo_nro'];
		}
		if(!empty($this->params['named']['tipo_inscripcion'])) {
            $conditions['Inscripcion.tipo_inscripcion ='] = $this->params['named']['tipo_inscripcion'];
        }
        if(!empty($this->params['named']['estado_documentacion'])) {
			$conditions['Inscripcion.estado_documentacion ='] = $this->params['named']['estado_documentacion'];
		}
        if(!empty($this->params['named']['estado_inscripcion'])) {
            $conditions['Inscripcion.estado_inscripcion ='] = $this->params['named']['estado_inscripcion'];
        }
		$inscripcions = $this->paginate('Inscripcion',$conditions);
		/* FIN */
		/* SETS DE DATOS PARA COMBOBOX (INICIO). */
		/* Carga de Ciclos */
        $ciclos = $this->Inscripcion->Ciclo->find('list', array('fields'=>array('id', 'nombre')));
        /* Carga de Centros
        *  Sí es superadmin carga todos los centros.
        *  Sino sí es un usario de Inicial/Primaria, carga los centros de ambos niveles.
        *  Sino sí es un usuario del resto de los niveles, carga los centros del nivel correspondientes.     
        */
        $this->loadModel('Centro');
        $nivelCentroArray = $this->Centro->findById($userCentroId, 'nivel_servicio');
        $nivelCentro = $nivelCentroArray['Centro']['nivel_servicio'];
        $nivelCentroId = $this->Centro->find('list', array('fields'=>array('id'), 'conditions'=>array('nivel_servicio'=>$nivelCentro)));
		if ($userRole == 'superadmin') {
			$centros = $this->Inscripcion->Centro->find('list', array('fields'=>array('id', 'sigla')));
		} else if (($userRole === 'usuario') && ($nivelCentro === 'Común - Inicial - Primario')) {
			$nivelCentroId = $this->Inscripcion->Centro->find('list', array('fields'=>array('id'), 'conditions'=>array('nivel_servicio'=>array('Común - Inicial', 'Común - Primario')))); 		
			$centros = $this->Inscripcion->Centro->find('list', array('fields'=>array('sigla'), 'conditions'=>array('id'=>$nivelCentroId)));
        } else if ($userRole === 'usuario') {
            $nivelCentroId = $this->Inscripcion->Centro->find('list', array('fields'=>array('id'), 'conditions'=>array('nivel_servicio'=>$nivelCentro)));       
            $centros = $this->Inscripcion->Centro->find('list', array('fields'=>array('sigla'), 'conditions'=>array('id'=>$nivelCentroId)));
        } else if ($userRole == 'admin') {
			$centros = $this->Inscripcion->Centro->find('list', array('fields'=>array('id', 'sigla'), 'conditions'=>array('id'=>$nivelCentroId)));
		}
        /* Carga de Alumnos */
		$personaId = $this->Inscripcion->Alumno->find('list', array('fields'=>array('persona_id')));
        $this->loadModel('Persona');
        $personaNombre = $this->Persona->find('list', array('fields'=>array('nombre_completo_persona')));
        /* FIN */
		$this->set(compact('inscripcions', 'personaId', 'personaNombre', 'centros', 'ciclos'));
	}

    public function view($id = null) {
        if (!$id) {
            $this->Session->setFlash('Inscripcion no valida.', 'default', array('class' => 'alert alert-warning'));
            $this->redirect(array('action' => 'index'));
        }
        $this->set('inscripcion', $this->Inscripcion->read(null, $id));
        $personaId = $this->Inscripcion->Alumno->find('list', array('fields'=>array('persona_id')));
        $this->loadModel('Persona');
        $personaNombre = $this->Persona->find('list', array('fields'=>array('nombre_completo_persona')));
        $this->set(compact('inscripcions', 'personaId', 'personaNombre'));
    }

	public function add() {
        /* BOTÓN CANCELAR (INICIO).
        *abort if cancel button was pressed.
        */

        if (isset($this->params['data']['cancel'])) {
            $this->Session->setFlash('Los cambios no fueron guardados. Agregación cancelada.', 'default', array('class' => 'alert alert-warning'));
            $this->redirect( array( 'action' => 'index' ));
		}
	    /* FIN */
        //Al realizar SUBMIT
        if (!empty($this->data)) {
            //Iniciamos proceso de inscripcion
            $this->Inscripcion->create();
            //Se genera el id del usuario
            $this->request->data['Inscripcion']['usuario_id'] = $this->Auth->user('id');
            //La fecha de alta se toma del servidor php al momento de ejecutar el controlador
            $this->request->data['Inscripcion']['fecha_alta'] = date('Y-m-d');
            $userCentroId = $this->getUserCentroId();
            //Se obtiene el rol del usuario
            $userRole = $this->Auth->user('role');
            switch($userRole) {
                case 'superadmin':
                case 'usuario':
                    // Usa el centro especificado en el formulario
                    $userCentroId = $this->request->data['Inscripcion']['centro_id'];
                break;
                case 'admin':
                    // Usa el centro definido para el usuario
                    $userCentroId = $this->getUserCentroId();
                    $this->request->data['Inscripcion']['centro_id'] = $userCentroId ;
                break;
            }
            // Luego de seleccionar el ciclo, se deja en los datos que se intentarán guardar.
            $cicloId = $this->request->data['Inscripcion']['ciclo_id'];
            $this->Inscripcion->Ciclo->recursive = 0;
            $ciclos = $this->Inscripcion->Ciclo->findById($cicloId, 'nombre');
            $ciclo = substr($ciclos['Ciclo']['nombre'], -2);

            // Obtiene la división del curso...
            $this->loadModel('Curso');
            $cursoIdArray = $this->request->data['Curso'];
            $cursoIdString = $cursoIdArray['Curso'];
            $divisionArray = $this->Curso->findById($cursoIdString, 'division');
            $divisionString = $divisionArray['Curso']['division'];

            // No hay que continuar con la inscripcion si no se definio el centro_id, y el curso!
            if (count($divisionArray)<=0) {
                $this->Session->setFlash('No definio la sección.', 'default', array('class' => 'alert alert-danger'));
                $this->redirect($this->referer());
            }

            /*
             *  VERIFICACION DE PERSONA
             */
            //Antes que nada obtengo personaId
            $personaId = $this->request->data['Persona']['persona_id'];
            if (empty($personaId)) {
                //No esta definida? terminamos volvemos al formulario anterior
                $this->Session->setFlash('No se definio la persona.', 'default', array('class' => 'alert alert-danger'));
                $this->redirect($this->referer());
            }
            //Obtenemos algunos datos de esa personaId
            $this->loadModel('Persona');
            $this->Persona->recursive = 0;
            $persona = $this->Persona->findById($personaId,'id, documento_nro');
            $personaDni = $persona['Persona']['documento_nro'];
            //Genera el nro de legajo y se deja en los datos que se intentaran guardar
            $codigoActual = $this->__getCodigo($ciclo, $personaDni);
            //Comprueba que ese legajo no exista directamente a la base de datos
            $personaInscripta = $this->Inscripcion->find('list', array(
                'fields'=>array('legajo_nro'),
                'conditions'=>array('legajo_nro'=>$codigoActual)
            ));
            /*
             *  FIN VERIFICACION DE PERSONA
             */
            if (count($personaInscripta)) {
                $this->Session->setFlash('El alumno ya está inscripto en este ciclo.', 'default', array('class' => 'alert alert-danger'));
            } else {
                $this->request->data['Inscripcion']['legajo_nro'] = $codigoActual;
                //Antes de guardar genera el estado de la inscripción
                if(($this->request->data['Inscripcion']['fotocopia_dni'] == true) && ($this->request->data['Inscripcion']['certificado_septimo'] == true) && ($this->request->data['Inscripcion']['analitico'] == true) && ($this->request->data['Inscripcion']['partida_nacimiento_alumno'] == true) && ($this->request->data['Inscripcion']['partida_nacimiento_tutor'] == true) && ($this->request->data['Inscripcion']['libreta_sanitaria'] == true)) {
                    $estadoDocumentacion = "COMPLETA";
                } else {
                    $estadoDocumentacion = "PENDIENTE";
                }
                //Genera el estado y se deja en los datos que se intentaran guardar
                $this->request->data['Inscripcion']['estado_documentacion'] = $estadoDocumentacion;
                /*
                 *  VERIFICACION DE ALUMNO
                 */
                //Antes de guardar hay que ver si la persona se encuentra inscripta como alumno
                $this->loadModel('Alumno');
                $this->Alumno->recursive = 0;
                $alumno = $this->Alumno->findByPersonaId($personaId);
                if (count($alumno) == 0) {
                    // Si no existe el alumno, hay que crearlo
                    $this->Alumno->create();
                    $insert = array(
                        'Alumno' => array(
                            'created' => '2017-09-08 12:01',
                            'persona_id' => $personaId,
                            'centro_id' => $userCentroId
                        ));
                    $alumno = $this->Alumno->save($insert);
                    if (!$alumno['Alumno']['id']) {
                        print_r("Error al registrar a la persona como alumno");
                        die;
                    }
                }

                switch($this->request->data['Inscripcion']['tipo_inscripcion'])
                {
                    case 'Hermano de alumno regular':

                        $hermano  = $this->Alumno->findById($this->request->data['Inscripcion']['hermano_id']);

                        if (count($hermano) == 0) {
                            $this->Session->setFlash('No se localizo al hermano como alumno.', 'default', array('class' => 'alert alert-danger'));
                            $this->redirect($this->referer());
                        }
                    break;
                    case 'Pase':

                        $this->loadModel('Centro');
                        $this->Centro->recursive = 0;
                        $centroOrigen = $this->Centro->findById($this->request->data['Inscripcion']['centro_origen_id']);

                        // Aca puede ir la logica de que nivel de servicio es necesario para guardar la inscripcion por pase
                        if (count($centroOrigen) == 0) {
                            $this->Session->setFlash('No se localizo el centro origen para el pase', 'default', array('class' => 'alert alert-danger'));
                            $this->redirect($this->referer());
                        }
                    break;
                }

                $this->request->data['Inscripcion']['alumno_id'] = $alumno['Alumno']['id'];
                /*
                 *  FIN VERIFICACION DE ALUMNO
                 */
                if ($this->Inscripcion->save($this->data)) {
                    /* ATUALIZA MATRÍCULA Y VACANTES (INICIO).
                    *  Al registrarse una Inscripción sí es para el ciclo actual o para un agrupamiento 
                    *  para el próximo ciclo, actualiza valores de matrícula y vacantes del curso correspondiente.
                    */
                    // Obtiene el ciclo id...
                    $this->loadModel('Ciclo');
                    $cicloIdActual = $this->getActualCicloId();
                    $cicloIdActualArray = $this->Ciclo->findById($cicloIdActual, 'id');
                    $cicloIdActualString = $cicloIdActualArray['Ciclo']['id'];

                    /*
                     * __ LINEAS PARA DEBUG __
                    echo '<pre>';
                    print_r($cicloId); // Siclo 2018
                    print_r($cicloIdActualString); // Siclo 2017
                    print_r($divisionString); // Celeste

                    // Si 2018 == 2017 o Celeste = ''
                    print_r(($cicloId == $cicloIdActualString) || ($divisionString == ''));
                    echo '</pre>';
                    */

                    // Como las inscripciones son para el 2018, y el ciclo actual es 2017, no ingresa en la siguiente logica
                    if (($cicloId == $cicloIdActualString) || ($divisionString == '')) {
                        //$this->loadModel('Curso');
                        //$cursoIdArray = $this->request->data['Curso'];
                        //$cursoIdString = $cursoIdArray['Curso'];
                        $matriculaActual = $this->Inscripcion->CursosInscripcion->find('count', array('fields'=>array('curso_id'), 'conditions'=>array('CursosInscripcion.curso_id'=>$cursoIdString)));
                        $this->Curso->id=$cursoIdString;
                        $this->Curso->saveField("matricula", $matriculaActual);
                        $plazasArray = $this->Curso->findById($cursoIdString, 'plazas');
                        $plazasString = $plazasArray['Curso']['plazas'];
                        $vacantesActual = $plazasString - $matriculaActual;
                        $this->Curso->saveField("vacantes", $vacantesActual);

                        /*
                         * __ LINEAS PARA DEBUG __
                        echo '<pre>';
                        print_r($matriculaActual);
                        print_r($plazasArray);
                        print_r($this->request->data);
                        echo '</pre>';
                        echo '<br> END MATRICULAS <br>';
                        die;
                        */
                    }
                    /* FIN */
                    $inserted_id = $this->Inscripcion->id;

                    /*
                     * __ LINEAS PARA DEBUG __
                    echo '<pre>';
                    print_r($inserted_id);
                    print_r($this->request->data);
                    echo '</pre>';
                    die;
                    */

                    $this->Session->setFlash('La inscripcion ha sido grabada.', 'default', array('class' => 'alert alert-success'));
                    $this->redirect(array('action' => 'view', $inserted_id));
                } else {
                    $this->Session->setFlash('La inscripcion no fue grabada. Intente nuevamente.', 'default', array('class' => 'alert alert-danger'));
                }
            }
        }
    }

	public function edit($id = null) {
        if (!$id && empty($this->data)) {
			$this->Session->setFlash('Inscripcion no valida.', 'default', array('class' => 'alert alert-warning'));
			$this->redirect(array('action' => 'index'));
		}

        $this->loadModel('CursosInscripcion');
        $cursoInscripcion  = $this->CursosInscripcion->find('first',[
            'recursive' => 0,
            'contains' => 'Curso',
            'conditions' => ['Inscripcion.id'=> $id]
        ]);

        $this->loadModel('Alumno');
        $alumno = $this->Alumno->find('first',[
            'recursive' => 0,
            'contains' => 'Personas',
            'conditions' => ['Alumno.id'=> $cursoInscripcion['Inscripcion']['alumno_id']]
        ]);
        // En este punto tengo al alumno y a la persona relacionadas al id de inscripcion.
        $alumnoId = $alumno['Alumno']['id'];
        $personaId  = $alumno['Persona']['id'];

        // Submit de formulario
    	if (!empty($this->data)) {
            //abort if cancel button was pressed
            if(isset($this->params['data']['cancel'])){
                $this->Session->setFlash('Los cambios no fueron guardados. Edición cancelada.', 'default', array('class' => 'alert alert-warning'));
                $this->redirect( array( 'action' => 'index' ));
		    }
            //Antes de guardar genera el estado de la inscripción
            if(($this->request->data['Inscripcion']['fotocopia_dni'] == true) && ($this->request->data['Inscripcion']['certificado_septimo'] == true) && ($this->request->data['Inscripcion']['analitico'] == true) && ($this->request->data['Inscripcion']['partida_nacimiento_alumno'] == true) && ($this->request->data['Inscripcion']['partida_nacimiento_tutor'] == true) && ($this->request->data['Inscripcion']['libreta_sanitaria'] == true)) {
                $estadoDocumentacion = "COMPLETA";
            } else {
                $estadoDocumentacion = "PENDIENTE";
            }
            //Se genera el estado y se deja en los datos que se intentaran guardar
			$this->request->data['Inscripcion']['estado_documentacion'] = $estadoDocumentacion;
			// Se define el id del centro.
            //$userCentroId = $this->getUserCentroId();
            //Se obtiene el rol del usuario
            $userRole = $this->Auth->user('role');
            // Se define el id del centro en función del rol.
            switch($userRole) {
                case 'superadmin':
                case 'usuario':
                    // Usa el centro especificado en el formulario
                    $userCentroId = $this->request->data['Inscripcion']['centro_id'];
                break;
                case 'admin':
                    // Usa el centro definido para el usuario
                    $userCentroId = $this->getUserCentroId();
                    $this->request->data['Inscripcion']['centro_id'] = $userCentroId ;
                break;
            }
            // Obtiene la división del curso "Seleccionado"
            $cursoIdArray = $this->request->data['Curso'];
            $cursoIdString = $cursoIdArray['Curso'];
            $this->loadModel('Curso');
            $this->Curso->recursive = -1;
            $nuevoCurso = $this->Curso->findById($cursoIdString);
            // Es necesario tener una seccion definida para la edicion
            if (count($nuevoCurso) <= 0 || !is_numeric($nuevoCurso['Curso']['id'])) {
                $this->Session->setFlash('No definio la sección.', 'default', array('class' => 'alert alert-danger'));
                $this->redirect($this->referer());
            }
            /* METODOLOGÍAS DE PASE SEGÚN PERFILES DE USUARIOS*/
            /* Sí es admin, primero debe generar desde su institución (centro origen) y con el módulo PASE, la propuesta de pase.
            *  Luego la institución destino, podrá acceder a la inscripción del alumno y actualizando el centro y la sección.
            */
            if ($userRole == 'admin') {
            /* Se trata de un pase externo, sí se identifica un cambio en el id del centro.
            *  Actualiza el id del centro del Alumno.
            *  Actualiza valores de matrícula y vacantes.
            *  Actualiza a confirmado el estado del pase.
            */
            if ($cursoInscripcion['Inscripcion']['centro_id'] != $userCentroId) {
                /* Actualiza el id del centro del Alumno. */
                $this->loadModel('Alumno');
                $alumnoIdArray = $this->Alumno->findByPersonaId($personaId);
                $alumnoIdString = $alumnoIdArray['Alumno'];
                $this->Alumno->id=$alumnoIdString;
                $this->Alumno->saveField("centro_id", $userCentroId);
                /* Modifica a "CONFIRMADO" el estado del pase. */
                $alumnoIdArray = $this->Inscripcion->findById($id, 'alumno_id');
                $alumnoIdString = $alumnoIdArray['Inscripcion']['alumno_id'];
                $this->loadModel('Pase');
                $this->Pase->alumno_id=$alumnoIdString;
                $this->Pase->saveField("estado_pase", 'CONFIRMADO');
                /* ATUALIZA MATRÍCULA Y VACANTES (INICIO). */
                $this->loadModel('Curso');
                $cursoIdArray = $this->request->data['Curso'];
                $cursoIdString = $cursoIdArray['Curso'];
                $matriculaActual = $this->Inscripcion->CursosInscripcion->find('count', array('fields'=>array('curso_id'), 'conditions'=>array('CursosInscripcion.curso_id'=>$cursoIdString)));
                $this->Curso->id=$cursoIdString;
                $this->Curso->saveField("matricula", $matriculaActual);
                $plazasArray = $this->Curso->findById($cursoIdString, 'plazas');
                $plazasString = $plazasArray['Curso']['plazas'];
                $vacantesActual = $plazasString - $matriculaActual;
                $this->Curso->saveField("vacantes", $vacantesActual);
                /* FIN */
                }
            } else {
                /* Síno sí es superadmin o usuario , generara el pase directamente con la edición de la Inscripción */
                if ($userRole == 'superadmin' || $userRole == 'usuario') {
                    if ($cursoInscripcion['Inscripcion']['centro_id'] != $userCentroId) {
                        /* Actualiza el id del centro del Alumno. */
                        $this->loadModel('Alumno');
                        $alumnoIdArray = $this->Alumno->findByPersonaId($personaId);
                        $alumnoIdString = $alumnoIdArray['Alumno'];
                        $this->Alumno->id=$alumnoIdString;
                        $this->Alumno->saveField("centro_id", $userCentroId);
                        /* ATUALIZA MATRÍCULA Y VACANTES (INICIO). */
                        $this->loadModel('Curso');
                        $cursoIdArray = $this->request->data['Curso'];
                        $cursoIdString = $cursoIdArray['Curso'];
                        $matriculaActual = $this->Inscripcion->CursosInscripcion->find('count', array('fields'=>array('curso_id'), 'conditions'=>array('CursosInscripcion.curso_id'=>$cursoIdString)));
                        $this->Curso->id=$cursoIdString;
                        $this->Curso->saveField("matricula", $matriculaActual);
                        $plazasArray = $this->Curso->findById($cursoIdString, 'plazas');
                        $plazasString = $plazasArray['Curso']['plazas'];
                        $vacantesActual = $plazasString - $matriculaActual;
                        $this->Curso->saveField("vacantes", $vacantesActual);
                        /* FIN */
                    }
                }
            }    
            /* Sino sí cambia de sección, se trata de un pase interno.
            *  Actualiza valores de matrícula y vacantes del curso origen.
            *  Actualiza valores de matrícula y vacantes del curso destino.
            */
            $cursoIdAnterior = $cursoInscripcion['Curso']['id'];
            $cursoIdNew = $nuevoCurso['Curso']['id'];
            // Sí los id de los cursos son diferentes, se trata de un cambio de sección.
            if ($cursoIdNew != $cursoIdAnterior) {
                // Actualiza los valores de matrícula y vacantes tanto de la sección origen como de la sección destino.
                // Comienza por el curso anterior...
                $matricula = $this->Inscripcion->CursosInscripcion->find('count', array('fields' => array('curso_id'), 'conditions' => array('CursosInscripcion.curso_id' => $cursoIdAnterior)));
                $matriculaActual = $matricula - 1;

                $this->Curso->id = $cursoIdAnterior;
                $this->Curso->saveField("matricula", $matriculaActual);

                $plazasArray = $this->Curso->findById($cursoIdAnterior, 'plazas');
                $plazasString = $plazasArray['Curso']['plazas'];
                $vacantesActual = $plazasString - $matriculaActual;

                $this->Curso->saveField("vacantes", $vacantesActual);

               // Continúa por el curso actual...    
               $matricula = $this->Inscripcion->CursosInscripcion->find('count', array('fields'=>array('curso_id'), 'conditions'=>array('CursosInscripcion.curso_id'=>$cursoIdNew)));
               $matriculaActual = $matricula + 1;

                $this->Curso->id=$cursoIdNew;
                $this->Curso->saveField("matricula", $matriculaActual);

               $plazasArray = $this->Curso->findById($cursoIdNew, 'plazas');
               $plazasString = $plazasArray['Curso']['plazas'];
               $vacantesActual = $plazasString - $matriculaActual;

                $this->Curso->saveField("vacantes", $vacantesActual);
            }

            // Quito estos campos de la modificacion, este dato no se modifica
            unset($this->request->data['Inscripcion']['alumno_id']);
            unset($this->request->data['Inscripcion']['ciclo_id']);

            $this->request->data['Inscripcion']['legajo_nro'] = $cursoInscripcion['Inscripcion']['legajo_nro'];
//            $this->request->data['Inscripcion']['estado_inscripcion'] = $cursoInscripcion['Inscripcion']['estado_inscripcion'];
//            $this->request->data['Inscripcion']['alumno_id'] = $cursoInscripcion['Inscripcion']['alumno_id'];

            $this->request->data['Inscripcion']['id'] = $id;
            $this->request->data['Inscripcion']['usuario_id'] = $this->Auth->user('id');
            $this->Inscripcion->set($this->request->data);

            // ACA INTENTA HACER UN INSERT., CUANDO DEBERIA HACER UN UPDATE
            if ($this->Inscripcion->save()) {
                $this->Session->setFlash('La inscripcion ha sido grabada.', 'default', array('class' => 'alert alert-success'));
				$inserted_id = $this->Inscripcion->id;
				$this->redirect(array('action' => 'view', $inserted_id));
			} else {
                //debug( $this->Inscripcion->invalidFields() );
                //die;

				$this->Session->setFlash('La inscripcion no fue grabada. Intente nuevamente.', 'default', array('class' => 'alert alert-danger'));
			}
		}
        // End submit de formulario

        $this->set(compact('cursoInscripcion','alumno', 'personaId'));
    }

    public function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash('Id no valida para inscripcion.', 'default', array('class' => 'alert alert-warning'));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Inscripcion->delete($id)) {
			$this->Session->setFlash('La Inscripcion ha sido borrada.', 'default', array('class' => 'alert alert-success'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash('La Inscripcion no fue borrada. Intentelo nuevamente.', 'default', array('class' => 'alert alert-danger'));
		$this->redirect(array('action' => 'index'));
	}

	//Métodos privados
	private function __lists(){
	    $this->loadModel('User');
        // Carga en el combobox el Ciclo actual y uno posterior sí lo hubiera.        
        $this->loadModel('Ciclo');
        $cicloIdActual = $this->getActualCicloId();
        $cicloIdActualArray = $this->Ciclo->findById($cicloIdActual, 'id');
        $cicloIdActualString = $cicloIdActualArray['Ciclo']['id'];
        $cicloIdUltimo = $this->getLastCicloId();
        $cicloIdUltimoArray = $this->Ciclo->findById($cicloIdUltimo, 'id');
        $cicloIdUltimoString = $cicloIdUltimoArray['Ciclo']['id'];
        $ciclos = $this->getTwoLastCicloNombres($cicloIdActualString, $cicloIdUltimoString);
        $centros = $this->Inscripcion->Centro->find('list');
		/* Sí es "superadmin" ve combobox con todos los cursos, 
        *  Sino sí es usuario de Inicial y Primaria, ve los propios de ambos niveles,
        *  Sino sí es usuario de otro nivel ve los correspondiente.
        */
		$userCentroId = $this->getUserCentroId();
        $nivelCentro = $this->Inscripcion->Centro->find('list', array('fields'=>array('nivel_servicio'), 'conditions'=>array('id'=>$userCentroId)));
        $userRol = $this->Auth->user('role');
		if ($userRol == 'superadmin') {
			$cursos = $this->Inscripcion->Curso->find('list', array('fields'=>array('id','nombre_completo_curso')));
		} else if (($userRol === 'usuario') && ($nivelCentro === 'Común - Inicial - Primario')) {
            $nivelCentroId = $this->Inscripcion->Centro->find('list', array('fields'=>array('id'), 'conditions'=>array('nivel_servicio'=>array('Común - Inicial', 'Común - Primario'))));
            $cursos = $this->Inscripcion->Curso->find('list', array('fields'=>array('id','nombre_completo_curso'), 'conditions'=>array('centro_id'=>$nivelCentroId, 'status'=> '1')));
        } else if ($userRol === 'usuario') {
            $nivelCentroId = $this->Inscripcion->Centro->find('list', array('fields'=>array('id'), 'conditions'=>array('nivel_servicio'=>$nivelCentro)));
            $cursos = $this->Inscripcion->Curso->find('list', array('fields'=>array('nombre_completo_curso'), 'conditions'=>array('centro_id'=>$nivelCentroId, 'status' => '1')));
        } else if ($userRol == 'admin') {
			$userCentroId = $this->getUserCentroId();
			$cursos = $this->Inscripcion->Curso->find('list', array('fields'=>array('id','nombre_completo_curso'), 'conditions'=>array('centro_id'=>$userCentroId, 'status' => '1')));
		}
		//$materias = $this->Inscripcion->Materia->find('list');
    	/* Sí es "superadmin" o "usuario" ve combobox con todos los alumnos.
    	*  Sino ve los propios del centro. (INICIO) */
		$userCentroId = $this->getUserCentroId();
		$userRole = $this->Auth->user('role');
		if ($this->Auth->user('role') === 'admin') {
			$this->loadModel('Alumno');
			$personaId = $this->Alumno->find('list', array('fields'=>array('persona_id'), 'conditions'=>array('centro_id'=>$userCentroId)));
		    //$this->loadModel('Persona');
			//$personaNombre = $this->Persona->find('list', array('fields'=>array('nombre_completo_persona'), 'conditions'=>array('id'=>$personaId)));
		} else if ($userRole === 'usuario') {
            $this->loadModel('Centro');
            $nivelCentro = $this->Centro->find('list', array('fields'=>array('nivel_servicio'), 'conditions'=>array('id'=>$userCentroId)));
            $nivelCentroId = $this->Centro->find('list', array('fields'=>array('id'), 'conditions'=>array('nivel_servicio'=>$nivelCentro)));
            $personaId = $this->Inscripcion->find('list', array('fields'=>array('alumno_id'), 'conditions'=>array('centro_id'=>$nivelCentroId)));
            //$this->loadModel('Persona');
            //$personaNombre = $this->Persona->find('list', array('fields'=>array('nombre_completo_persona'), 'conditions'=>array('id'=>$personaId)));
        } else {
			//Sí es superadmin
			$this->loadModel('Alumno');
			$personaId = $this->Alumno->find('list', array('fields'=>array('persona_id')));
		    //$this->loadModel('Persona');
			//$personaNombre = $this->Persona->find('list', array('fields'=>array('nombre_completo_persona'), 'conditions'=>array('id'=>$personaId)));
		}
		/* FIN */
		$this->set(compact( 'ciclos', 'centros', 'cursos', 'materias', 'empleados', 'cicloIdActual','cicloIdUltimo'));
	}

	private function __getCodigo($ciclo, $personaDocString){
		$legajo = $personaDocString."-".$ciclo;
		return $legajo;
    }

    public function constanciaPdf($id)
    {
        try {
            $httpSocket = new HttpSocket();
            $response = $httpSocket->get("http://web:3000/api/constancia/$id");
            $response = $response->body;

            $api = json_decode($response);
            if( isset($api->error)) {
                $this->Session->setFlash($api->error, 'default', array('class' => 'alert alert-warning'));
                $this->redirect(array('action' => 'index'));
            } else {
                header("content-type: application/pdf");
                echo $response;
            }
        } catch(\Exception $ex){
            $this->Session->setFlash($ex->getMessage(), 'default', array('class' => 'alert alert-warning'));
            $this->redirect(array('action' => 'index'));
        }
    }
}
?>
