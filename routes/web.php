<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

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
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__.'/auth.php';
