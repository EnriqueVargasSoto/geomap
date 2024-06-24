@extends('layouts.frontend.master')
@section('style')
    <style>
        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #3c8dbc;
            border-color: #367fa9;
            padding: 1px 10px;
            color: #fff;
        }
    </style>
@endsection
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <section class="content">
            <div class="box box-primary">
                <div class="box-body">
                    <h3> Editar Usuario </h3><br>
                    <div class="row">
                        <?php
                            $empresa = ["" => "[ --seleccione-- ]"] + \App\Models\Empresa::has('sucursales')->orderBy('razonSocial', 'asc')->get()->pluck('razonSocial', 'idEmpresa')->toArray();

                            $zonas  =   \App\Models\Zona::porUsuario( $user->idEmpresa, $user->idSucursal, $user->idUsuario)->pluck('idZona')->toArray();
                        ?>
                        {!! Form::model($user, ['route' => ['users.update', $user->idUsuario], 'method' => 'patch', 'enctype' => 'multipart/form-data']) !!}
                            <div class="form-group col-sm-6">
                                <input name='_id' type="hidden" value="{{ $user->idUsuario}} "/>
                                {!! Form::label('empresa', '* Empresa:') !!}
                                {!! Form::select('empresa',$empresa, $user->idEmpresa, ['class'=> 'form-control select2','tabindex' => 1, 'id' => 'empresa']) !!}
                                {!! $errors->first('empresa', '<div class="text-red">:message</div>') !!}
                            </div>
                            <div class="form-group col-sm-6">
                                {!! Form::label('sucursal', '* Sucursal:') !!}
                                {!! Form::select('sucursal',[],  null, ['class'=> 'form-control select2','tabindex' => 2, 'id' => 'sucursal']) !!}
                                {!! $errors->first('sucursal', '<div class="text-red">:message</div>') !!}
                            </div>
                            {!! Form::hidden('cargo', $user->idPerfil, ['class'=> 'form-control','tabindex' => 3, 'id' => 'cargo']) !!}
                            <div class="form-group col-sm-6">
                                {!! Form::label('usuario', '* Usuario:') !!}
                                {!! Form::text('usuario', $user->usuario, ['class' => 'form-control' ,'tabindex' => 4]) !!}
                                {!! $errors->first('usuario', '<div class="text-red">:message</div>') !!}
                            </div>
                            <div class="form-group col-sm-6">
                                {!! Form::label('nombre', 'Nombre y Apellidos:') !!}
                                {!! Form::text('nombre', $user->nombre, ['class' => 'form-control','tabindex' => 7]) !!}
                                {!! $errors->first('nombre', '<div class="text-red">:message</div>') !!}
                            </div>
                            <div class="form-group col-sm-12">
                                {!! Form::label('nombre', 'Zonas:') !!}
                                {!! Form::select('zonas[]',[], null  , ['class'=> 'form-control','tabindex' => 8,'multiple'=> true, 'id' => 'zonas']) !!}
                                @if (count($errors) > 0)
                                    <div class="text-red">
                                        @foreach ($errors->get('zonas') as $error)
                                        {{ $error }}</br>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                            <div class="form-group col-sm-6">
                                {!! Form::label('clave', 'Nueva Contraseña:') !!}
                                {!! Form::password('clave', ['class' => 'form-control','tabindex' => 5]) !!}
                                {!! $errors->first('clave', '<div class="text-red">:message</div>') !!}
                            </div>
                            <div class="form-group col-sm-6">
                                {!! Form::label('confirmacion', 'Confirmar Contraseña:') !!}
                                {!! Form::password('confirmacion', ['class' => 'form-control','tabindex' => 6]) !!}
                                {!! $errors->first('confirmacion', '<div class="text-red">:message</div>') !!}
                            </div>
                            <div class="form-group col-sm-12">
                                {!! Form::submit('Guardar', ['class' => 'btn btn-primary','tabindex' => 9]) !!}
                                <a href="{!! route('users.index') !!}" class="btn btn-default">Cancelar</a>
                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!-- /.content-wrapper -->
@endsection
@section('script')
    <script>
        
        $(document).ready(function() {
            $('#empresa').select2({language: 'es', placeholder: "Empresa"});
            $('#sucursal').select2({language: 'es', placeholder: "Sucursal"});
            $('#zonas').select2({language: 'es', placeholder: "Zonas"});

            if("{{ $user->idSucursal }}".length > 1){
                actualizarSucursales( "{{ $user->idSucursal }}".trim());
            }

            if("{{ old('sucursal') }}".length > 1){
                actualizarSucursales( "{{ old('sucursal') }}");
            }

            function actualizarSucursales(valorAnterior){
                $("#sucursal").empty();
                $("#sucursal").prop('disabled', true);
                $.ajax({
                    global: false,
                    type: "POST",
                    dataType: 'json',
                    data: { "empresa": $("#empresa").val()},
                    url: '{{ url('/') }}/get/sucursalEmpresa',
                }).done(function(jsondata) {
                    if(jsondata.length >=1){
                        var selectObject = $("#sucursal");
                        $.each(jsondata, function(index, element){
                            selectObject.append("<option value='"+ element['idSucursal'].trim() +"'>" + element['nombre'] + "</option>");
                        });
                        if(valorAnterior.length > 0){
                            selectObject.val(valorAnterior);

                            if({{old('zonas')}}){
                                actualizarZonas(true);
                            }else  if({{ count($zonas) }} > 0){
                                actualizarZonas(true);
                            }else{
                                actualizarZonas(false);
                            }
                        }
                        selectObject.prop('disabled', false);
                    }
                })
                    .fail(function() {
                        alert( "Error" );
                    });
            }


            if({{old('zonas')}}){
                listaZonas =  [ <?php   if ( old('zonas')){ foreach (old('zonas') as $id){ echo $id.','; } } ?> ];
            } else if ({{ count( $zonas) }} > 0){
                listaZonas =  [ <?php   if ( count($zonas) > 0){ foreach ($zonas as $id){ echo $id.','; } } ?> ];
            }

            function actualizarZonas(hasValue){
                $("#zonas").empty();
                $("#zonas").prop('disabled', true);

                $.ajax({
                    global: false,
                    type: "POST",
                    dataType: 'json',
                    data: { "empresa": $("#empresa").val(),  "sucursal": $("#sucursal").val(),  "usuario": '{{ $user->idUsuario }}'},
                    url: '{{ url('/') }}/get/zonasxUser',
                }).done(function(jsondata) {
                    if(jsondata.length >=1){
                        var selectObject = $("#zonas");
                        $.each(jsondata, function(index, element){
                            selectObject.append("<option value='"+ element['idZona'] +"'>" + element['idZona'] + "-" +element['descripcion'] + "</option>");
                        });
                        if(hasValue){
                            $("#zonas").val( listaZonas);
                            $('#zonas').trigger('change.select2');
                        }
                        selectObject.prop('disabled', false);
                        $('#zonas').trigger('change.select2');
                    }
                    $("#zonas").prop('disabled', false);
                })
                .fail(function() {
                    alert( "Error" );
                });
            }

            $("#empresa").change(function() {
                if($("#empresa").val().length > 1){
                    actualizarSucursales(null);
                }
            });

            $("#sucursal").change(function() {
                if( $('#sucursal').val().length > 1){
                    actualizarZonas(false);
                }
            });

        });
       
    </script>
@endsection