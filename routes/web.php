<?php

use App\Http\Controllers\DetalleprestamoController;
use App\Http\Controllers\DocentesController;
use App\Http\Controllers\EquiposController;
use App\Http\Controllers\PeriodoacademicoController;
use App\Http\Controllers\PrestamosController;
use App\Http\Controllers\SolimantenimientoController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UbicacionController;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LoginRegisterController;
use App\Http\Controllers\Auth\RegisterController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [LoginRegisterController::class, 'showLogin'])->name('login');
Route::post('/login', [LoginRegisterController::class, 'authenticate']);
Route::post('/logout', [LoginRegisterController::class, 'logout'])->name('logout');
Route::get('/register', [LoginRegisterController::class, 'register'])->name('register');
Route::post('/store', [LoginRegisterController::class, 'store'])->name('store');
Route::get('/home', [LoginRegisterController::class, 'dashboard'])->name('dashboard');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.post');
// Route::controller(LoginRegisterController::class)->group(function() {
//     Route::get('/register', 'register')->name('register');
//     Route::post('/store', 'store')->name('store');
//     Route::get('/login', 'showLogin')->name('login');
//     Route::post('/login', 'login')->name('login');
//     Route::get('/dashboard', 'dashboard')->name('dashboard');
    // Route::post('/logout', 'logout')->name('logout');
// });

// Route::middleware(['auth'])->group(function () {
//     Route::get('/dashboard', function () {
//         return view('dashboard');
//     });
// });

Route::resource('ubicacion', UbicacionController::class);
Route::get('/ubicacion', [UbicacionController::class, 'index'])->name('ubicacion.index');
Route::get('/ubicacion/create', [UbicacionController::class, 'create'])->name('ubicacion.create');
Route::post('/ubicacion', [UbicacionController::class, 'store'])->name('ubicacion.store');
Route::get('/ubicacion/{idubicacion}', [UbicacionController::class, 'show'])->name('ubicacion.show');
Route::get('/ubicacion/{idubicacion}/edit', [UbicacionController::class, 'edit'])->name('ubicacion.edit');
Route::put('/ubicacion/{idubicacion}', [UbicacionController::class, 'update'])->name('ubicacion.update');
Route::delete('/ubicacion/{id}', [UbicacionController::class, 'destroy'])->name('ubicacion.destroy');


Route::resource('docentes', DocentesController::class);
Route::get('/docentes', [DocentesController::class, 'index'])->name('docentes.index');
Route::get('/docentes/create', [DocentesController::class, 'create'])->name('docentes.create');
Route::post('/docentes', [DocentesController::class, 'store'])->name('docentes.store');
Route::get('/docentes/{iddocente}', [DocentesController::class, 'show'])->name('docentes.show');
Route::get('/docentes/{iddocente}/edit', [DocentesController::class, 'edit'])->name('docentes.edit');
Route::put('/docentes/{iddocente}', [DocentesController::class, 'update'])->name('docentes.update');
Route::delete('/docentes/{id}', [DocentesController::class, 'destroy'])->name('docentes.destroy');

route::resource('usuarios', UsuariosController::class);
Route::get('/usuarios', [UsuariosController::class, 'index'])->name('usuarios.index');
Route::get('/usuarios/create', [UsuariosController::class, 'create'])->name('usuarios.create');
Route::post('/usuarios', [UsuariosController::class, 'store'])->name('usuarios.store');
Route::get('/usuarios/{idusuario}', [UsuariosController::class, 'show'])->name('usuarios.show');
Route::get('/usuarios/{idusuario}/edit', [UsuariosController::class, 'edit'])->name('usuarios.edit');
Route::put('/usuarios/{idusuario}', [UsuariosController::class, 'update'])->name('usuarios.update');
Route::delete('/usuarios/{id}', [UsuariosController::class, 'destroy'])->name('usuarios.destroy');

route::resource('equipos', EquiposController::class);
Route::get('/equipos', [EquiposController::class, 'index'])->name('equipos.index');
Route::get('/equipos/create', [EquiposController::class, 'create'])->name('equipos.create');
Route::post('/equipos', [EquiposController::class, 'store'])->name('equipos.store');
Route::get('/equipos/{idequipo}', [EquiposController::class, 'show'])->name('equipos.show');
Route::get('/equipos/{idequipo}/edit', [EquiposController::class, 'edit'])->name('equipos.edit');
route::put('/equipos/{idequipo}', [EquiposController::class, 'update'])->name('equipos.update');
Route::delete('/equipos/{id}', [EquiposController::class, 'destroy'])->name('equipos.destroy');

route::resource('periodoacademico', PeriodoacademicoController::class);
Route::get('/periodoacademico', [PeriodoacademicoController::class, 'index'])->name('periodoacademico.index');
Route::get('/periodoacademico/create', [PeriodoacademicoController::class, 'create'])->name('periodoacademico.create');
Route::post('/periodoacademico', [PeriodoacademicoController::class, 'store'])->name('periodoacademico.store');
Route::get('/periodoacademico/{idperoacademico}', [PeriodoacademicoController::class, 'show'])->name('periodoacademico.show');
Route::get('/periodoacademico/{idperoacademico}/edit', [PeriodoacademicoController::class, 'edit'])->name('periodoacademico.edit');
Route::put('/periodoacademico/{idperoacademico}', [PeriodoacademicoController::class, 'update'])->name('periodoacademico.update');
Route::delete('/periodoacademico/{id}', [PeriodoacademicoController::class, 'destroy'])->name('periodoacademico.destroy');

route::resource('solimantenimiento', SolimantenimientoController::class);
Route::get('/solimantenimiento', [SolimantenimientoController::class, 'index'])->name('solimantenimiento.index');
Route::get('/solimantenimiento/create', [SolimantenimientoController::class, 'create'])->name('solimantenimiento.create');
Route::post('/solimantenimiento', [SolimantenimientoController::class, 'store'])->name('solimantenimiento.store');
Route::get('/solimantenimiento/{idsolicitud}', [SolimantenimientoController::class, 'show'])->name('solimantenimiento.show');
Route::get('/solimantenimiento/{idsolicitud}/edit', [SolimantenimientoController::class, 'edit'])->name('solimantenimiento.edit');
Route::put('/solimantenimiento/{idsolicitud}', [SolimantenimientoController::class, 'update'])->name('solimantenimiento.update');
Route::delete('/solimantenimiento/{id}', [SolimantenimientoController::class, 'destroy'])->name('solimantenimiento.destroy');

route::resource('prestamos', PrestamosController::class);
Route::get('/prestamos', [PrestamosController::class, 'index'])->name('prestamos.index');
route::get('/prestamos/create', [PrestamosController::class, 'create'])->name('prestamos.create');
Route::post('/prestamos', [PrestamosController::class, 'store'])->name('prestamos.store');
Route::get('/prestamos/{idprestamo}', [PrestamosController::class, 'show'])->name('prestamos.show');
// Route::get('/prestamos/{idprestamo}/edit', [PrestamosController::class, 'edit'])->name('prestamos.edit');
// Route::put('/prestamos/{idprestamo}', [PrestamosController::class, 'update'])->name('prestamos.update');
Route::delete('/prestamos/{id}', [PrestamosController::class, 'destroy'])->name('prestamos.destroy');

Route::get('/prestamos/{prestamo}/edit', [PrestamosController::class, 'edit'])->name('prestamos.edit');
Route::put('/prestamos/{prestamo}', [PrestamosController::class, 'update'])->name('prestamos.update');

route::resource('detalleprestamo', DetalleprestamoController::class);
Route::get('/detalleprestamo', [DetalleprestamoController::class, 'index'])->name('detalleprestamo.index');
Route::get('/detalleprestamo/create', [DetalleprestamoController::class, 'create'])->name('detalleprestamo.create');
Route::post('/detalleprestamo', [DetalleprestamoController::class, 'store'])->name('detalleprestamo.store');
Route::get('/detalleprestamo/{iddetalle}', [DetalleprestamoController::class, 'show'])->name('detalleprestamo.show');
Route::get('/detalleprestamo/{iddetalle}/edit', [DetalleprestamoController::class, 'edit'])->name('detalleprestamo.edit');
Route::put('/detalleprestamo/{iddetalle}', [DetalleprestamoController::class, 'update'])->name('detalleprestamo.update');
Route::delete('/detalleprestamo/{id}', [DetalleprestamoController::class, 'destroy'])->name('detalleprestamo.destroy');
#Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
