<?php echo $this->Html->script(array('acordeon', 'slider')); ?>
<?php echo $this->Html->css('slider.css'); ?>
<!-- start main -->
<div class="TituloSec"><?php echo ($titulacion['Titulacion']['nombre']); ?></div>
   <div id="ContenidoSec">
      <div class="row">
         <div class="col-md-8">	
	        <div class="unit">
 		       <div class="row perfil">
                  <div class="col-md-4 col-sm-6 col-xs-8">
                      <div id="click_01" class="titulo_acordeon_datos">Datos Generales <span class="caret"></span></div>
                      <div id="acordeon_01">
                         <div class="unit">
                              <b><?php echo __('Orientación:'); ?></b>
                              <?php echo ($titulacion['Titulacion']['orientacion']); ?></p>
                              <b><?php echo __('Edad mínima:'); ?></b>
                              <?php echo ($titulacion['Titulacion']['edad_minima']); ?></p>
                              <b><?php echo __('Certificación:'); ?></b>
                              <?php echo ($titulacion['Titulacion']['certificacion']); ?></p>
                              <b><?php echo __('Condición de ingreso:'); ?></b>
                              <?php echo ($titulacion['Titulacion']['condicion_ingreso']); ?></p>
                              <b><?php echo __('Ciclo de implementación:'); ?></b>
                              <?php echo ($titulacion['Titulacion']['ciclo_implementacion']); ?></p>
                              <b><?php echo __('Ciclo de finalización:'); ?></b>
                              <?php echo ($titulacion['Titulacion']['ciclo_finalizacion']); ?></p>
                              <b><?php echo __('A término:'); ?></b>
                              <?php echo $titulacion['Titulacion']['a_termino']; ?></p>
                         </div>
                      </div>    
                  </div>            
                  <div class="col-md-4 col-sm-6 col-xs-8">
                      <div id="click_02" class="titulo_acordeon_datos">Datos Específicos <span class="caret"></span></div>
                      <div id="acordeon_02">
                         <div class="unit">            
                              <b><?php echo __('Organización del Plan:'); ?></b>
                              <?php echo ($titulacion['Titulacion']['organizacion_plan']); ?></p>
                              <b><?php echo __('Organización de la cursada:'); ?></b>
                              <?php echo ($titulacion['Titulacion']['organizacion_cursada']); ?></p>
                              <b><?php echo __('Forma del dictado:'); ?></b>
                              <?php echo ($titulacion['Titulacion']['forma_dictado']); ?></p>
                              <b><?php echo __('Carga horaria en:'); ?></b>
                              <?php echo ($titulacion['Titulacion']['carga_horaria_en']); ?></p>
                              <b><?php echo __('Carga horaria:'); ?></b>
                              <?php echo ($titulacion['Titulacion']['carga_horaria']); ?></p>
                              <b><?php echo __('Tiene articulación:'); ?></b>
                              <?php echo ($titulacion['Titulacion']['tiene_articulacion']); ?></p>
                              <b><?php echo __('Duración:'); ?></b>
                              <?php echo ($titulacion['Titulacion']['duracion']); ?></p>
                               <b><?php echo __('Duración en:'); ?></b>
                              <?php echo ($titulacion['Titulacion']['duracion_en']); ?></p>
                         </div>
                      </div>
                  </div>       
                  <div class="col-md-4 col-sm-6 col-xs-8">
                      <div id="click_03" class="titulo_acordeon_datos">Normativas <span class="caret"></span></div>
                      <div id="acordeon_03">
                         <div class="unit">
                              <b><?php echo __('Norma aprobada jurisdiccional:'); ?></b>
                              <?php echo ($titulacion['Titulacion']['norma_aprob_jur_tipo']); ?></p>
                              <b><?php echo __('Norma aprobada jurisdiccional tipo:'); ?></b>
                              <?php echo ($titulacion['Titulacion']['norma_aprob_jur_tipo']); ?></p>
                              <b><?php echo __('Norma aprobada jurisdiccional nro:'); ?></b>
                              <?php echo ($titulacion['Titulacion']['norma_aprob_jur_nro']); ?></p>
                              <b><?php echo __('Norma aprobada jurisdiccional año:'); ?></b>
                              <?php echo ($titulacion['Titulacion']['norma_aprob_jur_anio']); ?></p>
                              <b><?php echo __('Norma de validez nacional tipo:'); ?></b>
                              <?php echo ($titulacion['Titulacion']['norma_val_nac_tipo']); ?></p>
                              <b><?php echo __('Norma de validez nacional nro:'); ?></b>
                              <?php echo ($titulacion['Titulacion']['norma_val_nac_nro']); ?></p>
                              <b><?php echo __('Norma de validez nacional año:'); ?></b>
                              <?php echo ($titulacion['Titulacion']['norma_val_nac_anio']); ?></p>
                              <b><?php echo __('Norma de ratificación  jurisdiccional tipo:'); ?></b>
                              <?php echo ($titulacion['Titulacion']['norma_ratif_jur_tipo']); ?></p>
                              <b><?php echo __('Norma de ratificación  jurisdiccional nro:'); ?></b>
                              <?php echo ($titulacion['Titulacion']['norma_ratif_jur_nro']); ?></p>
                              <b><?php echo __('Norma de ratificación  jurisdiccional año:'); ?></b>
                              <?php echo ($titulacion['Titulacion']['norma_ratif_jur_anio']); ?></p>
                              <b><?php echo __('Norma de homologación tipo:'); ?></b>
                              <?php echo ($titulacion['Titulacion']['norma_homologacion_tipo']); ?></p>
                              <b><?php echo __('Norma de homologación nro:'); ?></b>
                              <?php echo ($titulacion['Titulacion']['norma_homologacion_nro']); ?></p>
                              <b><?php echo __('Norma de homologación año:'); ?></b>
                              <?php echo ($titulacion['Titulacion']['norma_homologacion_anio']); ?></p>
                         </div>
                     </div>
		         </div>
 	         </div>
         </div>
     </div>
   <div class="col-md-4">
       <div class="unit">
            <div class="subtitulo">Opciones</div>
            <div class="opcion"><?php echo $this->Html->link('Listar Titulaciones', array('controller' => 'titulacions', 'action' => 'index')); ?></div>
            <div class="opcion"><?php echo $this->Html->link(__('Editar'), array('action' => 'edit', $titulacion['Titulacion']['id'])); ?></div>
            <div class="opcion"><?php echo $this->Html->link(__('Borrar'), array('action' => 'delete', $titulacion['Titulacion']['id']), null, sprintf(__('Esta seguro de borrar la titulación %s?'), $titulacion['Titulacion']['nombre'])); ?></div>
        </div>
    </div>
 </div>
<!-- end main -->
<!-- Centros Relacionados -->
<div id="click_04" class="titulo_acordeon">Centros Relacionados <span class="caret"></span></div>
<div id="acordeon_04">
  <div class="row">
  <?php if (!empty($titulacion['Centro'])):?>
    <div class="col-xs-12 col-sm-6 col-md-8">
    <?php foreach ($titulacion['Centro'] as $centro): ?>
      <div class="col-md-4">
        <div class="unit">
          <?php echo ' <b>CUE N°:</b> '.$centro['cue']; ?><br/>
          <?php echo ' <b>Nombre:</b> '.$centro['sigla']; ?><br/>
          <?php echo ' <b>Ciudad:</b> '.$ciudades[$centro['ciudad_id']]; ?><br/>
          <?php echo ' <b>Teléfono:</b> '.$centro['telefono']; ?><br/>
          <hr>
            <div class="text-right">
              <?php echo $this->Html->link(__('<i class="glyphicon glyphicon-eye-open"></i>'), array('controller' => 'centros', 'action' => 'view', $centro['id']), array('class' => 'btn btn-success','escape' => false)); ?>
              <?php if($current_user['role'] == 'superadmin'): ?>
              <?php echo $this->Html->link(__('<i class="glyphicon glyphicon-edit"></i>'), array('controller' => 'centros', 'action' => 'edit', $centro['id']), array('class' => 'btn btn-warning','escape' => false)); ?>
              <?php echo $this->Html->link(__('<i class="glyphicon glyphicon-trash"></i>'), array('controller' => 'centros', 'action' => 'delete', $centro['id']), array('class' => 'btn btn-danger','escape' => false)); ?>
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
<!-- end Centros Relacionados -->
<!-- Diseños Curriculares Relacionados -->
<div id="click_05" class="titulo_acordeon">Diseños Curriculares Relacionados <span class="caret"></span></div>
<div id="acordeon_05">
  <div class="row">
  <?php if (!empty($titulacion['Disenocurricular'])):?>
    <div class="col-xs-12 col-sm-6 col-md-8">
    <?php foreach ($titulacion['Disenocurricular'] as $disenocurricular): ?>
      <div class="col-md-4">
        <div class="unit">
          <?php echo ' <b>Resolución N°:</b> '.$this->Html->link($resolucions[$disenocurricular['resolucion_id']], array('controller' => 'resolucions', 'action' => 'view', $disenocurricular['resolucion_id'])); ?></span><br/>
          <?php echo ' <b>Año:</b> '.$disenocurricular['anio']; ?><br/>
          <hr>
          <div class="text-right">
            <?php echo $this->Html->link(__('<i class="glyphicon glyphicon-eye-open"></i>'), array('controller' => 'disenocurriculars', 'action' => 'view', $disenocurricular['id']), array('class' => 'btn btn-success','escape' => false)); ?>
            <?php if($current_user['role'] == 'superadmin'): ?>
            <?php echo $this->Html->link(__('<i class="glyphicon glyphicon-edit"></i>'), array('controller' => 'disenocurriculars', 'action' => 'edit', $disenocurricular['id']), array('class' => 'btn btn-warning','escape' => false)); ?>
            <?php echo $this->Html->link(__('<i class="glyphicon glyphicon-trash"></i>'), array('controller' => 'disenocurriculars', 'action' => 'delete', $disenocurricular['id']), array('class' => 'btn btn-danger','escape' => false)); ?>
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
<!-- end Diseños Relacionados -->
<!-- Cursos Relacionados -->
<div id="click_06" class="titulo_acordeon">Secciones Relacionadas <span class="caret"></span></div>
<div id="acordeon_06">
  <div class="row">
  <?php if (!empty($titulacion['Curso'])):?>
    <div class="col-xs-12 col-sm-6 col-md-8">
    <?php foreach ($titulacion['Curso'] as $curso): ?>
      <div class="col-md-4">
        <div class="unit">
          <?php echo '<b>Anio y División:</b> '.($this->Html->link($curso['anio'], array('controller' => 'cursos', 'action' => 'view', $curso['id']))." ".($this->Html->link($curso['division'], array('controller' => 'cursos', 'action' => 'view', $curso['id']))));?><br>
          <?php echo '<b>Turno:</b> '.$curso['turno'];?><br>
          <?php echo '<b>AulaNro:</b> '.$curso['aula_nro'];?><br>
          <?php echo '<b>Cursada:</b> '.$curso['organizacion_cursada'];?><br>
          <hr>
          <div class="text-right">
            <?php echo $this->Html->link(__('<i class="glyphicon glyphicon-eye-open"></i>'), array('controller' => 'cursos', 'action' => 'view', $curso['id']), array('class' => 'btn btn-success','escape' => false)); ?>
            <?php if($current_user['role'] == 'superadmin'): ?>
            <?php echo $this->Html->link(__('<i class="glyphicon glyphicon-edit"></i>'), array('controller' => 'cursos', 'action' => 'edit', $curso['id']), array('class' => 'btn btn-warning','escape' => false)); ?>
            <?php echo $this->Html->link(__('<i class="glyphicon glyphicon-trash"></i>'), array('controller' => 'cursos', 'action' => 'delete', $curso['id']), array('class' => 'btn btn-danger','escape' => false)); ?>
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
<!-- end Cursos Relacionados -->
</div>
