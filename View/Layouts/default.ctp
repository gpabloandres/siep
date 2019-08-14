<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
    <?php echo $this->Html->charset(); ?>
    <!-- Smartphones, tablet -->
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width,  minimum-scale=1.0, maximum-scale=1.0, initial-scale=no">
    <!-- ******************* -->
    <!-- ************ Css *********** -->
    <?php echo $this->Html->css(array('bootstrap', 'bootstrap.min', 'bootstrap-theme.min', 'jquery-ui.min', 'fileinput.min')); ?>
    <!-- **************************************** -->
    <!-- ************* Js *******************-->
    <?php echo $this->Html->script(array('jquery.min', 'jquery-ui.min', 'bootstrap.min', 'fastclick', 'fileinput.min')); ?>
    <!-- **************************************** -->
    <!-- ************ Sigedu Css *********** -->
    <?php echo $this->Html->css('custom', 'stylesheet', array("media"=>"all" )); ?>
    <?php echo $this->Html->css('animate', 'stylesheet', array("media"=>"all" )); ?> 
    <!-- ************************************** -->
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-140467901-1"></script>
    <script type="text/javascript">
         $("#foto").fileinput();
    	 var basePath = "<?php echo Router::url('/'); ?>"

        // ****** Google Analytics ******
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-140467901-1');
        // **** End Google Analytics ****
    </script>
    		<title>SIEP</title>
    </head>
    <body>
    	<div class="content">
    <!-- INICIO: Menú Principal 
    ** Carga del menú correspondiente al rol y al nivel de servicio del centro relacionado al usuario.
    -->
       	<?php 
            if($this->Html->loggedIn()) { 
                $userRole = $current_user['role'];
                $userPuesto = $current_user['puesto'];
                if ($userRole == 'superadmin') {
                    if ($userPuesto == 'Sistemas') {
                        echo $this->element('menues/menu-superadminSistemas');
                    } else {
                        echo $this->element('menues/menu-usuario');
                    }                    
                } elseif ($userRole == 'admin') {
                    $userPuesto = $current_user['puesto'];
                    switch ($userPuesto) {
                        case 'Dirección Jardín':
                        case 'Dirección Escuela Primaria':
                            echo $this->element('menues/menu-adminInicialPrimario');
                            break;
                        case 'Dirección Colegio Secundario':
                            echo $this->element('menues/menu-adminSecundario');
                            break;
                        case 'Dirección Instituto Superior':
                            echo $this->element('menues/menu-adminSuperior');
                            break;                        
                        default:
                            echo $this->element('menues/menu-admin');
                            break;
                    }
                } elseif ($userRole == 'usuario') {
                    $userPuesto = $current_user['puesto'];
                    switch ($userPuesto) {
                        case 'Supervisión Inicial/Primaria':
                            echo $this->element('menues/menu-usuarioInicialPrimario');
                            break;
                        case 'Supervisión Secundaria':
                            echo $this->element('menues/menu-usuarioSecundario');
                            break;                    
                        default:
                            //Dirección Provincial de Superior.
                            echo $this->element('menues/menu-admin');
                            break;
                    }
                }
            }    
        ?>
    <!-- FIN: Menú Principal -->
    	<script>
            $(function() {
                FastClick.attach(document.body);
            });
        </script>
        <?php echo $scripts_for_layout;?>
        <div id="bg" class="animated fadeIn"></div>			
    		<?php echo $this->Session->flash(); ?>
            <?php echo $content_for_layout; ?>
        </div>
        <div class="footer">
            <p><?php echo '<strong>© Subsecretaría de Planeamiento Educativo, Informática y Evaluación - Ministerio Educación TDF A.I.A.S.</strong>'; ?> </p>
            <p><?php echo $this->Html->link('License  Creative Commons: by-nc-sa', 'http://creativecommons.org/licenses/by-nc-sa/3.0'); ?> </p>
        </div>
    </body>
</html>
