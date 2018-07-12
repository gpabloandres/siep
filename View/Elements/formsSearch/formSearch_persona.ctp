<?php echo $this->Form->create('Persona',array('id'=>'formularioBusqueda','type'=>'get','url'=>'index', 'novalidate' => true));?>
<!-- Autocomplete -->
<div>
    <input id="AutocompleteForm" class="form-control" placeholder="Ingrese documento, nombre o apellido">
    <input id="personaId" type="hidden" name="Persona.id">
</div>
<hr />
<div class="text-center">
    <span class="link"><?php echo $this->Form->button('<span class="glyphicon glyphicon-search"></span> BUSCAR', array('class' => 'submit', 'class' => 'btn btn-primary')); ?>
    </span>
    <?php echo $this->Form->end(); ?>
</div>
<?php echo $this->Form->end(); ?>
<script>
    $( function() {
        $( "#AutocompleteForm" ).autocomplete({
            source: "<?php echo $this->Html->url(array('action'=>'autocompletePersonas'));?>",
            minLength: 2,
            select: function( event, ui ) {
                var nombre_completo = ui.item.Persona.nombres +" "+ui.item.Persona.apellidos;
                $("#AutocompleteForm").val( nombre_completo );
//              window.location.href = "<?php echo $this->Html->url(array('controller'=>'personas','action'=>'view'));?>/"+ui.item.Persona.id;
                $('#personaId').val(ui.item.Persona.id);
                return false;
            }
        }).autocomplete( "instance" )._renderItem = function( ul, item ) {
            var nombre_completo = item.Persona.nombres +" "+item.Persona.apellidos + " - "+item.Persona.documento_nro;

            return $( "<li>" )
                .append( "<div>" +nombre_completo+ "</div>" )
                .appendTo( ul );
        };

        $("#formularioBusqueda").submit(function(e){
            e.preventDefault();
            //console.log(personaId);

            var personaId = $('#personaId').val();
            window.location.href = "<?php echo $this->Html->url(array('controller'=>'personas','action'=>'view'));?>/"+personaId;
        });
    });
</script>
<!-- End Autocomplete -->
