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

		if($this->apiHasError($apiResponse)==false) {
			if($apiResponse['total']>0)
			{
				$firstApiData = $apiResponse['data'][0];
				$curso = $firstApiData['curso'];
				$centro = $firstApiData['inscripcion']['centro'];
				$ciclo = $firstApiData['inscripcion']['ciclo'];

				/* Secciones disponibles para Reubicacion
				** Sí son Instituciones Comunes (secciones del mismo año).
				** Sí son Instituciones Experimentales o de la Modalidad Especial (secciones de todos los años).
				*/
				if ($centro_id != 11 || $centro_id != 101 || $centro_id != 129 || $centro_id != 141 || $centro_id != 150 ||
					$centro_id != 502 || $centro_id != 505 || $centro_id != 506 || $centro_id != 507 || $centro_id != 508 ||
					$centro_id != 509 || $centro_id != 510 || $centro_id != 511 || $centro_id != 512 || $centro_id != 23 ||
					$centro_id != 73 || $centro_id != 81 || $centro_id != 196) {
					$this->loadModel('Curso');
					$secciones = $this->Curso->find('list', array(
						'recursive'=>-1,
						'fields'=>array('id','nombre_completo_curso'),
						'conditions'=>array(
						'centro_id'=>$centro_id,
						'anio' => $curso['anio']
						//'division !='=> ''
					)
				));
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

			$httpSocket = new HttpSocket();
			$this->request->data['user_id'] = $userId;
			$data = $this->request->data;
	
			$hostApi = getenv('HOSTAPI');
			$response = $httpSocket->post("http://$hostApi/api/inscripcion/reubicacion", $data);
			$apiResponse = json_decode($response->body,true);

			if($this->apiHasError($apiResponse)==false) {
				$this->Session->setFlash("Reubicacion realizada con exito", 'default', array('class' => 'alert alert-success'));
			}

			$this->redirect($this->referer());

		} catch(\Exception $ex){
			$this->Session->setFlash("API($hostApi) TryError: ".$ex->getMessage(), 'default', array('class' => 'alert alert-danger'));
			$this->redirect($this->referer());
		}
	}

	private function apiHasError($apiResponse) {
		if(isset($apiResponse['error'])) {
			if(is_array($apiResponse['error']) && count($apiResponse['error'])>0) {
				$msgError = "";
				foreach ($apiResponse['error'] as $errParam) {
					if(is_array($errParam))
					{
						foreach ($errParam as $subErr) {
							$msgError .= $subErr."<br>";
						}
					} else {
						$msgError .= $errParam."<br>";
					}
				}
			} else {
				$msgError = $apiResponse['error'];
			}
			$this->Session->setFlash($msgError, 'default', array('class' => 'alert alert-danger'));
			return true;
		} else {
			return false;
		}
	}

	private function apiListaDeAlumnos($centroId,$cursoId,$cicloId)
	{
		try {
			$userId = $this->Auth->user('id');

			$httpSocket = new HttpSocket();
			$request = array('header' => array('Content-Type' => 'application/json'));
			$this->request->data['user_id'] = $userId;
			$this->request->data['centro_id'] = $centroId;
			$this->request->data['curso_id'] = $cursoId;
			$this->request->data['ciclo_id'] = $cicloId;
			$this->request->data['estado_inscripcion'] = "CONFIRMADA";
			$this->request->data['por_pagina'] = 'all';

			$dataToSend = $this->request->data;

			$hostApi = getenv('HOSTAPI');
			$response = $httpSocket->get("http://$hostApi/api/inscripcion/lista", $dataToSend, $request);

			$response = $response->body;
			$apiResponse = json_decode($response,true);
			return $apiResponse;

		} catch(\Exception $ex){
			return [
				'error'=>'API($hostApi) TryError: '.$ex->getMessage()
			];
		}
	}
}