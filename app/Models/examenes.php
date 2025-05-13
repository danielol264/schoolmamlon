<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class examenes extends Model
{
    public function maestro()
{
    return $this->belongsTo(Maestro::class, 'id_maestro'); 
}

public function grupos()
{
    return $this->belongsToMany(Grupo::class, 'grupo_examens', 'id_examen', 'id_grupo');
}
}
