<!-- start main -->
<div class="TituloSec"> Egreso de alumnos </div>
<div id="ContenidoSec">
    <h4><?php echo $centro['nombre']; ?> <?php echo "(".$curso['anio']." ".$curso['division']." ".$curso['turno'].")" ?>
    </h4>

    <div class="row">
        <?php
        echo $this->element('egreso_lista',array( 'cursosInscripcions' => $cursosInscripcions ));
        ?>
    </div>
    <div class="unit text-center">
        <?php echo $this->element('pagination'); ?>
    </div>
</div>
