<?php echo $this->Html->script('datepicker'); ?>
  	<div class="row">
  	 	<div class="col-md-6 col-sm-6 col-xs-12">
	  	<?php 
	        echo $this->Form->input('creado', array('type' => 'text', 'between' => '<br>', 'empty' => '','class' => 'datepicker form-control'));
			echo $this->Form->input('centro_id', array('label'=>'Centro ID', 'between' => '<br>', 'class' => 'form-control'));
			echo $this->Form->input('ciclo_id', array('label'=>'Ciclo ID', 'between' => '<br>', 'class' => 'form-control'));
			echo $this->Form->input('alumno_id', array('label'=>'Alumno ID', 'between' => '<br>', 'class' => 'form-control'));
			$tipos_discapacidad = array('Motriz' => 'Motriz', 'Visual' => 'Visual', 'Mental' => 'Mental', 'Auditiva' => 'Auditiva', 'De lenguaje' => 'De lenguaje');
	        echo $this->Form->input('tipo_discapacidad', array('options' => $tipos_discapacidad, 'empty' => '','between' => '<br>', 'class' => 'form-control'));
	  	echo '</div><div class="col-md-6 col-sm-6 col-xs-12">';
			echo $this->Form->input('docente_nombre_completo', array('label' => 'Nombre completo del docente integrador', 'between' => '<br>', 'class' => 'form-control'));
			echo $this->Form->input('fecha_inicio', array('type' => 'text', 'between' => '<br>', 'empty' => '','class' => 'datepicker form-control'));
			echo $this->Form->input('fecha_fin', array('type' => 'text', 'between' => '<br>', 'empty' => '','class' => 'datepicker form-control', 'empty' => ''));
	        echo $this->Form->input('informe', array('label'=>'Informe relacionado', 'type' => 'file',  'between' => '<br>', 'class' => 'form-control'));
	        echo $this->Form->input('informe_dir', array('type' => 'hidden'));
		?>
		</div>
		<div class="col-md-12 col-sm-6 col-xs-12">
			<?php 
				echo $this->Form->input('observaciones', array('label'=>'Descripción', 'type' => 'textarea', 'between' => '<br>', 'class' => 'form-control'));
			?>
        </div>
		<script>tinymce.init({ selector:'textarea' });</script>
	</div>
</div>
