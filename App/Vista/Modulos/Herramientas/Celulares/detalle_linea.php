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

  $nroLinea = (isset($_GET["fNroLinea"])?$_GET["fNroLinea"]:'');
  $datosLinea = $handlerCel->getDatosByNroLinea($nroLinea);
  if($datosLinea->getOcupada()){
    $datosEntrega=$handlerCel->getEntrega($nroLinea);
    $IMEI = $datosEntrega->getIMEI();
    $usuarios = $datosEntrega->getUsId();
    if($IMEI != ''){
      $equipo = $handlerCel->getEquipoLinea($IMEI);
      $telefono = $equipo->getMarca()." ".$equipo->getModelo();
    } else {
      $telefono='Propio';
      $IMEI = 'Desconocido';
    }
    $usuario = $handlerUs->selectById($datosEntrega->getUsId());
  } else {
    $lineaLibre = '<h4>Línea Libre</h4>';
  }
  $histEntregas = $handlerCel->getHistEntregas($nroLinea);



?>
<style>
  .table td {border:none !important;}
  hr {margin-bottom: 10px;margin-top: 10px;}
</style>
<div class="content-wrapper">  
  <section class="content-header">
    <h1>
      Línea <?php echo $nroLinea ?>
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
            <h3 class="box-title"> Detalle de la línea</h3>
            <a href="#" class="btn btn-success pull-right" data-toggle='modal' data-target='#modal-editar-linea'>
                <i class="ion-edit"></i> Editar
            </a>
          </div>
          <div class="box-body">
            <table class="table " style="font-size: 16px;">
              <tbody>
                <tr>
                  <td width="40%">Empresa:</td>
                  <td><?php echo $datosLinea->getEmpresa() ?></td>
                </tr>
                <tr>
                  <td width="40%">Plan:</td>
                  <td><?php echo $datosLinea->getNombrePlan() ?></td>
                </tr>
                <tr>
                  <td width="40%">Fecha de alta:</td>
                  <td><?php echo $datosLinea->getFechaAlta()->format('d-m-Y') ?></td>
                </tr>
                <tr>
                  <td width="40%">Consumo Estimado:</td>
                  <td>$ <?php echo $datosLinea->getConsEstimado()?></td>
                </tr>
                <tr>
                  <td width="40%">Costo:</td>
                  <td>$ <?php echo $datosLinea->getCosto()?></td>
                </tr>
                <tr>
                  <td width="40%">Fecha de baja:</td>
                  <?php if(is_null($datosLinea->getFechaBaja())){ ?>
                    <td class="text-green">Activa</td>
                  <?php } else { ?>
                    <td><?php echo $datosLinea->getFechaBaja()->format('d-m-Y') ?></td>
                  <?php } ?>
                  
                </tr>
                <tr>
                  <td width="40%">Observaciones:</td>
                  <td><?php echo $datosLinea->getObs()?></td>
                </tr>
              </tbody>
            </table>
            <br>
            <a href="index.php?view=celulares" class="pull-left btn btn-default"><i class="ion-chevron-left"></i> Volver</a>
          </div>
        </div>
      </div>

      <!-- Tabla de asignaciones -->

      <div class="col-md-9">
        <div class="col-md-4">
        <div class="box box-solid">
          <div class="box-header with-border">
            <i class="ion-clipboard" style="font-size: 20px; margin-right: 5px;"></i>
            <h3 class="box-title"> Estado actual</h3>
          </div>
          <div class="box-body">
              <table class="table" style="font-size: 16px;">
                <tbody>
                  <?php 
                    if($datosLinea->getOcupada()){ ?>
                      <tr>
                        <td width="150px">Usuario:</td>
                        <td><?php echo $usuario->getNombre()." ".$usuario->getApellido(); ?></td>
                      </tr>
                      <tr>
                        <td width="150px">Teléfono:</td>
                        <td><?php echo $telefono; ?></td>
                      </tr>
                      <tr>
                        <td width="150px">IMEI:</td>
                        <td><?php echo $IMEI; ?></td>
                      </tr>
                      <tr>
                        <td width="150px">Fecha de Entrega:</td>
                        <td><?php echo $datosEntrega->getFechaEntrega()->format('d-m-Y'); ?></td>
                      </tr>
                      <tr>
                        <td width="150px">Observaciones:</td>
                        <td><?php echo $datosEntrega->getObsEntrega(); ?></td>
                      </tr>
                    <?php }else{
                      echo $lineaLibre;
                    }
                   ?>

                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="col-md-8">
          <div class="box box-solid">
          <div class="box-header with-border">
            <i class="ion-clipboard" style="font-size: 20px; margin-right: 5px;"></i>
            <h3 class="box-title"> Últimos Consumos</h3>
          </div>
          <div class="box-body">
              <table class="table" style="font-size: 16px;">
                <thead>
                  
                </thead>
                <tbody>
                  <?php 
                    
                   ?>

                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="col-xs-12">
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
                    <th>Equipo</th>
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
                      	$IMEI = $entrega->getIMEI();
                        $usuarioId = $entrega->getUsId();
                        if($IMEI != ''){
                          $equipo = $handlerCel->getEquipoLinea($IMEI);
                          $telefono = $equipo->getMarca()." ".$equipo->getModelo();
                        } else {
                          $telefono='Propio';
                          $IMEI = 'Desconocido';
                        }
                        $usuario = $handlerUs->selectById($usuarioId);
                      
	                      echo "<tr>";
	                        echo "<td>".$usuario->getNombre()." ".$usuario->getApellido()."</td>";
	                        echo "<td>".$telefono." - IMEI: ".$IMEI."</td>";
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


    </div>
  </section>


</div>
<div class="modal fade in" id="modal-editar-linea">
    <div class="modal-dialog">
      <div class="modal-content">

        <form action="<?php echo $url_action_nueva_linea; ?>" method="post">

          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span></button>
            <h4 class="modal-title"><i class="ion-edit"></i> Editar línea <?php echo $datosLinea->getNroLinea() ?></h4>
          </div>
          <div class="modal-body">
              <div class="row">
                  <div class="col-md-6">
                    <label>Empresa</label>
                    <input type="text" name="txtEmpresa" class="form-control" value="<?php echo $datosLinea->getEmpresa() ?>">
                    <input type="text" name="txtNroLinea" class="form-control" value="<?php echo $datosLinea->getNroLinea() ?>" style="display: none;">
                  </div>          
                  <div class="col-md-6">
                    <label>Plan</label>
                    <input type="text" name="txtNombrePlan" class="form-control" value="<?php echo $datosLinea->getNombrePlan() ?>">
                  </div>
                  <div class="col-md-6">
                    <label>Consumo Estimado</label>
                    <input type="text" name="txtConsEstimado" class="form-control" value="<?php echo $datosLinea->getConsEstimado()?>">
                  </div>
                  <div class="col-md-6">
                    <label>Costo</label>
                    <input type="text" name="txtCosto" class="form-control" value="<?php echo $datosLinea->getCosto()?>">
                  </div>
                  <div class="col-md-12">
                    <label>Observaciones</label>
                    <textarea name="txtObs" id="txtObs" class="form-control" rows="5"><?php echo $datosLinea->getObs()?></textarea>
                  </div>
              </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Guardar</button>
          </div>
        </form>

      </div>
    </div>
  </div>

