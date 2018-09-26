<?php	

	include_once "../../Config/config.ini.php";
	include_once '../../Datos/BaseDatos/conexionapp.class.php';
	include_once '../../Datos/BaseDatos/sql.class.php';
	include_once PATH_NEGOCIO."Funciones/Fechas/fechas.class.php"; 
	include_once PATH_NEGOCIO."Funciones/Array/funcionesarray.class.php"; 
	include_once PATH_NEGOCIO."Usuarios/handlerusuarios.class.php";     
	include_once PATH_NEGOCIO."Usuarios/handlerplazausuarios.class.php"; 
	include_once PATH_NEGOCIO."Modulos/handlerkanban.class.php"; 
	include_once PATH_NEGOCIO."Funciones/String/string.class.php";
	$handlerUs = new HandlerUsuarios;
	$dFecha = new Fechas;
	$handlerKB = new HandlerKanban;
	$id = $_POST['id'];
	$id_user = $_POST['id_user'];
	

    $url_kanban = 'index.php?view=kanban';
    $url_kanban_terminadas = 'index.php?view=kanban_terminadas';
    $url_borrar_notificacion = PATH_VISTA.'Notificaciones/action_borrar_KB.php';


	try {
		$handlerKB->borrarNotificacion($id);

		$arrNotifKB = $handlerKB->selectNotificacionesByUser($id_user);
	    $cantNotifKB = count($arrNotifKB);
	    $rta = '';

	    if (!empty($arrNotifKB)) { 
	    	
	    	$rta .= '<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
	    		        <i class="fa fa-bookmark-o" data-toggle="tooltip" data-placement="bottom"  title="Solicitudes"></i> 
	    		        <span id="contador_noti_user" class="label" style="font-size:12px;"></span>
	    		        <span id="contador_noti_empresa" class="label label-danger" data-toggle="tooltip" data-placement="bottom"  title="Solicitudes" style="font-size:12px;">'.$cantNotifKB.'</span>
	    		        </a>
	    		        <ul class="dropdown-menu">
	    		        	<li>
	    		        		<div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: auto;">
	    		        			<ul class="menu" style="overflow: auto; width: 100%; height: auto;">';
	    		          	             foreach ($arrNotifKB as $key => $value) { 
	                						$rta .= '<li>
	                									<a class="pull-left" style="max-width: 88%" title="'.$value->getDescripcion().'" href="'.$url_kanban.'">'.$value->getDescripcion().'</a>
	                	                   				<a class="pull-right close-notif" data-id="'.$value->getId().'" data-iduser="'.$value->getIdUser().'" href="#">×</a>
	                	                			</li>';
	                	                 } 
	            $rta.= '</ul>
	            	</div>
	            </li>
			</ul>';
		}
		echo $rta;


	} catch (Exception $e) {
		header("Location: ".$url);
	}
	
?>