
			<div class="col-md-4 col-md-offset-6">
              <label>Plazas</label>

                <select id="slt_plaza" class="form-control" style="width: 100%" name="slt_coordinador" onchange="crearHref()">                              
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
                  ?>
                </select>
              </div>
              