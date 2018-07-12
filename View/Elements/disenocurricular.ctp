<div class="col-md-4">
	<div class="unit">
        <span class="name"><span class="glyphicon glyphicon-info-sign"></span> <b>Titulación:</b> 
        <?php echo $this->Html->link($titulacions[$disenocurricular['Disenocurricular']['titulacion_id']], array('controller' => 'titulacions', 'action' => 'view', $disenocurricular['Disenocurricular']['titulacion_id'])); ?></span><br/>
        <span class="name"><span class="glyphicon glyphicon-info-sign"></span> <b>Resolución:</b> 
        <?php echo $this->Html->link($resolucions[$disenocurricular['Disenocurricular']['resolucion_id']], array('controller' => 'resolucions', 'action' => 'view', $disenocurricular['Disenocurricular']['resolucion_id'])); ?></span><br/>
        <span class="name"><span class="glyphicon glyphicon-info-sign"></span> <b>Año:</b>
        <?php echo $disenocurricular['Disenocurricular']['anio']; ?></span><br/>
        <hr />
        <div class="text-right">
            <span class="link"><?php echo $this->Html->link('<i class="glyphicon glyphicon-eye-open"></i>', array('controller' => 'disenocurriculars', 'action' => 'view', $disenocurricular['Disenocurricular']['id']), array('class' => 'btn btn-success','escape' => false)); ?></span>
           <?php if($current_user['role'] == 'superadmin'): ?>
            <span class="link"><?php echo $this->Html->link(__('<i class="glyphicon glyphicon-edit"></i>'), array('action' => 'edit', $disenocurricular['Disenocurricular']['id']), array('class' => 'btn btn-warning','escape' => false)); ?></span>
            <span class="link"><?php echo $this->Html->link('<i class="glyphicon glyphicon-trash"></i>', array('controller' => 'disenocurriculars', 'action' => 'delete', $disenocurricular['Disenocurricular']['id']), array('confirm' => 'Está seguro de borrar el Diseño Curricular '.$disenocurricular['Disenocurricular']['resolucion_id'], 'class' => 'btn btn-danger','escape' => false)); ?></span>
           <?php endif; ?>  
 		</div>
	</div>
</div>
