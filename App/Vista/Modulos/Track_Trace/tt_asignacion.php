<div class="content-wrapper" id="app">
    <section class="content-header">
        <h1>Track & Trace - ABM Cuadrantes</h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li class="active">Track & Trace - Asignaciones</li>
        </ol>
    </section>        
    <section class="content">

        <div id="msj-success"></div>
        <div id="msj-errors"></div>

        <div class="row">
            <div class="col-md-8">
                <div class="box box-primary">         
                    <div class="box-body table-responsive">
                        <div class="col-md-12">
                            <div class="col-md-3"></div>
                            <div class="col-md-6">
                                <select class="form-control" v-model="servicios_gestor.GESTORES_id">
                                    <option v-for="(gst,id) in gestores" v-bind:value="gst.id">{{ gst.GESTOR21_ALIAS }}</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <a class="btn btn-default" onclick="asignarCuadrantes()" style="float: right;">Asignar Cuadrante y Gestor</a>
                            </div>
                        </div>
                        <div id="map-canvas" style="width: 100%; height: 500px; margin-top:40px;"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">  
                <div class="box box-primary">     
                    <div class="box-body table-responsive">
                        <div class='col-md-12 form-group'>
                            <div class="col-md-6" id='sandbox-container'>
                                <label>Fecha</label>                
                                <div class="input-daterange input-group" id="datepicker">
                                <input type="date" class="input-sm form-control" onchange="crearHref()" id="start" name="start" value="<?php echo date('Y-m-d'); ?>"/>
                                </div>  
                            </div>
                            <div class='col-md-6'>                
                                <label></label>                
                                <a class='btn btn-block btn-success' id='filtro_reporte' v-on:click='getServicios("init")'><i class='fa fa-filter'></i> Ver</a>
                            </div>
                        </div>
                        <div class="col-md-12" style="margin-top: 20px;">
                            <table class="table table-striped table-condensed" id="tabla" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th class='text-center'>Domicilio</th>
                                        <th class='text-center'>Cuadrante</th>
                                        <th class='text-center'>Gestor</th>
                                        <th class='text-center'></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(srv,id) in servicios">                     
                                        <td class='text-center'>{{ srv.SERTT91_DOMICILIO }}</td>
                                        <td class='text-center'>{{ srv.SERTT91_CUADRANTE }}</td>
                                        <td class='text-center' v-if="srv.gestores">{{ srv.gestores["GESTOR21_ALIAS"] }}</td>
                                        <td class='text-center' v-else>{{ }}</td>
                                        <td class='text-center'>
                                            <input type="checkbox" :id="'check_' + srv.id">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script type="text/javascript"> 
    var URL_API_MIGRACION = '<?php echo URL_API_MIGRACION; ?>';

    var USER = '<?php echo $usuarioActivoSesion->getAliasUserSistema(); ?>';
    //var FECHA = '<?php echo date('Y-m-d'); ?>';
    
    var BASE_URL = '<?php echo BASE_URL; ?>';
    var PATH_VISTA = '<?php echo PATH_VISTA; ?>';

    $(document).ready(function () {
        $("#msj-success").load(BASE_URL + PATH_VISTA + 'info_vue.html');
        $("#msj-errors").load(BASE_URL + PATH_VISTA + 'error_vue.html');
    })

    crearHref();
    function crearHref()
    {
        FECHA = $("#start").val();
    } 
</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAFIze2OonMyj3L7KKisgK-iKqss3tI7-o" type="text/javascript"></script>

<script type="text/javascript"> 
    var appVue = new Vue(
    {
        el: '#app',
        
        created: function() {                                             
            this.getCuadrantes();                                      
            this.getServicios("init");                                      
            this.getGestores();
            this.getCoordinadores();
        },

        data: function() {
            return {
                cuadrantes: [],
                servicios: [],
                gestores: [],
                coordinadores: [],    
                servicios_gestor: [],            
            }
        },        

        methods: {

            getCuadrantes: function() {
                this.$http.get(URL_API_MIGRACION + 'cuadrantes/consulta?coordinador_id='+USER)    
                .then(function(response){
                    this.cuadrantes = response.data.data;
                    cuadrantes_tmp = this.cuadrantes;

                    for (var x = 0; x < this.cuadrantes.length; x++) {

                        if(x == 0){
                            lat_init = parseFloat(this.cuadrantes[x]["CUAD91_LATI1"]);
                            lng_init = parseFloat(this.cuadrantes[x]["CUAD91_LONGI1"]);
                            initMap(lat_init, lng_init);
                        }   

                        value = this.cuadrantes[x];

                        g_lat1=value["CUAD91_LATI1"];
                        g_lat2=value["CUAD91_LATI2"];
                        g_lng1=value["CUAD91_LONGI1"];
                        g_lng2=value["CUAD91_LONGI2"];  

                        dibujarRectangulo(g_lat1, g_lng1, g_lat2, g_lng2);
                    }
                }) 
            },

            getCoordinadores: function() {
                this.$http.get(URL_API_MIGRACION + 'coordinadores/consulta')    
                .then(function(response){
                    this.coordinadores = response.data.data;
                }) 
            },

            getGestores: function() {
                this.$http.get(URL_API_MIGRACION + 'gestores/consulta?coordinador_id='+USER)
                .then(function(response){
                    this.gestores = response.data.data;
                }) 
                .catch((err) => {
                    showAlertaERROR(err.statusText);                    
                })
            },

            getServicios: function(tipo_metodo) {
                this.$http.get(URL_API_MIGRACION + 'servicios/serviciosByCoordinador?coordinador_id='+USER+'&fecha='+FECHA)    
                .then(function(response){
                    this.servicios = null;
                    this.servicios = response.data.data;                    

                    for (var x = 0; x < this.servicios.length; x++) {
                        
                        id=this.servicios[x]["id"];
                        lat=this.servicios[x]["latitud"];
                        lng=this.servicios[x]["longitud"];
                        domicilio=this.servicios[x]["SERTT91_DOMICILIO"];
                        
                        /*if(tipo_metodo=="update"){
                            setNullAnimationMarker(id);
                        }*/
                        
                        if(tipo_metodo=="init"){
                            mostrarMarker(id,lat,lng,domicilio);
                        }                        
                    }
                }) 
            },

            storeGestor: function() {              
                for (var x = 0; x < this.servicios.length; x++) {                    
                    //marker.splice(this.servicios[x]["id"]);

                    //marker[this.servicios[x]["id"]].splice();

                    if($("#check_"+this.servicios[x]["id"]).is(":checked") == true){                        
                        this.$http.post(URL_API_MIGRACION + 'servicios/storeGestor',{
                            gestor: this.servicios_gestor.GESTORES_id,
                            id: this.servicios[x]["id"]
                        })
                        .then(function(response){
                            showAlertaOK("Se guardo el registro con exito");
                            this.getServicios("update");
                        }) 
                        .catch((err) => {
                            showAlertaERROR(err.statusText);                    
                        })

                        setNullAnimationMarker(this.servicios[x]["id"]);
                        //marker.slice(this.servicios[x]["id"],1);
                        $('#check_' + this.servicios[x]["id"]).prop( "checked", false );
                        $('#check_' + this.servicios[x]["id"]).closest('tr').css("background-color", "");
                    }
                }
            },

            storeUbicacion: function(id, cuadrante, latitud, longitud) {

                this.$http.post(URL_API_MIGRACION + 'servicios/storeUbicacion',{
                    cuadrante: cuadrante,
                    latitud: latitud,
                    longitud: longitud,
                    id: id
                })
                .then(function(response){
                    showAlertaOK("Se guardo el registro con exito");
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
    //var lat_coord = -32.3298979;
    //var lng_coord = -63.2715422;
    var marker = [];
    var cuadrantes_tmp = [];
    var markers_edit = [];
    var existe = 0;

    function initMap(lat, lng) {

        maps = new google.maps.Map(document.getElementById("map-canvas"), {
            center: {
                lat: lat,
                lng: lng
            },
            zoom: 12
        });
    }  

    function dibujarRectangulo(lat1, lng1, lat2, lng2){

        var color = '#'+(Math.random()*0xFFFFFF<<0).toString(16);

        g_rectangle = new google.maps.Rectangle({
            strokeColor: color,
            strokeOpacity: 0.8,
            strokeWeight: 2,
            fillColor: color,
            fillOpacity: 0.35,
            map: maps,
            bounds: new google.maps.LatLngBounds(  
                        new google.maps.LatLng(lat1, lng1),  
                        new google.maps.LatLng(lat2, lng2),
                    )  
        });   
    }    

    function mostrarMarker(id_marker, lat_marker, lng_marker, domicilio_marker){
        marker[id_marker] = new google.maps.Marker({
            position: new google.maps.LatLng(lat_marker, lng_marker),
            map: maps,
            draggable: true,
            title: domicilio_marker + '[' + id_marker + ']'
        });
        
        google.maps.event.addListener(marker[id_marker], 'click', function () {
            if (event.ctrlKey) {
                if (markers_edit.length > 0) {                    
                    $.each( markers_edit, function( id, value ){
                        if(value == undefined){
                            markers_edit.splice(id_marker);
                        }
                        if( id != id_marker) {
                            existe = 1;
                        }
                        else {
                            existe = 0;
                        }
                    });
                    
                    if (existe == 1) {
                        marker[id_marker].setAnimation(google.maps.Animation.BOUNCE);
                        markers_edit[id_marker] = marker[id_marker];

                        $('#check_' + id_marker).prop( "checked", true );
                        $('#check_' + id_marker).closest('tr').css("background-color", "#a0dca5");
                    }
                    else if (existe == 0) {
                        marker[id_marker].setAnimation(null);
                        markers_edit.splice(id_marker);

                        $('#check_' + id_marker).prop( "checked", false );
                        $('#check_' + id_marker).closest('tr').css("background-color", "");
                    }
                }
                else {
                    marker[id_marker].setAnimation(google.maps.Animation.BOUNCE);
                    markers_edit[id_marker] = marker[id_marker];

                    $('#check_' + id_marker).prop( "checked", true );
                    $('#check_' + id_marker).closest('tr').css("background-color", "#a0dca5");
                }
            }
        });
    }

    function asignarCuadrantes(){
        $.each( marker, function( id, value ){
            if( value != undefined){
        
                latitud_srv = value.getPosition().lat().toFixed(8);
                longitud_srv = value.getPosition().lng().toFixed(8);

                for (var x = 0; x < cuadrantes_tmp.length; x++) {
                    
                    latitud_1 = parseFloat(cuadrantes_tmp[x]["CUAD91_LATI1"]).toFixed(8);
                    latitud_2 = parseFloat(cuadrantes_tmp[x]["[CUAD91_LATI2]"]).toFixed(8);
                    longitud_1 = parseFloat(cuadrantes_tmp[x]["CUAD91_LONGI1"]).toFixed(8);
                    longitud_2 = parseFloat(cuadrantes_tmp[x]["CUAD91_LONGI2"]).toFixed(8);

                    if( latitud_srv >= latitud_1 &&
                        latitud_srv <= latitud_2 &&
                        longitud_srv <= longitud_1 && 
                        longitud_srv >= longitud_2 ){
                            
                        appVue.storeUbicacion(id, cuadrantes_tmp[x]["id"], latitud_srv, longitud_srv);
                        
                    }
                }
            }                
        }); 

        appVue.storeGestor();        
    }
    
    function setNullAnimationMarker(id_marker){
        marker[id_marker].setAnimation(null);
    }
</script>