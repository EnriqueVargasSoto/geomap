<?php
/**
 * Created by ExpedioDigital.
 * User: Monica Toribio Rojas
 * Date: 17/09/2017
 * Time: 07:06
 */
namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Sucursal; 
use App\Models\Persona; 
use App\Models\RutasxPersona;  
use App\Models\Configuracion;
use Illuminate\Http\Request;
use DB;
use Response;
class MapaController extends Controller
{
	protected function index(){ 
		return view('frontend.index');//,['sucursal' => $list ]
	}
	
	/*
	* Api....
	*/
	protected function obtenerSucursales(){
		$idEmpresa = Auth::user()->idEmpresa;
		$idPersona = Auth::user()->_id;
		$lista = Sucursal::porPersona($idEmpresa,$idPersona);
		return response()->json($lista); 
	}
	
	protected function obtenerRutas(Request $request){
		$idEmpresa = Auth::user()->idEmpresa;
		$idSucursal = $request->input('sucursal');
		$lista = RutasxPersona::distinct()->select('idRuta')->where('idEmpresa', '=', $idEmpresa)
				 ->where('idSucursal', '=', $idSucursal)
				 ->groupBy('idRuta')->get();
		return response()->json($lista);
	}
	
	/*protected function obtenerVendedores(Request $request){
		$idEmpresa = Auth::user()->idEmpresa;
		$idSucursal = $request->input('sucursal');
		$lista = Persona::vendedoresPorSucursal($idEmpresa,$idSucursal);
		return response()->json($lista); 
	}*/
	
	protected function obtenerFecha(Request $request){
		$idEmpresa = Auth::user()->idEmpresa;
		$idSucursal = (int)$request->input('sucursal');
		$fecha = Configuracion::getSetting($idEmpresa, $idSucursal);
		return response()->json( $fecha );
	}
	
	protected function obtenerPosicionesCliente(Request $request){ 
		$idEmpresa = Auth::user()->idEmpresa;
		$idSucursal = $request->input('sucursal');
		$idRuta = $request->input('ruta'); 
		$Desde = $request->input('desde'); 
		$Hasta = $request->input('hasta'); 
		$lista = DB::select("exec api_obtenerClientes ?,?,?,?,?", [$idEmpresa, $idSucursal,$idRuta , $Desde, $Hasta ]);
		return response()->json($lista);
	}
	
	protected function obtenerDetallePedido(Request $request){ 
		$idEmpresa = Auth::user()->idEmpresa;
		$idSucursal = $request->input('sucursal');
		$numeroPedido = $request->input('pedido');
		$lista = DB::select("exec api_obtenerDetallePedido ?,?,?", [$idEmpresa, $idSucursal, $numeroPedido ]);		 
		return  response()->json($lista);
	}
	
	protected function obtenerPosicionesPedido(Request $request){ 
		$idEmpresa = Auth::user()->idEmpresa;
		$idSucursal = $request->input('sucursal');
		/*$idPersona = $request->input('vendedor');*/
		$Desde = $request->input('desde');
		$Hasta = $request->input('hasta');
		$lista = DB::select("exec api_obtenerPedidos ?,?,?,?,?", [$idEmpresa, $idSucursal, 0, $Desde, $Hasta ]);
		return  response()->json($lista);
	} 
}