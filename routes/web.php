<?php
use App\Http\Controllers\ExamenesController;
use App\Http\Controllers\PreguntasController;
use App\Http\Controllers\CalificacionesController;
use App\Http\Controllers\GrupoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AlumnoController;
use App\Http\Controllers\MaestroController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/administracion/register', [UserController::class, "register"])
            ->middleware(['auth','verified'])
            ->name('administracion.register');

            Route::resource('/user',UserController::class)
            ->middleware(['auth','verified']);

Route::middleware(['auth', 'verified','rol.admin'])->group(function () {

    
        Route::get('/administracion/actualizarContraseña/{user}', [UserController::class, "actualizarContraseña"])
        ->middleware(['auth','verified'])
        ->name('administracion.actualizarContraseña');   
           
            Route::resource('administracion/alumnos', AlumnoController::class)
            ->middleware(['auth', 'verified'])
            ->names('administracion.alumnos');

        Route::post('administracion/alumnos/buscar', [AlumnoController::class, 'buscar'])
            ->middleware(['auth', 'verified'])
            ->name('administracion.alumnos.buscar');

        Route::get('/administracion/register', [UserController::class, "register"])
            ->middleware(['auth','verified'])
            ->name('administracion.register');

            Route::resource('/user',UserController::class)
            ->middleware(['auth','verified']);
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
        Route::get('/administracion/dashboard',function(){
            return view('administracion.dashboard');
            })->middleware(['auth'])->name('administracion.dashboard');
        });
Route::middleware(['auth', 'verified','rol.maestro'])->group(function () {

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
            Route::resource('/examenes',ExamenesController::class)
            ->middleware(['auth','verified']); 
            
        Route::resource('/preguntas',PreguntasController::class)
            ->middleware(['auth','verified']);
        Route::get('/calificaciones/examen/', [CalificacionesController::class, "examen"])
        ->middleware(['auth','verified'])
        ->name('calificaciones.examen');
        Route::get('/maestro/dashboard', function () {
            return view('maestro.dashboard');
            })->middleware(['auth'])->name('maestro.dashboard');
        Route::get('/examenes/examen/',[ExamenesController::class,"examen"])
            ->middleware(['auth','verified'])
            ->name('examenes.examen'); 
            Route::resource('/calificaciones', CalificacionesController::class)
            ->middleware(['auth','verified']);
        Route::resource('/examenes',ExamenesController::class)
            ->middleware(['auth','verified']); 
            
        Route::resource('/preguntas',PreguntasController::class)
            ->middleware(['auth','verified']);
        Route::resource('/grupo', GrupoController::class)
            ->middleware(['auth','verified']); 
        Route::resource('/calificaciones', CalificacionesController::class)
            ->middleware(['auth','verified']);
        Route::resource('/examenes',ExamenesController::class)
            ->middleware(['auth','verified']); 
    });


Route::middleware(['auth', 'verified','rol.alumno'])->group(function () {

            Route::middleware(['auth'])->group(function () {
                Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
                Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
            });
            Route::get('/alumno/calificaciones', function () {

                    return view('alumno.calificaciones');
                })->middleware(['auth'])->name('alumno.calificaciones');
            Route::get('/alumno/examen', function () {
                    return view('alumno.examen');
                })->middleware(['auth'])->name('alumno.examen');    
            
            Route::get('/alumno/dashboard', function () {
                return view('alumno.dashboard');
            })->middleware(['auth'])->name('alumno.dashboard');
            Route::get('/calificaciones/examen/', [CalificacionesController::class, "examen"])
            ->middleware(['auth','verified'])
            ->name('calificaciones.examen');
            Route::post('/examenes/enviar',[ExamenesController::class,"enviar"])
            ->middleware(['auth','verified'])
            ->name('examenes.enviar');
            Route::get('/examenes/responder/{examenes}',[ExamenesController::class,"responder"])
            ->middleware(['auth','verified'])
            ->name('examenes.reponder');  

            Route::resource('/calificaciones', CalificacionesController::class)
                ->middleware(['auth','verified']);
            Route::resource('/examenes',ExamenesController::class)
                ->middleware(['auth','verified']);    
            Route::resource('/preguntas',PreguntasController::class)
                ->middleware(['auth','verified']);
            Route::resource('/grupo', GrupoController::class)
                ->middleware(['auth','verified']);
            });
        Route::get('/calificaciones/examen/', [CalificacionesController::class, "examen"])
            ->middleware(['auth','verified'])
            ->name('calificaciones.examen');
        Route::resource('/preguntas',PreguntasController::class)
            ->middleware(['auth','verified']);
        Route::resource('/grupo', GrupoController::class)
            ->middleware(['auth','verified']); 
        Route::resource('/calificaciones', CalificacionesController::class)
            ->middleware(['auth','verified']);
        Route::resource('/examenes',ExamenesController::class)
            ->middleware(['auth','verified']); 
Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__.'/auth.php';
