<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class grupoExamen extends Model
{
    // app/Models/GrupoExamen.php
public function examen()
    {
        return $this->belongsTo(examenes::class, 'id_examen'); // Filtro adicional por si acaso
    }
    public function grupo(){
        return $this->belongsToMany(grupo::class,'id_grupo');
    }
}
