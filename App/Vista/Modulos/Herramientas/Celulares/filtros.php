
<!-- Filtro por plaza -->
<div class="col-md-4 col-md-offset-6">
  <label>Usuario</label>
  <select name="slt_gestor" id="slt_gestor" class="form-control" style="width: 100%" onchange="crearHrefG()">
    <option value="">Seleccionar</option>
    <option value="0">Todos</option>
    <?php 
      if(!empty($arrUsuarios)){
        foreach ($arrUsuarios as $usuario) {
          if($fgestorId == $usuario->getId()){
              echo "<option value='".$usuario->getId()."' selected>".$usuario->getNombre()." ".$usuario->getApellido()."</option>";
            } else {
              echo "<option value='".$usuario->getId()."'>".$usuario->getNombre()." ".$usuario->getApellido()."</option>";
          }
        } 
      }
    ?>
  </select>
</div>
