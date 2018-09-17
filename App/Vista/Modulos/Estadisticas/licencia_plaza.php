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
    $countLic=0;
   
     
     if (!empty($arruser)) {         
    
    foreach ($arruser as $value ) {

                        $fechaDesde = date('Y-m-d',strtotime($fdesde));
                        $fechaHasta = date('Y-m-d',strtotime($fhasta));
                        $FECHA = $dFecha->FormatearFechas($fechaDesde,"Y-m-d","Y-m-d");
                        $HASTA = $dFecha->FormatearFechas($fechaHasta,"Y-m-d","Y-m-d");
                        $arrayIde[]=0;
                        while (strtotime($FECHA) <= strtotime($HASTA)) {
                        $arrLicencia = $handler->seleccionarByFiltrosRRHH($FECHA,$FECHA,$value->getId(),2);

                        
                        if(!empty($arrLicencia))
                         {                                                   
                        foreach ($arrLicencia as $key => $val) {
                            foreach ($arrayIde as $idrepeate) {
                              if (intval($val->getId()) == $idrepeate) {
                                $seguir = false;
                                break;
                              } else {
                                $seguir = true;
                              }
                            }
                         
                             if($seguir){
                              $arrayIde[]=intval($val->getId());
                              $countLic+=1;
                              }
                            }
                          }
                               $FECHA = date('Y-m-d',strtotime('+1 day',strtotime($FECHA)));  
                            }
                             
                            
        }
       
 
    $arrPlazaLicencias[]= array('plaza' =>$valor->getNombre(),
                                'licencia' =>$countLic);
    // var_dump($arrPlazaLicencias);
    //   exit();
 }
}

    $labels = '';
    $data = '' ;
    foreach ($arrPlazaLicencias as $valPlaza) {
      $labels = $labels."'".$valPlaza['plaza']."', ";
      $data = $data.$valPlaza['licencia'].", "; 
      
         
    }
    unset($arrPlazaLicencias);


 if ($data!="0, 0, 0, 0, 0, 0, ") {
  
?>

<div class="col-md-12 nopadding">
	<div class="box box-solid">    
    <div class="box-header"> 
      <h3 class="box-title" style="width: 100%;">
        <i class="ion-speedometer"> </i> Cant. Licencias Plazas <span><b></b></span>
        <small class="pull-right" style="font-size: 15px;"><span class='text-yellow '><b><?php echo $dFecha->FormatearFechas($fdesde,'Y-m-d','d/m/Y');echo "-".$dFecha->FormatearFechas($fhasta,'Y-m-d','d/m/Y'); ?></b></span></small>
      </h3>
    </div>
    <div class="box-body text-center">
	 <canvas id="budget_licencias" class="col-xs-12 chart"></canvas>
     </div>
	</div>
</div>

<!-- SCRIPTS PARA GRAFICAR -->


<script>


  var config_licencias = {

type: 'pie',
    data: {
      
      labels: [<?php echo $labels ?>],
      datasets: [{ 
        label: 'Licencias',
        data: [<?php echo $data ?>],
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
 }else{
  echo "<span><b class='text-red'>¡Ups! No se han encontrado registros para esta fecha.</b></span>";
 }

 ?>


