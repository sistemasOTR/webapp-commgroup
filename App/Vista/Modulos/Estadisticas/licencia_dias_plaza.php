<?php
  	include_once PATH_NEGOCIO."Funciones/Fechas/fechas.class.php"; 
    include_once PATH_NEGOCIO."Sistema/handlersistema.class.php";  
  	include_once PATH_NEGOCIO."Modulos/handlertickets.class.php";
    include_once PATH_DATOS.'Entidades/usuario.class.php'; 
    include_once PATH_NEGOCIO."Usuarios/handlerplazausuarios.class.php"; 

  	$dFecha = new Fechas;
    $handlertickets = new HandlerTickets;
  	$handlerUsuario = new Usuario; 
  	$user = $usuarioActivoSesion;
    $handlerPlaza = new HandlerPlazaUsuarios;
    $arrPlaza = $handlerPlaza->selectTodas();


// $arrPlazaLicencias[]='';

    foreach ($arrPlaza as $key => $valor) {
         
    $arruser=$handlerUsuario->selectByPlaza($valor->getId());
    $countDiasLic=0;
   
     
     if (!empty($arruser)) {         
    
    foreach ($arruser as $value ) {

                        $fechaDesde = date('Y-m-d',strtotime($fdesde));
                        $fechaHasta = date('Y-m-d',strtotime($fhasta));
                        $FECHA = $dFecha->FormatearFechas($fechaDesde,"Y-m-d","Y-m-d");
                        $HASTA = $dFecha->FormatearFechas($fechaHasta,"Y-m-d","Y-m-d");
                        while (strtotime($FECHA) <= strtotime($HASTA)) {
                        $arrLicencia = $handler->seleccionarByFiltrosRRHH($FECHA,$FECHA,$value->getId(),2);
                         // var_dump(count($arrLicencia));
                         //    exit();
        
                        if(!empty($arrLicencia))
                         {  

                              
                              $countDiasLic+=count($arrLicencia);
                           
                          }
                               $FECHA = date('Y-m-d',strtotime('+1 day',strtotime($FECHA)));  
                            }
                             
                       
        }

          //      var_dump($countDiasLic);
          // exit();
 
    $arrPlazaDias[]= array('plaza' =>$valor->getNombre(),
                                'licencia' =>$countDiasLic);
    // var_dump($arrPlazaLicencias);
    //   exit();
 }
}

    $labelsDias = '';
    $dataDias = '' ;
    foreach ($arrPlazaDias as $valPlaza) {
      $labelsDias = $labelsDias."'".$valPlaza['plaza']."', ";
      $dataDias = $dataDias.$valPlaza['licencia'].", "; 
      
         
    }
    unset($arrPlazaDias);

  if ($dataDias!="0, 0, 0, 0, 0, 0, ") {
     
?>

<div class="col-md-12 nopadding">
	<div class="box box-solid">    
    <div class="box-header">
      <h3 class="box-title" style="width: 100%;">
        <i class="ion-speedometer"> </i> Dias Licencias Plazas <span><b></b></span>
        <small class="pull-right" style="font-size: 15px;"><span class='text-yellow '><b><?php echo $dFecha->FormatearFechas($fdesde,'Y-m-d','d/m/Y');echo "-".$dFecha->FormatearFechas($fhasta,'Y-m-d','d/m/Y'); ?></b></span></small>
      </h3>
    </div>
    <div class="box-body text-center">
	 <canvas id="budget_dias_plaza" class="col-xs-12 chart"></canvas>
     </div>
	</div>
</div>

<!-- SCRIPTS PARA GRAFICAR -->


<script>


  var config_dias_plaza = {

type: 'pie',
    data: {
      
      labels: [<?php echo $labelsDias ?>],
      datasets: [{ 
        label: 'Dias Licencias',
        data: [<?php echo $dataDias ?>],
        fill: false,
        borderColor: 'white',
        backgroundColor:['#BDC7E0','#D17272','#D2B4DE','#D4EFDF','#87CEFA','#CD853F','#F9E79F'], 
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

}


 ?>


