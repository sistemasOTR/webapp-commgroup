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
  $url_action_guardar = PATH_VISTA.'Modulos/Herramientas/Impresoras/action_editar.php';
  $url_ver_consumo = 'index.php?view=consumo_impresora&fserialNro=';
  $arrUsuarios = $handlerUs->selectGestores();
  $impresora = $handlerimpresoras->getDatosConSerial($fserialNro);
  $arrDatos = $handlerimpresoras->getAsignaciones($impresora['_serialNro']);
  $fecha = new Fechas;

?>

<div class="content-wrapper">  
  <section class="content-header">
    <h1>
      Impresora <?php echo $impresora["_marca"]." ".$impresora["_modelo"];?>
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
      <div class="col-md-3">
        <div class="box box-solid">
          <div class="box-header with-border">
            <i class="ion-clipboard" style="font-size: 20px; margin-right: 5px;"></i>
            <h3 class="box-title"> Detalle de la impresora</h3>
            <?php if(!$impresora["_aprobado"]){ ?>
              <a href='#' data-toggle='modal' id="<?php echo $fserialNro ?>" data-target='#modal-editar' data-serialNro="<?php echo $fserialNro ?>" class="pull-right btn btn-primary"><i class="ion-edit" > Editar</i></a>
            <?php } ?>
            
          </div>
          <div class="box-body">
            <h4>Fecha de compra: <?php if(is_null($impresora["_fechaCompra"])){ echo "";} else {echo $impresora["_fechaCompra"]->format('d-m-Y');} ?></h4>
            <h4>Precio de compra: <?php echo $impresora['_precioCompra'] ?></h4>
            <h4>Fecha de baja: <?php if(is_null($impresora["_fechaBaja"])){ echo "";} else {echo $impresora["_fechaBaja"]->format('d-m-Y');}  ?></h4>
            <h4>Observaciones: <?php echo $impresora["_obs"] ?></h4>
            <br>
            <?php if ($impresora["_marca"] == 'RICOH' ||$impresora["_marca"] == 'LEXMARK' ||$impresora["_marca"] == 'SAMSUNG') { ?>
              <a href="<?php echo $url_ver_consumo.$fserialNro ?>" class="pull-right btn btn-warning"><i class="fa fa-bar-chart"></i> Ver Consumos</a>
            <?php } ?>
            
            <a href="index.php?view=impresorasxplaza" class="pull-left btn btn-default"><i class="ion-chevron-left"></i> Volver</a>
          </div>
        </div>
      </div>

      <!-- Tabla de asignaciones -->

      <div class="col-md-9">
        <div class="box box-solid">
          <div class="box-header with-border">
            <i class="ion-clipboard" style="font-size: 20px; margin-right: 5px;"></i>
            <h3 class="box-title"> Asignaciones</h3>
          </div>
          <div class="box-body table-responsive">
            <table class="table table-striped table-condensed" id="tabla-plaza" cellspacing="0" width="100%" style="text-align:center;">
              <thead>
                <tr>
                  <th class='text-center' width="200">Plaza</th>
                  <th class='text-center' width="200">Gestor</th>
                  <th class='text-center' width="150">Asignación</th>
                  <th class='text-center' width="150">Devolución</th>
                  <th class='text-left'>Observaciones</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                if(!empty($arrDatos)){
                  foreach ($arrDatos as $asignaciones) {
                    //Armado de los datos
                    $plaza = $asignaciones->getPlaza();
                    if($asignaciones->getGestorId() != 0){
                        $gestorId = $asignaciones->getGestorId();
                        $gestorXId = $handlerUs->selectById($gestorId);
                        $nombre = $gestorXId->getNombre(). " " . $gestorXId->getApellido();
                      } else {
                        $nombre = '-';
                      }
                    if(is_null($asignaciones->getFechaAsig())){
                      $fechaAsig='-';
                    } else {
                      $fechaAsig = $asignaciones->getFechaAsig()->format('d-m-Y');
                    }
                    if(is_null($asignaciones->getFechaDev())){
                      $fechaDev='-';
                    } else {
                      $fechaDev = $asignaciones->getFechaDev()->format('d-m-Y');
                    }
                    $obs = $asignaciones->getObs();

                    //Impresión de los datos
                    echo "<tr>
                    <td>".$plaza."</td>
                    <td>".$nombre."</td>
                    <td>".$fechaAsig."</td>
                    <td>".$fechaDev."</td>
                    <td class='text-left'>".$obs."</td>
                    </tr>";
                  }}
                 ?>

              </tbody>
              </table>
          </div>
        </div>
      </div>


    </div>
  </section>
</div>
<div class="modal fade in" id="modal-editar">
    <div class="modal-dialog">
      <div class="modal-content">

        <form id="asig-form" action="<?php echo $url_action_guardar; ?>" method="post">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span></button>
            <h4 class="modal-title">Editar datos contables de la Impresora</h4>
          </div>
          <div class="modal-body">
              <div class="row">
                <div class="col-md-6">
                  <label>Fecha</label>
                  <input type="date" name="fechaCompra" class="form-control">
                </div>
                <div class="col-md-6">
                  <label>Precio</label>
                  <input type="number" name="precioCompra" class="form-control">
                </div> 
                    <input type="text" style="display: none;" id="serialNro" name="serialNro" value='<?php echo $fserialNro; ?>'>
                    <input type="text" style="display: none;" id="userAprobacion" name="userAprobacion" value="<?php echo $user->getId() ?>">
                    <input type="text" style="display: none;" id="fechaActual" name="fechaActual" value="<?php echo $fecha->FechaHoraActual()?>">
              </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Guardar</button>
          </div>
        </form>

      </div>
    </div>
  </div>

<script type="text/javascript">        
  $(document).ready(function(){                
    $("#mnu_herramientas").addClass("active");
  });
</script>