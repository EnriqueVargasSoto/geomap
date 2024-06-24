@extends('layouts.frontend.master')
@section('style')
    <!-- Datatable -->
    <link rel="stylesheet" type="text/css" href="{{ url('/') }}/plugins/datatable/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="{{ url('/') }}/plugins/datatable/buttons.dataTables.min.css">
    <style>
		.select2-selection select2-selection--single{
			padding-bottom: 25px;
		}
		.col-lg-3 .form-buttons{
            padding-top: 0px;
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
		h4#myLargeModalLabel {
			display: inline-block;
		}
		.label-progress, .label-cantidad{
			font-size: 11.5px;
			padding-right: 8px;
		}
		.progress.sm{
			height: 14px;
			position:relative;
		}
		.progress-bar{
			position:relative;			
		}
		.label-progress{
			float: left;	
			position: absolute;
			z-index: 99;		
		}
		.label-cantidad{
			float: right;	
			right: 0px;
			position: absolute			
		}
		.progress.sm{
			margin-bottom: 10px !important;
		}
		.progress-bar-aqua{
			background-color: #15e5eca6;
		}
		select.form-control{
			font-size: 13px;    
			height: 26px; 
			padding-top: 0px;
			padding-bottom: 0px;
		}
		#formatoTabla{
			text-transform: uppercase;
		}
    </style>
@stop
@section('content')
 <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content">
		<div class="box box-success">
            <div class="box-header with-border">
			 <div class="row"> 
				<div class="col-md-5">
					<h3 class="box-title">Indicadores por Sucursal</h3>
				</div>
				<div class="col-md-6">
					<select id="fomato" class="form-control">
						<option value="soles">Formato:   Soles</option>
						<option value="paquete">Formato:  Paquetes</option>
					</select>
				</div>
				<div class="col-md-1">
					<div class="box-tools pull-right">
						<button id="btnGrafico" type="button" class="btn btn-box-tool" > <i class="fa fa-fw fa-refresh"></i></button>
						<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					</div>
				</div>
            </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="row">                    
					<div class="col-md-offset-1 col-md-10 ">
						<div id="graficoBarras"></div>
						<div id="overlay-grafico" class="overlay" style="height: 30px; position: inherit;"><i class="fa fa-refresh fa-spin"></i></div>
					</div>
                </div>
            </div>
        </div>
		
		<div class="box box-primary">
			<div class="box-header with-border">
				 <div class="row"> 
					<div class="col-md-5">
						<h3 class="box-title">Indicadores por Vendedor <small id="formatoTabla"> (soles)</small></h3>
					</div>
					<div class="col-md-6">
						 <select id="vendedores" class="form-control select2">
                                <option value="all">Todos</option>
                            </select>
					</div>
					<div class="col-md-1">
						<div class="box-tools pull-right">
							<button id="btnBuscar" type="button" class="btn btn-box-tool" > <i class="fa fa-fw fa-refresh"></i></button>
							<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
						</div>
					</div>
				</div>
			</div>				
			<div class="box-body">
				<div class="row">
					<div class="col-xs-12">				
						<table id="tableVendedores"  class="row-border hover order-column" width="100%">
							<thead class="bg-blue">
							<tr> 
								<th>Cliente</th>
								<th>HR%</th>
								<th>Venta Día</th>
								<th>Prom MA</th>
								<th>Prom AA</th>
								<th>Cuota Diaria</th>
								<th>Faltante Venta</th>
								<th>Avance Mes</th>
								<th>KR</th>
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
								<th>HR%</th>
								<th>Venta Día</th>
								<th>Prom MA</th>
								<th>Prom AA</th>
								<th>Cuota Diaria</th>
								<th>Faltante Venta</th>
								<th>Avance Mes</th>
								<th>KR</th>
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

    <div id="overlay" class="overlay"><i class="fa fa-refresh fa-spin"></i></div>
   
   <!-- Modal -->
	<div class="modal fade" id="modalMarcas" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="myLargeModalLabel">Marcas por Cliente</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">×</span>
				</button>
			  </div>
		  <div class="modal-body">
			<div class="row">
					<div class="col-xs-12">				
						<table id="tableMarca"  class="row-border hover order-column" width="100%">
							<thead class="bg-blue">
							<tr> 
								<th>Marca</th>
								<th>Paquetes</th>
							</tr>
							</thead>
							<tfoot class="bg-blue footer">
							<tr>
								<th>Total</th>
								<th>0.0</th>
							</tr>
							</tfoot>
						</table>
					</div>
				</div>	
		  </div>
		</div>
	  </div>
	</div>
	
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
        var esquema;
        //var timerSincronizacion;		
        var tableVendedores, tableMarca;
        var languageES;
		
		var vendedor = '0';
		var formato = 'soles';
		var clientePublic = '0';
        
		var styleRed = {  backgroundColor : "red", color: "white" };
		var styleGreen = {  backgroundColor : "green", color: "white" };
	
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

            //timerSincronizacion = null;
			//fc_validarTimer();
			/*
			tableMarca = $('#tableMarca').DataTable( {
                "processing": true,
                "scrollX": true, 
				lengthMenu:[[ 15,25,45,50, -1],[ "15","25", "45", "50", "Todo" ]],               			
                "ajax": {
                    "url" : 'get/obtenerIndicadorMarca',
                    "type": 'POST',
                    "dataSrc": '',
					"data" : function(d){
						return { 
							"cliente" : clientePublic,
						};
					}
                },
				"columns":[
					{ data: "marca" },
					{ data: "CanPaq" }
				],
                "language":  languageES,
				"order": [[ 1, "desc" ]],
				"rowCallback": function( row, data, index ) {
				  if (data.CanPaq <= 0) { 
					$('td:nth-child(2)', row).css('background-color', 'yellow');
				  }
				},
				"footerCallback": function ( row, data, start, end, display ){
					var api = this.api(), data;
					var columna = 1;
					var total = 0;		
					var intVal = function ( i ) {
						return typeof i === 'string' ?  parseInt(i) :typeof i === 'number' ?i : 0;
					};
					
					while(columna <= 1){ 						
						// Total de todas las paginas
						total = api
							.column( columna )
							.data()
							.reduce( function (a, b) {								
								if(columna == 1){
									var resto = parseInt(b);
									if(resto <= 0 ){
										resto = 0; 
									}
									return intVal(a) + intVal(resto);								
								}else{
									return intVal(a) + intVal(b);
								}
							}, 0 );
							 
						// Update footer
						console.log(total);
						$( api.column( columna ).footer() ).html( total );
						columna = columna +1;
					}
														
				}
			});
			*/			
			
			tableVendedores = $('#tableVendedores').DataTable( {
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
					{ data: null },
					{ data: "ventaDia" },
					{ data: "PromVentaMesAnterior" },
					{ data: "PromVentaAnoAnterior" },
					{ data: "CUOTAGTM" },
					{ data: null },// Faltante venta
					{ data: "avanceMes" },
					{ data: "KR" },
					{ data: "CIE" },
					{ data: "ORO" },
					{ data: "SPR" },
					{ data: "CIF" },
					{ data: "PUL" },
					{ data: "VOL" },
					{ data: "OTROS" },
					/*{ data: "tipoCobertura" },*/
					{ data: "CoberturaMultiple" },
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
                        "data": null,
                        "render": function ( data, type, row, meta ) {
                           return row.hitrate+"%";	
                        }
                    },
                    {
                        "targets": 6,
                        "data": null,
                        "render": function ( data, type, row, meta ) {
                           return ( parseFloat(row.PromVentaMesAnterior)  - parseFloat( row.ventaDia ) ).toFixed(2);	
                        }
                    },
                   /* {
                        "targets": 25,
                        "data": null,
                        "render": function ( data, type, row, meta ) {
                           return row.avanceAnual+"%";
                        }
                    },*/
                    {
                        "targets": 7,
                        "data": null,
                        "render": function ( data, type, row, meta ) {
                           return row.avanceMes+"%";
                        }
                    }
				],
                "language":  languageES,
				"order": [[ 1, "desc" ]],
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
				  
				  //Avance Anual
				 /* if (data.avanceAnual < 50) { 
					$('td:nth-child(26)', row).css(styleRed);
				  }else if(data.avanceAnual >= 50 && data.avanceAnual < 80 ){
					$('td:nth-child(26)', row).css('background-color', 'orange');  
				  }else{
					$('td:nth-child(26)', row).css(styleGreen);   
				  }*/
				  
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
					
            $("#btnBuscar").click(function(){
				actualizarVariablesGlobales();  
				actualizarTabla();
            });
			
			$("#btnGrafico").click(function(){
				actualizarVariablesGlobales();  
				sc_obtenerGrafico();
				actualizarTabla();			 
            });
			
			$("#btnLimpiar").click(function(){
				limpiarCampos(); 
			});

			$( "#fomato" ).change(function() {
				actualizarVariablesGlobales();  
				sc_obtenerGrafico();
				actualizarTabla();	
			});
			
			$( "#vendedores" ).change(function() {
				actualizarVariablesGlobales(); 
				actualizarTabla();	
			});
			
			function actualizarVariablesGlobales(){
				vendedor = $("#vendedores").val();
				formato = $( "#fomato option:selected" ).val();
			}
									
            $("#menuButton").click(function(){  
                setTimeout('resizeTable()',320); 
            });

			$('#vendedores').select2({ language: 'es'});
			
			sc_obtenerVendedores();
			
			sc_obtenerGrafico();
			
        } );

		/*function mostrarModalCliente (cliente){ //obtenerIndicadorMarca	
			clientePublic = cliente;
			tableMarca.ajax.reload( null, false );
			$('#modalMarcas').modal({  keyboard: false  });
		}*/
			
		function limpiarCampos(){
			vendedor = "0";
			$('#vendedores').val('all'); 
			$('#vendedores').trigger('change'); 			
			actualizarTabla(); 
		}
			
		function sc_obtenerVendedores() {
			$("#overlay").removeClass("hidden");
			$("#vendedores").empty();
			
			var zona = $("#vendedores").val();
			$.ajax({
				global: false,
				type: "POST",
				dataType: 'json', 
				url: "get/vendedores"
			})
			.done(function(jsondata) {
				var select = $("#vendedores");
				select.append("<option value='all'>Ninguno</option>");
				$.each(jsondata, function(index, element){
					select.append("<option value='"+ element['idPersona'] +"'>" + element['nombre'].toLowerCase() +"- "+element['idPersona'] + "</option>"); 
				}); 
				select.prop( "disabled", false ); 
				$("#overlay").addClass("hidden"); 
			})
			.fail(function() {
				alert( "Error" );
			});
		}
		
		function sc_obtenerGrafico() {
			$("#graficoBarras").html(""); 
			$("#overlay-grafico").removeClass("hidden");
			console.log(formato);
			$.ajax({
				global: false,
				type: "POST",
				dataType: 'json', 
				url: "get/obtenerIndicadorHRXSucursal",
				data: {"formato": formato }
			})
			.done(function(jsondata) {	
				$("#overlay-grafico").addClass("hidden");
				
				var maximo = 0;	
				var porcentaje = 0;	
				
				$.each(jsondata, function(index, element){
					if(index == 0 && element.cantidad > 0){
						maximo = element.cantidad;
					}
					
					if( maximo > 100){
						porcentaje = (element.cantidad * 100)/ maximo;
					}else{
						porcentaje = element.cantidad;
					}
					$("#graficoBarras").append('<div class="progress-group"><div class="progress sm"><span class="label-progress">'+element.marca+'</span><div class="progress-bar progress-bar-aqua" style="width: '+porcentaje+'%"></div><span  class="label-cantidad">'+element.cantidad+'</span></div></div> '); 
				}); 
				  
			})
			.fail(function() {
				alert( "Error" );
			});
		}
		
        function resizeTable(){
            tableVendedores.columns.adjust().draw();
        }      
		
		function actualizarTabla(){
			$("#formatoTabla").html(" ("+formato+")");
			tableVendedores.ajax.reload( function ( json ) {
				 setTimeout('resizeTable()',320); 
			} );
		}
		
    </script>
@stop