<?php echo $this->Html->script(array('acordeon', 'tooltip', 'datepicker', 'moment', 'bootstrap-datetimepicker')); ?>
<div class="row">
	<!--<div class="col-xs-6 col-sm-3">
	    <?php echo $this->Form->input('created', array('label' => 'Creado*', 'id' => 'datetimepicker1', 'type' => 'text', 'class' => 'input-group date', 'class' => 'form-control', 'span class' => 'fa fa-calendar')); ?>
  </div>-->
</div><hr />
<div class="row">
  <div class="col-md-6 col-sm-6 col-xs-12">
      <div class="unit"><strong><h3>Datos Generales</h3></strong><hr />
		  <?php
              echo $this->Form->input('nombre', array('label' => 'Nombre*', 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Ingrese el año con formato AAAA', 'Placeholder' => 'Ingrese año del ciclo...'));
              echo $this->Form->input('fechaInicio', array('label' => 'Fecha de Inicio*', 'type' => 'text', 'between' => '<br>', 'class' => 'datepicker form-control', 'Placeholder' => 'Ingrese la fecha de inicio...'));
              echo $this->Form->input('fechaFinal', array('label' => 'Fecha de Finalización*', 'between' => '<br>', 'type' => 'text', 'class' => 'datepicker form-control', 'placeholder' => 'Ingrese la fecha de finalización...'));
          ?>
      </div></br>
  </div>
  <!--<div class="col-md-6 col-sm-6 col-xs-12">
      <div class="unit"><strong><h3>Datos Específicos</h3></strong><hr />
		  <?php
              echo $this->Form->input('primer_periodo', array('label' => 'Fecha de Inicio Primer Período*', 'type' => 'text', 'between' => '<br>', 'class' => 'datepicker form-control', 'Placeholder' => 'Ingrese la fecha de incio del primer período...'));
              echo $this->Form->input('segundo_periodo', array('label' => 'Fecha de Inicio Segundo Período*', 'between' => '<br>', 'type' => 'text', 'class' => 'datepicker form-control', 'placeholder' => 'Ingrese la fecha de incio del segundo período...'));
              echo $this->Form->input('tercer_periodo', array('label' => 'Fecha de Inicio Tercer Período*', 'between' => '<br>', 'type' => 'text', 'class' => 'datepicker form-control', 'placeholder' => 'Ingrese la fecha de incio del tercer período...'));
          ?>
      </div>
  </div>
    <div class="col-md-12 col-sm-6 col-xs-12">
       <?php echo $this->Form->input('observaciones', array('label'=>'Observaciones', 'type' => 'textarea', 'between' => '<br>', 'class' => 'form-control')); ?>
  </div>-->
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
  <!--<script>tinymce.init({ selector:'textarea' });</script>-->
</div>
