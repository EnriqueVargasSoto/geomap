<?php

namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Models\Persona;
use Response;
use DB;
class MaestrosController extends Controller
{
    protected function index(){
    	session(['active' => 'maestros']);
        return view('frontend.maestros.lista_precio');//,['sucursal' => $list ]
    }


    protected function obtenerListaPrecio(Request $request){
    	$idEmpresa=Auth::user()->idEmpresa;
		/*try{
			$lista = DB::select("exec [BDDATA].[dbo].[web_getListaPrecio] ?", [$idEmpresa]);
		}catch(QueryException $ex){
			return $ex->getMessage();
		}*/
		/*$itemDefecto = array( "ARTICULO" => null ) ;
		try{
			$lista = DB::select("exec [BDDATA].[dbo].[web_getListaPrecio] ?", [$idEmpresa]);
			if( sizeof($lista) > 0){
				$item = $lista[0];
				if($item->ARTICULO == null){
					return  response()->json( $item );
				}else{
					return  response()->json( $lista );
				}
			}else {
				return  response()->json( $itemDefecto );
			}
		}catch(QueryException $ex){
			return $ex->getMessage();
		}*/
		$lista = DB::select("exec [BDDATA].[dbo].[web_getListaPrecio] ?", [$idEmpresa]);
		return  response()->json( $lista );
    }

    protected function obtenerBonificacion(Request $request)
    {
    	$fechaInicio = $request->input('fechaInicio');
    	//$fechaFin = $request->input('fechaFin');

    	$mes='';
    	$anio='';

    	if($fechaInicio){
    		$mes=substr($fechaInicio, 0,2);
    		$anio=substr($fechaInicio,3, 6);
    	}
    	//return 'mes '.$mes.'anio '.$anio;
    	$idEmpresa=Auth::user()->idEmpresa;

		$itemDefecto = array( "IDPROMOCION" => null ) ;
		try{
			$lista = DB::select("exec [BDDATA].[dbo].[web_getBonificacion] ?,?,?", [$idEmpresa,$mes,$anio]);
			if( sizeof($lista) > 0){
				$item = $lista[0];
				if($item->IDPROMOCION == null){
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
    
    protected function obtenerGrupos(Request $request)
    {
    	$idEmpresa=Auth::user()->idEmpresa;

		$itemDefecto = array( "IDGRUPO" => null ) ;
		try{
			$lista = DB::select("exec [BDDATA].[dbo].[web_getgrupos] ?", [$idEmpresa]);
			if( sizeof($lista) > 0){
				$item = $lista[0];
				if($item->IDGRUPO == null){
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

    protected function getDetailGroup(Request $request)
    {
    	
    	$idEmpresa=Auth::user()->idEmpresa;
    	$idGrupo= $request->id_grupo;
		$itemDefecto = array( "IDGRUPO" => null ) ;
		try{
			$lista = DB::select("exec [BDDATA].[dbo].[web_get_detail_grupo] ?,?", [$idEmpresa,$idGrupo]);
			if( sizeof($lista) > 0){
				$item = $lista[0];
				if($item->IDGRUPO == null){
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
