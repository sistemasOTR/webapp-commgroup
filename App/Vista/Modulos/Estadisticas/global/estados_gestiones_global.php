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
      $fHOY = "2018-07-11";

  $arrEstados = $handler->selectGroupServiciosByEstados($fHOY,$fHOY,null,null,null,null,null,null);   

	$allEstados = $handler->selectAllEstados();
  $today=$dFecha->FechaActual();
?>

<div class="col-md-12 nopadding">
	<div class="box box-solid">
	  	<div class="box-header with-border">
	    	<i class="ion-arrow-graph-up-right"></i>
	    	<h3 class="box-title">Estados. <span class='text-yellow'><b><?php echo $dFecha->FormatearFechas($fHOY,'Y-m-d','d/m/Y - h:i'); ?></b></span></h3>
	  	</div>
	  		
        <div class="box-body text-center">
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
			                			$dataEstados[] = array('estados' => $value->ESTADOS_DESCCI,
                      							               'EFICIENCIA' => $value->CANTIDAD_SERVICIOS);
                            $est[]=intval($value->SERTT91_ESTADO);
				                		
			              		}
                               
			              		$sum_total_estados = $sum_total_estados + $value->CANTIDAD_SERVICIOS;
			              		if($value->SERTT91_ESTADO>2)
			              			$sum_estados_gestionados=$sum_estados_gestionados+$value->CANTIDAD_SERVICIOS;
			              	
			            	}

			            	if(empty($sum_total_estados))
			            		$porc_estados_gestionados = 0;
			            	else	
			            		$porc_estados_gestionados = ($sum_estados_gestionados / $sum_total_estados) *100;	
			          	
                    

      			        $labels5 = '';
          					$data5 = '' ;

        				    foreach ($dataEstados as $key => $valor) {
        				      $labels5 = $labels5."'".$valor['estados']."', ";
        				      $data5 = $data5.$valor['EFICIENCIA'].", "; 
    
        				    }     
                 } 
                else{
                  echo "Aun No hay datos  cargados";
                } 

			        ?>
               
               <canvas id="budget_estados_chart" class="col-xs-12 chart"></canvas> 
          	</div>
        </div>
    </div>

<script type="text/javascript">
	 var config_est_global = {
    type: 'pie',
    data: {
      labels: [<?php echo $labels5 ?>],
      datasets: [{ 
        label: 'Efectividad',
        data: [<?php echo $data5 ?>],
        fill: false,
        borderColor: 'white',
        backgroundColor:['#2874A6','#229954','#85C1E9','#D2B4DE','#f56954','#C0392B','#B7950B','#979A9A','#A04000','#F1C40F','#D2B4DE']
      }]
    },
    options: {
      responsive: true,
      legend: {display:false},
      title: {
        display: false,
      },
    }
  };

</script>
