<?php

namespace App\Http\Controllers;

use App\Models\preguntas;
use Illuminate\Http\Request;

class PreguntasController extends Controller
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
    public function show(preguntas $preguntas)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(preguntas $preguntas)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, preguntas $preguntas)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(preguntas $preguntas)
    {
        dd($preguntas->all());
        try{
            $preguntas->delete();
            return redirect()->route('examenes.show', $preguntas->id_examen)->with('success', 'Pregunta eliminada correctamente');
        }catch(\Exception $e){
            return redirect()->route('examenes.show', $preguntas->id_examen)->with('error', 'Pregunta eliminada correctamente');

        }
    }
}
