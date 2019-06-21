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

    public function ficha()
    {
        $this->autoRender = false;
        $hostApi = getenv('HOSTAPI');
        $id = $this->params['named']['id'];

        $url = "http://{$hostApi}/api/v1/personas/{$id}/ficha";

        $opts = array(
            'http' => array(
                'method' => 'GET',
                'agent'  => "CakePHP",
                'header' => getenv('XHOSTCAKE').": do"
            )
        );
        $context = stream_context_create($opts);

        $result= file_get_contents($url,false, $context);

        $json = json_decode($result, TRUE);
        if($json['error'])
        {
            debug($json);
        } else {
            $this->response->body($result);
            $this->response->type('pdf');
        }
    }

    public function constancia()
    {
        $this->autoRender = false;
        $hostApi = getenv('HOSTAPI');
        $id = $this->params['named']['id'];

        $url = "http://{$hostApi}/api/v1/constancia/{$id}";

        $opts = array(
            'http' => array(
                'method' => 'GET',
                'agent'  => "CakePHP",
                'header' => getenv('XHOSTCAKE').": do"
            )
        );
        $context = stream_context_create($opts);

        $result= file_get_contents($url,false, $context);

        $this->response->body($result);
        $this->response->type('pdf');
    }
    public function constancia_regular()
    {
        $this->autoRender = false;
        $hostApi = getenv('HOSTAPI');
        $id = $this->params['named']['id'];

        $url = "http://{$hostApi}/api/v1/constancia_regular/{$id}";

        $opts = array(
            'http' => array(
                'method' => 'GET',
                'agent'  => "CakePHP",
                'header' => getenv('XHOSTCAKE').": do"
            )
        );
        $context = stream_context_create($opts);

        $result= file_get_contents($url,false, $context);

        $this->response->body($result);
        $this->response->type('pdf');
    }

    public function excel_inscripcion()
    {
        $this->autoRender = false;
        $hostApi = getenv('HOSTAPI');
        $query = $this->request->data['query'];

        $url = "http://{$hostApi}/api/v1/inscripcion/lista/excel?$query";

        $opts = array(
            'http' => array(
                'method' => 'GET',
                'agent'  => "CakePHP",
                'header' => getenv('XHOSTCAKE').": do"
            )
        );
        $context = stream_context_create($opts);

        $result= file_get_contents($url,false, $context);

        header('Cache-Control: public');
        header('Content-type: application/xls');
        header('Content-Disposition: attachment; filename="Exportacion_Inscripciones.xls"');
        header('Content-Length: '.strlen($result));

        $this->response->body($result);
        $this->response->type('xls');
    }

    public function excel_alumnos()
    {
        $this->autoRender = false;
        $hostApi = getenv('HOSTAPI');
        $query = $this->request->data['query'];

        $url = "http://{$hostApi}/api/v1/exportar/excel/ListaAlumnos?$query";

        $opts = array(
            'http' => array(
                'method' => 'GET',
                'agent'  => "CakePHP",
                'header' => getenv('XHOSTCAKE').": do"
            )
        );
        $context = stream_context_create($opts);

        $result= file_get_contents($url,false, $context);

        header('Cache-Control: public');
        header('Content-type: application/xls');
        header('Content-Disposition: attachment; filename="Exportacion_Alumnos.xls"');
        header('Content-Length: '.strlen($result));

        $this->response->body($result);
        $this->response->type('xls');
    }

}