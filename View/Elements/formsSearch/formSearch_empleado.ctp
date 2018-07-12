<?php echo $this->Form->create('Empleado',array('type'=>'get','url'=>'index', 'novalidate' => true));?>
<div class="form-group">
    <?php echo $this->Form->input('documento_nro' , array('label' => false, 'class' => 'form-control', 'Placeholder' => 'Ingrese Nº de documento...'));	?>
</div><br>
<div>
    <input id="AutocompleteForm" class="form-control" placeholder="Buscar agente por nombre y/o apellido">
</div>
<hr />
<div class="text-center">
    <span class="link"><?php echo $this->Form->button('<span class="glyphicon glyphicon-search"></span> BUSCAR', array('class' => 'submit', 'class' => 'btn btn-primary')); ?>
    </span>
    <?php echo $this->Form->end(); ?>
</div>

<!-- Autocomplete -->
<script>
    $( function() {
        $( "#AutocompleteForm" ).autocomplete({
            source: "<?php echo $this->Html->url(array('action'=>'autocompleteEmpleados'));?>",
            minLength: 2,
            select: function( event, ui ) {
                var nombre_completo = ui.item.Empleado.apellidos+', '+ui.item.Empleado.nombres;
                $("#AutocompleteForm").val( nombre_completo );

                window.location.href = "<?php echo $this->Html->url(array('controller'=>'empleados','action'=>'view'));?>/"+ui.item.Empleado.id;

                return false;
            }
        }).autocomplete( "instance" )._renderItem = function( ul, item ) {
            var nombre_completo = item.Empleado.apellidos+', '+item.Empleado.nombres;

            return $( "<li>" )
                .append( "<div>" +nombre_completo+ "</div>" )
                .appendTo( ul );
        };
    });
</script>
<!-- End Autocomplete -->
