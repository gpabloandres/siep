<?php
    // Sí el usuario no es Admin, muestro el filtro.
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

                    window.location.href = "<?php echo $this->Html->url(array('controller'=>'vacantes'));?>/index?centro_id="+ui.item.Centro.id+"&ciclo=<?php echo $apiParams['ciclo']; ?>";
                    return false;
                  }
                }).autocomplete( "instance" )._renderItem = function( ul, item ) {
                  return $( "<li>" )
                      .append( "<div>" +item.Centro.sigla + "</div>" )
                      .appendTo( ul );
                };
              });
            </script>
            <!-- End Autocompletes -->
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
    $nivelServicio = null;
    if( $current_user['Centro']['nivel_servicio'] === 'Común - Inicial - Primario' ||
        $current_user['Centro']['nivel_servicio'] === 'Común - Inicial' ||
        $current_user['Centro']['nivel_servicio'] === 'Común - Primario' ) {
        $nivelServicio = 'inicialPrimarioComun';
    } else if ($current_user['Centro']['nivel_servicio'] === 'Común - Secundario') {
        $nivelServicio = 'secundarioComun';
    } 
     
?>
<div class="TituloSec">Matrícula <?php echo $apiParams['ciclo']; ?></div>
<div id="ContenidoSec">
    <?php
    if($showBtnExcel) :
    ?>
        <?php
        if($this->Siep->isAdmin()) :
        ?>
            <a target="_blank" class="btn btn-success pull-right" href="<?php echo '/gateway/excel_vacantes/ciclo:'.$apiParams['ciclo'].'/centro_id:'.$centroSolicitado; ?>">
                <span class="glyphicon glyphicon-file"></span> Exportar resultados a excel
            </a>
            <a target="_blank" style="margin-right:5px;" class="btn btn-danger pull-right" href="<?php echo '/gateway/pdf_matriculas_por_seccion/ciclo:'.$apiParams['ciclo'].'/centro_id:'.$centroSolicitado;?>">
                <span class="glyphicon glyphicon-file"></span><span>Exportar resultados a PDF</span>
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
                            <a target="_blank" href="<?php echo '/gateway/excel_vacantes/ciudad:'.$ubicacion['nombre'].'/ciclo:'.$apiParams['ciclo'].'/centro_id:'.$centroSolicitado; ?>">
                                <?php echo $ubicacion['nombre']; ?>
                            </a>
                        </li>
                        <?php
                    endforeach;
                    ?>
                    <li role="separator" class="divider"></li>
                    <li>
                    <li>
                        <a target="_blank" href="<?php echo '/gateway/excel_vacantes/ciclo:'.$apiParams['ciclo'].'/centro_id:'.$centroSolicitado; ?>">Toda la provincia</a>
                    </li>
                </ul>
            </div>
            <!-- <div class="btn-group pull-right">:
            
                <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="glyphicon glyphicon-file"></span> Exportar resultados a PDF <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">
                    <?php
                    foreach($ubicaciones as $ubicacion):
                        ?>
                        <li>
                            <a target="_blank" href="<?php echo '/gateway/pdf_matriculas_por_seccion/ciudad:'.$ubicacion['nombre'].'/ciclo:'.$apiParams['ciclo'].'/centro_id:'.$centroSolicitado; ?>">
                                <?php echo $ubicacion['nombre']; ?>
                            </a>
                        </li>
                        <?php
                    endforeach;
                    ?>
                    <li role="separator" class="divider"></li>
                    <li>
                    <li>
                        <a target="_blank" href="<?php echo '/gateway/excel_vacantes/ciclo:'.$apiParams['ciclo'].'/centro_id:'.$centroSolicitado; ?>">Toda la provincia</a>
                    </li>
                </ul>
            </div> -->
            <?php
            if(isset($centroSolicitado) && $centroSolicitado !=""): ?>
            <a target="_blank" style="margin-right:5px;" class="btn btn-danger pull-right" href="<?php echo '/gateway/pdf_matriculas_por_seccion/ciclo:'.$apiParams['ciclo'].'/centro_id:'.$centroSolicitado;?>">
                <span class="glyphicon glyphicon-file"></span><span>Exportar resultados a PDF</span>
            </a>

        <?php
            endif; 
          endif; 
        ?>
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
          <?php if($nivelServicio == 'secundarioComun') : ?>
          <th>Hs Cátedras</th>
          <th>Res. Pedagógica</th>
          <th>Instr. Legal de Creación</th>
          <?php endif; ?>
          <?php if($nivelServicio == 'inicialPrimarioComun') : ?>
          <th>P.P.</th>
          <th>M.I.</th>
          <?php endif; ?>
          <th>Plaza</th>
          <th>Matricula</th>
          <th>Varones</th>
          <th>VACANTES</th>
          <th>Observaciones</th>          
          <!--<th>Accioness</th>-->
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
            <?php if($nivelServicio == 'secundarioComun') : ?>
            <td>
              <?php echo $seccion['hs_catedras']; ?>
            </td>
            <td>
              <?php echo ($seccion['titulacion']['reso_titulacion_nro'].'/'.$seccion['titulacion']['reso_titulacion_anio']); ?>
            </td>
            <td>
              <?php echo $seccion['reso_presupuestaria']; ?>
            </td>
            <?php endif; ?>
            <?php if($nivelServicio == 'inicialPrimarioComun') : ?>
            <td>
                <?php if($seccion['pareja_pedagogica'] == 1): ?>
                <span class="glyphicon glyphicon-ok"></span>
                <?php endif; ?>
            </td>
            <td>
                <?php if($seccion['maestra_apoyo_inclusion'] == 1): ?>
                <span class="glyphicon glyphicon-ok"></span>
                <?php endif; ?>
            </td>
            <?php endif; ?>
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
            <td>
                <?php echo $seccion['varones']; ?>
            </td>
            <?php
                if($seccion['cue']=='940001300' || $seccion['cue']=='940009200' || $seccion['cue']=='940011600' || $seccion['cue']=='940013400' || $seccion['cue']=='940014600' || $seccion['cue']=='940020900') { 
                    echo'<td>'.'--'.'</td>';
                } else { 
                    echo'<td>'.$seccion['vacantes'].'</td>';
                }
            ?>
            <td>
              <?php echo $seccion['observaciones']; ?>
            </td>
            <?php if ($apiParams['ciclo'] == 2019) { ?>
              <td>
                <span class="link"><?php echo $this->Html->link('<i class="glyphicon glyphicon-eye-open"></i>', array('controller' => 'Cursos', 'action'=> 'view', $seccion['curso_id']), array('class' => 'btn btn-default', 'escape' => false)); ?></span>
              </td>
            <?php } else { ?>
              <td>  
                <span class="link"><?php echo $this->Html->link('<i class="glyphicon glyphicon-eye-open"></i>', array('controller' => 'ListaAlumnos', 'action'=> '/index/centro_id:'.$seccion['centro_id'].'/curso_id:'.$seccion['curso_id'].'/ciclo:2020'), array('class' => 'btn btn-default', 'escape' => false)); ?></span>
              </td>
            <?php } ?>
          </tr>
        <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
      <!--<tfoot>
        <tr>
          <th>
            Autocomplete 
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
             End Autocomplete 
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
