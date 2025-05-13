<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');
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
        Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
        Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    });

    Route::get('/alumno/examen/{id}', function ($id) {
    $examen = App\Models\Examen::findOrFail($id);

    // Obtener grupo del examen (puedes hacerlo si hay relación definida)
    $grupo = $examen->grupos()->first(); // O como lo tengas
    $preguntas = $examen->preguntas;

    // Preparar respuestas por pregunta
    $respuestas = [];
    foreach ($preguntas as $pregunta) {
        $respuestas[$pregunta->id] = $pregunta->respuestas;
    }

    return view('alumno.examenes-disponibles', compact('examen', 'grupo', 'preguntas', 'respuestas'));
})->name('alumno.examen');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__.'/auth.php';
