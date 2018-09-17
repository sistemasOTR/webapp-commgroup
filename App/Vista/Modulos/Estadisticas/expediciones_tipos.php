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
    


      foreach ($arrTipos as $value) {
      
                        $countExpediciones=0;
   
                        $consulta = $handlerExp->seleccionarByFiltros($fdesde,$fhasta,$value->getId(),null,null); //$valor->getNombre()
                         
                         if (!empty($consulta)) {
                           $countExpediciones+=count($consulta);            
                          }
                    $arrTipoExpediciones[]= array('tipos' =>$value->getGrupo(),
                                                   'expediciones' =>$countExpediciones);
    }  
     
 

    $labelsTipos = '';
    $dataTipos = '' ;
    foreach ($arrTipoExpediciones as $valPlaza) {
      $labelsTipos = $labelsTipos."'".$valPlaza['tipos']."', ";
      $dataTipos = $dataTipos.$valPlaza['expediciones'].", "; 
      
         
    }
    unset($arrTipoExpediciones);

    if ($dataTipos!="0, 0, 0, ") {

?>

<div class="col-md-12 ">
	<div class="box box-solid">    
    <div class="box-header">
      <h3 class="box-title" style="width: 100%;">
        <i class="ion-speedometer"> </i>Tipos Expediciones<span><b></b></span>
        <small class="pull-right" style="font-size: 15px;"><span class='text-yellow '><b><?php echo $dFecha->FormatearFechas($fdesde,'Y-m-d','d/m/Y');echo "-".$dFecha->FormatearFechas($fhasta,'Y-m-d','d/m/Y'); ?></b></span></small>
      </h3>
    </div>
    <div class="box-body text-center">
	 <canvas id="budget_tipos" class="col-xs-12 chart"></canvas>
     </div>
	</div>
</div>

<!-- SCRIPTS PARA GRAFICAR -->


<script>


  var config_tipos = {

type: 'pie',
    data: {
      
      labels: [<?php echo $labelsTipos ?>],
      datasets: [{ 
        label: 'Licencias',
        data: [<?php echo $dataTipos ?>],
        fill: false,
        borderColor: 'white',
        backgroundColor:['#BDC7E0','#D17272','#D2B4DE','#D4EFDF','#87CEFA','#CD853F','#F9E79F','#B7BFBC','#9EA9C9'], 
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


