<!-- Autocomplete -->
<div>
    <input id="TitulacionId" class="form-control" placeholder="Buscar por nombre">
</div>
<hr />
<div class="text-center">
    <span class="link"><?php echo $this->Form->button('<span class="glyphicon glyphicon-search"></span> BUSCAR', array('class' => 'submit', 'class' => 'btn btn-primary')); ?>
    </span>
    <?php echo $this->Form->end(); ?>
</div>
<script>
    $( function() {
        $( "#TitulacionId" ).autocomplete({
            source: "<?php echo $this->Html->url(array('action'=>'autocompleteTitulacions'));?>",
            minLength: 2,
            select: function( event, ui ) {
                $("#TitulacionId").val( ui.item.Titulacion.nombre );
                window.location.href = "<?php echo $this->Html->url(array('controller'=>'titulacions','action'=>'view'));?>/"+ui.item.Titulacion.id;
                return false;
            }
        }).autocomplete( "instance" )._renderItem = function( ul, item ) {
            return $( "<li>" )
                .append( "<div>" +item.Titulacion.nombre+ "</div>" )
                .appendTo( ul );
        };
    });
</script>
<!-- End Autocomplete -->
</div>