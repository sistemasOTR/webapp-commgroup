<?php 
  $arrDatos = $handlerCel->getLineasEntregadas();
  $arrELibres = $handlerCel->getEquiposLibres();
  $arrLLibres = $handlerCel->getLineasLibres();
  $url_action_entregar = PATH_VISTA.'Modulos/Herramientas/Celulares/action_entregar.php';
  $url_action_devolver = PATH_VISTA.'Modulos/Herramientas/Celulares/action_devolver.php';
  $url_action_enrocar = PATH_VISTA.'Modulos/Herramientas/Celulares/action_enrocar.php';
  $url_detalle_linea = "index.php?view=detalle_linea";
  $url_detalle_equipo = "index.php?view=detalle_equipo";

?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.quicksearch/2.2.1/jquery.quicksearch.js"></script>

<div class="box box-solid">
  <div class="box-header with-border">
    <i class="fa fa-list"></i>
    <h3 class="box-title">Líneas y Equipos asignados</h3>

    
    <a href="#" class="btn btn-success pull-right" data-toggle='modal' data-target='#modal-entrega-linea' onclick="entregaLinea('<?php echo $fHoy; ?>')">
        <i class="fa fa-share"></i> Entregar
    </a>
    
  </div>

  <div class="box-body table-responsive"> 
    <div class="col-xs-12 col-md-3 pull-right"><input type="text" id="search-entregas" class="form-control" placeholder="Escribe para buscar..." /></div>
    <table class="table table-striped table-condensed" id="tabla-entregas" cellspacing="0" width="100%" style="text-align:center;">
      <thead>
        <tr>
          <th class='text-center' width="150">Nro Línea</th>
          <th class='text-center' width="100">Entrega Línea</th>
          <th class='text-center'>Equipo</th>
          <th class='text-center' width="110">Entrega Equipo</th>
          <th class='text-center' width="200">Usuario</th>
          <th class='text-center' width="250">Observaciones</th>
          <th class='text-center' colspan="3">Acciones</th>
        </tr>
      </thead>

      <tbody>
      <?php    
        if(!empty($arrDatos)){
          foreach ($arrDatos as $nroLinea) {
            $IMEI = $nroLinea->getIMEI();
            // var_dump($IMEI);
            // exit();
            if($IMEI != '0'){
              $equipo = $handlerCel->getEquipoLinea($IMEI);
              $telefono = $equipo->getMarca()." ".$equipo->getModelo();
            } else {
              $telefono='Propio';
            }

            $linea = $handlerCel->getDatosByNroLinea($nroLinea->getNroLinea());

            $devolucion = "<a href='#' data-toggle='modal' id='".$nroLinea->getEntId()."' data-target='#modal-devolver' data-nroLinea='".$nroLinea->getNroLinea()."' data-fechaEnt='".$nroLinea->getFechaEntregaLinea()->format('Y-m-d')."' data-IMEI='".$nroLinea->getIMEI()."' onclick='devolverLinea(".$nroLinea->getEntId().")'><i class='ion-arrow-return-left text-maroon'></i></a>";
            $enroque_eq = "<a href='#' data-toggle='modal' id='".$nroLinea->getEntId()."_equipo' data-target='#modal-enroque-equipo' data-tipo='equipo' data-nroLinea='".$nroLinea->getNroLinea()."' data-fechaEnt='".$nroLinea->getFechaEntregaLinea()->format('Y-m-d')."' data-IMEI='".$nroLinea->getIMEI()."' data-user='".$nroLinea->getUsId()."' onclick='enroqueEquipo(".$nroLinea->getEntId().")'><i class='fa fa-refresh text-navy'></i></a>";
            $enroque_linea = "<a href='#' data-toggle='modal' id='".$nroLinea->getEntId()."' data-target='#modal-enroque-equipo' data-tipo='linea' data-nroLinea='".$nroLinea->getNroLinea()."' data-fechaEnt='".$nroLinea->getFechaEntregaEquipo()->format('Y-m-d')."' data-IMEI='".$nroLinea->getIMEI()."' data-user='".$nroLinea->getUsId()."' onclick='enroqueLinea(".$nroLinea->getEntId().")'><i class='fa fa-refresh text-navy'></i></a>";

            
            $usuario = $handlerUs->selectById($nroLinea->getUsId());
            if($nroLinea->getFechaEntregaEquipo()->format('d-m-Y') != '01-01-1900'){
              $entregaEquipo = $nroLinea->getFechaEntregaEquipo()->format('d-m-Y');
            } else {
              $entregaEquipo = '-';
            }

            
            $visible ='';
            if(strlen(trim(strip_tags($nroLinea->getObsEntrega())))<31)
              $visible= "style='display:none;'";

            echo "<tr>";
              echo "<td>".$nroLinea->getNroLinea()." ".$enroque_linea."<br>".$linea->getNombrePlan()."</td>";
              echo "<td>".$nroLinea->getFechaEntregaLinea()->format('d-m-Y')."</td>";
              echo "<td>".$telefono." ".$enroque_eq."<br>IMEI: ".$IMEI."</td>";
              echo "<td>".$entregaEquipo."</td>";
              echo "<td>".$usuario->getNombre()." ".$usuario->getApellido()."</td>";
              echo "<td style='max-width:150px;white-space: nowrap;overflow: hidden;text-overflow: ellipsis; '><i ".$visible." class='fa fa-sort-down pull-left' data-toggle='tooltip' data-placement='bottom' title='' data-original-title='".trim(strip_tags($nroLinea->getObsEntrega()))."'></i>".trim(strip_tags($nroLinea->getObsEntrega()))."</td>";
              echo "<td style='font-size: 20px;' width='30'><a href='".$url_detalle_linea."&fNroLinea=".$nroLinea->getNroLinea()."'><i class='ion-eye text-blue'></i></td>";
              echo "<td style='font-size: 20px;' width='30'>".$devolucion."</td>";
              echo "<td style='font-size: 20px;' width='30'><a href='".$url_impresion."fID=".$nroLinea->getEntId()."' target='_blank'><i class='ion-document text-yellow' data-toggle='tooltip' title='Ver Comodato'></i></td>";
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

  $('#search-entregas').quicksearch('#tabla-entregas tbody tr');               
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
                    <input type="date" name="fechaEntrega" id="fechaEntrega" class="form-control">
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
                            if(is_null($equipo->getFechaBaja()) && is_null($equipo->getFechaRobo()) && is_null($equipo->getFechaPerd())){
                              echo "<option value='".$equipo->getIMEI()."'>".$equipo->getMarca()." ".$equipo->getModelo()." IMEI: ".$equipo->getIMEI()."</option>";
                            }
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
            <button type="submit" class="btn btn-primary">Guardar</button>
          </div>
        </form>

      </div>
    </div>
  </div>

  <script>
    function entregaLinea(fecha) {
      document.getElementById('fechaEntrega').value = fecha;
      document.getElementById('slt_nroLinea').selectedIndex = 0;
      document.getElementById('slt_equipo').value = '0';
      document.getElementById('slt_usuario').value = '0';
      document.getElementById('txtObs').value = '';
    }
  </script>

<div class="modal fade in" id="modal-enroque-equipo">
    <div class="modal-dialog">
      <div class="modal-content">

        <form action="<?php echo $url_action_enrocar; ?>" method="post">

          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span></button>
            <h4 class="modal-title">Enroque de Equipos</h4>
          </div>
          <div class="modal-body">
              <div class="row">
                
                  <div class="col-md-6">
                    <label>Fecha</label>
                    <input type="date" name="fechaNueva" class="form-control">
                    <input type="text" name="estado" id="estado" class="form-control" style="display: none;">
                    <input type="text" style="display: none" id="EnroEEntId" name="EnroEEntId">
                    <input type="text" style="display: none" id="enroENroLinea" name="enroENroLinea">
                    <input type="text" style="display: none" id="EnroEIMEI" name="EnroEIMEI">
                    <input type="text" style="display: none" id="fechaACambiar" name="fechaACambiar">
                    <input type="text" style="display: none" id="EnroEuserId" name="EnroEuserId">
                  </div>
                            
                  <div class="col-md-12" id="EquiposEnroque" style="display: none">
                    <label>Forma de devolución</label>
                    <select name="txtTipoBaja" id="txtTipoBaja" class="form-control" style="width: 100%">
                      <option value="linea">Seleccionar...</option>
                      <option value="condi">En condiciones</option>
                      <option value="roto01">Equipo roto a cargo de la empresa</option>
                      <option value="roto02">Equipo roto a cargo del usuario</option>
                      <option value="robo">Equipo robado</option>
                      <option value="perd">Equipo perdido</option>
                    </select>
                    
                    <label>Equipos libres</label>
                    <select name="EnroEquipo" id="EnroEquipo" class="form-control" style="width: 100%">
                      <option value="">Seleccionar</option>
                      <option value="0">Todos</option>
                      <?php 
                        if(!empty($arrELibres)){
                          foreach ($arrELibres as $equipo) {
                            if(is_null($equipo->getFechaBaja()) && is_null($equipo->getFechaRobo()) && is_null($equipo->getFechaPerd())){
                              echo "<option value='".$equipo->getIMEI()."'>".$equipo->getMarca()." ".$equipo->getModelo()." IMEI: ".$equipo->getIMEI()."</option>";
                            }
                          } 
                        }
                      ?>
                    </select>
                  </div>
                  <div class="col-md-12" id="LineasEnroque" style="display: none">
                    <label>Líneas libres</label>
                    <select name="EnroLinea" id="EnroLinea" class="form-control" style="width: 100%">
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
                  <div class="col-md-12">
                    <label>Observaciones</label>
                    <textarea name="txtObs" id="txtObsEnro" class="form-control" rows="5"></textarea>
                  </div>
              </div>
          </div>
          <div class="modal-footer">
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
                    <label>Forma de devolución</label>
                    <select name="txtTipoBaja" id="txtTipoBajaDev" class="form-control" style="width: 100%">
                      <option value="linea">Seleccionar...</option>
                      <option value="condi">En condiciones</option>
                      <option value="roto01">Equipo roto a cargo de la empresa</option>
                      <option value="roto02">Equipo roto a cargo del usuario</option>
                      <option value="robo">Equipo robado</option>
                      <option value="perd">Equipo perdido</option>
                    </select>
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
    $("#EnroEquipo").select2({
        placeholder: "Seleccionar",                  
    }).on('change', function (e) { 
      
    });
  });
    $(document).ready(function() {
    $("#EnroLinea").select2({
        placeholder: "Seleccionar",                  
    }).on('change', function (e) { 
      
    });
  });
    $(document).ready(function() {
    $("#fechaDev").on('change', function (e) { 
      controlFecha();
    });
  });
    $(document).ready(function() {
    $("#txtTipoBaja").on('change', function (e) { 
      cambioObs();
    });
  });
    $(document).ready(function() {
    $("#txtTipoBajaDev").on('change', function (e) { 
      cambioObsDev();
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

    function enroqueEquipo(id){
		nroLinea = document.getElementById(id+"_equipo").getAttribute('data-nroLinea');
		IMEI = document.getElementById(id+"_equipo").getAttribute('data-IMEI');
		fechaEnt = document.getElementById(id+"_equipo").getAttribute('data-fechaEnt');
		userId = document.getElementById(id+"_equipo").getAttribute('data-user');
		tipo = document.getElementById(id+"_equipo").getAttribute('data-tipo');
    if (fechaEnt == '1900-01-01') {fechaEnt= document.getElementById(id).getAttribute('data-fechaEnt');}

		document.getElementById("EquiposEnroque").style.display = "block";
		
		document.getElementById("estado").value = "equipo";
		document.getElementById("enroENroLinea").value = nroLinea;
		document.getElementById("EnroEEntId").value = id;
		document.getElementById("EnroEIMEI").value = IMEI;
		document.getElementById("fechaACambiar").value = fechaEnt;
		document.getElementById("EnroEuserId").value = userId;
	}

    function enroqueLinea(id){
		nroLinea = document.getElementById(id).getAttribute('data-nroLinea');
		IMEI = document.getElementById(id).getAttribute('data-IMEI');
		fechaEnt = document.getElementById(id).getAttribute('data-fechaEnt');
		userId = document.getElementById(id).getAttribute('data-user');
		
		document.getElementById("LineasEnroque").style.display = "block";
		document.getElementById("estado").value = "linea";
		document.getElementById("enroENroLinea").value = nroLinea;
		document.getElementById("EnroEEntId").value = id;
		document.getElementById("EnroEIMEI").value = IMEI;
		document.getElementById("fechaACambiar").value = fechaEnt;
		document.getElementById("EnroEuserId").value = userId;
	}

  function controlFecha(){
    fechadev = document.getElementById("fechaDev").value;
    fechaent = document.getElementById("fechaEnt").value;
    if(fechadev<fechaent){
      alert("Fecha de devolucion equivocada");
      document.getElementById("fechaDev").value = fechaent;
    } 

  }

  function cambioObsDev() {
    tipoBaja = document.getElementById("txtTipoBajaDev").value;
    console.log(tipoBaja);

    if (tipoBaja == 'roto01') {
      document.getElementById("txtObsDev").value = "con dictamen por parte del Servicio Técnico Oficial, [COMPLETAR CON DETALLE TECNICO] estado que hace imposible la reparación y/o uso para el comodante. En consecuencia, solo a modo excepcional, asume los costos de sustitución/reparación del equipo el comodante. No existiendo nada que reclamarse las partes por el vínculo contractual habido.";
    }
    if (tipoBaja == 'roto02') {
      document.getElementById("txtObsDev").value = "con dictamen por parte del Servicio Técnico Oficial, [COMPLETAR CON DETALLE TECNICO] estado que hace imposible la reparación y/o uso para el comodante. En consecuencia, será a cargo del comodatario la suma de Pesos [COMPLETAR CON MONTO FORMATO TEXTO] ($0000,00.-) en concepto de sustitución por el nuevo equipo.";
    }
  }

  function cambioObs() {
    tipoBaja = document.getElementById("txtTipoBaja").value;
    console.log(tipoBaja);

    if (tipoBaja == 'roto01') {
      document.getElementById("txtObsEnro").value = "con dictamen por parte del Servicio Técnico Oficial, [COMPLETAR CON DETALLE TECNICO] estado que hace imposible la reparación y/o uso para el comodante. En consecuencia, solo a modo excepcional, asume los costos de sustitución/reparación del equipo el comodante. No existiendo nada que reclamarse las partes por el vínculo contractual habido.";
    }
    if (tipoBaja == 'roto02') {
      document.getElementById("txtObsEnro").value = "con dictamen por parte del Servicio Técnico Oficial, [COMPLETAR CON DETALLE TECNICO] estado que hace imposible la reparación y/o uso para el comodante. En consecuencia, será a cargo del comodatario la suma de Pesos [COMPLETAR CON MONTO FORMATO TEXTO] ($0000,00.-) en concepto de sustitución por el nuevo equipo.";
    }
  }

  </script>