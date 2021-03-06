<?php
  include_once PATH_NEGOCIO."Funciones/String/string.class.php";
  include_once PATH_NEGOCIO."Usuarios/handlerusuarios.class.php";	
  include_once PATH_NEGOCIO."Usuarios/handlertipousuarios.class.php"; 
  include_once PATH_NEGOCIO."Usuarios/handlerplazausuarios.class.php";  
  include_once PATH_NEGOCIO."Usuarios/handlerperfiles.class.php";
  include_once PATH_NEGOCIO."Sistema/handlersistema.class.php";
  include_once PATH_NEGOCIO."Modulos/handlercelulares.class.php";
  include_once PATH_NEGOCIO."Modulos/handlerlegajos.class.php"; 
  include_once PATH_NEGOCIO."Funciones/Fechas/fechas.class.php";
  include_once PATH_NEGOCIO."Modulos/handlertickets.class.php";
  include_once PATH_NEGOCIO."Sistema/handlerconsultas.class.php";
  include_once PATH_NEGOCIO."Modulos/handlerpuntaje.class.php";
  include_once PATH_NEGOCIO."Modulos/handlersueldos.class.php";


  $url_update = PATH_VISTA.'Modulos/UsuariosAdmin/action_update_usuario.php';  
  $url_delete = PATH_VISTA.'Modulos/UsuariosAdmin/action_delete_usuario.php';  
  
  $url_volver = "?view=usuarioABM";
  $dFechas=new Fechas;
  $id = (isset($_GET["id"])?$_GET["id"]:"");
  $handlerTickets = new HandlerTickets;
 
  $user=null;
  if(!empty($id)){
    $handler = new HandlerUsuarios;
    $handlerConsultas = new HandlerConsultas;
    $handlerPuntaje = new HandlerPuntaje;
    $handlerSueldos = new HandlerSueldos;
    $user = $handler->selectById($id);
    $handlerLegajo= new HandlerLegajos;
    $legajo = $handlerLegajo->seleccionarLegajos($id);

    // var_dump($user->getUsuarioPerfil()->getId());
    // exit();
  }

  $handlerTU = new HandlerTipoUsuarios;
  $arrTipoUser = $handlerTU->selectTodos();

  $handlerCel = new HandlerCelulares;
  $arrDatosCel = $handlerCel->getEntregasByUser($id);

  $handlerSistema = new HandlerSistema;
  $arrEmpresa = $handlerSistema->selectAllEmpresa();
  $arrGerente = $handlerSistema->selectAllGerente();
  $arrGestor = $handlerSistema->selectAllGestor(null);
  $arrCoordinador = $handlerSistema->selectAllCoordinador(null);
  $arrOperador = $handlerSistema->selectAllOperador();

  $handlerPlaza = new HandlerPlazaUsuarios;
  $arrPlaza = $handlerPlaza->selectTodas();

  $handlerLegajos= new HandlerLegajos;
  $arrTipoCategorias = $handlerLegajos->selecionarTiposCategorias();

  $handlerP = new HandlerPerfiles;
  $arrPerfiles = $handlerP->selectTodosNoAdmin(); 

  $pestaña = (isset($_GET["pestaña"])?$_GET["pestaña"]:'');
  switch ($pestaña) { 
    case 'viaticos':
      $act_1 = '';
      $act_2 = '';
      $act_3 = '';
      $act_4 = '';
      $act_5 = 'active';
      $act_6 = '';
      break;
    case 'comisiones':
      $act_1 = '';
      $act_2 = '';
      $act_3 = '';
      $act_4 = '';
      $act_5 = '';
      $act_6 = 'active';
      break;
    
    default:
      $act_1 = ' active';
      $act_2 = '';
      $act_3 = '';
      $act_4 = '';
      $act_5 = '';
      $act_6= '';
      break;
    }

  
  // var_dump($url_activar);
  // exit(); 
  $url_impresion_celu = PATH_VISTA.'Modulos/Herramientas/Celulares/imprimir_comodato.php?'; 
  $url_impresion_celu_baja = PATH_VISTA."Modulos/Herramientas/Celulares/imprimir_baja_comodato.php?"; 
?>

  <div class="content-wrapper">    
    <section class="content-header">
      <h1>
        Usuario
        <small>Edición </small>
      </h1>
      <ol class="breadcrumb">
        <li><i class="fa fa-dashboard"></i> Inicio</li>
        <li>Usuario</li>
        <li class="active">Edición</li>
      </ol>
    </section>            
    <section class="content">

	    <?php include_once PATH_VISTA."error.php"; ?>
      <?php include_once PATH_VISTA."info.php"; ?>

  		<div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Edición del Usuario</h3>
        </div>        
        <form action=<?php echo $url_update; ?> method="post" enctype="multipart/form-data">
          <input type="hidden" name="id" value=<?php echo $user->getId();?>>          

          <div class="box-body">          
            <div class="form-group">

              <div class="row">

                
                <div class="col-md-6">
                  <div class="col-md-4">              
                    <label for="nombre">Nombre</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ingresa tu nombre" value='<?php echo $user->getNombre(); ?>'>
                  </div>
                
                  <div class="col-md-4">
                    <label for="apellido">Apellido</label>
                    <input type="text" class="form-control" id="apellido" name="apellido" placeholder="Ingresa tu apellido" value='<?php echo $user->getApellido(); ?>'>
                  </div>
                    <?php 
                    if(!empty($legajo)){
                      $dni = $legajo->getDni();
                      $cuit = $legajo->getCuit();
                      if (is_null($legajo->getFechaIngreso())) {
                        $f_ingreso = '';
                      } else {
                        $f_ingreso = $legajo->getFechaIngreso()->format('Y-m-d');
                      }
                      if (is_null($legajo->getNacimiento())) {
                        $f_nac = '';
                      } else {
                        $f_nac = $legajo->getNacimiento()->format('Y-m-d');
                      }
                      $dom = $legajo->getDireccion();
                      $cat = $legajo->getCategoria();
                      $horas_lab = $legajo->getHoras();
                      $num_legajo = $legajo->getNumeroLegajo();
                    } else {
                      $dni = null;
                      $cuit = null;
                      $f_ingreso = '';
                      $f_nac = '';
                      $dom = '';
                      $cat = null;
                      $horas_lab = null;
                      $num_legajo= null;
                    } 
                    ?>
                   <div class="col-md-4 Nocliente">
                    <label for="dni">N° de DNI</label>
                    <input type="number" class="form-control" id="dni" name="dni" placeholder="EJ.: 33921549" value='<?php echo intval($dni); ?>'>
                  </div>

                  <div class="col-md-4 Nocliente">
                    <label for="cuil">N° de CUIL</label>
                    <input type="text" class="form-control" id="cuil" name="cuil" placeholder="EJ.: 20-33921549-9" value='<?php echo $cuit; ?>'>
                  </div>

                  <div class="col-md-4 Nocliente">
                    <label for="fecha_ingreso">Fecha de Ingreso</label>
                    <input type="date" class="form-control" id="fecha_ingreso" name="fecha_ingreso"  value='<?php echo $f_ingreso; ?>'>
                  </div>

                  <div class="col-md-4 Nocliente">
                    <label for="fecha_nacimiento">Fecha de Nacimiento</label>
                    <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento"  value='<?php echo $f_nac; ?>'>
                  </div>

                  <div class="col-md-12 Nocliente">
                    <label for="direccion">Domicilio, Localidad, Provincia, CP</label>
                    <input type="text" class="form-control" id="direccion" name="direccion"  value='<?php echo $dom; ?>'>
                  </div>
                  <div class="col-md-6" style="margin-top: 20px;">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Ingresa un email" value='<?php echo $user->getEmail(); ?>'>
                  </div>

                  <div class="col-md-6" style="margin-top: 20px;">
                    <label for="passwords">Contraseña
                      <i class='fa fa-search-plus pull-right' data-toggle='tooltip' title='' data-original-title='<?php echo $user->getPasswordAux(); ?>'></i>
                    </label>
                    <input type="password" class="form-control" id="passwords" name="password" placeholder="Ingresa la contraseña" value='<?php echo $user->getPasswordAux(); ?>'>
                  </div>
                
                  <div class="col-md-8" style="margin-top: 20px;">  
                    <label>Perfil</label>                          
                    <select id="slt_perfil" class="form-control"  style="width: 100%" name="slt_perfil" required="">                    
                      <option ></option>
                      <?php
                        if(!empty($arrPerfiles))
                        {                        
                          foreach ($arrPerfiles as $key => $value) {
                            if($user->getUsuarioPerfil()->getId()==$value->getId())
                              echo "<option value='".$value->getId()."' selected>".$value->getNombre()."</option>";
                            else
                              echo "<option value='".$value->getId()."'>".$value->getNombre()."</option>";
                          }
                        }                      
                      ?>                      
                    </select>                  
                  </div>

                  <div class="col-md-4" style="margin-top: 40px;">
                    <div class="checkbox">
                      <label>
                        <?php if($user->getCambioRol()){ ?>
                          <input type="checkbox" name="cambio_rol" checked=""> Permitir Cambio de Rol
                        <?php }else{ ?>
                          <input type="checkbox" name="cambio_rol"> Permitir Cambio de Rol
                        <?php } ?>
                      </label>
                    </div>                    
                  </div>

                  <div class="col-md-4 Nocliente">
                <label>Tipo Categoria</label>
                <select name="slt_categoria"  id="slt_categoria" class='form-control' value='' >
                  <option></option>
                  <?php
                  if ($cat > 0) {
                    if(!empty($arrTipoCategorias)){                    
                        foreach ($arrTipoCategorias as $key => $value) {
                          if($cat == $value->getId()){
                          echo "<option value=".$value->getId()." selected>".$value->getCategoria()."</option>";
                        }else{
                            echo "<option value=".$value->getId().">".$value->getCategoria()."</option>";
                          }
                       }                  
                    }     
                  } else {
                    if(!empty($arrTipoCategorias)){                    
                        foreach ($arrTipoCategorias as $key => $value) {
                            echo "<option value=".$value->getId().">".$value->getCategoria()."</option>";
                       }
                    }
                  }              
                  ?>
                </select>
              </div>   
               <div class="col-md-4 Nocliente">
                    <label for="apellido ">Horas Laborales</label>
                    <input type="number" class="form-control" id="horas" name="horas"  value='<?php echo $horas_lab; ?>'>
                  </div>

                  <div class="col-md-4 Nocliente">
                    <label for="apellido">Nº Legajo</label>
                    <input type="number" class="form-control" id="legajo" name="legajo"  value='<?php echo $num_legajo; ?>'>
                  </div>

                  <div class="col-md-6" style="">  
                    <label>Plaza</label>                          
                    <select id="slt_plaza" class="form-control" style="width: 100%" name="slt_plaza" required="">                    
                      <option></option>
                      <?php
                        if(!empty($arrPlaza))
                        {                        
                          foreach ($arrPlaza as $key => $value) {
                            if($user->getUserPlaza() == $value->getId())
                              echo "<option value='".$value->getId()."' selected>".$value->getNombre()."</option>";
                            else
                              echo "<option value='".$value->getId()."'>".$value->getNombre()."</option>";
                          }
                        }                      
                      ?>                      
                    </select>                  
                  </div>

                  <?php  if ($user->getUsuarioPerfil()->getId()!=6) {

                    if ($legajo) {
                    if(!empty($legajo->getFechaBaja())){
                   if ($legajo->getFechaBaja()->format('d-m-Y')!='01-01-1900') {
                    // var_dump($legajo->getFechaBaja());
                    ?> 

                  <div class="col-md-4 Nocliente">
                    <label for="apellido" class="text-red">Fecha Baja</label>
                    <input type="text" class="form-control text-red" id="fecha_baja" name="fecha_baja" disabled  value='<?php echo $legajo->getFechaBaja()->format('d-m-Y'); ?>'>
                  </div>
                  <?php } } } }?>                 
                </div>

                <div class="col-md-6">
                  <div class="col-md-3">
                    <?php                        
                        if(StringUser::emptyUser($user->getFotoPerfil()))
                          $foto_perfil = PATH_VISTA."assets/dist/img/sinlogo_usuario.png";                          
                        else
                          $foto_perfil = PATH_CLIENTE.$user->getFotoPerfil();
                          
                    ?>
                    <img id="foto_view" src=<?php echo $foto_perfil; ?> style="width: 100%;">
                  </div>
                  <div class="col-md-9">                    
                    <label for="foto">Foto Perfil</label>
                    <input type="file" id="foto" name="foto" accept=".jpg, .png, .gif">                
                    <p class="help-block">Selecciona una imagen de perfil</p>
                  </div>

                  <div class="col-md-12">
                    <div class="box box-danger" style="margin-top: 20px;">
                      <div class="box-header with-border">
                        <i class="fa fa-user"></i>
                        <h3 class="box-title">Usuario Asociado Activo</h3>
                      </div>                    
                      <div class="box-body">
                        <div class="col-md-6">
                          <label for="apellido">Tipo Usuario </label><br>                 
                          <input type="text" class="form-control" disabled value="<?php echo (is_object($user->getTipoUsuario())?$user->getTipoUsuario()->getNombre():''); ?>">
                        </div>  
                        <div class="col-md-6">
                          <label for="apellido">Usuario Sistema </label><br>                 
                          <input type="text" class="form-control" disabled value="<?php echo (is_object($user->getTipoUsuario())?$user->getUserSistema().' - '.$user->getAliasUserSistema():''); ?>">
                        </div> 
                      </div>            
                    </div>
                  </div>                  
                </div>
                             
                
              </div>             

            </div>                                                  
          </div>

          <div class="box-footer">
            <a href='<?php echo $url_volver; ?>' class="pull-left btn btn-default"><i class="fa fa-chevron-left"></i> Volver</a>
            <?php if ($user->getUsuarioPerfil()->getId()!=6) {

            if ($legajo) {
              if(!empty($legajo->getFechaBaja())){

            if ($legajo->getFechaBaja()->format('d-m-Y')!='01-01-1900') { 
              $url_activar = PATH_VISTA.'Modulos/UsuariosAdmin/action_activar_usuario.php?id_aprobar='.$user->getId().'&id_legajo='.$legajo->getId().'&perfil='.$user->getUsuarioPerfil()->getId(); ?>
              <a class="btn btn-primary pull-right" href="<?php echo $url_activar ?>"><i class="fa fa-check"></i> Activar Usuario</a>
              <script>
                $(document).ready(function() {
                $("#delete_user").hide();
                });     
              </script>
              <?php } } } 
               }else{
                
                if ($user->getEstado()==0) { 
                  $url_activar_cli = PATH_VISTA.'Modulos/UsuariosAdmin/action_activar_usuario.php?id_aprobar='.$user->getId().'&perfil='.$user->getUsuarioPerfil()->getId(); ?>
                <a class="btn btn-primary pull-right" href="<?php echo $url_activar_cli ?>"><i class="fa fa-check"></i> Activar Usuario</a> 
                <script>
                $(document).ready(function() {
                $("#delete_user").hide();
                });     
              </script> 

               <?php } } ?>
               
            <a class="btn btn-danger pull-right" href="#" data-toggle='modal' id="delete_user" data-target='#modalEliminar'><i class="fa fa-trash-o"></i> Eliminar Usuario</a> 
         
            <button type="submit" style="margin-right: 15px" class="btn btn-success pull-right"><i class="fa fa-save"></i> Guardar</button>
          </div>          
        </form>
      </div>
      <!-- Lineas asignadas -->
      <div class="box box-solid " id="asignaciones_user">
      	<div class="box-header with-border">
          <h3 class="box-title">Asignaciones</h3>
        </div>
        <div class="box-body">
	        <div class="nav-tabs-custom">
				<ul class="nav nav-tabs">
					<li class='<?php echo $act_1 ?>'><a href="#tab_1" data-toggle="tab" aria-expanded="true">Líneas</a></li>
					<li class='<?php echo $act_2 ?>'><a href="#tab_2" data-toggle="tab" aria-expanded="false">Equipos</a></li>
          <li class='<?php echo $act_3 ?>'><a href="#tab_3" data-toggle="tab" aria-expanded="false">Impresoras</a></li>
          <li class='<?php echo $act_4 ?>'><a href="#tab_4" data-toggle="tab" aria-expanded="false">Licencias</a></li>
          <li class='<?php echo $act_5 ?>'><a href="#tab_5" data-toggle="tab" aria-expanded="false">Viaticos</a></li>
					<li class='<?php echo $act_6 ?>'><a href="#tab_6" data-toggle="tab" aria-expanded="false">Comisiones</a></li>
				</ul>
				<div class="tab-content col-xs-12">
		          	<div class='tab-pane <?php echo $act_1 ?>' id="tab_1">
		        		<?php include_once PATH_VISTA.'Modulos/UsuariosAdmin/lineas_usuario.php'; ?>
	        		</div>
		          	<div class='tab-pane <?php echo $act_2 ?>' id="tab_2">
		        		<?php include_once PATH_VISTA.'Modulos/UsuariosAdmin/equipos_usuario.php'; ?>
	        		</div>
		          	<div class='tab-pane <?php echo $act_3 ?>' id="tab_3">
                <?php include_once PATH_VISTA.'Modulos/UsuariosAdmin/impresoras_usuario.php'; ?>
              </div>
              <div class='tab-pane <?php echo $act_4 ?>' id="tab_4">
                <?php include_once PATH_VISTA.'Modulos/UsuariosAdmin/cantidad_licencias.php'; ?>
              </div>
              <div class='tab-pane <?php echo $act_5 ?>' id="tab_5">
                <?php include_once PATH_VISTA.'Modulos/UsuariosAdmin/calculo_viaticos.php'; ?>
              </div> 
              <div class='tab-pane <?php echo $act_6 ?>' id="tab_6">
		        		<?php include_once PATH_VISTA.'Modulos/UsuariosAdmin/calculo_comisiones.php'; ?>
	        		</div>
        		</div>
        	</div>
        </div>
      </div>
	

    </section>
  </div>

  <script type="text/javascript">
    function mostrarImagen(input) {
      if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
         $('#foto_view').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
      }
    }
     
    $("#foto").change(function(){
      mostrarImagen(this);
    });

    $(document).ready(function() {
      $("#slt_tipoUsuario").select2({
          placeholder: "Seleccionar un Tipo de Usuario",                  
      });

      $("#slt_empresa").select2({
          placeholder: "Seleccionar Empresa",                  
      });

      $("#slt_gerente").select2({
          placeholder: "Seleccionar Gerente",                  
      });

      $("#slt_gestor").select2({
          placeholder: "Seleccionar Gestor",                  
      });

      $("#slt_coordinador").select2({
          placeholder: "Seleccionar Coordinador",                  
      });

      $("#slt_operador").select2({
          placeholder: "Seleccionar Operador",                  
      });                     
    });


    $("#parent_slt_empresa").hide();
    $("#parent_slt_gerente").hide();
    $("#parent_slt_gestor").hide();
    $("#parent_slt_coordinador").hide();
    $("#parent_slt_operador").hide();

    function mostrarSelector(option){
      
      switch(option.value) {
        case "1":
          $("#parent_slt_empresa").show();
          $("#parent_slt_gerente").hide();
          $("#parent_slt_gestor").hide();
          $("#parent_slt_coordinador").hide();
          $("#parent_slt_operador").hide();
          break;
        case "2":
          $("#parent_slt_empresa").hide();
          $("#parent_slt_gerente").show();
          $("#parent_slt_gestor").hide();
          $("#parent_slt_coordinador").hide();
          $("#parent_slt_operador").hide();
          break;
        case "3":
          $("#parent_slt_empresa").hide();
          $("#parent_slt_gerente").hide();
          $("#parent_slt_gestor").show();
          $("#parent_slt_coordinador").hide();
          $("#parent_slt_operador").hide();
          break;
        case "4":
          $("#parent_slt_empresa").hide();
          $("#parent_slt_gerente").hide();
          $("#parent_slt_gestor").hide();
          $("#parent_slt_coordinador").show();
          $("#parent_slt_operador").hide();
          break;
        case "5":
          $("#parent_slt_empresa").hide();
          $("#parent_slt_gerente").hide();
          $("#parent_slt_gestor").hide();
          $("#parent_slt_coordinador").hide();
          $("#parent_slt_operador").show();
          break;
      }    
    }

  </script>

<div class="modal modal-danger fade" id="modalEliminar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title" id="myModalLabel">Eliminar Usuario</h4>
      </div>
      <form name="formEliminar" id="form" method="post" action=<?php echo $url_delete; ?>>
        <input type="hidden" name="id" value=<?php echo $user->getId();?>>  
        <input type="hidden" name="nombre" value=<?php echo $user->getNombre();?>>  
        <input type="hidden" name="apellido" value=<?php echo $user->getApellido();?>>  
        <input type="hidden" name="perfil" value=<?php echo $user->getUsuarioPerfil()->getId();?>>  
        <?php if ($user->getUsuarioPerfil()->getId()!=6) {?>
        <input type="hidden" name="legajo_id" value=<?php echo $legajo->getId();?>> 
        <?php } ?> 
        <div class="modal-body">
        <div class="row">
         <?php if ($user->getUsuarioPerfil()->getId()!=6) {?> 
        <div class="col-md-4">
          <label>Fecha Baja</label>
        <input type="date" name="fecha_baja" id="fecha_baja" value="<?php echo $dFechas->FechaActual(); ?>" class="form-control">  
        </div>
        <?php } ?> 
        <div class="col-md-8">
          <div id="mensaje_eliminar">
            <P>
              Se eliminará el usuario <b><?php echo $user->getNombre()." ".$user->getApellido(); ?></b>. <br>              
              ¿Desea continuar?
            </P>
          </div>
        </div>
          </div>                    
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Cancelar</button>
          <input  type="submit" name="submit" value="Eliminar" class="btn btn-outline">
        </div>                                      
      </form>
    </div>
  </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
      $("#slt_perfil").select2({
          placeholder: "Seleccionar",                  
      });
    });  

     $(document).ready(function() {
      $("#slt_categoria").select2({
          placeholder: "Seleccionar",                  
      });  
     });      
    $(document).ready(function() {
      $("#slt_plaza").select2({
          placeholder: "Seleccionar",                  
      });
    }); 

    $(document).ready(function() {
      if($("#slt_perfil").val()==6){ 
      $(".Nocliente").hide();                 
      $("#asignaciones_user").hide();                
      }else{
      $(".Nocliente").show();
      $("#asignaciones_user").show(); 
      };
    });   

  </script>