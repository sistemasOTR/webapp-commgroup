<div class="content-wrapper" id="app">  
    <section class="content-header">
        <h1>Track & Trace - Trackeo</h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li class="active">Track & Trace - Trackeo</li>
        </ol>
    </section>        
    <section class="content">
        <div class="row">
            <div class="col-md-12">
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
                    <button v-on:click="getRecorrido" class="btn btn-success pull-right" style="position: absolute; margin-top: 25px;">Imprimir</button>
                </div>
                <div class="col-md-2"></div>
            </div>
            <div class="col-md-12">
                <div id="map-canvas" style="width: 100%; height: 500px; margin-top:40px;"></div>
            </div>
        </div>
    </section>
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

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAFIze2OonMyj3L7KKisgK-iKqss3tI7-o" type="text/javascript"></script>

<script type="text/javascript"> 
    var appVue = new Vue(
    {
        el: '#app',
        
        created: function() {                                    
            this.getGestores();
            this.getRecorrido("init");
        },

        data: function() {
            return {
                gestores: [],   
                un_gestor: [],
                recorrido: [],
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

            getRecorrido: function(tipo_metodo) {
                this.$http.get(URL_API_MIGRACION + 'recorrido/gestor?gestor_id='+this.un_gestor.GESTORES_id+'&fecha='+this.un_gestor.fecha)
                .then(function(response){
                    this.recorrido = response.data.data;

                    for (var x = 0; x < this.recorrido.length; x++) {

                        if(x == 0) {
                            initMap(parseFloat(this.recorrido[x]["SEGGB91_LATI"]), parseFloat(this.recorrido[x]["SEGGB91_LONGI"]));
                        }

                        id=this.recorrido[x]["id"];
                        lat=this.recorrido[x]["SEGGB91_LATI"];
                        lng=this.recorrido[x]["SEGGB91_LONGI"];
                        domicilio=this.recorrido[x]["SEGGB91_LATI"]+' - '+this.recorrido[x]["SEGGB91_LONGI"];
                        
                        mostrarMarker(id,lat,lng,domicilio);
                    }
                })
                .catch((err) => {
                    showAlertaERROR(err.statusText);                    
                })
            },
        },
    })
</script>

<script>
    var maps=null;
    var marker = [];

    function initMap(lat, lng) {

        maps = new google.maps.Map(document.getElementById("map-canvas"), {
            center: {
                lat: lat,
                lng: lng
            },
            zoom: 15
        });
    }

    function mostrarMarker(id_marker, lat_marker, lng_marker, domicilio_marker){
        marker[id_marker] = new google.maps.Marker({
            position: new google.maps.LatLng(lat_marker, lng_marker),
            map: maps,
            draggable: false,
            title: domicilio_marker + '[' + id_marker + ']'
        });
    }
</script>