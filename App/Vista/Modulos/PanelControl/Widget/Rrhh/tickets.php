<?php
  include_once PATH_NEGOCIO."Modulos/handlertickets.class.php";       
  include_once PATH_NEGOCIO."Funciones/Fechas/fechas.class.php"; 
  include_once PATH_NEGOCIO."Funciones/Array/funcionesarray.class.php"; 
  include_once PATH_NEGOCIO."Usuarios/handlerusuarios.class.php";         
  include_once PATH_NEGOCIO."Sistema/handlersistema.class.php";        

  $dFecha = new Fechas;

  $fdesde = (isset($_GET["fdesde"])?$_GET["fdesde"]:$dFecha->RestarDiasFechaActual(365));
  $fhasta = (isset($_GET["fhasta"])?$_GET["fhasta"]:$dFecha->FechaActual());    
  $fusuario= (isset($_GET["fusuario"])?$_GET["fusuario"]:'');
  $fplaza= (isset($_GET["fplaza"])?$_GET["fplaza"]:'');
  $user = $usuarioActivoSesion;
  $handlerSist = new HandlerSistema;
  $arrGestor = $handlerSist->selectAllGestor($user->getAliasUserSistema());

  $handler = new HandlerTickets;  
  $consulta = $handler->seleccionarByFiltrosAprobacion($fdesde,$fhasta,null,null);

  $handlerUsuarios = new HandlerUsuarios;
  $arrUsuarios = $handlerUsuarios->selectTodos();

  $url_action_enviar = PATH_VISTA.'Modulos/Ticket/action_enviar.php?id=';  
  $url_action_noenviar = PATH_VISTA.'Modulos/Ticket/action_noenviar.php?id=';  
  $url_detalle = 'index.php?view=tickets_detalle&fticket=';  

  $url_retorno = 'view=tickets_control&fdesde='.$fdesde.'&fhasta='.$fhasta.'&fusuario='.$fusuario;
?>

  <div class="col-md-12 nopadding">
	<div class="box box-solid">
	  <div class="box-header with-border">
	    <i class=" fa fa-check"></i>
	    <h3 class="box-title">Tabla Tickets 
	    	<span class='text-green'><b>Aprobar</b></span>
	    	
	    </h3>
	  </div>
	  <div class="box-body table-responsive">
	  	<table class="table table-striped table-condensed" id="tabla-tickets" cellspacing="0" width="100%">

        <thead>
                    <tr>
                      <th style='text-align: center;'>FECHA HORA</th>
                      <th style='text-align: center;'>USUARIO</th>   
                      <th style='text-align: center;'>CONCEPTO</th>
                      <th style='text-align: center;'>IMPORTE</th>                      
                      <th style='text-align: center;'>REINT</th>                      
                      <th style='text-align: center;'>ALED</th>          
                      <th style='text-align: center;'>LOCALIDAD</th>          
                      <th style='text-align: center;'>OPER</th>
                      <th style='text-align: center;'>ESTADO</th>
                      <th style='text-align: center;'>VER</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                      if(!empty($consulta))
                      {
                        foreach ($consulta as $key => $value) {

                          if (!$value->getAprobado()) {
                           $class_estilos_aprobado = "<span class='label label-warning'>PENDIENTE</span>";
                          } else {
                            $class_estilos_aprobado = "<span class='label label-success'> APROBADO</span>";

                          }
                          

                          if($value->getAledanio())
                            $class_estilos_aledanio = "<span class='label label-success'>SI</span>";
                          else
                            $class_estilos_aledanio = "<span class='label label-danger'>NO</span>";

                          $fechaT = $value->getFechaHora()->format('Y-m-d');
                          $usuarioSist = $value->getUsuarioId()->getUserSistema();
                          if($fplaza != '' || $fplaza != 0){
                            foreach ($arrGestor as $gestor) {
                                if($usuarioSist == $gestor->GESTOR11_CODIGO) {
                                    $seguir = true;
                                    break;
                                } else {
                                  $seguir = false;
                                }
                              }
                            } else {
                              $seguir = true;
                            }

                            
                            if ($seguir && !$value->getAprobado()) {
                              $countServ = new HandlerSistema;
                              $cantServ = $countServ->selectCountServicios($fechaT, $fechaT, 100, null, $usuarioSist, null, null, null);  
                              $url_tickets="index.php?view=tickets_aprobar&fdesde=".$dFecha->RestarDiasFechaActual(365)."&fhasta=".$dFecha->FechaActual()."&fusuario=";
                             
                          
                             
                          

                              echo "<tr>"; 
                                echo "<td>".$value->getFechaHora()->format('d/m/Y h:s')."</td>";                          
                                echo "<td>".$value->getUsuarioId()->getApellido()." ".$value->getUsuarioId()->getNombre()."</td>";
                                echo "<td>".$value->getConcepto()."</td>";
                                echo "<td>$ ".$value->getImporte()."</td>";    
                                echo "<td>$ ".number_format($value->getImporteReintegro(),2)."</td>";
                                echo "<td>".$class_estilos_aledanio."</td>";
                                echo "<td>".$value->getAledNombre()."</td>";
                                echo "<td>".$cantServ[0]->CANTIDAD_SERVICIOS."</td>";                                                    
                                echo "<td>".$class_estilos_aprobado."</td>"; ?>
                                <td><a href='<?php echo "index.php?view=tickets_aprobar&fdesde=".$dFecha->RestarDiasFechaActual(365)."&fhasta=".$dFecha->FechaActual()."&fusuario=".$value->getUsuarioId()->getId()."&festados=2" ?>' class="fa fa-eye" id="btn-nuevo"></a></td>


                                
                                <?php

                              echo "</tr>";
                              }

                          
                        }

                      }            
                    ?>
                  </tbody>
                  
              </table>	  
	  </div>
	</div>
</div>
<script>
  
    
    $(document).ready(function() {
        $('#tabla-tickets').DataTable({
          "dom": 'Bfrtip',
          "buttons": ['copy', 'csv', 'excel', 'print'],
          "iDisplayLength":20,
          "order": [[ 1, "asc" ]],
          "language": {
              "sProcessing":    "Procesando...",
              "sLengthMenu":    "Mostrar _MENU_ registros",
              "sZeroRecords":   "No se encontraron resultados",
              "sEmptyTable":    "Ningún dato disponible en esta tabla",
              "sInfo":          "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
              "sInfoEmpty":     "Mostrando registros del 0 al 0 de un total de 0 registros",
              "sInfoFiltered":  "(filtrado de un total de _MAX_ registros)",
              "sInfoPostFix":   "",
              "sSearch":        "Buscar:",
              "sUrl":           "",
              "sInfoThousands":  ",",
              "sLoadingRecords": "Cargando...",
              "oPaginate": {
                  "sFirst":    "Primero",
                  "sLast":    "Último",
                  "sNext":    "Siguiente",
                  "sPrevious": "Anterior"
              },
              "oAria": {
                  "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                  "sSortDescending": ": Activar para ordenar la columna de manera descendente"
              }
          }
        });
    });
</script>




