<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Raza extends Model
{
    use HasFactory;
    protected $table = 'razas';

    public function especie()
    {
        return $this->belongsTo(Especie::class, 'id_especie');
    }

    public function pacientes()
    {
        return $this->hasMany(Paciente::class, 'id_raza');
    }
}
