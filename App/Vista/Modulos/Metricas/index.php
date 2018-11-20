<?php
  include_once PATH_NEGOCIO."Sistema/handlerconsultas.class.php";  
  include_once PATH_NEGOCIO."Sistema/handlersistema.class.php";  
  include_once PATH_NEGOCIO."Funciones/Fechas/fechas.class.php"; 
  include_once PATH_NEGOCIO."Funciones/Array/funcionesarray.class.php";

  include_once PATH_NEGOCIO."Usuarios/handlerplazausuarios.class.php";  

  include_once PATH_NEGOCIO."Modulos/handlerpuntaje.class.php"; 
  
  $user = $usuarioActivoSesion;
  
  $dFecha = new Fechas;

  $handlerSist = new HandlerSistema;
  $arrEmpresas = $handlerSist->selectAllEmpresa();
  $arrGestores = $handlerSist->selectAllGestorArray();
  $arrCoord = $handlerSist->selectAllCoordinador(null);

  $fdesde = (isset($_GET["fdesde"])?$_GET["fdesde"]:$dFecha->FechaActual());
  $fhasta = (isset($_GET["fhasta"])?$_GET["fhasta"]:$dFecha->FechaActual());      
  $tipo = (isset($_GET["tipo"])?$_GET["tipo"]:'');   
  $fvista = (isset($_GET["fvista"])?$_GET["fvista"]:'');     
  // $url_servicios = "index.php?view=servicio&fgestor=".$fgestor."&fdesde=".$fdesde."&fhasta=".$fhasta."&festado=";     
  // $fcoordinador= $user->getAliasUserSistema();
  // $fdesde='2018-10-01';
  // $fhasta = '2018-10-31';
  // var_dump($arrGestores);
  // exit();

  $handler =  new HandlerConsultas;
?>
<style>
ul li {list-style:none;}
  td{font-size: 10pt;}
  /*tr {border-bottom: 1px solid #999;}*/
</style>
<div class="content-wrapper">  
  <section class="content-header">
    <h1>
      Métricas
      <small>Detalle del métricas con resolución entre el <?php echo $fdesde ?> y el <?php echo $fhasta ?></small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
      <li class="active">Puntajes</li>
    </ol>
  </section>        
  
  <section class="content">

    <?php include_once PATH_VISTA."error.php"; ?>
    <?php include_once PATH_VISTA."info.php"; ?>

    <div class="row">
      <div class='col-md-12'>
        <div class="box box-solid">
            <div class="box-header with-border">
              <i class="fa fa-filter"></i>
              <h3 class="box-title">Filtros Disponibles</h3>
              <button type="button" class="btn btn-box-tool pull-right bg-red" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
            <div class="box-body">
              <div class='row'> 
                <div class="col-md-3">
                    <label>Fecha Resolución: Desde - Hasta</label>
                    <div class="input-group">
                      <input type="date" class="input-sm form-control" onchange="crearHref()" id="start" name="start" value="<?php echo $fdesde; ?>"/>
                      <span class="input-group-addon" >a</span>
                      <input type="date" class="input-sm form-control" onchange="crearHref()" id="end" name="end" value="<?php echo $fhasta; ?>"/>
                    </div>
                    
                </div>    
                <div class="col-md-3">
                <label>Tipo</label>
                <select id="slt_tipo" class="form-control" style="width: 100%" name="slt_tipo" onchange="crearHref()">
                  <option value='0' <?php if ($tipo == 0) { echo "selected";} ?>>GLOBAL</option>
                  <option value='1' <?php if ($tipo == 1) { echo "selected";} ?>>EMPRESA</option>
                  <option value='2' <?php if ($tipo == 2) { echo "selected";} ?>>PLAZA</option>
                  <option value='3' <?php if ($tipo == 3) { echo "selected";} ?>>GESTOR</option>
                  
                </select>
              </div>
                <div class="col-md-2">
                  <label >Vista</label>
                  <select name="slt_vista" id="slt_vista" class="form-control" onchange="crearHref()">
                    <option value="0">Completa</option>
                    <option value="1" <?php if ($fvista == 1) {echo "selected";} ?>>Numérica</option>
                    <option value="2" <?php if ($fvista == 2) {echo "selected";} ?>>Porcentual</option>
                  </select>
                </div>
                

                <div class='col-md-3 pull-right'>                
                  <label></label>                
                  <a class="btn btn-block btn-success" id="filtro_reporte"><i class='fa fa-filter'></i> Filtrar</a>
                </div>
              </div>
            </div>
        </div>
      </div>
      <?php 
        switch ($tipo) {
          case 0:
            include_once 'global.php';
            break;
          case 1:
            include_once 'empresas.php';
            break;
          case 2:
            include_once 'plazas.php';
            break;
          case 3:
            include_once 'gestores.php';
            break;
          
          default:
            include_once 'global.php';
            break;
        }
       ?>

</div>
</section>
</div>



<script type="text/javascript">

  function crearHref()
  {
      aStart = $("#start").val();
      aEnd = $("#end").val();

      f_inicio = aStart[2] +"-"+ aStart[1] +"-"+ aStart[0];
      f_fin = aEnd[2] +"-"+ aEnd[1] +"-"+ aEnd[0];                                 

      // f_usuario = $("#slt_usuario").val();   

      // f_plaza = $("#slt_plaza").val();
      f_tipo = $("#slt_tipo").val();
      f_plaza = $("#slt_plaza").val();
      f_vista = $("#slt_vista").val();

      url_filtro_reporte="index.php?view=metricas_tt&fdesde="+aStart+"&fhasta="+aEnd;


    // if(f_plaza!=undefined)
    //   if(f_plaza!='' && f_plaza!=0)
    //     url_filtro_reporte= url_filtro_reporte +"&fplaza="+f_plaza;  

    //   if(f_usuario!=undefined)
    //     if(f_usuario>0)
    //       url_filtro_reporte= url_filtro_reporte + "&fusuario="+f_usuario; 

        if(f_tipo!=undefined)
          url_filtro_reporte= url_filtro_reporte + "&tipo="+f_tipo;

        if(f_plaza!=undefined)
          if (f_plaza>'0')
            url_filtro_reporte= url_filtro_reporte + "&fplaza="+f_plaza;

        if(f_vista!=undefined)
          if (f_vista>'0')
            url_filtro_reporte= url_filtro_reporte + "&fvista="+f_vista;
      
      
      $("#filtro_reporte").attr("href", url_filtro_reporte);
  }

  function filtrarReporte()
  {
    crearHref();
    window.location = $("#filtro_reporte").attr("href");
  }

  $(document).ready(function(){                
    $("#mnu_estadisticas").addClass("active");
  });
  $(document).ready(function(){                
    $("#mnu_metricas_tt").addClass("active");
  });
</script>