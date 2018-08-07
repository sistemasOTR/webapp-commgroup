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
              
                
                <div class="col-md-4">
                  <label>Usuarios </label>  
                  <select id="slt_gestor" class="form-control" style="width: 100%" name="slt_gestor" onchange="crearHref()">
                    <option value=''></option>
                    <option value='0'>TODOS</option>
                    <?php
                      if(!empty($arrGestores) || !empty($arrUsuarios)){
                        if ($fplaza != '') {

                          foreach ($arrGestores as $user) {

                            foreach ($arrGestor as $gestor) {
                              if($fgestorId == $user->getId() && $user->getUserSistema() == $gestor->GESTOR11_CODIGO && $user->getTipoUsuario()->getNombre()!= 'Empresa'){
                                echo "<option value='".$user->getId()."' selected>".$user->getApellido()." ".$user->getNombre()."</option>";
                              } elseif ($user->getUserSistema() == $gestor->GESTOR11_CODIGO && $user->getTipoUsuario()->getNombre()!= 'Empresa') {
                                echo "<option value='".$user->getId()."'>".$user->getApellido()." ".$user->getNombre()."</option>";
                                }
                              }
                            }
                        } else {
                          foreach ($arrUsuarios as $user) {
                            if($fgestorId == $user->getId())
                                echo "<option value='".$user->getId()."' selected>".$user->getApellido()." ".$user->getNombre()."</option>";
                              else
                                echo "<option value='".$user->getId()."'>".$user->getApellido()." ".$user->getNombre()."</option>";                  
                                
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
