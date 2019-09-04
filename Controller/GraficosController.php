<?php
App::uses('AppController', 'Controller');

class GraficosController extends AppController {
	var $name = 'Graficos';

    public $helpers = array('Session', 'Siep');
	public $components = array('Auth','Session', 'RequestHandler');
	
	function beforeFilter(){
		parent::beforeFilter();
		// Importa el Helper de Siep al controlador es accesible mediante $this->Siep
		App::import('Helper', 'Siep');
		$this->Siep= new SiepHelper(new View());
		/* ACCESOS SEGÚN ROLES DE USUARIOS (INICIO).
        *Si el usuario tiene un rol de superadmin le damos acceso a todo. Si no es así (se trata de un usuario "admin o usuario") tendrá acceso sólo a las acciones que les correspondan.
        */
        switch($this->Auth->user('role'))
		{
			case 'admin':
				$this->Auth->allow('index');
				break;
			
			default:
				$this->Session->setFlash('No tiene permisos para ver TABLERO 2019.', 'default', array('class' => 'alert alert-warning'));
				$this->redirect($this->referer());
				break;
		}
		/* FIN */
		App::uses('HttpSocket', 'Network/Http');
	}

	public function index() {
		// Obtención del ciclo actual, anterior y posterior.
		$this->loadModel('Ciclo');
		$this->Ciclo->recursive = 0;
		$this->Ciclo->Behaviors->load('Containable');
		$cicloIdActual = $this->getActualCicloId();
		$cicloIdActualArray = $this->Ciclo->findById($cicloIdActual, 'id, nombre');
		$cicloIdActual = $cicloIdActualArray['Ciclo']['id'];
		$ciclosVecinos = $this->Ciclo->find('neighbors', ['field' => 'id', 'value' => $cicloIdActual]);
		$cicloIdAnterior = $ciclosVecinos ['prev']['Ciclo']['id'];
		$cicloIdPosterior = $ciclosVecinos ['next']['Ciclo']['id'];
		$cicloIdAnteriorNombre = $ciclosVecinos ['prev']['Ciclo']['nombre'];
		// Obtención del nombre y el nivel del centro del usuario.
		$userCentroId = $this->getUserCentroId();
		$this->loadModel('Centro');
		$this->Centro->recursive = 0;
		$this->Centro->Behaviors->load('Containable');
		$centroArray = $this->Centro->findById($userCentroId,'nombre, nivel_servicio');
		$centroNombre = $centroArray['Centro']['nombre'];
		$nivelCentro = $centroArray['Centro']['nivel_servicio'];
		/* INICIO DE CONTEOS GENERALES Y ESPECÍFICOS. */
		/* INICIO: CONTEO GENERAL DE LOS USUARIOS.*/
		$this->loadModel('User');
		/*
		$this->User->recursive = 0;
		$this->User->Behaviors->load('Containable');
		*/
		// Obtención y conteo de datos de ids de empleados de los usuarios activos relacionados al centro. 
		$empleadosId = $this->User->find('list', array(
			'fields' => 'empleado_id',
			'conditions' => array(
				'User.centro_id' => $userCentroId,
				'User.status' => 1)
			)
		);
		// Conteo de usuarios activos del centro.
		$usuarios = count($empleadosId); 
		// Obtención de los nombres completos de los empleados.
		$empleados = $this->User->Empleado->find('list', array(
			'fields' => 'nombre_completo_empleado',
			'conditions' => array('id' => $empleadosId)
		));
		/* FIN: CONTEO GENERAL DE LOS USUARIOS.*/
		/* INICIO: CONTEO GENERAL DE LAS TITULACIONES ACTIVAS DE SECUNDARIOS(Modalidades: Común y Adultos).*/
		if ($nivelCentro == 'Común - Secundario' || $nivelCentro == 'Adultos - Secundario') {
			$this->loadModel('Titulacion');
			$this->Titulacion->recursive = 0;
			$this->Titulacion->Behaviors->load('Containable');
			$titulacionesIdTodas = $this->Titulacion->CentrosTitulacion->find('list', array(
				'fields' => array('titulacion_id'),
				'conditions' => array(
					'CentrosTitulacion.centro_id' => $userCentroId
				)
			));			
			$titulacionesIdActivas = $this->Titulacion->find('count', array(
				'conditions' => array(
					'Titulacion.id' => $titulacionesIdTodas,
					'Titulacion.status' => 1
				)
			));
		}
		/* FIN: CONTEO GENERAL DE LAS TITULACIONES ACTIVAS DE SECUNDARIOS(Modalidades: Común y Adultos).*/
		/* INICIO: CONTEOS GENERAL Y ESPECÍFICO DE LAS SECCIONES REALES y ACTIVAS.*/
		// Conteo general.
		$this->loadModel('Curso');
		$this->Curso->recursive = 0;
		$this->Curso->Behaviors->load('Containable');
		$cursos = $this->Curso->find('count', array(
			'conditions' => array(
				'Curso.centro_id' => $userCentroId,
				'Curso.division !=' => ' ',
				'Curso.turno !=' => 'Otro',
				'Curso.status' => 1
			)
		));
		/* Conteo específico por año para usuarios con role "admin". 
		** Según el nivel_servicio, realiza el conteo de Salas (Inicial) o Grados (Primario) o Cursos (Secundario).
		*/
        switch ($nivelCentro) {
			case 'Común - Inicial':
				$cursosTresAnios = $this->Curso->find('count', array(
					'conditions' => array(
						'Curso.centro_id' => $userCentroId,
						'Curso.anio' => array('Sala de 3 años'),
						'Curso.division !=' => '',
						'Curso.turno !=' => 'Otro',
						'Curso.tipo' => 'Independiente',
						'Curso.status' => 1
					)
				));
				$cursosTresAniosMultiple = $this->Curso->find('count', array(
					'conditions' => array(
						'Curso.centro_id' => $userCentroId,
						'Curso.anio' => array('Sala de 3 años'),
						'Curso.division !=' => '',
						'Curso.turno !=' => 'Otro',
						'Curso.tipo' => 'Múltiple',
						'Curso.status' => 1
					)
				));
				$cursosCuatroAnios = $this->Curso->find('count', array(
					'conditions' => array(
						'Curso.centro_id' => $userCentroId,
						'Curso.anio' => array('Sala de 4 años'),
						'Curso.division !=' => '',
						'Curso.turno !=' => 'Otro',
						'Curso.tipo' => 'Independiente',
						'Curso.status' => 1
					)
				));
				$cursosCuatroAniosMultiple = $this->Curso->find('count', array(
					'conditions' => array(
						'Curso.centro_id' => $userCentroId,
						'Curso.anio' => array('Sala de 4 años'),
						'Curso.division !=' => '',
						'Curso.turno !=' => 'Otro',
						'Curso.tipo' => 'Múltiple',
						'Curso.status' => 1
					)
				));
				$cursosCincoAnios = $this->Curso->find('count', array(
					'conditions' => array(
						'Curso.centro_id' => $userCentroId,
						'Curso.anio' => array('Sala de 5 años'),
						'Curso.division !=' => '',
						'Curso.turno !=' => 'Otro',
						'Curso.tipo' => 'Independiente',
						'Curso.status' => 1
					)
				));
				break;
			case 'Común - Primario':
			case 'Común - Secundario':
			case 'Adultos - Primario':
			case 'Adultos - Secundario':
				// Todos los niveles-servicios cuentan 3 años.
				$cursosPrimerosAnios = $this->Curso->find('count', array(
					'conditions' => array(
						'Curso.centro_id' => $userCentroId,
						'Curso.anio' => array('1ro'),
						'Curso.division !=' => '',
						'Curso.turno !=' => 'Otro',
						//'Curso.tipo' => 'Independiente',
						'Curso.status' => 1
					)
				));
				$cursosSegundosAnios = $this->Curso->find('count', array(
					'conditions' => array(
						'Curso.centro_id' => $userCentroId,
						'Curso.anio' => array('2do'),
						'Curso.division !=' => '',
						'Curso.turno !=' => 'Otro',
						//'Curso.tipo' => 'Independiente',
						'Curso.status' => 1
					)
				));
				$cursosTercerosAnios = $this->Curso->find('count', array(
					'conditions' => array(
						'Curso.centro_id' => $userCentroId,
						'Curso.anio' => array('3ro'),
						'Curso.division !=' => '',
						'Curso.turno !=' => 'Otro',
						//'Curso.tipo' => 'Independiente',
						'Curso.status' => 1
					)
				));
				// Sólo Primario y Secundario cuenta 4tos a 6tos.
				if ($nivelCentro != 'Adulto - Primario' || $nivelCentro != 'Adulto - Secundario') {
					$cursosCuartosAnios = $this->Curso->find('count', array(
						'conditions' => array(
							'Curso.centro_id' => $userCentroId,
							'Curso.anio' => array('4to'),
							'Curso.division !=' => '',
							'Curso.turno !=' => 'Otro',
							//'Curso.tipo' => 'Independiente',
							'Curso.status' => 1
						)
					));
					$cursosQuintosAnios = $this->Curso->find('count', array(
						'conditions' => array(
							'Curso.centro_id' => $userCentroId,
							'Curso.anio' => array('5to'),
							'Curso.division !=' => '',
							'Curso.turno !=' => 'Otro',
							//'Curso.tipo' => 'Independiente',
							'Curso.status' => 1
						)
					));
					$cursosSextosAnios = $this->Curso->find('count', array(
						'conditions' => array(
							'Curso.centro_id' => $userCentroId,
							'Curso.anio' => array('6to'),
							'Curso.division !=' => '',
							'Curso.turno !=' => 'Otro',
							//'Curso.tipo' => 'Independiente',
							'Curso.status' => 1
						)
					));
				}
				// Sólo Secundarios cuentan 7mos.
				if ($nivelCentro == 'Común - Secundario') {
					$cursosSeptimosAnios = $this->Curso->find('count', array(
						'conditions' => array(
							'Curso.centro_id' => $userCentroId,
							'Curso.anio' => array('7mo'),
							'Curso.division !=' => '',
							'Curso.turno !=' => 'Otro',
							//'Curso.tipo' => 'Independiente',
							'Curso.status' => 1
						)
					));
				}
				// Sólo Adultos - Primario cuentan ALFABETIZACIÓN.
				if ($nivelCentro == 'Adultos - Primario') {
					$cursosAlfabetizacion = $this->Curso->find('count', array(
						'conditions' => array(
							'Curso.centro_id' => $userCentroId,
							'Curso.anio' => array('ALFABETIZACIÓN'),
							'Curso.division !=' => '',
							'Curso.turno !=' => 'Otro',
							'Curso.tipo' => 'Múltiple',
							'Curso.status' => 1
						)
					));
					$cursosCAP = $this->Curso->find('count', array(
						'conditions' => array(
							'Curso.centro_id' => $userCentroId,
							'Curso.anio' => array('CAP'),
							'Curso.division !=' => '',
							'Curso.turno !=' => 'Otro',
							//'Curso.tipo' => 'Idependiente',
							'Curso.status' => 1
						)
					));
				}				
				break;

			default:
				# code...
				break;
		}
		/* FIN: CONTEOS GENERAL Y ESPECÍFICO DE LAS SECCIONES REALES y ACTIVAS.*/
		/* INICIO: CONTEOS GENERAL Y ESPECÍFICO DE MATRÍCULA ALTAS.*/
		// Conteo general.
		$this->loadModel('Inscripcion');
		$this->Inscripcion->recursive = 0;
		$this->Inscripcion->Behaviors->load('Containable');
		$matricula = $this->Inscripcion->find('count', array(
			'conditions' => array(
				'Inscripcion.centro_id' => $userCentroId,
				'Inscripcion.estado_inscripcion' => 'CONFIRMADA',
				'Inscripcion.ciclo_id' => $cicloIdActual
			))
		);
		// Conteos específicos.
		// Conteo de inscripciones por hermanos.
		$inscripcionesPorHermano = $this->Inscripcion->find('count', array(
			'conditions' => array(
				'Inscripcion.centro_id' => $userCentroId,
				'Inscripcion.tipo_inscripcion' => 'Hermano de alumno regular',
				'Inscripcion.ciclo_id' => $cicloIdActual,
				'Inscripcion.estado_inscripcion' => 'CONFIRMADA',
			))
		);
		// Conteo de inscripciones comunes.
		$inscripcionesComunes = $this->Inscripcion->find('count', array(
			'conditions' => array(
				'Inscripcion.centro_id' => $userCentroId,
				'Inscripcion.tipo_inscripcion' => 'Común',
				'Inscripcion.ciclo_id' => $cicloIdActual,
				'Inscripcion.estado_inscripcion' => 'CONFIRMADA',
			))
		);
		// Conteo de inscripciones por situación social.
		$inscripcionesPorSituacionSocial = $this->Inscripcion->find('count', array(
			'conditions' => array(
				'Inscripcion.centro_id' => $userCentroId,
				'Inscripcion.tipo_inscripcion' => 'Situación Social',
				'Inscripcion.ciclo_id' => $cicloIdActual,
				'Inscripcion.estado_inscripcion' => 'CONFIRMADA',
			))
		);
		// Conteo de inscripciones por Pase (Entradas).
		$inscripcionesPorPase = $this->Inscripcion->find('count', array(
			'conditions' => array(
				'Inscripcion.centro_id' => $userCentroId,
				'Inscripcion.tipo_inscripcion' => 'Pase',
				'Inscripcion.ciclo_id' => $cicloIdActual,
				'Inscripcion.estado_inscripcion' => 'CONFIRMADA',
			))
		);
		/* FIN: CONTEO GENERAL Y ESPECÍFICOS DE MATRÍCULA ALTAS.*/
		/* INICIO: CONTEO GENERAL Y ESPECÍFICOS DE MATRÍCULA BAJAS.*/
		//Conteo general.
		$legajoTipo = 'SINVACANTE';
		$matriculaBaja = $this->Inscripcion->find('count', array(
			'conditions' => array(
				'Inscripcion.centro_id' => $userCentroId,
				'Inscripcion.estado_inscripcion' => 'BAJA',
				'Inscripcion.ciclo_id' => $cicloIdActual,
				'Inscripcion.legajo_nro NOT LIKE' => '%'.$legajoTipo.'%'
			))
		);
		// Conteos específicos.
		// Conteo de bajas por salidos con pase.
		$bajasSalidosConPase = $this->Inscripcion->find('count', array(
			'conditions' => array(
				'Inscripcion.centro_id' => $userCentroId,
				'Inscripcion.estado_inscripcion' => 'BAJA',
				'Inscripcion.ciclo_id' => $cicloIdActual,
				'Inscripcion.tipo_baja' => 'Salido con pase',
				'Inscripcion.legajo_nro NOT LIKE' => '%'.$legajoTipo.'%'
			))
		);
		// Conteo de bajas por salidos sin pase.
		$bajasSalidosSinPase = $this->Inscripcion->find('count', array(
			'conditions' => array(
				'Inscripcion.centro_id' => $userCentroId,
				'Inscripcion.estado_inscripcion' => 'BAJA',
				'Inscripcion.ciclo_id' => $cicloIdActual,
				'Inscripcion.tipo_baja' => 'Salido sin pase',
				'Inscripcion.legajo_nro NOT LIKE' => '%'.$legajoTipo.'%'
			))
		);
		// Conteo de bajas por pérdida de regularidad.
		$bajasPerdidaRegularidad = $this->Inscripcion->find('count', array(
			'conditions' => array(
				'Inscripcion.centro_id' => $userCentroId,
				'Inscripcion.estado_inscripcion' => 'BAJA',
				'Inscripcion.ciclo_id' => $cicloIdActual,
				'Inscripcion.tipo_baja' => 'Pérdida de regularidad',
				'Inscripcion.legajo_nro NOT LIKE' => '%'.$legajoTipo.'%'
			))
		);
		// Conteo de bajas por fallecimiento.
		$bajasFallecimiento = $this->Inscripcion->find('count', array(
			'conditions' => array(
				'Inscripcion.centro_id' => $userCentroId,
				'Inscripcion.estado_inscripcion' => 'BAJA',
				'Inscripcion.ciclo_id' => $cicloIdActual,
				'Inscripcion.tipo_baja' => 'Fallecimiento',
				'Inscripcion.legajo_nro NOT LIKE' => '%'.$legajoTipo.'%'
			))
		);
		// Conteo de bajas sin especificar tipo.
		$bajasSinEspecificar = $this->Inscripcion->find('count', array(
			'conditions' => array(
				'Inscripcion.centro_id' => $userCentroId,
				'Inscripcion.estado_inscripcion' => 'BAJA',
				'Inscripcion.ciclo_id' => $cicloIdActual,
				'Inscripcion.tipo_baja' => 'Sin especificar',
				'Inscripcion.legajo_nro NOT LIKE' => '%'.$legajoTipo.'%'
			))
		);
		/* FIN: CONTEOS GENERAL Y ESPECÍFICOS DE MATRÍCULA BAJAS.*/
		/* INICIO: CONTEO GENERAL DE EGRESOS.*/
		// Conteo general.
		$matriculaEgresos = $this->Inscripcion->find('count', array(
			'conditions' => array(
				'Inscripcion.centro_id' => $userCentroId,
				'Inscripcion.estado_inscripcion' => 'EGRESO',
				'Inscripcion.ciclo_id' => $cicloIdAnterior
			))
		);
		/* FIN: CONTEO GENERAL DE EGRESOS.*/
		/* INICIO: CONTEOS GENERAL Y ESPECÍFICOS DE PASES.*/
		// Conteo de pases: Entradas + Salidas
		$matriculaPases = $inscripcionesPorPase + $bajasSalidosConPase; //Falta implementar con API.
		/* FIN: CONTEOS GENERAL Y ESPECÍFICOS DE PASES.*/
		/* INICIO: CONTEO GENERAL Y ESPECÍFICOS DE PROMOCIONES.*/
		// Conteo general.		
		// Parametros de API por defecto
		$apiParamsTotal = [];
		$apiParamsTotal['ciclo'] = $cicloIdAnteriorNombre;
		$apiParamsTotal['promocion'] = 'con';
		$apiParamsTotal['centro_id'] = $userCentroId;
		$matriculaPromociones = $this->Siep->consumeApi("api/v1/matriculas/cuantitativa/por_seccion",$apiParamsTotal);
		if(isset($promociones['error'])) {
			// Manejar error de API
		}
		$matriculaPromocionesTotal = $matriculaPromociones['total'];
		$matriculaPromociones = $this->Inscripcion->find('count', array(
			'conditions' => array(
				'Inscripcion.centro_id' => $userCentroId,
				'Inscripcion.ciclo_id' => $cicloIdAnterior,
				'Inscripcion.promocion_id !=' => ''
			))
		);
		// Conteos específicos por año.
		//Salas de 3 años.
		// Parametros de API por defecto
		$apiParams = $this->parametrosApi('500', $cicloIdAnteriorNombre, 'CONFIRMADA', 'con', 'Sala de 3 años', '', $userCentroId);
		// Consumo de API		
		$promocionTresAniosArray = $this->Siep->consumeApi("api/v1/promocion",$apiParams);
		if(isset($promocionTresAniosArray['error'])) {
			// Manejar error de API
		}
		$promocionTresAnios = $promocionTresAniosArray['meta']['total'];
		//Salas de 4 años.
		// Parametros de API por defecto
		$apiParams = $this->parametrosApi('500', $cicloIdAnteriorNombre, 'CONFIRMADA', 'con', 'Sala de 4 años', '', $userCentroId);
		// Consumo de API		
		$promocionCuatroAniosArray = $this->Siep->consumeApi("api/v1/promocion",$apiParams);
		if(isset($promocionCuatroAniosArray['error'])) {
			// Manejar error de API
		}
		$promocionCuatroAnios = $promocionCuatroAniosArray['meta']['total'];
		//1eros año.
		// Parametros de API por defecto
		$apiParams = $this->parametrosApi('500', $cicloIdAnteriorNombre, 'CONFIRMADA', 'con', '1ro', '', $userCentroId);
		// Consumo de API		
		$promocionPrimerosAniosArray = $this->Siep->consumeApi("api/v1/promocion",$apiParams);
		if(isset($promocionPrimerosAniosArray['error'])) {
			// Manejar error de API
		}
		$promocionPrimerosAnios = $promocionPrimerosAniosArray['meta']['total'];
		//2dos año.
		// Parametros de API por defecto
		$apiParams = $this->parametrosApi('500', $cicloIdAnteriorNombre, 'CONFIRMADA', 'con', '2do', '', $userCentroId);
		// Consumo de API		
		$promocionSegundosAniosArray = $this->Siep->consumeApi("api/v1/promocion",$apiParams);
		if(isset($promocionSegundosAniosArray['error'])) {
			// Manejar error de API
		}
		$promocionSegundosAnios = $promocionSegundosAniosArray['meta']['total'];
		//3ros año.
		// Parametros de API por defecto
		$apiParams = $this->parametrosApi('500', $cicloIdAnteriorNombre, 'CONFIRMADA', 'con', '3ro', '', $userCentroId);
		// Consumo de API		
		$promocionTercerosAniosArray = $this->Siep->consumeApi("api/v1/promocion",$apiParams);
		if(isset($promocionTercerosAniosArray['error'])) {
			// Manejar error de API
		}
		$promocionTercerosAnios = $promocionTercerosAniosArray['meta']['total'];
		//4tos año.
		// Parametros de API por defecto
		$apiParams = $this->parametrosApi('500', $cicloIdAnteriorNombre, 'CONFIRMADA', 'con', '4to', '', $userCentroId);
		// Consumo de API		
		$promocionCuartosAniosArray = $this->Siep->consumeApi("api/v1/promocion",$apiParams);
		if(isset($promocionCuartosAniosArray['error'])) {
			// Manejar error de API
		}
		$promocionCuartosAnios = $promocionCuartosAniosArray['meta']['total'];
		//5tos año.
		// Parametros de API por defecto
		$apiParams = $this->parametrosApi('500', $cicloIdAnteriorNombre, 'CONFIRMADA', 'con', '5to', '', $userCentroId);
		// Consumo de API		
		$promocionQuintosAniosArray = $this->Siep->consumeApi("api/v1/promocion",$apiParams);
		if(isset($promocionQuintosAniosArray['error'])) {
			// Manejar error de API
		}
		$promocionQuintosAnios = $promocionQuintosAniosArray['meta']['total'];
		//6tos año.
		// Parametros de API por defecto
		$apiParams = $this->parametrosApi('500', $cicloIdAnteriorNombre, 'CONFIRMADA', 'con', '6to', '', $userCentroId);
		// Consumo de API		
		$promocionSextosAniosArray = $this->Siep->consumeApi("api/v1/promocion",$apiParams);
		if(isset($promocionSextosAniosArray['error'])) {
			// Manejar error de API
		}
		$promocionSextosAnios = $promocionSextosAniosArray['meta']['total'];
		if ($nivelCentro == 'Común - Secundarios') :
		//7mos año.
		// Parametros de API por defecto
		$apiParams = $this->parametrosApi('500', $cicloIdAnteriorNombre, 'CONFIRMADA', 'con', '7mo', '', $userCentroId);
		// Consumo de API		
		$promocionSeptimosAniosArray = $this->Siep->consumeApi("api/v1/promocion",$apiParams);
		if(isset($promocionSeptimosAniosArray['error'])) {
			// Manejar error de API
		}
		$promocionSeptimosAnios = $promocionSeptimosAniosArray['meta']['total'];
		endif;
		/* FIN: CONTEOS GENERAL Y ESPECÍFICOS DE PROMOCIONES.*/
		/* INICIO: CONTEOS GENERAL Y ESPECÍFICOS DE REPITENTES.*/
		// Conteo general. 
		$matriculaRepitentes = $this->Inscripcion->find('count', array(
			'conditions' => array(
				'Inscripcion.centro_id' => $userCentroId,
				'Inscripcion.ciclo_id' => $cicloIdAnterior,
				'Inscripcion.repitencia_id !=' => ''
			))
		);
		// Conteos específicos por año.
		//Salas de 3 años.
		// Parametros de API por defecto
		$apiParams = $this->parametrosApi('500', $cicloIdAnteriorNombre, 'CONFIRMADA', 'con', 'Sala de 3 años', '', $userCentroId);
		// Consumo de API		
		$repitenciaTresAniosArray = $this->Siep->consumeApi("api/v1/repitencia",$apiParams);
		if(isset($repitenciaTresAniosArray['error'])) {
			// Manejar error de API
		}
		$repitenciaTresAnios = $repitenciaTresAniosArray['meta']['total'];
		//Salas de 4 años.
		// Parametros de API por defecto
		$apiParams = $this->parametrosApi('500', $cicloIdAnteriorNombre, 'CONFIRMADA', 'con', 'Sala de 4 años', '', $userCentroId);
		// Consumo de API		
		$repitenciaCuatroAniosArray = $this->Siep->consumeApi("api/v1/repitencia",$apiParams);
		if(isset($repitenciaCuatroAniosArray['error'])) {
			// Manejar error de API
		}
		$repitenciaCuatroAnios = $repitenciaCuatroAniosArray['meta']['total'];
		//1eros año.
		// Parametros de API por defecto
		$apiParams = $this->parametrosApi('500', $cicloIdAnteriorNombre, 'CONFIRMADA', 'con', '1ro', '', $userCentroId);
		// Consumo de API		
		$repitenciaPrimerosAniosArray = $this->Siep->consumeApi("api/v1/repitencia",$apiParams);
		if(isset($repitenciaPrimerosAniosArray['error'])) {
			// Manejar error de API
		}
		$repitenciaPrimerosAnios = $repitenciaPrimerosAniosArray['meta']['total'];
		//2dos año.
		// Parametros de API por defecto
		$apiParams = $this->parametrosApi('500', $cicloIdAnteriorNombre, 'CONFIRMADA', 'con', '2do', '', $userCentroId);
		// Consumo de API		
		$repitenciaSegundosAniosArray = $this->Siep->consumeApi("api/v1/repitencia",$apiParams);
		if(isset($repitenciaSegundosAniosArray['error'])) {
			// Manejar error de API
		}
		$repitenciaSegundosAnios = $repitenciaSegundosAniosArray['meta']['total'];
		//3ros año.
		// Parametros de API por defecto
		$apiParams = $this->parametrosApi('500', $cicloIdAnteriorNombre, 'CONFIRMADA', 'con', '3ro', '', $userCentroId);
		// Consumo de API		
		$repitenciaTercerosAniosArray = $this->Siep->consumeApi("api/v1/repitencia",$apiParams);
		if(isset($repitenciaTercerosAniosArray['error'])) {
			// Manejar error de API
		}
		$repitenciaTercerosAnios = $repitenciaTercerosAniosArray['meta']['total'];
		//4tos año.
		// Parametros de API por defecto
		$apiParams = $this->parametrosApi('500', $cicloIdAnteriorNombre, 'CONFIRMADA', 'con', '4to', '', $userCentroId);
		// Consumo de API		
		$repitenciaCuartosAniosArray = $this->Siep->consumeApi("api/v1/repitencia",$apiParams);
		if(isset($repitenciaCuartosAniosArray['error'])) {
			// Manejar error de API
		}
		$repitenciaCuartosAnios = $repitenciaCuartosAniosArray['meta']['total'];
		//5tos año.
		// Parametros de API por defecto
		$apiParams = $this->parametrosApi('500', $cicloIdAnteriorNombre, 'CONFIRMADA', 'con', '5to', '', $userCentroId);
		// Consumo de API		
		$repitenciaQuintosAniosArray = $this->Siep->consumeApi("api/v1/repitencia",$apiParams);
		if(isset($repitenciaQuintosAniosArray['error'])) {
			// Manejar error de API
		}
		$repitenciaQuintosAnios = $repitenciaQuintosAniosArray['meta']['total'];
		//6tos año.
		// Parametros de API por defecto
		$apiParams = $this->parametrosApi('500', $cicloIdAnteriorNombre, 'CONFIRMADA', 'con', '6to', '', $userCentroId);
		// Consumo de API		
		$repitenciaSextosAniosArray = $this->Siep->consumeApi("api/v1/repitencia",$apiParams);
		if(isset($repitenciaSextosAniosArray['error'])) {
			// Manejar error de API
		}
		$repitenciaSextosAnios = $repitenciaSextosAniosArray['meta']['total'];
		//7mos año.
		// Parametros de API por defecto
		$apiParams = $this->parametrosApi('500', $cicloIdAnteriorNombre, 'CONFIRMADA', 'con', '7mo', '', $userCentroId);
		// Consumo de API		
		$repitenciaSeptimosAniosArray = $this->Siep->consumeApi("api/v1/repitencia",$apiParams);
		if(isset($repitenciaSeptimosAniosArray['error'])) {
			// Manejar error de API
		}
		$repitenciaSeptimosAnios = $repitenciaSeptimosAniosArray['meta']['total'];
		/* FIN: CONTEOS GENERAL Y ESPECÍFICOS DE REPITENTES.*/
		// Envío de valores a la vista.
		$this->set(compact('centroNombre', 'usuarios', 'empleados', 'cursos', 'matricula', 'ingresantes',
		 'matriculaBaja', 'matriculaPromocionesTotal', 'matriculaPromociones1ro', 'matriculaEgresos', 'matriculaPases', 
		 'cursosTresAnios', 'cursosTresAniosMultiple', 'cursosCuatroAnios', 'cursosCuatroAniosMultiple',
		 'cursosCincoAnios', 'cursosPrimerosAnios', 'cursosSegundosAnios', 'cursosTercerosAnios', 'cursosCuartosAnios',
		 'cursosQuintosAnios', 'cursosSextosAnios', 'cursosSeptimosAnios', 'cursosAlfabetizacion', 'cursosCAP', 'inscripcionesPorHermano', 'inscripcionesComunes', 'inscripcionesPorSituacionSocial',
		 'inscripcionesPorPase', 'bajasSalidosConPase', 'bajasSalidosSinPase', 'bajasPerdidaRegularidad', 
		 'bajasFallecimiento', 'bajasSinEspecificar', 'titulacionesIdActivas', 'nivelCentro', 'matriculaPromociones', 'matriculaRepitentes',
		 'promocionTresAnios', 'promocionCuatroAnios', 'promocionCincoAnios', 'promocionPrimerosAnios', 'promocionSegundosAnios', 'promocionTercerosAnios', 'promocionCuartosAnios', 'promocionQuintosAnios', 'promocionSextosAnios', 'promocionSeptimosAnios',
		 'repitenciaTresAnios', 'repitenciaCuatroAnios', 'repitenciaCincoAnios', 'repitenciaPrimerosAnios', 'repitenciaSegundosAnios', 'repitenciaTercerosAnios', 'repitenciaCuartosAnios', 'repitenciaQuintosAnios', 'repitenciaSextosAnios', 'repitenciaSeptimosAnios')); 
	} 
	
	public function parametrosApi ($paginas, $ciclo, $inscripcionEstado, $division, $anio, $turno, $userCentro) {
		$apiParams = [];
		$apiParams['por_pagina'] = $paginas;
		$apiParams['ciclo'] = $ciclo;
		$apiParams['estado_inscripcion'] = $inscripcionEstado;
		$apiParams['division'] = $division;
		$apiParams['anio'] = $anio;
		$apiParams['turno'] = $turno;
		$apiParams['centro_id'] = $userCentro;
		return $apiParams;
	}

	/*
    public function i_x_curso() {
     	$this->loadModel('Curso');
     	$cursos = $this->Curso->find('list', array('field'=>array('matricula'), 'conditions'=>array('centro_id'=>19)));
		$this->set(compact($cursos));
	}

	public function r_x_curso() {

	}
, 
	public function a_x_curso() {

	}
	*/
}
?>