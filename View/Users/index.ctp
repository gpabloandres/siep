<!-- app/View/Users/index.ctp -->
<?php App::import('Vendor', 'delete_confirm.php');;  ?>
<div class="users form">
<!-- start main -->
    <div class="TituloSec">Administracion de Usuarios</div>
    <div id="ContenidoSec">
        <div class="row">
            <div class="col-xs-12 col-sm-10 col-md-12">
                <div id="second-nav">
                    <div class="unit text-center">
                        <span class="link"><?php echo $this->Html->link('<i class="glyphicon glyphicon-plus-sign"></i> AGREGAR', array('action' => 'add'), array('class' => 'btn btn-primary', 'escape' => false)); ?></span>
                    </div>
                </div>
                <div class="unit text-center">
                    <?php echo $this->element('formsSearch/formSearch_user'); ?>
                </div>   
                <div class="table-responsive">
                  <table class="table table-bordered table-hover table-condensed">
                    <thead>
                        <tr>
                          <th><?php echo $this->Form->checkbox('all', array('name' => 'CheckAll',  'id' => 'CheckAll')); ?></th>
                          <th><?php echo $this->Paginator->sort('username', 'Usuario');?>  </th>
                          <!--<th><?php echo $this->Paginator->sort('role','Rol');?></th>-->
                          <th><?php echo $this->Paginator->sort('centro_id', 'Centro');?></th>
                          <th><?php echo $this->Paginator->sort('puesto', 'Puesto');?></th>
                          <th><?php echo $this->Paginator->sort('empleado_id', 'Agente');?></th>
                          <th><?php echo $this->Paginator->sort('email', 'E-Mail');?></th>
                          <!--<th><?php echo $this->Paginator->sort('created', 'Creado');?></th>-->
                          <!--<th><?php echo $this->Paginator->sort('modified','Modificado');?></th>-->
                          <!--<th><?php echo $this->Paginator->sort('status','Estado');?></th>-->
                          <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>						
                        <?php $count=0; ?>
                        <?php foreach($users as $user): ?>				
                        <?php $count ++;?>
                        <?php if($count % 2): echo '<tr>'; else: echo '<tr class="zebra">' ?>
                        <?php endif; ?>
                            <td><?php echo $this->Form->checkbox('User.id.'.$user['User']['id']); ?></td>
                            <td><?php echo $this->Html->link( $user['User']['username']  ,   array('action'=>'edit', $user['User']['id']),array('escape' => false) );?></td>
                            <td style="text-align: center;"><?php echo $this->Html->link($user['Centro']['sigla'], array('controller' => 'centros', 'action' => 'view', $user['User']['centro_id'])); ?></td>
                            <td style="text-align: center;"><?php echo $user['User']['puesto']; ?></td>
                            <!--<td style="text-align: center;"><?php echo $user['User']['role']; ?></td>-->
                            <td style="text-align: center;"><?php echo $this->Html->link($user['Empleado']['nombre_completo_empleado'], array('controller' => 'empleados', 'action' => 'view', $user['User']['empleado_id'])); ?></td>
                            <td style="text-align: center;"><?php echo $this->Html->link($user['User']['email'], 'mailto:'.$user['User']['email']); ?></td>
                            <!--<td style="text-align: center;"><?php echo $this->Html->formatTime($user['User']['created']); ?></td>-->
                            <!--<td style="text-align: center;"><?php echo $this->Html->formatTime($user['User']['modified']); ?></td>-->
                            <!--<td style="text-align: center;"><?php echo $user['User']['status']; ?></td>-->
                            <td >
                             <span class="link"><?php echo $this->Html->link('<i class="glyphicon glyphicon-edit"></i>', array('action' => 'edit', $user['User']['id']), array('class' => 'btn btn-warning', 'escape' => false)); ?></span>
                            <?php if( $user['User']['status'] != 0){ ?>
                                <span class="link"><?php echo $this->Html->link('<i class="glyphicon glyphicon-eye-open"></i>', array('action' => 'view', $user['User']['id']), array('class' => 'btn btn-default', 'escape' => false)); ?></span>
                                <!--<span class="link"><?php echo $this->Html->link('<i class="glyphicon glyphicon-trash"></i>', array('action' => 'delete', $user['User']['id']), array('confirm' => 'Está seguro de borrar a '.$user['User']['username'], 'class' => 'btn btn-danger', 'escape' => false)); ?></span>-->
                                <span class="link"><?php echo $this->Html->link('<i class="glyphicon glyphicon-trash"></i>', array('action' => 'delete', $user['User']['id']), array('confirm' => 'Está seguro de borrar a '.$user['User']['username'], 'class' => 'btn btn-danger', 'escape' => false)); ?></span>
                            <?php } else{ ?>
                            	<span class="link"><?php echo $this->Html->link('<i class="glyphicon glyphicon-repeat"></i>', array('action' => 'activate', $user['User']['id']), array('class' => 'btn btn-danger', 'escape' => false)); ?></span>
                            <?php } ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php unset($user); ?>
                    </tbody>
                </table>
               </div>
               <br/>
               <div class="unit text-center">
                   <?php echo $this->element('pagination'); ?> 
               </div>
          </div>
      </div>    
</div>