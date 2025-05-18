<?php

namespace App\Http\Controllers;

use App\Models\Alumno; 
use Exception;
use Illuminate\Http\Request;

class AlumnoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
            $alumnos = Alumno::with('grupo') ->get();
            return view('administracion.alumnos.index', compact('alumnos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("administracion.alumnos.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "nombre" => "required|min:5",
            "AP" => "required",
            "AM" => "required",
            "CURP" => "required",
            "FIG" => "required|date|before_or_equal:today",
            "FTG" => "nullable|date|after:FIG|before_or_equal:today"
        ]);

        $nuevoAlumno = new Alumno(); // Cambiado a mayúscula
        $nuevoAlumno->Nombre = $request->nombre;
        $nuevoAlumno->AP = $request->AP;
        $nuevoAlumno->AM = $request->AM;
        $nuevoAlumno->CURP = $request->CURP;
        $nuevoAlumno->FIG = $request->FIG;
        $nuevoAlumno->FTG = null;
        $nuevoAlumno->save();
        session()->flash("mensaje", "Alumno creado con exito");
        return redirect()->route("administracion.alumnos.index");
    }

    /**
     * Display the specified resource.
     */
    public function show(Alumno $alumno) // Cambiado a mayúscula
    {
         $alumno->load('grupo'); // Carga la relación grupo (nota: mantengo "gruppo" como en tu código)
        return view("administracion.alumnos.show", compact('alumno')); // Cambiado a singular
    }

  public function buscar(Request $request)
{
    $termino = $request->input('alumno');
    
    $alumnos = Alumno::where('Nombre', 'LIKE', "%$termino%")
                ->orWhere('AP', 'LIKE', "%$termino%")
                ->orWhere('AM', 'LIKE', "%$termino%")
                ->orWhere('CURP', 'LIKE', "%$termino%")
                ->with('grupo')
                ->get();

    if($alumnos->isEmpty()) {
        session()->flash('mensaje', 'No se encontraron alumnos con ese criterio');
    }

    return view('administracion.alumnos.index', compact('alumnos'));
}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($alumno)
    {
        $alumnoEdit = Alumno::findOrFail($alumno); // Cambiado a mayúscula
        return view("administracion.alumnos.edit", ["alumno" => $alumnoEdit]); // Corregido ruta (plural)
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Alumno $alumno) // Cambiado a mayúscula
    {
        $datos = $request->validate([
            "nombre" => "required|min:5",
            "AP" => "required",
            "AM" => "required",
            "CURP" => "required",
            "FIG" => "required|date|before_or_equal:today",
            "FTG" => "nullable|date|after:FIG|before_or_equal:today"
        ]);

        $alumno->update($request ->all());
        session()->flash("mensaje", "Alumno modificado con exito :D");
        return redirect()->route("administracion.alumnos.index");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Alumno $alumno) // Cambiado a mayúscula
    {
        try {
            $alumno->delete();
            session()->flash("mensaje", "alumno borrado con exito");
        } catch (Exception $e) {
            session()->flash("mensaje", "No se puede borrar al alumno que esta dado de alta en un grupo");
        }
        return redirect()->route("administracion.alumnos.index");
    }


    public function finalizarCurso(Request $request, Alumno $alumno)
    {
    $alumno->FTG = now()->format('Y-m-d');
    $alumno->save();
    
    session()->flash("mensaje", "Alumno marcado como finalizado");
    return redirect()->route("administracion.alumnos.show", $alumno);
    }
}