<?php echo $this->Html->script(array('acordeon', 'slider')); ?>
<?php echo $this->Html->css('slider.css'); ?>

<!-- start main -->
<div class="TituloSec">Alumno</div>
  <div id="ContenidoSec">
     <div class="row">
        <div class="col-md-8">	
	       <div class="unit">
 		      <div class="row perfil">
                 <div class="col-md-8 col-sm-6 col-xs-8">	
                    <b><?php echo __('Alumno: '); ?></b>
                    <?php echo $this->Html->link($alumno['persona']['nombre_completo'], array('controller' => 'personas', 'action' => 'view', $alumno['persona']['id'])); ?></p>
                    <b><?php echo __('Documento: '); ?></b>
                    <?php echo $alumno['persona']['documento_tipo'].' '.$alumno['persona']['documento_nro']; ?></p>
                    <b><?php echo __('Edad: '); ?></b>
                    <?php echo $alumno['persona']['edad']." ".'años'; ?></p>
                    <b><?php echo __('Legajo Físico N°: '); ?></b>
                    <?php echo $alumno['legajo_fisico_nro']; ?></p>
                 </div>
 	          </div>
         </div>
    </div>

		 <?php
		 	$SIEP_API_GW_INGRESS = env('SIEP_API_GW_INGRESS');
			 if(!$SIEP_API_GW_INGRESS) {
				 $SIEP_API_GW_INGRESS = 'http://api.sieptdf.org';
			 }
		 ?>
<!-- star sidebar -->
<div class="col-md-4">
 <div class="unit">
        <div class="subtitulo">Opciones</div>
        <div class="opcion"><a href="<?php echo $SIEP_API_GW_INGRESS."/api/v1/personas/".$alumno['persona_id']."/ficha"?>" target="_blank">Ficha de Alumno</a></div>
        <div class="opcion"><?php echo $this->Html->link(__('Listar Alumnos'), array('action' => 'index')); ?></div>
       <?php if($current_user['role'] == 'superadmin' && $current_user['puesto'] == 'Sistemas'): ?>
        <div class="opcion"><?php echo $this->Html->link(__('Editar'), array('action' => 'edit', $alumno['id'])); ?></div>
        <div class="opcion"><?php echo $this->Html->link(__('Borrar'), array('action' => 'delete', $alumno['id']), null, sprintf(__('¿Está seguro de borrar este alumno?'))); ?></div>
        <?php /*
        <!--<div class="opcion"><?php echo $this->Html->link(__('Export to PDF'), array('action' => 'view', $alumno['id'], 'ext' => 'pdf')); ?></div>-->
        <!--<div class="opcion"><?php echo $this->Html->link(__('Agregar Familiar'), array('controller' => 'familiars', 'action' => 'add')); ?></div>-->
        <!--<div class="opcion"><?php echo $this->Html->link(__('Agregar Integracion'), array('controller' => 'integracions', 'action' => 'add')); ?></div>
        <div class="opcion"><?php echo $this->Html->link(__('Agregar Servicio'), array('controller' => 'servicios', 'action' => 'add')); ?></div>
        <div class="opcion"><?php echo $this->Html->link(__('Agregar Calificación'), array('controller' => 'notas', 'action' => 'add')); ?></div>
        <div class="opcion"><?php echo $this->Html->link(__('Agregar Inasistencia'), array('controller' => 'inasistencias', 'action' => 'add')); ?></div>-->
        */ ?>
      <?php endif; ?>	
	</div>
  </div>
</div> 
<!-- end main -->
<!-- Familiares Relacionados -->
<div id="click_01" class="titulo_acordeon">Familiares Relacionados <span class="caret"></span></div>
<div id="acordeon_01">
	<div class="row">			
	<?php if (!empty($alumno['familiares'])):?>
		<div class="col-xs-12 col-sm-6 col-md-8">
			<?php foreach ($alumno['familiares'] as $familiar): ?>
            <div class="col-md-4">
                <div class="unit">
                    <?php echo '<b>Vinculo:</b> '.$familiar['vinculo'];?><br>
                    <?php echo '<b>Nombre:</b> '.$familiar['persona']['nombre_completo'];?><br>
                    <?php echo '<b>Telefono:</b> '.$familiar['persona']['telefono_nro'];?>
                    <hr>
                    <div class="text-right">
	                    <?php echo $this->Html->link(__('<i class="glyphicon glyphicon-eye-open"></i>'), array('controller' => 'familiars', 'action' => 'view', $familiar['id']), array('class' => 'btn btn-success','escape' => false)); ?>
	                    <?php if($current_user['role'] == 'superadmin' && $current_user['puesto'] == 'Sistemas'): ?> 
	                    <?php echo $this->Html->link(__('<i class="glyphicon glyphicon-edit"></i>'), array('controller' => 'familiars', 'action' => 'edit', $familiar['id']), array('class' => 'btn btn-warning','escape' => false)); ?>
	                    <?php echo $this->Html->link(__('<i class="glyphicon glyphicon-trash"></i>'), array('controller' => 'familiars', 'action' => 'delete', $familiar['id']), array('class' => 'btn btn-danger','escape' => false)); ?>
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
<!-- end Familiares Relacionados -->
<!-- Inscripciones Relacionadas -->
	<div id="click_02" class="titulo_acordeon">Inscripciones Relacionadas <span class="caret"></span></div>
	<div id="acordeon_02">
		<div class="row">
			<?php if (!empty($alumno['inscripciones'])):?>
  			<div class="col-xs-12 col-sm-6 col-md-8">
				<?php foreach ($alumno['inscripciones'] as $inscripcion):	?>
			<div class="col-md-4">
				<div class="unit">
					<!--<?php echo '<b>Ciclo id:</b> '.($this->Html->link($inscripcion['ciclo_id'], array('controller' => 'ciclos', 'action' => 'view', $inscripcion['ciclo_id'])));?><br>-->
					<?php if (($current_user['role'] == 'superadmin') || ($current_user['role'] == 'usuario')): ?>
					<?php echo '<b>Centro:</b> '.($this->Html->link($siglaCentroId[$inscripcion['centro_id']], array('controller' => 'centros', 'action' => 'view', $inscripcion['centro_id'])));?><br>
					<?php endif; ?>
					<?php echo '<b>Código:</b> '.$inscripcion['legajo_nro'];?><br>
					<?php echo '<b>Tipo de alta:</b> '.$inscripcion['tipo_alta'];?><br>
					<?php echo '<b>Estado de la Inscripción:</b> '.$inscripcion['estado_inscripcion'];?><br>
					<?php /*
					<!--<?php echo '<b>Fecha de alta:</b> '.$this->Html->formatTime($inscripcion['fecha_alta']);?><br>-->
					<!--<?php echo '<b>Cursa:</b> '.$inscripcion['cursa'];?><br>
		            <?php echo '<b>Fecha de baja:</b> '.$this->Html->formatTime($inscripcion['fecha_baja']);?><br>
					<?php echo '<b>Tipo de baja:</b> '.$inscripcion['tipo_baja'];?><br>
		            <?php echo '<b>Fecha de egreso:</b> '.$this->Html->formatTime($inscripcion['fecha_egreso']);?><br>
		            <!--<?php echo '<b>Nota:</b> '.$inscripcion['nota'];?><br>-->
		            */ ?>
		            <b>Documentación:</b> <?php if($inscripcion['estado_documentacion'] == "COMPLETA"){; ?><span class="label label-success"><?php echo $inscripcion['estado_documentacion']; ?></span><?php } else{; ?><span class="label label-danger"><?php echo $inscripcion['estado_documentacion']; ?></span><?php } ?></br>
		            <hr>
		            <div class="text-right">
			            <?php echo $this->Html->link(__('<i class="glyphicon glyphicon-eye-open"></i>'), array('controller' => 'inscripcions', 'action' => 'view', $inscripcion['id']), array('class' => 'btn btn-success','escape' => false)); ?>
			          <?php if($current_user['role'] == 'superadmin' && $current_user['puesto'] == 'Sistemas'): ?>	
					    <?php echo $this->Html->link(__('<i class="glyphicon glyphicon-edit"></i>'), array('controller' => 'inscripcions', 'action' => 'edit', $inscripcion['id']), array('class' => 'btn btn-warning','escape' => false)); ?>	
						<?php echo $this->Html->link(__('<i class="glyphicon glyphicon-trash"></i>'), array('controller' => 'inscripcions', 'action' => 'delete', $inscripcion['id']), array('class' => 'btn btn-danger','escape' => false)); ?>
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
<!-- end Inscripciones Relacionadas -->
<?php /*
<?php if ((($current_user['role'] == 'superadmin') || ($current_user['role'] == 'usuario')) || (($nivelCentro === 'Común - Secundario'))): ?>
<!-- Pases Relacionados -->
	<div id="click_03" class="titulo_acordeon">Pases Relacionados <span class="caret"></span></div>
	<div id="acordeon_03">
		<div class="row">
			<?php if (!empty($alumno['Pase'])):?>
  			<div class="col-xs-12 col-sm-6 col-md-8">
				<?php foreach ($alumno['Pase'] as $pase):	?>
			<div class="col-md-4">
				<div class="unit">
					<?php echo '<b>Ciclo:</b> '.($this->Html->link($cicloNombre[$pase['ciclo_id']], array('controller' => 'ciclos', 'action' => 'view', $pase['ciclo_id'])));?><br>
					<?php if (($current_user['role'] == 'superadmin') || ($current_user['role'] == 'usuario')) { ?>
						<?php echo '<b>Centro de Origen:</b> '.($this->Html->link($centroNombre[$pase['centro_id_origen']], array('controller' => 'centros', 'action' => 'view', $pase['centro_id_origen'])));?><br>
						<?php echo '<b>Centro de Destino:</b> '.($this->Html->link($centroNombre[$pase['centro_id_destino']], array('controller' => 'centros', 'action' => 'view', $pase['centro_id_destino'])));?><br>
					<?php } ?>	
					<?php if ($current_user['role'] == 'admin') { ?>
						<?php echo '<b>Centro de Destino:</b> '.($this->Html->link($centroNombre[$pase['centro_id_destino']], array('controller' => 'centros', 'action' => 'view', $pase['centro_id_destino'])));?><br>
					<?php } ?>
					<!--<?php// echo '<b>Código:</b> '.$inscripcion['legajo_nro'];?><br>-->
					<!--<?php// echo '<b>Alumno:</b> '.($this->Html->link($personaNombre[$personaId[$pase['alumno_id']]], array('controller' => 'alumnos', 'action' => 'view', $pase['alumno_id'])));?><br>-->
		            <b>Documentación:</b> <?php if($pase['estado_documentacion'] == "COMPLETA"){; ?><span class="label label-success"><?php echo $pase['estado_documentacion']; ?></span><?php } else{; ?><span class="label label-danger"><?php echo $pase['estado_documentacion']; ?></span><?php } ?></br>
		            <?php echo '<b>Estado:</b> '.$pase['estado_pase'];?><br>
		            <hr>
		            <div class="text-right">
			            <?php echo $this->Html->link(__('<i class="glyphicon glyphicon-eye-open"></i>'), array('controller' => 'pases', 'action' => 'view', $pase['id']), array('class' => 'btn btn-success','escape' => false)); ?>
			          <?php if(($current_user['role'] == 'superadmin')): ?>
			            <?php echo $this->Html->link(__('<i class="glyphicon glyphicon-edit"></i>'), array('controller' => 'pases', 'action' => 'edit', $pase['id']), array('class' => 'btn btn-warning','escape' => false)); ?>
					  	<?php echo $this->Html->link(__('<i class="glyphicon glyphicon-trash"></i>'), array('controller' => 'pases', 'action' => 'delete', $pase['id']), array('class' => 'btn btn-danger','escape' => false)); ?>
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
<!-- end Pases Relacionados -->
<?php endif; ?>
<?php /*
<!-- Integraciones Relacionadas 
	<div id="click_03" class="titulo_acordeon">Integraciones Relacionadas <span class="caret"></span></div>
	<div id="acordeon_03">
		<div class="row">
		<?php if (!empty($alumno['Integracion'])):?>
  			<div class="col-xs-12 col-sm-6 col-md-8">
	<?php foreach ($alumno['Integracion'] as $integracion):	?>
	<div class="col-md-6">
		<div class="unit">
			<?php echo '<b>Ciclo ID:</b> '.($this->Html->link($integracion['ciclo_id'], array('controller' => 'ciclos', 'action' => 'view', $integracion['ciclo_id'])));?><br>
			<?php echo '<b>Centro integrador:</b> '.($this->Html->link($integracion['centro_id'], array('controller' => 'centros', 'action' => 'view', $integracion['centro_id'])));?><br>
			<?php echo '<b>Docente integrador:</b> '.$integracion['docente_nombre_completo'];?><br>
			<?php echo '<b>Fecha de inicio:</b> '.$this->Html->formatTime($integracion['fecha_inicio']);?><br>
            <?php echo '<b>Fecha de fin:</b> '.$this->Html->formatTime($integracion['fecha_fin']);?><br>
            <div class="text-right">
            <?php echo $this->Html->link(__('<i class="glyphicon glyphicon-edit"></i>'), array('controller' => 'integracions', 'action' => 'edit', $integracion['id']), array('class' => 'btn btn-warning','escape' => false)); ?>
			<?php echo $this->Html->link(__('<i class= "glyphicon glyphicon-eye-open"></i>'), array('controller' => 'integracions', 'action' => 'view', $integracion['id']), array('class' => 'btn btn-success','escape' => false)); ?>
			<?php echo $this->Html->link(__('<i class= "glyphicon glyphicon-trash"></i>'), array('controller' => 'integracions', 'action' => 'delete', $integracion['id']), array('class' => 'btn btn-danger','escape' => false)); ?>
			</div>
		</div>
	</div>
		<?php endforeach; ?>
			</div>
		<?php else: echo '<div class="col-md-12"><div class="unit text-center">No se encuentran relaciones.</div></div>'; ?>
		<?php endif; ?>
	</div>
</div>
<!-- end Integraciones Relacionadas -->
<!-- Servicios Complementarios Relacionadas 
	<div id="click_04" class="titulo_acordeon">Servicios Complementarios Relacionadas <span class="caret"></span></div>
	<div id="acordeon_04">
		<div class="row">
			<?php if (!empty($alumno['Servicio'])):?>
  			<div class="col-xs-12 col-sm-6 col-md-8">
	<?php foreach ($alumno['Servicio'] as $servicio): ?>
	<div class="col-md-6">
		<div class="unit">
			<?php echo '<b>Ciclo ID:</b> '.($this->Html->link($servicio['ciclo_id'], array('controller' => 'ciclos', 'action' => 'view', $servicio['ciclo_id'])));?><br>
			<?php echo '<b>Tipo:</b> '.$servicio['tipo_servicio'];?><br>
			<?php echo '<b>Estado:</b> '.$servicio['estado'];?><br>
			<?php echo '<b>Docente/Profesional a cargo:</b> '.$servicio['docente_profesional_acargo'];?><br>
            <?php echo '<b>Fecha de alta:</b> '.$this->Html->formatTime($servicio['fecha_alta']);?><br>
            <?php echo '<b>Fecha de baja:</b> '.$this->Html->formatTime($servicio['fecha_baja']);?><br>
            <div class="text-right">
            <?php echo $this->Html->link(__('<i class= "glyphicon glyphicon-edit"></i>'), array('controller' => 'servicios', 'action' => 'edit', $servicio['id']), array('class' => 'btn btn-warning','escape' => false)); ?>
			<?php echo $this->Html->link(__('<i class= "glyphicon glyphicon-eye-open"></i>'), array('controller' => 'servicios', 'action' => 'view', $servicio['id']), array('class' => 'btn btn-success','escape' => false)); ?>
			<?php echo $this->Html->link(__('<i class= "glyphicon glyphicon-trash"></i>'), array('controller' => 'integracions', 'action' => 'delete', $servicio['id']), array('class' => 'btn btn-danger','escape' =>false)); ?>
			</div>
		</div>
	</div>
		<?php endforeach; ?>
			</div>
		<?php else: echo '<div class="col-md-12"><div class="unit text-center">No se encuentran relaciones.</div></div>'; ?>
		<?php endif; ?>
	</div>
</div>
<!-- end Servicios Complementarios Relacionadas -->
<!-- Inasistencias Relacionadas  
	<div id="click_06" class="titulo_acordeon">Inasistencias Relacionadas <span class="caret"></span></div>
	<div id="acordeon_06">
		<div class="row">
		<?php if (!empty($alumno['Inasistencia'])):?>
  			<div class="col-xs-12 col-sm-6 col-md-8">
	<?php foreach ($alumno['Inasistencia'] as $inasistencia): ?>
	<div class="col-md-6">
		<div class="unit">
			<?php echo '<b>Ciclo Id:</b> '.($this->Html->link($inasistencia['ciclo_id'], array('controller' => 'ciclos', 'action' => 'view', $inasistencia['ciclo_id'])));?><br>
			<?php echo '<b>Tipo:</b> '. $inasistencia['tipo'];?><br>
			<?php echo '<b>Causa:</b> '.$inasistencia['causa'];?><br>
            <?php echo '<b>Justificado:</b> '.$inasistencia['justificado'];?><br>
            <?php echo '<b>Fecha:</b> '.$this->Html->formatTime($inasistencia['created']);?><br>
            <div class="text-right">
	            <?php echo $this->Html->link(__('<i class= "glyphicon glyphicon-edit"></I>'), array('controller' => 'inasistencias', 'action' => 'edit', $inasistencia['id']), array('class' => 'btn btn-warning','escape' => false)); ?>
				<?php echo $this->Html->link(__('<i class= "glyphicon glyphicon-eye-open"></i>'), array('controller' => 'inasistencias', 'action' => 'view', $inasistencia['id']), array('class' => 'btn btn-success','escape' => false)); ?>
				<?php echo $this->Html->link(__('<i class= "glyphicon glyphicon-trash"></i>'), array('controller' => 'inasistencias', 'action' => 'delete', $inasistencia['id']), array('class' => 'btn btn-danger','escape' => false)); ?>
			</div>
		</div>
	</div>
		<?php endforeach; ?>
			</div>
		<?php else: echo '<div class="col-md-12"><div class="unit text-center">No se encuentran relaciones.</div></div>'; ?>
		<?php endif; ?>
	</div>
</div>
<!-- end Inasistencias Relacionadas -->
<!-- Calificaciones Relacionadas 
<div id="click_05" class="titulo_acordeon">Calificaciones Relacionadas 
	<span class="caret"></span>
</div>
<div id="acordeon_05">
	<div class="row">
		<?php if (!empty($alumno['Nota'])):?>
  	<!-- Swiper 
	    <div class="swiper-container" style="height: 200px;">
    	    <div class="swiper-wrapper" >
				<?php foreach ($alumno['Nota'] as $nota): ?>
				<div class="swiper-slide">
					<div class="col-md-6">
						<div class="unit">
							<?php echo '<b>Ciclo:</b> '. ($this->Html->link($cicloNombre[$nota['ciclo_id']], array('controller' => 'ciclos', 'action' => 'view', $nota['ciclo_id'])));?><br>
							<?php echo '<b>Espacio:</b> '. ($this->Html->link($materiaAlia[$nota['materia_id']], array('controller' => 'materias', 'action' => 'view', $nota['materia_id'])));?><br>
							<?php echo '<b>Estado:</b>'?> <?php if($nota['estado'] == "En curso"){; ?><span class="label label-default"><?php echo $nota['estado']; ?></span><?php } else if($nota['estado'] == "Abandonada"){; ?><span class="label label-info"><?php echo $nota['estado']; ?></span><?php } else if($nota['estado'] == "Regularizada"){; ?><span class="label label-warning"><?php echo $nota['estado']; ?><?php } else if($nota['estado'] == "Desaprobada"){; ?><span class="label label-danger"><?php echo $nota['estado']; }?></span></br>		
				            <div class="text-right">
				            <?php echo $this->Html->link(__('<i class= "glyphicon glyphicon-edit"></i>'), array('controller' => 'notas', 'action' => 'edit', $nota['id']), array('class' => 'btn btn-warning','escape' => false )); ?>
							<?php echo $this->Html->link(__('<i class= "glyphicon glyphicon-eye-open"></i>'), array('controller' => 'notas', 'action' => 'view', $nota['id']), array('class' => 'btn btn-success','escape' => false)); ?>
							<?php echo $this->Html->link(__('<i class="glyphicon glyphicon-trash"></i>'), array('controller' => 'notas', 'action' => 'delete', $nota['id']), array('class' => 'btn btn-danger','escape' => false )); ?>
				        </div>
			        </div>
	            </div>
            </div>
		<?php endforeach; ?>
	</div>
	<!-- Add Pagination  
    <div class="swiper-pagination"></div>
    <!-- Include plugin after Swiper  
	<?php else: echo '<div class="col-md-12"><div class="unit text-center">No se encuentran relaciones.</div></div>'; ?>
	<?php endif; ?>
    </div>
  </div>
<!-- end Calificaciones Relacionadas -->
*/ ?>
</div>
<!-- Initialize Swiper -->
    <script>
    var swiper = new Swiper('.swiper-container', {
        pagination: '.swiper-pagination',
        paginationClickable: true,
    });
    </script>
