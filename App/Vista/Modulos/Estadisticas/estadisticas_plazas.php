<?php
    include_once PATH_NEGOCIO."Sistema/handlersistema.class.php";  
    include_once PATH_NEGOCIO."Funciones/Fechas/fechas.class.php"; 
    include_once PATH_NEGOCIO."Funciones/Array/funcionesarray.class.php";  
    include_once PATH_NEGOCIO."Usuarios/handlerplazausuarios.class.php"; 

    $est_plaza=(isset($_GET['plaza'])?$_GET['plaza']:'');
    $handlerPlaza = new HandlerPlazaUsuarios;
    $arrPlaza = $handlerPlaza->selectTodas();

?>
    


<div class="content-wrapper">  
  <section class="content-header">
    <h1>
      Panel de Control
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
              <div class='col-md-12'>
                <div class="box box-solid">
                  <div class="box-header with-border">
                    <i class="fa fa-filter"></i>
                    <h3 class="box-title">Filtros Disponibles</h3>
                    <button type="button" class="btn btn-box-tool pull-right bg-red" data-widget="collapse"><i class="fa fa-minus"></i></button>
                  </div>
                    <div class="box-body">
                      <div class="col-md-2 pull-left">  
                         <label>Plaza</label>                          
                           <select id="slt_plaza" class="form-control" style="width: 100%" name="slt_plaza" required="">                    
                             <option></option>
                               <?php
                                if(!empty($arrPlaza))
                                {                        
                                  foreach ($arrPlaza as $key => $value) {
                                    if($est_plaza == $value->getNombre())
                                        echo "<option value='".$value->getNombre()."' selected>".$value->getNombre()."</option>";
                                    else
                                        echo "<option value='".$value->getNombre()."'>".$value->getNombre()."</option>";   
                                      }
                                    }                      
                                ?>                      
                           </select>                  
                      </div>
                     <div class='col-md-2' style="display: none;">                
                       <label></label>                
                        <a class="btn btn-block btn-success" id="filtro_reporte" onclick="crearHref()"><i class='fa fa-filter'></i> Filtrar</a>
                     </div>
                 </div> 
             </div>
           </div>
      </div>
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

  // $(document).ready(function() {
  //   $("#slt_plaza").select2({
  //       placeholder: "Seleccionar una Plaza",                  
  //   });
  // }); 

  $(document).ready(function() {
    $("#slt_plaza").select2({
        placeholder: "Seleccionar",                  
    }).on('change', function (e) { 
      filtrarReporte();
    });
  });

  function filtrarReporte()
  {
    crearHref();
    window.location = $("#filtro_reporte").attr("href");
  }

  // crearHref();
  function crearHref()
  {
                                    
      f_plaza = $("#slt_plaza").val();       
      console.log(f_plaza);

      url_filtro_reporte="index.php?view=estadisticas_plaza";  

      url_filtro_reporte= url_filtro_reporte + "&plaza="+f_plaza;
 

      $("#filtro_reporte").attr("href", url_filtro_reporte);
  } 

</script>