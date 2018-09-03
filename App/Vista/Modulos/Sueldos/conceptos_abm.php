<?php
  include_once PATH_NEGOCIO."Funciones/Fechas/fechas.class.php"; 
  include_once PATH_NEGOCIO."Funciones/Array/funcionesarray.class.php"; 
  include_once PATH_NEGOCIO."Usuarios/handlerusuarios.class.php";
  include_once PATH_NEGOCIO.'Modulos/handlersueldos.class.php';  

  $url_action_guardar_conceptos=PATH_VISTA.'Modulos/Sueldos/action_guardar_concepto.php';
  // $url_action_editar_categorias = PATH_VISTA.'Modulos/Legajos/action_editar_categoria.php';  
  $url_action_eliminar_conceptos = PATH_VISTA.'Modulos/Sueldos/action_eliminar_concepto.php?id=';


  $user = $usuarioActivoSesion;
  $handlerConcepto= new HandlerSueldos;
  $arrSueldos = $handlerConcepto->selectConceptos();
  $fechas= new Fechas;


?>


<div class="content-wrapper">  
  <section class="content-header">
    <h1>
      ABM Conceptos
      <small>Altas, Bajas y Modificaciones de los conceptos salariales</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
      <li class="active">Conceptos Salariales</li>
    </ol>
  </section>        
  
  <section class="content">

    <?php include_once PATH_VISTA."error.php"; ?>
    <?php include_once PATH_VISTA."info.php"; ?>


    <div class="row">

      <div class='col-md-8 col-md-offset-2'>
        <div class="box box-solid">
            <div class="box-header with-border">    
              <h3 class="box-title">Conceptos</h3>
              <a href="#" class="btn btn-success pull-right" id="btn-nuevo" data-accion='nuevo' data-toggle='modal' data-target='#modal-nuevo' onclick="cargarNuevo()">
                  Nuevo
              </a>
            </div>

            <div class="box-body table-responsive">
              <table class="table table-striped table-condensed" id="tabla" cellspacing="0" width="100%">
                  <thead>
                    <tr class="bg-black">
                      <th style="width: 10%;" class='text-center'>ID</th>
                      <th style="width: 50%">CONCEPTO</th>
                      <th style="width: 20%">VALOR</th>
                      <th style="width: 20%;" class='text-center'>ACCIONES</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                       // var_dump($arrSueldos);
                       //     exit();
                      if (!empty($arrSueldos)) {
                        $tipo_concepto = '';
                      foreach ($arrSueldos as $key => $value){ 
                        switch ($value->getBase()) {
                          case 1:
                            $percent = '';
                            break;
                          case 100:
                            $percent = ' %';
                            break;

                          default:
                            $percent = '';
                            break;
                        }
                        ?>
                       

                        <tr>
                          <td class="text-center"> <?php echo $value->getId();?> </td>
                          <td> <?php echo $value->getConcepto();?> </td>
                          <td> <?php echo number_format($value->getValor(),2).$percent;?> </td>
                          <td class="text-center"><a href="#" id='<?php echo $value->getId() ?>' data-id='<?php echo $value->getId() ?>' data-categoria='<?php echo $value->getConcepto() ?>' data-valor='<?php echo $value->getValor() ?>' data-base='<?php echo $value->getBase() ?>' data-accion='editar'class="btn btn-warning" data-toggle='modal' data-target='#modal-nuevo' onclick='cargarDatos(<?php echo $value->getId() ?>)'><i class='fa fa-pencil'></i></a>   <a href="#" class='btn btn-danger' id='<?php echo $value->getId() ?>_elim' data-action="eliminar" onclick='eliminarDatos(<?php echo $value->getId() ?>)' data-id='<?php echo $value->getId() ?>' data-toggle='modal' data-target='#modal-eliminar'><i class="fa fa-trash"></i></a></td>
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

      <form action="<?php echo $url_action_guardar_conceptos; ?>" method="post">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span></button>
          <h4 class="modal-title">Nuevo</h4>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                  <label>Concepto</label>
                  <input type="text" name="categoria" id="categoria" class="form-control" >
                </div>
                <div class="col-md-12">
                  <label>Valor</label>
                  <input type="number" name="valor" id="valor" class="form-control" step="0.01" >
                   <input type="number" name="estado" id="estado" style="display:none;">
                  <input type="" name="accion" id="accion" style="display: none;">
                  <input type="" name="tipo_id" id="tipo_id" style="display:none;">
                </div> 
                <div class="col-md-12">
                  <label>Base</label>
                  <input type="number" name="base" id="base" class="form-control" >
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

      <form action="<?php echo $url_action_eliminar_conceptos ;?>" method="post" enctype="multipart/form-data">
        <input type="hidden" name="usuario" value="<?php echo $fusuario; ?>">

        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span></button>
          <h4 class="modal-title">Eliminar</h4>
        </div>      
             
        <div class="modal-body">
            <div class="row"> 
              <h4 class="container">Esta Seguro Que Quiere Eliminar Esta Opción?</h4>
                <input type="hidden" name="id_eliminar" id="id_eliminar" class="form-control"  required="" >  
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
    $("#mnu_sueldos").addClass("active");
  });
  
  $(document).ready(function(){                
    $("#mnu_legajos_conceptos").addClass("active");
  });

 function cargarDatos(id){
    categoria = document.getElementById(id).getAttribute('data-categoria');
    tipo_id = document.getElementById(id).getAttribute('data-id');
    estado= document.getElementById(id).getAttribute('data-accion');
    valor= document.getElementById(id).getAttribute('data-valor');
    base= document.getElementById(id).getAttribute('data-base');
   
   
    document.getElementById("categoria").value = categoria;
    document.getElementById("valor").value = valor;
    document.getElementById("base").value = base;
    document.getElementById("tipo_id").value = tipo_id;
    document.getElementById("accion").value = estado;
    
  }
  function cargarNuevo(){
    
    estado = document.getElementById('btn-nuevo').getAttribute('data-accion');
   
    document.getElementById("accion").value = estado;
     document.getElementById("categoria").value = '';
     document.getElementById("valor").value = 0;
     document.getElementById("base").value = 0;

    
  }
  function eliminarDatos(id){

    id_eliminar = document.getElementById(id+'_elim').getAttribute('data-id');
    document.getElementById("id_eliminar").value = id_eliminar;
  
  }
</script>