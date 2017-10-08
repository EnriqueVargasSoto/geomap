<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Empresa
 * @package App\Models
 */
class Empresa extends Model
{

    public $table = 'Empresa';

    public $timestamps = false;
    protected $primaryKey = 'idEmpresa';

    public $fillable = [
        'ruc',
        'razonSocial'
    ]; 
}
