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
    </style>
     <!-- iCheck for checkboxes and radio inputs -->   
    <link href="{{ url('/') }}/plugins/iCheck/square/green.css" rel="stylesheet">
	<!-- Select2 -->
    <style>       
        footer {
            display: none !important;
        }
        
        .label-checkbox{
            margin-left: 8px;
        }
        #content-map { 
            width: 100%;
		}
        #mapa {
            height: 20%;
            width: 100%;
            margin-left: 0px !important
        }
			 
        #legend {
            padding: 10px;
            margin: 10px;
            box-shadow: rgba(0, 0, 0, 0.3) 0px 1px 4px -1px;
            border-radius: 2px;
            cursor: pointer;
            background-color: rgb(255, 255, 255);
            bottom: 14px !important;
            margin-right: 48px;
            display:none;
        }
        #rutas:focus {
            -webkit-box-shadow: inset 0 0px 0px rgba(0,0,0,.075), 0 0 5px rgba(102,175,233,.6);
            box-shadow: inset 0 0px 0px rgba(0,0,0,.075), 0 0 5px rgba(102,175,233,.6);
        }
        .show {
            position: relative;
        }
        #legend div {
            padding-top: 2px;
        }
        #legend img {
            vertical-align: middle;
        }
		.bar-default{
			 background-color: #747171 !important;
		}
        .label-G{
            background-color: #00a65a !important;
        }
        .label-F{
            background-color: #b12edc !important;
        }
        .label-A{
            background-color: #dc2e4e !important;
        }	
		.text-G{
            color: #00a65a !important;
        }
        .text-F{
            color: #b12edc !important;
        }
        .text-A{
            color: #dc2e4e !important;
        }		
        .modal-title{
            text-align: center;
        }
        div .collapsed-box{
            height: auto !important;
        }
        #sucursales .select2-results__option[aria-selected=true] {
            display: none;
        }
		.labels_primary {
			background-color: white;
			font-size: 11px;
			font-weight: bold;
			text-align: center;
			border: 1px solid #efede2;
			white-space: nowrap;
		}
        .ui-draggable{
            cursor: pointer; cursor: hand;
        }
        .direct-chat-contacts{
            z-index: 2;
            height: 100%;
        }
        #content-cliente{
            position: relative;
        }
        .box-body{
            padding: 10px !important;
            padding-bottom: 0px !important;
            max-height: 100%;
            text-transform: capitalize;
        }
        .nav-tabs-custom{
            box-shadow: 0 0px 0px rgba(0,0,0,0.1);
        }
        li .contacts-list-img i.fa{
            display: none;
            color:white;
        }
        li.active .contacts-list-img i.fa{
            display: block;
        }
        input.form-control.half-content {
            width: 50%;
            padding-right: 2px;
            padding-left: 2px;
            text-align: center;
        }
        .row.datos{
            margin-bottom: 10px;
            text-transform: capitalize;
        }
      
        .contacts-list-img{
            padding-top: 6px;
            text-align: center
        }
        .contacts-list{
            padding-right: 8px;
        }
        #content-cliente .box{
            display: none;
        }
        .box.direct-chat.show.ui-draggable .box-title {
            padding-right: 96px;
        }
       
        .text-white{
            color: white !important;
        }
        .tab-content a.pull-right i.fa.fa-fw.pull-right {
            margin-top: 2px;
        }

        #floating-button{
            width: 50px;
            z-index: 9999999999;
            height: 50px;
            border-radius: 50%;
            background: #00a65a;
            position: fixed;
            bottom: 30px;
            right: 30px;
            display: none;
            cursor: pointer;
            box-shadow: 0px 2px 5px #666;
        }
        .plus{
            color: white;
            position: absolute;
            top: 0;
            display: block;
            bottom: 0;
            left: 0;
            right: 0;
            text-align: center;
            padding: 0;
            margin: 0;
            line-height: 50px;
            font-size: 16px;
            font-weight: 300;
            animation: plus-out 0.3s;
            transition: all 0.3s;
        }
        @media (max-width: 768px){
            .control-sidebar {
                padding-top: 50px;
            }
			.navbar-brand{
				font-size: 13px;
			}
			.description-text {
				font-size: 10.5px !important;
			}
			#floating-button{
				display: block;
			}
        }
        /*Desktops and Laptops */
        @media only screen and (min-width: 1224px) {
            footer {
                display: block !important;
            }
            #floating-button{
                display: none !important;
            }
            #content-cliente{
                position: absolute;
                z-index: 9999;
                max-width: 47%;
                /*height: 70%;*/
            }
            #legend{
                /*display: block; mostrar en tab borrar esto*/
            }
            #content-cliente .box.collapsed-box {
                padding-bottom: 0px;
            }
            #content-cliente .box{
                display: none;
                margin-left: 15px;
                margin-top: 15px;
                width: auto !important;
                height: auto !important;
                overflow: auto;
                padding-bottom: 10px;
                /* padding-bottom: 50px;*/
            }
            .box-body::-webkit-scrollbar {
                display: none;
            }
        }
		.progress.progress-xxs{
			height: 18px;
			background: #3a4b53;
		}
		.progress-label{
			font-weight: 400;
		}
        .content.map{
            padding: 0px !important;
        }
        /** Desktops and Laptops height min **/
        @media only screen and (min-width: 1224px) and (min-height: 620px) {
            #content-cliente .box {
                max-height: 560px;
            }
        }
        /** Desktops and Laptops height high **/
        @media only screen and (min-width: 1224px) and (min-height:760px){
            #content-cliente .box {
                max-height: 760px;
            }
        }
        .table>tbody>tr.bonificacion>td {
            background-color: rgba(81, 255, 60, 0.47);
        }       
        .tab-pane table {
            margin-bottom: 0px;
        }
		.dashboard{
			background: white;
		}
		.border-right{
			border-right: 1px solid #f4f4f4;
		}
		.dashboard .description-text {
			font-size: 12px;
		}
		.row-dashboard{
			display: block;
			padding: 0px 15px;
			padding-bottom: 1px;
		}
		.modal{
			z-index: 19050;		
		}
    </style>
</head>
<body class="skin-green layout-top-nav" style="height: auto; min-height: 100%;"> 
    <div class="wrapper">
       <header class="main-header">
    <nav class="navbar navbar-static-top">
      <div class="container">
        <div class="navbar-header">
          <span class="navbar-brand"><b>MONITOREO: </b>{{ $nombreVendedor }}</span>         
        </div>      
        <!-- Navbar Right Menu -->         
        <!-- /.navbar-custom-menu -->
      </div>
      <!-- /.container-fluid -->
    </nav>
  </header>
<div class="content-wrapper">
	<section class="content map">
		<div id="dashboard" class="row dashboard">
			<div class="col-sm-2 col-xs-3 border-right">
				<div class="description-block">
					<span class="description-percentage text-G" id="numero-paquete-label"><i class="fa fa-caret-up"><i></i></i></span>
					<h5 class="description-header" id="numero-paquete">0</h5>
					<span class="description-text">Numero de Paquetes</span>
				</div>
			</div>
			<div class="col-sm-1 col-xs-3 border-right">
				<div class="description-block">
					<span class="description-percentage text-G" id="importe-total-label"><i class="fa fa-caret-up"><i></i></i></span>
					<h5 class="description-header" id="importe-total">0</h5>
					<span class="description-text">Importe Total</span>
				</div>
			</div>
			<div class="col-sm-2 col-xs-3 border-right">
				<div class="description-block">
					<span class="description-percentage text-G" id="pedido-generado-label">0%</span>
					<h5 class="description-header" id="pedido-generado">0</h5>
					<span class="description-text">Pedidos generados</span>
				</div>
			</div>
			<div class="col-sm-2 col-xs-3 border-right">
				<div class="description-block">
					<span class="description-percentage text-F" id="facturados-label">0%</span>
					<h5 class="description-header" id="facturados">0</h5>
					<span class="description-text">Pedidos facturados</span>
				</div>
			</div>
			<div class="col-sm-1 col-xs-4 border-right">
				<div class="description-block">
					<span class="description-percentage text-A" id="no-venta-label">0%</span>
					<h5 class="description-header" id="no-venta">0</h5>
					<span class="description-text">Motivo no compra</span>
				</div>
			</div>
			<div class="col-sm-2 col-xs-4 border-right">
				<div class="description-block">
					<span class="description-percentage text-blue" id="visitados-label">0%</span>
					<h5 class="description-header" id="visitados">0</h5>
					<span class="description-text">Clientes visitados</span>
				</div>
			</div>
			<div class="col-sm-2 col-xs-4 border-right">
				<div class="description-block">
					<span class="description-percentage text-default" id="no-visitados-label">0%</span>
					<h5 class="description-header" id="no-visitados">0</h5>
					<span class="description-text">Clientes no visitados</span>
				</div>
			</div>
		</div>			
			
        <!-- Content Wrapper. Contains page content -->
        <div id="content-map">
            <div id="overlay" class="overlay hidden"><i class="fa fa-refresh fa-spin"></i></div>
            <div id="content-cliente"></div>			
			
			<div class="content-wrapper" id= "mapa"></div>						
        </div>

        <div id="floating-button" class="ir-arriba">
            <p id="button-down" class="plus"><i class="fa fa-fw fa-chevron-down"></i></p>
            <p id="button-up" class="plus hidden"><i class="fa fa-fw fa-chevron-up"></i></p>
        </div>
        <div class="modal fade" id="modal-logout" >
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span></button>
                        <h4 class="modal-title">¿Esta seguro que desea cerrar su sesión?</h4>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                        <button id="logout-mobile" type="button" class="btn btn-primary">Salir</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    </section>
	<div class="modal fade" id="modal-encuesta">
	  <div class="modal-dialog modal-dialog-centered modal-lg">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">×</span></button>
			<h4 class="modal-title">Detalle de Encuesta</h4>
		  </div>
		  <div class="modal-body">
			<div class="container-fluid">
				<div class="row" id="contenidoModal"> 
				</div>
			  </div>
		  </div> 
		</div>
		<!-- /.modal-content -->
	  </div>
	  <!-- /.modal-dialog -->
	</div>
	
	<div class="modal fade" id="modal-encuesta-pedido">
	  <div class="modal-dialog modal-dialog-centered modal-lg">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">×</span></button>
			<h4 class="modal-title">Detalle de Encuesta Pedido</h4>
		  </div>
		  <div class="modal-body">
			<div class="container-fluid">
				<div class="row" id="contenidoModalFotosPedido"> 
				</div>
			  </div>
		  </div> 
		</div>
		<!-- /.modal-content -->
	  </div>
	  <!-- /.modal-dialog -->
	</div>
	
</div>



        <footer class="main-footer">
            <div class="pull-right hidden-xs">
                <b>Version</b> 1.2
            </div>
            <strong>Copyright &copy; <?php echo date('Y'); ?> <a href="#"> Power by</a>.</strong> Expedio Digital
        </footer>

      
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
    
	 <script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAQaS-JzwKRanBFgbQVquqQuuauSHO2zkg"></script>     
	<script src="{{ url('/') }}/js/markerwithlabel.js"></script>
	<script src="{{ url('/') }}/js/infobox.js"></script>
    <!-- iCheck 1.0.1 -->
    <script src="{{ url('/') }}/plugins/iCheck/icheck.min.js"></script>
	<!-- Select2 -->
    <!--script src="bower_components/select2/js/select2.min.js"></script>
    <script src="bower_components/select2/js/i18n/es.js"></script-->
    <script>
        var map, markerClusterClientes, markerClusterPedidos, bounds, iconos;
        var listaClientes = [];
        var datosClientes = []; 
        var listaMarkersPedidos = []; 
		var listaMarkersClientes = []; 
        var iconMapBase = "{{ url('/') }}/images/map/";
        var timerPedidos = null;  
        var esquema;
        var totalPedidos = [];
		var zonaFiltro, rutaFiltro, fechaPreventaFiltro, vendedorFiltro, nombreVendedor;
		var actualPolyLine;
		var myOptions = {
			boxStyle: { 
			   textAlign: "center"
			  ,fontSize: "14pt"
			  ,width: "120px"
			 }
			,pixelOffset: new google.maps.Size(-25, 0)
			,closeBoxURL: ""
			,isHidden: false
		};
		
		var contentInfoBox = document.createElement("div"); 
		var poligonoInfoBox = new InfoBox(myOptions);
		
		$(document).ready(function(){
			var centro = {lat: -11.971990, lng:  -77.062177}; //Sucursal
			contentInfoBox.style.cssText = "color:#3F51B5;font-weight:bold";
			
			zonaFiltro = "{{ isset($zona)? $zona : 'all' }}";
			rutaFiltro = "{{ isset($ruta)? $ruta : 'all' }}";
			fechaPreventaFiltro = "{{ $fecha }}";
			vendedorFiltro = "{{ isset($vendedor) ? $vendedor : 'x' }}";
			nombreVendedor = "{{$nombreVendedor}}";
            $('#zonas').val("{{ $nombreZona }}"); 
            $('#rutas').val("{{ $nombreRuta }}"); 
            $('#vendedores').val(nombreVendedor);
            esquema = {
                P: '<div id="modal-_cliente_" class="box direct-chat">'+
                '<div id="box-header-_cliente_" class="box-header">'+
                '<h3 class="box-title">[nombre]</h3>'+
                '<div class="box-tools pull-right">'+
                '<span id="cantidad-_cliente_" data-toggle="tooltip" class="badge bg-yellow">[cantidad]</span>'+
                '<button id="collapse-_cliente_" onclick="fc_collapseModal(_cliente_)" type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>'+
                '<button type="button" class="btn btn-box-tool" data-toggle="tooltip" data-widget="chat-pane-toggle" data-original-title="Contacts"><i class="fa fa-fw fa-cubes"></i></button>'+
                '<button onclick="fc_closeModal(_cliente_)" type="button" class="btn btn-box-tool" data-widget="close"><i class="fa fa-times"></i></button>'+
                '</div>'+
                '</div>'+
                '<div class="box-body">'+
                '<div class="row datos">'+
                '<div class="col-md-6"><b>Ruc: </b><span>[ruc]</span></div>'+
                '<div class="col-md-6"><b>Modulo: </b><span>[modulo]</span></div>'+
                '<div class="col-md-6"><b>Correo: </b><span>[correo]</span></div>'+
                '<div class="col-md-6"><b>Dirección: </b><span>[direccion]</span></div>'+
                '</div>'+
                '<div class="nav-tabs-custom">'+
                '<div class="direct-chat-contacts">'+
                '<ul id="nav-_cliente_" class="contacts-list">'+
                '</ul>'+
                '</div>'+
                '<div class="tab-content no-padding" id="content-tabs-_cliente_">'+
                '</div>'+
                '</div>'+
                '</div>'+
                '</div>',
                S: '<div id="modal-_cliente_" class="box direct-chat">'+
                '<div id="box-header-_cliente_" class="box-header">'+
                '<h3 class="box-title">[nombre]</h3>'+
                '<div class="box-tools pull-right">'+
                '<button id="collapse-_cliente_" onclick="fc_collapseModal(_cliente_)" type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>'+
                '<button onclick="fc_closeModal(_cliente_)" type="button" class="btn btn-box-tool" data-widget="close"><i class="fa fa-times"></i></button>'+
                '</div>'+
                '</div>'+
                '<div class="box-body">'+
                '<div class="row datos">'+
                '<div class="col-md-6"><b>Ruc: </b><span>[ruc]</span></div>'+
                '<div class="col-md-6"><b>Modulo: </b><span>[modulo]</span></div>'+
                '<div class="col-md-6"><b>Correo: </b><span>[correo]</span></div>'+
                '<div class="col-md-6"><b>Dirección: </b><span>[direccion]</span></div>'+
                '</div>'+
                '</div>'+
                '</div>',
                T: '<div class="[class]" id="tab-_pedido_-_indice_">'+
                '<div class="row datos">'+
                '<div class="col-md-6"><b>Pedido: </b><span>_pedido_</span>  <span name="estado" class="label [class-estado]">[estado]</span> </div>'+
                '<div class="col-md-6"><b>Recibo: </b><span name="factura">[factura]</span></div>'+
                '<div class="col-md-6"><b>Total: </b><span name="total">[total]</span></div>'+
                '<div class="col-md-6"><b>Fecha: </b><span name="fecha">[fecha]</span></div>'+
                '<div class="col-md-6"><b>Vendedor: </b><span name="vendedor">[vendedor]</span></div>'+
				'<div class="col-md-6"><b>Segmento: </b><span name="segmento">[segmento]</span></div>'+
				'<div class="col-md-6"><b>NroExhibidores : </b><span name="nroExhibidores">[nroExhibidores]</span></div>'+
				'<div class="col-md-6"><b>NroPuertasFrio : </b><span name="nroPuertasFrio">[nroPuertasFrio]</span></div>'+
                '<div id="extra-_pedido_-_indice_" class="col-md-12">[motivo-no-venta]</div>'+
				'<div id="[encuesta]" class="col-md-6" ></div>'+
				'<div id="[encuesta-pedido]"  class="col-md-6" ></div>'+ 
                '</div>'+
                '<div class="table-responsive">'+
                '<div id="overlay-_pedido_-_indice_" class="overlay"><i class="fa fa-refresh fa-spin"></i></div>'+
                '<table class="table table-striped">'+
                '<thead>' +
                '<tr> <th>Producto</th> <th>Cant<span class="hidden-xs">idad</span></th> <th>Und</th> <th>Importe</th></tr>'+
                '</thead>'+
                '<tbody id="table-_pedido_-_indice_">'+
                '</tbody>'+
                '</table>'+
                '</div>'+
                '</div>',
                N: '<li class="[class]">'+
                '<a href="#tab-_pedido_-[indice]" data-toggle="tab" data-order="[order]"  data-cliente="[cliente]"  data-widget="chat-pane-toggle" aria-expanded="false">'+
                '<div class="contacts-list-img"><i class="fa fa-star-o"></i></div>'+
                '<div class="contacts-list-info">'+
                '<span class="contacts-list-name">_pedido_ (<small name="estado">[estado]</small>) <small name="fecha" class="contacts-list-date pull-right">[fecha]</small> </span>'+
                '<span class="contacts-list-msg">[vendedor] <small name="total" class="contacts-list-date pull-right">S/ [total]</small> </span>'+
                '</div>'+
                '</a>'+
                '</li>'
            }

            iconos = {
                'G': iconMapBase + 'icon_geomarker_greenldpi.png',
                'D': iconMapBase + 'icon_geomarker_greyldpi.png',
                'A': iconMapBase + 'icon_geomarker_redldpi.png',
                'F': iconMapBase + 'icon_geomarker_purpleldpi.png',
                '0': iconMapBase + 'icon_geomarker_redldpi.png',
				'I' : iconMapBase + 'icon_geomarker_pinldpi.png', /* Icono pedido inicial. */
            };
		
			$('input[type="checkbox"].minimal').iCheck({ checkboxClass: 'icheckbox_square-green' });
			
			$('.ir-arriba').click(function(){
                if( $("#button-up").hasClass("hidden") ){
                    $('html,body').animate({scrollTop: $("#mapa").offset().top}, 1000);
                }else{
                    var modalID = $("#floating-button").data("offset");
					if(!modalID){
						modalID = $("#dashboard");
					}
                    var modalOffset = $(modalID).offset().top;
                    $('html,body').animate({ scrollTop: modalOffset }, 1000);
                }
            });

            $(window).scroll(function(){
                var modalID = $("#floating-button").data("offset");
                if( modalID !== 'undefined' && $(this).scrollTop() > 0 ){
                    if( $(this).scrollTop() > ($("#mapa").offset().top - 100) ){
                        if($("#button-up").hasClass("hidden") ){
                            $("#button-up").removeClass("hidden");
                            $("#button-down").addClass("hidden");
                        }
                    }else{
                        if($("#button-down").hasClass("hidden") ){
                            $("#button-down").removeClass("hidden");
                            $("#button-up").addClass("hidden");
                        }
                    }
                }
            });

			map = new google.maps.Map(document.getElementById('mapa'), {
                zoom: 10,
                center: centro,
                gestureHandling: 'greedy',
                fullscreenControl: false,
                mapTypeControl: false,
                zoomControlOptions: {
                    position: google.maps.ControlPosition.LEFT_BOTTOM
                },
                streetViewControlOptions: {
                    position: google.maps.ControlPosition.LEFT_BOTTOM
                }
            });
			
			google.maps.Polygon.prototype.my_getBounds=function(){
				var bounds = new google.maps.LatLngBounds();
				this.getPath().forEach(function(element,index){bounds.extend(element)});
				return bounds
			};
			
			// Define a symbol using a predefined path (an arrow)
			// supplied by the Google Maps JavaScript API.
			var lineSymbol = {
			  path: google.maps.SymbolPath.FORWARD_CLOSED_ARROW
			};
		
			actualPolyLine = new google.maps.Polyline({
			    strokeColor: '#000000',
				icons: [{icon: {path:google.maps.SymbolPath.FORWARD_OPEN_ARROW,strokeWeight:2.5,scale:2}, offset: '100%',repeat:'35px'}],				 
				strokeColor: '#2edc9d',
			    strokeOpacity: 1.0 
			});
			actualPolyLine.setMap(map);
					
			// Path by google https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m            
			markerClusterClientes = new MarkerClusterer(map, null, {imagePath: iconMapBase});
			markerClusterPedidos  = new MarkerClusterer(map, null, {imagePath: iconMapBase});
			
            // Obtener Pedidos Inicio
            fc_limpiarPedidos();
            sc_obtenerPosicionCliente();
			sc_obtenerGeocercas();
            fc_validarTimer($("#fecha").val());
		 	
			setTimeout( resizeMap, 1500); 
			
			function resizeMap(){
				google.maps.event.trigger(map,'resize');
				if(bounds){
					map.fitBounds(bounds);
				}
			}
						
			$("#btnLimpiar").click(function(){
				fc_limpiarPedidos(); 
				sc_actualizarPedidos(true);
				fc_validarTimer($("#fecha").val());
			});
			
						
			/*
			* Funciones
			*/			
			function sc_obtenerZonas() {
				$("#overlay").removeClass("hidden");
				$.ajax({
					global: false,
					type: "POST",
					dataType: 'json',
					url: "{{ url('/') }}/get/zonas",
					success: function(jsondata){
						var select = $('#zonas');
						$.each(jsondata, function(index, element) {
							select.append("<option value='"+ element['idZona'] +"'>" + element['descripcion'].toLowerCase() + "</option>");							
						}); 
						select.append("<option value='all'>Todos</option>");
						select.val(zonaFiltro).trigger('change'); 
						$("#overlay").addClass("hidden");
					}
				});
			}
			
			function sc_obtenerRutas() {
				$("#overlay").removeClass("hidden"); 
				$.ajax({
					global: false,
					type: "POST",
					dataType: 'json',
					data: { "zona": zonaFiltro },
					url: "{{ url('/') }}/get/rutas"
				})
				.done(function(jsondata) {
					var select = $('#rutas');
					select.empty();
					if( rutaFiltro == 'x' ){ select.append("<option value='x'>Ninguna</option>"); } 
					$.each(jsondata, function(index, element){ select.append("<option value='"+ element['idRuta'] +"'>" + element['idRuta'] + "</option>"); });
					select.append("<option value='all'>Todas</option>");
					select.val(rutaFiltro).trigger('change');
					select.prop( "disabled", false );
					$("#overlay").addClass("hidden"); 
				})
				.fail(function() {
					alert( "Error" );
				});
			}
		
			function sc_obtenerVendedores(){
				$("#overlay").removeClass("hidden"); 
				$.ajax({
					global: false,
					type: "POST",
					dataType: 'json',
					data: { "zona": zonaFiltro, "ruta": rutaFiltro },
					url: "{{ url('/') }}/get/vendedores"
				})
				.done(function(jsondata) {
					var select = $('#vendedores'); 
					select.empty();
					$.each(jsondata, function(index, element){ select.append("<option value='"+ element['idPersona'] +"'>" + element['nombre'] + "</option>"); });
					select.append("<option value='all'>Todos</option>");
					select.val(vendedorFiltro).trigger('change');
					select.prop( "disabled", false );
					$("#overlay").addClass("hidden");				
				})
				.fail(function() {
					alert( "Error" );
				});
			}

			function fc_validarTimer(fecha){
				if (timerPedidos){ clearInterval(timerPedidos); }
				if( fecha == $("#fechaPorDefecto").val()){
					timerPedidos = setTimeout(function() { sc_actualizarPedidos(false); }, 100);
				}
			}
			
			function getRandomColor() {
			  var letters = '0123456789ABCDEF';
			  var color = '#';
			  for (var i = 0; i < 6; i++) {
				color += letters[Math.floor(Math.random() * 16)];
			  }
			  return color;
			}
		
			function sc_obtenerGeocercas(){
				$.ajax({
					type: 'POST',
					url: "{{ url('/') }}/get/geocercas",					
					data: { empresa : "{{ $empresa }}", sucursal : "{{ $sucursal }}", zona: zonaFiltro, ruta : rutaFiltro } 
				})
				.done(function(jsondata) {
					var coordenadas = [];
					var codigo = null;
					for(var i=0; i<jsondata.length; i++){ 
						var datos = jsondata[i];
						
						if(codigo == null){
							codigo = datos.id;
						}
						
						if(codigo == datos.id){
							
							coordenadas.push( new google.maps.LatLng( datos['latitud'], datos['longitud'] ));	
						}else{
							var color = getRandomColor();
							 var poligono = new google.maps.Polygon({
								paths: coordenadas,
								strokeColor: color,
								strokeOpacity: 0.8,
								strokeWeight: 2,
								fillColor: '#6b6a6a',
								fillOpacity: 0.35
							});
							
							poligono.setMap(map);
							
							(function(p_poligono, p_contenido){
								p_poligono.addListener('rightclick', function () {
									p_poligono.setOptions({fillOpacity: 0.1});
									contentInfoBox.innerHTML = p_contenido;
									poligonoInfoBox.setContent(contentInfoBox);
									poligonoInfoBox.setPosition(p_poligono.my_getBounds().getCenter());
									poligonoInfoBox.setMap(map);
								});
							})(poligono,codigo);

							(function(p_poligono){
								p_poligono.addListener('mouseout', function () {
									poligonoInfoBox.setMap(null);
								});
							})(poligono);	

							coordenadas = [];
							codigo = datos.id;							
						}						
					} 
					
				})
				.fail(function() {
					alert( "Error" );
				})
			}
			
			function sc_obtenerPosicionCliente() {
				$("#overlay").removeClass("hidden");
				$.ajax({
					type: 'POST',
					url: "{{ url('/') }}/get/clientes",					
					data: { empresa : "{{ $empresa }}", sucursal : "{{ $sucursal }}", supervisor : "{{ $super }}", zona: zonaFiltro, ruta : rutaFiltro, fecha : fechaPreventaFiltro, vendedor : vendedorFiltro } 
				})
				.done(function(jsondata) {

					for(var i=0; i<jsondata.length; i++){  md_agregarDatosCliete(jsondata[i]); } 
					bounds = new google.maps.LatLngBounds();
					/*SE VAN A CENTRAR EN BASE A PEDIDOS MAS NO A CLIENTES
                    for (var i = 0; i < listaClientes.length; i++){ 						
						var ubicacionCliente = new google.maps.LatLng( datosClientes[listaClientes[i]].latitud, datosClientes[listaClientes[i]].longitud);				
						bounds.extend(ubicacionCliente); 
					}  
					*/
					sc_actualizarPedidos(true);
				})
				.fail(function() {
					alert( "Error" );
				})
			}
			
			function md_agregarDatosCliete(jsondata){
				console.log("agregar cliente"+jsondata);
				var cliente = new Array();
				var estado = jsondata.estado;
				var codigoCliente = jsondata.codigo;
				
				if(listaClientes.indexOf(codigoCliente) < 0){
					cliente['markerCliente'] = null;
					cliente['rucDni'] = jsondata.documento;
					cliente['correo'] = jsondata.email;
					cliente['modulo'] = jsondata.modulo;
					cliente['latitud'] = jsondata.latitudCliente;
					cliente['longitud'] = jsondata.longitudCliente;
					cliente['markerCliente'] = -1;
                    cliente['existePedido'] = false;
					cliente['direccion'] = jsondata.direccion.toLowerCase();
					cliente['razonSocial'] = jsondata.nombre;
					cliente['segmento'] = jsondata.segmento;
					cliente['nroExhibidores'] = jsondata.nroExhibidores;
					cliente['nroPuertasFrio'] = jsondata.nroPuertasFrio;
					
					cliente['listaPedidos'] = new Array();

					datosClientes[codigoCliente] = cliente;
					listaClientes.push(codigoCliente);
				} 
			}
			
			function sc_actualizarPedidos(mostrarOverlay){			    
				$.ajax({
					type: 'POST',
					url: "{{ url('/') }}/get/pedidos",
					data: { empresa : "{{ $empresa }}", sucursal : "{{ $sucursal }}", supervisor : "{{ $super }}", zona: zonaFiltro, ruta : rutaFiltro, fecha : fechaPreventaFiltro, vendedor : vendedorFiltro, guia: "{!! $guia !!}" }
				}).done(function(jsondata) {
					$.each(jsondata, function(index, pedido) {
						var numCliente = pedido.cliente;
						var nuevoEstado = pedido.estado;
						var primerPedido = listaMarkersPedidos.length;
						var ultimoPedido = jsondata.length;
						
						if(datosClientes[numCliente]){ 
							if(datosClientes[numCliente].existePedido){
								 if((indexPedido = fc_obtenerIndicePedido(numCliente, pedido.pedido)) >= 0){
									 //actualizar pedido
                                     var oldEstado =  datosClientes[numCliente].listaPedidos[indexPedido].estado;
                                     var importeTotal =  datosClientes[numCliente].listaPedidos[indexPedido].importeTotal;
                                     var fecha =  datosClientes[numCliente].listaPedidos[indexPedido].fecha;
											
                                     if(!(nuevoEstado == oldEstado && pedido.importeTotal == importeTotal && pedido.fechaPedido == fecha)){
																				 
										md_actualizarModalPedido(indexPedido, pedido);
										datosClientes[numCliente].listaPedidos[indexPedido].estado = nuevoEstado;
										datosClientes[numCliente].listaPedidos[indexPedido].importeTotal = pedido.importeTotal;
										datosClientes[numCliente].listaPedidos[indexPedido].fecha = pedido.fechaPedido;
										
                                         //actualizar latitud y longitud
										if( nuevoEstado != oldEstado ){
											
											var indiceMarkerPedido = datosClientes[numCliente].listaPedidos[indexPedido].markerPedido;
											var nuevaUbicacion = new google.maps.LatLng( pedido.latitud, pedido.longitud);
											listaMarkersPedidos[indiceMarkerPedido].setPosition(nuevaUbicacion);	
											
											/* Si no es el primer pedido */
											if(listaMarkersPedidos[indiceMarkerPedido]['orden'] > 0){
												listaMarkersPedidos[indiceMarkerPedido].setIcon(iconos[nuevoEstado]);
											}											
											
											totalPedidos[oldEstado] = totalPedidos[oldEstado] -1;
											totalPedidos[nuevoEstado] = totalPedidos[nuevoEstado] +1;
											
										}
                                     }
								 }else{
								      //ocultar marcador cliente
                                     var indiceMarkerCliente = datosClientes[numCliente].markerCliente;
                                     if(indiceMarkerCliente >= 0){
                                         listaMarkersClientes[indiceMarkerCliente].setMap(null);
										 listaMarkersClientes[indiceMarkerCliente] = null; //quitar referencia
                                     }
									 //nuevo pedido
									var indice = md_agregarMarkerPedido(pedido, ultimoPedido); 
									md_agregarTabPedidoModal(numCliente, indice);
								 }
                                 var nuevoTotalPedido = datosClientes[numCliente].listaPedidos.length;
                                 $('#cantidad-'+numCliente).html(nuevoTotalPedido);
							}else{																
                                var isShow = $("#modal-"+numCliente).hasClass("show");
                                $("#modal-"+numCliente).remove();								
                                var indicePedido = md_agregarMarkerPedido(pedido, ultimoPedido);								
                                datosClientes[numCliente].existePedido = true;								
								if(datosClientes[numCliente].markerCliente >= 0){
									console.log("quitar marker cliente");
									listaMarkersClientes[datosClientes[numCliente].markerCliente].setMap(null);
								}								
                                //Actualizamos al cliente que ya tiene un pedido
                                if(isShow){ md_mostrarModalCliente( numCliente, indicePedido ,pedido.pedido);  }
							} 
						}else{
							console.log("ALERTA: No existe el cliente "+numCliente+" en el mapa actual, refresque el mapa para obtener este nuevo cliente");
						}
						
						if(primerPedido <= 0){
							resizeMap(); /* centrar mapa - pedidos**/
						}else{
							google.maps.event.trigger(map,'resize'); 
						} 
					});
					
					
					
					if(mostrarOverlay){ mostrarClientesSinPedido(); }
				
                    md_actualizarDashboard();
				}).fail(function() {
					alert( "Error" );
				}).always(function() {
					if(mostrarOverlay){
						$("#overlay").addClass("hidden");
					}
				});
			}
			
			function md_agregarMarkerPedido(datosPedido, ultimoPedido){
				var nuevoPedido = new Array();
				var numeroPedido = datosPedido.pedido;
				var codigoCliente= datosPedido.cliente;
				var ubicacionPedido = new google.maps.LatLng(datosPedido.latitud, datosPedido.longitud);
				var label  = ""+(listaMarkersPedidos.length + 1);
				var icono = datosPedido.estado;
				/* Centrar por pedido **/
				bounds.extend(ubicacionPedido);
				/*
					var marker = new MarkerWithLabel({
						position: location,
						map: var_map,
						labelContent: hora,
						labelAnchor: new google.maps.Point(22, 0),
						labelClass: "labels_primary", // the CSS class for the label
						labelStyle: {opacity: 0.75},
						icon: 'site_media/img/gps_inicio.png'
					});
				*/
				/*	Verificar si es el ultimo pedido	*/
				if(listaMarkersPedidos.length <= 0){
					icono = "I";
				}
			 
				if(listaMarkersPedidos.length == (ultimoPedido - 1)){
					icono = "I";
				}
			 
				//Encuesta Pre Post Pedido
				if( has_encuestaPedido(numeroPedido, codigoCliente, false) ){
					label = label +"*";
				}
				
				var markerPedido = new  MarkerWithLabel({
					position: ubicacionPedido,
					map: map,
					/*label: {text: label , fontSize:"13px" },*/
					labelContent: label,
					labelAnchor: new google.maps.Point(10, 0),
					labelClass: "labels_primary", 
					icon: iconos[icono], 
					/*draggable: false,*/
					title: datosClientes[codigoCliente].razonSocial
				});
				

				//Add polyline
				var path = actualPolyLine.getPath();
				path.push(ubicacionPedido);
				  
				if($("#checkAgruparPedidos").is(":checked")){
					markerClusterPedidos.addMarker(markerPedido);
				}
				//verificar funcionalidad al modificar algun item (pedido anulado?)
                totalPedidos['total'] = (totalPedidos['total'] ? totalPedidos['total'] : 0 ) + 1;
                totalPedidos[datosPedido.estado] = (totalPedidos[datosPedido.estado] ? totalPedidos[datosPedido.estado] : 0 ) + 1;

				nuevoPedido['numeroPedido'] = numeroPedido;
				nuevoPedido['orden'] = listaMarkersPedidos.length;
				nuevoPedido['importeTotal'] = datosPedido.importeTotal;
				nuevoPedido['estado'] = datosPedido.estado;
				nuevoPedido['ajaxPedido'] = false;
				nuevoPedido['motivo'] = datosPedido.motivo;
				nuevoPedido['factura'] = datosPedido.factura;
				nuevoPedido['fecha'] =  datosPedido.fechaPedido;
				nuevoPedido['vendedor'] =  nombreVendedor.toLowerCase();

				listaMarkersPedidos.push(markerPedido);
				nuevoPedido['markerPedido'] = (listaMarkersPedidos.length-1);

				datosClientes[codigoCliente].listaPedidos.push(nuevoPedido);

				if(!datosClientes[codigoCliente].existePedido){
					datosClientes[codigoCliente].existePedido = true;
				}
				var indicePedido = datosClientes[codigoCliente].listaPedidos.length - 1;
				
				(function(codigoClientex,indicePedidox,numeroPedidox){
					markerPedido.addListener('click', function() {
						md_mostrarModalCliente(codigoClientex,indicePedidox,numeroPedidox);
					});
				}(codigoCliente, indicePedido ,numeroPedido));
				
				return ( indicePedido);
				
			}
		
			function mostrarClientesSinPedido(){
				
				for (var i = 0; i < listaClientes.length; i++) {
					var codigo= listaClientes[i];
						
					if( datosClientes[ codigo ].existePedido == false && datosClientes[ codigo ].markerCliente < 0){
						
						var ubicacionCliente = new google.maps.LatLng(datosClientes[ codigo ].latitud, datosClientes[ codigo ].longitud);
												
						var markerCliente = new google.maps.Marker({
							position: ubicacionCliente,
							map: map,
							icon: iconos['D'], 
							title: datosClientes[ codigo ].razonSocial
						});
						
						(function(codigox){
							markerCliente.addListener('click', function() {	
							md_mostrarModalCliente( codigox  , -1, null);
							});
						}(codigo));
							
						if($("#checkAgruparClientes").is(":checked")){
							markerClusterClientes.addMarker(markerCliente);
						}
						listaMarkersClientes.push(markerCliente);
						
						datosClientes['markerCliente'] = (listaMarkersClientes.length -1);
					} 
				}
			}
			
			function md_mostrarModalCliente(cliente, indiceTab, numeroPedido){
                $( "#content-cliente .box.direct-chat.ui-draggable.show").each(function( index ){
                    $(this).removeClass("show");
                });
				
				if ($('#modal-'+cliente).length <= 0) {
					if(datosClientes[cliente].existePedido){					 
						 
						var listaPedido = datosClientes[cliente].listaPedidos;
						var htmlModal = esquema["P"];
						htmlModal = htmlModal.replace(/_cliente_/g , cliente );
						htmlModal = htmlModal.replace('[nombre]', datosClientes[cliente].razonSocial );
						htmlModal = htmlModal.replace('[cantidad]', listaPedido.length );
						htmlModal = htmlModal.replace('[ruc]', datosClientes[cliente].rucDni );
						htmlModal = htmlModal.replace('[modulo]', datosClientes[cliente].modulo );
						htmlModal = htmlModal.replace('[correo]', datosClientes[cliente].correo );
						htmlModal = htmlModal.replace('[direccion]', datosClientes[cliente].direccion );
						$('#content-cliente').append(htmlModal);
						for(var i=0; i<listaPedido.length; i++){
							md_agregarTabPedidoModal(cliente, i);
						}
						$('#floating-button').slideDown(300);
						$("#floating-button").data("offset", "#modal-" +cliente);
					}else{
						console.log("cliente(N)"+cliente); 
						var htmlModal = esquema["S"];
						htmlModal = htmlModal.replace(/_cliente_/g , cliente );
						htmlModal = htmlModal.replace('[nombre]', datosClientes[cliente].razonSocial );
						htmlModal = htmlModal.replace('[ruc]', datosClientes[cliente].rucDni );
						htmlModal = htmlModal.replace('[modulo]', datosClientes[cliente].modulo );
						htmlModal = htmlModal.replace('[correo]', datosClientes[cliente].correo );
						htmlModal = htmlModal.replace('[direccion]', datosClientes[cliente].direccion );
						$('#content-cliente').append(htmlModal);
					}

					$('#modal-'+cliente).draggable(  { handle: '#box-header-'+cliente } );
				}else {
					$('#floating-button').slideDown(300);
					$("#floating-button").data("offset", "#modal-" +cliente);
				}
               
                if(indiceTab >= 0){ $('#nav-'+cliente+' li a[href="#tab-'+numeroPedido+"-"+indiceTab+'"]').tab('show'); }
                $('#modal-'+cliente).addClass("show");
				//Encuesta trade
				has_encuesta(numeroPedido, cliente);  
				has_encuestaPedido(numeroPedido, cliente, true); 
				
			}
			
			function has_encuesta(p_numeroPedido, p_clientePedido){
				$("#contenidoModal").html("")
				$("#e-"+p_numeroPedido).removeClass("col-md-4");
				$("#e-"+p_numeroPedido).html('');
				
				$.ajax({
					type: "POST",
					data: { empresa : "{{ $empresa }}", sucursal : "{{ $sucursal }}", pedido : p_numeroPedido, cliente : p_clientePedido },
					dataType: 'json',
					url: "{{ url('/') }}/get/encuestaTrade"
				})
				.done(function(jsonDetalleEncuesta) {
					if(jsonDetalleEncuesta.length > 0){
						$("#e-"+p_numeroPedido).addClass("col-md-4");
						
						$.each(jsonDetalleEncuesta, function(index, item) {  
							$("#contenidoModal").append(' <div class="col-md-4"><p>'+item['pregunta']+'</p><img class="img-responsive pad" src="http://35.184.215.96:1200/'+item['foto']+'" alt="No se encontró esta foto"></div>');
						});
						
						$("#e-"+p_numeroPedido).html('<button type="button"  data-toggle="modal" data-target="#modal-encuesta" class="btn btn-block bg-purple btn-xs"> Trade </button>');				
					}
				})
				.fail(function() {
					alert( "Error" );
					return false;
				});
			}
			
			function has_encuestaPedido(p_numeroPedido, p_clientePedido, drawhtml){
				$("#contenidoModalFotosPedido").html("")
				$("#ep-"+p_numeroPedido).html('');
				$("#ep-"+p_numeroPedido).removeClass("col-md-4");
				$("#ep-"+p_numeroPedido).hide();
				
				var result;
				
				 $.ajax({
					url: "{{ url('/') }}/get/encuestaPrePost",
					type: 'POST',
					async: false,
					cache: false,
					timeout: 30000,
					data: { empresa : "{{ $empresa }}", sucursal : "{{ $sucursal }}", pedido : p_numeroPedido, cliente : p_clientePedido },
					dataType: 'json',
					error: function(){
						result = false;
					},
					success: function(jsonDetalleEncuesta){ 
						if(jsonDetalleEncuesta.length > 0){
							if( drawhtml ){
								$("#ep-"+p_numeroPedido).show();
								$("#ep-"+p_numeroPedido).addClass("col-md-4");
							
								$.each(jsonDetalleEncuesta, function(index, item) {  
									$("#contenidoModalFotosPedido").append(' <div class="col-md-4"><p>'+item['pregunta']+'</p><img class="img-responsive pad" src="http://35.184.215.96:1200/'+item['foto']+'" alt="No se encontró esta foto"></div>');
								});
								
								$("#ep-"+p_numeroPedido).html('<button type="button"  data-toggle="modal" data-target="#modal-encuesta-pedido" class="btn btn-block bg-blue btn-xs"> Fotos </button>');
							}
							
							result = true ;
						}else{
							result = false;							
						}
					}
				});
	
				return result;	
			}
			
			
			
			function md_agregarTabPedidoModal( cliente, indice){
				var htmlNav = esquema["N"];
				var tabPedido =  esquema["T"];
				var pedido = datosClientes[cliente].listaPedidos[indice];

				tabPedido = tabPedido.replace('[class]', "tab-pane");
                htmlNav = htmlNav.replace('[class]', "");
               
				htmlNav = htmlNav.replace(/_pedido_/g, pedido.numeroPedido);
				htmlNav = htmlNav.replace('[fecha]', pedido.fecha);
				htmlNav = htmlNav.replace('[estado]', pedido.estado);
				htmlNav = htmlNav.replace('[total]', pedido.importeTotal);
				htmlNav = htmlNav.replace('[vendedor]', pedido.vendedor);
				htmlNav = htmlNav.replace('[cliente]', cliente);
				htmlNav = htmlNav.replace('[order]', indice);
				htmlNav = htmlNav.replace('[indice]', indice);

				tabPedido = tabPedido.replace(/_pedido_/g, pedido.numeroPedido);
				tabPedido = tabPedido.replace('[total]', pedido.importeTotal);
				tabPedido = tabPedido.replace('[fecha]', pedido.fecha);
				tabPedido = tabPedido.replace('[estado]', pedido.estado);
				tabPedido = tabPedido.replace('[class-estado]', "label-" + pedido.estado);
				tabPedido = tabPedido.replace('[vendedor]', pedido.vendedor);
				tabPedido = tabPedido.replace(/_indice_/g, indice);
				tabPedido = tabPedido.replace('[encuesta]', 'e-'+ pedido.numeroPedido);
				tabPedido = tabPedido.replace('[encuesta-pedido]', 'ep-'+ pedido.numeroPedido);
				
				tabPedido = tabPedido.replace('[segmento]', datosClientes[cliente].segmento);
				tabPedido = tabPedido.replace('[nroExhibidores]', datosClientes[cliente].nroExhibidores);
				tabPedido = tabPedido.replace('[nroPuertasFrio]', datosClientes[cliente].nroPuertasFrio);
				
				if(pedido.estado == 'A'){
					tabPedido = tabPedido.replace('[motivo-no-venta]', '<b> Motivo no venta: </b> <span name="motivo">'+pedido.motivo+"</span>");
				}else {
					tabPedido = tabPedido.replace('[motivo-no-venta]', "");
				}

				if(pedido.estado == 'F'){
					tabPedido = tabPedido.replace('[factura]', pedido.factura);
				}else{
					tabPedido = tabPedido.replace('[factura]', "");
				}

				$("#content-tabs-"+cliente).append(tabPedido);
				$("#nav-"+cliente).append(htmlNav);

				sc_detallePedido(pedido.numeroPedido, pedido.fecha, cliente, indice);
				
			}

            function md_actualizarModalPedido( indice, pedidoNuevo){			
                //validar que el actualizar solo si las fechas es igual que configuracion de lo contrario mostrar emnsaje en console
                var datos = { factura : pedidoNuevo.factura, total : pedidoNuevo.importeTotal, fecha : pedidoNuevo.fechaPedido, estado : pedidoNuevo.estado,
				vendedor : pedidoNuevo.vendedor , motivo : pedidoNuevo.motivo}; //agregar motivo
                var estadoAnterior;
				
                $( "#tab-"+pedidoNuevo.pedido+"-"+indice+" span").each(function( index ) { 
                    if($(this).attr("name") == "estado"){
                        estadoAnterior = $(this).html();
                        $(this).removeClass();
                        $(this).addClass("label label-"+datos["estado"]);
                    }
					console.log($(this).attr("name")+"   "+datos[$(this).attr("name")]);
                    $(this).html(datos[$(this).attr("name")]);
                });

                if(estadoAnterior != datos["estado"] && datos["estado"] == "A"){
                    $( "#extra-"+pedidoNuevo.pedido+"-"+indice).html('<b>Motivo No Venta: </b><span name="motivo">'+ datos["motivo"] +'</span>');
                }

                $( "#nav-"+pedidoNuevo.cliente+" a small").each(function( index ) {
                    $(this).html( datos[$(this).attr("name")]);
                });
				console.log("limpiar tabla"+pedidoNuevo.pedido);
                $("#table-"+pedidoNuevo.pedido+"-"+indice).html("");
                $("#overlay-"+pedidoNuevo.pedido+"-"+indice).removeClass("hidden");

                sc_detallePedido(pedidoNuevo.pedido, pedidoNuevo.fechaPedido, pedidoNuevo.cliente, indice);
				//actualizar imagen marker
            }

			function sc_detallePedido(numeroPedido, fechaPedido, clientePedido, indicePedido){
               
				$.ajax({
					type: "POST",
					data: {  empresa : "{{ $empresa }}", sucursal : "{{ $sucursal }}", pedido : numeroPedido , fecha : fechaPedido, cliente : clientePedido },
					dataType: 'json',
					url: "{{ url('/') }}/get/detallePedido",
					indicePedidoAjax: indicePedido,
					clienteAjax: clientePedido,
					pedidoAjax: numeroPedido
				})
				.done(function(jsonDetallePedido) {
					//validar si el total es equivalente de lo contrario actualizar los totales
					var tablaPedido = "";
					$.each(jsonDetallePedido, function(index, item) {
						if(item['tipoProducto'] == 'V'){
							tablaPedido += '<tr><td>'+item['descripcion']+'</td><td>'+item['cantidad']+'</td><td>'+item['unidad']+'</td><td>'+item['precioNeto']+'</td></tr>';
						}else{
							tablaPedido += '<tr class="bonificacion"><td>'+item['descripcion']+'</td><td>'+item['cantidad']+'</td><td>'+item['unidad']+'</td><td>0</td></tr>';
						}
					});

					$("#table-"+this.pedidoAjax+"-"+this.indicePedidoAjax).append(tablaPedido);
					$("#overlay-"+this.pedidoAjax+"-"+this.indicePedidoAjax).addClass('hidden');
					datosClientes[this.clienteAjax].listaPedidos[this.indicePedidoAjax].ajaxPedido = true;
				})
				.fail(function() {
					alert( "Error" );
				});
			}

			$( "#refrescarMapa" ).click(function() {
				fc_limpiarPedidos(); 
				sc_actualizarPedidos(true);
				fc_validarTimer($("#fecha").val());
				resizeMap();				
			});
		
			$('#checkAgruparClientes').on('ifChecked', function(event){
                $('#checkAgruparClientes').iCheck('disable');
                document.getElementById("checkAgruparClientes").disabled = true;
                fc_agruparMarcadoresCliente();
                $('#checkAgruparClientes').iCheck('enable');
            });
			
			$('#checkAgruparPedidos').on('ifChecked', function(event){
                $('#checkAgruparPedidos').iCheck('disable');
                document.getElementById("checkAgruparPedidos").disabled = true;
                fc_agruparMarcadoresPedido();
                $('#checkAgruparPedidos').iCheck('enable');
            });

			function fc_agruparMarcadoresCliente() {				
				for (var i = 0; i < listaMarkersClientes.length; i++) {
					markerClusterClientes.addMarker(listaMarkersClientes[i]);
				}
			}
			
			function fc_agruparMarcadoresPedido() {
				for (var i = 0; i < listaMarkersPedidos.length; i++) {
					markerClusterPedidos.addMarker(listaMarkersPedidos[i]);
				}				
			}

			function fc_removerAgrupacionMarcadoresCliente() {				
				for (var i = 0; i < listaMarkersClientes.length; i++) {
					if(listaMarkersClientes[i] != null){
						listaMarkersClientes[i].setMap(map);						
					}
				}
			}
			
			function fc_removerAgrupacionMarcadoresPedido() {
				for (var i = 0; i < listaMarkersPedidos.length; i++) {
					listaMarkersPedidos[i].setMap(map);
				}				
			}
		
            $('#checkAgruparClientes').on('ifUnchecked', function(event){
                $('#checkAgruparClientes').iCheck('disable');
                markerClusterClientes.clearMarkers();
                fc_removerAgrupacionMarcadoresCliente();
                $('#checkAgruparClientes').iCheck('enable');
            });
			
			$('#checkAgruparPedidos').on('ifUnchecked', function(event){
                $('#checkAgruparPedidos').iCheck('disable');
                markerClusterPedidos.clearMarkers();
                fc_removerAgrupacionMarcadoresPedido();
                $('#checkAgruparPedidos').iCheck('enable');
            });

			
			function fc_limpiarPedidos(){
				totalPedidos['A'] = 0;
				totalPedidos['G'] = 0;
				totalPedidos['F'] = 0;

				for (var i = 0; i < listaClientes.length; i++) {
					datosClientes[ listaClientes[i] ].listaPedidos = [];
					datosClientes[ listaClientes[i] ].existePedido = false;
					$("#modal-"+listaClientes[i]+" .nav-tabs-custom").html("");
				}
				for(var i=0; i<listaMarkersClientes.length; i++){listaMarkersClientes[i].setMap(null);}
				listaMarkersClientes = [];
				for(var i=0; i<listaMarkersPedidos.length; i++){listaMarkersPedidos[i].setMap(null);}
				
				listaMarkersPedidos =[];
				actualPolyLine.setPath([]);    
				
				markerClusterPedidos.clearMarkers();
				markerClusterClientes.clearMarkers();
				
				md_actualizarDashboard();
			}
			
			$( "#centrarMapa" ).click(function() {
				resizeMap();	 				
            });
		});
       
		
		
		function fc_obtenerIndicePedido(cliente, numeroPedido){
            var index = -1;
            var lista = datosClientes[cliente].listaPedidos;
            for(var i = 0; i<lista.length; i++){
                if( lista[i].numeroPedido == numeroPedido){
                    index = i;
                    break;
                }
            }
            return index;
        }	
		
		function fc_closeModal(cliente){
			$('#modal-'+cliente).removeClass("show"); 
		}

		function fc_collapseModal(cliente){
			if($(this).data("widget") == "extend"){
				$('#modal-'+cliente).removeClass("collapsed-box");
				$(this).data("widget", "collapse");
			}else{
				$('#modal-'+cliente).addClass("collapsed-box");
				$(this).data("widget", "extend");
			} 
		}
		
        function md_actualizarDashboard(){			
			$.ajax({
				global: false,
				type: "POST",
				dataType: 'json',
				data: { "empresa" : "{{ $empresa }}","sucursal" : "{{ $sucursal }}","supervisor" : "{{ $super }}","ruta" : rutaFiltro,"zona" : zonaFiltro,"fecha" : fechaPreventaFiltro,"vendedor": {{ $vendedor }} },
				url: "{{ url('/') }}/get/{{ $metodo }}"
			})
			.done(function(jsondata) {
				console.log(jsondata); 
				for(var i = 0; i<jsondata.length; i++){
					var clientesProgramados = jsondata[i].clientesProgramados;
					var clientesConPedidos = jsondata[i].clientesConPedidos;
					var clientesVisitados = jsondata[i].clientesVisitados;
					var estadoVendedor = jsondata[i].estadoVendedor;
					var importeVentasx = jsondata[i].importeVentasx;
					var totalPaquetes = jsondata[i].totalPaquetes;
					
					var clientesConPedidosPorcentaje = ((clientesConPedidos/clientesProgramados)*100).toFixed(2) + '%';
					var clientesNoPedido = clientesProgramados - clientesVisitados;
					var clientesVisitadosPorcentaje = ((clientesVisitados/clientesProgramados)*100).toFixed(2) + '%';
					var clientesNoVisitados = clientesProgramados - clientesVisitados;
					var visitadosPorcentaje = ((clientesVisitados/clientesProgramados)*100).toFixed(2) + '%';
					var dropPaquetes = (totalPaquetes/clientesConPedidos).toFixed(2);
					var dropSoles = (importeVentasx/clientesConPedidos).toFixed(2);
					
					$("#clientesProgramados").html(clientesProgramados);
					$("#clientesConPedidos").html(clientesConPedidos);
					$("#clientesConPedidosPorcentaje").html(clientesConPedidosPorcentaje);  $("#clientesConPedidosPercent").html(clientesConPedidosPorcentaje);
					$("#totalPaquetes").html(totalPaquetes);
					$("#clientesNoPedido").html(clientesNoPedido);
					$("#clientesVisitados").html(clientesVisitados);
					$("#clientesVisitadosPorcentaje").html(clientesVisitadosPorcentaje);
					$("#clientesNoVisitados").html(clientesNoVisitados);
					$("#estadoVendedor").html(estadoVendedor);
					$("#visitadosPorcentaje").html(visitadosPorcentaje);
					$("#importeTotal").html(importeVentasx);
					$("#dropPaquetes").html(dropPaquetes);
					$("#dropSoles").html(dropSoles);

					$("#numero-paquete").html(totalPaquetes);
					$("#importe-total").html(importeVentasx);
				}
				
			})
			.fail(function() {
				alert( "Error" );
			});
				
			var iconoU = "<i class='fa fa-caret-up'><i/>";
			var iconoD = "<i class='fa fa-caret-down'><i/>";
			
            var porcentajeNoVenta = typeof totalPedidos['A']  !== 'undefined' ? (100 * totalPedidos['A'])/totalPedidos['total'] : 0;
            var porcentajePedidoGenerado = typeof totalPedidos['G']  !== 'undefined' ? (100 * totalPedidos['G'])/totalPedidos['total'] : 0;
            var porcentajeFacturados = typeof totalPedidos['F']  !== 'undefined' ? (100 * totalPedidos['F'])/totalPedidos['total'] : 0;

			porcentajeNoVenta = porcentajeNoVenta.toFixed(2);
			porcentajePedidoGenerado = porcentajePedidoGenerado.toFixed(2);
			porcentajeFacturados = porcentajeFacturados.toFixed(2);
			
            $("#no-venta").html(totalPedidos['A']); //revisar motivos no venta
			if( porcentajeNoVenta <= 30){ $("#no-venta-label").html(iconoD);
			}else{ $("#no-venta-label").html(iconoU); }	
			$("#no-venta-label").append("  "+porcentajeNoVenta+"%");
            $("#no-venta-sidebar").css("width", porcentajeNoVenta+"%");

            $("#pedido-generado").html(totalPedidos['G']);
						
			if( porcentajePedidoGenerado <= 30){ $("#pedido-generado-label").html(iconoD);
			}else{ $("#pedido-generado-label").html(iconoU); }			
			$("#pedido-generado-label").append("  "+porcentajePedidoGenerado+"%");
            $("#pedido-generado-sidebar").css("width", porcentajePedidoGenerado + "%");

            $("#facturados").html(totalPedidos['F']);
			if( porcentajeFacturados <= 30){ $("#facturados-label").html(iconoD);
			}else{ $("#facturados-label").html(iconoU); }			
			$("#facturados-label").append("  "+porcentajeFacturados+"%");
            $("#facturados-sidebar").css("width", porcentajeFacturados + "%");

            var totalClientes = listaClientes.length;
            var visitados = 0;
            var noVisitados = 0;

            for(var i = 0; i<listaClientes.length; i++){
                if(datosClientes[listaClientes[i]].existePedido){
                    visitados += 1;
                }
            }
            noVisitados = totalClientes - visitados;
            var porcentajeVisitados = ((100 * visitados)/totalClientes).toFixed(2);
            var porcentajeNoVisitados = ((100 * noVisitados)/totalClientes).toFixed(2);
						
            $("#visitados").html(visitados);
			if( porcentajeVisitados <= 30){ $("#visitados-label").html(iconoD);
			}else{ $("#visitados-label").html(iconoU); }			
			$("#visitados-label").append("  "+porcentajeVisitados+"%");			
            $("#visitados-sidebar").css("width", porcentajeVisitados + "%");

            $("#no-visitados").html(noVisitados);
			if( porcentajeNoVisitados <= 30){ $("#no-visitados-label").html(iconoD);
			}else{ $("#no-visitados-label").html(iconoU); }			
			$("#no-visitados-label").append("  "+porcentajeNoVisitados+"%");
            $("#no-visitados-sidebar").css("width", porcentajeNoVisitados + "%");
			

        }
    </script>
</body>
</html>


