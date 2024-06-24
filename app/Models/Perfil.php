<?php
/**
 * Created by ExpedioDigital.
 * User: Monica Toribio Rojas
 * Date: 28/01/2018
 * Time: 12:41
 */

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Perfil extends Model
{
    protected $table = 'Web_Perfil';

    public $timestamps = true;
    protected $primaryKey = 'idPerfil';

    protected $fillable = [
        'descripcion',
        'abreviatura'
    ];

}