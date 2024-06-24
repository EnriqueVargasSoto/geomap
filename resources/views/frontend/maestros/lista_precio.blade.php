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
        {{--<div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Filtros para la búsqueda </h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                </div>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Zona</label>
                            <select id="zonasPreventa" class="form-control select2">
                                <option value="all">Todas</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Ruta</label>
                            <select id="rutasPreventa" class="form-control select2">
                                <option value="all">Todas</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
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


                    <div class="col-md-1">
                        <div class="form-group">
                            <br>
                            <input type="checkbox" name="chk_kg" id="chk_kg" value="1"> KG
                        </div>
                    </div>
                    <div class="col-md-3">
                        <br>
                        <div class="form-buttons">
                            <button id="btnBuscarPreventa" class="btn btn-primary"><i class="fa fa-fw fa-search"></i> Buscar</button>
                            <button id="btnLimpiarPreventa" class="btn btn-default"><i class="fa fa-fw fa-trash"></i> Limpiar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>--}}
       
		<div class="row">
            <div class="col-xs-12">
				<div class="nav-tabs-custom">
					<ul class="nav nav-tabs">
					  <li ><a id="listaPrecio" href="#tab_1" data-toggle="tab" aria-expanded="false" >Lista Precio</a></li>
					  <li class="active"><a id="bonificacion" href="#tab_2" data-toggle="tab" aria-expanded="false">Bonificación</a></li>
					  {{--<li><a id="grupo" href="#tab_3" data-toggle="tab" aria-expanded="false">Grupos</a></li> --}}
					</ul>
					<div class="tab-content">
					  <br>
                      
					  <div class="tab-pane " id="tab_1">
                        <div class="contenido_scroll_ancho">
						<table id="tableListaPrecio"  class="row-border hover order-column table" width="100%">
                            <thead class="bg-blue">
                            <tr>
                                <th>Articulo&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                <th>Descripción</th>
                                <th>Unid. Compra</th>
                                <th>Unid. Venta</th>
                                <th>Contenido</th>
                                <th>Peso</th>
                                <th>Familia</th>
                                <th>Subfamilia</th>
                                <th>Marca</th>
                                <th>Grupo</th>
                                <th>Precio Un. Venta</th>
                                <th>Precio Unidades</th>
                                <th>Vigencia</th>
                            </tr>
                            </thead>
                            <tfoot class="bg-blue footer">
                            <tr>
                                <th>Articulo</th>
                                <th>Descripción</th>
                                <th>Unid. Compra</th>
                                <th>Unid. Venta</th>
                                <th>Contenido</th>
                                <th>Peso</th>
                                <th>Familia</th>
                                <th>Subfamilia</th>
                                <th>Marca</th>
                                <th>Grupo</th>
                                <th>Precio Un. Venta</th>
                                <th>Precio Unidades</th>
                                <th>Vigencia</th>
                            </tr>
                            </tfoot>
                        </table>
                        </div>
					  </div>
					  <div class="tab-pane active" id="tab_2">
                        

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
                                    
                                    <div class="col-md-3">

                                        <div class="form-group">
                                            <label>Mes y Año:</label>
                                            <div class="input-group date">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                                <input type="text" class="form-control pull-right" id="fechaInicio" readonly="">
                                            </div>
                                        </div>

                                    </div>


                                    {{--<div class="col-md-3">
                                        <div class="form-group">
                                            <label>Fecha Fin:</label>
                                            <div class="input-group date">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                                <input type="text" class="form-control pull-right" id="fechaFin" >
                                            </div>
                                        </div>
                                    </div>--}}

                                    
                                    <div class="col-md-3">
                                        <br>
                                        <div class="form-buttons">
                                            {{--<button id="btnBuscarBonificacion" class="btn btn-primary"><i class="fa fa-fw fa-search"></i> Buscar</button>--}}
                                            <button id="btnLimpiarBonificacion" class="btn btn-default"><i class="fa fa-fw fa-trash"></i> Limpiar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="contenido_scroll_ancho">
                        <table id="tableBonificacion"  class="row-border hover order-column table" width="100%">
                            <thead class="bg-purple">
                            <tr width="100%">
                                <th>IDPROMOCION&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                <th>DESCRIPCION PROMO</th>
                                <th>IDGRUPO</th>
                                <th>MALLA</th>
                                <th>DESCRIPCION GRUPO</th>
                                <th>IDRANGO</th>
                                <th>UNIDAD</th>
                                <th>DESDE</th>
                                <th>HASTA</th>
                                <th>PORCADA</th>
                                <th>IDACCION</th>
                                <th>ARTICULO</th>
                                <th>DESCRIPCION</th>
                                <th>INICIO</th>
                                <th>FIN</th>
                                {{--<th>ESTADO</th>--}}
                            </tr>
                            </thead>
                            <tfoot class="bg-purple footer">
                            <tr>
                                <th>IDPROMOCION</th>
                                <th>DESCRIPCION PROMO</th>
                                <th>IDGRUPO</th>
                                <th>MALLA</th>
                                <th>DESCRIPCION GRUPO</th>
                                <th>IDRANGO</th>
                                <th>UNIDAD</th>
                                <th>DESDE</th>
                                <th>HASTA</th>
                                <th>PORCADA</th>
                                <th>IDACCION</th>
                                <th>ARTICULO</th>
                                <th>DESCRIPCION</th>
                                <th>INICIO</th>
                                <th>FIN</th>
                                {{--<th>ESTADO</th>--}}
                            </tr>
                            </tfoot>
                        </table>
                        </div>
                      </div>

                      <div class="tab-pane" id="tab_3">
                        <table id="tableGrupos"  class="row-border hover order-column" width="100%">
                            <thead class="bg-purple">
                            <tr>
                                
                                <th>IDGRUPO</th>
                                <th>MALLA</th>
                                <th>DESCRIPCION</th>
                                <th>ARTICULO</th>
                                <th>OTRA DESCRIPCION</th>
                            </tr>
                            </thead>
                            <tfoot class="bg-purple footer">
                            <tr>
                                
                                <th>IDGRUPO</th>
                                <th>MALLA</th>
                                <th>DESCRIPCION</th>
                                <th>ARTICULO</th>
                                <th>OTRA DESCRIPCION</th>
                            </tr>
                            </tfoot>
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
    <div id="overlay" class="overlay hidden"><i class="fa fa-refresh fa-spin"></i></div>
</div>
<div class="modal fade" id="group_detail_dialog">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                 
                            </div>
                            <div class="modal-body">
                                <div id="overlay_numero_" class="overlay hidden"><i class="fa fa-refresh fa-spin"></i></div>
                                <div class="table-responsive">
                                    <table id="grupo_detail_table" class="row-border hover order-column responsive" cellspacing="0" width="100%">
                                    <thead class="bg-light-blue">
                                    <tr>
                                    <th>Malla</th>
                                    <th>Descripcion</th>
                                    <th>Artículo</th>
                                    <th>Otra Descripcion</th>
                                     
                                    </tr>
                                    </thead>
                                    <tfoot class="bg-light-blue-footer">
                                    <tr>
                                    <th>Malla</th>
                                    <th>Descripcion</th>
                                    <th>Artículo</th>
                                    <th>Otra Descripcion</th>
                                    </tr>
                                    </tfoot>
                                    </table>
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
    var tableListaPrecio;
    var tableListaBonificacion;
    var tableGrupos;
    var languageES;
    var tableDetailGroup;
    var grupo_id;
    var fechaInicio = $("#fechaInicio").val();
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
    //var fechaFin = $("#fechaFin").val();

    $(document).ready(function() {
        /*$('#fechaInicio').datepicker( {
            changeMonth: true,
            viewMode: 'years',
            changeYear: true,
            showButtonPanel: true,
            dateFormat: 'MM yy',
            onClose: function(dateText, inst) { 
                $(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));
            }
        });*/

        //$("#fechaInicio").datepicker({ language: "es", format: 'dd/mm/yyyy' });

        $("#fechaInicio").datepicker({
            language: "es",
            startviewMode: 'months',
            format: 'mm/yyyy',
            minViewMode:'months',
            
            autoclose:true

        }).datepicker('setDate','now');
          fechaInicio = $("#fechaInicio").val();
        $('#fechaInicio').on('changeDate', function (ev) {
            //close when viewMode='0' (days)
            if(ev.viewMode === 'months'){
              $('#fechaInicio').datepicker('hide');
            }

            actualizarVariablesGlobales();
            tableListaBonificacion.ajax.reload( null, false );
        })
        /*$("#fechaInicio").datepicker( {
            format: "mm/yyyy",
            viewMode: "months", 
            minViewMode: "months"
        });*/

        //$("#fechaFin").datepicker({ language: "es", format: 'dd/mm/yyyy' });
        $("#btnBuscarBonificacion").click(function(){
            //alert('aqui andamoss');
            actualizarVariablesGlobales();
            tableListaBonificacion.ajax.reload( null, false );
            //limpiarCampos();
        });
        
        $("#btnLimpiarBonificacion").click(function(){
            //alert('aqui andamoss');
            fechaInicio = $("#fechaInicio").val('');
            actualizarVariablesGlobales();
            tableListaBonificacion.ajax.reload( null, false );
            //limpiarCampos();
        });

        function actualizarVariablesGlobales(){
            fechaInicio = $("#fechaInicio").val();
            //fechaFin = $("#fechaFin").val();
        }

        

        tableListaPrecio = $('#tableListaPrecio').DataTable( {
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
                    "url" : 'get/obtenerListaPrecio',
                    "type": 'POST',
                    "dataSrc": '',
                    
                },
                "columnDefs": [
                    {
                        "targets": 0,
                        "data": "ARTICULO",
                        "render": function ( data, type, row, meta ) {
                            var count = Object.keys(row).length;
                            if(count == 0){
                                return "-";
                            }else {
                                var arti=parseFloat(row.ARTICULO).toFixed(0);
                                return arti;
                            }
                        }
                    },
                    {
                        "targets": 4,
                        "data": "CONTENIDO",
                        "render": function ( data, type, row, meta ) {
                            var count = Object.keys(row).length;
                            if(count == 0){
                                return "-";
                            }else {
                                var cont=parseFloat(row.CONTENIDO).toFixed(2);
                                return cont;
                            }
                        }
                    }, 
                    {
                        "targets": 5,
                        "data": "PESO",
                        "render": function ( data, type, row, meta ) {
                            var count = Object.keys(row).length;
                            if(count == 0){
                                return "-";
                            }else {
                                var cont=parseFloat(row.PESO).toFixed(2);
                                return cont;
                            }
                        }
                    },
                    
                    {
                        "targets": 10,
                        "data": "PRECIOUNIVENTA",
                        "render": function ( data, type, row, meta ) {
                            var count = Object.keys(row).length;
                            if(count == 0){
                                return "-";
                            }else {
                                var cont=parseFloat(row.PRECIOUNIVENTA).toFixed(2);
                                return cont;
                            }
                        }
                    }, 
                    {
                        "targets": 11,
                        "data": "PRECIOUNIDADES",
                        "render": function ( data, type, row, meta ) {
                            var count = Object.keys(row).length;
                            if(count == 0){
                                return "-";
                            }else {
                                var cont=parseFloat(row.PRECIOUNIDADES).toFixed(2);
                                return cont;
                            }
                        }
                    },  
                ],
                "columns": [
                    { data: null},
                    { data: "DESCRIPCION" , defaultContent: ""},
                    { data: "UNICOMPRA", defaultContent: "" },
                    { data: "UNIVENTA", defaultContent: "" },
                    { data: "CONTENIDO", defaultContent: "" },
                    { data: "PESO", defaultContent: "" },
                    { data: "FAMILIA", defaultContent: "" },
                    { data: "SUBFAMILIA", defaultContent: "" },
                    { data: "MARCA", defaultContent: "" },
                    { data: "GRUPO", defaultContent: "" },
                    { data: "PRECIOUNIVENTA", defaultContent: "" },
                    { data: "PRECIOUNIDADES", defaultContent: "" },
                    { data: "VIGENCIA", defaultContent: "" }
                ],
                "language":  languageES
        });

        tableListaBonificacion = $('#tableBonificacion').DataTable( {
                "processing": true,
                "scrollX": true, 
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
                        action: function ( e, dt, node, config ){
                            $("#fechaInicio").val(fechaInicio);
                            //$("#fechaFin").val(fechaFin);
                        }
                    }                   
                ],
                "ajax": {
                    "url" : 'get/obtenerListaBonificacion',
                    "type": 'POST',
                    "dataSrc": '',
                    "data" : function(d){
                        return { 
                            "fechaInicio" : fechaInicio,
                            //"fechaFin" : fechaFin,
                        };
                    }
                },
                "columnDefs": [
                 {
                        "targets": 2,
                        "data": "IDGRUPO",
                        "render": function ( data, type, row, meta ) {
                            
                            var count = Object.keys(row).length;
                            if(count == 0){
                               return "0";
                            }else{
                                return  '<a href="javascript:void(0)" onClick="showDetailGroups('+row.IDGRUPO+')">'+row.IDGRUPO+'</a>';;
                            }   
                        }
                    },
                ],
                "columns": [
                    { data: "IDPROMOCION" , defaultContent: ""},
                    { data: "DESCRIPCION_PROMO" , defaultContent: ""},
                    { data: "IDGRUPO" , defaultContent: ""},
                    { data: "MALLA" , defaultContent: ""},
                    { data: "DESCRIPCION_GRUPO" , defaultContent: ""},
                    { data: "IDRANGO" , defaultContent: ""},
                    { data: "UNIDAD" , defaultContent: ""},
                    { data: "DESDE" , defaultContent: ""},
                    //{ data: "HASTA" , defaultContent: ""},
                    {
                    "targets": 0,
                        "data": "HASTA",
                        "render": function ( data, type, row, meta ) {
                            var count = Object.keys(row).length;
                            if(count == 0){
                                return "-";
                            }else {
                                var arti=parseFloat(row.HASTA).toFixed(0);
                                return arti;
                            }
                        }
                    },
                    { data: "PORCADA" , defaultContent: ""},
                    { data: "IDACCION" , defaultContent: ""},
                    { data: "ARTICULO" , defaultContent: ""},
                    { data: "DESCRIPCION" , defaultContent: ""},
                    { data: "INICIO" , defaultContent: ""},
                    { data: "FIN" , defaultContent: ""},
                    //{ data: "ESTADO" , defaultContent: ""}
                ],
                "language":  languageES
        });

        tableGrupos = $('#tableGrupos').DataTable({
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
                    }
                                  
                ],

                "ajax": {
                    "url" : 'get/obtenerGrupos',
                    "type": 'POST',
                    "dataSrc": ''
                },

                "columnDefs": [
                    {
                        "targets":[1,2,3,4],
                        "searchable":false

                    }
                ],
                "columns": [
                    
                    { data: "IDGRUPO",defaultContent: "" },
                    { data: "MALLA",defaultContent: "" },
                    { data: "DESCRIPCION", defaultContent: "" },   
                    { data: "ARTICULO", defaultContent: "" },
                    { data: "DESCRIP1", defaultContent: "" }
                ],
                "language":  languageES
        });

        /*$('#tableGrupos').on( 'keyup', function () {
            table
                .columns( 0 )
                .search( this.value )
                .draw();
        } );*/
        $("#tableGrupos").on( 'keyup', function () {
            tableGrupos.columns( 0 ).search( this.value ).draw();
        });
       

    });
 function showDetailGroups(id){
            grupo_id=id;
               tableDetailGroup = $('#grupo_detail_table').DataTable( {
                bDestroy:true,
                "processing": true,
                "scrollX": true, 
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
                                   
                ],
                "ajax": {
                    "url" : 'get/getDetailGroup',
                    "type": 'POST',
                    "dataSrc": '',
                    "data" : function(){
                        return { 
                            "id_grupo" : grupo_id,
                            //"fechaFin" : fechaFin,
                        };
                    }
                },
               
                "columns": [
                    { data: "MALLA" , defaultContent: ""},
                    { data: "DESCRIPCION" , defaultContent: ""},
                    { data: "ARTICULO" , defaultContent: ""},
                    { data: "DESCRIP1" , defaultContent: ""},
                    
                   
                     
                ],
                  "language":  languageES
                 
        });
                $("#group_detail_dialog").modal({backdrop: 'static', show: true, keyboard: false });
        }
    </script>
@stop