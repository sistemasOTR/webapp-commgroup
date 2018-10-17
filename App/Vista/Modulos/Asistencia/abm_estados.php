<?php
  include_once PATH_NEGOCIO."Expediciones/handlerexpediciones.class.php";     
  include_once PATH_NEGOCIO."Sistema/handlerconsultascontrol.class.php";    
  include_once PATH_NEGOCIO."Funciones/Fechas/fechas.class.php"; 
  include_once PATH_NEGOCIO."Funciones/Array/funcionesarray.class.php"; 
  include_once PATH_NEGOCIO."Usuarios/handlerusuarios.class.php";         
  include_once PATH_NEGOCIO."Modulos/handlerasistencias.class.php";         
  include_once PATH_NEGOCIO."Usuarios/handlerperfiles.class.php";         

  $url_action_guardar_estado = PATH_VISTA.'Modulos/Asistencia/action_guardar_estado.php';
   $url_action_eliminar_estado = PATH_VISTA.'Modulos/Asistencia/action_eliminar_estado.php';


  $handlerAsistencia = new HandlerAsistencias;
  $handlerPerfil = new HandlerPerfiles;
  $arrEstados = $handlerAsistencia->selectEstados();
  $arrUserPerfil = $handlerPerfil->selectTodos();
  // var_dump($arrUserPerfil);
  // exit();
?>

<div class="content-wrapper">  
  <section class="content-header">
    <h1 style="text-align: center;">
      ESTADOS
      <small>Agregar, modificar y eliminar los estados de Asistencia</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
      <li class="active">Estados</li>
    </ol>
  </section>        
  
  <section class="content">

    <?php include_once PATH_VISTA."error.php"; ?>
    <?php include_once PATH_VISTA."info.php"; ?>


    <div class="row">

      <div class='col-md-6 col-md-offset-3'>
        <div class="box box-solid">
            <div class="box-header with-border">    
              <h3 class="box-title">Estados</h3>
              <a href="#" class="btn btn-success pull-right" id="btn-nuevo" data-accion='nuevo' data-toggle='modal' data-target='#modal-nuevo' onclick="cargarNuevo()">
                  Nuevo
              </a>
            </div>

            <div class="box-body table-responsive">
              <table class="table table-striped table-condensed" id="tabla" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th>NOMBRE</th>
                      <th>PERFIL</th>
                      <th>COLOR</th>
                      <th colspan="2" style="text-align: center;">ACCIÓN</th>

                      <th style="width: 3%;" class='text-center'></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                      if (!empty($arrEstados)) {
                        
                      foreach ($arrEstados as $key => $value) {
                     if ($value->getUsuarioPerfil()==0) {
                       $perfil='PARA TODOS';
                     }else{
                        $idEstado=$handlerPerfil->selectById($value->getUsuarioPerfil()); 
                        $perfil=$idEstado->getNombre();
                      }
                           ?>
                        <tr>
                          <td> <?php echo $value->getNombre();?> </td>
                          <td> <?php echo $perfil;?> </td>
                          <td> <?php echo "<span class='".$value->getColor()."'><b></b></span>";  ?> </td>
                          <td width="150"> <a href="#" id='<?php echo $value->getId() ?>_edit'  data-id='<?php echo $value->getId() ?>' data-color='<?php echo $value->getColor() ?>' data-perfil='<?php echo $value->getUsuarioPerfil() ?>'data-productivo='<?php echo $value->getProductivo() ?>' data-nombre='<?php echo $value->getNombre() ?>' data-ejemplo='asdadasd'  data-accion='editar' class="btn btn-warning btn-xs" data-toggle='modal' data-target='#modal-nuevo' onclick='cargarDatos(<?php echo $value->getId();?>)'>Editar</a></td>
                          <td width="50"> <a href="#" class='btn btn-danger btn-xs' id='<?php echo $value->getId() ?>_elim' data-action="eliminar" onclick='eliminarDatos(<?php echo $value->getId() ?>)' data-id='<?php echo $value->getId() ?>' data-toggle='modal' data-target='#modal-eliminar'>Eliminar</a></td>
                        </tr>
                        <?php 
                        }
                      }
                    ?>
                  </tbody>
              </table>
            </div>
          </div>
          </div>
        </div>

    <div class="modal fade in" id="modal-nuevo">
  <div class="modal-dialog">
    <div class="modal-content">

      <form action="<?php echo $url_action_guardar_estado; ?>" method="post">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span></button>
          <h4 class="modal-title"></h4>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                  <label>NOMBRE</label>
                  <input type="text" name="nombre" id="input_nombre" required="" class="form-control" >
                   <input type="number" name="estado" id="estado" style="display:none;">
                  <input type="" name="accion" id="accion" style="display:none;">
                  <input type="" name="tipo_id" id="tipo_id" style="display:none;">
                </div> 
                <div class="col-md-4">
                  <label>PERFIL</label>
                 <select id="perfil" class="form-control" required="" style="width: 100%" name="perfil" >
                  <option value="0" >PARA TODOS</option>
                  <?php foreach ($arrUserPerfil as $key => $value) {
                     echo "<option value='".$value->getId()."'>".$value->getNombre()."</option>";
                  } ?>
                </select>
                </div>
                <div class="col-md-3">
                  <label>COLOR</label>
                  <select class="form-control" id="color" required="" name="color">
                  <option class="btn-danger" value="label badge label-danger">Rojo</option>
                  <option class="btn-success" value="label badge label-success">Verde</option>
                  <option class="btn-warning" value="label badge label-warning">Amarillo</option>
                  <option class="btn-primary" value="label badge label-primary">Azul</option>
                  <option class="btn-info" value="label badge label-info">Cian</option>
                  <option class="btn-default" value="label badge label-default">Gris</option>
                  </select>
                </div>
                <div class="col-md-4">
                  <label>FUNCIÓN</label>
                 <select id="productividad" class="form-control" required="" style="width: 100%" name="productividad" >
                  <!-- <option value="" ></option> -->
                  <option value='1' >PRODUCTIVO</option>
                  <option value='0' >IMPRODUCTIVO</option>
                </select>
                </div>

            </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Guardar</button>
        </div>
      </form>

    </div>
  </div>
</div>

<div class="modal modal-danger fade" id="modal-eliminar">
     <div class="modal-dialog">
    <div class="modal-content">

      <form action="<?php echo $url_action_eliminar_estado ;?>" method="post" enctype="multipart/form-data">
        <input type="hidden" name="usuario" value="<?php echo $fusuario; ?>">

        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span></button>
          <h4 class="modal-title">Eliminar</h4>
        </div>      
             
        <div class="modal-body">
            <div class="row"> 
              <h4 class="container">Esta Seguro Que Quiere Eliminar Esta Opción?</h4>
                <input type="hidden" name="id_eliminar" id="id_eliminar" class="form-control"  required="" estado ='".$this->getEstado()."'>  
              </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-danger">Eliminar</button>
        </div>
      </form>

    </div>
  </div>
</div>


  </section>
</div>

<script type="text/javascript">
  $(document).ready(function(){                
    $("#mnu_asistencias_estados").addClass("active");
  }); 
   

 function cargarDatos(id){

    
    nombre = document.getElementById(id+"_edit").getAttribute('data-nombre');
    tipo_id = document.getElementById(id+"_edit").getAttribute('data-id');
    accion= document.getElementById(id+"_edit").getAttribute('data-accion');
    perfil= document.getElementById(id+"_edit").getAttribute('data-perfil');
    colores= document.getElementById(id+"_edit").getAttribute('data-color');
    productivo= document.getElementById(id+"_edit").getAttribute('data-productivo');

   
   
    document.getElementById("input_nombre").value = nombre;
    document.getElementById("tipo_id").value = tipo_id;
    document.getElementById("accion").value = accion;
    document.getElementById("perfil").value = perfil;
    document.getElementById("color").value = colores;
    document.getElementById("productividad").value = productivo;
    
  }
  function cargarNuevo(){
    
    estado = document.getElementById('btn-nuevo').getAttribute('data-accion');
   
    document.getElementById("accion").value = estado;
     document.getElementById("input_nombre").value = '';
     document.getElementById("perfil").value = '';
     document.getElementById("color").value = '';
     document.getElementById("productividad").value = '';

    
  }
  function eliminarDatos(id){

    id_eliminar = document.getElementById(id+'_elim').getAttribute('data-id');
    document.getElementById("id_eliminar").value = id_eliminar;
  
  }
</script>
