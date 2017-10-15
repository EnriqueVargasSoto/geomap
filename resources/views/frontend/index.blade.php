@extends('layouts.frontend.master')
@section('style')
    <style>
        overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 9999;
            background: rgba(255,255,255,0.7);
            border-radius: 3px;
        }
        .overlay>.fa {
            position: absolute;
            top: 50%;
            left: 50%;
            margin-left: -15px;
            margin-top: -15px;
            color: #000;
            font-size: 30px;
        }
        #mapa, #content-map {
            height: 100%;
            width: 100%;
            margin-left: 0px !important
        }
        #legend {
            padding: 10px;
            margin: 10px;
            box-shadow: rgba(0, 0, 0, 0.3) 0px 1px 4px -1px;
            border-radius: 2px;
            cursor: pointer;
            background-color: rgb(255, 255, 255);
            bottom: 14px !important;
            margin-right: 48px;
            display:none;
        }
        .show {
            position: relative;
        }
        #legend div {
            padding-top: 2px;
        }
        #legend img {
            vertical-align: middle;
        }
        .label-G{
            background-color: #00a65a !important;
        }
        .label-F{
            background-color: #b12edc !important;
        }
        .label-A{
            background-color: #dc2e4e !important;
        }
        div .collapsed-box{
            height: auto !important;
        }
        #sucursales .select2-results__option[aria-selected=true] {
            display: none;
        }
        .ui-draggable{
            cursor: pointer; cursor: hand;
        }
        .direct-chat-contacts{
            z-index: 2;
            height: 100%;
        }
        #content-cliente{
            position: relative;
        }
        .box-body{
            padding: 10px !important;
            padding-bottom: 0px !important;
            max-height: 100%;
            text-transform: capitalize;
        }
        .nav-tabs-custom{
            box-shadow: 0 0px 0px rgba(0,0,0,0.1);
        }
        li .contacts-list-img i.fa{
            display: none;
            color:white;
        }
        li.active .contacts-list-img i.fa{
            display: block;
        }
        input.form-control.half-content {
            width: 50%;
            padding-right: 2px;
            padding-left: 2px;
            text-align: center;
        }
        .row.datos{
            margin-bottom: 10px;
            text-transform: capitalize;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            text-transform: capitalize;
        }
        i.fa.fa-calendar:hover {
            color: green;
            border-color: red;
        }
        .input-group .input-group-addon:hover {
            border-color: green;
            box-shadow: 0 1px 2px 0 #00a65a, 0 1px 2px 0 #00a65a;
        }
        .contacts-list-img{
            padding-top: 6px;
            text-align: center
        }
        .contacts-list{
            padding-right: 8px;
        }
        #content-cliente .box{
            display: none;
            margin-left: 15px;
            margin-top: 15px;
        }

        /*Desktops and Laptops*/
        @media only screen and (min-width: 1224px) {
            #content-cliente{
                position: absolute;
                z-index: 9999;
            }
            #legend{
                display: block;
            }
        }
    </style>
@stop
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div id="content-map">
        <div id="overlay" class="overlay hidden"><i class="fa fa-refresh fa-spin"></i></div>
        <div id="content-cliente">
        </div>
        <div class="content-wrapper" id= "mapa"></div>
    </div>
    <div id="legend"></div>
    <!-- /.content-wrapper -->
@stop
@section('script')
    <script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA8tDfygL5CFzsEOfJpEhPYdDFzma-5P8c"></script>
    <!-- InputMask -->
    <script src="plugins/input-mask/jquery.inputmask.js"></script>
    <script src="plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
    <!-- datepicker -->
    <script src="bower_components/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
    <script src="bower_components/bootstrap-datepicker/locales/bootstrap-datepicker.es.min.js"></script>
    <!-- Select2 -->
    <script src="bower_components/select2/js/select2.min.js"></script>
    <script src="bower_components/select2/js/i18n/es.js"></script>
    <script>
        var map, markerCluster, bounds, util;
        var listaClientes = [];
        var clientesMarkers = [];
        var iconMapBase = 'images/map/';
        var timerPedidos = null;
        var fechaDefecto = '';
        var esquema;

        $(document).ready(function(){
            var centro = {lat: -11.971990, lng:  -77.062177};
            var legenda = document.getElementById('legend');

            var htmlNoPedido = '<div class="col-xs-12 "><h5>[cliente]</h5><b>Ruc: </b>[ruc]<br><b>Correo: </b>[correo]<br><b>Dirección: </b>[direccion]</div>';
            var htmlPedido = '<div class="col-xs-12 contenido"><h5>[cliente]</h5><p><b>Ruc: </b>[ruc]<br><b>Pedido N°: </b>[pedido]<br><b>Total: </b>[total]</p><p><b>Correo: </b>[correo]<br> <b>Factura: </b>[factura]<br>'+
                '<b>Hora: </b>[hora]</p><span><b>Vendedor : </b>[vendedor]</span><br><span><b>Dirección: </b>[direccion]</span></div>'+
                '<div id="[pedido]-table" class="col-xs-12 table-responsive table-content"><div id="[pedido]-overlay" class="overlay"><i class="fa fa-refresh fa-spin"></i></div></div>';
            var htmlNoVenta = '<div class="col-xs-12 contenido"><h5>[cliente]</h5><p><b>Ruc: </b>[ruc]<br><b>Pedido N°: </b>[pedido]<br><b>Total: </b>[total]</p><p><b>Correo: </b>[correo]<br> <b>Factura: </b>[factura]<br>'+
                '<b>Hora: </b>[hora]</p><span><b>Vendedor : </b>[vendedor]</span><br><span><b>Motivo : </b>[motivo]</span><br><span><b>Dirección: </b>[direccion]</span></div>';

            esquema = {
                P: '<div id="modal-[cliente]" class="box direct-chat">'+
                '<div class="box-header with-border">'+
                '<h3 class="box-title">[nombre]</h3>'+
                '<div class="box-tools pull-right">'+
                '<span id="cantidad-[cliente]" data-toggle="tooltip" class="badge bg-yellow">[cantidad]</span>'+
                '<button id="collapse-[cliente]" onclick="collapseModal([cliente])" type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>'+
                '<button type="button" class="btn btn-box-tool" data-toggle="tooltip" data-widget="chat-pane-toggle" data-original-title="Contacts"><i class="fa fa-fw fa-cubes"></i></button>'+
                '<button onclick="closeModal([cliente])" type="button" class="btn btn-box-tool" data-widget="close"><i class="fa fa-times"></i></button>'+
                '</div>'+
                '</div>'+
                '<div class="box-body">'+
                '<div class="row datos">'+
                '<div class="col-md-6"><b>Ruc: </b><span>[ruc]</span></div>'+
                '<div class="col-md-6"><b>Modulo: </b><span>[modulo]</span></div>'+
                '<div class="col-md-6"><b>Correo: </b><span>[correo]</span></div>'+
                '<div class="col-md-6"><b>Dirección: </b><span>[direccion]</span></div>'+
                '</div>'+
                '<div class="nav-tabs-custom">'+
                '<div class="direct-chat-contacts">'+
                '<ul id="nav-[cliente]" class="contacts-list">'+
                '</ul>'+
                '</div>'+
                '<div class="tab-content no-padding" id="content-tabs-[cliente]">'+
                '</div>'+
                '</div>'+
                '</div>'+
                '</div>',
                S: '<div id="modal-[cliente]" class="box direct-chat">'+
                '<div class="box-header with-border">'+
                '<h3 class="box-title">[nombre]</h3>'+
                '<div class="box-tools pull-right">'+
                '<button id="collapse-[cliente]" onclick="collapseModal([cliente])" type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>'+
                '<button onclick="closeModal([cliente])" type="button" class="btn btn-box-tool" data-widget="close"><i class="fa fa-times"></i></button>'+
                '</div>'+
                '</div>'+
                '<div class="box-body">'+
                '<div class="row datos">'+
                '<div class="col-md-6"><b>Ruc: </b><span>[ruc]</span></div>'+
                '<div class="col-md-6"><b>Modulo: </b><span>[modulo]</span></div>'+
                '<div class="col-md-6"><b>Correo: </b><span>[correo]</span></div>'+
                '<div class="col-md-6"><b>Dirección: </b><span>[direccion]</span></div>'+
                '</div>'+
                '</div>'+
                '</div>',
                T: '<div class="[class]" id="tab-[pedido]">'+
                '<div class="row datos">'+
                '<div class="col-md-6"><b>Pedido: </b><span>[pedido]</span>  <span name="estado" class="label [class-estado]">[estado]</span> </div>'+
                '<div class="col-md-6"><b>Recibo: </b><span name="factura">[factura]</span></div>'+
                '<div class="col-md-6"><b>Total: </b><span name="total">[total]</span></div>'+
                '<div class="col-md-6"><b>Fecha: </b><span name="fecha">[fecha]</span></div>'+
                '<div class="col-md-12"><b>Vendedor: </b><span name="vendedor">[vendedor]</span></div>'+
                '[motivo-no-venta]'+
                '</div>'+
                '<div class="table-responsive">'+
                '<div id="overlay-[pedido]" class="overlay"><i class="fa fa-refresh fa-spin"></i></div>'+
                '<table class="table table-striped">'+
                '<thead>' +
                '<tr> <th>Producto</th> <th>Cantidad</th> <th>Und</th> <th>Importe</th></tr>'+
                '</thead>'+
                '<tbody id="table-[pedido]">'+
                '</tbody>'+
                '</table>'+
                '</div>'+
                '</div>',
                N: '<li class="[class]">'+
                '<a href="#tab-[pedido]" data-toggle="tab" data-widget="chat-pane-toggle" aria-expanded="false">'+
                '<div class="contacts-list-img"><i class="fa fa-star-o"></i></div>'+
                '<div class="contacts-list-info">'+
                '<span class="contacts-list-name">[pedido] <small name="estado"> ( [estado] )</small> <small name="fecha" class="contacts-list-date pull-right">[fecha]</small> </span>'+
                '<span class="contacts-list-msg">[vendedor] <small name="total" class="contacts-list-date pull-right">S/ [total]</small> </span>'+
                '</div>'+
                '</a>'+
                '</li>'
            } /* onClick="mostrarUbicacion(\"[pedido]\",\"[cliente]\")"*/
            util = {
                G: { nombre: 'Visitado', img: iconMapBase + 'icon_geomarker_greenldpi.png', html: htmlPedido},
                D: { nombre: 'No visitado', img: iconMapBase + 'icon_geomarker_greyldpi.png', html: htmlNoPedido},
                A: { nombre: 'No venta', img: iconMapBase + 'icon_geomarker_redldpi.png', html: htmlNoVenta},
                F: { nombre: 'Factura', img: iconMapBase + 'icon_geomarker_purpleldpi.png', html: htmlPedido }
            };

            $('#desde').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' });
            $('#hasta').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' });

            $('#desde').datepicker({ language:'es', autoclose: true });
            $('#hasta').datepicker({ language:'es', autoclose: true });

            map = new google.maps.Map(document.getElementById('mapa'), {
                zoom: 10,
                center: centro
            });
            for (var key in util) {
                var icono = util[key]; var nombre = icono.nombre; var icono = icono.img; var div = document.createElement('div');
                div.innerHTML = '<img src="' + icono + '"> ' + nombre+'<p id="total'+key+'"><p/>';
                legend.appendChild(div);
            }
            map.controls[google.maps.ControlPosition.RIGHT_BOTTOM].push(legenda);

            // Path by google https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m
            markerCluster = new MarkerClusterer(map, null, {imagePath: iconMapBase});
            obtenerSucursales();

            $("#sucursales" ).change(function() {
                var sucursal = $(this).val();
                if(sucursal !== "x"){
                    limpiarMapa();
                    $("#rutas").empty();
                    $('#sucursales option[value="x"]').remove();
                    $("#overlay").removeClass("hidden");
                    obtenerRutas();
                    $.ajax({
                        type: "POST",
                        dataType: 'json',
                        data: { sucursal: sucursal },
                        url: "get/fecha"
                    })
                        .done(function(jsondata){
                            if($("#desde").val() == "" || $("#hasta").val() == ""){
                                fechaDefecto = jsondata;
                                $("#desde").val(jsondata);
                            }
                        })
                        .fail(function() {
                            alert( "Error al obtener las sucursales" );
                        });
                }
            });

            $("#rutas" ).change(function() {
                $("#overlay").removeClass("hidden");
                $('#rutas option[value="x"]').remove();
                limpiarMapa();
                obtenerPosicionCliente();
            });

            $('#btnFecha').click(function() {
                //limpiar pedidos
                //remover timer
                $("#overlay").removeClass("hidden");
                limpiarMapa();
                actualizarPedidos(true);
            });

            $('#checkAgrupar').change(function() {
                if($("#sucursales").val() !== "x"){
                    if(!this.checked){ markerCluster.clearMarkers(); }
                    establecerMapaClientes(map, false);
                }
            });

            $( "#centrarMapa" ).click(function() {
                if($("#sucursales").val() !== "x"){  map.fitBounds(bounds); }
            });

            $( "#refrescarMapa" ).click(function() {
                if($("#sucursales").val() !== "x"){
                    if ( timerPedidos ) {clearInterval(timerPedidos);}
                    actualizarPedidos(true);
                }
            });
        });

        function obtenerSucursales() {
            $.ajax({
                global: false,
                type: "POST",
                dataType: 'json',
                url: "get/sucursales",
                success: function(jsondata){
                    var select = $('#sucursales');

                    $.each(jsondata, function(index, element) {
                        select.append("<option value='"+ element['idSucursal'] +"'>" + element['nombre'].toLowerCase() + "</option>");
                    });
                    $('#sucursales').select2({
                        language: 'es'
                    });
                }
            });
        }

        function obtenerRutas() {
            var sucursal = $("#sucursales").val();
            $.ajax({
                global: false,
                type: "POST",
                dataType: 'json',
                data: { sucursal: sucursal },
                url: "get/rutas"
            })
                .done(function(jsondata) {
                    var select = $('#rutas');
                    select.append("<option value='x'>Ninguna</option>");
                    $.each(jsondata, function(index, element){ select.append("<option value='"+ element['idRuta'] +"'>" + element['idRuta'] + "</option>"); });
                    select.append("<option value='all'>Todas</option>");
                    $('#sucursales').select2({ language: 'es' });
                    select.prop( "disabled", false );
                })
                .fail(function() {
                    alert( "Error" );
                })
                .always(function(){
                    $("#overlay").addClass("hidden");
                });
        }

        function obtenerPosicionCliente() {
            var sucursal = $("#sucursales").val();
            var ruta = $("#rutas" ).val();
            var desde = $("#desde" ).val();
            var hasta = $("#hasta" ).val();

            $.ajax({
                type: 'POST',
                url: 'get/clientes',
                data: { sucursal: sucursal, ruta : ruta, desde : desde, hasta : hasta },
            })
            .done(function(jsondata) {

                for(var i=0; i<jsondata.length; i++){ agregarMarcadorCliente(jsondata[i]); }
                bounds = new google.maps.LatLngBounds();
                for (var i = 0; i < listaClientes.length; i++){ bounds.extend(clientesMarkers[listaClientes[i]].markerCliente.getPosition()); }
                map.fitBounds(bounds);

            })
            .fail(function() {
                alert( "Error" );
            })
            .always(function() {
                if(desde == fechaDefecto){
                    console.log("fecha actual, se inicia el timer");
                    if (timerPedidos ){ clearInterval(timerPedidos); }
                    timerPedidos = setInterval(function() { actualizarPedidos(false); }, 300 * 1000);
                }
                $("#overlay").addClass("hidden");
            });
        }

        function closeModal(cliente){
            $('#modal-'+cliente).removeClass("show");
            //Quitar las referencia de todos sus pedidos
            var lista = clientesMarkers[cliente].listaPedidos;
            console.log("length: "+lista.length);
            for(var i=0; i<lista.length; i++){
                clientesMarkers[cliente].listaPedidos[i].markerPedido.setMap(null);
                clientesMarkers[cliente].listaPedidos[i].posicionPedido.setMap(null);
            }
        }

        function collapseModal(cliente){

            if($(this).data("widget") == "extend"){
                $('#modal-'+cliente).removeClass("collapsed-box");
                $(this).data("widget", "collapse");
            }else{
                $('#modal-'+cliente).addClass("collapsed-box");
                $(this).data("widget", "extend");
            }

        }

        function agregarPedidoModal( cliente, indice){
            var htmlNav = esquema["N"];
            var tabPedido =  esquema["T"];
            var pedido = clientesMarkers[cliente].listaPedidos[indice]

            if(indice == 0){
                tabPedido = tabPedido.replace('[class]', "tab-pane active");
                htmlNav = htmlNav.replace('[class]', "active");
                //mostrar puntos en el mapa
                clientesMarkers[cliente].listaPedidos[indice].markerPedido.setMap(map);
                clientesMarkers[cliente].listaPedidos[indice].posicionPedido.setMap(map);

            }else{
                tabPedido = tabPedido.replace('[class]', "tab-pane");
                htmlNav = htmlNav.replace('[class]', "");
            }

            htmlNav = htmlNav.replace('[pedido]', pedido.numeroPedido);
            htmlNav = htmlNav.replace('[pedido]', pedido.numeroPedido);
            htmlNav = htmlNav.replace('[pedido]', pedido.numeroPedido);
            htmlNav = htmlNav.replace('[fecha]', pedido.fecha);
            htmlNav = htmlNav.replace('[estado]', pedido.estado);
            htmlNav = htmlNav.replace('[total]', pedido.importeTotal);
            htmlNav = htmlNav.replace('[vendedor]', pedido.vendedor);

            tabPedido = tabPedido.replace('[pedido]', pedido.numeroPedido);
            tabPedido = tabPedido.replace('[pedido]', pedido.numeroPedido);
            tabPedido = tabPedido.replace('[pedido]', pedido.numeroPedido);
            tabPedido = tabPedido.replace('[pedido]', pedido.numeroPedido);
            tabPedido = tabPedido.replace('[pedido]', pedido.numeroPedido);
            tabPedido = tabPedido.replace('[pedido]', pedido.numeroPedido);
            tabPedido = tabPedido.replace('[pedido]', pedido.numeroPedido);
            tabPedido = tabPedido.replace('[total]', pedido.importeTotal);
            tabPedido = tabPedido.replace('[fecha]', pedido.fecha);
            tabPedido = tabPedido.replace('[estado]', pedido.estado);
            tabPedido = tabPedido.replace('[class-estado]', "label-" + pedido.estado);
            tabPedido = tabPedido.replace('[vendedor]', pedido.vendedor);

            if(pedido.estado == 'A'){
                tabPedido = tabPedido.replace('[motivo-no-venta]', '<div class="col-md-12"> <b> Motivo no venta: </b> '+pedido.motivo+"</div>");
            }else {
                tabPedido = tabPedido.replace('[motivo-no-venta]', "");
            }

            if(pedido.estado == 'F'){
                tabPedido = tabPedido.replace('[factura]', pedido.factura);
            }else{
                tabPedido = tabPedido.replace('[factura]', "");
            }

            $("#content-tabs-"+cliente).append(tabPedido);
            $("#nav-"+cliente).append(htmlNav);

            $.ajax({
                type: "POST",
                data: { sucursal: $("#sucursales" ).val() , pedido : pedido.numeroPedido },
                dataType: 'json',
                url: "get/detallePedido",
                indexAjax: indice,
                clienteAjax: cliente,
                pedidoAjax: pedido.numeroPedido
            })
                .done(function(jsonDetallePedido) {
                    var tablaPedido = "";

                    $.each(jsonDetallePedido, function(index, item) {
                        tablaPedido += '<tr><td>'+item['descripcion']+'</td><td>'+item['cantidad']+'</td><td>'+item['unidad']+'</td><td>'+item['precioNeto']+'</td></tr>';
                    });

                    $("#table-"+this.pedidoAjax).append(tablaPedido);
                    $("#overlay-"+this.pedidoAjax).addClass('hidden');

                    clientesMarkers[this.clienteAjax].listaPedidos[this.indexAjax].ajaxPedido = true;

                })
                .fail(function() {
                    alert( "Error" );
                });

            /*
            var htmlNav = esquema["N"];
            var tabPedido =  esquema["T"];

            htmlNav = htmlNav.replace('[class]', "");
            htmlNav = htmlNav.replace('[pedido]', 'N'+pedidoNuevo.numeroPedido);
            htmlNav = htmlNav.replace('[pedido]', 'N'+pedidoNuevo.numeroPedido);
            htmlNav = htmlNav.replace('[pedido]', 'N'+pedidoNuevo.numeroPedido);
            htmlNav = htmlNav.replace('[fecha]', pedidoNuevo.fecha);
            htmlNav = htmlNav.replace('[estado]', pedidoNuevo.estado);
            htmlNav = htmlNav.replace('[total]', pedidoNuevo.importeTotal);
            htmlNav = htmlNav.replace('[vendedor]', pedidoNuevo.vendedor);

            tabPedido = tabPedido.replace('[class]', "tab-pane");
            tabPedido = tabPedido.replace('[pedido]', 'N'+pedidoNuevo.numeroPedido);
            tabPedido = tabPedido.replace('[pedido]', 'N'+pedidoNuevo.numeroPedido);
            tabPedido = tabPedido.replace('[pedido]', 'N'+pedidoNuevo.numeroPedido);

            tabPedido = tabPedido.replace('[vendedor]', pedidoNuevo.vendedor);
            tabPedido = tabPedido.replace('[pedido]', 'N'+pedidoNuevo.numeroPedido);
            tabPedido = tabPedido.replace('[pedido]', 'N'+pedidoNuevo.numeroPedido);
            tabPedido = tabPedido.replace('[pedido]', 'N'+pedidoNuevo.numeroPedido);
            tabPedido = tabPedido.replace('[pedido]', 'N'+pedidoNuevo.numeroPedido);
            tabPedido = tabPedido.replace('[total]', pedidoNuevo.importeTotal);
            tabPedido = tabPedido.replace('[fecha]', pedidoNuevo.fecha);
            tabPedido = tabPedido.replace('[estado]', pedidoNuevo.estado);
            tabPedido = tabPedido.replace('[class-estado]', "label-"+pedidoNuevo.estado);

            if(pedidoNuevo.estado == 'A'){
                tabPedido = tabPedido.replace('[motivo-no-venta]', '<div class="col-md-12"> <b> Motivo no venta: </b> '+pedidoNuevo.motivo+"</div>");
            }else {
                tabPedido = tabPedido.replace('[motivo-no-venta]', "");
            }

            if(pedidoNuevo.estado == 'F'){
                tabPedido = tabPedido.replace('[factura]', pedidoNuevo.factura);
            }else{
                tabPedido = tabPedido.replace('[factura]', "");
            }

            $.ajax({
                type: "POST",
                data: { sucursal: $("#sucursales" ).val() , pedido : pedidoNuevo.numeroPedido },
                dataType: 'json',
                url: "get/detallePedido",
                indexAjax: indice,
                clienteAjax: pedidoNuevo.idCliente,
                pedidoAjax: pedidoNuevo.numeroPedido
            })
            .done(function(jsonDetallePedido) {
                var tablaPedido = "";
                $.each(jsonDetallePedido, function(index, item) {
                    tablaPedido += '<tr><td>'+item['descripcion']+'</td><td>'+item['cantidad']+'</td><td>'+item['unidad']+'</td><td>'+item['precioNeto']+'</td></tr>';
                });
                $("#table-N"+this.pedidoAjax).append(tablaPedido);
                $("#overlay-N"+this.pedidoAjax).addClass('hidden');
                clientesMarkers[this.clienteAjax].listaPedidos[this.indexAjax].ajaxPedido = true;
            })
            .fail(function() {
                alert( "Error" );
            });

            $("#nav-"+pedidoNuevo.idCliente).append(htmlNav);
            $("#content-tabs-"+pedidoNuevo.idCliente).append(tabPedido);
*/
        }

        function actualizarModalPedido( indice, pedidoNuevo){
            var datos = {
                factura : pedidoNuevo.factura,
                total : pedidoNuevo.importeTotal,
                fecha : pedidoNuevo.fecha,
                estado : pedidoNuevo.estado,
                vendedor : pedidoNuevo.vendedor
            }
            $( "#tab-"+pedidoNuevo.numeroPedido+" span").each(function( index ) {

                $(this).html( datos[$(this).attr("name")]);
                console.log($(this).attr("name"));
            });

            $( "#nav-"+pedidoNuevo.numeroPedido+" small").each(function( index ) {

                $(this).html( datos[$(this).attr("name")]);
                console.log($(this).attr("name"));
            });

            $("#table-"+pedidoNuevo.numeroPedido).html();
            $("#overlay-"+pedidoNuevo.numeroPedido).removeClass("hidden");

            //$( "input[id][name$='man']" ).val( "only this one" );
            $.ajax({
                type: "POST",
                data: { sucursal: $("#sucursales" ).val() , pedido : pedidoNuevo.numeroPedido },
                dataType: 'json',
                url: "get/detallePedido",
                indexAjax: indice,
                clienteAjax: pedidoNuevo.idCliente,
                pedidoAjax: pedidoNuevo.numeroPedido
            })
                .done(function(jsonDetallePedido) {
                    var tablaPedido = "";

                    $.each(jsonDetallePedido, function(index, item) {
                        tablaPedido += '<tr><td>'+item['descripcion']+'</td><td>'+item['cantidad']+'</td><td>'+item['unidad']+'</td><td>'+item['precioNeto']+'</td></tr>';
                    });

                    $("#table-"+this.pedidoAjax).append(tablaPedido);
                    $("#overlay-"+this.pedidoAjax).addClass('hidden');

                    clientesMarkers[this.clienteAjax].listaPedidos[this.indexAjax].ajaxPedido = true;

                })
                .fail(function() {
                    alert( "Error" );
                });
        }

        function mostrarModalCliente(cliente){
            $( "#content-cliente .box.direct-chat.ui-draggable.ui-draggable-handle.show").each(function( index ){
                $(this).removeClass("show");
            });

            if ($('#modal-'+cliente).length <= 0) {

                if(clientesMarkers[cliente].existePedido){
                    var listaPedido = clientesMarkers[cliente].listaPedidos;
                    var htmlModal = esquema["P"];

                    htmlModal = htmlModal.replace('[cliente]', cliente );
                    htmlModal = htmlModal.replace('[nombre]', clientesMarkers[cliente].razonSocial );
                    htmlModal = htmlModal.replace('[cantidad]', listaPedido.length );
                    htmlModal = htmlModal.replace('[ruc]', clientesMarkers[cliente].rucDni );
                    htmlModal = htmlModal.replace('[modulo]', clientesMarkers[cliente].modulo );
                    htmlModal = htmlModal.replace('[correo]', clientesMarkers[cliente].correo );
                    htmlModal = htmlModal.replace('[direccion]', clientesMarkers[cliente].direccion );
                    htmlModal = htmlModal.replace('[cliente]', cliente );// ver como remplazar todo no 1x1
                    htmlModal = htmlModal.replace('[cliente]', cliente );// ver como remplazar todo no 1x1
                    htmlModal = htmlModal.replace('[cliente]', cliente );// ver como remplazar todo no 1x1
                    htmlModal = htmlModal.replace('[cliente]', cliente );// ver como remplazar todo no 1x1
                    htmlModal = htmlModal.replace('[cliente]', cliente );// ver como remplazar todo no 1x1
                    htmlModal = htmlModal.replace('[cliente]', cliente );// ver como remplazar todo no 1x1

                    $('#content-cliente').append(htmlModal);

                    for(var i=0; i<listaPedido.length; i++){
                        agregarPedidoModal(cliente, i);
                    }

                }else{
                    var htmlModal = esquema["S"];

                    htmlModal = htmlModal.replace('[cliente]', cliente );
                    htmlModal = htmlModal.replace('[nombre]', clientesMarkers[cliente].razonSocial );
                    htmlModal = htmlModal.replace('[ruc]', clientesMarkers[cliente].rucDni );
                    htmlModal = htmlModal.replace('[modulo]', clientesMarkers[cliente].modulo );
                    htmlModal = htmlModal.replace('[correo]', clientesMarkers[cliente].correo );
                    htmlModal = htmlModal.replace('[direccion]', clientesMarkers[cliente].direccion );
                    htmlModal = htmlModal.replace('[cliente]', cliente );// ver como remplazar todo no 1x1
                    htmlModal = htmlModal.replace('[cliente]', cliente );// ver como remplazar todo no 1x1
                    htmlModal = htmlModal.replace('[cliente]', cliente );// ver como remplazar todo no 1x1
                    htmlModal = htmlModal.replace('[cliente]', cliente );// ver como remplazar todo no 1x1
                    htmlModal = htmlModal.replace('[cliente]', cliente );// ver como remplazar todo no 1x1

                    $('#content-cliente').append(htmlModal);
                }

                $('#modal-'+cliente).addClass("show");
                $('#modal-'+cliente).draggable();
            }else {
                if(clientesMarkers[cliente].pedidoActualizado){}

                $('#cantidad-'+cliente).html(clientesMarkers[cliente].listaPedidos.length);
                $('#modal-'+cliente).addClass("show");
            }

        }

        function agregarMarcadorCliente(jsondata){
            var cliente = new Array();
            var nuevoPedido= new Array();
            var listaPedidos = new Array();
            var existePedido = false;
            var estado = jsondata.estado;
            var codigoCliente = jsondata.idCliente;
            var ubicacionCliente = new google.maps.LatLng(jsondata.latitudCliente, jsondata.longitudCliente);

            if(estado != "D"){

                nuevoPedido['numeroPedido'] = jsondata.numeroPedido;
                nuevoPedido['importeTotal'] = jsondata.importeTotal;
                nuevoPedido['pesoTotal'] = jsondata.pesoTotal;
                nuevoPedido['estado'] = estado;
                nuevoPedido['ajaxPedido'] = false;
                nuevoPedido['motivo'] = jsondata.descripcion==null ? '' : jsondata.descripcion.toLowerCase();
                nuevoPedido['factura'] = jsondata.serieDocumento + "-" + jsondata.numeroDocumento;
                nuevoPedido['fecha'] =  jsondata.hora;
                nuevoPedido['vendedor'] =  jsondata.vendedor.toLowerCase();

                existePedido = true;

                var latitudPedido = jsondata.latitudPedido;
                var longitudPedido = jsondata.longitudPedido;
                var ubicacionPedido = new google.maps.LatLng(latitudPedido, longitudPedido);
                var markerPedido = new google.maps.Marker({
                    position: ubicacionPedido,
                    map: null,
                    icon:  iconMapBase+"icon_geomarker_pinldpi.png",
                    draggable: false,
                    title: jsondata.vendedor
                });
                var posicionPedido = new google.maps.Polyline({
                    path: [ubicacionPedido,ubicacionCliente],
                    icons: [{icon: google.maps.SymbolPath.FORWARD_CLOSED_ARROW, offset: '100%'}],
                    zIndex: 99,
                    strokeOpacity: 0.4,
                    strokeColor: '#FF4500',
                    map: null
                });

                /*google.maps.event.addListener(map, 'click', function() {
                    posicionPedido.setMap(null);
                    markerPedido.setMap(null);
                });*/

                nuevoPedido['markerPedido'] = markerPedido;
                nuevoPedido['posicionPedido'] = posicionPedido;

                listaPedidos.push(nuevoPedido);
            }

            if(listaClientes.indexOf(codigoCliente) < 0){

                var markerCliente = new google.maps.Marker({
                    position: ubicacionCliente,
                    map: map,
                    icon: util[estado].img,
                    title: jsondata.razonSocial
                });

                listaClientes.push(codigoCliente);

                cliente['rucDni'] = jsondata.rucDni;
                cliente['correo'] = jsondata.correo;
                cliente['modulo'] = jsondata.modulo;
                cliente['existePedido'] = existePedido;
                cliente['pedidoActualizado'] = false;
                cliente['direccion'] = jsondata.direccion;
                cliente['razonSocial'] = jsondata.razonSocial;
                cliente['markerCliente'] = markerCliente;
                cliente['listaPedidos'] = listaPedidos;

                if ($('#checkAgrupar').is(':checked') ){
                    markerCluster.addMarker(markerCliente);
                }

                if(estado == "D"){
                    markerCliente.addListener('click', function() {
                        mostrarModalCliente(codigoCliente);
                    });
                }else{
                    markerCliente.addListener('click', function() {
                        /*markerPedido.setMap(map);
                        posicionPedido.setMap(map);*/
                        mostrarModalCliente(codigoCliente);
                    });
                }
                clientesMarkers[codigoCliente] = cliente;

            }else{
                clientesMarkers[codigoCliente].existePedido = existePedido;
                if(existePedido){clientesMarkers[codigoCliente].listaPedidos.push(nuevoPedido);}

                //listaPedidos = clientesMarkers[codigoCliente].listaPedidos;
            }
        }

        function obtenerPedido(cliente, numeroPedido){
            var index = -1;
            var lista = clientesMarkers[cliente].listaPedidos;
            for(var i = 0; i<lista.length; i++){
                if( lista[i].numeroPedido == numeroPedido){
                    index = i;
                    break;
                }
            }
            return index;
        }

        function actualizarPedidos(overlay){
            /**optimizar ocnsulta mandando hora actual y verificar que la fecha de creacion o la fecha de actulizacion sean igual o mayor a esa hora**/
                //verificar que se cierren los demás pedidos antes de abrir otro
            var latLngPedido;
            var sucursal = $("#sucursales" ).val();
            var desde = $("#desde" ).val();
            var hasta = $("#hasta" ).val();
            var ruta = $("#rutas" ).val();

            $.ajax({
                type: 'POST',
                url: 'get/pedido',
                data: { sucursal: sucursal, ruta : ruta, desde : desde, hasta : hasta }
            }).done(function(jsondata) {
                $.each(jsondata, function(index, item) {
                    if(clientesMarkers[item.idCliente]){
                        var indexPedido = -1;
                        if(clientesMarkers[item.idCliente].existePedido){
                            if((indexPedido = obtenerPedido(item.idCliente,item.numeroPedido)) >= 0){
                                var estado =  clientesMarkers[item.idCliente].listaPedidos[indexPedido].estado;
                                var importeTotal =  clientesMarkers[item.idCliente].listaPedidos[indexPedido].importeTotal;
                                console.log("El pedido se ha modificado (item.estado)"+ item.estado +"  (estado)"+ estado + "  (item.importeTotal)" + item.importeTotal + " (importeTotal)" + importeTotal);
                                if(!(item.estado == estado && item.importeTotal == importeTotal)){
                                    actualizarModalPedido(indexPedido, item);
                                }
                            }else{
                                var primerPedido= new Array();
                                primerPedido['numeroPedido'] = item.numeroPedido;
                                primerPedido['importeTotal'] = item.importeTotal;
                                primerPedido['pesoTotal'] = item.pesoTotal;
                                primerPedido['estado'] = item.estado;
                                primerPedido['ajaxPedido'] = false;
                                primerPedido['motivo'] = item.descripcion==null ? '' : item.descripcion.toLowerCase();
                                primerPedido['factura'] = item.serieDocumento + "-" + item.numeroDocumento;
                                primerPedido['fecha'] =  item.hora;
                                primerPedido['vendedor'] =  item.vendedor.toLowerCase();

                                //añadir punto el mapa
                                var latitudPedido = jsondata.latitudPedido;
                                var longitudPedido = jsondata.longitudPedido;
                                var ubicacionPedido = new google.maps.LatLng(latitudPedido, longitudPedido);
                                var markerPedido = new google.maps.Marker({
                                    position: ubicacionPedido,
                                    map: null,
                                    icon:  iconMapBase+"icon_geomarker_pinldpi.png",
                                    draggable: false,
                                    title: jsondata.vendedor
                                });
                                var posicionPedido = new google.maps.Polyline({
                                    path: [ubicacionPedido,ubicacionCliente],
                                    icons: [{icon: google.maps.SymbolPath.FORWARD_CLOSED_ARROW, offset: '100%'}],
                                    zIndex: 99,
                                    strokeOpacity: 0.4,
                                    strokeColor: '#FF4500',
                                    map: null
                                });

                                primerPedido['markerPedido'] = markerPedido;
                                primerPedido['posicionPedido'] = posicionPedido;


                                console.log("Nuevo pedido para el cliente");

                                clientesMarkers[item.idCliente].listaPedidos.push(primerPedido);
                                clientesMarkers[item.idCliente].pedidoActualizado = true;

                                var indice = (clientesMarkers[item.idCliente].listaPedidos.length) - 1;
                                agregarPedidoModal(item.idCliente, indice);

                                console.log("Lista de pedidos"+clientesMarkers[item.idCliente].listaPedidos.length);
                            }
                        }else{
                            //Limpiar Estructura Actual
                            $("#modal-"+item.idCliente).remove();

                            var primerPedido= new Array();
                            primerPedido['numeroPedido'] = item.numeroPedido;
                            primerPedido['importeTotal'] = item.importeTotal;
                            primerPedido['pesoTotal'] = item.pesoTotal;
                            primerPedido['estado'] = item.estado;
                            primerPedido['ajaxPedido'] = false;
                            primerPedido['motivo'] = item.descripcion==null ? '' : item.descripcion.toLowerCase();
                            primerPedido['factura'] = item.serieDocumento + "-" + item.numeroDocumento;
                            primerPedido['fecha'] =  item.hora;
                            primerPedido['vendedor'] =  item.vendedor.toLowerCase();

                            clientesMarkers[item.idCliente].listaPedidos.push(primerPedido);
                            clientesMarkers[item.idCliente].existePedido= true;
                        }

                    }else{
                        console.log("ALERTA: No existe el cliente "+item.idCliente+" en el mapa actual, refresque el mapa para obtener este nuevo cliente");
                    }
                });
            }).fail(function() {
                alert( "Error" );
            }).always(function() {
                if(overlay){ $("#overlay").addClass("hidden");}
            });
        }

        function limpiarMapa(){
            establecerMapaClientes(null);
            clientesMarkers = [];
            listaClientes = [];
            markerCluster.clearMarkers();
        }

        function establecerMapaClientes( nuevoMapa ) {
            for (var i = 0; i < listaClientes.length; i++){
                clientesMarkers[listaClientes[i]].markerCliente.setMap(nuevoMapa);

                if ($('#checkAgrupar').is(':checked') ){
                    markerCluster.addMarker( clientesMarkers[listaClientes[i]].markerCliente );
                }
            }
        }

    </script>

@stop