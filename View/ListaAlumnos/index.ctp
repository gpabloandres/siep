<!-- start main -->
<div class="TituloSec">Lista de alumnos</div>
<div id="ContenidoSec">
    <?php
    if(isset($centro['nombre'])) :
    ?>
    <div class="row">
        <div class="col-sm-12">
            <form method="POST" action="/gateway/excel_alumnos">
                <input type="hidden" name="query" value="<?php echo http_build_query($apiParams); ?>">
                <input  type="submit" class="btn btn-success pull-right" value="Exportar resultados a excel" />
            </form>
            <h4>
                <?php echo $centro['nombre']; ?>
                <?php echo "(".$curso['anio']." ".$curso['division']." ".$curso['turno'].")" ?> | <?php echo "Ciclo ".$ciclo['nombre']; ?>
            </h4>

            <table class="table table-bordered table-hover table-striped table-condensed">
                <thead>
                    <tr>
                        <th>DNI</th>
                        <th>Alumno</th>
                        <th>Fecha de Nac.</th>
                        <th>Telefono</th>
                        <th>Direccion</th>
                        <th>Email</th>
                        <th>Familiares</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($cursosInscripcions as $cursosInscripcion) : ?>
                    <tr>
                        <td><?php echo $cursosInscripcion['inscripcion']['alumno']['persona']['documento_nro']; ?> </td>
                        <td><?php echo $cursosInscripcion['inscripcion']['alumno']['persona']['nombre_completo']; ?> </td>
                        <td><?php
                            list($nacY,$nacM,$nacD) = explode('-',$cursosInscripcion['inscripcion']['alumno']['persona']['fecha_nac']);
                            echo "$nacD/$nacM/$nacY";
                            ?> </td>
                        <td><?php echo $cursosInscripcion['inscripcion']['alumno']['persona']['telefono_nro']; ?> </td>
                        <td>
                            <?php echo $cursosInscripcion['inscripcion']['alumno']['persona']['calle_nombre']; ?>
                            <?php echo $cursosInscripcion['inscripcion']['alumno']['persona']['calle_nro']; ?>
                        </td>
                        <td>
                            <?php echo $cursosInscripcion['inscripcion']['alumno']['persona']['email']; ?>
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
                        <td width="60px">

                            <div class="dropdown">
                                <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    Imprimir
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu pull-right" aria-labelledby="dropdownMenu1">
                                    <li>
                                        <a target="_blank" href="<?php echo "/gateway/constancia_regular/id:".$cursosInscripcion['inscripcion']['id'];?>">
                                            Constancia de alumno regular
                                        </a>
                                    </li>
                                    <li>
                                        <a target="_blank" href="<?php echo "/gateway/constancia/id:".$cursosInscripcion['inscripcion']['id'];?>">
                                            Constancia de inscripcion
                                        </a>
                                    </li>
                                </ul>
                            </div>
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
        No hay alumnos registrados en la seccion solicitada en el ciclo <b><?php echo $cicloDatoAlumno; ?></b>
    <?php
    endif
    ?>
</div>

<script>
    function updateRelacion(id,mode) {
        <?php
            if($this->Siep->isAdmin() || $this->Siep->isSuperAdmin() ) {
        ?>
        $.get("/ListaAlumnos/updateFamiliar/", { id: id, mode: mode} , function() {
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
