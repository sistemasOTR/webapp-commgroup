<?php
	include_once PATH_NEGOCIO."Usuarios/handlerusuarios.class.php";	
	include_once PATH_NEGOCIO."AccesoSistema/accesosistema.class.php";	

	$url_logout = PATH_VISTA."Login/action_logout.php";	

	//###########################################
	//   Validacion de la sesion del usuario
	//###########################################	

	session_start([
	    'cookie_lifetime' => 2592000,
	    'gc_maxlifetime'  => 2592000,
	]);
    if(!isset($_SESSION["usuario"]) || !isset($_SESSION["logueado"]) || !isset($_SESSION["pass"]))
        header("Location: ".$url_logout);     

	//########################################################################################################################
	//   Registro el login del usuario en cada peticion
	//########################################################################################################################

    $acceso = new AccesoSistema;
    $acceso->registrarLoginLog($_SESSION["usuario"]);

	//########################################################################################################################
	//   Seteo un objeto Usuario (usuario activo) para que este disponible en toda la aplicacion. Proviene de la $_SESSION
	//########################################################################################################################
    
    $handler = new HandlerUsuarios;
    $usuarioActivoSesion = $handler->selectById($_SESSION["usuario"]);    
	
	//##################################
	//   Instancio la clase de permisos
	//##################################	
	$permiso=$handler->selectPerfil($usuarioActivoSesion->getId());
	$perfil =$usuarioActivoSesion->getUsuarioPerfil()->getId();

	if(is_null($usuarioActivoSesion->getTipoUsuario()))
		$tipo_usuario = $usuarioActivoSesion->getTipoUsuario()->getId();
	else
		$tipo_usuario = 0;

	$include="";

	//##################################
	//   Seteo el permiso del usuario
	//##################################	
        
        $esAdmin = false;
        $esGerencia = false; 
        $esCliente = false;                            
        $esBO = false;                        
        $esCoordinador = false;                         
        $esGestor = false;
        $esIngresante = false;
        $esDesarrollo = false;
        $esSupervisor = false;
        $esRRHH = false;
        $esContabilidad = false;

        $handler = new HandlerUsuarios;
        $permiso = $handler->selectPerfil($usuarioActivoSesion->getId());                        
        
        switch ($permiso->getNombre()) {
          case "ADMINISTRADOR":
            $esAdmin = true;
            break;

          case "GERENCIA":
            $esGerencia = true;
            break;
          
          case "BACK OFFICE":
            $esBO = true;
            break;
          
          case "RRHH":
            $esRRHH = true;
            break;
          
          case "CONTABILIDAD":
            $esContabilidad = true;
            break;

          case "COORDINADOR":
            $esCoordinador = true;
            break;

          case "GESTOR":
            $esGestor = true;
            break;

          case "CLIENTE":
            $esCliente = true;
            break;   

          case "INGRESANTE":
            $esIngresante = true;
            break;   

          case "PRUEBA-DESA":
            $esDesarrollo = true;
            break;   

          case "SUPERVISOR":
            $esSupervisor = true;
            break;
        }        

	//############################
	//   Ruteo de la aplicacion
	//############################

    if(isset($_GET["view"]))
        $view=$_GET["view"];
    else
        $view="";

	include_once "head.php";
	include_once "header.php";
	include_once "siderbar.php";
	include_once 'siderbar_right.php';

	switch ($view) {

		  /*###############*/
		 /* PANEL CONTROL */
		/*###############*/		
		case 'panelcontrol':			
			if($permiso->getModuloPanelBoolean() && $esCliente)
				$include = 'Modulos/PanelControl/v2/cliente.php';			
			elseif ($permiso->getModuloPanelBoolean() && $esGestor)
				$include = 'Modulos/PanelControl/v2/gestor.php';		
			elseif ($permiso->getModuloPanelBoolean() && $esCoordinador)	
				$include = 'Modulos/PanelControl/v2/coordinador.php';		
			elseif ($permiso->getModuloPanelBoolean() && $esGerencia)
				$include = 'Modulos/PanelControl/v2/gerencia.php';		
			elseif ($permiso->getModuloPanelBoolean() && $esBO)
				$include = 'Modulos/PanelControl/bo.php';				
			elseif ($permiso->getModuloPanelBoolean() && $esRRHH)
				$include = 'Modulos/PanelControl/rrhh.php';				
			elseif ($permiso->getModuloPanelBoolean() && $esContabilidad)
				$include = 'Modulos/PanelControl/contab.php';		
			elseif ($permiso->getModuloPanelBoolean() && $esIngresante)
				$include = 'Modulos/PanelControl/ingresante.php';		
			elseif ($permiso->getModuloPanelBoolean() && $esDesarrollo)
				$include = 'Modulos/PanelControl/desarrollo.php';		
			elseif ($permiso->getModuloPanelBoolean() && $esSupervisor)
				$include = 'Modulos/PanelControl/v2/supervisor.php';				
			break;		

		// *****************************
		// FALTAN DESARROLLAR
		// *****************************
		case 'panel-cliente':			
			$include = 'Modulos/PanelControl/_revisar/clientes.php';			
			break;

		case 'panel-gestor':			
			$include = 'Modulos/PanelControl/_revisar/gestor.php';			
			break;

		case 'panel-gerencia':			
			$include = 'Modulos/PanelControl/_revisar/gerencia.php';			
			break;

		case 'panel-supervisor':			
			$include = 'Modulos/PanelControl/_revisar/supervisor.php';						
			break;

		case 'metrica-rosario':			
			$include = 'Modulos/PanelControl/_revisar/metrica_rosario.php';						
			break;

		case 'metrica-servicio':			
			$include = 'Modulos/PanelControl/_revisar/metrica_servicios.php';						
			break;	

		  /*###########*/
		 /* SERVICIOS */
		/*###########*/
		case 'servicio':				
			if($permiso->getModuloServiciosBoolean())
				$include = 'Modulos/Servicio/index.php';			
			break;

		case 'servicio_resumen':				
			if($permiso->getModuloServiciosBoolean())
				$include = 'Modulos/Servicio/resumen.php';			
			break;

		case 'detalle_servicio':				
			if($permiso->getModuloServiciosBoolean())
				$include = 'Modulos/Servicio/detalle.php';			
			break;

		case 'upload_file':	
			if($permiso->getModuloUploadBoolean())		
				$include = 'Modulos/Servicio/UploadFile/uploadfile.php';
			
			break;

		  /*#######*/
		 /* INBOX */
		/*#######*/
		case 'inbox':				
			if($permiso->getModuloInboxBoolean())
				$include = 'Modulos/Inbox/index.php';			
			break;

		  /*############*/
		 /* INVENTARIO */
		/*############*/
		case 'exp_control':				
			if($permiso->getModuloInventariosBoolean() && ($esBO || $esContabilidad))
				$include = 'Modulos/Expediciones/control.php';			
			break;

		case 'exp_remito':				
			if($permiso->getModuloInventariosBoolean() && ($esContabilidad || $esBO))
				$include = 'Modulos/Expediciones/remitos.php';		
			break;

		case 'exp_detalle_remito':				
			if($permiso->getModuloInventariosBoolean() && ($esContabilidad || $esBO))
	            $include = 'Modulos/Expediciones/detalle_remitos.php';		
			break;	

		case 'exp_control_coordinador':				
			if($permiso->getModuloInventariosBoolean() && ($usuarioActivoSesion->getId()==10164))
				$include = 'Modulos/Expediciones/control_coordinador.php';			
			break;	

		case 'exp_tipo_abm':				
			if($permiso->getModuloInventariosBoolean() && ($esBO || $esContabilidad))
				$include = 'Modulos/Expediciones/tipo_abm.php';			
			break;
		case 'exp_item_abm':				
			if($permiso->getModuloInventariosBoolean() && ($esBO || $esContabilidad))
				$include = 'Modulos/Expediciones/item_abm.php';			
			break;	

		case 'exp_solicitud':				
			if($permiso->getModuloInventariosBoolean() && ($esBO || $esCoordinador|| $esContabilidad || $esRRHH))
				$include = 'Modulos/Expediciones/solicitud.php';
			break;
		case 'exp_seguimiento_remito':				
			if($permiso->getModuloInventariosBoolean() && $esCoordinador)
				$include = 'Modulos/Expediciones/seguimiento_remito.php';
			break;

		case 'exp_recibir_remito':				
			if($permiso->getModuloInventariosBoolean() && $esCoordinador)
				$include = 'Modulos/Expediciones/recibir_remito.php';
			break;	

		case 'exp_detalle':				
			if($permiso->getModuloInventariosBoolean() && ($esCoordinador || ($esBO || $esContabilidad || $esRRHH)))
				$include = 'Modulos/Expediciones/detalle_pedido.php';			
			break;

		case 'exp_seguimiento':				
			if($permiso->getModuloInventariosBoolean() && ($esCoordinador || $esBO || $esContabilidad || $esRRHH))
				$include = 'Modulos/Expediciones/seguimiento.php';			
			break;

			case 'exp_compra':				
			if($permiso->getModuloInventariosBoolean() && (($esBO || $esContabilidad)))
				$include = 'Modulos/Expediciones/compra.php';			
			break;		

		  /*#######*/
		 /* GUIAS */
		/*#######*/
		case 'guias_control':				
			if($permiso->getModuloGuiasBoolean() && ($esBO || $esContabilidad || $esRRHH))
				$include = 'Modulos/Guias/control.php';			
			break;

		case 'guias_control_empresa':				
			if($permiso->getModuloGuiasBoolean() && $esCliente)
				$include = 'Modulos/Guias/control_empresa.php';			
			break;

		case 'guias_envios':				
			if($permiso->getModuloGuiasBoolean() && $esCoordinador)
				$include = 'Modulos/Guias/envios.php';			
			break;

		case 'guias_seguimiento':				
			if($permiso->getModuloGuiasBoolean() && $esCoordinador)
				$include = 'Modulos/Guias/seguimiento.php';			
			break;		

		  /*########*/
		 /* PERFIL */
		/*########*/
		case 'perfil_usuario':
			if($permiso->getModuloPerfilBoolean())
				$include = 'Modulos/UsuariosPerfil/index.php';
			break;

		case 'password_usuario':
			if($permiso->getModuloPerfilBoolean())
				$include = 'Modulos/UsuariosPerfil/change_password.php';
			break;

		  /*##############*/
		 /* MULTIUSUARIO */
		/*##############*/
		case 'cambiarUsuario':			
			if($permiso->getModuloMultiusuarioBoolean())
				$include = 'Modulos/UsuariosAdmin/activar_tipo_usuario.php';
			break;			

		  /*##############*/
		 /* ROL USUARIO */
		/*##############*/
		case 'cambioRol':			
			if($usuarioActivoSesion->getCambioRol())
				$include = 'Modulos/UsuariosAdmin/cambiar_rol_usuario.php';
			break;	

		  /*##############*/
		 /* USUARIOS ABM */
		/*##############*/
		case 'usuarioABM':
			if($permiso->getModuloUsuariosBoolean())
				$include = 'Modulos/UsuariosAdmin/index.php';
			break;

		case 'usuarioABM_edit':
			if($permiso->getModuloUsuariosBoolean())
				$include = 'Modulos/UsuariosAdmin/edit_usuario.php';
			break;

		case 'usuarioABM_add':
			if($permiso->getModuloUsuariosBoolean())
				$include = 'Modulos/UsuariosAdmin/add_usuario.php';
			break;

		case 'usuarioABM_multiuser':
			if($permiso->getModuloUsuariosBoolean())
				$include = 'Modulos/UsuariosAdmin/multiusuario.php';
			break;

		  /*#############*/
		 /* IMPORTACION */
		/*#############*/
		case 'importacion':
			if($permiso->getModuloImportacionBoolean() && $esCliente){
				if(is_object($usuarioActivoSesion->getTipoUsuario())){
					if($usuarioActivoSesion->getTipoUsuario()->getId()==1)
						$include = 'Modulos/Importacion/index.php';
				}
			}
			break;

		case 'importacion_manual':
			if($permiso->getModuloImportacionBoolean() && $esCliente){
				if(is_object($usuarioActivoSesion->getTipoUsuario())){
					if($usuarioActivoSesion->getTipoUsuario()->getId()==1)
						$include = 'Modulos/Importacion/index_formulario.php';
				}
			}
			break;

		case 'importacion_1':
			if($permiso->getModuloImportacionBoolean() && $esCliente){
				if(is_object($usuarioActivoSesion->getTipoUsuario())){
					if($usuarioActivoSesion->getTipoUsuario()->getId()==1)
						$include = 'Modulos/Importacion/importacion_1.php';
				}
			}
			break;

		case 'importacion_2':
			if($permiso->getModuloImportacionBoolean() && $esCliente){
				if(is_object($usuarioActivoSesion->getTipoUsuario())){
					if($usuarioActivoSesion->getTipoUsuario()->getId()==1)
						$include = 'Modulos/Importacion/importacion_2.php';
				}
			}
			break;

		case 'importacion_3':
			if($permiso->getModuloImportacionBoolean() && $esCliente){
				if(is_object($usuarioActivoSesion->getTipoUsuario())){
					if($usuarioActivoSesion->getTipoUsuario()->getId()==1)
						$include = 'Modulos/Importacion/importacion_3.php';
				}
			}
			break;

		case 'importacion_detalle':
			if($permiso->getModuloImportacionBoolean() && $esCliente){
				if(is_object($usuarioActivoSesion->getTipoUsuario())){
					if($usuarioActivoSesion->getTipoUsuario()->getId()==1)
						$include = 'Modulos/Importacion/index_detalle.php';
				}
			}
			break;

		case 'cp_plaza':
			if($permiso->getModuloImportacionBoolean() && ($esGerencia || $esBO || $esContabilidad || $esRRHH || $esCoordinador || $esSupervisor)){								
				$include = 'Modulos/Importacion/cp_abm.php';				
			}
			break;

		case 'importaciones_sin_plaza':
			if($permiso->getModuloImportacionBoolean() && ($esGerencia || $esBO || $esContabilidad || $esRRHH || $esCoordinador || $esSupervisor)){								
				$include = 'Modulos/Importacion/importacion_sin_plaza.php';				
			}
			break;

		case 'importaciones_sin_importar':
			if($permiso->getModuloImportacionBoolean() && ($esGerencia || $esBO || $esContabilidad || $esRRHH || $esCoordinador || $esSupervisor)){								
				$include = 'Modulos/Importacion/importacion_sin_importar.php';				
			}
			break;

		  /*##########*/
		 /* METRICAS */
		/*##########*/
		case 'estadisticas':
			if($permiso->getModuloMetricasBoolean())
				$include = 'Modulos/Estadisticas/index.php';
			break;

		case 'estadisticas_plaza':
			if($permiso->getModuloMetricasBoolean() && $esGerencia)
				$include = 'Modulos/Estadisticas/estadisticas_plazas.php';
			break;

        case 'estadisticas_global':
			if($permiso->getModuloMetricasBoolean() && $esGerencia)
				$include = 'Modulos/Estadisticas/estadisticas_global.php';
			break;

		case 'estadisticas_gestor':
			if($permiso->getModuloMetricasBoolean() && $esGestor)
				$include = 'Modulos/Estadisticas/estadisticas_gestor.php';
			break;
			
		case 'estadisticas_coordinador':
			if($permiso->getModuloMetricasBoolean() && $esCoordinador)
				$include = 'Modulos/Estadisticas/estadisticas_coordinador.php';
			break;	

		  /*###############*/
		 /* CONFIGURACION */
		/*###############*/
		case 'configuraciones':
			if($permiso->getModuloConfiguracionBoolean())
				$include = 'Modulos/Configuraciones/index.php';
			break;

		case 'detalle':
			if($permiso->getModuloConfiguracionBoolean())
				$include = 'Modulos/Configuraciones/detalle_ver.php';
			break;

		  /*#######*/
		 /* AYUDA */
		/*#######*/
		case 'ayuda':			
			if($permiso->getModuloAyudaBoolean())
				$include = 'Modulos/Ayuda/index.php';
			break;

		case 'grupo_ayuda':				
			if($permiso->getModuloAyudaBoolean() && $esGerencia)
				$include = 'Modulos/Ayuda/grupo.php';			
			break;

		case 'documento_ayuda':		
			if($permiso->getModuloAyudaBoolean() && $esGerencia)
				$include = 'Modulos/Ayuda/documentos.php';			
			break;

		  /*#########*/
		 /* LEGAJOS */
		/*#########*/
		case 'legajos_carga':			
			if($permiso->getModuloLegajosBoolean()  && ($esGestor || $esGerencia || $esBO || $esContabilidad || $esRRHH || $esCoordinador || $esIngresante || $esSupervisor))
				$include = 'Modulos/Legajos/carga.php';
			break;		

		case 'legajos_control':			
			if($permiso->getModuloLegajosBoolean() && (($esBO || $esContabilidad || $esRRHH) || $esCoordinador))
				$include = 'Modulos/Legajos/control.php';
			break;

	    case 'legajos_basicos':			
			if($permiso->getModuloLegajosBoolean() && (($esBO || $esContabilidad || $esRRHH) || $esCoordinador))
				$include = 'Modulos/Legajos/basicos.php';
			break;				
        
        case 'legajos_categorias':			
			if($permiso->getModuloLegajosBoolean() && (($esBO || $esContabilidad || $esRRHH) || $esCoordinador))
				$include = 'Modulos/Legajos/categorias.php';
			break;

		case 'legajos_actualizar':			
			if($permiso->getModuloLegajosBoolean() && (($esBO || $esContabilidad || $esRRHH) || $esCoordinador))
				$include = 'Modulos/Legajos/actualizar.php';
			break;	

		  /*########*/
		 /* TICKET */
		/*########*/
		case 'tickets_carga':			
			if($permiso->getModuloTicketsBoolean() && ($esGestor || $esGerencia || ($esBO || $esContabilidad || $esRRHH) || $esCoordinador || $esIngresante || $esSupervisor))
				$include = 'Modulos/Ticket/index.php';
			break;		

		case 'tickets_detalle':			
			if($permiso->getModuloTicketsBoolean() && ($esGestor || $esGerencia || ($esBO||$esRRHH||$esContabilidad) || $esCoordinador || $esIngresante || $esSupervisor))
				$include = 'Modulos/Ticket/ticket_detalle.php';
			break;	

		case 'tickets_control':			
			if($permiso->getModuloTicketsBoolean() && $esCoordinador)
				$include = 'Modulos/Ticket/control.php';
			break;	

		case 'tickets_aprobar':			
			if($permiso->getModuloTicketsBoolean() && ($esBO || $esContabilidad || $esRRHH))
				$include = 'Modulos/Ticket/aprobar.php';
			break;	

		case 'tickets_conceptos':			
			if($permiso->getModuloTicketsBoolean() && ($esGerencia || ($esBO || $esContabilidad || $esRRHH) || $esCoordinador || $esSupervisor))
				$include = 'Modulos/Ticket/conceptos_abm.php';
			break;	
		
		case 'tickets_reintegros':			
			if($permiso->getModuloTicketsBoolean() && ($esBO || $esContabilidad || $esRRHH))
				$include = 'Modulos/Ticket/operacion_reintegro.php';
			break;	
		
		case 'tickets_resumen':			
			if($permiso->getModuloTicketsBoolean() && ($esBO || $esContabilidad || $esRRHH))
				$include = 'Modulos/Ticket/resumen.php';
			break;	

		case 'tickets_fechas_inhabilitadas':			
			if($permiso->getModuloTicketsBoolean() && ($esGerencia || ($esBO || $esContabilidad || $esRRHH) || $esCoordinador || $esSupervisor))
				$include = 'Modulos/Ticket/fechasinhabilitadas_abm.php';
			break;	

		  /*###########*/
		 /* LICENCIAS */
		/*###########*/
		case 'licencias_carga':			
			if($permiso->getModuloLicenciasBoolean() && ($esGestor || $esGerencia || ($esBO || $esContabilidad || $esRRHH) || $esCoordinador || $esIngresante || $esSupervisor))
				$include = 'Modulos/Licencias/generar.php';
			break;	

		case 'licencias_control':			
			if($permiso->getModuloLicenciasBoolean() && (($esBO || $esRRHH) || $esCoordinador))
				$include = 'Modulos/Licencias/control.php';
			break;	

		case 'licencias_controlcoord':			
			if($permiso->getModuloLicenciasBoolean() && (($esCoordinador)))
				$include = 'Modulos/Licencias/control_cord.php';
			break;

		case 'licencias_imprimir':			
			if($permiso->getModuloLicenciasBoolean() && (($esBO || $esRRHH) || $esCoordinador))
				$include = 'Modulos/Licencias/imprimir.php';
			break;	

		case 'tipo_licencias':				
			if($permiso->getModuloLicenciasBoolean()  && (($esBO || $esRRHH) || $esCoordinador))
				$include = 'Modulos/Licencias/tipo_licencias.php';			
			break;

		  /*################*/
		 /* CAPACITACIONES */
		/*################*/
		case 'capacitaciones':			
			if($permiso->getModuloCapacitacionesBoolean())
				$include = 'Modulos/Capacitaciones/index.php';
			break;	

		  /*################*/
		 /* PUNTAJES */
		/*################*/
		case 'puntajes_gestor':			
			if($permiso->getModuloPuntajesBoolean() && $esGestor)
				$include = 'Modulos/Puntajes/view_gestor.php';
			break;	

		case 'puntajes_gestor_detalle':	
			if($permiso->getModuloPuntajesBoolean() && $esGestor)
				$include = 'Modulos/Puntajes/view_gestor_detalle.php';
			break;	

		case 'puntajes_coordinador':			
			if($permiso->getModuloPuntajesBoolean() && $esCoordinador)
				$include = 'Modulos/Puntajes/view_coordinador.php';
			break;	

		case 'puntajes_coordinador_detalle':	
			if($permiso->getModuloPuntajesBoolean() && $esCoordinador)
				$include = 'Modulos/Puntajes/view_coordinador_detalle.php';
			break;	

		case 'puntajes_general':			
			if($permiso->getModuloPuntajesBoolean() && $esGerencia)
				$include = 'Modulos/Puntajes/view_general.php';
			break;	

		case 'puntajes_general_detalle':			
			if($permiso->getModuloPuntajesBoolean() && $esGerencia)
				$include = 'Modulos/Puntajes/view_general_detalle.php';
			break;	

		case 'puntajes_general_gestores':			
			if($permiso->getModuloPuntajesBoolean() && $esGerencia)
				$include = 'Modulos/Puntajes/view_general_gestores.php';
			break;	

		case 'puntajes_general_xgestor':			
			if($permiso->getModuloPuntajesBoolean() && ($esGerencia || $esCoordinador || $esGestor))
				$include = 'Modulos/Puntajes/view_general_xgestor.php';
			break;

		  /*##############*/
		 /* HERRAMIENTAS */
		/*##############*/
		case 'herramientas':			
			if($permiso->getModuloHerramientasBoolean())
				$include = 'Modulos/Herramientas/index.php';		
			break;

		case 'impresorasxplaza':			
			if($permiso->getModuloHerramientasBoolean())
				$include = 'Modulos/Herramientas/Impresoras/index.php';		
			break;
		
		case 'impresora_detalle':			
			if($permiso->getModuloHerramientasBoolean())
				$include = 'Modulos/Herramientas/Impresoras/detalle.php';		
			break;
		
		case 'consumo_impresora':			
			if($permiso->getModuloHerramientasBoolean())
				$include = 'Modulos/Herramientas/Impresoras/detalle_consumo.php';		
			break;
		
		case 'asignar_imp':			
			if($permiso->getModuloHerramientasBoolean())
				$include = 'Modulos/Herramientas/Impresoras/asignar_imp.php';		
			break;

		case 'imprimir_comodato':			
			if($permiso->getModuloHerramientasBoolean())
				$include = 'Modulos/Herramientas/Impresoras/imprimir_comodato.php';		
			break;

		case 'celulares':			
			if($permiso->getModuloHerramientasBoolean())
				$include = 'Modulos/Herramientas/Celulares/index.php';		
			break;

		case 'detalle_linea':			
			if($permiso->getModuloHerramientasBoolean())
				$include = 'Modulos/Herramientas/Celulares/detalle_linea.php';		
			break;

		case 'detalle_equipo':			
			if($permiso->getModuloHerramientasBoolean())
				$include = 'Modulos/Herramientas/Celulares/detalle_equipo.php';		
			break;
			
		case 'insumos':			
			if($permiso->getModuloHerramientasBoolean())
				$include = 'Modulos/Herramientas/Insumos/index.php';		
			break;


	      /*########*/
		 /* UPLOAD */
		/*########*/
		case 'upload_file':			
			if($permiso->getModuloUploadBoolean())
				$include = 'Modulos/UploadFile/uploadfile.php';		
			break;


	      /*########*/
		 /* AGENDA */
		/*########*/
		case 'agenda':			
			$include = 'Modulos/Agenda/index.php';		
			break;

		case 'agenda_detalle':			
			$include = 'Modulos/Agenda/detalle.php';		
			break;

		case 'agenda_rubros':			
			$include = 'Modulos/Agenda/rubros.php';		
			break;


	      /*#######*/
		 /* STOCK */
		/*#######*/
		case 'stock':			
			if($permiso->getModuloStockBoolean())
				$include = 'Modulos/Stock/index.php';		
			break;

	      /*##########*/
		 /* ENVIADAS */
		/*##########*/
		case 'enviadas':			
			if($permiso->getModuloEnviadasBoolean())
				$include = 'Modulos/Enviadas/index.php';		
			break;

	      /*##########*/
		 /* ROLES */
		/*##########*/
		case 'roles':			
			if($permiso->getModuloRolesBoolean())
				$include = 'Modulos/Roles/index.php';		
			break;

		case 'roles_edit':
			if($permiso->getModuloRolesBoolean())
				$include = 'Modulos/Roles/edit_roles.php';		
			break;		

		default:
			if($permiso->getModuloPanelBoolean() && $esCliente)	
				$include = 'Modulos/PanelControl/v2/cliente.php';			
			elseif ($permiso->getModuloPanelBoolean() && $esGestor)
				$include = 'Modulos/PanelControl/v2/gestor.php';		
			elseif ($permiso->getModuloPanelBoolean() && $esCoordinador)	
				$include = 'Modulos/PanelControl/v2/coordinador.php';		
			elseif ($permiso->getModuloPanelBoolean() && $esGerencia)
				$include = 'Modulos/PanelControl/v2/gerencia.php';		
			elseif ($permiso->getModuloPanelBoolean() && $esBO)
				$include = 'Modulos/PanelControl/bo.php';				
			elseif ($permiso->getModuloPanelBoolean() && $esRRHH)
				$include = 'Modulos/PanelControl/rrhh.php';				
			elseif ($permiso->getModuloPanelBoolean() && $esContabilidad)
				$include = 'Modulos/PanelControl/contab.php';		
			elseif ($permiso->getModuloPanelBoolean() && $esIngresante)
				$include = 'Modulos/PanelControl/ingresante.php';		
			elseif ($permiso->getModuloPanelBoolean() && $esDesarrollo)
				$include = 'Modulos/PanelControl/desarrollo.php';		
			break;		
	}	

	if($usuarioActivoSesion->getUsuarioPerfil()->getNombre()=="GESTOR" || 
		$usuarioActivoSesion->getUsuarioPerfil()->getNombre()=="CLIENTE" || 
		$usuarioActivoSesion->getUsuarioPerfil()->getNombre()=="COORDINADOR" )
		if(!is_object($usuarioActivoSesion->getTipoUsuario()))
			$include = 'Modulos/UsuariosAdmin/activar_tipo_usuario.php';

	if(empty($include))
		include_once 'errorpermisos.php';
	else		
		include_once $include;

	include_once "footer.php";
?>