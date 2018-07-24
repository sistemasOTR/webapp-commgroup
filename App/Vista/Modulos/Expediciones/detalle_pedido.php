<?php
  include_once PATH_NEGOCIO."Expediciones/handlerexpediciones.class.php";   

  include_once PATH_NEGOCIO."Usuarios/handlerusuarios.class.php";  

 $fechaped=(isset($_GET["fechaped"])?$_GET["fechaped"]:'no hay');
 $cantped=(isset($_GET["cantped"])?$_GET["cantped"]:'no hay');
 $vista= (isset($_GET["vista"])?$_GET["vista"]:'');
 $fdesde = (isset($_GET["fdesde"])?$_GET["fdesde"]:$dFecha->FechaActual());
 $fhasta = (isset($_GET["fhasta"])?$_GET["fhasta"]:$dFecha->FechaActual());  
 $ftipo= (isset($_GET["ftipo"])?$_GET["ftipo"]:'');
 $festados= (isset($_GET["festados"])?$_GET["festados"]:'');
 $handler = new HandlerExpediciones;
 $handlerUsuarios = new HandlerUsuarios;
 $idpedido= (isset($_GET["idpedido"])?$_GET["idpedido"]:0);
 $plaza= (isset($_GET["plaza"])?$_GET["plaza"]:'');
 $itemenvio= (isset($_GET["item"])?$_GET["item"]:0);
 $usuario= (isset($_GET["user"])?$_GET["user"]:'');
 
 $envios=$handler->selecionarEnvios($idpedido);
 
 $item = $handler->selectById(intval($itemenvio));
  if (count($item)==1) {
    $item = $item[""];
  }
 $usuario_sol = $handlerUsuarios->selectById($usuario);
 //$userr = $usuarioActivoSesion;

 $url_redireccion = 'index.php?view=exp_control&fdesde='.$fdesde.'&fhasta='.$fhasta.'&fplaza='.$plaza.'&festados='.$festados.'&ftipo='.$ftipo;
 $url_seguimiento = 'index.php?view=exp_seguimiento&fdesde='.$fdesde.'&fhasta='.$fhasta.'&fplaza='.$plaza.'&festados='.$festados.'&ftipo='.$ftipo;



?>
<div class="content-wrapper">  
  <section class="content-header">
    <h1 style="text-align: center;">
      Envios
      <small>Detalle de envios </small>
    </h1>
  </section>  
  <section class="content">

    <?php include_once PATH_VISTA."error.php"; ?>
    <?php include_once PATH_VISTA."info.php"; ?>


    <div class="row">

      <div class='col-md-8 col-md-offset-2'>
        <div class="box box-solid">
            <div class="box-header with-border">
              <i class="fa fa-plane"></i>
              <h3 class="box-title">Tabla Envios</h3>
            </div>


          <div class="box-body  table-responsive" >
              <table class="table table-striped table-condensed"  id="tabla" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th width="">FECHA PEDIDO</th>
                      <th width="">FECHA ENVIO</th> 
                      <th width="">PLAZA</th>
                      <th width="">USUARIO</th>
                      <th width="">PEDIDO</th>
                      <th width="">CANT PED</th>
                      <th width="">CANT ENV</th>
                      <th width="">ENVIA</th>
                      
                    </tr>
                  </thead>
                  <tbody>
                   
                    <?php


 					            $suma=0;

                   foreach ($envios as $key => $value){
                     
                     $userr= $handlerUsuarios->selectById($value->getUsuario());
                     $parcial=$value->getCantidadEnviada()-$value->getCantidadFaltante();
                       // var_dump($userr);
                        // exit();
                   	?>
                      
                      
                     <tr>
                     <td><?php echo $fechaped;?></td>
                     <td><?php echo $value->getFecha()->format('d-m-Y');?></td>
                     <td><?php echo $plaza ;?></td>
                     <td><?php echo $usuario_sol->getNombre()." ".$usuario_sol->getApellido();?></td>                   
                     <td><?php echo $item->getNombre();?></td>
                     <td><?php echo $cantped;?></td>
                     <td><?php echo $parcial; ?></td>                    
                     <td><?php echo $userr->getNombre()." ".$userr->getApellido();?></td>
                     
                      

                     </tr>
                    <?php  
                      
                      $suma+= $parcial;
                        }
                      
                    ?>
                    <tr class="bg-olive">
                      <td colspan="6"  style="text-align: right;"><strong>CANTIDAD TOTAL</strong></td>
                      <td colspan="2" ><strong><?php echo $suma ; ?></strong></td>

                    </tr>
                    

                  </tbody>
                </table>
                
              </div>
            </div>
             <div> <?php if ($vista=='control') { ?>  
              <a href="javascript:history.back(-1);" class="btn btn-primary" title="Ir la página anterior">Regresar</a>
            <?php } 
            elseif ($vista=='seguimiento') { ?>
             <a href="<?php echo $url_seguimiento;?>"class="btn btn-primary">Regresar</a>
            
             <?php
              }
             ?>
             </div>
          </div>

        </div>
           
       </section> 
     </div>