<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Brand
 * @package App\Models
 */
class Cliente extends Model {

    public $table = 'Cliente';

    public $timestamps = false;
    protected $primaryKey = 'idCliente';

    public $fillable = [
        'idEmpresa'
        ,'idSucursal'
        ,'rucDni'
        ,'razonSocial'
        ,'correo'
        ,'direccion'
        ,'direccionFiscal'
        ,'idModulo'
        ,'orden'
        ,'latitud'
        ,'longitud'
        ,'distancia'
        ,'idSegmento'
        ,'idCluster'
        ,'limiteCredito'
        ,'idSubGiro'
        ,'idGiro'
        ,'idCanalVentas'
        ,'idOcasionConsumo'
    ];

    protected $casts = [ 'idEmpresa' => 'string' , 'idSucursal' => 'string' ];

}