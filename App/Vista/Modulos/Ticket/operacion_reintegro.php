<?php 
  include_once PATH_NEGOCIO."Modulos/handlertickets.class.php";       
  include_once PATH_NEGOCIO."Funciones/Fechas/fechas.class.php"; 

//  include_once PATH_NEGOCIO."Funciones/Array/funcionesarray.class.php"; 
//  include_once PATH_NEGOCIO."Usuarios/handlerusuarios.class.php";
  include_once PATH_NEGOCIO."Sistema/handlersistema.class.php";  
  include_once PATH_NEGOCIO."Usuarios/handlerplazausuarios.class.php";

  $fplaza= (isset($_GET["fplaza"])?$_GET["fplaza"]:'');

  $f = new Fechas;
  $handler = new HandlerSistema;
  $handlerTickets= new HandlerTickets();
  $reintegra= $handlerTickets->selecionarReintegros($fplaza);
  $arrCoordinador = $handler->selectAllPlazasArray();

  $handlerPlaza = new HandlerPlazaUsuarios;
  $arrPlaza = $handlerPlaza->selectTodas();

  $url_action_editar = PATH_VISTA.'Modulos/Ticket/action_editreintegro.php?id=';
  $url_action_eliminar = PATH_VISTA.'Modulos/Ticket/action_deletereintegro.php?id=';

  $url_retorno = "index.php?view=tickets_reintegros&fplaza=".$fplaza;

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
            <h3 class="box-title col-md-3"><i class="fa fa-dollar"></i>
            Tabla Reintegros</h3>
            <div class="col-md-3">
                <label>Plazas</label>
                <select id="slt_plaza" class="form-control" style="width: 100%" name="slt_plaza" required="">                    
                  <option value=''></option>
                  <option value='0'>TODOS</option>
                  <?php
                    if(!empty($arrPlaza))
                    {                        
                      foreach ($arrPlaza as $key => $value) {
                        if($fplaza == $value->getNombre()){
                          echo "<option value='".$value->getNombre()."' selected>".$value->getNombre()."</option>";
                        } else {
                          echo "<option value='".$value->getNombre()."'>".$value->getNombre()."</option>";
                        }
                        
                      }
                    }                      
                  ?>                      
                </select>     
              </div>
              <div class='col-md-3' style="display: none;">                
                  <label></label>                
                  <a class="btn btn-block btn-success" id="filtro_reporte" onclick="crearHref()"><i class='fa fa-filter'></i> Filtrar</a>
                </div>
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
                      <th>PLAZA</th>
                      <th style="text-align: center;">ALEDAÑO</th>
                      <th width="100" class="text-center">REINTEGRO</th> 
                      <th width="100" class="text-center">MÍN OPS</th> 
                      <th style="text-align: center;">ACCIONES</th>

                    </tr>
                  </thead>
                  <tbody>
                   
                    <?php 
                    foreach ($reintegra as $key => $value){ ?>
                      <?php if ($value->getAled()) {
                        $aled= 1;
                        $txtAled = '<span class= "label label-success">SI</span>';
                      } else {
                        $aled= 0;
                        $txtAled = '<span class= "label label-danger">NO</span>';
                      }
                       ?>
                       <tr>
                        
                         <td> <?php echo $value->getCp();?> </td>
                         <td> <?php echo $value->getDescripcion();?> </td>
                         <td> <?php echo $value->getPlaza();?> </td>
                         <td style="text-align: center;"> <?php echo $txtAled;?> </td>
                         <td class="text-center">$ <?php echo number_format($value->getReintegro(),2);?> </td>
                         <td class="text-center"><?php echo number_format($value->getCantOp(),0);?></td>
                         <td width="100" style="text-align: center;"> <a href="#" id='<?php echo $value->getId() ?>' data-id='<?php echo $value->getId() ?>' data-cp='<?php echo $value->getCp() ?>' data-cantop='<?php echo $value->getCantOp() ?>' data-fechaValida='<?php echo $value->getFechaIni()->format('Y-m-d') ?>' data-estado='editar'data-descripcion='<?php echo $value->getDescripcion() ?>' data-reintegro='<?php echo $value->getReintegro() ?>' data-aled='<?php echo $aled ?>'data-plaza='<?php echo $value->getPlaza() ?>' class="btn btn-warning" data-toggle='modal' data-target='#modal-nuevo' onclick='cargarDatos(<?php echo $value->getId() ?>)'><i class="fa fa-edit"></i></a> <a href="#" class='btn btn-danger' id='<?php echo $value->getId() ?>_elim' onclick='eliminarDatos(<?php echo $value->getId() ?>)' data-id='<?php echo $value->getId() ?>' data-fechafin='<?php echo $f->FechaActual()?>' data-toggle='modal' data-target='#modal-eliminar'><i class="fa fa-trash"></i></a></td>

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
        <input type="hidden" name="url_retorno" value="<?php echo $url_retorno; ?>">

        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span></button>
          <h4 class="modal-title">Nuevo</h4>
        </div>
        <div class="modal-body">
            <div class="row">
              <div class="col-md-6">
                <label>Fecha Vigencia</label>
                <input type="date" id="fechaini" name="fechaini" class="form-control" required="">
                <input type="date" id="fechaValida" name="fechaValida" class="form-control" style="display: none;">
              </div>                                             
              <div class="col-md-6">
                <label>Codigo Postal</label>
                <input type="number" name="codigopostal" id="codigopostal" class="form-control"  required="">
              </div>
              
              <div class="col-md-6">
                <label>Localidad</label>
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
              <div class="col-md-6">
                <label>Aledaño</label>
                <select id="aled" class="form-control" style="width: 100%" name="aled" required="" >                              
                  <option value="0">NO</option>
                  <option value="1">SI</option>
                </select>
                
              </div>
              <div class="col-md-6 col-md-offset-3">
                <label>Mínimas Operaciones</label>
                <input type="number" name="cant_op" id="cant_op"  class="form-control" step="0.01"  required="">
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
        <input type="hidden" name="url_retorno" value="<?php echo $url_retorno; ?>">

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
  $(document).ready(function(){                
    $("#mnu_tickets_reintegro").addClass("active");
  });
  $(document).ready(function(){                
    $("#mnu_tickets").addClass("active");
  });

    $(document).ready(function() {
    $("#fechaini").on('change', function (e) { 
      controlFecha();
    });
  });

  $(document).ready(function() {
    $("#slt_plaza").select2({
        placeholder: "Seleccionar",                  
    }).on('change', function (e) { 
      filtrarReportePlaza();
    });
  });


  function controlFecha(){
    fechadev = document.getElementById("fechaini").value;
    fechaent = document.getElementById("fechaValida").value;
    if(fechadev<fechaent){
      alert("Nueva fecha de vigencia previa a la fecha de vigencia anterior.");
      document.getElementById("fechaini").value = fechaent;
    } 

  }
  
  function cargarDatos(id){
    
    cp = document.getElementById(id).getAttribute('data-cp');
    descripcion = document.getElementById(id).getAttribute('data-descripcion');
    reintegro = document.getElementById(id).getAttribute('data-reintegro');
    plaza = document.getElementById(id).getAttribute('data-plaza');
    estado = document.getElementById(id).getAttribute('data-estado');
    reintegro_id = document.getElementById(id).getAttribute('data-id');
    aled = document.getElementById(id).getAttribute('data-aled');
    cant_op = document.getElementById(id).getAttribute('data-cantop');
    fechaini = document.getElementById(id).getAttribute('data-fechaValida');
   
    document.getElementById("aled").value = aled;
    document.getElementById("estado").value = estado;
    document.getElementById("codigopostal").value = cp;
    document.getElementById("descripcion").value = descripcion;
    document.getElementById("reintegro").value = reintegro;
    document.getElementById("plaza").value = plaza;
    document.getElementById("reintegro_id").value = reintegro_id;
    document.getElementById("cant_op").value = cant_op;
    document.getElementById("fechaValida").value = fechaini;
    
  }
  function cargarNuevo(){
    
    estado = document.getElementById('btn-nuevo').getAttribute('data-estado');
   
    document.getElementById("estado").value = estado;
     document.getElementById("codigopostal").value = '';
    document.getElementById("descripcion").value = '';
    document.getElementById("reintegro").value = '';
    document.getElementById("plaza").value = '';
    document.getElementById("aled").value = 0;
    document.getElementById("cant_op").value = 0;
    document.getElementById("fechaValida").value = '';
    
    
  }
  function eliminarDatos(id){

    id_eliminar = document.getElementById(id+'_elim').getAttribute('data-id');
    fechafin=document.getElementById(id+'_elim').getAttribute('data-fechafin');

    document.getElementById("id_eliminar").value = id_eliminar;
    document.getElementById("fechafin").value = fechafin;
  }

  function crearHrefPlaza()
  {
      f_plaza = $("#slt_plaza").val();

      url_filtro_reporte="index.php?view=tickets_reintegros";


    if(f_plaza!=undefined)
      if(f_plaza!='' && f_plaza!=0)
        url_filtro_reporte= url_filtro_reporte +"&fplaza="+f_plaza;      
      
      $("#filtro_reporte").attr("href", url_filtro_reporte);
  } 

  function filtrarReportePlaza()
  {
    crearHrefPlaza();
    window.location = $("#filtro_reporte").attr("href");
  }
 
  
</script>




