<?php
  	include_once PATH_NEGOCIO."Funciones/Fechas/fechas.class.php"; 
    include_once PATH_NEGOCIO."Sistema/handlersistema.class.php";  
  	include_once PATH_NEGOCIO."Modulos/handlertickets.class.php";
    include_once PATH_DATOS.'Entidades/usuario.class.php'; 
    include_once PATH_NEGOCIO."Usuarios/handlerplazausuarios.class.php"; 
    include_once PATH_DATOS.'Entidades/expedicionesestados.class.php';

  	$dFecha = new Fechas;
    $handlertickets = new HandlerTickets;
  	$handlerUsuario = new Usuario; 
  	$user = $usuarioActivoSesion;
    $handlerPlaza = new HandlerPlazaUsuarios;
    $arrPlaza = $handlerPlaza->selectTodas();
    $handlerExp = new HandlerExpediciones;
    $handlerEstadosExp= new ExpedicionesEstados;
    $arrEstados=$handlerEstadosExp->select();
    

    foreach ($arrPlaza as $key => $valor) {

      foreach ($arrEstados as $value) {
      
      
   
                        $countExpediciones=0;
   
                        $consulta = $handlerExp->seleccionarByFiltros($fdesde,$fhasta,null,$value->getId(),$valor->getNombre()); //$valor->getNombre()
                         
                         if (!empty($consulta)) {
                           $countExpediciones+=count($consulta);            
                          }

                           $arrPlazaExpediciones[]= array('estados' =>$value->getNombre(),
                                                      'expediciones' =>$countExpediciones);
                         
    }  

 

    $labelsEst = '';
    $dataEst = '' ;
    foreach ($arrPlazaExpediciones as $valPlaza) {
      $labelsEst = $labelsEst."'".$valPlaza['estados']."', ";
      $dataEst = $dataEst.$valPlaza['expediciones'].", "; 
      
         
    }
    unset($arrPlazaExpediciones);

if ($dataEst!="0, 0, 0, 0, 0, 0, 0, 0, 0, ") {
$arrNombrePlaza[]=array('PLAZA'=>$valor->getId());
?>

<div class="col-lg-6 col-md-12 col-sm-6">
	<div class="box box-solid">    
    <div class="box-header">
      <h3 class="box-title" style="width: 100%;">
        <i class="ion-speedometer"> </i> Estados Expediciones<span><b></b></span>
        <small class="pull-right" style="font-size: 15px;"><span class='text-yellow '><b><?php echo $dFecha->FormatearFechas($fdesde,'Y-m-d','d/m/Y');echo "-".$dFecha->FormatearFechas($fhasta,'Y-m-d','d/m/Y'); ?></b></span></small>
      </h3>
    </div>
    <div class="box-body text-center">
	 <canvas id="budget_expediciones<?php echo $valor->getId();?>" class="col-xs-12 chart"></canvas>
     </div>
	</div>
</div>

<!-- SCRIPTS PARA GRAFICAR -->


<script>


  var config_expediciones<?php echo $valor->getId();?> = {

type: 'pie',
    data: {
      
      labels: [<?php echo $labelsEst ?>],
      datasets: [{ 
        label: 'Licencias',
        data: [<?php echo $dataEst ?>],
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

  }
 }

?>
 


