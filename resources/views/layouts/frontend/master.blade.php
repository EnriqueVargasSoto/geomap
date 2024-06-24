<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>GeoMap</title>
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
    <link rel="stylesheet" href="{{ url('/') }}/css/AdminLTE.min.css">
    <link rel="stylesheet" href="{{ url('/') }}/css/skins/skin-green.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ url('/') }}/plugins/select2/css/select2.min.css">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]--> 
	<link rel="stylesheet" href="{{ url('/') }}/plugins/pNotify/pnotify.css">
    <style>
        html{
            font-family: sans-serif;
        }
        table {
            font-size: 12px !important;
        }
        .dataTables_wrapper .dataTables_scroll div.dataTables_scrollBody>table>tbody>tr>td {
            text-align: center;
        }
        .btn.mdn{
            padding-left:13px;
            padding-right:16px;
        }
        .main-header .logo .logo-lg {
            font-size: 15px;
        }
        .only-mobile{
            display: block;
        }
        .not-mobile{
            display: none !important;
        }
        #empresaNombre {
            display: none;
        }
        select{
            text-transform: capitalize;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            text-transform: capitalize;
        }
        span.select2-results ul li{
            text-transform: capitalize;
        }
        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 9999;
            background: rgba(255,255,255,0.7);
            border-radius: 3px;
        }
        .overlay>.fa {
            position: absolute;
            top: 50%;
            left: 50%;
            margin-left: -15px;
            margin-top: -15px;
            color: #000;
            font-size: 30px;
        }
        .brighttheme .ui-pnotify-title {
            text-transform: uppercase;
        }
        .error {
            border-color: red;
            font-weight: 300;
            display: block;
        }
        /*Desktops and Laptops */
        @media only screen and (min-width: 1224px) {
            #empresaNombre {
                display: block;
            }
            .not-mobile{
                display: block !important;
            }
            .only-mobile a {
                display: none !important;
            }
            .brighttheme.ui-pnotify-container{
                text-align: left !important;
            }
        }
        th{
            font-weight: 500 !important;
        }
        /** Tablet */
        @media only screen and (min-width: 768px) {
            #empresaNombre {
                display: block;
            }
            .only-mobile{
                display: none;
            }
            .brighttheme.ui-pnotify-container{
                text-align: left !important;
            } 
        }
        .error {
            border-color: red;
        }
        .empresa {
            float: left;
            white-space: nowrap;
            padding-top: 15px;
            padding-bottom: 15px;
            padding-left: 15px;
            line-height: 20px;
            color: white;
            text-decoration: none;
        }
        .empresa a {
            color: white;
            text-decoration: none;
        }
        .navbar-nav>.user-menu>.dropdown-menu>li.user-header {
            height: auto;
        }
        .brighttheme.ui-pnotify-container{
            text-align: center;
        }
		
		.sidebar-collapse .logo-nav{
			display: none;
		}
		.main-sidebar{
			padding-top: 60px;
		}
		.logo-nav{
			max-width: 264px;
			position: absolute;
			top: 450px; 
			max-height: 80px;
			left: 20px;
			z-index: 0;
			display: block;
		}
    </style>
    @yield('style')
</head>
<body class="hold-transition skin-green sidebar-mini">
    <div class="wrapper">
        <header class="main-header">
            <!-- Logo -->
            <a href="" id="empresaNombre" class="logo">
                <!-- mini logo for sidebar mini 50x50 pixels -->
            <!-- span class="logo-mini">{{ Auth::user()->empresa }}</span -->
                <!-- logo for regular state and mobile devices -->
                <span class="logo-lg">{{ Auth::user()->empresa }}</span>
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top">
                <!-- Sidebar toggle button-->
                @if (Auth::check())
					<a id="menuButton" href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                        <span class="sr-only">Toggle navigation</span>
                    </a> 
					<span class="empresa only-mobile">
						<a href="javascript:void(0)" class="dropdown-toggle">{{ Auth::user()->empresa }}</a>
					</span>           
                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">
                            <li class="messages-menu only-mobile">
                                <a href="javascript:void(0)" class="signout dropdown-toggle">
                                    <i class="fa fa-fw fa-sign-out"></i>
                                </a>
                            </li>
                            <!-- User Account: style can be found in dropdown.less -->
                            <li class="dropdown user user-menu not-mobile">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-fw fa-user"></i>
                                    <span class="hidden-xs">{{  Auth::user()->nombre != "" ? Auth::user()->nombre : Auth::user()->usuario }}</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <!-- User image -->
                                    <li class="user-header">
                                        <p>
                                            {{ Auth::user()->cargo }}
                                            <small>{{ Auth::user()->empresa }}</small>
                                        </p>
                                    </li>
                                    <!-- Menu Footer-->
                                    <li class="user-footer">
                                        <div class="pull-right">
                                            <a href="{{ url('logout') }}" id="logout" class="btn btn-default btn-flat">Salir</a>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                            <!-- Control Sidebar Toggle Button -->
                            @if(Session::get('active') == 'mapa')
                                <li> <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a> </li>
                            @endif
                        </ul>
                    </div>
                @endif
            </nav>
        </header>

        @include('layouts.frontend.menu')

        @yield('content')

        <footer class="main-footer">
            <div class="pull-right hidden-xs">
                <b>Version</b> 1.2
            </div>
            <strong>Copyright &copy; <?php echo date('Y'); ?> <a href="#"> Power by</a>.</strong> Xertica
        </footer>

        @include('layouts.frontend.controlSidebar')
        <!-- Add the sidebar's background. This div must be placed immediately after the control sidebar -->
        <div class="control-sidebar-bg"></div>
    </div>
    <!-- ./wrapper -->
    <!-- jQuery 3 -->
    <script src="{{ url('/') }}/plugins/jQuery/jquery.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{ url('/') }}/plugins/jQueryUI/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button);
    </script>
    <script src="{{ url('/') }}/plugins/jQueryValidate/jquery.validate.js"></script>
    <script src="{{ url('/') }}/plugins/jQueryValidate/localization/messages_es_PE.min.js"></script>
    <!-- pNotify -->
    <script src="{{ url('/') }}/plugins/pNotify/pnotify.js"></script>
    <script type="text/javascript">
        $.ajaxSetup({
            type: 'POST',
            headers: {
                "cache-control": "no-cache",
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
		
		$(document).ready(function(){
			$(".signout").click(function(){
				new PNotify({
				   title: 'Cerrar Sesion',
				   text: 'Esta seguro?',
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
				   addclass: 'stack-modal',
				   stack: {'dir1': 'down', 'dir2': 'right', 'modal': true}
				}).get().on('pnotify.confirm', function(){
					var href = $('#logout').attr('href');
					window.location.href = href;
				}).on('pnotify.cancel', function(){
				}); 
			});
		});
    </script>
    <!-- Bootstrap 3.3.7 -->
    <script src="{{ url('/') }}/plugins/bootstrap/js/bootstrap.min.js"></script>
    <!-- Slimscroll -->
    <script src="{{ url('/') }}/plugins/jquery-slimscroll/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    <script src="{{ url('/') }}/plugins/fastclick/fastclick.min.js"></script>
    <!-- AdminLTE App -->
    <script src="{{ url('/') }}/js/adminlte.min.js"></script>
    <!-- InputMask -->
    <script src="{{ url('/') }}/plugins/input-mask/jquery.inputmask.js"></script>
    <script src="{{ url('/') }}/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
    <!-- Select2 -->
    <script src="{{ url('/') }}/plugins/select2/js/select2.min.js"></script>
    <script src="{{ url('/') }}/plugins/select2/js/i18n/es.js"></script>
    @yield('script')
</body>
</html>