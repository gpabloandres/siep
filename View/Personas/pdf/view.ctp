<?php /*
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <link rel="STYLESHEET" href="css/print_static.css" type="text/css" />
</head>
<body>
    <div id="body">
        <div id="section_header"></div>
        <div id="content">
            <div class="page" style="font-size: 7pt">
                <table style="width: 100%;" class="header">
                    <tr>
                        <td><h1 style="text-align: left">LEGAJO DE ALUMNO </h1></td>
                        <td><h1 style="text-align: right"><?php echo ($alumno['Alumno']['nombre_completo_alumno']) ?></h1></td>
                    </tr>
                </table>
                <table style="width: 100%; font-size: 8pt;">
                    <tr>
                        <td>Documento: <strong><?php echo ($alumno['Alumno']['documento_tipo']).' '.($alumno['Alumno']['documento_nro']); ?></strong></td>
                    </tr>
                <!--<tr>
                        <td>Dirección: <strong><?php echo $alumno['Alumno']['calle_nombre'].' N° '.$alumno['Alumno']['calle_nro']; ?></strong></td>
                        <td>Barrio: <strong><?php echo ($alumno['Alumno']['barrio']); ?></strong></td>
                    </tr>
                    <tr>
                        <td>Teléfono: <strong><?php echo $alumno['Alumno']['telefono_nro']; ?></strong></td>
                        <td>Email: <strong><?php echo ($this->Html->link($alumno['Alumno']['email'],'mailto:'.$alumno['Alumno']['email'])); ?></strong></td>
                    </tr>-->
                </table>
                <table style="width: 100%; border-top: 1px solid black; border-bottom: 1px solid black; font-size: 8pt;">
                    <tr>
                    <td>Dirección: <strong> <?php echo $alumno['Alumno']['calle_nombre'].' N° '.$alumno['Alumno']['calle_nro']; ?></strong></td>
                    <td>Barrio: <strong> <?php echo ($alumno['Alumno']['barrio']); ?></strong></td>
                    <td>Teléfono: <strong> <?php echo $alumno['Alumno']['telefono_nro']; ?></strong></td>
                    <td>Email: <strong> <?php echo ($this->Html->link($alumno['Alumno']['email'],'mailto:'.$alumno['Alumno']['email'])); ?></strong></td>
                    </tr>
                </table>
                <table style="width: 100%; border-top: 1px solid black; border-bottom: 1px solid black; font-size: 8pt;">
                    <tr><td colspan="6"><h2>Familiares Relacionados:</h2></td></tr>
                    <tr class="even_row">
                        <th><?php echo $this->Paginator->sort('vinculo', 'Vinculo');?></th>
                        <th><?php echo $this->Paginator->sort('nombre_completo', 'Nombre');?></th>
                        <th><?php echo $this->Paginator->sort('telefono_nro', 'Teléfono');?></th>
                        <th><?php echo $this->Paginator->sort('email', 'Email');?></th>
                        <th><?php echo $this->Paginator->sort('domicilio', 'Domicilio');?></th>
                    </tr>
                    <tbody>                     
                        <?php foreach($alumno['Familiar'] as $familiar): ?>              
                         <tr class="list">   
                            <td style="text-align: center"><?php echo $familiar['vinculo']; ?></td>
                            <td style="text-align: center"><?php echo $familiar['nombre_completo']; ?></td>
                            <td style="text-align: center"><?php echo $familiar['telefono_nro']; ?></td>
                            <td style="text-align: center"><?php echo $familiar['email']; ?></td>
                            <td style="text-align: center"><?php echo $familiar['domicilio']; ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <table style="width: 100%; border-top: 1px solid black; border-bottom: 1px solid black; font-size: 8pt;">
                    <tr><td colspan="6"><h2>Inscripciones Relacionadas:</h2></td></tr>
                    <tr class="even_row">
                        <th><?php echo $this->Paginator->sort('fecha_alta', 'Fecha de alta');?></th>
                        <th><?php echo $this->Paginator->sort('tipo_alta', 'Tipo de alta');?></th>
                        <th><?php echo $this->Paginator->sort('estado', 'Estado');?></th>
                        <th><?php echo $this->Paginator->sort('fecha_baja', 'Fecha de baja');?></th>
                        <th><?php echo $this->Paginator->sort('motivo_baja', 'Motivo de baja');?></th>
                    </tr>
                    <tbody>                     
                        <?php foreach($alumno['Inscripcion'] as $inscripcion): ?>              
                         <tr class="list">   
                            <td style="text-align: center"><?php echo $inscripcion['fecha_alta']; ?></td>
                            <td style="text-align: center"><?php echo $inscripcion['tipo_alta']; ?></td>
                            <td style="text-align: center"><?php echo $inscripcion['estado']; ?></td>
                            <td style="text-align: center"><?php echo $inscripcion['fecha_baja']; ?></td>
                            <td style="text-align: center"><?php echo $inscripcion['motivo_baja']; ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <table style="width: 100%; border-top: 1px solid black; border-bottom: 1px solid black; font-size: 8pt;">
                    <tr><td colspan="6"><h2>Inasistencias Relacionadas:</h2></td></tr>
                    <tr class="even_row">
                        <th><?php echo $this->Paginator->sort('tipo', 'Tipo');?></th>
                        <th><?php echo $this->Paginator->sort('causa', 'Causa');?></th>
                        <th><?php echo $this->Paginator->sort('justificado', 'Justificado');?></th>
                        <th><?php echo $this->Paginator->sort('created', 'Fecha');?></th>
                    </tr>
                    <tbody>                     
                        <?php foreach($alumno['Inasistencia'] as $inasistencia): ?>              
                         <tr class="list">   
                            <td style="text-align: center"><?php echo $inasistencia['tipo']; ?></td>
                            <td style="text-align: center"><?php echo $inasistencia['causa']; ?></td>
                            <td style="text-align: center"><?php echo $inasistencia['justificado']; ?></td>
                            <td style="text-align: center"><?php echo $inasistencia['created']; ?></td>
                         </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>            
</body>
</html>
*/ ?>