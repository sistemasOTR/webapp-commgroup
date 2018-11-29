<div class="content-wrapper" id="app">
    <section class="content-header">
        <h1>Track & Trace - ABM Estados</h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li class="active">Track & Trace - ABM Estados</li>
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
                                    <th class='text-center'>Estados</th>
                                    <th class='text-center'>Habilitado App</th>
                                    <!--<th class='text-center'>Fideliza App</th>-->
                                    <th class='text-center'></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(est,id) in estados">
                                    <td class='text-center'>{{ est.nombre }}</td>
                                    <td class='text-center' v-if="est.habilitado_app == 0">
                                        NO
                                    </td>
                                    <td class='text-center' v-else>
                                        SI
                                    </td>
                                    <!--<td class='text-center' v-if="est.fideliza_app == 0">
                                        NO
                                    </td>
                                    <td class='text-center' v-else>
                                        SI
                                    </td>-->
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
                    <h4 class="modal-title">{{ un_estado.nombre }}</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-12">
                                <label>Habilitado App</label>
                                <select v-model="un_estado.habilitado_app" class="form-control">
                                    <option value="0">NO</option>
                                    <option value="1">SI</option>
                                </select>
                            </div> 
                            <!--<div class="col-md-12">
                                <label>Fideliza App</label>
                                <select v-model="un_estado.fideliza_app" class="form-control">
                                    <option value="0">NO</option>
                                    <option value="1">SI</option>
                                </select>
                            </div>-->
                        </div>                              
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
                    <button v-on:click="updateEstado" class="btn btn-danger">Guardar</button>
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
            this.getEstados();
        },

        data() {
            return {
                titulo: "Estados",
                estados: [],
                un_estado: [],
            }
        },        

        methods: {

            getEstados: function() {
                this.$http.get(URL_API_MIGRACION + 'estados/consulta')
                .then(function(response){
                    this.estados = response.data.data;
                }) 
            },
            
            abrirModalEditar : function(id){ 
                this.un_estado = this.estados[id];
                $("#modal-actualizar").modal();                                                                            
            },

            updateEstado: function() {

                this.$http.post(URL_API_MIGRACION + 'estados/habilita_app',{
                    habilitado_app: this.un_estado.habilitado_app,
                    //fideliza_app: this.un_estado.fideliza_app,
                    id: this.un_estado.id,
                })
                .then(function(response){
                    this.getEstados();
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