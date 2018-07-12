<?php echo $this->Html->script(array('acordeon', 'slider')); ?>
<?php echo $this->Html->css('slider'); ?>
<!-- start main -->
<div class="TituloSec">Unidad: <?php echo ($materia['Materia']['alia']); ?></div>
<div id="ContenidoSec">
<div class="row">
   <div class="col-md-8">	
	 <div class="unit">
 		<div class="row perfil">
		  <div class="col-md-4 col-sm-6 col-xs-8">	
			<b><?php echo __('Nombre:'); ?></b>
			<?php echo ($materia['Materia']['nombre']); ?></p>

			<b><?php echo __('Diseño Curricular:'); ?></b>
			<?php echo $this->Html->link(($disenocurriculars[$materia['Materia']['disenocurricular_id']]), array('action' => 'view', 'controller' => 'disenocurriculars', $materia['Materia']['disenocurricular_id'])); ?></p>
            
            <b><?php echo __('Sección:'); ?></b>
			<?php echo ($this->Html->link($materia['Curso']['nombre_completo_curso'], array('controller' => 'cursos', 'action' => 'view', $materia['Curso']['id']))); ?></p>
            
            <b><?php echo __('Campo de formación:'); ?></b>
			<?php echo ($materia['Materia']['campo_formacion']); ?></p>

			<b><?php echo __('Formato:'); ?></b>
			<?php echo ($materia['Materia']['formato']); ?></p>

			<b><?php echo __('Obligatoriedad:'); ?></b>
			<?php echo ($materia['Materia']['obligatoriedad']); ?></p>

			<b><?php echo __('Dictado:'); ?></b>
			<?php echo ($materia['Materia']['dictado']); ?></p>

			<!--<b><?php echo __('Contenido:'); ?></b>
			<?php echo $this->Html->link('View File', '../files/materias/'.$materia['Materia']['contenido'], array('class' => 'button', 'target' => '_blank')); ?></p>-->
            
  </div><div class="col-md-4 col-sm-6 col-xs-8">	

			<b><?php echo __('Carga horaria en:'); ?></b>
			<?php echo ($materia['Materia']['carga_horaria_en']); ?></p>

			<b><?php echo __('Carga horaria semanal:'); ?></b>
			<?php echo ($materia['Materia']['carga_horaria_semanal']); ?></p>

			<b><?php echo __('Duración en:'); ?></b>
			<?php echo ($materia['Materia']['duracion_en']); ?></p>

			<b><?php echo __('Duración:'); ?></b>
			<?php echo ($materia['Materia']['duracion']); ?></p>

			<b><?php echo __('Escala numérica:'); ?></b>
			<?php echo ($materia['Materia']['escala_numerica']); ?></p>

			<b><?php echo __('Nota mínima:'); ?></b>
			<?php echo ($materia['Materia']['nota_minima']); ?></p>

            <!--<b><?php echo __('Cargo:'); ?></b>
			<?php echo ($this->Html->link($materia['Cargo']['nombre'], array('controller' => 'cargos', 'action' => 'view', $materia['Cargo']['nombre']))); ?></p>
		  </div>-->
 	  </div>
    </div>
 </div>
</div>
<div class="col-md-4">
 	<div class="unit">
 		<div class="subtitulo">Opciones</div>
 			<div class="opcion"><?php echo $this->Html->link(__('Listar Unidades Curriculares'), array('action' => 'index')); ?></div>
 			<?php if(($current_user['role'] == 'superadmin') || ($current_user['role'] == 'admin')): ?>
			<div class="opcion"><?php echo $this->Html->link(__('Editar'), array('action' => 'edit', $materia['Materia']['id'])); ?></div>
			<div class="opcion"><?php echo $this->Html->link(__('Borrar'), array('action' => 'delete', $materia['Materia']['id']), null, sprintf(__('Esta seguro de borrar la materia %s?'), $materia['Cargo']['nombre'])); ?></div>
			<?php endif; ?>
			<!--<div class="opcion"><?php echo $this->Html->link(__('Agregar Horario'), array('controller' => 'horarios', 'action' => 'add')); ?></div>-->
    	</div>
  	</div>
</div>
 <!-- end main -->
<!--<div class="related">
	<h3><?php echo __('Ciclos Relacionados');?></h3>
	<?php if (!empty($materia['Ciclo'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Ciclo'); ?></th>
		<th><?php echo __('FechaInicio'); ?></th>
		<th><?php echo __('FechaFinal'); ?></th>
		<th><?php echo __('PrimerCuatrimestre'); ?></th>
		<th><?php echo __('SegundoCuatrimestre'); ?></th>
		<th><?php echo __('Observaciones'); ?></th>
		<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($materia['Ciclo'] as $ciclo):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $ciclo['id'];?></td>
			<td><?php echo $ciclo['ciclo'];?></td>
			<td><?php echo $ciclo['fechaInicio'];?></td>
			<td><?php echo $ciclo['fechaFinal'];?></td>
			<td><?php echo $ciclo['primerCuatrimestre'];?></td>
			<td><?php echo $ciclo['segundoCuatrimestre'];?></td>
			<td><?php echo $ciclo['observaciones'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('Ver'), array('controller' => 'ciclos', 'action' => 'view', $ciclo['id'])); ?>
				<?php echo $this->Html->link(__('Editar'), array('controller' => 'ciclos', 'action' => 'edit', $ciclo['id'])); ?>
				<?php echo $this->Html->link(__('Borrar'), array('controller' => 'ciclos', 'action' => 'delete', $ciclo['id']), null, sprintf(__('Are you sure you want to delete # %s?'), $ciclo['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Ciclo'), array('controller' => 'ciclos', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>-->
<!-- Horarios Relacionados  
<div id="click_01" class="titulo_acordeon">Horarios Relacionados <span class="caret"></span></div>
<div id="acordeon_01">
   <div class="table-responsive">
     <table class="table table-bordered table-hover table-condensed">
       <thead>
		<tr>
			<th><?php echo $this->Paginator->sort('ciclo_id', 'Ciclo');?></th>
            <th><?php echo $this->Paginator->sort('materia_id', 'Espacio');?></th>
            <th><?php echo $this->Paginator->sort('dia', 'Día');?></th>
			<th><?php echo $this->Paginator->sort('horaInicio', 'Inicio');?></th>
			<th><?php echo $this->Paginator->sort('horaFin', 'Finaliza');?></th>
			<th>Acciones</th>
		</tr>
	</thead>
	<tbody>						
		<?php $count=0; ?>
		<?php foreach($materia['Horario'] as $horario): ?>				
		<?php $count ++;?>
		<?php if($count % 2): echo '<tr>'; else: echo '<tr class="zebra">' ?>
		<?php endif; ?>
			<td style="text-align: center;"><?php echo ($this->Html->link($cicloNombre[$horario['ciclo_id']], array('controller' => 'ciclos', 'action' => 'view', $horario['ciclo_id']))); ?></td>
            <td style="text-align: center;"><?php echo ($this->Html->link($materiaAlia[$horario['materia_id']], array('controller' => 'materias', 'action' => 'view', $horario['materia_id']))); ?></td>
            <td style="text-align: center;"><?php echo $horario['dia']; ?></td>
			<td style="text-align: center;"><?php echo $horario['horaInicio']; ?></td>
            <td style="text-align: center;"><?php echo $horario['horaFin']; ?></td>
           	<td >
            <?php echo $this->Html->link(__('<i class= "glyphicon glyphicon-edit"></i>'), array('controller' => 'horarios', 'action' => 'edit', $horario['id']), array('class' => 'btn btn-warning','escape' => false)); ?>
			<?php echo $this->Html->link(__('<i class= "glyphicon glyphicon-eye-open"></i>'), array('controller' => 'horarios', 'action' => 'view', $horario['id']), array('class' => 'btn btn-success','escape' => false)); ?>
			<!--<?php echo $this->Html->link(__('Borrar'), array('controller' => 'horarios', 'action' => 'delete', $horario['id']), array('class' => 'btn btn-danger')); ?>
	        </td>
		</tr>
		<?php endforeach; ?>
		<?php unset($horario); ?>
	</tbody>
  </table>
 </div>
</div>
<!-- end Horarios Relacionados -->
<!-- Inscripciones Relacionadas -->
<div id="click_02" class="titulo_acordeon">Inscripciones Relacionadas <span class="caret"></span></div>
<div id="acordeon_02">
		<div class="row">
	<?php if (!empty($materia['Inscripcion'])):?>
  	<!-- Swiper -->
    <div class="swiper-container" style="height: 200px;">
        <div class="swiper-wrapper" >
	<?php foreach ($materia['Inscripcion'] as $inscripcion): ?>
	<div class="swiper-slide">
	<div class="col-md-6">
		<div class="unit">
			<?php echo '<b>Código inscripción:</b> '.$this->Html->link($inscripcion['legajo_nro'], array('controller' => 'inscripcions', 'action' => 'view', $inscripcion['id']));?><br>
			<?php echo '<b>Alumno:</b> '.($this->Html->link($alumnoNombre[$inscripcion['persona_id']], array('controller' => 'personas', 'action' => 'view', $inscripcion['persona_id'])));?><br>
            <?php echo '<b>Fecha_alta:</b> '.($this->Html->formatTime($inscripcion['fecha_alta']));?><br>
			<!--<?php echo '<b>Fecha_baja:</b> '.($this->Html->formatTime($inscripcion['fecha_baja']));?><br>
            <?php echo '<b>Fecha_egreso:</b> '.($this->Html->formatTime($inscripcion['fecha_egreso']));?><br>-->
            <hr>      
            <div class="text-right">
            <?php echo $this->Html->link(__('<i class= "glyphicon glyphicon-eye-open"></i>'), array('controller' => 'inscripcions', 'action' => 'view', $inscripcion['id']), array('class' => 'btn btn-success','escape' => false)); ?>
            <?php if(($current_user['role'] == 'superadmin') || ($current_user['role'] == 'admin')): ?>
            <?php echo $this->Html->link(__('<i class= "glyphicon glyphicon-edit"></i>'), array('controller' => 'inscripcions', 'action' => 'edit', $inscripcion['id']), array('class' => 'btn btn-warning','escape' =>false)); ?>
			<?php echo $this->Html->link(__('<i class= "glyphicon glyphicon-trash"></i>'), array('controller' => 'inscripcions', 'action' => 'delete', $inscripcion['id']), array('class' => 'btn btn-danger','escape' => false)); ?>
			<?php endif; ?>
            </div>
		</div>
	</div>
</div>
		<?php endforeach; ?>
			</div>
			        <!-- Add Pagination -->
        <div class="swiper-pagination"></div>
    </div>
    <!-- Include plugin after Swiper -->
		<?php else: echo '<div class="col-md-12"><div class="unit text-center">No se encuentran relaciones.</div></div>'; ?>
		<?php endif; ?>

        </div>
</div>
<!-- end Inscripciones Relacionados -->
<!-- Correlativas Relacionadas 
<div id="click_03" class="titulo_acordeon">Correlativas Relacionadas <span class="caret"></span></div>
<div id="acordeon_03">
		<div class="row">
	<?php if (!empty($materia['Correlativa'])):?>

  	<!-- Swiper 
    <div class="swiper-container" style="height: 200px;">
        <div class="swiper-wrapper" >
	<?php foreach ($materia['Correlativa'] as $correlativa): ?>
	<div class="swiper-slide">
	<div class="col-md-6">
		<div class="unit">
			<?php echo '<b>Alia:</b> '.$this->Html->link($correlativa['alia'], array('controller' => 'correlativas', 'action' => 'view', $correlativa['id']));?><br>
			<?php echo '<b>Tipo:</b> '.($this->Html->link($correlativa['tipo'], array('controller' => 'correlativas', 'action' => 'view', $correlativa['id'])));?><br>
            <div class="text-right">
            <?php echo $this->Html->link(__('<i class= "glyphicon glyphicon-edit"></i>'), array('controller' => 'correlativas', 'action' => 'edit', $correlativa['id']), array('class' => 'btn btn-warning','escape' =>false)); ?>
			<?php echo $this->Html->link(__('<i class= "glyphicon glyphicon-eye-open"></i>'), array('controller' => 'correlativas', 'action' => 'view', $correlativa['id']), array('class' => 'btn btn-success','escape' => false)); ?>
			<?php echo $this->Html->link(__('<i class= "glyphicon glyphicon-trash"></i>'), array('controller' => 'correlativas', 'action' => 'delete', $correlativa['id']), array('class' => 'btn btn-danger','escape' => false)); ?>
            </div>
		</div>
	</div>
</div>
		<?php endforeach; ?>
			</div>
			        <!-- Add Pagination 
        <div class="swiper-pagination"></div>
    </div>
    <!-- Include plugin after Swiper 
		<?php else: echo '<div class="col-md-12"><div class="unit text-center">No se encuentran relaciones.</div></div>'; ?>
		<?php endif; ?>

        </div>
</div>
<!-- end Correlativass Relacionadas -->
<!-- Alumnos Relacionados -->
<!--<div class="related">
	<h3><?php echo __('Alumnos Relacionados');?></h3>
	<?php if (!empty($materia['Alumno'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('PrimerNombre'); ?></th>
		<th><?php echo __('Apellido'); ?></th>
		<th><?php echo __('Dni'); ?></th>
		<th><?php echo __('Direccion'); ?></th>
		<th><?php echo __('Telefono'); ?></th>
		<th><?php echo __('Email'); ?></th>
		<th><?php echo __('Ciudad'); ?></th>
		<th><?php echo __('Centro Id'); ?></th>
		<th><?php echo __('Curso Id'); ?></th>
		<th class="actions"><?php echo __('Opciones');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($materia['Alumno'] as $alumno):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $alumno['id'];?></td>
			<td><?php echo $alumno['primerNombre'];?></td>
			<td><?php echo $alumno['apellido'];?></td>
			<td><?php echo $alumno['dni'];?></td>
			<td><?php echo $alumno['direccion'];?></td>
			<td><?php echo $alumno['telefono'];?></td>
			<td><?php echo $alumno['email'];?></td>
			<td><?php echo $alumno['ciudad'];?></td>
			<td><?php echo ($this->Html->link($alumno['centro_id'], array('controller' => 'centros', 'action' => 'view', $alumno['centro_id'])));?></td>
			<td><?php echo ($this->Html->link($alumno['curso_id'], array('controller' => 'cursos', 'action' => 'view', $alumno['curso_id'])));?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('Ver'), array('controller' => 'alumnos', 'action' => 'view', $alumno['id'])); ?>
				<?php echo $this->Html->link(__('Editar'), array('controller' => 'alumnos', 'action' => 'edit', $alumno['id'])); ?>
				<?php echo $this->Html->link(__('Borrar'), array('controller' => 'alumnos', 'action' => 'delete', $alumno['id']), null, sprintf(__('Are you sure you want to delete # %s?'), $alumno['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Alumno'), array('controller' => 'alumnos', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>-->
<!-- end Alumnos Relacionados -->
<!-- Calificaciones Relacionados -->
<!--<div class="related">
	<h3><?php echo __('Notas Relacionadas');?></h3>
	<?php if (!empty($materia['Nota'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Alumno Id'); ?></th>
		<th><?php echo __('Nota1Cuat1º'); ?></th>
		<th><?php echo __('Nota2Cuat1º'); ?></th>
		<th><?php echo __('PromCuat1º'); ?></th>
		<th><?php echo __('Nota1Cuat2º'); ?></th>
		<th><?php echo __('Nota2Cuat2º'); ?></th>
		<th><?php echo __('PromCuat2º'); ?></th>
		<th><?php echo __('PromTermino'); ?></th>
		<th><?php echo __('NotaDic'); ?></th>
		<th><?php echo __('NotaMar'); ?></th>
		<th><?php echo __('PromFinal'); ?></th>
		<th><?php echo __('Observaciones'); ?></th>
		<th><?php echo __('Materia Id'); ?></th>
		<th class="actions"><?php echo __('Opciones');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($materia['Nota'] as $nota):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $nota['id'];?></td>
			<td><?php echo ($this->Html->link($nota['alumno_id'], array('controller' => 'alumnos', 'action' => 'view', $nota['alumno_id'])));?></td>
			<td><?php echo $nota['notaPrimeraCuatPrimero'];?></td>
			<td><?php echo $nota['notaSegundaCuatPrimero'];?></td>
			<td><?php echo $nota['promCuatPrimero'];?></td>
			<td><?php echo $nota['notaPrimeraCuatSegundo'];?></td>
			<td><?php echo $nota['notaSegundaCuatSegundo'];?></td>
			<td><?php echo $nota['promCuatSegundo'];?></td>
			<td><?php echo $nota['promTermino'];?></td>
			<td><?php echo $nota['notaDic'];?></td>
			<td><?php echo $nota['notaMar'];?></td>
			<td><?php echo $nota['promFinal'];?></td>
			<td><?php echo $nota['observaciones'];?></td>
			<td><?php echo ($this->Html->link($nota['materia_id'], array('controller' => 'materias', 'action' => 'view', $nota['materia_id'])));?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('Ver'), array('controller' => 'notas', 'action' => 'view', $nota['id'])); ?>
				<?php echo $this->Html->link(__('Editar'), array('controller' => 'notas', 'action' => 'edit', $nota['id'])); ?>
				<?php echo $this->Html->link(__('Borrar'), array('controller' => 'notas', 'action' => 'delete', $nota['id']), null, sprintf(__('Are you sure you want to delete # %s?'), $nota['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Nota'), array('controller' => 'notas', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>-->
<!-- end Calificaciones Relacionados -->
<!-- Docentes Relacionados -->
<!--<div class="related">
	<h3><?php echo __('Docentes Relacionados');?></h3>
	<?php if (!empty($materia['Docente'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('PrimerNombre'); ?></th>
		<th><?php echo __('Apellido'); ?></th>
		<th><?php echo __('Dni'); ?></th>
		<th><?php echo __('Direccion'); ?></th>
		<th><?php echo __('Telefono'); ?></th>
		<th><?php echo __('Email'); ?></th>
		<th><?php echo __('Ciudad'); ?></th>
		<th class="actions"><?php echo __('Opciones');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($materia['Docente'] as $docente):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $docente['id'];?></td>
			<td><?php echo $docente['primerNombre'];?></td>
			<td><?php echo $docente['apellido'];?></td>
			<td><?php echo $docente['dni'];?></td>
			<td><?php echo $docente['direccion'];?></td>
			<td><?php echo $docente['telefono'];?></td>
			<td><?php echo $docente['email'];?></td>
			<td><?php echo $docente['ciudad'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('Ver'), array('controller' => 'docentes', 'action' => 'view', $docente['id'])); ?>
				<?php echo $this->Html->link(__('Editar'), array('controller' => 'docentes', 'action' => 'edit', $docente['id'])); ?>
				<?php echo $this->Html->link(__('Borrar'), array('controller' => 'docentes', 'action' => 'delete', $docente['id']), null, sprintf(__('Are you sure you want to delete # %s?'), $docente['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Docente'), array('controller' => 'docentes', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>-->
</div>

    <!-- Initialize Swiper -->
    <script>
    var swiper = new Swiper('.swiper-container', {
        pagination: '.swiper-pagination',
        paginationClickable: true,
    });
    </script>