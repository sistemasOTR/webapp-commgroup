<?php
  include_once PATH_NEGOCIO."Funciones/String/string.class.php";
  include_once PATH_NEGOCIO.'Notificaciones/handlernotificaciones.class.php';
    include_once PATH_NEGOCIO."Sistema/handlersistema.class.php";
  $url_activar_header=PATH_VISTA.'Modulos/UsuariosAdmin/action_activar_tipo_usuario_header.php?';

  $url_perfil= "index.php?view=perfil_usuario";
  $url_logout= PATH_VISTA."Login/action_logout.php";

  $handler = new HandlerNotificaciones;
  $handlerSist = new HandlerSistema;
  $arrNotificaiones = $handler->seleccionarTodo();
  $arrNotificaionesUsuario = $handler->seleccionarByUsuario($usuarioActivoSesion->getId());

  $arrNotificaionesEmpresa = null;
  if(!empty($usuarioActivoSesion->getTipoUsuario()))
  {
    if(count($usuarioActivoSesion->getTipoUsuario())==1){
      if($usuarioActivoSesion->getTipoUsuario()->getId()==1)
        $arrNotificaionesEmpresa = $handler->seleccionarByEmpresa($usuarioActivoSesion->getUserSistema());   
    }
  }

  $i_contador_user=0;
  $i_contador_admin=0;
  $i_contador_empresa=0;
?>
      <style>
        .header-change li:hover {background: #3c8dbc !important;}
        .header-change li:hover > a {color:white;}
        .header-change li {list-style: none;width: 100%;line-height: 30px;padding: 5px}
        .header-change li a {color: #555; display: block;}
        .bg-blue a {padding: 0px 5px; color: white; font-weight: 100; font-family: monospace;}
        .bg-blue {padding: 0px 5px; color: white; font-weight: 100; font-family: monospace;}
      </style>
      <header class="main-header">
        <!-- Logo -->
        <a href="index.php" class="logo">          
          <span class="logo-mini"><img src="<?php echo PATH_VISTA."assets/dist/img/logo-otr.png"; ?>" style="width: 90%;" alt="OTR Group"></span>          
          <span class="logo-lg hidden-xs"><img src="<?php echo PATH_VISTA."assets/dist/img/logo-otr.png"; ?>" style="width: 50%;" alt="OTR Group"></span>          
          <span class="logo-lg hidden-md">OTR Group</span>          
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>
          
          <?php

            if($usuarioActivoSesion->getUsuarioPerfil()->getNombre()=="GESTOR" ||
                $usuarioActivoSesion->getUsuarioPerfil()->getNombre()=="CLIENTE" ||
                $usuarioActivoSesion->getUsuarioPerfil()->getNombre()=="COORDINADOR" || 
                $usuarioActivoSesion->getUsuarioPerfil()->getNombre()=="SUPERVISOR" ){
                
              if(is_object($usuarioActivoSesion->getTipoUsuario()))
                // $strTipoLogin = $usuarioActivoSesion->getUsuarioPerfil()->getNombre()." - ".$usuarioActivoSesion->getAliasUserSistema();
                $strTipoLogin = substr($usuarioActivoSesion->getUsuarioPerfil()->getNombre(), 0,3)." - ". $usuarioActivoSesion->getAliasUserSistema();
              else
                $strTipoLogin = "";

            }
            else{
             $strTipoLogin = $usuarioActivoSesion->getUsuarioPerfil()->getNombre();
            }            
          ?>
          <label style="margin-top: 2px; margin-left: 15px;">                                  
            <span>Login como</span><br>
            <?php if($usuarioActivoSesion->getUsuarioPerfil()->getNombre()=="GESTOR" ||
                $usuarioActivoSesion->getUsuarioPerfil()->getNombre()=="CLIENTE" ||
                $usuarioActivoSesion->getUsuarioPerfil()->getNombre()=="COORDINADOR" || 
                $usuarioActivoSesion->getUsuarioPerfil()->getNombre()=="SUPERVISOR" ){ ?>
            <li class="dropdown notifications-menu bg-blue" style="list-style: none;">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                <span class="" style=""><?php echo $strTipoLogin; ?> <i class="fa fa-caret-down"></i> </span>
              </a>
              <ul class="dropdown-menu">
                
                <li>
                  <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: 300px; height: auto;">
                    <ul class="menu header-change" style="overflow: auto; width: 100%; height: auto; padding: 0px;">
                      <?php $multi = $usuarioActivoSesion->getMultiusuario();
                  
                      if(count($multi)==1)
                        $multi = array($multi);

                      if(!empty($multi))
                      {
                        foreach ($multi as $uType) {
                          switch ($usuarioActivoSesion->getUsuarioPerfil()->getNombre()) {
                            case 'CLIENTE':
                              $tipoUser = 1;
                              break;
                            case 'GESTOR':
                              $tipoUser = 3;
                              break;
                            case 'SUPERVISOR':
                              $tipoUser = 6;
                              break;
                            case 'COORDINADOR':
                              $tipoUser = 4;
                              break;
                          }

                          if ($uType->getTipoUsuario()->getId() == $tipoUser) { 
                            if ($tipoUser == 1) {
                              $empresa = $handlerSist->getEmpresaByCodigo($uType->getUserSistema());

                              $name = $empresa[0]->NOMBRE;
                            } else {
                              $name = trim($uType->getAliasUserSistema());
                            }
                            ?>
                            
                              <li>

                                <a href='<?php echo $url_activar_header."usuario=".$usuarioActivoSesion->getId()."&tipo_usuario=".$uType->getTipoUsuario()->getId()."&id_usuario_sistema=".$uType->getUserSistema()."&alias_usuario_sistema=".$uType->getAliasUserSistema(); ?>' style="font-weight: 100; font-family: monospace;">
                                  <?php echo trim($name) ?>
                                  
                                </a>
                              </li>
                          <?php }
                       }
                      }
                      ?>
                    </ul>
                  </div>
                </li>
              </ul>
            </li>
            <?php } else{ ?>
              <span class="label-primary" style="padding: 3px;"><?php echo $strTipoLogin; ?></span>
            <?php } ?>
          </label>

          <?php
            if(!PRODUCCION)
              echo "<span class='label label-danger'>SISTEMA DE DESARROLLO</span>";
          ?>

          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">

              <!-- CERRADAS PROBLEMAS -->
              <?php include_once PATH_VISTA.'Notificaciones/cerr_problemas.php'; ?>
              <!-- FIN CERRADAS PROBLEMAS -->
              <!-- IMPORTACIONES -->
              <?php include_once PATH_VISTA.'Notificaciones/importaciones.php'; ?>
              <!-- FIN IMPORTACIONES -->
              <!-- PEDIDOS -->
              <?php include_once PATH_VISTA.'Notificaciones/pedidos.php'; ?>
              <!-- FIN PEDIDOS -->
              <!-- STOCK -->
              <?php include_once PATH_VISTA.'Notificaciones/stock.php'; ?>
              <!-- FIN STOCK -->
              <!-- LICENCIAS -->
              <?php include_once PATH_VISTA.'Notificaciones/licencias.php'; ?>
              <!-- FIN LICENCIAS -->
              <!-- ASISTENCIAS -->
              <?php include_once PATH_VISTA.'Notificaciones/asistencia.php'; ?>
              <!-- FIN ASISTENCIAS -->
              <!-- AUSENTE -->
              <?php include_once PATH_VISTA.'Notificaciones/ausente.php'; ?>
              <!-- FIN AUSENTE -->
              
              <?php include_once PATH_VISTA.'Notificaciones/kanban.php'; ?>

              <li class="dropdown notifications-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                  <i class="fa fa-bullhorn"></i>                     
                  <?php 
                      
                    if($usuarioActivoSesion->getUsuarioPerfil()->getId()==1 || $usuarioActivoSesion->getUsuarioPerfil()->getId()==3){
                      echo "<span id='contador_noti_admin' class='label' style='font-size:12px;'></span>";
                    }

                    if($usuarioActivoSesion->getUsuarioPerfil()->getId()==2){                         
                      echo "<span id='contador_noti_user' class='label' style='font-size:12px;'></span>";
                    }

                    if(!is_null($usuarioActivoSesion->getTipoUsuario())){
                        
                      if(count($usuarioActivoSesion->getTipoUsuario())==1){

                        if($usuarioActivoSesion->getTipoUsuario()->getId()==1){                                        
                          echo "<span id='contador_noti_empresa' class='label' style='font-size:12px;'></span>";
                        }                  
                      }
                    }
                  ?>

                </a>
                <ul class="dropdown-menu">                
                  <li>                      
                    <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: auto;">
                      <ul class="menu" style="overflow: auto; width: 100%; height: auto;">
                        <?php          

                          if(!is_null($usuarioActivoSesion->getUsuarioPerfil())){         
                            if($usuarioActivoSesion->getUsuarioPerfil()->getId()==1 || $usuarioActivoSesion->getUsuarioPerfil()->getId()==3)
                            {  
                              
                              if(!empty($arrNotificaiones)){                              

                                foreach ($arrNotificaiones as $key => $value) {                              

                                  if(isset($_GET["view"]))
                                    $url_borrar_notificacion = PATH_VISTA.'Notificaciones/action_borrar.php?id='.$value->getId()."&vista=".$_GET["view"];
                                  else
                                    $url_borrar_notificacion = PATH_VISTA.'Notificaciones/action_borrar.php?id='.$value->getId()."&vista=";

                                  $data = $handler->establerFormatOrigen($value->getOrigen());
                                  $url_link_notificacion = "index.php?".$data["link"];

                                  //SI ES ADMIN
                                  if(!is_null($usuarioActivoSesion->getUsuarioPerfil())){
                                    if($usuarioActivoSesion->getUsuarioPerfil()->getId()==(int) $data["perfil_usuario"]){
                                      
                                      /*if(!is_null($usuarioActivoSesion->getTipoUsuario())){
                                        if($usuarioActivoSesion->getTipoUsuario()->getId()==(int) $data["tipo_usuario"]){*/

                                          echo "
                                            <li>
                                              <a class='pull-right close' href='".$url_borrar_notificacion."'>×</a>                                
                                              <a href='".$url_link_notificacion."'>"
                                                .$value->getFechaHora()->format('d/m/Y')." | ".$value->getFechaHora()->format('H:i')." HS. <br>
                                                <b>".$value->getOrigen()."</b><br>"
                                                .$value->getDetalle().
                                              "</a>
                                            </li>";

                                            $i_contador_admin=$i_contador_admin+1;
                                        /*}
                                      }*/

                                    }
                                  }

                                }
                              }
                            }
                          }

                          if(!is_null($usuarioActivoSesion->getUsuarioPerfil())){
                            if($usuarioActivoSesion->getUsuarioPerfil()->getId()==2)
                              if(!empty($arrNotificaionesUsuario)){                              

                                foreach ($arrNotificaionesUsuario as $key => $value) {   
                                  
                                  if(isset($_GET["view"]))
                                    $url_borrar_notificacion = PATH_VISTA.'Notificaciones/action_borrar.php?id='.$value->getId()."&vista=".$_GET["view"];
                                  else
                                    $url_borrar_notificacion = PATH_VISTA.'Notificaciones/action_borrar.php?id='.$value->getId()."&vista=";


                                  $data = $handler->establerFormatOrigen($value->getOrigen());
                                  $url_link_notificacion = "index.php?".$data["link"];                            

                                  //SI ES USUARIO
                                  if(!is_null($usuarioActivoSesion->getUsuarioPerfil())){
                                    if($usuarioActivoSesion->getUsuarioPerfil()->getId()==(int)  $data["perfil_usuario"]){
                                      
                                      if(!is_null($usuarioActivoSesion->getTipoUsuario())){
                                        if($usuarioActivoSesion->getTipoUsuario()->getId()==(int) $data["tipo_usuario"]){

                                          echo "
                                            <li>
                                              <a class='pull-right close' href='".$url_borrar_notificacion."'>×</a>                                
                                              <a href='".$url_link_notificacion."'>"
                                                .$value->getFechaHora()->format('d/m/Y')." | ".$value->getFechaHora()->format('H:i')." HS. <br>
                                                <b>".$value->getOrigen()."</b><br>"
                                                .$value->getDetalle().
                                              "</a>
                                            </li>";


                                            $i_contador_user=$i_contador_user+1;
                                        }                            
                                      }

                                  }
                                }
                              }
                            }
                          }

                          if(!is_null($usuarioActivoSesion->getTipoUsuario())){
                              
                            if(count($usuarioActivoSesion->getTipoUsuario())==1){

                              if($usuarioActivoSesion->getTipoUsuario()->getId()==1){
                                if(!empty($arrNotificaionesEmpresa)){                              

                                  foreach ($arrNotificaionesEmpresa as $key => $value) {   

                                    //var_dump("asdasdasldjaksld");
                                    //exit();
                                    
                                    if(isset($_GET["view"]))
                                      $url_borrar_notificacion = PATH_VISTA.'Notificaciones/action_borrar.php?id='.$value->getId()."&vista=".$_GET["view"];
                                    else
                                      $url_borrar_notificacion = PATH_VISTA.'Notificaciones/action_borrar.php?id='.$value->getId()."&vista=";


                                    $data = $handler->establerFormatOrigen($value->getOrigen());
                                    $url_link_notificacion = "index.php?".$data["link"];                            

                                    

                                    echo "
                                      <li>
                                        <a class='pull-right close' href='".$url_borrar_notificacion."'>×</a>                                
                                        <a href='".$url_link_notificacion."'>"
                                          .$value->getFechaHora()->format('d/m/Y')." | ".$value->getFechaHora()->format('H:i')." HS. <br>
                                          <b>".$value->getOrigen()."</b><br>"
                                          .$value->getPlaza()." envío guías
                                          </a>
                                      </li>";


                                      $i_contador_empresa=$i_contador_empresa+1;
                                         
                                  }
                                }
                              }
                            }
                          }                        
                        ?>
                      </ul>                    
                    </div>
                  </li>                
                </ul>
              </li>


              <?php                
                  if(StringUser::emptyUser($usuarioActivoSesion->getFotoPerfil()))
                    $foto_perfil = PATH_VISTA."assets/dist/img/sinlogo_usuario.png";                                                        
                  else                  
                    $foto_perfil = PATH_CLIENTE.$usuarioActivoSesion->getFotoPerfil();                                      
              ?>

              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <img src=<?php echo $foto_perfil; ?> class="user-image" alt="User Image"/>
                  <span class="hidden-xs"><?php echo $usuarioActivoSesion->getNombre().' '.$usuarioActivoSesion->getApellido(); ?></span>
                </a>
                <ul class="dropdown-menu">
                  <!-- User image -->
                  <li class="user-header"  style="height: 200px;">
                    <img src=<?php echo $foto_perfil; ?> class="img-circle" alt="User Image" />
                    <p>
                      <?php echo $usuarioActivoSesion->getNombre().' '.$usuarioActivoSesion->getApellido(); ?>
                      <br>
                      <?php echo $usuarioActivoSesion->getEmail(); ?>
                      <small><?php echo '<u>ID Usuario:</u> '.$usuarioActivoSesion->getId(); ?> | <?php echo '<u>Perfil:</u> '.$usuarioActivoSesion->getUsuarioPerfil()->getNombre(); ?></small>          

                      <?php
                        if($usuarioActivoSesion->getUsuarioPerfil()->getId()==2)
                        {
                          if(is_object($usuarioActivoSesion->getTipoUsuario())){
                            echo "
                              <small><u>Tipo Usuario:</u> ".$usuarioActivoSesion->getTipoUsuario()->getNombre()." | <u>Asociado Con:</u> ".$usuarioActivoSesion->getAliasUserSistema()."</small>";
                          }
                        }
                      ?>

                    </p>                                        
                  </li>                                   
                  <li class="user-footer">
                    <div class="pull-left">
                      <a href=<?php echo $url_logout; ?> class="btn btn-bg btn-default btn-flat margin">Cerrar Sesión</a>
                    </div>                    
                    <div class="pull-right">                      
                      <a href=<?php echo $url_perfil; ?> class="btn bg-purple btn-flat margin">Perfil</a>                                            
                    </div>
                  </li>
                </ul>
              </li>
              <?php
              if($usuarioActivoSesion->getCambioRol()){               
              ?>
                <!-- Control Sidebar Toggle Button -->
                <li>
                  <a href="#" data-toggle="control-sidebar"><i class="fa fa-refresh" data-toggle="tooltip" data-placement="bottom" title="Cambio de Rol"></i></a>
                </li>
            <?php } ?>
            </ul>
          </div>
        </nav>
      </header>

<?php
  echo 
    '<script type="text/javascript">          
        var cont_admin="'.$i_contador_admin.'";              
        var cont_user="'.$i_contador_user.'";              
        var cont_empresa="'.$i_contador_empresa.'";              

        if(cont_admin>0){
          $("#contador_noti_admin").text(cont_admin);
          $("#contador_noti_admin").addClass("label-danger");
        }
        if(cont_user>0){
          $("#contador_noti_user").text(cont_user);
          $("#contador_noti_user").addClass("label-danger");
        }
        if(cont_empresa>0){
          $("#contador_noti_empresa").text(cont_empresa);
          $("#contador_noti_empresa").addClass("label-danger");
        }        
    </script>';

?>