<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class alumno extends Model
{
    public function user()
    {
        return $this->hasOne(User::class, 'id_alumno');
    }

    public function grupo()
{
    return $this->belongsTo(Grupo::class);
}
}
