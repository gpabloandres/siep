<?php
    // Si el usuario no es Admin, muestro el filtro.
    if(!$this->Siep->isAdmin()) :
?>
<div class="TituloSec">Filtro</div>
<div id="ContenidoSec">
    <?php echo $this->Form->create('Curso',array('type'=>'get','url'=>'index', 'novalidate' => true));?>
    <div class="row">
          <div class="col-xs-4">
              <!-- Autocomplete --> 
              <strong>Nombre de la Institución</strong>
              <input id="AutocompleteForm" class="form-control" placeholder="Indique el nombre de la institución" type="text">
            <script>
              $( function() {
                $( "#AutocompleteForm" ).autocomplete({
                  source: "<?php echo $this->Html->url(array('controller'=>'Centros','action'=>'autocompleteCentro'));?>",
                  minLength: 2,
                  select: function( event, ui ) {
                    $("#AutocompleteForm").val( ui.item.Centro.sigla );

                    window.location.href = "<?php echo $this->Html->url(array('controller'=>'vacantes'));?>/index?centro_id="+ui.item.Centro.id;
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
            </div>
        <!--<div class="col-xs-2">
            <div class="input select">
                <?php
                echo $this->Form->input('sector', array('options'=>$comboSector, 'empty'=>'- Todos los sectores -', 'label'=>false, 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Seleccione una opción'));
                ?>
            </div>
        </div>-->
        <!--<div class="col-xs-2">
            <div class="input select">
                <?php
                echo $this->Form->input('ciudad_id', array('options'=>$comboCiudad, 'empty'=>'- Todas las ciudades -', 'label'=>false, 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Seleccione una opción'));
                ?>
            </div>
        </div>-->
        <!--<div class="col-xs-2">
            <div class="text-center">
                <span class="link">
                    <?php echo $this->Form->button('<span class="glyphicon glyphicon-search"></span> Aplicar filtro', array('class' => 'btn btn-primary')); ?>
                </span>
            </div>
        </div>-->
    </div>
    <?php echo $this->Form->end(); ?>
</div>
        <br>
<?php endif; ?>
<?php
     $ocultar = false;
     /*
     if( $current_user['Centro']['nivel_servicio'] === 'Común - Inicial - Primario' ||
         $current_user['Centro']['nivel_servicio'] === 'Común - Inicial' ||
         $current_user['Centro']['nivel_servicio'] === 'Común - Primario' ) {
         $ocultar = true;
     }
     */
?>
<div class="TituloSec">Inscripciones 2019</div>
<div id="ContenidoSec">
    <?php
    if($showBtnExcel) :
    ?>
        <?php
        if($this->Siep->isAdmin()) :
        ?>
            <a target="_blank" class="btn btn-success pull-right" href="<?php echo env('SIEP_API_GW_INGRESS').'/api/v1/matriculas/cuantitativa/por_seccion?'.http_build_query($queryExportarExcel); ?>">
                <span class="glyphicon glyphicon-file"></span> Exportar resultados a excel
            </a>
        <?php else: ?>
            <div class="btn-group pull-right">:
                <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="glyphicon glyphicon-file"></span> Exportar resultados a excel <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">
                    <?php
                    foreach($ubicaciones as $ubicacion):
                        ?>
                        <li>
                            <a target="_blank" href="<?php echo env('SIEP_API_GW_INGRESS').'/api/v1/matriculas/cuantitativa/por_seccion?ciudad='.$ubicacion['nombre'].'&'.http_build_query($queryExportarExcel); ?>">
                                <?php echo $ubicacion['nombre']; ?>
                            </a>
                        </li>
                        <?php
                    endforeach;
                    ?>
                    <li role="separator" class="divider"></li>
                    <li>
                    <li>
                        <a target="_blank" href="<?php echo env('SIEP_API_GW_INGRESS').'/api/v1/matriculas/cuantitativa/por_seccion?'.http_build_query($queryExportarExcel); ?>">Toda la provincia</a>
                    </li>
                </ul>
            </div>
        <?php endif; ?>
        <br>
        <br>
    <?php endif; ?>
    <div class="table-responsive">
    <table id="tablaPieBuscador" class="table table-bordered table-hover table-striped    table-condensed">
      <thead>
        <tr>
          <th>Institución</th>
          <th>Año/Gpo</th>
          <th>División</th>
          <th>Turno</th>
          <th>Tipo</th>
          <th>Titulación</th>
          <?php if(!$ocultar) : ?>
            <th>Plaza</th>
          <?php endif ?>
          <th>Matricula</th>
          <?php if(!$ocultar) : ?>
              <th>VACANTES</th>
          <?php endif ?>
          <!--<th>Acciones</th>-->
        </tr>
      </thead>
      <tbody>
        <?php $count=0;
        ?>
        <?php
        if(isset($matriculas_por_seccion['total'])) :
        foreach($matriculas_por_seccion['data'] as $seccion): ?>
            <td>
              <?php echo $seccion['nombre']; ?>
            </td>
            <td>
              <?php echo $seccion['anio']; ?>
            </td>
            <td>
              <?php echo $seccion['division']; ?>
            </td>
            <td>
              <?php echo $seccion['turno']; ?>
            </td>
            <td>
              <?php echo $seccion['tipo']; ?>
            </td>
            <td>
              <?php echo $titulacionesNombres[$seccion['titulacion_id']]; ?>
            </td>
            <?php 
                if($seccion['cue']=='940001300' || $seccion['cue']=='940009200' || $seccion['cue']=='940011600' || $seccion['cue']=='940013400' || $seccion['cue']=='940014600' || $seccion['cue']=='940020900') { 
                    echo'<td>'.'--'.'</td>';
                } else { 
                    echo'<td>'.$seccion['plazas'].'</td>';
                }
            ?>    
            <td>
              <?php echo $seccion['matriculas']; ?>
            </td>
            <?php 
                if($seccion['cue']=='940001300' || $seccion['cue']=='940009200' || $seccion['cue']=='940011600' || $seccion['cue']=='940013400' || $seccion['cue']=='940014600' || $seccion['cue']=='940020900') { 
                    echo'<td>'.'--'.'</td>';
                } else { 
                    echo'<td>'.$seccion['vacantes'].'</td>';
                }
            ?>
            <td >
              <span class="link"><?php echo $this->Html->link('<i class="glyphicon glyphicon-eye-open"></i>', array('controller' => 'Cursos', 'action'=> 'view', $seccion['curso_id']), array('class' => 'btn btn-default', 'escape' => false)); ?></span>
            </td>
          </tr>
        <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
      <!--<tfoot>
        <tr>
          <th>
            <!-- Autocomplete 
              <input id="AutocompleteForm" class="form-control" placeholder="Buscar institucion por nombre" type="text">

            <script>
              $( function() {
                $( "#AutocompleteForm" ).autocomplete({
                  source: "<?php echo $this->Html->url(array('controller'=>'Centros','action'=>'autocompleteCentro'));?>",
                  minLength: 2,
                  select: function( event, ui ) {
                    $("#AutocompleteForm").val( ui.item.Centro.sigla );

                    window.location.href = "<?php echo $this->Html->url(array('controller'=>'vacantes'));?>/index?centro_id="+ui.item.Centro.id;
                    return false;
                  }
                }).autocomplete( "instance" )._renderItem = function( ul, item ) {
                  return $( "<li>" )
                      .append( "<div>" +item.Centro.sigla + "</div>" )
                      .appendTo( ul );
                };
              });
            </script>
            <!-- End Autocomplete 
          </th>
          <th>
              <?php echo $this->Form->create('Vacantes',array('id'=>'formFiltroAnio','type'=>'get','url'=>'index', 'novalidate' => true));?>

              <?php
              if ($this->Siep->isSuperAdmin()) {
                  $anios = array('Sala de 3 años' => 'Sala de 3 años', 'Sala de 4 años' => 'Sala de 4 años', 'Sala de 5 años' => 'Sala de 5 años', '1ro' => '1ro', '2do' => '2do', '3ro' => '3ro', '4to' => '4to', '5to' => '5to', '6to' => '6to', '7mo' => '7mo');
              } else if ($current_user['puesto'] == 'Dirección Jardín') {
                  $anios = array('Sala de 3 años' => 'Sala de 3 años', 'Sala de 4 años' => 'Sala de 4 años', 'Sala de 5 años' => 'Sala de 5 años');
              } else if ($current_user['puesto'] == 'Dirección Escuela Primaria') {
                  $anios = array('1ro' => '1ro', '2do' => '2do', '3ro' => '3ro', '4to' => '4to', '5to' => '5to', '6to' => '6to', '7mo' => '7mo');
              } else if ($current_user['puesto'] == 'Supervisión Inicial/Primaria') {
                  $anios = array('Sala de 3 años' => 'Sala de 3 años', 'Sala de 4 años' => 'Sala de 4 años', 'Sala de 5 años' => 'Sala de 5 años', '1ro' => '1ro', '2do' => '2do', '3ro' => '3ro', '4to' => '4to', '5to' => '5to', '6to' => '6to', '7mo' => '7mo');
              } else {
                  $anios = array('1ro' => '1ro', '2do' => '2do', '3ro' => '3ro', '4to' => '4to', '5to' => '5to', '6to' => '6to', '7mo' => '7mo');
              }
              echo $this->Form->input('anio', array('id'=>'filtroAnio','label' =>false, 'empty' => 'Ingrese un año...', 'options' => $anios, 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Selecciones una opción de la lista'));

              ?>

              <?php echo $this->Form->end(); ?>
          </th>
          <th>

          </th>
        </tr>
      </tfoot>-->
    </table>

      <script>
        $(function(){

          $('#filtroAnio').on( 'change', function () {
              $('#formFiltroAnio').submit();
           });
        });
      </script>
    </div>
</div>

<?php
echo $this->Siep->pagination($matriculas_por_seccion);
?>
