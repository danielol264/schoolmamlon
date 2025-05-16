<?php
use App\Http\Controllers\ExamenesController;
use App\Http\Controllers\PreguntasController;
use App\Http\Controllers\CalificacionesController;
use App\Http\Controllers\GrupoController;
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
  
Route::post('/examenes/enviar',[ExamenesController::class,"enviar"])
    ->middleware(['auth','verified'])
    ->name('examenes.enviar');  
Route::get('/examenes/responder/{examenes}',[ExamenesController::class,"responder"])
    ->middleware(['auth','verified'])
    ->name('examenes.reponder');  
Route::resource('/examenes',ExamenesController::class)
    ->middleware(['auth','verified']); 
    
Route::resource('/preguntas',PreguntasController::class)
    ->middleware(['auth','verified']);

    
Route::get('/alumno/examen', function () {
        return view('alumno.examen');
    })->middleware(['auth'])->name('alumno.examen');    
Route::get('/maestro/dashboard', function () {
        return view('maestro.dashboard');
    })->middleware(['auth'])->name('maestro.dashboard');
Route::get('/alumno/dashboard', function () {
        return view('alumno.dashboard');
    })->middleware(['auth'])->name('alumno.dashboard');
Route::get('/administracion/dashboard',function(){
    return view('administracion.dashboard');
    })->middleware(['auth'])->name('administracion.dashboard');


Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__.'/auth.php';
