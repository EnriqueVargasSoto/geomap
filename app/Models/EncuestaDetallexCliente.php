<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Brand
 * @package App\Models
 */
class EncuestaDetallexCliente extends Model
{

    public $table = 'EncuestaDetallexCliente';

    public $timestamps = false;
    protected $primaryKey = 'idEncuestaDetalle';

    public $fillable = [
        'idEmpresa',
        'idSucursal',
        'idEncuesta',
        'idEncuestaDetalle',
        'idCliente'
    ]; 

	/**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [ 'idSucursal' => 'string' ];

}