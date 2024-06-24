<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Brand
 * @package App\Models
 */
class EncuestaDetalle extends Model
{

    public $table = 'EncuestaDetalle';

    public $timestamps = false;
    protected $primaryKey = 'idEncuestaDetalle';


    public $fillable = [ 
		'idEmpresa',
        'idSucursal',
        'idEncuesta',
        'fechaInicio',
        'fechaFin',
        'clientesObligatorios',
        'clientesAnonimos',
        'encuestasMinimas',
        'fotosMinimas',
        'maximoIntentosCliente',
        'filtroOcasion',
        'filtroCanalVentas',
        'filtroGiro',
        'filtroSubGiro'
    ]; 

	/**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [ 'idSucursal' => 'string' ];


}
