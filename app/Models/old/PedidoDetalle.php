<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Brand
 * @package App\Models
 */
class PedidoDetalle extends Model
{

    public $table = 'PedidoDetalle';

    public $timestamps = false;
    protected $primaryKey = 'pendiente';


    public $fillable = [
        'idEmpresa',
        'idSucursal',
		'numeroGuia',
		'numeroPedido',
		'idProducto',
		'tipoProducto',
		'idPoliticaPrecio',
		'precioBruto',
		'cantidad',
		'precioNeto',
		'idUnidadMedida',
		'pesoNeto'
    ]; 
}
