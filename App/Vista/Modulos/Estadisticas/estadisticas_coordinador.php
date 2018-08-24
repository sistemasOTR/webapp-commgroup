<?php
    include_once PATH_NEGOCIO."Sistema/handlersistema.class.php";  
    include_once PATH_NEGOCIO."Funciones/Fechas/fechas.class.php"; 
    include_once PATH_NEGOCIO."Funciones/Array/funcionesarray.class.php";  
    include_once PATH_NEGOCIO."Usuarios/handlerplazausuarios.class.php"; 

    $est_plaza=(isset($_GET['plaza'])?$_GET['plaza']:'');
    $global=false;


$activo = (isset($_GET["active"])?$_GET["active"]:'');
  switch ($activo) { 
    case 'panel':
      $act_1 = '';
      $act_2 = ' active';
      $act_3 = '';
      $act_4 = '';
      break;
    
    default:
      $act_1 = ' active';
      $act_2 = '';
      $act_3 = '';
      $act_4 = '';
      break;
    }


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
          <!-- MULTI PESTAÑAS -->
          <div class="col-md-12">
        <div class="nav-tabs-custom">
          <ul class="nav nav-tabs">
            <li class='<?php echo $act_1 ?>'><a href="#tab_1" data-toggle="tab" aria-expanded="true">Diario</a></li>
            <li class='<?php echo $act_2 ?>'><a href="#tab_2" data-toggle="tab" aria-expanded="false">Historico</a></li>
            <li class='<?php echo $act_3 ?>'><a href="#tab_3" data-toggle="tab" aria-expanded="false">Empresa Mensual</a></li>
            <li class='<?php echo $act_4 ?>'><a href="#tab_4" data-toggle="tab" aria-expanded="false">Empresa Semestral</a></li>
            
          </ul>
          <div class="tab-content col-xs-12">
            <div class='tab-pane <?php echo $act_1 ?>' id="tab_1">
               <div class='col-md-6'>
                <?php include_once"efectividad_coordinador.php";?>
             </div>
              <div class='col-md-6'>
                <?php include_once"estados_gestiones.php"; ?>
              </div> 
            </div>         
           <div class='tab-pane <?php echo $act_2 ?>' id="tab_2">
           
             <div class='col-md-6'>
                  <?php include_once"mensual.php"; ?>
                </div>  
                <div class='col-md-6'>
                   <?php include_once"ultimo_semestre.php"; ?> 
                 </div> 
                 <div class='col-md-4' style="display: none;">
                    <?php include_once"errores.php"; ?> 
                 </div>
            </div>
            <div class='tab-pane <?php echo $act_3 ?>' id="tab_3">
              <div class="row">
                <?php include_once"empresas_plaza.php"; ?>
              </div>
             <!--  -->
            </div>
            <div class='tab-pane <?php echo $act_4 ?>' id="tab_4">
              <div class="row">
                <?php include_once"plaza_semestral_empresa.php"; ?>
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
       <?php
          if (!empty($cod_emp_plaza)) { 
      foreach ($cod_emp_plaza as $key => $value) { ?>
        var ctx_empresa<?php echo $value["EMPRESA"] ?> = document.getElementById('plaza_<?php echo $value["EMPRESA"] ?>').getContext('2d');
        window.myLine_BSF = new Chart(ctx_empresa<?php echo $value["EMPRESA"] ?>, config_empresas_plaza<?php echo $value["EMPRESA"];?>);
      <?php } } ?>

    
  };
setTimeout('document.location.reload()',300000);
  </script>
 

  <?php if ($despachados_efec[0]->CANTIDAD_SERVICIOS>0) {?>

  <script>
  $(document).ready(function(){

      
        var ctx_cord = $("#budget_cord_chart").get(0).getContext("2d");
        var chartjs = new Chart(ctx_cord,config_cord);
        var codigo= [ <?php echo implode(",",$codigo);?> ]; 
        console.log(codigo);
     var segments = chartjs.segments;
     console.log(segments);
    for (var i = 0; i < codigo.length; i++) {
        // Add properties in here like this
        codigo[i].filter = (i); 

    }
 
        $("#budget_cord_chart").click(
            function(evt){
                var activePoints = chartjs.getElementAtEvent(evt);
                var url = "index.php?view=servicio&fdesde=<?php echo $today;?>&fhasta=<?php echo $today;?>&fgestor="+codigo[activePoints[0]['_index']]; 
                location.href=url;
            }
        );
   
    });

 
 
setTimeout('document.location.reload()',300000);
</script>
<?php } ?>

<?php 
   if (!empty($arrEstados)) {  ?>
    
    <script>
     $(document).ready(function(){

          
            var ctx_est = $("#budget_estados_chart").get(0).getContext("2d");
            var chartestados = new Chart(ctx_est,config_est);
            var est= [ <?php echo implode(",",$est);?> ]; 
        for (var i = 0; i < est.length; i++) {
            // Add properties in here like this
            est[i].filter = (i); 

        }
     
            $("#budget_estados_chart").click(
                function(evt){
                    var activePoints = chartestados.getElementAtEvent(evt);
                    var url = "index.php?view=servicio&fdesde=<?php echo $today;?>&fhasta=<?php echo $today;?>&festado="+est[activePoints[0]['_index']]; 
                    location.href=url;
                }
            );
       
        });

     </script>
  <?php
  } 
  ?>
