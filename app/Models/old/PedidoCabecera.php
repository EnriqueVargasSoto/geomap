<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Brand
 * @package App\Models
 */
class PedidoCabecera extends Model
{

    public $table = 'PedidoCabecera';

    public $timestamps = false;
    protected $primaryKey = '..';


    public $fillable = [
        'idEmpresa',
        'idSucursal',
		'numeroGuia',
		'numeroPedido',
		'idAlmacen',
		'idCliente',
		'idVendedor',
		'fechaPedido',
		'fechaEntrega',
		'idFormaPago',
		'observacion',
		'pesoTotal',
		'importeTotal',
		'idMotivoNoVenta',
		'estado',
		'flag',
		'serieDocumento',
		'numeroDocumento',
		'EstadoERP',
		'numeroAnterior',
		'fechaModificacion',
		'latitud',
		'longitud',
		'latitudDocumento',
		'longitudDocumento'
    ]; 
 
}
