<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Brand
 * @package App\Models
 */
class Segmento extends Model {

    public $table = 'Segmento';

    public $timestamps = false;
    protected $primaryKey = 'idSegmento';

    public $fillable = [ 
		'idEmpresa',
        'descripcion'
    ];

    protected $casts = [ 'idEmpresa' => 'string' ];
}