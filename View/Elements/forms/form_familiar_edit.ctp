<?php echo $this->Html->css(array('/js/select2/select2.min')); ?>
<?php echo $this->Html->script(array('tooltip', 'datepicker', 'moment', 'bootstrap-datetimepicker','select2/select2.min')); ?>
<script>
    $(function(){
        $('.s2_alumno').select2();
    });
</script>
<div class="row">
</div><hr />
<div class="row">
   	<div class="col-md-6 col-sm-6 col-xs-12">
		<div class="unit"><strong><h3>Datos Generales</h3></strong><hr />
			<div>
                <strong><h5>Nombres y Apellidos del Padre/Madre/Tutor*</h5></strong>
                <input class="form-control" disabled="disabled" label= "Nombre y apellidos del alumno*" data-toggle="tooltip" data-placemente="bottom" value="<?php echo $familiarPersonaNombre;?>">
                <?php echo $this->Form->input('persona_id', array('type' => 'hidden', 'default'=>$familiarPersonaId)); ?>
            </div><br>
            <div>
                <strong><h5>Nombre y apellidos del alumno*</h5></strong>
                <input class="form-control" disabled="disabled" label= "Nombre y apellidos del alumno*" data-toggle="tooltip" data-placemente="bottom" value="<?php echo $alumnoPersonaNombre;?>">
                <?php echo $this->Form->input('Familiar.alumno_id', array('type' => 'hidden', 'default'=>$alumnoId)); ?>
            </div><br>
        </div>
	  	<?php echo '</div><div class="col-md-6 col-sm-6 col-xs-12">'; ?>
      	<div class="unit"><strong><h3>Datos Específicos</h3></strong><hr />
        	<?php
			  	$vinculos = array('Padre' => 'Padre', 'Madre'=>'Madre', 'Tutor'=>'Tutor');
			  	echo $this->Form->input('vinculo', array('label'=>'Vinculo*', 'empty' => 'Ingrese un vinculo...', 'options' => $vinculos, 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Seleccione una opción'));
			?>
        </div>
        <div class="input-group">
            <span class="input-group-addon">
              <?php echo $this->Form->input('conviviente', array('between' => '<br>', 'class' => 'form-control', 'label' => false, 'type' => 'checkbox', 'before' => '<label class="checkbox">', 'after' => '<br><i></i><br>Conviviente</label>'));?>
            </span>
        </div>
        <div class="input-group">
            <span class="input-group-addon">
              <?php echo $this->Form->input('autorizado_retirar', array('between' => '<br>', 'class' => 'form-control', 'label' => false, 'type' => 'checkbox', 'before' => '<label class="checkbox">', 'after' => '<br><i></i><br>Autorizado a Retirar</label>'));?>
            </span>
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
</div>
