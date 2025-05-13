<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class grupo extends Model
{
    public function user()
    {
        return $this->hasOne(User::class, 'id_grupo');
    }

    public function examenes()
{
    return $this->belongsToMany(Examen::class, 'grupo_examenes', 'grupo_id', 'examen_id');
}
}
