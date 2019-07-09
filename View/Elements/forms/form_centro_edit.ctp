<?php echo $this->Html->script(array('tooltip', 'datepicker', 'moment', 'bootstrap-datetimepicker')); ?>
<div class="row"></div>
<div class="row">
	<div class="col-md-4 col-sm-6 col-xs-12">
  		<div class="unit"><strong><h3>PASO 1: Datos Generales</h3></strong><hr />
  	  	<?php
			if ($current_user['role'] == 'superadmin' && $current_user['puesto'] == 'Sistemas') {
				echo $this->Form->input('cue', array('id'=>'cue', 'label'=>'CUEANEXO (*Obligatorio)', ' between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Ingrese un CUE')); 
			} else {
				echo $this->Form->input('cue', array('id'=>'cue', 'label'=>'CUEANEXO (*Obligatorio)', 'readonly' => true, ' between' => '<br>', 'class' => 'form-control'));
			}
			if ($current_user['role'] == 'superadmin' && $current_user['puesto'] == 'Sistemas') {
				echo $this->Form->input('nombre', array('id'=>'nombre', 'label'=>'Nombre (*Obligatorio)', 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Ingrese un nombre'));	 
			} else {
				echo $this->Form->input('nombre', array('id'=>'nombre', 'label'=>'Nombre (*Obligatorio)', 'readonly' => true, 'between' => '<br>', 'class' => 'form-control'));
			}
			if ($current_user['role'] == 'superadmin' && $current_user['puesto'] == 'Sistemas') {
				echo $this->Form->input('sigla', array('id'=>'sigla', 'label'=>'Sigla (*Obligatorio)', 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Ingrese una sigla'));
			} else {
				echo $this->Form->input('sigla', array('id'=>'sigla', 'label'=>'Sigla (*Obligatorio)', 'readonly' => true, 'between' => '<br>', 'class' => 'form-control'));
			}	
			$sectores = array('ESTATAL' => 'ESTATAL', 'PRIVADO' => 'PRIVADO');
	        if ($current_user['role'] == 'superadmin' && $current_user['puesto'] == 'Sistemas') {
	        	echo $this->Form->input('sector', array('label' => 'Sector (*Obligatorio)', 'empty' => 'Ingrese un sector...', 'options' => $sectores, 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Seleccione una opción...'));
	        } else {
	        	echo $this->Form->input('sector', array('label' => 'Sector (*Obligatorio)', 'readonly' => true, 'between' => '<br>', 'class' => 'form-control'));
	        }	
	        $nivelServicios = array('Común - Inicial' => 'Común - Inicial', 'Común - Primario' => 'Común - Primario', 'Común - Inicial - Primario' => 'Común - Inicial - Primario', 'Común - Secundario' => 'Común - Secundario', 'Común - Superior' => 'Común - Superior', 'Común - Cursos de Capacitación de Superior' => 'Común - Cursos de Capacitación de Superior', 'Común - Trayecto Artístico Profesional' => 'Común - Trayecto Artístico Profesional', 'Común - Cursos y Talleres de Artística
				' => 'Común - Cursos y Talleres de Artística', 'Común - Ciclos de Enseñanza Artística' => 'Común - Ciclos de Enseñanza Artística', 'Común - Servicios Alternativos/Complementarios' => 'Común - Servicios Alternativos/Complementarios', 'Común - Domiciliaria-hospitalaria. Inicial' => 'Común - Domiciliaria-hospitalaria. Inicial', 'Común - Domiciliaria-hospitalaria. Primario' => 'Común - Domiciliaria-hospitalaria. Primario', 'Común - Domiciliaria-hospitalaria. Secundario
				' => 'Común - Domiciliaria-hospitalaria. Secundario', 'Común - Trayecto técnico profesional' => 'Común - Trayecto técnico profesional', 'Común - Itinerario formativo' => 'Común - Itinerario formativo', 'Especial - Inicial' => 'Especial - Inicial', 'Especial - Primario' => 'Especial - Primario', 'Especial - Secundario
				' => 'Especial - Secundario', 'Especial - Taller de nivel Primario' => 'Especial - Taller de nivel Primario', 'Especial - Taller de nivel Secundario' => 'Especial - Taller de nivel Secundario', 'Especial - Talleres de educacion integral' => 'Especial - Talleres de educacion integral', 'Especial - Integración' => 'Especial - Integración', 'Especial - Domiciliaria-hospitalaria. Inicial' => 'Especial - Domiciliaria-hospitalaria. Inicial', 'Especial - Domiciliaria-hospitalaria. Primario' => 'Especial - Domiciliaria-hospitalaria. Primario', 'Especial - Domiciliaria-hospitalaria. Secundario' => 'Especial - Domiciliaria-hospitalaria. Secundario', 'Adultos - Primario' => 'Adultos - Primario', 'Adultos - Secundario' => 'Adultos - Secundario', 'Adultos - Alfabetización' => 'Adultos - Alfabetización', 'Adultos - Formación Profesional/Capacitación Laboral' => 'Adultos - Formación Profesional/Capacitación Laboral', 'Adultos - Domiciliaria-hospitalaria. Primario
				' => 'Adultos - Domiciliaria-hospitalaria. Primario', 'Adultos - Domiciliaria-hospitalaria. Secundario' => 'Adultos - Domiciliaria-hospitalaria. Secundario');
	        if ($current_user['role'] == 'superadmin' && $current_user['puesto'] == 'Sistemas') {
	        	echo $this->Form->input('nivel_servicio', array('label' => 'Nivel - Servicio (*Obligatorio)', 'empty' => 'Ingrese un nivel y servicio...', 'options' => $nivelServicios, 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Seleccione una opción...'));
	        } else {
	        	echo $this->Form->input('nivel_servicio', array('label' => 'Nivel - Servicio (*Obligatorio)', 'readonly' => true, 'between' => '<br>', 'class' => 'form-control'));
	        }	
			echo $this->Form->input('fechaFundacion', array('label' => 'Fecha de fundación*', 'id' => 'datetimepicker2', 'type' => 'text', 'class' => 'input-group date', 'class' => 'form-control', 'span class' => 'fa fa-calendar'));
			?>
		</div>
	<?php echo '</div><div class="col-md-4 col-sm-6 col-xs-12">'; ?>
    <div class="unit"><strong><h3>PASO 2: Datos de Ubicación</h3></strong><hr />
	  	<?php
			$ambitos = array('URBANO' => 'URBANO', 'RURAL' => 'RURAL');
			if ($current_user['role'] == 'superadmin' && $current_user['puesto'] == 'Sistemas') {
	        	echo $this->Form->input('ambito', array('label' => 'Ambito (*Obligatorio)', 'empty' => 'Ingrese un ámbito...', 'options' => $ambitos, 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Seleccione una opción...'));
			} else {
				echo $this->Form->input('ambito', array('label' => 'Ambito (*Obligatorio)', 'readonly' => true, 'between' => '<br>', 'class' => 'form-control'));
			}
			if ($current_user['role'] == 'superadmin' && $current_user['puesto'] == 'Sistemas') {
				echo $this->Form->input('direccion', array('id'=>'direccion', 'label' => 'Dirección (*Obligatorio)', 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Ingrese una dirección', 'placeholder' => 'Ingrese la dirección...'));
			} else {
				echo $this->Form->input('direccion', array('id'=>'direccion', 'label' => 'Dirección (*Obligatorio)', 'readonly' => true, 'between' => '<br>', 'class' => 'form-control'));
			}
			if ($current_user['role'] == 'superadmin' && $current_user['puesto'] == 'Sistemas') {
				echo $this->Form->input('cp', array('label' => 'Código Postal', 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Ingrese un código postal', 'placeholder' => 'Ingrese el código postal...'));
			} else {
				echo $this->Form->input('cp', array('label' => 'Código Postal', 'readonly' => true, 'between' => '<br>', 'class' => 'form-control'));
			}
			//echo $this->Form->input('codigo_localidad', array('between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Ingrese un código de localidad', 'placeholder' => 'Ingrese el código de localidad...'));
			if ($current_user['role'] == 'superadmin' && $current_user['puesto'] == 'Sistemas') {
				echo $this->Form->input('departamento_id', array('label' => 'Departamento (*Obligatorio)', 'id'=> 'comboDepto', 'options' => $departamentos, 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom','empty' => 'Ingrese un departamento...', 'title' => 'Seleccione una opción...'));
			} else {
				echo $this->Form->input('departamento_id', array('label' => 'Departamento (*Obligatorio)', 'readonly' => true, 'between' => '<br>', 'class' => 'form-control'));
			}
			if ($current_user['role'] == 'superadmin' && $current_user['puesto'] == 'Sistemas') {	
		  		echo $this->Form->input('ciudad_id', array('label' => 'Ciudad / Localidad (*Obligatorio)' , 'id'=> 'comboCiudad', 'options' => $ciudades, 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Seleccione una opción...'));
		  	} else {
		  		echo $this->Form->input('ciudad_id', array('label' => 'Ciudad / Localidad (*Obligatorio)', 'readonly' => true, 'between' => '<br>', 'class' => 'form-control'));
		  	}	
		  	if ($current_user['role'] == 'superadmin' && $current_user['puesto'] == 'Sistemas') {
				echo $this->Form->input('barrio_id', array('label' => 'Barrio', 'id'=> 'comboBarrio', 'options' => $barrios, 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Seleccione una opción...'));
			} else {
				echo $this->Form->input('barrio_id', array('label' => 'Barrio', 'readonly' => true, 'between' => '<br>', 'class' => 'form-control'));
			}	
		?>
	</div>
	<?php echo '</div><div class="col-md-4 col-sm-6 col-xs-12">'; ?>
    <div class="unit"><strong><h3>PASO 3: Datos de Contacto</h3></strong><hr />
	  	<?php
			echo $this->Form->input('email', array('id'=>'email', 'label' => 'Email (*Obligatorio)', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Introduzca un email de contacto válido', 'Placeholder' => 'Ingrese un email de contacto.'));
			echo $this->Form->input('url', array('id'=>'url', 'label' => 'URL', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Introduzca un sitio web válido', 'Placeholder' => 'Ingrese un sitio web.'));
			echo $this->Form->input('telefono', array('label' => 'Teléfono fijo (*Obligatorio)', 'id'=>'telefono', 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Ingrese un teléfono fijo', 'placeholder' => 'Ingrese un número de teléfono fijo...'));
			echo $this->Form->input('equipoDirectivo', array('label'=>'Equipo directivo', 'type' => 'textarea', 'between' => '<br>', 'class' => 'form-control'));
		?>
	</div>
</div>
<script>
	var barrioActual = '<?php echo $this->data['Centro']['barrio_id']; ?>';
	
	function getBarrios(idCiudad) {
		var elBarrio = $("#comboBarrio");
		elBarrio.empty();
		$.ajax({
			type: "GET",
			url: basePath + "personas/listarBarrios/" + idCiudad,
			success: function (respuesta) {
				var lista = JSON.parse(respuesta);
				elBarrio.append('<option value="">' + 'seleccione un barrio' + '</option>');
				for (var key in lista) {
					elBarrio.append('<option value="' + key + '">' + lista[key] + '</option>');
				}
				elBarrio.val(barrioActual);
			}
		});
	}

	$(document).ready(function(){
		var elCiudad = $("#comboCiudad");
		$("#comboBarrio").empty();

		getBarrios(elCiudad.val());

		elCiudad.on("change", function(){
			var idCiudad = $(this).val();
			getBarrios(idCiudad);
		});

	});
</script>
<script type="text/javascript">
            $('#datetimepicker1').datetimepicker({
			useCurrent: true, //this is important as the functions sets the default date value to the current value
			format: 'YYYY-MM-DD hh:mm',
			}).on('dp.change', function (e) {
                  var specifiedDate = new Date(e.date);
				  if (specifiedDate.getMinutes() == 0)
				  {
					  specifiedDate.setMinutes(1);
					  $(this).data('DateTimePicker').date(specifiedDate);
				  }
               });
</script>
<script type="text/javascript">
            $('#datetimepicker2').datetimepicker({
			useCurrent: true, //this is important as the functions sets the default date value to the current value
			format: 'YYYY-MM-DD hh:mm',
			}).on('dp.change', function (e) {
                  var specifiedDate = new Date(e.date);
				  if (specifiedDate.getMinutes() == 0)
				  {
					  specifiedDate.setMinutes(1);
					  $(this).data('DateTimePicker').date(specifiedDate);
				  }
               });
</script>
</div>
