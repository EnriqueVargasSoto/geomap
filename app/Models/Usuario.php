<?php
/**
 * Created by ExpedioDigital.
 * User: Monica Toribio Rojas
 * Date: 17/09/2017
 * Time: 07:06
 */
namespace App\Models;
use DB;

class Usuario extends BaseModel
{
    public $table = 'Web_Usuario';

    public $timestamps = true;

    protected $primaryKey = 'idUsuario';

    public $fillable = [ 'idPerfil','idEmpresa' ,'nombre', 'idSucursal', 'deleted' ];

    protected $hidden = array('usuario, clave');

    protected $casts = [ 'idEmpresa' => 'string' ,  'idSucursal' => 'string'];

    public function getEmpresa()
    {
        return $this->belongsTo('App\Models\Empresa', 'idEmpresa', 'idEmpresa');
    }

    public function getSucursal()
    {
        return $this->belongsTo('App\Models\Sucursal', 'idSucursal', 'idSucursal');
    }

    public function perfil()
    {
        return $this->belongsTo('App\Models\Perfil', 'idPerfil');
    }

    public function scopeEliminated($query)
    {
        return $query->where('deleted',0);
    }

}