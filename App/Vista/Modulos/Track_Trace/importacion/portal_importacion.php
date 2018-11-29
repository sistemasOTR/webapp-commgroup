<div class="content-wrapper">  
    <section class="content-header">
        <h1>Track & Trace - Portal Importación Contratos</h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li class="active">Track & Trace - Portal Importación Contratos</li>
        </ol>
    </section>        
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="col-sm-6 col-md-3">
                    <div class="box box-solid">
                      <div class="box-header with-border bg-green">
                        <h3 class="box-title">Contratos</h3>
                        <div class="box-tools">                
                            <button type="button" class="btn btn-box-tool" data-widget="collapse">
                              <i class="fa fa-minus"></i>
                            </button>                
                          </div>
                      </div>
                      <div class="box-body no-padding">
                        <ul class="nav nav-pills nav-stacked">
                          <li><a href="?view=portal_importacion"><i class="fa fa-database"></i> Desde Portal</a></li>
                          <li><a href="?view=webservice_importacion"><i class="fa fa-cloud"></i> Desde WebService</a></li>
                        </ul>
                      </div>  
                    </div>
                    <div class="box box-solid">
                      <div class="box-header with-border bg-red">
                        <h3 class="box-title">Servicios</h3>
                        <div class="box-tools">                
                            <button type="button" class="btn btn-box-tool" data-widget="collapse">
                              <i class="fa fa-minus"></i>
                            </button>                
                          </div>
                      </div>
                      <div class="box-body no-padding">
                        <ul class="nav nav-pills nav-stacked">
                          <li><a href="?view=portal_importacion"><i class="fa fa-database"></i> Desde Portal</a></li>
                          <li><a href="?view=webservice_importacion"><i class="fa fa-cloud"></i> Desde WebService</a></li>
                        </ul>
                      </div>  
                    </div>
                </div>
                <div class="col-sm-6 col-md-9">
        


<div class="col-md-12">
    <div class="box box-solid">
        <div class="box-header with-border">
          <i class="fa fa-filter"></i>
          <h3 class="box-title">Filtros Disponibles</h3>
          <button type="button" class="btn btn-box-tool pull-right bg-red" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>
        <div class="box-body">
          <div class="row">  
        <div class="col-md-3" id="sandbox-container">
            <label>Documento </label>                
            <div class="input-daterange input-group" id="datepicker">
              <input type="text" class="input-sm form-control"  id="start" name="start" value="">
                
            </div>
        </div>
        <div class="col-md-3"></div>
        <div class="col-md-3 col-md-offset-3">                
          <label></label>                
          <a class="btn btn-block btn-success" id="filtro_reporte" onclick="crearHref()" href="index.php?view=estadisticas&amp;consulta=cons7&amp;fdesde=2018-08-29&amp;fhasta=2018-08-29"><i class="fa fa-filter"></i> Filtrar</a>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="col-md-12">
  <div class="box">
    <div class="box-body table-responsive">
        <div id="tabla_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer"><div id="tabla_filter" class="dataTables_filter"><label>Buscar:<input type="search" class="form-control input-sm" placeholder="" aria-controls="tabla"></label></div><table class="table table-striped dataTable no-footer" id="tabla" role="grid" aria-describedby="tabla_info">
          <thead>
            <tr role="row">
            <th>DOCUMENTO</th>
              <th>ARCHIVO</th></tr>
        </thead>
        <tbody>
            
                          
                            <tr role="row" class="odd">
                      <td>35876520</td>                       
                        <td>Contrato.pdf</td>                                        
                    </tr></tbody>
      </table><div class="dataTables_info" id="tabla_info" role="status" aria-live="polite">Mostrando registros del 1 al 1 de un total de 1 registros</div><div class="dataTables_paginate paging_simple_numbers" id="tabla_paginate"><ul class="pagination"><li class="paginate_button previous disabled" id="tabla_previous"><a href="#" aria-controls="tabla" data-dt-idx="0" tabindex="0">Anterior</a></li><li class="paginate_button active"><a href="#" aria-controls="tabla" data-dt-idx="1" tabindex="0">1</a></li><li class="paginate_button next disabled" id="tabla_next"><a href="#" aria-controls="tabla" data-dt-idx="2" tabindex="0">Siguiente</a></li></ul></div></div>
    </div>
  </div>
</div>


      </div>




            </div>
        </div>
    </section>
</div>