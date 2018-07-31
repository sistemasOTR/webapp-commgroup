<?php
  include_once PATH_NEGOCIO."Sistema/handlerconsultas.class.php";  
  include_once PATH_NEGOCIO."Sistema/handlersistema.class.php";  
  include_once PATH_NEGOCIO."Funciones/Fechas/fechas.class.php"; 
  include_once PATH_NEGOCIO."Funciones/Array/funcionesarray.class.php"; 

  include_once PATH_NEGOCIO."Modulos/handlerpuntaje.class.php"; 
  
  $user = $usuarioActivoSesion;
  
  $dFecha = new Fechas;

  $handler = new HandlerSistema;

  $fdesde = (isset($_GET["fdesde"])?$_GET["fdesde"]:$dFecha->FechaActual());
  $fhasta = (isset($_GET["fhasta"])?$_GET["fhasta"]:$dFecha->FechaActual());      
  $fcoordinador = (isset($_GET["fcoordinador"])?$_GET["fcoordinador"]:'');      
  // $fcoordinador= $user->getAliasUserSistema();
  $arrGestor = $handler->selectAllGestor($fcoordinador);

  $handler =  new HandlerConsultas;
  $consulta = $handler->consultaPuntajesCoordinador($fdesde, $fhasta, $fcoordinador);
  $url_detalle_xgestor = "index.php?view=puntajes_general_xgestor&fgestor=";
?>

<div class="content-wrapper">  
  <section class="content-header">
    <h1>
      Puntajes
      <small>Detalle del puntaje</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
      <li class="active">Puntajes</li>
    </ol>
  </section>        
  
  <section class="content">

    <?php include_once PATH_VISTA."error.php"; ?>
    <?php include_once PATH_VISTA."info.php"; ?>

    <div class="row">
      <div class="col-md-12">
        <?php
          foreach ($arrGestor as $key => $gestor) {
            $total_servicios = 0;
            $total_servicios_cerrados = 0;
            $total_efectividad = 0;
            $total_puntajes_cerrados = 0;

            $total_servicios_enviadas = 0;
            $total_puntajes_enviadas = 0;

            $objetivo=0;
            $consulta = $handler->consultaPuntajes($fdesde, $fhasta, $gestor->GESTOR11_CODIGO);

            if(!empty($consulta))
            {
              foreach ($consulta as $key => $value) { 

                $handlerP = new HandlerPuntaje;
                $objetivo = $handlerP->buscarObjetivo($value->COD_GESTOR);                        
                $fechaPuntajeActual = $handlerP->buscarFechaPuntaje();
                if ($value->FECHA->format('d-m-Y')>= $fechaPuntajeActual->format('d-m-Y')) {
                  $puntaje = $handlerP->buscarPuntaje($value->COD_EMPRESA);
                  if ($value->FECHA->format('d-m-Y') >= date('d-m-Y',strtotime('01-06-2018')) && ($value->COD_EMPRESA == 39 || $value->COD_EMPRESA==41) && $value->CP_GEST == '2000') {
                    $puntaje = 2;
                  }
                } else {
                  $puntaje = $handlerP->buscarPuntajeFecha($value->COD_EMPRESA,$value->FECHA->format('Y-m-d'));
                  if ($value->FECHA->format('d-m-Y') >= date('d-m-Y',strtotime('01-06-2018')) && ($value->COD_EMPRESA == 39 || $value->COD_EMPRESA==41) && $value->CP_GEST == '2000') {
                    $puntaje = 2;
                  }
                }
                
                if(empty($objetivo))                                                  
                  $objetivo = 0;

                if (($value->FECHA->format('d-m-Y') >= date('d-m-Y',strtotime('01-06-2018')) && $value->FECHA->format('d-m-Y') <= date('d-m-Y',strtotime('31-06-2018'))) && ($value->COD_EMPRESA == 39 || $value->COD_EMPRESA==41) && $value->CP_GEST == '2000') {

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
                  $txtPuntajePorciento = 50;
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
            if(!empty($consulta)){
        ?>
        <div class="col-sm-6 col-md-4">
            <div class="box box-solid">
              <div class="box-header with-border">
                <h3 class="box-title" style="text-transform: uppercase;"><?php echo $gestor->GESTOR21_ALIAS ?></h3>
                <a class="text-navy pull-right" href="<?php echo $url_detalle_xgestor.$gestor->GESTOR11_CODIGO."&fnomgestor=".$gestor->GESTOR21_ALIAS."&fdesde=".$fdesde."&fhasta=".$fhasta; ?>"><i class="fa fa-search"></i></a>
              </div>    
              <div class="box-body">

                <div class="col-xs-12 no-padding">
                <div <?php echo $clase_medidor; ?>>
                      <span class="info-box-icon"><i class="ion-calculator"></i></span>
                      <div class="info-box-content">
                        <span class="info-box-text">Objetivo</span>
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
                <div class="col-xs-6 col-md-3 border-right">
                  <p class="text-center text-olive">CERRADOS<br>
                  <span style="font-weight: bold;font-size: 20px"><?php echo $total_servicios_cerrados; ?></span></p>
                </div>
                <div class="col-xs-6 col-md-3 border-right">
                  <p class="text-center text-aqua">ENVIADOS<br>
                  <span style="font-weight: bold;font-size: 20px"><?php echo $total_servicios_enviadas; ?></span></p>
                </div>
                <div class="col-xs-6 col-md-3 border-right">
                  <p class="text-center text-blue">TOTAL<br>
                  <span style="font-weight: bold;font-size: 20px"><?php echo $total_servicios; ?></span></p>
                </div>
                <div class="col-xs-6 col-md-3">
                  <p <?php echo $clase_efectividad; ?>>EFECTIVIDAD<br>
                  <span style="font-weight: bold;font-size: 20px"><?php echo $total_efectividad; ?>%</span></p>
                </div>
                
              </div>
            </div>
        </div>


          <?php 
          }
        } ?>
        <div class="col-xs-12">
          <a href="#" onClick="history.go(-1);return true;" class="btn btn-default"><i class="fa fa-chevron-left"></i> Volver</a>
        </div>
      </div>                
    </div>

  </section>
</div>

<script type="text/javascript">        
  $(document).ready(function(){                
    $("#mnu_puntajes").addClass("active");
  });
</script>