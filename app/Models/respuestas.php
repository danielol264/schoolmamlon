<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class respuestas extends Model
{
    protected $fillable = ['respuesta', 'id_pregunta', 'id_maestro', 'id_alumno'];
    public function pregunta()
{
    return $this->belongsTo(Preguntas::class, 'id_pregunta');
}
}
