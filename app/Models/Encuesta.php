<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
/**
 * Class Brand
 * @package App\Models
 */
class Encuesta extends Model {

    public $table = 'Encuesta';

    public $timestamps = false;
    protected $primaryKey = 'idEncuesta';


    public $fillable = [ 
		'idEmpresa',
        'idSucursal',
        'descripcion',
        'idTipoEncuesta',
        'estado'
    ]; 

	/**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [ 'idSucursal' => 'string' ];

}
