<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use DB;
/**
 * Class Empresa
 * @package App\Models
 */
class Fectranscurridos extends Model
{

    public $table = 'fectranscurridos';

    public $timestamps = false; 
 
    public $fillable = [
        'DiaTotal',
        'DiaLaboral',
		'Diatrans'
    ]; 
	 
}
