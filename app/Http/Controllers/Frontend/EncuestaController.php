<?php

/**
 * Created by ExpedioDigital.
 * User: Monica Toribio Rojas
 * Date: 9/02/2018
 * Time: 05:48
 */

namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Controller;
use App\Http\Requests\Ajax\AjaxNuevaEncuestaRequest;
use App\Http\Requests\Frontend\NuevaEncuestaRequest;
use App\Http\Requests\Frontend\NuevoDetalleEncuestaRequest;
use App\Models\CanalVentas;
use App\Models\Encuesta;
use App\Models\EncuestaDetalle;
use App\Models\EncuestaDetallexCargo;
use App\Models\EncuestaDetallexCliente;
use App\Models\EncuestaDetallexSegmento;
use App\Models\EncuestaDetallexVendedor;
use App\Models\Giro;
use App\Models\SubGiro;
use Illuminate\Http\Request;
use Auth;
use DB;
use Symfony\Component\HttpKernel\Client;

class EncuestaController extends Controller
{
    protected function index(){
        $encuesta = session('codigo', 'x') ;

        session(['codigo' => 'x']);
        session(['active' => 'encuesta', 'hijo' => 'lista']);
        return view('frontend.listaEncuesta')->with("encuesta", $encuesta);
    }
	
	protected function obtenerDetalleEncuestaPrePost(Request $request){ 
		if(Auth::user()){
			$idEmpresa = Auth::user()->idEmpresa;
			$idSucursal = Auth::user()->idSucursal;		
		}else{
			$idEmpresa = $request->input('empresa');
			$idSucursal = $request->input('sucursal');
		}
		
		$numeroPedido = $request->input('pedido');  
		$cliente = $request->input('cliente'); 
		
		$lista = DB::select("exec web_obtenerDetalleEncuestaPrePost ?,?,?,?", [$idEmpresa, $idSucursal, $numeroPedido , $cliente ]);
		return  response()->json($lista);
	}
	
	protected function obtenerDetalleEncuestaTrade(Request $request){ 
		if(Auth::user()){
			$idEmpresa = Auth::user()->idEmpresa;
			$idSucursal = Auth::user()->idSucursal;		
		}else{
			$idEmpresa = $request->input('empresa');
			$idSucursal = $request->input('sucursal');
		}
		
		$numeroPedido = $request->input('pedido');  
		$cliente = $request->input('cliente'); 
		
		$lista = DB::select("exec web_obtenerDetalleEncuestaTrade ?,?,?,?", [$idEmpresa, $idSucursal, $numeroPedido , $cliente ]);
		return  response()->json($lista);
	}

    protected function nuevoDetalleEncuesta($id){
        session(['active' => 'encuesta']);
        $encuesta = Encuesta::where('idEncuesta',$id)->where( 'idEmpresa','=', Auth::user()->idEmpresa )->where( 'idSucursal','=',Auth::user()->idSucursal )->first();
        return view('frontend.nuevoDetalleEncuesta',['encuesta' =>  $encuesta ]);
    }

    protected function verDetalleEncuesta($idEncuesta, $id){
        session(['active' => 'encuesta']);
        $encuesta = Encuesta::where('idEncuesta',$idEncuesta)->where( 'idEmpresa', Auth::user()->idEmpresa )->where( 'idSucursal',Auth::user()->idSucursal )->first();
        $detalleEncuesta = EncuestaDetalle::where('idEncuesta',$idEncuesta)->where( 'idEncuestaDetalle', $id)->where( 'idEmpresa', Auth::user()->idEmpresa )->where( 'idSucursal',Auth::user()->idSucursal )->first();

        if($encuesta && $detalleEncuesta){
            return view('frontend.editarDetalleEncuesta',['encuesta' =>  $encuesta, 'detalleEncuesta' =>  $detalleEncuesta ]);
        }else{
            flash('')->error( 'La encuesta seleccionada no existe.');
            return redirect(url('encuesta'));
        }
    }

    protected function postEditarDetalleEncuesta ($idEncuesta, $id, NuevoDetalleEncuestaRequest $request){
        $encuesta = Encuesta::where('idEncuesta',$idEncuesta)->where( 'idEmpresa', Auth::user()->idEmpresa )->where( 'idSucursal',Auth::user()->idSucursal )->first();
        $detalleEncuesta = EncuestaDetalle::where('idEncuesta',$idEncuesta)->where( 'idEncuestaDetalle', $id)->where( 'idEmpresa', Auth::user()->idEmpresa )->where( 'idSucursal',Auth::user()->idSucursal )->first();

        if($encuesta && $detalleEncuesta){
            $this->guardarDetalleFiltrosEncuesta($request, $encuesta->getKey(),$detalleEncuesta);
            flash('')->success( 'La encuesta seleccionada ha sido modificada');
        }else{
            flash('')->error( 'La encuesta seleccionada no existe.');
        }
        return redirect(url('encuesta'));
    }

    protected function guardarNuevoDetalleEncuesta ($id, NuevoDetalleEncuestaRequest $request){

        $encuesta = Encuesta::where('idEncuesta',$id)->where('idEmpresa', Auth::user()->idEmpresa)->where('idSucursal',Auth::user()->idSucursal)->first();
        if($encuesta){
            $nuevoDetalle = new EncuestaDetalle();
            $this->guardarDetalleFiltrosEncuesta($request, $id, $nuevoDetalle);
            flash('')->success( 'Se añadio la nueva vigencia a la encuesta : '.$encuesta->descripcion);
        }else{
            flash('')->error( 'La encuesta seleccionada no existe.');
        }

        return redirect(url('encuesta'));
    }

    function guardarDetalleFiltrosEncuesta($request, $id, $detalleEncuesta){
        if($request->has('ocasionConsumo')){
            $listaOcasionConsumo = $this->obtenerCadena( $request->input('ocasionConsumo'));
            $detalleEncuesta->filtroOcasion = $listaOcasionConsumo;
        }else{
            $detalleEncuesta->filtroOcasion = 0;
        }

        if($request->has('canalVentas')){
            $listaCanalVentas = $this->obtenerCadena( $request->input('canalVentas'));
            $detalleEncuesta->filtroCanalVentas = $listaCanalVentas;
        }else{
            $detalleEncuesta->filtroCanalVentas = 0;
        }

        if($request->has('giro')){
            $listaGiro = $this->obtenerCadena( $request->input('giro'));
            $detalleEncuesta->filtroGiro = $listaGiro;
        }else{
            $detalleEncuesta->filtroGiro = 0;
        }

        if($request->has('subGiro')){
            $listaGiro = $this->obtenerCadena( $request->input('subGiro'));
            $detalleEncuesta->filtroSubGiro = $listaGiro;
        }else{
            $detalleEncuesta->filtroSubGiro = 0;
        }

        if(!isset( $detalleEncuesta->idEncuestaDetalle )){
            $detalleEncuesta->idEmpresa =  Auth::user()->idEmpresa;
            $detalleEncuesta->idSucursal =  Auth::user()->idSucursal;
            $detalleEncuesta->idEncuesta = $id;
        }

        $detalleEncuesta->fechaInicio = $request->input('fechaDesde');
        $detalleEncuesta->fechaFin = $request->input('fechaHasta');
        $detalleEncuesta->clientesObligatorios = ($request->has('clienteObligatorio'))? $request->input('clienteObligatorio') : 0 ;
        $detalleEncuesta->clientesAnonimos = ($request->has('clienteAnonimo'))? $request->input('clienteAnonimo') : 0 ;
        $detalleEncuesta->encuestasMinimas = $request->input('encuestaMinima');
        $detalleEncuesta->fotosMinimas = $request->input('fotosMinimas');
        $detalleEncuesta->maximoIntentosCliente = $request->input('intentosEncuesta');
        $detalleEncuesta->estado = $request->input('estadoEncuesta');

        $detalleEncuesta->save();

        if($request->has('filtroVendedor_to')){
            if(isset( $detalleEncuesta->idEncuestaDetalle )){
                $filtrosAnteriores = EncuestaDetallexVendedor::where("idEmpresa",Auth::user()->idEmpresa)->where("idSucursal",Auth::user()->idSucursal)->where("idEncuesta",$id)
                                     ->where("idEncuestaDetalle",$detalleEncuesta->getKey());
                if($filtrosAnteriores->get()->count() > 0){
                    $filtrosAnteriores->delete();
                }
            }

            foreach($request->input('filtroVendedor_to') as $idVendedor){
                $nuevoFiltroVendedor = new EncuestaDetallexVendedor();
                $nuevoFiltroVendedor->idEmpresa = Auth::user()->idEmpresa;
                $nuevoFiltroVendedor->idSucursal = Auth::user()->idSucursal;
                $nuevoFiltroVendedor->idEncuesta = $id;
                $nuevoFiltroVendedor->idEncuestaDetalle = $detalleEncuesta->getKey();
                $nuevoFiltroVendedor->idVendedor = $idVendedor;
                $nuevoFiltroVendedor->save();
            }
        }

        if($request->has('filtroRoles_to')){
            if(isset( $detalleEncuesta->idEncuestaDetalle )){
                $filtrosAnteriores = EncuestaDetallexCargo::where("idEmpresa",Auth::user()->idEmpresa)->where("idSucursal",Auth::user()->idSucursal)->where("idEncuesta",$id)
                    ->where("idEncuestaDetalle",$detalleEncuesta->getKey());
                if($filtrosAnteriores->get()->count() > 0){
                    $filtrosAnteriores->delete();
                }
            }

            foreach($request->input('filtroRoles_to') as $cargo){
                $nuevoFiltroCargo = new EncuestaDetallexCargo();
                $nuevoFiltroCargo->idEmpresa = Auth::user()->idEmpresa;
                $nuevoFiltroCargo->idSucursal = Auth::user()->idSucursal;
                $nuevoFiltroCargo->idEncuesta = $id;
                $nuevoFiltroCargo->idEncuestaDetalle = $detalleEncuesta->getKey();
                $nuevoFiltroCargo->cargo = $cargo;
                $nuevoFiltroCargo->save();
            }
        }

        if($request->has('filtroSegmentos_to')){
            if(isset( $detalleEncuesta->idEncuestaDetalle)){
                $filtrosAnteriores = EncuestaDetallexSegmento::where("idEmpresa",Auth::user()->idEmpresa)->where("idSucursal",Auth::user()->idSucursal)->where("idEncuesta",$id)
                    ->where("idEncuestaDetalle",$detalleEncuesta->getKey());
                if($filtrosAnteriores->get()->count() > 0){
                    $filtrosAnteriores->delete();
                }
            }

            foreach($request->input('filtroSegmentos_to') as $segmento){
                $nuevoFiltroSegmento = new EncuestaDetallexSegmento();
                $nuevoFiltroSegmento->idEmpresa = Auth::user()->idEmpresa;
                $nuevoFiltroSegmento->idSucursal = Auth::user()->idSucursal;
                $nuevoFiltroSegmento->idEncuesta = $id;
                $nuevoFiltroSegmento->idEncuestaDetalle = $detalleEncuesta->getKey();
                $nuevoFiltroSegmento->idSegmentoCliente = $segmento;
                $nuevoFiltroSegmento->save();
            }
        }

        if($request->has('filtroClientes')){
            if(isset( $detalleEncuesta->idEncuestaDetalle )){
                $filtrosAnteriores = EncuestaDetallexCliente::where("idEmpresa",Auth::user()->idEmpresa)->where("idSucursal",Auth::user()->idSucursal)->where("idEncuesta",$id)
                                     ->where("idEncuestaDetalle",$detalleEncuesta->getKey());
                if($filtrosAnteriores->get()->count() > 0){
                    $filtrosAnteriores->delete();
                }
            }

            foreach($request->input('filtroClientes') as $cliente){
                $nuevoFiltroCliente = new EncuestaDetallexCliente();
                $nuevoFiltroCliente->idEmpresa = Auth::user()->idEmpresa;
                $nuevoFiltroCliente->idSucursal = Auth::user()->idSucursal;
                $nuevoFiltroCliente->idEncuesta = $id;
                $nuevoFiltroCliente->idEncuestaDetalle = $detalleEncuesta->getKey();
                $nuevoFiltroCliente->idCliente = $cliente;
                $nuevoFiltroCliente->save();
            }
        }
    }

    function obtenerCadena($lista){
        $cadena = "";
        foreach($lista as $item){
            $cadena .=  $item.",";
        }
        return  substr ($cadena, 0, -1);
    }

    protected function desactivarEncuesta(Request $request){
        $encuestaDetalle = EncuestaDetalle::where("idEmpresa",Auth::user()->idEmpresa)->where("idSucursal",Auth::user()->idSucursal)
            ->where("idEncuesta", $request->input('encuesta'))
            ->where("idEncuestaDetalle", $request->input('detalleEncuesta'))->first();

        if($encuestaDetalle){
            $encuestaDetalle->estado = ($request->input('estado') == "activar" ? 1 : 0 );
            $encuestaDetalle->save();

            flash('')->success( "Se actualizo el estado del detalle de la encuesta.");

        }else{
            flash('')->error( "No se encontro el detalle de la encuesta.");
        }

        session(['codigo' => $request->input('encuesta')]);
        return redirect(url('encuesta'));
    }

    protected function nuevaEncuesta(){
        session(['active' => 'encuesta', 'hijo' => 'nuevo']);
        return view('frontend.nuevaEncuesta');
    }


    protected function guardarNuevaEncuesta (NuevaEncuestaRequest $request){
        $nuevaEncuesta = new Encuesta();
        $nuevaEncuesta->idEmpresa =  Auth::user()->idEmpresa;
        $nuevaEncuesta->idSucursal =  Auth::user()->idSucursal;
        $nuevaEncuesta->descripcion = $request->input('descripcion');
        $nuevaEncuesta->idTipoEncuesta = $request->input('tipoEncuesta');
        $nuevaEncuesta->estado = $request->input('estadoEncuesta');
        $nuevaEncuesta->save();

        $nuevoDetalle = new EncuestaDetalle();
        $this->guardarDetalleFiltrosEncuesta($request, $nuevaEncuesta->getKey(),$nuevoDetalle);
        flash('')->success( 'Se creo la encuesta satisfactoriamente');

        return redirect(url('encuesta'));
    }

    protected function verPreguntasDetalleEncuesta ($idEncuesta, $idDetalleEncuesta){
        $detalleEncuesta = EncuestaDetalle::find($idDetalleEncuesta);

        return view('frontend.mantenimientoPreguntas')->with(["encuesta" => $detalleEncuesta]);
    }

    /****
     * Ajax
     ****/
    protected function obtenerPreguntas($idEncuesta, $idEncuestaDetalle){
        $idEmpresa = Auth::user()->idEmpresa;
        $idSucursal = Auth::user()->idSucursal;
        $lista = DB::select("exec web_obtenerPreguntas ?,?,?,?", [ $idEmpresa, $idSucursal,$idEncuesta, $idEncuestaDetalle]);
        return response()->json($lista);
    }
    protected function obtenerEncuestas(Request $request){
        $idEmpresa = Auth::user()->idEmpresa;
        $idSucursal = Auth::user()->idSucursal;

        $descripcion = '%'.$request->input('descripcion').'%';
        $tipo = $request->input('tipo');
        $estado = $request->input('estado');

        $lista = DB::select("exec web_obtenerEncuestas ?,?,?,?,?", [ $idEmpresa, $idSucursal, $descripcion, $tipo, $estado ]);
        return response()->json($lista);
    }

    protected function obtenerDetalleCopiaEncuesta(Request $request){
        $idEmpresa = Auth::user()->idEmpresa;
        $idSucursal = Auth::user()->idSucursal;
        $encuesta = $request->input('encuesta');

        $lista = DB::table('EncuestaDetalle')
            ->select(DB::raw('idEncuestaDetalle, fechaInicio, fechaFin '))
            ->where('idEmpresa', '=', $idEmpresa)
            ->where('idSucursal', '=', $idSucursal)
            ->where('idEncuesta', '=', $encuesta)
            ->get();

        /*select("exec web_obtenerDetalleEncuesta ?,?,?", [ $idEmpresa, $idSucursal, $encuesta ]);*/
        return response()->json($lista);
    }

    protected function obtenerDetalleEncuesta(Request $request){
        $idEmpresa = Auth::user()->idEmpresa;
        $idSucursal = Auth::user()->idSucursal;
        $encuesta = $request->input('encuesta');

        $lista = DB::select("exec web_obtenerDetalleEncuesta ?,?,?", [ $idEmpresa, $idSucursal, $encuesta ]);
        return response()->json($lista);
    }

    protected function obtenerEncuesta(Request $request){
        $encuesta = Encuesta::where( 'idEncuesta','=',$request->input('encuesta'))->where( 'idEmpresa','=', Auth::user()->idEmpresa )->where( 'idSucursal','=',Auth::user()->idSucursal )->first();
        return response()->json($encuesta);
    }

    protected function modificarEncuesta(AjaxNuevaEncuestaRequest $request){
        $encuesta = Encuesta::where( 'idEncuesta','=',$request->input('encuesta'))->where( 'idEmpresa','=', Auth::user()->idEmpresa )->where( 'idSucursal','=',Auth::user()->idSucursal )->first();
        if( $encuesta ){
            $encuesta->descripcion = $request->input('descripcion');
            $encuesta->idTipoEncuesta = $request->input('tipoEncuesta');
            $encuesta->estado = $request->input('estadoEncuesta');
            $encuesta->save();

            return response()->json(['id' => $encuesta->idEncuesta ]);
        }
        return response()->json(['message' => 'No se encuentra la encuesta' ]);
    }

    protected function obtenerCanalVentas(Request $request){
        $lista = CanalVentas::whereIn('idOcasionConsumo', $request->input('ocasionConsumo') )->get();
        return response()->json($lista);
    }

    protected function obtenerGiro(Request $request){
        $lista = Giro::whereIn('idCanalVentas', $request->input('canalVentas') )->get();
        return response()->json($lista);
    }

    protected function obtenerSubGiro(Request $request){
        $lista = SubGiro::whereIn('idGiro', $request->input('giro') )->get();
        return response()->json($lista);
    }
}