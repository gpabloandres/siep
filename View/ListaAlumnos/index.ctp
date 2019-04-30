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
                        <th>Familiares</th>
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
                        <td>
                        <?php foreach($cursosInscripcion['inscripcion']['alumno']['familiares'] as $relacion) : ?>

                            <?php if($this->Siep->isAdmin() || $this->Siep->isSuperAdmin()) { ?>
                            <div class="dropdown">
                            <?php if ($relacion['status']=='pendiente') : ?>
                                <button class="btn btn-warning dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                <span class="glyphicon glyphicon-time" aria-hidden="true"></span>
                            <?php endif; ?>

                            <?php if ($relacion['status']=='confirmada') : ?>
                                <button class="btn btn-success dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                            <?php endif; ?>

                            <?php if ($relacion['status']=='revisar') : ?>
                            <button class="btn btn-danger dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                                <?php endif; ?>

                                        <?php echo $relacion['familiar']['persona']['nombre_completo'];  ?>
                                        (<?php echo $relacion['familiar']['vinculo']; ?>)
                                        <span class="caret"></span>
                                    </button>

                                <ul class="dropdown-menu">
                                    <?php if ($relacion['status']!='confirmada') : ?>
                                    <li><a href="javascript:updateRelacion('<?php echo $relacion['id'];?>','confirmar');">Confirmar relación</a></li>
                                    <?php endif; ?>
                                    <?php if ($relacion['status']!='pendiente') : ?>
                                    <li><a href="javascript:updateRelacion('<?php echo $relacion['id'];?>','pendiente');">Relación pendiente</a></li>
                                    <?php endif; ?>
                                    <?php if ($relacion['status']!='revisar') : ?>
                                    <li><a href="javascript:updateRelacion('<?php echo $relacion['id'];?>','cancelar');">Cancelar relación</a></li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                            <?php } else { ?>
                                <?php echo $relacion['familiar']['persona']['nombre_completo'];  ?>
                                (<?php echo $relacion['familiar']['vinculo']; ?>)
                            <?php } ?>
                        <?php endforeach ?>
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

<script>
    function updateRelacion(id,mode) {
        <?php
            if($this->Siep->isAdmin() || $this->Siep->isSuperAdmin() ) {
        ?>
        $.get("<?php echo $this->Html->url(array('controller' => 'ListaAlumnos','action' =>'updateFamiliar'),true);?>", { id: id, mode: mode} , function() {
            window.location.reload();
        })
            .fail(function() {
                alert( "Ocurrio un error al realizar la operacion, por favor contactese con los administradores" );
            });
        <?php } else { ?>
        alert('No tiene permisos para realizar esta operacion');
        <?php } ?>
    }
</script>