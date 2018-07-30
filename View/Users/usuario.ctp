<!-- app/View/Users/usuario.ctp -->
<div class="users form">
<!-- start main -->
<div class="TituloSec"><?php echo $nombreCentro ?></div>
<div id="ContenidoSec">
	<div class="panel panel-primary">
	  <div class="panel-heading">
	    <h3 class="panel-title">INICIAL, PRIMARIA Y SECUNDARIA | INSCRIPCIONES POR HERMANOS</h3>
	  </div>
	  <div class="panel-body">
	    <p> Se desarrollarán en todos los niveles los días 6 y 7 de Agosto. La operatoria en SIEP incluye los siguiente pasos: </p>
	  </div>
	  <!-- List group -->
	  <ul class="list-group">
	    <li class="list-group-item">1º PASO | "Acceso al formulario p/agregar inscripciones": Desde el menú ALUMNADO --> INSCRIPCIONES, click en el botón "+AGREGAR". </li>
	    <li class="list-group-item">2º PASO | "Alta de inscripción por hermano": Completar los siguientes campos obligatorios como se indican a continuación:
	    <ul>
	    	<li>"Ciclo lectivo*": 2019</li>
	    	<li>"Estado de la inscripción*": CONFIRMADA</li>
	    	<li>"Nombre y apellidos del alumno*": (Indique el nombre del ingresante)</li>
	    	<li>"Sección*": (indique una sección sin división ej: 1ro Mañana)</li>
	    	<li>"Tipo de inscripción*": Hermano de alumno regular</li>
	    	<li>"Hermano de Alumno Regular": (Indique el alumno que corresponda)</li>
	    	<li>Click en el botón "GUARDAR" (SIEP le mostrará el detalle de la inscripción registrada)</li>
	    </ul>	
	    </li>
	    <li class="list-group-item">3º PASO | "Revisión de la inscripción recién registrada": verifique en "Datos de Alta" figure el nombre correcto del hermano.</li>
	  </ul>
	</div>
<?php if($current_user['role'] == 'usuario'): ?>
	<div class="panel panel-primary">
	  <div class="panel-heading">
	    <h3 class="panel-title">INICIAL Y PRIMARIA | INSCRIPCIONES POR PASES (Nuevo procedimiento)</h3>
	  </div>
	  <div class="panel-body">
	    <p> A continuación se detallan los pasos a seguir para registrar inscripciones por pases en SIEP entre una institución origen (IO) y una institución destino (ID): </p>
	  </div>
	  <!-- List group -->
	  <ul class="list-group">
	    <li class="list-group-item">1º PASO | "Verificación de Baja en la IO": Desde el menú ALTA DE PERSONAS, indicar en "BÚSQUEDA" un alumno y luego click en el botón "BUSCAR". </li>
	    <li class="list-group-item">2º PASO | "Alta de inscripción por pase": Completar los siguientes campos obligatorios como se indican a continuación:
	    <ul>
	    	<li>"Ciclo lectivo*": (indicar el corriente ciclo lectivo)</li>
	    	<li>"Estado de la inscripción*": CONFIRMADA</li>
	    	<li>"Nombre y apellidos del alumno*": (Indique el nombre del ingresante)</li>
	    	<li>"Sección*": (indique una sección sin división ej: 1ro Mañana)</li>
	    	<li>"Tipo de inscripción*": Pase</li>
	    	<li>"Pase": (Indique IO)</li>
	    	<li>Click en el botón "GUARDAR" (SIEP le mostrará el detalle de la inscripción registrada)</li>
	    </ul>	
	    </li>
	    <li class="list-group-item">3º PASO | "Revisión de la inscripción recién registrada": verifique en "Datos de Alta" figure el nombre correcto de la IO.</li>
	  </ul>
	</div>
<?php endif; ?>
</div>
