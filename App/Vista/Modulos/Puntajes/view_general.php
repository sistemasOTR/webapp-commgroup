<?php
  include_once PATH_NEGOCIO."Sistema/handlerconsultas.class.php";  
  include_once PATH_NEGOCIO."Sistema/handlersistema.class.php";  
  include_once PATH_NEGOCIO."Funciones/Fechas/fechas.class.php"; 
  include_once PATH_NEGOCIO."Funciones/Array/funcionesarray.class.php"; 
  include_once PATH_NEGOCIO."Parametros/handlerparametros.class.php";  
  include_once PATH_NEGOCIO."Modulos/handlerpuntaje.class.php"; 
  
  $view_detalle= "index.php?view=puntajes_general_detalle";

  $user = $usuarioActivoSesion;

  $dFecha = new Fechas;

  //$handler = new HandlerSistema;
  //$arrCoordinador = $handler->selectAllCoordinadorFiltro(null,null,null,null,null);  

  $fdesde = (isset($_GET["fdesde"])?$_GET["fdesde"]:$dFecha->FechaActual());
  $fhasta = (isset($_GET["fhasta"])?$_GET["fhasta"]:$dFecha->FechaActual()); 
      

  $handler =  new HandlerConsultas;
  

  $p_handler = new HandlerPuntaje;
  $puntos = $p_handler->buscarObjetivoSupervisor(1) + $p_handler->buscarObjetivoSupervisor(2) ; 

  //$p_handler = new HandlerParametros;  
  //$puntos = $p_handler->seleccionarById(3)["valor_int"]; 

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
      <!-- <div class='col-md-12'>
          <div class="box box-solid">
              <div class="box-header with-border">
                <i class="fa fa-filter"></i>
                <h3 class="box-title">Filtros Disponibles</h3>
                <button type="button" class="btn btn-box-tool pull-right bg-red" data-widget="collapse"><i class="fa fa-minus"></i></button>
              </div>    
              <div class="box-body">
                <div class='row'>     
                  <div class="col-md-10">     
                <div class="col-md-3" id='sandbox-container'>
                  <label>Fecha Resolucion Desde - Hasta </label>                
                  <div class="input-daterange input-group" id="datepicker">
                      <input type="text" class="input-sm form-control" onchange="crearHref()" id="start" name="start" value="<?php echo $dFecha->FormatearFechas($fdesde,'Y-m-d','d/m/Y'); ?>"/>
                      <span class="input-group-addon">a</span>
                        <input type="text" class="input-sm form-control" onchange="crearHref()" id="end" name="end" value="<?php echo $dFecha->FormatearFechas($fhasta,'Y-m-d','d/m/Y'); ?>"/>
                    </div>  
                </div>
                
                <div class="col-md-2" style="margin-top: 30px;">              
                    <label></label>                
                  <a class="btn btn-warning btn-sm pull-right" href="<?php echo $view_detalle."&fdesde=".$fdesde."&fhasta=".$fhasta; ?>"> Ver detalle</a>                         
                </div>
              </div>
              <div class="col-md-2">              
                  <label></label>                
                <a class="btn btn-block btn-success" id="filtro_reporte" onclick="crearHref()"><i class='fa fa-filter'></i> Filtrar</a>                         
              </div>
            </div>
          </div>
        </div>
      </div> -->

      
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
            $handlerP = new HandlerPuntaje;
                $fechaPuntajeActual = $handlerP->buscarFechaPuntaje();
                // var_dump($fechaPuntajeActual);
                // exit();
                  if ($fechaPuntajeActual->format('Y-m-d') <= $fdesde) {  
                    $objetivo = $puntos;
              }else{
         
                 $objetivo=$p_handler->buscarObjetivoSupervisor2(1,$fhasta) + $p_handler->buscarObjetivoSupervisor2(2,$fhasta) ;
                
              }

            $consulta = $handler->consultaPuntajesGeneral($fdesde, $fhasta);

            if(!empty($consulta))

            {
              foreach ($consulta as $key => $value) { 
                 // var_dump($value->FECHA->format('Y-m-d'));


                // $objetivo = $puntos;
                 // var_dump($fdesde,$fhasta);
                
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
      <?php }  ?>
                
    </div>

  </section>
</div>

<script type="text/javascript">        
  $(document).ready(function(){                
    $("#mnu_puntajes").addClass("active");
  });
</script>