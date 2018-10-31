<?php
  include_once PATH_NEGOCIO."Expediciones/handlerexpediciones.class.php";     
  include_once PATH_NEGOCIO."Sistema/handlerconsultascontrol.class.php";    
  include_once PATH_NEGOCIO."Funciones/Fechas/fechas.class.php"; 
  include_once PATH_NEGOCIO."Funciones/Array/funcionesarray.class.php"; 
  include_once PATH_NEGOCIO."Usuarios/handlerusuarios.class.php";         
  include_once PATH_NEGOCIO."Modulos/handleragenda.class.php";         
  include_once PATH_NEGOCIO."Usuarios/handlerperfiles.class.php";         

  $url_action_guardar_estado = PATH_VISTA.'Modulos/Agenda/action_guardar_estado.php';
   $url_action_eliminar_estado = PATH_VISTA.'Modulos/Agenda/action_eliminar_estado.php';


  $handlerAgenda = new HandlerAgenda;
  $arrEstados = $handlerAgenda->selectEstados();
  // var_dump($arrEstados);
  // exit();
?>

<div class="content-wrapper">  
  <section class="content-header">
    <h1>
      ESTADOS
      <small>Agregar, modificar y eliminar los estados de la Agenda</small>
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
                      <th>COLOR</th>
                      <th style="text-align: center;" width="100">ACCIONES</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                      if (!empty($arrEstados)) {
                        
                      foreach ($arrEstados as $key => $value) {
                        $editar = "<a href='#' id='".$value->getId()."_edit'  data-id='".$value->getId()."' data-color='".$value->getColor()."' data-nombre='".$value->getNombre()."' data-accion='editar' class='btn btn-warning' data-toggle='modal' data-target='#modal-nuevo' onclick='cargarDatos(".$value->getId().")'><i class='fa fa-edit'></i></a>";
                        $eliminar = "<a href='#' class='btn btn-danger' id='".$value->getId()."_elim' data-action='eliminar' onclick='eliminarDatos(".$value->getId()."' data-id='".$value->getId()."' data-toggle='modal' data-target='#modal-eliminar'><i class='fa fa-trash'></i></a>";
                           ?>
                        <tr>
                          <td> <?php echo $value->getNombre();?> </td>
                          <td> <?php echo "<span class='badge ".$value->getColor()."'><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></span>";  ?> </td>
                          <td style="text-align: center;"><?php echo $editar." ".$eliminar; ?></td>
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
          <h4 class="modal-title" id="modal-title"></h4>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-8">
                  <label>NOMBRE</label>
                  <input type="text" name="nombre" id="input_nombre" required="" class="form-control" >
                   <input type="number" name="estado" id="estado" style="display:none;">
                  <input type="" name="accion" id="accion" style="display:none;">
                  <input type="" name="tipo_id" id="tipo_id" style="display:none;">
                </div> 
                <div class="col-md-4">
                  <label>COLOR</label>
                  <select class="form-control" id="color" required="" name="color">
                  <option class="label label-danger" value="label label-danger">Rojo</option>
                  <option class="label label-success" value="label label-success">Verde</option>
                  <option class="label label-warning" value="label label-warning">Amarillo</option>
                  <option class="label label-primary" value="label label-primary">Azul</option>
                  <option class="label label-info" value="label label-info">Cian</option>
                  <option class="label label-default" value="label label-default">Gris</option>
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
    $("#mnu_agenda_estados").addClass("active");
    $("#mnu_agenda").addClass("active");
  }); 
   

 function cargarDatos(id){

    
    nombre = document.getElementById(id+"_edit").getAttribute('data-nombre');
    tipo_id = document.getElementById(id+"_edit").getAttribute('data-id');
    accion= document.getElementById(id+"_edit").getAttribute('data-accion');
    colores= document.getElementById(id+"_edit").getAttribute('data-color');

   
   
    document.getElementById("input_nombre").value = nombre;
    document.getElementById("tipo_id").value = tipo_id;
    document.getElementById("accion").value = accion;
    document.getElementById("color").value = colores;
    document.getElementById("modal-title").innerHTML = 'Editar estado';
    
  }
  function cargarNuevo(){
    
    estado = document.getElementById('btn-nuevo').getAttribute('data-accion');
   
    document.getElementById("accion").value = estado;
     document.getElementById("input_nombre").value = '';
     document.getElementById("color").value = '';
    document.getElementById("modal-title").innerHTML = 'Nuevo estado';

    
  }
  function eliminarDatos(id){

    id_eliminar = document.getElementById(id+'_elim').getAttribute('data-id');
    document.getElementById("id_eliminar").value = id_eliminar;
  
  }
</script>
