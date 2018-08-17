      <?php
        include_once PATH_NEGOCIO."Usuarios/handlerusuarios.class.php";
        include_once PATH_NEGOCIO."Usuarios/handlerperfiles.class.php";
        $url_cambiar_side=PATH_VISTA.'Modulos/UsuariosAdmin/action_cambiar_rol_usuario_side.php?id=';

        $handlerP = new HandlerPerfiles;
        $arrPerfiles = $handlerP->selectTodosNoAdmin();


      ?>
      <style type="text/css">
        .control-sidebar a {color: white !important;}
        /*.control-sidebar  {height: 100vh}*/
      </style>

      <aside class="control-sidebar control-sidebar-dark">
        <section>
        <?php
          if($usuarioActivoSesion->getCambioRol()){               
        ?>
          
            <ul class="sidebar-menu">
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
        <?php 
          }
        ?>
      </section>
      </aside>