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
					</ul>
					<div class="tab-content">
					  <br>
					  <div class="tab-pane active contenido_scroll_ancho style_pers" id="tab_1">
						<table id="tblavanceVentas" class="row-border hover order-column " width="100%">
                            <thead  style="font-size: 11px;">
                            <tr class="bg-blue">
                                <th class="alinear_centro" rowspan="2" >VENDEDOR</th>
                                <th class="alinear_centro" colspan="4">ALIMENTOS</th>
                                <th class="alinear_centro" colspan="4">CONFITES</th>
                                <th class="alinear_centro" colspan="4">MASCOTAS</th>
                                <th class="alinear_centro" colspan="4">TOTAL</th>
                            </tr>
                            <tr class="" style="background-color: #599bc1 !important;color:white">
                                <th class="alinear_centro" align="right">ACTUAL</th>
                                <th class="alinear_centro" align="right">CUOTA <br>DEL DIA</th>
                                <th class="alinear_centro" align="right">FALTANTE <br>PREVENTA</th>
                                <th class="alinear_centro" align="right">%</th>
                                

                                <th class="alinear_centro" align="right">ACTUAL</th>
                                <th class="alinear_centro" align="right">CUOTA <br> DEL DIA</th>
                                <th class="alinear_centro" align="right">FALTANTE <br>PREVENTA</th>
                                <th class="alinear_centro" align="right">%</th>
                                

                                <th class="alinear_centro" align="right">ACTUAL</th>
                                <th class="alinear_centro" align="right">CUOTA <br> DEL DIA</th>
                                <th class="alinear_centro" align="right">FALTANTE <br>Preventa</th>
                                <th class="alinear_centro" align="right">%</th>
                                

                                <th class="alinear_centro" align="right">ACTUAL</th>
                                <th class="alinear_centro" align="right">CUOTA <br> DEL DIA</th>
                                <th class="alinear_centro" align="right">FALTANTE <br>Preventa</th>
                                <th class="alinear_centro" align="right">%</th>
                                
                            </tr>
                            </thead>

                                      
                            

                        </table>
					  </div>
					  
					  <!-- /.tab-pane -->
					</div>
					<!-- /.tab-content -->
				</div>
			</div>
		</div>
		
    </section>

    
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
        var tblavanceVentas;
        var importeAlimentos=[];
        var totalRpt = 0;
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
                    { data: "nombresVendedor" , defaultContent: ""},
                    {
                        "targets": 2,
                        "data": "importeActualAlimentos",
                        "class": "alinear_derecha",
                        "render": function ( data, type, row, meta ) {
                           if(row.importeActualAlimentos){
                                var aux=0;
                                /*if(row.importeActualAlimentos>aux){
                                    var may=row.importeActualAlimentos;
                                }*/
                                //importeAlimentos[0]=row.importeActualAlimentos;
                                return parseFloat(row.importeActualAlimentos).toFixed(2);
                            }
                            else{
                                return '';
                            }
                        }
                    },
                    {
                        "targets": 2,
                        "data": "faltanteAlimentos",
                        "class": "alinear_derecha",
                        "render": function ( data, type, row, meta ) {
                           if(row.importeActualAlimentos){
                                var CuotafaltanteAlimentos=({{$dias_restantes_para_finalizarmes}})/row.faltanteAlimentos;

                                return parseFloat(CuotafaltanteAlimentos).toFixed(5);
                            }
                            else{
                                return '';
                            }
                        }
                    },
                    {
                        "targets": 3,
                        "data": "faltanteAlimentos",
                        "class": "alinear_derecha",
                        "render": function ( data, type, row, meta ) {
                            
                           if(row.importeActualAlimentos){
                                var CuotafaltanteAlimentos=({{$dias_restantes_para_finalizarmes}})/row.faltanteAlimentos;
                                var faltantePreventaAlimentos=CuotafaltanteAlimentos-row.importeActualAlimentos;
                                return parseFloat(faltantePreventaAlimentos).toFixed(3);
                            }
                            else{
                                return '';
                            }
                        }
                    },
                    {
                        "targets": 4,
                        "data": "importeActualAlimentos",
                        "class": "alinear_derecha_anchopor",
                        "render": function ( data, type, row, meta ) {
                            
                           if(row.importeActualAlimentos){
                                var CuotafaltanteAlimentos=({{$dias_restantes_para_finalizarmes}})/row.faltanteAlimentos;
                                var porcAlimentos=(row.importeActualAlimentos/CuotafaltanteAlimentos)*100;
                                return muestra_porc(porcAlimentos);
                            }
                            else{
                                return '';
                            }
                        }
                    },

                    { data: "importeActualConfites" , defaultContent: "",class:"alinear_derecha"},
                    {
                        "targets": 6,
                        "data": "faltanteConfites",
                        "class": "alinear_derecha",
                        "render": function ( data, type, row, meta ) {
                            //var count = Object.keys(row.importeActualAlimentos).length;
                            
                           if(row.importeActualConfites){
                                var CuotafaltanteConfites=({{$dias_restantes_para_finalizarmes}})/row.faltanteConfites;

                                return parseFloat(CuotafaltanteConfites).toFixed(5);
                            }
                            else{
                                return '';
                            }
                        }
                    },
                    {
                        "targets": 7,
                        "data": "faltanteConfites",
                        "class": "alinear_derecha",
                        "render": function ( data, type, row, meta ) {
                            //var count = Object.keys(row.importeActualAlimentos).length;
                            
                           if(row.importeActualConfites){
                                var CuotafaltanteConfites=({{$dias_restantes_para_finalizarmes}})/row.faltanteConfites;
                                var faltantePreventaConfites=CuotafaltanteConfites-row.importeActualConfites;
                                return parseFloat(faltantePreventaConfites).toFixed(3);
                            }
                            else{
                                return '';
                            }
                        }
                    },
                    {
                        "targets": 8,
                        "data": "faltanteConfites",
                        "class": "alinear_derecha_anchopor",
                        "render": function ( data, type, row, meta ) {
                           if(row.importeActualConfites){
                                var CuotafaltanteConfites=({{$dias_restantes_para_finalizarmes}})/row.faltanteConfites;
                                var porcConfites=(row.importeActualConfites/CuotafaltanteConfites)*100;
                                return muestra_porc(porcConfites);
                            }
                            else{
                                return '';
                            }
                        }
                    },

                    { data: "importeActualMascotas" , defaultContent: "",class:"alinear_derecha"},
                    {
                        "targets": 10,
                        "data": "faltanteMascotas",
                        "class": "alinear_derecha",
                        "render": function ( data, type, row, meta ) {
                            //var count = Object.keys(row.importeActualAlimentos).length;
                            
                           if(row.importeActualMascotas){
                                var CuotafaltanteMascotas=({{$dias_restantes_para_finalizarmes}})/row.faltanteMascotas;

                                return parseFloat(CuotafaltanteMascotas).toFixed(5);
                            }
                            else{
                                return '';
                            }
                        }
                    },
                    {
                        "targets": 11,
                        "data": "faltanteMascotas",
                        "class": "alinear_derecha",
                        "render": function ( data, type, row, meta ) {
                            //var count = Object.keys(row.importeActualAlimentos).length;
                            
                           if(row.importeActualMascotas){
                                var CuotafaltanteMascotas=({{$dias_restantes_para_finalizarmes}})/row.faltanteMascotas;
                                var faltantePreventeMascotas=CuotafaltanteMascotas-row.importeActualMascotas;
                                return parseFloat(faltantePreventeMascotas).toFixed(3);
                            }
                            else{
                                return '';
                            }
                        }
                    },
                    {
                        "targets": 12,
                        "data": "faltanteMascotas",
                        "class": "alinear_derecha_anchopor",
                        "render": function ( data, type, row, meta ) {
                            //var count = Object.keys(row.importeActualAlimentos).length;
                            
                           if(row.importeActualMascotas){
                                var CuotafaltanteMascotas=({{$dias_restantes_para_finalizarmes}})/row.faltanteMascotas;
                                var porcMascotas=(row.importeActualMascotas/CuotafaltanteMascotas)*100;
                                return muestra_porc(porcMascotas);
                            }
                            else{
                                return '';
                            }
                        }
                    },

                    {
                        "targets": 13,
                        /*"data": "faltanteAlimentos",*/
                        "class": "alinear_derecha",
                        "render": function ( data, type, row, meta ) {
                            if(row.importeActualAlimentos && row.importeActualConfites && row.importeActualMascotas){
                                var total=parseFloat(row.importeActualAlimentos)+parseFloat(row.importeActualConfites)+parseFloat(row.importeActualMascotas);

                                return parseFloat(total).toFixed(2);
                            }
                            else{
                                return '';
                            }
                        }
                    },
                    {
                        "targets": 10,
                        "data": "faltanteMascotas",
                        "class": "alinear_derecha",
                        "render": function ( data, type, row, meta ) {
                            //var count = Object.keys(row.importeActualAlimentos).length;
                           if(row.importeActualAlimentos&&row.importeActualConfites&&row.importeActualMascotas){
                                var CuotafaltanteAlimentos=({{$dias_restantes_para_finalizarmes}})/row.faltanteAlimentos;
                                var CuotafaltanteConfites=({{$dias_restantes_para_finalizarmes}})/row.faltanteConfites;
                                var CuotafaltanteMascotas=({{$dias_restantes_para_finalizarmes}})/row.faltanteMascotas;
                                var cuotaTotal=CuotafaltanteAlimentos+CuotafaltanteConfites+CuotafaltanteMascotas;
                                return parseFloat(cuotaTotal).toFixed(5);
                            }
                            else{
                                return '';
                            }

                            


                        }
                    },
                    {
                        "targets": 11,
                        "data": "faltanteMascotas",
                        "class": "alinear_derecha",
                        "render": function ( data, type, row, meta ) {
                            //var count = Object.keys(row.importeActualAlimentos).length;
                            
                           if(row.importeActualAlimentos&&row.importeActualConfites&&row.importeActualMascotas){
                                var CuotafaltanteAlimentos=({{$dias_restantes_para_finalizarmes}})/row.faltanteAlimentos;
                                var faltantePreventaAlimentos=CuotafaltanteAlimentos-row.importeActualAlimentos;

                                var CuotafaltanteConfites=({{$dias_restantes_para_finalizarmes}})/row.faltanteConfites;
                                var faltantePreventaConfites=CuotafaltanteConfites-row.importeActualConfites;

                                var CuotafaltanteMascotas=({{$dias_restantes_para_finalizarmes}})/row.faltanteMascotas;
                                var faltantePreventeMascotas=CuotafaltanteMascotas-row.importeActualMascotas;

                                var faltantesTotales=faltantePreventaAlimentos+faltantePreventaConfites+faltantePreventeMascotas;
                                return parseFloat(faltantesTotales).toFixed(3);
                            }
                            else{
                                return '';
                            }
                        }
                    },
                    {
                        "targets": 12,
                        "data": "faltanteMascotas",
                        "class": "alinear_derecha_anchopor",
                        "render": function ( data, type, row, meta ) {
                            //var count = Object.keys(row.importeActualAlimentos).length;
                            
                           if(row.importeActualAlimentos && row.importeActualConfites && row.importeActualMascotas){
                                var importesTotal=parseFloat(row.importeActualAlimentos)+parseFloat(row.importeActualConfites)+parseFloat(row.importeActualMascotas);


                                var CuotafaltanteAlimentos=({{$dias_restantes_para_finalizarmes}})/row.faltanteAlimentos;
                                var CuotafaltanteConfites=({{$dias_restantes_para_finalizarmes}})/row.faltanteConfites;
                                var CuotafaltanteMascotas=({{$dias_restantes_para_finalizarmes}})/row.faltanteMascotas;
                                var cuotaTotal=CuotafaltanteAlimentos+CuotafaltanteConfites+CuotafaltanteMascotas;


                                
                                var porcTotal=(importesTotal/cuotaTotal)*100;
                                return muestra_porc(porcTotal);
                            }
                            else{
                                return '';
                            }
                        }
                    },

                ],
                "language":  languageES,

                /*"footerCallback": function ( row, data, start, end, display ) {
                    var api = this.api(), data;
                    var columna = 1;
                    // Remove the formatting to get integer data for summation
                    var intVal = function ( i ) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '')*1 :
                            typeof i === 'number' ?
                                i : 0;
                    };
                        
                    while(columna <= totalRpt){                      
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
                    var ultimaColumna = totalRpt + 1;
                    var filas = api.column( ultimaColumna ).data().length;
                    
                    for( n = 1; n <= filas; n++){
                        totalTotales = totalTotales + parseInt( $('#tblavanceVentas tr:nth-child('+n+') td:nth-child('+( ultimaColumna + 1 )+')').text());
                    }
                    $( api.column( ultimaColumna ).footer() ).html( totalTotales );
                    
                }*/
        });

            $('#tblavanceVentas tbody').on( 'mouseenter', 'td', function () {
               if(typeof tblavanceVentas.cell(this).index() != 'undefined'){
                    var colIdx = tblavanceVentas.cell(this).index().column;
                    $( tblavanceVentas.cells().nodes() ).removeClass( 'highlight-blue' );
                    $( tblavanceVentas.column( colIdx ).nodes() ).addClass( 'highlight-blue' );
               }               
            });

           


            

    function muestra_porc(resultado){
        if(resultado>60){
            return '<span class="glyphicon glyphicon-arrow-up text-success" style="font-weight"></span><span>'+parseFloat(resultado).toFixed(2)+'</span>'
        }
        else{
            if(resultado>30 && resultado<=60){
                return '<span class="glyphicon glyphicon-arrow-right text-warning"></span><span>'+parseFloat(resultado).toFixed(2)+'</span>'
            }
            else{
                return '<span class="glyphicon glyphicon-arrow-down text-danger"></span><span>'+parseFloat(resultado).toFixed(2)+'</span>'
            }
        }
    }
    </script>

@stop