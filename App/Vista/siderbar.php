      <?php
        include_once PATH_NEGOCIO."Usuarios/handlerusuarios.class.php";
        include_once PATH_NEGOCIO."Usuarios/handlerperfiles.class.php";
        
        $url_panelcontrol = "index.php?view=panelcontrol";

        $url_servicio = "index.php?view=servicio";
        $url_servicio_resumen = "index.php?view=servicio_resumen";
        $url_inbox = "index.php?view=inbox";
        $url_usuariosABM = "index.php?view=usuarioABM";
        $url_plazaABM = "index.php?view=plazas";  
        $url_cambiarUsuario = "index.php?view=cambiarUsuario";  
        $url_cambiorol = "index.php?view=cambioRol";  
        $url_estadisticas = "index.php?view=estadisticas";
        $url_estadisticas_plaza = "index.php?view=estadisticas_plaza&plaza=CABA";
        $url_estadisticas_global = "index.php?view=estadisticas_global&global=si";
        $url_estadisticas_empresas = "index.php?view=estadisticas_empresas&empresa=2";
        $url_estadisticas_clientes = "index.php?view=estadisticas_clientes";
        $url_metricas_empresa = "index.php?view=metricas_empresa";
        $url_metricas_tt = "index.php?view=metricas_tt";
        $url_estadisticas_tickets = "index.php?view=estadisticas_tickets&fplaza=1";
        $url_estadisticas_licencias = "index.php?view=estadisticas_licencias";
        $url_estadisticas_expediciones = "index.php?view=estadisticas_expediciones";
        $url_estadisticas_compras = "index.php?view=estadisticas_compras";
        $url_estadisticas_asistencias = "index.php?view=estadisticas_asistencias";
        $url_estadisticas_asistencias_coord = "index.php?view=estadisticas_asistencia_coord";
        $url_configuraciones = "index.php?view=configuraciones";
        $url_importacion = "index.php?view=importacion";
        $url_importacion_manual = "index.php?view=importacion_manual";
        $url_plaza_cp = "index.php?view=cp_plaza";
        $url_importacion_sin_plaza = "index.php?view=importaciones_sin_plaza";
        $url_importacion_sin_importar = "index.php?view=importaciones_sin_importar";
        
        $url_ayuda = "index.php?view=ayuda";
        $url_grupo_ayuda = "index.php?view=grupo_ayuda";
        $url_documento_ayuda = "index.php?view=documento_ayuda";

        $url_asistencias = "index.php?view=asistencias";
        $url_tabla_asistencias = "index.php?view=tabla_asistencias";
        $url_asistencias_gestor = "index.php?view=asistencias_gestor";
        $url_asistencias_estados = "index.php?view=asistencias_estados";
        $url_asistencias_gerenciaBO = "index.php?view=asistencias_gerenciaBO";
        $url_asistencias_comparativas_coord = "index.php?view=asistencias_comparativas_coordinador";
        $url_asistencias_comparativas2 = "index.php?view=asistencias_comparativas&modo=gerencia";
        $url_asistencias_comparativas_gerencia = "index.php?view=asistencias_gerencia_comparativas";

        $url_legajos_carga = "index.php?view=legajos_carga";
        $url_sueldos_remun = "index.php?view=sueldos_remun";
        $url_sueldos_conceptos = "index.php?view=sueldos_conceptos";
        $url_legajos_control = "index.php?view=legajos_control";
        $url_sueldos_basicos = "index.php?view=sueldos_basicos";
        $url_sueldos_categorias = "index.php?view=sueldos_categorias";
        $url_imprimir_credencial = PATH_VISTA.'Modulos/Legajos/imprimir_credencial.php?';

        $url_tickets_carga = "index.php?view=tickets_carga";
        $url_tickets_control = "index.php?view=tickets_control";
        $url_tickets_aprobar = "index.php?view=tickets_aprobar";
        $url_tickets_conceptos = "index.php?view=tickets_conceptos";
        $url_tickets_fechas = "index.php?view=tickets_fechas_inhabilitadas";
        $url_tickets_reintegro = "index.php?view=tickets_reintegros";
        $url_tickets_resumen = "index.php?view=tickets_resumen";
        $url_tickets_resumen_gestor = "index.php?view=tickets_resumen_gestor";
        
        $url_licencias_carga = "index.php?view=licencias_carga";
        $url_licencias_control = "index.php?view=licencias_control";       
        $url_licencias_resumen = "index.php?view=licencias_resumen";       
        $url_licencias_controlcoordinador = "index.php?view=licencias_controlcoord";       
        $url_tipo_licencias_abm = "index.php?view=tipo_licencias";
        
        $url_capacitaciones = "index.php?view=capacitaciones";

        $url_herramientas = "index.php?view=herramientas";
        $url_impresorasxplaza = "index.php?view=impresorasxplaza";
        $url_celulares = "index.php?view=celulares";
        $url_insumos = "index.php?view=insumos";

        $url_track_trace="index.php?view=webservice_importacion";
        $url_track_asignacion="index.php?view=asignacion";
        $url_track_abm="index.php?view=track_abm";
        $url_track_importacion="index.php?view=importacion";
        $url_track_localizacion="index.php?view=localizacion";
        $url_track_trackeo="index.php?view=trackeo";
        $url_track_fidelizar="index.php?view=fidelizar";
        $url_track_portal_importacion="index.php?view=portal_importacion";
        $url_track_cambio_estado="index.php?view=cambio_estado";
        $url_track_abm_empresas="index.php?view=track_trace_empresas";
        
        $url_puntajes_gestor = "index.php?view=puntajes_gestor";
        $url_puntajes_coordinador = "index.php?view=puntajes_coordinador";
        $url_puntajes_general = "index.php?view=puntajes_general";
        $url_puntajes_supervisor = "index.php?view=puntajes_supervisor";
        $url_resumen_comisiones = "index.php?view=resumen_comisiones";

        $url_stock = "index.php?view=stock";
        $url_enviadas = "index.php?view=enviadas";
        $url_roles = "index.php?view=roles";        

        $url_exp_control = "index.php?view=exp_control";
        $url_exp_remito = "index.php?view=exp_remito";
        $url_exp_controlcoordinador = "index.php?view=exp_control_coordinador";
        $url_exp_tipo_abm = "index.php?view=exp_tipo_abm";
        $url_exp_item_abm = "index.php?view=exp_item_abm";
        $url_exp_solicitud = "index.php?view=exp_solicitud";
        $url_exp_seguimiento = "index.php?view=exp_seguimiento";
        $url_exp_seguimiento_remito = "index.php?view=exp_seguimiento_remito";
        $url_exp_compra = "index.php?view=exp_compra";

        $url_guias_control = "index.php?view=guias_control";
        $url_guias_control_empresa = "index.php?view=guias_control_empresa";
        $url_guias_envios = "index.php?view=guias_envios";
        $url_guias_seguimiento = "index.php?view=guias_seguimiento";
        $url_agenda = "index.php?view=agenda";
        $url_agenda_rubros = "index.php?view=agenda_rubros";
        $url_agenda_estados = "index.php?view=agenda_estados";

        $url_kanban_listado = "index.php?view=kanban";
        $url_kanban_lista_terminadas = "index.php?view=kanban_terminadas";
      
        $perfil =$usuarioActivoSesion->getUsuarioPerfil()->getId();
        $url_cambiar_side=PATH_VISTA.'Modulos/UsuariosAdmin/action_cambiar_rol_usuario_side.php?id=';

        $handlerP = new HandlerPerfiles;
        $arrPerfiles = $handlerP->selectTodosNoAdmin();


      ?>
      <style type="text/css">
        .skin-black .sidebar-menu>li>.treeview-menu {
            margin: -1px 1px;
            background: #2c3b41;
            border-top: 1px solid #aaa;
        }
      </style>
      
      <aside class="main-sidebar">        
        <section class="sidebar">          
          <ul class="sidebar-menu">
                              
            <li class="header">ACCESOS</li>

            <?php
              if($permiso->getModuloPanelBoolean()){  
            ?>          
   
              <li class="treeview" id="mnu_panelcontrol">
                <a href=<?php echo $url_panelcontrol; ?>>
                  <i class="fa fa-dashboard"></i> <span>Panel de Control</span> </i>
                </a>
              </li>

            <?php 
              }
            ?>  

            <?php
              if($permiso->getModuloLegajosBoolean()){  
            ?>          
              <li class="treeview" id="mnu_legajos">
                <a href="#"><i class="fa fa-archive"></i> <span>Legajos</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">

                  <?php if($esGestor || $esGerencia || ($esBO || $esContabilidad || $esRRHH) || $esCoordinador || $esIngresante || $esSupervisor){ ?>
                    <li class="treeview" id="mnu_legajos_carga">
                      <a href=<?php echo $url_legajos_carga; ?>> 
                        <i class="fa fa-plus-square"></i> <span>Cargar</span> </i>
                      </a>
                    </li>   
                  <?php } ?>

                  <?php if(($esBO || $esContabilidad || $esRRHH) || $esCoordinador){ ?>  
                    <li class="treeview" id="mnu_legajos_control">
                      <a href=<?php echo $url_legajos_control; ?>> 
                        <i class="fa fa-tasks"></i> <span>Control</span> </i>
                      </a>
                    </li> 
                  <?php } ?> 
                </ul>
              </li>
            <?php 
              }
            ?>  

            <?php
              if($permiso->getModuloLegajosBoolean() && (!$esCoordinador && !$esGestor )){  
            ?>          
              <li class="treeview" id="mnu_sueldos">
                <a href="#"><i class="fa fa-money"></i> <span>Salarios</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                  <?php if(($esBO || $esContabilidad || $esRRHH) || $esGerencia){ ?>
                    <li class="treeview" id="mnu_sueldos_categorias">
                      <a href=<?php echo $url_sueldos_categorias; ?>> 
                        <i class="fa fa-book"></i> <span>Categorias</span> </i>
                      </a>
                    </li>
                    <li class="treeview" id="mnu_sueldos_basicos">
                      <a href=<?php echo $url_sueldos_basicos; ?>> 
                        <i class="fa fa-list"></i> <span>Basicos</span> </i>
                      </a>
                    </li> 
                    <li class="treeview" id="mnu_sueldos_conceptos">
                      <a href=<?php echo $url_sueldos_conceptos; ?>> 
                        <i class="fa fa-edit"></i> <span>Conceptos Salariales</span> </i>
                      </a>
                    </li>
                    <li class="treeview" id="mnu_sueldos_remun">
                      <a href=<?php echo $url_sueldos_remun; ?>> 
                        <i class="fa fa-dollar"></i> <span>Salarios</span> </i>
                      </a>
                    </li> 
                  <?php } ?> 
                </ul>
              </li>
            <?php 
              }
            ?>  

            <?php
              if($permiso->getModuloLegajosBoolean() && ($esCoordinador)){  
            ?>          
              <li class="treeview" id="mnu_track_trace">
                <a href="#"><i class="fa fa-text-width"></i> <span>T&T</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                	<?php if($esCoordinador){ ?>
                    <li class="treeview" id="mnu_track_abm">
                      <a href=<?php echo $url_track_abm; ?>> 
                        <i class="fa fa-eraser"></i> <span>Abm</span> </i>
                      </a>
                    </li>
                    <li class="treeview" id="mnu_track_trace">
                      <a href=<?php echo $url_track_trace; ?>> 
                        <i class="fa fa-book"></i> <span>Web Service</span> </i>
                      </a>
                    </li>
                    <li class="treeview" id="mnu_track_asignacion">
                      <a href=<?php echo $url_track_asignacion; ?>> 
                        <i class="fa fa-map-pin"></i> <span>Asignacion</span> </i>
                      </a>
                    </li>
                    <li class="treeview" id="mnu_track_importacion">
                      <a href=<?php echo $url_track_importacion; ?>> 
                        <i class="fa fa-map"></i> <span>Importacion</span> </i>
                      </a>
                    </li> 
                    <li class="treeview" id="mnu_track_localizacion">
                      <a href=<?php echo $url_track_localizacion; ?>> 
                        <i class="fa fa-map-marker"></i> <span>Localización</span> </i>
                      </a>
                    </li>
                    <li class="treeview" id="mnu_track_trackeo">
                      <a href=<?php echo $url_track_trackeo; ?>> 
                        <i class="fa fa-map-signs"></i> <span>Trackeo</span> </i>
                      </a>
                    </li>
                    <li class="treeview" id="mnu_track_fidelizar">
                      <a href=<?php echo $url_track_fidelizar; ?>> 
                        <i class="fa fa-location-arrow"></i> <span>Fidelizar</span> </i>
                      </a>
                    </li>
                    <li class="treeview" id="mnu_track_cambio_estado">
                      <a href=<?php echo $url_track_cambio_estado; ?>> 
                        <i class="fa fa-edit"></i> <span>Cambio Estado</span> </i>
                      </a>
                    </li>                     
                  <?php } ?> 
                </ul>
              </li>
            <?php 
              }
            ?>  

            <?php
              if($permiso->getModuloLicenciasBoolean()){ 
                if($usuarioActivoSesion->getId()==10045 || $usuarioActivoSesion->getId()==3|| $usuarioActivoSesion->getId()==20168 ||$usuarioActivoSesion->getId()==10104 || $esGestor || $esCoordinador || $esBO || $usuarioActivoSesion->getId()==20174 || $usuarioActivoSesion->getId()==10082){   
            ?>
              <li class="treeview" id="mnu_asistencias">
                <a href="#"><i class="fa fa-user"></i> <span>Asistencias</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                <?php  if($esCoordinador && ($usuarioActivoSesion->getId()!=10045 || $usuarioActivoSesion->getId()!=20174 || $usuarioActivoSesion->getId()!=10082 )){ //10045   ?>
                    <li id="mnu_asistencias_presentismo">
                      <a href=<?php echo $url_asistencias; ?>>
                        <i class="fa fa-check-square-o"></i> <span>Presentismo Coord</span>
                      </a>
                    </li>
                        <li id="mnu_asistencias_estados">
                      <a href=<?php echo $url_asistencias_estados; ?>>
                        <i class="fa fa-edit"></i> <span>ABM Estados</span>
                      </a>
                    </li>
                    <li id="mnu_asistencias_comparativas">
                     <a href=<?php echo $url_asistencias_comparativas_coord; ?>>
                       <i class="fa fa-refresh"></i> <span>Comparativas Coord</span>
                      </a>
                   </li>  
                    </ul>
                  </li>
                  <?php }elseif($esGestor){?> 
                   <li id="mnu_asistencias_presentismo">
                      <a href=<?php echo $url_asistencias_gestor; ?>>
                        <i class="fa fa-check-square-o"></i> <span>Gestor</span>
                      </a>
                    </li>  
                </ul>
              </li>
                <?php } elseif($usuarioActivoSesion->getId()==10045 || $usuarioActivoSesion->getId()==3|| $usuarioActivoSesion->getId()==20168 ||$usuarioActivoSesion->getId()==10104 || $usuarioActivoSesion->getId()==20174 || $usuarioActivoSesion->getId()==10082 ||$esBO){?> 
                   <li id="mnu_asistencias_gerenciaBO">
                      <a href=<?php echo $url_asistencias_gerenciaBO; ?>>
                        <i class="fa fa-check-square-o"></i> <span>Presentismo Global</span>
                      </a>
                    </li> 
                       <li id="mnu_asistencias_estados">
                      <a href=<?php echo $url_asistencias_estados; ?>>
                        <i class="fa fa-edit"></i> <span>ABM Estados</span>
                      </a>
                    </li>  
                   <li id="mnu_asistencias_gerencia_comparativas">
                      <a href=<?php echo $url_asistencias_comparativas_gerencia; ?>>
                        <i class="fa fa-exchange"></i> <span>Comparativas Plazas</span>
                      </a>
                    </li> 
                   <li id="mnu_asistencias_comparativas">
                     <a href=<?php echo $url_asistencias_comparativas2; ?>>
                       <i class="fa fa-refresh"></i> <span>Comparativas Empl</span>
                      </a>
                   </li> 
                    <li id="mnu_tabla_asistencias">
                     <a href=<?php echo $url_tabla_asistencias; ?>>
                       <i class="fa fa-file-text-o"></i> <span>Tabla Asistencias</span>
                      </a>
                   </li>    
                       
                </ul>
              </li>
               <?php } } }?> 

            <?php
              if($permiso->getModuloTicketsBoolean()){  
            ?>          
              <li class="treeview" id="mnu_tickets">
                <a href="#"><i class="fa fa-ticket"></i> <span>Tickets</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">

                  <?php if($esGestor || $esGerencia || ($esBO || $esContabilidad || $esRRHH) || $esCoordinador || $esIngresante || $esSupervisor){ ?>
                    <li class="treeview" id="mnu_tickets_carga">
                      <a href=<?php echo $url_tickets_carga; ?>> 
                        <i class="fa fa-plus-square"></i> <span>Cargar</span> </i>
                      </a>
                    </li>   
                  <?php } ?>

                  <?php if($esCoordinador){ ?>   
                    <li class="treeview" id="mnu_tickets_control">
                      <a href=<?php echo $url_tickets_control; ?>> 
                        <i class="fa fa-tasks"></i> <span>Control</span> </i>
                      </a>
                    </li>     
                  <?php } ?>   

                  <?php if(($esBO || $esContabilidad || $esRRHH)){ ?>   
                    <li class="treeview" id="mnu_tickets_aprobar">
                      <a href=<?php echo $url_tickets_aprobar; ?>> 
                        <i class="fa fa-check"></i> <span>Aprobar</span> </i>
                      </a>
                    </li>                
                    <li class="treeview" id="mnu_tickets_reintegro">
                      <a href=<?php echo $url_tickets_reintegro; ?>> 
                        <i class="fa fa-list"></i> <span>Tabla Reintegros</span> </i>
                      </a>
                    </li>
                    <li class="treeview" id="mnu_tickets_resumen">
                      <a href=<?php echo $url_tickets_resumen; ?>>
                        <i class="fa fa-list"></i> <span>Resumen Viáticos</span> </i>
                      </a>
                    </li>
                    <li class="treeview" id="mnu_tickets_resumen_gestor">
                      <a href=<?php echo $url_tickets_resumen_gestor; ?>>
                        <i class="fa fa-file-text-o"></i> <span>Resumen x Gestor</span> </i>
                      </a>
                    </li>
                  <?php } ?>    

                  
                  <?php if($esGerencia || ($esBO || $esContabilidad || $esRRHH) ){ ?>   
                    <li class="treeview" id="mnu_tickets_concepto">
                      <a href=<?php echo $url_tickets_conceptos; ?>> 
                        <i class="fa fa-edit"></i> <span>Conceptos</span> </i>
                      </a>
                    </li>     
                  <?php } ?>         

                  <?php if($esGerencia || ($esBO || $esContabilidad || $esRRHH) ){ ?>   
                    <li class="treeview" id="mnu_tickets_fechas">
                      <a href=<?php echo $url_tickets_fechas; ?>> 
                        <i class="fa fa-edit"></i> <span>Fechas Inhabilitadas</span> </i>
                      </a>
                    </li>     
                  <?php } ?>                                 
                </ul>
              </li>              
            <?php 
              }
            ?>

            <?php
              if($permiso->getModuloLicenciasBoolean()){    
            ?>
              <li class="treeview" id="mnu_licencias">
                <a href="#"><i class="fa fa-certificate"></i> <span>Licencias</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">

                  <?php if($esGestor || $esGerencia || ($esBO || $esContabilidad || $esRRHH) || $esCoordinador || $esIngresante || $esSupervisor){ ?>
                    <li id="mnu_licencias_carga">
                      <a href=<?php echo $url_licencias_carga; ?>>
                        <i class="fa fa-plus-square"></i> <span>Generar</span>
                      </a>
                    </li> 
                  <?php } ?>

                  <?php if(($esBO || $esContabilidad || $esRRHH) ){ ?>
                    <li id="mnu_licencias_control">
                      <a href=<?php echo $url_licencias_control; ?>>
                        <i class="fa fa-tasks"></i> <span>Control</span>
                      </a>
                    </li> 
                    <li id="mnu_licencias_resumen">
                      <a href=<?php echo $url_licencias_resumen; ?>>
                        <i class="fa fa-list"></i> <span>Resumen</span>
                      </a>
                    </li> 
                    <li id="mnu_tipo_licencias_abm">
                      <a href=<?php echo $url_tipo_licencias_abm; ?>>
                        <i class="fa fa-edit"></i> <span>Tipo Licencias</span>
                      </a>
                    </li>                     
                  <?php } ?>
                  <?php if(($esCoordinador) ){ ?>
                    <li id="mnu_licencias_controlcoord">
                      <a href=<?php echo $url_licencias_controlcoordinador; ?>>
                        <i class="fa fa-tasks"></i> <span>Control Coord</span>
                      </a>
                    </li>
                    <li id="mnu_tipo_licencias_abm">
                      <a href=<?php echo $url_tipo_licencias_abm; ?>>
                        <i class="fa fa-edit"></i> <span>Tipo Licencias</span>
                      </a>
                    </li>   
                     <?php } ?>

                </ul>
              </li>
            <?php 
              }
            ?>


            <?php
              if($permiso->getModuloCapacitacionesBoolean()){  
            ?>          
              <li class="treeview" id="mnu_capacitaciones">
                <a href=<?php echo $url_capacitaciones; ?>> 
                  <i class="fa fa-university"></i> <span>Capacitaciones</span> </i>
                </a>
              </li>   
            <?php 
              }
            ?>  

            <?php
              if($permiso->getModuloPuntajesBoolean() && $esGestor){  
            ?>          
              <li class="treeview" id="mnu_puntajes">
                <a href=<?php echo $url_puntajes_gestor; ?>> 
                  <i class="fa fa-percent"></i> <span>Puntajes</span> </i>
                </a>
              </li>   
            <?php 
              } 

              if($permiso->getModuloPuntajesBoolean() && $esCoordinador){
            ?>  
              <li class="treeview" id="mnu_puntajes">
                <a href=<?php echo $url_puntajes_coordinador; ?>> 
                  <i class="fa fa-percent"></i> <span>Puntajes</span> </i>
                </a>
              </li>              
            <?php 
              }
              if($permiso->getModuloPuntajesBoolean() && ($esGerencia || $esBO || $esContabilidad || $esRRHH)){
            ?>
            <li class="treeview" id="mnu_puntajes">
              <a href="#"><i class="fa fa-percent"></i> <span>Puntajes</span> <i class="fa fa-angle-left pull-right"></i></a>
              <ul class="treeview-menu">  
                <li class="treeview" id="mnu_puntajes">
                  <a href=<?php echo $url_puntajes_general; ?>> 
                    <i class="fa fa-percent"></i> <span>Puntajes</span> </i>
                  </a>
                </li>  
                <li class="treeview" id="mnu_resumen_comisiones">
                  <a href=<?php echo $url_resumen_comisiones; ?>> 
                    <i class="fa fa-list"></i> <span>Resumen Comisiones</span> </i>
                  </a>
                </li>
              </ul>
            </li>
            <?php 
              }
            ?>  


            <?php
              
              if($permiso->getModuloServiciosBoolean() && !($esBO || $esContabilidad || $esRRHH)){
            ?>
              <li class="treeview" id="mnu_servicio">
                <a href=<?php echo $url_servicio; ?>>
                  <i class="fa fa-truck"></i> <span>Servicios</span> </i>
                </a>
              </li>
            <?php 
              }
            ?>

            <?php
              if($permiso->getModuloServiciosBoolean() && ($esBO || $esContabilidad || $esRRHH)){
            ?>

              <li class="treeview" id="mnu_servicio">
                <a href="#"><i class="fa fa-truck"></i> <span>Servicios</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                  <li class="treeview" id="mnu_servicio">
                    <a href=<?php echo $url_servicio; ?>>
                      <i class="fa fa-truck"></i> <span>Servicios</span> </i>
                    </a>
                  </li>
                  <li class="treeview" id="mnu_servicio">
                    <a href=<?php echo $url_servicio_resumen; ?>>
                      <i class="fa fa-list"></i> <span>Resumen</span> </i>
                    </a>
                  </li>
                </ul>
              </li>
            <?php 
              }
            ?>

            <?php
              if($permiso->getModuloImportacionBoolean()){               
            ?>
              <li class="treeview" id="mnu_importacion">
                <a href="#"><i class="fa fa-upload"></i> <span>Importaciones</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                
                  <?php if($esCliente){ ?>
                    <li class="treeview" id="mnu_importacion">
                      <a href=<?php echo $url_importacion_manual; ?>>
                        <i class="fa fa-file-text-o"></i> <span>Carga Simple</span> </i>
                      </a>
                    </li>
                  <?php } ?>

                  <?php if($esCliente){ ?>
                    <li class="treeview" id="mnu_importacion">
                      <a href=<?php echo $url_importacion; ?>>
                        <i class="fa fa-file-excel-o"></i> <span>Importación por Lote</span> </i>
                      </a>
                    </li>
                  <?php } ?>

                  <?php if($esGerencia || $esBO || $esCoordinador || $esSupervisor){ ?> 
                    <li class="treeview" id="mnu_importacion">
                      <a href=<?php echo $url_plaza_cp; ?>>
                        <i class="fa fa-map-pin"></i> <span>CP por Plaza</span> </i>
                      </a>
                    </li>
                  <?php } ?>

                  <?php if($esGerencia || ($esBO || $esContabilidad || $esRRHH) || $esCoordinador || $esSupervisor){ ?> 
                    <li class="treeview" id="mnu_importacion">
                      <a href=<?php echo $url_importacion_sin_plaza; ?>>
                        <i class="fa fa-plus-circle"></i> <span>Sin Plaza</span> </i>
                      </a>
                    </li>
                  <?php } ?>

                  <?php if($esGerencia || ($esBO || $esContabilidad || $esRRHH) || $esCoordinador || $esSupervisor){ ?> 
                    <li class="treeview" id="mnu_importacion">
                      <a href=<?php echo $url_importacion_sin_importar; ?>>
                        <i class="fa fa-plus-circle"></i> <span>Pendientes</span> </i>
                      </a>
                    </li>
                  <?php } ?>

                </ul>
              </li>
            <?php } ?>

            <?php
              if($permiso->getModuloInventariosBoolean()){    
            ?>
              <li class="treeview" id="mnu_expediciones">
                <a href="#"><i class="fa fa-cubes"></i> <span>Expediciones</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">

                  <?php if(($esBO || $esContabilidad ) || $esGerencia){ ?>
                    <li id="mnu_expediciones_compra">
                      <a href=<?php echo $url_exp_compra; ?>>
                        <i class="fa fa-shopping-cart"></i> <span>Compras</span>
                      </a>
                    </li>

                     <?php } ?>
                  <?php if(($esBO || $esContabilidad )){ ?>

                    <li id="mnu_expediciones_control">
                      <a href=<?php echo $url_exp_control; ?>>
                        <i class="fa fa-tasks"></i> <span>Control</span>
                      </a>
                    </li>
                    <li id="mnu_expediciones_tipo_abm">
                      <a href=<?php echo $url_exp_tipo_abm; ?>>
                        <i class="fa fa-edit"></i> <span>Tipos</span>
                      </a>
                    </li> 
                    <li id="mnu_expediciones_item_abm">
                      <a href=<?php echo $url_exp_item_abm; ?>>
                        <i class="fa fa-check"></i> <span>Items</span>
                      </a>
                    </li> 
                    <?php } ?> 
                     <?php if($esContabilidad){ ?>

                    <li id="mnu_expediciones_remito">
                      <a href=<?php echo $url_exp_remito; ?>>
                        <i class="fa fa-file-text-o"></i> <span>Remitos</span>
                      </a>
                    </li>
                    <?php } ?> 
                     
                    
                    <?php if($esBO || $esCoordinador|| $esContabilidad || $esRRHH){ ?>
                    <li id="meu_expediciones_solicitud" >
                      <a href=<?php echo $url_exp_solicitud; ?>>
                        <i class="fa fa-plus"></i> <span>Solicitud</span>
                      </a>
                    </li> 
                     <?php } ?> 
                     <?php if($esCoordinador){ ?>

                    <li id="mnu_expediciones_seguimiento_remito">
                      <a href=<?php echo $url_exp_seguimiento_remito; ?>>
                        <i class="fa fa-car"></i> <span>Seguimiento Remitos</span>
                      </a>
                    </li>
                    <?php } ?> 
                      <?php if($esBO || $esContabilidad || $esRRHH){ ?>   
                    <li id="mnu_expediciones_seguimiento">
                      <a href=<?php echo $url_exp_seguimiento; ?>>
                        <i class="fa fa-car"></i> <span>Seguimiento</span>
                      </a>
                    </li>
                  <?php } ?>
                </ul>
              </li>
            <?php 
              }
            ?>

            <?php if($permiso->getModuloGuiasBoolean()){ ?>
              <li class="treeview" id="mnu_guias">
                <a href="#"><i class="fa fa-bell "></i> <span>Guias y Remitos</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">

                  <?php if(($esBO || $esContabilidad || $esRRHH)){ ?>
                    <li id="mnu_guias_control">
                      <a href=<?php echo $url_guias_control; ?>>
                        <i class="fa fa-tasks"></i> <span>Control</span>
                      </a>
                    </li>
                  <?php } ?>

                  <?php if($esCoordinador){ ?>  
                    <li id="mnu_guias_envio">
                      <a href=<?php echo $url_guias_envios; ?>>
                        <i class="fa fa-send"></i> <span>Envío</span>
                      </a>
                    </li>
                    <li id="mnu_guias_seguimiento">
                      <a href=<?php echo $url_guias_seguimiento; ?>>
                        <i class="fa fa-check"></i> <span>Seguimiento</span>
                      </a>
                    </li>
                  <?php } ?>

                  <?php if($esCliente){ ?>  
                    <li id="mnu_guias_control_empresa">
                      <a href=<?php echo $url_guias_control_empresa; ?>>
                        <i class="fa fa-tasks"></i> <span>Control</span>
                      </a>
                    </li>   
                  <?php } ?>

                </ul>
              </li>            
            <?php 
              }
            ?>

            <?php
              if($permiso->getModuloStockBoolean()){  
            ?>             
              <li class="treeview" id="mnu_stock">
                <a href=<?php echo $url_stock; ?>>
                  <i class="fa fa-cubes"></i> <span>Stock</span> </i>
                </a>
              </li>
            <?php 
              }
            ?>
            <?php
              if($permiso->getModuloHerramientasBoolean()){  
            ?>   
              <li class="treeview" id="mnu_herramientas">
                <a href="#"><i class="fa fa-wrench"></i> <span>Herramientas</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">

                  
                    <li id="mnu_impresorasxplaza">
                      <a href=<?php echo $url_impresorasxplaza; ?>>
                        <i class="fa fa-print"></i> <span>Impresoras</span>
                      </a>
                    </li>
                    <?php if($esGerencia || ($esBO || $esContabilidad || $esRRHH)){ ?>
                    <li id="mnu_celulares">
                      <a href=<?php echo $url_celulares; ?>>
                        <i class="fa fa-mobile"></i> <span>Líneas y Equipos</span>
                      </a>
                    </li>
                  <li id="mnu_insumos">
                    <a href=<?php echo $url_insumos; ?>> 
                      <i class="fa fa-cubes"></i> <span>Insumos</span> </i>
                    </a>
                  </li>
                <?php } ?>
                </ul>
              </li>
            <?php 
              }
            ?>

            <?php
              if($permiso->getModuloEnviadasBoolean()){  
            ?>             
              <li class="treeview" id="mnu_enviadas">
                <a href=<?php echo $url_enviadas; ?>>
                  <i class="fa fa-paper-plane"></i> <span>Enviadas</span> </i>
                </a>
              </li>
            <?php 
              }
            ?>        

            <?php
              if($permiso->getModuloMetricasBoolean() && !$esCoordinador){  
            ?>   
              <li class="treeview" id="mnu_estadisticas">
                <a href="#"><i class="fa fa-area-chart"></i> <span>Estadisticas</span> </i></a>       
              <ul class="treeview-menu">
                <li id="mnu_estadistica">
                <a href=<?php echo $url_estadisticas; ?>>
                  <i class="fa fa-area-chart"></i> <span>Estadisticas</span> </i>
                </a>
              </li>
             <?php              
              if($esGerencia){  
            ?>   
              <li id="mnu_estadisticas_plaza">
                <a href=<?php echo $url_estadisticas_plaza; ?>>
                  <i class="fa fa-line-chart"></i> <span>Est.Plazas</span> </i>
                </a>
              </li>
                <li id="mnu_estadisticas_empresas">
                <a href=<?php echo $url_estadisticas_empresas; ?>>
                  <i class="fa fa-bar-chart"></i> <span>Est.Empresas</span> </i>
                </a>
              </li>
                <li id="mnu_estadisticas_global">
                <a href=<?php echo $url_estadisticas_global; ?>>
                  <i class="fa fa-pie-chart"></i> <span>Global</span> </i>
                </a>
              </li>
                <li id="mnu_metricas_tt">
                <a href=<?php echo $url_metricas_tt; ?>>
                  <i class="fa fa-table"></i> <span>Metricas</span> </i>
                </a>
              </li> 
            
              <?php 
              }
            ?>
             <?php              
              if($esGerencia || $esBO){  
            ?>              
              <li id="mnu_estadisticas_tickets">
                <a href=<?php echo $url_estadisticas_tickets; ?>>
                  <i class="fa fa-bar-chart"></i> <span>Est.Tickets</span> </i>
                </a>              
              </li>
             <li id="mnu_estadisticas_licencias">
                <a href=<?php echo $url_estadisticas_licencias; ?>>
                  <i class="fa fa-pie-chart"></i> <span>Est.Licencias</span> </i>
                </a>              
              </li>
              <li id="mnu_estadisticas_expediciones">
                <a href=<?php echo $url_estadisticas_expediciones; ?>>
                  <i class="fa fa-line-chart"></i> <span>Est.Expediciones</span> </i>
                </a>              
              </li>
               <li id="mnu_estadisticas_compras">
                <a href=<?php echo $url_estadisticas_compras; ?>>
                  <i class="fa fa-bar-chart"></i> <span>Est.Compras</span> </i>
                </a>              
              </li>
              <li id="mnu_estadisticas_asistencias">
                <a href=<?php echo $url_estadisticas_asistencias; ?>>
                  <i class="fa fa-pie-chart"></i> <span>Est.Asistencias</span> </i>
                </a>              
              </li>
            <?php } ?>
            </ul>
          </li>
            <?php 
              }
            ?>
             <?php  if($esCliente){
            ?>
              <li class="treeview" id="mnu_est_cliente">
                <a href="#"><i class="fa fa-bar-chart "></i> <span>Estadísticas</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                  <li class="treeview" id="mnu_estadisticas_clientes">
                    <a href=<?php echo $url_estadisticas_clientes; ?>>
                      <i class="fa fa-bar-chart"></i> <span>Gráficos</span> </i>
                    </a>
                  </li>
                  <li class="treeview" id="mnu_metricas_empresa">
                    <a href=<?php echo $url_metricas_empresa; ?>>
                      <i class="fa fa-line-chart"></i> <span>Métricas</span> </i>
                    </a>
                  </li>
                </ul>
              </li>
            <?php 
              }
            ?>
            <?php
              if($permiso->getModuloAyudaBoolean()){  
            ?>          
              <li class="treeview" id="mnu_ayuda">
                <a href="#"><i class="fa fa-support "></i> <span>Documentación</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">

                  <?php if($esGerencia){ ?>
                    <li id="mnu_documento_ayuda">
                      <a href=<?php echo $url_documento_ayuda; ?>>
                        <i class="fa fa-book"></i> <span>Documentos</span>
                      </a>
                    </li>
                    <li id="mnu_grupo_ayuda">
                      <a href=<?php echo $url_grupo_ayuda; ?>>
                        <i class="fa fa-edit"></i> <span>Grupos</span>
                      </a>
                    </li>   
                  <?php } ?>

                  <li class="treeview" id="mnu_view_ayuda">
                    <a href=<?php echo $url_ayuda; ?>> 
                      <i class="fa fa-question"></i> <span>Ayuda</span> </i>
                    </a>
                  </li> 
                </ul>
              </li>  
            <?php 
              }
            ?> 

            <?php
              if($permiso->getModuloInboxBoolean()){               
            ?>
              <li class="treeview" id="mnu_inbox">
                <a href=<?php echo $url_inbox; ?>>
                  <i class="fa fa-commenting"></i> <span>Contactar con OTR</span> </i>
                </a>
              </li>  
            <?php 
              }
            ?>     

            <?php
              if($permiso->getModuloMultiusuarioBoolean()){               
            ?>
              <li class="treeview" id="mnu_cambiarusuario">
                <a href=<?php echo $url_cambiarUsuario; ?>> 
                  <i class="fa fa-refresh"></i> <span>Cambiar Usuario</span> </i>
                </a>
              </li>  
            <?php 
              }
            ?><!--      

            <?php
              if($usuarioActivoSesion->getCambioRol()){               
            ?>
              <li class="treeview" id="mnu_cambiorol">
                <a href="#"><i class="fa fa-refresh"></i> <span>Cambiar Perfil</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                  <?php
                    if(!empty($arrPerfiles))
                    {                        
                      foreach ($arrPerfiles as $rol) { 
                        if($usuarioActivoSesion->getUsuarioPerfil()->getId()!=$rol->getId()){ ?>
                        
                        <li class="mnu_cambiorol">
                          <a href=<?php echo $url_cambiar_side.$usuarioActivoSesion->getId()."&rol=".$rol->getId(); ?>> 
                            <?php echo $rol->getNombre() ?>
                          </a>
                        </li>
                    <?php } 
                     }
                    }                      
                  ?> 
                </ul>              
              </li>
            <?php 
              }
            ?> -->

            <?php              
              if($permiso->getModuloUsuariosBoolean() ||
                  $permiso->getModuloRolesBoolean() ||
                  $permiso->getModuloConfiguracionBoolean()){  
            ?>  
              <li class="header">ADMINISTRACION</li>
            <?php 
              }
            ?>     

            <?php              
              if($permiso->getModuloUsuariosBoolean()){  
            ?> 
             <li class="treeview" id="mnu_usuariosyplazas">
                <a href="#"><i class="fa fa-users "></i> <span>Usuarios</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                  <li class="treeview" id="mnu_usuariosABM">
                    <a href=<?php echo $url_usuariosABM; ?>>
                      <i class="fa fa-users"></i> <span>Usuarios</span> </i>
                    </a>
                  </li>
                  <li class="treeview" id="mnu_plazaABM">
                    <a href=<?php echo $url_plazaABM; ?>>
                      <i class="fa fa-map-signs"></i> <span>Plazas</span> </i>
                    </a>
                  </li>
                </ul>
              </li>
            <?php 
              }
            ?>

            <?php
              if($permiso->getModuloRolesBoolean()){  
            ?>             
              <li class="treeview" id="mnu_roles">
                <a href=<?php echo $url_roles; ?>>
                  <i class="fa fa-shield"></i> <span>Roles</span> </i>
                </a>
              </li>
            <?php 
              }
            ?>

            <?php
              if($permiso->getModuloConfiguracionBoolean()){  
            ?>             
              <li class="treeview" id="mnu_configuraciones">
                <a href=<?php echo $url_configuraciones; ?>>
                  <i class="fa fa-cogs"></i> <span>Configuraciones</span> </i>
                </a>
              </li>
            <?php 
              }
            ?>

            <?php if($esGestor || $esCoordinador || $esIngresante || $esSupervisor || ($esBO || $esContabilidad || $esRRHH) || $esGerencia){ ?>
              <li class="treeview" id="mnu_legajos_credencial">
                <a href=<?php echo $url_imprimir_credencial."userId=".$usuarioActivoSesion->getId(); ?> target="_blank"> 
                  <i class="fa fa-print"></i> <span>Credencial</span> </i>
                </a>
              </li>   
            <?php } ?>
            <?php if($esGerencia){ ?>
              <li class="treeview" id="mnu_agenda">
                <a href="#"><i class="fa fa-book "></i> <span>Agenda</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                  <li id="mnu_agenda_inicio">
                    <a href=<?php echo $url_agenda ?>> 
                      <i class="fa fa-book"></i> <span>Agenda</span> </i>
                    </a>
                  </li>
                  <li id="mnu_agenda_rubros">
                    <a href=<?php echo $url_agenda_rubros ?>> 
                      <i class="fa fa-list"></i> <span>Rubros</span> </i>
                    </a>
                  </li>
                  <li id="mnu_agenda_estados">
                    <a href=<?php echo $url_agenda_estados; ?>>
                      <i class="fa fa-edit"></i> <span>ABM Estados</span>
                    </a>
                  </li>  
                </ul>              
              </li>   
            <?php } ?>

            <?php if(!$esCliente){ ?>
              <li class="treeview" id="mnu_kanban">
                <a href="#"><i class="fa fa-bookmark-o"></i> <span>Tareas</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                  <li id="mnu_kanban_listado">
                    <a href=<?php echo $url_kanban_listado ?>> 
                      <i class="fa fa-bookmark-o"></i> <span>Solicitudes</span> </i>
                    </a>
                  </li>
                  <li id="mnu_kanban_lista_terminadas">
                    <a href=<?php echo $url_kanban_lista_terminadas ?>>
                      <i class="fa  fa-check"></i> <span>Tareas Terminadas</span> </i>
                    </a>
                  </li>
                </ul>              
              </li>  
              <?php } ?> 

             <?php
              if($usuarioActivoSesion->getId()==10164){    
            ?>
              <li class="treeview" id="mnu_control_coordinador">
                <a href="#"><i class="fa fa-tasks"></i> <span>Control General</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li id="mnu_control_coord">
                      <a href=<?php echo $url_exp_controlcoordinador; ?>>
                        <i class="fa fa-tasks"></i> <span>Control</span>
                      </a>
                    </li> 
                  <?php } ?>

          </ul>

        </section>        
      </aside>