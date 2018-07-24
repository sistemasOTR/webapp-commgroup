<?php
    include_once PATH_NEGOCIO."Sistema/handlersistema.class.php";  
    include_once PATH_NEGOCIO."Funciones/Fechas/fechas.class.php"; 
    include_once PATH_NEGOCIO."Funciones/Array/funcionesarray.class.php"; 
    include_once PATH_NEGOCIO."Expediciones/handlerexpediciones.class.php";
?>
    
<div class="content-wrapper">  
  <section class="content-header">
    <h1>
      Panel de Control
      <small>Resumen general de todas las compras</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
      <li class="active">Panel de Control</li>
    </ol>
  </section>        
  
  <section class="content">

    <?php include_once PATH_VISTA."error.php"; ?>
    <?php include_once PATH_VISTA."info.php"; ?>

    <div class='container-fluid'>


      <div class="row">     
        <div class='col-md-4'>
         <!-- INCLUDES TABLAS ITEM , COMPRAS, REMITOS -->
         <?php include_once "Widget/Compras/item.php"; ?>
         <?php include_once "Widget/Compras/compras.php"; ?>
         <?php include_once "Widget/Envios/remito.php"; ?>
        </div>
        <div class='col-md-8'>
           <!-- INCLUDE TABLAS SOLICITUD,APROBADOS -->
           <?php include_once "Widget/Compras/solicitud.php"; ?>
           <?php include_once "Widget/Envios/aprobados.php"; ?>
         
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