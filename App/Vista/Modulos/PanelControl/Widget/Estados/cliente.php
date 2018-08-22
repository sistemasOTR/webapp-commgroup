<?php
  	include_once PATH_NEGOCIO."Funciones/Fechas/fechas.class.php"; 
  	include_once PATH_NEGOCIO."Sistema/handlersistema.class.php";  
	include_once PATH_NEGOCIO."Funciones/Array/funcionesarray.class.php"; 
  	
  	$dFecha = new Fechas;
  
 	$user = $usuarioActivoSesion;
 	$fplaza=(isset($_GET["fplaza"])?$_GET["fplaza"]:'');

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
  	$fHOY = '2018-07-11';

  	$arrEstados = $handler->selectGroupServiciosByEstados($fHOY,$fHOY,null,$user->getUserSistema(),null,null,null,null);
  	$allEstados = $handler->selectAllEstados();

  	if (!empty($arrEstados)) {
		$sum_total_estados=0; 
		$sum_estados_gestionados=0;
		$porc_estados_gestionados=0;

		if(!empty($arrEstados))
		{                   
			foreach ($arrEstados as $key => $value) {
			//$url_estados = "?view=servicio&fdesde=".$fHOY."&fhasta=".$fHOY."&festado=".$value->SERTT91_ESTADO;

				$f_array = new FuncionesArray;
				$class_estado = $f_array->buscarValor($allEstados,"1",$value->ESTADOS_DESCCI,"2");

				// totales
				$sum_total_estados = $sum_total_estados + $value->CANTIDAD_SERVICIOS;
				if($value->SERTT91_ESTADO>2 && $value->SERTT91_ESTADO != 12)
					$sum_estados_gestionados=$sum_estados_gestionados+$value->CANTIDAD_SERVICIOS;
			}

			if(empty($sum_total_estados))
				$porc_estados_gestionados = 0;
			else	
				$porc_estados_gestionados = ($sum_estados_gestionados / $sum_total_estados) *100;
		}                  
?>

<div class="col-xs-12">
	<div class="box box-solid">
	  	<div class="box-header with-border">
	    	<i class="ion-arrow-graph-up-right"></i>
	    	<h3 class="box-title">Actividad General.</h3>
	    	<a href="#" class="pull-right text-navy" data-toggle='modal' data-target='#modal_todos'>
        		<i class="fa fa-search"  data-toggle='tooltip' title='Detalle de gestiones'></i>
        	</a>
	  	</div>
	  	<div class="box-body no-padding">

  	       	<div class="info-box bg-aqua">
                <span class="info-box-icon"><i class="fa fa-truck"></i></span>

                <div class="info-box-content">
                  	<span class="info-box-text">GESTIONES</span>
                  	<span class="info-box-number" id="widget-estado-total-gestiones"><?php echo $sum_total_estados; ?></span>

                  	<div class="progress">
                    	<div class="progress-bar" id="widget-estado-progreso" style="width: <?php echo round($porc_estados_gestionados,2); ?>%"></div>
                  	</div>
                  	<span class="progress-description">
                    	<span class="pull-right" id="widget-estado-porcentaje-gestionados"><?php echo round($porc_estados_gestionados,2); ?> % <small>Gestionadas</small></span>
                  	</span>

                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade in" id='modal_todos'>
    <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span></button>
            <h4 class="modal-title">Detalle General</h4>
          </div>
          <div class="modal-body">
            <div class="no-padding">
                <ul class="nav nav-stacked">
              <?php

			        	$sum_total_estados=0; 
			          	$sum_estados_gestionados=0;
			          	$porc_estados_gestionados=0;
			          	
			          	if(!empty($arrEstados))
			          	{                   
			            	foreach ($arrEstados as $key => $value) {
			              		//$url_estados = "?view=servicio&fdesde=".$fHOY."&fhasta=".$fHOY."&festado=".$value->SERTT91_ESTADO;

				            	$f_array = new FuncionesArray;
				            	$class_estado = $f_array->buscarValor($allEstados,"1",$value->ESTADOS_DESCCI,"2");

			              		if(!($value->ESTADOS_DESCCI=="Liquidar C. Parcial") || !($value->ESTADOS_DESCCI=="No Efectivas"))
			              		{
			                		echo "                	
				                		<li><a href='#'>".$value->ESTADOS_DESCCI." <span class='pull-right badge ".$class_estado."'>
				                		".round($value->CANTIDAD_SERVICIOS,2)."
				                		</span></a></li>";
			              		}

			              		// totales
			              		$sum_total_estados = $sum_total_estados + $value->CANTIDAD_SERVICIOS;
			              		if($value->SERTT91_ESTADO>2)
			              			$sum_estados_gestionados=$sum_estados_gestionados+$value->CANTIDAD_SERVICIOS;
			            	}

			            	if(empty($sum_total_estados))
			            		$porc_estados_gestionados = 0;
			            	else	
			            		$porc_estados_gestionados = ($sum_estados_gestionados / $sum_total_estados) *100;
			          	}                  
			        ?>
                </ul>
            </div>
          </div>

      </div>
    </div>
  </div>
<?php } ?>
	        