<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class preguntas extends Model
{
    protected $fillable = ['pregunta', 'tipo', 'id_examen', 'respuestacrt'];
        public function respuestas()
    {
        return $this->hasOne(Respuestas::class, 'id_respuesta');
    }
}
