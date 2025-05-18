<?php

namespace App\Http\Controllers;

use App\Models\Maestro;
use Illuminate\Http\Request;
use Exception;

class MaestroController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $maestros = Maestro::withCount('grupos')->get();
        return view("administracion.maestros.index", ["maestros" => $maestros]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("administracion.maestros.create");
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
            "CEDULA" => "required",
            "FI" => "required",
        ]);

        $nuevoMaestro = new Maestro();
        $nuevoMaestro->nombre = $request->nombre;
        $nuevoMaestro->AP = $request->AP;
        $nuevoMaestro->AM = $request->AM;
        $nuevoMaestro->CEDULA = $request->CEDULA;
        $nuevoMaestro->FI = $request->FI;
        $nuevoMaestro->save();
        
        session()->flash("mensaje", "Maestro creado con éxito");
        return redirect()->route("administracion.maestros.index");
    }

    /**
     * Display the specified resource.
     */
    public function show(Maestro $maestro)
    {
       $maestro->load('grupos'); 
        return view("administracion.maestros.show", compact('maestro'));

    }

    /**
     * Buscar maestros
     */
    public function buscar(Request $request)
    {
            $searchTerm = $request->input('maestro');
    
            $maestros = Maestro::where('nombre', 'LIKE', "%$searchTerm%")
                ->orWhere('AP', 'LIKE', "%$searchTerm%")
                ->orWhere('AM', 'LIKE', "%$searchTerm%")
                ->orWhere('CEDULA', 'LIKE', "%$searchTerm%")
                ->withCount('grupos')
                ->get();
    
        return view("administracion.maestros.index", ["maestros" => $maestros]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($maestro)
    {
        $maestroEdit = Maestro::findOrFail($maestro);
        return view("administracion.maestros.edit", ["maestro" => $maestroEdit]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Maestro $maestro)
    {
        $datos = $request->validate([
            "nombre" => "required|min:5",
            "AP" => "required",
            "AM" => "required",
            "CEDULA" => "required",
            "FI" => "required",
        ]);

        $maestro->update($datos);
        session()->flash("mensaje", "Maestro modificado con éxito");
        return redirect()->route("administracion.maestros.index");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Maestro $maestro)
    {
        try {
            $maestro->delete();
            session()->flash("mensaje", "Maestro borrado con éxito");
        } 
        catch (Exception $e) {
            session()->flash("mensaje", "No se puede borrar al maestro que está asignado a un grupo");
        }
        return redirect()->route("administracion.maestros.index");
    }
}