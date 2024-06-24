<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\UserDataTable;
use App\Http\Requests\Admin\CreateUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Models\Usuario;
use App\Models\ZonaxUsuario;
use App\Repositories\UserRepository;
use Flash;
use InfyOm\Generator\Controller\AppBaseController;
use Response;

class UserController extends AppBaseController
{
    /** @var  UserRepository */
    private $userRepository;

    public function __construct(UserRepository $userRepo)
    {
        $this->userRepository = $userRepo;
    }

    /**
     * Display a listing of the User.
     *
     * @param UserDataTable $userDataTable
     * @return Response
     */
    public function index(UserDataTable $userDataTable)
    { 

        session(['active' => 'usuarios', 'hijo' => 'lista']);
        return $userDataTable->render('admin.usuarios.index');
    }

    /**
     * Show the form for creating a new User.
     *
     * @return Response
     */
    public function create()
    {
        session(['active' => 'usuarios', 'hijo' => 'nuevo']);
        return view('admin.usuarios.create');
    }

    /**
     * Store a newly created User in storage.
     *
     * @param CreateUserRequest $request
     *
     * @return Response
     */
    public function store(CreateUserRequest $request) /*CreateUserRequest*/
    {
        $usuario = $request->input("usuario");
        $empresa = $request->input("empresa");
        $sucursal  = $request->input("sucursal");

        $usuarioModel = new Usuario();
        $usuarioModel->idPerfil = $request->input("cargo");
        $usuarioModel->idEmpresa = $empresa;
        $usuarioModel->idSucursal = $sucursal ;
        $usuarioModel->nombre = $request->input("nombre");
        $usuarioModel->usuario = $usuario;
        $usuarioModel->clave =  MD5(SHA1($request->input("clave")));
        $usuarioModel->save();

        foreach ($request->input("zonas") as $zona){
            $zonaModel = new ZonaxUsuario();

            $zonaModel->idEmpresa = $empresa;
            $zonaModel->idSucursal = $sucursal;
            $zonaModel->idUsuario = $usuarioModel->getKey();
            $zonaModel->idZona = $zona;
            $zonaModel->save();
        }

        Flash::success('Usuario creado satisfactoriamente.');
        return redirect(route('users.index'));
    }

    /**
     * Display the specified User.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $user = $this->userRepository->findWithoutFail($id);
 
        if (empty($user)) {
            Flash::error('User not found');

            return redirect(route('users.index'));
        }

        return view('admin.usuarios.show')->with('model', $user);
    }


    public function edit($id)
    {

        $user = $this->userRepository->findWithoutFail($id);
        
 
        if (empty($user)) {
            Flash::error('No se encontro al usuario.');
            return redirect(route('users.index'));
        }
        return view('admin.usuarios.edit')->with('user', $user);
    }

    public function update($id, UpdateUserRequest $request)
    {
        $user = $this->userRepository->findWithoutFail($id);

        if (empty($user)) {
            Flash::error('No se encontro al usuario.');
            return redirect(route('users.index'));
        }

        $input = $request->all();

        $user->idPerfil = $input['cargo'] ;
        $user->usuario = $input['usuario'] ;
        $user->nombre = $input['nombre'] ;

        if($input['empresa'] !=  $user->idEmpresa || $input['sucursal'] !=  $user->idSucursal){
            $user->idEmpresa = $input['empresa'] ;
            $user->idSucursal = $input['sucursal'] ;

            ZonaxUsuario::where('idUsuario', '=' , $id)->delete();

            foreach ($input["zonas"] as $zona){
                $zonaModel = new ZonaxUsuario();

                $zonaModel->idEmpresa = $input['empresa'] ;
                $zonaModel->idSucursal = $input['sucursal'] ;
                $zonaModel->idUsuario = $user->getKey();
                $zonaModel->idZona = $zona;
                $zonaModel->save();

            }
        }

        if($input['clave'] != ""){
            $user->clave =  MD5(SHA1($request->input("clave")));
        }
        $user->save();

        Flash::success('El usuario se actualizo correctamente');

        return redirect(route('users.index'));
    }

    /**
     * Remove the specified User from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $user = $this->userRepository->findWithoutFail($id);

        if (empty($user)) {
            Flash::error('No se encontro al usuario.');

            return redirect(route('users.index'));
        }

        $this->userRepository->delete($id);
        ZonaxUsuario::where('idUsuario', '=' , $id)->delete();

        Flash::success('Se elimino el usuario correctamente');

        return redirect(route('users.index'));
    }
}
