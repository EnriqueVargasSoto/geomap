<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Brand
 * @package App\Models
 */
class EncuestaDetallexCargo extends Model
{

    public $table = 'EncuestaDetallexCargo';

    public $timestamps = false;
    protected $primaryKey = 'idEncuestaDetalle';

    public $fillable = [
        'idEmpresa',
        'idSucursal',
        'idEncuesta',
        'cargo'
    ]; 

	/**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [ 'idSucursal' => 'string' ];

}
