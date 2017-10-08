<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Brand
 * @package App\Models
 */
class Factura extends Model
{

    public $table = 'PedidoCabecera';

    public $timestamps = false;
    protected $primaryKey = '..';


    public $fillable = [
        'idEmpresa',
        'idSucursal',
		'numeroPedido',
		'idVendedor',
		'pesoTotal',
		'importeTotal',
		'estado',
		'flag',
		'latitud',
		'longitud'
    ]; 
	/** incorporar fecha**/
	public function scopePorSucursal($query, $idEmpresa, $idSucursal)
    {	 
        return $query->where('idEmpresa',$idEmpresa)->where('idSucursal',$idSucursal)->where('estado','F');
    }
}
