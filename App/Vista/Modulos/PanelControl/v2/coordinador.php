<?php
    include_once PATH_NEGOCIO."Sistema/handlersistema.class.php";  
    include_once PATH_NEGOCIO."Funciones/Fechas/fechas.class.php"; 
    include_once PATH_NEGOCIO."Funciones/Array/funcionesarray.class.php";
    $user = $usuarioActivoSesion; 
?>
    
<div class="content-wrapper">  

  <section class="content-header">
    <h1>
      Resumen Diario
      <small>Resumen diario en plaza <?php echo $user->getAliasUserSistema() ?></small>
    </h1>
    <ol class="breadcrumb">
      <li class="active"><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>      
    </ol>
  </section>        
  
  <section class="content">

    <?php include_once PATH_VISTA."error.php"; ?>
    <?php include_once PATH_VISTA."info.php"; ?>

    <div class="container-fluid">
      <div class="row">
        <div class="col-md-8" style="border-right-style: solid; border-right-color: #d2d6de;">
          
          <div class="row">
            <div class="col-md-6">
                <?php include_once PATH_VISTA."Modulos/PanelControl/Widget/Estados/coordinador.php"; ?>
            </div>
           
            <div class="col-md-6">
              <?php include_once PATH_VISTA."Modulos/PanelControl/Widget/Efectividad/coordinador.php"; ?>
            </div>     
          </div>
        </div>

        <div class="col-md-4">
          <div class="row">
            <div class="col-md-12">
              <?php include_once PATH_VISTA."Modulos/PanelControl/Widget/VencimientosGestiones/coordinador.php"; ?>
            </div>
          </div>
        </div>
        
      </div> 
    </div>
  </section>
    <section class="content-header">
      <h1>
        Resumen Mensual
        <small>Resumen mensual en plaza <?php echo $user->getAliasUserSistema() ?></small>
      </h1>
    </section>
    <section class="content">
      <div class="container-fluid">
      <div class="row">

         <div class="col-md-6">
          <?php // include_once PATH_VISTA."Modulos/PanelControl/Widget/ProgresoMensual/coordinador.php"; ?>
        </div>
      
        <div class="col-md-6">
           <div class="col-md-12">
          <?php include_once PATH_VISTA."Modulos/PanelControl/Widget/GestionMensualEfectividad/coordinador.php"; ?>
           </div>

        <div class="col-md-12">
          <?php include_once PATH_VISTA."Modulos/PanelControl/Widget/ServiciosMensualEfectividad/coordinador.php"; ?>
        </div>

        <div class="col-md-12">
          <?php include_once PATH_VISTA."Modulos/PanelControl/Widget/Puntaje/coordinador.php"; ?>
        </div>  
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