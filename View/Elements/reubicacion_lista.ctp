<?php echo $this->Form->create('CursosInscripcion',array('type'=>'post','url'=>'confirmarAlumnos', 'novalidate' => true));?>

<div id="app" class="col-sm-8 table-responsive">
    <table class="table table-bordered table-hover table-striped table-condensed">
        <thead>
            <tr>
                <th width="25px">
                    <input type="checkbox" id="checkAll"/>
                </th>
                <th>DNI</th>
                <th>Alumno</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($apiResponse['data'] as $item) : ?>
            <tr>
                <td>
                <input type="checkbox" class="toggle_checkbox" name="id[]" value="<?php echo $item['inscripcion']['id']; ?>">
                </td>
                <td><?php echo $item['inscripcion']['alumno']['persona']['documento_nro']; ?> </td>
                <td><?php echo $item['inscripcion']['alumno']['persona']['apellidos']." ".$item['inscripcion']['alumno']['persona']['nombres']; ?> </td>
                <td width="60px">
                    <span class="link"><?php echo $this->Html->link('<i class="glyphicon glyphicon-eye-open"></i>', array('controller' => 'Inscripcions', 'action'=> 'view', $item['inscripcion']['id']), array('class' => 'btn btn-default', 'escape' => false)); ?></span>
                </td>
            </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>

<div class="col-sm-4">
    <div class="unit">
        <div class="subtitulo">Opciones de promocion</div>

        Desde: <b><?php echo $curso['anio']." ".$curso['division']." ".$curso['turno']; ?></b>

        <input type="hidden" name="centro_id" value="<?php echo $centro['id'];?>">
        <input type="hidden" name="curso_id" value="<?php echo $curso['id'];?>">
        <input type="hidden" name="ciclo" value="<?php echo $ciclo['nombre'];?>">

        <div class="showConfirmar" style="display:none;margin-top:2px;border-top:1px solid #636363;">
            <h5>Hacia</h5>
            <?php
            echo $this->Form->input('seccion', array('name'=>'curso_id_to','label'=>false,'empty' => '- Seleccionar seccion - ', 'options' => $secciones, 'class' => 'form-control'));
            ?>
        </div>
        <hr>
        <div class="showConfirmar text-center">
            <input type="submit" class="btn btn-primary" value="Confirmar reubicacion" />
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