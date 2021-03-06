
<head>
<script type="text/javascript">
<?php

if( isset($_GET['pop'])){
  $entregaId = intval($_GET['fID']) ;

  $fTipo = $_GET['fTipo'];

echo "window.open('".PATH_VISTA."Modulos/Herramientas/Impresoras/imprimir_baja_comodato.php?fID=".$entregaId."&fTipo=".$fTipo."')";

}

?></script></head>


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
  include_once PATH_NEGOCIO."Usuarios/handlerplazausuarios.class.php";  
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

  $handlerPlaza = new HandlerPlazaUsuarios;
  $arrPlaza = $handlerPlaza->selectTodas();

  $arrUsuarios = $handlerUs->selectEmpleados();
  $arrGestores = $handlerUs->selectGestores(null);

  $url_detalle = "index.php?view=impresora_detalle";
  $url_asignacion = "index.php?view=asignar_imp";
  $url_impresion = PATH_VISTA.'Modulos/Herramientas/Impresoras/imprimir_comodato.php?';

  $url_action_guardar = PATH_VISTA.'Modulos/Herramientas/Impresoras/action_guardar.php';
  $url_action_devolver = PATH_VISTA.'Modulos/Herramientas/Impresoras/action_devolver.php';
  $url_action_baja = PATH_VISTA.'Modulos/Herramientas/Impresoras/action_baja.php';
  $url_action_devGestor = PATH_VISTA.'Modulos/Herramientas/Impresoras/action_devolver_gestor.php';
  $url_action_asignar = PATH_VISTA.'Modulos/Herramientas/Impresoras/action_asignar.php';
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
      <?php if ($user->getUsuarioPerfil()->getNombre() != 'COORDINADOR') { ?>
        <div class="col-md-12">
          <?php include_once 'filtro_plaza.php'; ?>
        </div>
      <?php } ?>
      
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
