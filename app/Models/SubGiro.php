<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SubGiro
 * @package App\Models
 */
class SubGiro extends Model {

    public $table = 'SubGiro';

    public $timestamps = false;
    protected $primaryKey = 'idSubGiro';

    public $fillable = [ 
		'idGiro',
        'descripcion'
    ];

    protected $casts = [ 'idSubGiro' => 'string' , 'idGiro' => 'string' ];

}