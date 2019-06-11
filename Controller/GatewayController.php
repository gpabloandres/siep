<?php
App::uses('AppController', 'Controller');

class GatewayController extends AppController
{
    // Permite agregar el Helper de Siep a las vistas
    public $helpers = array('Siep');

    public function beforeFilter()
    {
        parent::beforeFilter();
        App::import('Helper', 'Siep');
        $this->Siep= new SiepHelper(new View());

        switch ($this->Auth->user('role')) {
            case 'superadmin':
            case 'admin':
                $this->Auth->allow();
            break;
            case 'usuario':
                $this->Auth->allow();
            break;
        }
    }

    public function index_____() {
        /*
        // Parametros de API por defecto
        $apiParams = [];
        $apiParams['por_pagina'] = 10;
        $apiParams['ciclo'] = 2019;
        $apiParams['estado_inscripcion'] = 'CONFIRMADA';
        $apiParams['division'] = 'con';
        $apiParams['order'] = 'anio';
        $apiParams['order_dir'] = 'asc';

        // Filtros de formulario y paginacion
        if(isset($this->request->query['ciclo'])){
            $apiParams['ciclo'] = $this->request->query['ciclo'];
        }
        if(isset($this->request->query['anio'])){
            $apiParams['anio'] = $this->request->query['anio'];
        }
        if(isset($this->request->query['centro_id'])){
            $apiParams['centro_id'] = $this->request->query['centro_id'];
        }
        if(isset($this->request->query['page'])){
            $apiParams['page'] = $this->request->query['page'];
        }
        */

        // Consumo de API
        $matriculas_por_seccion = $this->Siep->consumeApi("api/matriculas/cuantitativa/por_seccion",$apiParams);
        if(isset($matriculas_por_seccion['error']))
        {
            // Manejar error de API
        }

        $this->set(compact('response'));
    }

    public function cursos()
    {
            $por_pagina=  $this->params['named']['por_pagina'];
            $centro_id = $this->params['named']['centro_id'];

            // Evita buscar el archivo VIEW
            $this->autoRender = false;

            $route = "api/v1/cursos?por_pagina={$por_pagina}&centro_id={$centro_id}";

            $response = $this->Siep->consumeApi($route);

            // Muestra el resultado de un Array como JSON
            $this->response->type('json');
            $json = json_encode($response);
            $this->response->body($json);
    }
}