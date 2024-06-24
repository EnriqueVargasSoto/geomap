<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Brand
 * @package App\Models
 *
 */
class EncuestaDetallexVendedor extends Model
{
    public $table = 'EncuestaDetallexVendedor';

    public $timestamps = false;
    protected $primaryKey = 'idEncuestaDetalle';

    public $fillable = [ 
		'idEmpresa',
        'idSucursal',
        'idEncuesta',
        'idVendedor'
    ];

	/**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [ 'idSucursal' => 'string' ];

}