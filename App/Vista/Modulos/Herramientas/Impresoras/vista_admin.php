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


            if(is_null($handlerimpresoras->PlazaImpresoras($value->getSerialNro())["_fechaDev"]) && !is_null($handlerimpresoras->PlazaImpresoras($value->getSerialNro()))){
				      $fecha = $handlerimpresoras->PlazaImpresoras($value->getSerialNro())["_fechaAsig"]->format('d-m-Y');
            	$asig = "<a href='#' data-toggle='modal' id='".$handlerimpresoras->PlazaImpresoras($value->getSerialNro())['_asigId']."' data-target='#modal-devolver' data-asigId='".$handlerimpresoras->PlazaImpresoras($value->getSerialNro())['_asigId']."' data-obs='".$handlerimpresoras->PlazaImpresoras($value->getSerialNro())['_obs']."' onclick='cargarDatos(".$handlerimpresoras->PlazaImpresoras($value->getSerialNro())["_asigId"].")'><i class='ion-arrow-return-left text-maroon'></i></a>";
            	$plaza = $handlerimpresoras->PlazaImpresoras($value->getSerialNro())["_plaza"];
            	if($handlerimpresoras->PlazaImpresoras($value->getSerialNro())["_gestorId"] != 0){
	              	$gestorId = $handlerimpresoras->PlazaImpresoras($value->getSerialNro())["_gestorId"];
                  $gestorXId = $handlerUs->selectById($gestorId);
	              	$nombre = $gestorXId->getNombre(). " " . $gestorXId->getApellido();
                  $baja= "<a href='".$url_impresion."fserialNro=".$value->getSerialNro()."&fgestor=".$gestorXId->getId()."&fasigId=".$handlerimpresoras->PlazaImpresoras($value->getSerialNro())["_asigId"]."' target='_blank'><i class='ion-document text-yellow' data-toggle='tooltip' title='Ver Comodato'></i></a>"; 
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
<script type="text/javascript">   

  $(function () {

  $('#search').quicksearch('table tbody tr');               
});
       
</script>
