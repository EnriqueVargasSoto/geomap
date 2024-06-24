<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Contracts\Auth\Guard; 
use App\Models\LogSession;
use Auth;
use Session;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Guard $auth)
    {
		$this->auth = $auth;
        $this->middleware('guest', ['except' => 'logout']);
    }
	
	protected function login(LoginRequest $request)
    { 
        if ($this->auth->attempt($request->only('usuario', 'clave', 'empresa', 'sucursal'))) {
             if($this->auth->user()->cargo == 'Admin'){
                $url = '/admin/users';
            }else if(isset($request->next) ){
                $url = '/';
            }else if ((trim($request->input('back'), '/') == trim(url('/'), '/')) ||
                (trim($request->input('back'), '/') == trim(url('/login'), '/')) ) {
                $url = '/';
            } else {
                $url = $request->input('back');
            }
            return redirect($url);
        }

        return redirect('login') ->withInput($request->only('usuario'), 'LoginRequest')
            ->withErrors([ 'clave' => 'Usuario o contraseña incorrecta', ], 'LoginRequest');
    }

    /**
     * Log the user out of the application.
     *
     * @return Response
     */
    protected function logout()
    {
        $this->auth->logout();
        Session::flush();
		
        return redirect('/login');
    }
}
