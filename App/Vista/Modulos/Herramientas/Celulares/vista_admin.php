<?php 
  $arrDatos = $handlerCel->getLineasEntregadas();
  $arrELibres = $handlerCel->getEquiposLibres();
  $arrLLibres = $handlerCel->getLineasLibres();
  $url_action_entregar = PATH_VISTA.'Modulos/Herramientas/Celulares/action_entregar.php';
  $url_action_devolver = PATH_VISTA.'Modulos/Herramientas/Celulares/action_devolver.php';
  $url_detalle_linea = "index.php?view=detalle_linea";

?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.quicksearch/2.2.1/jquery.quicksearch.js"></script>

<div class="box box-solid">
  <div class="box-header with-border">
    <i class="fa fa-list"></i>
    <h3 class="box-title">Líneas entregadas</h3>

    
    <a href="#" class="btn btn-success pull-right" data-toggle='modal' data-target='#modal-entrega-linea'>
        <i class="fa fa-share"></i> Entregar
    </a>
    <div class="col-xs-12 col-md-3 pull-right"><input type="text" id="search" class="form-control" placeholder="Escribe para buscar..." /></div>
  </div>

  <div class="box-body table-responsive"> 
    
    <table class="table table-striped table-condensed" id="tabla-plaza" cellspacing="0" width="100%" style="text-align:center;">
      <thead>
        <tr>
          <th class='text-center' width="100">Nro Línea</th>
          <th class='text-center'>IMEI</th>
          <th class='text-center'>Teléfono</th>
          <th class='text-center' width="200">Usuario</th>
          <th class='text-center' width="100">Entrega</th>
          <th class='text-center' width="250">Observaciones</th>
          <th class='text-center' colspan="3">Acciones</th>
        </tr>
      </thead>

      <tbody>
      <?php    
        if(!empty($arrDatos)){
          foreach ($arrDatos as $nroLinea) {
            $IMEI = $nroLinea->getIMEI();
            //var_dump($equipo);
            //exit();
            if($IMEI != ''){
              $equipo = $handlerCel->getEquipoLinea($IMEI);
              $telefono = $equipo->getMarca()." ".$equipo->getModelo();
            } else {
              $telefono='Propio';
            }

            $devolucion = "<a href='#' data-toggle='modal' id='".$nroLinea->getEntId()."' data-target='#modal-devolver' data-nroLinea='".$nroLinea->getNroLinea()."' data-fechaEnt='".$nroLinea->getFechaEntrega()->format('Y-m-d')."' data-IMEI='".$nroLinea->getIMEI()."' onclick='devolverLinea(".$nroLinea->getEntId().")'><i class='ion-arrow-return-left text-maroon'></i></a>";

            
            $usuario = $handlerUs->selectById($nroLinea->getUsId());
            
            $visible ='';
            if(strlen(trim(strip_tags($nroLinea->getObsEntrega())))<31)
              $visible= "style='display:none;'";

            echo "<tr>";
              echo "<td>".$nroLinea->getNroLinea()."</td>";
              echo "<td>".$IMEI."</td>";
              echo "<td>".$telefono."</td>";
              echo "<td>".$usuario->getNombre()." ".$usuario->getApellido()."</td>";
              echo "<td>".$nroLinea->getFechaEntrega()->format('d-m-Y')."</td>";
              echo "<td style='max-width:150px;white-space: nowrap;overflow: hidden;text-overflow: ellipsis; '><i ".$visible." class='fa fa-sort-down pull-left' data-toggle='tooltip' data-placement='bottom' title='' data-original-title='".trim(strip_tags($nroLinea->getObsEntrega()))."'></i>".trim(strip_tags($nroLinea->getObsEntrega()))."</td>";
              echo "<td style='font-size: 20px;' width='30'><a href='".$url_detalle_linea."&fNroLinea=".$nroLinea->getNroLinea()."'><i class='ion-eye text-blue'></i></td>";
              echo "<td style='font-size: 20px;' width='30'>".$devolucion."</td>";
              echo "<td style='font-size: 20px;' width='30'><i class='ion-document text-yellow' data-toggle='tooltip' title='Ver Comodato'></i></td>";
            echo "</tr>";
          }
        }

      ?>                        
      </tbody>
    </table> 
  </div>             
</div>
<script type="text/javascript">   

  $(function () {

  $('#search').quicksearch('table tbody tr');               
});
       
</script>
<div class="modal fade in" id="modal-entrega-linea">
    <div class="modal-dialog">
      <div class="modal-content">

        <form action="<?php echo $url_action_entregar; ?>" method="post">

          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span></button>
            <h4 class="modal-title">Entrega de Línea</h4>
          </div>
          <div class="modal-body">
              <div class="row">
                <div class="col-xs-12 no-padding">
                  <div class="col-md-4">
                    <label>Fecha</label>
                    <input type="date" name="fechaEntrega" class="form-control">
                  </div>          
                </div>
                  <div class="col-md-6">
                    <label>Líneas libres</label>
                    <select name="slt_nroLinea" id="slt_nroLinea" class="form-control" style="width: 100%">
                      <option value="">Seleccionar</option>
                      <option value="0">Todos</option>
                      <?php 
                        if(!empty($arrLLibres)){
                          foreach ($arrLLibres as $nroLinea) {
                            echo "<option value='".$nroLinea->getNroLinea()."'>".$nroLinea->getNroLinea()."</option>";
                          } 
                        }
                      ?>
                    </select>
                  </div>
                  <div class="col-md-6">
                    <label>Equipos libres</label>
                    <select name="slt_equipo" id="slt_equipo" class="form-control" style="width: 100%">
                      <option value="">Seleccionar</option>
                      <option value="0">Todos</option>
                      <?php 
                        if(!empty($arrELibres)){
                          foreach ($arrELibres as $equipo) {
                            echo "<option value='".$equipo->getIMEI()."'>".$equipo->getMarca()." ".$equipo->getModelo()." IMEI: ".$equipo->getIMEI()."</option>";
                          } 
                        }
                      ?>
                    </select>
                  </div>
                  <div class="col-md-12">
                    <label>Usuario</label>
                    <select name="slt_usuario" id="slt_usuario" class="form-control" style="width: 100%">
                      <option value="">Seleccionar</option>
                      <option value="0">Todos</option>
                      <?php 
                        if(!empty($arrUsuarios)){
                          foreach ($arrUsuarios as $usuario) {
                            echo "<option value='".$usuario->getId()."'>".$usuario->getNombre()." ".$usuario->getApellido()."</option>";
                          } 
                        }
                      ?>
                    </select>
                  </div>
                  <div class="col-md-12">
                    <label>Observaciones</label>
                    <textarea name="txtObs" id="txtObs" class="form-control" rows="5"></textarea>
                  </div>
              </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-primary">Guardar</button>
          </div>
        </form>

      </div>
    </div>
  </div>

  <div class="modal fade in" id="modal-devolver">
    <div class="modal-dialog">
      <div class="modal-content">

        <form id="asig-form" action="<?php echo $url_action_devolver; ?>" method="post">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span></button>
            <h4 class="modal-title">Devolución de Línea</h4>
          </div>
          <div class="modal-body">
              <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <label>Fecha de devolución</label>
                    <input type="date" name="fechaDev" id="fechaDev" class="form-control">
                    <input type="text" style="display: none" id="entId" name="entId">
                    <input type="text" style="display: none" id="devNroLinea" name="devNroLinea">
                    <input type="text" style="display: none" id="devIMEI" name="devIMEI">
                    <input type="text" style="display: none" id="fechaEnt" name="fechaEnt">
                    <label>Observaciones</label>
                  <textarea name="txtObsDev" id="txtObsDev" class="form-control" rows="5"></textarea>
                </div>
              </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-primary">Devolver</button>
          </div>
        </form>

      </div>
    </div>
  </div>
  <script>
    $(document).ready(function() {
    $("#slt_usuario").select2({
        placeholder: "Seleccionar",                  
    }).on('change', function (e) { 
      
    });
  });
    $(document).ready(function() {
    $("#slt_nroLinea").select2({
        placeholder: "Seleccionar",                  
    }).on('change', function (e) { 
      
    });
  });
    $(document).ready(function() {
    $("#slt_equipo").select2({
        placeholder: "Seleccionar",                  
    }).on('change', function (e) { 
      
    });
  });
    $(document).ready(function() {
    $("#fechaDev").on('change', function (e) { 
      controlFecha();
    });
  });

    function devolverLinea(id){
    
    nroLinea = document.getElementById(id).getAttribute('data-nroLinea');
    IMEI = document.getElementById(id).getAttribute('data-IMEI');
    fechaEnt = document.getElementById(id).getAttribute('data-fechaEnt');
    
    document.getElementById("devNroLinea").value = nroLinea;
    document.getElementById("entId").value = id;
    document.getElementById("devIMEI").value = IMEI;
    document.getElementById("fechaEnt").value = fechaEnt;
    
  }

  function controlFecha(){
    fechadev = document.getElementById("fechaDev").value;
    fechaent = document.getElementById("fechaEnt").value;
    if(fechadev<fechaent){
      alert("Fecha de devolucion equivocada");
      document.getElementById("fechaDev").value = fechaent;
    } 

  }
  </script>