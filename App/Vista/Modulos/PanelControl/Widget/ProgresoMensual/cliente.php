<?php
  	include_once PATH_NEGOCIO."Funciones/Fechas/fechas.class.php"; 
  	include_once PATH_NEGOCIO."Sistema/handlersistema.class.php";  
    include_once PATH_NEGOCIO."Funciones/Array/funcionesarray.class.php"; 
  	
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

    //ESTADO = 300 --> Cerrado Parcial, Re pactado, Re llamar, Cerrado, Negativo (los 5 estados que se toman como operacion en la calle)
    $countServiciosMesCursoGestion = $handler->selectCountServiciosGestion($fMES,$fHOY,null,$user->getUserSistema(),null,null,null,null);  
    $countDiasMesCurso = $handler->selectCountFechasServicios($fMES,$fHOY,null,$user->getUserSistema(),null,null,null,null);

    if(!empty($countDiasMesCurso[0]->CANTIDAD_DIAS))
      $countServiciosTotalGestion = round((intval($countServiciosMesCursoGestion[0]->CANTIDAD_SERVICIOS) / intval($countDiasMesCurso[0]->CANTIDAD_DIAS)),0);
    else
      $countServiciosTotalGestion = round(0,2);    

    //ESTADO = 200 --> Cerrado, Enviado y Liquidar (los 3 estados que se toman como operacion cerrada)
    $countServiciosCerradosMesCursoGestion = $handler->selectCountServiciosGestion($fMES,$fHOY,200,$user->getUserSistema(),null,null,null,null);        

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
    for ($i=$fdesde; $i <= $fhasta; $i++) { 
    	list($año, $mes, $dia) = split('[/.-]', $i);
    	$servCerrados = $handler->selectCountServiciosGestion($i,$i,200,$user->getUserSistema(),null,null,null,null);
    	$servTotales = $handler->selectCountServiciosGestion($i,$i,null,$user->getUserSistema(),null,null,null,null);
    	if ($servTotales[0]->CANTIDAD_SERVICIOS != 0 && $servCerrados[0]->CANTIDAD_SERVICIOS != 0) {
    		$dataGraf[] = array('dia' => $dia.'-'.$mes,
    						'EFICIENCIA' => number_format($servCerrados[0]->CANTIDAD_SERVICIOS*100/$servTotales[0]->CANTIDAD_SERVICIOS,2) );
    	}
    }

    // Construccion de labels y datos para representacion //
    $labels = '';
    $data = '' ;

    foreach ($dataGraf as $key => $value) {
    	$labels = $labels."'".$value['dia']."', ";
    	$data = $data.$value['EFICIENCIA'].", ";
    	$eficienciaDiaria[] = floatval($value['EFICIENCIA']);
    }

    // Valores representativos //
    $maxEf = max($eficienciaDiaria);
    $minEf = min($eficienciaDiaria);
    $promEf = number_format(array_sum($eficienciaDiaria)/count($eficienciaDiaria),2);
?>

<div class="box box-solid">
	<div class="box-header with-border">
		<h3 class="box-title"><i class="ion-stats-bars"></i> Progreso Mensual hasta el <?php echo $dia."-".$mes."-".$año ?></h3>
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
		<canvas id="budget_month_chart" class="col-xs-12 chart"></canvas>
		<div class="col-xs-6 border-right">
			<h5>Cerradas</h5>
			<h3 class="text-light-blue"><?php echo $countServiciosCerradosMesCurso[0]->CANTIDAD_SERVICIOS; ?></h3>
		</div>
		<div class="col-xs-6">
			<h5>Total</h5>
			<h3 class="text-blue"><?php echo $countServiciosMesCurso[0]->CANTIDAD_SERVICIOS; ?></h3>
		</div>
	</div>
</div>

<!-- SCRIPTS PARA GRAFICAR -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script>
<script src="https://rawgit.com/chartjs/chartjs-plugin-annotation/master/chartjs-plugin-annotation.js"></script>
<script>
	var config_BSF = {
		type: 'line',
		data: {
			labels: [<?php echo $labels ?>],
			datasets: [{
				label: 'Efectividad',
				data: [<?php echo $data ?>],
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
						max: 90,
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
					value: 75,
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

	window.onload = function() {
		var ctx_BSF = document.getElementById('budget_month_chart').getContext('2d');
		window.myLine_BSF = new Chart(ctx_BSF, config_BSF);
		
	};
</script>