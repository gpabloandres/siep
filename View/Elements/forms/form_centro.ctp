<?php echo $this->Html->script(array('tooltip', 'datepicker', 'moment', 'bootstrap-datetimepicker')); ?>
<div class="row">
</div>
</div><hr />
<div class="row">
	<div class="col-md-4 col-sm-6 col-xs-12">
  		<div class="unit"><strong><h3>Datos Generales</h3></strong><hr />
  	  	<?php
			echo $this->Form->input('cue', array('id'=>'cue', 'label'=>'CUE*', 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Ingrese un CUE', 'placeholder' => 'Ingrese un CUE...'));
			echo $this->Form->input('nombre', array('id'=>'nombre', 'label'=>'Nombre*', 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Ingrese un nombre', 'placeholder' => 'Ingrese el nombre de la institución...'));
			echo $this->Form->input('sigla', array('id'=>'sigla', 'label'=>'Sigla*', 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Ingrese una sigla', 'placeholder' => 'Ingrese una sigla de la institución...'));
			$sectores = array('ESTATAL' => 'ESTATAL', 'PRIVADO' => 'PRIVADO');
	        echo $this->Form->input('sector', array('label' => 'Sector*', 'empty' => 'Ingrese un sector...', 'options' => $sectores, 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Seleccione una opción...'));
	        $nivelServicios = array('Común - Inicial' => 'Común - Inicial', 'Común - Primario' => 'Común - Primario', 'Común - Inicial - Primario' => 'Común - Inicial - Primario', 'Común - Secundario' => 'Común - Secundario', 'Común - Superior' => 'Común - Superior', 'Común - Cursos de Capacitación de Superior' => 'Común - Cursos de Capacitación de Superior', 'Común - Trayecto Artístico Profesional' => 'Común - Trayecto Artístico Profesional', 'Común - Cursos y Talleres de Artística
				' => 'Común - Cursos y Talleres de Artística', 'Común - Ciclos de Enseñanza Artística' => 'Común - Ciclos de Enseñanza Artística', 'Común - Servicios Alternativos/Complementarios' => 'Común - Servicios Alternativos/Complementarios', 'Común - Domiciliaria-hospitalaria. Inicial' => 'Común - Domiciliaria-hospitalaria. Inicial', 'Común - Domiciliaria-hospitalaria. Primario' => 'Común - Domiciliaria-hospitalaria. Primario', 'Común - Domiciliaria-hospitalaria. Secundario
				' => 'Común - Domiciliaria-hospitalaria. Secundario', 'Común - Trayecto técnico profesional' => 'Común - Trayecto técnico profesional', 'Común - Itinerario formativo' => 'Común - Itinerario formativo', 'Especial - Inicial' => 'Especial - Inicial', 'Especial - Primario' => 'Especial - Primario', 'Especial - Secundario
				' => 'Especial - Secundario', 'Especial - Taller de nivel Primario' => 'Especial - Taller de nivel Primario', 'Especial - Taller de nivel Secundario' => 'Especial - Taller de nivel Secundario', 'Especial - Talleres de educacion integral' => 'Especial - Talleres de educacion integral', 'Especial - Integración' => 'Especial - Integración', 'Especial - Domiciliaria-hospitalaria. Inicial' => 'Especial - Domiciliaria-hospitalaria. Inicial', 'Especial - Domiciliaria-hospitalaria. Primario' => 'Especial - Domiciliaria-hospitalaria. Primario', 'Especial - Domiciliaria-hospitalaria. Secundario' => 'Especial - Domiciliaria-hospitalaria. Secundario', 'Adultos - Primario' => 'Adultos - Primario', 'Adultos - Secundario' => 'Adultos - Secundario', 'Adultos - Alfabetización' => 'Adultos - Alfabetización', 'Adultos - Formación Profesional/Capacitación Laboral' => 'Adultos - Formación Profesional/Capacitación Laboral', 'Adultos - Domiciliaria-hospitalaria. Primario
				' => 'Adultos - Domiciliaria-hospitalaria. Primario', 'Adultos - Domiciliaria-hospitalaria. Secundario' => 'Adultos - Domiciliaria-hospitalaria. Secundario');
	        echo $this->Form->input('nivel_servicio', array('label' => 'Nivel - Servicio*', 'empty' => 'Ingrese un nivel y servicio...', 'options' => $nivelServicios, 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Seleccione una opción...'));
			echo $this->Form->input('fechaFundacion', array('label' => 'Fecha de fundación*', 'id' => 'datetimepicker2', 'type' => 'text', 'class' => 'input-group date', 'class' => 'form-control', 'span class' => 'fa fa-calendar'));
			?>
		</div>
	<?php echo '</div><div class="col-md-4 col-sm-6 col-xs-12">'; ?>
    <div class="unit"><strong><h3>Datos de Contacto</h3></strong><hr />
	  	<?php
			$ambitos = array('URBANO' => 'URBANO', 'RURAL' => 'RURAL');
	        echo $this->Form->input('ambito', array('label' => 'Ambito*', 'empty' => 'Ingrese un ámbito...', 'options' => $ambitos, 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Seleccione una opción...'));
			echo $this->Form->input('direccion', array('id'=>'direccion', 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Ingrese una dirección', 'placeholder' => 'Ingrese la dirección...'));
			echo $this->Form->input('cp', array('between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Ingrese un código postal', 'placeholder' => 'Ingrese el código postal...'));
			echo $this->Form->input('codigo_localidad', array('between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Ingrese un código de localidad', 'placeholder' => 'Ingrese el código de localidad...'));
			echo $this->Form->input('departamento_id', array('label' => '*Departamento', 'id'=> 'comboDepto','options' => $departamentos,'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom','empty' => 'Ingrese un departamento...', 'title' => 'Seleccione una opción...'));
		  echo $this->Form->input('ciudad_id', array('label' => '*ciudad' ,'id'=> 'comboCiudad','options' => $ciudades, 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Seleccione una opción...'));
			echo $this->Form->input('barrio_id', array('label' => 'barrio','id'=> 'comboBarrio', 'options' => $barrios, 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Seleccione una opción...'));
		?>
	</div>
	<?php echo '</div><div class="col-md-4 col-sm-6 col-xs-12">'; ?>
    <div class="unit"><strong><h3>Datos de Contacto</h3></strong><hr />
	  	<?php
			echo $this->Form->input('email', array('id'=>'email', 'label' => 'Email*', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Introduzca un email de contacto válido', 'Placeholder' => 'Ingrese un email de contacto.'));
			echo $this->Form->input('url', array('id'=>'url', 'label' => 'URL', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Introduzca un sitio web válido', 'Placeholder' => 'Ingrese un sitio web.'));
			echo $this->Form->input('telefono', array('id'=>'telefono', 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Ingrese un teléfono', 'placeholder' => 'Ingrese un número de teléfono...'));
			?>
	</div>
</div>
<div class="col-md-12 col-sm-6 col-xs-12">
    <?php echo $this->Form->input('equipoDirectivo', array('label'=>'Equipo directivo', 'type' => 'textarea', 'between' => '<br>', 'class' => 'form-control')); ?>
</div>
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
<script>
	 	$(document).ready(function(){
	 		var el = $("#comboDepto")
			var elCiudad = $("#comboCiudad")
			$("#comboBarrio").empty(); //si se produce un cambio en #comboDepto-> se vacia el #comboBarrio
			$("#comboCiudad").empty(); //si se produce un cambio en #comboDepto-> se vacia el #comboBarrio
	 		el.on("change", function(){
	 			console.log($(this).val());
				$("#comboCiudad").empty();
				$("#comboBarrio").empty();
	 			$.ajax({
	 				type:"GET",
	 				url:basePath+"centros/listarCiudad/" + $(this).val(),
	 				success: function(respuesta){
						var lista = JSON.parse(respuesta);
						$("#comboCiudad").append('<option value="' +''+ '"> ' + 'seleccione una ciudad'+ '</option>');
						for (var key in lista) {
							$("#comboCiudad").append('<option value="' +key+ '"> ' + lista[key] + '</option>');
						}
					}
	 		})
	 	});
		elCiudad.on("change", function(){
			console.log($(this).val());
			$("#comboBarrio").empty();
			$.ajax({
				type:"GET",
				url:basePath+"centros/listarBarrios/" + $(this).val(),
				success: function(respuesta){
					var lista = JSON.parse(respuesta);
					$("#comboBarrio").append('<option value="' +''+ '"> ' + 'seleccione un barrio'+ '</option>');
					for (var key in lista) {
						$("#comboBarrio").append('<option value="' +key+ '"> ' + lista[key] + '</option>');
					}
				}
		})
	});
	});
	 	</script>
</div>
