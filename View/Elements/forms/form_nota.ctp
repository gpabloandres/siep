<?php echo $this->Html->script(array('acordeon', 'tooltip', 'datepicker', 'moment', 'bootstrap-datetimepicker')); ?>
<div class="row">
	<div class="col-xs-6 col-sm-3">
	    <?php echo $this->Form->input('created', array('label' => 'Creado*', 'id' => 'datetimepicker1', 'type' => 'text', 'class' => 'input-group date', 'class' => 'form-control', 'span class' => 'fa fa-calendar')); ?>
    </div>
</div><hr />
<div class="row">
  <div class="col-md-4 col-sm-6 col-xs-12">
	  <div class="unit"><strong><h3>Datos Generales</h3></strong><hr />
		  <?php
              echo $this->Form->input('ciclo_id', array('label' => 'Ciclo*', 'default' => $cicloIdActual, 'readonly' => true, 'between' => '<br>', 'class' => 'form-control'));
              echo $this->Form->input('alumno_id', array('label' => 'Alumno*', 'empty' => 'Ingrese un alumno...', 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Seleccione una opción'));
              echo $this->Form->input('materia_id', array('label' => 'Espacio*', 'empty' => 'Ingrese una materia...', 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Seleccione una opción'));
              $estados = array('En curso' => 'En curso', 'Abandonada' => 'Abandonada', 
                'Regularizada' => 'Regularizada', 'Promocionada' => 'Promocionada', 'Desaprobada' => 'Desaprobada');
              echo $this->Form->input('estado', array('label' => 'Estado*', 'empty' => 'Ingrese tipo de estado...', 'options' => $estados, 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Seleccione una opción de la lista'));  
          ?>
      </div></br>
  </div>
  <div class="col-md-4 col-sm-4 col-xs-4">
     <div id="click_01" class="titulo_acordeon">Primer período <span class="caret"></span></div>
     <div id="acordeon_01"><!--</br><div class="subtitulo">Primer período</div>-->
		 <?php 		
            $evaluacionTipos = array('Producción (en cualquier lenguaje)' => 'Producción (en cualquier lenguaje)', 'Instancia Oral' => 'Instancia Oral', 'Instancia Escrita' => 'Instancia Escrita',
									 'Otros' => 'Otros');
     ?>
      <div class="unit">
        <div class="unit">
          <b>EVALUACIÓN Nº 1</b>       
          <?php  
            echo $this->Form->input('evaluacion_tipo_nota_uno_primer_periodo', array('label' => 'Tipo', 'empty' => 'Ingrese tipo de evaluación...', 'options' => $evaluacionTipos, 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Seleccione una opción de la lista'));
            //$notaTipos = array('E' => 'Excelente', 'MB' => 'Muy Bien', 'B' => 'Bien', 'R' => 'Regular', 'NS' => 'No Satisfactorio');
            echo $this->Form->input('nota_uno_primer_periodo', array('label' => 'Nota',/*'options' => $notaTipos,*/ 'empty' => 'Ingrese una nota...', 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Seleccione una opción de la lista'));
          ?>
        </div>
        <div class="unit">
          <b>EVALUACIÓN Nº 2</b>       
          <?php
            echo $this->Form->input('evaluacion_tipo_nota_dos_primer_periodo', array('label' => 'Tipo', 'empty' => 'Ingrese tipo de evaluación...', 'options' => $evaluacionTipos, 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Seleccione una opción de la lista'));
            echo $this->Form->input('nota_dos_primer_periodo', array('label' => 'Nota', 'empty' => 'Ingrese una nota...',/*'options' => $notaTipos,*/ 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Seleccione una opción de la lista'));
          ?>
        </div>
        <div class="unit">
          <b>EVALUACIÓN Nº 3</b>       
          <?php    
            echo $this->Form->input('evaluacion_tipo_nota_tres_primer_periodo', array('label' => 'Tipo', 'empty' => 'Ingrese tipo de evaluación...', 'options' => $evaluacionTipos, 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Seleccione una opción de la lista'));
            echo $this->Form->input('nota_tres_primer_periodo', array('label' => 'Nota', 'empty' => 'Ingrese una nota...',/* 'options' => $notaTipos,*/ 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Seleccione una opción de la lista'));
          ?>
        </div>
        <b>CIERRE DEL PRIMER PERÍODO</b>
          <?php    
            //echo $this->Form->input('promedio_primer_periodo', array('label' => 'Promedio', 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Ingrese un valor redondeado.', 'placeholder' => 'Ingrese una nota...'));
            echo $this->Form->input('fecha_promedio_primer_periodo', array('label' => 'Fecha Promedio', 'type' => 'text', 'between' => '<br>', 'class' => 'datepicker form-control', 'placeholder' => 'Ingrese una fecha...'));
            $desarrolloTipos = array('MF' => 'Muy Frecuentemente', 'F' => 'Frecuentemente', 'PF' => 'Poco Frecuentemente', 'N' => 'Nunca');
            //echo $this->Form->input('desarrollo_personalSocial_primer_periodo', array('label' => 'Desarrollo Personal y Social', 'empty' => 'Ingrese un tipo de desarrollo...', 'options' => $desarrolloTipos, 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Seleccione una opción de la lista'));
          ?>
      </div>
    </div></br>
    <div id="click_02" class="titulo_acordeon">Segundo período <span class="caret"></span></div>
      <div id="acordeon_02"><!--</br><div class="subtitulo">Segundo período</div>-->
		  <div class="unit">
        <div class="unit">
          <b>EVALUACIÓN Nº 1</b>       
          <?php  
            echo $this->Form->input('evaluacion_tipo_nota_uno_segundo_periodo', array('label' => 'Tipo', 'empty' => 'Ingrese tipo de evaluación...', 'options' => $evaluacionTipos, 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Seleccione una opción de la lista'));
            echo $this->Form->input('nota_uno_segundo_periodo', array('label' => 'Nota',/*'options' => $notaTipos,*/ 'empty' => 'Ingrese una nota...', 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Seleccione una opción de la lista'));
          ?>
        </div>
        <div class="unit">
          <b>EVALUACIÓN Nº 2</b>       
          <?php  
            echo $this->Form->input('evaluacion_tipo_nota_dos_segundo_periodo', array('label' => 'Tipo', 'empty' => 'Ingrese tipo de evaluación...', 'options' => $evaluacionTipos, 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Seleccione una opción de la lista'));
            echo $this->Form->input('nota_dos_segundo_periodo', array('label' => 'Nota', 'empty' => 'Ingrese una nota...',/* 'options' => $notaTipos,*/ 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Seleccione una opción de la lista'));
          ?>
        </div>
        <div class="unit">
          <b>EVALUACIÓN Nº 3</b>       
          <?php  
            echo $this->Form->input('evaluacion_tipo_nota_tres_segundo_periodo', array('label' => 'Tipo', 'empty' => 'Ingrese tipo de evaluación...', 'options' => $evaluacionTipos, 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Seleccione una opción de la lista'));
            echo $this->Form->input('nota_tres_segundo_periodo', array('label' => 'Nota', 'empty' => 'Ingrese una nota...',/* 'options' => $notaTipos,*/ 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Seleccione una opción de la lista'));
          ?>
        </div>
        <b>CIERRE DEL SEGUNDO PERÍODO</b>
          <?php    
            echo $this->Form->input('promedio_segundo_periodo', array('label' => 'Promedio', 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Ingrese un valor redondeado.', 'placeholder' => 'Ingrese una nota...'));
            echo $this->Form->input('fecha_promedio_segundo_periodo', array('label' => 'Fecha Promedio', 'type' => 'text', 'between' => '<br>', 'class' => 'datepicker form-control', 'placeholder' => 'Ingrese una fecha...'));
            //echo $this->Form->input('desarrollo_personalSocial_segundo_periodo', array('label' => 'Desarrollo Personal y Social', 'empty' => 'Ingrese un tipo de desarrollo...', 'options' => $desarrolloTipos, 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Seleccione una opción de la lista'));
        ?>
      </div>  	
     </div></br>
     <div id="click_03" class="titulo_acordeon">Tercer período <span class="caret"></span></div>
     <div id="acordeon_03"><!--</br><div class="subtitulo">Tercer período</div>-->
		 <div class="unit">
        <div class="unit">
          <b>EVALUACIÓN Nº 1</b>       
          <?php  
            echo $this->Form->input('evaluacion_tipo_nota_uno_tercer_periodo', array('label' => 'Tipo', 'empty' => 'Ingrese tipo de evaluación...', 'options' => $evaluacionTipos, 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Seleccione una opción de la lista'));
            echo $this->Form->input('nota_uno_tercer_periodo', array('label' => 'Nota',/*'options' => $notaTipos,*/ 'empty' => 'Ingrese una nota...', 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Seleccione una opción de la lista'));
          ?>
        </div>
        <div class="unit">
        <b>EVALUACIÓN Nº 2</b>       
          <?php  
            echo $this->Form->input('evaluacion_tipo_nota_dos_tercer_periodo', array('label' => 'Tipo', 'empty' => 'Ingrese tipo de evaluación...', 'options' => $evaluacionTipos, 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Seleccione una opción de la lista'));
            echo $this->Form->input('nota_dos_tercer_periodo', array('label' => 'Nota', 'empty' => 'Ingrese una nota...',/* 'options' => $notaTipos,*/ 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Seleccione una opción de la lista'));
          ?>
        </div>
        <div class="unit">
        <b>EVALUACIÓN Nº 3</b> 
          <?php  
            echo $this->Form->input('evaluacion_tipo_nota_tres_tercer_periodo', array('label' => 'Tipo', 'empty' => 'Ingrese tipo de evaluación...', 'options' => $evaluacionTipos, 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Seleccione una opción de la lista'));
            echo $this->Form->input('nota_tres_tercer_periodo', array('label' => 'Nota', 'empty' => 'Ingrese una nota...',/* 'options' => $notaTipos,*/ 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Seleccione una opción de la lista'));
          ?>
        </div>
        <b>CIERRE DEL TERCER PERÍODO</b>
          <?php    
            echo $this->Form->input('promedio_tercer_periodo', array('label' => '3º Promedio', 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Ingrese un valor redondeado.', 'placeholder' => 'Ingrese una nota...'));
            echo $this->Form->input('fecha_promedio_tercer_periodo', array('label' => 'Fecha 3º Promedio', 'type' => 'text', 'between' => '<br>', 'class' => 'datepicker form-control', 'placeholder' => 'Ingrese una fecha...'));
            //echo $this->Form->input('desarrollo_personalSocial_tercer_periodo', array('label' => 'Desarrollo Personal y Social', 'empty' => 'Ingrese un tipo de desarrollo...', 'options' => $desarrolloTipos, 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Seleccione una opción de la lista'));
        ?>
      </div>  		
     </div></br>
     </div>
     <div class="col-md-4 col-sm-4 col-xs-4">
     <div id="click_04" class="titulo_acordeon">Cierre <span class="caret"></span></div>
     <div id="acordeon_04"><!--</br><div class="subtitulo">Cierre</div>-->
       <div class="unit">
       <b>A TÉRMINO</b>
       <?php
            echo $this->Form->input('promedio_a_termino', array('label' => 'Promedio', 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Ingrese un valor con decimales.', 'placeholder' => 'Ingrese un promedio...'));
            echo $this->Form->input('fecha_promedio_a_termino', array('label' => 'Fecha Promedio', 'type' => 'text', 'between' => '<br>', 'class' => 'datepicker form-control', 'placeholder' => 'Ingrese una fecha...'));
        ?>
        </div>
        <div class="unit">
        <b>MESAS DE EXÁMENES DE DICIEMBRE</b>
        <?php
            echo $this->Form->input('nota_en_diciembre', array('label' => 'Nota', 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Ingrese un valor con decimales.', 'placeholder' => 'Ingrese una nota...'));
            echo $this->Form->input('fecha_nota_en_diciembre', array('label' => 'Fecha Nota', 'type' => 'text', 'between' => '<br>', 'class' => 'datepicker form-control', 'placeholder' => 'Ingrese una fecha...'));
         ?>
        </div> 
        <div class="unit">
        <b>MESAS DE EXÁMENES DE MARZO</b>
        <?php
            echo $this->Form->input('nota_en_marzo', array('label' => 'Nota', 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Ingrese un valor con decimales.', 'placeholder' => 'Ingrese una nota...'));
            echo $this->Form->input('fecha_nota_en_marzo', array('label' => 'Fecha Nota', 'type' => 'text', 'between' => '<br>', 'class' => 'datepicker form-control', 'placeholder' => 'Ingrese una fecha...'));
        ?>
        </div>
        <div class="unit">
        <?php
            echo $this->Form->input('promedio_final', array('label' => 'PROMEDIO FINAL', 'between' => '<br>', 'class' => 'form-control', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Ingrese un valor con decimales.', 'placeholder' => 'Ingrese un promedio...'));
            echo $this->Form->input('fecha_promedio_final', array('label' => 'Fecha Promedio Final', 'type' => 'text', 'between' => '<br>', 'class' => 'datepicker form-control', 'placeholder' => 'Ingrese una fecha...'));
        ?>
        </div>
     </div>
  </div>
  <div class="col-md-12 col-sm-6 col-xs-12">
       <?php echo $this->Form->input('observaciones', array('label'=>'Observaciones', 'type' => 'textarea', 'between' => '<br>', 'class' => 'form-control')); ?>
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
  <script>tinymce.init({ selector:'textarea' });</script>
</div>
