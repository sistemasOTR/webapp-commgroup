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
                        <th class='text-center'>FECHA</th>
                        <th class='text-center'>NUMERO</th>
                        <th class='text-center'>DOCUMENTO</th>
                        <th class='text-center'>NOMBRE</th>
                        <th class='text-center'>DOMICILIO</th>
                        <th class='text-center'>TELEFONO</th>
                      </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(srv,indice) in servicios" class="odd">
                      <td class='text-center'>{{ srv.SERTT11_FECSER["date"].substring(0, 10) }}</td>
                      <td class='text-center'>{{ srv.SERTT12_NUMEING }}</td>
                      <td class='text-center'>{{ srv.SERTT31_PERNUMDOC }}</td>
                      <td class='text-center'>{{ srv.SERTT91_NOMBRE }}</td>
                      <td class='text-center'>{{ srv.SERTT91_DOMICILIO }}</td>
                      <td class='text-center'>{{ srv.SERTT91_TELEFONO }}</td>                      
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
    new Vue(
    {
        el: '#app',
        
        created: function() {
            this.getServiciosPendientes();
        },

        data() {
            return {
              servicios: [],
            }
        },        

        methods: {
            getServiciosPendientes: function() {
                this.$http.get(URL_API_MIGRACION + 'servicios/serviciosSistema')    
                .then(function(response){
                  this.servicios = response.data.data;
                })
            },
            procesarServicios: function() {
              this.$http.get(URL_API_MIGRACION + 'servicios/serviciosSistema')    
                .then(function(response){
                  //console.log(response.data.data)
                  for (let id in response.data.data) {                    
                    this.$http.post(URL_API_MIGRACION + 'servicios/importarSistema',{                    
                      fecha: response.data.data[id]["SERTT11_FECSER"]["date"].substring(0, 10),
                      documento: response.data.data[id]["SERTT31_PERNUMDOC"],
                      nombre: response.data.data[id]["SERTT91_NOMBRE"],
                      numero: response.data.data[id]["SERTT12_NUMEING"],
                      tipo_documento: response.data.data[id]["SERTT31_PERTIPDOC"],
                      domicilio: response.data.data[id]["SERTT91_DOMICILIO"],
                      localidad: response.data.data[id]["SERTT91_LOCALIDAD"],
                      horario: response.data.data[id]["SERTT91_HORARIO"],
                      telefono: response.data.data[id]["SERTT91_TELEFONO"],
                      empresa: response.data.data[id]["SERTT91_CODEMPRE"],
                      plaza: response.data.data[id]["SERTT91_COOALIAS"],
                      producto: response.data.data[id]["SERTT91_PRODUCTO"],
                      comentarios: response.data.data[id]["SERTT91_OBSERV"],
                      codigo_postal: "",
                      datosextras: "",
                      adicionales: "",
                      documentacion: "",
                    })
                  }
                })                      
              },
            },
    })
</script>