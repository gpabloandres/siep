<?php
App::uses('AppController', 'Controller');

class MatriculasController extends AppController
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
                $this->Auth->allow('index', 'view', 'requestDatatable');
            break;

			default:
                $this->Session->setFlash('No tiene permisos.', 'default', array('class' => 'alert alert-warning'));
                $this->redirect($this->referer());
                break;
        }
    }

    public function index() {
        //$this->User->recursive = 0;
        $this->loadModel('Curso');
        $this->paginate = array(
            'contain' => array('Centro'),
            'limit' => 10,
            'conditions' => array('Curso.division !=' => '', 'Curso.status =' => 1, 'Curso.matricula !=' => 0),
            'order' => array('Curso.centro_id' => 'asc' )
        );
        $this->redirectToNamed();
        $conditions = array();
        if (!empty($this->params['named']['ciclo_id'])) {

            // Condicion para filtrar el ciclo_id
            //$conditions['CursosInscripcions.ciclo_id ='] = $this->params['named']['ciclo_id'];
        }
        if(!empty($this->params['named']['centro_id']))
        {
            $conditions['Centro.id = '] = $this->params['named']['centro_id'];
        }
        if (!empty($this->params['named']['anio'])) {
            $conditions['Curso.anio ='] = $this->params['named']['anio'];
        }
        if (!empty($this->params['named']['division'])) {
            $conditions['Curso.division ='] = $this->params['named']['division'];
        }
        $userCentroId = $this->getUserCentroId();
        // Cargo todos los cilos de la base de datos
        $this->loadModel('Ciclo');
        $comboCiclo = $this->Ciclo->find('list', array('fields'=>array('id', 'nombre')));

        $cicloIdUltimo = $this->getLastCicloId();
        $cicloIdActual = $this->getActualCicloId();

        if($this->Siep->isAdmin()) {
            $conditions['Curso.centro_id'] = $userCentroId;
            $matriculas = $this->paginate('Curso',$conditions);
            $comboAnio = $this->Curso->find('list', array(
                'recursive'=> -1,
                'fields'=> array('Curso.anio','Curso.anio'),
                'conditions'=>array('centro_id'=>$userCentroId)
            ));
            $comboDivision = $this->Curso->find('list', array(
                'recursive'=> -1,
                'fields'=> array('Curso.division','Curso.division'),
                'conditions'=>array('centro_id'=>$userCentroId)
            ));

//            $comboDivision = $this->Curso->query("SELECT `Curso`.`division` FROM `siep`.`cursos` AS `Curso` WHERE `centro_id` = ".$userCentroId." GROUP BY division");

//            $comboDivision = $this->Curso->find('list', array(
//                'recursive'=> -1,
//                'fields'=> 'division',
//                'conditions'=>array('centro_id'=>$userCentroId)
//            ));
        }

        if($this->Siep->isUsuario()) {
            $nivelCentroArray = $this->Curso->Centro->findById($userCentroId, 'nivel_servicio');
            $nivelCentroString = $nivelCentroArray['Centro']['nivel_servicio'];
            if ($nivelCentroString === 'Común - Inicial - Primario') {
                $nivelCentroId = $this->Curso->Centro->find('list', array(
                    'fields' => array('id'),
                    'conditions' => array(
                        'nivel_servicio' => array('Común - Inicial', 'Común - Primario')
                    )
                ));
                $conditions['Curso.centro_id'] = $nivelCentroId;
                $matriculas = $this->paginate('Curso', $conditions);
            } else {
                $nivelCentroId = $this->Curso->Centro->find('list', array(
                    'fields' => array('id'),
                    'conditions' => array('nivel_servicio' => $nivelCentroString)
                ));
                $conditions['Curso.centro_id'] = $nivelCentroId;
                $matriculas = $this->paginate('Curso', $conditions);
            }

            $comboAnio = $this->Curso->find('list', array(
                'recursive'=> -1,
                'fields'=> array('Curso.anio','Curso.anio'),
                'conditions'=>array('centro_id'=>$nivelCentroId)
            ));
            $comboDivision = $this->Curso->find('list', array(
                'recursive'=> -1,
                'fields'=> array('Curso.division','Curso.division'),
                'conditions'=>array('centro_id'=>$nivelCentroId)
            ));
        }

        if($this->Siep->isSuperAdmin()) {
            $matriculas = $this->paginate('Curso',$conditions);

            $comboAnio = $this->Curso->find('list', array(
                'recursive'=> -1,
                'fields'=> array('Curso.anio','Curso.anio')
            ));
            $comboDivision = $this->Curso->find('list', array(
                'recursive'=> -1,
                'fields'=> array('Curso.division','Curso.division')
            ));
        }
        //Obtención de los nombres de las titulaciones para mostrar en las secciones.
        $this->loadModel('Titulacion');
        $this->Titulacion->recursive = 0;
        $this->Titulacion->Behaviors->load('Containable');
        $titulacionesNombres = $this->Titulacion->find('list', array(
            'fields'=>array('nombre_abreviado'),
            'contain'=>false,
            'conditions'=>array('status'=>1)));
        $this->set(compact('matriculas','comboAnio','comboDivision','comboCiclo','cicloIdUltimo','cicloIdActual', 'titulacionesNombres'));
  	}

    /*
     * Este metodo se encarga de listar todas las inscripciones realizadas, y las agrupa segun el siguiente filtro
     *
     * Inscripcion en -> ciclo_id, centro_id, curso.anio, curso.division, curso.turno
     *
     * El filtro obtiene la cantidad de matriculas y sus plazas, lo que permite obtener las vacantes.
     *
     * Esta consulta a su vez actualiza los datos en la tabla Cursos segun el Curso.id
     *
     */
    public function recuento()
    {
        // Evita buscar el archivo VIEW
        $this->autoRender = false;

        if(isset($this->params['named']['ciclo']))
        {
            $ciclo = $this->params['named']['ciclo'];
            $response = $this->Siep->consumeApi("api/matriculas/recuento/$ciclo");
        } else {
            $response = ['error'=>'Debe definir el parametro CICLO'];
        }

        // Muestra el resultado de un Array como JSON
        $this->response->type('json');
        $json = json_encode($response);
        $this->response->body($json);

        // Redireccionar a otra ruta
        // $this->redirect(array('action' => 'index'));
    }
}
