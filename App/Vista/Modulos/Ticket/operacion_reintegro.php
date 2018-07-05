<?php 
    include_once PATH_NEGOCIO."Modulos/handlertickets.class.php";       
    include_once PATH_NEGOCIO."Funciones/Fechas/fechas.class.php"; 

//  include_once PATH_NEGOCIO."Funciones/Array/funcionesarray.class.php"; 
//  include_once PATH_NEGOCIO."Usuarios/handlerusuarios.class.php";
    include_once PATH_NEGOCIO."Sistema/handlersistema.class.php";

    $f = new Fechas;
    $handler = new HandlerSistema;
    $handlerTickets= new HandlerTickets();
    $reintegra= $handlerTickets->selecionarReintegros();
    $arrCoordinador = $handler->selectAllPlazasArray();

  $url_action_editar = PATH_VISTA.'Modulos/Ticket/action_editreintegro.php?id=';
  $url_action_eliminar = PATH_VISTA.'Modulos/Ticket/action_deletereintegro.php?id=';

?>

<div class="content-wrapper">  
  <section class="content-header">
    <h1>
      Ticket
      <small>Operacion de Reintegro </small>
    </h1>
  </section>  
  <section class="content">

    <?php include_once PATH_VISTA."error.php"; ?>
    <?php include_once PATH_VISTA."info.php"; ?>


    <div class="row">

      <div class='col-md-12'>
        <div class="box box-solid">
            <div class="box-header with-border">
              <i class="fa fa-filter"></i>
              <h3 class="box-title">Tabla Reintegros</h3>
              <a href="#" class="btn btn-success pull-right" id="btn-nuevo" data-toggle='modal' data-target='#modal-nuevo' data-estado='nuevo' onclick="cargarNuevo()">
                  Nuevo
              </a>
            </div>


          <div class="box-body table-responsive">
              <table class="table table-striped table-condensed" id="tabla" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th>CODIGO POSTAL</th>
                      <th>DESCRIPCION</th>
                      <th>REINTEGRO</th>  
                      <th>PLAZA</th>
                      <th colspan="2">ACCIÓN</th>

                      <th style="width: 3%;" class='text-center'></th>
                    </tr>
                  </thead>
                  <tbody>
                   
                    <?php 
                    foreach ($reintegra as $key => $value){ ?>  
                       <tr>
                    
                     <td> <?php echo $value->getCp();?> </td>
                     <td> <?php echo $value->getDescripcion();?> </td>
                     <td> <?php echo $value->getReintegro();?> </td>
                     <td> <?php echo $value->getPlaza();?> </td>
                     <td> <a href="#" id='<?php echo $value->getId() ?>' data-id='<?php echo $value->getId() ?>' data-cp='<?php echo $value->getCp() ?>' data-estado='editar'data-descripcion='<?php echo $value->getDescripcion() ?>' data-reintegro='<?php echo $value->getReintegro() ?>'data-plaza='<?php echo $value->getPlaza() ?>' class="btn btn-warning btn-xs" data-toggle='modal' data-target='#modal-nuevo' onclick='cargarDatos(<?php echo $value->getId() ?>)'>Editar</a></td>
                     <td> <a href="#" class='btn btn-danger btn-xs' id='<?php echo $value->getId() ?>_elim' onclick='eliminarDatos(<?php echo $value->getId() ?>)' data-id='<?php echo $value->getId() ?>' data-fechafin='<?php echo $f->FechaActual()?>' data-toggle='modal' data-target='#modal-eliminar'>Eliminar</a></td>

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

      <form action="<?php echo $url_action_editar; ?>" method="post" enctype="multipart/form-data">
        <input type="hidden" name="usuario" value="<?php echo $fusuario; ?>">

        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span></button>
          <h4 class="modal-title">Nuevo</h4>
        </div>
        <div class="modal-body">
            <div class="row">
              <div class="col-md-5">
                <label>Fecha Vigencia</label>
                <input type="date" name="fechaini" class="form-control" required="">
              </div>                                             
              <div class="col-md-6">
                <label>Codigo Postal</label>
                <input type="number" name="codigopostal" id="codigopostal" class="form-control"  required="">
              </div>
              
              <div class="col-md-6">
                <label>Descripcion</label>
                <input type="text" name="descripcion" class="form-control" id="descripcion" required="">
                <input type="text" name="estado" id="estado" style="display: none;" class="form-control" >
                <input type="text" name="reintegro_id" id="reintegro_id" style="display: none;" class="form-control" >
              </div>         
              <div class="col-md-6">
                <label>Reintegro</label>
                <input type="number" name="reintegro" id="reintegro"  class="form-control" step="0.01"  required="">
              </div>   
              <div class="col-md-6">
                <label>Plaza</label>
                <select id="plaza" class="form-control" style="width: 100%" name="plaza" required="" >                              
                  <option value="">Seleccionar...</option>
                  <?php
                    if(!empty($arrCoordinador))
                    {                        
                      foreach ($arrCoordinador as $key => $value) {                                                  
                        echo "<option value='".trim($value['PLAZA'])."'>".$value['PLAZA']."</option>";
                      }
                    }
                    
                  ?>
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
          
         <div class="modal fade in" id="modal-eliminar">
     <div class="modal-dialog">
    <div class="modal-content">

      <form action="<?php echo $url_action_eliminar;?>" method="post" enctype="multipart/form-data">
        <input type="hidden" name="usuario" value="<?php echo $fusuario; ?>">

        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span></button>
          <h4 class="modal-title">Eliminar</h4>
        </div>
        <div class="modal-header">
        <p style="color:red;">Esta Seguro Que Quiere Eliminar Este Codigo Postal?</p>
        </div>
        <div class="modal-body">
            <div class="row">
              
                <input type="date" name="fechafin" id="fechafin"class="form-control" required="" style="display:none;">
                                                           
              
                <input type="number" name="id_eliminar" id="id_eliminar" class="form-control"  required="" style="display:none;">
              
               
              </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Eliminar</button>
        </div>
      </form>

    </div>
  </div>
</div>
         

       
       </section> 
     </div>
  
       
<script>
  
  function cargarDatos(id){
    
    cp = document.getElementById(id).getAttribute('data-cp');
    descripcion = document.getElementById(id).getAttribute('data-descripcion');
    reintegro = document.getElementById(id).getAttribute('data-reintegro');
    plaza = document.getElementById(id).getAttribute('data-plaza');
    estado = document.getElementById(id).getAttribute('data-estado');
    reintegro_id = document.getElementById(id).getAttribute('data-id');
   
    document.getElementById("estado").value = estado;
    document.getElementById("codigopostal").value = cp;
    document.getElementById("descripcion").value = descripcion;
    document.getElementById("reintegro").value = reintegro;
    document.getElementById("plaza").value = plaza;
    document.getElementById("reintegro_id").value = reintegro_id;
    
  }
  function cargarNuevo(){
    
    estado = document.getElementById('btn-nuevo').getAttribute('data-estado');
   
    document.getElementById("estado").value = estado;
     document.getElementById("codigopostal").value = '';
    document.getElementById("descripcion").value = '';
    document.getElementById("reintegro").value = '';
    document.getElementById("plaza").value = '';
    
    
  }
  function eliminarDatos(id){

    id_eliminar = document.getElementById(id+'_elim').getAttribute('data-id');
    fechafin=document.getElementById(id+'_elim').getAttribute('data-fechafin');

    document.getElementById("id_eliminar").value = id_eliminar;
    document.getElementById("fechafin").value = fechafin;





  }
 
  
</script>




