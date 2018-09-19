
<!-- Modal nuevo -->
<div class="modal fade in" id="modal-nuevo">
  <div class="modal-dialog">
    <div class="modal-content">

      <form action="<?php echo $url_action_nueva_tarea; ?>" method="post">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span></button>
          <h4 class="modal-title">Nuevo</h4>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-9">
                  <label>Título</label>
                  <input type="text" name="titulo" class="form-control editable">
                  <input type="hidden" name="id_sol" class="form-control" value='<?php echo $user->getId(); ?>'>
                  <input type="hidden" name="fecha_sol" class="form-control" value='<?php echo $dFecha->FechaActual(); ?>'>
                  <input type="hidden" name="plaza" class="form-control" value='<?php echo $user->getUserPlaza(); ?>'>
                </div>
                <div class="col-md-3">
                  <label>Prioridad</label>
                  <select name="slt_prioridad" id="" class="form-control slt_editable">
                    <option value="0" selected="">BAJA</option>
                    <option value="1">MEDIA</option>
                    <option value="2">ALTA</option>
                  </select>
                </div>
                <div class="col-md-12">
                  <label>Descripción</label>
                  <textarea name="descripcion" id="descripcion" class=" txt_editable"></textarea>
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


<!-- modal asignacion usuario -->
<div class="modal fade in" id="modal-usuario">
  <div class="modal-dialog">
    <div class="modal-content">

      <form action="<?php echo $url_action_asignar_user; ?>" method="post">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span></button>
          <h4 class="modal-title">Asignar Usuario</h4>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                  <label>Usuario</label>
                  <select name="slt_usuario" id="slt_usuario" class="form-control">
                    <?php 
                      $arrEmpleados = $handlerUs->selectEmpleados();
                      if (!empty($arrEmpleados)) {
                        foreach ($arrEmpleados as $empleado) {
                          echo "<option value='".$empleado->getId()."'>".$empleado->getApellido()." ".$empleado->getNombre()."</option>";
                          
                        }
                      }

                     ?>
                  </select>
                  <input type="hidden" name="id_tarea" id="id_tarea" class="form-control">
                  <input type="hidden" name="id_operador" id="id_operador" class="form-control" value='<?php echo $user->getId(); ?>'>
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


<!-- modal asignacion fechas -->
<div class="modal fade in" id="modal-fechas">
  <div class="modal-dialog">
    <div class="modal-content">

      <form action="<?php echo $url_action_asignar_fechas; ?>" method="post">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span></button>
          <h4 class="modal-title">Asignar Fechas estimadas</h4>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-6">
                  <label>Inicio</label>
                  <input type="date" name="inicio_est" id="inicio_est" class="form-control">
                  <input type="hidden" name="id_tarea" id="id_tarea_fechas" class="form-control">
                  <input type="hidden" name="id_operador" id="id_operador" class="form-control" value='<?php echo $user->getId(); ?>'>
                </div>           
                <div class="col-md-6">
                  <label>Final</label>
                  <input type="date" name="fin_est" id="fin_est" class="form-control">
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