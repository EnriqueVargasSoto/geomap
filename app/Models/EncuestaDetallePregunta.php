<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Brand
 * @package App\Models
 */
class EncuestaDetallePregunta extends Model
{

    public $table = 'EncuestaDetallePregunta';

    public $timestamps = false;
    protected $primaryKey = 'idPregunta';

    public $fillable = [ 
		'idEmpresa',
        'idSucursal',
        'idEncuesta',
        'idEncuestaDetalle',
        'pregunta',
        'orden',
        'idTipoRespuesta',
        'requerido',
        'cantidadAlternativas'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [ 'idSucursal' => 'string' ];

}
