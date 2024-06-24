<?php
/**
 * Created by ExpedioDigital.
 * User: Monica Toribio Rojas
 * Date: 17/09/2017
 * Time: 07:06
 */
namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Controller;
use App\Http\Requests\MonitoreoRequest;
use App\Models\Usuario;
use Illuminate\Support\Facades\Auth;
use App\Models\Sucursal; 
use App\Models\Persona; 
use App\Models\Zona; 
use App\Models\Ruta;  
use App\Models\Configuracion;
use Illuminate\Http\Request;
use DB;
use Response;
class MapaController extends Controller
{
	protected function index(){  
		session(['active' => 'mapa']); 
		return view('frontend.index');
	}
	
	protected function indexPost(Request $request, $vendedor, $zona, $ruta){ 
		session(['active' => 'mapa']);
		$vendedorModel = Persona::where('idPersona', $vendedor )
							->where('idEmpresa', Auth::user()->idEmpresa )
							->where('idSucursal', Auth::user()->idSucursal )
							->first(); 
		$zonaModel = Zona::where('idZona', $zona )
							->where('idEmpresa', Auth::user()->idEmpresa )
							->where('idSucursal', Auth::user()->idSucursal )
							->first();  
		$rutaModel = Ruta::where('idRuta', $ruta )
							->where('idEmpresa', Auth::user()->idEmpresa )
							->where('idSucursal', Auth::user()->idSucursal )
							->first();  
		
		if($vendedorModel && $zonaModel && $rutaModel){
			return view('frontend.index',['zona' => $zona, 
					'nombreVendedor' =>  rtrim($vendedorModel->nombre ), 
					'ruta' => $ruta,	
					'fecha' => $request->input('fecha'), 
					'vendedor' => $vendedor , 
					'nombreZona' =>  rtrim($zonaModel->descripcion), 
					'nombreRuta' =>  strlen(rtrim($rutaModel->descripcion)) > 1 ? rtrim($rutaModel->descripcion) : $ruta  ]);
		}else{ 
			return redirect('/');
		}	
	}
	
	protected function indexAutoventa($modo, Request $request){ 
		session(['active' => 'mapa']);
		
		if($modo == "autoventa"){
			$metodo = 'obtenerResumenVentasAutoventa';
		}else if($modo == "despacho"){
			$metodo = 'obtenerResumenVentasDespacho';
		}else if($modo == "preventa"){
			$metodo = 'obtenerResumenVentasPreventa';
		}else{ 
			return redirect('/');
		}	
		
		$vendedorModel = Persona::where('idPersona', $request->input('vendedorx') )
							->where('idEmpresa', Auth::user()->idEmpresa )
							->where('idSucursal', Auth::user()->idSucursal )
							->first(); 
		$zonaModel = Zona::where('idZona', $request->input('zona') )
							->where('idEmpresa', Auth::user()->idEmpresa )
							->where('idSucursal', Auth::user()->idSucursal )
							->first(); 
							
		if($request->input('ruta') != "all"){
			$rutaModel = Ruta::where('idRuta', $request->input('ruta') )
							->where('idEmpresa', Auth::user()->idEmpresa )
							->where('idSucursal', Auth::user()->idSucursal )
							->first();
							
			if($vendedorModel && $zonaModel && $rutaModel){
				return view('frontend.mapaAutoventa',[
						'zona' => $zonaModel->getKey(), 
						'ruta' => $rutaModel->idRuta,	
						'nombreVendedor' =>  rtrim($vendedorModel->nombre ), 
						'metodo' => $metodo,
						/*'fecha' => $request->input('fecha'),*/
						'guia' => $request->input('guia'), 
						'vendedor' => $vendedorModel->getKey(), 
						'nombreZona' =>  rtrim($zonaModel->descripcion).'-'.$zonaModel->getKey(), 
						'nombreRuta' => $rutaModel->idRuta."-".$rutaModel->descripcion]);
			}	
			
		}else if($vendedorModel && $zonaModel){
			return view('frontend.mapaAutoventa',[
					'nombreVendedor' =>  rtrim($vendedorModel->nombre ), 
					'metodo' => $metodo,
					/*'fecha' => $request->input('fecha'), */
					'guia' => $request->input('guia'), 
					'vendedor' => $vendedorModel->getKey(), 
					'zona' => $zonaModel->getKey(), 
					'ruta' =>  "all",	
					'nombreZona' =>  rtrim($zonaModel->descripcion).'-'.$zonaModel->getKey(), 
					'nombreRuta' => 'Todas' ]);
		}else{ 
			return redirect('/');
		}	
	}
	/*
	* Api....
	*/	
	
	protected function monitoreoUsuario($empresa,$sucursal,$modo,$vendedor){ 
		$guia = null;
		$ruta = "all";
		
		if($modo == "autoventa"){
			$ruta = null;
			$metodo = 'obtenerResumenVentasAutoventa';
		}else if($modo == "despacho"){
			$metodo = 'obtenerResumenVentasDespacho';
		}else if($modo == "preventa" || $modo == "preventaEnLinea"){
			$metodo = 'obtenerResumenVentasPreventa';
			$ruta = null;
		}else{ 
			dd("Información incompleta o errónea");
		}	
		
		if($ruta == null){			
			$getRuta = DB::table('RutasxPersona')->where('idEmpresa', $empresa)->where(DB::raw('rtrim(idSucursal)'), $sucursal)->where('idPersona', $vendedor)->first();
			if($getRuta){
				$ruta = $getRuta->idRuta;
			}
			
		}		
		
		if($ruta != null){					
			$getZona= DB::table('ruta')->where('idEmpresa', $empresa)->where(DB::raw('rtrim(idSucursal)'), $sucursal)->where('idRuta', $ruta)->first();
			$getVendedor= DB::table('vendedor')->where('idEmpresa', $empresa)->where(DB::raw('rtrim(idSucursal)'), $sucursal)->where('idVendedor', $vendedor)->first();
			
			$zona = $getZona->idZona;			
			$vendedorModel = Persona::where('idPersona', $vendedor )
									->where('idEmpresa', $empresa )
									->where('idSucursal', $sucursal )
									->first(); 
								
			if($modo == "preventa"){
				$guia = "preventa";
			}else{
				
				$getGuia = DB::table('Guia')->where('idEmpresa', $empresa)->where(DB::raw('rtrim(idSucursal)'), $sucursal)->where('idAlmacen', $getVendedor->idAlmacen )->where('estado', 'O')->first();
				if($getGuia){
					$guia =  $getGuia->numeroGuia;
				}
			}		
			
			if($ruta && $zona && $guia){
				$fecha = Configuracion::getSetting($empresa, $sucursal) ;
				$getSupervisor = DB::table('Web_ZonasxUsuario')->where('idEmpresa', $empresa)->where(DB::raw('rtrim(idSucursal)'), $sucursal)->where('idZona ', $zona )->first();
				if($getSupervisor ){
					$super = $getSupervisor->idUsuario ;
				}else{
					dd("No se encontró algún Supervisor asignado");
				}
				
				return view('frontend.monitoreoMapaUser', [ 	'empresa' => $empresa, 
																'sucursal' => $sucursal,
																'super' => $super,
																'zona' => $zona, 
																'ruta' => $ruta,	
																'fecha' => $fecha,
																'nombreVendedor' => rtrim($vendedorModel->nombre ), 
																'metodo' => $metodo, 
																'guia' => $guia, 
																'vendedor' => $vendedor, 
																'nombreZona' => 'ZONA-'.$zona, 
																'nombreRuta' => "RUTA-".($ruta == "all"?  "Todos": $ruta)
														  ]);
			}else{
				dd("Información incompleta");
			}
		}else{
			dd("Información incompleta");
		}
			
	}
		
	protected function obtenerZonas(Request $request){
		$idEmpresa = Auth::user()->idEmpresa;
		$idSucursal = Auth::user()->idSucursal;
		$idPersona = Auth::user()->id;
		$lista = DB::select("exec web_obtenerZonasxPersona ?,?,?", [$idEmpresa, $idSucursal, $idPersona ]);
		return response()->json($lista);
	}

	protected function obtenerUnidadMedida(Request $request){
		$idEmpresa = Auth::user()->idEmpresa;
		//$idSucursal = Auth::user()->idSucursal;
		//$idPersona = Auth::user()->id;
		$lista = DB::select("exec web_obtenerUnidadMedidaxEmpresa ?", [$idEmpresa]);
		return response()->json($lista);
	}

	protected function obtenerSucursalesEmpresa(Request $request){
		$idEmpresa = $request->input('empresa');		
		$lista = Sucursal::where('idEmpresa', $idEmpresa)->orderBy('nombre', 'ASC')->get();
		return response()->json($lista);
	}
	
	protected function obtenerGeocercas(Request $request){
		if(Auth::user()){
			$idEmpresa = Auth::user()->idEmpresa;
			$idSucursal = Auth::user()->idSucursal;
		}else{
			$idEmpresa = $request->input('empresa');
			$idSucursal = $request->input('sucursal');
		}
		
		$idZona = $request->input('zona');
		$idRuta = $request->input('ruta');
		
		$lista = DB::select("exec web_obtener_geocerca ?,?,?,?", [$idEmpresa, $idSucursal, $idZona, $idRuta ]);
		return response()->json($lista);
	}
	
	protected function obtenerFecha(Request $request){
		$idEmpresa = Auth::user()->idEmpresa;
		$idSucursal = Auth::user()->idSucursal;
		$fecha = Configuracion::getSetting($idEmpresa, $idSucursal);
		return response()->json( $fecha );
	}
	
	protected function obtenerRutas(Request $request){
		$idEmpresa = Auth::user()->idEmpresa;
		$idSucursal = Auth::user()->idSucursal;
		$idZona = $request->input('zona');
		$idPersona = Auth::user()->id;
		$lista = DB::select("exec web_obtenerRutasxZona ?,?,?,?", [$idEmpresa, $idSucursal, $idZona, $idPersona  ]);
		return response()->json($lista);
	}
	
	protected function obtenerVendedores(Request $request){
		$idEmpresa = Auth::user()->idEmpresa;
		$idSucursal = Auth::user()->idSucursal;
		$idZona = 'all';
		if($request->input('zona')){
			$idZona = $request->input('zona');
		}
		$idRuta = 'all';
		if($request->input('ruta')){
			$idRuta = $request->input('ruta');
		}
		$idPersona = Auth::user()->id;
		$lista = DB::select("exec web_obtenerVendedores ?,?,?,?,?", [$idEmpresa, $idSucursal, $idZona, $idRuta, $idPersona ]);
		return response()->json($lista); 
	}
	
	protected function obtenerDatosCliente(Request $request){ 
		if(Auth::user()){
			$idEmpresa = Auth::user()->idEmpresa;
			$idSucursal = Auth::user()->idSucursal;
			$idSupervisor = Auth::user()->id;			
		}else{
			$idEmpresa = $request->input('empresa');
			$idSucursal = $request->input('sucursal');
			$idSupervisor =  $request->input('supervisor');
		}
		
		$idZona = $request->input('zona'); 
		$idRuta = $request->input('ruta'); 
		$idVendedor = $request->input('vendedor');
	
		$lista = DB::select("exec web_obtenerClientesGeolocalizados ?,?,?,?,?,?", [$idEmpresa, $idSucursal, $idZona, $idRuta, $idVendedor, $idSupervisor ]);
		return response()->json($lista);
	}
	
	protected function obtenerDetallePedido(Request $request){ 
		
		if(Auth::user()){
			$idEmpresa = Auth::user()->idEmpresa;
			$idSucursal = Auth::user()->idSucursal;		
		}else{
			$idEmpresa = $request->input('empresa');
			$idSucursal = $request->input('sucursal');
		}
		
		$numeroPedido = $request->input('pedido'); 
		$fecha = $request->input('fecha'); 
		$cliente = $request->input('cliente'); 
		$lista = DB::select("exec web_obtenerDetallePedido ?,?,?,?,?", [$idEmpresa, $idSucursal, $numeroPedido , $fecha, $cliente ]);
		return  response()->json($lista);
	}
	
	protected function obtenerPosicionesPedido(Request $request){ 
		if(Auth::user()){
			$idEmpresa = Auth::user()->idEmpresa;
			$idSucursal = Auth::user()->idSucursal;
			$idSupervisor = Auth::user()->id;			
		}else{
			$idEmpresa = $request->input('empresa');
			$idSucursal = $request->input('sucursal');
			$idSupervisor =  $request->input('supervisor');
		}
		
		$idZona = $request->input('zona'); 
		$idRuta = $request->input('ruta'); 
		$fecha = $request->input('fecha');
		$idVendedor = $request->input('vendedor');
		$numeroGuia = $request->input('guia'); 
		$lista = DB::select("exec web_obtenerPedidosGeolocalizados ?,?,?,?,?,?,?,?", [$idEmpresa, $idSucursal, $idZona, $idRuta, $fecha, $idVendedor, $idSupervisor , $numeroGuia]);
		return  response()->json($lista);
	}
	/*
	protected function obtenerDatosCliente(Request $request){ 
		$idEmpresa = Auth::user()->idEmpresa;
		$idSucursal = Auth::user()->idSucursal;
		$idZona = $request->input('zona'); 
		$idRuta = $request->input('ruta'); 
		$idVendedor = $request->input('vendedor');
		$idSupervisor = Auth::user()->id;
		$lista = DB::select("exec web_obtenerClientesGeolocalizados ?,?,?,?,?,?", [$idEmpresa, $idSucursal, $idZona, $idRuta, $idVendedor, $idSupervisor ]);
		return response()->json($lista);
	}
	
	protected function obtenerDetallePedido(Request $request){ 
		$idEmpresa = Auth::user()->idEmpresa;
		$idSucursal = Auth::user()->idSucursal;
		$numeroPedido = $request->input('pedido'); 
		$fecha = $request->input('fecha'); 
		$cliente = $request->input('cliente'); 
		$lista = DB::select("exec web_obtenerDetallePedido ?,?,?,?,?", [$idEmpresa, $idSucursal, $numeroPedido , $fecha, $cliente ]);
		return  response()->json($lista);
	}
	
	protected function obtenerPosicionesPedido(Request $request){ 
		$idEmpresa = Auth::user()->idEmpresa;
		$idSucursal = Auth::user()->idSucursal;
		$idZona = $request->input('zona'); 
		$idRuta = $request->input('ruta'); 
		$fecha = $request->input('fecha');
		$idVendedor = $request->input('vendedor');
		$numeroGuia = $request->input('guia'); 
		$idSupervisor = Auth::user()->id;
		$lista = DB::select("exec web_obtenerPedidosGeolocalizados ?,?,?,?,?,?,?,?", [$idEmpresa, $idSucursal, $idZona, $idRuta, $fecha, $idVendedor, $idSupervisor , $numeroGuia]);
		return  response()->json($lista);
	}
*/
	/*
     * Admin
    */
    protected function obtenerZonasxUsuario(Request $request){
        $idEmpresa = $request->input('empresa');
        $idSucursal = $request->input('sucursal');
        $zonas = Zona::libres( $idEmpresa, $idSucursal);

        if($request->has('usuario')){
            $id = intval($request->input('usuario'));
            $usuario = Usuario::where( "idUsuario", $id )->where("idEmpresa",$idEmpresa)->where("idSucursal",$idSucursal)->first();
            if($usuario){
                $zonasUsuario =  Zona::porUsuario( $idEmpresa, $idSucursal, $usuario->idUsuario);
                $array = array_merge($zonasUsuario->toArray(), $zonas->toArray());
                return response()->json( $array );
            }
        }
        return response()->json( $zonas->toArray() );
    }
}