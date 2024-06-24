@extends('layouts.frontend.master')
@section('style')
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" type="text/css" href="{{ url('/') }}/plugins/datatable/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="{{ url('/') }}/plugins/datatable/buttons.dataTables.min.css">
    <style>
		.col-lg-3 .form-buttons{
            padding-top: 0px;
        }
        .form-group label{
            display: block;
        } 
        table.DTFC_Cloned thead,table.DTFC_Cloned tfoot{background-color:white}
        div.DTFC_Blocker{background-color:white}
        div.DTFC_LeftWrapper table.dataTable,div.DTFC_RightWrapper table.dataTable{margin-bottom:0;z-index:2}
        div.DTFC_LeftWrapper table.dataTable.no-footer,div.DTFC_RightWrapper table.dataTable.no-footer{border-bottom:none}
        
        @media (min-width: 1200px){
            .modal-dialog{
                width: 70%;
            }
            .col-lg-3 .form-buttons{
                padding-top: 24px;
            }
        }
		#tableVendedores.dataTable.hover tbody tr:hover,td.highlight-blue,.bg-light-blue-footer{
			background-color: #d2e5ef  !important;
		}
		#listaPedidosTable.dataTable.hover tbody tr:hover, td.highlight-green,.bg-green-footer{
			background-color: #d4efd2  !important;
		}
		.button.close {   
			font-size: 30px  !important;
		}

    </style>
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
                    <div class="col-lg-3 col-md-4">
                        <div class="form-group">
                            <label>Zona</label>
                            <select id="zonasPreventa" class="form-control select2">
                                <option value="all">Todas</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4">
                        <div class="form-group">
                            <label>Ruta</label>
                            <select id="rutasPreventa" class="form-control select2">
                                <option value="all">Todas</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4">
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
                    <div class="col-lg-3 col-md-4">
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
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Vendedores(Autoventa)</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse" id="minAutoventa"><i class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="tableVendedores"  class="row-border hover order-column" width="100%">
                            <!--table id="example" class="row-border hover order-column responsive" cellspacing="0" width="100%"-->
                            <thead class="bg-blue">
                            <tr>
                                <th>Vendedor&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
								<th>Teléfono</th>
                                <th>Zona</th>
                                <!--<th>Ruta</th>-->
                                <th>Clientes</th>
                                <th>Cli. Efect.</th>
                                <th>C.E.%</th>
                                <th>Cant. Total</th>
                                <th>Cli. NP</th>
								<th>Cli. Efect. NP</th>
                                <th>C.E.NP%</th>
                                <th>C.Total NP</th>
                                <th>Estado</th>
                                <th>Imp.Total</th>
                                <th>DropPaquetes</th>
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
                                <th>Cli. Efect.</th>
                                <th>C.E.%</th>
                                <th>Cant. Total</th>
                                <th>Cli. NP</th>
								<th>Cli. Efect. NP</th>
                                <th>C.E.NP%</th>
                                <th>C.Total NP</th>
                                <th>Estado</th>
                                <th>Imp.Total</th>
                                <th>DropPaquetes</th>
                                <th>DropSoles</th>
								<th>Visitados</th>
                                <th>Acciones</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
		<div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Vendedores(Preventa)</h3>
                        <div class="box-tools pull-right">
                            <button id="minPreventa" type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="tablePreventaVendedores"  class="row-border hover order-column" width="100%">
                            <!--table id="example" class="row-border hover order-column responsive" cellspacing="0" width="100%"-->
                            <thead class="bg-purple">
                            <tr>
                                <th>Vendedor&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
								<th>Teléfono</th>
                                <th>Zona</th>
                                <th>Ruta</th>
                                <th>Clientes</th>
                                <th>Cli. Efect.</th>
                                <th>C.E.%</th>
                                <th>Cant. Total</th>
                                <th>Cli. NP</th>
								<th>Cli. Efect. NP</th>
                                <th>C.E.NP%</th>
                                <th>C.Total NP</th>
                                <th>Estado</th>
                                <th>Imp.Total</th>
                                <th>DropPaquetes</th>
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
                                <th>Cli. Efect.</th>
                                <th>C.E.%</th>
                                <th>Cant. Total</th>
                                <th>Cli. NP</th>
								<th>Cli. Efect. NP</th>
                                <th>C.E.NP%</th>
                                <th>C.Total NP</th>
                                <th>Estado</th>
                                <th>Imp.Total</th>
                                <th>DropPaquetes</th>
                                <th>DropSoles</th>
								<th>Visitados</th>
                                <th>Acciones</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
		<div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Vendedores(Despacho)</h3>
                        <div class="box-tools pull-right">
                            <button id="minDespacho" type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="tableDespachoVendedores"  class="row-border hover order-column" width="100%">
                            <!--table id="example" class="row-border hover order-column responsive" cellspacing="0" width="100%"-->
                            <thead class="bg-teal">
                            <tr>
                                <th>Vendedor&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
								<th>Teléfono</th>
                                <th>Zona</th>
                                <!--<th>Ruta</th>-->
                                <th>Clientes</th>
                                <th>Cli. Efect.</th>
                                <th>C.E.%</th>
                                <th>Cant. Total</th>
                                <th>Cli. NP</th>
								<th>Cli. Efect. NP</th>
                                <th>C.E.NP%</th>
                                <th>C.Total NP</th>
                                <th>Estado</th>
                                <th>Imp.Total</th>
                                <th>DropPaquetes</th>
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
                                <th>Cli. Efect.</th>
                                <th>C.E.%</th>
                                <th>Cant. Total</th>
                                <th>Cli. NP</th>
								<th>Cli. Efect. NP</th>
                                <th>C.E.NP%</th>
                                <th>C.Total NP</th>
                                <th>Estado</th>
                                <th>Imp.Total</th>
                                <th>DropPaquetes</th>
                                <th>DropSoles</th>
								<th>Visitados</th>
                                <th>Acciones</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Lista de Pedidos <label id="nombreVendedor"></label></h3>
                        <input id="vendedorActual" value="x" hidden>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="table-responsive">
                            <table id="listaPedidosTable"  class="row-border hover" width="100%">
                                <!--table id="example" class="row-border hover order-column responsive" cellspacing="0" width="100%"-->
                                <thead class="bg-green">
                                <tr>
                                    <th>Cliente&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                    <th>Dirección</th>
                                    <th>Hora Inicio</th>
                                    <th>Tiempo Pedido</th>
									<th>Tiempo traslado</th>
                                    <th>Fecha Entrega</th>
                                    <th>Cantidad</th>
                                    <th>Cajas(ERP)</th>
                                    <th>Importe Total</th>
                                    <th>Acción</th>
                                </tr>
                                </thead>
                                <tfoot class="bg-green-footer">
                                <tr>
                                    <th>Cliente&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                    <th>Dirección</th>
                                    <th>Hora Inicio</th>
                                    <th>Tiempo Pedido</th>
									<th>Tiempo traslado</th>
                                    <th>Fecha Entrega</th>
                                    <th>Cantidad</th>
                                    <th>Cajas(ERP)</th>
                                    <th>Importe Total</th>
                                    <th>Acción</th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
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
		
		var rutaTabla = 'ninguna';
		var guiaTabla = 'ninguna';
		var zonaTabla = 'ninguna';

        $(document).ready(function() {
			
            esquema = {
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
                                    '</tr>'+
                                    '</thead>'+
                                    '<tfoot class="bg-light-blue-footer">'+
                                    '<tr>'+
                                    '<th>Codigo</th>'+
                                    '<th>Cliente</th>'+
                                    '<th>Direccion</th>'+
                                    '<th>Secuencia de visita</th>'+
                                    '<th>Subgiro</th>'+
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
                    }					
                ],
				"fixedColumns" :{
					leftColumns: 1
				},
                "ajax": {
                    "url" : 'get/obtenerResumenVentasPreventa',
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
                        "data": "clientesConPedidos",
                        "render": function ( data, type, row, meta ) {
                            var count = Object.keys(row).length;

                            if(count == 0 || row.clientesConPedidos <= 0 ){
                               return "";
                            }else{
								return '<div class="btn-group"> <a href="javascript:void(0)" class="btn btn-default btn-xs" onClick="fc_mostrarDetalle(\''+row.nombrex+'\',\''+row.vendedorx+'\',\''+row.zona+'\',\''+row.ruta+'\',\''+row.numeroGuiax+'\')"><i class="fa fa-fw fa-eye"></i></a>'+
                                    '<a href="geomap/monitoreo/'+row.vendedorx+'/'+row.zona+'/'+row.ruta+'/?fecha='+fechaPreventaFiltro
									+'" target="_blank" class="btn btn-default btn-xs"><i class="fa fa-fw fa-map-o"></i></a>'+
                                    '</div>';
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
                        "data": "clientesProgramados",
                        "render": function ( data, type, row, meta ) {
                            var count = Object.keys(row).length;
                            if(count == 0){
                                return "0";
                            }else {
								if(row.clientesProgramados > 0){
									return '<a href="javascript:void(0)" onClick="fc_mostrarClientes(\''+row.nombrex+'\','+row.vendedorx+')">'+row.clientesProgramados+'</a>';
								}else{
									return '0';
								}
                            }
                        }
                    },
                    {
                        "targets": 6,
                        "data": "clientesProgramados",
                        "render": function ( data, type, row, meta ) {
                            var count = Object.keys(row).length;
                            if(count == 0){
                                return "";
                            }else {
                                var ce = ( row.clientesConPedidos/row.clientesProgramados*100).toFixed(3);
                                return ce+" %" ;
                            }
                        }
                    },
					{
                        "targets": 8, /*Cli. NP*/
                        "data": "clientesVisitados",
                        "defaultContent": "",
                        "render": function ( data, type, row, meta ) {
                            var count = Object.keys(row).length;
                            if(count == 0){
                                return "";
                            }else {
                                var noVisitados =  parseInt(row.clientesProgramados) - parseInt(row.clientesVisitados);
                                return noVisitados ; 
                            }
                        }
                    },
                    {
                        "targets": 10,
                        "data": "clientesVisitados",
                        "defaultContent": "",
                        "render": function ( data, type, row, meta ) {
                            var count = Object.keys(row).length;
                            if(count == 0){
                                return "0%";
                            }else {
                                var cenp = ( row.clientesVisitados/row.clientesProgramados*100).toFixed(3);
                                return cenp+" %" ;
                            }
                        }
                    },
                    {
                        "targets": 11, /* C.Total NP */
                        "data": "clientesProgramados",
                        "render": function ( data, type, row, meta ) {
                            var count = Object.keys(row).length;
                            if(count == 0){
                                return "";
                            }else {
                                var noVisitados =  row.clientesProgramados - row.clientesVisitados;
                                return noVisitados ;
                            }
                        }
                    },
                    {
                        "targets": 14,
                        "data": "totalPaquetes",
                        "render": function ( data, type, row, meta ) {
                            var count = Object.keys(row).length;
                            if(count >0 && row.clientesConPedidos > 0){
                                var dropPaquetes = (row.totalPaquetes / row.clientesConPedidos).toFixed(3);
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
                            if(count > 0 && row.importeVentasx != ".00" && row.clientesConPedidos > 0){
                                var dropSoles =  (row.importeVentasx / row.clientesConPedidos).toFixed(3);
                                return dropSoles ;
                            }else {
                                return "0";
                            }
                        }
                    },
					{
                        "targets": 16,
                        "data": "clientesVisitados",
                        "defaultContent": "",
                        "render": function ( data, type, row, meta ) {
                            var count = Object.keys(row).length;
                            if(count == 0){
                                return "0%";
                            }else {
                                var cenp = ( row.clientesVisitados/row.clientesProgramados*100).toFixed(3);
                                return cenp+" %" ;
                            }
                        }
                    },
                ],
                "columns": [
                    { data: null },
                    { data: null }, 
					{ data: "zona", defaultContent: "" },
                    { data: "ruta", defaultContent: "" },	
                    { data: "clientesProgramados", defaultContent: "" },
                    { data: "clientesConPedidos", defaultContent: "" },
                    { data: null },
                    { data: "totalPaquetes", defaultContent: "" },
					{ data: null },
                    { data: "clientesVisitados", defaultContent: "" },
                    { data: null },
                    { data: null },
                    { data: "estadoVendedor", defaultContent: "" },
                    { data: "importeVentasx", defaultContent: "" },
                    { data: null },
                    { data: null },
					{ data: null },
                    { data: null }
                ],
                "language":  languageES
            } );
			
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
									return '<div class="btn-group"> <a href="javascript:void(0)" class="btn btn-default btn-xs" onClick="fc_mostrarDetalle(\''+row.nombrex+'\',\''+row.vendedorx+'\',\''+row.zona+'\',\'all\',\''+row.numeroGuiax+'\')"><i class="fa fa-fw fa-eye"></i></a>'+
                                    '<a href="geomap/monitoreo/'+row.vendedorx+'/'+row.zona+'/'+row.ruta+'/?fecha='+fechaPreventaFiltro
									+'" target="_blank" class="btn btn-default btn-xs"><i class="fa fa-fw fa-map-o"></i></a>'+
                                    '</div>';
								                               
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
                        "data": "clientesProgramados",
                        "render": function ( data, type, row, meta ) {
                            var count = Object.keys(row).length;
                            if(count == 0){
                                return "0";
                            }else {
								if(row.clientesProgramados > 0){
									return '<a href="javascript:void(0)" onClick="fc_mostrarClientes(\''+row.nombrex+'\','+row.vendedorx+')">'+row.clientesProgramados+'</a>';
								}else{
									return '0';
								}
                            }
                        }
                    },
                    {
                        "targets": 5,
                        "data": "clientesProgramados",
                        "render": function ( data, type, row, meta ) {
                            var count = Object.keys(row).length;
                            if(count == 0){
                                return "";
                            }else {
                                var ce = ( row.clientesConPedidos/row.clientesProgramados*100).toFixed(3);
                                return ce+" %" ;
                            }
                        }
                    },
					{
                        "targets": 7,
                        "data": "clientesVisitados",
                        "defaultContent": "",
                        "render": function ( data, type, row, meta ) {
                            var count = Object.keys(row).length;
                            if(count == 0){
                                return "";
                            }else {
                                var noVisitados =  row.clientesProgramados - row.clientesVisitados;
                                return noVisitados ; /* Cli. NP */
                            }
                        }
                    },
                    {
                        "targets": 9,
                        "data": "clientesVisitados",
                        "defaultContent": "",
                        "render": function ( data, type, row, meta ) {
                            var count = Object.keys(row).length;
                            if(count == 0){
                                return "0%";
                            }else {
                                var cenp = ( row.clientesVisitados/row.clientesProgramados*100).toFixed(3);
                                return cenp+" %" ;
                            }
                        }
                    },
                    {
                        "targets": 10, /*C.Total NP*/
                        "data": "clientesProgramados",
                        "render": function ( data, type, row, meta ) {
                            var count = Object.keys(row).length;
                            if(count == 0){
                                return "";
                            }else {
                                var noVisitados =  row.clientesProgramados - row.clientesVisitados;
                                return noVisitados ;
                            }
                        }
                    },
                    {
                        "targets": 13,
                        "data": "totalPaquetes",
                        "render": function ( data, type, row, meta ) {
                            var count = Object.keys(row).length;
                            if(count >0 && row.clientesConPedidos > 0){
                                var dropPaquetes = (row.totalPaquetes / row.clientesConPedidos).toFixed(3);
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
                            if(count > 0 && row.importeVentasx != ".00" && row.clientesConPedidos > 0){
                                var dropSoles =  (row.importeVentasx / row.clientesConPedidos).toFixed(3);
                                return dropSoles ;
                            }else {
                                return "0";
                            }
                        }
                    },
					{
                        "targets": 15,
                        "data": "clientesVisitados",
                        "defaultContent": "",
                        "render": function ( data, type, row, meta ) {
                            var count = Object.keys(row).length;
                            if(count == 0){
                                return "0%";
                            }else {
                                var cenp = ( row.clientesVisitados/row.clientesProgramados*100).toFixed(3);
                                return cenp+" %" ;
                            }
                        }
                    },
                ],
                "columns": [
                    { data: null },
                    { data: null }, 
					{ data: "zona", defaultContent: "" },	
                    { data: "clientesProgramados", defaultContent: "" },
                    { data: "clientesConPedidos", defaultContent: "" },
                    { data: null },
                    { data: "totalPaquetes", defaultContent: "" },
					{ data: null },
                    { data: "clientesVisitados", defaultContent: "" },
                    { data: null },
                    { data: null },
                    { data: "estadoVendedor", defaultContent: "" },
                    { data: "importeVentasx", defaultContent: "" },
                    { data: null },
                    { data: null },
					{ data: null },
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
															
									return '<div class="btn-group"> <a href="javascript:void(0)" class="btn btn-default btn-xs" onClick="fc_mostrarDetalle(\''+row.nombrex+'\',\''+row.vendedorx+'\',\''+row.zona+'\',\'all\',\''+row.numeroGuiax+'\')"><i class="fa fa-fw fa-eye"></i></a>'+
                                    '<a href="geomap/monitoreo/'+row.vendedorx+'/'+row.zona+'/'+row.ruta+'/?fecha='+fechaPreventaFiltro
									+'" target="_blank" class="btn btn-default btn-xs"><i class="fa fa-fw fa-map-o"></i></a>'+
                                    '</div>';
								                               
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
                        "data": "clientesProgramados",
                        "render": function ( data, type, row, meta ) {
                            var count = Object.keys(row).length;
                            if(count == 0){
                                return "0";
                            }else {
								if(row.clientesProgramados > 0){
									return '<a href="javascript:void(0)" onClick="fc_mostrarClientes(\''+row.nombrex+'\','+row.vendedorx+')">'+row.clientesProgramados+'</a>';
								}else{
									return '0';
								}
                            }
                        }
                    },
                    {
                        "targets": 5,
                        "data": "clientesProgramados",
                        "render": function ( data, type, row, meta ) {
                            var count = Object.keys(row).length;
                            if(count == 0){
                                return "";
                            }else {
                                var ce = ( row.clientesConPedidos/row.clientesProgramados*100).toFixed(3);
                                return ce+" %" ;
                            }
                        }
                    },
					{
                        "targets": 7,
                        "data": "clientesVisitados",
                        "defaultContent": "",
                        "render": function ( data, type, row, meta ) {
                            var count = Object.keys(row).length;
                            if(count == 0){
                                return "";
                            }else {
                                var noVisitados =  row.clientesProgramados - row.clientesVisitados;
                                return noVisitados ;
                            }
                        }
                    },
                    {
                        "targets": 9,
                        "data": "clientesVisitados",
                        "defaultContent": "",
                        "render": function ( data, type, row, meta ) {
                            var count = Object.keys(row).length;
                            if(count == 0){
                                return "0%";
                            }else {
                                var cenp = ( row.clientesVisitados/row.clientesProgramados*100).toFixed(3);
                                return cenp+" %" ;
                            }
                        }
                    },
                    {
                        "targets": 10,
                        "data": "clientesProgramados",
                        "render": function ( data, type, row, meta ) {
                            var count = Object.keys(row).length;
                            if(count == 0){
                                return "";
                            }else {
                                var noVisitados =  row.clientesProgramados - row.clientesVisitados;
                                return noVisitados ;
                            }
                        }
                    },
                    {
                        "targets": 13,
                        "data": "totalPaquetes",
                        "render": function ( data, type, row, meta ) {
                            var count = Object.keys(row).length;
                            if(count >0 && row.clientesConPedidos > 0){
                                var dropPaquetes = (row.totalPaquetes / row.clientesConPedidos).toFixed(3);
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
                            if(count > 0 && row.importeVentasx != ".00" && row.clientesConPedidos > 0){
                                var dropSoles =  (row.importeVentasx / row.clientesConPedidos).toFixed(3);
                                return dropSoles ;
                            }else {
                                return "0";
                            }
                        }
                    },
					{
                        "targets": 15,
                        "data": "clientesVisitados",
                        "defaultContent": "",
                        "render": function ( data, type, row, meta ) {
                            var count = Object.keys(row).length;
                            if(count == 0){
                                return "0%";
                            }else {
                                var cenp = ( row.clientesVisitados/row.clientesProgramados*100).toFixed(3);
                                return cenp+" %" ;
                            }
                        }
                    },
                ],
                "columns": [
                    { data: null },
                    { data: null }, 
					{ data: "zona", defaultContent: "" },
                    { data: "clientesProgramados", defaultContent: "" },
                    { data: "clientesConPedidos", defaultContent: "" },
                    { data: null },
                    { data: "totalPaquetes", defaultContent: "" },
					{ data: null },
                    { data: "clientesVisitados", defaultContent: "" },
                    { data: null },
                    { data: null },
                    { data: "estadoVendedor", defaultContent: "" },
                    { data: "importeVentasx", defaultContent: "" },
                    { data: null },
                    { data: null },
					{ data: null },
                    { data: null }
                ],
                "language":  languageES
            } );
			statusAutoventa = 1;/* Tabla Visible */
			statusPreventa = 1;
			statusDespacho = 1;
			$("#minAutoventa").click( function() {  statusAutoventa = statusAutoventa == 1? 0: 1; if(statusAutoventa == 1){tableVendedores.ajax.reload( null, false );} });
			$("#minPreventa").click( function() {  statusPreventa = statusPreventa == 1? 0: 1; if(statusPreventa == 1){tablePreventaVendedores.ajax.reload( null, false );} });
			$("#minDespacho").click( function() {  statusDespacho = statusDespacho == 1? 0: 1; if(statusDespacho == 1){tableDespachoVendedores.ajax.reload( null, false );} });
			
            $('#tableVendedores tbody').on( 'mouseenter', 'td', function () {
			   if(typeof tableVendedores.cell(this).index() != 'undefined'){
				    var colIdx = tableVendedores.cell(this).index().column;
					$( tableVendedores.cells().nodes() ).removeClass( 'highlight-blue' );
					$( tableVendedores.column( colIdx ).nodes() ).addClass( 'highlight-blue' );
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

			sc_obtenerZonas();

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
                    timerSincronizacion = setInterval(function() {
                        tableVendedores.ajax.reload( null, false );
						tableDespachoVendedores.ajax.reload( null, false );
						tablePreventaVendedores.ajax.reload( null, false ); 
                    }, 30000);
                }  
            }
        } );

        function resizeTable(){
			tablePedidos.columns.adjust().draw();
            tableVendedores.columns.adjust().draw();
			tableDespachoVendedores.columns.adjust().draw();
			tablePreventaVendedores.columns.adjust().draw();
        }

        function fc_mostrarDetalle(vendedor, numero, zona, ruta, guia){
			rutaTabla = ruta;
			zonaTabla = zona;
			guiaTabla = guia;

			$('html,body').animate({ scrollTop: $("#listaPedidosTable").offset().top},  'slow');
			 
			$("#nombreVendedor").html(": "+vendedor);			
            $("#vendedorActual").val(numero);
			tablePedidos.ajax.reload( null, false );
			
			if (timerSincronizacionPedidosActual){ clearInterval(timerSincronizacionPedidosActual); }			 
			if( $("#fechaPreventa").val() == $("#fechaPorDefecto").val()){
				timerSincronizacionPedidosActual = setInterval(function() {
					tablePedidos.ajax.reload( null, false );
				 }, 30000);
			}
        }

        function fc_mostrarClientes(vendedor, numero){
            if(typeof vendedores[numero] == 'undefined'){
                var datos = [];
                datos['cliente'] = false;
                datos['listaPedidos'] = [];
                vendedores[numero] = datos;
            }
            //verificar si esta en la lista
            if( vendedores[numero].cliente == false ){
                vendedores[numero].cliente = true;
                var modalVendedor = esquema["M"];
                modalVendedor = modalVendedor.replace(/_numero_/g, numero);
                modalVendedor = modalVendedor.replace('[vendedor]', vendedor);
                //si no, crear modal
                $("#modals").append(modalVendedor);

                //crear tabla, definir ajax y search

                $("#table"+numero).DataTable( {
                    "processing": true,
					"lengthMenu":[[ 5, 10, 25, -1],[ "5", "10", "25", "Todo" ]],
                    "ajax": {
                        "url" : 'get/clientesxVendedor',
                        "type": 'POST',
                        "dataSrc": '',
                        "data" : {
                            "ruta" : $("#rutasPreventa").val(),
                            "zona" : $("#zonasPreventa").val(),
                            "vendedor" : numero
                        }
                    },
                    "columns": [
                        { data: "codigo" },
                        { data: "cliente" },
                        { data: "direccion" },
                        { data: "secuencia" },
                        { data: "subgiro" }
                    ],
                    "scrollX": true,
                    "language":  languageES

                } );

            }
            //mostrar modal
            $("#modal"+numero).modal({backdrop: 'static', show: true, keyboard: false });
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
                        "url" : 'get/detalleExtendidoPedido',
                        "type": 'POST',
                        "dataSrc": '',
                        "data" : {
                            "vendedor" : vendedor,
                            "fecha" : $("#fechaPreventa").val(),
                            "numeroPedido" : numeroPedido
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