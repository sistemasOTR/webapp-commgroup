<div class="content-wrapper" id="app">
    <section class="content-header">
        <h1>Track & Trace - ABM Frente Paquete</h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li class="active">Track & Trace - ABM Frente Paquete</li>
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
                                    <th class='text-center'>Referencia</th>                  
                                    <th class='text-center'>Habilitado</th>
                                    <th class='text-center'></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(formu,id) in formularios">
                                    <td class='text-center'>{{ formu.FOIM11_CODIGO }}</td>
                                    <td class='text-center'>{{ formu.FOIM21_NOMBRE }}</td>
                                    <td class='text-center'>{{ formu.FOIM91_HABILI }}</td>
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
                                <label>Referencia</label>
                                <input type="text" v-model="un_formulario.FOIM21_NOMBRE" class="form-control" required="">
                            </div>
                            <div class="col-md-6">
                                <label>Habilitado</label>
                                <select v-model="un_formulario.FOIM91_HABILI" class="form-control">
                                    <option value="S">SI</option>
                                    <option value="N">NO</option>
                                </select>
                            </div>
                            <div class="col-md-12">
                                <blockquote style="font-size:11px; border-left: 0"> 
                                    <p style="font-size:13px !important;"><b>Formato para usar variables las cuales seran reemplazadas con los datos del servicio</b></p>
                                    
                                    <div class="col-md-3" style="border-left: 5px solid #eee;">
                                        <p>[[EMPRESA]]</p>
                                        <p>[[FECHA]]</p>
                                        <p>[[NUMERO]]</p>
                                        <p>[[APEYNOM]]</p>
                                    </div>
                                    <div class="col-md-3">
                                        <p>[[DOMICILIO]]</p>
                                        <p>[[DOCUMENTO]]</p>
                                        <p>[[LOCALIDAD]]</p>
                                        <p>[[TELEFONO]]</p>
                                    </div>
                                    <div class="col-md-3">
                                        <p>[[HORARIO]]</p>
                                        <p>[[DOCUMENTACION]]</p>
                                        <p>[[OBSERVACIONES]]</p>
                                        <p>[[PRODUCTO]]</p>
                                    </div>
                                    <div class="col-md-3">
                                        <p>[[ADICIONALES]]</p>
                                        <p>[[EJECUTIVO]]</p>
                                        <p>[[COD_BARRA_1]]</p>
                                        <p>[[COD_BARRA_2]]</p>
                                    </div>
                                </blockquote>
                            </div>
                            <div class="col-md-12" style="margin-top: 20px;">
                                <label>Contenido</label>
                                <textarea id="contenido-new" class='form-control'></textarea>
                            </div>
                        </div>                              
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
                    <button v-on:click="guardarFormulario" class="btn btn-danger">Guardar</button>
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
                                <input type="hidden" v-model="un_formulario.id" class="form-control" required="">
                            </div>
                            <div class="col-md-6">
                                <label>Referencia</label>
                                <input type="text" v-model="un_formulario.FOIM21_NOMBRE" class="form-control" required="">
                            </div>
                            <div class="col-md-6">
                                <label>Habilitado</label>
                                <select v-model="un_formulario.FOIM91_HABILI" class="form-control">
                                    <option selected="true" value="S">SI</option>
                                    <option value="N">NO</option>
                                </select>
                            </div>
                            <div class="col-md-12">
                                <blockquote style="font-size:11px; border-left: 0"> 
                                    <p style="font-size:13px !important;"><b>Formato para usar variables las cuales seran reemplazadas con los datos del servicio</b></p>
                                    
                                    <div class="col-md-3" style="border-left: 5px solid #eee;">
                                        <p>[[EMPRESA]]</p>
                                        <p>[[FECHA]]</p>
                                        <p>[[NUMERO]]</p>
                                        <p>[[APEYNOM]]</p>
                                    </div>
                                    <div class="col-md-3">
                                        <p>[[DOMICILIO]]</p>
                                        <p>[[DOCUMENTO]]</p>
                                        <p>[[LOCALIDAD]]</p>
                                        <p>[[TELEFONO]]</p>
                                    </div>
                                    <div class="col-md-3">
                                        <p>[[HORARIO]]</p>
                                        <p>[[DOCUMENTACION]]</p>
                                        <p>[[OBSERVACIONES]]</p>
                                        <p>[[PRODUCTO]]</p>
                                    </div>
                                    <div class="col-md-3">
                                        <p>[[ADICIONALES]]</p>
                                        <p>[[EJECUTIVO]]</p>
                                        <p>[[COD_BARRA_1]]</p>
                                        <p>[[COD_BARRA_2]]</p>
                                    </div>
                                </blockquote>
                            </div>
                            <div class="col-md-12" style="margin-top: 20px;">
                                <label>Contenido</label>
                                <textarea id="contenido-upd" class='form-control'></textarea>
                            </div>
                        </div>                              
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
                    <button v-on:click="modificarFormulario" class="btn btn-danger">Guardar</button>
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
            this.getFormulario();     
        },

        data() {
            return {
                titulo: "Frente Paquete",
                un_formulario: [],
                formularios: [],
            }
        },        

        methods: {

            getFormulario: function() {
                this.$http.get(URL_API_MIGRACION + 'formularios/consulta')    
                .then(function(response){
                    this.formularios = response.data.data;
                }) 
            },
            
            abrirModalEditar : function(id){ 
                this.un_formulario = this.formularios[id];

                if(CKEDITOR.instances['contenido-upd'])
                    CKEDITOR.instances['contenido-upd'].destroy();

                $("#contenido-upd").empty();                             
                $("#contenido-upd").val(this.un_formulario.contenido);
                 
                CKEDITOR.replace( 'contenido-upd' );
                
                $("#modal-actualizar").modal();                                                                            
            },
            
            abrirModalNuevo : function(){
                this.un_formulario = []; 
                this.un_formulario.FOIM91_HABILI = 'S';

                if(CKEDITOR.instances['contenido-new'])
                    CKEDITOR.instances['contenido-new'].destroy();

                $("#contenido-new").empty();                             
                $("#contenido-new").val(this.un_formulario.contenido);
                
                CKEDITOR.replace( 'contenido-new' );
                           
                $("#modal-nuevo").modal();
            },

            guardarFormulario: function() {
                
                this.un_formulario.contenido = CKEDITOR.instances[ 'contenido-new' ].getData(); 

                this.$http.post(URL_API_MIGRACION + 'formularios/guardar',{
                    nombre: this.un_formulario.FOIM21_NOMBRE,
                    contenido: this.un_formulario.contenido,
                    habilitado: this.un_formulario.FOIM91_HABILI,
                })
                .then(function(response){
                    this.getFormulario();
                    $("#modal-nuevo").modal("toggle");
                    showAlertaOK("Se guardo el registro con exito");
                }) 
                .catch((err) => {
                    $("#modal-nuevo").modal("toggle");
                    showAlertaERROR(err.statusText);                    
                })
            },

            modificarFormulario: function() {               

                this.un_formulario.contenido = CKEDITOR.instances[ 'contenido-upd' ].getData(); 

                this.$http.post(URL_API_MIGRACION + 'formularios/modificar',{
                    nombre: this.un_formulario.FOIM21_NOMBRE,
                    contenido: this.un_formulario.contenido,
                    habilitado: this.un_formulario.FOIM91_HABILI,
                    id: this.un_formulario.id,                    
                })
                .then(function(response){
                    this.getFormulario();
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