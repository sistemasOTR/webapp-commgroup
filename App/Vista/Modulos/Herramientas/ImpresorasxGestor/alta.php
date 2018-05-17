<?php
  include_once PATH_NEGOCIO."Sistema/handlersistema.class.php";
  include_once PATH_NEGOCIO."Modulos/handlerimpresoras.class.php";
  include_once PATH_NEGOCIO."Funciones/Array/funcionesarray.class.php";

  $dFecha = new Fechas;

  $handler = new HandlerSistema;

    $user = $usuarioActivoSesion;
  $arrCoordinador = $handler->selectAllPlazasArray();

  $url_impresoras = "index.php?view=impresoras";
  $url_celulares = "index.php?view=celulares";
  $url_insumos = "index.php?view=insumos";

  $fdesde=(isset($_GET["fdesde"])?$_GET["fdesde"]:date('Y-m-d', strtotime('-0 days')));
  $fhasta=(isset($_GET["fhasta"])?$_GET["fhasta"]:date('Y-m-d'));
  $festado=(isset($_GET["festado"])?$_GET["festado"]:0);
  $fequipoventa=(isset($_GET["fequipoventa"])?$_GET["fequipoventa"]:'');
  $fcliente=(isset($_GET["fcliente"])?$_GET["fcliente"]:'');
  $fgerente=(isset($_GET["fgerente"])?$_GET["fgerente"]:'');    
  $fcoordinador=(isset($_GET["fcoordinador"])?$_GET["fcoordinador"]:'');
  $fgestor=(isset($_GET["fgestor"])?$_GET["fgestor"]:'');
  $foperador=(isset($_GET["foperador"])?$_GET["foperador"]:'');

  $fdoc=(isset($_GET["fdoc"])?$_GET["fdoc"]:'');

  $f_dd_dni = (isset($_GET["f_dd_dni"])?$_GET["f_dd_dni"]:'');

  $url_detalle = "index.php?view=detalle_servicio";     
  $url_upload = "index.php?view=upload_file";    

  $arrEstados = $handler->selectAllEstados();    
  $allEstados = $handler->selectAllEstados();        

 // $url_action_enviar = PATH_VISTA.'Modulos/Inbox/action_enviar.php';
?>

<div class="content-wrapper">  
  <section class="content-header">
    <h1>
      Herramientas
      <small>ABM de herramientas </small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
      <li>Herramientas</li>
      <li class="active">Impresoras</li>
    </ol>
  </section>        
  
  <section class="content">

    <?php include_once PATH_VISTA."error.php"; ?>
    <?php include_once PATH_VISTA."info.php"; ?>

    <div class="row">
      <div class="col-md-12">
        <div class="box box-solid">
          <div class="box-header with-border">   
            <i class="fa fa-print"></i>       
            <h3 class="box-title">Impresoras</h3>          
          </div>
          <div class="box-body">

           <?php include_once "filtros.php"; ?>
          <div class='col-md-2'>                
                  <label></label>                
                  <?php 
                    if($fdoc=="si")
                      echo "<a class='btn btn-block btn-success' id='filtro_reporte_documento' onclick='crearHrefDocumento()'><i class='fa fa-filter'></i> Filtrar</a>";
                    else
                      echo "<a class='btn btn-block btn-success' id='filtro_reporte' onclick='crearHref()'><i class='fa fa-filter'></i> Filtrar</a>";
                  ?>                  
              </div>
          </div>
        </div>
      </div>                
    </div>


    
  </section>


</div>

<script type="text/javascript">        
  $(document).ready(function(){                
    $("#mnu_herramientas").addClass("active");
  });

  $(document).ready(function() {
    $("#slt_coordinador").select2({
        placeholder: "Seleccionar",                  
    }).on('change', function (e) { 
      filtrarReporte(); 
    });
  });

  crearHref();
  function crearHref()
  {
    f_coordinador = $("#slt_coordinador").val();   
    
    url_filtro_reporte="index.php?view=impresoras";

    if(f_coordinador!=undefined)
      if(f_coordinador!='')
        url_filtro_reporte= url_filtro_reporte + "&fcoordinador="+f_coordinador;

    $("#filtro_reporte").attr("href", url_filtro_reporte);

    document.cookie = "url-tmp-back="+url_filtro_reporte;
  } 

  function filtrarReporte()
  {
    crearHref();
    window.location = $("#filtro_reporte").attr("href");
  }

</script>