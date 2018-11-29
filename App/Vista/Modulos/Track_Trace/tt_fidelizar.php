<div class="content-wrapper" id="app">
    <section class="content-header">
        <h1>Track & Trace - Fidelizar</h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li class="active">Track & Trace - Fidelizar</li>
        </ol>
    </section>        
    <section class="content">

        <div id="msj-success"></div>
        <div id="msj-errors"></div>

        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <i class="fa fa-list"></i>
                        <h3 class="box-title">{{ titulo }}</h3>
                    </div>            
                    <div class="box-body table-responsive">         
                        <table class="table table-striped table-condensed" id="tabla" cellspacing="0" width="100%">
                            <thead>
                                <tr>       
                                    <th class='text-center'>Fecha</th>
                                    <th class='text-center'>Numero</th>
                                    <th class='text-center'>Documento</th>
                                    <th class='text-center'>Gestor</th>
                                    <th class='text-center'>Estado</th>
                                    <th class='text-center'>Respuesta</th>
                                    <th class='text-center'></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(rt,id) in respuestas">
                                    <td class='text-center'>{{ rt.RESMB11_FECSER }}</td>
                                    <td class='text-center'>{{ rt.RESMB12_NUMEING }}</td>
                                    <td class='text-center'>{{ rt.RESMB31_PERNUMDOC }}</td>
                                    <td class='text-center'>{{ rt.gestores["GESTOR21_ALIAS"] }}</td><!--["GESTOR21_ALIAS"]-->
                                    <td class='text-center'>{{ rt.estados["nombre"] }}</td><!--["nombre"]-->
                                    <td class='text-center'>{{ rt.RESMB91_OBRESPU }}</td>
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
        </div>
    </section>
   
    <div class="modal fade" id="modal-actualizar" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">          
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                    <h4 class="modal-title">{{ una_respuesta.RESMB31_PERNUMDOC }}</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-12">
                                <label>Telefono</label>
                                <input type="text" v-model="una_respuesta.telefono" disabled class="form-control">
                            </div> 
                            <div class="col-md-6">
                                <label>Estado</label>
                                <select class="form-control" v-model="una_respuesta.ESTADOS_id" v-on:change="getSubEstados(una_respuesta.ESTADOS_id)">
                                    <option v-for="(est,id) in estados" v-bind:value="est.id">{{ est.nombre }}</option>
                                </select>
                            </div> 
                            <div class="col-md-6">
                                <label>Sub Estado</label>
                                <select class="form-control" v-model="una_respuesta.SUBESTADOS_id">
                                    <option v-for="(sest,id) in subestados" v-bind:value="sest.id">{{ sest.nombre }}</option>
                                </select>
                            </div> 
                            <div class="col-md-12">
                                <label>Respuesta</label>
                                <input type="text" v-model="una_respuesta.RESMB91_OBRESPU" class="form-control">
                            </div>  
                            <div class="col-md-6" v-if="una_respuesta.ESTADOS_id == 4">
                                <label>Fecha Repactado</label>
                                <input type="date" v-model="una_respuesta.fecha_repacta" class="form-control">
                            </div> 
                            <div class="col-md-6" v-if="una_respuesta.ESTADOS_id == 4">
                                <label>Hora Repactado</label>
                                <input type="text" v-model="una_respuesta.hora_repacta" class="form-control">
                            </div> 
                            <div class="col-md-12">
                                <label>Audio</label><br>
                                <audio  controls v-bind:src="una_respuesta.audio">
                                    Your browser does not support the <code>audio</code> element.
                                </audio>
                            </div> 
                            <div class="col-md-12">
                                <label>Imagenes</label>
                                <div class="timeline-body">
                                    <a v-for="(item, idx) in gal_imagen" v-bind:href="item.medios" target="_blank">
                                        <img v-bind:src="item.medios" class="margin" style="width:100px;">    
                                    </a>
                                </div>
                            </div>
                            <!--<div class="col-md-12">
                                <label>Fideliza</label>
                                <select v-model="una_respuesta.fideliza" class="form-control">
                                    <option value="2">NO</option>
                                    <option value="1">SI</option>
                                </select>
                            </div>-->
                        </div>                              
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
                    <button v-on:click="updateRespuesta" class="btn btn-danger">Guardar</button>
                </div>            
            </div>
        </div>
    </div>
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
            this.getRespuestas();                                      
            this.getEstados(); 
            this.getSubEstados();
        },

        data() {
            return {
                titulo: "Fidelizar",
                respuestas: [],
                una_respuesta: [],
                gal_imagen: [],
                estados: [],
                subestados: [],
            }
        },        

        methods: {

            getRespuestas: function() {
                this.$http.get(URL_API_MIGRACION + 'respuesta_mobile/consulta')
                .then(function(response){
                    this.respuestas = response.data.data;
                }) 
            },

            getEstados: function() {
                this.$http.get(URL_API_MIGRACION + 'estados/consulta')
                .then(function(response){
                    this.estados = response.data.data;
                }) 
            },

            getSubEstados: function(id) {

                if(id == undefined) {

                    API = 'subestados/consulta';
                } else {

                    API = 'subestados/consultaByEstado?id='+id;
                }
                    
                
                this.$http.get(URL_API_MIGRACION + API)
                .then(function(response){
                    this.subestados = response.data.data;
                }) 
            },
            
            abrirModalEditar : function(id){ 
                this.una_respuesta = this.respuestas[id];
                this.gal_imagen = JSON.parse(this.respuestas[id].servicios.imagen);
                this.una_respuesta["telefono"] = this.respuestas[id].servicios.SERTT91_TELEFONO;

                //console.log(this.gal_imagen[0]["medios"]);

                $("#modal-actualizar").modal();                                                                            
            },

            updateRespuesta: function() {

                this.$http.post(URL_API_MIGRACION + 'respuesta_mobile/fideliza',{
                    fecha_repacta: this.una_respuesta.fecha_repacta,
                    hora_repacta: this.una_respuesta.hora_repacta,
                    estado: this.una_respuesta.ESTADOS_id,
                    subestado: this.una_respuesta.SUBESTADOS_id,
                    observaciones: this.una_respuesta.RESMB91_OBRESPU,
                    //fideliza: this.una_respuesta.fideliza,
                    id: this.una_respuesta.id,
                })
                .then(function(response){
                    this.getRespuestas();
                    $("#modal-actualizar").modal("toggle");                    
                    showAlertaOK("Se actualizo el registro con exito");
                }) 
                .catch((err) => {
                    $("#modal-actualizar").modal("toggle");
                    showAlertaERROR(err.statusText);                    
                })                
            },
        }        
    })
</script>