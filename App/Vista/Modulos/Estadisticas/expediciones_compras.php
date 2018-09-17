<?php
  	include_once PATH_NEGOCIO."Funciones/Fechas/fechas.class.php"; 
    include_once PATH_NEGOCIO."Sistema/handlersistema.class.php";  
  	include_once PATH_NEGOCIO."Modulos/handlertickets.class.php";
    include_once PATH_DATOS.'Entidades/usuario.class.php'; 
    include_once PATH_NEGOCIO."Usuarios/handlerplazausuarios.class.php"; 
    include_once PATH_DATOS.'Entidades/expedicionestipo.class.php';

  	$dFecha = new Fechas;
    $handlertickets = new HandlerTickets;
  	$handlerUsuario = new Usuario; 
  	$user = $usuarioActivoSesion;
    $handlerPlaza = new HandlerPlazaUsuarios;
    $arrPlaza = $handlerPlaza->selectTodas();
    $handlerExp = new HandlerExpediciones;
    $handlerTipos= new ExpedicionesTipo;
    $arrTipos=$handlerTipos->select();
    // var_dump($arrTipos);
    // exit();
    $arrEstadosCompras=array("enviado" =>array('estado'=>1,'nombre'=>'Pedido'),
                                "recibido"=>array('estado'=>2,'nombre'=>'Recibido'));
    
  
  

      foreach ($arrTipos as $value) {

        foreach ($arrEstadosCompras as $key => $val) {
      
                        $countExpediciones=0;
   
                        $consulta = $handlerExp->seleccionarAllComprasByFiltros($fdesde,$fhasta,$value->getId(),$val['estado']); //$valor->getNombre()
                         
                         if (!empty($consulta)) {
                           $countExpediciones+=count($consulta);            
                          }
                    $arrCompras[]= array('tipos' =>$value->getGrupo()." ".$val['nombre'],     
                                                 'expediciones' =>$countExpediciones);

      }              
    }  
     
 

    $labelsCompras = '';
    $dataCompras = '' ;
    foreach ($arrCompras as $valPlaza) {
      $labelsCompras = $labelsCompras."'".$valPlaza['tipos']."', ";
      $dataCompras = $dataCompras.$valPlaza['expediciones'].", "; 
      
         
    }
    unset($arrCompras);
    
      if ($dataCompras!="0, 0, 0, 0, 0, 0, ") {
  ?>

<div class="col-md-6 ">
	<div class="box box-solid">    
    <div class="box-header">
      <h3 class="box-title" style="width: 100%;">
        <i class="ion-speedometer"> </i>Compras <span><b></b></span>
        <small class="pull-right" style="font-size: 15px;"><span class='text-yellow '><b><?php echo $dFecha->FormatearFechas($fdesde,'Y-m-d','d/m/Y');echo "-".$dFecha->FormatearFechas($fhasta,'Y-m-d','d/m/Y'); ?></b></span></small>
      </h3>
    </div>
    <div class="box-body text-center">
	 <canvas id="budget_compras" class="col-xs-12 chart"></canvas>
     </div>
	</div>
</div>


<!-- SCRIPTS PARA GRAFICAR -->


<script>


  var config_compras = {

type: 'pie',
    data: {
      
      labels: [<?php echo $labelsCompras ?>],
      datasets: [{ 
        label: 'Licencias',
        data: [<?php echo $dataCompras ?>],
        fill: false,
        borderColor: 'white',
        backgroundColor:['#D2EAF2','#D17272','#D2B4DE','#D4EFDF','#87CEFA','#CD853F','#F9E79F','#B7BFBC','#9EA9C9'], 
      }]
    },
    options: {
      responsive: true,
       legend: {display:true,position:'left'},
      title: {
        display: false,
      },
    }
  };


</script>  

<?php
 }else{
  echo "<span><b class='text-red'>¡Ups! No se han encontrado registros para esta fecha.</b></span>";
 }


?>
 


