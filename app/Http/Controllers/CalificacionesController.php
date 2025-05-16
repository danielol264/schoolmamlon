<?php

namespace App\Http\Controllers;

use App\Models\calificaciones;
use App\Models\grupo;
use App\Models\alumno;
use App\Models\grupoExamen;
use App\Models\examenes;
use App\Models\preguntas;
use App\Models\respuestas;
use Illuminate\Http\Request;

class CalificacionesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    
       $grupos = Grupo::with('alumnos','examenes')->get();
        
       
        return view('maestro.calificaciones.index',["grupos"=>$grupos]);
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
    public function examen(Request $request)
    {
        $grupo=grupo::where('id','=',$request->grupo_id)->first();
        $examen=examenes::findorfail($request->examen_id);
        $grupoEx=grupoExamen::where('id_examen',$examen->id)->first();
        $preguntas=preguntas::where('id_examen',$examen->id)->get();
        $respuestas=[];
         foreach ($preguntas as $pregunta) {
                $respuestas[$pregunta->id] = respuestas::where('id_pregunta', $pregunta->id)->where('id_maestro',$examen->id_maestro)->get();
          }
        $respuestasAlumno=[];
        foreach ($preguntas as $pregunta) {
                $respuestasAlumno[$pregunta->id] = respuestas::where('id_pregunta', $pregunta->id)->where('id_alumno',$request->alumno_id)->get();
          }
        $calificaciones=calificaciones::where('id_examen',$examen->id)->where('id_alumno',$request->alumno_id)->first();
        return view('maestro.calificaciones.examen',["examen"=>$examen,"grupo"=>$grupo,"gruposEx"=>$grupoEx,"preguntas"=>$preguntas,"respuestas"=>$respuestas,"respuestasAlumno"=>$respuestasAlumno,"calificaciones"=>$calificaciones]);

    }
    /**
     * Display the specified resource.
     */
    public function show(calificaciones $calificaciones)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(calificaciones $calificaciones)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, calificaciones $calificaciones)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(calificaciones $calificaciones)
    {
        //
    }
}
