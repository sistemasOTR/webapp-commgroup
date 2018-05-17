<?php
    if(realpath("App/Config/config.ini.php"))
    include_once "App/Config/config.ini.php";
  
  if(realpath("../../Config/config.ini.php"))
    include_once "../../Config/config.ini.php";

  include_once PATH_DATOS.'BaseDatos/conexionapp.class.php';
  include_once PATH_DATOS.'BaseDatos/sql.class.php';
  include_once PATH_DATOS.'Entidades/usuarioperfil.class.php';


  include_once PATH_NEGOCIO."Sistema/handlersistema.class.php";
  include_once PATH_NEGOCIO."Modulos/handlerimpresoras.class.php";
  include_once PATH_NEGOCIO."Funciones/Array/funcionesarray.class.php";

  $handler = new HandlerSistema;
  $handlerimpresoras = new HandlerImpresoras;

  $user = $usuarioActivoSesion;
  $arrCoordinador = $handler->selectAllPlazasArray();
  $arrGestor = $handler->selectAllGestor($fplaza); 

  $fplaza=(isset($_GET["fplaza"])?$_GET["fplaza"]:'');
  $fgestor=(isset($_GET["fgestor"])?$_GET["fgestor"]:'');

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

           <?php include_once "filtro_plaza.php"; ?>
          <div class='col-md-2'>                
                  <label></label>                
                  <?php 
                      echo "<a class='btn btn-block btn-success' id='filtro_reporte' onclick='crearHref()'><i class='fa fa-filter'></i> Filtrar</a>";
                  ?>                  
              </div>
          </div>
        </div>
      </div>                
    </div>
    <div class="row">
      <div class="col-md-12">

         

            <?php 
              switch ($user->getUsuarioPerfil()->getNombre()) {
                case 'COORDINADOR':

                    include_once "vista_coordinador.php";
                    
                  break;

                case 'GERENCIA' || 'BACK OFFICE':
                    include_once "vista_admin.php";
                    
                  break;                                            
              }
            ?>
          

      </div>
    </div>


    
  </section>


</div>

<script type="text/javascript">        
  $(document).ready(function(){                
    $("#mnu_herramientas").addClass("active");
  });

  $(document).ready(function() {
    $("#slt_plaza").select2({
        placeholder: "Seleccionar",                  
    }).on('change', function (e) { 
      filtrarReporte(); 
    });
  });

  crearHref();
  function crearHref()
  {
    f_plaza = $("#slt_plaza").val();   
    
    url_filtro_reporte="index.php?view=impresoras";

    if(f_plaza!=undefined)
      if(f_plaza!='')
        url_filtro_reporte= url_filtro_reporte + "&fplaza="+f_plaza;

    $("#filtro_reporte").attr("href", url_filtro_reporte);

    document.cookie = "url-tmp-back="+url_filtro_reporte;
  } 

  function filtrarReporte()
  {
    crearHref();
    window.location = $("#filtro_reporte").attr("href");
  }

</script>