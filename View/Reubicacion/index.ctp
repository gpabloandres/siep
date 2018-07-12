<!-- start main -->
<div class="TituloSec"> Reubicacion de alumnos </div>
<div id="ContenidoSec">

    <?php
        if($success) :
    ?>

    <h4><?php echo $centro['nombre']; ?> <?php echo "(".$curso['anio']." ".$curso['division']." ".$curso['turno'].")" ?>
    | <b><?php echo $ciclo['nombre']; ?></b>
    </h4>

    <div class="row">
        <?php
        echo $this->element('reubicacion_lista',array( 'apiResponse' => $apiResponse));
        ?>
    </div>


    <?php
    endif;
    ?>

</div>
