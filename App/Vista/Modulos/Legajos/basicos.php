<?php
  include_once PATH_NEGOCIO."Modulos/handlerlicencias.class.php";       
  include_once PATH_NEGOCIO."Funciones/Fechas/fechas.class.php"; 
  include_once PATH_NEGOCIO."Funciones/Array/funcionesarray.class.php"; 
  include_once PATH_NEGOCIO."Usuarios/handlerusuarios.class.php"; 
  include_once PATH_NEGOCIO.'Modulos/handlerlegajos.class.php';
  include_once PATH_DATOS.'Entidades/legajos_basicos.class.php';  
  include_once PATH_DATOS.'Entidades/legajos_categorias.class.php';  

  $url_action_guardar_basicos=PATH_VISTA.'Modulos/Legajos/action_guardar_basico.php';
  $url_action_eliminar_basicos=PATH_VISTA.'Modulos/Legajos/action_eliminar_basico.php';
  // $url_action_editar_categorias = PATH_VISTA.'Modulos/Legajos/action_editar_categoria.php';  
  // $url_action_eliminar_categorias = PATH_VISTA.'Modulos/Legajos/action_eliminar_categoria.php?id=';


  $user = $usuarioActivoSesion;
  $handlertipocategoria= new LegajosCategorias;
  $handler = new HandlerLegajos; 
  $arrBasicos = $handler->seleccionarLegajosBasicos();

  $arrTipoCategorias = $handler->selecionarTiposCategorias();
  // $handlerusuario=new handlerusuarios;
  // $arrEmpleados=$handlerusuario->selectEmpleados();
  $fechas= new Fechas;


?>

<div class="content-wrapper">  
  <section class="content-header">
    <h1 style="text-align: center;">
      Basicos
      <small>Basicos control</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
      <li class="active">Basicos</li>
    </ol>
  </section>        
  
  <section class="content">

    <?php include_once PATH_VISTA."error.php"; ?>
    <?php include_once PATH_VISTA."info.php"; ?>


    <div class="row">
      <div class='col-md-6 col-md-offset-3' >
        <div class="box box-solid">
            <div class="box-header with-border">    
              <i class="fa fa-dollar"></i>       
              <h3 class="box-title">Basicos</h3>   
                <a href="#" class="btn btn-success pull-right" id="btn-nuevo"  data-fechaDesde='<?php echo $fechas->FechaActual() ?>'data-accion='nuevo' data-toggle='modal' data-target='#modal-nuevo' onclick="cargarNuevo()">
                  Nuevo
              </a>
            </div>
            <div class="box-body">
              <table class="table table-striped table-condensed" id="tabla" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th>CATEGORIA</th>
                      <th>BASICO</th>
                      <th>HORAS NORMALES</th>
                      <th>DESDE</th>
                      <th>HASTA</th>
                      <th colspan="2" style="text-align: center;">ACCIÓN</th>
                      <th style="width: 3%;" class='text-center'></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                    
                      
                      if(!empty($arrBasicos))
                      {
                        foreach ($arrBasicos as $key => $value) {
                          // var_dump($user->getUsuarioPerfil()->getNombre());
                          $categoria = $handlertipocategoria->selectById($value->getIdCategoria());
                          if (count($categoria)==1) {
                            $categoria = $categoria[""];
                          }
                          if ($value->getFechaHasta()->format('d/m/Y') == '01/01/1900') {
                            $fechaHasta='';
                          } else {
                            $fechaHasta=$value->getFechaHasta()->format('d/m/Y');
                          }

                          // var_dump($categoria);
                          // exit();
                          echo "<tr>";
                            echo "<td>".$categoria["categoria"]."</td>";
                            echo "<td>".$value->getBasico()."</td>";
                            echo "<td>".$value->getHorasNormales()."</td>";
                            echo "<td>".$value->getFechaDesde()->format('d/m/Y')."</td>";
                            echo "<td>".$fechaHasta."</td>";
                            echo "<td><a href='#'class='btn btn-warning btn-xs'  data-id='".$value->getId()."' data-accion='editar' onclick='cargarDatos(".$value->getId().")' data-toggle='modal' data-target='#modal-nuevo' data-tipo='".$value->getIdCategoria()."' data-basico='".$value->getBasico()."' data-hnormales='".$value->getHorasNormales()."' data-fechaDesde='".$value->getFechaDesde()->format('Y-m-d')."' data-fechaHasta='".$fechas->FechaActual()."' id='".$value->getId()."' >Editar</a></td>";
                            echo "<td><a href='#'class='btn btn-danger btn-xs'id='".$value->getId()."' data-id='".$value->getId()."' onclick='eliminarDatos(".$value->getId().")' data-toggle='modal' data-target='#modal-eliminar' >Eliminar</a></td>";
                         
                          echo "</tr>";
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

      <form action="<?php echo $url_action_guardar_basicos; ?>" method="post"  enctype="multipart/form-data">
        <input type="hidden" name="id" id="id" value="">
        <input type="hidden" name="accion" id="accion" value="">
        <input type="hidden" name="userSistema" value="<?php echo $user->getUsuarioPerfil()->getNombre(); ?>">

        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span></button>
          <h4 class="modal-title">Nuevo</h4>
        </div>
        <div class="modal-body">
            <div class="row"> 
        
              <div class="col-md-12">
                <label>Tipo Categoria</label>
                <select name="tipo_categoria" id="tipo_categoria" class='form-control' required="">
                  <option value="0" >Seleccione una Categoria ...</option>
                  <?php                  
                    if(!empty($arrTipoCategorias)){                    
                        foreach ($arrTipoCategorias as $key => $value) {
                          echo "<option value=".$value->getId().">".$value->getCategoria()."</option>";
                        }                  
                    }                  
                  ?>
                </select>
              </div>   
              <div class="col-md-6">
                <label>Basico</label>
                <input type="number" name="basico" id="basico" class="form-control" required="">
              </div> 
              <div class="col-md-6">
                <label>Horas Normales</label>
                <input type="number" name="horas_normales" id="horas_normales" class="form-control" required="">
              </div>           
              <div class="col-md-6">
                <label>Fecha Desde</label>
                <input type="date" name="fecha_desde" id="fecha_desde" class="form-control" value="" required="">
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

      <form action="<?php echo $url_action_eliminar_basicos ;?>" method="post" enctype="multipart/form-data">
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
    $("#mnu_legajos_basicos").addClass("active");
  });

  function cargarDatos(id){

    ide=document.getElementById(id).getAttribute('data-id');
    console.log(id);
    estado = document.getElementById(id).getAttribute('data-accion');
    tipo = document.getElementById(id).getAttribute('data-tipo');
    basico = document.getElementById(id).getAttribute('data-basico');
    horasNormales = document.getElementById(id).getAttribute('data-hnormales');
    fechaDesde = document.getElementById(id).getAttribute('data-fechaDesde');
    fechaHasta = document.getElementById(id).getAttribute('data-fechaHasta');

    document.getElementById("id").value = ide;
    document.getElementById("accion").value = estado; 
    document.getElementById("tipo_categoria").value = tipo;
    document.getElementById("categoria_anterior").value = tipo;
    document.getElementById("basico").value = basico;
    document.getElementById("basico_anterior").value = basico;
    document.getElementById("horas_normales").value = horasNormales;
    document.getElementById("horas_anteriores").value = horasNormales;
    document.getElementById("fecha_desde").value = fechaDesde;
    document.getElementById("fecha_hasta").value = fechaHasta;
  }

  function cargarNuevo(){
    
    estado = document.getElementById('btn-nuevo').getAttribute('data-accion');
    fechaDesde = document.getElementById('btn-nuevo').getAttribute('data-fechaDesde');
   
     document.getElementById("accion").value = estado;
     document.getElementById("tipo_categoria").value = 0;
     document.getElementById("basico").value = '';
     document.getElementById("horas_normales").value = '';
     document.getElementById("fecha_desde").value = fechaDesde;
    
    
  }
  function eliminarDatos(id){

    id_eliminar = document.getElementById(id).getAttribute('data-id');
    document.getElementById("id_eliminar").value = id_eliminar;
  
  }

  
</script>