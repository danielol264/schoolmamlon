<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class alumno extends Model
{

    protected $fillable = [
        'nombre',
        'AP',
        'AM',
        'CURP',
        'FIG',
        'FTG',
        'grupo_id' 
    ];

    public function grupo()
    {
        return $this->belongsTo(Grupo::class, 'grupo_id');
    }
        public function user()
    {
        return $this->hasOne(User::class, 'id_alumno');
    }

}
