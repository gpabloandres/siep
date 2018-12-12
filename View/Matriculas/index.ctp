<?php
    // Si la persona que navega no es Admin, muestra el Filtro.
    if(!$this->Siep->isAdmin()) :
?>
<div class="TituloSec">Filtro</div>
<div id="ContenidoSec">
    <?php echo $this->Form->create('Curso',array('type'=>'get','url'=>'index', 'novalidate' => true));?>
    <div class="row">
        <!--<div class="col-xs-2">
            <div class="input select">
                <?php
                echo $this->Form->input('ciclo_id', array('options'=>$comboCiclo /*'empty' => 'Ingrese un ciclo lectivo...'*/ , 'default'=>$cicloIdActual, 'disabled' => true, 'label'=>false, 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Seleccione una opción'));
                ?>
            </div>
        </div>-->
            <div class="col-xs-4">
                <!-- Autocomplete -->
                <strong>Nombre de la Institución</strong>
                <input id="AutocompleteForm" class="form-control" placeholder="Indicar el nombre de la institución" type="text">
                <script>
                    $( function() {
                        $( "#AutocompleteForm" ).autocomplete({
                            source: "<?php echo $this->Html->url(array('controller'=>'Centros','action'=>'autocompleteCentro'));?>",
                            minLength: 2,
                            select: function( event, ui ) {
                                $("#AutocompleteForm").val( ui.item.Centro.sigla );

                                window.location.href = "<?php echo $this->Html->url(array('controller'=>'matriculas'));?>/index/centro_id:"+ui.item.Centro.id;
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
                <select name="anio" class="form-control" data-toggle="tooltip" data-placement="bottom">
                    <option value="">Seleccione un año...</option>
                    <?php
                    foreach($comboAnio as $index => $item) :
                        ?>
                        <option value="<?php echo $item; ?>"><?php echo $item; ?></option>
                        <?php
                    endforeach;
                    ?>
                </select>
            </div>
        </div>-->
        <!--<div class="col-xs-2">
            <div class="input select">
                <select name="division" class="form-control" data-toggle="tooltip" data-placement="bottom">
                    <option value="">Seleccione una division...</option>
                    <?php
                    foreach($comboDivision as $index => $item) :
                        ?>
                        <option value="<?php echo $item; ?>"><?php echo $item; ?></option>
                        <?php
                    endforeach;
                    ?>
                </select>
            </div>
        </div>-->

        <!--<div class="col-xs-2">
            <div class="text-center">
                <span class="link">
                    <?php echo $this->Form->button('<span class="glyphicon glyphicon-search"></span> Aplicar filtro', array('class' => 'submit', 'class' => 'btn btn-primary')); ?>
                </span>
            </div>-->
    </div>
        <?php echo $this->Form->end(); ?>
    </div>
</div><br>
<?php endif; ?>
<?php
     $ocultar = false;
     if( $current_user['Centro']['nivel_servicio'] === 'Común - Inicial - Primario' ||
         $current_user['Centro']['nivel_servicio'] === 'Común - Inicial' ||
         $current_user['Centro']['nivel_servicio'] === 'Común - Primario' ) {
         $ocultar = true;
     }
?>
<div class="TituloSec">Inscripciones 2018</div>
<div id="ContenidoSec">

    <div class="table-responsive">
    <table id="tablaPieBuscador" class="table table-bordered table-hover table-striped table-condensed">
      <thead>
        <tr>
          <th><?php echo $this->Paginator->sort('Centro.sigla', 'Centro');?>  </th>
          <th><?php echo $this->Paginator->sort('anio','Año');?></th>
          <th><?php echo $this->Paginator->sort('division', 'Division');?></th>
          <th><?php echo $this->Paginator->sort('tipo', 'Tipo');?></th>
          <th><?php echo $this->Paginator->sort('turno', 'Turno');?></th>
        <?php if(!$ocultar) : ?>
          <th><?php echo $this->Paginator->sort('titulacion', 'Titulación');?></th>
        <?php endif; ?>  
          <th><?php echo $this->Paginator->sort('plazas', 'Plazas');?></th>
          <th><?php echo $this->Paginator->sort('matricula', 'Matriculas');?></th>
          <th><?php echo $this->Paginator->sort('vacantes', 'Vacantes');?></th>
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
              <?php echo $matricula['Curso']['division']; ?>
            </td>
            <td>
              <?php echo $matricula['Curso']['tipo']; ?>
            </td>
            <td>
              <?php echo $matricula['Curso']['turno']; ?>
            </td>
          <?php if(!$ocultar) : ?>  
            <td>
              <?php echo $titulacionesNombres[$matricula['Curso']['titulacion_id']]; ?>
            </td>
          <?php endif; ?>  
            <td>
              <?php echo $matricula['Curso']['plazas']; ?>
            </td>
            <td>
              <?php echo $matricula['Curso']['matricula']; ?>
            </td>
            <td>
              <?php echo $matricula['Curso']['vacantes']; ?>
            </td>
            <td >
              <span class="link"><?php echo $this->Html->link('<i class="glyphicon glyphicon-eye-open"></i>', array('controller' => 'Cursos', 'action'=> 'view', $matricula['Curso']['id']), array('class' => 'btn btn-default', 'escape' => false)); ?></span>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

      <script>
        $(function(){

          $('#tablaPieBuscador_DESACTIVADO tfoot th').each( function (i) {
            var title = $(this).text();
            var inputFind = $(this).html( '<input type="text" data-column="'+ i +'" class="form-control" placeholder="Buscar '+title+'" />' );

            inputFind.find('input').on( 'keypress', function (e) {
              if(e.which == 13) {
                var i = $(this).attr('data-column');
                var find =$(this).val();

                matriculasTable.columns(i).search(find).draw();
              }
            });
          });


            // Quita el modo disabled del formulario, para enviar los datos!
            $('form').submit(function(e) {
                $(':disabled').each(function(e) {
                    $(this).removeAttr('disabled');
                })
            });
        });
      </script>
    </div>
</div>


    <div class="unit text-center">
    <?php echo $this->element('pagination'); ?>
  </div>
</div>
