<?php echo $this->Form->create('Centro',array('id'=>'formularioBusqueda','type'=>'get', 'url'=>'view', 'novalidate' => true));?>
<!-- Autocomplete -->
<div>
   <input id="AutocompleteForm" class="form-control" placeholder="Ingrese institucion por nombre o CUE">
   <input id="centroId" type="hidden" name="Centro.id">
</div>
<hr />
<div class="text-center">
    <span class="link"><?php echo $this->Form->button('<span class="glyphicon glyphicon-search"></span> BUSCAR', array('class' => 'submit', 'class' => 'btn btn-primary')); ?>
    </span>
   <?php echo $this->Form->end(); ?>
</div>
<script>
   $( function() {
      $( "#AutocompleteForm" ).autocomplete({
         source: "<?php echo $this->Html->url(array('action'=>'autocompleteCentro'));?>",
         minLength: 2,
         select: function( event, ui ) {
            $("#AutocompleteForm").val( ui.item.Centro.sigla );
            $('#centroId').val(ui.item.Centro.id);
            return false;
         }
      }).autocomplete( "instance" )._renderItem = function( ul, item ) {
         return $( "<li>" )
             .append( "<div>" +item.Centro.sigla + "</div>" )
             .appendTo( ul );
      };

      $("#formularioBusqueda").submit(function(e){
         e.preventDefault();

         var centroId = $('#centroId').val();
         window.location.href = "<?php echo $this->Html->url(array('controller'=>'centros','action'=>'view'));?>/"+centroId;
      });
   });
</script>
<!-- End Autocomplete -->
