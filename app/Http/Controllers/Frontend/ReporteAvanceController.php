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
use App\Models\Marca;
use Response;
use DB;
class ReporteAvanceController  extends Controller
{
    protected function verAvancexMarca(){
        session(['active' => 'avancexmarca']);
		$listaMarcas = Marca::where('idEmpresa', Auth::user()->idEmpresa)->orderBy('descripcion')->get();
        return view('frontend.avancexmarca', ['marcas' => $listaMarcas] );
    }
	
	protected function verAvancexCuota(){
        session(['active' => 'avancexcuota']);
        return view('frontend.avancexcuota');
    }
		
    /*
     * Api....
    */ 
	protected function  obtenerAvanceVentaxMarca(Request $request){
		$idEmpresa = Auth::user()->idEmpresa;
		$idSucursal = Auth::user()->idSucursal;	
		$desde = $request->input('fechaDesde');
		$hasta = $request->input('fechaHasta');
		
		if(strlen( $request->input('timeDesde')) > 2 && strlen( $desde ) > 2){
			$hora = strtotime(  strtolower( $request->input('timeDesde') ) );
			$desde = $desde.' '.date("H:i", $hora);	
		}
		if(strlen( $request->input('timeHasta')) > 2 && strlen( $hasta ) > 2){
			$hora = strtotime(  strtolower( $request->input('timeHasta') ) );
			$hasta = $hasta.' '.date("H:i", $hora);		
		}
				
		$lista = DB::select("exec web_reporteAvanceVentaxMarca  ?,?,?,?", [$idEmpresa, $idSucursal, $desde, $hasta ]);
		return response()->json($lista);
	}
	
	protected function  obtenerAvancexCuota(Request $request){
		$idEmpresa = Auth::user()->idEmpresa;
		$idSucursal = Auth::user()->idSucursal;	
		$desde = $request->input('fechaDesde');
		$hasta = $request->input('fechaHasta');
		$supervisor = Auth::user()->id;
		
		if(strlen( $request->input('timeDesde')) > 2 && strlen( $desde ) > 2){
			$hora = strtotime(  strtolower( $request->input('timeDesde') ) );
			$desde = $desde.' '.date("H:i", $hora);	
		}
		if(strlen( $request->input('timeHasta')) > 2 && strlen( $hasta ) > 2){
			$hora = strtotime(  strtolower( $request->input('timeHasta') ) );
			$hasta = $hasta.' '.date("H:i", $hora);		
		}
				
		$lista = DB::select("exec web_reporteAvanceCuota  ?,?,?,?,?", [$idEmpresa, $idSucursal, $desde, $hasta, $supervisor ]);
		return response()->json($lista);
	}		

	protected function obtenerAvanceCuotaxSucursal(Request $request){
		$idEmpresa = Auth::user()->idEmpresa;
		$idSucursal = Auth::user()->idSucursal;	
		
		if(  $request->input('formato') == "paquete"){
			$lista = DB::select("exec web_obtenerHRCuotaPaquetesxSucursal  ?,?", [$idEmpresa, $idSucursal]);
		}else{
			$lista = DB::select("exec web_obtenerHRCuotaSolesxSucursal  ?,?", [$idEmpresa, $idSucursal]);
		}
		
		return response()->json($lista);
	}
	
}