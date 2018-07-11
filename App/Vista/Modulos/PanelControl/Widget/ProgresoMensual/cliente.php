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

?>

<div class="box box-solid">
	<div class="box-header with-border">
		<h3 class="box-title"><i class="ion-stats-bars"></i> Progreso Mensual</h3>
		<div class="box-tools pull-right">
			<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
			<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
		</div>
	</div>
	<div class="box-body text-center">
		<div class="col-xs-4 border-right">
			<h5>Promedio</h5>
			<h3 class="text-yellow">69.53%</h3>
		</div>
		<div class="col-xs-4 border-right">
			<h5>Máximo</h5>
			<h3 class="text-green">80.00%</h3>
		</div>
		<div class="col-xs-4">
			<h5>Mínimo</h5>
			<h3 class="text-red">58.00%</h3>
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