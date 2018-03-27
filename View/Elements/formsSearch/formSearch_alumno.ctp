<?php echo $this->Form->create('Alumno', array('id'=>'formSearchAlumno','type'=>'get','url'=>'index', 'novalidate' => true));?>
<!--<div class="form-group">
   <?php /*echo $this->Form->input('legajo_fisico_nro', array('label' => false, 'class' => 'form-control', 'Placeholder' => 'Ingrese un nº de legajo físico...'));	*/?>
</div>
-->

<!-- Autocomplete -->
<div>
    <input id="AutocompelteAlumno" class="form-control" placeholder="Buscar alumno por DNI, nombre y/o apellido">
    <input id="AutocompleteId" type="hidden" name="alumno_id">

    <div class="alert alert-danger" role="alert" id="AutocompleteAlumnoError" style="display:none;">
        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
        <span class="sr-only">Error:</span>
        No se encontraron resultados de busqueda
    </div>
</div>
<hr />
<div class="text-center">
    <span class="link"><?php echo $this->Form->button('<span class="glyphicon glyphicon-search"></span> BUSCAR', array('class' => 'submit', 'class' => 'btn btn-primary')); ?>
    </span>
    <?php echo $this->Form->end(); ?>
</div>
<script>
    $( function() {

        $('#formSearchAlumno').submit(function(e){
            e.preventDefault();
            window.location.href = "<?php echo $this->Html->url(array('controller'=>'alumnos','action'=>'view'));?>/"+$("#AutocompleteId").val();
        });

        $( "#AutocompelteAlumno" ).autocomplete({
            source: "<?php echo $this->Html->url(array('action'=>'autocompleteNombreAlumno'));?>",
            minLength: 2,
            select: function( event, ui ) {
                var nombre_completo = ui.item.Persona.apellidos +" "+ ui.item.Persona.nombres;
                $("#AutocompelteAlumno").val( nombre_completo );
                $("#AutocompleteId").val( ui.item.Alumno.id );

                window.location.href = "<?php echo $this->Html->url(array('controller'=>'alumnos','action'=>'view'));?>/"+ui.item.Alumno.id;
                return false;
            },
            response: function(event, ui) {
                if (ui.content.length === 0)
                {
                    $("#AutocompleteAlumnoError").show();
                } else {
                    $("#AutocompleteAlumnoError").hide();
                }
            }
        }).autocomplete( "instance" )._renderItem = function( ul, item ) {
            var nombre_completo = item.Persona.apellidos +" "+ item.Persona.nombres +' - ' +item.Persona.documento_nro;
            return $( "<li>" )
                .append( "<div>" +nombre_completo+ "</div>" )
                .appendTo( ul );
        };
    });
</script>
<!-- End Autocomplete -->
