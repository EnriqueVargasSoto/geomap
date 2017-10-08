<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Brand
 * @package App\Models
 */
class Configuracion extends Model
{

    public $table = 'Configuracion';

    public $timestamps = false;
    protected $primaryKey = 'identificador';


    public $fillable = [
        'idEmpresa',
        'idSucursal',
		'valor' 
    ]; 
 
	public static function getSetting($idEmpresa, $idSucursal, $name = "fecha")
    {
        $setting = Configuracion::where('idEmpresa',$idEmpresa)
								->where('idSucursal', $idSucursal)
								->where('identificador', $name)
								->first();
		
        if(!empty($setting)){  
            if(!empty($setting->valor)){ 
				$value = str_replace('/', '-', $setting->valor);
                return  $value;
            } 
        }

        return null;
    }
}
