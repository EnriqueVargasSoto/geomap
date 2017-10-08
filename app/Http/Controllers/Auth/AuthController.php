<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

use Auth;
use Request;
use Session;

use App\Http\Requests\Frontend\LoginRequest;
use Illuminate\Contracts\Auth\Guard; 
use App\Models\LogSession;

class AuthController extends Controller
{
    /*
     |--------------------------------------------------------------------------
     | Registration & Login Controller
     |--------------------------------------------------------------------------
     |
     | This controller handles the registration of new users, as well as the
     | authentication of existing users. By default, this controller uses
     | a simple trait to add these behaviors. Why don't you explore it?
     |
     */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
        $this->middleware('guest', ['except' => 'logout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    /* Login get post methods */
    protected function getLogin() {
        return View('auth.login');
    }

    protected function login(LoginRequest $request)
    {
        if ($this->auth->attempt($request->only('email', 'password'))) {
            if(isset($request->next) ){
                $url = '/';
            }else if(isset($request->page)&& $request->page != null  ){
                $url = 'checkout/billing';
            } else if ((trim($request->input('back'), '/') == trim(url('/'), '/')) ||
                (trim($request->input('back'), '/') == trim(url('/login'), '/')) ) {
                $url = '/';
            } else {
                $url = $request->input('back');
            }
            return redirect($url);
        }

        return redirect('login') ->withInput($request->only('email'), 'LoginRequest')
            ->withErrors([ 'password' => 'Email o contraseña incorrecta', ], 'LoginRequest');
    }

    /**
     * Log the user out of the application.
     *
     * @return Response
     */
    protected function logout()
    {
        $log = new LogSession;
        $log->id_person = Auth::user()->id;
        $log->type      = 'LOGOUT';
        $log->ip        = Request::ip();
        $log->url       = Request::url();
        $log->save();

        $this->auth->logout();
        Session::flush();
        return redirect('/');
    }
}