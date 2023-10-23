<?php

namespace App\Models;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Personal extends Model
{
    use HasFactory;
    protected $fillable = [
        'ci','nombre', 'imagen_path', 'telefono', 'sueldo', 'estado', 'baja', 'id_especialidad',
    ];

    // Definir la relación con la tabla 'especialidades'
    public function especialidad()
    {
        return $this->belongsTo(Especialidad::class, 'id_especialidad');
    }

    

}
