<!-- start filtro -->
<div class="TituloSec">Filtro</div>
<div id="ContenidoSec">
    <?php echo $this->Form->create('Promocionados',array('type'=>'get','url'=>'view', 'novalidate' => true));?>
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
<div class="TituloSec">Promocionados</div>
<div id="ContenidoSec">
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
                      <?php foreach($promociones['data'] as $promocionado) : ?>
                          <tr>
                              <td><?php echo $promocionado['inscripcion']['persona']['nombre_completo']; ?></td>
                              <td><?php echo "<b>{$promocionado['actual']['centro']['sigla']}</b> {$promocionado['actual']['curso']['anio']} {$promocionado['actual']['curso']['division']} {$promocionado['actual']['curso']['turno']}"; ?></td>
                              <td>
                                  <span class="link"><?php echo $this->Html->link('<i class="glyphicon glyphicon-eye-open"></i>', array('controller' => 'Inscripcions', 'action'=> 'view', $promocionado['inscripcion']['id']), array('class' => 'btn btn-default', 'escape' => false)); ?></span>
                              </td>
                              <td><?php echo "<b>{$promocionado['anterior']['centro']['sigla']}</b> {$promocionado['anterior']['curso']['anio']} {$promocionado['anterior']['curso']['division']} {$promocionado['anterior']['curso']['turno']}"; ?></td>
                              <td>
                                  <span class="link"><?php echo $this->Html->link('<i class="glyphicon glyphicon-eye-open"></i>', array('controller' => 'Inscripcions', 'action'=> 'view', $promocionado['inscripcion']['promocion_id']), array('class' => 'btn btn-default', 'escape' => false)); ?></span>
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
        echo $this->Siep->pagination($promociones['meta']);
        ?>
</div>
<!-- end main -->
