<!-- start main -->
<div class="TituloSec">Lista de alumnos</div>
<div id="ContenidoSec">
    <?php
    if(isset($centro['nombre'])) :
    ?>
    <div class="row">
        <div class="col-sm-12 table-responsive">
            <a target="_blank" href="<?php echo env('SIEP_API_GW_INGRESS').'/api/v1/exportar/excel/ListaAlumnos?'.http_build_query($apiParams); ?>" class="btn btn-success pull-right">Exportar resultados a excel</a>
            <h4>
                <?php echo $centro['nombre']; ?>
                <?php echo "(".$curso['anio']." ".$curso['division']." ".$curso['turno'].")" ?> | <?php echo "Ciclo ".$ciclo['nombre']; ?>
            </h4>

            <table class="table table-bordered table-hover table-striped table-condensed">
                <thead>
                    <tr>
                        <th>DNI</th>
                        <th>Alumno</th>
                        <th>Telefono</th>
                        <th>Direccion</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($cursosInscripcions as $cursosInscripcion) : ?>
                    <tr>
                        <td><?php echo $cursosInscripcion['inscripcion']['alumno']['persona']['documento_nro']; ?> </td>
                        <td><?php echo $cursosInscripcion['inscripcion']['alumno']['persona']['nombre_completo']; ?> </td>
                        <td><?php echo $cursosInscripcion['inscripcion']['alumno']['persona']['telefono_nro']; ?> </td>
                        <td>
                            <?php echo $cursosInscripcion['inscripcion']['alumno']['persona']['calle_nombre']; ?>
                            <?php echo $cursosInscripcion['inscripcion']['alumno']['persona']['calle_nro']; ?>
                        </td>
                        <td width="60px">
                            <span class="link"><?php echo $this->Html->link('<i class="glyphicon glyphicon-eye-open"></i>', array('controller' => 'Inscripcions', 'action'=> 'view', $cursosInscripcion['inscripcion']['id']), array('class' => 'btn btn-default', 'escape' => false)); ?></span>
                        </td>
                    </tr>
                <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php
    else :
    ?>
        No hay alumnos registrados en la seccion solicitada en el ciclo <b><?php echo $cicloActual; ?></b>
    <?php
    endif
    ?>

</div>
