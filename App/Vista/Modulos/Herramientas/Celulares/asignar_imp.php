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
  $arrGestor = $handler->selectAllGestor($fplaza); 
  $arrUsuarios = $handlerUs->selectGestores(null);

  $url_detalle = "index.php?view=impresora_detalle";
  $url_asignacion = "index.php?view=asignar_imp";

  $url_action_guardar = PATH_VISTA.'Modulos/Herramientas/Impresoras/action_asignar.php';
  $fserialNro=(isset($_GET["fserialNro"])?$_GET["fserialNro"]:'');
  $ffechaAsig=(isset($_GET["ffechaAsig"])?$_GET["ffechaAsig"]:'');
  $impresora = $handlerimpresoras->getDatosConSerial($fserialNro);
  $arrDatos = $handlerimpresoras->getAsignaciones($impresora['_serialNro']);

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
          </div>
          <div class="box-body">
            
            <h4>Fecha de compra: <?php if(is_null($impresora["_fechaCompra"])){ echo "";} else {echo $impresora["_fechaCompra"]->format('d-m-Y');} ?></h4>
            <h4>Precio de compra: <?php echo $impresora["_precioCompra"] ?></h4>
            <h4>Fecha de baja: <?php if(is_null($impresora["_fechaBaja"])){ echo "";} else {echo $impresora["_fechaBaja"]->format('d-m-Y');}  ?></h4>
            <h4>Observaciones: <?php echo $impresora["_obs"] ?></h4>
            <br>
            <a href="index.php?view=impresorasxplaza" class="pull-left btn btn-default"><i class="ion-chevron-left"></i> Volver</a>
          </div>
        </div>
      </div>
      <div class="col-md-9">
        <div class="box box-solid">
          <div class="box-header with-border">
            <i class="ion-clipboard" style="font-size: 20px; margin-right: 5px;"></i>
            <h3 class="box-title"> Asignación</h3>
          </div>
          <div class="box-body">
            <form action="<?php echo $url_action_guardar; ?>" method="post">
              <input type="text" style="display: none" value="<?php echo $impresora["_serialNro"] ?>" id="serialNro" name="serialNro">
              <div class="col-md-5">
                <label>Plazas</label>
                <select id="slt_plaza" class="form-control" style="width: 100%" name="slt_plaza" onchange="crearHrefP()">                              
                  <option value="">Seleccionar...</option>
                  <option value='0'>TODAS</option>
                  <?php
                    if(!empty($arrCoordinador))
                    {                        
                      foreach ($arrCoordinador as $key => $value) {                                                  
                        if($fplaza==$value['PLAZA'])
                          echo "<option value='".trim($value['PLAZA'])."' selected>".$value['PLAZA']."</option>";
                        else
                          echo "<option value='".trim($value['PLAZA'])."'>".$value['PLAZA']."</option>";
                      }
                    }
                    if($fplaza=='MANTENIMIENTO')
                      echo "<option value='MANTENIMIENTO' selected>MANTENIMIENTO</option>";
                    else
                      echo "<option value='MANTENIMIENTO'>MANTENIMIENTO</option>"; 
                  ?>
                </select>
              </div>
              <div class="col-md-5">
                <label>Gestor</label>
                <select name="slt_gestor" id="slt_gestor" class="form-control" style="width: 100%" onchange="crearHrefG()">
                  <option value="">Seleccionar</option>
                  <option value="0">Todos</option>
                  <?php 
                    if(!empty($arrUsuarios)){
                    foreach ($arrUsuarios as $usuario) {
                      foreach ($arrGestor as $gestor) {
                        if($fgestorId == $usuario->getId() && $usuario->getUserSistema() == $gestor->GESTOR11_CODIGO)
                          echo "<option value='".$usuario->getId()."' selected>".$usuario->getNombre()." ".$usuario->getApellido()."</option>";
                        elseif ($usuario->getUserSistema() == $gestor->GESTOR11_CODIGO) {
                          echo "<option value='".$usuario->getId()."'>".$usuario->getNombre()." ".$usuario->getApellido()."</option>";
                          }
                        }
                      } 
                    }
                  ?>
                </select>
              </div>
              <div class="col-md-2">
                <label>Fecha</label>
                <input type="date" name="fechaAsig" class="form-control">
              </div>
              <div class='col-md-2' style="display: none;">                
                <label></label>                
                <?php 
                echo "<a class='btn btn-block btn-success' id='filtro_reporte' onclick='crearHref()'><i class='fa fa-filter'></i> Filtrar</a>";
                ?>                  
              </div>
              <div class="col-xs-12">
                <label>Observaciones</label>
                <textarea name="txtObs" id="txtObs" class="form-control" rows="5"></textarea>
              </div>

              <div class="col-xs-12"><button type="submit" style="margin-top: 1em;" class="btn btn-primary pull-right">Asignar</button></div>
              
            </form>
          </div>
        </div>
      </div>

      <!-- Asignaciones previas -->

      <div class="col-md-12">
        <div class="box box-solid">
          <div class="box-header with-border">
            <i class="ion-clipboard" style="font-size: 20px; margin-right: 5px;"></i>
            <h3 class="box-title"> Asignaciones Previas</h3>
          </div>
          <div class="box-body">
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

  $(document).ready(function() {
    $("#slt_gestor").select2({
        placeholder: "Seleccionar",                  
    }).on('change', function (e) { 
      filtrarReporte(); 
    });
  });

  
  function crearHref()
  {
    f_gestorId = $("#slt_gestor").val();
    f_serialNro = $("#serialNro").val().trim();
    f_plaza = $("#slt_plaza").val();   
    url_filtro_reporte="index.php?view=asignar_imp&fserialNro="+f_serialNro;

    if(f_plaza!=undefined)
      if(f_plaza!='')
        url_filtro_reporte= url_filtro_reporte +"&fplaza="+f_plaza;

    if(f_gestorId!=undefined)
      if(f_gestorId!='')
        url_filtro_reporte= url_filtro_reporte +"&fgestorId="+f_gestorId;
    
    $("#filtro_reporte").attr("href", url_filtro_reporte);

    document.cookie = "url-tmp-back="+url_filtro_reporte;
  } 

  function filtrarReporte()
  {
    crearHref();
    window.location = $("#filtro_reporte").attr("href");
  }
  
</script>