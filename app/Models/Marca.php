<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Marca
 * @package App\Models
 */
class Marca extends Model
{

    public $table = 'Marca';

    public $timestamps = false;
    protected $primaryKey = 'idMarca';
	
	protected $casts = [ 'idEmpresa' => 'string' ];
	
    public $fillable = [ 
		'idEmpresa',
		'descripcion'
    ]; 
 
}
