<div class="content-wrapper" id="app">
    <section class="content-header">
        <h1>Track & Trace - ABM Empresas</h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li class="active">Track & Trace - ABM Empresas</li>
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
                                    <th class='text-center'>Código</th>
                                    <th class='text-center'>Razón Social</th>                  
                                    <th class='text-center'>Siglas</th>
                                    <th class='text-center'>Nombre Fantasía</th>
                                    <th class='text-center'>Email</th>
                                    <th class='text-center'></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(empresas,id) in info_empresas">
                                    <td class='text-center'>{{ empresas.EMPTT11_CODIGO }}</td>
                                    <td class='text-center'>{{ empresas.EMPTT21_NOMBRE }}</td>
                                    <td class='text-center'>{{ empresas.EMPTT21_ABREV }}</td>
                                    <td class='text-center'>{{ empresas.EMPTT21_NOMBREFA }}</td>
                                    <td class='text-center'>{{ empresas.EMPTT91_EMAIL }}</td>
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
                            <div class="col-md-6">
                                <label>Código</label>
                                <input type="number"  v-model="una_empresa.EMPTT11_CODIGO" class="form-control" required="">
                            </div>
                            <div class="col-md-6">
                                <label>Razón Social</label>
                                <input type="text" v-model="una_empresa.EMPTT21_NOMBRE" class="form-control" required="">
                            </div>
                            <div class="col-md-12">
                                <label>Siglas</label>
                                <input type="text" v-model="una_empresa.EMPTT21_ABREV" class="form-control"> 
                            </div>
                            <div class="col-md-12">
                                <label>Nombre Fantasía</label>
                                <input type="text" v-model="una_empresa.EMPTT21_NOMBREFA" class="form-control" required="">
                            </div>
                            <div class="col-md-4">
                                <label>Valor Servicio</label>
                                <input type="number" v-model="una_empresa.EMPTT91_VALSERV" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label>Carg. Cliente</label>
                                <input type="number" v-model="una_empresa.EMPTT91_CARGCLIE" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label>Pago Est.</label>
                                <input type="number" v-model="una_empresa.EMPTT91_PAGOGEST" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label>Email</label>
                                <input type="text" v-model="una_empresa.EMPTT91_EMAIL" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label>Email</label>
                                <input type="text" v-model="una_empresa.EMPTT91_EMAIL2" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label>Email</label>
                                <input type="text" v-model="una_empresa.EMPTT91_EMAIL3" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label>Email</label>
                                <input type="text" v-model="una_empresa.EMPTT91_EMAIL4" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label>Email</label>
                                <input type="text" v-model="una_empresa.EMPTT91_EMAIL5" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label>Email</label>
                                <input type="text" v-model="una_empresa.EMPTT91_EMAIL6" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label>Email</label>
                                <input type="text" v-model="una_empresa.EMPTT91_EMAIL7" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label>Email</label>
                                <input type="text" v-model="una_empresa.EMPTT91_EMAIL8" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label>Email</label>
                                <input type="text" v-model="una_empresa.EMPTT91_EMAIL9" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label>Email</label>
                                <input type="text" v-model="una_empresa.EMPTT91_EMAIL10" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label>Email</label>
                                <input type="text" v-model="una_empresa.EMPTT91_EMAIL11" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label>Email</label>
                                <input type="text" v-model="una_empresa.EMPTT91_EMAIL12" class="form-control">
                            </div>
                            <div class="col-md-12">
                                <label>Frente Paquete</label>
                                <select v-model="una_empresa.FORMU_IMPRE_id" class="form-control">
                                    <option v-for="(frm,id) in formularios" v-bind:value="frm.id">{{ frm.FOIM21_NOMBRE }}</option>
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label>Alias WS Budget</label>
                                <input type="text" v-model="una_empresa.alias_ws_budget" class="form-control">
                            </div>
                            <div class="col-md-12">
                                <label>Alias WS Budget II</label>
                                <input type="text" v-model="una_empresa.alias_ws_budget2" class="form-control">
                            </div>
                            <div class="col-md-12">
                                <label>Informa WS Budget</label>
                                <select v-model="una_empresa.informa_ws_budget" class="form-control">
                                    <option value="0">NO</option>
                                    <option value="1">SI</option>
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label>Repacta el Cliente</label>
                                <select v-model="una_empresa.repacta" class="form-control">
                                    <option value="0">NO</option>
                                    <option value="1">SI</option>
                                </select>
                            </div>
                        </div>                              
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
                    <button v-on:click="StoreEmpresas" class="btn btn-danger">Guardar</button>
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
                                <input type="hidden" v-model="una_empresa.id" class="form-control" required="">
                            </div>
                            <div class="col-md-6">
                                <label>Código</label>
                                <input type="number"  v-model="una_empresa.EMPTT11_CODIGO" class="form-control" required="">
                            </div>
                            <div class="col-md-6">
                                <label>Razón Social</label>
                                <input type="text" v-model="una_empresa.EMPTT21_NOMBRE" class="form-control" required="">
                            </div>
                            <div class="col-md-12">
                                <label>Siglas</label>
                                <input type="text" v-model="una_empresa.EMPTT21_ABREV" class="form-control"> 
                            </div>
                            <div class="col-md-12">
                                <label>Nombre Fantasía</label>
                                <input type="text" v-model="una_empresa.EMPTT21_NOMBREFA" class="form-control" required="">
                            </div>
                            <div class="col-md-4">
                                <label>Valor Servicio</label>
                                <input type="number" v-model="una_empresa.EMPTT91_VALSERV" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label>Carg. Cliente</label>
                                <input type="number" v-model="una_empresa.EMPTT91_CARGCLIE" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label>Pago Est.</label>
                                <input type="number" v-model="una_empresa.EMPTT91_PAGOGEST" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label>Email</label>
                                <input type="text" v-model="una_empresa.EMPTT91_EMAIL" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label>Email</label>
                                <input type="text" v-model="una_empresa.EMPTT91_EMAIL2" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label>Email</label>
                                <input type="text" v-model="una_empresa.EMPTT91_EMAIL3" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label>Email</label>
                                <input type="text" v-model="una_empresa.EMPTT91_EMAIL4" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label>Email</label>
                                <input type="text" v-model="una_empresa.EMPTT91_EMAIL5" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label>Email</label>
                                <input type="text" v-model="una_empresa.EMPTT91_EMAIL6" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label>Email</label>
                                <input type="text" v-model="una_empresa.EMPTT91_EMAIL7" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label>Email</label>
                                <input type="text" v-model="una_empresa.EMPTT91_EMAIL8" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label>Email</label>
                                <input type="text" v-model="una_empresa.EMPTT91_EMAIL9" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label>Email</label>
                                <input type="text" v-model="una_empresa.EMPTT91_EMAIL10" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label>Email</label>
                                <input type="text" v-model="una_empresa.EMPTT91_EMAIL11" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label>Email</label>
                                <input type="text" v-model="una_empresa.EMPTT91_EMAIL12" class="form-control">
                            </div>
                            <div class="col-md-12">
                                <label>Frente Paquete</label>
                                <select v-model="una_empresa.FORMU_IMPRE_id" class="form-control">
                                    <option v-for="(frm,id) in formularios" v-bind:value="frm.id">{{ frm.FOIM21_NOMBRE }}</option>
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label>Alias WS Budget</label>
                                <input type="text" v-model="una_empresa.alias_ws_budget" class="form-control">
                            </div>
                            <div class="col-md-12">
                                <label>Alias WS Budget II</label>
                                <input type="text" v-model="una_empresa.alias_ws_budget2" class="form-control">
                            </div>
                            <div class="col-md-12">
                                <label>Informa WS Budget</label>
                                <select v-model="una_empresa.informa_ws_budget" class="form-control">
                                    <option value="0">NO</option>
                                    <option value="1">SI</option>
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label>Repacta el Cliente</label>
                                <select v-model="una_empresa.repacta" class="form-control">
                                    <option value="0">NO</option>
                                    <option value="1">SI</option>
                                </select>
                            </div>
                        </div>                              
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
                    <button v-on:click="updateEmpresas" class="btn btn-danger">Guardar</button>
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
            this.getEmpresas();                                           
            this.getFormulario();     
        },

        data() {
            return {
                titulo: "Empresas",
                info_empresas: [],
                una_empresa: [],
                formularios: [],
            }
        },        

        methods: {

            getEmpresas: function() {
                this.$http.get(URL_API_MIGRACION + 'empresas/consulta')    
                .then(function(response){
                    this.info_empresas = response.data.data;
                }) 
            },

            getFormulario: function() {
                this.$http.get(URL_API_MIGRACION + 'formularios/consulta')    
                .then(function(response){
                    this.formularios = response.data.data;
                }) 
            },
            
            abrirModalEditar : function(id){ 
                this.una_empresa = this.info_empresas[id];
                $("#modal-actualizar").modal();                                                                            
            },
            
            abrirModalNuevo : function(){
                this.una_empresa = [];
                $("#modal-nuevo").modal();
            },

            StoreEmpresas: function() {
                this.$http.post(URL_API_MIGRACION + 'empresas/guardar',{                    
                    codigo: this.una_empresa.EMPTT11_CODIGO,
                    nombre: this.una_empresa.EMPTT21_NOMBRE,
                    abreviatura: this.una_empresa.EMPTT21_ABREV,
                    nombre_fantasia: this.una_empresa.EMPTT21_NOMBREFA,
                    valor_servicio: this.una_empresa.EMPTT91_VALSERV,
                    cargclie: this.una_empresa.EMPTT91_CARGCLIE,
                    pago_estimado: this.una_empresa.EMPTT91_PAGOGEST,
                    email_1: this.una_empresa.EMPTT91_EMAIL,
                    email_2: this.una_empresa.EMPTT91_EMAIL2,
                    email_3: this.una_empresa.EMPTT91_EMAIL3,
                    email_4: this.una_empresa.EMPTT91_EMAIL4,
                    email_5: this.una_empresa.EMPTT91_EMAIL5,
                    email_6: this.una_empresa.EMPTT91_EMAIL6,
                    email_7: this.una_empresa.EMPTT91_EMAIL7,
                    email_8: this.una_empresa.EMPTT91_EMAIL8,
                    email_9: this.una_empresa.EMPTT91_EMAIL9,
                    email_10: this.una_empresa.EMPTT91_EMAIL10,
                    email_11: this.una_empresa.EMPTT91_EMAIL11,
                    email_12: this.una_empresa.EMPTT91_EMAIL12,
                    formulario_id: this.una_empresa.FORMU_IMPRE_id,
                    alias_ws_budget: this.una_empresa.alias_ws_budget,
                    alias_ws_budget2: this.una_empresa.alias_ws_budget2,
                    informa_ws_budget: this.una_empresa.informa_ws_budget,
                    repacta: this.una_empresa.repacta,
                })
                .then(function(response){
                    this.getEmpresas();
                    $("#modal-nuevo").modal("toggle");
                    showAlertaOK("Se guardo el registro con exito");
                }) 
                .catch((err) => {
                    $("#modal-nuevo").modal("toggle");
                    showAlertaERROR(err.statusText);                    
                })
            },

            updateEmpresas: function() {

                this.$http.post(URL_API_MIGRACION + 'empresas/modificar',{
                    codigo: this.una_empresa.EMPTT11_CODIGO,
                    nombre: this.una_empresa.EMPTT21_NOMBRE,
                    abreviatura: this.una_empresa.EMPTT21_ABREV,
                    nombre_fantasia: this.una_empresa.EMPTT21_NOMBREFA,
                    valor_servicio: this.una_empresa.EMPTT91_VALSERV,
                    cargclie: this.una_empresa.EMPTT91_CARGCLIE,
                    pago_estimado: this.una_empresa.EMPTT91_PAGOGEST,
                    email_1: this.una_empresa.EMPTT91_EMAIL,
                    email_2: this.una_empresa.EMPTT91_EMAIL2,
                    email_3: this.una_empresa.EMPTT91_EMAIL3,
                    email_4: this.una_empresa.EMPTT91_EMAIL4,
                    email_5: this.una_empresa.EMPTT91_EMAIL5,
                    email_6: this.una_empresa.EMPTT91_EMAIL6,
                    email_7: this.una_empresa.EMPTT91_EMAIL7,
                    email_8: this.una_empresa.EMPTT91_EMAIL8,
                    email_9: this.una_empresa.EMPTT91_EMAIL9,
                    email_10: this.una_empresa.EMPTT91_EMAIL10,
                    email_11: this.una_empresa.EMPTT91_EMAIL11,
                    email_12: this.una_empresa.EMPTT91_EMAIL12,
                    formulario_id: this.una_empresa.FORMU_IMPRE_id,
                    alias_ws_budget: this.una_empresa.alias_ws_budget,
                    alias_ws_budget2: this.una_empresa.alias_ws_budget2,
                    repacta: this.una_empresa.repacta,
                    informa_ws_budget: this.una_empresa.informa_ws_budget,
                    id: this.una_empresa.id,                    
                })
                .then(function(response){
                    this.getEmpresas();
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