<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Brand
 * @package App\Models
 */
class OcasionConsumo extends Model {

    public $table = 'OcasionConsumo';

    public $timestamps = false;
    protected $primaryKey = 'idOcasionConsumo';

    public $fillable = [
        'descripcion'
    ];

    protected $casts = [ 'idOcasionConsumo' => 'string' ];

    public function getDescripcion($value) {
        return strtolower($value);
    }
}