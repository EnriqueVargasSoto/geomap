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
        {{--Filtros--}}
       
		<div class="row">
            <div class="col-xs-12">
				<div class="nav-tabs-custom">
					<ul class="nav nav-tabs">
					  <li class="active"><a id="minAutoventa" href="#tab_1" data-toggle="tab" aria-expanded="false" >Avance Ventas</a></li>
					  <li><a id="minPreventa" href="#tab_2" data-toggle="tab" aria-expanded="false">Foco Cobertura</a></li>
					  <li><a id="minDespacho" href="#tab_3" data-toggle="tab" aria-expanded="false">Innovación Cobertura</a></li>
                      {{--<li><a id="FF" href="#tab_4" data-toggle="tab" aria-expanded="false">Bonificaciones Cobertura</a></li>
                      <li><a id="FF" href="#tab_4" data-toggle="tab" aria-expanded="false">Pareto(8020)????</a></li>--}}
					</ul>
					<div class="tab-content">
					  <br>
					  <div class="tab-pane active" id="tab_1">
						<table id="tblavanceVentas"  class="row-border hover order-column" width="100%">
                            <thead class="bg-blue">
                            <tr>
                                <th align="center" rowspan="2">Vendedor</th>
                                <th colspan="3">ALIMENTOS</th>
                                <th colspan="3">CONFITES</th>
                                <th colspan="3">MASCOTAS</th>
                                <th colspan="3">TOTAL</th>
                            </tr>
                            <tr>
                                <th align="center">Actual</th>
                                <th align="center">Faltante <br>Preventa</th>
                                <th align="center">%</th>
                                

                                <th align="center">Actual</th>
                                <th align="center">Faltante <br> Preventa</th>
                                <th align="center">%</th>
                                

                                <th align="center">Actual</th>
                                <th align="center">Faltante <br>Preventa</th>
                                <th align="center">%</th>
                                

                                <th align="center">Actual</th>
                                <th align="center">Faltante <br>Preventa</th>
                                <th align="center">%</th>
                                
                            </tr>
                            </thead>

                                                   
                            

                        </table>
					  </div>
					  <!-- /.tab-pane -->
					  <div class="tab-pane " id="tab_2">
						 <table id="tablePreventaVendedores"  class="row-border hover order-column" width="100%">
                            <!--table id="example" class="row-border hover order-column responsive" cellspacing="0" width="100%"-->
                            <thead class="bg-purple">
                            <tr>
                                <th>Vendedor&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                            </tr>
                            </thead>
                            
                        </table>
					  </div>
					  <!-- /.tab-pane -->
					  <div class="tab-pane" id="tab_3">
						<table id="tableDespachoVendedores"  class="row-border hover order-column" width="100%">
                            <!--table id="example" class="row-border hover order-column responsive" cellspacing="0" width="100%"-->
                            <thead class="bg-teal">
                            <tr>
                                <th>Vendedor&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
								
                            </tr>
                            </thead>
                            
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

    
</div>
@stop
{{--@section('script')
    <!-- Datatable -->
    <script type="text/javascript" language="javascript" src="{{ url('/') }}/plugins/datatable/jquery.dataTables.min.js"></script>
    <script type="text/javascript" language="javascript" src="{{ url('/') }}/plugins/datatable/dataTables.buttons.min.js"></script>
    <script type="text/javascript" language="javascript" src="{{ url('/') }}/plugins/datatable/jszip.min.js"></script>
    <script type="text/javascript" language="javascript" src="{{ url('/') }}/plugins/datatable/pdfmake.min.js"></script>
    <script type="text/javascript" language="javascript" src="{{ url('/') }}/plugins/datatable/vfs_fonts.js"></script>
    <script type="text/javascript" language="javascript" src="{{ url('/') }}/plugins/datatable/buttons.html5.min.js"></script>
    <script type="text/javascript" language="javascript" src="{{ url('/') }}/plugins/datatable/dataTables.fixedColumns.min.js"></script>
    <script>
        var tblavanceVentas;

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

        tblavanceVentas = $('#tblavanceVentas').DataTable( {
                "processing": true,
                "scrollX": false, 
                dom: 'Bfrltip',
                lengthMenu:[[ 10, 25,30, -1],[ "10", "25", "30", "Todo" ]],
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
                            //$("#zona").val(zonaFiltro);
                            //$("#fecha").val(fechaPreventaFiltro);
                            //$("#guia").val('autoventa');
                            //$("#formExcelInforme").submit(); 
                        }
                    }                   
                ],
                "fixedColumns" :{
                    leftColumns: 1
                },
                "ajax": {
                    "url" : 'get/obtenerImporteVenta',
                    "type": 'POST',
                    "dataSrc": '',
                    
                },
                "columnDefs": [
                    

                ],
                "columns": [
                    { data: "nombrex" , defaultContent: ""},
                    { data: "importeVentasMascotasx" , defaultContent: ""},
                    { data: null , defaultContent: ""},
                    { data: null , defaultContent: ""},
                    { data: "importeVentasMascotasx" , defaultContent: ""},
                    { data: null , defaultContent: ""},
                    { data: null , defaultContent: ""},
                    { data: "importeVentasMascotasx" , defaultContent: ""},
                    { data: null , defaultContent: ""},
                    { data: null , defaultContent: ""},
                    { data: "importeVentasMascotasx" , defaultContent: ""},
                    { data: null , defaultContent: ""},
                    { data: null , defaultContent: ""}

                ],
                "language":  languageES
        });
    </script>
@stop--}}