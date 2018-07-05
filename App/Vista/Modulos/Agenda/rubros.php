<?php
  include_once PATH_NEGOCIO."Modulos/handleragenda.class.php";       
  include_once PATH_NEGOCIO."Funciones/Fechas/fechas.class.php"; 
  include_once PATH_NEGOCIO."Funciones/Array/funcionesarray.class.php"; 
  include_once PATH_NEGOCIO."Usuarios/handlerusuarios.class.php";     

  $fusuario= $usuarioActivoSesion->getId();
  $handlerAg = new HandlerAgenda;
  $arrRubros = $handlerAg->selectAllRubros();

  $url_action_guardar = PATH_VISTA.'Modulos/Agenda/action_guardar_rubro.php';
  $url_action_accion = PATH_VISTA.'Modulos/Agenda/action_accion.php';
  $url_action_eliminar = PATH_VISTA.'Modulos/Agenda/action_eliminar.php?id=';

?>
<!-- <style>

  td::before {
    content: attr(data-th);
    font-weight: bold;
    color: #a1a1a1;
    display: inline;
    font-size: 12px;
    text-transform: uppercase;
  }
  tr::before {
    content: attr(data-th);
    font-weight: bold;
    color: #fff;
    display: block;
    font-size: 14px;
    text-transform: uppercase;
    background: #555;
    width: 100% !important;
    padding-left: 5px
  }
  @media (min-width:768px){
    td::before{display: none;}
    tr::before{display: none;}
  }
  @media only screen and (max-width: 767px){
    td {display: block !important;width: auto;}
  }
</style> -->
<div class="content-wrapper">  
  <section class="content-header">
    <h1>
      Agenda
      <small>Listado de Rubros</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
      <li class="active">Agenda</li>
    </ol>
  </section>        
  
  <section class="content">

    <?php include_once PATH_VISTA."error.php"; ?>
    <?php include_once PATH_VISTA."info.php"; ?>


    <div class="row">
      <div class='col-md-6 col-md-offset-3'>
        <div class="box box-solid">
            <div class="box-header with-border">  
              <i class="fa fa-book"></i>  
              <h3 class="box-title">Listado de Rubros</h3>
              <a href="#" class="btn btn-success pull-right" data-toggle='modal' data-target='#modal-nuevo'>
                  Nuevo
              </a>
            </div>
            <div class="box-body table-responsive">
              <table class="table table-striped table-condensed" id="tabla-entregas" cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <th >RUBRO</th>
                    <th >ESTADO</th>
                    <th style='text-align:center; ' colspan="2">ACCIONES</th>
                  </tr>
                </thead>

                <tbody>
                <?php    
                  if(!empty($arrRubros)){
                    foreach ($arrRubros as $key => $value) {
                      if ($value->getEstado()) {
                        $estado = '<span class="text-green" style="font-size:14px; font-weight:900;">Activo</span>';
                        $publicar = '<a href="#" id="'.$value->getId().'_baja" onclick="bajaRubro('.$value->getId().')" data-id="'.$value->getId().'" data-nombre="'.$value->getNombre().'" data-toggle="modal" data-target="#modal-eliminar"><i class="fa fa-close text-red"></i></a>';
                      } else {
                        $estado = '<span class="text-red" style="font-size:14px; font-weight:900;">De baja</span>';
                        $publicar = '<a href="#" id="'.$value->getId().'_activa" onclick="activarRubro('.$value->getId().')" data-id="'.$value->getId().'" data-nombre="'.$value->getNombre().'" data-toggle="modal" data-target="#modal-eliminar"><i class="fa fa-check text-green"></i></a>';
                      }
                      $editar = '<a href="#" id="'.$value->getId().'_editar" onclick="editRubro('.$value->getId().')" data-id="'.$value->getId().'" data-nombre="'.$value->getNombre().'" data-toggle="modal" data-target="#modal-nuevo"><i class="fa fa-edit text-blue"></i></a>';
                      echo "<tr>";
                      echo "<td>".$value->getNombre()."</td>";
                      echo "<td>".$estado."</td>";
                      echo "<td style='text-align:center; font-size:14px;' width='40'>".$editar."</td>";
                      echo "<td style='text-align:center; font-size:14px;' width='40'>".$publicar."</td>";
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
  </section>
</div>

<div class="modal fade in" id="modal-nuevo">
  <div class="modal-dialog">
    <div class="modal-content">

      <form action="<?php echo $url_action_guardar; ?>" method="post" enctype="multipart/form-data">
        <input type="hidden" name="usuario" value="<?php echo $fusuario; ?>">

        <div class="modal-header bg-teal">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="limpiar()">
            <span aria-hidden="true">×</span></button>
          <h4 class="modal-title">Nuevo Rubro</h4>
        </div>
        <div class="modal-body">
            <div class="row">
              <div class="col-md-12">
                <label>RUBRO</label>
                <input type="text" name="nombre" id="nombre"  class="form-control">
                <input style="display: none;" type="number" name="idRubro" id="idRubro" class="form-control">
                <input style="display: none;" type="text" name="accion" id="accion" class="form-control" value="nuevo">
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
<div class="modal fade in " id="modal-eliminar">
  <div class="modal-dialog">
    <div class="modal-content">

      <form action="<?php echo $url_action_guardar; ?>" method="post" enctype="multipart/form-data">
        <input type="hidden" name="usuario" value="<?php echo $fusuario; ?>">

        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="limpiar()">
            <span aria-hidden="true">×</span></button>
          <h4 class="modal-title">Dar de Baja Rubro</h4>
        </div>
        <div class="modal-body">
            <div class="row">
              <div class="col-md-12">
                <p id="txtMensaje"></p>
                <input style="display: none;" type="number" name="idRubro" id="idRubroBaja" class="form-control">
                <input style="display: none;" type="text" name="accion" id="accionBaja" class="form-control" value="nuevo">
              </div>
               
            </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn" id="btnEliminar">Guardar</button>
        </div>
      </form>

    </div>
  </div>
</div>
<script type="text/javascript">
  $(document).ready(function(){                
    $("#mnu_agenda").addClass("active");
  });
  $(document).ready(function(){                
    $("#mnu_agenda_rubros").addClass("active");
  });

  function editRubro(id) {
    idRubro = document.getElementById(id+'_editar').getAttribute('data-id');
    nombre = document.getElementById(id+'_editar').getAttribute('data-nombre');
    
    document.getElementById("accion").value = 'editar';
    document.getElementById("nombre").value = nombre;
    document.getElementById("idRubro").value = idRubro;
  }

  function bajaRubro(id) {
    idRubro = document.getElementById(id+'_baja').getAttribute('data-id');
    
    document.getElementById("accionBaja").value = 'baja';
    document.getElementById("idRubroBaja").value = idRubro;
    document.getElementById("modal-eliminar").classList.add("modal-danger");
    document.getElementById("txtMensaje").innerHTML = '¿Está seguro de darlo de baja?';
    document.getElementById("btnEliminar").classList.add("btn-danger");
    document.getElementById("btnEliminar").innerHTML = 'Eliminar';
  }

  function activarRubro(id) {
    idRubro = document.getElementById(id+'_activa').getAttribute('data-id');
    
    document.getElementById("accionBaja").value = 'alta';
    document.getElementById("idRubroBaja").value = idRubro;
    document.getElementById("modal-eliminar").classList.add("modal-success");
    document.getElementById("txtMensaje").innerHTML = '¿Está seguro de activarlo nuevamente?';
    document.getElementById("btnEliminar").classList.add("btn-success");
    document.getElementById("btnEliminar").innerHTML = 'Activar';
  }

  function limpiar() {
  	document.getElementById("accion").value = 'nuevo';
    document.getElementById("nombre").value = '';
    document.getElementById("idRubro").value = '';
  }

</script>
<script type="text/javascript"> 
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
</script>
<script type="text/javascript">
  crearHref();
  function crearHref()
  {
      aStart = $("#start").val().split('/');
      aEnd = $("#end").val().split('/');

      f_inicio = aStart[2] +"-"+ aStart[1] +"-"+ aStart[0];
      f_fin = aEnd[2] +"-"+ aEnd[1] +"-"+ aEnd[0];                                 

      //f_usuario = $("#slt_usuario").val();     
      
      url_filtro_reporte="index.php?view=tickets_carga&fdesde="+f_inicio+"&fhasta="+f_fin  

      /*if(f_usuario!=undefined)
        if(f_usuario>0)
          url_filtro_reporte= url_filtro_reporte + "&fusuario="+f_usuario;
      */
      
      $("#filtro_reporte").attr("href", url_filtro_reporte);
  } 
</script>