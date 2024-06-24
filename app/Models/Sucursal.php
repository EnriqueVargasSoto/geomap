<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Brand
 * @package App\Models
 */
class Sucursal extends Model
{

    public $table = 'Sucursal';

    public $timestamps = false;
    protected $primaryKey = 'idSucursal';


    public $fillable = [ 
		'nombre' 
    ]; 
	
	protected $hidden = array( 'idEmpresa','idPoliticaMinorista', 'serieFactura', 'numeroFactura', 'serieBoleta', 'numeroBoleta');
	
	/**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [ 'idSucursal' => 'string' ];
	
	/**
     * Get the Sucursal's nombre.
     *
     * @param  string  $nombre
     * @return void
     */
    public function getNombreAttribute($value)
    {
        return trim($value);
    }
	
	public static function porPersona($idEmpresa, $idPersona)
    {	 
		return self::where('Sucursal.idEmpresa', $idEmpresa)
            ->where('SucursalxPersona.idPersona', $idPersona) 
			->join('SucursalxPersona', function ($join) {
				$join->on('SucursalxPersona.idEmpresa', '=', 'Sucursal.idEmpresa')
				     ->on('SucursalxPersona.idSucursal', '=', 'Sucursal.idSucursal');
			})
            ->get(); 
    }  
}
