<?php
    include_once PATH_NEGOCIO."Sistema/handlersistema.class.php";  
    include_once PATH_NEGOCIO."Funciones/Fechas/fechas.class.php"; 
    include_once PATH_NEGOCIO."Funciones/Array/funcionesarray.class.php";  
    include_once PATH_NEGOCIO."Usuarios/handlerplazausuarios.class.php"; 
    include_once PATH_NEGOCIO."Usuarios/handlerusuarios.class.php";
    include_once PATH_NEGOCIO."Modulos/handlerlicencias.class.php";  

    $dFecha=new Fechas;
    $fplaza=(isset($_GET['fplaza'])?$_GET['fplaza']:'');
    $fdesde = (isset($_GET["fdesde"])?$_GET["fdesde"]:date('Y-m-01', mktime(0,0,0,date('m'),1,date('Y'))));
    $fhasta = (isset($_GET["fhasta"])?$_GET["fhasta"]:$dFecha->FechaActual());   
    $ftipo= (isset($_GET["ftipo"])?$_GET["ftipo"]:'');   
    $global=false;
    $handlerPlaza = new HandlerPlazaUsuarios;
    $arrPlaza = $handlerPlaza->selectTodas();
    $handler = new HandlerLicencias;
    $arrTipos = $handler->selecionarTipos();
    // $handlerusuario=new handlerusuarios;
    // $arrEmpleados=$handlerusuario->selectEmpleados();
    
        // var_dump($arrPlaza[0]->getNombre());
        // exit();



?>
<div class="content-wrapper">  
  <section class="content-header">
    <h1>
       <i class="ion-arrow-graph-up-right"></i> ESTADISTICAS LICENCIAS 
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
          <div class='col-md-12'>
            <div class="box box-solid">
            <div class="box-header with-border">
             <div class='col-md-6'>
                <?php include_once"licencia_plaza.php";?>
             </div>
             <div class='col-md-6'>
              <?php include_once"licencia_tipo.php";?>  
             </div>
             <div class='col-md-6'>
              <?php include_once"licencia_dias_plaza.php";?>  
             </div>
             <div class='col-md-6'>
              <?php include_once"licencia_dias_tipo.php";?>  
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
      
        var ctx_licencias= document.getElementById('budget_licencias').getContext('2d');
        window.myLine_BSF = new Chart(ctx_licencias, config_licencias);

        var ctx_tipo= document.getElementById('budget_tipo').getContext('2d');
        window.myLine_BSF = new Chart(ctx_tipo, config_tipo);

        var ctx_dias_plaza= document.getElementById('budget_dias_plaza').getContext('2d');
        window.myLine_BSF = new Chart(ctx_dias_plaza, config_dias_plaza);

         var ctx_dias_tipo= document.getElementById('budget_dias_tipo').getContext('2d');
        window.myLine_BSF = new Chart(ctx_dias_tipo, config_dias_tipo);
         
  }

  crearHref();
  function crearHref()
  {   

      aStart = $("#start").val();
      aEnd = $("#end").val();
      
      f_inicio = aStart[2] +"-"+ aStart[1] +"-"+ aStart[0];
      f_fin = aEnd[2] +"-"+ aEnd[1] +"-"+ aEnd[0];                                 

      f_plaza = $("#slt_plaza").val();     
      f_tipo = $("#slt_tipo").val();     
      
      url_filtro_reporte="index.php?view=estadisticas_licencias&fdesde="+aStart+"&fhasta="+aEnd;

      if(f_plaza!=undefined)
  
          url_filtro_reporte= url_filtro_reporte + "&fplaza="+f_plaza;

      if(f_tipo!=undefined)
  
          url_filtro_reporte= url_filtro_reporte + "&ftipo="+f_tipo;
      
      
      $("#filtro_reporte").attr("href", url_filtro_reporte);
  }

</script>

