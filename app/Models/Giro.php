<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Brand
 * @package App\Models
 */
class Giro extends Model {

    public $table = 'Giro';

    public $timestamps = false;
    protected $primaryKey = 'idGiro';

    public $fillable = [ 
		'idCanalVentas',
        'descripcion'
    ];

    protected $casts = [ 'idCanalVentas' => 'string' ,'idGiro' => 'string' ];
}