<?php echo $this->Html->script(array('acordeon', 'slider')); ?>
<?php echo $this->Html->css('slider.css'); ?>
<!-- start main -->
<div class="TituloSec">Pase <?php echo ($pase['Pase']['pase_nro']); ?></div>
<div id="ContenidoSec">
    <div class="row">
        <div class="col-md-8">
             <div class="unit">
                <div class="row perfil">
                    <div class="col-md-8 col-sm-6 col-xs-8">
                        <b><?php echo __('Fecha de Inicio: '); ?></b>
                            <?php echo ($pase['Pase']['created']); ?></p>
                        <b><?php echo __('Ciclo: '); ?></b>
                            <?php echo $ciclos; ?></p>
                        <b><?php echo __('Alumno: '); ?></b>
                            <?php echo ($this->Html->link($personaNombre, array('controller' => 'alumnos', 'action' => 'view', $pase['Pase']['alumno_id']))); ?></p>
                        <b><?php echo __('Institución de Destino: '); ?></b>
                            <?php echo ($this->Html->link($centros[$pase['Pase']['centro_id_destino']], array('controller' => 'centros', 'action' => 'view', $pase['Pase']['centro_id_destino']))); ?></p>
                        <b><?php echo __('Año de estudio: '); ?></b>
                            <?php echo ($pase['Pase']['anio']); ?></p>    
                        <b><?php echo __('Tipo: '); ?></b>
                            <?php echo ($pase['Pase']['tipo']); ?></p>
                        <b><?php echo __('Motivo: '); ?></b>
                            <?php echo ($pase['Pase']['motivo']); ?></p>
                        <b><?php echo __('Documentación: '); ?></b>
                            <?php echo ($pase['Pase']['estado_documentacion']); ?></p>
                        <b><?php echo __('Estado: '); ?></b>
                            <?php echo ($pase['Pase']['estado_pase'])." desde el ".($pase['Pase']['modified']); ?></p>
                        <b><?php echo __('Observaciones: '); ?></b>
                            <?php echo ($pase['Pase']['observaciones']); ?></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="unit">
                <div class="subtitulo">Opciones</div>
                <div class="opcion"><?php echo $this->Html->link(__('Listar Pases'), array('action' => 'index')); ?></div>
              <?php if($current_user['role'] == 'superadmin'): ?>
                <div class="opcion"><?php echo $this->Html->link(__('Editar'), array('action' => 'edit', $pase['Pase']['id'])); ?></div>
                <div class="opcion"><?php echo $this->Html->link(__('Borrar'), array('action' => 'delete', $pase['Pase']['id']), null, sprintf(__('Esta seguro de borrar el pase %s?'), $pase['Pase']['id'])); ?></div>
              <?php endif; ?>
            </div>
        </div>
    </div>
<!-- end main -->
