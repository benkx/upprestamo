<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
#use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\Usuarios;
use Illuminate\Support\Facades\Hash;

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


    

    // use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request){
       
        #dd($request->all()); 
       
        $credentials = $request->validate([
            'nomusuario' => 'required|string',
            'contrasena' => 'required|string'
        ]);

        if (Auth::attempt(['nomusuario' => $credentials['nomusuario'], 'contrasena' => $credentials['contrasena']])) {

            $request->session()->regenerate();
            return redirect()->intended($this->redirectTo);
        }

        return back()->withErrors([
            'nomusuario' => 'The provided credentials do not match our records.',
        ]);

        

    }

    public function logout()
    {
        Auth::guard('web')->logout();

        return redirect('/login');
    }

   
}
