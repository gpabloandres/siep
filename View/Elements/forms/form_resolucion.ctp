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
		 	echo $this->Form->input('numero', array('label'=>'Número', 'between' => '<br>', 'class' => 'form-control'));
		 	$tipos = array('PROVINCIAL' => 'PROVINCIAL', 'NACIONAL' => 'NACIONAL', 'HOMOLOGACIÓN' => 'HOMOLOGACIÓN');
		 	echo $this->Form->input('tipo', array('label'=>'Tipo', 'options' => $tipos ,'between' => '<br>', 'class' => 'form-control'));
		 	echo $this->Form->input('anio', array('label'=>'Anio', 'between' => '<br>', 'class' => 'form-control'));
		?>
		</div>
	</div>
	<div class="col-md-6 col-sm-6 col-xs-12">	
		<div class="unit"><strong><h3>Datos Específicos</h3></strong><hr />	
  	  	<?php
		 	echo $this->Form->input('descripcion', array('label'=>'Descripción', 'type' => 'textarea', 'between' => '<br>', 'class' => 'form-control'));
		 	echo $this->Form->input('documento', array('label' => 'Documento', 'type' => 'file', 'class' => 'file', 'data-show-upload' => 'false', 'data-show-caption' => 'true'));
        ?>
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
