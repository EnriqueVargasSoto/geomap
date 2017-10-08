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
	Route::get('/login', 'LoginController@index');
	
	Route::group(['middleware' => 'auth'], function(){
		Route::get('/', 'MapaController@index');
		
		Route::group(['prefix' => 'get'], function(){
			Route::post('/fecha', 'MapaController@obtenerFecha');
			Route::post('/sucursales', 'MapaController@obtenerSucursales');
			Route::post('/rutas', 'MapaController@obtenerRutas');			
			Route::post('/vendedores', 'MapaController@obtenerVendedores');
			Route::post('/clientes', 'MapaController@obtenerPosicionesCliente'); 
			Route::post('/pedido', 'MapaController@obtenerPosicionesPedido'); 
			Route::post('/detallePedido', 'MapaController@obtenerDetallePedido');
		});	
	});	
});
	
Route::group(['namespace' => 'Auth'], function(){
    Route::post('/login', 'LoginController@login');
    Route::get('/logout', 'LoginController@logout');
});
