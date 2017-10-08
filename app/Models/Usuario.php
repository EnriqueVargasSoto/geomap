<?php
/**
 * Created by ExpedioDigital.
 * User: Monica Toribio Rojas
 * Date: 17/09/2017
 * Time: 07:06
 */
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Usuario extends Model
{

    public $table = 'Usuario';

    public $timestamps = false;
    protected $primaryKey = 'idUsuario';


    public $fillable = [  'idEmpresa'  ]; 
	
	protected $hidden = array('usuario, clave');
	
	public function getEmpresa()
    {
        return $this->belongsTo('App\Models\Empresa', 'idEmpresa', 'idEmpresa');
    }
}
