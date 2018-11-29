<div class="content-wrapper" id="app">
    <section class="content-header">
        <h1>Track & Trace - ABM Cuadrantes</h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li class="active">Track & Trace - ABM Cuadrantes</li>
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
                        <a href="#" class="btn btn-success pull-right" @click="abrirModal()">
                            Nuevo
                        </a>
                    </div>            
                    <div class="box-body table-responsive">         
                        <table class="table table-striped table-condensed" id="tabla" cellspacing="0" width="100%">
                            <thead>
                                <tr>       
                                    <th class='text-center'>Clave</th>
                                    <th class='text-center'>Descripcion</th>                  
                                    <th class='text-center'>Latitud</th>
                                    <th class='text-center'>Longitud</th>
                                    <th class='text-center'>Latitud</th>
                                    <th class='text-center'>Longitud</th>
                                    <th class='text-center'></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(cuadrantes,id) in info_cuadrantes">
                                    <td class='text-center'>{{ cuadrantes.CUAD11_CLAVE }}</td>
                                    <td class='text-center'>{{ cuadrantes.CUAD21_DESCRI }}</td>
                                    <td class='text-center'>{{ cuadrantes.CUAD91_LATI1 }}</td>
                                    <td class='text-center'>{{ cuadrantes.CUAD91_LONGI1 }}</td>
                                    <td class='text-center'>{{ cuadrantes.CUAD91_LATI2 }}</td>
                                    <td class='text-center'>{{ cuadrantes.CUAD91_LONGI2 }}</td>
                                    <td class='text-center'>
                                        <a href='#' class='btn btn-primary btn-xs' v-on:click="abrirModal(id)" >
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

    <div class="modal fade" id="modal-abm" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">          
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                    <h4 class="modal-title">{{ titulo_modal }}</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-6">
                                <label>Clave</label>
                                <input type="text"  v-model="un_cuadrante.CUAD11_CLAVE" class="form-control" required="">
                            </div>
                            <div class="col-md-6">
                                <label>Descripción</label>
                                <input type="text" v-model="un_cuadrante.CUAD21_DESCRI" class="form-control" required="">
                            </div>
                            <div class="col-md-12">
                                <label>Plaza</label>
                                <select v-model="un_cuadrante.CORDITT_id" class="form-control">
                                    <option v-for="(coor,id) in coordinadores" v-bind:value="coor.id">{{ coor.CORDI11_ALIAS }}</option>
                                </select>
                            </div>
                            <div class="col-md-12">
                                <br>
                                <div id="map-canvas" style="width: 100%; height: 500px;"></div>
                            </div>
                        </div>                              
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
                    <button v-on:click="StoreCuadrantes" class="btn btn-danger">Guardar</button>
                </div>            
            </div>
        </div>
    </div>
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

<script>
    var g_lat1 = null;
    var g_lat2 = null;
    var g_lng1 = null;
    var g_lng2 = null;
</script>

<script type="text/javascript"> 
    new Vue(
    {
        el: '#app',
        
        created: function() {                                             
            this.getCuadrantes();
            this.getCoordinadores();            
        },

        data: function() {
            return {
                titulo: "Cuadrantes",
                titulo_modal: "",
                info_cuadrantes: [],
                un_cuadrante: [],
                coordinadores: [],
            }
        },        

        methods: {

            getCuadrantes: function() {
                this.$http.get(URL_API_MIGRACION + 'cuadrantes/consulta?coordinador_id='+USER)    
                .then(function(response){
                    this.info_cuadrantes = response.data.data;
                }) 
            },

            getCoordinadores: function() {
                this.$http.get(URL_API_MIGRACION + 'coordinadores/consulta')    
                .then(function(response){
                    this.coordinadores = response.data.data;
                }) 
            },
            
            abrirModal : function(id){

                if(id==undefined){
                    this.titulo_modal = "Nuevo Cuadrante";
                    this.un_cuadrante = [];
                    g_lat1 = -32.94071;
                    g_lng1 = -60.6709244;
                    g_lat2 = -32.9446716;                    
                    g_lng2 = -60.6654312;                     
                }
                else{
                    this.un_cuadrante = this.info_cuadrantes[id]; 
                    this.titulo_modal = "Editar Cuadrante";     

                    g_lat1 = parseFloat(this.un_cuadrante.CUAD91_LATI1);
                    g_lng1 = parseFloat(this.un_cuadrante.CUAD91_LONGI1);
                    g_lat2 = parseFloat(this.un_cuadrante.CUAD91_LATI2);
                    g_lng2 = parseFloat(this.un_cuadrante.CUAD91_LONGI2);                                    
                }                

                initMap("map-canvas"); 
                $("#modal-abm").modal();
            },

            StoreCuadrantes: function() {

                if(this.un_cuadrante.id==undefined)
                    api='cuadrantes/guardar';
                else
                    api='cuadrantes/modificar';                  

                this.$http.post(URL_API_MIGRACION + api,{                    
                    clave: this.un_cuadrante.CUAD11_CLAVE,
                    descripcion: this.un_cuadrante.CUAD21_DESCRI,
                    latitud1: g_lat1,
                    longitud1: g_lng1,
                    latitud2: g_lat2,
                    longitud2: g_lng2,
                    fecha_alta: this.un_cuadrante.CUAD91_FECALT,
                    alias_coordinador: this.un_cuadrante.CUAD91_COOALIAS,
                    coordinador_id: this.un_cuadrante.CORDITT_id,
                    id: this.un_cuadrante.id                
                })
                .then(function(response){
                    this.getCuadrantes();
                    $("#modal-abm").modal("toggle");
                    showAlertaOK("Se guardo el registro con exito");
                }) 
                .catch((err) => {
                    $("#modal-abm").modal("toggle");
                    showAlertaERROR(err.statusText);                    
                })
            },
        },
 
    })
</script>

<script type="text/javascript"> 

    var g_map = null;
    var g_marker1 = null;
    var g_marker2 = null;
    var g_rectangle = null;
 
    function initMap(id_mapa) {

        g_map = new google.maps.Map(document.getElementById(id_mapa), {
            center: {
                lat: ((g_lat1 + g_lat2) / 2),
                lng: ((g_lng1 + g_lng2) / 2)
            },
            zoom: 12
        });

        g_marker1 = new google.maps.Marker({
            position: {
                lat: g_lat1,
                lng: g_lng1,
            },
            map: g_map,
            draggable: true
        });

        g_marker2 = new google.maps.Marker({
            position: {
                lat: g_lat2,
                lng: g_lng2,
            },
            map: g_map,
            draggable: true,
        });      
        
        dibujarRectangulo(g_lat1, g_lng1, g_lat2, g_lng2); 

        google.maps.event.addListener(g_marker1, 'dragend', function(evt){                    
            g_lat1 = evt.latLng.lat();
            g_lng1 = evt.latLng.lng();
            
            g_rectangle.setMap(null);

            dibujarRectangulo(  evt.latLng.lat(), 
                                evt.latLng.lng(),
                                g_lat2,
                                g_lng2);      
        });

        google.maps.event.addListener(g_marker2, 'dragend', function(evt){
            g_lat2 = evt.latLng.lat();
            g_lng2 = evt.latLng.lng();
            
            g_rectangle.setMap(null);
            
            dibujarRectangulo(  g_lat1,
                                g_lng1,
                                evt.latLng.lat(), 
                                evt.latLng.lng());
        });
    }  

    function dibujarRectangulo(lat1, lng1, lat2, lng2){

        g_rectangle = new google.maps.Rectangle({
            strokeColor: '#FF0000',
            strokeOpacity: 0.8,
            strokeWeight: 2,
            fillColor: '#FF0000',
            fillOpacity: 0.35,
            map: g_map,
            bounds: new google.maps.LatLngBounds(  
                        new google.maps.LatLng(lat1, lng1),  
                        new google.maps.LatLng(lat2, lng2),
                    )  
        });   
    }

</script>