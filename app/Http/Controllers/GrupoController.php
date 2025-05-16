<?php

namespace App\Http\Controllers;

use App\Models\grupo;
use App\Models\examenes;
use App\Http\Controllers\AlumnoController;
use App\Models\alumno;
use App\Models\calificaciones;
use App\Models\grupoExamen;
use Illuminate\Http\Request;

class GrupoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function alumno(Request $request)
    {
        $examenes=grupoExamen::where('id_grupo','=',$request->grupo_id)->get();
        $examengrupo=[];
        foreach ($examenes as $examen){
            $examengrupo[$examen->id_examen]=examenes::where('id',$examen->id_examen)->first();
        }
        $alumno=alumno::where('id','=',$request->alumno_id)->first();
        $calificaciones=calificaciones::where('id_alumno',$alumno->id)->get();
        return view('maestro.calificaciones.alumno',["examenes"=>$examengrupo,"alumno"=>$alumno,"calificaciones"=>$calificaciones,"grupo"=>$request->grupo_id]);
    }
    public function examen(Request $request){

         $grupo = grupo::with('alumnos')->find($request->grupo_id);
        $examen = examenes::findOrFail($request->examen_id);
         
        return view('maestro.calificaciones.show',["grupo"=>$grupo,"examen"=>$examen]);
    }
    public function show(grupo $grupo)
    {
        //
    }
    
        
    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(grupo $grupo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, grupo $grupo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(grupo $grupo)
    {
        //
    }
}
