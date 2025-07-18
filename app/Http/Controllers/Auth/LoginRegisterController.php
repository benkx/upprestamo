<?php

namespace App\Http\Controllers\Auth;

use App\Models\Usuarios;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
#echo Hash::make('Up123123');
class LoginRegisterController extends Controller
{
    /**
     * Instantiate a new LoginRegisterController instance.
     */
    public function __construct()
    {
        $this->middleware('guest')->except([
            'logout', 'home'
        ]);
    }

    

    public function register()
    {
        return view('auth.register');
    }

    /**
     * Store a new user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
          'nomusuario' => 'required|string',
            'contrasena' => 'required|string',
            'nomcompleto' => 'required|string',
            'estado' => 'nullable|in:Activo,Inactivo',
        ]);

        Usuarios::create([
            'nomusuario' => $request->nomusuario,
            'contrasena' => Hash::make($request->contrasena),
            'nomcompleto' => $request->nomcompleto,
            'estado' => $request->estado ?? null, // Manejo explícito de null
        ]);

        $credentials = $request->only('nomusuario', 'contrasena', 'nomcompleto', 'estado');
        Auth::attempt($credentials);
        $request->session()->regenerate();
        return redirect()->route('app')
        ->withSuccess('You have successfully registered & logged in!');
    }

    
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Authenticate the usuario.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function authenticate(Request $request): RedirectResponse    
    {
        #dd($request->all());
        $credentials = $request->validate([
             'nomusuario' => 'required|string',
             'contrasena' => 'required|string'
        ]);
       # $credentials = $request->only('nomusuario', 'contrasena');

       if (Auth::attempt([
        'nomusuario' => $credentials['nomusuario'],
        'password' => $credentials['contrasena'] // ¡CAMBIADO DE 'contrasena' A 'password'!
        ])) {
            $request->session()->regenerate();
            return redirect()->route('home');
        }

        return back()->withErrors([
            'nomusuario' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
        ])->onlyInput('nomusuario');
    } 
    
   
    public function dashboard()
    {
        if(Auth::check())
        {
            return view('auth.home');
        }
        
        return redirect()->route('login')
            ->withErrors([
            'nomusuario' => 'Please login to access the dashboard.',
        ])->onlyInput('nomusuario');
    } 
    
    /**
     * Log out the user from application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')
            ->withSuccess('You have logged out successfully!');;
    }    

       /**
     * Get the guard to be used during registration.
     * Esto asegura que se use el guard configurado en auth.php
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('web'); // Asegúrate de que 'web' sea el guard que configuraste para 'usuarios'
    }

}