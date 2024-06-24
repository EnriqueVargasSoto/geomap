<?php

namespace App\Models;
/**
 * Class Zona
 * @package App\Models
 */
class ZonaxUsuario extends BaseModel
{

    public $table = 'Web_ZonasxUsuario';

    public $timestamps = true;

    protected $primaryKey = '_id';

    protected $casts = [ 'idEmpresa' => 'string' ,  'idSucursal' => 'string'];

    public $fillable = [
		'idEmpresa',
		'idSucursal',
		'idUsuario',
        'idZona',
        'updated_at',
        'created_at'
    ]; 
 
}
