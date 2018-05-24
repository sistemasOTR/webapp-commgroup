<?php
    if(realpath("App/Config/config.ini.php"))
    include_once "App/Config/config.ini.php";
  
  if(realpath("../../Config/config.ini.php"))
    include_once "../../Config/config.ini.php";

  include_once PATH_DATOS.'BaseDatos/conexionapp.class.php';
  include_once PATH_DATOS.'BaseDatos/sql.class.php';
  include_once PATH_DATOS.'Entidades/usuarioperfil.class.php';
  include_once PATH_NEGOCIO.'Funciones/Fechas/fechas.class.php'; 


  include_once PATH_NEGOCIO."Sistema/handlersistema.class.php";
  include_once PATH_NEGOCIO."Usuarios/handlerusuarios.class.php";
  include_once PATH_NEGOCIO."Modulos/handlerimpresoras.class.php";
  include_once PATH_NEGOCIO."Funciones/Array/funcionesarray.class.php";

  $handler = new HandlerSistema;
  $handlerimpresoras = new HandlerImpresoras;
  $handlerUs = new HandlerUsuarios;

  $user = $usuarioActivoSesion;
  $fplaza=(isset($_GET["fplaza"])?$_GET["fplaza"]:'');
  $fgestor=(isset($_GET["fgestor"])?$_GET["fgestor"]:'');
  $fgestorId=(isset($_GET["fgestorId"])?$_GET["fgestorId"]:0);
  $arrCoordinador = $handler->selectAllPlazasArray();
  $arrUsuarios = $handlerUs->selectGestores();

  $url_detalle = "index.php?view=impresora_detalle";
  $url_asignacion = "index.php?view=asignar_imp";
  $url_impresion = PATH_VISTA.'Modulos/Herramientas/Impresoras/imprimir_comodato.php?';

  $url_action_guardar = PATH_VISTA.'Modulos/Herramientas/Impresoras/action_guardar.php';
  $url_action_devolver = PATH_VISTA.'Modulos/Herramientas/Impresoras/action_devolver.php';
  $url_action_baja = PATH_VISTA.'Modulos/Herramientas/Impresoras/action_baja.php';
  

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

    <div class="row" <?php if($user->getUsuarioPerfil()->getNombre()=='COORDINADOR'){echo "style='display:none;'";} ?>>
      <div class="col-md-12">
        <div class="box box-solid">
          <div class="box-header with-border">   
            <i class="fa fa-print"></i>       
            <h3 class="box-title">Impresoras</h3>          
          </div>
          <div class="box-body">
            <?php 
              switch ($user->getUsuarioPerfil()->getNombre()) {
                case 'COORDINADOR':
                 include_once "filtro_gestor.php";
                 break;

                case 'GERENCIA' || 'BACK OFFICE':
                  include_once "filtro_plaza.php";
                  break;
              }
            ?>
          <div class='col-md-2' style="display: none;">                
            <label></label>                
              <?php 
                echo "<a class='btn btn-block btn-success' id='filtro_reporte' onclick='crearHref()'><i class='fa fa-filter'></i> Filtrar</a>";
              ?>                  
          </div>
          <div class='col-md-2'>
            <label></label>               
              <?php 
                echo "<a class='btn btn-block btn-warning' href='index.php?view=impresorasxplaza'><i class='fa fa-filter'></i> Limpiar</a>";
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
  

  

</script>
