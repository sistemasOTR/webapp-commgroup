<?php
  include_once PATH_NEGOCIO."Sistema/handlerconsultas.class.php";  
  include_once PATH_NEGOCIO."Sistema/handlersistema.class.php";  
  include_once PATH_NEGOCIO."Funciones/Fechas/fechas.class.php"; 
  include_once PATH_NEGOCIO."Funciones/Array/funcionesarray.class.php"; 

  include_once PATH_NEGOCIO."Modulos/handlerpuntaje.class.php"; 
  
  $view_detalle= "index.php?view=puntajes_coordinador_detalle";

  $user = $usuarioActivoSesion;

  $dFecha = new Fechas;

  $handler = new HandlerSistema;
  $arrCoordinador = $handler->selectAllCoordinadorFiltro(null,null,null,null,null);  

  $fdesde = (isset($_GET["fdesde"])?$_GET["fdesde"]:$dFecha->FechaActual());
  $fhasta = (isset($_GET["fhasta"])?$_GET["fhasta"]:$dFecha->FechaActual());      
  $fcoordinador= $user->getAliasUserSistema();

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
            $fdesde = date('Y-m-01', mktime(0,0,0,date('m')-$i,1,date('Y')));
            $fhasta = date('Y-m-t', mktime(0,0,0,date('m')-$i,1,date('Y')));
            setlocale(LC_TIME, 'spanish');  
            $nombreMES = strftime("%B",mktime(0, 0, 0, date('m')-$i, 1, 2000));      
            $anioMES = date('Y',mktime(0,0,0,date('m')-$i,1,date('Y')));
            $total_servicios = 0;
            $total_servicios_cerrados = 0;
            $total_efectividad = 0;
            $total_puntajes_cerrados = 0;

            $total_servicios_enviadas = 0;
            $total_puntajes_enviadas = 0;

            $objetivo=0;
            $consulta = $handler->consultaPuntajesCoordinador($fdesde, $fhasta, $fcoordinador);

            if(!empty($consulta))
            {
              foreach ($consulta as $key => $value) { 

                $handlerP = new HandlerPuntaje;
                $objetivo = $handlerP->buscarObjetivoCoordinador($value->ALIAS_COORDINADOR);                        
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
        ?>

        

        <div class="col-sm-6 col-md-4">
            <div class="box box-solid">
              <div class="box-header with-border">
                <h3 class="box-title" style="text-transform: uppercase;"><?php echo $nombreMES ?> <?php echo $anioMES ?></h3>
                <a class="text-navy pull-right" href="<?php echo $view_detalle."&fdesde=".$fdesde."&fhasta=".$fhasta; ?>"><i class="fa fa-search"></i></a>
              </div>    
              <div class="box-body">

                <div class="col-xs-12 no-padding">
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
      <?php }  ?>
                
    </div>

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
      
      url_filtro_reporte="index.php?view=puntajes_coordinador&fdesde="+f_inicio+"&fhasta="+f_fin;

      $("#filtro_reporte").attr("href", url_filtro_reporte);
  }     
</script>