<?php
  	include_once PATH_NEGOCIO."Funciones/Fechas/fechas.class.php"; 
    include_once PATH_NEGOCIO."Sistema/handlersistema.class.php";  
  	include_once PATH_NEGOCIO."Modulos/handlertickets.class.php";
    include_once PATH_DATOS.'Entidades/usuario.class.php'; 
    include_once PATH_NEGOCIO."Usuarios/handlerplazausuarios.class.php"; 

  	$dFecha = new Fechas;    
    $handler = new HandlerSistema;
    $handlertickets = new HandlerTickets;
  	$handlerUsuario = new Usuario; 
  	$user = $usuarioActivoSesion;
    $handlerPlaza = new HandlerPlazaUsuarios;
    $arrPlaza = $handlerPlaza->selectTodas();
         foreach ($arrPlaza as $key => $valor) {
         
    $arruser=$handlerUsuario->selectByPlaza($valor->getId());
     // var_dump($arruser);
     //          exit();
 
   
    //PARA TRABAJAR MAS COMODOS EN MODO DESARROLLO
    if(!PRODUCCION)
      $fHOY = "2018-08-27";
    $arrGasoil=0;
    $arrNafta=0;
    $arrGnc=0;
    $dataTickets='';
    
    if (!empty($arruser)) {

    foreach ($arruser as $value ) {
   $conceptos=$handlertickets->seleccionarByConcepto($fdesde,$fhasta,$value->getId());

      if(!empty($conceptos)) {

              foreach ($conceptos as $val) {
               if (trim($val->getConcepto())=='GASOIL' ) {
                 $arrGasoil+=1;
               }
               elseif (trim($val->getConcepto())=='NAFTA') {
                 $arrNafta+=1;
               }
               elseif (trim($val->getConcepto())=='GNC') {
                 $arrGnc+=1;
               }
        
      }
    }
  }
 }
  
    $dataTickets =$arrNafta.",".$arrGasoil.",".$arrGnc;
    if ($dataTickets!="0,0,0") {
   
    $arrTickets[]=array('PLAZA'=>$valor->getId());
  
?>

<div class="col-md-12 nopadding">
	<div class="box box-solid">    
    <div class="box-header">
      <h3 class="box-title">
        <i class="ion-speedometer"> </i> Tickets <span><b><?php echo $valor->getNombre();?></b></span>
        <span class='text-yellow'><b><?php echo $dFecha->FormatearFechas($fhasta,'Y-m-d','d/m/Y  - h:i'); ?></b></span>
      </h3>
    </div>
    <div class="box-body text-center">
	 <canvas id="budget_tickets_<?php echo $valor->getId(); ?>" class="col-xs-12 chart"></canvas>
     </div>
	</div>
</div>

<!-- SCRIPTS PARA GRAFICAR -->


<script>


  var config_tickets<?php echo $valor->getId(); ?> = {

type: 'bar',
    data: {
      
      labels: ['NAFTA','GASOIL','GNC'],
      datasets: [{ 
        label: 'Tickets',
        data: [<?php echo $dataTickets ?>],
        fill: false,
        borderColor: 'cornflowerblue',
        backgroundColor:['#2980B9','#5D6D7E','#138D75'], 
        borderWidth: 0,
        lineTension: 0,
        pointRadius: 1,
      }]
    },
    options: {
      responsive: true,
      legend: {display:false},
      title: {
        display: false,
      },
      scales: {
        
        xAxes:[{
          gridLines: {
            display: false,
          },
          ticks:{
            stepSize:1,
            autoSkip: false

          },
        }],
        yAxes:[{
          ticks: {
            min: 0,
            gridLines: {
              display: false,
            },
          }
        }]
      },
      tooltips: {
        xPadding:20,
        yPadding:20,
      },
    }
  };


</script>  
 
<?php
  }
}
?>

