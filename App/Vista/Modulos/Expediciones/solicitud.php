<?php
  include_once PATH_NEGOCIO."Expediciones/handlerexpediciones.class.php";


  $url_action_guardar = PATH_VISTA.'Modulos/Expediciones/action_guardar.php';
  $url_action_eliminar = PATH_VISTA.'Modulos/Expediciones/action_eliminar.php';
  $url_action_publicar = PATH_VISTA.'Modulos/Expediciones/action_publicar.php?id_usuario='.$usuarioActivoSesion->getId();
  $url_ajax= PATH_VISTA.'Modulos/Expediciones/selectitemtipo.php';

  $handler = new HandlerExpediciones;
  $arrTipo = $handler->selecionarTipo();
  $arritem = $handler->selecionarItem();

  $user = $usuarioActivoSesion;


  $consulta = $handler->seleccionarSinPublicar($user->getId());
?>

<div class="content-wrapper">  
  <section class="content-header">
    <h1>
      Solicitud
      <small>Realizar un pedido</small>

    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
      <li class="active">Solicitud</li>
    </ol>
  </section>        
  
  <section class="content">

    <?php include_once PATH_VISTA."error.php"; ?>
    <?php include_once PATH_VISTA."info.php"; ?>

    <div class="row">
      <div class="col-md-12">
        <div class="box box-solid">
          <div class="box-header with-border">   
            <i class="fa fa-plus"></i>       
            <h3 class="box-title">Pedido</h3>          
          </div>
          <div class="box-body">

              <form action="<?php echo $url_action_guardar; ?>" method="post">
                <input type="hidden" value="<?php echo $user->getId(); ?>" name="usuario">

                <div class="row">
                  <div class="col-md-3">
                    <div class="form-group">
                      <label>Tipo</label>            
                      <select  id="slt_tipo" class="form-control" style="width: 100%" name="slt_tipo">
                        <option value="">Seleccionar un tipo...</option>
                        <?php 
                          if(!empty($arrTipo)){
                            foreach ($arrTipo as $key => $value) {
                              echo "<option value=".$value->getId().">".$value->getGrupo()."</option>";
                            }
                          }
                        ?>
                      </select>                
                    </div>
                  </div> 
                  <div class="col-md-3">
                    <div class="form-group">
                      <label>Item</label>            
                      <select id="slt_item" class="form-control" style="width: 100%" name="slt_item">
                        <option value="">Escoga un tipo primero</option>
                      </select>                
                    </div>
                  </div>         
                  <div class="col-md-3">
                    <div class="form-group">
                      <label>Detalle</label>            
                      <input type="tex" name="detalle" placeholder="Detalle del pedido" class="form-control">
                      <input type="tex" name="plaza"  value="<?php echo $user->getAliasUserSistema(); ?>" class="form-control" style="display: none;">

                      <input type="tex" name="tipoUsuario"  value="<?php echo $user->getUsuarioPerfil()->getNombre(); ?>" class="form-control" style="display: none;">
                       
                    </div>
                  </div>              
                  <div class="col-md-1">
                    <div class="form-group">
                      <label>Cantidad</label>            
                      <input type="number" name="cantidad" value="1" class="form-control">
                    </div>
                  </div>                              
                  <div class="col-md-2">
                    <div class="form-group" style="margin-top: 25px;">
                      <button type="submit" class="btn btn-primary pull-right">Agregar</button>            
                    </div>
                  </div>
                </div>

              </form>

          </div>          
        </div>
      </div>  

      <div class='col-md-12'>
        <div class="box">
          <div class="box-header">
            <h3 class="box-title"> Detalle Expediciones</h3>   
            <a href="<?php echo $url_action_publicar; ?>" class="btn btn-success pull-right">Enviar Items</a>
          </div>

          <div class="box-body table-responsive">
              <table class="table table-striped" id='tabla'>
                <thead>
                  <tr>
                    <th>FECHA</th>
                    <th>ITEM-DESCRIPCIÓN</th>             
                    <th>CANTIDAD</th>             
                    <th>DETALLE</th>
                    <th>ESTADO</th>             
                    <th>OBSERVACIONES</th>                             
                    <th>ACCION</th>
                  </tr>
                </thead>
                <tbody>
                    <?php

                      if(!empty($consulta))
                      { 
                        foreach ($consulta as $key => $value) {
                          $item = $handler->selectById($value->getItemExpediciones());
                          $estado = $handler->selectEstado($value->getEstadosExpediciones());
                          if (count($item)==1) {
                            $item = $item[""];
                          }

                          echo "
                            <tr>
                              <td>".$value->getFecha()->format('d/m/Y')."</td>
                              <td>".$item->getNombre()."-".$item->getDescripcion()."</td>
                                <td>".$value->getCantidad()."</td>
                                <td>".$value->getDetalle()."</td>                        
                                <td>
                                  <span class='label label-".$estado->getColor()."' style='font-size:12px;'>"
                                    .$estado->getNombre().
                                  "</span>
                                </td>
                                <td>".$value->getObservaciones()."</td>                                                               
                                <td>
                                  <form action='".$url_action_eliminar."' method='post'>
                                    <input type='hidden' name='id' value='".$value->getId()."'>
                                    <button type='submit' class='btn btn-danger' >Quitar</button>
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
    </div>                
  
  </section>
</div>

<script type="text/javascript">        
  $(document).ready(function(){                
    $("#mnu_expediciones_solicitud").addClass("active");
  });  

   $(document).ready(function(){                
    $("#slt_tipo").change(function(){
    var id_tipo= $(this).val();
    $.post("<?php echo $url_ajax; ?>",{ id_tipo: id_tipo }, function(data){
              $("#slt_item").html(data);
            });

    });
  });
</script>