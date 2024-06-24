<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use DB;
/**
 * Class Zona
 * @package App\Models
 */
class Zona extends Model
{

    public $table = 'Zona';

    public $timestamps = false;

    protected $primaryKey = 'idZona';

    protected $casts = [ 'idZona' => 'string' ];

    public $fillable = [
        'idEmpresa',
        'idSucursal',
        'descripcion',
        'idSupervisor'
    ];

    public static function usuario()
    {
        return $query = self::select(DB::raw("Zona.*"))
            ->leftJoin('Web_ZonasxUsuario', function($join){
                $join->on( 'Web_ZonasxUsuario.idZona','=','Zona.idZona')
                    ->on( 'Web_ZonasxUsuario.idEmpresa','=','Zona.idEmpresa')
                    ->on( 'Web_ZonasxUsuario.idSucursal','=','Zona.idSucursal');
            })->get();
    }

    public static function libres($idEmpresa, $idSucursal ){
        return DB::table('Zona')
            ->whereNotExists(function($query)
            {
                $query->select(DB::raw(1))
                    ->from('Web_ZonasxUsuario')
                    ->whereRaw('Web_ZonasxUsuario.idZona = Zona.idZona')
                    ->whereRaw('Web_ZonasxUsuario.idEmpresa = Zona.idEmpresa')
                    ->whereRaw('Web_ZonasxUsuario.idSucursal = Zona.idSucursal');
            })
            ->where('idEmpresa', '=', $idEmpresa )
            ->where('idSucursal', '=',$idSucursal)
            ->get();
    }

    public static function porUsuario($idEmpresa, $idSucursal , $idUsuario ){
        return DB::table('Zona')->join('Web_ZonasxUsuario', function($join){
            $join->on( 'Web_ZonasxUsuario.idZona','=','Zona.idZona')
                ->on( 'Web_ZonasxUsuario.idEmpresa','=','Zona.idEmpresa')
                ->on( 'Web_ZonasxUsuario.idSucursal','=','Zona.idSucursal');
        })->where('Web_ZonasxUsuario.idUsuario', '=', $idUsuario )
            ->where('Web_ZonasxUsuario.idEmpresa', '=', $idEmpresa )
            ->where('Web_ZonasxUsuario.idSucursal', '=',$idSucursal)
            ->get();
    }

}