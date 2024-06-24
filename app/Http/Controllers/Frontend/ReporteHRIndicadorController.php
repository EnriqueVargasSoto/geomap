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
use App\Models\Fectranscurridos;
use Response;
use DB;
class ReporteHRIndicadorController  extends Controller
{
	protected function verReportexVendedor(){
        session(['active' => 'hrindicadorxvendedor']);
		$modelo = Fectranscurridos::first();
		$diasLaborados = $modelo->Diatrans;
		$diasLaborables = $modelo->DiaLaboral;
        return view('frontend.hrindicadorxvendedor', [ "diasLaborados" => $diasLaborados, "diasLaborables" => $diasLaborables]);
    }
	
	 /*
     * Api....
    */ 
	protected function obtenerIndicadorxVendedor(Request $request){
        $idEmpresa = Auth::user()->idEmpresa;
		$idSucursal = Auth::user()->idSucursal;
		$idVendedor = $request->input('vendedor');
		$formato = $request->input('formato');
		if($formato == "soles"){
			$lista = DB::select("exec web_obtenerHRIndicadorSolesxVendedor ?,?,?", [$idVendedor, $idEmpresa, $idSucursal ]);
		}else{
			$lista = DB::select("exec web_obtenerHRIndicadorPaquetesxVendedor ?,?,?", [$idVendedor, $idEmpresa, $idSucursal ]);
		}
		
		return response()->json($lista);		
    }
	
	protected function obtenerIndicadorxSucursal(Request $request){
        $idEmpresa = Auth::user()->idEmpresa;
		$idSucursal = Auth::user()->idSucursal;
		
		$formato = $request->input('formato');
		if($formato == "soles"){
			$lista = DB::select("exec web_obtenerHRMarcaSolesxSucursal  ?,?", [ $idEmpresa, $idSucursal ]);
		}else{
			$lista = DB::select("exec web_obtenerHRMarcaPaquetesxSucursal ?,?", [ $idEmpresa, $idSucursal ]);
		}
		
		return response()->json( $lista );		
    }
	
	protected function obtenerHRMarcaxCliente(Request $request){
        $idEmpresa = Auth::user()->idEmpresa;
		$idSucursal = Auth::user()->idSucursal;
		$idCliente = $request->input('cliente');
		
		$lista = DB::select("exec web_obtenerHRMarcaxCliente ?,?,?", [$idCliente, $idEmpresa, $idSucursal ]);
		return response()->json($lista);		
    }
	
}