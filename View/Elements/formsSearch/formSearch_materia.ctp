<?php echo $this->Form->create('Materia',array('type'=>'get','url'=>'index', 'novalidate' => true));?>
<?php if(($current_user['role'] == 'superadmin') || ($current_user['role'] == 'usuario')): ?>
<div class="form-group">
	<?php
		echo $this->Form->input('centro_id', array('label' => false, 'empty' => 'Ingrese una institución...', 'class' => 'form-control'));
    ?>
</div><br>
<?php endif; ?>
<div class="form-group">
	<?php
		echo $this->Form->input('curso_id', array('label' => false, 'empty' => 'Ingrese una sección...', 'class' => 'form-control'));
    ?>
</div><br>
<div class="form-group">
	<?php
		echo $this->Form->input('alia', array('label' => false, 'class' => 'form-control', 'Placeholder' => 'Ingrese un alia...'));
    ?>
</div><br>
<div class="form-group">
	<?php
		echo $this->Form->input('plan_de_estudio', array('label' => false, 'class' => 'form-control', 'Placeholder' => 'Ingrese un plan de estudio...'));
    ?>
</div><br>
<div class="text-center">
    <span class="link"><?php echo $this->Form->button('<span class="glyphicon glyphicon-search"></span> BUSCAR', array('class' => 'submit', 'class' => 'btn btn-primary')); ?>
    </span>
    <?php echo $this->Form->end(); ?>
</div>
