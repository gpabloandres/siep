<!-- Autocomplete para nombre de Personas -->
<div>
    <input id="PersonaNombreCompleto" class="form-control" label= "Nombre y apellidos del alumno*" data-toggle="tooltip" data-placemente="bottom" placeholder="Ingrese el nombre completo">
    <input id="PersonaId" name="data[Persona][persona_id]" type="text" style="display:none;">
    <div class="alert alert-danger" role="alert" id="AutocompleteError" style="display:none;">
        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
        <span class="sr-only">Error:</span>
        La persona no fue localizada.
        <?php echo $this->Html->link("Crear persona",array('controller'=>'personas','action'=>'add'));?>
    </div>
</div>
<script>
    $( function() {
        $( "#PersonaNombreCompleto" ).autocomplete({
            source: "<?php echo $this->Html->url($url);?>",
            minLength: 2,
            // Evento: se ejecuta al seleccionar el resultado
            select: function( event, ui ) {
                // Elimina ID de persona previo a establecer la seleccion
                $("#PersonaId").val("");
                if(ui.item != undefined) {
                    var nombre_completo = ui.item.Persona.nombre_completo_persona;
                    $("#PersonaNombreCompleto").val(nombre_completo);
                    $("#PersonaId").val(ui.item.Persona.id);
                    return false;
                }
            },
            response: function(event, ui) {
                // Elimina ID de persona al obtener respuesta
                $("#PersonaId").val("");
                if (ui.content.length === 0) {
                    $("#AutocompleteError").show();
                    $("#PersonaId").val("");
                } else {
                    $("#AutocompleteError").hide();
                }
            }
        }).autocomplete("instance")._renderItem = function( ul, item ) {
            // Renderiza el resultado de la respuesta
            var nombre_completo = item.Persona.nombre_completo_persona + " - "+item.Persona.documento_nro;
            return $( "<li>" )
                .append( "<div>" +nombre_completo+ "</div>" )
                .appendTo( ul );
        };
    });
</script>
