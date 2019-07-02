<?php
App::uses('AppController', 'Controller');

class ReubicacionController extends AppController {

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

			default:
				$this->Session->setFlash('No tiene permisos.', 'default', array('class' => 'alert alert-warning'));
				$this->redirect($this->referer());
				break;
		}
	    /* FIN */
		App::import('Helper', 'Siep');
		$this->Siep= new SiepHelper(new View());
	}

/**
 * index method
 *
 * @return void
 */
	public function index()
	{
		// Ciclo actual
		$hoyArray = getdate();
		$this->loadModel('Ciclo');
		$cicloActual = $this->Ciclo->find('first', array(
			'recursive' => -1,
			'conditions' => array('nombre' => $hoyArray['year'])
		));
		$cicloActual = array_pop($cicloActual);

		$centro_id = $this->params['named']['centro_id'];
		$curso_id = $this->params['named']['curso_id'];

		// Obtengo lista de alumnos desde la API
		$apiResponse = $this->apiListaDeAlumnos(
			$centro_id,
			$curso_id,
			$cicloActual['id']
		);

		$success = false;

		if($this->Siep->apiHasError($apiResponse)==false) {
			if($apiResponse['total']>0)
			{
				$firstApiData = $apiResponse['data'][0];
				$curso = $firstApiData['curso'];
				$centro = $firstApiData['inscripcion']['centro'];
				$ciclo = $firstApiData['inscripcion']['ciclo'];

				/* Secciones disponibles para Reubicacion
				** Sí son Instituciones Experimentales o de la Modalidad Especial (secciones de todos los años).
				** Sino para Instituciones Comunes (secciones del mismo año).
				*/
				$this->loadModel('Curso');
				if ($centro_id == 11 || $centro_id == 101 || $centro_id == 129 || $centro_id == 141 || $centro_id == 150 ||
					$centro_id == 502 || $centro_id == 505 || $centro_id == 506 || $centro_id == 507 || $centro_id == 508 ||
					$centro_id == 509 || $centro_id == 510 || $centro_id == 511 || $centro_id == 512 || $centro_id == 23 ||
					$centro_id == 73 || $centro_id == 81 || $centro_id == 196) {
					$secciones = $this->Curso->find('list', array(
						'recursive'=>-1,
						'fields'=>array('id','nombre_completo_curso'),
						'conditions'=>array(
						'centro_id'=>$centro_id
						//'anio' => $curso['anio']
						//'division !='=> ''
					)));
				} else {
					$secciones = $this->Curso->find('list', array(
						'recursive'=>-1,
						'fields'=>array('id','nombre_completo_curso'),
						'conditions'=>array(
						'centro_id'=>$centro_id,
						'anio' => $curso['anio']
						//'division !='=> ''
					)));	
				}				
				$success = true;
			} else {
				$this->Session->setFlash("No hay alumnos en esta seccion", 'default', array('class' => 'alert alert-danger'));
			}
		}

		$this->set(compact('apiResponse','curso','centro','ciclo','success','secciones'));
	}

	public function confirmarAlumnos()
	{
		try {
			$userId = $this->Auth->user('id');
			$this->request->data['user_id'] = $userId;
			$data = $this->request->data;

			$apiParams = $data;

			$api = $this->Siep->consumeApi("api/inscripcion/reubicacion",$apiParams,'POST');
			$apiErr = $this->Siep->apiHasError($api);

			if($apiErr)
			{
				$this->Session->setFlash("$apiErr", 'default', array('class' => 'alert alert-danger'));
			} else {
				$this->Session->setFlash("Reubicacion realizada con exito", 'default', array('class' => 'alert alert-success'));
			}

		} catch(\Exception $ex){
			$this->Session->setFlash("API TryError: ".$ex->getMessage(), 'default', array('class' => 'alert alert-danger'));
		}

		$this->redirect($this->referer());
	}

	private function apiListaDeAlumnos($centroId,$cursoId,$cicloId)
	{
		try {
			$userId = $this->Auth->user('id');

			$apiParams['user_id'] = $userId;
			$apiParams['centro_id'] = $centroId;
			$apiParams['curso_id'] = $cursoId;
			$apiParams['ciclo_id'] = $cicloId;
			$apiParams['estado_inscripcion'] = 'CONFIRMADA';
			$apiParams['por_pagina'] = 'all';

			$api = $this->Siep->consumeApi("api/inscripcion/lista",$apiParams);
			$apiErr = $this->Siep->apiHasError($api);

			if($apiErr)
			{
				$this->Session->setFlash("API Error: ".$apiErr, 'default', array('class' => 'alert alert-danger'));
			}

			return $api;

		} catch(\Exception $ex){
			return [
				'error'=>'API TryError: '.$ex->getMessage()
			];
		}
	}
}