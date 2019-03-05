<?php echo $this->Html->css(array('/js/daterangepicker/daterangepicker')); ?>
<?php echo $this->Html->script(array('tooltip','moment-with-locales.min','daterangepicker/daterangepicker')); ?>
<div class="row">
	<div class="col-xs-6 col-sm-3">
	    <?php echo $this->Form->input('created', array('label' => 'Creado*', 'readonly' => true, 'id' => 'datetimepicker1', 'type' => 'text', 'class' => 'input-group date', 'class' => 'form-control', 'span class' => 'fa fa-calendar')); ?>
	</div>
  	<!--<div class="col-xs-6 col-sm-3">
	    <?php// echo $this->Form->input('pendiente', array('between' => '<br>', 'class' => 'form-control')); ?>
  	</div>-->
</div><hr />
<div class="row">
	<div class="col-md-4 col-sm-6 col-xs-12">
		<div class="unit"><strong><h3>PASO 1: Datos del Perfil</h3></strong><hr />
			<?php	
				if ($current_user['role'] == 'superadmin') {
						echo $this->Form->input('agente', array('between' => '<br>', 'class' => 'form-control', 'label' => "Agente", 'type' => 'checkbox', 'before' => '<label class="checkbox">'));
					}
					echo $this->Form->input('alumno', array('between' => '<br>', 'class' => 'form-control', 'label' => "Alumno", 'type' => 'checkbox', 'before' => '<label class="checkbox">'));
					echo $this->Form->input('familiar', array('between' => '<br>', 'class' => 'form-control', 'label' => "Familiar", 'type' => 'checkbox', 'before' => '<label class="checkbox">'));
			?>
		</div>
		<div class="unit"><strong><h3>PASO 2: Datos Generales</h3></strong><hr />
			<?php
				echo $this->Form->input('nombres', array('label' => 'Nombres (*Obligatorio)', 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Ingrese todos los nombres', 'placeholder' => 'Ingrese todos los Nombres...'));
				echo $this->Form->input('apellidos', array('label'=>'Apellidos (*Obligatorio)', 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Ingrese todos los apellidos', 'placeholder' => 'Ingrese todos los apellidos...'));
				$sexos = array('MASCULINO' => 'MASCULINO', 'FEMENINO' => 'FEMENINO');
				echo $this->Form->input('sexo', array('label' => 'Sexo (*Obligatorio)', 'options' => $sexos, 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Seleccione una opción...'));
				/*
				echo $this->Form->input('foto', array('type' => 'file', 'label' => 'Foto', 'id' => 'foto', 'class' => 'file', 'data-show-upload' => 'false', 'data-show-caption' => 'true'));
				echo $this->Form->input('foto_dir', array('type' => 'hidden'));
				*/
				$documentosTipos = array('DNI' => 'DNI', 'CI' => 'CI', 'LC' => 'LC', 'LE' => 'LE', 'Cédula Mercosur' => 'Cédula Mercosur', 'Pasaporte extranjero' => 'Pasaporte extranjero', 'Cédula de identidad extranjera' => 'Cédula de identidad extranjera', 'Otro documento extranjero' => 'Otro documento extranjero', 'No posee' => 'No posee', 'En trámite' => 'En trámite');
				echo $this->Form->input('documento_tipo', array('label' => 'Tipo de Documento (*Obligatorio)', 'default' => 'DNI', 'options' => $documentosTipos, 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Seleccione una opción...'));
				echo $this->Form->input('documento_nro', array('label'=>'Número de Documento (*Obligatorio)', 'readonly' => true, 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Indique el número sin puntos, ni guiones, ni espacios', 'placeholder' => 'Ingrese un nº de documento...'));
				//echo $this->Form->input('cuil_cuit', array('label'=>'CUIL / CUIT', 'between' => '<br>', 'class' => 'form-control', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Indique el número sin puntos, ni guiones, ni espacios', 'placeholder' => 'Ingrese un nº de CUIL/CUIT...'));
				// Configurando opciones para agregar más años
				?>
    	</div>
	</div>
	<div class="col-md-4 col-sm-6 col-xs-12">
    	<div class="unit"><strong><h3>PASO 3: Datos de Nacimiento</h3></strong><hr />
			<?php
				echo $this->Form->input('fecha_nacimiento', array('id'=>'fecha_nacimiento','value'=>$fechaNacimiento,'label' => 'Fecha de nacimiento (*Obligatorio)', 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Ingrese la fecha de nacimiento...'));
				echo $this->Form->input('pcia_nac', array('label' => 'Lugar de Nacimiento (*Obligatorio)', 'between' => '<br>', 'class' => 'form-control', 'Placeholder' => 'Ingrese un nombre de pcia...'));
				$divisionesTipos = array('Provincia'=>'Provincia','Departamento'=>'Departamento','Partido'=>'Partido','Ciudad'=>'Ciudad','Estado'=>'Estado','Comunidad'=>'Comunidad','Condado'=>'Condado','Tierra'=>'Tierra');
				echo $this->Form->input('division_politica', array('label' => 'División Política (*Obligatorio)', 'default' => 'Provincia', 'options' => $divisionesTipos, 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Seleccione una opción...'));
				$nacionalidades = array(
					'América del Sur' => array( 'Argentino' => 'Argentino', 'Boliviana' => 'Boliviana', 'Brasileña' => 'Brasileña', 'Chilena' => 'Chilena', 'Colombiana' => 'Colombiana', 'Ecuatoriana' => 'Ecuatoriana', 'Guyanesa' => 'Guyanesa', 'Paraguaya' => 'Paraguaya', 'Peruana' => 'Peruana', 'Surinamesa' => 'Surinamesa', 'Uruguaya' => 'Uruguaya', 'Venezolana' => 'Venezolana'),
				'América Central' => array( 'Beliceña' => 'Beliceña', 'Costarricense' => 'Costarricense', 'Guatemalteca' => 'Guatemalteca', 'Hondureña' => 'Hondureña', 'Nicaragüense' => 'Nicaragüense', 'Salvadoreña' => 'Salvadoreña'),
				'América del Norte' => array( 'Canadiense' => 'Canadiense', 'Estadounidense' => 'Estadounidense', 'Mexicana' => 'Mexicana'),
				'Caribe' => array( 'Cubana' => 'Cubana', 'Arubana' => 'Arubana', 'Bahameña' => 'Bahameña', 'Barbadense' => 'Barbadense', 'Dominiquesa' => 'Dominiquesa', 'Dominicana' => 'Dominicana', 'Haitiana' => 'Haitiana', 'Jamaiquina' => 'Jamaiquina', 'Puertorriqueña' => 'Puertorriqueña', 'Sancristobaleña' => 'Sancristobaleña', 'Santaluciana' => 'Santaluciana', 'Sanvicentina' => 'Sanvicentina'),
				'Europa' => array( 'Albanesa' => 'Albanesa', 'Alemana' => 'Alemana', 'Andorrana' => 'Andorrana', 'Armenia' => 'Armenia', 'Austríaca' => 'Austríaca', 'Belga' => 'Belga', 'Bielorrusa' => 'Bielorrusa', 'Bosnia' => 'Bosnia', 'Búlgara' => 'Búlgara', 'Checa' => 'Checa', 'Chipriota' => 'Chipriota', 'Croata' => 'Croata', 'Danesa' => 'Danesa', 'Escocesa' => 'Escocesa', 'Eslovaca' => 'Eslovaca', 'Hindú' => 'Hindú', 'Eslovena' => 'Eslovena', 'Española' => 'Española', 'Estonia' => 'Estonia', 'Finlandesa' => 'Finlandesa', 'Francesa' => 'Francesa', 'Griega' => 'Griega', 'Holandesa' => 'Holandesa', 'Húngara' => 'Húngara', 'Británica' => 'Británica', 'Irlandesa' => 'Irlandesa', 'Italiana' => 'Italiana', 'Letona' => 'Letona', 'Lituana' => 'Lituana', 'Luxemburguesa' => 'Luxemburguesa',  'Maltesa' => 'Maltesa', 'Moldava' => 'Moldava', 'Monegasca' => 'Monegasca', 'Montenegrina' => 'Montenegrina', 'Noruega' => 'Noruega', 'Polaca' => 'Polaca', 'Luxemburguesa' => 'Luxemburguesa', 'Portuguesa' => 'Portuguesa', 'Rumana' => 'Rumana', 'Rusa' => 'Rusa', 'Serbia' => 'Serbia', 'Sueca' => 'Sueca', 'Suiza' => 'Suiza', 'Turca' => 'Turca', 'Ucraniana' => 'Ucraniana'),
					'Oceanía' => array( 'Australiana' => 'Australiana', 'Neozelandesa' => 'Neozelandesa'),
					'Asia' => array( 'Afgana' => 'Afgana', 'Azerbaiyana' => 'Azerbaiyana', 'Bangladesí' => 'Bangladesí', 'Bareiní' => 'Bareiní', 'China' => 'China', 'Liberiana' => 'Liberiana', 'Emiratí' => 'Emiratí', 'Filipina' => 'Filipina', 'Georgiana' => 'Georgiana', 'Hindú' => 'Hindú', 'Indonesia' => 'Indonesia', 'Israelí' => 'Israelí', 'Japonesa' => 'Japonesa', 'Libanesa' => 'Libanesa', 'Mongola' => 'Mongola', 'Norcoreana' => 'Norcoreana', 'Hindú' => 'Hindú', 'Siria' => 'Siria', 'Surcoreana' => 'Surcoreana', 'Vietnamita' => 'Vietnamita'
					),
					'África' => array( 'Argelina' => 'Argelina', 'Camerunesa' => 'Camerunesa', 'Etíope' => 'Etíope', 'Ecuatoguineana' => 'Ecuatoguineana', 'Egipcia' => 'Egipcia', 'Liberiana' => 'Liberiana', 'Libia' => 'Libia', 'Marroquí' => 'Marroquí', 'Namibia' => 'Namibia', 'Nigeriana' => 'Nigeriana', 'Saharaui' => 'Saharaui', 'Senegalesa' => 'Senegalesa', 'Sudafricana' => 'Sudafricana', 'Togolesa' => 'Togolesa'),);
				echo $this->Form->input('nacionalidad', array('label'=>'Nacionalidad (*Obligatorio)', 'empty' => 'Ingrese una nacionalidad...',  'options' => $nacionalidades, 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Seleccione una opción.'));

			if($this->request->data['Persona']['familiar']!=0) {
				echo $this->Form->input('pueblosoriginario_id', array('label' => 'Pueblo originario', 'empty' => 'Ingrese una comunidad...', 'options' => $nativos, 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Si pertenece a algún pueblo originario seleccione una opción de la lista'));
				//Sí el usuario es del nivel Inicial/Primario no muestra los siguientes campos.
				/*
				if (($current_user['role'] == 'superadmin') || ($current_user['puesto'] == 'Dirección Colegio Secundario') || ($current_user['puesto'] == 'Supervisión Secundaria') || ($current_user['puesto'] == 'Dirección Instituto Superior') || ($current_user['puesto'] == 'Supervisión Secundaria')) {
					$estadosCiviles = array('Soltero' => 'Soltero', 'Casado' => 'Casado', 'Viudo' => 'Viudo', 'Divorciado' => 'Divorciado', 'Concubinato' => 'Concubinato', 'Unión civil' => 'Unión civil');
					echo $this->Form->input('estado_civil', array('label' => 'Estado civil*', 'empty' => 'Ingrese un estado...', 'options' => $estadosCiviles, 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Seleccione una opción de la lista'));
					echo $this->Form->input('ocupacion', array('label'=>'Ocupación*', 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Indique a qué se dedica', 'placeholder' => 'Ingrese una ocupación...'));
					echo $this->Form->input('lugar_de_trabajo', array('label'=>'Lugar de Trabajo*', 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Indique un lugar de trabajo', 'placeholder' => 'Ingrese un lugar de trabajo...'));
					$horarios = array('mañana'=>'mañana','mañana y tarde'=>'mañana y tarde','tarde'=>'tarde','tarde y noche'=>'tarde y noche','noche'=>'noche', 'noche y mañana'=>'noche y mañana');
					echo $this->Form->input('horario_de_trabajo', array('label'=>'Horario de Trabajo*', 'options' => $horarios, 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Indique un horario de trabajo', 'placeholder' => 'Ingrese un horario de trabajo...'));
				}
				*/
			} // Estos campos se muestran si la persona es familiar
			// Solo el superadmin asigna Agentes
			?>
		</div>
	</div>	
	<div class="col-md-4 col-sm-6 col-xs-12">
    <div class="unit"><strong><h3>PASO 4: Datos de Contacto</h3></strong><hr />
		<?php
          	echo $this->Form->input('telefono_nro', array('label' => 'Numero de Telefono (*Obligatorio)','class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Ingrese un teléfono de contacto', 'placeholder' => 'Ingrese un nº de teléfono...'));
			echo $this->Form->input('telefono_nro_alt', array('label' => 'Numero de Telefono alternativo','class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Ingrese un teléfono de contacto', 'placeholder' => 'Ingrese un nº de teléfono...'));
          	echo $this->Form->input('email', array('label' => 'Email','class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Ingrese un email de contacto', 'placeholder' => 'Ingrese un email...'));
          	echo $this->Form->input('calle_nombre', array('label' => 'Nombre de la calle','class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Ingrese el nombre de la calle del domicilio real', 'placeholder' => 'Ingrese el nombre de la calle...'));
			echo $this->Form->input('calle_nro', array('label' => 'Número de la calle','class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Ingrese el número de la calle del domicilio real', 'placeholder' => 'Ingrese el número de la calle...'));
			echo $this->Form->input('depto_casa', array('label' => 'Dto/Casa','class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Ingrese el número o letra del Dto/Casa', 'placeholder' => 'Ingrese referencia de Dto/Casa...'));
			echo $this->Form->input('tira_edificio', array('label' => 'Tira/Edificio','class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Ingrese el número o letra de Tira/Edificio', 'placeholder' => 'Ingrese referencia de la Tira/Edificio...'));
			echo $this->Form->input('ciudad_id', array('label' => 'Ciudad', 'empty' => 'Ingrese una ciudad...', 'options' => $ciudades,'id'=>'comboCiudad', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Seleccione la ciudad del domicilio real', 'placeholder' => 'Ingrese una ciudad...'));
			echo $this->Form->input('barrio_id', array('label' => 'Barrio','id'=>'comboBarrio','options'=>$barrios ,'empty' => 'Ingrese un barrio...','between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Seleccione una opción.'));
			echo $this->Form->input('asentamiento_id', array('label' => 'Barrio informal','id'=>'comboAsentamiento', 'empty' => 'Ingrese un barrio informal...',  'options' => $asentamientos, 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Seleccione una opción.'));
			$pendientes = array('SI' => 'SI', 'NO' => 'NO');
	    ?>
    </div>
</div>
<div class="col-md-12 col-sm-6 col-xs-12">
    <?php echo $this->Form->input('observaciones', array('label'=>'Observaciones', 'type' => 'textarea', 'between' => '<br>', 'class' => 'form-control')); ?>
</div>
<script>
	$(document).ready(function(){
		var el = $("#comboCiudad")
		$("#comboBarrio").empty();
		$("#comboAsentamiento").empty();
		console.log(el)
		el.on("change", function(){
			console.log($(this).val());
			$("#comboBarrio").empty();
			$("#comboAsentamiento").empty();
			$.ajax({
				type:"GET",
				url:basePath+"personas/listarBarrios/" + $(this).val(),
				success: function(respuesta){
					var lista = JSON.parse(respuesta);
					$("#comboBarrio").append('<option value="' +''+ '"> ' + 'seleccione un barrio'+ '</option>');
					for (var key in lista) {
						$("#comboBarrio").append('<option value="' +key+ '"> ' + lista[key] + '</option>');
					}
				}
		})
		$.ajax({
			type:"GET",
			url:basePath+"personas/listarAsentamientos/" + $(this).val(),
			success: function(respAsentamiento){
				var listaA = JSON.parse(respAsentamiento);
				$("#comboAsentamiento").append('<option value="' +''+ '"> ' + 'seleccione un asentamiento'+ '</option>');
				for (var keyA in listaA) {
					$("#comboAsentamiento").append('<option value="' +keyA+ '"> ' + listaA[keyA] + '</option>');
				}
			}
		})
	});
	});
</script>

<script type="text/javascript">
	$(function() {
		moment.locale('es');

		$('#fecha_nacimiento').daterangepicker({
			singleDatePicker: true,
			showDropdowns: true,
			minYear: 1901,
			maxYear: parseInt(moment().format('YYYY'),10)
		}, function(start, end, label) {
   			var years = moment().diff(start, 'years');
			alert("Tiene " + years + " años!"); 
		});
	});
</script>