
<?php
  include_once PATH_NEGOCIO."Funciones/Fechas/fechas.class.php"; 
  include_once PATH_NEGOCIO."Funciones/Array/funcionesarray.class.php"; 
  include_once PATH_NEGOCIO."Modulos/handlerpuntaje.class.php"; 
  include_once PATH_NEGOCIO."Sistema/handlerconsultas.class.php"; 
  include_once PATH_DATOS.'Entidades/ticketsfechasinhabilitadas.class.php'; 

  $user = $usuarioActivoSesion;

  $dFecha = new Fechas;

  /*-------------------------*/
  /* --- gestion de fechas --*/
  $fHOY = $dFecha->FechaActual();
  $fHOY = $dFecha->FormatearFechas($fHOY,"Y-m-d","Y-m-d"); 

  $menos30 = $dFecha->RestarDiasFechaActual(30);
  $menos30 = $dFecha->FormatearFechas($menos30,'Y-m-d','Y-m-d');

  $f = new DateTime();
  $f->modify('last day of this month');
  $fMES = $f->format('Y-m-d');

  $f->modify('first day of this month');
  $menos30 = $f->format('Y-m-d'); 

  setlocale(LC_TIME, 'spanish');  
  $nombreMES = strftime("%B",mktime(0, 0, 0, $f->format('m'), 1, 2000));      
  $anioMES = $f->format('Y'); 
  /*-------------------------*/

  $total_servicios = 0;
  $total_servicios_cerrados = 0;
  $total_efectividad = 0;
  $total_puntajes_cerrados = 0;

  $total_servicios_enviadas = 0;
  $total_puntajes_enviadas = 0;

  $objetivo=0;


  $handler =  new HandlerConsultas;
  $consulta = $handler->consultaPuntajes($menos30,$fHOY, $user->getUserSistema());

  if(!empty($consulta))
  {
    foreach ($consulta as $key => $value) { 

      $handlerP = new HandlerPuntaje;
      $objetivo = $handlerP->buscarObjetivo($user->getUserSistema());                        
      $fechaPuntajeActual = $handlerP->buscarFechaPuntaje();
      $localidad = strtoupper($value->LOCALIDAD);
      $localidad = str_replace('(', '', $localidad);
      $localidad = str_replace(')', '', $localidad);
      if ($value->FECHA->format('d-m-Y')>= $fechaPuntajeActual->format('d-m-Y')) {
        $puntaje = $handlerP->buscarPuntaje($value->COD_EMPRESA);
        if ($value->FECHA->format('d-m-Y') >= date('d-m-Y',strtotime('01-06-2018')) && ($value->COD_EMPRESA == 39 || $value->COD_EMPRESA==41) && $localidad == 'ROSARIO') {
          $puntaje = 2;
        }
      } else {
        $puntaje = $handlerP->buscarPuntajeFecha($value->COD_EMPRESA,$value->FECHA->format('Y-m-d'));
        if ($value->FECHA->format('d-m-Y') >= date('d-m-Y',strtotime('01-06-2018')) && ($value->COD_EMPRESA == 39 || $value->COD_EMPRESA==41) && $localidad == 'ROSARIO') {
          $puntaje = 2;
        }
      }
                
      if(empty($objetivo))                                                  
        $objetivo = 0;

      if (($value->FECHA->format('d-m-Y') >= date('d-m-Y',strtotime('01-06-2018')) && $value->FECHA->format('d-m-Y') <= date('d-m-Y',strtotime('31-06-2018'))) && ($value->COD_EMPRESA == 39 || $value->COD_EMPRESA==41) && $localidad == 'ROSARIO') {

        if(empty($puntaje))
          $puntaje_enviadas = 0;
        else
          $puntaje_enviadas = round($value->TOTAL_SERVICIOS*$puntaje,2);

        $total_puntajes_enviadas = $total_puntajes_enviadas + $puntaje_enviadas;

      }else{
        if(empty($puntaje))
          $puntaje_cerrados = 0;
        else
          $puntaje_cerrados = round($value->CERRADO*$puntaje,2);

        if(empty($puntaje))
          $puntaje_enviadas = 0;
        else
          $puntaje_enviadas = round($value->ENVIADO*$puntaje,2);

        $total_puntajes_cerrados = $total_puntajes_cerrados + $puntaje_cerrados;
        $total_puntajes_enviadas = $total_puntajes_enviadas + $puntaje_enviadas; 
      }

      $total_servicios = $total_servicios + $value->TOTAL_SERVICIOS;
      $total_servicios_cerrados = $total_servicios_cerrados + $value->CERRADO;
      $total_servicios_enviadas = $total_servicios_enviadas + $value->ENVIADO;                      
    }
  }

  $handlerFInhab = new TicketsFechasInhabilitadas;

  // Determinar días laborales
  // ============================
  $diasLaborales = 0;
  while (strtotime($menos30) <= strtotime($fHOY)) {

    $result = $handlerFInhab->selecionarFechasInhabilitadasByFecha($menos30); 
    $estado_result = (!empty($result)?true:false);

    if (date('N',strtotime($menos30)) != 7 && !$estado_result) {
      $diasLaborales += 1;
    }

    $menos30 = date('Y-m-d',strtotime('+1 day',strtotime($menos30)));
  }

  $promPuntos = number_format((($total_puntajes_enviadas + $total_puntajes_cerrados) / $diasLaborales),2);
  $promEnviadas = number_format((($total_servicios_enviadas + $total_servicios_cerrados) / $diasLaborales),2);
  $promServicios = number_format(($total_servicios / $diasLaborales),2);


  // Proy de puntaje
  // ============================

  $fInicio = $fHOY;

  while (strtotime($fInicio) <= strtotime($fMES)) {

    $result = $handlerFInhab->selecionarFechasInhabilitadasByFecha($fInicio); 
    $estado_result = (!empty($result)?true:false);

    if (date('N',strtotime($menos30)) != 7 && !$estado_result) {
      $puntajeMes += $promPuntos;
    }

    $fInicio = date('Y-m-d',strtotime('+1 day',strtotime($fInicio)));
  }
  $aComisionar = 0;
  if($objetivo != 0){
    if ($puntajeMes > $objetivo) {
      $clase_medidor = 'class="text-green"';
      $progressbar = 'progress-bar-green';
      $puntajePorciento = round(($puntajeMes - $objetivo)*100/$objetivo,2);
      $txtPuntajePorciento = round($puntajeMes * 100/$objetivo,2);
      $aComisionar = round(($puntajeMes - $objetivo));
    } elseif(($puntajeMes/$objetivo) >= 0.75) {
      $clase_medidor = 'class="text-yellow"';
      $progressbar = 'progress-bar-yellow';
      $puntajePorciento = round(($puntajeMes) * 100 /$objetivo,2);
      $txtPuntajePorciento = round($puntajeMes * 100/$objetivo,2);
    } else {
      $clase_medidor = 'class="text-red"';
      $progressbar = 'progress-bar-red';
      $puntajePorciento = round(($puntajeMes) * 100 /$objetivo,2);
      $txtPuntajePorciento = round($puntajeMes * 100/$objetivo,2);
    }

  } else {
    $clase_medidor = 'class="text-yellow"';
    $progressbar = 'progress-bar-yellow';
    $puntajePorciento = 50;
    $txtPuntajePorciento = 50.00;
  }


  ?>

        <div class="col-xs-12 no-padding text-center">
          <h3 class="text-gray">PROYECCIÓN</h3>
          <h1 <?php echo $clase_medidor ?>><?php echo $puntajeMes ?> <small>/ <?php echo number_format($objetivo,0,'',''); ?> </small></h1>
          <div class="col-xs-10 col-xs-offset-1">
            <div class="progress progress-xs" style="border-radius: 50px; height: 10px; margin-bottom: 5px;">
              <div class="progress-bar <?php echo $progressbar; ?>" role="progressbar" aria-valuenow="<?php echo $puntajePorciento ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $puntajePorciento; ?>%; background-image: none;">
              </div>
                
            </div>
          </div>
           <h2 <?php echo $clase_medidor ?>><?php echo number_format(($puntajePorciento),2) ?>%</h2>
        </div>
        <div class="col-xs-6 border-right">
          <p class="text-center text-olive">PUNTOS x DÍA<br>
          <span style="font-weight: bold;font-size: 20px"><?php echo $promPuntos; ?></span></p>
        </div>
        <div class="col-xs-6">
          <p class="text-center text-aqua">ENVIADOS x DÍA<br>
          <span style="font-weight: bold;font-size: 20px"><?php echo $promEnviadas; ?></span></p>
        </div>
        <!-- <div class="col-xs-6 col-md-3 border-right">
          <p class="text-center text-blue">TOTAL<br>
          <span style="font-weight: bold;font-size: 20px"><?php echo $total_servicios; ?></span></p>
        </div> -->
        <div class="col-xs-6 border-right">
          <p class="text-navi text-center">SERV. x DÍA<br>
          <span style="font-weight: bold;font-size: 20px"><?php echo $promServicios; ?></span></p>
        </div>
        <div class="col-xs-6">
          <p class="text-center text-green">A COMISIONAR<br>
          <span style="font-weight: bold;font-size: 20px"><?php echo $aComisionar; ?></span></p>
        </div>