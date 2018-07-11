<?php
    include_once PATH_NEGOCIO."Funciones/Fechas/fechas.class.php"; 
    include_once PATH_NEGOCIO."Sistema/handlersistema.class.php";  
    include_once PATH_NEGOCIO."Modulos/handlerpuntaje.class.php";
    include_once PATH_NEGOCIO."Sistema/handlerconsultas.class.php"; 
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

  //GESTIONES DIARIAS
    $arrEstados = $handler->selectGroupServiciosByEstados($fHOY,$fHOY,null,null,null,null,$value->PLAZA,null);        
    $allEstados = $handler->selectAllEstados();  

    $sum_total_estados=0; 
    $sum_estados_gestionados=0;
    $porc_estados_gestionados=0;

    if(!empty($arrEstados))
    {                   
      foreach ($arrEstados as $key => $value_estados) {

        $f_array = new FuncionesArray;
        $class_estado = $f_array->buscarValor($allEstados,"1",$value_estados->ESTADOS_DESCCI,"2");

        // totales
        $sum_total_estados = $sum_total_estados + $value_estados->CANTIDAD_SERVICIOS;
        if($value_estados->SERTT91_ESTADO>2)
          $sum_estados_gestionados=$sum_estados_gestionados+$value_estados->CANTIDAD_SERVICIOS;
      }

      if(empty($sum_total_estados))
        $porc_estados_gestionados = 0;
      else  
        $porc_estados_gestionados = ($sum_estados_gestionados / $sum_total_estados) *100;
    }    
  // FIN GESTIONES DIARIAS

  // SERVICIOS DIARIOS
    $cerrados_efec =  $handler->selectCountServicios($fHOY,$fHOY, 6, null, null, null, $value->PLAZA, null);
    $despachados_efec = $handler->selectCountServicios($fHOY,$fHOY, 400, null, null, null, $value->PLAZA, null);  

    if($despachados_efec[0]->CANTIDAD_SERVICIOS>0){        
      $efectividad_dia = 100 * $cerrados_efec[0]->CANTIDAD_SERVICIOS / $despachados_efec[0]->CANTIDAD_SERVICIOS;
    }
    else{
      $efectividad_dia = 0;
    }

    $class_semaforo_efectividad_dia = "bg-red";
    if($efectividad_dia>=0 && $efectividad_dia<60)
      $class_semaforo_efectividad_dia = "bg-red";

    if($efectividad_dia>=60 && $efectividad_dia<70)
      $class_semaforo_efectividad_dia = "bg-yellow";

    if($efectividad_dia>=70 && $efectividad_dia<=100)
      $class_semaforo_efectividad_dia = "bg-green";
  // FIN SERVICIOS DIARIOS

  //EFECTIVIDAD MENSUAL
    $countServiciosMesCurso = $handler->selectCountServicios($fMES,$fHOY,null,null,null,null,$value->PLAZA,null);  
    $countDiasMesCurso = $handler->selectCountFechasServicios($fMES,$fHOY,null,null,null,null,$value->PLAZA,null);

    if(!empty($countDiasMesCurso[0]->CANTIDAD_DIAS))
      $countServiciosTotal = round((intval($countServiciosMesCurso[0]->CANTIDAD_SERVICIOS) / intval($countDiasMesCurso[0]->CANTIDAD_DIAS)),0);  
    else    
      $countServiciosTotal = round(0,2);
    
    $countServiciosCerradosMesCurso = $handler->selectCountServicios($fMES,$fHOY,200,null,null,null,$value->PLAZA,null);

    if(!empty($countServiciosMesCurso[0]->CANTIDAD_SERVICIOS))    
      $efectividadMesCurso = round(($countServiciosCerradosMesCurso[0]->CANTIDAD_SERVICIOS) / intval(intval($countServiciosMesCurso[0]->CANTIDAD_SERVICIOS))*100,2); 
    else
      $efectividadMesCurso = round(0,2); 

    $class_semaforo = "bg-red";
    if($efectividadMesCurso>=0 && $efectividadMesCurso<60)
      $class_semaforo = "bg-red";

    if($efectividadMesCurso>=60 && $efectividadMesCurso<70)
      $class_semaforo = "bg-yellow";

    if($efectividadMesCurso>=70 && $efectividadMesCurso<=100)
      $class_semaforo = "bg-green";   
  //FIN EFECTIVIDAD MENSUAL

  //PUNTAJE MENSUAL
    $total_servicios = 0;
    $total_servicios_cerrados = 0;
    $total_efectividad = 0;
    $total_puntajes_cerrados = 0;

    $total_servicios_enviadas = 0;
    $total_puntajes_enviadas = 0;

    $objetivo=0;

    $handler =  new HandlerConsultas;
    $consulta = $handler->consultaPuntajesCoordinador($fMES,$fHOY,$value->PLAZA);

    if(!empty($consulta))
    {
      foreach ($consulta as $key => $value_puntaje) { 

        $handlerP = new HandlerPuntaje;
        $objetivo = $handlerP->buscarObjetivoCoordinador($value->PLAZA);
        $fechaPuntajeActual = $handlerP->buscarFechaPuntaje();
        if ($value_puntaje->FECHA->format('d-m-Y')>= $fechaPuntajeActual->format('d-m-Y')) {
          $puntaje = $handlerP->buscarPuntaje($value_puntaje->COD_EMPRESA);
        } else {
          $puntaje = $handlerP->buscarPuntajeFecha($value_puntaje->COD_EMPRESA,$value_puntaje->FECHA->format('Y-m-d'));
        }

        if(empty($objetivo))                                                  
          $objetivo = 0;

        if(empty($puntaje))
          $puntaje_cerrados = 0;
        else
          $puntaje_cerrados = round($value_puntaje->CERRADO*$puntaje,2);

        if(empty($puntaje))
          $puntaje_enviadas = 0;
        else
          $puntaje_enviadas = round($value_puntaje->ENVIADO*$puntaje,2);                        

        if(!empty($value_puntaje->TOTAL_SERVICIOS))
          $efectividad = round($value_puntaje->CERRADO/$value_puntaje->TOTAL_SERVICIOS,2) * 100;
        else
          $efectividad = 0;
        

        $total_servicios = $total_servicios + $value_puntaje->TOTAL_SERVICIOS;
        $total_servicios_cerrados = $total_servicios_cerrados + $value_puntaje->CERRADO;
        $total_puntajes_cerrados = $total_puntajes_cerrados + $puntaje_cerrados;                        

        $total_servicios_enviadas = $total_servicios_enviadas + $value_puntaje->ENVIADO;
        $total_puntajes_enviadas = $total_puntajes_enviadas + $puntaje_enviadas;                        
      }
    }

    if($objetivo != 0){
      if ($total_puntajes_enviadas > $objetivo) {
        $clase_medidor = 'class="info-box bg-green"';
        $puntajePorciento = round(($total_puntajes_enviadas - $objetivo)*100/$objetivo,2);
        $txtPuntajePorciento = round($total_puntajes_enviadas * 100/$objetivo,2);
      } else {
        $clase_medidor = 'class="info-box bg-yellow"';
        $puntajePorciento = round(($total_puntajes_enviadas) * 100 /$objetivo,2);
        $txtPuntajePorciento = round($total_puntajes_enviadas * 100/$objetivo,2);
      }

    } else {
      $clase_medidor = 'class="info-box bg-yellow"';
      $puntajePorciento = 50;
      $txtPuntajePorciento = 50.00;
    }

    if(!empty($total_servicios)){
      $total_efectividad = round(($total_servicios_enviadas+$total_servicios_cerrados)*100/$total_servicios,2) ;
      if ($total_efectividad > 70) {
        $clase_efectividad = 'class="text-center text-green"';
      } else if($total_efectividad < 60){
        $clase_efectividad = 'class="text-center text-red"';
      } else {
        $clase_efectividad = 'class="text-center text-yellow"';
      }
     } else {
      $total_efectividad = 0;
      $clase_efectividad = 'class="text-center text-red"';
    }  
  //FIN PUNTAJE MENSUAL   
?>

<div class="box box-solid">
  <div class="box-header with-border"><h3 class="box-title"><i class="ion-arrow-graph-up-right"> </i> <?php echo $value->PLAZA ?></h3></div>
  <div class="box-body">
    <h4>DIARIO</h4>
    <div class="info-box bg-aqua">
      <span class="info-box-icon"><i class="ion-ios-paperplane"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">GESTIONES</span>
        <span class="info-box-number"><?php echo round($porc_estados_gestionados,2)."%"; ?></span>

        <div class="progress">
          <div class="progress-bar" style="width: <?php echo round($porc_estados_gestionados,2)."%"; ?>"></div>
        </div>
        <span class="progress-description">
          <span class="pull-right"><?php echo $sum_estados_gestionados; ?><small> Gestionadas</small></span>
        </span>

      </div>
    </div>

    <div class="info-box <?php echo $class_semaforo_efectividad_dia; ?>">
      <span class="info-box-icon"><i class="ion-ios-paperplane"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">EFECTIVIDAD</span>
        <span class="info-box-number"><?php echo round($efectividad_dia,2); ?>%</span>

        <div class="progress">
          <div class="progress-bar" style="width: <?php echo round($efectividad_dia,2); ?>%"></div>
        </div>
        <span class="progress-description">
          <?php echo $cerrados_efec[0]->CANTIDAD_SERVICIOS; ?> <small>Cerrados</small><span class="pull-right"><?php echo $despachados_efec[0]->CANTIDAD_SERVICIOS; ?> <small>Servicios</small> </span>
        </span>
      </div>
    </div>

    <h4>MENSUAL</h4>

    <div class="info-box <?php echo $class_semaforo; ?>">
      <span class="info-box-icon"><i class="ion-arrow-graph-up-right"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">Efectividad</span>
        <span class="info-box-number"><?php echo $efectividadMesCurso."%"; ?></span>

        <div class="progress">
          <div class="progress-bar" style="width: <?php echo $efectividadMesCurso."%"; ?>"></div>
        </div>
          <span class="progress-description">
            <?php echo $countServiciosMesCurso[0]->CANTIDAD_SERVICIOS; ?> <small>Servicios</small> 
            <span class="pull-right"><?php echo $countServiciosCerradosMesCurso[0]->CANTIDAD_SERVICIOS; ?> <small>Cerrados</small></span>
          </span>
      </div>
    </div>

    <div <?php echo $clase_medidor; ?>>
      <span class="info-box-icon"><i class="ion-calculator"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">PUNTAJE</span>
        <span class="info-box-number"><?php echo $txtPuntajePorciento."%"; ?></span>

        <div class="progress">
          <div class="progress-bar" style="width: <?php echo $puntajePorciento ?>%"></div>
        </div>
        <span class="progress-description">
          <small>Enviados: </small><?php echo $total_puntajes_enviadas ?> <span class="pull-right"><small>Objetivo: </small><?php echo $objetivo; ?></span>
        </span>
      </div>
    </div>
  </div>
</div>