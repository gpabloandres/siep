<div class="col-md-6">
	<div class="unit">
        <!--<div class="col-md-4 col-sm-6 col-xs-12 thumbnail text-center">
            <?php if($inscripcion['Inscripcion']['estado_documentacion'] == "COMPLETA"): ?>
            <span class="checked"></span><?php echo $this->Html->image('../img/inscription_image.png', array('class' => 'img-thumbnail img-responsive')); ?>
            <?php endif; ?>
            <?php if($inscripcion['Inscripcion']['estado_documentacion'] == "PENDIENTE"): ?>
            <span class="error"></span><?php echo $this->Html->image('../img/inscription_image.png', array('class' => 'img-thumbnail img-responsive')); ?>
                <?php endif; ?>
        </div>-->
        <?php if(($current_user['role'] == 'superadmin') || ($current_user['role'] == 'usuario')): ?>
        <span class="name"><span class="glyphicon glyphicon-home"></span> <b>Centro:</b> <?php echo $this->Html->link($centros[$inscripcion['Inscripcion']['centro_id']], array('controller' => 'centros', 'action' => 'view', $inscripcion['Inscripcion']['centro_id'])); ?></span><br/>
        <?php endif; ?>
        <span class="name"><span class="glyphicon glyphicon-info-sign"></span> <b>Código:</b> <?php echo $inscripcion['Inscripcion']['legajo_nro']; ?></span><br/>
        <span class="name"><span class="glyphicon glyphicon-info-sign"></span> <b>Tipo:</b> <?php echo $inscripcion['Inscripcion']['tipo_inscripcion']; ?></span><br/>
        <span class="name"><span class="glyphicon glyphicon-user"></span> <b>Alumno:</b> <?php echo $this->Html->link($inscripcion['Alumno']['Persona']['nombre_completo_persona'], array('controller' => 'alumnos', 'action' => 'view', $inscripcion['Inscripcion']['alumno_id'])); ?></span><br/>
        <span class="name"><span class="glyphicon glyphicon-info-sign"></span> <b>Estado:</b> <?php echo $inscripcion['Inscripcion']['estado_inscripcion']; ?></span><br/>
        <span class="name"><span class="glyphicon glyphicon-info-sign"></span> <b>Documentación:</b> <?php echo $inscripcion['Inscripcion']['estado_documentacion']; ?></span>
	    <hr />
        <div class="text-right">
            <span class="link"><?php echo $this->Html->link('<i class="glyphicon glyphicon-eye-open"></i>', array('controller' => 'inscripcions', 'action' => 'view', $inscripcion['Inscripcion']['id']), array('class' => 'btn btn-success','escape' => false)); ?></span>
          <!-- No se editan inscripciones con estado ANULADA. -->  
          <?php if ($inscripcion['Inscripcion']['estado_inscripcion'] != 'ANULADA') : ?>
            <span class="link"><?php echo $this->Html->link('<i class= "glyphicon glyphicon-edit"></i>', array('controller' => 'inscripcions', 'action' => 'edit', $inscripcion['Inscripcion']['id']), array('class' => 'btn btn-warning','escape' => false)); ?></span>
          <?php endif; ?>
          <!-- Sólo para inscripciones del 2020 y para ciertos usuarios. -->
          <?php if(($inscripcion['Inscripcion']['ciclo_id'] == 7) && ($current_user['role'] == 'usuario' || $current_user['id'] == 1 || $current_user['id'] == 438 || $current_user['id'] == 326 || $current_user['id'] == 325 || $current_user['id'] == 338)): ?>  
            <?php if ($inscripcion['Inscripcion']['estado_inscripcion'] != 'ANULADA') { ?>
              <span class="link"><?php echo $this->Html->link('<i class= "glyphicon glyphicon-trash"></i>', array('controller' => 'inscripcions', 'action' => 'delete', $inscripcion['Inscripcion']['id']), array('confirm' => 'Está seguro de ANULAR la inscripción con legajo Nº: '.$inscripcion['Inscripcion']['legajo_nro'], 'class' => 'btn btn-danger','escape' => false)); ?></span>
                <?php } else { ?>
                <span class="link"><?php echo $this->Html->link('<i class="glyphicon glyphicon-ban-circle"></i>', array(), array('class' => 'btn btn-danger', 'escape' => false)); ?></span>
            <?php } ?>
          <?php endif; ?>   
		</div>
	</div>
</div>
