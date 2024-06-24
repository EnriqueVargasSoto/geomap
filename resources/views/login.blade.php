<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>GeoMap| Log in</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="{{ url('/') }}/plugins/bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ url('/') }}/plugins/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{ url('/') }}/plugins/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/iCheck/square/blue.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="{{ url('/') }}/plugins/select2/css/select2.min.css">
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <style>
    .select2-container--default .select2-results__option--highlighted[aria-selected] {
      text-transform: uppercase;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
      text-transform: uppercase;
    }
    .select2{
        max-width: 100%;
    }
	.login-page{
		background: #edf5f2 !important;
	}
  </style>
  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="#"> <img src="images/xalesmap_icon.png" style="max-width: 264px;" alt="Logo"></a>
  </div>
  <!-- /.login-logo -->
  @include('flash::message')
    <?php
      $empresa = [""=>"Empresa"]+ \App\Models\Empresa::has('sucursales')->orderBy('razonSocial', 'asc')->get()->pluck('razonSocial', 'idEmpresa')->toArray();
    ?>
  <div class="login-box-body">
    <p class="login-box-msg">Ingrese sus credenciales para iniciar su sesión</p>
    {!! Form::model($login, ['url' => '/login', 'id' => 'login-form', 'name' => 'login-form', 'method' => 'post']) !!}
    <div class="form-group has-feedback">
      {!! Form::select('empresa',$empresa, null, ['class'=> 'form-control select2','tabindex' => 1, 'id' => 'empresa']) !!}
      {!! $errors->first('empresa', '<div class="text-red">:message</div>') !!}
    </div>
    <div class="form-group has-feedback">
      {!! Form::select('sucursal',[], null, ['class'=> 'form-control select2','tabindex' => 2, 'id' => 'sucursal']) !!}
      {!! $errors->first('sucursal', '<div class="text-red">:message</div>') !!}
    </div>
    <div class="form-group has-feedback">
      {!! Form::text('usuario', null, ['placeholder'=> "usuario", 'class'=> "form-control", 'tabindex' => 3]) !!}
      <span class="glyphicon glyphicon-user form-control-feedback"></span>
      {!! $errors->default->first('usuario', '<div class="text-red">:message</div>') !!}
    </div>
    <div class="form-group has-feedback">
      {!! Form::password('clave', ['placeholder'=> "contraseña", 'class'=> "form-control", 'tabindex' => 4]) !!}
      <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      {!! $errors->default->first('clave', '<div class="text-red">:message</div>') !!}
    </div>
    <div class="row">
      <div class="col-xs-12">
        {!! Form::hidden('back', redirect()->getUrlGenerator()->previous()) !!}
        {!! Form::button('Acceder', ['type' => 'submit', 'class' => 'btn btn-primary btn-block btn-flat']) !!}
      </div>
      <!-- /.col -->
    </div>
    {!! Form::close() !!}
  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->
<!-- jQuery 3 -->
<script src="{{ url('/') }}/plugins/jQuery/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{ url('/') }}/plugins/bootstrap/js/bootstrap.min.js"></script>
<!-- Select2 -->
<script src="{{ url('/') }}/plugins/select2/js/select2.min.js"></script>
<script src="{{ url('/') }}/plugins/select2/js/i18n/es.js"></script>
<script>
    $.ajaxSetup({
        type: 'POST',
        headers: {
            "cache-control": "no-cache",
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(function() {
        $('#empresa').select2({  language: 'es',  placeholder: "Empresa" });
        $('#sucursal').select2({ language: 'es',  placeholder: "Sucursal" });
		$('#sucursal').prop('disabled', true);
 
        $("#empresa").change(function() {
            var empresa = $("#empresa").val();
			$('#sucursal').prop('disabled', true);
            if(empresa.length > 2){
                $("#sucursal").empty();
                $.ajax({
                    global: false,
                    type: "POST",
                    dataType: 'json',
                    data: { "empresa": empresa},
                    url: 'get/sucursalEmpresa',
                }).done(function(jsondata) {
					$('#sucursal').prop('disabled', false);
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

        $.ajax({
            global: false,
            type: "POST",
            dataType: 'json',
            data: { "empresa": $('#empresa').val() },
            url: 'get/sucursalEmpresa',
        }).done(function(jsondata) {
			$('#sucursal').prop('disabled', false);
            if(jsondata.length >=1){
                var selectObject = $("#sucursal");
                $.each(jsondata, function(index, element){
                    selectObject.append("<option value='"+ element['idSucursal'] +"'>" + element['nombre'] + "</option>");
                });
                if("{{ old('sucursal') }}".length > 1){
                    selectObject.val("{{ old('sucursal') }}");
                }
            }
        })
        .fail(function() {
            alert( "Error" );
        });

    });
</script>
</body>
</html>