<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class maestro extends Model
{
    //
        public function user()
    {
        return $this->hasOne(User::class, 'id_maestro');
    }
    public function grupos()
    {
        return $this->hasMany(Grupo::class, 'id_maestro');
    }
    public function examenes()
{
    return $this->hasMany(Examenes::class, 'id_maestro'); // Exámenes creados por el maestro
}

}
