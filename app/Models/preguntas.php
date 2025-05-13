<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class preguntas extends Model
{
    public function respuestas()
{
    return $this->hasMany(Respuesta::class);
}
}
