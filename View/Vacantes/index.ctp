<div class="TituloSec">Filtro</div>
<div id="ContenidoSec">
    <?php echo $this->Form->create('Curso',array('type'=>'get','url'=>'index', 'novalidate' => true));?>
    <div class="row">
        <div class="col-xs-2">
            <div class="input select">
                <?php
                echo $this->Form->input('ciclo_id', array('options'=>$comboCiclo, 'default'=>$cicloIdActual, 'disabled' => true, 'label'=>false, 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Seleccione una opción'));
                ?>
            </div>
        </div>
        <div class="col-xs-2">
            <div class="input select">
                <?php
                echo $this->Form->input('sector', array('options'=>$comboSector, 'empty'=>'- Todos los sectores -', 'label'=>false, 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Seleccione una opción'));
                ?>
            </div>
        </div>
        <div class="col-xs-2">
            <div class="input select">
                <?php
                echo $this->Form->input('ciudad_id', array('options'=>$comboCiudad, 'empty'=>'- Todas las ciudades -', 'label'=>false, 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Seleccione una opción'));
                ?>
            </div>
        </div>

        <div class="col-xs-2">
            <div class="text-center">
                <span class="link">
                    <?php echo $this->Form->button('<span class="glyphicon glyphicon-search"></span> Aplicar filtro', array('class' => 'btn btn-primary')); ?>
                </span>
            </div>
        </div>
    </div>
    <?php echo $this->Form->end(); ?>
</div>
<?php
     $ocultar = false;
     if( $current_user['Centro']['nivel_servicio'] === 'Común - Inicial - Primario' ||
         $current_user['Centro']['nivel_servicio'] === 'Común - Inicial' ||
         $current_user['Centro']['nivel_servicio'] === 'Común - Primario' ) {
         $ocultar = true;
     }
?>
<div class="TituloSec">Matrículas y Vacantes por Agrupamientos</div>
<div id="ContenidoSec">
    <div class="table-responsive">
      <table id="tablaPieBuscador" class="table table-bordered table-hover table-striped    table-condensed">
      <thead>
        <tr>
          <th><?php echo $this->Paginator->sort('Centro.sigla', 'Centro');?>  </th>
          <th><?php echo $this->Paginator->sort('anio','Año');?></th>
          <th><?php echo $this->Paginator->sort('turno','Turno');?></th>
        <?php if(!$ocultar) : ?>
          <th><?php echo $this->Paginator->sort('plazas', 'Plaza');?></th>
        <?php endif ?>
          <th><?php echo $this->Paginator->sort('matricula', 'Matricula');?></th>
          <th><?php echo $this->Paginator->sort('por_hermanos', 'Por Hermanos');?></th>
        <?php if(!$ocultar) : ?>
          <th><?php echo $this->Paginator->sort('vacantes', 'VACANTES');?></th>
        <?php endif ?>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php $count=0; ?>
        <?php foreach($matriculas as $matricula): ?>
            <td>
              <?php echo $matricula['Centro']['sigla']; ?>
            </td>
            <td>
              <?php echo $matricula['Curso']['anio']; ?>
            </td>
            <td>
              <?php echo $matricula['Curso']['turno']; ?>
            </td>
            <?php if(!$ocultar) : ?>
            <td>
              <?php echo $matricula['Curso']['plazas']; ?>
            </td>
            <?php endif ?>
            <td>
              <?php echo $matricula['Curso']['matricula']; ?>
            </td>
            <td>
                <?php echo $matricula['Curso']['por_hermanos']; ?>
            </td>
            <?php if(!$ocultar) : ?>
            <td>
              <?php echo $matricula['Curso']['vacantes']; ?>
            </td>
            <?php endif ?>
            <td >
              <span class="link"><?php echo $this->Html->link('<i class="glyphicon glyphicon-eye-open"></i>', array('controller' => 'Cursos', 'action'=> 'view', $matricula['Curso']['id']), array('class' => 'btn btn-default', 'escape' => false)); ?></span>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
      <tfoot>
        <tr>
          <th>
            <!-- Autocomplete -->
              <input id="AutocompleteForm" class="form-control" placeholder="Buscar institucion por nombre" type="text">

            <script>
              $( function() {
                $( "#AutocompleteForm" ).autocomplete({
                  source: "<?php echo $this->Html->url(array('controller'=>'Centros','action'=>'autocompleteCentro'));?>",
                  minLength: 2,
                  select: function( event, ui ) {
                    $("#AutocompleteForm").val( ui.item.Centro.sigla );

                    window.location.href = "<?php echo $this->Html->url(array('controller'=>'vacantes'));?>/index/centro_id:"+ui.item.Centro.id;
                    return false;
                  }
                }).autocomplete( "instance" )._renderItem = function( ul, item ) {
                  return $( "<li>" )
                      .append( "<div>" +item.Centro.sigla + "</div>" )
                      .appendTo( ul );
                };
              });
            </script>
            <!-- End Autocomplete -->
          </th>
          <th>
              <?php echo $this->Form->create('Vacantes',array('id'=>'formFiltroAnio','type'=>'get','url'=>'index', 'novalidate' => true));?>

              <?php
              if ($this->Siep->isSuperAdmin()) {
                  $anios = array('Sala de 3 años' => 'Sala de 3 años', 'Sala de 4 años' => 'Sala de 4 años', 'Sala de 5 años' => 'Sala de 5 años', '1ro ' => '1ro', '2do' => '2do', '3ro' => '3ro', '4to' => '4to', '5to' => '5to', '6to' => '6to', '7mo' => '7mo');
              } else if ($current_user['puesto'] == 'Dirección Jardín') {
                  $anios = array('Sala de 3 años' => 'Sala de 3 años', 'Sala de 4 años' => 'Sala de 4 años', 'Sala de 5 años' => 'Sala de 5 años');
              } else if ($current_user['puesto'] == 'Dirección Escuela Primaria') {
                  $anios = array('1ro ' => '1ro', '2do' => '2do', '3ro' => '3ro', '4to' => '4to', '5to' => '5to', '6to' => '6to', '7mo' => '7mo');
              } else if ($current_user['puesto'] == 'Supervisión Inicial/Primaria') {
                  $anios = array('Sala de 3 años' => 'Sala de 3 años', 'Sala de 4 años' => 'Sala de 4 años', 'Sala de 5 años' => 'Sala de 5 años', '1ro ' => '1ro', '2do' => '2do', '3ro' => '3ro', '4to' => '4to', '5to' => '5to', '6to' => '6to', '7mo' => '7mo');
              } else {
                  $anios = array('1ro ' => '1ro', '2do' => '2do', '3ro' => '3ro', '4to' => '4to', '5to' => '5to', '6to' => '6to', '7mo' => '7mo');
              }
              echo $this->Form->input('anio', array('id'=>'filtroAnio','label' =>false, 'empty' => 'Ingrese un año...', 'options' => $anios, 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Selecciones una opción de la lista'));

              ?>

              <?php echo $this->Form->end(); ?>
          </th>
          <th>

          </th>
        </tr>
      </tfoot>
    </table>

      <script>
        $(function(){

          $('#filtroAnio').on( 'change', function () {
              $('#formFiltroAnio').submit();
           });
        });
      </script>
    </div>

  <div class="unit text-center">
    <?php echo $this->element('pagination'); ?>
  </div>
</div>
