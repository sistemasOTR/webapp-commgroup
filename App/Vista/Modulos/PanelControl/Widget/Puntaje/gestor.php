
<?php
  include_once PATH_NEGOCIO."Funciones/Fechas/fechas.class.php"; 
  include_once PATH_NEGOCIO."Funciones/Array/funcionesarray.class.php"; 
  include_once PATH_NEGOCIO."Modulos/handlerpuntaje.class.php"; 
  include_once PATH_NEGOCIO."Sistema/handlerconsultas.class.php"; 

  $user = $usuarioActivoSesion;

  $dFecha = new Fechas;

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

  $total_servicios = 0;
  $total_servicios_cerrados = 0;
  $total_efectividad = 0;
  $total_puntajes_cerrados = 0;

  $total_servicios_enviadas = 0;
  $total_puntajes_enviadas = 0;

  $objetivo=0;


  $handler =  new HandlerConsultas;
  $consulta = $handler->consultaPuntajes($fMES,$fHOY, $user->getUserSistema());

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

  if($objetivo != 0){
    if ($total_puntajes_enviadas > $objetivo) {
      $clase_medidor = 'class="text-green"';
      $progressbar = 'progress-bar-green';
      $puntajePorciento = round(($total_puntajes_enviadas - $objetivo)*100/$objetivo,2);
      $txtPuntajePorciento = round($total_puntajes_enviadas * 100/$objetivo,2);
    } elseif(($total_puntajes_enviadas/$objetivo) >= 0.75) {
      $clase_medidor = 'class="text-yellow"';
      $progressbar = 'progress-bar-yellow';
      $puntajePorciento = round(($total_puntajes_enviadas) * 100 /$objetivo,2);
      $txtPuntajePorciento = round($total_puntajes_enviadas * 100/$objetivo,2);
    } else {
      $clase_medidor = 'class="text-red"';
      $progressbar = 'progress-bar-red';
      $puntajePorciento = round(($total_puntajes_enviadas) * 100 /$objetivo,2);
      $txtPuntajePorciento = round($total_puntajes_enviadas * 100/$objetivo,2);
    }

  } else {
    $clase_medidor = 'class="text-yellow"';
    $progressbar = 'progress-bar-yellow';
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
  
?>

  <a href="index.php?view=puntajes_gestor"><div class="box box-solid">    
    <div class="box-header with-border">
        <h3 class="box-title"><i class="ion-calculator"></i> PUNTAJE. <span class="text-yellow"><b><?php echo strtoupper($nombreMES) ?> <?php echo $anioMES ?></b></span></h3>
    </div>    
    <div class="box-body no-padding">
      <div class="col-md-6 no-padding border-right">
        <div class="col-xs-12 no-padding text-center">
          <h3 class="text-gray">PUNTAJE</h3>
          <h1 <?php echo $clase_medidor ?>><?php echo $total_puntajes_enviadas ?> <small>/ <?php echo number_format($objetivo,0,'',''); ?> </small></h1>
          <div class="col-xs-10 col-xs-offset-1">
            <div class="progress progress-xs" style="border-radius: 50px; height: 10px; margin-bottom: 5px;">
              <div class="progress-bar <?php echo $progressbar; ?>" role="progressbar" aria-valuenow="<?php echo $puntajePorciento ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $puntajePorciento; ?>%; background-image: none;">
              </div>
                
            </div>
          </div>
           <h2 <?php echo $clase_medidor ?>><?php echo number_format(($puntajePorciento),2) ?>%</h2>
        </div>
          <div class="col-xs-6 border-right">
            <p class="text-center text-olive">CERRADOS<br>
            <span style="font-weight: bold;font-size: 20px"><?php echo $total_servicios_cerrados; ?></span></p>
          </div>
          <div class="col-xs-6">
            <p class="text-center text-aqua">ENVIADOS<br>
            <span style="font-weight: bold;font-size: 20px"><?php echo $total_servicios_enviadas; ?></span></p>
          </div>
          <div class="col-xs-6 border-right">
            <p class="text-center text-blue">TOTAL<br>
            <span style="font-weight: bold;font-size: 20px"><?php echo $total_servicios; ?></span></p>
          </div>
          <div class="col-xs-6">
            <p <?php echo $clase_efectividad; ?>>EFECTIVIDAD<br>
            <span style="font-weight: bold;font-size: 20px"><?php echo $total_efectividad; ?>%</span></p>
          </div> 
      </div>
      <div class="col-md-6 no-padding">
        <?php $puntajeMes = $total_puntajes_enviadas + $total_puntajes_cerrados; ?>
            <?php include_once PATH_VISTA."Modulos/PanelControl/Widget/Puntaje/gestor_proy.php"; ?>

      </div>
      </div>
    </div>
    </a>
    