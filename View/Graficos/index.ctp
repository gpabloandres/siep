
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
    /* Remove the jumbotron's default bottom margin */ 
     .jumbotron {
      margin-bottom: 5;
      margin-top: -45; 
      padding-bottom: 5px;
      padding-top: 50px;
    }
  </style>
</head>
<body>
<div class="jumbotron">
  <div class="container text-center">
  <hr>  
  <h3><i class= "glyphicon glyphicon-dashboard"></i> TABLERO 2019 | <?php echo $centroNombre; ?></h3>      
    <!--<p>Aquí podríamos indicar AVISOS SEMANALES.</p>-->
  </div>
</div>
<div class="container">    
  <div class="row">
    <div class="col-sm-4">
      <div class="panel panel-primary">
        <div class="panel-heading">
          <div class="text-left">
            <span class="link"><?php echo $this->Html->link('<i class= "glyphicon glyphicon-user"></i> <strong> USUARIOS | ACTIVOS</strong>', array('controller' => 'graficos', 'action' => 'index'), array('class' => 'btn btn-primary', 'escape' => false)); ?><span class="badge"> | <?php echo $usuarios?></span></span>
          </div>
        </div>
        <div class="panel-body">
          <?php
            foreach($empleados as $empleado => $nombres) {
              echo '<i class= "glyphicon glyphicon-user"></i>'.' '.$nombres."<br>";
            }
          ?>
        </div>  
      </div>
    </div>
    <div class="col-sm-4"> 
      <div class="panel panel-primary">
        <div class="panel-heading">
          <div class="text-left">
            <span class="link"><?php echo $this->Html->link('<i class= "glyphicon glyphicon-home"></i> <strong> SECCIONES</strong>', array('controller' => 'cursos', 'action' => 'index/turno:/anio:/division:/tipo:/status:1'), array('class' => 'btn btn-primary', 'target' => '_blank', 'escape' => false)); ?><span class="badge"> | <?php echo $cursos?></span></span>
          </div>
        </div>  
          <div class="panel-body">
            <!-- INICIO: Recuento para secciones de INICIAL.-->
						<?php if($nivelCentro == 'Común - Inicial'): ?>
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th><span class="link"><?php echo $this->Html->link('3s', array('controller' => 'cursos', 'action' => 'index/turno:/anio:Sala de 3 años/division:/tipo:Independiente'), array('class' => 'link', 'target' => '_blank', 'escape' => false)); ?></th>
                    <th><span class="link"><?php echo $this->Html->link('3s Mul.', array('controller' => 'cursos', 'action' => 'index/turno:/anio:Sala de 3 años/division:/tipo:Múltiple'), array('class' => 'link', 'target' => '_blank', 'escape' => false)); ?></th>
                    <th><span class="link"><?php echo $this->Html->link('4s', array('controller' => 'cursos', 'action' => 'index/turno:/anio:Sala de 4 años/division:/tipo:Independiente'), array('class' => 'link', 'target' => '_blank', 'escape' => false)); ?></th>
                    <th><span class="link"><?php echo $this->Html->link('4s Mul.', array('controller' => 'cursos', 'action' => 'index/turno:/anio:Sala de 4 años/division:/tipo:Múltiple'), array('class' => 'link', 'target' => '_blank', 'escape' => false)); ?></th>
                    <th><span class="link"><?php echo $this->Html->link('5s', array('controller' => 'cursos', 'action' => 'index/turno:/anio:Sala de 5 años/division:/tipo:Independiente'), array('class' => 'link', 'target' => '_blank', 'escape' => false)); ?></th>
                  <?php if ($nivelCentro == 'Común - Secundario'): ?>
                    <th><span class="link"><?php echo $this->Html->link('7ºs', array('controller' => 'cursos', 'action' => 'index/turno:/anio:7mo /division:/tipo:Independiente'), array('class' => 'link', 'target' => '_blank', 'escape' => false)); ?></th>
                  <?php endif; ?>
                  </tr>
                </thead>
                <tbody>
                  <td><?php echo $cursosTresAnios; ?></td>
                  <td><?php echo $cursosTresAniosMultiple; ?></td>
                  <td><?php echo $cursosCuatroAnios; ?></td>
                  <td><?php echo $cursosCuatroAniosMultiple; ?></td>
                  <td><?php echo $cursosCincoAnios; ?></td>
                </tbody>
              </table>
            <?php endif; ?>
						<!-- FIN: Recuento para secciones de INICIAL.-->  
            <!-- INICIO: Recuento para secciones de PRIMARIO Y SECUNDARIO.-->
						<?php if($nivelCentro == 'Común - Primario' || $nivelCentro == 'Común - Secundario' || $nivelCentro == 'Adultos - Primario' || $nivelCentro == 'Adultos - Secundario'): ?>
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th><span class="link"><?php echo $this->Html->link('1ºs', array('controller' => 'cursos', 'action' => 'index/turno:/anio:1ro /division:/tipo:Independiente'), array('class' => 'link', 'target' => '_blank', 'escape' => false)); ?></th>
                    <th><span class="link"><?php echo $this->Html->link('2ºs', array('controller' => 'cursos', 'action' => 'index/turno:/anio:2do /division:/tipo:Independiente'), array('class' => 'link', 'target' => '_blank', 'escape' => false)); ?></th>
                    <th><span class="link"><?php echo $this->Html->link('3ºs', array('controller' => 'cursos', 'action' => 'index/turno:/anio:3ro /division:/tipo:Independiente'), array('class' => 'link', 'target' => '_blank', 'escape' => false)); ?></th>
                  <?php if ($nivelCentro == 'Común - Primario' || $nivelCentro == 'Común - Secundario'): ?>
                    <th><span class="link"><?php echo $this->Html->link('4ºs', array('controller' => 'cursos', 'action' => 'index/turno:/anio:4to /division:/tipo:Independiente'), array('class' => 'link', 'target' => '_blank', 'escape' => false)); ?></th>
                    <th><span class="link"><?php echo $this->Html->link('5ºs', array('controller' => 'cursos', 'action' => 'index/turno:/anio:5to /division:/tipo:Independiente'), array('class' => 'link', 'target' => '_blank', 'escape' => false)); ?></th>
                    <th><span class="link"><?php echo $this->Html->link('6ºs', array('controller' => 'cursos', 'action' => 'index/turno:/anio:6to /division:/tipo:Independiente'), array('class' => 'link', 'target' => '_blank', 'escape' => false)); ?></th>
                  <?php endif; ?>
                  <?php if ($nivelCentro == 'Común - Secundario'): ?>
                    <th><span class="link"><?php echo $this->Html->link('7ºs', array('controller' => 'cursos', 'action' => 'index/turno:/anio:7mo /division:/tipo:Independiente'), array('class' => 'link', 'target' => '_blank', 'escape' => false)); ?></th>
                  <?php endif; ?>
                  <?php if ($nivelCentro == 'Adultos - Primario'): ?>
                    <th><span class="link"><?php echo $this->Html->link('Alfabetización', array('controller' => 'cursos', 'action' => 'index/turno:/anio:ALFABETIZACIÓN /division:/tipo:Múltiple'), array('class' => 'link', 'target' => '_blank', 'escape' => false)); ?></th>
                    <th><span class="link"><?php echo $this->Html->link('CAP', array('controller' => 'cursos', 'action' => 'index/turno:/anio:CAP /division:/'), array('class' => 'link', 'target' => '_blank', 'escape' => false)); ?></th>
                  <?php endif; ?>
                  </tr>
                </thead>
                <tbody>
                  <td><?php echo $cursosPrimerosAnios; ?></td>
                  <td><?php echo $cursosSegundosAnios; ?></td>
                  <td><?php echo $cursosTercerosAnios; ?></td>
                <?php if ($nivelCentro == 'Común - Primario' || $nivelCentro == 'Común - Secundario'): ?>
                  <td><?php echo $cursosCuartosAnios; ?></td>
                  <td><?php echo $cursosQuintosAnios; ?></td>
                  <td><?php echo $cursosSextosAnios; ?></td>
                <?php endif; ?>
                <?php if ($nivelCentro == 'Común - Secundario'): ?>
                  <td><?php echo $cursosSeptimosAnios; ?></td>
                <?php endif; ?>
                <?php if ($nivelCentro == 'Adultos - Primario'): ?>
                  <td><?php echo $cursosAlfabetizacion; ?></td>
                  <td><?php echo $cursosCAP; ?></td>
                <?php endif; ?>
                </tbody>
              </table>
            <?php endif; ?>
            <!-- FIN: Recuento para secciones de PRIMARIO.-->
          </div>
        </div>
      </div>
    <div class="col-sm-4">
      <div class="panel panel-primary">
        <div class="panel-heading">
          <div class="text-left">
            <span class="link"><?php echo $this->Html->link('<i class= "glyphicon glyphicon-list-alt"></i> <strong> MATRÍCULA - ALTAS</strong>', array('controller' => 'cursos_inscripcions', 'action' => 'index/ciclo_id:6/turno:/anio:/division:/estado_inscripcion:CONFIRMADA'), array('class' => 'btn btn-primary', 'target' => '_blank', 'escape' => false)); ?><span class="badge"> | <?php echo $matricula?></span></span>
          </div>
        </div>
        <div class="panel-body">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th><span class="link"><?php echo $this->Html->link('Por Hermano', array('controller' => 'cursos_inscripcions', 'action' => 'index/ciclo_id:6/turno:/anio:/division:/estado_inscripcion:CONFIRMADA/tipo_inscripcion:Hermano%20de%20alumno%20regular'), array('class' => 'link', 'target' => '_blank', 'escape' => false)); ?></th>
                <th><span class="link"><?php echo $this->Html->link('Común', array('controller' => 'cursos_inscripcions', 'action' => 'index/ciclo_id:6/turno:/anio:/division:/estado_inscripcion:CONFIRMADA/tipo_inscripcion:Com%C3%BAn'), array('class' => 'link', 'target' => '_blank', 'escape' => false)); ?></th>
                <th><span class="link"><?php echo $this->Html->link('Situación Social', array('controller' => 'cursos_inscripcions', 'action' => 'index/ciclo_id:6/turno:/anio:/division:/estado_inscripcion:CONFIRMADA/tipo_inscripcion:Situaci%C3%B3n%20social'), array('class' => 'link', 'target' => '_blank', 'escape' => false)); ?></th>
                <th><span class="link"><?php echo $this->Html->link('Pase (Entrada)', array('controller' => 'cursos_inscripcions', 'action' => 'index/ciclo_id:6/turno:/anio:/division:/estado_inscripcion:CONFIRMADA/tipo_inscripcion:Pase'), array('class' => 'link', 'target' => '_blank', 'escape' => false)); ?></th>
              </tr>
            </thead>
            <tbody>
              <td><?php echo $inscripcionesPorHermano; ?></td>
              <td><?php echo $inscripcionesComunes; ?></td>
              <td><?php echo $inscripcionesPorSituacionSocial; ?></td>
              <td><?php echo $inscripcionesPorPase; ?></td>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<hr>
<div class="container">    
  <div class="row">
    <div class="col-sm-4"> 
      <div class="panel panel-primary">
        <div class="panel-heading">
          <div class="text-left">
            <span class="link"><?php echo $this->Html->link('<i class= "glyphicon glyphicon-list-alt"></i> <strong> MATRÍCULA - BAJAS</strong>', array('controller' => 'cursos_inscripcions', 'action' => 'index/ciclo_id:6/turno:/anio:/division:/estado_inscripcion:BAJA/legajo_nro:SINVACANTE'), array('class' => 'btn btn-primary', 'target' => '_blank', 'escape' => false)); ?><span class="badge"> | <?php echo $matriculaBaja?></span></span>
          </div>
        </div>
        <div class="panel-body">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th><span class="link"><?php echo $this->Html->link('Salido con pase', array('controller' => 'cursos_inscripcions', 'action' => 'index/ciclo_id:6/turno:/anio:/division:/estado_inscripcion:BAJA/tipo_baja:Salido%20con%20pase'), array('class' => 'link', 'target' => '_blank', 'escape' => false)); ?></th>
                <th><span class="link"><?php echo $this->Html->link('Salido sin pase', array('controller' => 'cursos_inscripcions', 'action' => 'index/ciclo_id:6/turno:/anio:/division:/estado_inscripcion:BAJA/tipo_baja:Salido%20sin%20pase'), array('class' => 'link', 'target' => '_blank', 'escape' => false)); ?></th>
                <th><span class="link"><?php echo $this->Html->link('Pérdida de regul.', array('controller' => 'cursos_inscripcions', 'action' => 'index/ciclo_id:6/turno:/anio:/division:/estado_inscripcion:BAJA/tipo_baja:P%C3%A9rdida%20de%20regularidad'), array('class' => 'link', 'target' => '_blank', 'escape' => false)); ?></th>
                <th><span class="link"><?php echo $this->Html->link('Fallec.', array('controller' => 'cursos_inscripcions', 'action' => 'index/ciclo_id:6/turno:/anio:/division:/estado_inscripcion:BAJA/tipo_baja:Fallecimiento'), array('class' => 'link', 'target' => '_blank', 'escape' => false)); ?></th>
                <th><span class="link"><?php echo $this->Html->link('Sin espec.', array('controller' => 'cursos_inscripcions', 'action' => 'index/ciclo_id:6/turno:/anio:/division:/estado_inscripcion:BAJA/tipo_baja:Sin%20especificar'), array('class' => 'link', 'target' => '_blank', 'escape' => false)); ?></th>
              </tr>
            </thead>
            <tbody>
              <td><?php echo $bajasSalidosConPase; ?></td>
              <td><?php echo $bajasSalidosSinPase; ?></td>
              <td><?php echo $bajasPerdidaRegularidad; ?></td>
              <td><?php echo $bajasFallecimiento; ?></td>
              <td><?php echo $bajasSinEspecificar; ?></td>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <div class="col-sm-4"> 
      <div class="panel panel-primary">
        <div class="panel-heading">
          <div class="text-left">
            <span class="link"><?php echo $this->Html->link('<i class= "glyphicon glyphicon-list-alt"></i> <strong> MATRÍCULA - EGRESOS | 2018</strong>', array('controller' => 'cursos_inscripcions', 'action' => 'index/ciclo_id:4/turno:/anio:/division:/estado_inscripcion:EGRESO'), array('class' => 'btn btn-primary', 'target' => '_blank', 'escape' => false)); ?><span class="badge"> | <?php echo $matriculaEgresos?></span></span>
          </div>
        </div>
        <div class="panel-body">
        </div>  
      </div>
    </div>
    <div class="col-sm-4"> 
      <div class="panel panel-primary">
        <div class="panel-heading">
          <div class="text-left">
            <span class="link"><?php echo $this->Html->link('<i class= "glyphicon glyphicon-list-alt"></i> <strong> MATRÍCULA - PASES</strong>', array('controller' => 'graficos', 'action' => 'index'), array('class' => 'btn btn-primary',/* 'target' => '_blank',*/ 'escape' => false)); ?><span class="badge"> | <?php echo $matriculaPases?></span></span>
          </div>
        </div>
        <div class="panel-body">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th><span class="link"><?php echo $this->Html->link('Salido con pase', array('controller' => 'cursos_inscripcions', 'action' => 'index/ciclo_id:6/turno:/anio:/division:/estado_inscripcion:BAJA/tipo_baja:Salido%20con%20pase'), array('class' => 'link', 'target' => '_blank', 'escape' => false)); ?></th>
                <th><span class="link"><?php echo $this->Html->link('Pase (Entrada)', array('controller' => 'cursos_inscripcions', 'action' => 'index/ciclo_id:6/turno:/anio:/division:/estado_inscripcion:CONFIRMADA/tipo_inscripcion:Pase'), array('class' => 'link', 'target' => '_blank', 'escape' => false)); ?></th>
              </tr>
            </thead>
            <tbody>
              <td><?php echo $bajasSalidosConPase; ?></td>
              <td><?php echo $inscripcionesPorPase; ?></td>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<hr>
<div class="container">    
  <div class="row">
  <?php if ($current_user['puesto'] == 'Dirección Colegio Secundario'): ?>
    <div class="col-sm-4"> 
      <div class="panel panel-primary">
        <div class="panel-heading">
          <div class="text-left">
            <span class="link"><?php echo $this->Html->link('<i class= "glyphicon glyphicon-education"></i> <strong> TITULACIONES</strong>', array('controller' => 'titulacions', 'action' => 'index'), array('class' => 'btn btn-primary', 'target' => '_blank', 'escape' => false)); ?><span class="badge"> | <?php echo $titulacionesIdActivas?></span></span>
          </div>
        </div>
        <div class="panel-body">
        </div>  
      </div>
    </div>
    <?php endif; ?>
    <div class="col-sm-4"> 
      <div class="panel panel-primary">
        <div class="panel-heading">
          <div class="text-left">
            <span class="link"><?php echo $this->Html->link('<i class= "glyphicon glyphicon-home"></i> <strong> PROMOCIONES</strong>', array('controller' => 'promocion', 'action' => 'view'), array('class' => 'btn btn-primary', 'target' => '_blank', 'escape' => false)); ?><span class="badge"> | <?php// echo $matriculaPromociones?></span></span>
          </div>
        </div>  
        <div class="panel-body">
          <?php /*
          <!-- INICIO: Recuento para secciones de INICIAL.-->
          <?php if($nivelCentro == 'Común - Inicial'): ?>
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th><span class="link"><?php echo $this->Html->link('3s', array('controller' => 'cursos', 'action' => 'index/turno:/anio:Sala de 3 años/division:/tipo:Independiente'), array('class' => 'link', 'target' => '_blank', 'escape' => false)); ?></th>
                  <th><span class="link"><?php echo $this->Html->link('3s Mul.', array('controller' => 'cursos', 'action' => 'index/turno:/anio:Sala de 3 años/division:/tipo:Múltiple'), array('class' => 'link', 'target' => '_blank', 'escape' => false)); ?></th>
                  <th><span class="link"><?php echo $this->Html->link('4s', array('controller' => 'cursos', 'action' => 'index/turno:/anio:Sala de 4 años/division:/tipo:Independiente'), array('class' => 'link', 'target' => '_blank', 'escape' => false)); ?></th>
                  <th><span class="link"><?php echo $this->Html->link('4s Mul.', array('controller' => 'cursos', 'action' => 'index/turno:/anio:Sala de 4 años/division:/tipo:Múltiple'), array('class' => 'link', 'target' => '_blank', 'escape' => false)); ?></th>
                  <th><span class="link"><?php echo $this->Html->link('5s', array('controller' => 'cursos', 'action' => 'index/turno:/anio:Sala de 5 años/division:/tipo:Independiente'), array('class' => 'link', 'target' => '_blank', 'escape' => false)); ?></th>
                <?php if ($nivelCentro == 'Común - Secundario'): ?>
                  <th><span class="link"><?php echo $this->Html->link('7ºs', array('controller' => 'cursos', 'action' => 'index/turno:/anio:7mo /division:/tipo:Independiente'), array('class' => 'link', 'target' => '_blank', 'escape' => false)); ?></th>
                <?php endif; ?>
                </tr>
              </thead>
              <tbody>
                <td><?php echo $cursosTresAnios; ?></td>
                <td><?php echo $cursosTresAniosMultiple; ?></td>
                <td><?php echo $cursosCuatroAnios; ?></td>
                <td><?php echo $cursosCuatroAniosMultiple; ?></td>
                <td><?php echo $cursosCincoAnios; ?></td>
              </tbody>
            </table>
          <?php endif; ?>
          <!-- FIN: Recuento para secciones de INICIAL.-->  
          <!-- INICIO: Recuento para secciones de PRIMARIO Y SECUNDARIO.-->
          <?php if($nivelCentro == 'Común - Primario' || $nivelCentro == 'Común - Secundario'): ?>
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th><span class="link"><?php echo $this->Html->link('1ºs', array('controller' => 'promocion', 'action' => 'view?anio=1ro&turno='), array('class' => 'link', 'target' => '_blank', 'escape' => false)); ?></th>
                  <th><span class="link"><?php echo $this->Html->link('2ºs', array('controller' => 'promocion', 'action' => 'view?anio=2do&turno='), array('class' => 'link', 'target' => '_blank', 'escape' => false)); ?></th>
                  <th><span class="link"><?php echo $this->Html->link('3ºs', array('controller' => 'promocion', 'action' => 'view?anio=3ro&turno='), array('class' => 'link', 'target' => '_blank', 'escape' => false)); ?></th>
                  <th><span class="link"><?php echo $this->Html->link('4ºs', array('controller' => 'promocion', 'action' => 'view?anio=4to&turno='), array('class' => 'link', 'target' => '_blank', 'escape' => false)); ?></th>
                  <th><span class="link"><?php echo $this->Html->link('5ºs', array('controller' => 'promocion', 'action' => 'view?anio=5to&turno='), array('class' => 'link', 'target' => '_blank', 'escape' => false)); ?></th>
                  <th><span class="link"><?php echo $this->Html->link('6ºs', array('controller' => 'promocion', 'action' => 'view?anio=6to&turno='), array('class' => 'link', 'target' => '_blank', 'escape' => false)); ?></th>
                <?php if ($nivelCentro == 'Común - Secundario'): ?>
                  <th><span class="link"><?php echo $this->Html->link('7ºs', array('controller' => 'cursos', 'action' => 'index/turno:/anio:7mo /division:/tipo:Independiente'), array('class' => 'link', 'target' => '_blank', 'escape' => false)); ?></th>
                <?php endif; ?>
                </tr>
              </thead>
              <tbody>
                <td><?php echo $cursosPrimerosAnios; ?></td>
                <td><?php echo $cursosSegundosAnios; ?></td>
                <td><?php echo $cursosTercerosAnios; ?></td>
                <td><?php echo $cursosCuartosAnios; ?></td>
                <td><?php echo $cursosQuintosAnios; ?></td>
                <td><?php echo $cursosSextosAnios; ?></td>
              <?php if ($nivelCentro == 'Común - Secundario'): ?>
                <td><?php echo $cursosSeptimosAnios; ?></td>
              <?php endif; ?>
              </tbody>
            </table>
          <?php endif; ?>
          <!-- FIN: Recuento para secciones de PRIMARIO.-->
          */?>
        </div>
      </div>
    </div>
    <div class="col-sm-4"> 
      <div class="panel panel-primary">
        <div class="panel-heading">
          <div class="text-left">
            <span class="link"><?php echo $this->Html->link('<i class= "glyphicon glyphicon-home"></i> <strong> REPITENCIAS</strong>', array('controller' => 'repitentes', 'action' => 'view'), array('class' => 'btn btn-primary', 'target' => '_blank', 'escape' => false)); ?><span class="badge"> | <?php// echo $matriculaPromociones?></span></span>
          </div>
        </div>  
          <div class="panel-body">
            <?php /*
            <!-- INICIO: Recuento para secciones de INICIAL.-->
						<?php if($nivelCentro == 'Común - Inicial'): ?>
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th><span class="link"><?php echo $this->Html->link('3s', array('controller' => 'cursos', 'action' => 'index/turno:/anio:Sala de 3 años/division:/tipo:Independiente'), array('class' => 'link', 'target' => '_blank', 'escape' => false)); ?></th>
                    <th><span class="link"><?php echo $this->Html->link('3s Mul.', array('controller' => 'cursos', 'action' => 'index/turno:/anio:Sala de 3 años/division:/tipo:Múltiple'), array('class' => 'link', 'target' => '_blank', 'escape' => false)); ?></th>
                    <th><span class="link"><?php echo $this->Html->link('4s', array('controller' => 'cursos', 'action' => 'index/turno:/anio:Sala de 4 años/division:/tipo:Independiente'), array('class' => 'link', 'target' => '_blank', 'escape' => false)); ?></th>
                    <th><span class="link"><?php echo $this->Html->link('4s Mul.', array('controller' => 'cursos', 'action' => 'index/turno:/anio:Sala de 4 años/division:/tipo:Múltiple'), array('class' => 'link', 'target' => '_blank', 'escape' => false)); ?></th>
                    <th><span class="link"><?php echo $this->Html->link('5s', array('controller' => 'cursos', 'action' => 'index/turno:/anio:Sala de 5 años/division:/tipo:Independiente'), array('class' => 'link', 'target' => '_blank', 'escape' => false)); ?></th>
                  <?php if ($nivelCentro == 'Común - Secundario'): ?>
                    <th><span class="link"><?php echo $this->Html->link('7ºs', array('controller' => 'cursos', 'action' => 'index/turno:/anio:7mo /division:/tipo:Independiente'), array('class' => 'link', 'target' => '_blank', 'escape' => false)); ?></th>
                  <?php endif; ?>
                  </tr>
                </thead>
                <tbody>
                  <td><?php echo $cursosTresAnios; ?></td>
                  <td><?php echo $cursosTresAniosMultiple; ?></td>
                  <td><?php echo $cursosCuatroAnios; ?></td>
                  <td><?php echo $cursosCuatroAniosMultiple; ?></td>
                  <td><?php echo $cursosCincoAnios; ?></td>
                </tbody>
              </table>
            <?php endif; ?>
						<!-- FIN: Recuento para secciones de INICIAL.-->  
            <!-- INICIO: Recuento para secciones de PRIMARIO Y SECUNDARIO.-->
						<?php if($nivelCentro == 'Común - Primario' || $nivelCentro == 'Común - Secundario'): ?>
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th><span class="link"><?php echo $this->Html->link('1ºs', array('controller' => 'promocion', 'action' => 'view?anio=1ro&turno='), array('class' => 'link', 'target' => '_blank', 'escape' => false)); ?></th>
                    <th><span class="link"><?php echo $this->Html->link('2ºs', array('controller' => 'promocion', 'action' => 'view?anio=2do&turno='), array('class' => 'link', 'target' => '_blank', 'escape' => false)); ?></th>
                    <th><span class="link"><?php echo $this->Html->link('3ºs', array('controller' => 'promocion', 'action' => 'view?anio=3ro&turno='), array('class' => 'link', 'target' => '_blank', 'escape' => false)); ?></th>
                    <th><span class="link"><?php echo $this->Html->link('4ºs', array('controller' => 'promocion', 'action' => 'view?anio=4to&turno='), array('class' => 'link', 'target' => '_blank', 'escape' => false)); ?></th>
                    <th><span class="link"><?php echo $this->Html->link('5ºs', array('controller' => 'promocion', 'action' => 'view?anio=5to&turno='), array('class' => 'link', 'target' => '_blank', 'escape' => false)); ?></th>
                    <th><span class="link"><?php echo $this->Html->link('6ºs', array('controller' => 'promocion', 'action' => 'view?anio=6to&turno='), array('class' => 'link', 'target' => '_blank', 'escape' => false)); ?></th>
                  <?php if ($nivelCentro == 'Común - Secundario'): ?>
                    <th><span class="link"><?php echo $this->Html->link('7ºs', array('controller' => 'cursos', 'action' => 'index/turno:/anio:7mo /division:/tipo:Independiente'), array('class' => 'link', 'target' => '_blank', 'escape' => false)); ?></th>
                  <?php endif; ?>
                  </tr>
                </thead>
                <tbody>
                  <td><?php echo $cursosPrimerosAnios; ?></td>
                  <td><?php echo $cursosSegundosAnios; ?></td>
                  <td><?php echo $cursosTercerosAnios; ?></td>
                  <td><?php echo $cursosCuartosAnios; ?></td>
                  <td><?php echo $cursosQuintosAnios; ?></td>
                  <td><?php echo $cursosSextosAnios; ?></td>
                <?php if ($nivelCentro == 'Común - Secundario'): ?>
                  <td><?php echo $cursosSeptimosAnios; ?></td>
                <?php endif; ?>
                </tbody>
              </table>
            <?php endif; ?>
            <!-- FIN: Recuento para secciones de PRIMARIO.-->
            */?>
          </div>
        </div>
      </div>
    </div>
  </div>  
</div>  
</body>
</html>