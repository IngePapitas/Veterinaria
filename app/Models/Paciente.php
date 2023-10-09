<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Paciente extends Model
{
    use HasFactory;
    protected $table = 'pacientes';

    public function especie()
    {
        return $this->belongsTo(Especie::class, 'id_especie');
    }

    public function raza()
    {
        return $this->belongsTo(Raza::class, 'id_raza');
    }   
    public static function getTabla()
{
    $results = DB::table('pacientes')
        ->select('pacientes.id','pacientes.nombre', 'pacientes.peso', 'pacientes.tamano',
         'pacientes.imagen_path', 'razas.nombre as raza', 'especies.nombre as especie', 'especies.imagen_path as especie_imagen')
        ->leftJoin('especies', 'especies.id', '=', 'pacientes.id_especie')
        ->leftJoin('razas', 'razas.id_especie', '=', 'especies.id')
        ->orderBy('pacientes.nombre') 
        ->get();

    return $results;
}

}
