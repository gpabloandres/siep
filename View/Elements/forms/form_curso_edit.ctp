<?php echo $this->Html->script(array('acordeon', 'tooltip', 'datepicker', 'moment', 'bootstrap-datetimepicker')); ?>
<div class="row">
</div><hr />
<div class="row"><!--<div class="subtitulo">Datos del curso</div>-->
  <div class="col-md-6 col-sm-6 col-xs-12">
    <div class="unit"><strong><h3>Datos Generales</h3></strong><hr />
  		<?php
          if ($current_user['role'] == 'superadmin' && $current_user['puesto'] == 'Sistemas') {
            echo $this->Form->input('centro_id', array('label' => 'Centro*', 'empty' => 'Ingrese una institución...', 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Seleccione una opción de la lista'));
          } else {
            echo $this->Form->input('centro_id', array('label'=>'Centro*', 'readonly' => true, ' between' => '<br>', 'class' => 'form-control'));
          }
          //Define opciones de AÑOS según el nivel.
          if ($current_user['role'] == 'superadmin') {
            $anios = array('Sala de menos de 1 año'=>'Sala de menos de 1 año','Sala de 1 año'=>'Sala de 1 año','Sala de 2 años'=>'Sala de 2 años','Sala de 3 años'=>'Sala de 3 años','Sala de 4 años'=>'Sala de 4 años','Sala de 5 años'=>'Sala de 5 años','1ro'=>'1ro','2do'=>'2do','3ro'=>'3ro','4to'=>'4to','5to'=>'5to','6to'=>'6to','7mo'=>'7mo');
          } else if (($current_user['puesto'] == 'Dirección Jardín') || ($current_user['puesto'] == 'Dirección Escuela Primaria') || ($current_user['puesto'] == 'Supervisión Inicial/Primaria')) {
              $anios = array('Sala de menos de 1 año'=>'Sala de menos de 1 año','Sala de 1 año'=>'Sala de 1 año','Sala de 2 años'=>'Sala de 2 años','Sala de 3 años'=>'Sala de 3 años','Sala de 4 años'=>'Sala de 4 años','Sala de 5 años'=>'Sala de 5 años');
          } else {
              $anios = array('1ro '=>'1ro','2do' =>'2do','3ro' => '3ro','4to' => '4to','5to' => '5to','6to' => '6to','7mo' => '7mo');  
          }
          if ($current_user['role'] == 'superadmin' && $current_user['puesto'] == 'Sistemas') {
            echo $this->Form->input('anio', array('label' =>'Año*', 'empty' => 'Ingrese un año...', 'options' => $anios, 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Selecciones una opción de la lista'));
          } else {
            echo $this->Form->input('anio', array('label'=>'Año*', 'readonly' => true, ' between' => '<br>', 'class' => 'form-control'));
          }
          //Define opciones de DIVISIÓN según el nivel.
          if ($current_user['role'] == 'superadmin') {
              $divisiones = array('ROJA' => 'ROJA', 'NARANJA' => 'NARANJA', 'AMARILLA' => 'AMARILLA', 'A' => 'A', 'B' => 'B', 'C' => 'C', 'D' => 'D', 'E' => 'E', 'F' => 'F', 'G' => 'G', 'H' => 'H');
          } else if (($current_user['puesto'] == 'Dirección Jardín/Escuela') || ($current_user['puesto'] == 'Supervisión Inicial/Primaria')) {
              $divisiones = array('ROJA' => 'ROJA', 'NARANJA' => 'NARANJA', 'AMARILLA' => 'AMARILLA');
          } else {
            $divisiones = array('A' => 'A', 'B' => 'B', 'C' => 'C', 'D' => 'D', 'E' => 'E', 'F' => 'F', 'G' => 'G', 'H' => 'H');       
          }
          if ($current_user['role'] == 'superadmin' && $current_user['puesto'] == 'Sistemas') {
            echo $this->Form->input('division', array('label' => 'División*', 'empty' => 'Ingrese una división...', 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Seleccione una opción de la lista'));
          } else {
            echo $this->Form->input('division', array('label'=>'División*', 'readonly' => true, ' between' => '<br>', 'class' => 'form-control'));
          }
          //Define opciones de TURNOS según nivel.
          if (($current_user['puesto'] == 'Dirección Jardín') || ($current_user['puesto'] == 'Dirección Escuela Primaria') || ($current_user['puesto'] == 'Supervisión Inicial/Primaria')) {
            $turnos = array('Mañana' => 'Mañana', 'Tarde' =>'Tarde', 'Mañana Extendida' =>'Mañana Extendida', 'Tarde Extendida' => 'Tarde Extendida', 'Doble Extendida' =>'Doble Extendida', 'Otro' =>'Otro');
          } else {
            $turnos = array('Mañana' => 'Mañana', 'Tarde' =>'Tarde', 'Mañana Extendida' =>'Mañana Extendida', 'Tarde Extendida' => 'Tarde Extendida', 'Doble' =>'Doble', 'Vespertino' => 'Vespertino', 'Noche' =>'Noche', 'Otro' =>'Otro', 'Bachiller' => 'Bachiller','Tecnico' => 'Tecnico');       
          }
          if ($current_user['role'] == 'superadmin' && $current_user['puesto'] == 'Sistemas') {
            echo $this->Form->input('turno', array('label' => 'Turno*', 'empty' => 'Ingrese un turno...', 'options' => $turnos, 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Seleccione una opción de la lista'));
          } else {
            echo $this->Form->input('turno', array('label' => 'Turno*', 'readonly' => true, ' between' => '<br>', 'class' => 'form-control'));      
          }
          //Define opciones de TIPOS.
          $tipos = array('Independiente' => 'Independiente', 'Independiente de recuperación' => 'Independiente de recuperación', 'Independiente semipresencial' => 'Independiente semipresencial', 'Independiente presencial y semipresencial' => 'Independiente presencial y semipresencial', 'Múltiple' => 'Múltiple', 'Múltiple de recuperación' => 'Múltiple de recuperación', 'Múltiple semipresencial' => 'Múltiple semipresencial', 'Múltiple presencial y semipresencial' => 'Múltiple presencial y semipresencial', 'No Corresponde' => 'No Corresponde', 'Independiente presencial y semipresencial (violeta)' => 'Independiente presencial y semipresencial (violeta)','Mixta / Bimodal' => 'Mixta / Bimodal', 'Múltiple presencial y semipresencial (violeta)' => 'Múltiple presencial y semipresencial (violeta)', 'Multinivel' => 'Multinivel', 'Multiplan' => 'Multiplan');
          if ($current_user['role'] == 'superadmin' && $current_user['puesto'] == 'Sistemas') {
              echo $this->Form->input('tipo', array('empty' => 'Ingrese un tipo...', 'options' => $tipos, 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Seleccione una opción de la lista'));
          } else {
              echo $this->Form->input('tipo', array('label'=>'Tipo*', 'readonly' => true, ' between' => '<br>', 'class' => 'form-control'));
          }         
      ?>
    </div>
  </div>     
  <div class="col-md-6 col-sm-6 col-xs-12"><!--<div class="subtitulo">Datos de contacto</div>-->
		<div class="unit"><strong><h3>Datos Específicos</h3></strong><hr />
			<?php		
          if (($current_user['role'] == 'superadmin') || ($current_user['puesto'] == 'Dirección Colegio Secundario') || ($current_user['puesto'] == 'Supervisión Secundaria') || ($current_user['puesto'] == 'Dirección Instituto Superior')) {
            echo $this->Form->input('hs_catedras', array('label' => 'Hs Cátedras', 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'placeholder' => 'Ingrese cantidad de Hs Cátedras.'));
            echo $this->Form->input('titulacion_id', array('label' => 'Titulación', 'empty' => 'Ingrese una titulación...', 'options'=>$titulaciones, 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Seleccione una opción de la lista'));
            echo $this->Form->input('reso_presupuestaria', array('label' => 'Resolución Presupuestaria', 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'placeholder' => 'Ingrese Resolución Presupuestaria.'));
          }  
          if (($current_user['role'] == 'superadmin' && $current_user['puesto'] == 'Sistemas') || ($current_user['role'] == 'usuario' && $current_user['puesto'] == 'Supervisión Secundaria')) {
              echo $this->Form->input('plazas', array('between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Introduzca la cantidad de plazas admitidas en la sección...', 'Placeholder' => 'Ingrese cantidad máxima de plazas'));
          } else {
              echo $this->Form->input('plazas', array('label'=>'Plazas*', 'readonly' => true, ' between' => '<br>', 'class' => 'form-control'));
          }
          /*
          echo $this->Form->input('matricula', array('between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Introduzca la matrícula de la sección...', 'Placeholder' => 'Ingrese la matrícula de la sección'));
          echo $this->Form->input('vacantes', array('between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Introduzca las vacantes de la sección...', 'Placeholder' => 'Ingrese las vacantes de la sección'));
          */
          ?>
          <?php if (($current_user['role'] == 'superadmin') || ($current_user['puesto'] == 'Dirección Jardín') || ($current_user['puesto'] == 'Dirección Escuela Primaria') || ($current_user['puesto'] == 'Supervisión Inicial/Primaria')) : ?>
          <div class="input-group">
            <span class="input-group-addon">
              <?php echo $this->Form->input('pareja_pedagogica', array('between' => '<br>', 'class' => 'form-control', 'label' => false, 'type' => 'checkbox', 'before' => '<label class="checkbox">', 'after' => '<br><i></i><br>Pareja Pedagógica</label>'));?>
            </span>
          </div>
          <div class="input-group">
            <span class="input-group-addon">
              <?php echo $this->Form->input('maestra_apoyo_inclusion', array('between' => '<br>', 'class' => 'form-control', 'label' => false, 'type' => 'checkbox', 'before' => '<label class="checkbox">', 'after' => '<br><i></i><br>Maestra Apoyo Inclusión</label>'));?>
            </span>
          </div>
        <?php endif;?>
        <?php echo $this->Form->input('observaciones', array('label' => 'Observaciones', 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'placeholder' => 'Ingrese observaciones relevantes sobre la sección.'));?>
    </div>    
  </div>
  <script type="text/javascript">
            $('#datetimepicker1').datetimepicker({ 
      useCurrent: true, //this is important as the functions sets the default date value to the current value
      format: 'YYYY-MM-DD hh:mm',
      }).on('dp.change', function (e) {
                  var specifiedDate = new Date(e.date);
          if (specifiedDate.getMinutes() == 0)
          {
            specifiedDate.setMinutes(1);
            $(this).data('DateTimePicker').date(specifiedDate);
          }
               });
  </script>
</div>
