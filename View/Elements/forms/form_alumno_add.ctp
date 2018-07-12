<?php echo $this->Html->script(array('tooltip', 'datepicker', 'moment', 'bootstrap-datetimepicker')); ?>

<div class="row">
</div><hr />
<div class="row">
	<div class="col-md-4 col-sm-6 col-xs-12">
  	  <div class="unit"><strong><h3>Datos Generales</h3></strong><hr />

          <!-- Autocomplete para nombre de Personas -->
          <div>
            <label for="AlumnoNombreCompleto">Nombres y Apellidos*: </label>
            <br>
						<input id="AlumnoNombreCompleto" class="form-control" data-toggle="tooltip" data-placemente="bottom" placeholder="Ingrese el nombre completo">
						<input id="AlumnoPersonaId" name="data[Alumno][persona_id]" type="text" style="display:none;">
						<div class="alert alert-danger" role="alert" id="AutocompleteError" style="display:none;">
  					  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
	   				  <span class="sr-only">Error:</span>
							  No existe una persona con ese nombre:
							<?php echo $this->Html->link("Crear persona",array('controller'=>'personas','action'=>'add'));?>
						</div>
          </div>
          <script>
              $( function() {
                  $( "#AlumnoNombreCompleto" ).autocomplete({
                      source: "<?php echo $this->Html->url(array('action'=>'autocompleteNombrePersona'));?>",
											minLength: 2,
										  // Evento: se ejecuta al seleccionar el resultado
                      select: function( event, ui ) {
												// Elimina ID de persona previo a establecer la seleccion
												$("#AlumnoPersonaId").val("");

												if(ui.item != undefined) {
													$("#AlumnoNombreCompleto").val(ui.item.Persona.nombre_completo_persona);
													$("#AlumnoPersonaId").val(ui.item.Persona.id);
	                        return false;
												}
                      },
											response: function(event, ui) {
												  // Elimina ID de persona al obtener respuesta
													$("#AlumnoPersonaId").val("");
							            if (ui.content.length === 0) {
														  $("#AutocompleteError").show();
															$("#AlumnoPersonaId").val("");
							            } else {
															$("#AutocompleteError").hide();
							            }
							        }
                  }).autocomplete("instance")._renderItem = function( ul, item ) {
										  // Renderiza el resultado de la respuesta
                      return $( "<li>" )
                          .append( "<div>" +item.Persona.nombre_completo_persona+ "</div>" )
                        	.appendTo( ul );
                  };
              });
          </script>
          <!-- End Autocomplete -->
      </div>
    </div>
    <div class="col-md-4 col-sm-6 col-xs-12">
      <div class="unit"><strong><h3>Datos Específicos</h3></strong><hr />
      <?php
            echo $this->Form->input('legajo_fisico_nro', array('label'=>'Número de Legajo Físico*', 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Indique el número sin puntos, ni guiones, ni espacios', 'placeholder' => 'Ingrese un nº de legajo físico...'));
        ?>
      </div>
  </div>
  <div class="col-md-12 col-sm-6 col-xs-12">
    <?php echo $this->Form->input('observaciones', array('label'=>'Observaciones', 'type' => 'textarea', 'between' => '<br>', 'class' => 'form-control')); ?>
  </div>
</div>

    <script type="text/javascript">
        $('#datetimepicker1').datetimepicker({
        useCurrent: true, //this is important as the functions sets the default date value to the current value
        format: 'YYYY-MM-DD hh:mm',
        }).on('dp.change', function (e) {
              var specifiedDate = new Date(e.date);
              if (specifiedDate.getMinutes() == 0)
              {
                  specifiedDate.setMinutes(1);
                  $(this).data('DateTimePicker').date(specifiedDate);
              }
           });
    </script>
