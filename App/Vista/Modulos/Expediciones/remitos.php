<head>
<script type="text/javascript">
<?php

if(isset($_GET['pop'])){
  $ultimaId = intval($_GET['pedID']);
  $plazaEnv =$_GET['plazaEnv'];
 
echo "window.open('".PATH_VISTA."Modulos/Expediciones/imprimir_enviado.php?pedID=".$ultimaId."&plazaEnv=".$plazaEnv."')";

}

?></script></head>


<?php
  include_once PATH_NEGOCIO."Expediciones/handlerexpediciones.class.php";     
  include_once PATH_NEGOCIO."Sistema/handlerconsultascontrol.class.php";    
  include_once PATH_NEGOCIO."Funciones/Fechas/fechas.class.php"; 
  include_once PATH_NEGOCIO."Funciones/Array/funcionesarray.class.php"; 
  include_once PATH_NEGOCIO."Usuarios/handlerusuarios.class.php";         

  
  $url_action_eliminar = PATH_VISTA.'Modulos/Expediciones/action_eliminar_pedido.php';
  $url_action_cancelar = PATH_VISTA.'Modulos/Expediciones/action_cancelar_pedido.php';
  

  $dFecha = new Fechas;


  $fdesde = (isset($_GET["fdesde"])?$_GET["fdesde"]:$dFecha->RestarDiasFechaActual(90));
  $fhasta = (isset($_GET["fhasta"])?$_GET["fhasta"]:$dFecha->FechaActual());   
//  $ftipo= (isset($_GET["ftipo"])?$_GET["ftipo"]:'');
  $festados= (isset($_GET["festados"])?$_GET["festados"]:'');
  $fusuario= (isset($_GET["fusuario"])?$_GET["fusuario"]:'');
  $fplaza= (isset($_GET["fplaza"])?$_GET["fplaza"]:'');
  $plazaEnv= (isset($_GET["plazaEnv"])?$_GET["plazaEnv"]:'');

  $handlersistema = new HandlerSistema; 
  $plazas=$handlersistema->selectAllPlazasArray();

  $handlerUsuarios = new HandlerUsuarios;
  $arrUsuarios = $handlerUsuarios->selectTodos();
  $user = $usuarioActivoSesion;


  $handler = new HandlerExpediciones;
  $arrTipo = $handler->selecionarTipo();
  $arrEstados = $handler->selecionarEstados();
 // $consulta = $handler->seleccionarByFiltros($fdesde,$fhasta,$ftipo,9,$fplaza);
  $sinpedir=$handler->seleccionarApedir();

  $consulta = $handler->seleccionarByEnviados($fdesde,$fhasta);


  $url_action_cambiar = PATH_VISTA.'Modulos/Expediciones/action_enviar_pedido.php?id=';
  $url_redireccion ='index.php?view=exp_control_coordinador&fdesde='.$fdesde.'&fhasta='.$fhasta.'&fplaza='.$fplaza.'&festados=9';
  $url_detalle ='index.php?view=exp_detalle_remito&id=';
  $url_action_eliminar_envio = PATH_VISTA.'Modulos/Expediciones/action_eliminaritem_envio.php?id=';
  $url_action_publicar=PATH_VISTA.'Modulos/Expediciones/action_enviado.php?fdesde='.$fdesde.'&fhasta='.$fhasta.'&fplaza='.$fplaza;

?>

<div class="content-wrapper">  
  <section class="content-header">
    <h1 class="text-center">
      Control de Remitos
      <small>Control de las Remitos </small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
      <li class="active">Control Remitos</li>
    </ol>
  </section>        
  
  <section class="content">

    <?php include_once PATH_VISTA."error.php"; ?>
    <?php include_once PATH_VISTA."info.php"; ?>


    <div class="row">
      <div class='col-md-5 col-md-offset-3'>
        <div class="box box-solid">
            <div class="box-header with-border">
              <i class="fa fa-filter"></i>
              <h3 class="box-title">Filtros Disponibles</h3>
              <button type="button" class="btn btn-box-tool pull-right bg-red" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
            <div class="box-body">
              <div class='row'>  
                <div class="col-md-6" id='sandbox-container'>
                    <label>Fecha Desde - Hasta </label>                
                    <div class="input-daterange input-group" id="datepicker">
                      <input type="text" class="input-sm form-control" onchange="crearHref()" id="start" name="start" value="<?php echo $dFecha->FormatearFechas($fdesde,'Y-m-d','d/m/Y'); ?>"/>
                      <span class="input-group-addon">a</span>
                      <input type="text" class="input-sm form-control" onchange="crearHref()" id="end" name="end" value="<?php echo $dFecha->FormatearFechas($fhasta,'Y-m-d','d/m/Y'); ?>"/>
                    </div>
                </div>
                <div class='col-md-5 col-md-offset-1'>                
                  <label></label>                
                  <a class="btn btn-block btn-success" id="filtro_reporte" onclick="crearHref()"><i class='fa fa-filter'></i> Filtrar</a>
                </div>
              </div>
            </div>
        </div>     
      </div>

      <div class='col-md-5 col-md-offset-3'>
        <div class="box">
          <div class="box-header">
            <h3 class="box-title"> Control de Expediciones - <?php echo "desde <b>".$dFecha->FormatearFechas($fdesde,'Y-m-d','d/m/Y')."</b> hasta <b>".$dFecha->FormatearFechas($fhasta,'Y-m-d','d/m/Y')."</b>"; ?></h3>   
          </div>

          <div class="box-body table-responsive">
              <table class="table table-striped" id='tabla'>
                <thead>
                  <tr>
                    <th width="150">NRO REMITO</th> 
                    <th width="">FECHA</th>                                                              
                    <th width="100">REC</th>                          
                    <th width="100">VER</th>                          
                  </tr>
                </thead>
                <tbody>
                    <?php

                      if(!empty($consulta))
                      {
                          if (count($consulta)==1) {
                            $consulta = $consulta[""];
                          }
                        foreach ($consulta as $key => $value) {
                          $url_detalle_pedido ='index.php?view=exp_detalle_remito&id='.$value->getId().'&fechasolic='.$value->getFecha()->Format('d/m/Y').'&plaza='.$value->getPlaza();

                          if ($value->getRecibido()==1) {
                            $recibido="<span class='label label-success'>SI</span>";
                          } else{
                            $recibido="<span class='label label-danger'>NO</span>";
                          }

                           $envios = "<a href='".$url_detalle_pedido."'  
                                        type='button' 
                                         class='fa fa-eye'></a>";

                          echo "
                            <tr>
                              <td>".$value->getId()."</td>  
                              <td>".$value->getFecha()->Format('d/m/Y')."</td>     
                               <td>".$recibido."</td>
                               <td>".$envios."</td>

                          </tr>";
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

    $(document).ready(function() {
    $("#cantidadenviada").on('change', function (e) { 
      validarCantidad();
    });
  });
    

    function validarCantidad(){


      var enviar =document.getElementById("cantidadenviada").value;
      var entregada =document.getElementById("entregada").value;
      var cantOriginal =document.getElementById("cantidadoriginal").value;
      var stock =document.getElementById("stock").value;

      pend= cantOriginal-entregada;

  

      if (enviar>pend || enviar<=0 ) {
        alert("cantidad erronea");
        document.getElementById("cantidadenviada").value = pend;
      }
     
      if (enviar>stock) {
        alert("No hay stock");
        document.getElementById("cantidadenviada").value = stock;
      }


      
    }

    function btnEliminar(id_registro){
      var id= id_registro;
      var elemento_id=document.getElementById(id).getAttribute('id');
      document.getElementById("id_eliminar").value = elemento_id;
    }
    function btnCancelar(id_registro){
      var id= id_registro;
      var elemento_id=document.getElementById(id).getAttribute('id');
      document.getElementById("id_cancelar").value = elemento_id;
       

    }
    function btnCambiar(id_registro)
    {
       var id= id_registro;    
       var elemento_id=document.getElementById(id).getAttribute('id');  
       var cantidad=document.getElementById(id).getAttribute('data-cantidad');  
       var resto=document.getElementById(id).getAttribute('data-resto');  
       var entregada=document.getElementById(id).getAttribute('data-entregada');  
       var stock=document.getElementById(id).getAttribute('data-stock');
       var iditem=document.getElementById(id).getAttribute('data-iditem');
       var ppedido=document.getElementById(id).getAttribute('data-ppedido');
       
       document.getElementById("cantidadenviada").value = resto;
       
       if(Number(resto) > Number(stock))
        document.getElementById("cantidadenviada").value = stock

       document.getElementById("msj-stock").innerHTML = ' Nivel de stock: '+stock+' unidades';

       
       document.getElementById("entregada").value = entregada;
       document.getElementById("cantidadoriginal").value =cantidad; 
       document.getElementById("ppedido").value =ppedido; 
       document.getElementById("id").value = elemento_id; 
       document.getElementById("stock").value = stock; 
       document.getElementById("iditem").value = iditem; 

       var mensaje_activar="<p>Esta a punto de cambiar el estado del registro.<br>¿Desea Continuar?</p>";
    }

  </script>

  <div class="modal modal-primary fade" id="modalCambiar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" >
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h4 class="modal-title" id="myModalLabel">Envio</h4>
        </div>

        <form name="formCambiar" id="form" method="post" action=<?php echo $url_action_cambiar; ?>>    
          <input type="hidden" name="url_redireccion" value='<?php echo $url_redireccion; ?>'>        
          <input type="hidden" value="<?php echo $user->getId(); ?>" name="usuario2">
          <div class="modal-body">
              <input type="hidden" name="id" id="id" value="">              
              <div class="row">
                <div class="col-md-4">
                    <label style="display:none;">YaEntregada</label>
                    <input type="hidden" name="entregada" id="entregada"> 
                    <label>Cantidad A Enviar</label>
                    <input type="number" class="form-control" name="cantidadenviada" id="cantidadenviada">
                    <label style="display:none;">original</label>
                    <input type="hidden" name="cantidadoriginal" id="cantidadoriginal">
                    <input type="hidden"  class="form-control" name="stock" id="stock">
                    <input type="hidden"  class="form-control" name="iditem" id="iditem">
                    <input type="hidden"  class="form-control" name="ppedido" id="ppedido">
                            
                </div>           
                <div class="col-md-8">  
                  <label>Observación </label>  
                  <input type="text" name="observaciones" class="form-control" placeholder="Ingrese una observación">
                </div>
                <p style="padding-left: 10px; " id="msj-stock"></p>
              </div>
          </div>

          <div class="modal-footer">
            <input  type="submit" name="submit" value="Enviar" class="btn btn-primary">
          </div>                                      
        </form>

      </div>
    </div>
  </div>

  <div class="modal modal-danger fade" id="modal-eliminar">
     <div class="modal-dialog ">
    <div class="modal-content ">

      
      <form  method="post" enctype="multipart/form-data" action=<?php echo $url_action_eliminar;?>>

        <div class="modal-header ">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span></button>
          <h3 class="modal-title" style="" >Eliminar Envio</h3>
        </div>
        <div class="modal-body ">
            <div class="row">
              <div class="col-md-10">  
                  <label>Observación </label>  
                  <input type="text" name="observaciones" class="form-control" placeholder="Ingrese una observación">
                </div>                                                      
                <input type="number" name="id_eliminar" id="id_eliminar" class="form-control"  required="" style="display:none;">
                <input type="hidden" name="url_redireccion" value='<?php echo $url_redireccion; ?>'> 
              
               
              </div>
        </div>
        <div class="modal-footer ">
          <input type="submit" name="submit" value="Eliminar" class="btn btn-danger">
        </div>
      </form>

    </div>
  </div>
</div>
<div class="modal modal-danger fade" id="modal-cancelar">
     <div class="modal-dialog ">
    <div class="modal-content ">

      
      <form  method="post" enctype="multipart/form-data" action=<?php echo $url_action_cancelar;?>>

        <div class="modal-header ">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span></button>
          <h3 class="modal-title" style="" >Cancelar Envio</h3>
        </div>
        <div class="modal-body ">
            <div class="row">
               
               <div class="col-md-10">  
                  <label>Observación </label>  
                  <input type="text" name="observaciones" class="form-control" placeholder="Ingrese una observación">
                </div>                                        
                <input type="number" name="id_cancelar" id="id_cancelar" class="form-control"  required="" style="display:none;">
                <input type="hidden" name="url_redireccion" value='<?php echo $url_redireccion; ?>'>      
              </div>

        </div>
        <div class="modal-footer ">
          <input type="submit" name="submit" value="Ok" class="btn btn-danger">
        </div>
      </form>

    </div>
  </div>
</div>
       
<script type="text/javascript"> 

  $(document).ready(function(){                
    $("#mnu_expediciones_control").addClass("active");
  });

  $(document).ready(function() {
      $('#tabla').DataTable({
        "dom": 'Bfrtip',
        "buttons": ['copy', 'csv', 'excel', 'print'],
        "iDisplayLength":10,
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

  $('#sandbox-container .input-daterange').datepicker({
      format: "dd/mm/yyyy",
      clearBtn: false,
      language: "es",
      keyboardNavigation: false,
      forceParse: false,
      autoclose: true,
      todayHighlight: true,                                                                        
      multidate: false,
      todayBtn: "linked",  
  });

  $(document).ready(function() {
    $("#slt_usuario").select2({
        placeholder: "Seleccionar un Usuario",                  
    });
  }); 
  
  $(document).ready(function() {
    $("#slt_estados").select2({
        placeholder: "Seleccionar un Estado",                  
    });
  }); 

  $(document).ready(function() {
    $("#slt_tipo").select2({
        placeholder: "Seleccionar un Tipo",                  
    });
  }); 

  crearHref();
  function crearHref()
  {
      aStart = $("#start").val().split('/');
      aEnd = $("#end").val().split('/');

      f_inicio = aStart[2] +"-"+ aStart[1] +"-"+ aStart[0];
      f_fin = aEnd[2] +"-"+ aEnd[1] +"-"+ aEnd[0];                                 

      f_plaza = $("#slt_plaza").val();     
      f_estados = $("#slt_estados").val();     
      f_tipo = $("#slt_tipo").val();     
      console.log(f_plaza);
      console.log(f_tipo);

      url_filtro_reporte="index.php?view=exp_control_coordinador&fdesde="+f_inicio+"&fhasta="+f_fin;  

      url_filtro_reporte= url_filtro_reporte + "&fplaza="+f_plaza;
      

      if(f_estados!=undefined)
        if(f_estados>0)
          url_filtro_reporte= url_filtro_reporte + "&festados="+f_estados;
      
      if(f_tipo!=undefined)
        if(f_tipo>0)
          url_filtro_reporte= url_filtro_reporte + "&ftipo="+f_tipo;    

      $("#filtro_reporte").attr("href", url_filtro_reporte);
  } 

</script>