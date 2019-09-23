<?php

App::uses('AppHelper', 'View/Helper');
App::uses('HttpSocket', 'Network/Http');

class SiepHelper extends AppHelper
{
    public function isSuperAdmin()
    {
        return (AuthComponent::user('role') == 'superadmin') ? true : false;
    }

    public function isUsuario()
    {
        return (AuthComponent::user('role') == 'usuario') ? true : false;
    }

    public function isAdmin()
    {
        return (AuthComponent::user('role') == 'admin') ? true : false;
    }

    public function isSupervisionInicialPrimaria()
    {
        return (AuthComponent::user('puesto') == 'Supervisión Inicial/Primaria') ? true : false;
    }

    public function isSupervisionSecundaria()
    {
        return (AuthComponent::user('puesto') == 'Supervisión Secundaria') ? true : false;
    }

    public function logQuery($modelo)
    {
        $log = $modelo->getDataSource()->getLog(false, false);
        return $log['log'];
    }

    function logQuerySave($sql){
        //log error into a txt file and every day has unique file that contains the errors.
        //save file to tmp\logs\sql folder
        $log_dir_path = LOGS.'sql';
        $res1 = is_dir($log_dir_path);
        if($res1 != 1)
        {
            $res2= mkdir($log_dir_path, 0777, true);
        }
        $file = $log_dir_path.'/'.date('d-m-Y').".log";
        $message = date('Y-m-d G:i:s') . ' - ' . $sql;
        $handle = fopen($file, 'a+');
        if($handle !== false)
        {
            fwrite($handle, "\n\n".$message . "\n");
            fclose($handle);
        }
    }

    public function clearfix($counter,$rows=2)
    {
        if($counter%$rows==0)
        {
            echo '<div class="clearfix"></div>';
        }
        $counter++;
        return $counter;
    }

    public function consumeApi($route,$params=array(),$method="GET") {
        try {
            $hostApi = getenv('HOSTAPI');

            $request = array(
                'method' => $method,
                'uri' => array(
                    'host' => $hostApi,
                    'path' => $route,
                    'query' => $params,
                ),
                'header' => array(
                    'Connection' => 'close',
                    'User-Agent' => 'CakePHP',
                    'Content-Type' => 'application/json',
                ),
                'redirect' => false
            );

            $request['header'][getenv('XHOSTCAKE')] = 'do';

            $httpSocket = new HttpSocket();
            $response = $httpSocket->request($request);

            $response = $response->body;
            $apiResponse = json_decode($response,true);
            return $apiResponse;

        } catch(\Exception $ex){
            return [
                'error'=>'API($hostApi) TryError: '.$ex->getMessage()
            ];
        }
    }

    public function apiHasError($apiResponse) {
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

            return $msgError;
        } else {
            return false;
        }
    }


    public function pagination($item) {
        if(isset($item['total']))
        {
            echo '<div class="unit text-center"><p>Página 
            '.$item['current_page'].' de
            '.$item['last_page'].', mostrando
            '.$item['per_page'].' resultados de un <strong>TOTAL DE</strong>
            '.$item['total'].', desde
            '.$item['from'].' hasta
            '.$item['to'].'</p>';

            $i=1;
            echo '<div class="paging">';
            if($item['current_page']>1) {
                echo '<a href="'.$this->paginationLink($item['current_page']-1).'">&laquo; anterior</a> | ';
            }

            for($i;$i<=$item['last_page'];$i++)
            {
                if($i == $item['current_page']) {
                    echo "$i";
                } else {
                    echo '<a href="'.$this->paginationLink($i).'">'.$i.'</a>';
                }
                if($i != $item['last_page']) {
                    echo ' | ';
                }
            }

            if($item['current_page']<$item['last_page']) {
                echo ' | <a href="'.$this->paginationLink($item['current_page']+1).'">siguiente &raquo;</a>';
            }
            echo '</div></div>';
        }
    }

    private function paginationLink($page) {
        $this->request->query['page'] = $page;
        return Router::url(null,true).'?'.http_build_query($this->request->query);
    }

    private function paramLink($params) {
        $newParams = array_merge($this->request->query,$params);
        return Router::url(null,true).'?'.http_build_query($newParams);
    }
}