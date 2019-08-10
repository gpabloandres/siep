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
		$cicloIdActualArray = $this->Ciclo->findById($cicloIdActual, 'id');
		$cicloIdActual = $cicloIdActualArray['Ciclo']['id'];
		$ciclosVecinos = $this->Ciclo->find('neighbors', ['field' => 'id', 'value' => $cicloIdActual]);
		$cicloIdAnterior = $ciclosVecinos ['prev']['Ciclo']['id'];
		$cicloIdPosterior = $ciclosVecinos ['next']['Ciclo']['id'];		
		// Obtención del nombre y el nivel del centro del usuario.
		$userCentroId = $this->getUserCentroId();
		$this->loadModel('Centro');
		$this->Centro->recursive = 0;
		$this->Centro->Behaviors->load('Containable');
		$centroNombreArray = $this->Centro->findById($userCentroId,'nombre');
		$centroNombre = $centroNombreArray['Centro']['nombre'];
		$nivelCentroArray = $this->Centro->findById($userCentroId, 'nivel_servicio');
        $nivelCentro = $nivelCentroArray['Centro']['nivel_servicio'];
		/* INICIO: conteos generales */
		// Conteo de los usuarios.
		$this->loadModel('User');
		$this->User->recursive = 0;
		$this->User->Behaviors->load('Containable');
		$usuarios = $this->User->find('count', array(
			'conditions' => array('User.centro_id' => $userCentroId)));
		// Conteo de las titulaciones activas en Secundarios (Modalidades: Común y Adultos).
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
		// Conteo de las secciones.
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
		// Conteo de matrícula actual.
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
		// Conteo de baja de matrícula.
		$legajoTipo = 'SINVACANTE';
		$matriculaBaja = $this->Inscripcion->find('count', array(
			'conditions' => array(
				'Inscripcion.centro_id' => $userCentroId,
				'Inscripcion.estado_inscripcion' => 'BAJA',
				'Inscripcion.ciclo_id' => $cicloIdActual,
				'Inscripcion.legajo_nro NOT LIKE' => '%'.$legajoTipo.'%'
			))
		);
		// Conteo de promociones Totales.		
		// Parametros de API por defecto
		$apiParamsTotal = [];
		$apiParamsTotal['ciclo'] = '2018';
		$apiParamsTotal['promocion'] = 'con';
		$apiParamsTotal['centro_id'] = $userCentroId;
		
		$matriculaPromociones = $this->Siep->consumeApi("api/v1/matriculas/cuantitativa/por_seccion",$apiParamsTotal);
		if(isset($promociones['error'])) {
			// Manejar error de API
		}
		$matriculaPromocionesTotal = $matriculaPromociones['total'];
		
		// Conteo de repitentes. (PENDIENTE CON el campo repitencia_id) 
		
		
		// Conteo de egresos.
		$matriculaEgresos = $this->Inscripcion->find('count', array(
			'conditions' => array(
				'Inscripcion.centro_id' => $userCentroId,
				'Inscripcion.estado_inscripcion' => 'EGRESO',
				'Inscripcion.ciclo_id' => $cicloIdAnterior
			))
		);
		/* FIN: conteos generales */
		/* INICIO: conteos específicos */
		/* CONTEO de secciones por año para usuarios con role "admin". 
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
		// Conteo de pases: Entradas + Salidas
		$matriculaPases = $inscripcionesPorPase + $bajasSalidosConPase;
		/* Conteo de promociones según años. */
		// Primer año.
		// Parametros de API por defecto
		$apiParams1ro = [];
		$apiParams1ro['ciclo'] = '2018';
		$apiParams1ro['promocion'] = 'con';
		$apiParams1ro['centro_id'] = $userCentroId;
		$apiParams1ro['anio'] = '1ro';
		$matriculaPromociones = $this->Siep->consumeApi("api/v1/matriculas/cuantitativa/por_seccion",$apiParams1ro);
		if(isset($promociones['error'])) {
			// Manejar error de API
		}
		$matriculaPromociones1ro = $matriculaPromociones['total'];
		// Primer año.
		// Parametros de API por defecto
		$apiParams1ro = [];
		$apiParams1ro['ciclo'] = '2018';
		$apiParams1ro['promocion'] = 'con';
		$apiParams1ro['centro_id'] = $userCentroId;
		$apiParams1ro['anio'] = '1ro';
		$matriculaPromociones = $this->Siep->consumeApi("api/v1/matriculas/cuantitativa/por_seccion",$apiParams1ro);
		if(isset($promociones['error'])) {
			// Manejar error de API
		}
		$matriculaPromociones1ro = $matriculaPromociones['total'];

		
		// Envío de valores a la vista.
		$this->set(compact('centroNombre', 'usuarios', 'cursos', 'matricula', 'ingresantes',
		 'matriculaBaja', 'matriculaPromocionesTotal', 'matriculaPromociones1ro', 'matriculaEgresos', 'matriculaPases', 
		 'cursosTresAnios', 'cursosTresAniosMultiple', 'cursosCuatroAnios', 'cursosCuatroAniosMultiple',
		 'cursosCincoAnios', 'cursosPrimerosAnios', 'cursosSegundosAnios', 'cursosTercerosAnios', 'cursosCuartosAnios',
		 'cursosQuintosAnios', 'cursosSextosAnios', 'cursosSeptimosAnios', 'cursosAlfabetizacion', 'cursosCAP', 'inscripcionesPorHermano', 'inscripcionesComunes', 'inscripcionesPorSituacionSocial',
		 'inscripcionesPorPase', 'bajasSalidosConPase', 'bajasSalidosSinPase', 'bajasPerdidaRegularidad', 
		 'bajasFallecimiento', 'bajasSinEspecificar', 'titulacionesIdActivas', 'nivelCentro')); 
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