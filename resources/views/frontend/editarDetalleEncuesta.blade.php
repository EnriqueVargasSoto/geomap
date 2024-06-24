@extends('layouts.frontend.master')
@section('style')
    <!-- bootstrap datepicker -->
    <link rel="stylesheet" href="{{ url('/') }}/plugins/datepicker/datepicker3.css">
    <style>
        .v-center {
            min-height: 180px;
            display: flex;
            justify-content:center;
            flex-flow: column wrap;
        }
        a.list-group-item.item {
            font-size: 11.5px;
        }
        .center{
            text-align: center;
        }
        select.two-side[multiple]{
            height: 180px;
        }
        .two-side option {
            white-space: normal;
            padding: 4px;
        }
        .select2-selection__choice{
            background: #5897fb !important;
        }
        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
            color: white  !important;
        }
    </style>
@stop
@section('content')
 <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content-header">
        <h1> EDITAR VIGENCIA <small> {{ $encuesta->descripcion }} </small> </h1>
   </section>
   <section class="content">
       {!! Form::open(['url' => url('encuesta/detalle/editar',[$encuesta->idEncuesta, $detalleEncuesta->idEncuestaDetalle]), 'id' => 'formEncuesta', 'enctype' => 'multipart/form-data']) !!}
        <div class="box box-primary">
            <div class="box-body">
                <div  id="errorsModal" ></div>
                <div class="row">
                      <div class="col-lg-4">
                        <div class="form-group">
                            <label>Fecha Vigencia Desde:</label>
                            {!! Form::text('fechaDesde', $detalleEncuesta->fechaInicio, ['class'=> "form-control", 'id' => 'fechaDesde']) !!}
                            {!! $errors->first('fechaDesde', '<div class="text-red">:message</div>') !!}
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Fecha Vigencia Hasta:</label>
                            {!! Form::text('fechaHasta', $detalleEncuesta->fechaFin, ['class'=> "form-control", 'id' => 'fechaHasta']) !!}
                            {!! $errors->first('fechaHasta', '<div class="text-red">:message</div>') !!}
                        </div>
                    </div>
					<div class="col-lg-4">
                        <div class="form-group">
                            <label>Encuestas Mínimas:</label>
                            {!! Form::number('encuestaMinima',  $detalleEncuesta->encuestasMinimas , ['class'=> "form-control required", 'id' => 'encuestaMinima']) !!}
                            {!! $errors->first('encuestaMinima', '<div class="text-red">:message</div>') !!}
                        </div>
                    </div>
                </div>
                <div class="row">
					<div class="col-lg-4">
                        <div class="form-group">
                            <label>Fotos Mínimas:</label>
                            {!! Form::number('fotosMinimas',  $detalleEncuesta->fotosMinimas , ['class'=> "form-control required", 'id' => 'fotosMinimas']) !!}
                            {!! $errors->first('fotosMinimas', '<div class="text-red">:message</div>') !!}
                        </div>
                    </div>
					<div class="col-lg-4">
                        <div class="form-group">
                            <label>Max. intentos de encuesta a un Cliente</label>
                            {!! Form::number('intentosEncuesta',  $detalleEncuesta->maximoIntentosCliente , ['class'=> "form-control required", 'id' => 'intentosEncuesta']) !!}
                            {!! $errors->first('intentosEncuesta', '<div class="text-red">:message</div>') !!}
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <div class="form-group">
                            <?php
                                $estado = ["1" => "Activo", "0" => "Inactivo"]
                            ?>
                            <label>Estado:</label>
                            {!! Form::select('estadoEncuesta',$estado, $detalleEncuesta->estado, ['class'=> 'form-control select2','tabindex' => 1, 'id' => 'estadoEncuesta']) !!}
                            {!! $errors->first('estadoEncuesta', '<div class="text-red">:message</div>') !!}
                        </div>
                    </div>
					<div class="col-lg-4">
                        <div class="form-group">
							<div class="checkbox">
							    <label>
                                  {!! Form::checkbox('clienteObligatorio', '1', $detalleEncuesta->clientesObligatorios > 0 ? true : false) !!}
                                  Clientes Obligatorios
                                </label>
                                {!! $errors->first('clienteObligatorio', '<div class="text-red">:message</div>') !!}
							</div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <div class="checkbox">
                               <label>
                                  {!! Form::checkbox('clienteAnonimo', '1',  $detalleEncuesta->clientesAnonimos > 0 ? true : false) !!}
                                   Clientes Anónimo
                               </label>
                               {!! $errors->first('clienteAnonimo', '<div class="text-red">:message</div>') !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <h4 style="padding-left: 15px;">Asociacion de Encuesta</h4>
            <div class="col-md-12">
                <div class="box">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <?php
                                        $ocasionConsumo = [ "all" => "Todos"] + \App\Models\OcasionConsumo::orderBy('descripcion')->get()->pluck('descripcion', 'idOcasionConsumo')->toArray();
                                        $ocasionConsumoSeleccionado =  explode(",", $detalleEncuesta->filtroOcasion);
                                    ?>
                                    <label>Ocasion Consumo:</label>
                                    {!! Form::select('ocasionConsumo[]',$ocasionConsumo, $ocasionConsumoSeleccionado, ['class'=> 'form-control select2','tabindex' => 1, 'multiple'=> true, 'id' => 'ocasionConsumo']) !!}
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label>Canal de Ventas:</label>
                                    {!! Form::select('canalVentas[]',[], null, ['class'=> 'form-control select2','tabindex' => 1, 'multiple'=> true, 'id' => 'canalVentas']) !!}
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label>Giro:</label><br>
                                    {!! Form::select('giro[]',[], null, ['class'=> 'form-control select2','tabindex' => 1,'multiple'=> true, 'id' => 'giro']) !!}
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label>SubGiro:</label>
                                    {!! Form::select('subGiro[]',[], null, ['class'=> 'form-control select2','tabindex' => 1,'multiple'=> true, 'id' => 'subGiro']) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
            $vendedores = \App\Models\Persona::selectRaw("LOWER(nombre) as persona,idPersona ")->where('idEmpresa',Auth::user()->idEmpresa)->where('idSucursal',Auth::user()->idSucursal)->orderBy('persona')->get()->pluck('persona', 'idPersona')->toArray();
            $roles = \App\Models\Perfil::where('abreviatura','!=','X')->orderBy('descripcion')->get()->pluck('descripcion', 'idPerfil')->toArray();
            $segmentos = \App\Models\Segmento::where('idEmpresa',Auth::user()->idEmpresa)->orderBy('descripcion')->get()->pluck('descripcion', 'idSegmento')->toArray();
            $clientes = \App\Models\Cliente::where('idEmpresa',Auth::user()->idEmpresa)->where('idSucursal',Auth::user()->idSucursal)->orderBy('razonSocial')->get()->pluck('razonSocial', 'idCliente')->toArray();
        ?>
        <div class="row">
            <div class="col-md-12">
                <div class="box box-success">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-7">
                                <h4 class="center"> Lista de vendedores</h4>
                                <hr>
                                <div class="col-sm-5">
                                    <?php
                                    $listaFiltroVendedor = \App\Models\EncuestaDetallexVendedor::where("idEmpresa",Auth::user()->idEmpresa)->where("idSucursal",Auth::user()->idSucursal)->where("idEncuesta", $encuesta->idEncuesta)
                                                                                          ->where("idEncuestaDetalle", $detalleEncuesta->idEncuestaDetalle)->get();
                                    $filtroVendedor = "";
                                    foreach ($listaFiltroVendedor as $item){
                                        $filtroVendedor = $filtroVendedor.$item->idVendedor.",";
                                    }
                                    ?>
                                    {!! Form::select('filtroVendedor[]',$vendedores, null , ['class'=> 'form-control two-side','tabindex' => 8,'multiple'=> true, 'id' => 'filtroVendedor']) !!}
                                </div>
                                <div class="col-sm-2 v-center">
                                    <button type="button" id="filtroVendedor_rightAll"  class="btn btn-block"><i class="glyphicon glyphicon-forward"></i></button>
                                    <button type="button" id="filtroVendedor_rightSelected" class="btn btn-block"><i class="glyphicon glyphicon-chevron-right"></i></button>
                                    <button type="button" id="filtroVendedor_leftSelected" class="btn btn-block"><i class="glyphicon glyphicon-chevron-left"></i></button>
                                    <button type="button" id="filtroVendedor_leftAll" class="btn btn-block"><i class="glyphicon glyphicon-backward"></i></button>
                                </div>
                                <div class="col-sm-5">
                                    {!! Form::select('filtroVendedor_to[]',[],null, ['class'=> 'form-control two-side','tabindex' => 8,'multiple'=> true, 'id' => 'filtroVendedor_to']) !!}
                                </div>
                            </div>
                            <div class="col-md-5">
                                <h4 class="center"> Lista de roles</h4>
                                <hr>
                                <div class="col-sm-5">
                                    <?php
                                    $listaFiltroRoles = \App\Models\EncuestaDetallexCargo::where("idEmpresa",Auth::user()->idEmpresa)->where("idSucursal",Auth::user()->idSucursal)->where("idEncuesta", $encuesta->idEncuesta)
                                        ->where("idEncuestaDetalle", $detalleEncuesta->idEncuestaDetalle)->get();
                                    $filtroRoles = "";
                                    foreach ($listaFiltroRoles as $item){
                                        $filtroRoles = $filtroVendedor.$item->cargo.",";
                                    }
                                    ?>
                                    {!! Form::select('filtroRoles[]',$roles, null , ['class'=> 'form-control two-side','tabindex' => 8,'multiple'=> true, 'id' => 'filtroRoles']) !!}
                                </div>
                                <div class="col-sm-2 v-center">
                                    <button type="button" id="filtroRoles_rightAll" class="btn btn-block"><i class="glyphicon glyphicon-forward"></i></button>
                                    <button type="button" id="filtroRoles_rightSelected" class="btn btn-block"><i class="glyphicon glyphicon-chevron-right"></i></button>
                                    <button type="button" id="filtroRoles_leftSelected" class="btn btn-block"><i class="glyphicon glyphicon-chevron-left"></i></button>
                                    <button type="button" id="filtroRoles_leftAll" class="btn btn-block"><i class="glyphicon glyphicon-backward"></i></button>
                                </div>
                                <div class="col-sm-5">
                                    {!! Form::select('filtroRoles_to[]',[],null, ['class'=> 'form-control two-side','tabindex' => 8,'multiple'=> true, 'id' => 'filtroRoles_to']) !!}
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-7">
                                <h4 class="center"> Lista de segmentos</h4><hr>
                                <div class="col-sm-5">
                                    <?php
                                    $listaFiltroSegmento = \App\Models\EncuestaDetallexSegmento::where("idEmpresa",Auth::user()->idEmpresa)->where("idSucursal",Auth::user()->idSucursal)->where("idEncuesta", $encuesta->idEncuesta)
                                                                                            ->where("idEncuestaDetalle", $detalleEncuesta->idEncuestaDetalle)->get();
                                    $filtroSegmento = "";
                                    foreach ($listaFiltroSegmento as $item){
                                        $filtroSegmento = $filtroSegmento.$item->idSegmentoCliente.",";
                                    }
                                    ?>
                                    {!! Form::select('filtroSegmentos[]',$segmentos, null , ['class'=> 'form-control two-side','tabindex' => 8,'multiple'=> true, 'id' => 'filtroSegmentos']) !!}
                                </div>
                                <div class="col-sm-2 v-center">
                                    <button type="button" id="filtroSegmentos_rightAll"  class="btn btn-block"><i class="glyphicon glyphicon-forward"></i></button>
                                    <button type="button" id="filtroSegmentos_rightSelected" class="btn btn-block"><i class="glyphicon glyphicon-chevron-right"></i></button>
                                    <button type="button" id="filtroSegmentos_leftSelected" class="btn btn-block"><i class="glyphicon glyphicon-chevron-left"></i></button>
                                    <button type="button" id="filtroSegmentos_leftAll" class="btn btn-block"><i class="glyphicon glyphicon-backward"></i></button>
                                </div>
                                <div class="col-sm-5">
                                    <?php
                                    $listaFiltroCliente = \App\Models\EncuestaDetallexCliente::where("idEmpresa",Auth::user()->idEmpresa)->where("idSucursal",Auth::user()->idSucursal)->where("idEncuesta", $encuesta->idEncuesta)
                                                                                        ->where("idEncuestaDetalle", $detalleEncuesta->idEncuestaDetalle)->get();
                                    $filtroClientes = "";
                                    foreach ($listaFiltroCliente as $item){
                                        $filtroClientes = $filtroClientes.$item->idCliente.",";
                                    }
                                    ?>
                                    {!! Form::select('filtroSegmentos_to[]',[],null, ['class'=> 'form-control two-side','tabindex' => 8,'multiple'=> true, 'id' => 'filtroSegmentos_to']) !!}
                                </div>
                            </div>
                            <div class="col-md-5">
                                <h4 class="center"> Clientes</h4><hr>
                                {!! Form::select('filtroClientes[]',$clientes, null, ['class'=> 'form-control','tabindex' => 8,'multiple'=> true, 'id' => 'filtroClientes']) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="box-footer">
            <button id="btnNuevaEncuesta" type="submit" class="btn btn-primary"> Guardar </button>
            <button id="btnLimpiarEncuesta" type="button" class="btn btn-default"> Cancelar </button>
        </div>
        {!! Form::close() !!}
    </section>
</div>
@stop
@section('script')
    <!-- bootstrap datepicker -->
    <script src="{{ url('/') }}/plugins/datepicker/bootstrap-datepicker.js"></script>
    <script type="text/javascript" src="{{ url('/') }}/plugins/two-side-multi-select/multiselect.min.js"></script>
    <script>
        $(document).ready(function() {
            $('[data-toggle = "tooltip"]').tooltip();

            listaCanalVentas = [{{ $detalleEncuesta->filtroCanalVentas }}];
            listaGiro = [{{ $detalleEncuesta->filtroGiro }}];
            listaSubGiro = [{{ $detalleEncuesta->filtroSubGiro }}];

            if(listaCanalVentas.length > 0){
                actualizarCanalVentas(listaCanalVentas);
            }

            $.fn.datepicker.dates['es'] = {
                days:       ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo"],
                daysShort:  ["Dom", "Lun", "Mar", "Mié", "Jue", "Vie", "Sáb", "Dom"],
                daysMin:    ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa", "Do"],
                months:     ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
                monthsShort:  ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"],
                today: "Hoy"
            };

            $("#formEncuesta").validate({
                rules: {
                    fechaDesde: "required",
                    fechaHasta: "required",
                    descripcion: "required",
                    encuestaMinima: {
                        required: true,
                        digits: true
                    },
                    fotosMinimas: "required",
                    intentosEncuesta: "required"
                }
            });
            listaClientes = [{{ $filtroClientes }}];
            $('#filtroClientes').select2({language: 'es', placeholder: "cliente"});
            $('#filtroClientes').val(listaClientes);
            $('#filtroClientes').trigger('change.select2');

            $('#filtroVendedor').multiselect({
                search: {
                    left: '<input type="text" name="q" class="form-control" placeholder="Buscar..." />',
                    right: '<input type="text" name="q" class="form-control" placeholder="Buscar..." />',
                },
                fireSearch: function(value) {
                    return value.length >= 1;
                }
            });

            listaVendedores = [{{ $filtroVendedor }}];
            $("#filtroVendedor").val(listaVendedores);
            $("#filtroVendedor_rightSelected").click();

            $('#filtroRoles').multiselect({
                search: {
                    left: '<input type="text" name="q" class="form-control" placeholder="Buscar..." />',
                    right: '<input type="text" name="q" class="form-control" placeholder="Buscar..." />',
                },
                fireSearch: function(value) {
                    return value.length >= 1;
                }
            });
            listaRoles = [{{ $filtroRoles }}];
            $("#filtroRoles").val(listaRoles);
            $("#filtroRoles_rightSelected").click();

            $('#filtroSegmentos').multiselect({
                search: {
                    left: '<input type="text" name="q" class="form-control" placeholder="Buscar..." />',
                    right: '<input type="text" name="q" class="form-control" placeholder="Buscar..." />',
                },
                fireSearch: function(value) {
                    return value.length >= 1;
                }
            });

            listaSegmento = [{{ $filtroSegmento }}];
            $("#filtroSegmentos").val(listaSegmento);
            $("#filtroSegmentos_rightSelected").click();

            $('#ocasionConsumo').select2({  language: 'es',  placeholder: "ocasion de consumo"});
            $('#canalVentas').select2({  language: 'es',  placeholder: "canal de ventas"});
            $('#giro').select2({  language: 'es',  placeholder: "giro"});
            $('#subGiro').select2({  language: 'es',  placeholder: "SubGiro"});

            function limpiarCampos (){
                $("#fechaDesde").val('');
                $("#fechaHasta").val('');
                $("#encuestaMinima").val('0');
                $("#fotosMinimas").val('0');
                $("#intentosEncuesta").val('1');
                $('#clienteObligatorio').prop('checked', false);
                $('#clienteAnonimo').prop('checked', false);
            }

            //Date picker
            $('#fechaDesde').datepicker({
                language: 'es',
                format: 'yyyy/mm/dd',
                autoclose: true
            });

            $('#fechaHasta').datepicker({
                language: 'es',
                format: 'yyyy/mm/dd',
                autoclose: true
            });

            $("#fechaDesde").inputmask("yyyy/mm/dd", {"placeholder": "yyyy/mm/dd"});
            $("#fechaHasta").inputmask("yyyy/mm/dd", {"placeholder": "yyyy/mm/dd"});

        });

        //Filtros asociacion
        $("#ocasionConsumo").change(function() {
            actualizarCanalVentas([]);
        });

        function actualizarCanalVentas( lista ){
            var ocasionConsumo = $("#ocasionConsumo").val();
            if(ocasionConsumo.length > 0){
                $("#canalVentas").empty();
                $("#giro").empty();
                $("#subGiro").empty();

                $.ajax({
                    global: false,
                    type: "POST",
                    dataType: 'json',
                    data: { "ocasionConsumo": ocasionConsumo },
                    url: '{{ url("/") }}/get/canalVentas',
                }).done(function(jsondata) {
                    if(jsondata.length >=1){
                        var selectObject = $("#canalVentas");
                        $.each(jsondata, function(index, element){
                            selectObject.append("<option value='"+ element['idCanalVentas'] +"'>" + element['descripcion'] + "</option>");
                        });
                    }
                    if(lista.length > 0){
                        selectObject.val(lista);

                        if(listaGiro.length > 0){
                            actualizarGiro(listaGiro);
                        }
                    }
                })
                .fail(function() {
                    alert( "Error" );
                });
            }
        }

        //Filtros asociacion
        $("#canalVentas").change(function() {
            actualizarGiro([]);
        });

        function actualizarGiro( lista){
            var canalVentas = $("#canalVentas").val();
            if(canalVentas.length > 0){
                $("#giro").empty();
                $("#subGiro").empty();

                $.ajax({
                    global: false,
                    type: "POST",
                    dataType: 'json',
                    data: { "canalVentas": canalVentas },
                    url: '{{ url("/") }}/get/giro',
                }).done(function(jsondata) {
                    if(jsondata.length >=1){
                        var selectObject = $("#giro");
                        $.each(jsondata, function(index, element){
                            selectObject.append("<option value='"+ element['idGiro'] +"'>" + element['descripcion'] + "</option>");
                        });
                    }
                    if(lista.length > 0){
                        selectObject.val(lista);

                        if(listaSubGiro.length > 0){
                            actualizarSubGiro(listaSubGiro);
                        }
                    }
                })
                .fail(function() {
                    alert( "Error" );
                });
            }
        }

        //Filtros asociacion
        $("#giro").change(function() {
            actualizarSubGiro([]);
        });

        function actualizarSubGiro(lista){
            var giro = $("#giro").val();
            if(giro.length > 0){
                $("#subGiro").empty();
                $.ajax({
                    global: false,
                    type: "POST",
                    dataType: 'json',
                    data: { "giro": giro },
                    url: '{{ url("/") }}/get/subGiro',
                }).done(function(jsondata) {
                    if(jsondata.length >=1){
                        var selectObject = $("#subGiro");
                        $.each(jsondata, function(index, element){
                            selectObject.append("<option value='"+ element['idSubGiro'] +"'>" + element['descripcion'] + "</option>");
                        });
                    }
                    if(lista.length > 0){
                        selectObject.val(lista);
                    }
                })
                .fail(function() {
                    alert( "Error" );
                });
            }
        }
    </script>
@stop