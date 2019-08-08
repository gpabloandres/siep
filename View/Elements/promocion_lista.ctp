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
                    $cursosInscripcion['Inscripcion']['estado_inscripcion']=='CONFIRMADA' &&
                    $cursosInscripcion['Inscripcion']['promocion_id'] == null &&
                    $cursosInscripcion['Inscripcion']['ciclo_id'] == $cicloaPromocionar['id']
                ) :
                ?>
                    <input type="checkbox" class="toggle_checkbox" name="id[]" value="<?php echo $cursosInscripcion['Inscripcion']['id']; ?>">
                <?php  endif;  ?>
                </td>
                <td><?php echo $cursosInscripcion['Persona']['documento_nro']; ?> </td>
                <td><?php echo $cursosInscripcion['Persona']['apellidos']." ".$cursosInscripcion['Persona']['nombres']; ?> </td>
                <td width="60px">
                    <span class="link"><?php echo $this->Html->link('<i class="glyphicon glyphicon-eye-open"></i>', array('controller' => 'Inscripcions', 'action'=> 'view', $cursosInscripcion['Inscripcion']['id']), array('class' => 'btn btn-default', 'escape' => false)); ?></span>
                </td>
            </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>

<div class="col-sm-4">
    <div class="unit">
        <div class="subtitulo">Opciones de promocion</div>

        <h5>Desde</h5>
        Ciclo: <b><?php echo $cicloaPromocionar['nombre']; ?></b>
        Seccion: <b><?php echo $curso['anio']." ".$curso['division']." ".$curso['turno']; ?></b>

        <input type="hidden" name="centro_id" value="<?php echo $centro['id'];?>">
        <input type="hidden" name="curso_id" value="<?php echo $curso['id'];?>">
        <input type="hidden" name="ciclo" value="<?php echo $cicloaPromocionar['nombre']; ?>">

        <div class="showConfirmar" style="display:none;margin-top:2px;border-top:1px solid #636363;">
            <h5>Hacia</h5>
            Ciclo: <b><?php echo $cicloSiguienteNombre;?></b>
            <?php
            echo $this->Form->input('seccion', array('name'=>'curso_id_promocion','label'=>false,'empty' => '- Seleccionar seccion - ', 'options' => $secciones, 'class' => 'form-control'));
            ?>
        </div>
        <hr>
        <div class="showConfirmar text-center">
            <input type="submit" class="btn btn-primary" value="Confirmar promocion" />
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