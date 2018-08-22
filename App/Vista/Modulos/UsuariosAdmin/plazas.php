      <?php        
        include_once PATH_NEGOCIO."Usuarios/handlerusuarios.class.php";        
        include_once PATH_NEGOCIO."Usuarios/handlerplazausuarios.class.php";        
        include_once PATH_NEGOCIO."Funciones/String/string.class.php";

        $url_action_plaza = PATH_VISTA.'Modulos/UsuariosAdmin/action_plaza.php';
        $url_action_plaza_baja = PATH_VISTA.'Modulos/UsuariosAdmin/action_plaza_baja.php';

        $handler = new HandlerUsuarios;
        $handlerPlaza = new HandlerPlazaUsuarios;
        $arrPlazas = $handlerPlaza->selectAll();
        $arrUsuarios = $handler->selectTodos();


      ?>
      
      <div class="content-wrapper">      
        <section class="content-header">
          <h1>
            Plazas
            <small>Gestión de Plazas</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li>Usuarios</li>
            <li class="active">Plazas</li>
          </ol>
        </section>        

        <section class="content">

          <?php include_once PATH_VISTA."error.php"; ?>
          <?php include_once PATH_VISTA."info.php"; ?>

          <div class="row">
            <div class="col-xs-12 col-sm-10 col-sm-offset-1">
              
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Plazas</h3>

                  <a href='#' data-toggle='modal' data-target='#modal-nueva' onclick="nuevaPlaza()"><button class="btn btn-success pull-right">Nueva plaza</button></a>
                </div>                
              </div>

              <div class="box">                
                <div class="box-body table-responsive">
                  <table class="table table-striped table-condensed" id="tabla" cellspacing="0" width="100%">
                    <thead>        
                      <tr> 
                        <th style="width: 5%;">ID</th>
                        <th style="width: 25%;">NOMBRE</th>
                        <th style="width: 25%;">TIPO</th>
                        <th style="width: 15%;">ESTADO</th>
                        <th style="width: 10%;">ALTA</th>
                        <th style="width: 10%;">BAJA</th>
                        <th style="width: 10%; text-align: center;">ACCIONES</th>                        
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                        if(!empty($arrPlazas))
                        {
                          foreach ($arrPlazas as $key => $value) {
                            switch ($value->getTipo()) {
                              case 0:
                                $tipo = 'Productiva';
                                break;
                              case 1:
                                $tipo = 'Administrativa';
                                break;
                              
                              default:
                                $tipo = 'Productiva';
                                break;
                            }
                            if($value->getEstado()){
                              $estado = '<span class="label label-success">ACTIVA</span>';
                              $baja = "<a href='#' data-toggle='modal' id='".$value->getId()."_baja' data-target='#modal-baja' data-idplaza='".$value->getId()."' data-fecha='".$value->getFechaAlta()->format('Y-m-d')."' data-nombre='".$value->getNombre()."' onclick='bajaPlaza(".$value->getId().")'><button class='btn btn-danger'><i class='fa fa-times'></i></button></a>";
                            } else {
                              $estado = '<span class="label label-danger">INACTIVA</span>';
                              $baja = "<a href='#' data-toggle='modal' id='".$value->getId()."_alta' data-target='#modal-alta' data-idplaza='".$value->getId()."' data-fecha='".$value->getFechaBaja()->format('Y-m-d')."' data-nombre='".$value->getNombre()."' onclick='altaPlaza(".$value->getId().")'><button class='btn btn-success'><i class='fa fa-check'></i></button></a>";
                            }

                            $edicion = "<a href='#' data-toggle='modal' id='".$value->getId()."_edit' data-target='#modal-nueva' data-idplaza='".$value->getId()."'  data-nombre='".$value->getNombre()."'  data-tipo='".$value->getTipo()."' onclick='editaPlaza(".$value->getId().")'><button class='btn btn-info'><i class='fa fa-pencil'></i></button></a>";
                            
                            $fechaAlta = $value->getFechaAlta()->format('d-m-Y');
                            if (is_null($value->getFechaBaja())) {
                              $fechaBaja = '';
                            } else {
                              $fechaBaja= $value->getFechaBaja()->format('d-m-Y');
                            }

                            echo "<tr>";
                            echo "<td>".$value->getId()."</td>";
                            echo "<td>".$value->getNombre()."</td>";
                            echo "<td>".$tipo."</td>";
                            echo "<td>".$estado."</td>";
                            echo "<td>".$fechaAlta."</td>";
                            echo "<td>".$fechaBaja."</td>";
                            echo "<td style='text-align: center;'>".$edicion." ".$baja."</td>";
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

      <div class="modal fade in" id="modal-nueva">
    <div class="modal-dialog">
      <div class="modal-content">

        <form action="<?php echo $url_action_plaza; ?>" method="post">

          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span></button>
            <h4 class="modal-title">Entrega de Línea</h4>
          </div>
          <div class="modal-body">
              <div class="row">
                <div class="col-md-12" style="margin-bottom: 15px;" id='divFecha'>
                  <label>Fecha de Alta</label>
                  <input type="date" name="fecha" id="fecha" class="form-control">
                </div> 
                <div class="col-md-12" style="margin-bottom: 15px;">
                  <label>Nombre</label>
                  <input type="text" name="nombre" id="nombre" class="form-control">
                  <input type="hidden" name="accion" id="accion" class="form-control">
                  <input type="hidden" name="id" id="id" class="form-control">
                </div> 
                <div class="col-md-12" style="margin-bottom: 15px;">
                  <label>Tipo de plaza</label>
                  <select name="tipo" id="tipo" class="form-control" style="width: 100%">
                    <option value="0">Productiva</option>
                    <option value="1">Administrativa</option>
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

      <div class="modal fade in modal-danger" id="modal-baja">
    <div class="modal-dialog">
      <div class="modal-content">

        <form action="<?php echo $url_action_plaza_baja; ?>" method="post">

          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span></button>
            <h4 class="modal-title">Dar de baja la plaza <span id="nomPlaza"></span></h4>
          </div>
          <div class="modal-body">
              <div class="row">
                <div class="col-md-12" style="margin-bottom: 15px;" id='divFecha'>
                  <label>Fecha de Baja</label>
                  <input type="date" name="fecha" id="fechaBaja" class="form-control">
                  <input type="date" name="fechaRef" id="fechaBajaRef" class="form-control" style="display: none;">
                  <input type="hidden" name="id" id="idBaja" class="form-control">
                  <input type="hidden" name="accion" value="baja" class="form-control">
                </div>
              </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-danger">Dar de baja</button>
          </div>
        </form>

      </div>
    </div>
  </div>

      <div class="modal fade in modal-success" id="modal-alta">
    <div class="modal-dialog">
      <div class="modal-content">

        <form action="<?php echo $url_action_plaza_baja; ?>" method="post">

          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span></button>
            <h4 class="modal-title">Reactivar plaza <span id="nomPlazaA"></span></h4>
          </div>
          <div class="modal-body">
              <div class="row">
                <div class="col-md-12" style="margin-bottom: 15px;" id='divFecha'>
                  <label>Fecha de Reactivación</label>
                  <input type="date" name="fecha" id="fechaAlta" class="form-control">
                  <input type="date" name="fechaRef" id="fechaAltaRef" class="form-control" style="display: none;">
                  <input type="hidden" name="id" id="idAlta" class="form-control">
                  <input type="hidden" name="accion" value="alta" class="form-control">
                </div>
              </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-success">Reactivar</button>
          </div>
        </form>

      </div>
    </div>
  </div>

      <script type="text/javascript">        
        $(document).ready(function(){                
          $("#mnu_usuariosyplazas").addClass("active");
        });        
        $(document).ready(function(){                
          $("#mnu_plazaABM").addClass("active");
        });

        function nuevaPlaza(){
          document.getElementById("divFecha").style.display = "block";
          document.getElementById('id').value = 0;
          document.getElementById('nombre').value = '';
          document.getElementById('tipo').selectedIndex = 0;
          document.getElementById('accion').value = 'nueva';
        }

        function editaPlaza(id){
          document.getElementById("divFecha").style.display = "none";
          id_plaza = document.getElementById(id+'_edit').getAttribute('data-idplaza');
          nombre_plaza = document.getElementById(id+'_edit').getAttribute('data-nombre');
          tipo_plaza = document.getElementById(id+'_edit').getAttribute('data-tipo');

          document.getElementById('id').value = id_plaza;
          document.getElementById('nombre').value = nombre_plaza;
          document.getElementById('tipo').selectedIndex = tipo_plaza;
          document.getElementById('accion').value = 'edicion';
        }

        function bajaPlaza(id){
          id_plaza = document.getElementById(id+'_baja').getAttribute('data-idplaza');
          nombre_plaza = document.getElementById(id+'_baja').getAttribute('data-nombre');
          fechabaja = document.getElementById(id+'_baja').getAttribute('data-fecha');

          document.getElementById('idBaja').value = id_plaza;
          document.getElementById('fechaBajaRef').value = fechabaja;
          document.getElementById('nomPlaza').innerHTML = nombre_plaza;
        }

        function altaPlaza(id){
          id_plaza = document.getElementById(id+'_alta').getAttribute('data-idplaza');
          nombre_plaza = document.getElementById(id+'_alta').getAttribute('data-nombre');
          fechaalta = document.getElementById(id+'_alta').getAttribute('data-fecha');

          document.getElementById('idAlta').value = id_plaza;
          document.getElementById('fechaAltaRef').value = fechaalta;
          document.getElementById('nomPlazaA').innerHTML = nombre_plaza;
        }

        $(document).ready(function() {
          $("#fechaBaja").on('change', function (e) { 
            controlFecha();
          });
        });

        function controlFecha(){
          fechadev = document.getElementById("fechaBaja").value;
          fechaent = document.getElementById("fechaBajaRef").value;

          if(fechadev<fechaent){
            alert("No se puede dar de baja una plaza con una fecha anterior a la de activación");
            document.getElementById("fechaBaja").value = fechaent;
          }
        }

        $(document).ready(function() {
          $("#fechaAlta").on('change', function (e) { 
            controlFechaAlta();
          });
        });

        function controlFechaAlta(){
          fechadev = document.getElementById("fechaAlta").value;
          fechaent = document.getElementById("fechaAltaRef").value;

          if(fechadev<fechaent){
            alert("No se puede reactivar una plaza con una fecha anterior a la de baja");
            document.getElementById("fechaAlta").value = fechaent;
          } 

        }



        $(document).ready(function() {
            $('#tabla').DataTable({
              "bLengthChange":false,
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

