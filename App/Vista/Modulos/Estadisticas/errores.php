<?php
  include_once PATH_NEGOCIO."Sistema/handlerconsultas.class.php";  
  include_once PATH_NEGOCIO."Sistema/handlersistema.class.php";  
  include_once PATH_NEGOCIO."Funciones/Fechas/fechas.class.php"; 
  include_once PATH_NEGOCIO."Funciones/Array/funcionesarray.class.php"; 

  include_once PATH_NEGOCIO."Modulos/handlerpuntaje.class.php"; 
  
  $view_detalle= "index.php?view=puntajes_coordinador_detalle";

  $user = $usuarioActivoSesion;

  $dFecha = new Fechas;

  $handler = new HandlerSistema;
  $arrCoordinador = $handler->selectAllCoordinadorFiltro(null,null,null,null,null);  

  $fdesde = (isset($_GET["fdesde"])?$_GET["fdesde"]:$dFecha->FechaActual());
  $fhasta = (isset($_GET["fhasta"])?$_GET["fhasta"]:$dFecha->FechaActual());      
  $fcoordinador= $user->getAliasUserSistema();

  // $handler =  new HandlerConsultas;
        
     $cerrados3 = 0;
     $totales3 = 0;

        for ($i=6; $i >= 1 ; $i--) { 
            
            $monthsMinus = '- '.$i .' month';
            

            $fdesde = date('Y-m-01',strtotime($monthsMinus));
            $fhasta = date('Y-m-t',strtotime($monthsMinus));
            setlocale(LC_TIME, 'spanish');  
            $nombreMES = strftime("%B",mktime(0, 0, 0, date('m',strtotime($monthsMinus)), 1, 2000));      
            $anioMES = date('Y',strtotime($monthsMinus));
           
             $servCerrados = $handler->selectCountServiciosGestion($fdesde,$fhasta,200,null,null,null,$est_plaza,null);
             $cerrados3 += $servCerrados[0]->CANTIDAD_SERVICIOS;
             $servTotales = $handler->selectCountServiciosGestion($fdesde,$fhasta,null,null,null,null,$est_plaza,null);
             $totales3 += $servTotales[0]->CANTIDAD_SERVICIOS;
              if ($servTotales[0]->CANTIDAD_SERVICIOS != 0 && $servCerrados[0]->CANTIDAD_SERVICIOS != 0) {
                  $dataErr[] = array('mes' => $nombreMES,
                       'EFICIENCIA' => number_format($servCerrados[0]->CANTIDAD_SERVICIOS*100/$servTotales[0]->CANTIDAD_SERVICIOS,2) );
      }
    }

// var_dump($dataG);
// exit();

    $labels3 = '';
    $data3 = '' ;

    foreach ($dataErr as $key => $value) {
      $labels3 = $labels3."'".$value['mes']."', ";
      $data3 = $data3.$value['EFICIENCIA'].", "; 
      $eficienciaMes[] = floatval($value['EFICIENCIA']);
    }

    // Valores representativos //
    $maxEf = max($eficienciaMes);
    $minEf = min($eficienciaMes);
    $promEf = number_format(array_sum($eficienciaMes)/count($eficienciaMes),2);
     
?>


  <div class="box box-solid">
  <div class="box-header with-border">
    <h3 class="box-title"><i class="ion-stats-bars text-red"></i> Errores <?php echo $año ?></h3>
    <div class="box-tools pull-right">
      <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
      <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
    </div>
  </div>
  <div class="box-body text-center">
    <div class="col-xs-4 border-right">
      <h5>Promedio</h5>
      <h3 class="text-yellow"><?php echo $promEf; ?>%</h3>
    </div>
    <div class="col-xs-4 border-right">
      <h5>Máximo</h5>
      <h3 class="text-green"><?php echo $maxEf; ?>%</h3>
    </div>
    <div class="col-xs-4">
      <h5>Mínimo</h5>
      <h3 class="text-red"><?php echo $minEf ?>%</h3>
    </div>
    <canvas id="err_chart" class="col-xs-12 chart"></canvas>
    <div class="col-xs-6 border-right">
      <h5>Cerradas</h5>
      <h3 class="text-light-blue"><?php echo $cerrados3; ?></h3>
    </div>
    <div class="col-xs-6">
      <h5>Total</h5>
      <h3 class="text-blue"><?php echo $totales3; ?></h3>
    </div>
  </div>
</div>

<!-- SCRIPTS PARA GRAFICAR -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script>
<script src="https://rawgit.com/chartjs/chartjs-plugin-annotation/master/chartjs-plugin-annotation.js"></script>
<script>
  var config_err = {
    type: 'line',
    data: {
      labels: [<?php echo $labels3 ?>],
      datasets: [{ 
        label: 'Efectividad',
        data: [<?php echo $data3 ?>],
        fill: false,
        borderColor: 'cornflowerblue',
        backgroundColor: 'cornflowerblue',
        borderWidth: 2,
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
            stepSize:3,
          },
        }],
        yAxes:[{
          ticks: {
            min: 30,
            max: 100,
            stepSize: 10
          }
        }]
      },
      tooltips: {
        xPadding:20,
        yPadding:20,
      },
      annotation: {
        annotations: [{
          type: 'line',
          mode: 'horizontal',
          scaleID: 'y-axis-0',
          value: 70,
          borderColor: 'darkgreen',
          borderWidth: 1,
          label: {
            enabled: false,
            content: 'Test label'
            }
          },
          {
          type: 'line',
          mode: 'horizontal',
          scaleID: 'y-axis-0',
          value: 60,
          borderColor: 'red',
          borderWidth: 1,
          label: {
            enabled: false,
            content: 'Test label'
            }
          }
        ],
      },
    }
  };


</script>      