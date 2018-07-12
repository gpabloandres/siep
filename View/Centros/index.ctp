<!-- start main -->
<div class="TituloSec">Instituciones</div>
<div id="ContenidoSec">
	<div id="main">
	<!-- start second nav -->
		<div class="row">
			<div class="col-xs-12 col-sm-8 col-md-8">
	    		<div id="second-nav">
				    <div class="unit text-center">
			  	     <?php if($current_user['role'] == 'superadmin'): ?>  
		                <span class="link"><?php echo $this->Html->link(' <i class="glyphicon glyphicon-plus "></i> AGREGAR', array('action' => 'add'), array('class' => 'btn btn-primary','escape' => false)); ?>
		                </span>
		               <?php endif; ?>  
		            </div>
			    </div>
		<!-- end second nav -->
				<div class="row">
				    <?php
						// Este FIX logra que las tarjetas no se desarmen
						// Es necesario definir un puntero para el bucle $clear = 1
						$clear = 1;
						foreach ($centros as $centro) {
							echo $this->element('centro',array( 'centro' => $centro ));

							// El helper de Siep->clearfix se encarga de determinar cuando realizar el fix
							$clear = $this->Siep->clearfix($clear);
						}
					?>
			    </div>
	  		    <div class="unit text-center">
					<?php echo $this->element('pagination'); ?> 
				</div>
			</div>
		    <div class="col-xs-12 col-sm-4 col-md-4">
			  	<div class="unit">
			  	    <div class="subtitulo">Búsqueda</div>
					</br>
					<?php echo $this->element('formsSearch/formSearch_centro'); ?>
			  	</div>
			</div>
	    </div>
    </div>
<!-- end main -->
