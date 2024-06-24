<?php

/**
 * Created by ExpedioDigital.
 * User: Monica Toribio Rojas
 * Date: 9/02/2018
 * Time: 05:48
 */


namespace App\Http\Controllers\Frontend;

use App\Models\InformeAuditoria;
use App\Models\RecomendacionAuditoria;
use App\Models\EncuestaDetallePregunta;
use App\Http\Controllers\Controller;
use App\Models\AvanceAuditoria;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Excel;
use Auth;
use DB;

class ExcelController  extends Controller
{
	public function reporteHitRate(Request $request){ 
		$formato = $request->input('formatoExcel'); 
		$idEmpresa = Auth::user()->idEmpresa;
		$idSucursal = Auth::user()->idSucursal;
		
		if($formato == "soles"){
			$datos = DB::select("exec web_obtenerHRIndicadorSoles ?,?", [ $idEmpresa, $idSucursal ]); 
		}else{
			$datos = DB::select("exec web_obtenerHRIndicadorPaquetes ?,?", [ $idEmpresa, $idSucursal ]);
		}
		
		$data = [];
 
		$cabecera =  array('vendedor','Cliente', 'HR%', 'Venta Día', 'Prom MA', 'Prom AA', 'Cuota Diario', 'Faltante Venta','Avance Mes','KR','CIE','ORO','SPR','CIF','PUL','VOL','OT','CM%','SEG.','EX.','FR.','TL.');
		
		array_push($data,  $cabecera); 
		
		foreach($datos as $index => $item) {
			$itemExcel = array( $item->nombre,$item->idCliente, 0, $item->ventaDia, $item->PromVentaMesAnterior, $item->PromVentaAnoAnterior, $item->CUOTAGTM, 0 , $item->avanceMes , $item->KR ,$item->CIE, $item->ORO , $item->SPR, $item->CIF, $item->PUL, $item->VOL, $item->OTROS,0, $item->SEGMENTO , $item->EXHIBIDORES , $item->NROPTAFRIOGTM , $item->TMLOCALGTM  ); 
			array_push($data, $itemExcel);				
		}
		$mytime = Carbon::now(); 
		$nombreReporte = "HR_".$formato."xvendedor_".$mytime->toDateTimeString();
		
		Excel::create($nombreReporte, function($excel) use($data) {

			$excel->sheet('Ventas', function($sheet) use($data) {
				$sheet->fromArray($data,  null, 'A1', true, false);
				$sheet->getStyle('A1:U1')->applyFromArray(  array(  'font' => array( 'bold' => true ) ) );
				$sheet->setBorder('A1:U'.count($data), 'thin');
			});

		})->export('xls');
	}
	
	public function reporteTodosVendedoresPedidos(Request $request){
		$idEmpresa = Auth::user()->idEmpresa;
        $idSucursal = Auth::user()->idSucursal;
        $fecha = $request->input('fecha'); 
		$guia = $request->input('guia');
		$idSupervisor = Auth::user()->id;
		//exec web_obtenerReporteTodosPedidos '0024','02','28/01/2019','3','preventa'
		$datos = DB::select(" exec web_obtenerReporteTodosPedidos  ?,?,?,?,?", [ $idEmpresa, $idSucursal, $fecha, $idSupervisor, $guia ]);
		
		$data = [];
 
		$cabecera =  array('Vendedor', 'Zona', 'Ruta','Modulo', 'Clientes', 'Dirección', 'Hora Inicio', 'Tiempo Pedido','Fecha Entrega','Cantidad Venta','Cajas(ERP)','Importe Total');
		
		array_push($data,  $cabecera); 
		
		foreach($datos as $index => $item) {
			$itemExcel = array( $item->nombre, $item->idZona, $item->idRuta,$item->idModulo, $item->cliente, $item->direccion, $item->hora, $item->tiempoPedido , $item->fechaEntrega , $item->cantidad ,$item->cajas, $item->importeTotal   );
			array_push($data, $itemExcel);				
		}
		$mytime = Carbon::now(); 
		$nombreReporte = "detalle_pedidos_".$guia."xvendedor_".$mytime->toDateTimeString();
		
		Excel::create($nombreReporte, function($excel) use($data) {

			$excel->sheet('Pedidos', function($sheet) use($data) {
				$sheet->fromArray($data,  null, 'A1', true, false);
				$sheet->getStyle('A1:K1')->applyFromArray(  array(  'font' => array( 'bold' => true ) ) );
				$sheet->setBorder('A1:K'.count($data), 'thin');
			});

		})->export('xls');
		
	}
		
    public function respuestaEncuesta(Request $request){
		
        $mytime = Carbon::now();
        $nombreReporte = "RespuestaEncuesta".$mytime->toDateTimeString();
		
		$idEncuesta = $request->input("excelEncuesta");
		$idEncuestaDetalle = $request->input("excelEncuestaDetalle");
		
		$excelHasta = "";
		$excelDesde = "";
		
		if( strlen( $request->input("excelHasta") ) > 9 ){
			$excelHasta = $request->input("excelHasta");
		}
	
		if( strlen( $request->input("excelDesde") ) > 9 ){
			$excelDesde = $request->input("excelDesde");
		}
		
		$idEmpresa = Auth::user()->idEmpresa;
		$idSucursal = Auth::user()->idSucursal;
		
		$preguntas = EncuestaDetallePregunta::where('idEmpresa',$idEmpresa)->where('idSucursal',$idSucursal)->where('idEncuesta',$idEncuesta)->where('idEncuestaDetalle',$idEncuestaDetalle)->get();
	
		$datos = DB::select("exec web_reporteEncuesta  ?,?,?,?,?,?", [$idEmpresa, $idSucursal, $idEncuesta, $idEncuestaDetalle,$excelDesde, $excelHasta]);
		
		$data = [];

		$cabecera =  array('COMPAÑIA', 'ORGANIZACION', 'COD.ZONA', 'ZONA', 'COD.RUTA','COD.MÓDULO','MÓDULO','FECHA ENCUESTA','FECHA SERVIDOR','COD.CLIENTE','CLIENTE');
			
		foreach($preguntas  as $pregunta){
		  array_push($cabecera, $pregunta->pregunta);
		}
		
		array_push($data,  $cabecera);

		foreach($datos as $index => $item) {
			$itemExcel = array( $item->COMPANIA, $item->ORGANIZACION, $item->CODZONA, $item->ZONA, $item->CODRUTA , $item->CODMODULO , $item->MODULO , $item->FECHAENCUESTA ,$item->FECHASERVIDOR , $item->CLIENTE , $item->NOMBRE  );
			
			foreach($preguntas  as $pregunta){
				$nombre = $pregunta->idPregunta;
				array_push($itemExcel, $item->$nombre);
			} 

			array_push($data, $itemExcel);				
		}
	
		Excel::create($nombreReporte, function($excel) use($data) {

			$excel->sheet('RespuestaEncuesta', function($sheet) use($data) {
				$sheet->fromArray($data,  null, 'A1', true, false);
				$sheet->getStyle('A1:S1')->applyFromArray(  array(  'font' => array( 'bold' => true ) ) );
				$sheet->setBorder('A1:S'.count($data), 'thin');
			});

		})->export('xls');
		
    }      
}