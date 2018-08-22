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
    $fHOY = '2018-07-11';
    

    $cerrados_efec =  $handler->selectCountServicios($fHOY,$fHOY, 6, $user->getUserSistema(), null, null, null, null);
    $despachados_efec = $handler->selectCountServicios($fHOY,$fHOY, 400, $user->getUserSistema(), null, null, null, null);
    //$total_efec = $handler->selectCountServicios($fHOY,$fHOY, null, $user->getUserSistema(), null, null, null, null);    

    if($despachados_efec[0]->CANTIDAD_SERVICIOS>0){        
      $efectividad_dia = 100 * $cerrados_efec[0]->CANTIDAD_SERVICIOS / $despachados_efec[0]->CANTIDAD_SERVICIOS;
    }
    else{
      $efectividad_dia = 0;
    }

    $arrEstados = $handler->selectServiciosByEstados($fHOY,$fHOY, null, $user->getUserSistema(), null, null, null, null, null);

    $class_semaforo = "bg-red";
    if($efectividad_dia>=0 && $efectividad_dia<60)
      $class_semaforo = "bg-red";

    if($efectividad_dia>=60 && $efectividad_dia<70)
      $class_semaforo = "bg-yellow";

    if($efectividad_dia>=70 && $efectividad_dia<=100)
      $class_semaforo = "bg-green";

      if(!empty($arrEstados)){       
?>

<div class="col-xs-12">
  <div class="box box-solid">
    
    <div class="box-header">
      <h3 class="box-title">
        <i class="ion-speedometer"> </i> Performance general
      </h3>
    </div>

    <div class="box-body no-padding">

      <div class="info-box <?php echo $class_semaforo; ?>">
        <span class="info-box-icon"><i class="fa fa-percent"></i></span>

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
    </div>
   
  </div>
</div>
<?php } ?>