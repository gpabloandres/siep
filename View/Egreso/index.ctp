<!-- start main -->
<div class="TituloSec"> Egreso de alumnos </div>
<div id="ContenidoSec">

    <?php
    if(isset($centro['nombre'])) :
    ?>
    <h4><?php echo $centro['nombre']; ?> <?php echo "(".$curso['anio']." ".$curso['division']." ".$curso['turno'].")" ?>
    </h4>

    <div class="row">
        <?php
        echo $this->element('egreso_lista',array( 'cursosInscripcions' => $cursosInscripcions ));
        ?>
    </div>
    <?php
    else :
    ?>
        No hay mas alumnos a egresar en el ciclo <b><?php echo $cicloActual; ?></b>
    <?php
    endif;
    ?>
</div>
