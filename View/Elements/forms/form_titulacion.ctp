<?php echo $this->Html->script(array('tooltip', 'datepicker', 'moment', 'bootstrap-datetimepicker')); ?>
<div class="row">
  <div class="col-xs-6 col-sm-3">
      <?php echo $this->Form->input('created', array('label' => 'Creado*', 'id' => 'datetimepicker1', 'type' => 'text', 'class' => 'input-group date', 'class' => 'form-control', 'span class' => 'fa fa-calendar')); ?>
  </div>
</div><hr />
<div class="row">
  <div class="col-md-4 col-sm-6 col-xs-12">
	  <?php
          echo $this->Form->input('nombre', array('label' => 'Nombre*', 'empty' => 'Ingrese un nombre...', 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Introduzca el nombre de la titulación'));
          $certificaciones = array('Primaria de 6 años' => 'Primaria de 6 años', 'Primaria de 7 años' => 'Primaria de 7 años','9 años' => '9 años', 'Secundaria' => 'Secundaria', 'EGB - Primaria y Ciclo Básico' => 'EGB - Primaria y Ciclo Básico', 'Sin requisitos' => 'Sin requisitos', 'Medio completo' => 'Medio completo', 'Otros' => 'Otros' );
          echo $this->Form->input('certificacion', array('label' => 'Certificación*', 'empty' => 'Ingrese una certificación...',  'options' => $certificaciones, 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Seleccione una opción de la lista'));
          $condiciones_ingreso = array('Asistir al Curso' => 'Asistir al Curso', 'Aprobar Curso' => 'Aprobar Curso', 'Examen de Ingreso' => 'Examen de Ingreso', 'Prueba de nivel o aptitud' => 'Prueba de nivel o aptitud', 'Sin requisitos- unicamente Secundario' => 'Sin  requisitos - unicamente Secundario', 'Otros' => 'Otros');
          echo $this->Form->input('condicion_ingreso', array('label' => 'Condición de Ingreso*', 'empty' => 'Ingrese una condición de ingreso...', 'options' => $condiciones_ingreso, 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Seleccione una opción de la lista'));
          echo $this->Form->input('ciclo_implementacion', array('label' => 'Ciclo de implementación*', 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Introduzca el año inicial de vigencia del título', 'placeholder' => 'Ciclo de implementación'));
          echo $this->Form->input('ciclo_finalizacion', array('label' => 'Ciclo de finalización', 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Introduzca el año final de vigencia del título', 'placeholder' => 'Ciclo de finalización'));
          $tipo_formaciones = array('Docente' => 'Docente', 'Docente y Técnico Profesional' => 'Docente y Técnico Profesional', 'Técnico tecnológico' => 'Técnico tecnológico', 'Técnico humanístico' => 'Técnico humanístico');
          echo $this->Form->input('tipo_formacion', array('label' => 'Formación tipo (superior)*', 'empty' => 'Ingrese un tipo...', 'options' => $tipo_formaciones, 'between' => '<br>', 'class' => 'form-control'));
          $tipos = array('Grado-Formación Inicial' => 'Grado-Formación Inicial', 'Posgrado-Especialización' => 'Posgrado-Especialización', 'Postítulo Docente' => 'Postítulo Docente');
          echo $this->Form->input('tipo', array('label' => 'Tipo (superior)*', 'empty' => 'Ingrese un tipo...', 'options' => $tipos, 'between' => '<br>', 'class' => 'form-control'));
		  echo $this->Form->input('a_termino', array('between' => '<br>', 'class' => 'form-control'));
          $orientaciones = array('Bachiller' => 'Bachiller', 'Ciclo Básico' => 'Ciclo Básico', 'Comercial' => 'Comercial', 'Técnica' => 'Técnica', 'Agropecuaria' => 'Agropecuaria', 'Artística' => 'Artística', 'Otros' => 'Otros', 'Ciclo Básico Técnico' => 'Ciclo Básico Técnico', 'Humanidades y Cs. Sociales' => 'Humanidades y Cs. Sociales', 'Ciencias Naturales' => 'Ciencias Naturales', 'Economía y Gestión de las Organizaciones' => 'Economía y Gestión de las Organizaciones', 'Producción de Bienes y Servicios' => 'Producción de Bienes y Servicios', 'Comuncación, Artes y Diseño' => 'Comuncación, Artes y Diseño', 'Ciclo Básico Artístico' => 'Ciclo Básico Artístico', 'Ciclo Básico Agrario' => 'Ciclo Básico Agrario', 'Lenguas' => 'Lenguas', 'Economía y Administración' => 'Economía y Administración', 'Informática' => 'Informática', 'Agro y Ambiente' => 'Agro y Ambiente', 'Turismo' => 'Turismo', 'Comunicación' => 'Comunicación', 'Educación Física' => 'Educación Física', 'Ciencias naturales,salud y medio ambiente' => 'Ciencias naturales ,salud y medio ambiente', 'Gestión y Administración' => 'Gestión y Administración', 'Tecnología' => 'Tecnología', 'Letras' => 'Letras', 'Físico Matemática' => 'Físico Matemática', 'Pedagogía' => 'Pedagogía');
          echo $this->Form->input('orientacion', array('label' => 'Orientación*', 'empty' => 'Ingrese una Orientación...', 'options' => $orientaciones, 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Seleccione una opción de la lista'));
          $organizaciones_plan = array('Año de estudio' => 'Año de estudio', 'Grado' => 'Grado', 'Módulo' => 'Módulo', 'Ciclo' => 'Ciclo', 'Etapa' => 'Etapa', 'Trayecto formativo' => 'Trayecto formativo', 'Trayecto formativo y año' => 'Trayecto formativo y año');
          echo $this->Form->input('organizacion_plan', array('label' => 'Organización del plan*', 'empty' => 'Ingrese una opción...', 'options' => $organizaciones_plan, 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Seleccione una opción de la lista'));
          $organizaciones_cursada = array('Sección' => 'Sección', 'Comisión' => 'Comisión', 'División' => 'División', 'Espacio Curricular' => 'Espacio Curricular', 'Caso especial' => 'Caso especial');
          echo $this->Form->input('organizacion_cursada', array('label' => 'Organización de la cursada*', 'empty' => 'Ingrese una opción...', 'options' => $organizaciones_cursada, 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Seleccione una opción de la lista'));
       ?>
  </div>
  <div class="col-md-4 col-sm-6 col-xs-12">
	  <?php
          $formas_dictado = array('Presencial' => 'Presencial', 'A Distancia - Semipresencial' => 'A Distancia - Semipresencial', 'A Distancia - Asistida' => 'A Distancia - Asistida', 'A Distancia - Abierta' => 'A Distancia - Abierta', 'A Distancia - Virtual' => 'A Distancia - Virtual');
          echo $this->Form->input('forma_dictado', array('label' => 'Forma de dictado*', 'empty' => 'Ingrese una forma de dictado...', 'options' => $formas_dictado, 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Seleccione una opción de la lista'));
      	  $cargas_horarias_en = array('Hora Cátedra' => 'Hora Cátedra', 'Hora Reloj' => 'Hora Reloj');
          echo $this->Form->input('carga_horaria_en', array('label' => 'Carga horaria en*', 'empty' => 'Ingrese una carga horaria...', 'options' => $cargas_horarias_en, 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Seleccione una opción de la lista'));
          echo $this->Form->input('carga_horaria', array('label' => 'Carga horaria*', 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Introduzca un número', 'Placeholder' => 'Ingrese una carga horaria'));
          echo $this->Form->input('edad_minima', array('label' => 'Edad mínima*', 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Introduzca un número', 'Placeholder' => 'Ingrese una edad mínima'));
          $tiene_articulaciones = array('Si' => 'Si', 'No Articula' => 'No Articula', 'Si, en este establecimiento' => 'Si, en este establecimiento', 'Si, en otro establecimiento' => 'Si, en otro establecimiento');
          echo $this->Form->input('tiene_articulacion', array('label' => 'Tiene articulación*', 'empty' => 'Ingrese una opción...', 'options' => $tiene_articulaciones, 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Seleccione una opción de la lista'));
          $duraciones_en = array('Años' => 'Años', 'Cuatrimestres' => 'Cuatrimestres');
          echo $this->Form->input('duracion_en', array('label' => 'Duración en*', 'empty' => 'Ingrese duración...', 'options' => $duraciones_en, 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Seleccione una opción de la lista'));
          echo $this->Form->input('duracion', array('label' => 'Duración*', 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Introduzca una número', 'Placeholder' => 'Ingrese una duración'));
          $norma_jur_tipos = array('Ley' => 'Ley', 'Resolución' => 'Resolución');
          echo $this->Form->input('norma_aprob_jur_tipo', array('label' => 'Norma de aprobación provincial tipo', 'empty' => 'Ingrese un tipo de norma... ', 'options' => $norma_jur_tipos, 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Seleccione una opción de la lista'));
          echo $this->Form->input('norma_aprob_jur_nro', array('label' => 'Norma de aprobación provincial Nro*', 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Introduzca una número', 'Placeholder' => 'Ingrese un número'));
          echo $this->Form->input('norma_aprob_jur_anio', array('label' => 'Norma de aprobación provincial Año*', 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Introduzca un año', 'Placeholder' => 'Ingrese un año'));
          $norma_nac_tipos = array('Ley' => 'Ley', 'Resolución' => 'Resolución');
          echo $this->Form->input('norma_val_nac_tipo', array('label' => 'Norma de aprobación nacional tipo*', 'empty' => 'Ingrese un tipo de norma...', 'options' => $norma_nac_tipos, 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Seleccione una opción de la lista'));
      ?>
  </div>
  <div class="col-md-4 col-sm-6 col-xs-12">
	  <?php
          echo $this->Form->input('norma_val_nac_nro', array('label' => 'Norma de aprobación nacional Nro*', 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Introduzca una número', 'Placeholder' => 'Ingrese un número'));
          echo $this->Form->input('norma_val_nac_anio', array('label' => 'Norma de aprobación nacional año*', 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Introduzca un año', 'Placeholder' => 'Ingrese un año'));
          $norma_ratif_tipos = array('Ley' => 'Ley', 'Resolución' => 'Resolución');
          echo $this->Form->input('norma_ratif_jur_tipo', array('label' => 'Norma de ratificación provincial tipo*', 'empty' => 'Ingrese un tipo de norma...', 'options' => $norma_ratif_tipos, 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Seleccione una opción de la lista'));
          echo $this->Form->input('norma_ratif_jur_nro', array('label' => 'Norma de ratificación provincial Nro*', 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Introduzca una número', 'Placeholder' => 'Ingrese un número'));
          echo $this->Form->input('norma_ratif_jur_anio', array('label' => 'Norma de ratificación provincial año*', 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Introduzca un año', 'Placeholder' => 'Ingrese un año'));
          $norma_homologación_tipos = array('Ley' => 'Ley', 'Resolución' => 'Resolución');
          echo $this->Form->input('norma_homologacion_tipo', array('label' => 'Norma de homologación nacional tipo*', 'empty' => 'Ingrese un tipo de norma...', 'options' => $norma_homologación_tipos, 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Seleccione una opción de la lista'));
          echo $this->Form->input('norma_homologacion_nro', array('label' => 'Norma de homologación nacional Nro*', 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Introduzca una número', 'Placeholder' => 'Ingrese un número'));
          echo $this->Form->input('norma_homologacion_anio', array('label' => 'Norma de homologación nacional año*', 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Introduzca un año', 'Placeholder' => 'Ingrese un año'));
          echo $this->Form->input('Titulacion.Centro', array('label' => 'Centro*', 'multiple' => true, 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Seleccione una opción de la lista'));
      ?>
  </div>
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
</div>
