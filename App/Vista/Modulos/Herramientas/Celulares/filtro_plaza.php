
<!-- Filtro por plaza -->
<div class="col-md-4 col-md-offset-2">
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
          foreach ($arrGestor as $gestor) {
            if($fgestorId == $usuario->getId() && $usuario->getUserSistema() == $gestor->GESTOR11_CODIGO)
                echo "<option value='".$usuario->getId()."' selected>".$usuario->getNombre()." ".$usuario->getApellido()."</option>";
              elseif ($usuario->getUserSistema() == $gestor->GESTOR11_CODIGO) {
                echo "<option value='".$usuario->getId()."'>".$usuario->getNombre()." ".$usuario->getApellido()."</option>";
            }
          }
        } 
      }
    ?>
  </select>
</div>
