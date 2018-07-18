<?php 
 $arrGestor = $handler->selectAllGestor($fplaza); 
 ?>
 <div class="box box-solid">
  <div class="box-header with-border">
    <i class="fa fa-filter"></i>
    <h3 class="box-title">Filtros Disponibles</h3>
  </div>

  <div class="box-body"> 
    <!-- Filtro por plaza -->
    <div class="col-md-4">
      <label>Plazas</label>

      <select id="slt_plaza" class="form-control" style="width: 100%" name="slt_coordinador" onchange="crearHrefP()">                              
        <option value="">Seleccionar...</option>
        <option value='0'>TODAS</option>
        <?php
          if(!empty($arrCoordinador))
          {                        
            foreach ($arrCoordinador as $key => $value) {                                                  
              if($fplaza==$value['PLAZA'])
                echo "<option value='".trim($value['PLAZA'])."' selected>".$value['PLAZA']."</option>";
              else
                echo "<option value='".trim($value['PLAZA'])."'>".$value['PLAZA']."</option>";
            }
          }
          if($fplaza=='MANTENIMIENTO')
                echo "<option value='MANTENIMIENTO' selected>MANTENIMIENTO</option>";
              else
                echo "<option value='MANTENIMIENTO'>MANTENIMIENTO</option>";

        ?>
      </select>
    </div>

    <!-- Filtro por usuario -->

    <div class="col-md-4">
      <label>Gestor</label>
      <select name="slt_gestor" id="slt_gestor" class="form-control" style="width: 100%" onchange="crearHrefG()">
        <option value="">Seleccionar</option>
        <option value="0">Todos</option>
        <?php 
          if(!empty($arrUsuarios)){
            foreach ($arrUsuarios as $usuario) {
                if($fgestorId == $usuario->getId())
                    echo "<option value='".$usuario->getId()."' selected>".$usuario->getNombre()." ".$usuario->getApellido()."</option>";
                  else {
                    echo "<option value='".$usuario->getId()."'>".$usuario->getNombre()." ".$usuario->getApellido()."</option>";
                }
              
            } 
          }
        ?>
      </select>
    </div>
    <div class='col-md-2' style="display: none;">                
      <label></label>                
      <?php 
      echo "<a class='btn btn-block btn-success' id='filtro_reporte' onclick='crearHref()'><i class='fa fa-filter'></i> Filtrar</a>";
      ?>                  
    </div>
  </div>
</div>
