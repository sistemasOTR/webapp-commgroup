<?php
    include_once PATH_NEGOCIO."Sistema/handlersistema.class.php";  
    include_once PATH_NEGOCIO."Funciones/Fechas/fechas.class.php"; 
    include_once PATH_NEGOCIO."Funciones/Array/funcionesarray.class.php";  
    include_once PATH_NEGOCIO."Usuarios/handlerplazausuarios.class.php"; 

    $est_plaza='';
    $dFecha = new Fechas;
    if(!PRODUCCION){
      $today = "2018-08-21";
    }else{
      $today=$dFecha->FechaActual();
    }

    $admin='gestor';
    $activo = (isset($_GET["active"])?$_GET["active"]:'');
      switch ($activo) { 
        case 'panel':
          $act_1 = '';
          $act_2 = ' active';
          $act_3 = '';
          break;
        
        default:
          $act_1 = ' active';
          $act_2 = '';
          $act_3 = '';
          break;
        }


?>
<div class="content-wrapper">  
  <section class="content-header">
    <h1>
       <i class="ion-arrow-graph-up-right"></i> ESTADISTICAS GESTOR
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
          <!-- MULTI PESTAÑAS -->
          <div class="col-md-12">
        <div class="nav-tabs-custom">
          <ul class="nav nav-tabs">
            <li class='<?php echo $act_1 ?>'><a href="#tab_1" data-toggle="tab" aria-expanded="true">Diario</a></li>
            <li class='<?php echo $act_2 ?>'><a href="#tab_2" data-toggle="tab" aria-expanded="false">Historico</a></li>
            <li class='<?php echo $act_3 ?>'><a href="#tab_3" data-toggle="tab" aria-expanded="false">Hist.Empresa</a></li>
          </ul>
          <div class="tab-content col-xs-12">
            <div class='tab-pane <?php echo $act_1 ?>' id="tab_1">
              <div class='col-md-6'>
                <?php include_once"estados_gestores.php"; ?> 
              </div> 
                <div class='col-md-6'style="display: none;">
                 <?php include_once"efectividad_coordinador.php";?> 
             </div> 
            </div>         
            <div class='tab-pane <?php echo $act_2 ?>' id="tab_2"> 
           
             <div class='col-md-4'>
                  <?php include_once"mensual_gestor.php"; ?> 
                </div>  
                <div class='col-md-4'>
                    <?php include_once"ultimo_semestre_gestor.php"; ?>  
                 </div> 
            </div>
            <div class='tab-pane <?php echo $act_3 ?>' id="tab_3">
              <div class="row">
                <?php include_once"empresas_plaza_gestor.php"; ?> 
              </div>
             <!--  -->
            </div>

          </div>
        </div>
                
      </div>        
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
    var ctx_BSF_gestor = document.getElementById('budget_month_gestor_chart').getContext('2d');
    window.myLine_BSF = new Chart(ctx_BSF_gestor, config_BSF_gestor);
    var ctx_sem_gestor = document.getElementById('sem_gestor_chart').getContext('2d');
    window.myLine_BSF = new Chart(ctx_sem_gestor, config_sem_gestor);
    <?php 
      foreach ($cod_empresa_gestor as $key => $value) { ?>
        var ctx_gestor_<?php echo $value["EMPRESA"] ?> = document.getElementById('gestor_<?php echo $value["EMPRESA"] ?>').getContext('2d');
        window.myLine_BSF = new Chart(ctx_gestor_<?php echo $value["EMPRESA"] ?>, config_empresas_gestor<?php echo $value["EMPRESA"];?>);
      <?php } ?>

    
  };
 
setTimeout('document.location.reload()',300000);
</script>

<?php

   if (!empty($arrEstados)) { ?>
    
   

<script>
  $(document).ready(function(){

      
        var ctx_est_gestor = $("#budget_estados_gestor_chart").get(0).getContext("2d");
        var chartestadosgestor = new Chart(ctx_est_gestor,config_est_gestor);
        var est_gestor= [ <?php echo implode(",",$est_gestor);?> ]; 
    for (var i = 0; i < est_gestor.length; i++) {
        // Add properties in here like this
        est_gestor[i].filter = (i); 

    }
 
        $("#budget_estados_gestor_chart").click(
            function(evt){
                var activePoints = chartestadosgestor.getElementAtEvent(evt);
                var url = "index.php?view=servicio&fdesde=<?php echo $today;?>&fhasta=<?php echo $today;?>&festado="+est_gestor[activePoints[0]['_index']]; 
                location.href=url;
            }
        );
   
    });
  </script>

  <?php
  } 
  ?>


 