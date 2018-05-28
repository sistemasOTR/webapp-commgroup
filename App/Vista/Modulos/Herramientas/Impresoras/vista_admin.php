<?php 
  $arrDatos = $handlerimpresoras->AllImpresoras($fplaza,$fgestorId);

?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.quicksearch/2.2.1/jquery.quicksearch.js"></script>

<div class="box box-solid">
  <div class="box-header with-border">
    <i class="fa fa-list"></i>
    <h3 class="box-title">Listado de Impresoras</h3>
    <a href="#" class="btn btn-success pull-right" data-toggle='modal' data-target='#modal-nuevo'>
        <i class="fa fa-plus"></i> Agregar
    </a>
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
          <th class='text-center' width="200">Plaza</th>
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
            $i= $i + 1;
            $impresoraEnPlaza = $handlerimpresoras->PlazaImpresoras($value->getSerialNro());
            if(is_null($impresoraEnPlaza["_fechaDev"]) && !is_null($impresoraEnPlaza)){
              $fecha = $impresoraEnPlaza["_fechaAsig"]->format('d-m-Y');
				      $fechaDev = $impresoraEnPlaza["_fechaAsig"]->format('Y-m-d');
            	$asig = "<a href='#' data-toggle='modal' id='".$impresoraEnPlaza['_asigId']."' data-target='#modal-devolver' data-asigId='".$impresoraEnPlaza['_asigId']."' data-fechaEnt='".$fechaDev."' onclick='cargarDatos(".$impresoraEnPlaza["_asigId"].")'><i class='ion-arrow-return-left text-maroon'></i></a>";
            	$plaza = $impresoraEnPlaza["_plaza"];
            	if($impresoraEnPlaza["_gestorId"] != 0){
	              	$gestorId = $impresoraEnPlaza["_gestorId"];
                  $gestorXId = $handlerUs->selectById($gestorId);
	              	$nombre = $gestorXId->getNombre(). " " . $gestorXId->getApellido();
                  $baja= "<a href='".$url_impresion."fserialNro=".$value->getSerialNro()."&fgestor=".$gestorXId->getId()."&fasigId=".$impresoraEnPlaza["_asigId"]."' target='_blank'><i class='ion-document text-yellow' data-toggle='tooltip' title='Ver Comodato'></i></a>"; 
	              } else {
	              	$nombre = '-';
                  $baja= ""; 
	              }


            } else {
            	$fecha = '-';
      				$plaza = '-';
      				$nombre = '-';
      				$asig= "<a href='".$url_asignacion."&fserialNro=".$value->getSerialNro()."'><i class='ion-location text-green'></i></a>";
              $baja = "<a href='#' data-toggle='modal' id='".$i."_edit' data-target='#modal-baja' data-serialnro='".$value->getSerialNro()."' data-obsimp='".$value->getObs()."' onclick='bajaImp(".$i.")'><i class='ion-close text-red'></i></a>";
            }




            if(!is_null($value->getFechaBaja())){
              $estado = '<span class = "label label-danger" style="font-size: 13px; font-weight: normal;">Inactiva</span>';
              $asig= "<i class='ion-location text-gray'></i>";
            } elseif($plaza=='MANTENIMIENTO') {
              $estado = '<span class = "label label-warning" style="font-size: 13px; font-weight: normal;">Averiada</span>';
            } else {
              $estado = '<span class = "label label-success" style="font-size: 13px; font-weight: normal;">Activa</span>';
            }


            echo 
            "<tr>
                <td>".$value->getSerialNro()."</td>
                <td>".$value->getMarca()."</td>
                <td>".$value->getModelo()."</td>
                <td>".$estado."</td>
                <td>".$plaza."</td>
                <td>".$nombre."</td>
                <td>".$fecha."</td>";
                echo "<td style='font-size: 20px;' width='40'> <a href='".$url_detalle."&fserialNro=".$value->getSerialNro()."'><i class='ion-eye text-blue'></i></a></td>";
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
<div class="modal fade in" id="modal-nuevo">
    <div class="modal-dialog">
      <div class="modal-content">

        <form action="<?php echo $url_action_guardar; ?>" method="post">
          <input type="hidden" name="estado" value="NUEVO">

          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span></button>
            <h4 class="modal-title">Nueva Impresora</h4>
          </div>
          <div class="modal-body">
              <div class="row">
                  <div class="col-md-4">
                    <label>Fecha</label>
                    <input type="date" name="fechaCompra" class="form-control">
                  </div>           
                  <div class="col-md-8">
                    <label>Serial</label>
                    <input type="text" name="serialNro" class="form-control">
                  </div>
                  <div class="col-md-6">
                    <label>Marca</label>
                    <input type="text" name="marca" class="form-control">
                  </div>
                  <div class="col-md-6">
                    <label>Modelo</label>
                    <input type="text" name="modelo" class="form-control">
                  </div>
                  <div class="col-md-4 col-md-offset-8">
                    <label>Precio</label>
                    <input type="number" name="precioCompra" class="form-control">
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
            <h4 class="modal-title">Devolución de Impresora</h4>
          </div>
          <div class="modal-body">
              <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <label>Fecha de devolución</label>
                    <input type="date" name="fechaDev" id="fechaDev" class="form-control">
                    <input type="text" style="display: none" id="fechaEnt" name="fechaEnt">
                    <input type="text" style="display: none" id="asigId" name="asigId">
                    <label>Observaciones</label>
                  <textarea name="txtObs" id="txtObs" class="form-control" rows="5"></textarea>
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
  <div class="modal fade in" id="modal-baja">
    <div class="modal-dialog">
      <div class="modal-content">

        <form id="asig-form" action="<?php echo $url_action_baja; ?>" method="post">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span></button>
            <h4 class="modal-title">Baja de Impresora</h4>
          </div>
          <div class="modal-body">
              <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <label>Fecha de baja</label>
                    <input type="date" name="fechaBaja" class="form-control">
                    <input type="text" style="display: none" id="bajaSerialNro" name="bajaSerialNro">
                    <label>Observaciones</label>
                  <textarea name="txtObsImp" id="txtObsImp" class="form-control" rows="5"></textarea>
                </div>
              </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-danger">Dar de baja</button>
          </div>
        </form>

      </div>
    </div>
  </div>

<script type="text/javascript">   
  

  $(document).ready(function() {
    $("#slt_plaza").select2({
        placeholder: "Seleccionar",                  
    }).on('change', function (e) { 
      filtrarReporte(); 
    });
  });

  $(document).ready(function() {
    $("#slt_gestor").select2({
        placeholder: "Seleccionar",                  
    }).on('change', function (e) { 
      filtrarReporte(); 
    });
  });

  function cargarDatos(id){
    
    asigId = document.getElementById(id).getAttribute('data-asigId');
    fechaEnt = document.getElementById(id).getAttribute('data-fechaEnt');
    
    document.getElementById("fechaEnt").value = fechaEnt  ;
    document.getElementById("asigId").value = asigId;
    
  }

  function bajaImp(id){
    console.log(id);
    serialNro = document.getElementById(id+'_edit').getAttribute('data-serialnro');
    obsimp = document.getElementById(id+'_edit').getAttribute('data-obsimp');
    console.log(serialNro);
    document.getElementById("bajaSerialNro").value = "'" + serialNro + "'" ;
    if(obsimp!=undefined)
      document.getElementById("txtObsImp").value = obsimp;
    else
      document.getElementById("txtObsImp").value = ' ';
    
  }

  function crearHref()
  {
    f_gestorId = $("#slt_gestor").val();
    f_plaza = $("#slt_plaza").val();   
    url_filtro_reporte="index.php?view=impresorasxplaza";

    if(f_plaza!=undefined)
      if(f_plaza!='')
        url_filtro_reporte= url_filtro_reporte +"&fplaza="+f_plaza;

    if(f_gestorId!=undefined)
      if(f_gestorId!='')
        url_filtro_reporte= url_filtro_reporte +"&fgestorId="+f_gestorId;
    
    $("#filtro_reporte").attr("href", url_filtro_reporte);

    document.cookie = "url-tmp-back="+url_filtro_reporte;
  } 

  function filtrarReporte()
  {
    crearHref();
    window.location = $("#filtro_reporte").attr("href");
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

  $(function () {

  $('#search').quicksearch('table tbody tr');               
});
       
</script>
