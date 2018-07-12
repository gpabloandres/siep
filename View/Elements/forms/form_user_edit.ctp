<?php echo $this->Html->script(array('datepicker', 'tooltip')); ?>
<div class="row">
   <div class="col-md-6 col-sm-6 col-xs-12">
	  <?php
          echo $this->Form->input('username', array('label' => 'Nombre usuario*', 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Introduzca inicial nombre + apellido', 'placeholder' => 'Ingrese un nombre de usuario...'));
          $roles = array('superadmin' => 'superadmin', 'admin' => 'admin', 'usuario' => 'usuario');
          echo $this->Form->input('role', array('label' => 'Rol*', 'empty' => 'Ingrese un rol...', 'options' => $roles, 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Ingrese una opción.'));
          echo $this->Form->input('email', array('label' => 'Email*', 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Ingrese el correo electrónico del usuario', 'placeholder' => 'Ingrese un email del usuario'));
      ?>		
   </div>
   <div class="col-md-6 col-sm-6 col-xs-12">
	  <?php		
          echo $this->Form->input('centro_id', array('label' => 'Institución*', 'empty' => 'Ingrese una institución...', 'between' => '<br>', 'class' => 'form-control'));
          echo $this->Form->input('empleado_id', array('label' => 'Agente*', 'empty' => 'Ingrese un agente...', 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Ingrese una opción.'));
          $puestos = array('Sistemas' => 'Sistemas', 'Subsecretaría Provincial' => 'Subsecretaría Provincial', 'Dirección Provincial de Modalidades' => 'Dirección Provincial de Modalidades', 'Supervisión Inicial/Primaria' => 'Supervisión Inicial/Primaria', 'Supervisión Secundaria' => 'Supervisión Secundaria', 'Dirección Jardín' => 'Dirección Jardín', 'Dirección Escuela Primaria' => 'Dirección Escuela Primaria', 'Dirección Colegio Secundario' => 'Dirección Colegio Secundario', 'Dirección Instituto Superior' => 'Dirección Intituto Superior');
          echo $this->Form->input('puesto', array('label' => 'Puesto de trabajo*', 'empty' => 'Ingrese un puesto de trabajo...', 'options' => $puestos, 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Ingrese una opción.'));
      ?>
  </div>
</div>
