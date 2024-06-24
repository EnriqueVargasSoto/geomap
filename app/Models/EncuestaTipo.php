<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Brand
 * @package App\Models
 */
class EncuestaTipo extends Model {

    public $table = 'EncuestaTipo';

    public $timestamps = false;
    protected $primaryKey = 'idTipoEncuesta';


    public $fillable = [ 
		'idEmpresa',
        'descripcion'
    ];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [ 'idTipoEncuesta' => 'string' , 'idEmpresa' => 'string' ];
}