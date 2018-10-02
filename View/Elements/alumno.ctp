<div class="col-md-6">
  <div class="unit">
    <span class="name"><span class="glyphicon glyphicon-info-sign"></span> <b>Documento N°:</b> <?php echo $this->Html->link(($alumno['Persona']['documento_nro']), array('controller' => 'personas', 'action' => 'view', $alumno['Persona']['id']));?></span><br/>
    <span class="name"><span class="glyphicon glyphicon-info-sign"></span> <b>Nombre completo:</b> <?php echo $this->Html->link(($alumno['Persona']['nombre_completo_persona']), array('controller' => 'personas', 'action' => 'view', $alumno['Persona']['id']));?></span><br/>
    <span class="name"><span class="glyphicon glyphicon-folder-open"></span> <b>Legajo Físico N°:</b> <?php echo $this->Html->link(($alumno['Alumno']['legajo_fisico_nro']), array('controller' => 'alumnos', 'action' => 'view', $alumno['Alumno']['id']));?></span><br/>
    <hr />
      <div class="text-right">
        <span class="link"><?php echo $this->Html->link('<i class= "glyphicon glyphicon-eye-open"></i>', array('controller' => 'alumnos', 'action' => 'view', $alumno['Alumno']['id']), array('class' => 'btn btn-success','escape' => false)); ?></span>
      <?php //if(($current_user['role'] == 'superadmin') || ($current_user['role'] == 'admin')): ?>
        <!--<span class="link"><?php //echo $this->Html->link('<i class= "glyphicon glyphicon-edit"></i>', array('controller' => 'alumnos', 'action' => 'edit', $alumno['Alumno']['id']), array('class' => 'btn btn-warning','escape' => false)); ?></span>-->
      <?php //endif; ?>
      <?php if($current_user['role'] == 'superadmin' && $current_user['puesto'] == 'Sistemas'): ?>
        <span class="link"><?php echo $this->Html->link('<i class= "glyphicon glyphicon-edit"></i>', array('controller' => 'alumnos', 'action' => 'edit', $alumno['Alumno']['id']), array('class' => 'btn btn-warning','escape' => false)); ?>
        </span>
        <span class="link"><?php echo $this->Html->link('<i class= "glyphicon glyphicon-trash"></i>', array('controller' => 'alumnos', 'action' => 'delete', $alumno['Alumno']['id']), array('confirm' => 'Está seguro de borrar a '.$alumno['Alumno']['id'], 'class' => 'btn btn-danger','escape' => false)); ?>
        </span>
      <?php endif; ?>
      </div>
    </div>
</div>
