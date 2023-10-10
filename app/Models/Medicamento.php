<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicamento extends Model
{
    use HasFactory;
    protected $fillable = [
        'nombre','descripcion','forma_farmaceutica','dosis','precio','stock','id_laboratorio','id_categoriamedicamento',
    ];
    //Relacion con laboratorio
    public function laboratorio()
    {
        return $this->belongsTo(Laboratorio::class, 'id_laboratorio');
    }
    //relacion con la categoria de medicamento
    public function categoriaMedicamento()
    {
        return $this->belongsTo(CategoriaMedicamento::class, 'id_categoriamedicamento');
    }
}
