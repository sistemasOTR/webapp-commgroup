<?php
  	include_once PATH_NEGOCIO."Funciones/Fechas/fechas.class.php"; 
  	include_once PATH_NEGOCIO."Sistema/handlersistema.class.php";  
    include_once PATH_NEGOCIO."Sistema/handlersupervisor.class.php";
	include_once PATH_NEGOCIO."Funciones/Array/funcionesarray.class.php"; 
  	
  	$dFecha = new Fechas;    
  	$handler = new HandlerSistema;
    $handlerS = new HandlerSupervisor;    
  
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
      $fHOY = "2018-07-03";

	  $sum_total_estados=0; 
  	$sum_estados_gestionados=0;
  	$porc_estados_gestionados=0;

    $plazas = $handlerS->selectPlazasBySupervisorId($user->getUserSistema());

    if(!empty($plazas))
    {
      	foreach ($plazas as $key => $valuePlazas) {

		  	$arrEstados = $handler->selectGroupServiciosByEstados($fHOY,$fHOY,null,null,null,null,$valuePlazas["alias"],null);   

			  $allEstados = $handler->selectAllEstados();

          	if(!empty($arrEstados))
          	{                   
            	foreach ($arrEstados as $key => $value) {

	            	$f_array = new FuncionesArray;
	            	$class_estado = $f_array->buscarValor($allEstados,"1",$value->ESTADOS_DESCCI,"2");

              		// totales
              		$sum_total_estados = $sum_total_estados + $value->CANTIDAD_SERVICIOS;

              		if($value->SERTT91_ESTADO>2)
              			$sum_estados_gestionados = $sum_estados_gestionados + $value->CANTIDAD_SERVICIOS;
            	}
          	}          
		}

    	if(empty($sum_total_estados))
    		$porc_estados_gestionados = 0;
    	else	
    		$porc_estados_gestionados = round(($sum_estados_gestionados / $sum_total_estados) *100,2);
	}
?>

<div class="col-md-12 nopadding">
	<div class="box box-solid">
	  	<div class="box-header with-border">
	      <h3 class="box-title"><i class="ion-ios-paperplane"></i> Visor de Servicios Gestionados.</h3>
	    </div>
	  	<div class="box-body no-padding">

  	       	<div class="info-box bg-aqua">
                <span class="info-box-icon"><i class="ion-ios-paperplane"></i></span>

                <div class="info-box-content">
                  	<span class="info-box-text">GESTIONES</span>
                  	<span class="info-box-number"><?php echo $porc_estados_gestionados."%"; ?></span>

                  	<div class="progress">
                    	<div class="progress-bar" style="width: <?php echo $porc_estados_gestionados."%"; ?>"></div>
                  	</div>
		            <span class="progress-description">
		              <?php echo $sum_total_estados; ?> <small>Total</small> 
		              <span class="pull-right"><?php echo $sum_estados_gestionados; ?> <small>Gestionadas</small></span>
		            </span>

                </div>
            </div>
        </div>
    </div>
</div>