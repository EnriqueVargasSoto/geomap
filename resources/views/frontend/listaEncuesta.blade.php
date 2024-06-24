@extends('layouts.frontend.master')
@section('style')
    <!-- DataTables-->
    <link rel="stylesheet" type="text/css" href="{{ url('/') }}/plugins/datatable/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="{{ url('/') }}/plugins/datatable/buttons.dataTables.min.css">
    <!-- bootstrap datepicker -->
    <link rel="stylesheet" href="{{ url('/') }}/plugins/datepicker/datepicker3.css">
    <style>
        .select2{
            width: 100% !important;
        }
        .form-group label{
            display: block;
        }

		.btn-group button{
			font-size: 13px;
		}

        @media (min-width: 1200px){
            .modal-dialog{
                width: 70%;
            }
        }
        div#copiarTable_info {
            display: none;
        }
        th, td {
            text-align: center;
        }
		.bg-light-default{
			
		}
		table .tr_active {
			background: #003c8c !important;
			background-color: #003c8c !important;
			color: #fff;
		}

		table.dataTable.order-column tbody tr.tr_active>.sorting_1, table.dataTable.order-column tbody tr>.sorting_2, table.dataTable.order-column tbody tr>.sorting_3, table.dataTable.display tbody tr>.sorting_1, table.dataTable.display tbody tr>.sorting_2, table.dataTable.display tbody tr>.sorting_3 {
			background-color: #003c8c !important
		}
		thead.bg-light-default th {
			background: #f2f5f7;
			border-right: 1px solid #e0e2e3;
			border-top: 1px solid #e0e2e3;
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
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Descripcion:</label>
                            <input type="text" class="form-control" id="descripcion" >
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <?php
                                $tipoEncuesta = \App\Models\EncuestaTipo::where('idEmpresa','=', Auth::user()->idEmpresa )->orderBy('descripcion')->get()->pluck('descripcion', 'idTipoEncuesta')->toArray() + ['all' => 'Todos'];
                            ?>
                            <label>Tipo:</label>
                            {!! Form::select('tipoEncuesta',$tipoEncuesta, 'all', ['class'=> 'form-control select2','tabindex' => 1, 'id' => 'tipoEncuesta']) !!}
                        </div>
                    </div>                  
					<div class="col-lg-4">
                        <div class="form-group">
                            <label>Estado:</label>
                            <select id="estadoEncuesta" class="form-control select2">
                                <option value="1">Activo</option>
								<option value="0">Inactivo</option>
								<option value="all" selected>Todos</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-12"> 
						<div class="btn-group"> 									
							<button id="btnBuscar" type="button" class="btn btn-primary btn-sm"><i class="fa fa-fw fa-search"></i>  Buscar </button>
							<button id="btnLimpiar" type="button" class="btn btn-default btn-sm"><i class="fa fa-fw fa-trash"></i>  Limpiar</button>
						</div>
                    </div>
                </div>
            </div>
        </div>
        @include('flash::message')
        <div class="row">
            <div class="col-xs-12">
                <div class="box">                    
                    <div class="box-body">
                        <table id="tableEncuestas"  class="row-border hover order-column" width="100%">
                            <!--table id="example" class="row-border hover order-column responsive" cellspacing="0" width="100%"-->
                            <thead class="bg-light-default">
								<tr> 
									<th>Código </th>
									<th>Descripción</th>
									<th>Tipo</th>
									<th>Estado</th>
									<th>Acciones</th>
								</tr>                           
                            </thead>
                            <tfoot>
								<tr>
									<th>Código </th>
									<th>Descripción</th>
									<th>Tipo</th>
									<th>Estado</th>
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
                        <h3 class="box-title">Vigencia Encuesta <label id="nombreEncuesta"></label></h3>
                        <input id="encuestaActual" value="{{ $encuesta }}" hidden>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="table-responsive">
                            <table id="listaVigenciaTable"  class="row-border hover" width="100%">
                                <!--table id="example" class="row-border hover order-column responsive" cellspacing="0" width="100%"-->
                                <thead class="bg-green">
                                <tr>
                                    <th>Desde </th>
                                    <th>Hasta</th>
                                    <th>Cli. Obligatorios </th>
                                    <th>Cli. Anónimos </th>
                                    <th>Encuestas Min </th>
                                    <th>Fotos Min </th>
                                    <th>Max. int </th>
                                    <th>Estado </th>
                                    <th style="width: 140px;" >Acciones</th>
                                </tr>
                                </thead>
                                <tfoot class="bg-green-footer">
                                <tr>
                                    <th>Vigencia Desde </th>
                                    <th>Vigencia Hasta</th>
                                    <th>Cli. Obligatorios </th>
                                    <th>Cli. Anónimos </th>
                                    <th>Encuestas Min </th>
                                    <th>Fotos Min </th>
                                    <th>Max. int </th>
                                    <th>Estado </th>
                                    <th>Acciones</th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
	</section>
</div>

    <?php
        $empresa = [""=>"Empresa"]+ \App\Models\Empresa::has('sucursales')->orderBy('razonSocial', 'asc')->get()->pluck('razonSocial', 'idEmpresa')->toArray();
    ?>

    <!-- /.modal -->
    <div class="modal fade" id="modalCopiar" data-keyboard= false  data-backdrop = 'static'>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 id="tituloCopiarEncuesta" class="modal-title">COPIAR ENCUESTA </h4><br>
                    <table id="copiarTable"  class="row-border hover order-column" width="100%">
                        <thead>
                        <tr>
                            <th></th>
                            <th>Fecha vigencia desde</th>
                            <th>Fecha vigencia hasta</th>
                        </tr>
                        </thead>
                    </table>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Descripción :</label>
                                <input type="text" class="form-control" id="descripcion">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Vigencia Desde:</label>
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" class="form-control pull-right" id="copiarEncuestaDesde">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Vigencia Hasta:</label>
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" class="form-control pull-right" id="copiarEncuestaHasta">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label>Encuestas mínimas :</label>
                                <input type="text" class="form-control pull-right" value="0">
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label>Fotos mínimas :</label>
                                <input type="text" class="form-control pull-right"  value="0">
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label>Max. intentos:</label>
                                <input type="text" class="form-control pull-right"  value="1">
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <br>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox"> Clientes obligatorios
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary  pull-left">Guardar</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
	
	<div class="modal fade" id="modal-excel">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title">REPORTE: RESPUESTA ENCUESTA</h4>
		  </div>
		  <div class="modal-body">
		    <div class="row"> 				
			    <div class="col-lg-6">
					<div class="form-group">
						<label>Fecha Servidor Desde:</label>
						<div class="input-group date">
							<div class="input-group-addon">
								<i class="fa fa-calendar"></i>
							</div>
							<input type="text" class="form-control pull-right" id="fechaDesdeConsulta">
						</div>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="form-group">
						<label>Fecha Servidor Hasta:</label>
						<div class="input-group date">
							<div class="input-group-addon">
								<i class="fa fa-calendar"></i>
							</div>
							<input type="text" class="form-control pull-right" id="fechaHastaConsulta">
						</div>
					</div>
				</div>
			</div>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
			<button type="button" class="btn btn-primary" onclick="descargarExcel()" ><i class="fa fa-fw fa-file-excel-o"></i> Descargar Excel </button>
		  </div>
		</div>
		<!-- /.modal-content -->
	  </div>
	  <!-- /.modal-dialog -->
	</div>
	<!-- /.modal -->
	<form id="formExcelInforme" method="GET" action="{{ url('/encuesta/reporte1') }}">
		<input type="hidden" name="excelEncuesta" id="excelEncuesta">
        <input type="hidden" name="excelEncuestaDetalle" id="excelEncuestaDetalle">
		<input type="hidden" name="excelDesde" id="excelDesde">
        <input type="hidden" name="excelHasta" id="excelHasta">
	</form>
    <div class="modal fade" id="modalEncuesta"  data-keyboard= false  data-backdrop = 'static' >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 id="tituloModal" class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <div  id="errorsModal" ></div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Descripcion:</label>
                                <input type="hidden" val="" id="modEncuesta">
                                {!! Form::text('descripcionModal', null, ['class'=> "form-control", 'id' => 'descripcionModal']) !!}
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <?php
                                $tipoEncuesta = \App\Models\EncuestaTipo::where('idEmpresa','=', Auth::user()->idEmpresa )->orderBy('descripcion')->get()->pluck('descripcion', 'idTipoEncuesta')->toArray();
                                ?>
                                <label>Tipo:</label>
                                {!! Form::select('tipoEncuestaModal',$tipoEncuesta, null, ['class'=> 'form-control select2','tabindex' => 1, 'id' => 'tipoEncuestaModal']) !!}
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Estado:</label>
                                <select id="estadoEncuestaModal" name="estadoEncuestaModal" class="form-control select2">
                                    <option value="1">Activo</option>
                                    <option value="0">Inactivo</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="guardarEncuesta" type="button" class="hidden btn btn-primary pull-left" disabled><i class="fa fa-fw fa-save"></i>  Guardar </button>
                    <button id="modificarEncuesta" type="button" class="hidden btn btn-primary pull-left" disabled><i class="fa fa-fw fa-save"></i>  Modificar </button>
                    <button id="cancelarModal" type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-fw fa-close"></i>  Cancelar</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
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
    <!-- bootstrap datepicker -->
    <script src="{{ url('/') }}/plugins/datepicker/bootstrap-datepicker.js"></script>
    <script>
        var languageES;
		var tableEncuestas;
        var tableVigenciaEncuesta;
        var codigoCopia = 0;
		var descripcionFiltro = '';
		var tipoFiltro = 'all';
		var estadoFiltro = 'all';

        /*var tableCopiarEncuesta;*/

		$(document).ready(function(){

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

			$("#fechaDesdeConsulta").datepicker({ language: "es", format: 'dd/mm/yyyy' });
			$("#fechaHastaConsulta").datepicker({ language: "es",format: 'dd/mm/yyyy' });
			
            $.fn.datepicker.dates['es'] = {
                days: ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo"],
                daysShort: ["Dom", "Lun", "Mar", "Mié", "Jue", "Vie", "Sáb", "Dom"],
                daysMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa", "Do"],
                months: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
                monthsShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"],
                today: "Hoy"
            };

  
           /*tableCopiarEncuesta = $('#copiarTable').DataTable({
                "processing": true,
                "bPaginate": false,
                "bFilter": false,
                "lengthMenu" : [ [15, 25, -1], ["15", "25", "Todo"] ],
                "ajax": {
                    "url": 'get/detallesEncuesta',
                    "type": 'POST',
                    "dataSrc": '',
                    "data": function (d) {
                        return {
                            "encuesta": codigoCopia
                        };
                    },
                    "error": function (error) {
                        if (error.status === 401 || error.status === 500) {
                            sesionExpirada();
                        }
                    }
                },
                "columnDefs": [{
                    "targets": 0,
                    "data": null,
                    "render": function ( data, type, row, meta ) {
                       return '<input type="radio" name="copyDetalleEncuesta" id="input' + row.idEncuestaDetalle + '" class="filter-ck" />';
                    }
                }],
                "columns": [
                    { data: null , "orderable": false } ,
                    { data: "fechaInicio", defaultContent: "" },
                    { data: "fechaFin", defaultContent: "" }
                ],
                "language": languageES
            });*/

            tableVigenciaEncuesta = $('#listaVigenciaTable').DataTable( {
                "processing": true,
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
                "ajax": {
                    "url" : "{{ url('get/detalleEncuesta') }}",
                    "type": 'POST',
                    "dataSrc": '',
                    "data" : function(d){
                        return {
                            "encuesta" : $("#encuestaActual").val()
                        };
                    }
                },
                "columnDefs": [
                    {
                        "targets": 2,
                        "data": "clientesObligatorios",
                        "render": function ( data, type, row, meta ) {
                            if(row.clientesObligatorios == 1){
                                return 'SI';
                            }else{
                                return 'NO';
                            }
                        }
                    },
                    {
                        "targets": 3,
                        "data": "clientesAnonimos",
                        "render": function ( data, type, row, meta ) {
                            if(row.clientesAnonimos == 1){
                                return 'SI';
                            }else{
                                return 'NO';
                            }
                        }
                    },
                    {
                        "targets": 7,
                        "data": "estado",
                        "render": function ( data, type, row, meta ) {
                            if(row.estado == 1){
                                return 'ACTIVO';
                            }else{
                                return 'INACTIVO';
                            }
                        }
                    },
                    {
                        "targets": 8,
                        "data": "idEncuesta",
                        "render": function ( data, type, row, meta ) {
                            /*var botones = '<div class="btn-group"> {!! Form::open(['url' => [url('/encuesta/desactivar'),], 'method' => 'post']) !!} <a href="encuesta/pregunta/'+row.idEncuesta+'/'+row.idEncuestaDetalle+'"  class="btn btn-default btn-xs" data-toggle="tooltip" title="Editar Preguntas"><i class="fa fa-fw fa-table"></i></a>'+
                                              '<a href="encuesta/detalle/editar/'+row.idEncuesta+'/'+row.idEncuestaDetalle+'"  data-toggle="tooltip" title="Editar Detalle de Encuesta" class="btn btn-default btn-xs"><i class="fa fa-fw fa-pencil"></i></a><input type="hidden" name="encuesta" value="'+row.idEncuesta+'"><input type="hidden" name="detalleEncuesta" value="'+row.idEncuestaDetalle+'">';
                            if(row.estado == 0){
                                botones = botones + '<input type="hidden" name="estado" value="activar"><button onclick="return confirm(\'Esta seguro?\')" type="submit" class="btn btn-default btn-xs" data-toggle="tooltip" title="Activar Encuesta"><i class="fa fa-fw fa-check"></i></button>' ;
                            }else{
                                botones = botones + '<input type="hidden" name="estado" value="desActivar"><button onclick="return confirm(\'Esta seguro?\')" type="submit" class="btn btn-default btn-xs" data-toggle="tooltip" title="Desactivar Encuesta"><i class="fa fa-fw fa-close"></i></button>';
                            }*/
							var botones =  '<button type="button" title="Descargar Respuestas"  class="btn btn-default btn-xs" onclick="modalFechasEncuesta('+row.idEncuesta+','+row.idEncuestaDetalle+')"> <i class="fa fa-fw fa-file-excel-o"></i> </button>';
							                         
                            return botones;
                        }
                    }
                ],
                "columns": [
                    { data: "fechaInicio", defaultContent: "" },
                    { data: "fechaFin", defaultContent: "" },
                    { data: null , "orderable": false },
                    { data: null , "orderable": false },
                    { data: "encuestasMinimas", defaultContent: "" },
                    { data: "fotosMinimas", defaultContent: "" },
                    { data: "maximoIntentosCliente", defaultContent: "" },
                    { data: "estado", defaultContent: "" },
                    { data: null , "orderable": false }
                ],
                "language":  languageES
            });

            tableEncuestas = $('#tableEncuestas').DataTable( {
                "processing": true,
				dom: 'Bfrltip',
				lengthMenu:[[  15, 25, -1],[ "15", "25", "Todo" ]],
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
                "ajax": {
                    "url" : 'get/encuestas',
                    "type": 'POST',
                    "dataSrc": '',
					"data" : function(d){
						return { 
							"descripcion" : descripcionFiltro,
							"tipo" : tipoFiltro,
							"estado" : estadoFiltro
						};
					},
                    "error": function(error) {
                        if( error.status === 401 || error.status === 500 ) {
                            sesionExpirada();
                        }
                    }
                },
                "columnDefs": [  
                    {
                        "targets": 4,
                        "data": "idEncuesta",
                        "render": function ( data, type, row, meta ) {
                            botones =  '<div class="btn-group">'+
                                '<a href="javascript:void(0)" data-toggle="tooltip" title="Ver vigencias encuesta" class="btn btn-default btn-xs"  onClick="fc_mostrarDetalleEncuesta(\''+row.descripcion+'\',\''+row.idEncuesta+'\')"> <i class="fa fa-fw fa-eye"></i></a>';/*+
                                '<a href="encuesta/nuevo/detalle/'+row.idEncuesta+'"  data-toggle="tooltip" title="Agregar vigencia encuesta" target="_blank" class="btn btn-default btn-xs"><i class="fa fa-fw fa-calendar-plus-o"></i></a>'+
                                       '<button onclick="modificarEncuesta('+row.idEncuesta+')"  data-toggle="tooltip" title="Editar encuesta"  class="btn btn-default btn-xs"><i class="fa fa-edit"></i></button>';	*/								 
						   return  botones + '</div>';
                        }
                    },
                    {
                        "targets": 3,
                        "data": "estado",
                        "render": function ( data, type, row, meta ) {
                            if(row.estado == 1){
                                return 'ACTIVO';
                            }else{
                                return 'INACTIVO';
                            }
                        }
                    }
                ],
                "columns": [ 
                    { data: "idEncuesta", defaultContent: "" },
					{ data: "descripcion", defaultContent: "" }, 
                    { data: "tipo", defaultContent: "" },
                    { data: "estado", defaultContent: "" },
					{ data: null , "orderable": false }
                ],
                "language":  languageES
            }
            );
			
			$("#btnBuscar").click(function(){
				actualizarVariablesGlobales();
                actualizarTablaEncuesta();
            });

            $("#btnNuevaEncuesta").click(function(){
                $("#tituloModal").html("NUEVA ENCUESTA");
                $("#modificarEncuesta").prop('disabled', true);
                $("#modificarEncuesta").addClass('hidden');

                $("#guardarEncuesta").removeClass('hidden');
                $("#guardarEncuesta").prop('disabled', false);
                $("#modalEncuesta").modal('show');
            });

            $("#modificarEncuesta").click(function(){
                $("#errorsModal").html('');

                descripcion = $("#descripcionModal").val();
                tipoEncuesta = $("#tipoEncuestaModal").val();
                estadoEncuesta = $("#estadoEncuestaModal").val();

                $.ajax({
                    global: false,
                    type: "POST",
                    dataType: 'json',
                    data: { "descripcion": descripcion, "tipoEncuesta": tipoEncuesta, "estadoEncuesta": estadoEncuesta,"encuesta": $("#modEncuesta").val() },
                    url: '{{ url("/encuesta/modificar") }}',
                    success: function(data){
                        if( data['id']){
                            new PNotify({
                                title: 'Encuesta',
                                text: 'Se modifico la encuesta correctamente',
                                type: 'success'
                            });

                            limpiarModalEncuesta();
                            actualizarTablaEncuesta();
                            $("#modalEncuesta").modal('hide');
                        }
                    },
                    error: function(error) {
                        if( error.status === 401 || error.status === 500 ) {
                            sesionExpirada();
                        }
                        if( error.status === 422 ) {
                            //process validation errors here.
                            data = error.responseJSON; //this will get the errors response data.
                            //show them somewhere in the markup
                            //e.g
                            errorsHtml = '<div class="alert alert-danger"><ul>';

                            $.each( data, function( key, value ) {
                                errorsHtml += '<li>' + value[0] + '</li>'; //showing only the first error.
                            });
                            errorsHtml += '</ul></di>';

                            $("#errorsModal").html(errorsHtml);
                        }
                    }
                });
            });

            $("#cancelarModal").click(function(){
                limpiarModalEncuesta();
            });

            $("#guardarEncuesta").click(function(){
                $("#errorsModal").html('');

                descripcion = $("#descripcionModal").val();
                tipoEncuesta = $("#tipoEncuestaModal").val();
                estadoEncuesta = $("#estadoEncuestaModal").val();

                $.ajax({
                    global: false,
                    type: "POST",
                    dataType: 'json',
                    data: { "descripcion": descripcion, "tipoEncuesta": tipoEncuesta, "estadoEncuesta": estadoEncuesta },
                    url: '{{ url("/encuesta/crear") }}',
                    success: function(data){
                        if( data['id']){
                            new PNotify({
                                title: 'Encuesta',
                                text: 'Se creo correctamente la encuesta',
                                type: 'success'
                            });

                            limpiarModalEncuesta();
                            actualizarTablaEncuesta();
                            $("#modalEncuesta").modal('hide');
                        }
                    },
                    error: function(error) {
                        if( error.status === 401 || error.status === 500 ) {
                            sesionExpirada();
                        }
                        if( error.status === 422 ) {
                            //process validation errors here.
                            data = error.responseJSON; //this will get the errors response data.
                            //show them somewhere in the markup
                            //e.g
                            errorsHtml = '<div class="alert alert-danger"><ul>';

                            $.each( data, function( key, value ) {
                                errorsHtml += '<li>' + value[0] + '</li>'; //showing only the first error.
                            });
                            errorsHtml += '</ul></di>';

                            $("#errorsModal").html(errorsHtml);
                        }
                    }
                });

            });

            $("#btnLimpiar").click(function(){
				tipoFiltro = "all";
				estadoFiltro = "all";
				descripcionFiltro = "";

				limpiarCampos();
                actualizarTablaEncuesta();
			});
 			 
			function actualizarVariablesGlobales(){
				tipoFiltro = $("#tipoEncuesta").val();
				estadoFiltro = $("#estadoEncuesta").val();
				descripcionFiltro = $("#descripcion").val(); 
			}
				
            $("#menuButton").click(function(){  
                setTimeout('resizeTable()',320); 
            });

			function limpiarCampos(){
				$("#descripcion").val("");
                $("#tipoEncuesta").val('all');
                $("#estadoEncuesta").val('all');
			}

			function limpiarModalEncuesta(){
                $("#descripcionModal").val("");
            }

            $('#empresa').select2({  language: 'es',  placeholder: "Empresa" });
            $('#sucursal').select2({ language: 'es',  placeholder: "Sucursal" });

            $("#empresa").change(function() {
                var empresa = $("#empresa").val();
                if(empresa.length > 2){
                    $("#sucursal").empty();
                    $.ajax({
                        global: false,
                        type: "POST",
                        dataType: 'json',
                        data: { "empresa": empresa},
                        url: 'get/sucursalEmpresa',
                    }).done(function(jsondata) {
                        if(jsondata.length >=1){
                            var selectObject = $("#sucursal");
                            $.each(jsondata, function(index, element){
                                selectObject.append("<option value='"+ element['idSucursal'] +"'>" + element['nombre'] + "</option>");
                            });
                        }
                    })
                    .fail(function() {
                        alert( "Error" );
                    });
                }
            });


            $('#copiarEncuestaDesde').datepicker({
                language: 'es',
                autoclose: true
            });
            $('#copiarEncuestaHasta').datepicker({
                language: 'es',
                autoclose: true
            });
            $('#datepicker').datepicker({
                language: 'es',
                autoclose: true
            });

		});
		
		function modalFechasEncuesta(encuesta, encuestaDetalle){	
			$("#excelEncuesta").val(""+encuesta);
			$("#excelEncuestaDetalle").val(""+encuestaDetalle);
			
			$("#excelHasta").val("");			
			$("#excelDesde").val("");			
			
			$("#fechaHastaConsulta").val("")
			$("#fechaDesdeConsulta").val("")
			$('#modal-excel').modal('show');
		}
		
		function descargarExcel(){	
			$("#excelHasta").val(""+$("#fechaHastaConsulta").val());
			$("#excelDesde").val(""+$("#fechaDesdeConsulta").val());
			
			$("#formExcelInforme").submit();
			new PNotify({
				title: 'Reporte Encuesta',
				text: 'Su reporte se descargará en unos segundos',
				type: 'info'
			});
			$('#modal-excel').modal('hide');
		} 
			
        function fc_mostrarDetalleEncuesta(encuesta, codigo){
			$("#tableEncuestas tr.tr_active").removeClass("tr_active");
			var tableRow = $("td").filter(function() {
                return $(this).text() == codigo;
            }).closest("tr");
			tableRow.addClass( "tr_active" );
			
            $('html,body').animate({ scrollTop: $("#listaVigenciaTable").offset().top},  'slow');
            $("#nombreEncuesta").html(": "+encuesta);
            $("#encuestaActual").val(codigo);

            tableVigenciaEncuesta.ajax.reload( null, false );
        }

		function resizeTable(){
			tableEncuestas.columns.adjust().draw();
		}

		function actualizarTablaEncuesta(){
            tableEncuestas.ajax.reload( null, false );
		}

        function copiarEncuesta(encuesta, titulo){
		    codigoCopia = encuesta;
		    $("#tituloCopiarEncuesta").html("Copiar encuesta : "+titulo);
            tableCopiarEncuesta.ajax.reload();
            $("#modalCopiar").modal("show");
        }

        function modificarEncuesta(encuesta){
		    $("#modEncuesta").val(encuesta);

            $.ajax({
                global: false,
                type: "POST",
                dataType: 'json',
                data: { "encuesta": encuesta },
                url: '{{ url("get/encuesta") }}',
                success: function(data){

                    $("#descripcionModal").val(data['descripcion']);
                    $("#tipoEncuestaModal").val(data['idTipoEncuesta']);
                    $("#estadoEncuestaModal").val(data['estado']);

                    $("#tituloModal").html("MODIFICAR ENCUESTA");
                    $("#guardarEncuesta").prop('disabled', true);
                    $("#guardarEncuesta").addClass('hidden');

                    $("#modificarEncuesta").removeClass('hidden');
                    $("#modificarEncuesta").prop('disabled', false);

                    $("#modalEncuesta").modal('show');
                },
                error: function(error) {
                    alert(error);
                }
            });
        }

        function desactivarVigencia(){

        }

        function activarVigencia(){

        }

    </script>
@stop