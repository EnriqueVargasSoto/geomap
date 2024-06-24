@extends('layouts.frontend.master')
@section('style')
    <!-- Datatable -->
    <link rel="stylesheet" type="text/css" href="{{ url('/') }}/plugins/datatable/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="{{ url('/') }}/plugins/datatable/buttons.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="{{ url('/') }}/css/estilos.css">
@stop
@section('content')
 <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Filtros para la búsqueda </h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Zona</label>
                            <select id="zonasPreventa" class="form-control select2">
                                <option value="all">Todas</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Ruta</label>
                            <select id="rutasPreventa" class="form-control select2">
                                <option value="all">Todas</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Fecha Preventa:</label>
                            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" class="form-control pull-right" id="fechaPreventa" value="{{ Auth::user()->fecha }}" readonly>
                            </div>
                        </div>
                    </div>

                    {{--<div class="col-md-2">
                        <div class="form-group">
                            <label>Unid. Medida</label>
                            <select id="cbo_unidadMedida" class="form-control select2">
                                <option value="all">Todas</option>
                                <option value="sol">Soles</option>
                            </select>
                        </div>
                    </div>--}}
                    <div class="col-md-1">
                        <div class="form-group">
                            {{--<label>Seleccione</label>--}}
                            <br>
                            <input type="checkbox" name="chk_kg" id="chk_kg" value="1"> KG
                        </div>
                    </div>
                    <div class="col-md-3">
                        <br>
                        <div class="form-buttons">
                            <button id="btnBuscarPreventa" class="btn btn-primary"><i class="fa fa-fw fa-search"></i> Buscar</button>
                            <button id="btnLimpiarPreventa" class="btn btn-default"><i class="fa fa-fw fa-trash"></i> Limpiar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
       
        <div class="row">
            <div class="col-xs-12">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                      <li><a id="minAutoventa" href="#tab_1" data-toggle="tab" aria-expanded="false" >Autoventa</a></li>
                      <li class="active"><a id="minPreventa" href="#tab_2" data-toggle="tab" aria-expanded="false">Preventa</a></li>
                      <li><a id="minDespacho" href="#tab_3" data-toggle="tab" aria-expanded="false">Despacho</a></li>                     
                    </ul>
                    <div class="tab-content">
                      <br>
                      <div class="tab-pane" id="tab_1">
                        <table id="tableVendedores"  class="row-border hover order-column" width="100%">
                            <!--table id="example" class="row-border hover order-column responsive" cellspacing="0" width="100%"-->
                            <thead class="bg-blue">
                            <tr>
                                <th>Vendedor&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                <th>Teléfono</th>
                                <th>Zona</th>
                                <!--<th>Ruta</th>-->
                               <th>Clientes</th>
                                <th>Efectivos</th>
                                <th>C.E.%</th>
                                <th>NC</th>
                                <th>NC%</th>
                                <th>NV</th>
                                <th>NV%</th>
                                <th>Estado</th>
                                <th>Cantidad Venta</th>
                                <th>Importe Total</th>
                                {{--<th>DropPaquetes</th>--}}
                                <th>DropSoles</th>
                                <th>Visitados</th>
                                <th>Acciones</th>
                            </tr>
                            </thead>
                            <tfoot class="bg-blue footer">
                            <tr>
                                <th>Vendedor&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                <th>Teléfono</th>
                                <th>Zona</th>
                                <!--<th>Ruta</th>-->
                                <th>Clientes</th>
                                <th>Efectivos</th>
                                <th>C.E.%</th>
                                <th>NC</th>
                                <th>NC%</th>
                                <th>NV</th>
                                <th>NV%</th>
                                <th>Estado</th>
                                <th>Cantidad Venta</th>
                                <th>Importe Total</th>
                                {{--<th>DropPaquetes</th>--}}
                                <th>DropSoles</th>
                                <th>Visitados</th>
                                <th>Acciones</th>
                            </tr>
                            </tfoot>
                        </table>
                      </div>
                      <!-- /.tab-pane -->
                      <div class="tab-pane active" id="tab_2">
                         <table id="tablePreventaVendedores"  class="row-border hover order-column" width="100%">
                            <thead class="bg-purple">
                            <tr>
                                <th>Vendedor&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                <th>Teléfono</th>
                                <th>Zona</th>
                                <th>Ruta</th>
                                <th>Clientes</th>
                                <th>Efectivos</th>
                                <th>C.E.%</th>
                                <th>NC</th>
                                <th>NC%</th>
                                <th>NV</th>
                                <th>NV%</th>
                                <th>Estado</th>
                                <th>Cantidad Venta</th>
                                <th>U.M</th>
                                <th>Importe Total</th>
                                {{--<th>DropPaquetes</th>--}}
                                <th>DropSoles</th>
                                <th>Visitados</th>
                                <th>Acciones</th>
                            </tr>
                            </thead>
                            <tfoot class="bg-purple">
                            <tr>
                                <th>Vendedor&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                <th>Teléfono</th>
                                <th>Zona</th>
                                <th>Ruta</th>
                                <th>Clientes</th>
                                <th>Efectivos</th>
                                <th>C.E.%</th>
                                <th>NC</th>
                                <th>NC%</th>
                                <th>NV</th>
                                <th>NV%</th>
                                <th>Estado</th>
                                <th>Cantidad Venta</th>
                                <th>U.M</th>
                                <th>Importe Total</th>
                                {{--<th>DropPaquetes</th>--}}
                                <th>DropSoles</th>
                                <th>Visitados</th>
                                <th>Acciones</th>
                            </tr>
                            </tfoot>
                        </table>
                      </div>
                      <!-- /.tab-pane -->
                      <div class="tab-pane" id="tab_3">
                        <table id="tableDespachoVendedores"  class="row-border hover order-column" width="100%">
                            <!--table id="example" class="row-border hover order-column responsive" cellspacing="0" width="100%"-->
                            <thead class="bg-teal">
                            <tr>
                                <th>Vendedor&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                <th>Teléfono</th>
                                <th>Zona</th>
                                <!--<th>Ruta</th>-->
                                <th>Clientes</th>
                                <th>Efectivos</th>
                                <th>C.E.%</th>
                                <th>NC</th>
                                <th>NC%</th>
                                <th>NV</th>
                                <th>NV%</th>
                                <th>Estado</th>
                                <th>Cantidad Venta</th>
                                <th>Importe Total</th>
                                {{--<th>DropPaquetes</th>--}}
                                <th>DropSoles</th>
                                <th>Visitados</th>
                                <th>Acciones</th>
                            </tr>
                            </thead>
                            <tfoot class="bg-teal">
                            <tr>
                                <th>Vendedor&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                <th>Teléfono</th>
                                <th>Zona</th>
                                <!--<th>Ruta</th>-->
                                <th>Clientes</th>
                                <th>Efectivos</th>
                                <th>C.E.%</th>
                                <th>NC</th>
                                <th>NC%</th>
                                <th>NV</th>
                                <th>NV%</th>
                                <th>Estado</th>
                                <th>Cantidad Venta</th>
                                <th>Importe Total</th>
                                {{--<th>DropPaquetes</th>--}}
                                <th>DropSoles</th>
                                <th>Visitados</th>
                                <th>Acciones</th> 
                            </tr>
                            </tfoot>
                        </table>
                      </div>
                      <br>
                      <!-- /.tab-pane -->
                    </div>
                    <!-- /.tab-content -->
                </div>
            </div>
        </div>
        
    </section>

    <div id="overlay" class="overlay hidden"><i class="fa fa-refresh fa-spin"></i></div>
    <div id="modals"></div>
    <form action="{{ url('/geolocalizacionvendedor/{}') }}" id="goMap" method="POST" style="display:none">
        {{ csrf_field()}}
        <input id="zonaSubmit" name="zonaSubmit" value="all">
        <input id="rutaSubmit" name="rutaSubmit" value="all">
        <input id="fechaSubmit" name="fechaSubmit" value="all">
        <input id="vendedorSubmit" name="vendedorSubmit" value="all">
    </form>
    <form action="{{ url('/monitoreovendedores/detalle/') }}" id="goMonitoreo" target="_blank" method="POST" style="display:none">
        {{ csrf_field()}}
        <input id="monitoreoVendedor" name="monitoreoVendedor">
        <input id="monitoreoZona" name="monitoreoZona">
        <input id="monitoreoRuta" name="monitoreoRuta">
        <input id="monitoreoGuia" name="monitoreoGuia">
        <input id="monitoreoModo" name="monitoreoModo">
        <input id="monitoreoNombre" name="monitoreoNombre"> 
        <input id="monitoreoClienteProg" name="monitoreoClienteProg">       
    </form>
    <form id="formExcelInforme" target="_blank" method="POST" action="{{ url('/excel/reportePedidoVendedores') }}">
        {{ csrf_field()}}
        <input type="hidden" name="zona" id="zona">
        <input type="hidden" name="fecha" id="fecha">
        <input type="hidden" name="guia" id="guia"> 
    </form> 
</div>
@stop
@section('script')
    <!-- Datatable -->
    <script type="text/javascript" language="javascript" src="{{ url('/') }}/plugins/datatable/jquery.dataTables.min.js"></script>
    <script type="text/javascript" language="javascript" src="{{ url('/') }}/plugins/datatable/dataTables.buttons.min.js"></script>
    <script type="text/javascript" language="javascript" src="{{ url('/') }}/plugins/datatable/jszip.min.js"></script>
    <script type="text/javascript" language="javascript" src="{{ url('/') }}/plugins/datatable/pdfmake.min.js"></script>
    <script type="text/javascript" language="javascript" src="{{ url('/') }}/plugins/datatable/vfs_fonts.js"></script>
    <script type="text/javascript" language="javascript" src="{{ url('/') }}/plugins/datatable/buttons.html5.min.js"></script>
    <script type="text/javascript" language="javascript" src="{{ url('/') }}/plugins/datatable/dataTables.fixedColumns.min.js"></script>
    <script>
        var esquema;
        var timerSincronizacion;
        var timerSincronizacionPedidosActual;
        var tableVendedores;
        var tablePedidos,tableDespachoVendedores,tablePreventaVendedores; 
        var vendedores = []; 
        var listaTablasPedidos = [];
        var languageES;
        var zonaFiltro = 'all';
        var rutaFiltro = 'all';
        var fechaPreventaFiltro = $("#fechaPorDefecto").val();
        //var unidad_medida='all';
        var kg=0;

        /*if( $('#chk_kg').prop('checked') ) {
            alert('Seleccionado');
            var kg=0;
        }
        else{
            alert('NO Seleccionado');
            var kg=1;
        }*/
        
        var rutaTabla = 'ninguna';
        var guiaTabla = 'ninguna';
        var zonaTabla = 'ninguna';

        $(document).ready(function() {
            
            esquema = {
                SC: '<div class="modal fade" id="modal_numero_">'+
                    '<div class="modal-dialog modal-lg">'+
                        '<div class="modal-content">'+
                            '<div class="modal-header">'+
                                '<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>'+
                                '<h4 class="modal-title"> Vista por segmento: [vendedor]</h4>'+
                            '</div>'+
                            '<div class="modal-body">'+
                                '<div id="overlay_numero_" class="overlay hidden"><i class="fa fa-refresh fa-spin"></i></div>'+
                                '<div class="table-responsive">'+
                                    '<table id="table_numero_" class="row-border hover order-column responsive" cellspacing="0" width="100%">'+
                                        '<thead class="bg-light-blue">'+
                                            '<tr>'+
                                                '<th>Código</th>'+
                                                '<th>Clientes</th>'+
                                                '<th>Segmento</th>'+
                                                '<th>Exhibidores</th>'+
                                                '<th>Puertas</th>'+                                 
                                            '</tr>'+
                                        '</thead>'+
                                        '<tfoot class="bg-light-blue-footer">'+
                                            '<tr>'+
                                                '<th></th>'+
                                                '<th></th>'+
                                                '<th></th>'+
                                                '<th></th>'+
                                                '<th></th>'+                                    
                                            '</tr>'+
                                        '</tfoot>'+
                                    '</table>'+
                                '</div>'+
                            '</div>'+
                        '</div>'+
                    '</div>'+
                '</div>',
                M: '<div class="modal fade" id="modal_numero_">'+
                    '<div class="modal-dialog modal-lg">'+
                        '<div class="modal-content">'+
                            '<div class="modal-header">'+
                                '<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>'+
                                '<h4 class="modal-title"> Lista de Clientes: [vendedor]</h4>'+
                            '</div>'+
                            '<div class="modal-body">'+
                                '<div id="overlay_numero_" class="overlay hidden"><i class="fa fa-refresh fa-spin"></i></div>'+
                                '<div class="table-responsive">'+
                                    '<table id="table_numero_" class="row-border hover order-column responsive" cellspacing="0" width="100%">'+
                                    '<thead class="bg-light-blue">'+
                                    '<tr>'+
                                    '<th>Codigo</th>'+
                                    '<th>Cliente</th>'+
                                    '<th>Direccion</th>'+
                                    '<th>Secuencia de visita</th>'+
                                    '<th>Subgiro</th>'+
                                    '<th>N Exhibidores</th>'+
                                    '<th>N Puertas Frío</th>'+
                                    '</tr>'+
                                    '</thead>'+
                                    '<tfoot class="bg-light-blue-footer">'+
                                    '<tr>'+
                                    '<th>Codigo</th>'+
                                    '<th>Cliente</th>'+
                                    '<th>Direccion</th>'+
                                    '<th>Secuencia de visita</th>'+
                                    '<th>Subgiro</th>'+
                                    '<th>N Exhibidores</th>'+
                                    '<th>N Puertas Frío</th>'+
                                    '</tr>'+
                                    '</tfoot>'+
                                    '</table>'+
                                '</div>'+
                            '</div>'+
                        '</div>'+
                    '</div>'+
                '</div>',
                MP: '<div class="modal fade" id="modal_numero_">'+
                '<div class="modal-dialog modal-lg">'+
                '<div class="modal-content">'+
                '<div class="modal-header">'+
                '<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>'+
                '<h4 class="modal-title"> [cliente]</h4>'+
                '</div>'+
                '<div class="modal-body">'+
                '<div class="row datos"><div class="col-md-3"><b>Hora Inicio: </b><span>[hora_inicio]</span></div><div class="col-md-3"><b>Hora Fin: </b><span>[hora_fin]</span></div><div class="col-md-3"><b>Hora Actualización: </b><span>[hora_act]</span></div></div><br>'+                
                '<div id="overlay_numero_" class="overlay hidden"><i class="fa fa-refresh fa-spin"></i></div>'+
                '<div class="table-responsive">'+
                '<table id="table_numero_-[indice]" class="row-border responsive" cellspacing="0" width="100%">'+
                '<thead class="bg-green">'+
                '<tr>'+
                '<th>Codigo</th>'+
                '<th>Descripcion</th>'+
                '<th>Transaccion</th>'+
                '<th>UnidadMedida</th>'+
                '<th>Cantidad</th>'+ 
                '<th>CajasERP</th>'+
                '<th>ImporteTotal</th>'+ 
                '</tr>'+
                '</thead>'+
                '<tfoot class="bg-green-footer">'+
                '<tr>'+
                '<th>Codigo</th>'+
                '<th>Descripcion</th>'+
                '<th>Transaccion</th>'+
                '<th>UnidadMedida</th>'+
                '<th>Cantidad</th>'+ 
                '<th>CajasERP</th>'+
                '<th>ImporteTotal</th>'+ 
                '</tr>'+
                '</tfoot>'+
                '</table>'+
                '</div>'+
                '</div>'+
                '</div>'+
                '</div>'+
                '</div>'
            };

            languageES = {
                "sProcessing":     "Procesando...",
                "sLengthMenu":     "Mostrar _MENU_ registros",
                "sZeroRecords":    "No se encontraron resultados",
                "sEmptyTable":     "Ningún dato disponible en esta tabla",
                "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix":    "",
                "sSearch":         "Buscar:",
                "sUrl":            "",
                "sInfoThousands":  ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst":    "Primero",
                    "sLast":     "Último",
                    "sNext":     "Siguiente",
                    "sPrevious": "Anterior"
                },
                "oAria": {
                    "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                }
            };

            timerSincronizacion = null;
            fc_validarTimer();
             
            var fechaDefecto = '';

            tablePedidos = $('#listaPedidosTable').DataTable({
                "processing": true, 
                "scrollX": true,
                "lengthMenu":[ [5, 8, 10, 25, -1],["5", "8", "10", "25", "Todo"] ],
                "ajax": {
                    "url" : 'get/pedidosxVendedor',
                    "type": 'POST',
                    "dataSrc": '',
                    "data" : function(d){
                        if( rutaTabla != "ninguna" ){
                            return { 
                                "ruta" : rutaTabla,
                                "zona" : zonaTabla,
                                "fecha" : fechaPreventaFiltro,
                                "guia": guiaTabla,
                                "vendedor" : $("#vendedorActual").val()
                            };
                        }else{
                            return { 
                                "ruta" : rutaFiltro,
                                "zona" : zonaFiltro,
                                "fecha" : fechaPreventaFiltro,
                                "vendedor" : $("#vendedorActual").val()
                            };
                        } 
                    }
                },
                "columns": [ 
                    { data: "cliente" },
                    { data: "direccion" },
                    { data: "hora" },
                    { data: "tiempoPedido" },
                    { data: null },                    
                    { data: "fechaEntrega" },
                    { data: "cantidad" }, 
                    { data: "cajas" },
                    { data: "importeTotal" }, 
                    { data: null }
                ],
                "columnDefs": [ 
                    {
                        "targets": -1,
                        "data": null,
                        "render": function ( data, type, row, meta ) {
                            
                            var count = Object.keys(row).length;
                            if(count == 0){
                               return "0";
                            }else{
                                return '<div class="btn-group"> <a href="javascript:void(0)" class="btn btn-default btn-xs"  onClick="fc_mostrarDetallePedido(\''+row.numeroPedido+'\',\''+row.cliente+'\',\''+row.hora+'\',\''+row.hora_mod+'\',\''+row.horaFin+'\')"> <i class="fa fa-fw fa-eye"></i></a> </div>';
                            }   
                        }
                    },
                    {
                        "targets": 4,
                        "data": "hora",
                        "render": function ( data, type, row, meta ) {
                            var count = Object.keys(row).length;
                            if(count == 0){
                                return "";
                            }else {
                                /*La data tieneque estar ordenado de forma ASC de manera que se obtengan primero los pedidos mas intiguos, con el plugin del datatable se ordena de forma DESC */
                                /*Se tiene que restar la horaInicio actual - horaFin del anterior (la anterior fila tendrá el pedido que fue enviado antes del presente)
                                  Para saber el tiempo transcurrido tomaremos al menor de las horas(horaFin del anterior) como INICIO y al mayor (horaInicio actual) como FIN*/
                                  
                                var inicio = row.hora;//valor en caso ocurra un problema
                                //hora inicio actual - hora fin del anterior(esta invertido el orden asc)                           
                                var backIndex = meta.row - 1;               
                                
                                try{
                                    //No se puede obtener data de la sigueinte fila, pero si de una anterior, por lo que se pensó en esta forma.
                                    inicio = $( tablePedidos.rows( backIndex ).data())[0].horaFin; // HORA FIN DEL ANTERIOR COMO HORA MENOR
                                    
                                    if (inicio == undefined){
                                        inicio = row.hora;
                                    }
                                }catch(error){
                                    inicio = row.hora;                                      
                                }
                                                                                                    
                                var fin = row.hora;//HORA INICIO DE LA FILA COMO HORA MAYOR
                                                                
                                //Obtenemos los valores de las horas y minutos
                                var inicioHoras = parseInt(inicio.substr(0,2));
                                var inicioMinutos = parseInt(inicio.substr(3,2));                               
                                
                                var finHoras = parseInt(fin.substr(0,2));
                                var finMinutos = parseInt(fin.substr(3,2));
                                //Restamos a la HORA MAYOR (horaInicio de la fila)
                                var transcurridoMinutos = finMinutos - inicioMinutos;
                                var transcurridoHoras = finHoras - inicioHoras;
                                console.log("transcurridoMinutos:"+transcurridoMinutos+" - transcurridoHoras:"+transcurridoHoras);
                                                                
                                if (transcurridoMinutos < 0) {
                                    //Si el trascurrido es negativo,se le suma 60 para pasarlo a positivo de la siguiente hora, al hacer esto debemos descontar una hora transcurrida
                                    transcurridoHoras--;
                                    transcurridoMinutos = 60 + transcurridoMinutos;
                                }

                                var horas = transcurridoHoras.toString();
                                var minutos = transcurridoMinutos.toString();

                                if (horas.length < 2){ horas = "0"+horas; }
                                if (minutos.length < 2){ minutos = "0"+minutos;}
                                
                                //console.log(meta.row + "-->" + horas+":"+minutos);
                                return horas+":"+minutos;
                            }
                        }
                    }
                ],
                "language":  languageES,
                "order": [[ 2, "desc" ]],
                dom: 'Bfrltip',
                buttons: [
                    {
                        extend:    'excelHtml5',
                        text:      '<i class="fa fa-file-excel-o"></i>',
                        titleAttr: 'Excel'
                    },
                    {
                        extend:    'pdfHtml5',
                        text:      '<i class="fa fa-file-pdf-o"></i>',
                        titleAttr: 'PDF',
                        orientation: 'landscape',
                        pageSize: 'LEGAL'
                    }
                ],
            });
            //PREVENTA
            tablePreventaVendedores  = $('#tablePreventaVendedores').DataTable( {
                "processing": true,
                "scrollX": true, 
                dom: 'Bfrltip',
                lengthMenu:[[ 5, 10, 25, -1],[ "5", "10", "25", "Todo" ]],
                buttons: [
                    {
                        extend:    'excelHtml5',
                        text:      '<i class="fa fa-file-excel-o"></i>',
                        titleAttr: 'Excel'
                    },
                    {
                        extend:    'pdfHtml5',
                        text:      '<i class="fa fa-file-pdf-o"></i>',
                        titleAttr: 'PDF',
                        orientation: 'landscape',
                        pageSize: 'LEGAL'
                    },
                    {
                        text: '<i class="fa fa-table"></i>&nbsp;&nbsp;Resumen',
                        action: function ( e, dt, node, config ) {
                            $("#zona").val(zonaFiltro);
                            $("#fecha").val(fechaPreventaFiltro);
                            $("#guia").val('preventa');
                            //$("#unidad_medida").val(unidad_medida);
                            $("#kg").val(kg);
                            $("#formExcelInforme").submit(); 
                        }
                    }                       
                ],
                /*"fixedColumns" :{
                    leftColumns: 1
                },*/
                "ajax": {
                    "url" : 'get/obtenerResumenVentasPreventa',
                    "type": 'POST',
                    "dataSrc": '',
                    "data" : function(d){
                        return { 
                            "ruta" : rutaFiltro,
                            "zona" : zonaFiltro,
                            "fecha" : fechaPreventaFiltro,
                            "kg" : kg,
                            "vendedor": 'all'
                        };
                    }
                },
                "columnDefs": [
                    {
                        "targets": -1,
                        "data": "clientesConPedidos",
                        "render": function ( data, type, row, meta ) {
                            var count = Object.keys(row).length;

                            if(count == 0 || row.clientesConPedidos <= 0 ){
                               return "";
                            }else{
                                return '<div class="btn-group"> <a href="javascript:void(0)" class="btn btn-default btn-xs" onClick="fc_openDetalle(\''+row.nombrex+'\',\''+row.vendedorx+'\',\''+row.zona+'\',\''+row.ruta+'\',\''+row.numeroGuiax+'\',\'Preventa\','+row.clientes+')"><i class="fa fa-fw fa-eye"></i></a>'+
                                    '{!!Form::open(["url" => url("monitoreo/preventa"), "method" => "post", "target" => "_blank"])!!} <input type="hidden" name="vendedorx" value="'+row.vendedorx+'"><input name="zona" type="hidden" value="'+row.zona+'"><input name="ruta" type="hidden" value="'+row.ruta+'"><input name="guia" type="hidden" value="'+row.numeroGuiax+'"><button type="submit" class="btn btn-default btn-xs"><i class="fa fa-fw fa-map-o"></i></button> {!!Form::close()!!}'+
                                    '<a class="btn btn-default btn-xs" href="javascript:void(0)" onClick="fc_mostrarSegmentos(\''+row.nombrex+'\',\''+row.vendedorx+'\',\''+row.zona+'\',\''+row.ruta+'\')"><i class="fa fa-fw fa-tag"></i></a></div>';
                            }
                        }
                    },
                    {
                        "targets": 0,
                        "data": "nombrex",
                        "render": function ( data, type, row, meta ) {
                            
                            var count = Object.keys(row).length;
                            if(count == 0){
                                return "-";
                            }else {
                                return row.nombrex+"-"+row.vendedorx;
                            }
                        }
                    },                  
                    {
                        "targets": 1,
                        "data": "telefonox",
                        "render": function ( data, type, row, meta ) {
                            
                            var count = Object.keys(row).length;
                            if(count == 0){
                                return "";
                            }else {
                                return row.telefonox;
                            }
                        }
                    },
                    {
                        "targets": 4,
                        "data": "clientes",
                        "render": function ( data, type, row, meta ) {
                            var count = Object.keys(row).length;
                            if(count == 0){
                                return "0";
                            }else {
                                if(row.clientes > 0){
                                    return '<a href="javascript:void(0)" onClick="fc_mostrarClientes(\''+row.nombrex+'\',\''+row.vendedorx+'\',\''+row.zona+'\')">'+row.clientes+'</a>';
                                }else{
                                    return '0';
                                }
                            }
                        }
                    },
                    {
                        "targets": 6,
                        "data": "clientes",
                        "render": function ( data, type, row, meta ) {
                            var count = Object.keys(row).length;
                            if(count == 0){
                                return "";
                            }else {
                                var ce = (( row.efectivos/row.clientes) *100).toFixed(2);
                                return ce+" %" ;
                            }
                        }
                    },
                    {
                        "targets": 8,
                        "data": "clientes",
                        "render": function ( data, type, row, meta ) {
                            var count = Object.keys(row).length; 
                            if(count == 0 || row.noCompra == 0){
                                return "0%";
                            }else {
                                var nc_p = ((row.noCompra / row.clientes) *100).toFixed(2);
                                return nc_p+"%";
                            }
                        }
                    }, 
                    {
                        "targets": 9,
                        "data": "clientes",
                        "render": function ( data, type, row, meta ) {
                            var count = Object.keys(row).length;
                            if(count == 0){
                                return "";
                            }else {
                                var nv = (row.clientes - row.efectivos - row.noCompra ).toFixed(0);
                                return nv;
                            }
                        }
                    }, 
                    {
                        "targets": 10,
                        "data": "clientes",
                        "render": function ( data, type, row, meta ) {
                            var count = Object.keys(row).length;
                            if(count == 0){
                                return "";
                            }else {
                                var nv = (row.clientes - row.efectivos - row.noCompra ).toFixed(2);
                                var nv_p = ((nv / row.clientes ) *100).toFixed(2);
                                return nv_p+"%";
                            }
                        }
                    }, 
                    {
                        "targets": 14,
                        "data": "efectivos",
                        "render": function ( data, type, row, meta ) {
                            var count = Object.keys(row).length;if(count >0 && row.efectivos > 0){
                                var dropPaquetes = ( parseInt(row.cantidadVenta) / row.efectivos).toFixed(2);
                                return dropPaquetes;
                            }else {
                                return "0";
                            }
                        }
                    },
                    {
                        "targets": 15,
                        "data": "importeVentasx",
                        "render": function ( data, type, row, meta ) {
                            var count = Object.keys(row).length;
                            if(count > 0 && row.importeVentasx != ".00" && row.efectivos > 0){
                                var dropSoles =  (row.importeVentasx / row.efectivos).toFixed(2);
                                return dropSoles ;
                            }else {
                                return "0";
                            }
                        }
                    },
                    {
                        "targets": 16,
                        "data": "efectivos",
                        "defaultContent": "",
                        "render": function ( data, type, row, meta ) {
                            var count = Object.keys(row).length;
                            if(count == 0){
                                return "0%";
                            }else {
                                var visitados = ( (row.efectivos + row.noCompra) / row.clientes ).toFixed(1);
                                return visitados +"%";
                            }
                        }
                    },  

                                    
                ],
                "columns": [
                    { data: null },
                    { data: null }, 
                    { data: "zona", defaultContent: "" },
                    { data: "ruta", defaultContent: "" },   
                    { data: "clientes", defaultContent: "" },
                    { data: "efectivos", defaultContent: "" },
                    { data: null },/*CE%*/
                    { data: "noCompra", defaultContent: "" },
                    { data: null },/*NC%*/
                    { data: null },/*NV*/
                    { data: null },/*NV%*/
                    { data: "estadoVendedor", defaultContent: "" },
                    //{ data: "cantidadVenta", defaultContent: "" }, /*cantidadVenta*/
                    {
                        "targets": 6,
                        "data": "unidad_medida",
                        "render": function ( data, type, row, meta ) {
                            /*if(unidad_medida=='all')
                            {
                                return 'TODAS';
                            }
                            else if(unidad_medida=='sol')
                            {
                                return 'S/';
                            }
                            else{
                                return unidad_medida;    
                            }*/
                            if(kg==1){
                                return row.totalPesox;
                            }
                            else{
                                return row.cantidadVenta;
                            }
                        }
                    },
                    /*{
                        "targets": 17,
                        "data": "cantidadVenta",
                        "render": function ( data, type, row, meta ) {
                            if(unidad_medida=='sol')
                            {
                                return row.importeVentasx;
                            }
                            else{
                                return row.cantidadVenta;    
                            }
                        }
                    },*/
                    
                    {
                        "targets": 6,
                        "data": "unidad_medida",
                        "render": function ( data, type, row, meta ) {
                            /*if(unidad_medida=='all')
                            {
                                return 'TODAS';
                            }
                            else if(unidad_medida=='sol')
                            {
                                return 'S/';
                            }
                            else{
                                return unidad_medida;    
                            }*/
                            if(kg==1){
                                return 'KG';
                            }
                            else{
                                return 'UND';
                            }
                        }
                    },
                    { data: "importeVentasx", defaultContent: "" },
                    //{ data: null },/*DropPaquetes*/
                    { data: null },/*DropSoles*/
                    { data: null },/*Visitados*/
                    { data: null }
                ],
                "language":  languageES
            } );
             
            var counter = 1;
          
            //AUTOVENTA
            tableVendedores = $('#tableVendedores').DataTable( {
                "processing": true,
                "scrollX": true, 
                dom: 'Bfrltip',
                lengthMenu:[[ 5, 10, 25, -1],[ "5", "10", "25", "Todo" ]],
                buttons: [
                    {
                        extend:    'excelHtml5',
                        text:      '<i class="fa fa-file-excel-o"></i>',
                        titleAttr: 'Excel'
                    },
                    {
                        extend:    'pdfHtml5',
                        text:      '<i class="fa fa-file-pdf-o"></i>',
                        titleAttr: 'PDF',
                        orientation: 'landscape',
                        pageSize: 'LEGAL'
                    },
                    {
                        text: '<i class="fa fa-table"></i>&nbsp;&nbsp;Resumen',
                        action: function ( e, dt, node, config ) {
                            $("#zona").val(zonaFiltro);
                            $("#fecha").val(fechaPreventaFiltro);
                            $("#guia").val('autoventa');
                              
                            $("#formExcelInforme").submit(); 
                        }
                    }                   
                ],
                /*"scrollY": "400px",*/
                "fixedColumns" :{
                    leftColumns: 1
                    /*rightColumns: 1*/
                },
                "ajax": {
                    "url" : 'get/obtenerResumenVentasAutoventa',
                    "type": 'POST',
                    "dataSrc": '',
                    "data" : function(d){
                        return { 
                            "ruta" : rutaFiltro,
                            "zona" : zonaFiltro,
                            "fecha" : fechaPreventaFiltro,
                            "vendedor": 'all'
                        };
                    }
                },
                "columnDefs": [
                    {
                        "targets": -1,
                        "data": "vendedorx",
                        "render": function ( data, type, row, meta ) {
                            var count = Object.keys(row).length;

                             if(count == 0 || row.clientesConPedidos <= 0 ){
                               return "";
                            }else{  
                                return '<div class="btn-group"> <a href="javascript:void(0)" class="btn btn-default btn-xs" onClick="fc_openDetalle(\''+row.nombrex+'\',\''+row.vendedorx+'\',\''+row.zona+'\',\'all\',\''+row.numeroGuiax+'\',\'Autoventa\','+row.clientes+')"><i class="fa fa-fw fa-eye"></i></a>'+                                   
                                    '{!!Form::open(["url" => url("monitoreo/autoventa"), "method" => "post", "target" => "_blank"])!!} <input type="hidden" name="vendedorx" value="'+row.vendedorx+'"><input name="zona" type="hidden" value="'+row.zona+'"><input name="ruta" type="hidden" value="'+rutaFiltro+'"><input name="guia" type="hidden" value="'+row.numeroGuiax+'"><button type="submit" class="btn btn-default btn-xs"><i class="fa fa-fw fa-map-o"></i></button> {!!Form::close()!!}'+ 
                                    '<a class="btn btn-default btn-xs" href="javascript:void(0)" onClick="fc_mostrarSegmentos(\''+row.nombrex+'\',\''+row.vendedorx+'\',\''+row.zona+'\',\''+row.ruta+'\')"><i class="fa fa-fw fa-tag"></i></a></div>';                              
                            }
                        }
                    },
                    {
                        "targets": 0,
                        "data": "nombrex",
                        "render": function ( data, type, row, meta ) {
                            
                            var count = Object.keys(row).length;
                            if(count == 0){
                                return "-";
                            }else {
                                return row.nombrex+"-"+row.vendedorx;
                            }
                        }
                    },                  
                    {
                        "targets": 1,
                        "data": "telefonox",
                        "render": function ( data, type, row, meta ) {
                            
                            var count = Object.keys(row).length;
                            if(count == 0){
                                return "";
                            }else {
                                return row.telefonox;
                            }
                        }
                    }, 
                    {
                        "targets": 3,
                        "data": "clientes",
                        "render": function ( data, type, row, meta ) {
                            var count = Object.keys(row).length;
                            if(count == 0){
                                return "0";
                            }else {
                                if(row.clientes > 0){
                                    return '<a href="javascript:void(0)" onClick="fc_mostrarClientes(\''+row.nombrex+'\',\''+row.vendedorx+'\',\''+row.zona+'\')">'+row.clientes+'</a>';
                                }else{
                                    return '0';
                                }
                            }
                        }
                    },
                    {
                        "targets": 5,
                        "data": "clientes",
                        "render": function ( data, type, row, meta ) {
                            var count = Object.keys(row).length;
                            if(count == 0){
                                return "";
                            }else {
                                var ce = (( row.efectivos/row.clientes) *100).toFixed(2);
                                return ce+" %" ;
                            }
                        }
                    },
                    {
                        "targets": 7,
                        "data": "clientes",
                        "render": function ( data, type, row, meta ) {
                            var count = Object.keys(row).length; 
                            if(count == 0 || row.noCompra == 0){
                                return "0%";
                            }else {
                                var nc_p = ((row.noCompra / row.clientes) *100).toFixed(2);
                                return nc_p+"%";
                            }
                        }
                    }, 
                    {
                        "targets": 8,
                        "data": "clientes",
                        "render": function ( data, type, row, meta ) {
                            var count = Object.keys(row).length;
                            if(count == 0){
                                return "";
                            }else {
                                var nv = (row.clientes - row.efectivos - row.noCompra ).toFixed(3);
                                return nv;
                            }
                        }
                    }, 
                    {
                        "targets": 9,
                        "data": "clientes",
                        "render": function ( data, type, row, meta ) {
                            var count = Object.keys(row).length;
                            if(count == 0){
                                return "";
                            }else {
                                var nv = (row.clientes - row.efectivos - row.noCompra ).toFixed(2);
                                var nv_p = ((nv / row.clientes ) *100).toFixed(2);
                                return nv_p+"%";
                            }
                        }
                    }, 
                    {
                        "targets": 13,
                        "data": "efectivos",
                        "render": function ( data, type, row, meta ) {
                            var count = Object.keys(row).length;if(count >0 && row.efectivos > 0){
                                var dropPaquetes = ( parseInt(row.cantidadVenta) / row.efectivos).toFixed(2);
                                return dropPaquetes;
                            }else {
                                return "0";
                            }
                        }
                    },
                    {
                        "targets": 14,
                        "data": "importeVentasx",
                        "render": function ( data, type, row, meta ) {
                            var count = Object.keys(row).length;
                            if(count > 0 && row.importeVentasx != ".00" && row.efectivos > 0){
                                var dropSoles =  (row.importeVentasx / row.efectivos).toFixed(2);
                                return dropSoles ;
                            }else {
                                return "0";
                            }
                        }
                    },
                    {
                        "targets": 15,
                        "data": "efectivos",
                        "defaultContent": "",
                        "render": function ( data, type, row, meta ) {
                            var count = Object.keys(row).length;
                            if(count == 0){
                                return "0%";
                            }else {
                                var visitados = ( (row.efectivos + row.noCompra) / row.clientes ).toFixed(2);
                                return visitados ;
                            }
                        }
                    }
                ],
                "columns": [
                    { data: null },
                    { data: null }, 
                    { data: "zona", defaultContent: "" },   
                    { data: "clientes", defaultContent: "" },
                    { data: "efectivos", defaultContent: "" },
                    { data: null },/*CE%*/
                    { data: "noCompra", defaultContent: "" },
                    { data: null },/*NC%*/
                    { data: null },/*NV*/
                    { data: null },/*NV%*/
                    { data: "estadoVendedor", defaultContent: "" },
                    { data: "cantidadVenta", defaultContent: "" }, /*cantidadVenta*/
                    { data: "importeVentasx", defaultContent: "" },
                    //{ data: null },/*DropPaquetes*/
                    { data: null },/*DropSoles*/
                    { data: null },/*Visitados*/
                    { data: null }
                ],
                "language":  languageES
            } );

            tableDespachoVendedores= $('#tableDespachoVendedores').DataTable( {
                "processing": true,
                "scrollX": true, 
                dom: 'Bfrltip',
                lengthMenu:[[ 5, 10, 25, -1],[ "5", "10", "25", "Todo" ]],
                buttons: [
                    {
                        extend:    'excelHtml5',
                        text:      '<i class="fa fa-file-excel-o"></i>',
                        titleAttr: 'Excel'
                    },
                    {
                        extend:    'pdfHtml5',
                        text:      '<i class="fa fa-file-pdf-o"></i>',
                        titleAttr: 'PDF',
                        orientation: 'landscape',
                        pageSize: 'LEGAL'
                    },
                    {
                        text: '<i class="fa fa-table"></i>&nbsp;&nbsp;Resumen',
                        action: function ( e, dt, node, config ) {
                            $("#zona").val(zonaFiltro);
                            $("#fecha").val(fechaPreventaFiltro);
                            $("#guia").val('despacho');
                              
                            $("#formExcelInforme").submit(); 
                        }
                    }               
                ],
                /*"scrollY": "400px",*/
                "fixedColumns" :{
                    leftColumns: 1
                    /*rightColumns: 1*/
                },
                "ajax": {
                    "url" : 'get/obtenerResumenVentasDespacho',
                    "type": 'POST',
                    "dataSrc": '',
                    "data" : function(d){
                        return { 
                            "ruta" : rutaFiltro,
                            "zona" : zonaFiltro,
                            "fecha" : fechaPreventaFiltro,
                            "vendedor": 'all'
                        };
                    }
                },
                "columnDefs": [
                    {
                        "targets": -1,
                        "data": "vendedorx",
                        "render": function ( data, type, row, meta ) {
                            var count = Object.keys(row).length;

                            if(count == 0 || row.clientesConPedidos <= 0 ){ 
                               return "";
                            }else{                      
                                return '<div class="btn-group"> <a href="javascript:void(0)" class="btn btn-default btn-xs" onClick="fc_openDetalle(\''+row.nombrex+'\',\''+row.vendedorx+'\',\''+row.zona+'\',\'all\',\''+row.numeroGuiax+'\',\'Despacho\','+row.clientes+')"><i class="fa fa-fw fa-eye"></i></a>'+
                                '{!!Form::open(["url" => url("monitoreo/despacho"), "method" => "post", "target" => "_blank"])!!} <input type="hidden" name="vendedorx" value="'+row.vendedorx+'"><input name="zona" type="hidden" value="'+row.zona+'"><input name="ruta" type="hidden" value="'+rutaFiltro+'"><input name="guia" type="hidden" value="'+row.numeroGuiax+'"><button type="submit" class="btn btn-default btn-xs"><i class="fa fa-fw fa-map-o"></i></button> {!!Form::close()!!}'+                                    
                                '<a class="btn btn-default btn-xs" href="javascript:void(0)" onClick="fc_mostrarSegmentos(\''+row.nombrex+'\',\''+row.vendedorx+'\',\''+row.zona+'\',\'all\')"><i class="fa fa-fw fa-tag"></i></a></div>';                                                             
                            }
                        }
                    },
                    {
                        "targets": 0,
                        "data": "nombrex",
                        "render": function ( data, type, row, meta ) {
                            
                            var count = Object.keys(row).length;
                            if(count == 0){
                                return "-";
                            }else {
                                return row.nombrex+"-"+row.vendedorx;
                            }
                        }
                    },                  
                    {
                        "targets": 1,
                        "data": "telefonox",
                        "render": function ( data, type, row, meta ) {
                            
                            var count = Object.keys(row).length;
                            if(count == 0){
                                return "";
                            }else {
                                return row.telefonox;
                            }
                        }
                    },
                    {
                        "targets": 3,
                        "data": "clientes",
                        "render": function ( data, type, row, meta ) {
                            var count = Object.keys(row).length;
                            if(count == 0){
                                return "0";
                            }else {
                                if(row.clientes > 0){
                                    return '<a href="javascript:void(0)" onClick="fc_mostrarClientes(\''+row.nombrex+'\',\''+row.vendedorx+'\',\''+row.zona+'\')">'+row.clientes+'</a>';
                                }else{
                                    return '0';
                                }
                            }
                        }
                    },
                    {
                        "targets": 5,
                        "data": "clientes",
                        "render": function ( data, type, row, meta ) {
                            var count = Object.keys(row).length;
                            if(count == 0){
                                return "";
                            }else {
                                var ce = (( row.efectivos/row.clientes) *100).toFixed(2);
                                return ce+" %" ;
                            }
                        }
                    },
                    {
                        "targets": 7,
                        "data": "clientes",
                        "render": function ( data, type, row, meta ) {
                            var count = Object.keys(row).length; 
                            if(count == 0 || row.noCompra == 0){
                                return "0%";
                            }else {
                                var nc_p = ((row.noCompra / row.clientes) *100).toFixed(2);
                                return nc_p+"%";
                            }
                        }
                    }, 
                    {
                        "targets": 8,
                        "data": "clientes",
                        "render": function ( data, type, row, meta ) {
                            var count = Object.keys(row).length;
                            if(count == 0){
                                return "";
                            }else {
                                var nv = (row.clientes - row.efectivos - row.noCompra ).toFixed(3);
                                return nv;
                            }
                        }
                    }, 
                    {
                        "targets": 9,
                        "data": "clientes",
                        "render": function ( data, type, row, meta ) {
                            var count = Object.keys(row).length;
                            if(count == 0){
                                return "";
                            }else {
                                var nv = (row.clientes - row.efectivos - row.noCompra ).toFixed(2);
                                var nv_p = ((nv / row.clientes) *100).toFixed(2);
                                return nv_p+"%";
                            }
                        }
                    }, 
                    {
                        "targets": 13,
                        "data": "efectivos",
                        "render": function ( data, type, row, meta ) {
                            var count = Object.keys(row).length;if(count >0 && row.efectivos > 0){
                                var dropPaquetes = ( parseInt(row.cantidadVenta) / row.efectivos).toFixed(2);
                                return dropPaquetes;
                            }else {
                                return "0";
                            }
                        }
                    },
                    {
                        "targets": 14,
                        "data": "importeVentasx",
                        "render": function ( data, type, row, meta ) {
                            var count = Object.keys(row).length;
                            if(count > 0 && row.importeVentasx != ".00" && row.efectivos > 0){
                                var dropSoles =  (row.importeVentasx / row.efectivos).toFixed(2);
                                return dropSoles ;
                            }else {
                                return "0";
                            }
                        }
                    },
                    {
                        "targets": 15,
                        "data": "efectivos",
                        "defaultContent": "",
                        "render": function ( data, type, row, meta ) {
                            var count = Object.keys(row).length;
                            if(count == 0){
                                return "0%";
                            }else {
                                var visitados = ( (row.efectivos + row.noCompra) / row.clientes ).toFixed(2);
                                return visitados ;
                            }
                        }
                    }
                ],
                "columns": [
                    { data: null },
                    { data: null }, 
                    { data: "zona", defaultContent: "" },   
                    { data: "clientes", defaultContent: "" },
                    { data: "efectivos", defaultContent: "" },
                    { data: null },/*CE%*/
                    { data: "noCompra", defaultContent: "" },
                    { data: null },/*NC%*/
                    { data: null },/*NV*/
                    { data: null },/*NV%*/
                    { data: "estadoVendedor", defaultContent: "" },
                    { data: "cantidadVenta", defaultContent: "" }, /*cantidadVenta*/
                    { data: "importeVentasx", defaultContent: "" },
                    //{ data: null },/*DropPaquetes*/
                    { data: null },/*DropSoles*/
                    { data: null },/*Visitados*/
                    { data: null }
                ],
                "language":  languageES
            } );
            
            $("#minAutoventa").click( function() { 
                setTimeout( function(){ tableVendedores.draw(); },200 );
            });
            $("#minPreventa").click( function() {
                setTimeout( function(){ tablePreventaVendedores.draw(); },300 );
            });
            $("#minDespacho").click( function() { 
                setTimeout( function(){ tableDespachoVendedores.draw(); },400 );
            });
            
            $('#tableVendedores tbody').on( 'mouseenter', 'td', function () {
               if(typeof tableVendedores.cell(this).index() != 'undefined'){
                    var colIdx = tableVendedores.cell(this).index().column;
                    $( tableVendedores.cells().nodes() ).removeClass( 'highlight-blue' );
                    $( tableVendedores.column( colIdx ).nodes() ).addClass( 'highlight-blue' );
               }               
            });
            
            $('#tablePreventaVendedores tbody').on( 'mouseenter', 'td', function () {
               if(typeof tablePreventaVendedores.cell(this).index() != 'undefined'){
                    var colIdx = tablePreventaVendedores.cell(this).index().column;
                    $( tablePreventaVendedores.cells().nodes() ).removeClass( 'highlight-purple' );
                    $( tablePreventaVendedores.column( colIdx ).nodes() ).addClass( 'highlight-purple' );
               }               
            });
            
             $('#tableDespachoVendedores tbody').on( 'mouseenter', 'td', function () {
               if(typeof tableDespachoVendedores.cell(this).index() != 'undefined'){
                    var colIdx = tableDespachoVendedores.cell(this).index().column;
                    $( tableDespachoVendedores.cells().nodes() ).removeClass( 'highlight-cyal' );
                    $( tableDespachoVendedores.column( colIdx ).nodes() ).addClass( 'highlight-cyal' );
               }               
            });

           $('#listaPedidosTable tbody').on( 'mouseenter', 'td', function () {
               if(typeof tablePedidos.cell(this).index() != 'undefined'){
                    var colIdx = tablePedidos.cell(this).index().column;
                    $( tablePedidos.cells().nodes() ).removeClass( 'highlight-green' );
                    $( tablePedidos.column( colIdx ).nodes() ).addClass( 'highlight-green' );
               }               
           });

            /*$('#sucursales').select2({ language: 'es',  placeholder: "Ninguna" });*/
            $('#zonasPreventa').select2({ language: 'es',  placeholder: "Todas" });
            $('#rutasPreventa').select2({ language: 'es',  placeholder: "Todas" }); 
            //$('#cbo_unidadMedida').select2({ language: 'es',  placeholder: "Todas" }); 
            
            sc_obtenerZonas();
            //sc_obtenerUnidadMedida();

            $('#rutasPreventa').prop( "disabled", true );
            $('#zonasPreventa').prop( "disabled", true );

            $("#zonasPreventa").change(function() {
                fechaDefecto = '';
                var zona = $(this).val();
                if( zona !== "x"){
                    $("#overlay").removeClass("hidden"); 
                    $('#zonasPreventa option[value="x"]').remove();
                    limpiarCampos();
                    sc_obtenerRutas();

                }
            });
            $("#rutasPreventa").change(function() {
                limpiarCampos();
            });

            function limpiarCampos(){
                vendedores = [];
                listaTablasPedidos = [];
                tableListaPedidosActual = null;
                clearInterval(timerSincronizacion);
                if(timerSincronizacionPedidosActual != null){
                    clearInterval(timerSincronizacionPedidosActual);                    
                }                
                $("#modals").html("");              
                $("#nombreVendedor").html("");
                $("#vendedorActual").val("x"); 
                tablePedidos.ajax.reload( null, false );
            }
            
            $("#btnBuscarPreventa").click(function(){
                actualizarVariablesGlobales(); 
                md_obtenerResumenVendedores(); 
                limpiarCampos();
            });
            
            $("#btnLimpiarPreventa").click(function(){
                if($('#zonasPreventa').val() != 'all'){
                    $('#zonasPreventa').val('all').trigger('change.select2');
                    sc_obtenerRutas();
                }else{
                    $('#rutasPreventa').val('all').trigger('change.select2');
                } 
                zonaFiltro = "all";
                rutaFiltro = "all";
                fechaPreventaFiltro = $("#fechaPorDefecto").val();
                $("#fechaPreventa").val(fechaPreventaFiltro);
                limpiarCampos();
                md_obtenerResumenVendedores();
            });

            function actualizarVariablesGlobales(){
                zonaFiltro = $("#zonasPreventa").val();
                rutaFiltro = $("#rutasPreventa").val();
                fechaPreventaFiltro = $("#fechaPreventa").val();
                //unidad_medida = $("#cbo_unidadMedida").val();
                if( $('#chk_kg').prop('checked') ) {
                    kg=1;
                }
                else
                {
                    kg=0;
                }
                //kg=$("#chk_kg").val();
            }
                        
            function sc_obtenerZonas() {
                $("#overlay").removeClass("hidden");
                $.ajax({
                    global: false,
                    type: "POST",
                    dataType: 'json',
                    url: "get/zonas",
                    success: function(jsondata){
                        var select = $('#zonasPreventa');
                        $.each(jsondata, function(index, element) {
                            select.append("<option value='"+ element['idZona'] +"'>" + element['descripcion'].toLowerCase() + "</option>");                         
                        }); 
                        select.prop( "disabled", false );  
                        sc_obtenerRutas(); /*$("#rutasPreventa").prop( "disabled", false ); */
                        $("#overlay").addClass("hidden");
                    }
                });
            }
            /*function sc_obtenerUnidadMedida(){
                $("#overlay").removeClass("hidden");
                $.ajax({
                    global: false,
                    type: "POST",
                    dataType: 'json',
                    url: "get/unidad_medida",
                    success: function(jsondata){
                        var select = $('#cbo_unidadMedida');
                        $.each(jsondata, function(index, element) {
                            select.append("<option value='"+ element['idUnidadMedida'] +"'>" + element['descripcion'].toLowerCase() + "</option>");                         
                        });
                    }
                });
            }*/
                        
            $("#menuButton").click(function(){  
                setTimeout('resizeTable()',320); 
            });

            function sc_obtenerRutas() {
                $("#overlay").removeClass("hidden");
                $("#rutasPreventa").empty();
                var zona = $("#zonasPreventa").val();
                $.ajax({
                    global: false,
                    type: "POST",
                    dataType: 'json',
                    data: { "zona": zona },
                    url: "get/rutas"
                })
                .done(function(jsondata) {
                    var select = $("#rutasPreventa");
                    select.append("<option value='all'>Todas</option>");
                    $.each(jsondata, function(index, element){
                        select.append("<option value='"+ element['idRuta'] +"'>" + element['descripcion'].toLowerCase()  + "</option>"); 
                    }); 
                    select.prop( "disabled", false ); 
                    $("#overlay").addClass("hidden"); 
                })
                .fail(function() {
                    alert( "Error" );
                });
            }

            function md_obtenerResumenVendedores(){
                fc_validarTimer();
                tableVendedores.ajax.reload( null, false );
                tableDespachoVendedores.ajax.reload( null, false );
                tablePreventaVendedores.ajax.reload( null, false ); 
            }

            function fc_validarTimer(){
                if (timerSincronizacion){ clearInterval(timerSincronizacion); }
                if( $("#fechaPreventa").val() == $("#fechaPorDefecto").val()){
                    timerSincronizacion = setTimeout(function() {
                        tableVendedores.ajax.reload( null, false );
                        tableDespachoVendedores.ajax.reload( null, false );
                        tablePreventaVendedores.ajax.reload( null, false ); 
                    }, 100);
                }  
            }
        } );

        function resizeTable(){
            tablePedidos.columns.adjust().draw();
            tableVendedores.columns.adjust().draw();
            tableDespachoVendedores.columns.adjust().draw();
            tablePreventaVendedores.columns.adjust().draw();
        }

        function fc_openDetalle(vendedor, numero, zona, ruta, guia, modo, ClientesProg){
            rutaTabla = ruta;
            zonaTabla = zona;
            guiaTabla = guia;

            $("#monitoreoVendedor").val(numero);
            $("#monitoreoZona").val(zona);
            $("#monitoreoRuta").val(ruta);
            $("#monitoreoGuia").val(guia);
            $("#monitoreoModo").val(modo);
            $("#monitoreoNombre").val(vendedor);
            $("#monitoreoClienteProg").val(ClientesProg);
                        
            $("#goMonitoreo").submit();
        }
        
        function fc_mostrarDetalle(vendedor, numero, zona, ruta, guia, modo){
            rutaTabla = ruta;
            zonaTabla = zona;
            guiaTabla = guia;

            $('html,body').animate({ scrollTop: $("#listaPedidosTable").offset().top},  'slow');
             
            $("#nombreVendedor").html("("+modo+") : "+vendedor);            
            $("#vendedorActual").val(numero);
            tablePedidos.ajax.reload( null, false );
            
            if (timerSincronizacionPedidosActual){ clearInterval(timerSincronizacionPedidosActual); }            
            if( $("#fechaPreventa").val() == $("#fechaPorDefecto").val()){
                timerSincronizacionPedidosActual = setInterval(function() {
                    tablePedidos.ajax.reload( null, false );
                 }, 30000);
            }
        }
        
        function fc_mostrarSegmentos (vendedor, numero, zona, ruta){ 
            var nombreModal = numero+"-seg"+zona;
            if(typeof vendedores[nombreModal] == 'undefined'){
                var datos = [];
                datos['cliente'] = false;
                datos['listaPedidos'] = [];
                vendedores[nombreModal] = datos;
            }
            //verificar si esta en la lista
            if( vendedores[nombreModal].cliente == false ){
                vendedores[nombreModal].cliente = true;
                var modalVendedor = esquema["SC"];
                modalVendedor = modalVendedor.replace(/_numero_/g, nombreModal); 
                
                modalVendedor = modalVendedor.replace('[vendedor]', vendedor);
                //si no, crear modal
                $("#modals").append(modalVendedor);

                //crear tabla, definir ajax y search
                $("#table"+nombreModal).DataTable( {
                    "processing": true,
                    "lengthMenu":[[ 5, 10, 25, -1],[ "5", "10", "25", "Todo" ]],
                    "ajax": {
                        "url" : 'get/vistaxsegmento',
                        "type": 'POST',
                        "dataSrc": '',
                        "data" : {
                            "ruta" : ruta,
                            "zona" : zona,
                            "vendedor" : numero
                        }
                    },
                    "columns": [
                        { data: "codigo" },
                        { data: "segmento" },
                        { data: "clientes" }, 
                        { data: "exhibidores" },
                        { data: "puertas" }
                    ],
                    "scrollX": true,
                    "language":  languageES,
                    "footerCallback": function ( row, data, start, end, display ){
                        var api = this.api(), data;
                        var columna = 2;
                                            
                        var intVal = function ( i ) {
                            return typeof i === 'string' ?  parseInt(i) :typeof i === 'number' ?i : 0;
                        };
                            
                        while(columna <= 4){                        
                            // Total de todas las paginas
                            total = api
                                .column( columna )
                                .data()
                                .reduce( function (a, b) {                              
                                    return intVal(a) + intVal(b);                                   
                                }, 0 );
                            console.log(columna+": "+total);         
                            // Update footer
                            $( api.column( columna ).footer() ).html( total );
                            columna = columna +1;
                        }
                    }
                } );
            }
         
            $("#modal"+nombreModal).modal({backdrop: 'static', show: true, keyboard: false });
        }
        
        function fc_mostrarClientes(vendedor, numero, zona){ 
            var nombreModal = numero+"-"+zona;
            if(typeof vendedores[nombreModal] == 'undefined'){
                var datos = [];
                datos['cliente'] = false;
                datos['listaPedidos'] = [];
                vendedores[nombreModal] = datos;
            }
            //verificar si esta en la lista
            if( vendedores[nombreModal].cliente == false ){
                vendedores[nombreModal].cliente = true;
                var modalVendedor = esquema["M"];
                modalVendedor = modalVendedor.replace(/_numero_/g, nombreModal); 
                
                modalVendedor = modalVendedor.replace('[vendedor]', vendedor);
                //si no, crear modal
                $("#modals").append(modalVendedor);

                //crear tabla, definir ajax y search

                $("#table"+nombreModal).DataTable( {
                    "processing": true,
                    "lengthMenu":[[ 5, 10, 25, -1],[ "5", "10", "25", "Todo" ]],
                    "ajax": {
                        "url" : 'get/clientesxVendedor',
                        "type": 'POST',
                        "dataSrc": '',
                        "data" : {
                            "ruta" : $("#rutasPreventa").val(),
                            "zona" : zona /*$("#zonasPreventa").val()*/,
                            "vendedor" : numero
                        }
                    },
                    "columns": [
                        { data: "codigo" },
                        { data: "cliente" },
                        { data: "direccion" },
                        { data: "secuencia" },
                        { data: "subgiro" },
                        { data: "exhibidores" },
                        { data: "puertas" }
                    ],
                    "scrollX": true,
                    "language":  languageES 
                } );

            }
            //mostrar modal
            $("#modal"+nombreModal).modal({backdrop: 'static', show: true, keyboard: false });
        }

        /*function fc_mostrarMapa(codigo){
            $("#zonaSubmit").val(zonaFiltro);
            $("#rutaSubmit").val(rutaFiltro);
            $("#fechaSubmit").val(fechaPreventaFiltro);
            $("#vendedorSubmit").val(codigo);
            $("#goMap").submit();
        }*/

        function fc_mostrarDetallePedido (numeroPedido, cliente, horaInicio, horaMod, horaFin){         
            var vendedor = $("#vendedorActual").val();
            if(typeof vendedores[vendedor] == 'undefined'){
                var datos = [];
                datos['cliente'] = false;
                datos['listaPedidos'] = [];
                vendedores[vendedor] = datos;
            }
            //verificar si esta en la lista
            var listaPedidos = vendedores[vendedor].listaPedidos;
            var indice = listaPedidos.indexOf(numeroPedido);
            if( indice < 0 ){
                vendedores[vendedor].listaPedidos.push(numeroPedido); 
                vendedores[vendedor].detalle = true;
                
                indice = vendedores[vendedor].listaPedidos.length -1 ;
               
                var modalVendedor = esquema["MP"];
                modalVendedor = modalVendedor.replace(/_numero_/g, numeroPedido);
                modalVendedor = modalVendedor.replace('[cliente]', cliente);
                modalVendedor = modalVendedor.replace('[hora_inicio]', horaInicio);
                modalVendedor = modalVendedor.replace('[hora_act]', horaMod);
                modalVendedor = modalVendedor.replace('[hora_fin]', horaFin);
                modalVendedor = modalVendedor.replace('[indice]', indice);
                //si no, crear modal
                $("#modals").append(modalVendedor);

                //crear tabla, definir ajax y search 
                var tableDetalle = $("#table"+numeroPedido+"-"+indice).DataTable( {
                    "processing": true,
                    "lengthMenu": [[ 5, 10, 25, -1],[ "5", "10", "25", "Todo" ]],
                    "ajax": {
                        "url" : '{{ url("get/detalleExtendidoPedido")  }}',
                        "type": 'POST',
                        "dataSrc": '',
                        "data" : {
                            "vendedor" : vendedor,
                            "fecha" : $("#fechaPreventa").val(),
                            "numeroPedido" : numeroPedido,
                            "guia": guiaTabla
                        }
                    }, 
                    "columns": [
                        { data: "codigo" },
                        { data: "producto" },
                        { data: "transaccion" },
                        { data: "unidad" },
                        { data: "cantidad" }, 
                        { data: "cajasERP" }, 
                        { data: "precioNeto" },
                    ],
                    "fnCreatedRow": function( row, data, dataIndex ) {  
                        if( data["transaccion"] != "VENTA" ){
                            $(row).addClass( "bg-gray" );               
                        }
                    },
                    "scrollX": true,
                    "language":  languageES

                } );
                
                listaTablasPedidos[numeroPedido+"-"+indice] = tableDetalle;
            }else{
                //actualizar ajax
                listaTablasPedidos[numeroPedido+"-"+indice].ajax.reload( null, false );
            }
            //mostrar modal
            //actualizar ajax del pedido
            $("#modal"+numeroPedido).modal({backdrop: 'static', show: true, keyboard: false });
            //actualizar ajax table171117065003
           //$("#table"+numeroPedido).datatable().ajax().reoad();
        }
    </script>
@stop