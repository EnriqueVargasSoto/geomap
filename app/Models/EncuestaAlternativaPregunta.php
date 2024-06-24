<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Brand
 * @package App\Models
 */
class EncuestaAlternativaPregunta extends Model
{

    public $table = 'EncuestaAlternativaPregunta';

    public $timestamps = false;
    protected $primaryKey = 'idAlternativa';


    public $fillable = [ 
		'idEmpresa',
        'idSucursal',
        'idEncuesta',
        'idEncuestaDetalle',
        'idPregunta',
        'alternativa',
        'orden'
    ]; 

	/**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [ 'idSucursal' => 'string' ];

}
