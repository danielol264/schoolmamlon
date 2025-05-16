<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class grupo extends Model
{
    //
   public function alumnos()
    {
        return $this->hasMany(User::class, 'id_grupo')->where('ROL', 'A');
    }
    public function maestro()
    {
        return $this->belongsTo(Maestro::class, 'id_maestro');
    }
    public function examenes()
{
    return $this->belongsToMany(Examenes::class, 'grupo_examens', 'id_grupo', 'id_examen');
}
    public function user()
    {
        return $this->hasOne(User::class, 'id_grupo');
    }

}
