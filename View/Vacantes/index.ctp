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
        </div><br><hr>
        <?php
            echo $this->Form->input('ciclo', array('default'=>$apiParams['ciclo'], 'type'=>'hidden'));
        ?>
        <div class="col-xs-2">
            <div class="input select">
              <?php
                echo $this->Form->input('ciudad_id', array('default'=>'Ushuaia', 'options'=>$comboCiudad, 'empty'=>'- Todas las ciudades -', 'label'=>'Ciudad', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Seleccione una opción'));
              ?>
            </div>
        </div>
        <div class="col-xs-2">
            <div class="input select">
              <?php
                $nivelesServicios = array('Común - Inicial' => 'Común - Inicial', 'Común - Primario' => 'Común - Primario', 'Común - Secundario' => 'Común - Secundario', 'Especial - Primario' => 'Especial - Primario', 'Adulto - Primario' => 'Adulto - Primario', 'Adulto - Secundario' => 'Adulto - Secundario', 'Común - Superior' => 'Común - Superior');
                echo $this->Form->input('nivel_servicio', array('default'=>'Común - Inicial', 'options'=>$nivelesServicios, 'empty'=>'- Todos los niveles -', 'label'=>'Nivel-Servicio', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Seleccione una opción'));
              ?>
            </div>
        </div>
        <div class="col-xs-2">
            <div class="input select">
              <?php
                echo $this->Form->input('sector', array('default'=>'ESTATAL', 'options'=>$comboSector, 'empty'=>'- Todos los sectores -', 'label'=>'Sector', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Seleccione una opción'));
              ?>
            </div>
        </div>
        <div class="col-xs-2">
            <div class="input select">
              <?php
                $anios = array('Sala de 3 años' => 'Sala de 3 años', 'Sala de 4 años' => 'Sala de 4 años', 'Sala de 5 años' => 'Sala de 5 años', '1ro ' => '1ro', '2do' => '2do', '3ro' => '3ro', '4to' => '4to', '5to' => '5to', '6to' => '6to', '7mo' => '7mo');
                echo $this->Form->input('anio', array('default'=>'Sala de 4 años', 'options'=>$anios, 'empty'=>'- Todos los anios -', 'label'=>'Año', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Seleccione una opción'));
              ?>
            </div>
        </div>
        <div class="col-xs-2">
            <div class="input select">
              <?php
                $turnos = array('Mañana' => 'Mañana', 'Tarde' =>'Tarde', 'Mañana Extendida' =>'Mañana Extendida', 'Tarde Extendida' => 'Tarde Extendida', 'Doble Extendida' =>'Doble Extendida', 'Vespertino' => 'Vespertino', 'Noche' =>'Noche');
                echo $this->Form->input('turno', array('default'=>'Mañana', 'options'=>$turnos, 'empty'=>'- Todos los turnos -', 'label'=>'Turno', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Seleccione una opción'));
              ?>
            </div>
        </div>
        <div class="col-xs-2">
            <div class="input select">
              <?php
                $vacancias = array('con' => 'Con vacantes', 'sin' => 'Sin vacantes');
                echo $this->Form->input('vacantes', array('default'=>'Con vacantes', 'options'=>$vacancias, 'empty'=>'- Todos las vacantes -', 'label'=>'Vacantes', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Seleccione una opción'));
              ?>
            </div>
        </div><br><hr><br>
        <div class=".col-md-3 .col-md-offset-3">
            <div class="text-center">
                <span class="link">
                    <?php echo $this->Form->button('<span class="glyphicon glyphicon-search"></span> Aplicar filtro', array('class' => 'btn btn-primary')); ?>
                </span>
            </div>
        </div>
    </div>
    <?php echo $this->Form->end(); ?>
</div>
        <br>
<?php endif; ?>
<?php
    $nivelServicio = null;
    switch ($current_user['Centro']['nivel_servicio']) {
      case 'Común - Inicial':
      case 'Común - Primario':
        $nivelServicio = 'inicialPrimarioComun';
        break;
      case 'Común - Inicial - Primario':
        $nivelServicio = 'supervisionInicialPrimarioComun';
        break;
      case 'Común - Secundario':
        $nivelServicio = 'secundarioComun';
        break;
      
      default:
        # code...
        break;
    }
?>
<div class="TituloSec">Matrícula <?php echo $apiParams['ciclo']; ?></div>
<div id="ContenidoSec">
    <?php
    if($showBtnExcel) :
    ?>
        <a target="_blank" class="btn btn-success pull-right" href="<?php echo '/gateway/excel_vacantes/ciclo:'.$apiParams['ciclo'].'/centro_id:'.$centroSolicitado; ?>">
            <span class="glyphicon glyphicon-file"></span> Exportar resultados a excel
        </a>
        <a target="_blank" style="margin-right:5px;" class="btn btn-danger pull-right" href="<?php echo '/gateway/pdf_matriculas_por_seccion/ciclo:'.$apiParams['ciclo'].'/centro_id:'.$centroSolicitado;?>">
            <span class="glyphicon glyphicon-file"></span><span>Exportar resultados a PDF</span>
        </a>
        
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
        <?php if($nivelServicio == 'inicialPrimarioComun' || $nivelServicio == 'supervisionInicialPrimarioComun') : ?>
          <th>P.P.</th>
          <th>M.I.</th>
        <?php endif; ?>
          <th>Plaza</th>
          <th>Matricula</th>
          <th>Varones</th>
          <th>VACANTES</th>
        <?php if($nivelServicio != 'inicialPrimarioComun') : ?>
          <th>Observaciones</th>
        <?php endif; ?>
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
          <?php if($nivelServicio == 'inicialPrimarioComun' || $nivelServicio == 'supervisionInicialPrimarioComun') : ?>
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
          <?php if($nivelServicio != 'inicialPrimarioComun') : ?>
            <td>
              <?php echo $seccion['observaciones']; ?>
            </td>
          <?php endif; ?>
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
