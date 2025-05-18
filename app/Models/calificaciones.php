<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class calificaciones extends Model
{
    public function examen()
{
    return $this->belongsTo(examenes::class, 'id_examen');
}

public function alumno()
{
    return $this->belongsTo(alumno::class, 'id_alumno'); // O Alumno::class si tienes modelo separado
}
}
