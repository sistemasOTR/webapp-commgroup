<?php
    include_once PATH_NEGOCIO."Funciones/Fechas/fechas.class.php"; 
    include_once PATH_NEGOCIO."Sistema/handlersistema.class.php";  
    include_once PATH_NEGOCIO."Sistema/handlersupervisor.class.php";
    include_once PATH_NEGOCIO."Funciones/Array/funcionesarray.class.php"; 
    
    $dFecha = new Fechas;    
    $handler = new HandlerSistema;
    $handler_supervisor = new HandlerSupervisor;    
  
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

    //PARA TRABAJAR MAS COMODOS EN MODO DESARROLLO
    if(!PRODUCCION)
      $fHOY = "2018-07-02";
    /*-------------------------*/
    
    $TotalefectividadMesCursoGestion = 0;
    $TotalcountServiciosTotalGestion = 0;
    $TotalcountServiciosCerradosMesCursoGestion = 0;
    //ESTADO = 300 --> Cerrado Parcial, Re pactado, Re llamar, Cerrado, Negativo (los 5 estados que se toman como operacion en la calle)

    $coordinador = $handler_supervisor->selectPlazasBySupervisorId($user->getUserSistema());

    if(!empty($coordinador))
    {
      foreach ($coordinador as $key => $value) { 

        $countServiciosMesCurso = $handler->selectCountServiciosGestion($fMES,$fHOY,null,null,null,null,$value["alias"],null);  
        $countDiasMesCurso = $handler->selectCountFechasServicios($fMES,$fHOY,null,null,null,null,$value["alias"],null);

        $TotalcountServiciosTotalGestion = $TotalcountServiciosTotalGestion + $countServiciosMesCurso[0]->CANTIDAD_SERVICIOS;

        if(!empty($countDiasMesCurso[0]->CANTIDAD_DIAS))
          $countServiciosTotal = round((intval($countServiciosMesCurso[0]->CANTIDAD_SERVICIOS) / intval($countDiasMesCurso[0]->CANTIDAD_DIAS)),0);
        
        else 
          $countServiciosTotal = round(0,2);
        
        //ESTADO = 200 --> Cerrado, Enviado y Liquidar (los 3 estados que se toman como operacion cerrada)
        $countServiciosCerradosMesCurso = $handler->selectCountServiciosGestion($fMES,$fHOY,200,null,null,null,$value["alias"],null); 
        
        $TotalcountServiciosCerradosMesCursoGestion = $TotalcountServiciosCerradosMesCursoGestion + $countServiciosCerradosMesCurso[0]->CANTIDAD_SERVICIOS;
      }

      if($TotalcountServiciosTotalGestion > 0) {

        $TotalefectividadMesCursoGestion = round(($TotalcountServiciosCerradosMesCursoGestion / $TotalcountServiciosTotalGestion) * 100,2);
      }
      else {

        $TotalefectividadMesCursoGestion = round(0,2);
      }
    }

    $class_semaforo = "bg-red";
    if($TotalefectividadMesCursoGestion>=0 && $TotalefectividadMesCursoGestion<60)
      $class_semaforo = "bg-red";

    if($TotalefectividadMesCursoGestion>=60 && $TotalefectividadMesCursoGestion<70)
      $class_semaforo = "bg-yellow";

    if($TotalefectividadMesCursoGestion>=70 && $TotalefectividadMesCursoGestion<=100)
      $class_semaforo = "bg-green";      
?>

  <div class="col-md-12 nopadding">

    <div class="box box-solid">
      <div class="box-header with-border">
        <h3 class="box-title">
          <i class="ion-arrow-graph-up-right"></i> 
          GESTIÓN. <span class='text-yellow'><b><?php echo strtoupper($nombreMES)." ".$anioMES; ?></b></span>
        </h3>
      </div>

      <div class="box-body no-padding">
        <div class="info-box <?php echo $class_semaforo; ?>">
          <span class="info-box-icon"><i class="ion-arrow-graph-up-right"></i></span>

          <div class="info-box-content">
            <span class="info-box-text">Efectividad</span>
            <span class="info-box-number"><?php echo $TotalefectividadMesCursoGestion."%"; ?></span>

            <div class="progress">
              <div class="progress-bar" style="width: <?php echo $TotalefectividadMesCursoGestion."%"; ?>"></div>
            </div>
            <span class="progress-description">
              <?php echo $TotalcountServiciosTotalGestion; ?> <small>Gestiones</small> 
              <span class="pull-right"><?php echo $TotalcountServiciosCerradosMesCursoGestion; ?> <small>Cerradas</small></span>
            </span>
          </div>

        </div>
      </div>
    </div>
    
  </div>