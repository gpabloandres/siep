<!-- start main -->
<div class="TituloSec">Alumnos por sección</div>
<div id="ContenidoSec">
  <div id="main">
  <!-- start second nav -->
      <div class="row">
          <div class="col-xs-12 col-sm-8 col-md-8">
          <div class="row">
              <?php
              switch($modoLista)
              {
                  case 'lista':
                      echo $this->element('cursosInscripcion_lista',array( 'cursosInscripcions' => $cursosInscripcions ));
                  break;
                  default:
                      // Por defecto se visualiza en modo tarjetas
                      $clear = 1;
                      foreach ($cursosInscripcions as $cursosInscripcion):
                          echo $this->element('cursosInscripcion',array( 'cursosInscripcion' => $cursosInscripcion ));
                          // Este helper se encargada de arreglar las superposiciones de las tarjetas
                          $clear = $this->Siep->clearfix($clear,3); // 3 filas, y luego el fix
                      endforeach;
                  break;
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
              <br>
              <?php echo $this->element('formsSearch/formSearch_cursosInscripcion'); ?>
          </div>
      </div>
  </div>    
</div>
<!-- end main -->
