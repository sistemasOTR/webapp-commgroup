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
  include_once 'terminadas.php';
  # URLs externas #
  $url_action_nueva_tarea = PATH_VISTA.'Modulos/Kanban/action_nueva_tarea.php';
  $url_action_asignar_user = PATH_VISTA.'Modulos/Kanban/action_asignar_user.php';
  $url_action_asignar_fechas = PATH_VISTA.'Modulos/Kanban/action_asignar_fecha.php';
  $url_action_cambio_estado = PATH_VISTA.'Modulos/Kanban/action_cambio_estado.php';
  $url_js = PATH_VISTA.'Modulos/Kanban/kanban_finish.js';
  $url_ajax = PATH_VISTA.'Modulos/Kanban/detalle.php';
?>
<style>
  .panel .box-header {padding: 0 !important;}
  .panel .box-header a {padding: 10px !important; display: block; color: #fff; width: 100%}
  .bg-red:hover {background: #cc4b39 !important}
  .bg-yellow:hover {background: #f38b12 !important}
  .bg-aqua:hover {background: #00c0bc !important}
  .asignaciones {padding: 15px 0 0;}
  .asig-user-image {float: left;width: 35px;height: 35px;border-radius: 50%;margin-right: 5px;text-align: center;padding: 7px;}

  .lsp {flex-grow: 1;padding:10px 0px;}
  .lsa {flex-grow: 1;}
  .lsp span {padding: 5px}
  .item-flex {display: flex !important;}
  .btn-sol {flex-grow: 100;}
  .historia {color: #777;font-size: 12px;}
  @media (min-width: 768px){
    .div-conteiner {max-height: calc(100vh - 230px); overflow-y: auto;}
  }

</style>

<div class="content-wrapper">    
  
  <section class="content">
    <?php include_once PATH_VISTA."error.php"; ?>
    <?php include_once PATH_VISTA."info.php"; ?>
    <div class="row">
      <div class="col-md-6">
        <div class="box box-solid">
            <div class="box-header with-border">
              <h3 class="box-title">Solicitudes</h3><!-- 
              <a href="#" class="btn btn-info pull-right btn-new" data-toggle='modal' data-target='#modal-nuevo'>
                  <i class="fa fa-plus"></i> Nueva
              </a> -->
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding div-conteiner">
              <div class="box-group" id="accordion">
                <!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->
                <div class="panel box box-solid">
                  <div class="box-header with-border bg-green">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                      <h4 class="box-title">
                        Tareas Terminadas 
                      </h4>
                      <span class="pull-right badge bg-black"><?php echo $cantTerminadas ?></span>
                    </a>
                  </div>
                  <div id="collapseOne" class="panel-collapse in">
                    <div class="box-body no-padding">
                      <ul class="nav nav-stacked">
                        <?php echo $list_terminadas; ?>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
      </div>
      <div class="col-md-6">
              <div id="detalle"></div>
        
        </div>
      </div>
    </div>
  </section>
</div>
<?php include_once 'modales.php'; ?>
<script type="text/javascript" language="javascript" src='<?php echo $url_js; ?>'></script>

<script>
  

  $(document).ready(function(){                
  $(".btn-sol").on('click',function(){
    var id = $(this).attr("data-idsol"),
        id_operador = $(this).attr("data-idoperador"),
        self=this;


        $.ajax({
            type: "POST",
            url: '<?php echo $url_ajax; ?>',
            data: {
                id: id,
                id_operador: id_operador
            },
            success: function(data){
                $('#detalle').html(data);
            }
        });
  });


});
</script>