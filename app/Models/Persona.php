<?php
/**
 * Created by ExpedioDigital.
 * User: Monica Toribio Rojas
 * Date: 17/09/2017
 * Time: 07:06
 */
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Persona extends Model
{

    public $table = 'Persona';

    public $timestamps = false;
    protected $primaryKey = 'idPersona';


    public $fillable = [ 'nombre' ]; 
	protected $casts = [ 'idPersona' => 'string' ];
	protected $hidden = array('idEmpresa','idSucursal', 'cargo', 'idUsuario');
	
	/**
     * Get the Persona's nombre.
     *
     * @param  string  $nombre
     * @return void
     */
    public function getNombreAttribute($value)
    {
        return trim($value);
    }
	
	public static function findByUser($idEmpresa, $idUsuario)
    {	 
        return Persona::where('idEmpresa',$idEmpresa)-> where('idUsuario',$idUsuario)->first();
    }
	
	public static function vendedoresPorSucursal($idEmpresa, $idSucursal)
    {	
		return self::where('Persona.idEmpresa', $idEmpresa)
            ->where('SucursalxPersona.idSucursal', $idSucursal) 
			->where('Persona.cargo', 'V') 
			->join('SucursalxPersona', function ($join) {
				$join->on('SucursalxPersona.idEmpresa', '=', 'Persona.idEmpresa')
				     ->on('SucursalxPersona.idPersona', '=', 'Persona.idPersona');
			})
            ->get(); 
    }
	
   
}




