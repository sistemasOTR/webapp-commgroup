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
        
     $cerrados8 = 0;
     $totales8 = 0;

        for ($i=6; $i >= 1 ; $i--) { 
            
            
            $fdesde = date('Y-m-01', mktime(0,0,0,date('m')-$i,1,date('Y')));
            $fhasta = date('Y-m-t', mktime(0,0,0,date('m')-$i,1,date('Y')));
            setlocale(LC_TIME, 'spanish');  
            $nombreMES = strftime("%B",mktime(0, 0, 0, date('m')-$i, 1, 2000));      
            $anioMES = date('Y',mktime(0,0,0,date('m')-$i,1,date('Y')));
           
             $servCerrados = $handler->selectCountServicios($fdesde,$fhasta,200,null,$user->getUserSistema(),null,null,null);
             $cerrados8 += $servCerrados[0]->CANTIDAD_SERVICIOS;
             $servTotales = $handler->selectCountServicios($fdesde,$fhasta,null,null,$user->getUserSistema(),null,null,null);
             $totales8 += $servTotales[0]->CANTIDAD_SERVICIOS;
              if ($servTotales[0]->CANTIDAD_SERVICIOS > 1 && $servCerrados[0]->CANTIDAD_SERVICIOS > 1) {
                  $dataGest[] = array('mes' => $nombreMES,
                       'EFICIENCIA' => number_format($servCerrados[0]->CANTIDAD_SERVICIOS*100/$servTotales[0]->CANTIDAD_SERVICIOS,2) );
      }
    }

// var_dump($dataG);
// exit();

    $labels8 = '';
    $data8 = '' ;

    foreach ($dataGest as $key => $value) {
      $labels8 = $labels8."'".$value['mes']."', ";
      $data8 = $data8.$value['EFICIENCIA'].", "; 
      $eficienciaMes[] = floatval($value['EFICIENCIA']);
    }

    // Valores representativos //
    $maxEf = max($eficienciaMes);
    $minEf = min($eficienciaMes);
    $promEf = number_format(array_sum($eficienciaMes)/count($eficienciaMes),2);
     
?>


  <div class="box box-solid">
  <div class="box-header with-border">
    <h3 class="box-title"><i class="ion-stats-bars"></i> Últimos 6 meses</h3>
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
    <canvas id="sem_gestor_chart" class="col-xs-12 chart"></canvas>
    <div class="col-xs-4 border-right">
      <h5>Cerradas</h5>
      <h3 class="text-light-blue"><?php echo $cerrados8; ?></h3>
    </div>
    <div class="col-xs-4 border-right">
      <h5>Total</h5>
      <h3 class="text-blue"><?php echo $totales8; ?></h3>
    </div>
    <div class="col-xs-4">
      <h5>Eficiencia</h5>
      <h3 class="text-blue"><?php echo number_format($cerrados8*100/$totales8,2); ?> %</h3>
    </div>
  </div>
</div>

<!-- SCRIPTS PARA GRAFICAR -->


<script>
  var config_sem_gestor = {
    type: 'line',
    data: {
      labels: [<?php echo $labels8 ?>],
      datasets: [{ 
        label: 'Efectividad',
        data: [<?php echo $data8 ?>],
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