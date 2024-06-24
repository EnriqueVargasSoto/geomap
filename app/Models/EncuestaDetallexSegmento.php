<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Brand
 * @package App\Models
 */
class EncuestaDetallexSegmento extends Model
{

    public $table = 'EncuestaDetallexSegmento';

    public $timestamps = false;
    protected $primaryKey = 'idEncuestaDetalle';

    public $fillable = [ 
		'idEmpresa',
        'idSucursal',
        'idEncuesta',
        'idEncuestaDetalle',
        'idSegmentoCliente'
    ]; 

	/**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [ 'idSucursal' => 'string' ];

}
