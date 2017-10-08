<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Brand
 * @package App\Models
 */
class Cliente extends Model
{

    public $table = 'Cliente';

    public $timestamps = false;
    protected $primaryKey = 'idCliente';


    public $fillable = [
        'idEmpresa',
        'idSucursal',
		'rucDni',
		'razonSocial',
		'correo', 
		'direccionFiscal',  
		'latitud',
		'longitud'
    ]; 
	
	public function scopePorSucursal($query, $idEmpresa, $idSucursal)
    {	 
        return $query->where('idEmpresa',$idEmpresa)->where('idSucursal',$idSucursal);
    }
}
