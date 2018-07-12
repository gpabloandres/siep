<?php echo $this->Html->script(array('acordeon', 'tooltip', 'datepicker', 'moment', 'bootstrap-datetimepicker')); ?>
<div class="row">
	<div class="col-xs-6 col-sm-3">
	    <?php echo $this->Form->input('created', array('label' => 'Creado*', 'id' => 'datetimepicker1', 'type' => 'text', 'class' => 'input-group date', 'class' => 'form-control', 'span class' => 'fa fa-calendar')); ?>
    </div>
</div><hr />
<div class="row">
    <div class="col-md-4 col-sm-6 col-xs-12">
  	    <div class="unit"><strong><h3>Datos Generales</h3></strong><hr />
			<?php 
                echo $this->Form->input('ciclo_id', array('label' => 'Ciclo*', 'empty' => 'Ingrese un ciclo...', 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Seleccione una opción'));
                echo $this->Form->input('titulacion_id', array('label'=>'Titulación*', 'empty' => 'Ingrese una titulación...', 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Seleccione una opción'));
                echo $this->Form->input('materia_id', array('label'=>'Materia*', 'empty' => 'Ingrese una materia...', 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Seleccione una opción'));
                echo $this->Form->input('Alumno', array('label'=>'Alumno*', 'empty' => 'Ingrese un alumno...', 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Seleccione una opción'));
                $turnos = array('Marzo' => 'Marzo', 'Julio'=>'Julio', 'Diciembre'=>'Diciembre');
                echo $this->Form->input('turno', array('label' => 'Turno*', 'empty' => 'Ingrese un turno...', 'options' => $turnos, 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Seleccione una opción'));
            ?>
	</div></br>
</div>
    <div class="col-md-4 col-sm-6 col-xs-12">
        <div class="unit"><strong><h3>Datos Específicos</h3></strong><hr />
			<?php
                $mesaespecial = array('SI' => 'SI', 'NO'=>'NO');
                echo $this->Form->input('mesaespecial', array('label' => 'Mesa Especial*', 'empty' => 'Ingrese una opción...', 'options' => $turnos, 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Seleccione una opción'));            
                $modalidades = array('Escrito' => 'Escrito', 'Oral' => 'Oral', 'No definido' => 'No definido');
                echo $this->Form->input('modalidad', array('label' => 'Modalidad*', 'empty' => 'Ingrese una modalidad...', 'options' => $modalidades, 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Seleccione una opción'));
                echo $this->Form->input('acta_nro', array('label' => 'Acta Nº*', 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Seleccione una opción', 'Placeholder' => 'Ingrese un nº de acta...'));
                echo $this->Form->input('libro_nro', array('label' => 'Libro Nº*', 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Seleccione una opción', 'Placeholder' => 'Ingrese un nº de libro...'));
                echo $this->Form->input('folio_nro', array('label' => 'Folio Nº*', 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Seleccione una opción', 'Placeholder' => 'Ingrese un nº de folio...'));
                echo $this->Form->input('seccion', array('label' => 'Sección', 'between' => '<br>', 'class' => 'timepicker form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Seleccione una opción', 'Placeholder' => 'Ingrese una secciónº de aulan...'));
                echo $this->Form->input('aula_nro', array('label' => 'Aula Nº*', 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Seleccione una opción', 'Placeholder' => 'Ingrese un nº de aula...'));
            ?>
	</div></br>
</div>
    <div class="col-md-4 col-sm-6 col-xs-12">
        <div class="unit"><strong><h3>Datos de los Integrantes</h3></strong><hr />
			<?php
			    echo $this->Form->input('presidente', array('label' => 'Presidente*', 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Seleccione una opción', 'Placeholder' => 'Ingrese un presidente...'));
                echo $this->Form->input('vocal_uno', array('label' => 'Vocal Nº 1*', 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Seleccione una opción', 'Placeholder' => 'Ingrese un vocal...'));
                echo $this->Form->input('vocal_dos', array('label' => 'Vocal Nº 2*', 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Seleccione una opción', 'Placeholder' => 'Ingrese un vocal...'));
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
