<?php

namespace App\Http\Controllers;

use App\Models\Grupo;
use App\Models\Alumno;
use App\Models\Maestro;
use App\Models\calificaciones;
use App\Models\grupoExamen;
use App\Models\examenes;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Exists;

class GrupoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $grupos = Grupo::with('maestro') -> get();
        return view ('administracion.grupos.index', ['grupos' => $grupos]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {


    $maestros = Maestro::all();
   
    return view('administracion.grupos.create', [
        'maestros' => $maestros
    ]);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request ->validate([
            'Nombre' => 'required|min:10',
            'id_maestro' => 'required|exists:maestros,id'
        ]);

        $grupo = new Grupo();
        $grupo -> Nombre = $request -> Nombre;
        $grupo -> id_maestro = $request -> id_maestro;
        $grupo -> save();

        session() -> flash ('mensaje', 'El grupo se creo exitosamente');
        return redirect() -> route ('administracion.grupos.index');
    }


      public function buscar(Request $request)
{
        $grupos = Grupo::with('maestro') ->WhereLike('Nombre', "%$request->grupo%")->get();

    return view('administracion.grupos.index',["grupos"=>$grupos]);
}


    /**
     * Display the specified resource.
     */
    public function show(Grupo $grupo)
    {
        $alumnos = Alumno::whereDoesntHave('grupos', function ($query) use ($grupo){
            $query -> where ('grupo_id', $grupo -> id);
        }) -> get();

        return view ('administracion.grupos.show', ['grupo' => $grupo, 'alumnosDisponibles' => $alumnos]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($grupo)
    {
        $grupo = Grupo::Find($grupo);
        $maestros = Maestro::all();
    
    return view('administracion.grupos.edit', [
        'grupo' => $grupo,
        'maestros' => $maestros,
        ]);
    }
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
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Grupo $grupo)
    {
        $validated = $request->validate([
        'nombre' => 'required|string|max:50',
        'maestro_id' => 'required',
    ]);

    $grupo->Nombre = $request->nombre;
    $grupo->id_maestro = $request->maestro_id ;
    $grupo->save();
    return redirect()->route('administracion.grupos.index')
           ->with('mensaje', 'Grupo actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(grupo $grupo)
    {
        try {
            $grupo -> delete();
            session() -> flash ('mensaje', 'Grupo elimindado correctamente');
        }
         catch (Exception $e)
         {
            session() -> flash('mensaje', 'No se puede eliminar el grupo, todavía hay alumnos registrados');
         }
         return redirect() -> route('administracion.grupos.index');
    }

}