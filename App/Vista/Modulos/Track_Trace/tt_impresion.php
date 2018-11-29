<div class="content-wrapper" id="app">  
    <section class="content-header">
        <h1>Track & Trace - Impresión</h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li class="active">Track & Trace - Impresión</li>
        </ol>
    </section>        
    <section class="content">
        <div class="row">
            <div class="col-md-12" style="margin-top:5%;">
                <div class="col-md-2"></div>
                <div class="col-md-3">
                    <label>Fecha</label>
                    <input id="date" class="form-control" v-model="un_gestor.fecha" type="date">
                </div>
                <div class="col-md-3">
                    <label>Gestor</label>
                    <select class="form-control" v-model="un_gestor.GESTORES_id">
                        <option v-for="(gst,id) in gestores" v-bind:value="gst.id">{{ gst.GESTOR21_ALIAS }}</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label> </label>
                    <button v-on:click="getFrentePaquete" class="btn btn-success pull-right" style="position: absolute; margin-top: 25px;">Generar PDF</button>
                </div>
                <div class="col-md-12">
                    <ul>
                        <li><a v-if="link_contrato" v-bind:href="link_contrato" target="_blank">Descargar Contratos .ZIP</a></li>
                        <li><a v-if="link_frente_paquete" v-bind:href="link_frente_paquete" target="_blank">Descargar Frente de Paquetes</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
</div>

<script type="text/javascript"> 
    var URL_API_MIGRACION = '<?php echo URL_API_MIGRACION; ?>';

    var USER = '<?php echo $usuarioActivoSesion->getAliasUserSistema(); ?>';
    
    var BASE_URL = '<?php echo BASE_URL; ?>';
    var PATH_VISTA = '<?php echo PATH_VISTA; ?>';
    var URL_API_MIGRACION_BASE = '<?php echo URL_API_MIGRACION_BASE; ?>';

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
        },

        data: function() {
            return {
                gestores: [],   
                un_gestor: [],    

                link_contrato:"",
                link_frente_paquete:"",
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

            getFrentePaquete: function() {
                this.$http.post(URL_API_MIGRACION + 'gestores/frente_paquete', {
                    gestor_id: this.un_gestor.GESTORES_id,
                    fecha: this.un_gestor.fecha,  
                })
                .then(function(response){   

                    this.link_contrato = response.data.data.contrato;
                    this.link_frente_paquete = response.data.data.frente_paquete;                     
                    //url_pdf = URL_API_MIGRACION_BASE + response.data.data;                
                    //window.open(url_pdf,'_blank');
                    //console.log(this.link_frente_paquete);
                })
            },
        },
    })
</script>