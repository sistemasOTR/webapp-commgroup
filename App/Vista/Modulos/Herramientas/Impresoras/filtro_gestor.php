<?php 
 $arrGestor = $handler->selectAllGestor($user->getAliasUserSistema()); 
 ?>
<!-- Filtro por usuario -->

<div class="col-md-4 col-md-offset-6">
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
