<div class="col-md-4">
        <div class="unit">
        <span class="name"><span class="glyphicon glyphicon-calendar"></span> <b>Ciclo:</b> 
        <?php echo $this->Html->link($ciclos[$inscripcionsMateria['Inscripcion']['ciclo_id']], array('controller' => 'ciclos', 'action' => 'view', $inscripcionsMateria['Inscripcion']['ciclo_id'])); ?></span><br/>
        <span class="name"><span class="glyphicon glyphicon-calendar"></span> <b>Centro:</b> 
        <?php echo $this->Html->link($centros[$inscripcionsMateria['Inscripcion']['centro_id']], array('controller' => 'centros', 'action' => 'view', $inscripcionsMateria['Inscripcion']['centro_id'])); ?></span><br/>
        <span class="name"><span class="glyphicon glyphicon-info-sign"></span> <b>Espacio:</b> <?php echo $this->Html->link($inscripcionsMateria['Materia']['alia'], array('controller' => 'materias', 'action' => 'view',$inscripcionsMateria['Materia']['id']));?></span><br/>
        <span class="name"><span class="glyphicon glyphicon-info-sign"></span> <b>Alumno:</b>  <?php echo $this->Html->link($alumnoNombre[$inscripcionsMateria['Inscripcion']['alumno_id']], array('controller' => 'alumnos', 'action' => 'view', $inscripcionsMateria['Inscripcion']['alumno_id'])); ?></span><br/>
        <span class="name"><span class="glyphicon glyphicon-info-sign"></span> <b>Legajo Nº:</b> <?php echo $this->Html->link($inscripcionsMateria['Inscripcion']['legajo_nro'], array('controller' => 'inscripcions', 'action' => 'view', $inscripcionsMateria['Inscripcion']['id'])); ?></span><br/> 		   
	</div>
</div>
