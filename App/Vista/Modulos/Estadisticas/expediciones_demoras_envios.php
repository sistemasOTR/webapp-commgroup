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
    $handlerExp = new HandlerExpediciones;


// $arrPlazaLicencias[]='';

          foreach ($arrPlaza as $key => $valor) {

          unset($asda);
          $seguir=false;
   
             $consulta = $handlerExp->seleccionarByFiltros($fdesde,$fhasta,null,null,$valor->getNombre());// ej.'ROSARIO'
             // var_dump($consulta);
             // exit();
            
            
                  if (count($consulta)==1){
                    $consulta=$consulta[""];
                  }
                     
                     if(!empty($consulta)){
                      foreach ($consulta as $key => $value) {
                      
                        if ($value->getEstadosExpediciones()!=3) {
                        
                        $TablaEnvios=$handlerExp->selecionarEnvios($value->getId());// ej.13 
                        
                         if (!empty($TablaEnvios)) {
                         
                          foreach ($TablaEnvios as $val) {
                          
                         if (!empty($val->getNroEnvio())) { // si no estan en baja.
                            
                        $tableEnviados=$handlerExp->selectByIdEnviado($val->getNroEnvio());
                        
                        
                       // $dif_dias_aprobado = $dFecha->DiasDiferenciaFechas($val->getFecha()->format('Y-m-d'),$value->getFecha()->format('Y-m-d'),"Y-m-d");
                       $dif_dias_enviado = $dFecha->DiasDiferenciaFechas($tableEnviados[""]->getFecha()->format('Y-m-d'),$value->getFecha()->format('Y-m-d'),"Y-m-d");
                        // var_dump($dif_dias_enviado);
                        // exit();
                     
                        $asda[]=$dif_dias_enviado;
                        $seguir=true;
                          
                          }
                         }
                        }
                       } 
                               
                      }  
                     } 
      // var_dump($asda);
      // exit();
                    
       if ($seguir) {
            sort($asda);
            // var_dump($asda);
    
          $max=max($asda);
          // var_dump($max); 
   $flag=false;
         
    $recorrido=array_count_values($asda);
    // var_dump(intval($max));

    $dataDias = '';
    $labelsCantDias = '';
    $AxesMax='';
    // exit();
     // $a=0;
    if (intval($max)<=5) {
      $max=5;
    }
    for ($i=0; $i <= intval($max) ; $i++) { 
      

      foreach ($recorrido as $k =>$vall) {
               // var_dump($k);

                if ($i==$k) {
                  $dataDias = $dataDias."'".$vall."', "; 
                $flag=true;
                break;
                }else{
                  $flag=false;
                }
        
        }
        if (!$flag) {
                  $cero=0;
                  $dataDias = $dataDias."'".$cero."', "; 
    }
                  $labelsCantDias = $labelsCantDias."'".$i."', ";
                
                // exit();   
        // var_dump($dataDias,$labelsCantDias);
 }
    
    
     
    
    
  // var_dump($labelsCantDias,$dataDias);

    unset($recorrido);

$arrPlazaDiasCantEnvio[]=array('PLAZA'=>$valor->getId());



  
?>

<div class="col-md-4 nopadding">
	<div class="box box-solid">    
    <div class="box-header">
      <h3 class="box-title" style="width: 100%;">
        <i class="ion-speedometer"> </i>Dias Envios Plazas <span><b><?php echo $valor->getNombre(); ?></b></span>
        <small class="pull-right" style="font-size: 15px;"><span class='text-yellow '><b><?php echo $dFecha->FormatearFechas($fdesde,'Y-m-d','d/m/Y');echo "-".$dFecha->FormatearFechas($fhasta,'Y-m-d','d/m/Y'); ?></b></span></small>
      </h3>
    </div>
    <div class="box-body text-center">
	 <canvas id="budget_dias_envios<?php echo $valor->getId(); ?>" class="col-xs-12 chart"></canvas>
     </div>
	</div>
</div>

<!-- SCRIPTS PARA GRAFICAR -->


<script>


  var config_dias_envios<?php echo $valor->getId(); ?> = {

type: 'bar',
    data: {
      
      labels: [<?php echo $labelsCantDias  ?>],
      datasets: [{ 
        label: 'Personas',
        data: [<?php echo $dataDias  ?>],
        fill: false,
        borderColor: 'white',
        backgroundColor:'#BDC7E0', 

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
           stepSize:1
          },
          scaleLabel: { 
             display: true,
             labelString: 'Dias'
          },
        }],

       yAxes:[{
          ticks: {
           stepSize:1
          },
          scaleLabel: { 
           display: true,
           labelString: 'Personas'
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


