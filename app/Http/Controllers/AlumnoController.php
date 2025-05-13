<?php

namespace App\Http\Controllers;

use App\Models\alumno;
use Illuminate\Http\Request;


class AlumnoController extends Controller
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
    public function show(alumno $alumno)
    {
         $grupos=grupo::all(); 
       $examen=examenes::findorfail($id);
       $grupo=grupoExamen::where('id_examen',$examen->id)->first();
       $preguntas=preguntas::where('id_examen',$examen->id)->get();
       $respuestas=[];
         foreach ($preguntas as $pregunta) {
                $respuestas[$pregunta->id] = respuestas::where('id_pregunta', $pregunta->id)->get();
          }
        
    return view('maestro.examenes.show',["examen"=>$examen,"grupo"=>$grupo,"grupos"=>$grupos,"preguntas"=>$preguntas,"respuestas"=>$respuestas]);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(alumno $alumno)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, alumno $alumno)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(alumno $alumno)
    {
        //
    }
    
}
