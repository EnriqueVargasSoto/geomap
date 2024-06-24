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

    </style>
@stop
@section('content')
 <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content">
        {{--<div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Filtros para la búsqueda </h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="row">                    
					<div class="col-lg-2">
                        <div class="form-group">
                            <label>Fecha Desde:</label>
                            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" class="form-control pull-right" id="fechaDesde" value="">
                            </div>
                        </div>
                    </div>
					<div class="col-lg-2">
						<div class="bootstrap-timepicker">
							<div class="form-group">
								<label>Hora Desde:</label>
								<div class="input-group date">
									<div class="input-group-addon">
										<i class="fa fa-clock-o"></i>
									</div>
									<input type="text" class="form-control pull-right" id="timeDesde" value="">
								</div>
							</div>
						</div>
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label>Fecha Hasta:</label>
                            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" class="form-control pull-right" id="fechaHasta" value="">
                            </div>
                        </div>
                    </div>
					<div class="col-lg-2">
						<div class="bootstrap-timepicker">
							<div class="form-group">
								<label>Hora Hasta:</label>
								<div class="input-group date">
									<div class="input-group-addon">
										<i class="fa fa-clock-o"></i>
									</div>
									<input type="text" class="form-control pull-right" id="timeHasta" value="">
								</div>
							</div>
						</div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-buttons">
                            <button id="btnBuscarPreventa" class="btn btn-primary"><i class="fa fa-fw fa-search"></i> Buscar</button>
                            <button id="btnLimpiarPreventa" class="btn btn-default"><i class="fa fa-fw fa-trash"></i> Limpiar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>--}}
       
		<div class="box box-primary">
			<div class="box-body">
				<div class="row">
					<div class="col-xs-12">				
						<table id="tableVendedores"  class="row-border hover order-column" width="100%">
							<!--table id="example" class="row-border hover order-column responsive" cellspacing="0" width="100%"-->
							<thead class="bg-blue">
							<tr>
								<th>VENDEDOR&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
								@foreach ($marcas as $marca)
								<th>{{ $marca->descripcion }}</th>
								@endForeach
								<th>Avance Pre_venta</th>
							</tr>
							</thead>
							<tfoot class="bg-blue footer">
							<tr>
								<th>TOTAL </th>
								@foreach ($marcas as $marca)
								<th>{{ $marca->descripcion }}</th>
								@endForeach 
								<th>Avance Pre_venta</th>
							</tr>
							</tfoot>
						</table>
					</div>
				</div>
			</div>
		</div>
		        
    </section>

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
	<link rel="stylesheet" type="text/css" href="{{ url('/') }}/plugins/datepicker/datepicker3.css">
	<link rel="stylesheet" type="text/css" href="{{ url('/') }}/plugins/timepicker/bootstrap-timepicker.min.css">
	<script type="text/javascript" language="javascript" src="{{ url('/') }}/plugins/datepicker/bootstrap-datepicker.js"></script>
	<script type="text/javascript" language="javascript" src="{{ url('/') }}/plugins/timepicker/bootstrap-timepicker.min.js"></script>
    <script>
        var esquema;
        var timerSincronizacion;		
        var tableVendedores;
        var languageES;
		var fechaDesde = '';
		var fechaHasta = '';
		var timeDesde = '';
		var timeHasta = '';
		var datosMarca;
		var totalMarcas = 0;
				
        $(document).ready(function() {
			
			$.fn.datepicker.dates['es'] = {
				days: ["Domingo", "Lunes", "Martes", "MiÃ©rcoles", "Jueves", "Viernes", "SÃ¡bado", "Domingo"],
				daysShort: ["Dom", "Lun", "Mar", "MiÃ©", "Jue", "Vie", "SÃ¡b", "Dom"],
				daysMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa", "Do"],
				months: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
				monthsShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"],
				today: "Hoy"
			};

			$("#fechaDesde").datepicker({ language: "es", format: 'dd/mm/yyyy' });
			$("#fechaHasta").datepicker({ language: "es",format: 'dd/mm/yyyy' });
			
			//Timepicker
			$('#timeDesde').timepicker({
			  showInputs: false
			})
			$('#timeHasta').timepicker({
				 showInputs: false
			});
	
			datosMarca = [	
				{ data: 'vendedor' },
				@foreach ($marcas as $marca)
					{ data:	'{{ rtrim($marca->descripcion) }}' },
				@endForeach                 
				{ data: null }
			];
			totalMarcas = {{ count($marcas) }} ;
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
			            
			tableVendedores = $('#tableVendedores').DataTable( {
                "processing": true,
                "scrollX": true, 
				dom: 'Bfrltip',
				lengthMenu:[[   15,25,45,50, -1],[ "15","25", "45", "50", "Todo" ]],
                buttons: [
                    {
                        extend:    'excelHtml5',
                        text:      '<i class="fa fa-file-excel-o"></i>',
                        titleAttr: 'Excel'
                    }				
                ],	
				"fixedColumns" :{
					leftColumns: 1
				},				
                "ajax": {
                    "url" : 'get/obtenerAvancexMarca',
                    "type": 'POST',
                    "dataSrc": '',
					"data" : function(d){
						return { 
							"fechaDesde" : fechaDesde,
							"fechaHasta" : fechaHasta,
							"timeDesde" : timeDesde,
							"timeHasta" : timeHasta
						};
					}
                },
				"columns":datosMarca ,
				"columnDefs": [
                    {
                        "targets": -1,
                        "data": "",
                        "render": function ( data, type, row, meta ) {
							var total = 0;
							$.each(row, function(i, item) {								
								if(i != "idVendedor" && i != "vendedor" && item != null){
									total = total +  parseInt(item);									
								}
							});
                           return total;
                        }
                    }
				],
                "language":  languageES,
				"footerCallback": function ( row, data, start, end, display ) {
					var api = this.api(), data;
					var columna = 1;
					// Remove the formatting to get integer data for summation
					var intVal = function ( i ) {
						return typeof i === 'string' ?
							i.replace(/[\$,]/g, '')*1 :
							typeof i === 'number' ?
								i : 0;
					};
						
					while(columna <= totalMarcas){ 						
						// Total de todas las paginas
						total = api
							.column( columna )
							.data()
							.reduce( function (a, b) {
								return intVal(a) + intVal(b);
							}, 0 );
									 
						// Update footer
						$( api.column( columna ).footer() ).html( total );
						columna = columna +1;
					}
					
					var totalTotales = 0;
					var ultimaColumna = totalMarcas + 1;
					var filas = api.column( ultimaColumna ).data().length;
					
					for( n = 1; n <= filas; n++){
						totalTotales = totalTotales + parseInt( $('#tableVendedores tr:nth-child('+n+') td:nth-child('+( ultimaColumna + 1 )+')').text());
					}
					$( api.column( ultimaColumna ).footer() ).html( totalTotales );
					
				}
            } );

			
            $('#tableVendedores tbody').on( 'mouseenter', 'td', function () {
			   if(typeof tableVendedores.cell(this).index() != 'undefined'){
				    var colIdx = tableVendedores.cell(this).index().column;
					$( tableVendedores.cells().nodes() ).removeClass( 'highlight-blue' );
					$( tableVendedores.column( colIdx ).nodes() ).addClass( 'highlight-blue' );
			   }               
            });
			
			function limpiarCampos(){
				clearInterval(timerSincronizacion);				
               actualizarTabla();
			}
			
            $("#btnBuscarPreventa").click(function(){
				actualizarVariablesGlobales(); 
				limpiarCampos();
				resizeTable();
            });
			
			$("#btnLimpiarPreventa").click(function(){				
				fechaDesde = "";
				fechaHasta = "";
				timeDesde = "";
				timeHasta = "";
							
				$("#fechaDesde").val("");
				$("#fechaHasta").val("");
				
				$("#timeDesde").val("");
				$("#timeHasta").val("");
				limpiarCampos();
				setTimeout('resizeTable()',320); 
			});

			function actualizarVariablesGlobales(){
				fechaDesde = $("#fechaDesde").val();
				fechaHasta = $("#fechaHasta").val();
				
				timeDesde = $("#timeDesde").val();
				timeHasta = $("#timeHasta").val();
			}
									
            $("#menuButton").click(function(){  
                setTimeout('resizeTable()',320); 
            });

            function fc_validarTimer(){
                if (timerSincronizacion){ clearInterval(timerSincronizacion); }
               
			    timerSincronizacion = setTimeout(function() {
                    actualizarTabla();
                }, 100);
               
            }
        } );

        function resizeTable(){
            tableVendedores.columns.adjust().draw();
        }  
		
		function actualizarTabla(){
			tableVendedores.ajax.reload( function ( json ) {
				 setTimeout('resizeTable()',320); 
			} );
		}
    </script>
@stop