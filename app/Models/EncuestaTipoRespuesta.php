<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Brand
 * @package App\Models
 */
class EncuestaTipoRespuesta extends Model
{

    public $table = 'EncuestaTipoRespuesta';

    public $timestamps = false;
    protected $primaryKey = 'idTipoRespuesta';

    public $fillable = [ 
		'idEmpresa',
        'descripcion'
    ]; 

	/**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [ 'idEmpresa' => 'string', 'idTipoRespuesta' => 'string' ];

}
