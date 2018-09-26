<?php 
    include_once PATH_NEGOCIO."Usuarios/handlerusuarios.class.php";
    include_once PATH_NEGOCIO."Modulos/handlerkanban.class.php";
    include_once PATH_NEGOCIO."Funciones/Fechas/fechas.class.php";

    $user = $usuarioActivoSesion;
    $handlerKB = new HandlerKanban;
    $handlerUs = new HandlerUsuarios;

    $url_kanban = 'index.php?view=kanban';
    $url_kanban_terminadas = 'index.php?view=kanban_terminadas';
    $url_borrar_notificacion = PATH_VISTA.'Notificaciones/action_borrar_KB.php';

    $arrNotifKB = $handlerKB->selectNotificacionesByUser($user->getId());
    $cantNotifKB = count($arrNotifKB);

    if (!empty($arrNotifKB)) { ?>
    	<li class="dropdown notifications-menu" id="notiKB">
      <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
        <i class="fa fa-bookmark-o" data-toggle='tooltip' data-placement="bottom"  title='Solicitudes'></i> 
        <span id="contador_noti_user" class="label" style="font-size:12px;"></span>
          <span id="contador_noti_empresa" class="label label-danger" data-toggle='tooltip' data-placement="bottom"  title='Solicitudes' style="font-size:12px;">
            <?php echo ($cantNotifKB); ?>
          </span>
      </a>
      <ul class="dropdown-menu">
        
        <li>
          <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: auto;">
            <ul class="menu" style="overflow: auto; width: 100%; height: auto;">
              <?php foreach ($arrNotifKB as $key => $value) { ?>
                <li>
                	<?php 
                		if (substr_compare($value->getDescripcion(),'Se ha final',0,10) == 0) {
                			$url_kanban='index.php?view=kanban_terminadas';
                		} else {
                			 $url_kanban = 'index.php?view=kanban';
                		}
                	 ?>
                  <a class="pull-left" style="max-width: 88%" title='<?php echo $value->getDescripcion(); ?>' href='<?php echo $url_kanban; ?>'><?php echo $value->getDescripcion(); ?>
                  </a>
                  <a class='pull-right close-notif' data-id="<?php echo $value->getId() ?>" data-iduser="<?php echo $value->getIdUser() ?>" href='#'>×</a>
                </li>
              <?php } ?>
            </ul>
          </div>
        </li>
      </ul>
    </li>
    <?php } ?>


    <script>
    	$(document).ready(function(){
  		  $(".close-notif").on('click',function(){
  		    var id = $(this).attr("data-id"),
  		    	id_user = $(this).attr("data-iduser"),
  		        self=this;


  		        $.ajax({
  		            type: "POST",
  		            url: '<?php echo $url_borrar_notificacion; ?>',
  		            data: {
  		                id: id,
  		                id_user:id_user
  		            },
  		            success: function(data){
  		                $('#notiKB').html(data);
  		            }
  		        });
  		  });
  		});
      $( document ).ajaxComplete(function() {
        $(".close-notif").on('click',function(){
          var id = $(this).attr("data-id"),
            id_user = $(this).attr("data-iduser"),
              self=this;


              $.ajax({
                  type: "POST",
                  url: '<?php echo $url_borrar_notificacion; ?>',
                  data: {
                      id: id,
                      id_user:id_user
                  },
                  success: function(data){
                      $('#notiKB').html(data);
                  }
              });
        });
      });
    </script>