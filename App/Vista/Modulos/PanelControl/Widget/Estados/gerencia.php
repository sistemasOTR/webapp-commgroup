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

    //PARA TRABAJAR MAS COMODOS EN MODO DESARROLLO
    if(!PRODUCCION)
      $fHOY = "2016-08-12";

  	$arrEstados = $handler->selectGroupServiciosByEstados($fHOY,$fHOY,null,null,null,null,null,null);        
	$allEstados = $handler->selectAllEstados();
?>

<div class="col-md-12 nopadding">
	<div class="box box-solid">
	  	<div class="box-header with-border">
	    	<i class="ion-arrow-graph-up-right"></i>
	    	<h3 class="box-title">Gestiones. <span class='text-yellow'><b><?php echo $dFecha->FormatearFechas($fHOY,'Y-m-d','d/m/Y - h:i'); ?></b></span></h3>
	  	</div>
	  	<div class="box-body no-padding">

  	       	<div class="info-box bg-aqua">
                <span class="info-box-icon"><i class="ion-ios-paperplane"></i></span>

                <div class="info-box-content">
                  	<span class="info-box-text">GESTIONES</span>
                  	<span class="info-box-number" id="widget-estado-total-gestiones"></span>

                  	<div class="progress">
                    	<div class="progress-bar" id="widget-estado-progreso"></div>
                  	</div>
                  	<span class="progress-description">
                    	<span class="pull-right" id="widget-estado-porcentaje-gestionados"></span>
                  	</span>

                </div>
            </div>
          	<div class="col-xs-12 no-padding">
                <ul class="nav nav-stacked">
			        <?php

			        	$sum_total_estados=0; 
			          	$sum_estados_gestionados=0;
			          	$porc_estados_gestionados=0;
			          	
			          	if(!empty($arrEstados))
			          	{                   
			            	foreach ($arrEstados as $key => $value) {
			              		$url_estados = "?view=servicio&fdesde=".$fHOY."&fhasta=".$fHOY."&festado=".$value->SERTT91_ESTADO;

				            	$f_array = new FuncionesArray;
				            	$class_estado = $f_array->buscarValor($allEstados,"1",$value->ESTADOS_DESCCI,"2");

			              		if(!($value->ESTADOS_DESCCI=="Liquidar C. Parcial") || !($value->ESTADOS_DESCCI=="No Efectivas"))
			              		{
			                		echo "                	
				                		<li><a href='".$url_estados."'>".$value->ESTADOS_DESCCI." <span class='pull-right badge ".$class_estado."'>
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

<script type="text/javascript">
	$("#widget-estado-total-gestiones").text("<?php echo $sum_total_estados; ?>");
	$("#widget-estado-porcentaje-gestionados").append("<?php echo round($porc_estados_gestionados,2); ?> % <small>Gestionadas</small>");
	$("#widget-estado-progreso").css( "width", "<?php echo round($porc_estados_gestionados,2); ?>%" )
</script>

	        