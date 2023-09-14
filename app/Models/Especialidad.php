<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Especialidad extends Model
{
    use HasFactory;
    protected $fillable = [
        'descripcion',
    ];

    // Definir la relación con la tabla 'personals'
    public function personals()
    {
        return $this->hasMany(Personal::class, 'id_especialidad');
    }
}
