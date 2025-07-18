<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Usuarios;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{

    
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

   # use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

     /**
     * Muestra el formulario de registro.
     *
     * @return \Illuminate\View\View
     */
     // Otros métodos como showRegistrationForm() si los necesitas
     public function showRegistrationForm()
     {
         return view('auth.register');
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
            'nomusuario' => ['required', 'string', 'max:255', 'unique:usuarios'], // <--- 'unique:usuarios' para tu tabla
            'constrasena' => ['required', 'string', 'min:8', 'confirmed'], //
            'constrasena_confirmation' => ['required', 'string', 'min:8'], // Confirmación de contraseña
            'nomcompleto' => ['required', 'string', 'max:255'],
            'estado' => ['nullable', 'in:Activo,Inactivo'], // Estado opcional
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\Usuarios
     */
    protected function create(array $data)
    {
        return Usuarios::create([
           'nomusuario' => $data['nomusuario'],
            'constrasena' => Hash::make($data['constrasena']),
            'nomcompleto' => $data['nomcompleto'],
            'estado' => $data['estado'] ?? null, // Manejo explícito de null
        ]);
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        // Aquí puedes personalizar más el proceso si es necesario
        $user = $this->create($request->all());

        Auth::guard()->login($user);

        return redirect($this->redirectTo)->with('success', '¡Registro exitoso!');
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
