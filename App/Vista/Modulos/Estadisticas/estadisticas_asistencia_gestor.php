<?php
    include_once PATH_NEGOCIO."Sistema/handlersistema.class.php";  
    include_once PATH_NEGOCIO."Funciones/Fechas/fechas.class.php"; 
    include_once PATH_NEGOCIO."Funciones/Array/funcionesarray.class.php";  
    include_once PATH_NEGOCIO."Usuarios/handlerplazausuarios.class.php"; 

    $dFecha=new Fechas;
    $est_plaza=(isset($_GET['fplaza'])?$_GET['fplaza']:'');
    $id_gestor=(isset($_GET['id_gestor'])?$_GET['id_gestor']:'');
    $fdesde = (isset($_GET["fdesde"])?$_GET["fdesde"]:date('Y-m-01', mktime(0,0,0,date('m'),1,date('Y'))));
    $fhasta = (isset($_GET["fhasta"])?$_GET["fhasta"]:$dFecha->FechaActual());   
    $global=false;
    $handlerPlaza = new HandlerPlazaUsuarios;
    $arrPlaza = $handlerPlaza->selectTodas();

   
      // var_dump($arrPlaza);
      // exit();



?>
<div class="content-wrapper">  
  <section class="content-header">
    <h1>
       <i class="ion-arrow-graph-up-right"></i> ESTADISTICAS ASISTENCIAS 
      <small>Resumen general de todas las asistencias</small>
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
                      
                     <div class="col-md-2  col-md-offset 5">
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
          <div class='col-md-12'>
            <div class="box box-solid">
            <div class="box-header with-border">
             <div class='col-md-6'>
                <?php include_once"efectividad_asistencias_gestor.php";?>
             </div>
             <div class='col-md-6'>
             
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

   $(document).ready(function() {
    $("#slt_plaza").select2({
        placeholder: "Seleccionar ...",                  
    });
  }); 

  crearHref();
  function crearHref()
  {   

      aStart = $("#start").val().split('-');
      aFin = $("#end").val().split('-');
      f_inicio = aStart[0] +"-"+ aStart[1] +"-"+ aStart[2];                        
      f_fin = aFin[0] +"-"+ aFin[1] +"-"+ aFin[2]; 
                               
      
      url_filtro_reporte="index.php?view=estadisticas_asistencia_gestor&fdesde="+f_inicio+"&fhasta="+f_fin;
      
      
      $("#filtro_reporte").attr("href", url_filtro_reporte);
  }


    window.onload = function() {

        
        var ctx_asistencias_gestor= document.getElementById('budget_asistencias_gestor').getContext('2d');
        window.myLine_BSF = new Chart(ctx_asistencias_gestor, config_dias_asistencias_gestor);
        
   

    <?php 
    if (!empty($arrEstadosAsistencia)) {
    foreach ($arrEstadosAsistencia as $key => $imp) { ?>

    var ctx_estados<?php echo $imp['PLAZA'] ?> = document.getElementById('budget_horas_estados_<?php echo $imp['PLAZA'] ?>').getContext('2d');
    window.myLine_BSF = new Chart(ctx_estados<?php echo $imp['PLAZA'] ?>, config_horas_estados<?php echo $imp['PLAZA'] ?>);
      
  <?php } }?>

   <?php 
    if (!empty($arrReintegroTickets)) {
    foreach ($arrReintegroTickets as $key => $reint) { ?>

    var ctx_reintegro<?php echo $reint['PLAZA'] ?> = document.getElementById('budget_reintegro_<?php echo $reint['PLAZA'] ?>').getContext('2d');
    window.myLine_BSF = new Chart(ctx_reintegro<?php echo $reint['PLAZA'] ?>, config_reintegro<?php echo $reint['PLAZA'] ?>); 

    <?php } }?>
    };

</script>

