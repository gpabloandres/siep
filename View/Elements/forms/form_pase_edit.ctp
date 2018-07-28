<?php echo $this->Html->script(array('tooltip', 'datepicker', 'moment', 'bootstrap-datetimepicker')); ?>
<div class="row">
  <div class="col-xs-6 col-sm-3">
    <?php echo $this->Form->input('created', array('label' => 'Creado*', 'readonly' => true, 'id' => 'datetimepicker1', 'type' => 'text', 'class' => 'input-group date', 'class' => 'form-control', 'span class' => 'fa fa-calendar'));
    ?>
  </div>
  <div class="col-xs-6 col-sm-3">
        <?php
            $estados = array('INICIADO'=>'INICIADO', 'EN EVALUACIÓN'=>'EN EVALUACIÓN', 'CONFIRMADO'=>'CONFIRMADO', 'RECHAZADO'=>'RECHAZADO');
            echo $this->Form->input('estado_pase', array('label' => 'Estado del Pase', 'empty' => 'Ingrese una opción...', 'options' => $estados, 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Seleccione una opción'));
        ?>
  </div>
  <div class="col-xs-6 col-sm-3">
    <?php echo $this->Form->input('modified', array('label' => 'Modificado*', 'readonly' => true, 'id' => 'datetimepicker1', 'type' => 'text', 'class' => 'input-group date', 'class' => 'form-control', 'span class' => 'fa fa-calendar'));
    ?>
  </div>
</div><hr />
<div class="row">
  <div class="col-md-4 col-sm-6 col-xs-12">
    <div class="unit"><strong><h3>Datos Generales</h3></strong><hr />
       <!--<?php// 
          echo $this->Form->input('alumno_id', array('label'=>'Alumno*', 'readonly' => true, 'options'=>$PersonaAlumnoId, 'between' => '<br>', 'class' => 'form-control'));
      ?><br>-->
      <?php
          echo $this->Form->input('centro_id_destino', array('label'=>'Institución Destino*', 'readonly' => true, 'empty' => 'Ingrese una institución...', 'options'=>$centrosNombre, 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Seleccione una opción'));
      ?><br>
      <?php
          $anios = array('Sala de 3 años' => 'Sala de 3 años', 'Sala de 4 años' => 'Sala de 4 años', 'Sala de 5 años' => 'Sala de 5 años', '1ro' => '1ro', '2do' => '2do', '3ro' => '3ro', '4to' => '4to', '5to' => '5to', '6to' => '6to', '7mo' => '7mo');
          echo $this->Form->input('anio', array('label'=>'Año de estudio*', 'empty' => 'Ingrese un año de estudio...', 'options'=>$anios, 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Seleccione una opción'));
      ?><br>
    </div>
    <?php echo '</div><div class="col-md-4 col-sm-6 col-xs-12">'; ?>
    <div class="unit"><strong><h3>Datos Específicos</h3></strong><hr />
      <?php
            echo $this->Form->input('pase_nro', array('label'=>'Trámite de pase nro*', 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Indique el número sin puntos, ni guiones, ni espacios', 'placeholder' => 'Ingrese un nº de pase...'));
      ?><br>
      <?php
            $tipos = array('Ingreso a la provincia' => 'Ingreso a la provincia', 'Egreso de la provincia' => 'Egreso de la provincia', 'Dentro de la provincia' => 'Dentro de la provincia');
            echo $this->Form->input('tipo', array('label' => 'Tipo', 'empty' => 'Ingrese una opción...', 'options' => $tipos, 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Seleccione una opción'));
        ?><br>
        <?php
            $motivos = array('Mudanza de la familia' => 'Mudanza de la familia', 'Pasó a educación de jóvenes y adultos' => 'Pasó a educación de jóvenes y adultos', 'Pasó a educación especial' => 'Pasó a educación especial', 'No le gustaba la escuela' => 'No le gustaba la escuela', 'Tenía muchas materias previas' => 'Tenía muchas materias previas', 'Problemas disciplinarios' => 'Problemas disciplinarios',  'Decisión de la escuela' => 'Decisión de la escuela', 'Problemas de salud' =>  'Problemas de salud', 'Cambio en la situación económica' => 'Cambio en la situación económica', 'Comenzó a trabajar' => 'Comenzó a trabajar', 'No especifica' => 'No especifica', 'Otro' => 'Otro');
            echo $this->Form->input('motivo', array('label' => 'Motivo', 'empty' => 'Ingrese una opción...', 'options' => $motivos, 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Seleccione una opción'));
        ?>
    </div>
    <?php echo '</div><div class="col-md-4 col-sm-6 col-xs-12">'; ?>
    <div class="unit"><strong><h3>Documentación Presentada</h3></strong><hr />
      <div class="input-group">
        <span class="input-group-addon">
          <?php echo $this->Form->input('nota_tutor', array('between' => '<br>', 'class' => 'form-control', 'label' => false, 'type' => 'checkbox', 'before' => '<label class="checkbox">', 'after' => '<br><i></i><br>Nota del Tutor</label>'));?>
        </span>
      </div>
    </div>
  </div>
</div>
  <div class="row">
    <div class="col-md-12 col-sm-6 col-xs-12">
        <?php echo $this->Form->input('observaciones', array('label'=>'Observaciones', 'type' => 'textarea', 'between' => '<br>', 'class' => 'form-control')); ?>
      </div>
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
