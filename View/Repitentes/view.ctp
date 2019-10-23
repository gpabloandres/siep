<!-- start filtro -->
<div class="TituloSec">Filtro</div>
<div id="ContenidoSec">
    <?php echo $this->Form->create('Repitentes',array('type'=>'get','url'=>'view', 'novalidate' => true));?>
    <div class="row">

        <!-- COMBO CENTROS -->
        <?php
        // Si la persona que navega no es Admin, muestro autocomplete
            if(!$this->Siep->isAdmin()) :
        ?>
        <div class="col-xs-3">
                <!-- Autocomplete -->
                <input id="Autocomplete" class="form-control" placeholder="Buscar institucion por nombre" type="text" value="<?php echo $filtro['centro_sigla']; ?>" >
                <input id="AutocompleteId" type="hidden" name="centro_id" value="<?php echo $filtro['centro_id']; ?>">
                <script>
                    $( function() {
                        $( "#Autocomplete" ).autocomplete({
                            source: "<?php echo $this->Html->url(array('controller'=>'Centros','action'=>'autocompleteCentro'));?>",
                            minLength: 2,
                            select: function( event, ui ) {
                                $("#Autocomplete").val( ui.item.Centro.sigla );
                                $("#AutocompleteId").val( ui.item.Centro.id );
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
        <?php
            endif;
        ?>

        <div class="col-xs-2">
            <div class="input select">
                <?php
                    echo $this->Form->input('anio', array('default'=>$apiParams['anio'],'options'=>$comboAño, 'empty'=>'- Todos los años-', 'label'=>false, 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Seleccione una opción'));
                ?>
            </div>
        </div>
        <div class="col-xs-2">
            <div class="input select">
                <?php
                    echo $this->Form->input('turno', array('default'=>$apiParams['turno'],'options'=>$comboTurno, 'empty'=>'- Todos los turnos-', 'label'=>false, 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Seleccione una opción'));
                ?>
            </div>
        </div>
        <div class="col-xs-1">
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

<!-- start main -->
<div class="TituloSec">Repitentes</div>
<div id="ContenidoSec">
<?php
        if($showExportBtn) :
    ?>
    <?php
        if($this->Siep->isAdmin()):
        ?>
            <a target="_blank" class="btn btn-success pull-right" href="<?php echo '/gateway/excel_vacantes/ciclo:'.$apiParams['ciclo'].'/centro_id:'.$centro['Centro']['id'].'/report_type:repitencias'; ?>">
                <span class="glyphicon glyphicon-file"></span> Exportar resultados a excel
            </a>
            <a target="_blank" style="margin-right:5px;" class="btn btn-danger pull-right" href="<?php echo '/gateway/pdf_matriculas_por_seccion/ciclo:'.$apiParams['ciclo'].'/centro_id:'.$centro['Centro']['id'].'/report_type:repitencias';?>">
                <span class="glyphicon glyphicon-file"></span><span>Exportar resultados a PDF</span>
            </a>
        <?php else: ?>
            <div class="btn-group pull-right">
            
                <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="glyphicon glyphicon-file"></span> Exportar resultados a excel <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">
                    <?php
                    foreach($ubicaciones as $ubicacion):
                        ?>
                        <li>
                            <a target="_blank" href="<?php echo '/gateway/excel_vacantes/ciudad:'.$ubicacion['nombre'].'/ciclo:'.$apiParams['ciclo'].'/centro_id:'.$centro['Centro']['id'].'/report_type:repitencias'; ?>">
                                <?php echo $ubicacion['nombre']; ?>
                            </a>
                        </li>
                        <?php
                    endforeach;
                    ?>
                    <li role="separator" class="divider"></li>
                    <li>
                    <li>
                        <a target="_blank" href="<?php echo '/gateway/excel_vacantes/ciclo:'.$apiParams['ciclo'].'/centro_id:'.$centro['Centro']['id'].'/report_type:repitencias'; ?>">Toda la provincia</a>
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
                            <a target="_blank" href="<?php echo '/gateway/pdf_matriculas_por_seccion/ciudad:'.$ubicacion['nombre'].'/ciclo:'.$apiParams['ciclo'].'/centro_id:'.$centro['Centro']['id'].'/report_type:repitencias'; ?>">
                                <?php echo $ubicacion['nombre']; ?>
                            </a>
                        </li>
                        <?php
                    endforeach;
                    ?>
                    <li role="separator" class="divider"></li>
                    <li>
                    <li>
                        <a target="_blank" href="<?php echo '/gateway/excel_vacantes/ciclo:'.$apiParams['ciclo'].'/centro_id:'.$centro['Centro']['id'].'/report_type:repitencias'; ?>">Toda la provincia</a>
                    </li>
                </ul>
            </div> -->
            <?php
            if(isset($centro) && $centro !=""): ?>
            <a target="_blank" style="margin-right:5px;" class="btn btn-danger pull-right" href="<?php echo '/gateway/pdf_matriculas_por_seccion/ciclo:'.$apiParams['ciclo'].'/centro_id:'.$centro['Centro']['id'].'/report_type:repitencias';?>">
                <span class="glyphicon glyphicon-file"></span><span>Exportar resultados a PDF</span>
            </a>

        <?php
            endif; 
          endif; 
        ?>
        <br>
        <br>
    <?php endif; ?>
    <div id="main">
    <!-- start second nav -->
      <div class="row">
          <div class="col-xs-12">
          <div class="row">
    <!-- LISTA -->
              <div id="app" class="table-responsive">
                  <table class="table table-bordered table-hover table-striped table-condensed">
                      <thead>
                      <tr>
                          <th>Nombre completo</th>
                          <th>2018</th>
                          <th></th>
                          <th>2019</th>
                      </tr>
                      </thead>
                      <tbody>
                      <?php foreach($repitencia['data'] as $repitente) : ?>
                          <tr>
                              <td><?php echo $repitente['inscripcion']['persona']['nombre_completo']; ?></td>
                              <td><?php echo "<b>{$repitente['actual']['centro']['sigla']}</b> {$repitente['actual']['curso']['anio']} {$repitente['actual']['curso']['division']} {$repitente['actual']['curso']['turno']}"; ?></td>
                              <td>
                                  <span class="link"><?php echo $this->Html->link('<i class="glyphicon glyphicon-eye-open"></i>', array('controller' => 'Inscripcions', 'action'=> 'view', $repitente['inscripcion']['id']), array('class' => 'btn btn-default', 'escape' => false)); ?></span>
                              </td>
                              <td><?php echo "<b>{$repitente['anterior']['centro']['sigla']}</b> {$repitente['anterior']['curso']['anio']} {$repitente['anterior']['curso']['division']} {$repitente['anterior']['curso']['turno']}"; ?></td>
                              <td>
                                  <span class="link"><?php echo $this->Html->link('<i class="glyphicon glyphicon-eye-open"></i>', array('controller' => 'Inscripcions', 'action'=> 'view', $repitente['inscripcion']['repitencia_id']), array('class' => 'btn btn-default', 'escape' => false)); ?></span>
                              </td>
                          </tr>
                      <?php endforeach ?>
                      </tbody>
                  </table>
              </div>
    <!-- ./LISTA -->
           </div>
      </div>
    </div>

        <?php
        echo $this->Siep->pagination($repitencia['meta']);
        ?>
</div>
<!-- end main -->
