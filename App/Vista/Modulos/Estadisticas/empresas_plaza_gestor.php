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
  $arrEmpresas=$handler->selectAllEmpresaFiltroArray(null,null,null,$est_plaza,null);

  // var_dump($arrEmpresas);
  // exit();

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
     if(!PRODUCCION)
      $fHOY = "2018-08-11";

    $countServiciosMesCursoGestion = $handler->selectCountServiciosGestion($fMES,$fHOY,null,null,$user->getUserSistema(),null,null,null);
       
    $countDiasMesCurso = $handler->selectCountFechasServicios($fMES,$fHOY,null,null,$user->getUserSistema(),null,null,null);

    // var_dump($countServiciosMesCursoGestion,$countDiasMesCurso);
    // exit();
  
    if(!empty($countDiasMesCurso[0]->CANTIDAD_DIAS))
      $countServiciosTotalGestion = round((intval($countServiciosMesCursoGestion[0]->CANTIDAD_SERVICIOS) / intval($countDiasMesCurso[0]->CANTIDAD_DIAS)),0);
    else
      $countServiciosTotalGestion = round(0,2);   

    $countServiciosCerradosMesCursoGestion = $handler->selectCountServiciosGestion($fMES,$fHOY,200,null,$user->getUserSistema(),null,null,null); 

         

    if(!empty($countServiciosMesCursoGestion[0]->CANTIDAD_SERVICIOS))
      $efectividadMesCursoGestion = round(($countServiciosCerradosMesCursoGestion[0]->CANTIDAD_SERVICIOS) / intval(intval($countServiciosMesCursoGestion[0]->CANTIDAD_SERVICIOS))*100,0);
    else
      $efectividadMesCursoGestion = round(0,2);

   
    // Gestion graficos //
    list($año, $mes, $dia) = split('[/.-]', $dFecha->FechaActual());
    if ( $dia == '1') {
      $fechaAux = $dFecha->RestarDiasFechaActual(1);
      $fdesde = date('Y-m-01',strtotime($fechaAux));
      $fhasta = $fechaAux;
      $fhasta = $dFecha->FormatearFechas($fhasta,"Y-m-d","Y-m-d");
    } else {
      $fdesde = date('Y-m-01',strtotime($fHOY));
      $fhasta = $dFecha->RestarDiasFechaActual(1);
      $fhasta = $dFecha->FormatearFechas($fhasta,"Y-m-d","Y-m-d");
    }
  
 
    // Construccion de array para graficos //
    if(!empty($arrEmpresas)){
     if (count($arrEmpresas)==1) {
             $arrEmpresas=$arrEmpresas[""];
           }
    foreach ($arrEmpresas as $key => $value) {

    $cerrados9 = 0;
    $totales9 = 0;
    for ($i=$fdesde; $i <= $fhasta; $i++) { 
      list($año, $mes, $dia) = split('[/.-]', $i);
      $servCerrados = $handler->selectCountServiciosGestion($i,$i,200,$value["EMPTT11_CODIGO"],$user->getUserSistema(),null,null,null);
      $cerrados9 += $servCerrados[0]->CANTIDAD_SERVICIOS;
      $servTotales = $handler->selectCountServiciosGestion($i,$i,null,$value["EMPTT11_CODIGO"],$user->getUserSistema(),null,null,null);
      $totales9 += $servTotales[0]->CANTIDAD_SERVICIOS;
      if ($servTotales[0]->CANTIDAD_SERVICIOS != 0) {
        $dataGraf_emp[] = array('dia' => $dia.'-'.$mes,
                'EFICIENCIA' => number_format($servCerrados[0]->CANTIDAD_SERVICIOS*100/$servTotales[0]->CANTIDAD_SERVICIOS,2),
                'EMPRESA'=>$value["EMPTT21_NOMBREFA"] );
      }
    }
  
  // var_dump($dataGraff);
    // Construccion de labels y datos para representacion //
    $labels9 = '';
    $data9 = '' ;
    if(!empty($dataGraf_emp)){
      foreach ($dataGraf_emp as $dgf) {
        $labels9 = $labels9."'".$dgf['dia']."', ";
        $data9 = $data9.$dgf['EFICIENCIA'].", "; 
        $empresa_gestor=$dgf['EMPRESA'];
        $eficienciaDiaria[] = floatval($dgf['EFICIENCIA']);
      }
     // var_dump($empresa);
     //   exit();
    unset($dataGraf_emp);

      // Valores representativos //
      $maxEf = max($eficienciaDiaria);
      $minEf = min($eficienciaDiaria);
      $promEf = number_format(array_sum($eficienciaDiaria)/count($eficienciaDiaria),2);
    unset($eficienciaDiaria);

?>
<style>
  .col-xs-4 {padding-left: 5px;padding-right: 5px;}
</style>
<div class="col-lg-3 col-md-4 col-sm-6">
  <div class="box box-solid">
  <div class="box-header with-border">
    <h3 class="box-title"><i class="ion-stats-bars"></i> <?php echo $empresa_gestor; ?> <?php echo $mes.'-'.$año ?></h3>
  </div>
  <div class="box-body text-center">
    <div class="col-xs-4 border-right">
      <h5>Promedio</h5>
      <h4 class="text-yellow"><?php echo $promEf; ?>%</h4>
    </div>
    <div class="col-xs-4 border-right">
      <h5>Máximo</h5>
      <h4 class="text-green"><?php echo $maxEf; ?>%</h4>
    </div>
    <div class="col-xs-4">
      <h5>Mínimo</h5>
      <h4 class="text-red"><?php echo $minEf ?>%</h4>
    </div>
    <canvas id="gestor_<?php echo $value["EMPTT11_CODIGO"];?>" class="col-xs-12 chart"></canvas>
    <div class="col-xs-4 border-right">
      <h5>Cerradas</h5>
      <h4 class="text-light-blue"><?php echo $cerrados9; ?></h4>
    </div>
    <div class="col-xs-4 border-right">
      <h5>Total</h5>
      <h4 class="text-blue"><?php echo $totales9; ?></h4>
    </div>
    <div class="col-xs-4">
      <h5>Eficiencia</h5>
      <h4 class="text-blue"><?php echo number_format($cerrados9*100/$totales9,2); ?> %</h4>
    </div>
  </div>
</div>
</div>
<?php 
  $cod_empresa_gestor[]= array('EMPRESA'=>$value["EMPTT11_CODIGO"] );
 ?>
<!-- SCRIPTS PARA GRAFICAR -->

<script>
  var config_empresas_gestor<?php echo $value["EMPTT11_CODIGO"] ?> = { 
    type: 'line',
    data: {
      labels: [<?php echo $labels9 ?>],
      datasets: [{ 
        label: 'Efectividad',
        data: [<?php echo $data9 ?>],
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
            min: 0,
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


<?php 
  }
     }
   }
?>
