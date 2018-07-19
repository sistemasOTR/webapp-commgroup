<?php
    include_once PATH_NEGOCIO."Funciones/Fechas/fechas.class.php"; 
    include_once PATH_NEGOCIO."Sistema/handlersistema.class.php";  
    include_once PATH_NEGOCIO."Sistema/handlersupervisor.class.php";

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

    $plazas = $handlerS->selectPlazasBySupervisorId($user->getUserSistema());

    $cerrados = 0; 
    $despachados = 0;
    
    if(!empty($plazas))
    {
      foreach ($plazas as $key => $valuePlazas) {

        $arrEstados = $handler->selectGroupServiciosByEstados($fHOY,$fHOY,null,null,null,null,$valuePlazas["alias"],null); 

        $cerrados_efec =  $handler->selectCountServicios($fHOY,$fHOY, 6, null, null, null, $valuePlazas["alias"], null);
        $despachados_efec = $handler->selectCountServicios($fHOY,$fHOY, 400, null, null, null, $valuePlazas["alias"], null);  

        if($despachados_efec[0]->CANTIDAD_SERVICIOS>0){        
          $cerrados = $cerrados + $cerrados_efec[0]->CANTIDAD_SERVICIOS;
          $despachados = $despachados + $despachados_efec[0]->CANTIDAD_SERVICIOS;
        }
        else{
          $cerrados = $cerrados + 0;
          $despachados = $despachados + 0;
        }
      }

      if($despachados>0)
        $efectividad_dia = round(($cerrados / $despachados) * 100, 2);
      else
        $efectividad_dia = 0;

      $class_semaforo = "bg-red";
      if($efectividad_dia>=0 && $efectividad_dia<60)
        $class_semaforo = "bg-red";

      if($efectividad_dia>=60 && $efectividad_dia<70)
        $class_semaforo = "bg-yellow";

      if($efectividad_dia>=70 && $efectividad_dia<=100)
        $class_semaforo = "bg-green";   
    }
?>

<div class="col-md-12 nopadding">
  <div class="box box-solid">
    
    <div class="box-header with-border">
      <h3 class="box-title"><i class="ion-arrow-graph-up-right"> </i> Efectividad de cierre.</h3>
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
    </div>
   
  </div>
</div>