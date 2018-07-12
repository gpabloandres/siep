<!-- app/View/Users/usuario.ctp -->
<div class="users form">
<!-- start main -->
<div class="TituloSec">Bienvenido a SIEP</div>
<div id="ContenidoSec">
    <!--<h1 style="font-weight: bold; color: red; text-decoration: underline;"> Página de usuario común</h1>-->
<!--<h1>Usuarios:</h1>
	<table>
	    <thead>
			<tr>
				<th><?php echo $this->Form->checkbox('all', array('name' => 'CheckAll',  'id' => 'CheckAll')); ?></th>
				<th><?php echo $this->Paginator->sort('username', 'Usuario');?>  </th>
				<th><?php echo $this->Paginator->sort('email', 'E-Mail');?></th>
				<th><?php echo $this->Paginator->sort('created', 'Creado');?></th>
				<th><?php echo $this->Paginator->sort('modified','Modificado');?></th>
				<th><?php echo $this->Paginator->sort('role','Rol');?></th>
				<th><?php echo $this->Paginator->sort('status','Estado');?></th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>						
			<?php $count=0; ?>
			<?php foreach($users as $user): ?>				
			<?php $count ++;?>
			<?php if($count % 2): echo '<tr>'; else: echo '<tr class="zebra">' ?>
			<?php endif; ?>
				<td><?php echo $this->Form->checkbox('User.id.'.$user['User']['id']); ?></td>
				<td><?php echo $this->Html->link( $user['User']['username']  ,   array('action'=>'edit', $user['User']['id']),array('escape' => false) );?></td>
				<td style="text-align: center;"><?php echo $user['User']['email']; ?></td>
				<td style="text-align: center;"><?php echo $this->Html->formatTime($user['User']['created']); ?></td>
				<td style="text-align: center;"><?php echo $this->Html->formatTime($user['User']['modified']); ?></td>
				<td style="text-align: center;"><?php echo $user['User']['role']; ?></td>
				<td style="text-align: center;"><?php echo $user['User']['status']; ?></td>
			</tr>
			<?php endforeach; ?>
			<?php unset($user); ?>
		</tbody>
	</table>
	<?php echo $this->Paginator->prev('<< ' . __('previous', true), array(), null, array('class'=>'disabled'));?>
	<?php echo $this->Paginator->numbers(array(   'class' => 'numbers'     ));?>
	<?php echo $this->Paginator->next(__('next', true) . ' >>', array(), null, array('class' => 'd isabled'));?>
</div>				
<br/>-->
<?php //echo $this->Html->link( "Logout",   array('action'=>'logout') ); ?>
	<blockquote>
	  <h3>Resoluciones de Situaciones con el Sistema.</h3>
	  <hr />
	  <h4>INSCRIPCIÓN DE UN ALUMNO: Agregrar una Inscripción para el próximo Ciclo Lectivo (PRE-INSCRIPCIÓN)</h4><hr />
	  <h4>1° PASO: Abrir el formulario de Agregación</h4>
	  <p> - Desde el menú: "ALUMNADO" --> INSCRIPCIONES" presione el botón "+ AGREGAR".<p><br> 
	  <h4>2° PASO: Completar los campos</h4>	
	  <p> - En el campo "Ciclo lectivo*" seleccione el ciclo 2018.</p>
	  <p> - En el campo "Nombre y apellidos del alumno*" tipeé un nombre de persona correspondiente a su Institución (Ej: "ALUMNO PRIMERO SABATO"; "ALUMNO SEGUNDO SABATO").</p><br>
	  <h4>3° PASO: Presione el botón "GUARDAR".</h4>
	  <p> - El sistema automáticamente creará a esa persona como ALUMNO de su INSTITUCIÓN, le asignará un CÓDIGO ÚNICO DE INSCRIPCIÓN y actualizará la MATRÍCULA de la sección según el ciclo correspondiente.</p><br>
	  <hr />
	  <h4>INSCRIPCIÓN DE UN ALUMNO: Editar una Inscripción | Cambiar la SECCIÓN. </h4><hr />
	  <h4>1° PASO: Abrir el formulario de Edición</h4>
	  <p> - Desde la tarjeta correspondiente a la Inscripción seleccionada: presione el botón NARANJA.<p><br> 
	  <h4>2° PASO: Modificar el campo "Sección*"</h4>	
	  <p> - En el campo "Sección*" seleccione otra sección.</p><br>
	  <h4>3° PASO: Presione el botón "GUARDAR".</h4>
	  <p> - El sistema automáticamente actualizará la MATRÍCULA de la secciones correspondientes al cambio.</p><br>
	  <hr />	
	</blockquote>
</div>
