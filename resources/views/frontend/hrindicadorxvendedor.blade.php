@extends('layouts.frontend.master')
@section('style')
    <!-- Datatable -->
    <link rel="stylesheet" type="text/css" href="{{ url('/') }}/plugins/datatable/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="{{ url('/') }}/plugins/datatable/buttons.dataTables.min.css">
    <style>
		.col-lg-3 .form-buttons{
            padding-top: 0px;
        }
		.bg-white{
			background: white;
		}
        .form-group label{
            display: block;
        } 
		li.active a {
			font-weight: bold;
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
		
		#tablePreventaVendedores.dataTable.hover tbody tr:hover,td.highlight-purple{
			background-color: #b7aace  !important;
		}
		
		#tableDespachoVendedores.dataTable.hover tbody tr:hover,td.highlight-cyal{
			background-color: #aff1f1  !important;
		}
		#listaPedidosTable.dataTable.hover tbody tr:hover, td.highlight-green,.bg-green-footer{
			background-color: #d4efd2  !important;
		}
		th {
			text-align: center;
		}
		.button.close {   
			font-size: 30px  !important;
		}
		a:focus {
			color: #0d6175;
			font-weight: bold;
		}
		.small-box h3 {
			font-size: 25px;
		}
		th .small-box {
			margin: 0px;
		}
		#tableHitRate_wrapper td {
		    max-width: 240px;
			overflow: hidden;
			text-overflow: ellipsis;
			white-space: nowrap;
		}
		table.dataTable thead .bg-white th{
			padding: 5px;
		}
    </style>
@stop
@section('content')
 <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content">
	
		<div class="box box-primary">
			<div class="box-header">
				<div class="col-md-2">
					<label>Formato</label>
				</div>
				<div class="col-md-4">
					<select id="fomato" class="form-control">
						<option value="soles">  Soles</option>
						<option value="paquete">  Físicas</option>
					</select>
				</div>
			</div>
			<div class="box-body">
				<div class="row">
					<div class="col-xs-12">				
						<table id="tableVendedores"  class="row-border hover order-column" width="100%">
							<thead class="bg-blue">
							 <tr class="bg-white">
								<th colspan="1"></th>
								<th colspan="1">
									<div class="small-box bg-green">
										<div class="inner">
										   <p>Hit Rate</p>
										   <h3 id="sumHitRate">0</h3>
										</div>
									</div>
								</th>
								<th colspan="1">
									<div class="small-box bg-aqua">
										<div class="inner">
										 <p>Cob Multiple</p>
										  <h3 id="sumCobMultiple">0</h3>
										</div>
									</div>
								</th>
								<th colspan="1">
									<div class="small-box bg-yellow">
										<div class="inner">
											<p>Venta Liquidad-total de mes</p>
										  <h3 id="sumVentaLiquidada">0</h3>
										</div>
									</div>
								</th>
								<th colspan="1">
								<div class="small-box bg-navy">
									<div class="inner">
									 <p>Cuota</p>
									  <h3 id="sumCuotaDia">0</h3> 
									</div>
								</div>
								</th>
								<th colspan="1">
									<div class="small-box bg-teal">
										<div class="inner">
										  <p>Faltante acumulado mes</p>
										  <h3 id="sumFaltantes">0</h3> 
										</div>
									</div>
								</th>
								<th colspan="1">
									<div class="small-box bg-blue">
										<div class="inner">
										  <p>Mes proyectado mes</p>
										  <h3 id="sumProyectado">0</h3> 
										</div>
									</div>
								</th>
								<th colspan="1">
									<div class="small-box bg-purple">
										<div class="inner">
										  <p>Cuota necesaria del Día</p>
										  <h3 id="sumNecesidadDia">0</h3> 
										</div>
									</div>
								</th>
								<th colspan="1">
									<div class="small-box bg-yellow">
										<div class="inner">
										  <p>Avance de PreVenta</p>
										  <h3 id="sumAvanceDia">0</h3> 
										</div>
									</div>
								</th>
							</tr>
							<tr>
								<th>VENDEDOR</th>								
								<th>Hit Rate</th>
								<th>Cob Multiple</th>
								<th>Venta Liquidada</th>
								<th>Cuota</th>
								<th>Faltante</th>
								<th>Proyectado%</th>
								<th>Necesidad del Día</th>
								<th>Avance de Preventa</th>
							</tr>
							</thead>
							<tfoot class="bg-blue footer">
							<tr>
								<th>TOTAL</th>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
							</tr>
							</tfoot>
						</table>
					</div>
				</div>
			</div>
			<div class="box-footer">
				<div class="pull-right"><h5><strong>Promedio Avance</strong> <span id="promedioVendedores">0.0</span> </h5></div>
			</div>
		</div>
		
		<div class="box box-primary">
			<div class="box-header with-border">				
				<h3 class="box-title"><span id="clienteActual">Vendedor</span> <small id="formatoTabla"> (soles)</small></h3>		
				<div class="box-tools pull-right">
					<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
				</div>					
			</div>				
			<div class="box-body">
				<div class="row">
					<div class="col-xs-12">				
						<table id="tableHitRate"  class="row-border hover order-column" width="100%">
							<thead class="bg-blue">
							<tr> 
								<th>Clientes</th>
								<th>Direcciión</th>
								<th>HR%</th>
								<th>Venta Día</th>
								<th>Peso Total</th>
								<th>Prom MA</th>
								<th>Prom AA</th>
								<th>Cuota Diaria</th>
								<th>Faltante Venta</th>
								<th>Avance Mes</th>
								{{--<th>KR</th>--}}
								<th>CIE</th>
								<th>ORO</th>
								<th>SPR</th>
								<th>CIF</th>
								<th>PUL</th>
								<th>VOL</th>
								<th>OT</th>
								<!--th>CM</th-->
								<th>CM%</th>
								<!--th>PG</th>
								<th>TD</th>
								<th>LQ</th> 
								<th>AA</th>
								<th>LIQ</th>
								<th>MA</th>
								<th>LIQ </th>
								<th>AMA </th>
								<th>Avance Anual.</th-->
								<th>SEG.</th>
								<th>EX.</th>
								<th>FR.</th>
								<th>TL. </th>
							</tr>
							</thead>
							<tfoot class="bg-blue footer">
							<tr>
								<th>Cliente</th>
								<th>Direcciión</th>
								<th>HR%</th>
								<th>Venta Día</th>
								<th>Peso Total</th>
								<th>Prom MA</th>
								<th>Prom AA</th>
								<th>Cuota Diaria</th>
								<th>Faltante Venta</th>
								<th>Avance Mes</th>
								{{--<th>KR</th>--}}
								<th>CIE</th>
								<th>ORO</th>
								<th>SPR</th>
								<th>CIF</th>
								<th>PUL</th>
								<th>VOL</th>
								<th>OT</th>
								<!--th>CM</th-->
								<th>CM%</th>
								<!--th>PG</th>
								<th>TD</th>
								<th>LQ</th> 
								<th>AA</th>
								<th>LIQ</th>
								<th>MA</th>
								<th>LIQ </th>
								<th>AMA </th>
								<th>Avance Anual.</th-->
								<th>SEG.</th>
								<th>EX.</th>
								<th>FR.</th>
								<th>TL. </th>
							</tr>
							</tfoot>
						</table>
					</div>
				</div>
			</div>
		</div>
		
    </section>

    <div id="overlay" class="overlay hidden"><i class="fa fa-refresh fa-spin"></i></div>
    <form id="formExcelInforme" target="_blank" method="POST" action="{{ url('/excel/reporteHitRate') }}">
		{{ csrf_field()}}
		<input type="hidden" name="formatoExcel" id="formatoExcel"> 
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
	<link rel="stylesheet" type="text/css" href="{{ url('/') }}/plugins/datepicker/datepicker3.css">
	<link rel="stylesheet" type="text/css" href="{{ url('/') }}/plugins/timepicker/bootstrap-timepicker.min.css">
	<script type="text/javascript" language="javascript" src="{{ url('/') }}/plugins/datepicker/bootstrap-datepicker.js"></script>
	<script type="text/javascript" language="javascript" src="{{ url('/') }}/plugins/timepicker/bootstrap-timepicker.min.js"></script>
    <script>
        
		var	promedioPreVenta = 0.0;	
		var mayor = 0;
		var formato = 'soles';
		var vendedor = 0;
		var styleRed = {  backgroundColor : "red", color: "white" };
		var styleGreen = {  backgroundColor : "green", color: "white" };
		var sumHitRate = 0;
		var sumAvanceVenta = 0;
		var sumCobMultiple = 0;
		var sumStatus = 0;
		var sumFaltantes = 0;
		var sumProyectado = 0;
		var sumNecesidadDia = 0;
		var sumVentaLiquidada = 0;
		var diasLaborados = {{ $diasLaborados }};
		var diasLaborables = {{ $diasLaborables }};
	
        $(document).ready(function() {
				
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
      
			tableVendedores = $('#tableVendedores').DataTable( {
                "processing": true,
                "scrollX": true, 
				dom: 'Bfrltip',
				lengthMenu:[[ 5,25,45,50, -1],[ "5","25", "45", "50", "Todos" ]],
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
                        pageSize: 'LEGAL'
                    },
					{
						text: '<i class="fa fa-table"></i>&nbsp;&nbsp;Resumen',
						action: function ( e, dt, node, config ) {  
							$("#formatoExcel").val(formato);
							$("#formExcelInforme").submit(); 
						}
					}						
                ],	
				"fixedColumns" :{
				},				
                "ajax": {
                    "url" : 'get/obtenerAvanceCuotaxSucursal',
                    "type": 'POST',
                    "dataSrc": '',
					"data" : function(d){
						return { 
							"formato" : formato
						};
					}
                },
				"columns":[
					{ data: null },
					{ data: null },
					{ data: null },
                    { data: null },	
					{ data: null },
                    { data: null },
					{ data: null },	
					{ data: null },
					{ data: null },	
				],
				"columnDefs": [   
					{
						"targets": 0,
                        "data": null,
                        "render": function ( data, type, row, meta ) {
							return '<a href="javascript:void(0)" onClick="actualizarTablaHitRate(\''+row.idVendedor+'\',\''+row.nombre+'\')">'+row.nombre+"-"+row.idVendedor+'</span>';	                            
                        }
					},
					{
						"targets": 1,
                        "data": null,
                        "render": function ( data, type, row, meta ) {
							return   ( parseFloat( row.hitrate) ).toFixed(0)   + ' %';	                      
                        }
					},
					{
						"targets": 2,
                        "data": null,
                        "render": function ( data, type, row, meta ) {
							return  ( parseFloat( row.CoberturaMultiple) ).toFixed(0)   + ' %';	
                        }
					},		
					{
						"targets": 3,//venta liquidada
                        "data": null,
                        "render": function ( data, type, row, meta ) {
							return new Intl.NumberFormat('es-PE').format( row.ventaLiquidada );	
                        }
					},					
					{

                        "targets": 4,
                        "data": null,
                        "render": function ( data, type, row, meta ) {
							return new Intl.NumberFormat('es-PE').format( row.cuotaDia );	                           
                        }
                    },
					{
						"targets": 5, 
						 "data": null,
                        "render": function ( data, type, row, meta ) {
							var resto = ( parseFloat(row.cuotaDia) - parseFloat(row.ventaLiquidada) ).toFixed(2);	
							return resto <= 0 ? 0: '<span class="text-red">'+ new Intl.NumberFormat('es-PE').format( resto )+'</span>';	 
						}
					},
					{
						"targets": 6,//proyectado 
						"data": null,
                        "render": function ( data, type, row, meta ) {
							var resultado = 0;
							if( row.cuotaDia != 0 ){
								resultado = ((parseFloat(row.ventaLiquidada) / diasLaborados) * (diasLaborables / row.cuotaDia) * 100).toFixed(2);
							}							
							return  new Intl.NumberFormat('es-PE').format( resultado) + ' %';	
						}
					},
					{
						"targets": 7,  //necesidad del día
						 "data": null,
                        "render": function ( data, type, row, meta ) {
							var faltante =  parseFloat(row.cuotaDia) - parseFloat(row.ventaLiquidada);
							var resultado  = ( faltante / (diasLaborables - diasLaborados ) ).toFixed(2);	
							return new Intl.NumberFormat('es-PE').format( resultado) ;	
						}
					},
					{
						"targets": 8,
                        "data": null,
                        "render": function ( data, type, row, meta ) {
							return  new Intl.NumberFormat('es-PE').format( row.ventaDia );	
                        }
					}
				],
                "language":  languageES,
				"order": [[ 5, "desc" ]],
				"footerCallback": function ( row, data, start, end, display ){
					var api = this.api(), data;
					var columna = 1;
					var totalPreVenta = 0;
					var totalRate = 0;
					var totalMultiple= 0;
					
					var intVal = function ( i ) {
						return typeof i === 'string' ?  parseFloat( i.replace(",", "") ):typeof i === 'number' ? i : 0;
					};
						
					while(columna > 0 && columna <= 8){ 				
						// Total de todas las paginas
						total = api
							.column( columna )
							.data()
							.reduce( function (a, b) {	
								var valor;
									
								if( columna == 1 ){ 
									valor = intVal(b.hitrate); 
								}

								if( columna == 2 ){ 
									valor = intVal(b.CoberturaMultiple);
								}
								
								if(columna == 5){ //Faltante
									valor = intVal(b.cuotaDia) - intVal(b.ventaLiquidada);								
								}
								
								if( columna == 8 ){ 
									valor = intVal(b.ventaDia);  
								}
								
								if( columna == 4 ){ 
									valor = intVal(b.cuotaDia);  
								}
								
								if( columna == 3 ){ //liquidado
									valor = intVal(b.ventaLiquidada); 
									
								}
																
								if( columna == 6 ){ //proyectado
									valor = 0;
									if( intVal(b.cuotaDia) != 0 ){
										valor = (intVal(b.ventaLiquidada) / diasLaborados) * (diasLaborables / intVal(b.cuotaDia) ) * 100;
									}
								}
								
								if( columna == 7 ){ //necesidad del diasLaborables
									var faltante =  intVal(b.cuotaDia) - intVal(b.ventaLiquidada);
									
									var diaRestantes = diasLaborables - diasLaborados;
									valor =  faltante / diaRestantes;	
								}
								
								return intVal(a) + valor;
							}, 0 );
						
						 
							
						if( columna == 8 ){ //Avance Preventa
							totalPreVenta = total;
							sumAvanceVenta = total;	
							// Update footer
							$( api.column( columna ).footer() ).html( new Intl.NumberFormat('es-PE').format(  total.toFixed(2) ) ); 
						}else if(columna == 1){ 
							sumHitRate = total;
						}else if(columna == 2){ 
							totalMultiple = total; 
						}else if(columna == 4){ //Cuota
							sumCuotaDia = total;
						}else if(columna == 5){ //Faltante
							sumFaltantes = total;
						}else if(columna == 3){ //Venta Liquidada
							sumVentaLiquidada = total;
						}else if(columna == 6){ //Proyectado
							sumProyectado = total;
						}else if(columna == 7){ //Necesidad del día
							sumNecesidadDia = total;
						}
						
						columna = columna +1;
					}
					
					mayor = 0;
					cantVendedoresPreventa = 0;
					
					$.each( api.column( 8 ).data() , function(i, item) {	
						var avance = parseFloat(item.ventaDia);		
											
						if( avance > mayor){
							mayor = avance;
						} 
						cantVendedoresPreventa = cantVendedoresPreventa +1;
					});
							
						
							 
					promedioPreVenta = (totalPreVenta/cantVendedoresPreventa)/*.toFixed(2)*/;
					promedioPreVenta = promedioPreVenta.toFixed(2);
					
					sumHitRate = sumHitRate / cantVendedoresPreventa ;
					sumCobMultiple = totalMultiple /cantVendedoresPreventa;
					sumProyectado = ( sumProyectado /cantVendedoresPreventa ).toFixed(2);
					
					sumStatus = 0;
					
					$("#promedioVendedores").html( new Intl.NumberFormat('es-PE').format(  promedioPreVenta ) );
					
					var filas = api.column( 4 ).data().length;
					actualizarEstrellas(filas); 
										
					actualizarTotales();
				}
            });
			
          	tableHitRate = $('#tableHitRate').DataTable( {
                "processing": true,
                "scrollX": true, 
				dom: 'Bfrltip',
				lengthMenu:[[ 15,25,45,50, -1],[ "15","25", "45", "50", "Todo" ]],
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
                    "url" : 'get/obtenerIndicadorHRXVendedor',
                    "type": 'POST',
                    "dataSrc": '',
					"data" : function(d){
						return { 
							"vendedor" : vendedor,
							"formato" : formato,
						};
					}
                },
				"columns":[
					{ data: "idCliente"},
					{ data: "direccion"},
					{ data: null },
					{
                        "targets": 0,
                        "data": "pesoTotalx",
                        "render": function ( data, type, row, meta ) {
                            var count = Object.keys(row).length;
                            if(count == 0){
                                return "-";
                            }else {
                                var arti=parseFloat(row.ventaDia).toFixed(2);
                                return arti;
                            }
                        }
                    },

					{
                        "targets": 0,
                        "data": "pesoTotalx",
                        "render": function ( data, type, row, meta ) {
                            var count = Object.keys(row).length;
                            if(count == 0){
                                return "-";
                            }else {
                                var arti=parseFloat(row.pesoTotalx).toFixed(2);
                                return arti;
                            }
                        }
                    },

                    {
                        "targets": 0,
                        "data": "PromVentaMesAnterior",
                        "render": function ( data, type, row, meta ) {
                            var count = Object.keys(row).length;
                            if(count == 0){
                                return "-";
                            }else {
                                var arti=parseFloat(row.PromVentaMesAnterior).toFixed(2);
                                return arti;
                            }
                        }
                    },

					{
                        "targets": 0,
                        "data": "PromVentaAnoAnterior",
                        "render": function ( data, type, row, meta ) {
                            var count = Object.keys(row).length;
                            if(count == 0){
                                return "-";
                            }else {
                                var arti=parseFloat(row.PromVentaAnoAnterior).toFixed(2);
                                return arti;
                            }
                        }
                    },
					{ data: "CUOTAGTM" },
					{ data: null },// Faltante venta
					{ data: "avanceMes" },
					//{ data: "KR" },
					{ data: "CIE" },
					{ data: "ORO" },
					{ data: "SPR" },
					{ data: "CIF" },
					{ data: "PUL" },
					{ data: "VOL" },
					{ data: "OTROS" },
					/*{ data: "tipoCobertura" },*/
					{ data: null },
					/*{ data: "Programado" },
					{ data: "Transcurrido" },
                    { data: "Liquidado" },
					{ data: "venAnoAnterior" },
					{ data: "LiquidadoAnoAnterior" },
					{ data: "venMesAnterior" },
					{ data: "LiquidadoMesAnterior" },
					{ data: "AvanceMesActual" },
					{ data: "avanceAnual" },*/
					{ data: "SEGMENTO" },
					{ data: "EXHIBIDORES" },
					{ data: "NROPTAFRIOGTM" },
					{ data: "TMLOCALGTM" }
				],
				"columnDefs": [ 
					{
						"targets": 1,
						"visible": false
					},
					{
                        "targets": 2,
                        "data": null,
                        "render": function ( data, type, row, meta ) {
                           return ( parseFloat( row.hitrate) ).toFixed(0) + "%";	
                        }
                    },
                    {
                        "targets": 7,
                        "data": null,
                        "render": function ( data, type, row, meta ) {
                           return ( parseFloat(row.PromVentaMesAnterior)  - parseFloat( row.ventaDia ) ).toFixed(2);	
                        }
                    },                 
                    {
                        "targets": 8,
                        "data": null,
                        "render": function ( data, type, row, meta ) {
                           return ( parseFloat( row.avanceMes) ).toFixed(0)  +"%";
                        }
                    },                 
                    {
                        "targets": 17,
                        "data": null,
                        "render": function ( data, type, row, meta ) {
                           return ( parseFloat( row.CoberturaMultiple) ).toFixed(0)  +"%";
                        }
                    }
				],
                "language":  languageES,
				"order": [[ 7, "desc" ]],
				"rowCallback": function( row, data, index ) {
					// HitRate
					  if (data.hitrate < 50) { 
						$('td:nth-child(2)', row).css(styleRed);
					  }else if(data.hitrate >= 50 && data.hitrate < 80 ){
						$('td:nth-child(2)', row).css('background-color', 'orange');  
					  }else{
						$('td:nth-child(2)', row).css(styleGreen);   
					  }
				  
				  //CoberturaMultiple
				  if (data.CoberturaMultiple < 50) { 
					$('td:nth-child(17)', row).css(styleRed);
				  }else if(data.CoberturaMultiple >= 50 && data.CoberturaMultiple < 80 ){
					$('td:nth-child(17)', row).css('background-color', 'orange');  
				  }else{
					$('td:nth-child(17)', row).css(styleGreen);   
				  }
				  
				  //Faltante Venta
				  var faltanteVenta = ( parseFloat(data.PromVentaMesAnterior)  - parseFloat( data.ventaDia ) ).toFixed(2);
				  if (faltanteVenta > 50) { 
					$('td:nth-child(7)', row).css(styleRed);
				  }else if(faltanteVenta <= 50 && faltanteVenta > 3 ){
					$('td:nth-child(7)', row).css('background-color', 'orange');  
				  }else{
					$('td:nth-child(7)', row).css(styleGreen);   
				  }
				 
				  //Avance Mes
				  if (data.avanceMes < 50) { 
					$('td:nth-child(8)', row).css(styleRed);
				  }else if(data.avanceMes >= 50 && data.avanceMes < 80 ){
					$('td:nth-child(8)', row).css('background-color', 'orange');  
				  }else{
					$('td:nth-child(8)', row).css(styleGreen);   
				  }
				}
			});
		
        } );

		function limpiarTotales(){
			sumHitRate = 0;
			sumCobMultiple = 0;
			
			sumAvanceVenta = 0;
			sumCuotaDia = 0;
			sumFaltantes = 0;
			sumStatus = 0;
			
			sumFaltantes = 0;
			sumProyectado = 0;
			sumNecesidadDia = 0;
			sumVentaLiquidada = 0;

			actualizarTotales();
		}
		
		$("#menuButton").click(function(){			
			setTimeout('resizeTable()',300);
			setTimeout('resizeTableHitRate()',300); 
		});

		$( "#fomato" ).change(function() {
			limpiarTotales();
			
			actualizarVariablesGlobales(); 
			actualizarTabla();	
			refrescarTablaHitRate();
		});
		
		function actualizarTotales(){
			
			//cantVendedoresPreventa
			var simbolo = "";
			if(formato == "soles"){
				simbolo = "S/.";
			}
			if( sumStatus > 0 ){
				sumStatus = (sumStatus/cantVendedoresPreventa).toFixed(2);
			}
			
			$("#sumAvanceDia").html(simbolo +  new Intl.NumberFormat('es-PE').format( sumAvanceVenta.toFixed(0) ));
			$("#sumCuotaDia").html(simbolo + new Intl.NumberFormat('es-PE').format( sumCuotaDia.toFixed(0) ) );
			$("#sumFaltantes").html(simbolo +  new Intl.NumberFormat('es-PE').format( sumFaltantes.toFixed(0) ) );
			
			$("#sumCobMultiple").html(sumCobMultiple.toFixed(2)+" %");
			$("#sumHitRate").html( sumHitRate.toFixed(2)+" %");
			$("#sumStatus").html( sumStatus +" %");
			 
			$("#sumProyectado").html( sumProyectado +" %"); 
			
			sumVentaLiquidada = new Intl.NumberFormat('es-PE').format( sumVentaLiquidada.toFixed(0) );
			sumNecesidadDia = new Intl.NumberFormat('es-PE').format( sumNecesidadDia.toFixed(0) );
			 
			$("#sumVentaLiquidada").html(simbolo + sumVentaLiquidada );
			$("#sumNecesidadDia").html(simbolo + sumNecesidadDia); //  new Intl.NumberFormat('es-PE').format( sumNecesidadDia.toFixed(0) ) ); //.html( sumNecesidadDia );
			 
		}
			
		function actualizarTablaHitRate(codVendedor, nombre ){ 
			vendedor = codVendedor;
			$("#clienteActual").html(nombre);
			actualizarVariablesGlobales(); 
			
			refrescarTablaHitRate();
		}
		
		function actualizarVariablesGlobales(){
			formato = $( "#fomato option:selected" ).val();
		}
		
       function refrescarTablaHitRate(){
			$("#formatoTabla").html(" ("+formato+")");
			
			tableHitRate.ajax.reload(function ( json ) {
				setTimeout('resizeTableHitRate()',320); 
			} );			
		}
		
		function actualizarTabla(){			
			tableVendedores.ajax.reload( function ( json ) {
				 setTimeout('resizeTable()',320); 
			} );
		}
		
		function actualizarEstrellas(numFilas){ 
			for( n = 1; n <= numFilas; n++){
				var fila = $('#tableVendedores tr:nth-child('+n+') td:nth-child('+(9)+')');
				var avance = parseInt( fila.text().replace(",", ""));
				if( avance>= promedioPreVenta){
					fila.html(avance+'<i class="fa fa-fw fa-star text-yellow"></i>');
				}
			}
		}
		
		function actualizarStatus(numFilas){ 
			for( n = 1; n <= numFilas; n++){
				var fila = $('#tableVendedores tr:nth-child('+n+') td:nth-child('+(7)+')');
				var valor =   $('#tableVendedores tr:nth-child('+n+') td:nth-child(4)').text() .replace(",", "") ;
				 
				
				var porcentaje = ( ( valor * 100 )/ mayor ).toFixed(0);
				if(isNaN(porcentaje)){
					porcentaje = 0;
				}else{
					sumStatus = parseInt(porcentaje)+ sumStatus;
				}
								
				if( porcentaje >= 100 ){					
					fila.html('<span class="text-green">'+porcentaje+' %</span>');
				}else{ 
					fila.html(porcentaje+' %');
				} 
			}
		}
		//
		function resizeTable(){
			limpiarTotales();
            tableVendedores.columns.adjust().draw();
        }  
		
		function resizeTableHitRate(){
            tableHitRate.columns.adjust().draw();
        }
    </script>
@stop