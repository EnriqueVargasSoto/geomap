<?php

namespace App\Providers;

use Auth;
use Session;
use Request;
use ConfigSite;
use Illuminate\Auth\GenericUser; 
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Contracts\Auth\Authenticatable;
use App\Models\Supervisor; 

class CustomAuthSupervisorProvider implements UserProvider
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
        $model = Supervisor::find($identifier);
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
        $clave = $credentials['clave'];

        $model = Supervisor::where('usuario', $usuario)->where('clave',$clave)->first();

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

    public function createSession($model, $log = true)
    {
        if($model == null)
            return;
        else
        {  
            $user['id']           = $model->idSupervisor;
			$user['idEmpresa']    = $model->idEmpresa;
            $user['empresa']      = $model->getEmpresa->razonSocial;
            $user['usuario']      = strtoupper( $model->usuario );    
            $user['type_account'] = 'Administrador';

            $this->user = new GenericUser($user);
            return $this->user;
        }
    }
}