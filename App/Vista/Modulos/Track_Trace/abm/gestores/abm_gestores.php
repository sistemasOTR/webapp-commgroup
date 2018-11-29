<div class="content-wrapper" id="app">
    <section class="content-header">
        <h1>Track & Trace - ABM Gestores</h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li class="active">Track & Trace - ABM Gestores</li>
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
                                    <th class='text-center'>Estados a Fidelizar</th>
                                    <th class='text-center'></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(gst,id) in gestores">
                                    <td class='text-center'>{{ gst.GESTOR32_NUMDOC }}</td>
                                    <td class='text-center'>{{ gst.GESTOR21_ALIAS }}</td>
                                    <td class='text-center'>{{ gst.estados_fidelizar }}</td>
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
                                <label>Codigo</label>
                                <input type="text" v-model="un_gestor.GESTOR11_CODIGO" class="form-control">
                            </div> 
                            <div class="col-md-12">
                                <label>Alias</label>
                                <input type="text" v-model="un_gestor.GESTOR21_ALIAS" class="form-control">
                            </div>  
                            <div class="col-md-12">
                                <label>Tipo Documento</label>
                                <select v-model="un_gestor.TIPO_DOCUMENTOS_id" class="form-control">
                                    <option v-for="(td,id) in tipo_documentos" v-bind:value="td.id">{{ td.TDO_21_NOMBRE_FD }}</option>
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label>Documento</label>
                                <input type="text" v-model="un_gestor.GESTOR32_NUMDOC" class="form-control">
                            </div> 
                            <div class="col-md-12">
                                <label>Coordinador</label>
                                <select v-model="un_gestor.CORDITT_id" class="form-control">
                                    <option v-for="(coor,id) in coordinadores" v-bind:value="coor.id">{{ coor.CORDI11_ALIAS }}</option>
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label>Estados a Fidelizar</label>
                                <select multiple class="form-control" v-model="un_gestor.estados_fidelizar">
                                    <option v-for="(est,id) in estados" v-bind:value="est.id">{{ est.nombre }}</option>
                                </select>
                            </div>
                        </div>                              
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
                    <button v-on:click="storeGestor" class="btn btn-danger">Guardar</button>
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
                    <h4 class="modal-title">{{ un_gestor.GESTOR21_ALIAS }}</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-12">
                                <label>Codigo</label>
                                <input type="text" v-model="un_gestor.GESTOR11_CODIGO" class="form-control">
                            </div> 
                            <div class="col-md-12">
                                <label>Alias</label>
                                <input type="text" v-model="un_gestor.GESTOR21_ALIAS" class="form-control">
                            </div>  
                            <div class="col-md-12">
                                <label>Tipo Documento</label>
                                <select v-model="un_gestor.TIPO_DOCUMENTOS_id" class="form-control">
                                    <option v-for="(td,id) in tipo_documentos" v-bind:value="td.id">{{ td.TDO_21_NOMBRE_FD }}</option>
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label>Documento</label>
                                <input type="text" v-model="un_gestor.GESTOR32_NUMDOC" class="form-control">
                            </div> 
                            <div class="col-md-12">
                                <label>Coordinador</label>
                                <select v-model="un_gestor.CORDITT_id" class="form-control">
                                    <option v-for="(coor,id) in coordinadores" v-bind:value="coor.id">{{ coor.CORDI11_ALIAS }}</option>
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label>Estados a Fidelizar</label>
                                <select multiple class="form-control" v-model="un_gestor.estados_fidelizar">
                                    <option v-for="(est,id) in estados" v-bind:value="est.id">{{ est.nombre }}</option>
                                </select>
                            </div>
                        </div>                              
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
                    <button v-on:click="updateGestor" class="btn btn-danger">Guardar</button>
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
            this.getGestores();                                       
            this.getCoordinadores();                                       
            this.getTipoDocumentos();
            this.getEstados();
        },

        data() {
            return {
                titulo: "Gestores",
                gestores: [],
                un_gestor: [],
                coordinadores: [],
                tipo_documentos: [],
                estados: [],
            }
        },        

        methods: {

            getCoordinadores: function() {
                this.$http.get(URL_API_MIGRACION + 'coordinadores/consulta')
                .then(function(response){
                    this.coordinadores = response.data.data;
                }) 
            },            

            getEstados: function() {
                this.$http.get(URL_API_MIGRACION + 'estados/consulta')
                .then(function(response){
                    this.estados = response.data.data;
                }) 
            },

            getTipoDocumentos: function() {
                this.$http.get(URL_API_MIGRACION + 'tipo_documentos/consulta')
                .then(function(response){
                    this.tipo_documentos = response.data.data;
                }) 
            },

            getGestores: function() {
                this.$http.get(URL_API_MIGRACION + 'gestores/consultaAll')
                .then(function(response){
                    this.gestores = response.data.data;
                }) 
            },
            
            abrirModalEditar : function(id){ 
                this.un_gestor = this.gestores[id];

                //this.un_gestor('[' + this.gestores[id]["estados_fidelizar"] + ']');exit;
                //this.estados_a_fidelizar = '[' + this.gestores[id]["estados_fidelizar"] + ']';

                //console.log(this.estados_a_fidelizar);
                $("#modal-actualizar").modal();                                                                            
            },
            
            abrirModalNuevo : function(id){ 
                this.un_gestor = [];
                $("#modal-nuevo").modal();                                                                            
            },

            updateGestor: function() {

                this.$http.post(URL_API_MIGRACION + 'gestores/fideliza',{
                    GESTOR11_CODIGO: this.un_gestor.GESTOR11_CODIGO,
                    GESTOR21_ALIAS: this.un_gestor.GESTOR21_ALIAS,
                    TIPO_DOCUMENTOS_id: this.un_gestor.TIPO_DOCUMENTOS_id,
                    GESTOR32_NUMDOC: this.un_gestor.GESTOR32_NUMDOC,
                    CORDITT_id: this.un_gestor.CORDITT_id,
                    estados_fidelizar: this.un_gestor.estados_fidelizar,
                    id: this.un_gestor.id,
                })
                .then(function(response){
                    this.getGestores();
                    $("#modal-actualizar").modal("toggle");                    
                    showAlertaOK("Se actualizo el registro con exito");
                }) 
                .catch((err) => {
                    $("#modal-actualizar").modal("toggle");
                    showAlertaERROR(err.statusText);                    
                })                
            },

            storeGestor: function() {

                this.$http.post(URL_API_MIGRACION + 'gestores/storeGestor',{
                    GESTOR11_CODIGO: this.un_gestor.GESTOR11_CODIGO,
                    GESTOR21_ALIAS: this.un_gestor.GESTOR21_ALIAS,
                    TIPO_DOCUMENTOS_id: this.un_gestor.TIPO_DOCUMENTOS_id,
                    GESTOR32_NUMDOC: this.un_gestor.GESTOR32_NUMDOC,
                    CORDITT_id: this.un_gestor.CORDITT_id,
                    estados_fidelizar: this.un_gestor.estados_fidelizar,
                })
                .then(function(response){
                    this.getGestores();
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