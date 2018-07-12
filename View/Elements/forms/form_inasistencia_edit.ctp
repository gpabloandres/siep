<?php echo $this->Html->script(array('tooltip', 'datepicker', 'moment', 'bootstrap-datetimepicker')); ?>
<div class="row">
	<div class="col-xs-6 col-sm-3">
	    <?php echo $this->Form->input('created', array('label' => 'Creado*', 'id' => 'datetimepicker1', 'type' => 'text', 'class' => 'input-group date', 'class' => 'form-control', 'span class' => 'fa fa-calendar')); ?>
    </div>
</div><hr />
<div class="row">
	<div class="col-md-6 col-sm-6 col-xs-12">
		 <div class="unit"><strong><h3>Datos Generales</h3></strong><hr />
			  <?php 
				  echo $this->Form->input('ciclo_id', array('label' => 'Ciclo*', 'default' => $cicloIdActual, 'readonly' => true, 'between' => '<br>', 'class' => 'form-control'));
				  echo $this->Form->input('Curso', array('label' => 'Curso*', 'empty' => 'Ingrese un curso...', 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Seleccione una opción'));
				  echo $this->Form->input('alumno_id', array('label' => 'Alumno*', 'empty' => 'Ingrese un alumno...', 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Seleccione una opción'));
				  echo $this->Form->input('Materia', array('label' => 'Materia*', 'empty' => 'Ingrese una materia...', 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Seleccione una opción'));
				  $tipos_causa = array('Sin causa' => 'Sin causa', 'Razones particulares' => 'Razones particulares', 'Enfermedad' => 'Enfermedad',
									   'Fenómenos meteorológicos' => 'Fenómenos meteorológicos', 'Donación de sangre' => 'Donación de sangre',
									   'Obligaciones cívico_militares' => 'Obligaciones cívico_militares', 'Paro de transporte' => 'Paro de transporte');
			  ?>
         </div>
    <?php echo '</div><div class="col-md-6 col-sm-6 col-xs-12">'; ?>
         <div class="unit"><strong><h3>Datos Específicos</h3></strong><hr />      
			 <?php
				  echo $this->Form->input('causa', array('label' => 'Causa*', 'options' => $tipos_causa, 'empty' => 'Ingrese una causa...', 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Seleccione una opción'));
				  $tipos = array('un cuarto' => 'un cuarto' ,'media' => 'media', 'completa' => 'completa');
				  echo $this->Form->input('tipo', array('label' => 'Tipo*', 'options' => $tipos, 'empty' => 'Ingrese un tipo...', 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Seleccione una opción'));
				  $tipos_justificado = array('Si' => 'Si', 'No' => 'No', 'Pendiente' => 'Pendiente');
				  echo $this->Form->input('justificado', array('label' => 'Justificación*', 'options' => $tipos_justificado, 'empty' => 'Ingrese un tipo de justificación...', 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Seleccione una opción'));
             ?>
          </div> 
     </div>
     <div class="col-md-12 col-sm-6 col-xs-12">
         <?php echo $this->Form->input('observaciones', array('label'=>'Observaciones', 'type' => 'textarea', 'between' => '<br>', 'class' => 'form-control')); ?>
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
     <script>tinymce.init({ selector:'textarea' });</script>
</div>
