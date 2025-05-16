<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function show()
    {
        return view('profile');
    }

 
     public function update(Request $request)
    {
        $request->validate([
            'fotoperfil' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048', // Valida que sea una imagen
        ]);

        // Obtener al usuario autenticado
        $user = Auth::user();

        if ($request->hasFile('fotoperfil')) {
            // Si el usuario ha subido una foto, procesarla
            $path = $request->file('fotoperfil')->store('fotoperfiles', 'public');

            // Actualizar la base de datos con la nueva ruta de la foto
            $user->fotoperfil = $path;
            $user->save();
        }

        return redirect()->route('alumno.dashboard')->with('success', 'Foto de perfil actualizada.');
    }
}
