<?php
/**
 * Created by ExpedioDigital.
 * User: Monica Toribio Rojas
 * Date: 13/11/2017
 * Time: 22:52
 */
namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Models\Persona;
use Response;
use DB;
class MonitoreoController extends Controller
{
    protected function index(){
        session(['active' => 'vendedores']);
        return view('frontend.monitoreo');//,['sucursal' => $list ]
    }
		
	protected function verDetalle(Request $request){
		$monitoreoVendedor = $request->input('monitoreoVendedor');
		$monitoreoZona = $request->input('monitoreoZona');
		$monitoreoRuta = $request->input('monitoreoRuta');
		$monitoreoGuia = $request->input('monitoreoGuia');
		$monitoreoModo = $request->input('monitoreoModo');
		$nombreVendedor	= $request->input('monitoreoNombre');
		$clientesProgramados = $request->input('monitoreoClienteProg');
        session(['active' => 'vendedores']);
        return view('frontend.monitoreoDetalle')->with('vendedor',$monitoreoVendedor)
												->with('zona',$monitoreoZona)
												->with('ruta',$monitoreoRuta)
												->with('guia',$monitoreoGuia) 
												->with('modo',$monitoreoModo)
												->with('nombreVendedor',$nombreVendedor)
												->with('clientesProgramados',$clientesProgramados); 
		
		//,[ 'vendedor ' => $monitoreoVendedor, 'zona' => $monitoreoZona, 'ruta' => $monitoreoRuta, 'guia' => $monitoreoGuia, 'modo' => $monitoreoModo, ]);
	}
	
    /*
     * Api....
    */ 
	protected function obtenerResumenMarcaAjax(Request $request){
        $idEmpresa = Auth::user()->idEmpresa;
		$idSucursal = Auth::user()->idSucursal;
		$idVendedor = $request->input('vendedor');
		
		$lista = DB::select("exec web_obtenerResumenVentasxMarca  ?,?,?", [$idEmpresa, $idSucursal, $idVendedor ]);
		return response()->json($lista);		
    }
	
	
    protected function obtenerResumenVentasAutoventa(Request $request){
		if(Auth::user()){
			$idEmpresa = Auth::user()->idEmpresa;
			$idSucursal = Auth::user()->idSucursal;
			$idSupervisor = Auth::user()->id;			
		}else{
			$idEmpresa = $request->input('empresa');
			$idSucursal = $request->input('sucursal');
			$idSupervisor =  $request->input('supervisor');
		}
		      
        $idRuta = $request->input('ruta');
        $idZona = $request->input('zona');
        $fecha = $request->input('fecha');
		$idVendedor = $request->input('vendedor');
		$itemDefecto = array( "vendedorx" => null ) ;
		
		try{
			$lista = DB::select("exec web_obtenerResumenVentasAutoventa ?,?,?,?,?,?,?", [$idEmpresa, $idSucursal, $idRuta , $idZona, $fecha , $idSupervisor, $idVendedor ]);
			if( sizeof($lista) > 0){
				$item = $lista[0];
				if($item->vendedorx == null){
					return  response()->json( $item );
				}else{
					return  response()->json( $lista );
				}
			}else {
				return  response()->json( $itemDefecto );
			}
		}catch(QueryException $ex){
			return $ex->getMessage();
		}
    }

	protected function obtenerResumenVentasPreventa(Request $request){
		if(Auth::user()){
			$idEmpresa = Auth::user()->idEmpresa;
			$idSucursal = Auth::user()->idSucursal;
			$idSupervisor = Auth::user()->id;			
		}else{
			$idEmpresa = $request->input('empresa');
			$idSucursal = $request->input('sucursal');
			$idSupervisor =  $request->input('supervisor');
		}
       
        $idRuta = $request->input('ruta');
        $idZona = $request->input('zona');
        $fecha = $request->input('fecha');
		$idVendedor = $request->input('vendedor');
		$itemDefecto = array( "vendedorx" => null ) ;
		//$unidadMedida=$request->input('unidad_medida');
		$kg=$request->input('kg');
		
		/*if($kg==NULL)
		{
			$kg=0;
		}
		else{
			$kg=1;
		}*/

		//return $kg;

		try{
			$lista = DB::select("exec web_obtenerResumenVentasPreventa ?,?,?,?,?,?,?,?", [$idEmpresa, $idSucursal, $idRuta , $idZona, $fecha , $idSupervisor, $idVendedor,$kg ]);
			
			if( sizeof($lista) > 0){
				$item = $lista[0];
				if($item->vendedorx == null){
					return  response()->json( $item );
				}else{
					return  response()->json( $lista );
				}
			}else {
				return  response()->json( $itemDefecto );
			}
		}catch(QueryException $ex){
			return $ex->getMessage();
		}
    }
	
	protected function obtenerResumenVentasDespacho(Request $request){
        $idEmpresa = Auth::user()->idEmpresa;
		$idSucursal = Auth::user()->idSucursal;
		$idSupervisor = Auth::user()->id;
        $idRuta = $request->input('ruta');
        $idZona = $request->input('zona');
        $fecha = $request->input('fecha');
		$idVendedor = $request->input('vendedor');
		$itemDefecto = array( "vendedorx" => null ) ;
		
		try{
			$lista = DB::select("exec web_obtenerResumenVentasDespacho ?,?,?,?,?,?,?", [$idEmpresa, $idSucursal, $idRuta , $idZona, $fecha , $idSupervisor, $idVendedor ]);
			if( sizeof($lista) > 0){
				$item = $lista[0];
				if($item->vendedorx == null){
					return  response()->json( $item );
				}else{
					return  response()->json( $lista );
				}
			}else {
				return  response()->json( $itemDefecto );
			}
		}catch(QueryException $ex){
			return $ex->getMessage();
		}
    }
	
    protected function obtenerVendedores(Request $request){
        $idEmpresa = Auth::user()->idEmpresa;
        $idSucursal = $request->input('sucursal');
        $lista = Persona::vendedoresPorSucursal($idEmpresa,$idSucursal);
        return response()->json($lista);
    }

    protected function obtenerZonas (Request $request){
        $idEmpresa = Auth::user()->idEmpresa;
        $idSucursal = $request->input('sucursal');
        $idRuta = $request->input('ruta');
    }

    protected function obtenerClientesxVendedor (Request $request){
        $idEmpresa = Auth::user()->idEmpresa;
		$idSucursal = Auth::user()->idSucursal;
        $idRuta = $request->input('ruta');
        $idZona = $request->input('zona'); 
		$idVendedor = $request->input('vendedor'); 
		$idSupervisor = Auth::user()->id;
        $lista = DB::select("exec web_obtenerClientesxVendedor ?,?,?,?,?,?", [$idEmpresa, $idSucursal, $idZona, $idRuta , $idVendedor, $idSupervisor ]);
        return  response()->json( $lista );
    }

	protected function obtenerVistaxSegmento (Request $request){
        $idEmpresa = Auth::user()->idEmpresa;
		$idSucursal = Auth::user()->idSucursal;
        $idRuta = $request->input('ruta');
        $idZona = $request->input('zona'); 
		$idVendedor = $request->input('vendedor'); 
		$idSupervisor = Auth::user()->id;
		
        $lista = DB::select("exec web_obtenerSegmentosxVendedor ?,?,?,?,?,?", [$idEmpresa, $idSucursal, $idZona, $idRuta , $idVendedor, $idSupervisor ]);
        return  response()->json( $lista );
    }
	
    protected function obtenerPedidosxVendedor (Request $request){
        $idEmpresa = Auth::user()->idEmpresa;
        $idSucursal = Auth::user()->idSucursal;
        $idRuta = $request->input('ruta');
        $idZona = $request->input('zona');
        $fecha = $request->input('fecha');
        $idVendedor = $request->input('vendedor');
		$guia = $request->input('guia');
		$idSupervisor = Auth::user()->id;
	 
        $lista = DB::select("exec web_obtenerPedidosxVendedor ?,?,?,?,?,?,?,?", [$idEmpresa, $idSucursal, $idRuta , $idZona, $fecha, $idVendedor, $idSupervisor, $guia ]);
        $itemDefecto = array( "cliente" => null ) ;
		if( sizeof($lista) > 0){
			$item = $lista[0];
			if($item->cliente == null){
				return  response()->json( $item );
			}else{
				return  response()->json( $lista );
			}
		}else {
			return  response()->json( $itemDefecto );
		}			
    }

    protected function obtenerDetalleExtendidoPedido(Request $request){
        $idEmpresa = Auth::user()->idEmpresa;
        $idSucursal = Auth::user()->idSucursal;
        $numeroPedido = $request->input('numeroPedido');
		$idVendedor = $request->input('vendedor');
        $fecha = $request->input('fecha');
		$guia = $request->input('guia');
		
        $lista = DB::select("exec web_obtenerDetalleExtendidoPedido ?,?,?,?,?,?", [$idEmpresa, $idSucursal, $numeroPedido , $fecha , $idVendedor, $guia ]);
        return  response()->json( $lista );
    }
}