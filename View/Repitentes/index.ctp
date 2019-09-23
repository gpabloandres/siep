<!-- start main -->
<br>
<div class="TituloSec">Repitencia de alumnos</div>
<div id="ContenidoSec">
    <h4><?php echo $centro['nombre']; ?> <?php echo "(".$curso['anio']." ".$curso['division']." ".$curso['turno'].")" ?>
        | <b><?php echo $cicloaPromocionar['nombre']; ?></b>
    </h4>
    <div class="row">
        <?php
        echo $this->element('repitentes_lista',array( 'cursosInscripcions' => $cursosInscripcions ));
        ?>
    </div>
    <div class="unit text-center">
        <?php echo $this->element('pagination'); ?>
    </div>
</div>
