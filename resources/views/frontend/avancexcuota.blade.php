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
							<thead class="bg-blue">
							<tr>
								<th>VENDEDOR</th>								
								<th>Avance de Venta</th>
								<th>Cuota Día</th>
								<th>Cajas Faltantes</th>
								<th>Status</th>
							</tr>
							</thead>
							<tfoot class="bg-blue footer">
							<tr>
								<th>TOTAL</th>
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
		var	promedioPreVenta = 0.0;	
		var mayor = 0;
		
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
			});
			$('#timeHasta').timepicker({
			  showInputs: false
			});
	
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
				lengthMenu:[[ 15,25,45,50, -1 ],[ "15","25", "45", "50", "Todo" ]],
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
				"fixedColumns" : { leftColumns: 1 },				
                "ajax": {
                    "url" : 'get/obtenerAvancexCuota',
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
				"columns":[
					{ data: "nombrex" },
                    { data: "totalPaquetes" },
					{ data: "cuotaDia" },
                    { data: null },	
					{ data: null },	
				],
				"columnDefs": [                    
					{
                        "targets": 3,
                        "data": null,
                        "render": function ( data, type, row, meta ) {
							var resto = parseInt(row.cuotaDia) - parseInt(row.totalPaquetes);							
							return resto <= 0 ? 0: '<span class="text-red">'+resto+'</span>';	                            
                        }
                    }
				],
                "language":  languageES,
				"order": [[ 1, "desc" ]],
				"footerCallback": function ( row, data, start, end, display ){
					var api = this.api(), data;
					var columna = 1;
					var totalPreVenta = 0;
										
					var intVal = function ( i ) {
						return typeof i === 'string' ?  parseInt(i) :typeof i === 'number' ?i : 0;
					};
						
					while(columna <= 3){ 						
						// Total de todas las paginas
						total = api
							.column( columna )
							.data()
							.reduce( function (a, b) {								
								if(columna == 3){
									var resto = parseInt(b.cuotaDia) - parseInt(b.totalPaquetes);
									if(resto <= 0 ){
										resto = 0;
									}
									return intVal(a) + intVal(resto);								
								}else{
									return intVal(a) + intVal(b);
								}
							}, 0 );
						
						if( columna == 1 ){
							totalPreVenta = total;
						}			 
						// Update footer
						$( api.column( columna ).footer() ).html( total );
						columna = columna +1;
					}
					
					console.log( "mayor: "+ mayor );
					$.each( api.column( 1 ).data() , function(i, item) {
						
						if( parseInt(item) > mayor){
							mayor = parseInt(item);
							console.log(item +" > "+mayor);
						} 
					});
				
					
					var cantVendedoresPreventa = api.column( 1 )
													.data()
													.reduce( function (a, b) {
														if( intVal(b) > 0 ){
															return intVal(a) +1
														}
														return intVal(a);														
													}, 0 );
													
					promedioPreVenta = (totalPreVenta/cantVendedoresPreventa)/*.toFixed(2)*/;
					promedioPreVenta = promedioPreVenta.toFixed(2);
					$("#promedioVendedores").html(promedioPreVenta);
					
					var filas = api.column( 2 ).data().length;
					actualizarEstrellas(filas); 
					actualizarStatus(filas); 
				}
            });
			
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
				setTimeout('resizeTable()',320); 
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
                },100);
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
		
		function actualizarEstrellas(numFilas){ 
			for( n = 1; n <= numFilas; n++){
				var fila = $('#tableVendedores tr:nth-child('+n+') td:nth-child('+(2)+')');
				var avance = parseInt(fila.text());
				if( avance>= promedioPreVenta){
					fila.html(avance+'<i class="fa fa-fw fa-star text-yellow"></i>');
				}
			}
		}
		
		function actualizarStatus(numFilas){ 
			for( n = 1; n <= numFilas; n++){
				var fila = $('#tableVendedores tr:nth-child('+n+') td:nth-child('+(5)+')');
				var valor =  parseInt( $('#tableVendedores tr:nth-child('+n+') td:nth-child('+(2)+')').text() );
				console.log( valor );
				
				var porcentaje = ( ( valor * 100 )/ mayor ).toFixed(0);
				if( porcentaje >= 100 ){					
					fila.html('<span class="text-green">'+porcentaje+' %</span>');
				}else{ 
					fila.html(porcentaje+' %');
				} 
			}
		}
    </script>
@stop