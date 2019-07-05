<?php
App::uses('AppController', 'Controller');

class RepitentesController extends AppController
{
    // Permite agregar el Helper de Siep a las vistas
    public $helpers = array('Siep');

    public function beforeFilter()
    {
        parent::beforeFilter();

        /* ACCESOS SEGÚN ROLES DE USUARIOS (INICIO).
        *Si el usuario tiene un rol de superadmin le damos acceso a todo. Si no es así (se trata de un usuario "admin o usuario") tendrá acceso sólo a las acciones que les correspondan.
        */

        // Importa el Helper de Siep al controlador es accesible mediante $this->Siep
        App::import('Helper', 'Siep');
        $this->Siep= new SiepHelper(new View());

        /*
        --------------------------------------------------------------
                   Ejemplo de verificacion de rol con el Helper
        --------------------------------------------------------------
        if($this->Siep->isAdmin() || $this->Siep->isSuperAdmin()) {
            $this->Auth->allow();
        }

        if($this->Siep->isUsuario()) {
            $this->Auth->allow('index', 'view', 'requestDatatable');
        }
       */

        switch ($this->Auth->user('role')) {
            case 'superadmin':
            case 'admin':
                $this->Auth->allow();
            break;
            case 'usuario':
                $this->Auth->allow('index', 'view');
            break;
        }
    }

    public function view() {
        // Datos de usuario logueado
        $userCentro = $this->Auth->user('Centro');

        // Parametros de API por defecto
        $apiParams = [];
        $apiParams['por_pagina'] = 20;
        $apiParams['ciclo'] = 2018;
        $apiParams['estado_inscripcion'] = 'CONFIRMADA';
        $apiParams['division'] = 'con';
        //$apiParams['order'] = 'anio';
        //$apiParams['order_dir'] = 'asc';
        $apiParams['anio'] = '';
        $apiParams['turno'] = '';
        $apiParams['centro_id'] = '';

        if(isset($this->request->query['anio'])){
            $apiParams['anio'] = $this->request->query['anio'];
        }
        if(isset($this->request->query['centro_id'])){
            $apiParams['centro_id'] = $this->request->query['centro_id'];
        }
        if(isset($this->request->query['turno'])){
            $apiParams['turno'] = $this->request->query['turno'];
        }
        if(isset($this->request->query['page'])){
            $apiParams['page'] = $this->request->query['page'];
        }

        // Filtros de roles
        if($this->Siep->isAdmin())
        {
            $apiParams['centro_id'] = $userCentro['id'];
        }

        if($this->Siep->isUsuario())
        {
            // Supervision Primaria ve Jardines y Escuelas
            if($this->Siep->isSupervisionInicialPrimaria())
            {
                $apiParams['nivel_servicio'] = [
                    'Común - Inicial',
                    'Común - Primario',
                    'Común - Inicial - Primario'
                ];
            } elseif ($this->Siep->isSupervisionSecundaria())
            {
                // Supervision Secundaria, solo ve colegios secundarios
                $apiParams['nivel_servicio'] = [
                    'Común - Secundario'
                ];
            } else {
                // El resto de los usuarios, ven a los inscriptos de sus establecimientos, en su nivel de servicio
                $userNivelServicio = $userCentro['nivel_servicio'];
                $apiParams['centro_id'] = $userCentro['id'];
                $apiParams['nivel_servicio'] = $userNivelServicio;
            }
        }

        // Consumo de API
        $repitencia = $this->Siep->consumeApi("api/v1/repitencia",$apiParams);
        if(isset($repitencia['error']))
        {
            // Manejar error de API
        }
        
        // Consumo de FORMS de API
        $comboTurno = [
            'Mañana' => 'Mañana',
            'Tarde' => 'Tarde',
            'Noche' => 'Noche',
            'Vespertino' => 'Vespertino'
        ];

        $comboAño = [
            'Sala de 3 años' => 'Sala de 3 años',
            'Sala de 4 años' => 'Sala de 4 años',
            'Sala de 5 años' => 'Sala de 5 años',
            '1ro' => '1ro',
            '2do' => '2do',
            '3ro' => '3ro',
            '4to' => '4to',
            '5to' => '5to',
            '6to' => '6to',
            '7mo' => '7mo',
        ];


        // Completa nuevamente el campo de filtros con el ultimo aplicado
        $filtro = ['centro_id'=>'','centro_sigla'=>''];
        if(isset($apiParams['centro_id'])&&!empty($apiParams['centro_id']))
        {
            $this->loadModel('Centro');
            $this->Centro->recursive = false;
            $centro = $this->Centro->findById($apiParams['centro_id']);
            if($centro)
            {
                $filtro = [
                    'centro_id' => $centro['Centro']['id'],
                    'centro_sigla' => $centro['Centro']['sigla']
                ];
            }
        }

        $this->set(compact('filtro','repitencia','comboAño','comboTurno','apiParams'));
    }
}
