<div class="col-md-6">
	<div class="unit">
        <!--<div class="col-md-4 col-sm-6 col-xs-12 thumbnail text-center">
            <?php if($pase['Pase']['estado_documentacion'] == "COMPLETA"): ?>
            <span class="checked"></span><?php echo $this->Html->image('../img/inscription_image.png', array('class' => 'img-thumbnail img-responsive')); ?>
            <?php endif; ?>
            <?php if($pase['Pase']['estado_documentacion'] == "PENDIENTE"): ?>
            <span class="error"></span><?php echo $this->Html->image('../img/inscription_image.png', array('class' => 'img-thumbnail img-responsive')); ?>
                <?php endif; ?>
        </div>-->
        <span class="name"><span class="glyphicon glyphicon-info-sign"></span> <b>Ciclo:</b> <?php echo $this->Html->link($ciclosNombre[$pase['Pase']['ciclo_id']], array('controller' => 'ciclos', 'action' => 'view', $pase['Pase']['ciclo_id'])); ?></span><br/>
      <?php if (($current_user['role'] == 'superadmin') || ($current_user['role'] == 'usuario')) { ?>
          <span class="name"><span class="glyphicon glyphicon-home"></span> <b>Centro Origen:</b> <?php echo $this->Html->link($centrosNombreTarjetas[$pase['Pase']['centro_id_origen']], array('controller' => 'centros', 'action' => 'view', $pase['Pase']['centro_id_origen'])); ?></span><br/>
      <?php } ?> 
      <?php if (($current_user['centro_id'] === $pase['Pase']['centro_id_destino'])) { ?>
          <span class="name"><span class="glyphicon glyphicon-home"></span> <b>Centro Origen:</b> <?php echo $this->Html->link($centrosNombreTarjetas[$pase['Pase']['centro_id_origen']], array('controller' => 'centros', 'action' => 'view', $pase['Pase']['centro_id_origen'])); ?></span><br/>
      <?php } else { ?>
          <span class="name"><span class="glyphicon glyphicon-home"></span> <b>Centro Destino:</b> <?php echo $this->Html->link($centrosNombreTarjetas[$pase['Pase']['centro_id_destino']], array('controller' => 'centros', 'action' => 'view', $pase['Pase']['centro_id_destino'])); ?></span><br/>      
      <?php } ?>  
        <span class="name"><span class="glyphicon glyphicon-user"></span> <b>Año de estudio:</b> <?php echo $pase['Pase']['anio']; ?></span><br/>
       <?php if ($current_user['role'] == 'admin') {
        if (($pase['Pase']['estado_pase'] == 'INICIADO') && ($current_user['centro_id'] == $pase['Pase']['centro_id_origen'])) { ?>
            <span class="name"><span class="glyphicon glyphicon-user"></span> <b>Alumno:</b> <?php echo $this->Html->link($personaNombre[$personaId[$pase['Pase']['alumno_id']]], array('controller' => 'alumnos', 'action' => 'view', $pase['Pase']['alumno_id'])); ?></span><br/>
        <?php } else if (($pase['Pase']['estado_pase'] == 'CONFIRMADO') && ($current_user['centro_id'] == $pase['Pase']['centro_id_destino'])) { ?>
            <span class="name"><span class="glyphicon glyphicon-user"></span> <b>Alumno:</b> <?php echo $this->Html->link($personaNombre[$personaId[$pase['Pase']['alumno_id']]], array('controller' => 'alumnos', 'action' => 'view', $pase['Pase']['alumno_id'])); ?></span><br/>
        <?php } else { ?> 
            <span class="name"><span class="glyphicon glyphicon-user"></span> <b>Alumno:</b> <?php echo $personaNombre[$personaId[$pase['Pase']['alumno_id']]]; ?></span><br/> 
       <?php }
        } else if (($current_user['role'] == 'superadmin') || ($current_user['role'] == 'usuario')) { ?> 
            <span class="name"><span class="glyphicon glyphicon-user"></span> <b>Alumno:</b> <?php echo $this->Html->link($personaNombre[$personaId[$pase['Pase']['alumno_id']]], array('controller' => 'alumnos', 'action' => 'view', $pase['Pase']['alumno_id'])); ?></span><br/> 
       <?php }; ?>
        <span class="name"><span class="glyphicon glyphicon-info-sign"></span> <b>Documentación:</b> <?php echo $pase['Pase']['estado_documentacion']; ?></span><br/>
        <span class="name"><span class="glyphicon glyphicon-info-sign"></span> <b>Estado:</b> <?php echo $pase['Pase']['estado_pase']; ?></p>
        <div class="text-right">
          <?php if(($current_user['role'] == 'superadmin') || ($current_user['role'] == 'usuario')): ?>
            <span class="link"><?php echo $this->Html->link('<i class="glyphicon glyphicon-eye-open"></i>', array('controller' => 'pases', 'action' => 'view', $pase['Pase']['id']), array('class' => 'btn btn-success','escape' => false)); ?></span>
            <span class="link"><?php echo $this->Html->link('<i class= "glyphicon glyphicon-edit"></i>', array('controller' => 'pases', 'action' => 'edit', $pase['Pase']['id']), array('class' => 'btn btn-warning','escape' => false)); ?></span>
          <?php endif; ?>
          <?php if(($current_user['role'] == 'admin') && ((($current_user['centro_id'] == $pase['Pase']['centro_id_destino']) && $pase['Pase']['estado_pase'] == 'CONFIRMADO')) || (($current_user['centro_id'] == $pase['Pase']['centro_id_origen']) && $pase['Pase']['estado_pase'] == 'INICIADO')): ?>
            <span class="link"><?php echo $this->Html->link('<i class="glyphicon glyphicon-eye-open"></i>', array('controller' => 'pases', 'action' => 'view', $pase['Pase']['id']), array('class' => 'btn btn-success','escape' => false)); ?></span>
            <?php if ($nivelCentroString != 'Común - Secundario') { ?>
              <span class="link"><?php echo $this->Html->link('<i class= "glyphicon glyphicon-edit"></i>', array('controller' => 'pases', 'action' => 'edit', $pase['Pase']['id']), array('class' => 'btn btn-warning','escape' => false)); ?></span>
            <?php } ?>
          <?php endif; ?>
          <?php if($current_user['role'] == 'superadmin'): ?>
            <span class="link"><?php echo $this->Html->link('<i class= "glyphicon glyphicon-trash"></i>', array('controller' => 'pases', 'action' => 'delete', $pase['Pase']['id']), array('confirm' => 'Está seguro de borrar el pase nro.'.$pase['Pase']['id'], 'class' => 'btn btn-danger','escape' => false)); ?></span>
          <?php endif; ?>
		</div>
	</div>
</div>
