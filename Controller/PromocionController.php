<?php
App::uses('AppController', 'Controller');

class PromocionController extends AppController {

	public $paginate = array('CursosInscripcion' => array('limit' => 2, 'order' => 'CursosInscripcion.curso_id ASC'));

    public function beforeFilter() {
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
                    $this->Auth->allow('index','confirmarAlumnos');    
                }
                break;
			case 'usuario':
			case 'admin':
				$this->Auth->allow('index','confirmarAlumnos');
				break;
		}
	    /* FIN */
		App::uses('HttpSocket', 'Network/Http');
    } 

/**
 * index method
 *
 * @return void
 */
	public function index()
	{
		// Datos del usuario
		$userCentroId = $this->getUserCentroId();
		$userRole = $this->Auth->user('role');

		// Modelos a utilizar
		$this->loadModel('CursosInscripcion');
		$this->loadModel('Centro');
		$this->loadModel('Curso');

		$this->loadModel('Ciclo');

		$hoyArray = getdate();
		$hoyAñoString = $hoyArray['year']; // Si se resta un año... se relizan las promociones en Marzo, con los alumnos del año anterior.
		$cicloaPromocionar = $this->Ciclo->find('first', array(
			'recursive' => -1,
			'conditions' => array('nombre' => $hoyAñoString)
		));

		$cicloaPromocionar = array_pop($cicloaPromocionar);
		$cicloSiguienteNombre = ((int)$cicloaPromocionar['nombre']) + 1;

		// Habria que ver como cake gestiona estos joins de manera nativa en el ORM
		$this->paginate['CursosInscripcion'] = array(
			'fields' => array(
				'CursosInscripcion.*',
				'Inscripcion.*',
				'Curso.*',
				'Centro.*',
				'Persona.*',
				'Ciclo.nombre'
			),
			'limit' => 50,
			'order' => array('Alumno.apellido' => 'ASC'),
			'joins' => array(
				array(
					'alias' => 'Alumno',
					'table' => 'alumnos',
					'type' => 'LEFT',
					'conditions' => '`Alumno`.`id` = `Inscripcion`.`alumno_id`'
				),
				array(
					'alias' => 'Persona',
					'table' => 'personas',
					'type' => 'LEFT',
					'conditions' => '`Persona`.`id` = `Alumno`.`persona_id`'
				),
				array(
					'alias' => 'Ciclo',
					'table' => 'ciclos',
					'type' => 'LEFT',
					'conditions' => '`Ciclo`.`id` = `Inscripcion`.`ciclo_id`'
				),
				array(
					'alias' => 'Centro',
					'table' => 'centros',
					'type' => 'LEFT',
					'conditions' => '`Centro`.`id` = `Inscripcion`.`centro_id`'
				)
			)
		);
		/* PAGINACIÓN SEGÚN ROLES DE USUARIOS (INICIO).
		*Sí el usuario es "admin" muestra los cursos del establecimiento. Sino sí es "usuario" externo muestra los cursos del nivel.
		*/

		// Se busca el nivel del servicio segun el centro_id del usuario
		$nivelCentroServicio = $this->Centro->find('first', array(
				'recursive' => -1,
				'fields'=>array('Centro.nivel_servicio'),
				'conditions'=>array('Centro.id'=>$userCentroId))
		);

		$nivelServicio = $nivelCentroServicio['Centro']['nivel_servicio'];
		switch($userRole)
		{
			case 'admin':
				$this->paginate['CursosInscripcion']['conditions'] = array(
					'Inscripcion.centro_id' => $userCentroId,
					'Inscripcion.estado_inscripcion' =>array('CONFIRMADA','NO CONFIRMADA')
				);
			break;
			case 'usuario':
				if($nivelServicio === 'Común - Inicial - Primario')
				{
					$nivelCentroId = $this->Centro->find('list', array(
						'fields'=>array('id'),
						'conditions'=>array(
							'nivel_servicio'=>array('Común - Inicial', 'Común - Primario', 'Común - Inicial - Primario')
						)
					));

					$this->paginate['CursosInscripcion']['conditions'] = array(
						'Inscripcion.centro_id' => $nivelCentroId,
						'Inscripcion.estado_inscripcion' =>array('CONFIRMADA','NO CONFIRMADA')
					);
				} else
				{
					$nivelCentroId = $this->Centro->find('list', array(
						'fields'=>array('id'),
						'conditions'=>array('nivel_servicio'=>$nivelServicio))
					);
					$this->paginate['CursosInscripcion']['conditions'] = array(
						'Inscripcion.centro_id' => $nivelCentroId,
						'Inscripcion.estado_inscripcion' =>array('CONFIRMADA','NO CONFIRMADA')
					);
				}
				break;
		}
		/* FIN */

		/* PAGINACIÓN SEGÚN CRITERIOS DE BÚSQUEDAS (INICIO).
        *Pagina según búsquedas simultáneas ya sea por CENTRO y/o CURSO y/o INSCRIPCIÓN.
        */
		$this->redirectToNamed();
		$conditions = array();
		$conditions['Inscripcion.ciclo_id ='] = $cicloaPromocionar['id'];

		if(!empty($this->params['named']['centro_id'])) {
			$conditions['Inscripcion.centro_id ='] = $this->params['named']['centro_id'];
		}
		if(!empty($this->params['named']['curso_id'])) {
			$conditions['CursosInscripcion.curso_id ='] = $this->params['named']['curso_id'];
		}

		// Inicializa la paginacion segun las condiciones
		$cursosInscripcions = $this->paginate('CursosInscripcion', $conditions);

		$centro = $this->Centro->find('first', array(
				'recursive' => -1,
				'conditions'=>array('Centro.id'=>$this->params['named']['centro_id']))
		);

		$curso = $this->Curso->find('first', array(
				'recursive' => -1,
				'conditions'=>array('Curso.id'=>$this->params['named']['curso_id']))
		);

		$centro = array_pop($centro);
		$curso = array_pop($curso);
		//Sí el usuario es del nivel Secundario, visualiza en las opciones las secciones ficticias. 
		if($nivelServicio == 'Común - Secundario') {
			$secciones = $this->Curso->find('list', array(
			'recursive'=>-1,
			'fields'=>array('id','nombre_completo_curso'),
			'conditions'=>array(
				'centro_id'=>$this->params['named']['centro_id']))
			);	
		} else {
			$secciones = $this->Curso->find('list', array(
			'recursive'=>-1,
			'fields'=>array('id','nombre_completo_curso'),
			'conditions'=>array(
				'centro_id'=>$this->params['named']['centro_id'],
				'division !='=> ''))
			);
		}	
		$this->set(compact('cicloaPromocionar','centro','curso','cursosInscripcions','cicloaPromocionar','cicloSiguienteNombre','secciones'));
	}

	public function confirmarAlumnos()
	{
		try {
			$userId = $this->Auth->user('id');

			$httpSocket = new HttpSocket();
			$request = array('header' => array('Content-Type' => 'application/json'));
			$this->request->data['user_id'] = $userId;
			$data = $this->request->data;
			$data = json_encode($data);

			$hostApi = getenv('HOSTAPI');

			//$response = $httpSocket->post("https://constancia.sieptdf.tk/api/promocion", $data, $request);
			$response = $httpSocket->post("http://$hostApi/api/promocion", $data, $request);

			$response = $response->body;
			$apiResponse = json_decode($response,true);

			if( isset($apiResponse['error'])) {
				// El api puede devolver mas de 1 error, hay que mostrarlos a todos
				$err = $apiResponse['error'];
				if(is_array($err)) {
					$msgError = "";
					foreach ($err as $errParam) {
						$msgError .= $errParam[0]."<br>";
					}
				} else {
					$msgError = $err;
				}
				$this->Session->setFlash("API($hostApi) Error: ".$msgError, 'default', array('class' => 'alert alert-danger'));
				$this->redirect($this->referer());
			} else {
				if( isset($apiResponse['done'])) {
					$this->Session->setFlash("Promocion realizada con exito", 'default', array('class' => 'alert alert-success'));
					$this->redirect($this->referer());
				} else {
					$this->Session->setFlash("API($hostApi) !done: No se determinó si la operación se efectuo con exito", 'default', array('class' => 'alert alert-warning'));
					$this->redirect($this->referer());
				}
			}
		} catch(\Exception $ex){
			$this->Session->setFlash("API($hostApi) TryError: ".$ex->getMessage(), 'default', array('class' => 'alert alert-danger'));
			$this->redirect($this->referer());
		}
	}
}