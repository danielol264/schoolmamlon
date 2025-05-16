<?php

namespace App\Http\Controllers;

use App\Models\calificaciones;
use App\Models\examenes;
use App\Models\grupo;
use App\Models\preguntas;
use App\Models\respuestas;
use App\Models\grupoExamen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExamenesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $examenes= examenes::all();
        
        return view('maestro.examenes.index' ,["examenes"=>$examenes]);
    }

    public function responder(examenes $examenes){ 
        $examen=$examenes;
        $grupo=grupoExamen::where('id_examen',$examen->id)->first();
        $preguntas=preguntas::where('id_examen',$examen->id)->get();
        $respuestas=[];
         foreach ($preguntas as $pregunta) {
                $respuestas[$pregunta->id] = respuestas::where('id_pregunta', $pregunta->id)->where('id_maestro',$examen->id_maestro)->get();
          }
        return view('alumno.responder',["examen"=>$examenes,"grupo"=>$grupo,"preguntas"=>$preguntas,"respuestas"=>$respuestas]);
    }
    public function enviar(Request $request){
        $cantidadPreguntas=0;
        $preguntasCorrectas=0;
        $calificacion=0;
        try{
            foreach ($request->respuestas as $preguntaId => $valorRespuesta) {
                $respuesta= new respuestas();
                $respuesta->id_alumno=$request->alumno_id;
                $respuesta->id_pregunta=$preguntaId;
                $respuesta->respuesta=$valorRespuesta;
                $respuesta->save();
                $cantidadPreguntas++;
                $preguntas=preguntas::where('id_pregunta',$preguntaId)->get();
                $preguntas->respuestacrt==$valorRespuesta ? $preguntasCorrectas++ : null ;
            }
            $calificacionTotal=($preguntasCorrectas*10)/$cantidadPreguntas; 
            $califcacion=new calificaciones();
            $califcacion->calificacion=$calificacionTotal;
            $califcacion->id_examen=$request->examen_id;
            $califcacion->id_alumno=$request->alumno_id;
            $califcacion->save();
        }  
        catch(\Exception $e){

        }
        return redirect()->route('alumno.examen');
    }
    public function create(Request $Request)
    {
        $grupos=grupo::where("id_maestro", "=", $Request->maestro)->get();
        return view('maestro.examenes.create',["grupos"=>$grupos]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
           
       
        try { // Añadir esto
        $examen=new examenes();
        $examen->nombre=$request->nombre;
        $examen->id_maestro=$request->maestro;
        $examen->save();
        $examengrupo= new grupoExamen();
        $examengrupo->id_examen=$examen->id;
        $examengrupo->id_grupo=$request->grupo;
        $examengrupo->save();
        foreach ($request->preguntas as $preguntaData) {
                $pregunta = new preguntas();
                $pregunta->pregunta = $preguntaData['texto'];
                $pregunta->id_examen = $examen->id;
                $pregunta->tipo = $preguntaData['tipo'];
                $pregunta->save();
                switch($preguntaData['tipo']) {
                    case 'o':
                        foreach ($preguntaData['respuestas'] as $index => $textoRespuesta) {
                            $respuesta = new respuestas();
                            if ($index==0){
                                break;
                            }
                            $respuesta->respuesta = $textoRespuesta;
                            $respuesta->id_pregunta = $pregunta->id;
                            $respuesta->id_maestro = $request->maestro;
                            $respuesta->save();
                            
                            if ($index == $preguntaData['correcta']) {
                                $pregunta->respuestacrt =  $textoRespuesta;
                                $pregunta->save();
                            }
                        }
                        break;

                    case 't':
                        $pregunta->respuestacrt = ($preguntaData['correcta'] === 'verdadero')?'true':'false';
                        $pregunta->save();
                        break;

                    case 'a':
                        if (!empty($preguntaData['respuestas'][0])) {
                            $pregunta->respuestacrt = $preguntaData['respuestas'][0];
                            $pregunta->save();
                        }
                        break;
                }
        }
        
        session()->flash('success','Examen creado con exito');
        return redirect()->route('examenes.index');

        }
        catch(\Exception $e){
            DB::rollBack(); 
            session()->flash('error', 'Error al crear el examen');
            return redirect()->route('examenes.index');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
       $grupos=grupo::all(); 
       $examen=examenes::findorfail($id);
       $grupo=grupoExamen::where('id_examen',$examen->id)->first();
       $preguntas=preguntas::where('id_examen',$examen->id)->get();
       $respuestas=[];
         foreach ($preguntas as $pregunta) {
                $respuestas[$pregunta->id] = respuestas::where('id_pregunta', $pregunta->id)->where('id_maestro',$examen->id_maestro)->get();
          }
        
    return view('maestro.examenes.show',["examen"=>$examen,"grupo"=>$grupo,"grupos"=>$grupos,"preguntas"=>$preguntas,"respuestas"=>$respuestas]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $grupos=grupo::all(); 
        $examen=examenes::findorfail($id);
        $grupo=grupoExamen::where('id_examen',$examen->id)->first();
        $preguntas=preguntas::where('id_examen',$examen->id)->get();
        $respuestas=[];
        foreach ($preguntas as $pregunta) {
                $respuestas[$pregunta->id] = respuestas::where('id_pregunta', $pregunta->id)->where('id_maestro',$examen->id_maestro)->get();
        }
        
        return view('maestro.examenes.edit',["examen"=>$examen,"grupo"=>$grupo,"grupos"=>$grupos,"preguntas"=>$preguntas,"respuestas"=>$respuestas]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        
        try {
            dd($request->all());
            // 1. Actualizar el examen principal
            $examen = Examenes::findOrFail($id);
            $examen->nombre = $request->nombre;
            $examen->save();
            
            // 2. Actualizar el grupo del examen
            $grupoExamen = GrupoExamen::where('id_examen', $examen->id)->first();
            $grupoExamen->id_grupo = $request->grupo;
            $grupoExamen->save();
            
            // 3. Procesar preguntas existentes y nuevas
            foreach ($request->preguntas as $preguntaId => $preguntaData) {
                // Determinar si es pregunta existente o nueva
                if (strpos($preguntaId, 'nueva_') === 0) {
                    // Pregunta nueva
                    $pregunta = new Preguntas();
                } else {
                    // Pregunta existente
                    $pregunta = Preguntas::findOrFail($preguntaId);
                }
                
                $pregunta->pregunta = $preguntaData['texto'];
                $pregunta->tipo = $preguntaData['tipo'];
                $pregunta->id_examen = $examen->id;
                
                // Procesar según el tipo de pregunta
                switch ($preguntaData['tipo']) {
                    case 'o': // Opción múltiple
                        // Primero guardar la pregunta para obtener ID
                        $pregunta->save();
                        
                        // Procesar respuestas
                        foreach ($preguntaData['respuestas'] as $respuestaId => $respuestaData) {
                            // Determinar si es respuesta existente o nueva
                            if (strpos($respuestaId, 'nuevo_') === 0) {
                                $respuesta = new Respuestas();
                            } else {
                                $respuesta = Respuestas::findOrFail($respuestaId);
                            }
                            
                            $respuesta->respuesta = $respuestaData['texto'];
                            $respuesta->id_pregunta = $pregunta->id;
                            $respuesta->id_maestro = $request->maestro;
                            $respuesta->save();
                            
                            // Marcar respuesta correcta
                            if ($respuestaId == $preguntaData['correcta']) {
                                $pregunta->respuestacrt = $respuesta->respuesta;
                                $pregunta->save();
                            }
                        }
                        break;
                        
                    case 't': // Verdadero/Falso
                        $pregunta->respuestacrt = ($preguntaData['correcta'] === 'verdadero') ? 'true' : 'false';
                        $pregunta->save();
                        break;
                        
                    case 'a': // Respuesta abierta
                        $pregunta->respuestacrt = $preguntaData['respuesta_abierta'] ?? null;
                        $pregunta->save();
                        break;
                }
            }
            
            DB::commit();
            
            return redirect()->route('examenes.index')
                ->with('mensaje', 'Examen actualizado correctamente');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Error al actualizar el examen: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {   
        try {
            $examen = examenes::findOrFail($id);
            $examen->delete();
            session()->flash('success', 'Examen eliminado con éxito');  
            return redirect()->route('examenes.index');
                
        } catch (\Exception $e) {
            session()->flash('error', 'Error al eliminar el examen');
            return redirect()->route('examenes.index');
        }
    }
}
