<div class="content-wrapper" id="app">
    <section class="content-header">
        <h1>Track & Trace - ABM Coordinadores</h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li class="active">Track & Trace - ABM Coordinadores</li>
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
                        <a href="#" class="btn btn-success pull-right" @click="abrirModalNuevo()">
                            Nuevo
                        </a>
                    </div>            
                    <div class="box-body table-responsive">         
                        <table class="table table-striped table-condensed" id="tabla" cellspacing="0" width="100%">
                            <thead>
                                <tr>       
                                    <th class='text-center'>Documento</th>
                                    <th class='text-center'>Nombre</th>
                                    <th class='text-center'>Alias WS Budget</th>
                                    <th class='text-center'>Alias WS Budget II</th>
                                    <th class='text-center'>Alias Busqueda Budget</th>
                                    <th class='text-center'>Alias Busqueda Budget II</th>
                                    <th class='text-center'></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(coor,id) in coordinadores">
                                    <td class='text-center'>{{ coor.CORDI22_NUMDOC }}</td>
                                    <td class='text-center'>{{ coor.CORDI11_ALIAS }}</td>
                                    <td class='text-center'>{{ coor.alias_ws_budget }}</td>
                                    <td class='text-center'>{{ coor.alias_ws_budget2 }}</td>
                                    <td class='text-center'>{{ coor.alias_busqueda_budget }}</td>
                                    <td class='text-center'>{{ coor.alias_busqueda_budget2 }}</td>
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
                                <label>Alias</label>
                                <input type="text" v-model="un_coordinador.CORDI11_ALIAS" class="form-control">
                            </div> 
                            <div class="col-md-12">
                                <label>Tipo Documento</label>
                                <select v-model="un_coordinador.TIPO_DOCUMENTOS_id" class="form-control">
                                    <option v-for="(td,id) in tipo_documentos" v-bind:value="td.id">{{ td.TDO_21_NOMBRE_FD }}</option>
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label>Documento</label>
                                <input type="text" v-model="un_coordinador.CORDI22_NUMDOC" class="form-control">
                            </div>
                            <div class="col-md-12">
                                <label>Alias Ws Budget</label>
                                <input type="text" v-model="un_coordinador.alias_ws_budget" class="form-control">
                            </div> 
                            <div class="col-md-12">
                                <label>Alias Ws Budget II</label>
                                <input type="text" v-model="un_coordinador.alias_ws_budget2" class="form-control">
                            </div> 
                            <div class="col-md-12">
                                <label>Alias Busqueda Budget</label>
                                <input type="text" v-model="un_coordinador.alias_busqueda_budget" class="form-control">
                            </div>
                            <div class="col-md-12">
                                <label>Alias Busqueda Budget II</label>
                                <input type="text" v-model="un_coordinador.alias_busqueda_budget2" class="form-control">
                            </div>
                        </div>                              
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
                    <button v-on:click="storeCoordinador" class="btn btn-danger">Guardar</button>
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
                    <h4 class="modal-title">{{ un_coordinador.CORDI11_ALIAS }}</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-12">
                                <label>Alias</label>
                                <input type="text" v-model="un_coordinador.CORDI11_ALIAS" class="form-control">
                            </div> 
                            <div class="col-md-12">
                                <label>Tipo Documento</label>
                                <select v-model="un_coordinador.TIPO_DOCUMENTOS_id" class="form-control">
                                    <option v-for="(td,id) in tipo_documentos" v-bind:value="td.id">{{ td.TDO_21_NOMBRE_FD }}</option>
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label>Documento</label>
                                <input type="text" v-model="un_coordinador.CORDI22_NUMDOC" class="form-control">
                            </div>
                            <div class="col-md-12">
                                <label>Alias Ws Budget</label>
                                <input type="text" v-model="un_coordinador.alias_ws_budget" class="form-control">
                            </div> 
                            <div class="col-md-12">
                                <label>Alias Ws Budget II</label>
                                <input type="text" v-model="un_coordinador.alias_ws_budget2" class="form-control">
                            </div> 
                            <div class="col-md-12">
                                <label>Alias Busqueda Budget</label>
                                <input type="text" v-model="un_coordinador.alias_busqueda_budget" class="form-control">
                            </div>
                            <div class="col-md-12">
                                <label>Alias Busqueda Budget II</label>
                                <input type="text" v-model="un_coordinador.alias_busqueda_budget2" class="form-control">
                            </div>
                        </div>                              
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
                    <button v-on:click="updateCoordinador" class="btn btn-danger">Guardar</button>
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
            this.getCoordinadores();                                     
            this.getTipoDocumentos();    
        },

        data() {
            return {
                titulo: "Coordinadores",
                coordinadores: [],
                un_coordinador: [],
                tipo_documentos: [],
            }
        },        

        methods: {

            getCoordinadores: function() {
                this.$http.get(URL_API_MIGRACION + 'coordinadores/consulta')
                .then(function(response){
                    this.coordinadores = response.data.data;
                }) 
            },

            getTipoDocumentos: function() {
                this.$http.get(URL_API_MIGRACION + 'tipo_documentos/consulta')
                .then(function(response){
                    this.tipo_documentos = response.data.data;
                }) 
            },
            
            abrirModalEditar : function(id){ 
                this.un_coordinador = this.coordinadores[id];
                $("#modal-actualizar").modal();                                                                            
            },

            abrirModalNuevo : function(id){ 
                this.un_coordinador = [];
                $("#modal-nuevo").modal();                                                                            
            },

            updateCoordinador: function() {

                this.$http.post(URL_API_MIGRACION + 'coordinadores/alias_ws_budget',{
                    CORDI11_ALIAS: this.un_coordinador.CORDI11_ALIAS,
                    CORDI22_NUMDOC: this.un_coordinador.CORDI22_NUMDOC,
                    TIPO_DOCUMENTOS_id: this.un_coordinador.TIPO_DOCUMENTOS_id,
                    alias_ws_budget: this.un_coordinador.alias_ws_budget,
                    alias_ws_budget2: this.un_coordinador.alias_ws_budget2,
                    alias_busqueda_budget: this.un_coordinador.alias_busqueda_budget,
                    alias_busqueda_budget2: this.un_coordinador.alias_busqueda_budget2,
                    id: this.un_coordinador.id,
                })
                .then(function(response){
                    this.getCoordinadores();
                    $("#modal-actualizar").modal("toggle");                    
                    showAlertaOK("Se actualizo el registro con exito");
                }) 
                .catch((err) => {
                    $("#modal-actualizar").modal("toggle");
                    showAlertaERROR(err.statusText);                    
                })                
            },

            storeCoordinador: function() {

                this.$http.post(URL_API_MIGRACION + 'coordinadores/storeCoor',{
                    CORDI11_ALIAS: this.un_coordinador.CORDI11_ALIAS,
                    CORDI22_NUMDOC: this.un_coordinador.CORDI22_NUMDOC,
                    TIPO_DOCUMENTOS_id: this.un_coordinador.TIPO_DOCUMENTOS_id,
                    alias_ws_budget: this.un_coordinador.alias_ws_budget,
                    alias_ws_budget2: this.un_coordinador.alias_ws_budget2,
                    alias_busqueda_budget: this.un_coordinador.alias_busqueda_budget,
                    alias_busqueda_budget2: this.un_coordinador.alias_busqueda_budget2,
                })
                .then(function(response){
                    this.getCoordinadores();
                    $("#modal-nuevo").modal("toggle");                    
                    showAlertaOK("Se guardo el registro con exito");
                }) 
                .catch((err) => {
                    $("#modal-nuevo").modal("toggle");
                    showAlertaERROR(err.statusText);                    
                })                
            },
        }        
    })
</script>