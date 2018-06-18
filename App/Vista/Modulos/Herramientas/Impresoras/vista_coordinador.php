<?php 
  $arrDatos = $handlerimpresoras->AllImpresoras($user->getAliasUserSistema(),$fgestorId);
  $url_action_guardar = PATH_VISTA.'Modulos/Herramientas/Impresoras/action_asignar.php';
  $url_action_guardar_consumo = PATH_VISTA.'Modulos/Herramientas/Impresoras/action_guardar_consumo.php';
  $url_action_devGestor = PATH_VISTA.'Modulos/Herramientas/Impresoras/action_devolver_gestor.php';
  $arrGestor = $handler->selectAllGestor($user->getAliasUserSistema()); 
  

?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.quicksearch/2.2.1/jquery.quicksearch.js"></script>
<style>
  @media (min-width: 768px){
    .modal-dialog {width: 700px;}
  }
</style>

<div class="box box-solid">
  <div class="box-header with-border">
    <i class="fa fa-list"></i>
    <h3 class="box-title">Listado de Impresoras <?php echo $user->getId(); ?></h3>
    <div class="col-xs-12 col-md-2 pull-right"><input type="text" id="search" class="form-control" placeholder="Escribe para buscar..." /></div>         
  </div>

  <div class="box-body table-responsive"> 
    <table class="table table-striped table-condensed" id="tabla-plaza" cellspacing="0" width="100%" style="text-align:center;">
      <thead>
        <tr>
          <th class='text-center'>Serial</th>
          <th class='text-center'>Marca</th>
          <th class='text-center'>Modelo</th>
          <th class='text-center'>Estado</th>
          <th class='text-center' width="200">Gestor</th>
          <th class='text-center' width="150">Asignación</th>
          <th class='text-center' colspan="3">Acciones</th>
        </tr>
      </thead>

      <tbody>
      <?php    
        $i = 0;
        if(!empty($arrDatos)){
          foreach ($arrDatos as $key => $value) {
            $i = $i+1;
            $impresoraEnPlaza = $handlerimpresoras->PlazaImpresoras($value->getSerialNro());
            if(is_null($impresoraEnPlaza["_fechaDev"]) && !is_null($impresoraEnPlaza)){
              $fecha = $impresoraEnPlaza["_fechaAsig"]->format('d-m-Y');
              $fechaDev = $impresoraEnPlaza["_fechaAsig"]->format('Y-m-d');
              if($impresoraEnPlaza["_gestorId"] != 0){
                  $gestorId = $impresoraEnPlaza["_gestorId"];
                  $gestorXId = $handlerUs->selectById($gestorId);
                  $nombre = $gestorXId->getNombre(). " " . $gestorXId->getApellido();
                  $estado = '<span class = "text-green" >En Calle</span>';
                  $asig = "<a href='#' data-toggle='modal' id='".$i."_edit' data-target='#modal-devGestor' data-gestorId='".$impresoraEnPlaza['_gestorId']."' data-fechaEnt='".$fechaDev."' data-serialNro='".$impresoraEnPlaza['_serialNro']."' data-asigId='".$impresoraEnPlaza['_asigId']."' onclick='cargarDatosDev(".$i.")'><i class='fa fa-user-times text-blue'></i></a>";
                  $baja= "<a href='".$url_impresion."fserialNro=".$value->getSerialNro()."&fgestor=".$gestorXId->getId()."&fasigId=".$impresoraEnPlaza["_asigId"]."' target='_blank'><i class='ion-document text-yellow' data-toggle='tooltip' title='Ver Comodato'></i></a>"; 
                  $consumo = '';
                } else {
                  $nombre = '-';
                  $asig = "<a href='#' data-toggle='modal' id='".$impresoraEnPlaza['_asigId']."' data-target='#modal-devolver' data-asigId='".$impresoraEnPlaza['_asigId']."' onclick='cargarDatos(".$impresoraEnPlaza["_asigId"].")'><i class='ion-arrow-return-left text-maroon'></i></a>";
                  $baja= "<a href='#' data-toggle='modal' id='".$i."_edit' data-target='#modal-asigGestor' data-gestorId='".$impresoraEnPlaza['_gestorId']."' data-serialNro='".$impresoraEnPlaza['_serialNro']."' data-asigId='".$impresoraEnPlaza['_asigId']."' onclick='cargarDatosAsig(".$i.")'><i class='fa fa-user-plus text-green'></i></a>";
                  $estado = '<span class = "text-yellow">En Oficina</span>';
                  $consumo = "<a href='#' data-toggle='modal' id='".$impresoraEnPlaza['_asigId']."' data-target='#modal-consumo' data-marca='".$value->getMarca()."' data-serialNro='".$impresoraEnPlaza['_serialNro']."' onclick='cargarConsumos(".$impresoraEnPlaza["_asigId"].")'><i class='ion-wrench'></i>";
                }
            } 


            echo 
            "<tr>
                <td>".$value->getSerialNro()."</td>
                <td>".$value->getMarca()."</td>
                <td>".$value->getModelo()."</td>
                <td>".$estado."</td>
                <td>".$nombre."</td>
                <td>".$fecha."</td>";
                //echo "<td style='font-size: 20px;' width='40'> <a href='".$url_detalle."&fserialNro=".$value->getSerialNro()."'><i class='ion-eye text-blue'></i></a></td>";
                echo "<td style='font-size: 20px;' width='40'> ".$consumo."</td>";
                echo "<td style='font-size: 20px;' width='40'> ".$asig."</td>";
                echo "<td style='font-size: 20px;' width='40'> ".$baja."</td>";


            echo "</tr>";
          }
        }

      ?>                        
      </tbody>
    </table> 
  </div>             
</div>

<div class="modal fade in" id="modal-asigGestor">
    <div class="modal-dialog">
      <div class="modal-content">

        <form id="asig-form" action="<?php echo $url_action_guardar; ?>" method="post">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span></button>
            <h4 class="modal-title">Asignar a Gestor</h4>
          </div>
          <div class="modal-body">
              <div class="row">
                
                <div class="col-md-10 col-md-offset-1">
                    <label>Fecha de Entrega</label>
                    <input type="date" name="fechaAsig" class="form-control">
                    <input type="text" style="display: none;" id="asigId" name="asigId">
                    <input type="text" style="display: none;" id="serialNro" name="serialNro">
                    <input type="text" style="display: none;" id="slt_plaza" name="slt_plaza" value="<?php echo $user->getAliasUserSistema() ?>">
                    <label>Gestor</label>
                    <select name="slt_gestor" id="slt_gestor" class="form-control" style="width: 100%" onchange="crearHrefG()">
                      <option value="">Seleccionar</option>
                      <?php 
                        if(!empty($arrUsuarios)){
                          foreach ($arrUsuarios as $usuario) {
                            foreach ($arrGestor as $gestor) {
                              if($fgestorId == $usuario->getId() && $usuario->getUserSistema() == $gestor->GESTOR11_CODIGO)
                                  echo "<option value='".$usuario->getId()."' selected>".$usuario->getNombre()." ".$usuario->getApellido()."</option>";
                                elseif ($usuario->getUserSistema() == $gestor->GESTOR11_CODIGO) {
                                  echo "<option value='".$usuario->getId()."'>".$usuario->getNombre()." ".$usuario->getApellido()."</option>";
                              }
                            }
                          } 
                        }
                      ?>
                    </select>
                    <label>Observaciones</label>
                  <textarea name="txtObs" id="txtObs" class="form-control" rows="5"></textarea>
                </div>
              </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Asignar</button>
          </div>
        </form>

      </div>
    </div>
  </div>
<div class="modal fade in" id="modal-devGestor">
    <div class="modal-dialog">
      <div class="modal-content">

        <form id="asig-form" action="<?php echo $url_action_devGestor; ?>" method="post">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span></button>
            <h4 class="modal-title">Devolución a plaza</h4>
          </div>
          <div class="modal-body">
              <div class="row">
                
                <div class="col-md-10 col-md-offset-1">
                    <label>Fecha de Devolucion</label>
                    <input type="date" name="fechaDev" id="fechaDev" class="form-control">
                    <input type="text" style="display: none;" id="fechaEnt" name="fechaEnt">
                    <input type="text" style="display: none;" id="devAsigId" name="devAsigId">
                    <input type="text" style="display: none;" id="devSerialNro" name="devSerialNro">
                    <input type="text" style="display: none;" id="devPlaza" name="devPlaza" value="<?php echo $user->getAliasUserSistema() ?>">
                    <label>Observaciones</label>
                  <textarea name="txtDevObs" id="txtDevObs" class="form-control" rows="5"></textarea>
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

  <div class="modal fade in" id="modal-consumo">
    <div class="modal-dialog">
      <div class="modal-content">

        <form id="asig-form" action="<?php echo $url_action_guardar_consumo; ?>" method="post">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="ocultarConsumibles()">
              <span aria-hidden="true">×</span></button>
            <h4 class="modal-title">Cargar consumo</h4>
          </div>
          <div class="modal-body">
            <div class="row" style="padding:0 15px;">
              <div class="col-md-4">
                <label>Fecha de Consumo</label>
                <input type="date" name="consFecha" id="consFecha" class="form-control" required="">
                <input type="text" style="display: none;" id="consSerialNro" name="consSerialNro">
                <input type="text" style="display: none;" id="consPlaza" name="consPlaza" value="<?php echo $user->getAliasUserSistema() ?>">
                <input type="text" style="display: none;" id="consUserId" name="consUserId" value="<?php echo $user->getId() ?>">
              </div>
              <div class="col-md-4">
                <label>Contador</label>
                <input type="number" id="consContador" class="form-control" name="consContador" required="">
              </div>
              <div class="col-md-4">
                <label>Cambio de tonner</label>
                <select name="consTonner" id="consTonner" class="form-control" style="width: 100%">
                  <option value="0" selected>NO</option>
                  <option value="1">SI</option>
                </select>
              </div>
            </div>
            <div class="row" style="padding:0 15px;display: none;" id="RICOH">
              <h5>RICOH</h5>
              <hr style="margin: 5px 0;">
              <div class="col-md-4">
                <label>Kit A</label>
                <input type="text" name="consKitA" id="consKitA" class="form-control">
              </div>
              <div class="col-md-2">
                <label>Cambiar</label>
                <select name="consCambioKitA" id="consCambioKitA" class="form-control" style="width: 100%">
                  <option value="0" selected>NO</option>
                  <option value="1">SI</option>
                </select>
              </div>
              <div class="col-md-4">
                <label>Kit B</label>
                <input type="text" name="consKitB" id="consKitB" class="form-control">
              </div>
              <div class="col-md-2">
                <label>Cambiar</label>
                <select name="consCambioKitB" id="consCambioKitB" class="form-control" style="width: 100%">
                  <option value="0" selected>NO</option>
                  <option value="1">SI</option>
                </select>
              </div>
            </div>
            <div class="row" style="padding:0 15px;display: none;" id="SAMSUNG">
              <h5>SAMSUNG</h5>
              <hr style="margin: 5px 0;">
              <div class="col-md-10">
                <label>Consumibles</label>
                <input type="text" name="consSamsung" id="consSamsung" class="form-control">
              </div>
              <div class="col-md-2">
                <label>Cambiar</label>
                <select name="consCambioSamsung" id="consCambioSamsung" class="form-control" style="width: 100%">
                  <option value="0" selected>NO</option>
                  <option value="1">SI</option>
                </select>
              </div>
            </div>
            <div class="row" style="padding:0 15px;display: none;" id="LEXMARK">
              <h5>LEXMARK</h5>
              <hr style="margin: 5px 0;">
              <div class="col-md-4">
                <label>Unidad de Imagen</label>
                <input type="text" name="consUI" id="consUI" class="form-control">
              </div>
              <div class="col-md-2">
                <label>Cambiar</label>
                <select name="consCambioUI" id="consCambioUI" class="form-control" style="width: 100%">
                  <option value="0" selected>NO</option>
                  <option value="1">SI</option>
                </select>
              </div>
              <div class="col-md-4">
                <label>Kit Mantenimiento</label>
                <input type="text" name="consKitM" id="consKitM" class="form-control">
              </div>
              <div class="col-md-2">
                <label>Cambiar</label>
                <select name="consCambioKitM" id="consCambioKitM" class="form-control" style="width: 100%">
                  <option value="0" selected>NO</option>
                  <option value="1">SI</option>
                </select>
              </div>
            </div>
            <div class="row" style="padding:0 15px;">
              <hr style="margin: 5px 0;">
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

<script type="text/javascript">   

  $(function () {

  $('#search').quicksearch('table tbody tr');               
  });

  $(document).ready(function() {
    $("#slt_gestor").select2({
        placeholder: "Seleccionar",                  
    }).on('change', function (e) { 
      
    });
  });

  function cargarDatosAsig(id){
    
    asigId = document.getElementById(id+'_edit').getAttribute('data-asigId');
    serialNro = document.getElementById(id+'_edit').getAttribute('data-serialNro');
    
    document.getElementById("serialNro").value = serialNro  ;
    document.getElementById("asigId").value = asigId;
    
  }
  function cargarDatosDev(id){
    
    asigId = document.getElementById(id+'_edit').getAttribute('data-asigId');
    serialNro = document.getElementById(id+'_edit').getAttribute('data-serialNro');
    fechaEnt = document.getElementById(id+'_edit').getAttribute('data-fechaEnt');
    
    document.getElementById("devSerialNro").value = serialNro  ;
    document.getElementById("fechaEnt").value = fechaEnt  ;
    document.getElementById("devAsigId").value = asigId;
    
  }
  function cargarConsumos(id){
    
    serialNro = document.getElementById(id).getAttribute('data-serialNro');
    marca = document.getElementById(id).getAttribute('data-marca');

    document.getElementById("consSerialNro").value = serialNro;
    document.getElementById(marca).style.display = "block";
    
  }

  function ocultarConsumibles(){
    document.getElementById("RICOH").style.display = "none";
    document.getElementById("SAMSUNG").style.display = "none";
    document.getElementById("LEXMARK").style.display = "none";
  }




  $(document).ready(function() {
    $("#fechaDev").on('change', function (e) { 
      controlFecha();
    });
  });

  function controlFecha(){
    fechadev = document.getElementById("fechaDev").value;
    fechaent = document.getElementById("fechaEnt").value;
    console.log(fechadev);
    console.log(fechaent);

    if(fechadev<fechaent){
      alert("Fecha de devolucion equivocada");
      document.getElementById("fechaDev").value = fechaent;
    } 

  }

       
</script>