<div class="content-wrapper" id="app">  
  <section class="content-header">
    <h1>Track & Trace - Servicios Web Service</h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
      <li class="active">Track & Trace - Servicios Web Service</li>
    </ol>
  </section>        
  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="col-sm-6 col-md-3">
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
                <li><a href="?view=portal_importacion_serv"><i class="fa fa-database"></i> Desde Portal</a></li>
                <li><a href="?view=webservice_importacion_serv"><i class="fa fa-cloud"></i> Desde WebService</a></li>
                <li><a href="?view=webservice_importacion_serv2"><i class="fa fa-cloud"></i> Desde WebService Sec</a></li>
              </ul>
            </div>  
          </div>
        </div>
        <div class="col-sm-6 col-md-9">
          <div class="col-md-12">
            <div class="box">
              <div class="box-header with-border">
                  <i class="fa fa-list"></i>
                  <a href="#" class="btn btn-success pull-right" @click="procesarServicios()">
                      Procesar
                  </a>
              </div> 
              <div class="box-body table-responsive">
                <div id="tabla_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                  <table class="table table-striped dataTable no-footer" id="tabla" role="grid" aria-describedby="tabla_info">
                    <thead>
                      <tr role="row">
                        <th class='text-center'>PLAZA</th>
                        <th class='text-center'>BANCO</th>
                        <th class='text-center'>APELLIDO</th>
                        <th class='text-center'>NOMBRE</th>
                        <th class='text-center'>DOCUMENTO</th>
                        <th class='text-center'>DOMICILIO</th>
                      </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(srv,indice) in servicios" class="odd">
                      <td class='text-center'>{{ srv.nodo }}</td>
                      <td class='text-center'>{{ srv.banco }}</td>
                      <td class='text-center'>{{ srv.apellido }}</td>
                      <td class='text-center'>{{ srv.nombre }}</td>
                      <td class='text-center'>{{ srv.documento }}</td>
                      <td class='text-center'>{{ srv.domicilio }}</td>
                    </tr>
                  </tbody>
                </table>
               </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

<script type="text/javascript"> 
    var URL_API_MIGRACION = '<?php echo URL_API_MIGRACION; ?>';
    
    var BASE_URL = '<?php echo BASE_URL; ?>';
    var PATH_VISTA = '<?php echo PATH_VISTA; ?>';

    $(document).ready(function () {
        $("#msj-success").load(BASE_URL + PATH_VISTA + 'info_vue.html');
        $("#msj-errors").load(BASE_URL + PATH_VISTA + 'error_vue.html');
    })
</script>

<script type="text/javascript"> 
    var urlImportacion = 'http://200.123.131.169/APISERVICE/ENTREVISTASCOMMER?plaza=';

    new Vue(
    {
        el: '#app',
        
        created: function() {
            this.getServiciosByPlazas();
        },

        data() {
            return {
              plazas: [],
              servicios: [],
            }
        },        

        methods: {
            getServiciosByPlazas: function() {
                this.$http.get(URL_API_MIGRACION + 'plazas/consulta_sec')    
                .then(function(response){
                  this.plazas = response.data.data;

                  for (var x = 0; x < this.plazas.length; x++) {
                    this.$http.get(urlImportacion + this.plazas[x]["alias_ws_budget2"])
                      .then(function(response){
                        for (let id in response.data) {
                          this.servicios.push(response.data[id]);
                        }
                      }) 
                  }
                })
            },
            procesarServicios: function() {
                this.$http.get(URL_API_MIGRACION + 'plazas/consulta_sec')    
                .then(function(response){
                  this.plazas = response.data.data;

                  for (var x = 0; x < this.plazas.length; x++) {
                    this.$http.get(urlImportacion + this.plazas[x]["alias_ws_budget2"])
                      .then(function(response){
                        for (let id in response.data) {
                          this.$http.post(URL_API_MIGRACION + 'servicios/guardar',{                    
                              fecha: moment(response.data[id]["fecha"], 'DD/MM/YYYY').format('YYYY-MM-DD'),
                              documento: response.data[id]["documento"],
                              nombre: response.data[id]["cliente"],
                              domicilio: response.data[id]["calle"] + ' ' + response.data[id]["altura"] + ' ' + response.data[id]["piso"] + ' ' + response.data[id]["depto"],
                              localidad: response.data[id]["localidad"],
                              horario: response.data[id]["horario"],
                              telefono: response.data[id]["telefonos"],
                              empresa: response.data[id]["banco"],
                              plaza: response.data[id]["nodo"],
                              producto: response.data[id]["producto"],
                              codigo_postal: response.data[id]["cp"],
                              comentarios: response.data[id]["comentarios"],
                              datosextras: response.data[id]["datosextras"],
                              adicionales: response.data[id]["adicionales"],
                              documentacion: response.data[id]["documentacion"],     
                          })
                        }
                      }) 
                  }
                })
            },
            
        }        
    })
</script>