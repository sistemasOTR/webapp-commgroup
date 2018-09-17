<?php
    include_once PATH_NEGOCIO."Sistema/handlersistema.class.php";  
    include_once PATH_NEGOCIO."Funciones/Fechas/fechas.class.php"; 
    include_once PATH_NEGOCIO."Funciones/Array/funcionesarray.class.php";  
    include_once PATH_NEGOCIO."Usuarios/handlerplazausuarios.class.php"; 
    include_once PATH_NEGOCIO."Usuarios/handlerusuarios.class.php";
    include_once PATH_NEGOCIO."Expediciones/handlerexpediciones.class.php";
   

    $dFecha=new Fechas;
    $fplaza=(isset($_GET['fplaza'])?$_GET['fplaza']:'');
    $fdesde = (isset($_GET["fdesde"])?$_GET["fdesde"]:date('Y-m-01', mktime(0,0,0,date('m'),1,date('Y'))));
    $fhasta = (isset($_GET["fhasta"])?$_GET["fhasta"]:$dFecha->FechaActual());   
    $ftipo= (isset($_GET["ftipo"])?$_GET["ftipo"]:'');   
    $global=false;
    $handlerExp = new HandlerExpediciones;
    $handlerPlaza = new HandlerPlazaUsuarios;
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
       <i class="ion-arrow-graph-up-right"></i> ESTADISTICAS EXPEDICIONES 
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
              <div class='col-md-12'>
                <div class="box box-solid">
                  <div class="box-header with-border">
                    <i class="fa fa-filter"></i>
                    <h3 class="box-title">Filtros Disponibles</h3>
                    <button type="button" class="btn btn-box-tool pull-right bg-red" data-widget="collapse"><i class="fa fa-minus"></i></button>
                  </div>
                 <div class="box-body">   
    
                      <div class="col-md-3 ">
                    <label>Fecha Desde - Hasta</label>
                    <div class="input-group">
                      <input type="date" class="input-sm form-control" onchange="crearHref()" id="start" name="start" value="<?php echo $fdesde; ?>"/>
                      <span class="input-group-addon" >a</span>
                      <input type="date" class="input-sm form-control" onchange="crearHref()" id="end" name="end" value="<?php echo $fhasta; ?>"/>
                    </div>
                    
                </div>                           

                <div class='col-md-3 pull-right'>                
                  <label></label>                
                  <a class="btn btn-block btn-success" id="filtro_reporte" onclick="crearHref()"><i class='fa fa-filter'></i> Filtrar</a>
                </div>
                 </div> 
             </div>
           </div>
      </div>
          <div class="row">     
           <!-- MULTI PESTAÑAS -->
          <div class="col-md-12">
        <div class="nav-tabs-custom">
          <ul class="nav nav-tabs">
            <li class='<?php echo $act_1 ?>'><a href="#tab_1" data-toggle="tab" aria-expanded="true">Estados Expediciones</a></li>
            <li class='<?php echo $act_2 ?>'><a href="#tab_2" data-toggle="tab" aria-expanded="false">Tipos Expediciones</a></li>
              <li class='<?php echo $act_3 ?>'><a href="#tab_3" data-toggle="tab" aria-expanded="false">Demora Aprobadas</a></li>
              <li class='<?php echo $act_4 ?>'><a href="#tab_4" data-toggle="tab" aria-expanded="false">Demora Enviadas</a></li>
          </ul>

          <div class="tab-content col-xs-12">
            <div class='tab-pane <?php echo $act_1 ?>' id="tab_1">
               <div class="row">
                <?php include_once"expediciones_plaza.php";?>
              </div>
            </div>
              <div class='tab-pane <?php echo $act_2 ?>' id="tab_2">
                <div class='col-md-6'>
                  <?php include_once"expediciones_tipos.php";?>
                </div>
              </div>             
              <div class='tab-pane <?php echo $act_3 ?>' id="tab_3">
                <div class="row">
                   <?php include_once"expediciones_demoras_aprobado.php";?>
                </div>
              </div> 
              <div class='tab-pane <?php echo $act_4 ?>' id="tab_4">
                <div class="row">
                   <?php include_once"expediciones_demoras_envios.php";?>
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

   window.onload = function() {
        <?php if (!empty($arrNombrePlaza)) {
         foreach ($arrNombrePlaza as $key => $value) { ?>
        var ctx_expediciones<?php echo $value['PLAZA'];?>= document.getElementById('budget_expediciones<?php echo $value['PLAZA'];?>').getContext('2d');
        window.myLine_BSF = new Chart(ctx_expediciones<?php echo $value['PLAZA'];?>, config_expediciones<?php echo $value['PLAZA'];?>);
      <?php } } ?>
         
         <?php if (!empty($dataTipos)) { ?>
        var ctx_tipos= document.getElementById('budget_tipos').getContext('2d');
        window.myLine_BSF = new Chart(ctx_tipos, config_tipos);
        <?php } ?>

        // <?php if (!empty($dataCompras)) {?>
        // var ctx_compras= document.getElementById('budget_compras').getContext('2d');
        // window.myLine_BSF = new Chart(ctx_compras, config_compras);
        // <?php } ?>
         
         <?php if ($arrPlazaDiasCant) {
          foreach ($arrPlazaDiasCant as $key => $value) { ?>  
        var ctx_dias_aprobado<?php echo $value['PLAZA']; ?>= document.getElementById('budget_dias_aprobado<?php echo $value['PLAZA']; ?>').getContext('2d');
        window.myLine_BSF = new Chart(ctx_dias_aprobado<?php echo $value['PLAZA']; ?>, config_dias_aprobado<?php echo $value['PLAZA']; ?>);
        <?php }} ?> 

        <?php if ($arrPlazaDiasCantEnvio) {
          foreach ($arrPlazaDiasCantEnvio as $key => $value) { ?>  
        var ctx_dias_envios<?php echo $value['PLAZA']; ?>= document.getElementById('budget_dias_envios<?php echo $value['PLAZA']; ?>').getContext('2d');
        window.myLine_BSF = new Chart(ctx_dias_envios<?php echo $value['PLAZA']; ?>, config_dias_envios<?php echo $value['PLAZA']; ?>);
        <?php }} ?>
         
  }

  crearHref();
  function crearHref()
  {   

      aStart = $("#start").val();
      aEnd = $("#end").val();
      
      f_inicio = aStart[2] +"-"+ aStart[1] +"-"+ aStart[0];
      f_fin = aEnd[2] +"-"+ aEnd[1] +"-"+ aEnd[0];                                     
      
      url_filtro_reporte="index.php?view=estadisticas_expediciones&fdesde="+aStart+"&fhasta="+aEnd;

      
      $("#filtro_reporte").attr("href", url_filtro_reporte);
  }

</script>

