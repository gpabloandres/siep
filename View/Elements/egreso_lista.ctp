<?php echo $this->Form->create('CursosInscripcion',array('type'=>'post','url'=>'confirmarAlumnos', 'novalidate' => true));?>
<div id="app" class="col-sm-8 table-responsive">
    <table class="table table-bordered table-hover table-striped table-condensed">
        <thead>
            <tr>
                <th width="25px">
                    <input type="checkbox" id="checkAll"/>
                </th>
                <th><?php echo $this->Paginator->sort('documento_nro', 'DNI');?></th>
                <th><?php echo $this->Paginator->sort('persona_id', 'Alumno');?></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($cursosInscripcions as $cursosInscripcion) : ?>
            <tr>
                <td>
                <?php
                if(
                    $cursosInscripcion['inscripcion']['fecha_egreso'] == NULL  &&
                    $cursosInscripcion['inscripcion']['ciclo']['nombre'] == $cicloEgreso
                ) :
                ?>
                    <input type="checkbox" class="toggle_checkbox" name="id[]" value="<?php echo $cursosInscripcion['inscripcion']['id']; ?>">
                <?php  endif;  ?>
                </td>
                <td><?php echo $cursosInscripcion['inscripcion']['alumno']['persona']['documento_nro']; ?> </td>
                <td><?php echo $cursosInscripcion['inscripcion']['alumno']['persona']['nombre_completo']; ?> </td>
                <td width="60px">
                    <span class="link"><?php echo $this->Html->link('<i class="glyphicon glyphicon-eye-open"></i>', array('controller' => 'Inscripcions', 'action'=> 'view', $cursosInscripcion['inscripcion']['id']), array('class' => 'btn btn-default', 'escape' => false)); ?></span>
                </td>
            </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>

<div class="col-sm-4">
    <div class="unit">
        <div class="subtitulo">Opciones de egreso</div>

        Ciclo: <b><?php echo $ciclo['nombre']; ?></b>
        Seccion: <b><?php echo $curso['anio']." ".$curso['division']." ".$curso['turno']; ?></b>
        <br>
        <br>
        <input type="hidden" name="centro_id" value="<?php echo $centro['id'];?>">
        <input type="hidden" name="curso_id" value="<?php echo $curso['id'];?>">
        <div class="showConfirmar text-center">
            <input type="submit" class="btn btn-primary" value="Confirmar egreso" />
        </div>
    </div>
</div>

<?php echo $this->Form->end(); ?>

<script>
    $(function() {
        var seleccionados = 0;

        toggleConfirmButton();

        $("#checkAll").change(function () {
            var checkboxes = $(this).closest('form').find('.toggle_checkbox');
            var checked = $(this).prop("checked");
            checkboxes.prop('checked', checked);
            checkboxes.closest("tr").toggleClass("info", checked);

            toggleConfirmButton();
        });

        $('.toggle_checkbox').change(function() {
            $(this).closest("tr").toggleClass("info", this.checked);

            toggleConfirmButton();
        });
    });

    function toggleConfirmButton() {
        seleccionados = $('.toggle_checkbox:checked').length;
        if(seleccionados>0) {
            $('.showConfirmar').show();
        } else {
            $("#checkAll").prop('checked', false);
            $('.showConfirmar').hide();
        }
    }
</script>