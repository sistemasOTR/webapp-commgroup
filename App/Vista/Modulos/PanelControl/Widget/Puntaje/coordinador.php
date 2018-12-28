
<?php
  include_once PATH_NEGOCIO."Funciones/Fechas/fechas.class.php"; 
  include_once PATH_NEGOCIO."Funciones/Array/funcionesarray.class.php"; 
  include_once PATH_NEGOCIO."Modulos/handlerpuntaje.class.php"; 
  include_once PATH_NEGOCIO."Sistema/handlerconsultas.class.php"; 
  include_once PATH_NEGOCIO."Sistema/handlersistema.class.php"; 
  include_once PATH_NEGOCIO."Modulos/handlerobjetivos.class.php";
  include_once PATH_NEGOCIO."Modulos/handlerlegajos.class.php";
  include_once PATH_NEGOCIO."Usuarios/handlerusuarios.class.php";
  include_once PATH_NEGOCIO."Usuarios/handlerplazausuarios.class.php";
  include_once PATH_DATOS.'Entidades/ticketsfechasinhabilitadas.class.php'; 


  $user = $usuarioActivoSesion;
  $view_detalle= "index.php?view=puntajes_coordinador_detalle";

  $dFecha = new Fechas;

  /*-------------------------*/
  /* --- gestion de fechas --*/
  $fHOY = $dFecha->FechaActual();
  $fHOY = $dFecha->FormatearFechas($fHOY,"Y-m-d","Y-m-d"); 

  $f = new DateTime();
  $f->modify('first day of this month');
  $fMES = $f->format('Y-m-d'); 
  $fInicioMes = $f->format('Y-m-d');
  $f->modify('last day of this month');
  $fFinMes = $f->format('Y-m-d');  

  setlocale(LC_TIME, 'spanish');  
  $nombreMES = strftime("%B",mktime(0, 0, 0, $f->format('m'), 1, 2000));      
  $anioMES = $f->format('Y'); 
  /*-------------------------*/

  //PARA TRABAJAR MAS COMODOS EN MODO DESARROLLO
  if(!PRODUCCION)
    $fHOY = "2018-12-03";


  $total_servicios = 0;
  $total_servicios_cerrados = 0;
  $total_efectividad = 0;
  $total_puntajes_cerrados = 0;

  $total_servicios_enviadas = 0;
  $total_puntajes_enviadas = 0;

  $objetivo=0;


  // Definicion Handlers
  // ============================
  $handlerObj = new HandlerObjetivos;
  $handlerSist = new HandlerSistema;
  $handlerLegajos = new HandlerLegajos;
  $handlerFInhab = new TicketsFechasInhabilitadas;
  $handler =  new HandlerConsultas;
  $handlerP = new HandlerPuntaje;
  $handlerPlazas = new HandlerPlazaUsuarios;
  $handlerUsuario = new HandlerUsuarios;
  // ============================


  $consulta = $handler->consultaPuntajesCoordinador($fMES,$fHOY, $user->getAliasUserSistema());

  $gestoresPlaza = $handlerSist->selectGestoresByPlaza($user->getAliasUserSistema());
  // var_dump($gestoresPlaza);
  // exit();
  if(!empty($consulta))
  {
    $gestPlaza = '';
    $nomGestores = '';
    foreach ($consulta as $key => $value) { 
      if ($gestPlaza == '') {
        $gestPlaza[] = $value->COD_GESTOR;
        $nomGestores[$value->COD_GESTOR] = $value->NOM_GESTOR;
      }
      if (!in_array($value->COD_GESTOR, $gestPlaza)) {
        $gestPlaza[] = $value->COD_GESTOR;
        $nomGestores[$value->COD_GESTOR] = $value->NOM_GESTOR;
      }
    }
  }

  var_dump($gestPlaza);
  exit();

  // Determinar días laborales
  // ============================
  $laborales = 0;
  while (strtotime($fInicioMes) <= strtotime($fFinMes)) {

    $result = $handlerFInhab->selecionarFechasInhabilitadasByFecha($fInicioMes); 
    // var_dump($result);

    $estado_result = (!empty($result)?true:false);

    if (date('N',strtotime($fInicioMes)) != 7 && !$estado_result) {
      if (date('N',strtotime($fInicioMes)) != 6) {
        $laborales += 1;
      } else {
        $laborales += 0.5;
      }
    }

    $fInicioMes = date('Y-m-d',strtotime('+1 day',strtotime($fInicioMes)));
  }
  // ============================


  // Gestores / Coordinadores
  // ============================

  $gestCoor = $handlerObj->allGestCoor();
  foreach ($gestCoor as $key => $value) {
    $gc[] = intval($value->getIdGestor());
  }
  // ============================


  // Id PLAZA
  // ============================

  $allPlazas = $handlerPlazas->selectTodas();
  if (!empty($allPlazas)) {
    foreach ($allPlazas as $plaza) {
      if ($plaza->getNombre() == $user->getAliasUserSistema()) {
        $idPlaza = $plaza->getId();
      }
    }
  }
  // ============================

  // Usuarios Gestores
  // ============================
  $allUsuarios = $handlerUsuario->selectAll();
  $gestActivosPlaza = '';
  foreach ($allUsuarios as $ind => $usuario) {
    $tipoUsuario = $usuario->getTipoUsuario();
    if (is_array($tipoUsuario)) {
      $tipoUsuario = 0;
    }else{
      $tipoUsuario = $tipoUsuario->getId();
    }

    if ($tipoUsuario == 3 && $usuario->getUserPlaza() == $idPlaza) {
      $gestActivosPlaza[] = array('idGestor' => $usuario->getUserSistema(),
                                  'idUser' => $usuario->getId());
    }
  }
  // ============================


  // Objetivos de la plaza
  // ============================
  $objetivosXPlaza = $handlerObj->objetivosXPlaza($user->getAliasUserSistema());
  if (!empty($objetivosXPlaza)) {
    foreach ($objetivosXPlaza as $key => $value) {
      if ($fHOY >= $value->getVigencia()->format('Y-m-d')) {
          $objetivoBase = $value->getBasico();
          $objetivoGC = $value->getBasicoGC();
          break;
        
      }
    }
  }

  // Gestores según fechas trabajadas
  // ============================

  $arrGests = '';
  foreach ($gestoresPlaza as $idG => $gestorTT) {
    foreach ($gestActivosPlaza as $idG2 => $gestPortal) {
      if ($gestorTT->GESTOR11_CODIGO == $gestPortal['idGestor']) {
        $legajo = $handlerLegajos->seleccionarLegajos($gestPortal['idUser']);
        if (!is_null($legajo)) {
          if ($legajo->getFechaBaja()->format('Y-m-d') != '1900-01-01' && $legajo->getFechaBaja()->format('Y-m-d') < $fMES) {
            unset($gestoresPlaza[$idG]);
          } elseif ($legajo->getFechaBaja()->format('Y-m-d') != '1900-01-01' && $legajo->getFechaBaja()->format('Y-m-d') > $fMES) {
            $trabajo = 0;
            if ($legajo->getFechaIngreso()->format('Y-m-d') > $fMES) {
              $fInicioMes = $legajo->getFechaIngreso()->format('Y-m-d');
            } else {
              $fInicioMes= $fMES;
            }
            while (strtotime($fInicioMes) <= strtotime($legajo->getFechaBaja()->format('Y-m-d'))) {

              $result = $handlerFInhab->selecionarFechasInhabilitadasByFecha($fInicioMes); 

              $estado_result = (!empty($result)?true:false);

              if (date('N',strtotime($fInicioMes)) != 7 && !$estado_result) {
                if (date('N',strtotime($fInicioMes)) != 6) {
                  $trabajo += 1;
                } else {
                  $trabajo += 0.5;
                }
              }

              $fInicioMes = date('Y-m-d',strtotime('+1 day',strtotime($fInicioMes)));
            }

            $relativo = $trabajo/$laborales;
            $arrGests[] = array('cod' => $gestorTT->GESTOR11_CODIGO,
                              'nombre' => $gestorTT->GESTOR21_ALIAS,
                              'rel' => $relativo );
          } elseif ($legajo->getFechaIngreso()->format('Y-m-d') > $fMES){
            $trabajo = 0;
            $fInicioMes= $legajo->getFechaIngreso()->format('Y-m-d');
            while (strtotime($fInicioMes) <= strtotime($fFinMes)) {

              $result = $handlerFInhab->selecionarFechasInhabilitadasByFecha($fInicioMes); 
              // var_dump($result);

              $estado_result = (!empty($result)?true:false);

              if (date('N',strtotime($fInicioMes)) != 7 && !$estado_result) {
                if (date('N',strtotime($fInicioMes)) != 6) {
                  $trabajo += 1;
                } else {
                  $trabajo += 0.5;
                }
              }

              $fInicioMes = date('Y-m-d',strtotime('+1 day',strtotime($fInicioMes)));
            }
            
            $relativo = $trabajo/$laborales;
            $arrGests[] = array('cod' => $gestorTT->GESTOR11_CODIGO,
                              'nombre' => $gestorTT->GESTOR21_ALIAS,
                              'rel' => $relativo );
          } else {
            $arrGests[] = array('cod' => $gestorTT->GESTOR11_CODIGO,
                              'nombre' => $gestorTT->GESTOR21_ALIAS,
                              'rel' => 1 );
          }
        }


      }
    }
  }

  foreach ($arrGests as $indice => $valor) {
    // echo $valor->GESTOR21_ALIAS;
    if (!in_array($valor['cod'],$gc)) {
      $objetivo += $objetivoBase * $valor['rel'];
    } else {
      $objetivo += $objetivoGC* $valor['rel'];
    }
    
  }
  
  if(!empty($consulta))
  {
    foreach ($consulta as $key => $value) { 

      
      // $objetivo = $handlerP->buscarObjetivoCoordinador($value->NOM_COORDINADOR);
      
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

  <div class="box box-solid">
    <div class="box-header with-border">
      <h3 class="box-title" style="text-transform: uppercase;"><?php echo $nombreMES ?> <?php echo $anioMES ?></h3>
      <a class="text-navy pull-right" href="<?php echo $view_detalle."&fdesde=".$fdesde."&fhasta=".$fhasta; ?>"><i class="fa fa-search"></i></a>
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
            <?php include_once PATH_VISTA."Modulos/PanelControl/Widget/Puntaje/coordinador_proy.php"; ?>

      </div>
      </div>
    </div>