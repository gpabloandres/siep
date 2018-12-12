<div class="TituloSec"><?php echo __('Agregar Titulación'); ?></div>
<div id="ContenidoSec">
<div class="titulacions form">
<?php echo $this->Form->create('Titulacion', array('type' => 'file', 'novalidate' => 'novalidate'));?>
	         <div class="unit">
               <?php echo $this->element('forms/form_titulacion_add'); ?><p>
             </div>
             <div class="text-center">
              <div class="submit">                 
               <?php echo $this->Form->submit(__('GUARDAR', true), array('name' => 'ok', 'div' => false, 'class' => 'btn btn-success')); ?>
               <?php echo $this->Form->submit(__('CANCELAR', true), array('name' => 'cancel', 'div' => false, 'class' => 'btn btn-warning')); ?>
              </div>
              <?php echo $this->Form->end();?>   
        	 </div>
		</div>
	</div>