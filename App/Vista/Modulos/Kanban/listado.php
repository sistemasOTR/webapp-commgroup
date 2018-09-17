<?php
  include_once PATH_NEGOCIO."Funciones/Fechas/fechas.class.php"; 
  include_once PATH_NEGOCIO."Funciones/Array/funcionesarray.class.php"; 
  include_once PATH_NEGOCIO."Usuarios/handlerusuarios.class.php";     
  include_once PATH_NEGOCIO."Usuarios/handlerplazausuarios.class.php"; 
  include_once PATH_NEGOCIO."Modulos/handlerkanban.class.php"; 
 
  $user = $usuarioActivoSesion;
  $handlerUs = new HandlerUsuarios;
  $dFecha = new Fechas;
  $handlerKB = new HandlerKanban;
  include_once 'pendientes.php';
  # URLs externas #
  $url_action_nueva_tarea = PATH_VISTA.'Modulos/Kanban/action_nueva_tarea.php';
  $url_js = PATH_VISTA.'Modulos/Kanban/kanban.js';
?>
<style>
  .panel .box-header {padding: 0 !important;}
  .panel .box-header a {padding: 10px !important; display: block; color: #fff; width: 100%}
  .bg-red:hover {background: #cc4b39 !important}
  .bg-yellow:hover {background: #f38b12 !important}
  .bg-aqua:hover {background: #00c0bc !important}
</style>

<div class="content-wrapper">  
  <section class="content-header">
    <h1>
      Sistema de tickets
      <small></small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
      <li class="active">Kanban</li>
    </ol>
  </section>        
  
  <section class="content">
    <?php include_once PATH_VISTA."error.php"; ?>
    <?php include_once PATH_VISTA."info.php"; ?>
    <div class="row">
      <div class="col-md-4">
        <div class="box box-solid">
            <div class="box-header with-border">
              <h3 class="box-title">Solicitudes</h3>
              <a href="#" class="btn btn-info pull-right btn-new" data-toggle='modal' data-target='#modal-nuevo'>
                  <i class="fa fa-plus"></i> Nueva
              </a>
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
              <div class="box-group" id="accordion">
                <!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->
                <div class="panel box box-solid">
                  <div class="box-header with-border bg-red">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                      <h4 class="box-title">
                        Pendientes 
                      </h4>
                      <span class="pull-right badge bg-black"><?php echo $cantPend ?></span>
                    </a>
                  </div>
                  <div id="collapseOne" class="panel-collapse in">
                    <div class="box-body no-padding">
                      <ul class="nav nav-stacked">
                        <?php echo $list_pendientes; ?>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
              <div class="box-group" id="accordion2">
                <div class="panel box box-solid">
                  <div class="box-header with-border bg-yellow">
                    <a data-toggle="collapse" data-parent="#accordion2" href="#collapseTwo">
                      <h4 class="box-title">
                        En Curso
                      </h4>
                    </a>
                  </div>
                  <div id="collapseTwo" class="panel-collapse in">
                    <div class="box-body">
                      Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3
                      wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum
                      eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla
                      assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred
                      nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer
                      farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus
                      labore sustainable VHS.
                    </div>
                  </div>
                </div>
              </div>
              <div class="box-group" id="accordion3">
                <div class="panel box box-solid">
                  <div class="box-header with-border bg-aqua">
                    <a data-toggle="collapse" data-parent="#accordion3" href="#collapseThree">
                      <h4 class="box-title">
                        En Revisión
                      </h4>
                    </a>
                  </div>
                  <div id="collapseThree" class="panel-collapse in">
                    <div class="box-body">
                      Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3
                      wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum
                      eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla
                      assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred
                      nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer
                      farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus
                      labore sustainable VHS.
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
      </div>
    </div>
  </section>
</div>
<?php include_once 'modales.php'; ?>
<script type="text/javascript" language="javascript" src='<?php echo $url_js; ?>'></script>