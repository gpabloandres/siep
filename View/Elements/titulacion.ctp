<div class="col-md-6">
	<div class="unit">
         <!--<span class="name"><span class="glyphicon glyphicon-info-sign"></span> <b>Institución:</b> <?php echo $this->Html->link($centros[$titulacion['Titulacion']['id']], array('controller' => 'centros', 'action' => 'view', $titulacion['Titulacion']['id'])); ?></span><br/>-->
         <span class="name"><span class="glyphicon glyphicon-info-sign"></span> <b>Nombre:</b> <?php echo $titulacion['Titulacion']['nombre']; ?></span><br/>
         <span class="name"><span class="glyphicon glyphicon-info-sign"></span> <b>Orientación:</b> <?php echo $titulacion['Titulacion']['orientacion']; ?></span><br/>
         <span class="name"><span class="glyphicon glyphicon-info-sign"></span> <b>Forma del dictado:</b> <?php echo $titulacion['Titulacion']['forma_dictado']; ?></span><br/>
         <hr />
         <div class="text-right">
             <span class="link"><?php echo $this->Html->link('<i class="glyphicon glyphicon-eye-open"></i>', array('controller' => 'titulacions', 'action' => 'view', $titulacion['Titulacion']['id']), array('class' => 'btn btn-success','escape' => false)); ?></span>
            <?php if($current_user['role'] == 'superadmin'): ?> 
             <span class="link"><?php echo $this->Html->link('<i class="glyphicon glyphicon-edit"></i>', array('controller' => 'titulacions', 'action' => 'edit', $titulacion['Titulacion']['id']), array('class' => 'btn btn-warning','escape' => false)); ?></span>
             <span class="link"><?php echo $this->Html->link('<i class="glyphicon glyphicon-trash"></i>', array('controller' => 'titulacions', 'action' => 'delete', $titulacion['Titulacion']['id']), array('confirm' => 'Está seguro de borrar la titulación '.$titulacion['Titulacion']['nombre'], 'class' => 'btn btn-danger','escape' => false)); ?></span>
            <?php endif; ?> 
		 </div>
	</div>
</div>
