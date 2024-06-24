<?php

namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Models\Persona;
use Response;
use DB;

class ReporteCampeonatoController extends Controller
{
    protected function muestraCampeonato(){
    	$idEmpresa = Auth::user()->idEmpresa;
		$idSucursal = Auth::user()->idSucursal;

        session(['active' => 'campeonato']);
        //$vendedores = DB::select("exec web_obtenerImporteVentaxEmpresaySucursal ?,?", [$idEmpresa,$idSucursal]);
        $anio_actual=date('Y');
        $mes_actual=date('m');
        $dia_hoy=date('d');
        $dias_total_mes=cal_days_in_month(CAL_GREGORIAN,$mes_actual,$anio_actual);
        $dias_restantes_para_finalizarmes=$dias_total_mes-$dia_hoy;

        //$dias_restantes_para_finalizarmes=31;
        return view('frontend.rpt_campeonato',compact('dias_restantes_para_finalizarmes'));//,['sucursal' => $list ]
    }


	protected function obtenerImporteVenta(Request $request)
    {
    	$idEmpresa = Auth::user()->idEmpresa;
		$idSucursal = Auth::user()->idSucursal;
		$anio='2019';
		$mes='07';
		$itemDefecto = array( "vendedor" => null ) ;
		try{
			$lista = DB::select("exec [Ventas360App].[dbo].web_obtenerAvanceVentas ?,?,?,?", [$idEmpresa,$idSucursal,$anio,$mes]);
			if( sizeof($lista) > 0){
				$item = $lista[0];
				if($item->vendedor == null){
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

    
}
