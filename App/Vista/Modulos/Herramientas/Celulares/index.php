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

  $handler = new HandlerSistema;
  $handlerCel = new HandlerCelulares;
  $handlerUs = new HandlerUsuarios;

  $user = $usuarioActivoSesion;
  $fgestor=(isset($_GET["fgestor"])?$_GET["fgestor"]:'');
  $fgestorId=(isset($_GET["fgestorId"])?$_GET["fgestorId"]:0);
  $arrCoordinador = $handler->selectAllPlazasArray();
  $arrUsuarios = $handlerUs->selectTodos();

  /*$url_detalle = "index.php?view=impresora_detalle";
  $url_asignacion = "index.php?view=asignar_imp";
  $url_impresion = PATH_VISTA.'Modulos/Herramientas/Impresoras/imprimir_comodato.php?';*/

  /*$url_action_guardar = PATH_VISTA.'Modulos/Herramientas/Impresoras/action_guardar.php';
  $url_action_devolver = PATH_VISTA.'Modulos/Herramientas/Impresoras/action_devolver.php';
  $url_action_baja = PATH_VISTA.'Modulos/Herramientas/Impresoras/action_baja.php';*/
  

?>
<style>
  .box-header.with-border {height: 55px;}
</style>
<div class="content-wrapper">  
  <section class="content-header">
    <h1>
      Líneas y Equipos
      <small>Control de líneas y equipos</small>
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

    <div class="row" style="display: none;">
      <div class="col-md-12">
        <div class="box box-solid">
          <div class="box-header with-border">   
            <i class="fa fa-mobile"></i>       
            <h3 class="box-title">Equipos</h3>          
          </div>
          <div class="box-body">

           <?php include_once "filtros.php"; ?>
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
      <div class="col-md-7">

         

            <?php 
              switch ($user->getUsuarioPerfil()->getNombre()) {
                //case 'COORDINADOR':

                  //  include_once "vista_coordinador.php";
                    
                 // break;

                case 'GERENCIA' || 'BACK OFFICE':
                    include_once "vista_admin.php";
                    
                  break;                                            
              }
            ?>
          

      </div>
    <div class="col-md-2">

         

            <?php 
              switch ($user->getUsuarioPerfil()->getNombre()) {
                //case 'COORDINADOR':

                  //  include_once "vista_coordinador.php";
                    
                 // break;

                case 'GERENCIA' || 'BACK OFFICE':
                    include_once "lineas_libres_admin.php";
                    
                  break;                                            
              }
            ?>
          

      </div>
    <div class="col-md-3">

         

            <?php 
              switch ($user->getUsuarioPerfil()->getNombre()) {
                //case 'COORDINADOR':

                  //  include_once "vista_coordinador.php";
                    
                 // break;

                case 'GERENCIA' || 'BACK OFFICE':
                    include_once "equipos_libres_admin.php";
                    
                  break;                                            
              }
            ?>
          

      </div>
    </div>
  </section>
  
  <div class="modal fade in" id="modal-devolver">
    <div class="modal-dialog">
      <div class="modal-content">

        <form id="asig-form" action="<?php echo $url_action_devolver; ?>" method="post">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span></button>
            <h4 class="modal-title">Devolución de Impresora</h4>
          </div>
          <div class="modal-body">
              <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <label>Fecha de devolución</label>
                    <input type="date" name="fechaDev" class="form-control">
                    <input type="text" style="display: none" id="asigId" name="asigId">
                    <label>Observaciones</label>
                  <textarea name="txtObs" id="txtObs" class="form-control" rows="5"></textarea>
                </div>
              </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-primary">Devolver</button>
          </div>
        </form>

      </div>
    </div>
  </div>
  <div class="modal fade in" id="modal-baja">
    <div class="modal-dialog">
      <div class="modal-content">

        <form id="asig-form" action="<?php echo $url_action_baja; ?>" method="post">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span></button>
            <h4 class="modal-title">Baja de Impresora</h4>
          </div>
          <div class="modal-body">
              <div class="row">
              	<div class="col-md-10 col-md-offset-1">
                    <label>Fecha de baja</label>
                    <input type="date" name="fechaBaja" class="form-control">
                    <input type="text" style="display: none" id="bajaSerialNro" name="bajaSerialNro">
                    <label>Observaciones</label>
                	<textarea name="txtObsImp" id="txtObsImp" class="form-control" rows="5"></textarea>
                </div>
              </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-danger">Dar de baja</button>
          </div>
        </form>

      </div>
    </div>
  </div>
</div>



<script type="text/javascript">        
  $(document).ready(function(){                
    $("#mnu_herramientas").addClass("active");
  });

  $(document).ready(function() {
    $("#slt_gestor").select2({
        placeholder: "Seleccionar",                  
    }).on('change', function (e) { 
      filtrarReporte(); 
    });
  });

  function cargarDatos(id){
    
    asigId = document.getElementById(id).getAttribute('data-asigId');
    obs = document.getElementById(id).getAttribute('data-obs');
    
    document.getElementById("asigId").value = asigId;
    document.getElementById("txtObs").value = obs;
    
  }

function bajaImp(id){
    console.log(id);
    serialNro = document.getElementById(id+'_edit').getAttribute('data-serialnro');
    obsimp = document.getElementById(id+'_edit').getAttribute('data-obsimp');
    console.log(serialNro);
    document.getElementById("bajaSerialNro").value = "'" + serialNro + "'" ;
    if(obsimp!=undefined)
      document.getElementById("txtObsImp").value = obsimp;
    else
      document.getElementById("txtObsImp").value = ' ';
    
  }




  function crearHref()
  {
    f_gestorId = $("#slt_gestor").val();
    f_plaza = $("#slt_plaza").val();   
    url_filtro_reporte="index.php?view=impresorasxplaza";

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
