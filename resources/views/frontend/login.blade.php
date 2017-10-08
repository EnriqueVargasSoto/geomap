<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>GeoMap| Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="bower_components/bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/iCheck/square/blue.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="#"><b>GEO</b>Localización</a>
  </div>
  <!-- /.login-logo -->
  @include('flash::message')
  <div class="login-box-body">
    <p class="login-box-msg">Ingrese sus credenciales para iniciar su sesión</p>
    {!! Form::model($login, ['url' => '/login', 'id' => 'login-form', 'name' => 'login-form', 'method' => 'post']) !!}
      <div class="form-group has-feedback">
		{!! Form::text('usuario', null, ['placeholder'=> "usuario", 'class'=> "form-control"]) !!} 
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
        
		{!! $errors->default->first('usuario', '<div class="errorMessage">:message</div>') !!} 
      </div>
      <div class="form-group has-feedback">
		{!! Form::password('clave', ['placeholder'=> "contraseña", 'class'=> "form-control"]) !!}
        <span class="glyphicon glyphicon-lock form-control-feedback"></span> 
        {!! $errors->default->first('clave', '<div class="errorMessage">:message</div>') !!}        
      </div>
      <div class="row"> 
        <div class="col-xs-12">
			{!! Form::hidden('back', redirect()->getUrlGenerator()->previous()) !!}
			{!! Form::button('Submit', ['type' => 'Acceder', 'class' => 'btn btn-primary btn-block btn-flat']) !!} 
        </div>
        <!-- /.col -->
      </div>
    {!! Form::close() !!}
  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box --> 
<!-- jQuery 3 -->
<script src="bower_components/jquery/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>