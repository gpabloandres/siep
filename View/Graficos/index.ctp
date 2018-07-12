<!-- *********** Acordeon ************* -->
<?php echo $this->Html->script('jsapi'); ?>
<?php echo $this->Html->script('uds_api_contents'); ?>
<?php echo $this->Html->script('graficos'); ?>
<?php echo $this->Html->script('acordeon'); ?>
<!-- ************************************** -->

<div class="TituloSec"><?php echo __('Reportes gráficos'); ?></div>
<div id="ContenidoSec">
    <script>
		$(document).ready(function () {
		    $(window).resize(function(){
		        graficos('barra','inscripcion','i_x_curso');
		        graficos('barra','recursante','r_x_curso');
		        graficos('barra','abandono','a_x_curso');
		    });
		});
    </script>
<!-- Alumnos Inscriptos por curso -->
<div id="click_01" class="titulo_acordeon">Inscriptos por Curso</div>
<div id="acordeon_01"></div>
<div id="inscripcion" style="width:100%; height:300px"></div>
    <script>
     		graficos('barra','inscripcion','i_x_curso');
    </script>
<!-- end Alumnos Inscriptos por curso -->
<!-- Recursantes por curso -->
<div id="click_02" class="titulo_acordeon">Recursantes por Curso</div>
<div id="acordeon_02"></div>
<div id="recursante" style="width:100%; height:300px"></div>
<!-- end Recursantes por curso -->
</div>
    <script>
	        graficos('barra','recursante','r_x_curso');
    </script>
    <!-- Abandono por curso -->
<div id="click_02" class="titulo_acordeon">Abandonos por Curso</div>
<div id="acordeon_02"></div>
<div id="abandono" style="width:100%; height:300px"></div>
<!-- end Abandono por curso -->
</div>
    <script>
	        graficos('barra','abandono','a_x_curso');
    </script>