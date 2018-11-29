<div class="content-wrapper" id="app">  
    <section class="content-header">
        <h1>Track & Trace - Cambio de Estados</h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li class="active">Track & Trace - Cambio de Estados</li>
        </ol>
    </section>        
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-2"></div>
                <div class="col-md-3">
                    <label>Fecha</label>
                    <input id="date" class="form-control" v-model="un_servicio.fecha" type="date">
                </div>
                <div class="col-md-3">
                    <label>Gestor</label>
                    <select class="form-control" v-model="un_servicio.GESTORES_id">
                        <option v-for="(gst,id) in gestores" v-bind:value="gst.id">{{ gst.GESTOR21_ALIAS }}</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label> </label>
                    <button v-on:click="getServicios" class="btn btn-success pull-right" style="position: absolute; margin-top: 25px;">Ver</button>
                </div>
                <div class="col-md-2"></div>
            </div>
            <div class="col-md-12">
            <div class="box-body table-responsive">         
                        <table class="table table-striped table-condensed" id="tabla" cellspacing="0" width="100%">
                            <thead>
                                <tr>       
                                    <th class='text-center'>Fecha</th>
                                    <th class='text-center'>Numero</th>
                                    <th class='text-center'>Documento</th>
                                    <th class='text-center'>Nombre</th>
                                    <th class='text-center'>Domicilio</th>
                                    <th class='text-center'>Horario</th>
                                    <th class='text-center'>Estado</th>
                                    <th class='text-center'></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(srv,id) in servicios">
                                    <td class='text-center'>{{ srv.SERTT11_FECSER }}</td>
                                    <td class='text-center'>{{ srv.SERTT12_NUMEING }}</td>
                                    <td class='text-center'>{{ srv.SERTT31_PERNUMDOC }}</td>
                                    <td class='text-center'>{{ srv.SERTT91_NOMBRE }}</td>
                                    <td class='text-center'>{{ srv.SERTT91_DOMICILIO }}</td>
                                    <td class='text-center'>{{ srv.SERTT91_HORARIO }}</td>
                                    <td class='text-center'>{{ srv.estados["nombre"] }}</td>
                                    <td class='text-center'>
                                        <a href='#' class='btn btn-primary btn-xs' v-on:click="abrirModalEditar(id)" >
                                            <i class='fa fa-edit' data-original-title='Actualizar registro'></i>
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="modal-actualizar" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">          
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                    <h4 class="modal-title">{{ un_servicio.SERTT12_NUMEING }}</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-12">
                                <label>Telefono</label>
                                <input type="text" v-model="un_servicio.SERTT91_TELEFONO" class="form-control" disabled>
                            </div> 
                            <div class="col-md-12">
                                <label>Fecha</label>
                                <input type="text" v-model="un_servicio.SERTT11_FECSER" class="form-control" disabled>
                            </div> 
                            <div class="col-md-12">
                                <label>Numero</label>
                                <input type="text" v-model="un_servicio.SERTT12_NUMEING" class="form-control" disabled>
                            </div>  
                            <div class="col-md-6">
                                <label>Estado</label>
                                <select class="form-control" v-model="un_servicio.ESTADOS_id" v-on:change="getSubEstados(un_servicio.ESTADOS_id)">
                                    <option v-for="(est,id) in estados" v-bind:value="est.id">{{ est.nombre }}</option>
                                </select>
                            </div> 
                            <div class="col-md-6">
                                <label>Sub Estado</label>
                                <select class="form-control" v-model="un_servicio.SUBESTADOS_id">
                                    <option v-for="(sest,id) in subestados" v-bind:value="sest.id">{{ sest.nombre }}</option>
                                </select>
                            </div> 
                            <div class="col-md-6" v-if="un_servicio.ESTADOS_id == 4">
                                <label>Fecha Repactado</label>
                                <input type="date" v-model="un_servicio.fecha_repacta" class="form-control">
                            </div> 
                            <div class="col-md-6" v-if="un_servicio.ESTADOS_id == 4">
                                <label>Hora Repactado</label>
                                <input type="text" v-model="un_servicio.hora_repacta" class="form-control">
                            </div> 
                            <div class="col-md-12">
                                <label>Observaciones</label>
                                <textarea v-model="un_servicio.SERTT91_OBRESPU" class="form-control"></textarea>
                            </div>
                        </div>                              
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
                    <button v-on:click="updateServicioCoor" class="btn btn-danger">Guardar</button>
                </div>            
            </div>
        </div>
    </div>
</div>

<script type="text/javascript"> 
    var URL_API_MIGRACION = '<?php echo URL_API_MIGRACION; ?>';

    var USER = '<?php echo $usuarioActivoSesion->getAliasUserSistema(); ?>';
    
    var BASE_URL = '<?php echo BASE_URL; ?>';
    var PATH_VISTA = '<?php echo PATH_VISTA; ?>';

    $(document).ready(function () {
        $("#msj-success").load(BASE_URL + PATH_VISTA + 'info_vue.html');
        $("#msj-errors").load(BASE_URL + PATH_VISTA + 'error_vue.html');
    })
</script>

<script type="text/javascript"> 
    var appVue = new Vue(
    {
        el: '#app',
        
        created: function() {                                    
            this.getGestores();
            this.getServicios();
            this.getEstados();
            //this.getSubEstados();
        },

        data: function() {
            return {
                gestores: [],   
                un_servicio: [],
                servicios: [],
                estados: [],
                subestados: [],
            }
        },        

        methods: {

            getGestores: function() {
                this.$http.get(URL_API_MIGRACION + 'gestores/consulta?coordinador_id='+USER)     
                .then(function(response){
                    this.gestores = response.data.data;
                })
                .catch((err) => {
                    showAlertaERROR(err.statusText);                    
                })
            },

            getEstados: function() {
                this.$http.get(URL_API_MIGRACION + 'estados/consulta')
                .then(function(response){
                    this.estados = response.data.data;
                })
                .catch((err) => {
                    showAlertaERROR(err.statusText);                    
                })
            },

            getSubEstados: function(id) {
                    
                this.$http.get(URL_API_MIGRACION + 'subestados/consultaByEstado?id='+id)
                .then(function(response){
                    this.subestados = response.data.data;
                }) 
            },

            getServicios: function() {
                this.$http.get(URL_API_MIGRACION + 'servicios/serviciosCambioCoordinador?gestor_id='+this.un_servicio.GESTORES_id+'&fecha='+this.un_servicio.fecha)
                .then(function(response){
                    this.servicios = response.data.data;
                })
                .catch((err) => {
                    showAlertaERROR(err.statusText);                    
                })
            },
            
            abrirModalEditar : function(id){ 
                this.un_servicio = this.servicios[id];
                $("#modal-actualizar").modal();                                                                            
            },

            updateServicioCoor: function() {

                this.$http.post(URL_API_MIGRACION + 'servicios/modificarEstadoCoor',{
                    estado: this.un_servicio.ESTADOS_id,
                    imagenes: '',
                    audio: '',
                    observaciones: this.un_servicio.SERTT91_OBRESPU,
                    subestado: this.un_servicio.SUBESTADOS_id,
                    fecha: this.un_servicio.fecha_repacta,
                    hora: this.un_servicio.hora_repacta,
                    id: this.un_servicio.id,
                })
                .then(function(response){
                    $("#modal-actualizar").modal("toggle");                    
                    showAlertaOK("Se actualizo el registro con exito");
                }) 
                .catch((err) => {
                    $("#modal-actualizar").modal("toggle");
                    showAlertaERROR(err.statusText);                    
                })                
            },
        },
    })
</script>