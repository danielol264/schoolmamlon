<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class examenes extends Model
{
 public function preguntas()
{
    return $this->hasMany(Pregunta::class);
}

public function grupos()
{
    return $this->belongsToMany(Grupo::class, 'grupo_examenes');
}
}
