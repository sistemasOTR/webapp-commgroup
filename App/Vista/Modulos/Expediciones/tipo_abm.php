<?php
  include_once PATH_NEGOCIO."Expediciones/handlerexpediciones.class.php";     
  include_once PATH_NEGOCIO."Sistema/handlerconsultascontrol.class.php";    
  include_once PATH_NEGOCIO."Funciones/Fechas/fechas.class.php"; 
  include_once PATH_NEGOCIO."Funciones/Array/funcionesarray.class.php"; 
  include_once PATH_NEGOCIO."Usuarios/handlerusuarios.class.php";         

  $url_action_guardar_tipo = PATH_VISTA.'Modulos/Expediciones/action_tipo_abm.php';
  $url_action_editar_tipo = PATH_VISTA.'Modulos/Expediciones/action_tipo_abm.php';
   $url_action_eliminar_tipo = PATH_VISTA.'Modulos/Expediciones/action_tipoeliminar.php';


  $handler = new HandlerExpediciones;
  $arrTipos = $handler->selecionarTipo();
?>

<div class="content-wrapper">  
  <section class="content-header">
    <h1 style="text-align: center;">
      Tipos
      <small>Agregar, modificar y eliminar los tipos de expediciones</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
      <li class="active">Tipos</li>
    </ol>
  </section>        
  
  <section class="content">

    <?php include_once PATH_VISTA."error.php"; ?>
    <?php include_once PATH_VISTA."info.php"; ?>


    <div class="row">

      <div class='col-md-6 col-md-offset-3'>
        <div class="box box-solid">
            <div class="box-header with-border">    
              <h3 class="box-title">Tipos</h3>
              <a href="#" class="btn btn-success pull-right" id="btn-nuevo" data-accion='nuevo' data-toggle='modal' data-target='#modal-nuevo' onclick="cargarNuevo()">
                  Nuevo
              </a>
            </div>

            <div class="box-body table-responsive">
              <table class="table table-striped table-condensed" id="tabla" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th>NOMBRE</th>
                      <th colspan="2" style="text-align: center;">ACCIÓN</th>

                      <th style="width: 3%;" class='text-center'></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                      foreach ($arrTipos as $key => $value) { ?>
                         <tr>
                  
                     <td> <?php echo $value->getGrupo();?> </td>
                     <td width="150"> <a href="#" id='<?php echo $value->getId() ?>' data-id='<?php echo $value->getId() ?>' data-grupo='<?php echo $value->getGrupo() ?>'  data-accion='editar'class="btn btn-warning btn-xs" data-toggle='modal' data-target='#modal-nuevo' onclick='cargarDatos(<?php echo $value->getId() ?>)'>Editar</a></td>
                     <td width="50"> <a href="#" class='btn btn-danger btn-xs' id='<?php echo $value->getId() ?>_elim' data-action="eliminar" onclick='eliminarDatos(<?php echo $value->getId() ?>)' data-id='<?php echo $value->getId() ?>' data-toggle='modal' data-target='#modal-eliminar'>Eliminar</a></td>

                     </tr>
                    <?php 

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

      <form action="<?php echo $url_action_guardar_tipo; ?>" method="post">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span></button>
          <h4 class="modal-title">Nuevo</h4>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                  <label>Nombre</label>
                  <input type="text" name="grupo" id="grupo" class="form-control" >
                   <input type="number" name="estado" id="estado" style="display:none;">
                  <input type="" name="accion" id="accion" style="display:none;">
                  <input type="" name="tipo_id" id="tipo_id" style="display:none;">
                </div> 

            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-primary">Guardar</button>
        </div>
      </form>

    </div>
  </div>
</div>

<div class="modal modal-danger fade" id="modal-eliminar">
     <div class="modal-dialog">
    <div class="modal-content">

      <form action="<?php echo $url_action_eliminar_tipo ;?>" method="post" enctype="multipart/form-data">
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
    $("#mnu_expediciones_tipo_abm").addClass("active");
  });  

 function cargarDatos(id){

    
    grupo = document.getElementById(id).getAttribute('data-grupo');
    tipo_id = document.getElementById(id).getAttribute('data-id');
    estado= document.getElementById(id).getAttribute('data-accion');
   
   
    document.getElementById("grupo").value = grupo;
    document.getElementById("tipo_id").value = tipo_id;
    document.getElementById("accion").value = estado;
    
  }
  function cargarNuevo(){
    
    estado = document.getElementById('btn-nuevo').getAttribute('data-accion');
   
    document.getElementById("accion").value = estado;
     document.getElementById("grupo").value = '';

    
  }
  function eliminarDatos(id){

    id_eliminar = document.getElementById(id+'_elim').getAttribute('data-id');
    document.getElementById("id_eliminar").value = id_eliminar;
  
  }
</script>
