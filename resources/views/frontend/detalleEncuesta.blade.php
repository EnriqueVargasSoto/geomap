@extends('layouts.frontend.master')
@section('style')
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" type="text/css" href="bower_components/datatable/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="bower_components/datatable/buttons.dataTables.min.css">
	<link href="{{ url('/') }}/plugins/iCheck/flat/green.css" rel="stylesheet">
    <!-- Select2 -->
    <link rel="stylesheet" href="bower_components/select2/css/select2.min.css">
    <style>
        .form-group label{
            display: block;
        }
        td.highlight {
            background-color: whitesmoke !important;
        }
		.btn-group button{
			font-size: 13px;
		}
        table.DTFC_Cloned thead,table.DTFC_Cloned tfoot{background-color:white}
        div.DTFC_Blocker{background-color:white}
        div.DTFC_LeftWrapper table.dataTable,div.DTFC_RightWrapper table.dataTable{margin-bottom:0;z-index:2}
        div.DTFC_LeftWrapper table.dataTable.no-footer,div.DTFC_RightWrapper table.dataTable.no-footer{border-bottom:none}
        .center{
			text-align: center;
		}
		@media (min-width: 992px){
            .col-md-8 .btn-group{
                padding-top: 25px;
            }
        }
        @media (min-width: 1200px){
            .modal-dialog{
                width: 70%;
            }
            .col-lg-12 .btn-group{
                padding-top: 0px;
            }
        }
		#ultimaHoraDashboard{
			font-size: 16px;
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
                            <label>Zona:</label>
                            <select id="zonasPreventa" class="form-control select2">
                                <option value="all">Todas</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4">
                        <div class="form-group">
                            <label>Ruta:</label>
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
                        <div class="form-group">
                            <label>Operación:</label>
                            <select id="operacionFiltro" class="form-control select2">
                                <option value="preventa">Preventa</option>
								<option value="autoventa">Autoventa</option>
								<option value="all" selected>Todos</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-8">

						
						<div class="btn-group"> 									
							<button id="btnBuscarPreventa" type="button" class="btn btn-primary btn-sm"><i class="fa fa-fw fa-search"></i>  Buscar </button>
							<button id="btnLimpiarPreventa" type="button" class="btn btn-default btn-sm"><i class="fa fa-fw fa-trash"></i>  Limpiar</button>
						    <button type="button" class="btn btn-default btn-sm"><i class="fa fa-refresh"></i>&nbsp;&nbsp;Resincronizar Pedido </button>						   
						    <button id="btnActualizarGuias" type="button" class="btn btn-default btn-sm"><i class="fa fa-fw fa-lock"></i>  Cerrar día</button>
						</div>
						<!-- Check all button -->
						<button id="checkbox-toggle" name="checkAll"  type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"> </i>   Todos
						</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header with-border">
						<div class="row">
							<div class="col-lg-2 col-xs-6">
							  <!-- small box -->
							  <div class="small-box bg-teal">
								<div class="inner">
								  <h3 id="vendedoresDashboard">0</h3>
								  <p>Vendedores</p>
								</div>
								<div class="icon">
								  <i class="ion ion-ios-people"></i>
								</div> 
							  </div>
							</div>
							<!-- ./col -->							
							<div class="col-lg-2 col-xs-6">
							  <!-- small box -->
							  <div class="small-box bg-green">
								<div class="inner">
								  <h3 id="pedidosCompletosDashboard">0</h3>
								  <p>Completos</p>
								</div>
								<div class="icon">
								  <i class="fa fa-fw fa-heart"></i>
								</div>
							  </div>
							</div>
							<!-- ./col -->
							<div class="col-lg-2 col-xs-6">
							  <!-- small box -->
							  <div class="small-box bg-blue">
								<div class="inner">
								  <h3 id="pedidosPendientesDashboard">0 </h3> 
								  <p>Pendientes</p>
								</div>
								<div class="icon">
								  <i class="fa fa-fw fa-cart-plus"></i>
								</div>
							  </div>
							</div>
							<!-- ./col --> 
							<div class="col-lg-2 col-xs-6">
							  <!-- small box -->
							  <div class="small-box bg-maroon">
								<div class="inner">
								  <h3 id="pedidosFaltantesDashboard">0</h3> 
								  <p>Faltantes</p>
								</div>
								<div class="icon">
								  <i class="fa fa-fw fa-heartbeat"></i>
								</div> 
							  </div>
							</div>
							<!-- ./col -->
							<div class="col-lg-2 col-xs-6">
							  <!-- small box -->
							  <div class="small-box bg-red">
								<div class="inner">
								  <h3 id="excesoDashboard">0</h3> 
								  <p>Exceso</p>
								</div>
								<div class="icon">
								  <i class="fa fa-warning"></i>
								</div> 
							  </div>
							</div>
							<!-- ./col -->
							<div class="col-lg-2 col-xs-6">
							  <!-- small box -->
							  <div class="small-box bg-yellow">
								<div class="inner">
								  <h3 id="cantidadPaquetesDashboard">0</h3> 
								  <p>Cantidad</p>
								</div>
								<div class="icon">
								  <i class="ion-cube"></i>
								</div> 
							  </div>
							</div>
							<!-- ./col -->
						</div>
						
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="tableVendedores"  class="row-border hover order-column" width="100%">
                            <!--table id="example" class="row-border hover order-column responsive" cellspacing="0" width="100%"-->
                            <thead>
							<tr>
								<th rowspan="2"></th>
                                <th rowspan="2">Nombre Completo </th>
								<th rowspan="2">Vendedor</th>
								<th rowspan="2">Zona</th>
                                <th rowspan="2">Ruta</th>
								<th rowspan="2">Teléfono</th>
                                <th rowspan="2">Operación</th>
                                <th rowspan="2">H.Inicio</th>
                                <th rowspan="2">H.Primer </th>
                                <th rowspan="2">Último env</th>
                                <th rowspan="2">Cant.Pedido</th> 
								<th colspan="2">Pedidos/Venta</th>
								<th rowspan="2">No Pedidos</th>
                                <th rowspan="2">Estado</th>
                                <th rowspan="2">Accion</th>
                                <th rowspan="2">S.Completar</th>
                                <th rowspan="2">Bateria</th>
                                <th rowspan="2">GPS</th>
							</tr>
                            <tr> 
                                <th>Cajas</th>
								<th>Cajas(ERP)</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th></th>
                                <th>Nombre Completo </th>
								<th>Vendedor</th>
								<th>Zona</th>
                                <th>Ruta</th>								
								<th>Teléfono</th>
                                <th>Operación</th>
                                <th>H.Inicio</th>
                                <th>H.Primer </th>
                                <th>Último env</th>
                                <th>Cant.Pedido</th> 
								<th>Cajas</th>
								<th>Cajas(ERP)</th>
								<th>No Pedidos</th>
                                <th>Estado</th>
                                <th>Accion</th>
                                <th>S.Completar</th>
                                <th>Bateria</th>
                                <th>GPS</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div> 
					<div class="box-footer">
						<div class="pull-right"><h5><strong>ÚLTIMA ACTUALIZACIÓN  <i class="fa fa-fw fa-clock-o"></i>  </strong> <span id="ultimaHoraDashboard">00:00 </span> </h5></div>
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
	<!-- iCheck 1.0.1 -->
    <script src="{{ url('/') }}/plugins/iCheck/icheck.min.js"></script>
    <!-- Datatable -->
    <script type="text/javascript" language="javascript" src="bower_components/datatable/jquery.dataTables.min.js"></script>
    <script type="text/javascript" language="javascript" src="bower_components/datatable/dataTables.buttons.min.js"></script>
    <script type="text/javascript" language="javascript" src="bower_components/datatable/jszip.min.js"></script>
    <script type="text/javascript" language="javascript" src="bower_components/datatable/pdfmake.min.js"></script>
    <script type="text/javascript" language="javascript" src="bower_components/datatable/vfs_fonts.js"></script>
    <script type="text/javascript" language="javascript" src="bower_components/datatable/buttons.html5.min.js"></script>
    <script type="text/javascript" language="javascript" src="bower_components/datatable/dataTables.fixedColumns.min.js"></script>
    <!-- Select2 -->
    <script src="bower_components/select2/js/select2.min.js"></script>
    <script src="bower_components/select2/js/i18n/es.js"></script>	
    <script>
		var timerSincronizacion;
		var tableVendedores; 
		var languageES;
		var zonaFiltro = 'all';
		var rutaFiltro = 'all';
		var usecheckboxtoggle = false;
		var operacionFiltro  = 'all';
		var vendedoresCheckbox = [];
		var codigoVendedores = [];
		var ultimaHoraDashboard = "00:00";
		var totalVendedoresDashboard  = 0;
		var pedidosCompletosDashboard  = 0;
		var pedidosPendientesDashboard  = 0;
		var pedidosFaltantesDashboard  = 0;
		var excesoDashboard  = "0";
		var cantidadPaquetesDashboard = 0;
		
		
		var fechaPreventaFiltro = $("#fechaPorDefecto").val();
		
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
			timerSincronizacion = null;
			fc_validarTimer();
					  
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
				"fixedColumns" :{
					leftColumns: 2
				},
                "ajax": {
                    "url" : 'get/obtenerResumenPanel',
                    "type": 'POST',
                    "dataSrc": '',
					"data" : function(d){
						return { 
							"ruta" : rutaFiltro,
							"zona" : zonaFiltro,
							"fecha" : fechaPreventaFiltro,
							"operacion" : operacionFiltro
						};
					}
                },
				"fnInitComplete": function(oSettings, jsondata) {	
					procesarDatosDashboard(jsondata);		
					actualizarDashboard();
				},
                "columnDefs": [  
					{
                        "targets": 0,
                        "data": null,						
                        "render": function ( data, type, row, meta ) {  
							if(typeof  vendedoresCheckbox[row.vendedorx] !== "undefined"){
								return '<input type="checkbox" ' + ((vendedoresCheckbox[row.vendedorx] == 1) ? 'checked' : '') + ' id="input' + row.vendedorx + '" class="filter-ck" />';
							}else{
								return '<input type="checkbox" id="input' + row.vendedorx + '" class="filter-ck" />';
							}							
                        }
                    }, 
					
					{
                        "targets": 9,
                        "data": "ultimoEnvio",
                        "render": function ( data, type, row, meta ) {
							compararFechaDashboard(row.ultimoEnvio);
							return row.ultimoEnvio;
                        }
                    }, 
                    {
                        "targets": 15,
                        "data": null,
                        "render": function ( data, type, row, meta ) {
                            var count = Object.keys(row).length;
                            if(count > 0 && row.accion == 'O'){
                                return '<div class="btn-group"><a href="javascript:void(0)" class="btn btn-default btn-xs"  id="href'+row.vendedorx+'" onClick="fc_actualizarGuia(\''+row.vendedorx+'\',\''+row.accion+'\')"> <i class="fa fa-fw fa-lock"></i> Cerrar</a></div>';
                            }else if(count > 0 && row.accion != 'O') {
                               return '<div class="btn-group"><a href="javascript:void(0)" class="btn btn-default btn-xs"  id="href'+row.vendedorx+'"  onClick="fc_actualizarGuia(\''+row.vendedorx+'\',\''+row.accion+'\')"> <i class="fa fa-fw fa-unlock"></i> Abrir</a></div>';
                            } else{
								 return '';
							}
                        }
                    },
                    {
                        "targets": 16,
                        "data": "accion",
                        "render": function ( data, type, row, meta ) {
							return '<div class="btn-group"><a href="javascript:void(0)" class="btn btn-default btn-xs" onClick="fc_sincronizarDataVendedor(\''+row.vendedorx+'\')"><i class="fa fa-fw fa-refresh"></i></a></div>';									
                        }
                    },
                    {
                        "targets": 17,
                        "data": "porcentajeBeteria",
                        "render": function ( data, type, row, meta ) {
                            var count = Object.keys(row).length;
                            if(count > 0 ){
                                return row.porcentajeBeteria+'%';
                            }else {
                                return '0%';
                            }
                        }
                    },
                    {
                        "targets": 18,
                        "data": "GPSActivo",
                        "render": function ( data, type, row, meta ) {
                            var count = Object.keys(row).length;
                            if(count > 0 && row.GPSActivo == "1" ){
                                return '<i class="fa fa-circle text-red"></i>';
                            }else {
                                return '<i class="fa fa-circle text-black"></i>';
                            }
                        }
                    }
                ],
				"fnCreatedRow": function( row, data, dataIndex ) {	
					var clase = "";
				    if ( data["estadoVendedor"] == "EN PROCESO" ){
						clase = "text-maroon";
					}else  if ( data["estadoVendedor"] == "PENDIENTE" ){
						clase = "text-blue";
					}else  if ( data["estadoVendedor"] == "CERRADO" ){
						clase = "text-green";
					}
					$(row).addClass( clase );
					//$( tableVendedores.column( colIdx ).nodes() ).addClass( clase );
					
					$('td:eq(16)', row).addClass( "center" );
					$('td:eq(15)', row).addClass( "center" );
					/*$('td:eq(18)', row).removeClass();*/
					$('td:eq(18)', row).addClass( "center" );
					
				},
                "columns": [
                    { data: null, "orderable": false },
                    { data: "nombrex", defaultContent: "" },
					{ data: "vendedorx", defaultContent: "" },
					{ data: "zonax", defaultContent: "" },
                    { data: "rutax", defaultContent: "" },					
                    { data: "telefonox", defaultContent: "" },
                    { data: "operacion", defaultContent: "" },
                    { data: "horaInicio", defaultContent: "" },
                    { data: "primerEnvio", defaultContent: "" },
					{ data: null  },
                    { data: "cantidadPedidos", defaultContent: "" },
                    { data: "totalPaquetes", defaultContent: "" },
                    { data: "totalPaquetesERP", defaultContent: "" },
                    { data: "cantidadNoCompra", defaultContent: "" },
                    { data: "estadoVendedor", defaultContent: "" },/*.toLowerCase()*/
                    { data: null },
                    { data: null },
                    { data: null },
					{ data: null }
                ],
                "language":  languageES
            } );
			$('#zonasPreventa').select2({ language: 'es',  placeholder: "Todas" });
            $('#rutasPreventa').select2({ language: 'es',  placeholder: "Todas" }); 

			$("#checkbox-toggle").click(function(){
				
				var clicks = $(this).data('clicks');
				desactivarTodo(clicks);			
				
				if (clicks) {
					usecheckboxtoggle = false;
					$(".fa", this).removeClass("fa-check-square-o").addClass('fa-square-o');
				}else{
					usecheckboxtoggle = true;
					$(".fa", this).removeClass("fa-square-o").addClass('fa-check-square-o');
				}
				
				$(this).data("clicks", !clicks);				
			});
	
			function desactivarTodo( estado ){
				$("#tableVendedores_wrapper").find('.filter-ck').each(function (index, element) {
					var vendedor = $(this).attr('id');
					vendedor = vendedor.replace("input", "");	
					
					if(typeof  vendedoresCheckbox[vendedor] == "undefined"){
						codigoVendedores.push(vendedor);
					}
					if (estado) {		
						vendedoresCheckbox[vendedor] = 0;						
						$(this).prop('checked', false);						
					}else {
						vendedoresCheckbox[vendedor] = 1;
						$(this).prop('checked', true);						
					}
				});	
			}
			
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
				
				$("#operacionFiltro").val('all');
				zonaFiltro = "all";
				rutaFiltro = "all";
				operacionFiltro = "all";
				vendedoresCheckbox = [];
				codigoVendedores = [];
				fechaPreventaFiltro = $("#fechaPorDefecto").val();
				$("#fechaPreventa").val(fechaPreventaFiltro);
				limpiarCampos();
				md_obtenerResumenVendedores();
			});

			$('#tableVendedores_wrapper').on( 'click', 'tr', function () {
			   var data = tableVendedores.row(this).data();
			   if (typeof data != 'undefined') {
				    var vendedor = $(this).find('.filter-ck').attr('id');
					vendedor = vendedor.replace("input", "");
					if(typeof  vendedoresCheckbox[vendedor] == "undefined"){
						codigoVendedores.push(vendedor);
					}
					if ($(this).find('.filter-ck').prop('checked')) { 						
						vendedoresCheckbox[vendedor] = 1;
					} else {						
						vendedoresCheckbox[vendedor] = 0;
					}
			   }
			});
 
			$("#btnActualizarGuias").click(function(){
				new PNotify({
				  title: 'Cerrar Guias/Días',
				  text: 'Esta seguro de cerrar todas las guias/días de los vendedores seleccionados?',
				  icon: false,
				  hide: false,
				  confirm: {
					confirm: true
				  },
				  buttons: {
					closer: false,
					sticker: false
				  },
				  history: {
					history: false
				  },
				  type: 'info',
				  addclass: 'stack-modal',
				  stack: {'dir1': 'down', 'dir2': 'right', 'modal': true}
				}).get().on('pnotify.confirm', function(){
					var vendedores = "";
					for (x = 0; x<codigoVendedores.length; x++){
						if( vendedoresCheckbox[codigoVendedores[x]] == 1){
							vendedores = vendedores + codigoVendedores[x]+ ","; 
						}					
					}
					vendedores = vendedores.substring(0, vendedores.length - 1)
					$.ajax({
						global: false,
						type: "POST",
						dataType: 'json',
						data: { "listaVendedores": vendedores },
						url: "update/guias", 
						success: function(jsondata){
							desactivarTodo(true);
							if (usecheckboxtoggle) { 
								usecheckboxtoggle = false;
								$("#checkbox-toggle .fa").removeClass("fa-check-square-o").addClass('fa-square-o');
								$("#checkbox-toggle").data("clicks", false);	
							}				
							actualizarTablaVendedores();	
						}
					}); 
				}).on('pnotify.cancel', function(){
				});
			});
			 
			function actualizarVariablesGlobales(){
				zonaFiltro = $("#zonasPreventa").val();
				rutaFiltro = $("#rutasPreventa").val();
				operacionFiltro = $("#operacionFiltro").val();
				fechaPreventaFiltro = $("#fechaPreventa").val();
			}
			
						
            $("#menuButton").click(function(){  
                setTimeout('resizeTable()',320); 
            });
			
			
			
			function limpiarCampos(){
				vendedores = [];
				listaTablasPedidos = [];
				tableListaPedidosActual = null;
				clearInterval(timerSincronizacion);								 
				$("#modals").html("");				
				$("#nombreVendedor").html("");
				$("#vendedorActual").val("x");
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
						sc_obtenerRutas(); 
						$("#overlay").addClass("hidden");
					}
				});
			}
			
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
						select.append("<option value='"+ element['idRuta'] +"'>" + element['descripcion'] + "</option>"); 
					}); 
					select.prop( "disabled", false ); 
					$("#overlay").addClass("hidden"); 
				})
				.fail(function() {
					alert( "Error" );
				});
            }
			
			function fc_validarTimer(){
                if (timerSincronizacion){ clearInterval(timerSincronizacion); }
                if( $("#fechaPreventa").val() == $("#fechaPorDefecto").val()){
                    timerSincronizacion = setTimeout(function() { 
                        actualizarTablaVendedores();	
                    }, 100);
                }
            }
			
			function md_obtenerResumenVendedores(){
				fc_validarTimer();
				actualizarTablaVendedores();	
			}
			
			
			
		});
		function compararFechaDashboard(fechaNueva){				
				var hora = fechaNueva.split(":");
				var horaActual = ultimaHoraDashboard.split(":");	
				if( parseInt(hora[0]) > parseInt(horaActual[0]) ){								 
					ultimaHoraDashboard = fechaNueva;								
				}else if( parseInt(hora[0]) == parseInt(horaActual[0]) && parseInt(hora[2]) > parseInt(horaActual[2]) ){
					ultimaHoraDashboard = fechaNueva;
				}
			}	

			function procesarDatosDashboard(jsondata){
				totalVendedoresDashboard = jsondata.length;
				pedidosCompletosDashboard = 0;
				pedidosPendientesDashboard = 0;
				pedidosFaltantesDashboard = 0;
				cantidadPaquetesDashboard = 0;
				
				$.each(jsondata, function(index, element) {
					cantidadPaquetesDashboard = cantidadPaquetesDashboard + parseInt(element['totalPaquetes']);				
					if(element['estadoVendedor'] == "CERRADO"){
						pedidosCompletosDashboard = pedidosCompletosDashboard + 1;
					}else if(element['estadoVendedor'] == "PENDIENTE"){
						pedidosPendientesDashboard = pedidosPendientesDashboard + 1;
					}else if(element['estadoVendedor'] == "EN PROCESO"){
						pedidosFaltantesDashboard = pedidosFaltantesDashboard + 1;
					}
					compararFechaDashboard(element['ultimoEnvio']); 					
				}); 
				
				actualizarDashboard();  
			}
		
		function actualizarDashboard(){			
			$("#vendedoresDashboard").html(totalVendedoresDashboard);
			$("#pedidosCompletosDashboard").html(pedidosCompletosDashboard);
			$("#pedidosPendientesDashboard").html(pedidosPendientesDashboard);
			$("#pedidosFaltantesDashboard").html(pedidosFaltantesDashboard);
			$("#excesoDashboard").html(excesoDashboard);
			$("#cantidadPaquetesDashboard").html(cantidadPaquetesDashboard);
			$("#ultimaHoraDashboard").html(ultimaHoraDashboard);
		}
		
		function resizeTable(){
			tableVendedores.columns.adjust().draw();
		}
		function actualizarTablaVendedores(){
				tableVendedores.ajax.reload( function ( jsondata ) {
					procesarDatosDashboard(jsondata);
				} );
			}
			
		function fc_actualizarGuia( vendedor , operacion){
			$.ajax({
				global: false,
				type: "POST",
				dataType: 'json',
				data: { "vendedor": vendedor },
				url: "update/guia", 
				success: function(jsondata){
					actualizarTablaVendedores();		
				}
			}); 
		}
		 
		/*$('#tableVendedores tbody').on( 'mouseenter', 'td', function () {
			   if(typeof tableVendedores.cell(this).index() != 'undefined'){
				    var colIdx = tableVendedores.cell(this).index().column;
					$( tableVendedores.cells().nodes() ).removeClass( 'highlight' );
					$( tableVendedores.column( colIdx ).nodes() ).addClass( 'highlight' );
			   }               
            });*/
			
    </script>
@stop