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
  $fserialNro=(isset($_GET["fserialNro"])?$_GET["fserialNro"]:'');
  $url_action_guardar = PATH_VISTA.'Modulos/Herramientas/Impresoras/action_guardar.php';
  $arrUsuarios = $handlerUs->selectGestores(null);
  $impresora = $handlerimpresoras->getDatosConSerial($fserialNro);
  $arrDatos = $handlerimpresoras->getAsignaciones($impresora['_serialNro']);

?>

<div class="content-wrapper">  
  <section class="content-header">
    <h1>
      Consumos Impresora <?php echo $impresora["_marca"]." ".$impresora["_modelo"];?> <a href="javascript:history.go(-1)" class="btn btn-default"><i class="ion-chevron-left"></i> Volver</a>
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


      <!-- Tabla de asignaciones -->

      <div class="col-md-12">
        <div class="box box-solid">
          <div class="box-header with-border">
            <i class="ion-clipboard" style="font-size: 20px; margin-right: 5px;"></i>
            <h3 class="box-title"> Consumos</h3>
          </div>
          <div class="box-body table-responsive">
            <?php switch ($impresora["_marca"]) {
              case 'RICOH':
                include_once 'RICOH.php';
                break;
              case 'SAMSUNG':
                include_once 'SAMSUNG.php';
                break;
              case 'LEXMARK':
                include_once 'LEXMARK.php';
                break;
              
              default:
                # code...
                break;
            } ?>
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
</script>