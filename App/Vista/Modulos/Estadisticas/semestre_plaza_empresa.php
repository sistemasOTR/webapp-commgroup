<?php
  include_once PATH_NEGOCIO."Sistema/handlerconsultas.class.php";  
  include_once PATH_NEGOCIO."Sistema/handlersistema.class.php";  
  include_once PATH_NEGOCIO."Funciones/Fechas/fechas.class.php"; 
  include_once PATH_NEGOCIO."Funciones/Array/funcionesarray.class.php"; 
  include_once PATH_NEGOCIO."Usuarios/handlerplazausuarios.class.php";
  include_once PATH_NEGOCIO."Modulos/handlerpuntaje.class.php"; 
  
  $view_detalle= "index.php?view=puntajes_coordinador_detalle";
   $handlerPlaza = new HandlerPlazaUsuarios;
  $arrPlaza = $handlerPlaza->selectTodas();
  // var_dump($arrPlaza);
  // exit();

  $user = $usuarioActivoSesion;

  $dFecha = new Fechas;

  $handler = new HandlerSistema;
  $arrCoordinador = $handler->selectAllCoordinadorFiltro(null,null,null,null,null);  

  $fdesde = (isset($_GET["fdesde"])?$_GET["fdesde"]:$dFecha->FechaActual());
  $fhasta = (isset($_GET["fhasta"])?$_GET["fhasta"]:$dFecha->FechaActual());      
  $fcoordinador= $user->getAliasUserSistema();

  // $handler =  new HandlerConsultas;
        
     $cerradosp = 0;
     $totalesp = 0;
         
         if(!empty($arrPlaza)){
     
    foreach ($arrPlaza as $key => $value) {
      // var_dump($value->getNombre());
      // exit();
        $cerradosp = 0;
        $totalesp = 0;
        for ($i=6; $i >= 1 ; $i--) { 
          

           
            
            $fdesde = date('Y-m-01', mktime(0,0,0,date('m')-$i,1,date('Y')));
            $fhasta = date('Y-m-t', mktime(0,0,0,date('m')-$i,1,date('Y')));
            setlocale(LC_TIME, 'spanish');  
            $nombreMES = strftime("%B",mktime(0, 0, 0, date('m')-$i, 1, 2000));      
            $anioMES = date('Y',mktime(0,0,0,date('m')-$i,1,date('Y')));
           
             $servCerrados = $handler->selectCountServicios($fdesde,$fhasta,200,$est_empresa,null,null,$value->getNombre(),null);
             $cerradosp += $servCerrados[0]->CANTIDAD_SERVICIOS;
             $servTotales = $handler->selectCountServicios($fdesde,$fhasta,null,$est_empresa,null,null,$value->getNombre(),null);
             $totalesp += $servTotales[0]->CANTIDAD_SERVICIOS;

              if ($servTotales[0]->CANTIDAD_SERVICIOS >1 && $servCerrados[0]->CANTIDAD_SERVICIOS >1) {
                  $dataPlazaEmp[] = array('mes' => $nombreMES,
                       'EFICIENCIA' => number_format($servCerrados[0]->CANTIDAD_SERVICIOS*100/$servTotales[0]->CANTIDAD_SERVICIOS,2),
                       'EMPRESA'=>$value->getNombre());
      }
    }



      
$eficienciaMes[]=0; 
      
unset($eficienciaMes);


    $labelsp = '';
    $datap = '' ;
    $Axes=30;
    if(!empty($dataPlazaEmp)){
    foreach ($dataPlazaEmp as $val) {
      $labelsp = $labelsp."'".$val['mes']."', ";
       if ($val['EFICIENCIA'] < 30){
         $Axes=0; }
      $datap = $datap.$val['EFICIENCIA'].", "; 
       $empresa=$val['EMPRESA'];
      $eficienciaMes[] = floatval($val['EFICIENCIA']);
    }
   unset($dataPlazaEmp);

    // Valores representativos //
    $maxEf = max($eficienciaMes);
    $minEf = min($eficienciaMes);
    $promEf = number_format(array_sum($eficienciaMes)/count($eficienciaMes),2);

    
?>
<style>
  .col-xs-4 {padding-left: 5px;padding-right: 5px;}
</style>
<div class="col-lg-6 col-md-3 col-sm-6">
  <div class="box box-solid">
  <div class="box-header with-border">
    <h3 class="box-title"><i class="ion-stats-bars"></i> <?php echo $empresa; ?> <?php echo $año ?></h3>
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
    <canvas id="plaza_<?php echo $value->getId();?>" class="col-xs-12 chart"></canvas>
    <div class="col-xs-4 border-right">
      <h5>Cerradas</h5>
      <h3 class="text-light-blue"><?php echo $cerradosp; ?></h3>
    </div>
    <div class="col-xs-4 border-right">
      <h5>Total</h5>
      <h3 class="text-blue"><?php echo $totalesp; ?></h3>
    </div>
    <div class="col-xs-4">
      <h5>Eficiencia</h5>
      <h3 class="text-blue"> <?php echo number_format($cerradosp*100/$totalesp,2); ?> %</h3>
    </div>
  </div>
</div>
</div>
<?php 
  $cod_emp_plaza[]= array('PLAZA'=>$value->getId());
  // var_dump($cod_emp);
  // exit();
 ?>
<!-- SCRIPTS PARA GRAFICAR -->


<script>
  var config_empresas_plaza<?php echo $value->getId() ?> = {
    type: 'line',
    data: {
      labels: [<?php echo $labelsp ?>],
      datasets: [{ 
        label: 'Efectividad',
        data: [<?php echo $datap ?>],
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
            autoSkip: false
          },
        }],
        yAxes:[{
          ticks: {
            min: <?php echo $Axes ?>,
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
