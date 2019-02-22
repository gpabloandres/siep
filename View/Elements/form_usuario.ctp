
<strong><?php echo $this->Session->flash('auth'); ?></strong></br>
<br><br><br>
<div class="row">
	<div class="col-xs-12 col-md-6 col-centered">
		<div id="login" class="animated bounceInDown">
			<div class="titulo">SIEP | TDF</div><br>
			<div class="animated fadeIn">
				<span  class="img_login glyphicon glyphicon-user"></span>
			</div>
			<?php echo $this->Form->create('User', array('url'=> 'login'));?>
		 	<div id="resultado"></div>
	            <div class="form-inline">
	                <?php echo $this->Form->input('username', 
	        			array('label'=>'Nombre de usuario', 'between' => '<br>', 'placeholder' => 'Nombre de usuario','class' => 'form-control')); ?>
			    </div><br>
	            <div class="form-inline">
	                <?php echo $this->Form->input('password', 
	       			    array('label'=>'Contraseña', 'between' => '<br>', 'placeholder' => 'Contraseña','class' => 'form-control')); ?>
			    </div><br>
			    <?php echo $this->Form->end(array('label' => 'INICIAR SESIÓN', 'class' => 'btn btn-success'));?>
		</div>    
	</div>
</div>
