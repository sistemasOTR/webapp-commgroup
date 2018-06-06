<?php
  include_once PATH_NEGOCIO."Sistema/handlerconsultas.class.php";  
  include_once PATH_NEGOCIO."Sistema/handlersistema.class.php";  
  include_once PATH_NEGOCIO."Funciones/Fechas/fechas.class.php"; 
  include_once PATH_NEGOCIO."Funciones/Array/funcionesarray.class.php"; 

  include_once PATH_NEGOCIO."Modulos/handlerpuntaje.class.php"; 
  
  $view_detalle= "index.php?view=puntajes_gestor_detalle";

  $user = $usuarioActivoSesion;

  $dFecha = new Fechas;

  $handler = new HandlerSistema;
  $arrGestor = $handler->selectAllGestorFiltro(null,null,null,null,null);  

  $fdesde = (isset($_GET["fdesde"])?$_GET["fdesde"]:$dFecha->FechaActual());
  $fhasta = (isset($_GET["fhasta"])?$_GET["fhasta"]:$dFecha->FechaActual());      
  $fgestor= $user->getUserSistema();

  $handler =  new HandlerConsultas;
  
?>

<div class="content-wrapper">  
  <section class="content-header">
    <h1>
      Puntajes
      <small>Puntajes generados desde los servicios</small>
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
     
        <?php
        for ($i=0; $i <= 5 ; $i++) { 
            $monthsMinus = '- '.$i .' month';
            $fdesde = date('Y-m-01',strtotime($monthsMinus));
            $fhasta = date('Y-m-t',strtotime($monthsMinus));
            setlocale(LC_TIME, 'spanish');  
            $nombreMES = strftime("%B",mktime(0, 0, 0, date('m',strtotime($monthsMinus)), 1, 2000));      
            $anioMES = date('Y',strtotime($monthsMinus));
            $total_servicios = 0;
            $total_servicios_cerrados = 0;
            $total_efectividad = 0;
            $total_puntajes_cerrados = 0;

            $total_servicios_enviadas = 0;
            $total_puntajes_enviadas = 0;

            $objetivo=0;
            $consulta = $handler->consultaPuntajes($fdesde, $fhasta, $fgestor);

            if(!empty($consulta))
            {
              foreach ($consulta as $key => $value) { 

                $handlerP = new HandlerPuntaje;
                $objetivo = $handlerP->buscarObjetivo($value->COD_GESTOR);                        
                $fechaPuntajeActual = $handlerP->buscarFechaPuntaje();
                if ($value->FECHA->format('d-m-Y')>= $fechaPuntajeActual->format('d-m-Y')) {
                  $puntaje = $handlerP->buscarPuntaje($value->COD_EMPRESA);
                } else {
                  $puntaje = $handlerP->buscarPuntajeFecha($value->COD_EMPRESA,$value->FECHA->format('Y-m-d'));
                }

                if(empty($objetivo))                                                  
                  $objetivo = 0;

                if(empty($puntaje))
                  $puntaje_cerrados = 0;
                else
                  $puntaje_cerrados = round($value->CERRADO*$puntaje,2);

                if(empty($puntaje))
                  $puntaje_enviadas = 0;
                else
                  $puntaje_enviadas = round($value->ENVIADO*$puntaje,2);                        

                if(!empty($value->TOTAL_SERVICIOS))
                  $efectividad = round($value->CERRADO/$value->TOTAL_SERVICIOS,2) * 100;
                else
                  $efectividad = 0;
                

                $total_servicios = $total_servicios + $value->TOTAL_SERVICIOS;
                $total_servicios_cerrados = $total_servicios_cerrados + $value->CERRADO;
                $total_puntajes_cerrados = $total_puntajes_cerrados + $puntaje_cerrados;                        

                $total_servicios_enviadas = $total_servicios_enviadas + $value->ENVIADO;
                $total_puntajes_enviadas = $total_puntajes_enviadas + $puntaje_enviadas;                        
              }
            }

            if($objetivo != 0){
              if ($total_puntajes_enviadas > $objetivo) {
                $clase_medidor = 'class="info-box bg-green"';
                $puntajePorciento = round(($total_puntajes_enviadas - $objetivo)*100/$objetivo,2);
              } else {
                $clase_medidor = 'class="info-box bg-yellow"';
                $puntajePorciento = round(($total_puntajes_enviadas) * 100 /$objetivo,2);
              }

            } else {
              $clase_medidor = 'class="info-box bg-yellow"';
              $puntajePorciento = 50;
            }

            if(!empty($total_servicios)){
              $total_efectividad = round(($total_servicios_enviadas+$total_servicios_cerrados)/$total_servicios,2) *100;
              if ($total_efectividad > 70) {
                $clase_efectividad = 'class="info-box-icon bg-green"';
              } else if($total_efectividad < 60){
                $clase_efectividad = 'class="info-box-icon bg-red"';
              } else {
                $clase_efectividad = 'class="info-box-icon bg-yellow"';
              }
             } else {
              $total_efectividad = 0;
              $clase_efectividad = 'class="info-box-icon bg-red"';
            }
        ?>

        <div class="col-sm-10 col-md-8 col-sm-offset-1 col-md-offset-2">
            <div class="box box-solid">
              <div class="box-header with-border">
                <h3 class="box-title" style="text-transform: uppercase;"><?php echo $nombreMES ?> <?php echo $anioMES ?></h3>
              </div>    
              <div class="box-body">

                <div class="col-sm-12">
                <div <?php echo $clase_medidor; ?>>
                      <span class="info-box-icon"><i class="ion-calculator"></i></span>
                      <div class="info-box-content">
                        <span class="info-box-text">PUNTAJE</span>
                        <span class="info-box-number"><?php echo $puntajePorciento."%"; ?></span>

                        <div class="progress">
                          <div class="progress-bar" style="width: <?php echo $puntajePorciento ?>%"></div>
                        </div>
                        <span class="progress-description">
                          <small>Enviados: </small><?php echo $total_puntajes_enviadas ?> <span class="pull-right"><small>Objetivo: </small><?php echo $objetivo; ?></span>
                        </span>
                      </div>
                    </div>
                  </div>
                <div class="col-sm-6 col-lg-3">
                  <div class="info-box">
                    <span class="info-box-icon bg-yellow"><i class="ion-lock-combination"></i></span>

                    <div class="info-box-content">
                      <span class="info-box-text">CERRADOS</span>
                      <span class="info-box-number"><?php echo $total_servicios_cerrados; ?></span>
                    </div>
                  </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                  <div class="info-box">
                    <span class="info-box-icon bg-aqua"><i class="ion-ios-paperplane"></i></span>

                    <div class="info-box-content">
                      <span class="info-box-text">ENVIADOS</span>
                      <span class="info-box-number"><?php echo $total_servicios_enviadas; ?></span>
                    </div>
                  </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                  <div class="info-box">
                    <span class="info-box-icon bg-blue"><i class="ion-briefcase"></i></span>

                    <div class="info-box-content">
                      <span class="info-box-text">TOTAL</span>
                      <span class="info-box-number"><?php echo $total_servicios; ?></span>
                    </div>
                  </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                  <div class="info-box">
                    <span <?php echo $clase_efectividad; ?>><i class="ion-arrow-graph-up-right"></i></span>

                    <div class="info-box-content">
                      <span class="info-box-text">EFECTIVIDAD</span>
                      <span class="info-box-number"><?php echo $total_efectividad; ?> %</span>
                    </div>
                  </div>
                </div>
                
              </div>
            </div>
        </div>
      <?php }  ?>
                
    </div>

  </section>


  </section>
</div>

<script type="text/javascript">        
  $(document).ready(function(){                
    $("#mnu_puntajes").addClass("active");
  });

  $('#sandbox-container .input-daterange').datepicker({
      format: "dd/mm/yyyy",
      clearBtn: false,
      language: "es",
      keyboardNavigation: false,
      forceParse: false,
      autoclose: true,
      todayHighlight: true,                                                                        
      multidate: false,
      todayBtn: "linked",  
  });

  crearHref();  
  function crearHref()
  {
      aStart = $("#start").val().split('/');
      aEnd = $("#end").val().split('/');

      f_inicio = aStart[2] +"-"+ aStart[1] +"-"+ aStart[0];
      f_fin = aEnd[2] +"-"+ aEnd[1] +"-"+ aEnd[0];                              
      
      url_filtro_reporte="index.php?view=puntajes_gestor&fdesde="+f_inicio+"&fhasta="+f_fin;

      $("#filtro_reporte").attr("href", url_filtro_reporte);
  }     
</script>