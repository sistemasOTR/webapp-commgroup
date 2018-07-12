<?php
    include_once PATH_NEGOCIO."Sistema/handlersistema.class.php";  
    include_once PATH_NEGOCIO."Funciones/Fechas/fechas.class.php"; 
    include_once PATH_NEGOCIO."Funciones/Array/funcionesarray.class.php"; 
    include_once PATH_NEGOCIO."Expediciones/handlerexpediciones.class.php";
?>
    


<div class="content-wrapper">  
  <section class="content-header">
    <h1>
      Panel de Control RRHH
      <small></small>
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
        <div class='col-md-6'>
         <!-- INCLUDES TABLAS LICENCIAS PENDIENTES -->
         <?php include_once "Widget/Rrhh/pendlicencias.php"; ?>
               
        </div>
         <div class='col-md-6'>
          <!-- INCLUDES TABLAS LICENCIAS PROXIMAS -->
          <?php include_once "Widget/Rrhh/proxlicencias.php"; ?>
         </div>
        <div class='col-md-12'>
           <!-- INCLUDE TABLA TICKETS -->
           <?php include_once "Widget/Rrhh/tickets.php"; ?>  
           
         
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