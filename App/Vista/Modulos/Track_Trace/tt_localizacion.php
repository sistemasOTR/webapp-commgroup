<div class="content-wrapper" id="app">  
    <section class="content-header">
        <h1>Sincronizar Localizacion</h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li class="active">Sincronizar Localizacion</li>
        </ol>
    </section>        
    <section class="content">
        <div class="row">
            <div class="col-md-12" style="margin-top:5%;">
                <button v-on:click="ProcesaLocalizacion" type='submit' class='btn btn-primary'>Procesar</button>
            </div>
        </div>
    </section>
</div>


<script type="text/javascript"> 
    var URL_API_MIGRACION = '<?php echo URL_API_MIGRACION; ?>';
</script>

<script type="text/javascript"> 
    new Vue(
    {
        el: '#app',
        
        methods: {
            ProcesaLocalizacion: function() {                

                this.$http.post(URL_API_MIGRACION + 'appgestor/localizacion',{                    
                                 
                })
            },
        },
 
    })
</script>