<?php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::group(['namespace' => 'Frontend'], function(){
    Route::group(['middleware' => 'guest'], function(){
    	Route::get('/login', 'LoginController@index');
    });	
    Route::post('get/sucursalEmpresa', 'MapaController@obtenerSucursalesEmpresa');

	Route::get('/user/{empresa}/{sucursal}/{modo}/{vendedor}', 'MapaController@monitoreoUsuario');
	
	Route::group(['prefix' => 'get'], function(){	
		Route::post('/obtenerResumenVentasPreventa', 'MonitoreoController@obtenerResumenVentasPreventa');
		Route::post('/obtenerResumenVentasAutoventa', 'MonitoreoController@obtenerResumenVentasAutoventa');
		
		Route::post('/clientes', 'MapaController@obtenerDatosCliente');	 
		Route::post('/pedidos', 'MapaController@obtenerPosicionesPedido');		
		Route::post('/detallePedido', 'MapaController@obtenerDetallePedido');
		Route::post('/encuestaTrade', 'EncuestaController@obtenerDetalleEncuestaTrade');
		Route::post('/encuestaPrePost', 'EncuestaController@obtenerDetalleEncuestaPrePost');
		
		Route::post('/geocercas', 'MapaController@obtenerGeocercas');
	});		
	
    Route::group(['middleware' => 'auth'], function(){
        Route::get('/', 'MonitoreoController@index');
        Route::get('/encuesta', 'EncuestaController@index');
        Route::get('/panelcentral', 'PanelCentralController@index');
        Route::get('/geolocalizacion', 'MapaController@index');
		
        Route::get('/monitoreovendedores', 'MonitoreoController@index');
		Route::post('/monitoreovendedores/detalle', 'MonitoreoController@verDetalle');
		//Route::post('/get/resumenxmarca', 'MonitoreoController@obtenerResumenMarcaAjax');
        Route::post('/monitoreo/{modo}', 'MapaController@indexAutoventa');
		
		Route::get('/avancexmarca', 'ReporteAvanceController@verAvancexMarca');
		Route::get('/avancexcuota', 'ReporteAvanceController@verAvancexCuota');
		Route::get('/hrindicador', 'ReporteHRIndicadorController@verReportexVendedor');
		Route::get('/campeonato','ReporteCampeonatoController@muestraCampeonato');
		Route::get('/maestros','MaestrosController@index');
		
		Route::group(['prefix' => 'encuesta'], function(){
			Route::get('/reporte1', 'ExcelController@respuestaEncuesta');
			Route::get('/nueva', 'EncuestaController@nuevaEncuesta');
			Route::get('/detalle/editar/{idEncuesta}/{id}', 'EncuestaController@verDetalleEncuesta');
		});
		
		Route::group(['prefix' => 'excel'], function(){
			Route::post('/reportePedidoVendedores', 'ExcelController@reporteTodosVendedoresPedidos');
			Route::post('/reporteHitRate', 'ExcelController@reporteHitRate');			
		});
		
        Route::group(['prefix' => 'get'], function(){			
            Route::post('/fecha', 'MapaController@obtenerFecha');
            Route::post('/sucursales', 'MapaController@obtenerSucursales');
            Route::post('/rutas', 'MapaController@obtenerRutas');
            Route::post('/zonas', 'MapaController@obtenerZonas');
            Route::post('/zonasxUser', 'MapaController@obtenerZonasxUsuario');
            Route::post('/vendedores', 'MapaController@obtenerVendedores');
            Route::post('/unidad_medida', 'MapaController@obtenerUnidadMedida');
            
            Route::post('/obtenerResumenVentasDespacho', 'MonitoreoController@obtenerResumenVentasDespacho');
            Route::post('/clientesxVendedor', 'MonitoreoController@obtenerClientesxVendedor');
			Route::post('/vistaxsegmento', 'MonitoreoController@obtenerVistaxSegmento');
            Route::post('/pedidosxVendedor', 'MonitoreoController@obtenerPedidosxVendedor');
			Route::post('/resumenxMarca', 'MonitoreoController@obtenerResumenMarca');
            Route::post('/detalleExtendidoPedido', 'MonitoreoController@obtenerDetalleExtendidoPedido');
            Route::post('/obtenerResumenPanel', 'PanelCentralController@obtenerResumenPanel');
			
			Route::post('/encuesta', 'EncuestaController@obtenerEncuesta');
			Route::post('/encuestas', 'EncuestaController@obtenerEncuestas');
			Route::post('/detalleEncuesta', 'EncuestaController@obtenerDetalleEncuesta');
			
			Route::post('/obtenerAvancexMarca', 'ReporteAvanceController@obtenerAvanceVentaxMarca');
			Route::post('/obtenerAvancexCuota', 'ReporteAvanceController@obtenerAvancexCuota');
			Route::post('/obtenerAvanceCuotaxSucursal', 'ReporteAvanceController@obtenerAvanceCuotaxSucursal');
			
			Route::post('/obtenerIndicadorHRXVendedor', 'ReporteHRIndicadorController@obtenerIndicadorxVendedor');			
			Route::post('/obtenerIndicadorHRXSucursal', 'ReporteHRIndicadorController@obtenerIndicadorxSucursal');			
			
			Route::post('/obtenerIndicadorMarca', 'ReporteHRIndicadorController@obtenerHRMarcaxCliente');
			Route::post('/obtenerListaPrecio', 'MaestrosController@obtenerListaPrecio');
			Route::post('/obtenerListaBonificacion', 'MaestrosController@obtenerBonificacion');
			Route::post('/obtenerGrupos', 'MaestrosController@obtenerGrupos');
			Route::post('/getDetailGroup', 'MaestrosController@getDetailGroup');
			Route::post('/obtenerImporteVenta', 'ReporteCampeonatoController@obtenerImporteVenta');
			
			
        });

        Route::group(['prefix' => 'update'], function(){
            Route::post('/guia', 'PanelCentralController@actualizarEstados');
            Route::post('/guias', 'PanelCentralController@actualizarEstadoMasivo');
        });
    });
});

Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'middleware' => 'auth.admin'], function(){
    Route::resource('users', 'UserController');
});

Route::group(['namespace' => 'Auth'], function(){
    Route::post('/login', 'LoginController@login');
    Route::get('/logout', 'LoginController@logout');
});