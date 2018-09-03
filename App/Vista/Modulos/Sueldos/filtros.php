
      <div class='col-md-12'>
        <div class="box box-solid">
            <div class="box-header with-border">
              <i class="fa fa-filter"></i>
              <h3 class="box-title">Filtros Disponibles</h3>
            </div>
            <div class="box-body">
              <div class='row'>  
                
                <div class="col-md-3">
                  <label>Plazas</label>                
                  <select id="slt_plaza" class="form-control" style="width: 100%" name="slt_plaza" onchange="crearHref()">
                    <option value=''></option>
                    <option value='0'>TODOS</option>
                    <?php
                      if(!empty($arrPlazas)){
                        foreach ($arrPlazas as $plaza) { 
                          if($fplaza == $plaza->getId())
                            echo "<option value='".$plaza->getId()."' selected>".$plaza->getNombre()."</option>";
                          else
                            echo "<option value='".$plaza->getId()."'>".$plaza->getNombre()."</option>";
                        }
                      }
                    ?>
                  </select>
                </div>
                <div class="col-md-3">
                  <label>Empleados</label>                
                  <select id="slt_usuario" class="form-control" style="width: 100%" name="slt_usuario" onchange="crearHref()">
                    <option value=''></option>
                    <option value='0'>TODOS</option>
                    <?php
                      if(!empty($arrEmpleados)){
                        foreach ($arrEmpleados as $key => $value) { 
                          if($fusuario == $value->getId())
                            echo "<option value='".$value->getId()."' selected>".$value->getApellido()." ".$value->getNombre()."</option>";
                          else
                            echo "<option value='".$value->getId()."'>".$value->getApellido()." ".$value->getNombre()."</option>";
                        }
                      }
                    ?>
                  </select>
                </div>    
                         
                <div class='col-md-2 pull-right'>                
                  <label></label>                
                  <a class="btn btn-block btn-success" id="filtro_reporte" onclick="crearHref()"><i class='fa fa-filter'></i> Filtrar</a>
                </div>
              </div>
            </div>
        </div>
      </div>