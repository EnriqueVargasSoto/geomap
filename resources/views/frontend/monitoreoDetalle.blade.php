@extends('layouts.frontend.master')
@section('style')
    <!-- Datatable -->
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
		th {
			text-align: center;
		}
		#tableVendedores.dataTable.hover tbody tr:hover,td.highlight-blue,.bg-light-blue-footer{
			background-color: #d2e5ef  !important;
		}
		#tablePreventaVendedores.dataTable.hover tbody tr:hover,td.highlight-purple{
			background-color: #b7aace  !important;
		}
		#tableDespachoVendedores.dataTable.hover tbody tr:hover,td.highlight-cyal{
			background-color: #aff1f1  !important;
		}
		#listaPedidosTable.dataTable.hover tbody tr:hover, td.highlight-green,.bg-green-footer{
			background-color: #d4efd2  !important;
		}
		.button.close {   
			font-size: 30px  !important;
		} 
		.bg-white{
			background-color: white;
			font-weight: bold;
		}
    </style>
@stop
@section('content')
 <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content">	
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header with-border">
                        {{-- <h3 class="box-title">Lista de Pedidos {{ $modo }}: <label id="nombreVendedor">{{ $nombreVendedor}}</label></h3> --}}
                        <h3 class="box-title">Jefe de Unidad de Negocio: <label id="nombreVendedor">{{ $nombreVendedor}}</label></h3>
                        <input id="vendedorActual" value="{{ $vendedor }}" hidden>
                        <div class="box-tools pull-right">
                            <!--button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button-->
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="table-responsive">
                            <table id="listaPedidosTable"  class="row-border hover" width="100%">
                                <!--table id="example" class="row-border hover order-column responsive" cellspacing="0" width="100%"-->
                                <thead >
								 <tr  class="bg-white">
                                    <th>TOTAL</th>
                                    <th></th>
                                    <th></th>
                                    <th id="tablaTiempoPedido">00:00</th>
									<th id="tablaTiempoTraslado">00:00</th>
                                    <th> </th>
                                    <th id="tablaCantidadventa">0</th>
                                    <th id="tablaERP">0</th>
                                    <th id="tablaSumImporteTotal">0</th>
                                    <th></th>
                                </tr>
                                <tr class="bg-green">
                                    <th>Cliente&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                    <th>Establecimiento</th>{{-- <th>Dirección</th> --}}
                                    <th>Hora Inicio</th>
                                    <th>Tiempo de Atención</th>{{-- <th>Tiempo Pedido</th> --}}
									<th>Tiempo traslado</th>
                                    <th>Fecha Entrega</th>
                                    <th>Número Eventos</th>{{-- <th>Cantidad Venta</th> --}}
                                    <th>Cajas(ERP)</th>
                                    <th>Importe Total</th>
                                    <th>Acción</th>
                                </tr>
                                </thead>
                                <tfoot class="bg-green-footer">
                                <tr>
                                    <th>TOTAL&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                    <th></th>
                                    <th></th>
                                    <th>00:00</th>
									<th>00:00</th>
                                    <th></th>
                                    <th>0</th>
                                    <th>0</th>
                                    <th>0</th>
                                    <th></th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
			 <div class="col-xs-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Resumen de Ventas Por Marca</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="table-responsive">
                            <table id="tablaVentasxMarca"  class="row-border hover" width="100%">
								<thead >
									<tr class="bg-white">
										<th >TOTAL</th>
										<th id="tblMarcaPaquetes">0</th>
										<th id="tblMarcaUnidades">0</th>
										<th id="tblMarcaSoles" >0</th>
										<th id="tblMarcaClientes">0</th>  
										<th ></th>  
									</tr>
									<tr class="bg-blue">
										<th rowspan="2">Marca</th>
										<th colspan="2">Unidad Medida</th>
										<th rowspan="2">Soles</th>
										<th rowspan="2">N° Clientes</th>
										<th rowspan="2">Efct. Pre Venta Marca</th>  
									</tr>
									<tr class="bg-blue"> 
										<th>PQTES</th>
										<th>UNID</th>
									</tr>
								</thead> 
                                <tfoot class="bg-blue-footer">
                                <tr>
                                    <th>TOTAL&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                    <th>0</th>
                                    <th>0 </th>
                                    <th>0</th>
									<th>0</th>
                                    <th></th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
	<div id="modals"></div>
    <div id="overlay" class="overlay hidden"><i class="fa fa-refresh fa-spin"></i></div> 
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
        var tableVendedores;
        var vendedores = []; 
		var listaTablasPedidos = [];
        var languageES;
		var zonaFiltro = 'all';
		var rutaFiltro = 'all';
		var fechaPreventaFiltro = $("#fechaPorDefecto").val();
        var fechaDefecto = '';
		var rutaTabla = '{{ $ruta }}';
		var guiaTabla = '{{ $guia }}';
		var zonaTabla = '{{ $zona }}';
		var clientesProgramados = '{{ $clientesProgramados }}';
		
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

            tablePedidos = $('#listaPedidosTable').DataTable({
                "processing": true, 
				"scrollX": true,
				"lengthMenu":[ [5, 8, 10, 25, -1],["5", "8", "10", "25", "Todo"] ],
                "ajax": {
                    "url" : '{{url("get/pedidosxVendedor")}}',
                    "type": 'POST',
                    "dataSrc": '',
                    "data" : function(d){
							return { 
								"ruta" : rutaTabla,
								"zona" : zonaTabla,
								"fecha" : fechaPreventaFiltro,
								"guia": guiaTabla,
								"vendedor" : $("#vendedorActual").val()
							};
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
				"footerCallback": function ( row, data, start, end, display ) {
					var api = this.api(), data;
					// Remove the formatting to get integer data for summation
					var intVal = function ( i ) {
						return typeof i === 'string' ?
							i.replace(/[\$,]/g, '')*1 :
							typeof i === 'number' ?
								i : 0;
					};
					// Total over all pages
					total = api .column( 6 ) .data() .reduce( function (a, b) {
						return intVal(a) + intVal(b);
					}, 0 );
					
					$( api.column( 6 ).footer() ).html( total );
					$("#tablaCantidadventa").html(total);
					
					// Total over all pages
					total = api .column( 7 ) .data() .reduce( function (a, b) {
						return intVal(a) + intVal(b);
					}, 0 );
					
					$( api.column( 7 ).footer() ).html( total );
					$("#tablaERP").html(total);
					
					total = api .column( 8 ) .data() .reduce( function (a, b) {
						return intVal(a) + intVal(b);
					}, 0 );
					
					total = total.toFixed(2);
					
					$( api.column( 8 ).footer() ).html( total );
					$("#tablaSumImporteTotal").html(total);
					
					/** Tiempo Pedido  *************************************************/
					sumMinutosPedido = 0;
					sumSegundosPedido = 0;
					
					api .column( 3 ) .data() .reduce( function (a, b) {
					
						var tiempo = b.split(":"); 
						
						var minutos = intVal( tiempo[0] );						
						var segundos = intVal( tiempo[1] );						
						
						sumMinutosPedido = sumMinutosPedido + minutos;
						sumSegundosPedido = sumSegundosPedido + segundos;
						
					}, 0 );
					
					var minutos_Segundos = sumMinutosPedido * 60;
					var segundos = sumSegundosPedido + minutos_Segundos;
					var hours = Math.floor( segundos / 3600 );
					var minutes = Math.floor( (segundos % 3600) / 60 );
					var seconds = segundos % 60;

					var totalTiempoPedido = "";
					if(hours > 0){
						totalTiempoPedido = totalTiempoPedido + hours +":";
					}
					totalTiempoPedido = totalTiempoPedido +minutes+":"+seconds;

					// Update footer
					$( api.column( 3 ).footer() ).html( totalTiempoPedido );
					$("#tablaTiempoPedido").html(totalTiempoPedido);
					
					/** Tiempo Traslado *******************************/ 
					
					sumMinutosTraslado = 0;
					sumSegundosTraslado = 0;
					
					data = api.column( 4 ).cache('search');
					data.length ? data.reduce( function (a, b) {
						var minutos, segundos ;
					
						if (a !== undefined){
							var tiempo = a.split(":");
							minutos = intVal( tiempo[0] );
							segundos = intVal( tiempo[1] );
							
							sumMinutosTraslado = sumMinutosTraslado + minutos;
							sumSegundosTraslado = sumSegundosTraslado + segundos;
						}	
					 
						var tiempo2 = b.split(":");
						
						minutos = intVal( tiempo2[0] );
						segundos = intVal( tiempo2[1] );
											
						sumMinutosTraslado = sumMinutosTraslado + minutos;
						sumSegundosTraslado = sumSegundosTraslado + segundos;
							
					}) : 0 ;
						
					var minutos_Segundos = sumMinutosTraslado * 60;
					var segundos = sumSegundosTraslado + minutos_Segundos;
					var hours = Math.floor( segundos / 3600 );
					var minutes = Math.floor( (segundos % 3600) / 60 );
					var seconds = segundos % 60;

					var totalTiempoTraslado = "";
					if(hours > 0){
						totalTiempoTraslado = totalTiempoTraslado + hours +":";
					}
					
					totalTiempoTraslado = totalTiempoTraslado +minutes+":"+seconds;
					$( api.column( 4 ).footer() ).html( totalTiempoTraslado );
					$("#tablaTiempoTraslado").html(totalTiempoTraslado);
				}
            });
	
			tableVentasxMarca = $('#tablaVentasxMarca').DataTable({
                "processing": true, 
				"scrollX": true,
				"lengthMenu":[ [5, 8, 10, 25, -1],["5", "8", "10", "25", "Todo"] ],
                "ajax": {
                    "url" : '{{url("get/resumenxMarca")}}',
                    "type": 'POST',
                    "dataSrc": '',
                    "data" : function(d){
                        
						return { 
							"vendedor" : $("#vendedorActual").val()
						};
					},
                    

                },
                "columns": [ 
                    { data: "marca" },
                    { data: "paquetes" },
                    { data: "unidades" },
                    { data: "soles" },
                    { data: "numeroClientes" }, 
                    { data: null }
                ],
			    "columnDefs": [ 
					{
						"targets": -1,
						"data": null,
						"render": function ( data, type, row, meta ) {
							//console.log(row.numeroClientes +" / " + clientesProgramados );
							var efectividad = (( row.numeroClientes/ (clientesProgramados * 1.0)) *100 ).toFixed(3);
							return efectividad+"%";	
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
				"footerCallback": function ( row, data, start, end, display ) {
					var api = this.api(), data;
					// Remove the formatting to get integer data for summation
					var intVal = function ( i ) {
						return typeof i === 'string' ?
							i.replace(/[\$,]/g, '')*1 :
							typeof i === 'number' ?
								i : 0;
					};
					// Total over all pages
					total = api .column( 1 ) .data() .reduce( function (a, b) {
						return intVal(a) + intVal(b);
					}, 0 );
					
					$( api.column(1).footer() ).html( total );
					$("#tblMarcaPaquetes").html(total);
					
					total = api .column( 2 ) .data() .reduce( function (a, b) {
						return intVal(a) + intVal(b);
					}, 0 );
					
					$( api.column(2).footer() ).html( total );
					$("#tblMarcaUnidades").html(total);
					
					total = api .column( 3 ) .data() .reduce( function (a, b) {
						return intVal(a) + intVal(b);
					}, 0 );
					
					total = total.toFixed(2);					
					$( api.column(3).footer() ).html( total );
					$("#tblMarcaSoles").html(total);
					
					total = api .column( 4 ) .data() .reduce( function (a, b) {
						return intVal(a) + intVal(b);
					}, 0 );
					
					$( api.column(4).footer() ).html( total );
					$("#tblMarcaClientes").html(total);
					
					
					/*
					$("#").html(total);
					$("#").html(total);
					$("#tblMarcaClientes").html(total);*/
				}	
            });
			
           $('#listaPedidosTable tbody').on( 'mouseenter', 'td', function () {
			   if(typeof tablePedidos.cell(this).index() != 'undefined'){
				    var colIdx = tablePedidos.cell(this).index().column;
					$( tablePedidos.cells().nodes() ).removeClass( 'highlight-green' );
					$( tablePedidos.column( colIdx ).nodes() ).addClass( 'highlight-green' );
			   }               
           });
		
            $("#menuButton").click(function(){  
                setTimeout('resizeTable()',320); 
            });
			
        } );
				
		function resizeTable(){
			tablePedidos.columns.adjust().draw();
            tableVentasxMarca.columns.adjust().draw(); 
        }

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