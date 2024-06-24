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
class PanelCentralController extends Controller
{
    protected function index(){
        session(['active' => 'panelcentral']);
        return view('frontend.panelcentral');
    }
	
    /*
    * Api....
    */
    protected function obtenerResumenPanel(Request $request){
        $idEmpresa = Auth::user()->idEmpresa;
		$idSucursal = Auth::user()->idSucursal;
		$idSupervisor = Auth::user()->id;
        $idRuta = $request->input('ruta');
        $idZona = $request->input('zona');
        $fecha = $request->input('fecha');		
		$operacion = $request->input('operacion');		
		
		$itemDefecto = array( "vendedorx" => null ) ;
		try{
			$lista = DB::select("exec web_obtenerPanelCentral ?,?,?,?,?,?,?", [$idEmpresa, $idSucursal, $idRuta , $idZona, $fecha, $operacion, $idSupervisor]);
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
	
	protected function actualizarEstados(Request $request){
		$idEmpresa = Auth::user()->idEmpresa;
		$idSucursal = Auth::user()->idSucursal;
		$idVendedor = $request->input('vendedor');
		
		DB::statement ("exec web_abrirCerrarDia ?,?,?", [$idEmpresa, $idSucursal, $idVendedor]);
		return  response()->json( array( "vendedor" => $idVendedor ) );
	}
	
	protected function actualizarEstadoMasivo(Request $request){
		$idEmpresa = Auth::user()->idEmpresa;
		$idSucursal = Auth::user()->idSucursal;
		$listaVendedores = $request->input('listaVendedores');
		
		DB::statement ("exec web_abrirCerrarDiaLista ?,?,?", [$idEmpresa, $idSucursal, $listaVendedores]);
		return  response()->json( array( "vendedor" => "ok" ) );
	}
}