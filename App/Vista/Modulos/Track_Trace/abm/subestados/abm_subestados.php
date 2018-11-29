<div class="content-wrapper" id="app">
    <section class="content-header">
        <h1>Track & Trace - ABM Sub Estados</h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li class="active">Track & Trace - ABM Sub Estados</li>
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
                        <a href="#" class="btn btn-success pull-right" v-on:click="abrirModalNuevo()">
                            Nuevo
                        </a>
                    </div>            
                    <div class="box-body table-responsive">         
                        <table class="table table-striped table-condensed" id="tabla" cellspacing="0" width="100%">
                            <thead>
                                <tr>       
                                    <th class='text-center'>Sub Estado</th>
                                    <th class='text-center'>Estado</th>
                                    <th class='text-center'></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(subestados,id) in info_subestados">
                                    <td class='text-center'>{{ subestados.nombre }}</td>
                                    <td class='text-center'>{{ subestados.estados["nombre"] }}</td>
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

    <div class="modal fade" id="modal-nuevo" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">          
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                    <h4 class="modal-title">NUEVO</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-12">
                                <label>Sub Estado</label>
                                <input type="text" v-model="un_subestado.nombre" class="form-control" required="">
                            </div>
                            <div class="col-md-12">
                                <label>Estado</label>
                                <select v-model="un_subestado.ESTADOS_id" class="form-control">
                                    <option v-for="(est,id) in estados" v-bind:value="est.id">{{ est.nombre }}</option>
                                </select>
                            </div>     
                        </div>                         
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
                    <button v-on:click="StoreSubEstado" class="btn btn-danger">Guardar</button>
                </div>            
            </div>
        </div>
    </div>
   
    <div class="modal fade" id="modal-actualizar" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">          
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                    <h4 class="modal-title">MODIFICAR</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">                            
                            <div class="col-md-12">
                                <input type="hidden" v-model="un_subestado.id" class="form-control" required="">
                            </div>
                            <div class="col-md-12">
                                <label>Sub Estado</label>
                                <input type="text" v-model="un_subestado.nombre" class="form-control" required="">
                            </div>
                            <div class="col-md-12">
                                <label>Estado</label>
                                <select v-model="un_subestado.ESTADOS_id" class="form-control">
                                    <option v-for="(est,id) in estados" v-bind:value="est.id">{{ est.nombre }}</option>
                                </select>
                            </div> 
                        </div>                              
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
                    <button v-on:click="updateSubEstado" class="btn btn-danger">Guardar</button>
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
            this.getSubEstados();                                        
            this.getEstados();
        },

        data() {
            return {
                titulo: "Sub Estados",
                info_subestados: [],
                un_subestado: [],
                estados: [],
            }
        },        

        methods: {

            getEstados: function() {
                this.$http.get(URL_API_MIGRACION + 'estados/consulta')    
                .then(function(response){
                    this.estados = response.data.data;
                }) 
            },

            getSubEstados: function() {
                this.$http.get(URL_API_MIGRACION + 'subestados/consulta')    
                .then(function(response){
                    this.info_subestados = response.data.data;
                }) 
            },
            
            abrirModalEditar : function(id){ 
                this.un_subestado = this.info_subestados[id];
                $("#modal-actualizar").modal();                                                                            
            },
            
            abrirModalNuevo : function(){
                this.un_subestado = [];
                $("#modal-nuevo").modal();
            },

            StoreSubEstado: function() {
                this.$http.post(URL_API_MIGRACION + 'subestados/guardar',{    
                    nombre: this.un_subestado.nombre,
                    estado_id: this.un_subestado.ESTADOS_id,
                })
                .then(function(response){
                    this.getSubEstados();
                    $("#modal-nuevo").modal("toggle");
                    showAlertaOK("Se guardo el registro con exito");
                }) 
                .catch((err) => {
                    $("#modal-nuevo").modal("toggle");
                    showAlertaERROR(err.statusText);                    
                })
            },

           updateSubEstado: function() {

                this.$http.post(URL_API_MIGRACION + 'subestados/modificar',{
                    nombre: this.un_subestado.nombre,
                    estado_id: this.un_subestado.ESTADOS_id,
                    id: this.un_subestado.id,                    
                })
                .then(function(response){
                    this.getSubEstados();
                    $("#modal-actualizar").modal("toggle");                    
                    showAlertaOK("Se actualizo el registro con exito");
                }) 
                .catch((err) => {
                    $("#modal-nuevo").modal("toggle");
                    showAlertaERROR(err.statusText);                    
                })                
            },
        }        
    })
</script>