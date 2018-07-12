<div class="col-md-4">
	<div class="unit">
        <span class="name"><span class="glyphicon glyphicon-calendar"></span> <b>Institución:</b> 
        <?php echo $this->Html->link($centrosNombre[$materia['Curso']['centro_id']], array('controller' => 'centros', 'action' => 'view', $materia['Curso']['centro_id'])); ?></span><br/>
        <span class="name"><span class="glyphicon glyphicon-info-sign"></span> <b>Alia: </b> <?php echo $materia['Materia']['alia']; ?></span><br/>
        <span class="name"><span class="glyphicon glyphicon-info-sign"></span> <b>Dictado: </b> <?php echo $materia['Materia']['dictado']; ?></span><br/>
         <!--<span class="name"><span class="glyphicon glyphicon-info-sign"></span> <b>Obligatoriedad: </b> <?php echo $materia['Materia']['obligatoriedad']; ?></span><br/>-->
		<hr />
        <div class="text-right">
            <span class="link"><?php echo $this->Html->link('<i class="glyphicon glyphicon-eye-open"></i>', array('controller' => 'materias', 'action' => 'view', $materia['Materia']['id']), array('class' => 'btn btn-success','escape' => false)); ?></span>
           <?php if($current_user['role'] == 'superadmin'): ?>
            <span class="link"><?php echo $this->Html->link(__('<i class="glyphicon glyphicon-edit"></i>'), array('action' => 'edit', $materia['Materia']['id']), array('class' => 'btn btn-warning','escape' => false)); ?></span>
            <span class="link"><?php echo $this->Html->link('<i class="glyphicon glyphicon-trash"></i>', array('controller' => 'materias', 'action' => 'delete', $materia['Materia']['id']), array('confirm' => 'Está seguro de borrar la materia '.$materia['Materia']['alia'], 'class' => 'btn btn-danger','escape' => false)); ?></span>
           <?php endif; ?>  
 		</div>
	</div>
</div>
