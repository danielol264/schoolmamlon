<?php
use App\Http\Controllers\ExamenesController;
use App\Http\Controllers\PreguntasController;
use App\Http\Controllers\CalificacionesController;
use App\Http\Controllers\GrupoController;
use App\Http\Controllers\AlumnoController;
use App\Http\Controllers\MaestroController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('/calificaciones/examen/', [CalificacionesController::class, "examen"])
    ->middleware(['auth','verified'])
    ->name('calificaciones.examen');
Route::resource('/calificaciones', CalificacionesController::class)
    ->middleware(['auth','verified']);

Route::middleware(['auth'])->group(function () {
        Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
        Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    });

Route::get('/grupo/alumno', [GrupoController::class, "alumno"])
    ->middleware(['auth','verified'])
    ->name('grupo.alumno');   
Route::get('/grupo/examen', [GrupoController::class, "examen"])
    ->middleware(['auth','verified'])
    ->name('grupo.examen');
Route::resource('/grupo', GrupoController::class)
    ->middleware(['auth','verified']);
  
Route::post('/examenes/activar/{grupoExamen}',[ExamenesController::class,"activar"])
    ->middleware(['auth','verified'])
    ->name('examenes.activar'); 
Route::post('/examenes/desactivar/{grupoExamen}',[ExamenesController::class,"desactivar"])
    ->middleware(['auth','verified'])
    ->name('examenes.desactivar'); 
Route::post('/examenes/enviar',[ExamenesController::class,"enviar"])
    ->middleware(['auth','verified'])
    ->name('examenes.enviar');  
Route::get('/examenes/responder/{examenes}',[ExamenesController::class,"responder"])
    ->middleware(['auth','verified'])
    ->name('examenes.reponder');  
Route::get('/examenes/examen/',[ExamenesController::class,"examen"])
    ->middleware(['auth','verified'])
    ->name('examenes.examen');  

Route::resource('/examenes',ExamenesController::class)
    ->middleware(['auth','verified']); 
    
Route::resource('/preguntas',PreguntasController::class)
    ->middleware(['auth','verified']);



Route::resource('administracion/alumnos', AlumnoController::class)
    ->middleware(['auth', 'verified'])
    ->names('administracion.alumnos');

Route::post('administracion/alumnos/buscar', [AlumnoController::class, 'buscar'])
    ->middleware(['auth', 'verified'])
    ->name('administracion.alumnos.buscar');


Route::resource('administracion/maestros', MaestroController::class)
    ->middleware(['auth', 'verified'])
    ->names('administracion.maestros');


Route::post('administracion/maestros/buscar', [MaestroController::class, 'buscar'])
    ->middleware(['auth', 'verified'])
    ->name('administracion.maestros.buscar');

Route::resource('administracion/grupos', GrupoController::class)
    ->middleware(['auth', 'verified'])
    ->names('administracion.grupos');


Route::post('administracion/grupos/buscar', [GrupoController::class, 'buscar'])
    ->middleware(['auth', 'verified'])
    ->name('administracion.grupos.buscar');
    
Route::get('/alumno/calificaciones', function () {
    if (Auth::user()->ROL !== 'A') {
        abort(403, 'Acceso no autorizado,No eres un alumno');
    }
        return view('alumno.calificaciones');
    })->middleware(['auth'])->name('alumno.calificaciones');
Route::get('/alumno/examen', function () {
    if (Auth::user()->ROL !== 'A') {
        abort(403, 'Acceso no autorizado,No eres un alumno');
    }
        return view('alumno.examen');
    })->middleware(['auth'])->name('alumno.examen');    
Route::get('/maestro/dashboard', function () {
    if (Auth::user()->ROL !== 'M') {
        abort(403, 'Acceso no autorizado,No eres un maestro');
    }
        return view('maestro.dashboard');
    })->middleware(['auth'])->name('maestro.dashboard');
Route::get('/alumno/dashboard', function () {
    if (Auth::user()->ROL !== 'A') {
        abort(403, 'Acceso no autorizado,No eres un alumno');
    }
    return view('alumno.dashboard');
})->middleware(['auth'])->name('alumno.dashboard');
Route::get('/administracion/dashboard',function(){
    if (Auth::user()->ROL !== 'G') {
        abort(403, 'Acceso no autorizado,No eres un administrador');
    }
    return view('administracion.dashboard');
    })->middleware(['auth'])->name('administracion.dashboard');


Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__.'/auth.php';
