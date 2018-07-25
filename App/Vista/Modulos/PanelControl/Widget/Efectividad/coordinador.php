<?php
  	include_once PATH_NEGOCIO."Funciones/Fechas/fechas.class.php"; 
  	include_once PATH_NEGOCIO."Sistema/handlersistema.class.php";  

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


    $cerrados_efec =  $handler->selectCountServicios($fHOY,$fHOY, 6, null, null, null, $user->getAliasUserSistema(), null);
    $despachados_efec = $handler->selectCountServicios($fHOY,$fHOY, 400, null, null, null, $user->getAliasUserSistema(), null);
    //$total_efec = $handler->selectCountServicios($fHOY,$fHOY, null, null, null, null, $user->getAliasUserSistema(), null);        

    if($despachados_efec[0]->CANTIDAD_SERVICIOS>0){        
      $efectividad_dia = 100 * $cerrados_efec[0]->CANTIDAD_SERVICIOS / $despachados_efec[0]->CANTIDAD_SERVICIOS;
    }
    else{
      $efectividad_dia = 0;
    }

    $arrGestores = $handler->selectServiciosByGestor($fHOY,$fHOY, 400, null, null, null, $user->getAliasUserSistema(), null);

    $class_semaforo = "bg-red";
    if($efectividad_dia>=0 && $efectividad_dia<60)
      $class_semaforo = "bg-red";

    if($efectividad_dia>=60 && $efectividad_dia<70)
      $class_semaforo = "bg-yellow";

    if($efectividad_dia>=70 && $efectividad_dia<=100)
      $class_semaforo = "bg-green";          


?>

<div class="col-md-12 nopadding">
	<div class="box box-solid">
    
    <div class="box-header">
      <h3 class="box-title">
        <i class="ion-speedometer"> </i> Performance
        <span class='text-yellow'><b><?php echo $dFecha->FormatearFechas($fHOY,'Y-m-d','d/m/Y  - h:i'); ?></b></span>
      </h3>
    </div>

    <div class="box-body no-padding">

      <div class="info-box <?php echo $class_semaforo; ?>">
        <span class="info-box-icon"><i class="ion-arrow-graph-up-right"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">Efectividad</span>
          <span class="info-box-number"><?php echo round($efectividad_dia,2); ?>%</span>

          <div class="progress">
            <div class="progress-bar" style="width: <?php echo round($efectividad_dia,2); ?>%"></div>
          </div>
          <span class="progress-description">

          </span>

        </div>

      </div>

      <div class="col-xs-12 no-padding">
        <ul class="nav nav-stacked">
          <?php 
            if( !empty($arrGestores)) {

              foreach ($arrGestores as $key => $value) {
    
                if($value->DESPACHADO>0){        
                  $efec_gestor = 100 * $value->CERRADO / $value->DESPACHADO;
                }
                else{
                  $efec_gestor = 0;
                }                

              $class_semaforo_gestor = "bg-red";
              if($efec_gestor>=0 && $efec_gestor<60)
                $class_semaforo_gestor = "bg-red";

              if($efec_gestor>=60 && $efec_gestor<70)
                $class_semaforo_gestor = "bg-yellow";

              if($efec_gestor>=70 && $efec_gestor<=100)
                $class_semaforo_gestor = "bg-green";      

              $url_detalle = "?view=servicio&fdesde=".$fHOY."&fhasta=".$fHOY."&fgestor=".$value->CODGESTOR;

                echo "<li><a href='".$url_detalle."'>".$value->NOMGESTOR." <span class='pull-right badge ".$class_semaforo_gestor."'>".round($efec_gestor,2)."%</span></a></li>";
              }                    

            }
          ?>
        </ul>
      </div>
    </div>
	 
	</div>
</div>