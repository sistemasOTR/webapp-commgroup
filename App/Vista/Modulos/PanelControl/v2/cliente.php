<?php
    include_once PATH_NEGOCIO."Sistema/handlersistema.class.php";  
    include_once PATH_NEGOCIO."Funciones/Fechas/fechas.class.php"; 
    include_once PATH_NEGOCIO."Funciones/Array/funcionesarray.class.php"; 

    $dFecha = new Fechas;

    $fHOY = $dFecha->FechaActual();
    $fHOY = $dFecha->FormatearFechas($fHOY,"Y-m-d","Y-m-d"); 

    $f = new DateTime();
    $f->modify('first day of this month');
    $fMES = $f->format('Y-m-d'); 

    setlocale(LC_TIME, 'spanish');  
    $nombreMES = strftime("%B",mktime(0, 0, 0, $f->format('m'), 1, 2000));      
    $anioMES = $f->format('Y'); 

    $mes = $dFecha->Mes($f->format('m'));
    if(!PRODUCCION)
    $fHOY = '2018-07-11';
?>

<div class="content-wrapper">  
  <section class="content-header">
    <h1>Resumen Diario - (<span class="text-yellow"><?php echo $dFecha->FormatearFechas($fHOY,'Y-m-d','d/m/Y - h:i'); ?></span>)</h1>
    <ol class="breadcrumb">
      <li class="active"><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>      
    </ol>
  </section>
  
  <section class="content">

    <?php include_once PATH_VISTA."error.php"; ?>
    <?php include_once PATH_VISTA."info.php"; ?>
                  
    <div class="content-fluid">
      <div class="row">
      
        <div class="col-md-4 col-lg-3">
          <?php include_once PATH_VISTA."Modulos/PanelControl/Widget/Estados/cliente.php"; ?>
          <?php include_once PATH_VISTA."Modulos/PanelControl/Widget/Efectividad/cliente.php"; ?>
        </div>

        <div class="col-md-8 col-lg-9">              
          <?php include_once PATH_VISTA."Modulos/PanelControl/Widget/ServiciosHoyDetalle/cliente.php"; ?>
        </div>

      </div>
    </div>
  </section>

  <section class="content-header">
    <h1>Resumen Mensual - (<span class="text-yellow"><?php echo($mes.' '.$anioMES); ?></span>)</h1>
  </section>

  <section class="content">
    <div class="content-fluid">
      <div class="row">
        <div class="col-md-6">
            <?php include_once PATH_VISTA."Modulos/PanelControl/Widget/GestionMensualEfectividad/cliente.php"; ?>
            <?php include_once PATH_VISTA."Modulos/PanelControl/Widget/ServiciosMensualEfectividad/cliente.php"; ?>
        </div>
        <div class="col-md-6">
          <?php include_once PATH_VISTA."Modulos/PanelControl/Widget/ProgresoMensual/cliente.php"; ?>
        </div>
      </div>
    </div>
  </section>
</div>

<script type="text/javascript">        
  $(document).ready(function(){                
    $("#mnu_panelcontrol").addClass("active");
  });

  setTimeout('document.location.reload()',300000);
</script>