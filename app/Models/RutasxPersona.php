<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Brand
 * @package App\Models
 */
class RutasxPersona extends Model
{

    public $table = 'RutasxPersona';

    public $timestamps = false;
    protected $primaryKey = 'idRuta';


    public $fillable = [ 
		'idPersona',
		'idSucursal'		
    ]; 

	protected $hidden = array('idEmpresa', 'idSucursal');
	
	/**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [ 'idSucursal' => 'string' ];
	
}
