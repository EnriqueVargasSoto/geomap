@extends('layouts.frontend.master')
@section('style')
<style>
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
    #mapa, #content-map {
		height: 100%;
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
		display: block;
	}    
	#legend div { 
		padding-top: 2px;
	}
	#legend img {
		vertical-align: middle;
	}
	#infoWindow h5{
		text-align: center;
	}
	#infoWindow p{ 
		margin-left: 7px;   
		width: 46%;
		text-transform: capitalize;
		display: inline-block;  
		margin-bottom: 1px;
	}
	#infoWindow span{
		margin-left: 7px;
	}
	#infoWindow .col-xs-12 { 
		text-transform: capitalize;
	}
	.table-content{
		min-height: 22px;
		margin-top: 4px;
	}
	.table-content .overlay>.fa{
		font-size: 18px;
		top: 68%;
	}
	input.form-control.half-content {
		width: 50%;
		padding-right: 2px;
		padding-left: 2px;
		text-align: center;
	}
	div.input-group-addon.small-icon{
		padding-left: 6px;
		padding-right: 6px;
	}
	.select2-results__option {
		text-transform: capitalize;
	}
	.select2-container--default .select2-selection--single .select2-selection__rendered { 
		text-transform: capitalize;
	} 
	i.fa.fa-calendar:hover {
		color: green;
		border-color: red;
	}

	.input-group .input-group-addon:hover { 
		border-color: green; 
		 box-shadow: 0 1px 2px 0 #00a65a, 0 1px 2px 0 #00a65a;
	}

	#sucursales .select2-results__option[aria-selected=true] {
		display: none;
	}
	.setting .fa.pull-right{
		line-height: 20px;
	}
	@media screen and (max-width: 767px){ 
		#infoWindow p{ width : auto; margin-left: 0px; };
		#infoWindow span{
			margin-left: 0px;
		}
		#legend{
			display:none;
		}
	} 
</style>
@stop
@section('content')
  <!-- Content Wrapper. Contains page content -->  
  <div id="content-map">
	  <div id="overlay" class="overlay hidden"><i class="fa fa-refresh fa-spin"></i></div>
	  <div class="content-wrapper" id= "mapa"></div>
  </div>
  <div id="legend"></div>
  <!-- /.content-wrapper -->
@stop
@section('script')
<script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA8tDfygL5CFzsEOfJpEhPYdDFzma-5P8c"></script>
<!-- InputMask -->
<script src="plugins/input-mask/jquery.inputmask.js"></script>
<script src="plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<!-- datepicker -->  
<script src="bower_components/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script> 
<script src="bower_components/bootstrap-datepicker/locales/bootstrap-datepicker.es.min.js"></script> 
<!-- Select2 -->
<script src="bower_components/select2/js/select2.min.js"></script>
<script src="bower_components/select2/js/i18n/es.js"></script>
<script> 
	var map, markerCluster, bounds, util;
	var listaClientes = [];
	var clientesMarkers = []; 
	var iconMapBase = 'images/map/';
	var timerPedidos = null;
	var fechaDefecto = '';
	var rutaConsulta = '0';
	
	function obtenerSucursales() { 
		$.ajax({
			global: false,
			type: "POST",
			dataType: 'json',
			url: "get/sucursales",
			success: function(jsondata){
				var select = $('#sucursales');
				 
				$.each(jsondata, function(index, element) {
					select.append("<option value='"+ element['idSucursal'] +"'>" + element['nombre'].toLowerCase() + "</option>");                   
                });
				$('#sucursales').select2({
					language: 'es'
				}); 
			}
		});
	}
	
	function obtenerRutas() { 
		var sucursal = $("#sucursales").val();
		$.ajax({
			global: false,
			type: "POST",
			dataType: 'json', 
			data: { sucursal: sucursal },
			url: "get/rutas" 
		})
		.done(function(jsondata) {
			var select = $('#rutas');
			select.append("<option value='x'>Ninguna</option>");
			$.each(jsondata, function(index, element){ select.append("<option value='"+ element['idRuta'] +"'>" + element['idRuta'] + "</option>"); });
			select.append("<option value='all'>Todas</option>");				
			$('#sucursales').select2({ language: 'es' });
			select.prop( "disabled", false );
		})
		.fail(function() {
			alert( "Error" );
		})
		.always(function(){
			$("#overlay").addClass("hidden");
		}); 		
	}
	
	function obtenerPosicionCliente() { 
		var cliente;
		var sucursal = $("#sucursales").val();
		var desde = $("#desde" ).val();
		var hasta = $("#hasta" ).val();		
		var ruta = $("#rutas" ).val();		
		$.ajax({
			type: 'POST',
			url: 'get/clientes',
			data: { sucursal: sucursal, ruta : ruta, desde : desde, hasta : hasta }, 
		})
		.done(function(jsondata) {
			for(var i=0; i<jsondata.length; i++){ agregarMarcadorCliente(jsondata[i]); } 
			bounds = new google.maps.LatLngBounds();
			for (var i = 0; i < listaClientes.length; i++){ bounds.extend(clientesMarkers[listaClientes[i]].markerCliente.getPosition()); }
			map.fitBounds(bounds);  
			obtenerPedidos();	
		})
		.fail(function() {
			alert( "Error" );
		})
		.always(function() {
			if(desde == fechaDefecto){
				console.log("fecha actual, se inicia el timer");
				if (timerPedidos ){ clearInterval(timerPedidos); }			
				timerPedidos = setInterval(function() { obtenerPedidos(false); }, 300 * 1000);
			}
			$("#overlay").addClass("hidden");
		});  
	}
		
	function agregarMarcadorCliente(jsondata){  
		
		var nuevoRegistro = new Array(); 
		var existePedido = false;
		var sucursal = $("#sucursales" ).val();
		var estado = jsondata.estado;
		var codigo = jsondata.idCliente;
		var numeroPedido = jsondata.numeroPedido;
		var pedido, factura, contenidoPedido; 
		var latitudPedido = jsondata.latitudPedido;
		var longitudPedido = jsondata.longitudPedido;
		var latitudCliente = jsondata.latitudCliente;
		var longitudCliente = jsondata.longitudCliente;
		var ubicacionCliente = new google.maps.LatLng(latitudCliente, longitudCliente);
		 
		listaClientes.push(codigo);
		pedido = factura = contenidoPedido = ""; 
		 
		nuevoRegistro['razonSocial'] = jsondata.razonSocial;
		nuevoRegistro['rucDni'] = jsondata.rucDni;
		nuevoRegistro['direccion'] = jsondata.direccion;
		nuevoRegistro['correo'] = jsondata.correo;
		nuevoRegistro['numeroPedido'] = 0;
		nuevoRegistro['importeTotal'] = 0;
		nuevoRegistro['pesoTotal'] = 0;
			
		if(jsondata.importeTotal ){  
			existePedido = true; 
			nuevoRegistro['numeroPedido'] = numeroPedido;
			nuevoRegistro['importeTotal'] = jsondata.importeTotal;
			nuevoRegistro['pesoTotal'] = jsondata.pesoTotal;
		}
		
		nuevoRegistro['estado'] = estado;  
		nuevoRegistro['existePedido'] = existePedido;
		nuevoRegistro['ajaxPedido'] = false;
		 
		var contenidoInfoWindow = util[estado].html;
		contenidoInfoWindow = contenidoInfoWindow.replace('[cliente]', jsondata.razonSocial );
		contenidoInfoWindow = contenidoInfoWindow.replace('[ruc]', jsondata.rucDni );
		contenidoInfoWindow = contenidoInfoWindow.replace('[direccion]', jsondata.direccion );	
		contenidoInfoWindow = contenidoInfoWindow.replace('[correo]', jsondata.correo );
		contenidoInfoWindow = contenidoInfoWindow.replace('[pedido]', jsondata.numeroPedido );
		contenidoInfoWindow = contenidoInfoWindow.replace('[pedido]', jsondata.numeroPedido );
		contenidoInfoWindow = contenidoInfoWindow.replace('[pedido]', jsondata.numeroPedido );
		contenidoInfoWindow = contenidoInfoWindow.replace('[total]', jsondata.importeTotal ); 
		contenidoInfoWindow = contenidoInfoWindow.replace('[hora]', jsondata.hora );
		contenidoInfoWindow = contenidoInfoWindow.replace('[factura]', jsondata.serieDocumento+' '+jsondata.numeroDocumento );
		contenidoInfoWindow = contenidoInfoWindow.replace('[motivo]', jsondata.descripcion );
		contenidoInfoWindow = contenidoInfoWindow.replace('[vendedor]', jsondata.vendedor );
 			
		var contentString = '<div id="infoWindow">'+ contenidoInfoWindow + '</div>'; 
				
		var infowindow = new google.maps.InfoWindow({
            content: contentString,
		    maxWidth: 400
        });
		
		var markerCliente = new google.maps.Marker({
			position: ubicacionCliente,
			map: map, 
			icon: util[estado].img,
			title: jsondata.razonSocial 
		});
		
		nuevoRegistro['infowindow'] = infowindow;
		nuevoRegistro['markerCliente'] = markerCliente;
		
		if ($('#checkAgrupar').is(':checked') ){ markerCluster.addMarker(markerCliente); }
		
		if(estado == 'D'){
			markerCliente.addListener('click', function() {
			  infowindow.open(map, markerCliente);
			});
			
			google.maps.event.addListener(map, 'click', function() {
				infowindow.close();
			});
			nuevoRegistro['markerPedido'] = null;
			nuevoRegistro['posicionPedido'] =  null;
			
		}else{  
			var ubicacionPedido = new google.maps.LatLng(latitudPedido, longitudPedido); 
			var markerPedido = new google.maps.Marker({
								   position: ubicacionPedido,
								   map: null,
								   icon:  iconMapBase+"icon_geomarker_pinldpi.png",
								   draggable: false,
								   title: "Vendedor"
							});
			var posicionPedido = new google.maps.Polyline({
						   path: [ubicacionPedido,ubicacionCliente],
						   icons: [{icon: google.maps.SymbolPath.FORWARD_CLOSED_ARROW, offset: '100%'}],
						   zIndex: 99,
						   strokeOpacity: 0.4,
						   strokeColor: '#FF4500',
						   map: null
						});
			
			markerCliente.addListener('click', function() {
				if(!clientesMarkers[codigo].ajaxPedido){
					$.ajax({ 
						type: "POST",
						data: { sucursal: sucursal , pedido : numeroPedido },
						dataType: 'json',
						url: "get/detallePedido",
					})
					.done(function(jsonDetallePedido) {
						var tablaPedido = '<table class="table table-striped"><thead>'+
								  '<tr><th>Producto</th><th>Cant</th><th>UM</th><th>Importe</th></tr></thead><tbody>';
						$.each(jsonDetallePedido, function(index, item) {
							tablaPedido = tablaPedido + '<tr><td>'+item['descripcion']+'</td><td>'+item['cantidad']+'</td><td>'+item['unidad']+'</td><td>'+item['precioNeto']+'</td></tr>'; 
						});
						tablaPedido = tablaPedido +'</tbody></table>'; 
						document.getElementById(numeroPedido+'-table').innerHTML = tablaPedido; /* problema*/
						$('#'+numeroPedido+'-overlay').addClass('hidden');
						
						//Alerta : Si el total coinciden se marca como true de lo contrario false
						clientesMarkers[codigo].ajaxPedido = true;
					})
					.fail(function() {
						alert( "Error" );
					});
				}
				
				infowindow.open(map, markerCliente);
				markerPedido.setMap(map);
				posicionPedido.setMap(map);  
			});
						
			google.maps.event.addListener(map, 'click', function() {
				infowindow.close();
				posicionPedido.setMap(null); 
				markerPedido.setMap(null);
			});
			
			nuevoRegistro['markerPedido'] = markerPedido;
			nuevoRegistro['posicionPedido'] = posicionPedido;
		} 
		
		clientesMarkers[codigo] = nuevoRegistro;
	}
	
	function obtenerPedidos(overlay){ 
		var latLngPedido;   
		var sucursal = $("#sucursales" ).val();
		var desde = $("#desde" ).val();
		var hasta = $("#hasta" ).val();
		
		$.ajax({
			type: 'POST',
			url: 'get/pedido',
			data: { sucursal: sucursal, desde : desde, hasta : hasta }			
		}).done(function(jsondata) { 
			$.each(jsondata, function(index, item) {
				if(clientesMarkers[item.idCliente]){
					var contenidoPedido = "";
					var contenidoDetallePedido = "";
					var contenidoFactura = "";
					var contentString = ""; 
					
					var estado =  clientesMarkers[item.idCliente].estado;
					var numeroPedido = clientesMarkers[item.idCliente].numeroPedido;
					var pesoTotal =  clientesMarkers[item.idCliente].pesoTotal;
					var importeTotal =  clientesMarkers[item.idCliente].importeTotal; 
				
				
					if(!(item.numeroPedido == numeroPedido && item.estado == estado && item.pesoTotal == pesoTotal && item.importeTotal == importeTotal )){
						var contenidoInfoWindow = util[item.estado].html;
						contenidoInfoWindow = contenidoInfoWindow.replace('[cliente]', clientesMarkers[item.idCliente].razonSocial );
						contenidoInfoWindow = contenidoInfoWindow.replace('[ruc]', clientesMarkers[item.idCliente].rucDni );
						contenidoInfoWindow = contenidoInfoWindow.replace('[correo]', clientesMarkers[item.idCliente].correo );
						contenidoInfoWindow = contenidoInfoWindow.replace('[direccion]', clientesMarkers[item.idCliente].direccion );
						contenidoInfoWindow = contenidoInfoWindow.replace('[pedido]', jsondata.numeroPedido );
						contenidoInfoWindow = contenidoInfoWindow.replace('[pedido]', jsondata.numeroPedido );
						contenidoInfoWindow = contenidoInfoWindow.replace('[pedido]', jsondata.numeroPedido );
						contenidoInfoWindow = contenidoInfoWindow.replace('[total]', item.importeTotal ); 
						contenidoInfoWindow = contenidoInfoWindow.replace('[hora]', item.hora );
						contenidoInfoWindow = contenidoInfoWindow.replace('[factura]', item.serieDocumento+'-'+item.numeroDocumento );
						contenidoInfoWindow = contenidoInfoWindow.replace('[motivo]', item.descripcion );
						contenidoInfoWindow = contenidoInfoWindow.replace('[vendedor]', item.vendedor ); 

						contentString = '<div id="infoWindow">'+ contenidoInfoWindow + '</div>';
							 
						clientesMarkers[item.idCliente].infowindow.setContent(contentString);
						clientesMarkers[item.idCliente].markerCliente.setIcon(util[item.estado].img);
						clientesMarkers[item.idCliente].importeTotal = item.importeTotal ;
						clientesMarkers[item.idCliente].pesoTotal = item.pesoTotal ;
						clientesMarkers[item.idCliente].estado = item.estado ;
						
						clientesMarkers[item.idCliente].ajaxPedido = false;
					 
						if(!clientesMarkers[item.idCliente].existePedido){ 
							var ubicacionPedido = new google.maps.LatLng(item.latitudPedido, item.longitudPedido); 
							var markerPedido = new google.maps.Marker({
												   position: ubicacionPedido,
												   map: null,
												   icon:util['G'].img,
												   draggable: false,
												   title: "Vendedor"
											});
							var posicionPedido = new google.maps.Polyline({
										   path: [ubicacionPedido, clientesMarkers[item.idCliente].markerCliente.getPosition() ],
										   icons: [{icon: google.maps.SymbolPath.FORWARD_CLOSED_ARROW, offset: '100%'}],
										   zIndex: 99,
										   strokeOpacity: 0.4,
										   strokeColor: '#FF4500',
										   map: null
										});
							
							clientesMarkers[item.idCliente].markerCliente.addListener('click', function() {
								if(!clientesMarkers[item.idCliente].ajaxPedido){
									$.ajax({ 
										type: "POST",
										data: { sucursal: sucursal , pedido : item.numeroPedido },
										dataType: 'json',
										url: "get/detallePedido",
									})
									.done(function(jsonDetallePedido) {
										var tablaPedido = '<table class="table table-striped"><thead>'+
												  '<tr><th>Producto</th><th>Cant</th><th>UM</th><th>Importe</th></tr></thead><tbody>';
										$.each(jsonDetallePedido, function(index, item) {
											tablaPedido = tablaPedido + '<tr><td>'+item['descripcion']+'</td><td>'+item['cantidad']+'</td><td>'+item['unidad']+'</td><td>'+item['precioNeto']+'</td></tr>'; 
										});
										tablaPedido = tablaPedido +'</tbody></table>'; 
										document.getElementById(item.numeroPedido+'-table').innerHTML = tablaPedido;
										$('#'+item.numeroPedido+'-overlay').addClass('hidden');
										
										//Alerta : Si el total coinciden se marca como true de lo contrario false
										clientesMarkers[item.idCliente].ajaxPedido = true;
									})
									.fail(function() {
										alert( "Error" );
									});
								}
								 
								markerPedido.setMap(map);
								posicionPedido.setMap(map);  
							});
										
							google.maps.event.addListener(map, 'click', function() { 
								posicionPedido.setMap(null); 
								markerPedido.setMap(null);
							});
							
							clientesMarkers[item.idCliente].markerPedido  = markerPedido;
							clientesMarkers[item.idCliente].posicionPedido = posicionPedido;
						} 	
					} 
				}else{
					console.log("ALERTA: No existe el cliente "+item.idCliente+" en el mapa actual, refresque el mapa para obtener este nuevo cliente");
				} 
			});
		}).fail(function() {
			alert( "Error" );
		}).always(function() { 
			if(overlay){ $("#overlay").addClass("hidden");}
		}); 
	}
	
	function limpiarMapa(){ 
		establecerMapaClientes(null); 
		clientesMarkers = []; 
		listaClientes = [];
		markerCluster.clearMarkers();
	} 
	 	
	function establecerMapaClientes( nuevoMapa ) {  
		for (var i = 0; i < listaClientes.length; i++){  
			clientesMarkers[listaClientes[i]].markerCliente.setMap(nuevoMapa);
						
			if ($('#checkAgrupar').is(':checked') ){
				markerCluster.addMarker( clientesMarkers[listaClientes[i]].markerCliente );
			} 
		}
	}
	
	$(document).ready(function(){  
		var centro = {lat: -11.971990, lng:  -77.062177};
		var legenda = document.getElementById('legend'); 
		var htmlNoPedido = '<div class="col-xs-12 "><h5>[cliente]</h5><b>Ruc: </b>[ruc]<br><b>Correo: </b>[correo]<br><b>Dirección: </b>[direccion]</div>';
		var htmlPedido = '<div class="col-xs-12 contenido"><h5>[cliente]</h5><p><b>Ruc: </b>[ruc]<br><b>Pedido N°: </b>[pedido]<br><b>Total: </b>[total]</p><p><b>Correo: </b>[correo]<br> <b>Factura: </b>[factura]<br>'+
						 '<b>Hora: </b>[hora]</p><span><b>Vendedor : </b>[vendedor]</span><br><span><b>Dirección: </b>[direccion]</span></div>'+
						 '<div id="[pedido]-table" class="col-xs-12 table-responsive table-content"><div id="[pedido]-overlay" class="overlay"><i class="fa fa-refresh fa-spin"></i></div></div>'; 
		var htmlNoVenta = '<div class="col-xs-12 contenido"><h5>[cliente]</h5><p><b>Ruc: </b>[ruc]<br><b>Pedido N°: </b>[pedido]<br><b>Total: </b>[total]</p><p><b>Correo: </b>[correo]<br> <b>Factura: </b>[factura]<br>'+
						  '<b>Hora: </b>[hora]</p><span><b>Vendedor : </b>[vendedor]</span><br><span><b>Motivo : </b>[motivo]</span><br><span><b>Dirección: </b>[direccion]</span></div>';	
		util = { 
					G: { nombre: 'Visitado', img: iconMapBase + 'icon_geomarker_greenldpi.png', html: htmlPedido},
					D: { nombre: 'No visitado', img: iconMapBase + 'icon_geomarker_greyldpi.png', html: htmlNoPedido},
					A: { nombre: 'No venta', img: iconMapBase + 'icon_geomarker_redldpi.png', html: htmlNoVenta},
					F: { nombre: 'Factura', img: iconMapBase + 'icon_geomarker_purpleldpi.png', html: htmlPedido } 
				}; 
		 
		$('#desde').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' });
		$('#hasta').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' }); 
		
		$('#desde').datepicker({ language:'es', autoclose: true });
		$('#hasta').datepicker({ language:'es', autoclose: true });
	
        map = new google.maps.Map(document.getElementById('mapa'), {
            zoom: 10,
            center: centro
        });  
		for (var key in util) {
			var icono = util[key]; var nombre = icono.nombre; var icono = icono.img; var div = document.createElement('div');
			div.innerHTML = '<img src="' + icono + '"> ' + nombre+'<p id="total'+key+'"><p/>';
			legend.appendChild(div);
        }
        map.controls[google.maps.ControlPosition.RIGHT_BOTTOM].push(legenda);
		
		// Path by google https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m
		markerCluster = new MarkerClusterer(map, null, {imagePath: iconMapBase});
		obtenerSucursales();
		
		$("#sucursales" ).change(function() { 
			var sucursal = $(this).val();	
			if(sucursal !== "0"){
				rutaConsulta = '0'; 
				$("#rutas").empty(); 
				$('#sucursales option[value="0"]').remove();
				$("#overlay").removeClass("hidden");	
				obtenerRutas();				
				$.ajax({ 
					type: "POST",
					dataType: 'json',
					data: { sucursal: sucursal },
					url: "get/fecha"
				})
				.done(function(jsondata){
					if($("#desde").val() == "" || $("#hasta").val() == ""){
						fechaDefecto = jsondata;
						$("#desde").val(jsondata);
					}
				})
				.fail(function() {
					alert( "Error" );
				}); 
			} 
		});
		
		$("#rutas" ).change(function() { 
			$("#overlay").removeClass("hidden");
			limpiarMapa();		
			obtenerPosicionCliente();
		});
						
		$('#btnFecha').click(function() {
			$("#overlay").removeClass("hidden"); 
			limpiarMapa(); 
			obtenerPedidos(true); 
		});
				
		$('#checkAgrupar').change(function() {
			if($("#sucursales").val() !== "0"){  
				if(!this.checked){ markerCluster.clearMarkers(); } 
				establecerMapaClientes(map, false); 
			}				
		});
		
		$( "#centrarMapa" ).click(function() {
			if($("#sucursales").val() !== "0"){  map.fitBounds(bounds); }
		});	
	
		$( "#refrescarMapa" ).click(function() {
			if($("#sucursales").val() !== "0"){ 
				if ( timerPedidos ) {clearInterval(timerPedidos);}
				obtenerPedidos(true);
			}
		});	
	});
  </script>
  
@stop