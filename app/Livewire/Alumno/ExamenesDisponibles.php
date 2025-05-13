<?php

namespace App\Livewire\Alumno;

use Livewire\Component;

class ExamenesDisponibles extends Component
{
     public $examenes;

    public function mount()
    {
        // Obtener el usuario autenticado y su modelo de alumno
        $alumno = Alumno::where('user_id', Auth::id())->first();

        if ($alumno && $alumno->grupo) {
            $this->examenes = $alumno->grupo->examenes;
        } else {
            $this->examenes = collect(); // Vacío
        }
    }

    public function render()
    {
        return view('livewire.alumno.examenes-disponibles');
    }
}
