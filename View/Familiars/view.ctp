<?php echo $this->Html->script(array('acordeon', 'slider')); ?>
<div class="TituloSec">Familiares </div>
<div id="ContenidoSec">	
    <div class="row"><div class="col-md-8">
        <div class="unit perfil">
		    <div class="subtitulo"><?php echo ($familiar['Familiar']['vinculo']); ?></div>
	        <div class="row">
	            <div class="col-md-6 col-sm-6">
                    <b>Nombre completo:</b>		
                    <?php echo ($personaNombre[$familiar['Familiar']['persona_id']]); ?><br>
                    <b>Nacionalidad:</b>		
                    <?php echo ($personaNacionalidad[$familiar['Familiar']['persona_id']]); ?><br>
                    <b>Cuil/Cuit:</b>		
                    <?php echo ($personaCuilCuit[$familiar['Familiar']['persona_id']]); ?><br>
                    <b>Ocupación:</b>		
                    <?php echo ($personaOcupacion[$familiar['Familiar']['persona_id']]); ?><br>
                    <b>Lugar de trabajo:</b>		
                    <?php echo ($personaLugarTrabaja[$familiar['Familiar']['persona_id']]); ?><br>
                    <b>Observaciones:</b>
                    <?php echo ($familiar['Familiar']['observaciones']); ?>
                </div>
                <div class="col-md-6 col-sm-6">
                    <b>Ciudad:</b>
                    <?php echo ($ciudades[$personaCiudad[$familiar['Familiar']['persona_id']]]); ?><br>
                    <b>Domicilio:</b>
                    <?php echo ($personaCalleNombre[$familiar['Familiar']['persona_id']]). ' ' . ($personaCalleNumero[$familiar['Familiar']['persona_id']]); ?><br>
                    <b>Telefono:</b>
                    <?php echo ($personaTelefono[$familiar['Familiar']['persona_id']]); ?><br>
                    <b>Email:</b>
                    <?php echo ($personaEmail[$familiar['Familiar']['persona_id']]); ?><br>
                </div>
		    </div>
	    </div>
    </div>
    <div class="col-md-4">
        <div class="unit">
            <div class="subtitulo">Opciones</div>
            <div class="opcion"><?php echo $this->Html->link(__('Listar Alumnos'), array('action' => 'index', 'controller' => 'alumnos')); ?></div>
            <div class="opcion"><?php echo $this->Html->link(__('Editar'), array('action' => 'edit', $familiar['Familiar']['id'])); ?></div>
          <?php if($current_user['role'] == 'superadmin'): ?>  
            <div class="opcion"><?php echo $this->Html->link(__('Borrar'), array('action' => 'delete', $familiar['Familiar']['id'] ), null, sprintf(__('Esta seguro de borrar el familiar "'.$familiar['Familiar']['id'].'"'), $this->Form->value('Familiar.id'))); ?>
            </div>
          <?php endif; ?>  
        </div>
    </div>	
</div>
<!-- Alumnos Relacionados -->
<div id="click_01" class="titulo_acordeon">Alumnos Relacionados <span class="caret"></span></div>
<div id="acordeon_01">
    <div class="row">
    <?php if (!empty($familiar['Alumno'])):?>
    <div class="col-xs-12 col-sm-6 col-md-8">
    <?php foreach ($familiar['Alumno'] as $alumno): ?>
        <div class="col-md-4">
            <div class="unit">
                <?php echo '<b>Documento:</b> '.$personaDocumentoTipo[$alumnoPersonaId[$alumno['id']]]. ' '.$personaDocumentoNro[$alumnoPersonaId[$alumno['id']]];?><br>
                <?php echo '<b>Nombre Completo:</b> '.$personaNombre[$alumnoPersonaId[$alumno['id']]];?><br>
                <hr>
                <div class="text-right">
                <?php echo $this->Html->link(__('<i class= "glyphicon glyphicon-edit"></i>'), array('controller' => 'alumnos', 'action' => 'edit', $alumno['id']), array('class' => 'btn btn-warning', 'escape' => false)); ?>
                <?php echo $this->Html->link(__('<i class= "glyphicon glyphicon-eye-open"></i>'), array('controller' => 'alumnos', 'action' => 'view', $alumno['id']), array('class' => 'btn btn-success','escape' => false)); ?>
              <?php if($current_user['role'] == 'superadmin'): ?>  
                <?php echo $this->Html->link(__('<i class= "glyphicon glyphicon-trash"></i>'), array('controller' => 'alumnos', 'action' => 'delete', $alumno['id']), array('class' => 'btn btn-danger','escape' => false)); ?>
              <?php endif; ?>  
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php else: echo '<div class="col-md-12"><div class="unit text-center">No se encuentran relaciones.</div></div>'; ?>
    <?php endif; ?>
    </div>
</div>  
<!-- end Alumnos Relacionados -->
