<?php

namespace App\Repositories;

use App\Models\Usuario;
use InfyOm\Generator\Common\BaseRepository;

class UserRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'idPerfil','idEmpresa' , 'idSucursal', 'deleted'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Usuario::class;
    }

    public function delete($id)
    {
        $model = Usuario::where('idUsuario',$id);
        $model->update(['deleted' => 1]);
    }

}
