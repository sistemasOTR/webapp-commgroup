<?php
    include_once PATH_NEGOCIO."Sistema/handlersistema.class.php";  
    include_once PATH_NEGOCIO."Funciones/Fechas/fechas.class.php"; 
    include_once PATH_NEGOCIO."Funciones/Array/funcionesarray.class.php";  
    include_once PATH_NEGOCIO."Usuarios/handlerplazausuarios.class.php"; 
    
    // $est_plaza=(isset($_GET['plaza'])?$_GET['plaza']:'');
    $est_empresa=$usuarioActivoSesion->getUserSistema();
    $handlerPlaza = new HandlerPlazaUsuarios;
    $arrPlaza = $handlerPlaza->selectTodas();
    $handler = new HandlerSistema;
    // $arrEmpresas=$handler->selectAllEmpresaFiltroArray(null,null,null,null,null);
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
      Estadisticas <?php echo $usuarioActivoSesion->getAliasUserSistema();?>
      <small>Resumen general de toda la actividad</small>
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
            <li class='<?php echo $act_1 ?>'><a href="#tab_1" data-toggle="tab" aria-expanded="true">Mensual</a></li>
            <li class='<?php echo $act_2 ?>'><a href="#tab_2" data-toggle="tab" aria-expanded="false">Semestral</a></li>
          </ul>
          <div class="tab-content col-xs-12">
            <div class='tab-pane <?php echo $act_1 ?>' id="tab_1">
              <div class='col-md-6'>
                <?php include_once"mensual_empresa.php";?>
              </div>
               <div class='col-md-6'>
                <?php include_once"plaza_empresas.php";?>
              </div>  
            </div>       
           <div class='tab-pane <?php echo $act_2 ?>' id="tab_2">   
             <div class='col-md-6'>
               <?php  include_once"semestre_empresa.php"; ?>    
                </div>  
                <div class='col-md-6'>
                     <?php  include_once"semestre_plaza_empresa.php"; ?>
                 </div> 
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
     <?php 
     // var_dump($seguir);
      if ($seguir) { ?>
        
      var ctx_BSF = document.getElementById('budget_month_chart').getContext('2d');
      window.myLine_BSF = new Chart(ctx_BSF, config_BSF);
   <?php } ?>
    
    var ctx_sem = document.getElementById('sem_chart').getContext('2d');
    window.myLine_BSF = new Chart(ctx_sem, config_sem);
 


  <?php
          if (!empty($cod_emp)) { 
      foreach ($cod_emp as $key => $value) { ?>
        var ctx_<?php echo $value["PLAZA"] ?> = document.getElementById('<?php echo $value["PLAZA"] ?>').getContext('2d');
        window.myLine_BSF = new Chart(ctx_<?php echo $value["PLAZA"] ?>, config_empresas<?php echo $value["PLAZA"];?>);
      <?php } } ?>

      <?php
          if (!empty($cod_emp_plaza)) { 
      foreach ($cod_emp_plaza as $key => $value) { ?>
        var ctx_empresa<?php echo $value["PLAZA"] ?> = document.getElementById('plaza_<?php echo $value["PLAZA"] ?>').getContext('2d');
        window.myLine_BSF = new Chart(ctx_empresa<?php echo $value["PLAZA"] ?>, config_empresas_plaza<?php echo $value["PLAZA"];?>);
      <?php } } ?>
   

    
  };

setTimeout('document.location.reload()',300000);
</script>