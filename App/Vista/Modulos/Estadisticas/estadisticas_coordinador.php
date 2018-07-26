<?php
    include_once PATH_NEGOCIO."Sistema/handlersistema.class.php";  
    include_once PATH_NEGOCIO."Funciones/Fechas/fechas.class.php"; 
    include_once PATH_NEGOCIO."Funciones/Array/funcionesarray.class.php";  
    include_once PATH_NEGOCIO."Usuarios/handlerplazausuarios.class.php"; 

    $est_plaza=(isset($_GET['plaza'])?$_GET['plaza']:'');


?>
    


<div class="content-wrapper">  
  <section class="content-header">
    <h1>
       <i class="ion-arrow-graph-up-right"></i> ESTADISTICAS <?php echo $est_plaza; ?>
      <small>Resumen general de toda la estadistica</small>
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
            <?php include_once"mensual.php"; ?>
          </div>  
           <div class='col-md-4'>
          <?php include_once"ultimo_semestre.php"; ?> 
          </div> 
          <div class='col-md-4' style="display: none;">
          <?php include_once"errores.php"; ?> 
          </div>
        </div>
        <h3>
        EMPRESAS
        <small>Resumen general de todas las empresas</small>
        </h3>
        <div class="row">
          <?php include_once"empresas_plaza.php"; ?>
        </div>
    </div>  

  </section>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script>
<script src="https://rawgit.com/chartjs/chartjs-plugin-annotation/master/chartjs-plugin-annotation.js"></script>

<script type="text/javascript">   
  $(document).ready(function(){                
    $("#mnu_panelcontrol").addClass("active");
  });

  setTimeout('document.location.reload()',300000);

   window.onload = function() {
    var ctx_BSF = document.getElementById('budget_month_chart').getContext('2d');
    window.myLine_BSF = new Chart(ctx_BSF, config_BSF);
    var ctx_sem = document.getElementById('sem_chart').getContext('2d');
    window.myLine_BSF = new Chart(ctx_sem, config_sem);
    var ctx_err = document.getElementById('err_chart').getContext('2d');
    window.myLine_BSF = new Chart(ctx_err, config_err);
    <?php 
      foreach ($cod_emp as $key => $value) { ?>
        var ctx_<?php echo $value["EMPRESA"] ?> = document.getElementById('<?php echo $value["EMPRESA"] ?>').getContext('2d');
        window.myLine_BSF = new Chart(ctx_<?php echo $value["EMPRESA"] ?>, config_empresas<?php echo $value["EMPRESA"];?>);
      <?php } ?>

    
  };
 

</script>