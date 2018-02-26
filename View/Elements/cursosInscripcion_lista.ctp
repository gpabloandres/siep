<div id="app" class="table-responsive">
    <?php
        if($showExportBtn>=2) :
    ?>
    <a target="_blank" href="https://constancia.sieptdf.tk/api/inscripcion/export/excel?<?php echo http_build_query($queryExportacionExcel); ?>" class="btn btn-success pull-right">Exportar resultados a excel</a>
    <br>
    <br>
    <?php
        endif;
    ?>
        <table class="table table-bordered table-hover table-striped table-condensed">
        <thead>
            <tr>
                <th>
                    <input type="checkbox" id="checkAll"/>
                </th>
                <th><?php echo $this->Paginator->sort('ciclo_id', 'Ciclo');?></th>
                <th><?php echo $this->Paginator->sort('centro_id', 'Centro');?></th>
                <th><?php echo $this->Paginator->sort('curso_id', 'Curso');?></th>
                <th><?php echo $this->Paginator->sort('turno', 'Turno');?></th>
                <th><?php echo $this->Paginator->sort('documento_nro', 'DNI');?></th>
                <th><?php echo $this->Paginator->sort('persona_id', 'Alumno');?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($cursosInscripcions as $cursosInscripcion) : ?>
            <tr>
                <td><?php echo $cursosInscripcion['Ciclo']['nombre']; ?> </td>
                <td><?php echo $cursosInscripcion['Centro']['nombre']; ?> </td>
                <td><?php echo $cursosInscripcion['Curso']['anio']." ".$cursosInscripcion['Curso']['division']; ?> </td>
                <td><?php echo $cursosInscripcion['Curso']['turno']; ?> </td>
                <td><?php echo $cursosInscripcion['Persona']['documento_nro']; ?> </td>
                <td><?php echo $cursosInscripcion['Persona']['nombres']." ".$cursosInscripcion['Persona']['apellidos']; ?> </td>
                <td>
                    <span class="link"><?php echo $this->Html->link('<i class="glyphicon glyphicon-eye-open"></i>', array('controller' => 'Inscripcions', 'action'=> 'view', $cursosInscripcion['Inscripcion']['id']), array('class' => 'btn btn-default', 'escape' => false)); ?></span>
                </td>
            </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>
