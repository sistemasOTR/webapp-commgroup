<?php
  include_once PATH_NEGOCIO."Expediciones/handlerexpediciones.class.php";     
  include_once PATH_NEGOCIO."Sistema/handlerconsultascontrol.class.php";    
  include_once PATH_NEGOCIO."Funciones/Fechas/fechas.class.php"; 
  include_once PATH_NEGOCIO."Funciones/Array/funcionesarray.class.php"; 
  include_once PATH_NEGOCIO."Usuarios/handlerusuarios.class.php";         

  $url_action_guardar_tipo = PATH_VISTA.'Modulos/Expediciones/action_item_abm.php';
  $url_action_eliminar_tipo = PATH_VISTA.'Modulos/Expediciones/action_itemeliminar.php';
  $url_action_agregar = PATH_VISTA.'Modulos/Expediciones/action_agregaritemcompra.php';
  $url_action_eliminar_pedido = PATH_VISTA.'Modulos/Expediciones/action_eliminaritem_compra.php';
  $url_action_publicar = PATH_VISTA.'Modulos/Expediciones/action_publicarcompra.php?id_usuario='.$usuarioActivoSesion->getId();

  $handler = new HandlerExpediciones;
  $arrItem = $handler->selecionarItem();
  $arrTipo = $handler->selecionarTipo();
  $user = $usuarioActivoSesion;
  $consulta = $handler->seleccionarSinPedir($user->getId());

?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.quicksearch/2.2.1/jquery.quicksearch.js"></script>
<div class="content-wrapper">  
  <section class="content-header "> 
   
 
    <h1>
      Items
      <small>Agregar, modificar y eliminar los Items de expediciones</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
      <li class="active">Tipos</li>
    </ol>
  </section>        
  
  <section class="content">

    <?php include_once PATH_VISTA."error.php"; ?>
    <?php include_once PATH_VISTA."info.php"; ?>

     <aside>
      <div class='col-md-12'>
        <div class="box">
          <div class="box-header">
            <h3 class="box-title"> Detalle Compra</h3>   
            <a href="<?php echo $url_action_publicar; ?>" class="btn btn-success pull-right">Enviar Items</a>
          </div>

          <div class="box-body table-responsive">
            
              <table class="table table-striped" id='tabla'>
                <thead>
                  <tr>
                    <th>FECHA</th>
                    <th>ITEM</th>
                    <th>CANTIDAD</th>             
                  </tr>
                </thead>
                <tbody>
                    <?php if(!empty($consulta))
                      {               

                        if(count($consulta)<=1)
                          $consulta_tmp[0]=$consulta;
                        else
                          $consulta_tmp=$consulta;

                        foreach ($consulta_tmp as $key => $value) {
                          $item = $handler->selectById($value->getItemExpediciones());
                          echo "
                            <tr>
                            <td>".$value->getFecha()->format('d/m/Y')."</td>
                            <td>".$item->getNombre()."</td>
                            <td>".$value->getCantidad()."</td>
                            <td>
                                  <form action='".$url_action_eliminar_pedido."' method='post'>
                                    <input type='hidden' name='id' value='".$value->getId()."'>
                                    <button type='submit' class='btn btn-danger'>Quitar</button>
                                  </form>
                                </td>
                            </tr>     
                          ";
                        }
                      }
                    ?>

            
                  </tbody>
              </table>
          </div>
        </div>
      </div> 

  </aside>
  <style type="text/css">
    aside{
        display:block;
        float:right;
        width: 500px;
       
    }

  </style>


    <div class="row">

      <div class='col-md-8 '>
        <div class="box box-solid">
            <div class="box-header with-border">    
              <h3 class="box-title">Items</h3>
              <a href="#" class="btn btn-success pull-right" id="btn-nuevo" data-accion='nuevo' data-toggle='modal' data-target='#modal-nuevo' onclick="cargarNuevo()">
                  Nuevo
              </a>
            </div>

            <div class="box-body table-responsive">
              <div class="col-xs-12 col-md-3 pull-right"><input type="text" id="search-items" class="form-control" placeholder="Escribe para buscar..." /></div>
              <table class="table table-striped table-condensed" id="tabla-items" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th>ITEM</th>
                      <th>DESCRIPCIÓN</th>
                      <th>TIPO</th>                             
                      <th>STOCK</th>                             
                      <th>PTO PEDIDO</th>                             
                      <th colspan="3" style="text-align: center;">ACCIÓN</th>

                      <th style="width: 3%;" class='text-center'></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    if (!empty($arrItem)) { 

                      foreach ($arrItem as $key => $value) { 
                  
                        ?>
                         <tr>


                    
                     <td> <?php echo $value->getNombre();?> </td>
                     <td> <?php echo $value->getDescripcion();?> </td>
                     <td> <?php echo $value->getGrupo();?> </td>
                     <td> <?php echo $value->getStock();?> </td>
                     <td> <?php echo $value->getPtopedido();?> </td>
                     <td width="50"> <a href="#" id='<?php echo $value->getId() ?>'data-id='<?php echo $value->getId()?>'data-nombre='<?php echo $value->getNombre() ?>'data-stock='<?php echo $value->getStock() ?>'data-ptopedido='<?php echo $value->getPtopedido() ?>'data-numgrupo='<?php echo $value->getGruponum() ?>' data-descripcion='<?php echo $value->getDescripcion() ?>' data-grupo='<?php echo $value->getGrupo() ?>'data-accion='editar'class="btn btn-warning btn-xs" data-toggle='modal' data-target='#modal-nuevo' onclick='cargarDatos(<?php echo $value->getId() ?>)'>Editar</a></td>
                     <td width="50"> <a href="#" class='btn btn-danger btn-xs' id='<?php echo $value->getId() ?>_elim' data-action="eliminar" onclick='eliminarDatos(<?php echo $value->getId() ?>)' data-id='<?php echo $value->getId() ?>' data-toggle='modal' data-target='#modal-eliminar'>Eliminar</a></td>
                     <td width="50"><a href="#" data-toggle='modal' data-target='#modal-agregar'data-nombre='<?php echo $value->getNombre() ?>'data-id='<?php echo $value->getId()?>'class="btn btn-success btn-xs" onclick='agregarPedido(<?php echo $value->getId() ?>)'>Agregar</a></td>

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

      <form action="<?php echo $url_action_guardar_tipo; ?>" method="post">

        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span></button>
          <h4 class="modal-title">Nuevo</h4>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                  <label>NombreItem</label>
                  <input type="text" name="nombre_item" id="nombre_item" class="form-control" >
                  <input type="text" name="estado" id="estado" style="display:none;">
                  <input type="number" name="item_id" id="item_id" style="display:none;">
                  <input type="number" name="numgrupo" id="numgrupo" style="display:none;">
                </div> 
            </div>
            <div class="row">
              <div class="col-md-12">
                <label>Descripcion</label>
                 <input type="text" name="descripcion" id="descripcion"class="form-control">
               </div>
                 </div>
                <div class="row">
                <div class="col-md-12">
                  <label>Stock</label>
                   <input type="number" name="stock" id="stock"class="form-control">
                 </div>
                 <div class="col-md-12">
                  <label>Pto Pedido</label>
                   <input type="number" name="ptopedido" id="ptopedido"class="form-control">
                 </div>
                </div>   
                 <div class="row">
                 <div class="col-md-12">
                   <label>NombreGrupo</label>
                    <select id="grupo" class="form-control" style="width: 100%" name="grupo" required="" >                              
                  <option value="">Seleccionar...</option>
                  <?php
                    if(!empty($arrTipo))
                    {                        
                      foreach ($arrTipo as $key => $value) {                                                  
                        echo "<option value='".$value->getId()."'>".$value->getGrupo()."</option>";
                      }
                    }
                    
                  ?>
                </select>
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
          <h4 class="container" style="">Esta Seguro Que Quiere Eliminar Este Item?</h4>
            <div class="row"> 
                <input type="number" name="id_eliminar" id="id_eliminar" class="form-control"style="display:none;">  

              </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-danger">Eliminar</button>
        </div>
      </form>

    </div>
  </div>
</div>

<div class="modal fade in" id="modal-agregar">
     <div class="modal-dialog">
    <div class="modal-content">

      <form action="<?php echo $url_action_agregar ;?>" method="post" enctype="multipart/form-data">
        <input type="hidden" name="usuario" value="<?php echo $user->getId(); ?>">

        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span></button>
          <h4 class="modal-title">Agregar</h4>
        </div>
        <div class="modal-body">
          <div class="row">
              <div class="col-md-12">
                <label>Nombre</label> 
                <input name="nombreitem" id="nombreitem" class="form-control" value="">
                <input type="hidden" name="id_agregar" id="id_agregar" class="form-control">  
              </div>         
              <div class="col-md-12">
                <label>Cantidad</label> 
                <input type="number" name="cantidad" id="cantidad" class="form-control" value="1">
              </div>
        </div>
      </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Agregar</button>
        </div>
      </form>

    </div>
  </div>
</div>


  </section>

</div>


<script type="text/javascript">

  $(function () {
  $('#search-items').quicksearch('#tabla-items tbody tr');               
});
  $(document).ready(function(){                
    $("#mnu_expediciones_item_abm").addClass("active");
  });  

 function cargarDatos(id){

    item_id = document.getElementById(id).getAttribute('data-id');
    nombre = document.getElementById(id).getAttribute('data-nombre');
    descripcion = document.getElementById(id).getAttribute('data-descripcion');
    grupo = document.getElementById(id).getAttribute('data-grupo');
    estado= document.getElementById(id).getAttribute('data-accion');
    numgrupo= document.getElementById(id).getAttribute('data-numgrupo');
    stock= document.getElementById(id).getAttribute('data-stock');
    ptopedido= document.getElementById(id).getAttribute('data-ptopedido');
   
    document.getElementById("item_id").value = item_id;
    document.getElementById("nombre_item").value = nombre;
    document.getElementById("descripcion").value = descripcion;
    document.getElementById("grupo").value = numgrupo;
    document.getElementById("estado").value = estado;
    document.getElementById("stock").value = stock;
    document.getElementById("ptopedido").value = ptopedido;
    
  }
  function cargarNuevo(){
    
    estado = document.getElementById('btn-nuevo').getAttribute('data-accion');
   
    document.getElementById("estado").value = estado;
    document.getElementById("nombre_item").value = '';
    document.getElementById("descripcion").value = '';
    document.getElementById("stock").value = '';
    document.getElementById("ptopedido").value = '';
     document.getElementById("grupo").value = '';

    
  }
  function eliminarDatos(id){

    id_eliminar = document.getElementById(id+'_elim').getAttribute('data-id');
    document.getElementById("id_eliminar").value = id_eliminar;
   

  }
  function agregarPedido(id){

    id_agregar = document.getElementById(id).getAttribute('data-id');
    nombreitem = document.getElementById(id).getAttribute('data-nombre');

    document.getElementById("id_agregar").value = id_agregar;
    document.getElementById("nombreitem").value = nombreitem;
   

  }
</script>
