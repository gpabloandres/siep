<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>SIEP | TDF</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  <!-- jQuery 3 -->
  <?php echo $this->Html->script('/adminlte/bower_components/jquery/dist/jquery.min'); ?>
  <!-- jQuery UI 1.11.4 -->
  <?php echo $this->Html->script('/adminlte/bower_components/jquery-ui/jquery-ui.min'); ?>

  <!-- Bootstrap 3.3.7 -->
  <?php echo $this->Html->css('/adminlte/bower_components/bootstrap/dist/css/bootstrap.min'); ?>
  <!-- Font Awesome -->
  <?php echo $this->Html->css('/adminlte/bower_components/font-awesome/css/font-awesome.min'); ?>
  <!-- Ionicons -->
  <?php echo $this->Html->css('/adminlte/bower_components/Ionicons/css/ionicons.min'); ?>
  <!-- Theme style -->
  <?php echo $this->Html->css('/adminlte/dist/css/AdminLTE.min'); ?>
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <?php echo $this->Html->css('/adminlte/dist/css/skins/_all-skins.min'); ?>
  <!-- Date Picker -->
  <?php echo $this->Html->css('/adminlte/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min'); ?>
  <!-- Daterange picker -->
  <?php echo $this->Html->css('/adminlte/bower_components/bootstrap-daterangepicker/daterangepicker'); ?>

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

  <?php echo $this->fetch('include_head'); ?>

</head>
<body class="hold-transition skin-blue layout-top-nav">
<div class="wrapper">
  <header class="main-header">
    <nav class="navbar navbar-static-top">
      <div class="container">
        <div class="navbar-header">
          <a href="#" class="navbar-brand"><b>SIEP</b>TDF</a>
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
            <i class="fa fa-bars"></i>
          </button>
        </div>

        <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
          <ul class="nav navbar-nav">

            <!-- PERSONAS -->
            <li><a href="<?php echo $this->Html->url('/personas'); ?>">Alta de personas</a></li>

            <!-- CUES -->
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">CUEs <span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                <li><a href="<?php echo $this->Html->url('/centros'); ?>">Instituciones</a></li>
                <li><a href="<?php echo $this->Html->url('/empleados'); ?>">Agentes</a></li>
                <li><a href="<?php echo $this->Html->url('/users'); ?>">Usuarios</a></li>
              </ul>
            </li>
          </ul>
        </div>
        <!-- /.navbar-collapse -->
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
          <ul class="nav navbar-nav">
            <!-- User Account Menu -->
            <li class="dropdown user user-menu">
              <!-- Menu Toggle Button -->
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <!-- The user image in the navbar-->
                <img src="<?php echo $this->Html->url('/adminlte/dist/img/avatar3.png'); ?>" class="user-image" alt="User Image">
                <!-- hidden-xs hides the username on small devices so only the image appears. -->
                <span class="hidden-xs"><?php echo $current_user['Empleado']['nombre_completo_empleado']; ?></span>
              </a>
              <ul class="dropdown-menu">
                <!-- The user image in the menu -->
                <li class="user-header">
                  <img src="<?php echo $this->Html->url('/adminlte/dist/img/avatar3.png'); ?>" class="img-circle" alt="User Image">

                  <p>
                    <?php echo $current_user['Empleado']['nombre_completo_empleado']; ?>
                    <small><?php echo $current_user['Empleado']['email']; ?></small>
                  </p>
                </li>
                <!-- Menu Footer-->
                <li class="user-footer">
                  <div class="pull-left">
                    <a href="#" class="btn btn-default btn-flat">Mi perfil</a>
                  </div>
                  <div class="pull-right">
                    <a href="#" class="btn btn-default btn-flat">Finalizar</a>
                  </div>
                </li>
              </ul>
            </li>
          </ul>
        </div>
        <!-- /.navbar-custom-menu -->
      </div>
      <!-- /.container-fluid -->
    </nav>
  </header>


  <?php
  // NAVEGACION CON SIDEBAR
  /*
  <header class="main-header">
    <!-- Logo -->
    <a href="index2.html" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>S</b>IEP</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>SIEP</b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Navegacion</span>
      </a>

      <!-- LOGIN DE USUARIO -->
    </nav>
  </header>

  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">NAVEGACION</li>

        <!-- PERSONAS -->
        <li>
          <a href="<?php echo $this->Html->url('/personas'); ?>">
            <i class="fa fa-circle-o"></i> <span>Alta de personas</span>
          </a>
        </li>

        <!-- CUES -->
        <li class="treeview">
          <a href="#">
            <i class="fa fa-circle-o"></i> <span>CUEs</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?php echo $this->Html->url('/centros'); ?>"><i class="fa fa-circle"></i> Instituciones</a></li>
            <li><a href="<?php echo $this->Html->url('/empleados'); ?>"><i class="fa fa-circle"></i> Agentes</a></li>
            <li><a href="<?php echo $this->Html->url('/users'); ?>"><i class="fa fa-circle"></i> Usuarios</a></li>
          </ul>
        </li>

      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>
  */

  ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
      <?php echo $scripts_for_layout;?>
      <div id="bg" class="animated fadeIn"></div>
        <?php echo $this->Session->flash(); ?>
        <?php echo $content_for_layout; ?>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 2.4.0
    </div>
    <strong>Copyright &copy; 2014-2016 <a href="https://adminlte.io">Almsaeed Studio</a>.</strong> All rights
    reserved.
  </footer>
</div>
<!-- ./wrapper -->

<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<?php echo $this->Html->script('/adminlte/bower_components/bootstrap/dist/js/bootstrap.min'); ?>
<!-- daterangepicker -->
<?php echo $this->Html->script('/adminlte/bower_components/moment/min/moment.min'); ?>
<?php echo $this->Html->script('/adminlte/bower_components/bootstrap-daterangepicker/daterangepicker'); ?>
<!-- datepicker -->
<?php echo $this->Html->script('/adminlte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min'); ?>
<!-- Slimscroll -->
<?php echo $this->Html->script('/adminlte/bower_components/jquery-slimscroll/jquery.slimscroll.min'); ?>
<!-- FastClick -->
<?php echo $this->Html->script('/adminlte/bower_components/fastclick/lib/fastclick'); ?>
<!-- AdminLTE App -->
<?php echo $this->Html->script('/adminlte/dist/js/adminlte.min'); ?>

<?php echo $this->fetch('include_foot'); ?>


<?php echo $this->Js->writeBuffer(); ?>

</body>
</html>
