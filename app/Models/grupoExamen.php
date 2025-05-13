<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class grupoExamen extends Model
{
    public function examenes(){
        return $this->belongsToMany(examenes::class);
    }
    public function grupos(){
        return $this->belongsToMany(grupo::class);
    }
}
