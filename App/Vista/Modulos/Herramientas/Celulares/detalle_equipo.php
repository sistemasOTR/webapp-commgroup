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
  include_once PATH_NEGOCIO."Modulos/handlercelulares.class.php";
  include_once PATH_NEGOCIO."Funciones/Array/funcionesarray.class.php";

  $handlerCel = new HandlerCelulares;
  $handlerUs = new HandlerUsuarios;

  $IMEI = (isset($_GET["fIMEI"])?$_GET["fIMEI"]:'');
  $datosEquipo = $handlerCel->getDatosByIMEI($IMEI);
  if(!is_null($datosEquipo->getFechaBaja())){
    $estado = 'Roto';
    $class_estado = 'text-red';
  } elseif (!is_null($datosEquipo->getFechaPerd())) {
    $estado = 'Perdido';
    $class_estado = 'text-red';
  } elseif (!is_null($datosEquipo->getFechaRobo())) {
    $estado = 'Robado';
    $class_estado = 'text-red';
  } else {
    $estado = 'Activo';
    $class_estado = 'text-green';
  }
  
  $url_action_baja_equipo = PATH_VISTA.'Modulos/Herramientas/Celulares/action_baja_equipo.php';



  $histEntregas = $handlerCel->getHistEntregasXIMEI($IMEI);



?>
<style>
  .table td {border:none !important;}
  hr {margin-bottom: 10px;margin-top: 10px;}
</style>
<div class="content-wrapper">  
  <section class="content-header">
    <h1>
      Datos del Equipo
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
      <li>Herramientas</li>
      <li class="active">Celulares</li>
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
            <h3 class="box-title"> Detalle</h3>
            <?php if($estado == 'Activo'){ ?>
              <a href="#" class="btn btn-danger pull-right" data-toggle='modal' data-target='#modal-baja-equipo'>
                  <i class="ion-close"></i> Baja
              </a>
            <?php } ?>
            <!--<a href="#" class="btn btn-success pull-right" data-toggle='modal' data-target='#modal-editar-equipo'>
                <i class="ion-edit"></i> Editar
            </a>-->
          </div>
          <div class="box-body">
            <table class="table " style="font-size: 16px;">
              <tbody>
                <tr>
                  <td width="40%">Marca:</td>
                  <td><?php echo $datosEquipo->getMarca() ?></td>
                </tr>
                <tr>
                  <td width="40%">Modelo:</td>
                  <td><?php echo $datosEquipo->getModelo() ?></td>
                </tr>
                <tr>
                  <td width="40%">IMEI:</td>
                  <td><?php echo $datosEquipo->getIMEI() ?></td>
                </tr>
                <tr>
                  <td width="40%">Fecha de compra:</td>
                  <td><?php echo $datosEquipo->getFechaCompra()->format('d-m-Y') ?></td>
                </tr>
                <tr>
                  <td width="40%">Precio:</td>
                  <td>$ <?php echo $datosEquipo->getPrecioCompra()?></td>
                </tr>
                <tr>
                  <td width="40%">Estado:</td>
                  <td class="<?php echo $class_estado ?>"><?php echo $estado; ?></td>
                </tr>
                <?php 
                  if ($estado == 'Roto') { ?>
                    <tr>
                      <td width="40%">Fecha de Baja:</td>
                      <td><?php echo $datosEquipo->getFechaBaja()->format('d-m-Y')?></td>
                    </tr>
                    <tr>
                      <td width="40%">Observaciones:</td>
                      <td><?php echo $datosEquipo->getObsBaja()?></td>
                    </tr>
                <?php } ?>
                <?php 
                  if ($estado == 'Perdido') { ?>
                    <tr>
                      <td width="40%">Fecha de Pérdida:</td>
                      <td><?php echo $datosEquipo->getFechaPerd()->format('d-m-Y')?></td>
                    </tr>
                    <tr>
                      <td width="40%">Observaciones:</td>
                      <td><?php echo $datosEquipo->getObsPerd()?></td>
                    </tr>
                <?php } ?>
                <?php 
                  if ($estado == 'Robado') { ?>
                    <tr>
                      <td width="40%">Fecha de Robo:</td>
                      <td><?php echo $datosEquipo->getFechaRobo()->format('d-m-Y')?></td>
                    </tr>
                    <tr>
                      <td width="40%">Observaciones:</td>
                      <td><?php echo $datosEquipo->getObsRobo()?></td>
                    </tr>
                <?php } ?>

                

              </tbody>
            </table>
            <br>
            <a href="index.php?view=celulares" class="pull-left btn btn-default"><i class="ion-chevron-left"></i> Volver</a>
          </div>
        </div>
      </div>
      <div class="col-xs-9">
        <div class="box box-solid">
          <div class="box-header with-border">
            <i class="ion-clipboard" style="font-size: 20px; margin-right: 5px;"></i>
            <h3 class="box-title"> Histórico de entregas</h3>
          </div>
          <div class="box-body">
            <table class="table table-striped table-condensed" cellspacing="0" width="100%">
              <thead>
                  <tr>
                    <th>Usuario</th>
                    <th>Línea</th>
                    <th>Fecha Entrega</th>
                    <th>Obs Entrega</th>
                    <th>Fecha Devolución</th>
                    <th>Obs Devolución</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                    if(!empty($histEntregas)){

                      foreach ($histEntregas as $entrega) {
                        $nroLinea = $entrega->getNroLinea();
                        $usuarioId = $entrega->getUsId();
                        $usuario = $handlerUs->selectById($usuarioId);
                      
                        echo "<tr>";
                          echo "<td>".$usuario->getNombre()." ".$usuario->getApellido()."</td>";
                          echo "<td>".$nroLinea."</td>";
                          echo "<td>".$entrega->getFechaEntrega()->format('d-m-Y')."</td>";
                          echo "<td>".$entrega->getObsEntrega()."</td>";
                          echo "<td>".$entrega->getFechaDev()->format('d-m-Y')."</td>";
                          echo "<td>".$entrega->getObsDev()."</td>";
                        echo "</tr>";
                      }
                    }
                   ?>

                </tbody>
              </table>
          </div>
        </div>
      </div>

      


    </div>
  </section>


</div>


  <!-- Baja de equipo -->
  <div class="modal fade in" id="modal-baja-equipo">
    <div class="modal-dialog">
      <div class="modal-content">

        <form action="<?php echo $url_action_baja_equipo; ?>" method="post">

          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span></button>
            <h4 class="modal-title">Baja del equipo <?php echo $datosEquipo->getMarca()." ".$datosEquipo->getModelo(); ?></h4>
          </div>
          <div class="modal-body">
              <div class="row">
                  <div class="col-md-6">
                    <label>Fecha</label>
                    <input type="date" name="txtFecha" id="txtFecha" class="form-control">
                    <input type="text" name="txtFechaCompra" id="txtFechaCompra" class="form-control" value="<?php echo $datosEquipo->getFechaCompra()->format('Y-m-d') ?>" style="display: none;">
                    <input type="text" name="txtIMEI" class="form-control" value="<?php echo $datosEquipo->getIMEI() ?>" style="display: none;">
                  </div>
                  <div class="col-md-6">
                    <label>Tipo de baja</label>
                    <select name="txtTipoBaja" id="txtTipoBaja" class="form-control">
                      <option value="0">Seleccionar...</option>
                      <option value="roto">Rotura del equipo</option>
                      <option value="robo">Robo del equipo</option>
                      <option value="perd">Pérdida del equipo</option>
                    </select>
                  </div>
                  <div class="col-md-12">
                    <label>Observaciones</label>
                    <textarea name="txtObs" id="txtObs" class="form-control" rows="5"></textarea>
                  </div>
              </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-danger">Dar de baja</button>
          </div>
        </form>

      </div>
    </div>
  </div>

  <script>
    $(document).ready(function() {
      $("#txtFecha").on('change', function (e) { 
        controlFecha();
      });
    });

    function controlFecha(){
      fechabaja = document.getElementById("txtFecha").value;
      fechacompra = document.getElementById("txtFechaCompra").value;
      
      if(fechabaja<fechacompra){
        alert("La fecha de baja no puede ser anterior a la fecha de compra del equipo");
        document.getElementById("txtFecha").value = fechacompra;
      } 

    }
  </script>