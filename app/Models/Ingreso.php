<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ingreso extends Model
{

    protected $table = 'ingreso';

    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class, 'estudianteId');
    }
}
