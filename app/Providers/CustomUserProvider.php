<?php

namespace App\Providers;

use App\Models\Configuracion;
use App\Models\Usuario;
use Auth;
use Session;
use Request;
use ConfigSite;
use Illuminate\Auth\GenericUser;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Contracts\Auth\Authenticatable;

class CustomUserProvider implements UserProvider
{
    protected $model ;

    public function __construct($model)
    {
        $this->model = $model;
    }

    /**
     * Retrieve a user by their unique identifier.
     *
     * @param  mixed  $identifier
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveById($identifier){
        $model = Usuario::find($identifier);
        if($model != null)
            return $this->createSession($model, false);
        return;
    }
    /**
     * Retrieve a user by their unique identifier and "remember me" token.
     *
     * @param  mixed   $identifier
     * @param  string  $token
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveByToken($identifier, $token){}
    /**
     * Update the "remember me" token for the given user in storage.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @param  string  $token
     * @return void
     */
    public function updateRememberToken(Authenticatable $user, $token){}
    /**
     * Retrieve a user by the given credentials.
     *
     * @param  array  $credentials
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveByCredentials(array $credentials)
    {
        $usuario  = $credentials['usuario'];
        $password = $credentials['clave'];
        $empresa  = $credentials['empresa'];
        $sucursal = $credentials['sucursal'];

		$model =   null;
		$admin = Usuario::where('usuario', $usuario)->where('clave', MD5(SHA1($password)))->where('idPerfil', '246' )->where('deleted', '=', 0 )->first();
		if($admin){//validar admin
			return $this->createSession($admin);
		}else if( $empresa != "" && $sucursal != "") {
			$model = Usuario::where('usuario', $usuario)->where('clave', MD5(SHA1($password)))->where('idEmpresa', $empresa )->where('idSucursal', $sucursal )->where('deleted', '=', 0 )->first();
		}
        return $this->createSession($model);
    }
    /**
     * Validate a user against the given credentials.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @param  array  $credentials
     * @return bool
     */
    public function validateCredentials(Authenticatable $user, array $credentials){
        return !empty($user);
    }

    public function createSession($model)
    {
        if ($model == null){
            return;
        }else{

            if($model->rol == null && $model->deleted != 0 ){
                return;
            }else{
                $user['id']           = $model->idUsuario;
                $user['nombre']      = strtoupper($model->nombre);
                $user['usuario']      = strtoupper($model->usuario);
                $user['cargo']        = $model->perfil->descripcion;
                $user['fecha']        = str_replace('-', '/', Configuracion::getSetting($model->idEmpresa, $model->idSucursal) );
                $user['empresa']      = $model->getEmpresa->razonSocial;
                $user['idEmpresa']    = $model->idEmpresa;
                $user['idSucursal']   = $model->idSucursal;

                $this->user = new GenericUser($user);
                return $this->user;
            }
        }
    }
}
