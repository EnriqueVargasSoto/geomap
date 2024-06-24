<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

/**
 * @package App\Models
 */
class CanalVentas extends Model {

    public $table = 'CanalVentas';

    public $timestamps = false;
    protected $primaryKey = 'idCanalVentas';

    public $fillable = [ 
		'idOcasionConsumo',
        'descripcion'
    ];

    protected $casts = [ 'idCanalVentas' => 'string' ,'idOcasionConsumo' => 'string' ];

}