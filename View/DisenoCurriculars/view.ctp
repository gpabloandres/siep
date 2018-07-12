<?php echo $this->Html->script(array('acordeon', 'slider')); ?>
<?php echo $this->Html->css('slider'); ?>
<!-- start main -->
<div class="TituloSec">Diseño Curricular RESOL. <?php echo ($resolucions[$disenocurricular['Disenocurricular']['resolucion_id']]); ?></div>
<div id="ContenidoSec">
    <div class="row">
        <div class="col-md-8">	
	        <div class="unit">
 		        <div class="row perfil">
                    <!--Datos generales-->
                    <div class="col-md-6 col-sm-4 col-xs-12">	
                        <b><?php echo __('Titulación:'); ?></b>
                           <?php echo $this->Html->link($titulacions[$disenocurricular['Disenocurricular']['titulacion_id']], array('action' => 'view', $disenocurricular['Disenocurricular']['titulacion_id'])); ?></p>
                        <b><?php echo __('Año de elaboración:'); ?></b>
                           <?php echo h($disenocurricular['Disenocurricular']['anio']); ?></p>
                        <b><?php echo __('Resolución N°:'); ?></b>
                           <?php echo $this->Html->link($resolucions[$disenocurricular['Disenocurricular']['resolucion_id']], array('action' => 'view', $disenocurricular['Disenocurricular']['resolucion_id'])); ?></p>
                    </div><!--/Datos generales-->
                    <div class="col-md-6 col-sm-4 col-xs-12">
                    <!--Datos específicos-->
                     <div id="click_01" class="titulo_acordeon_datos">Detalle <span class="caret"></span></div>
                         <div id="acordeon_01">
                            <div class="unit">
                                <b><?php echo __('Contenidos:'); ?></b>
                                <?php echo h($disenocurricular['Disenocurricular']['contenidos']); ?></p>
                                <b><?php echo __('Plan de estudio:'); ?></b>
                                <?php echo h($disenocurricular['Disenocurricular']['plan_de_estudio']); ?></p></p>
                            </div>
                        </div><!--/Datos específicos-->
                        <!--Datos de los participantes-->
                        <div id="click_02" class="titulo_acordeon_datos">Docentes Participantes <span class="caret"></span></div>
                        <div id="acordeon_02">
                          <div class="unit">
                                <?php echo h($disenocurricular['Disenocurricular']['participantes']); ?></p>
                          </div>         
                        </div><!--/Datos de los participantes-->
                    </div>
                </div>
             </div>
          </div>
          <div class="col-md-4">
          <div class="unit">
            <div class="subtitulo">Opciones</div>
            <div class="opcion"><?php echo $this->Html->link(__('Listar Diseños'), array('action' => 'index')); ?> </div>
            <div class="opcion"><?php echo $this->Html->link(__('Editar'), array('action' => 'edit', $disenocurricular['Disenocurricular']['id'])); ?> </div>
            <div class="opcion"><?php echo $this->Html->link(__('Borrar'), array('action' => 'delete', $disenocurricular['Disenocurricular']['id']), null, sprintf(__('Esta seguro de borrar la mesa de exámen %s?'), $disenocurricular['Disenocurricular']['id'])); ?></div>
            </div>
     </div>
</div>
<!-- end main -->
<!-- Espacios Relacionados -->
<div id="click_03" class="titulo_acordeon">Unidades Curriculares Relacionadas <span class="caret"></span></div>
<div id="acordeon_03">
    <div class="row">
  <?php if (!empty($disenocurricular['Materia'])):?>
    <!-- Swiper --> 
    <div class="swiper-container" style="height: 200px;">
        <div class="swiper-wrapper" >
  <?php foreach ($disenocurricular['Materia'] as $materia): ?>
  <div class="swiper-slide">
  <div class="col-md-6">
    <div class="unit">
      <?php echo '<b>Nombre:</b> '.$materia['nombre'];?><br>
      <?php echo '<b>Alia:</b> '.($this->Html->link($materia['alia'], array('controller' => 'materias', 'action' => 'view', $materia['id'])));?><br>
      <?php echo '<b>Carga horaria en:</b> '.$materia['carga_horaria_en'];?><br>
      <?php echo '<b>Carga horaria semanal:</b> '.$materia['carga_horaria_semanal'];?><br>
        <div class="text-right">
            <?php echo $this->Html->link(__('<i class="glyphicon glyphicon-eye-open"></i>'), array('controller' => 'materias', 'action' => 'view', $materia['id']), array('class' => 'btn btn-success','escape' => false)); ?>
          <?php if($current_user['role'] == 'superadmin'): ?> 
        <?php echo $this->Html->link(__('<i class="glyphicon glyphicon-edit"></i>'), array('controller' => 'materias', 'action' => 'edit', $materia['id']), array('class' => 'btn btn-warning','escape' => false)); ?>  
      <?php echo $this->Html->link(__('<i class="glyphicon glyphicon-trash"></i>'), array('cont""roller' => 'materias', 'action' => 'delete', $materia['id']), array('class' => 'btn btn-danger','escape' => false)); ?>
          <?php endif; ?>  
            </div>
    </div>
  </div>
</div>
    <?php endforeach; ?>
      </div>
              <!-- Add Pagination --> 
        <div class="swiper-pagination"></div>
    </div>
    <!-- Include plugin after Swiper -->
    <?php else: echo '<div class="col-md-12"><div class="unit text-center">No se encuentran relaciones.</div></div>'; ?>
    <?php endif; ?>
    </div>
</div>
<!-- end Espacios Relacionados -->