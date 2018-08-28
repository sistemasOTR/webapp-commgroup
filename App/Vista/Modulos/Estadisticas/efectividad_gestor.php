<?php
  	include_once PATH_NEGOCIO."Funciones/Fechas/fechas.class.php"; 
  	include_once PATH_NEGOCIO."Sistema/handlersistema.class.php";  

  	$dFecha = new Fechas;    
  	$handler = new HandlerSistema;
  
  	$user = $usuarioActivoSesion;

    /*-------------------------*/
    /* --- gestion de fechas --*/
    $fHOY = $dFecha->FechaActual();
    $fHOY = $dFecha->FormatearFechas($fHOY,"Y-m-d","Y-m-d"); 

    $f = new DateTime();
    $f->modify('first day of this month');
    $fMES = $f->format('Y-m-d'); 

    setlocale(LC_TIME, 'spanish');  
    $nombreMES = strftime("%B",mktime(0, 0, 0, $f->format('m'), 1, 2000));      
    $anioMES = $f->format('Y'); 
    /*-------------------------*/


    //PARA TRABAJAR MAS COMODOS EN MODO DESARROLLO
    if(!PRODUCCION)
      $fHOY = "2018-08-10";


    $cerrados_efec =  $handler->selectCountServicios($fHOY,$fHOY, 6, null, null, null, $est_plaza, null);
    $despachados_efec = $handler->selectCountServicios($fHOY,$fHOY, 400, null, null, null, $est_plaza, null);
        

    if($despachados_efec[0]->CANTIDAD_SERVICIOS>0){        
      $efectividad_dia = 100 * $cerrados_efec[0]->CANTIDAD_SERVICIOS / $despachados_efec[0]->CANTIDAD_SERVICIOS;
    }
    else{
      $efectividad_dia = 0;
    }

    $arrGestores = $handler->selectServiciosByGestor($fHOY,$fHOY, 400, null, null, null,$est_plaza, null);

  
    $class_semaforo = "bg-red";
    if($efectividad_dia>=0 && $efectividad_dia<60)
      $class_semaforo = "bg-red";

    if($efectividad_dia>=60 && $efectividad_dia<70)
      $class_semaforo = "bg-yellow";

    if($efectividad_dia>=70 && $efectividad_dia<=100)
      $class_semaforo = "bg-green";          


?>

<div class="col-md-12 nopadding">
	<div class="box box-solid">    
    <div class="box-header">
      <h3 class="box-title">
        <i class="ion-speedometer"> </i> Gestores
        <span class='text-yellow'><b><?php echo $dFecha->FormatearFechas($fHOY,'Y-m-d','d/m/Y  - h:i'); ?></b></span>
      </h3>
    </div>
    <div class="box-body text-center">
          <?php 
            if( !empty($arrGestores)) {

              foreach ($arrGestores as $key => $value) {
    
                if($value->DESPACHADO>0){        
                  $efec_gestor = 100 * $value->CERRADO / $value->DESPACHADO;
                }
                else{
                  $efec_gestor = 0;
                }                
                if ($efec_gestor < 60) {
                      $bgcolour = '#dd4b39';
                    } elseif ($efec_gestor<=70) {
                      $bgcolour = '#f39c12';
                    } else {
                      $bgcolour = '#00a65a';
                    }

              $url_detalle = "index.php?view=servicio&fdesde=".$fHOY."&fhasta=".$fHOY."&fgestor=".$value->CODGESTOR;

             $dataGestores[] = array('gestores' => $value->NOMGESTOR,
                                     'link' => '<a href="'.$url_detalle.'">'.$value->NOMGESTOR.'<a>',                  
                                     'EFICIENCIA' => round($efec_gestor,2),
                                      'COLOR' => $bgcolour);

             $codigo[]=intval($value->CODGESTOR);
        
      }
      }
    $labels4 = '';
    $data4 = '' ;
    $link='';
    $barColor='';
    foreach ($dataGestores as $key => $val) {
      $labels4 = $labels4."'".$val['gestores']."', ";
      $data4 = $data4.$val['EFICIENCIA'].", "; 
      $link= $link."'".$val['link']."', ";
      $barColor= $barColor."'".$val['COLOR']."', ";
      
    }
        ?>

	 <canvas id="budget_cord_chart" class="col-xs-12 chart"></canvas>
     </div>
	</div>
</div>

<!-- SCRIPTS PARA GRAFICAR -->


<script>


  var config_cord = {

type: 'bar',
    data: {
      
      labels: [<?php echo $labels4 ?>],
      datasets: [{ 
        label: 'Efectividad',
        data: [<?php echo $data4 ?>],
        fill: false,
        borderColor: 'cornflowerblue',
        backgroundColor:[<?php echo $barColor ?>], 
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
            max: 100,
            stepSize: 10,
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
