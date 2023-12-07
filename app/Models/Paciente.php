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
            ->select(
                'pacientes.id',
                'pacientes.nombre',
                'pacientes.peso',
                'pacientes.tamano',
                'pacientes.imagen_path',
                'razas.nombre as raza',
                'especies.nombre as especie',
                'especies.imagen_path as especie_imagen'
            )
            ->leftJoin('razas', 'razas.id', '=', 'pacientes.id_raza')
            ->leftJoin('especies', 'razas.id_especie', '=', 'especies.id')
            ->orderBy('pacientes.nombre')
            ->get();

        return $results;
    }
    public static function getDatos($id)
    {
        $results = DB::table('pacientes')
            ->select(
                'pacientes.id',
                'pacientes.nombre',
                'pacientes.peso',
                'pacientes.tamano',
                'pacientes.imagen_path',
                'razas.nombre as raza',
                'especies.nombre as especie',
                'especies.imagen_path as especie_imagen'
            )
            ->leftJoin('razas', 'razas.id', '=', 'pacientes.id_raza')
            ->leftJoin('especies', 'razas.id_especie', '=', 'especies.id')
            ->where('pacientes.id',$id)
            ->first();

        return $results;
    }
    public static function getNotasServicio($id){
        $results = DB::table('nota_servicios')
            ->select(
                'nota_servicios.id',
                'personals.nombre as personalNombre',
                'nota_servicios.id as id_notaservicio',
                'nota_servicios.descripcion as nota_descripcion',
                'estado_pacientes.descripcion as estado',
                'estado_pacientes.id as id_estado',
                'nota_servicios.total',
                'nota_servicios.created_at',
                'clientes.nombre as cliente',
            )
            ->leftJoin('clientes', 'clientes.id', '=', 'nota_servicios.id_cliente')
            ->leftJoin('personals', 'personals.id', '=', 'nota_servicios.id_personal')
            ->leftJoin('estado_pacientes', 'estado_pacientes.id', '=', 'nota_servicios.id_estado')
            ->where('nota_servicios.id_paciente', $id)
            ->get();

        return $results;
    }

    public static function getAlergias($id){
        $results = DB::table('alergias')
            ->select(
                
                'medicamentos.nombre'
            )
            ->leftJoin('medicamentos', 'alergias.id_medicamento', '=', 'medicamentos.id')
            
            ->where('alergias.id_paciente', $id)
            ->get();

        return $results;
    }
}
