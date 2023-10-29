<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class NotaServicio extends Model
{
    use HasFactory;

    public static function getServicios($id){
        $results = DB::table('nota_servicios')
            ->select(
                'servicios.id',
                'servicios.descripcion',
                'nota_servicio_servicios.id',
                'servicios.precio'
            )
            ->leftJoin('nota_servicio_servicios', 'nota_servicio_servicios.id_notaservicio', '=', 'nota_servicios.id')
            ->leftJoin('servicios', 'servicios.id', '=', 'nota_servicio_servicios.id_servicio')
            ->where('nota_servicios.id', $id)
            ->get();

        return $results;
    }
    public static function getMedicamentos($id){
        $results = DB::table('nota_servicios')
            ->select(
                'medicamentos.id',
                'medicamentos.nombre',
                'medicamentos.forma_farmaceutica',
                'nota_servicio_medicamentos.id',
                'medicamentos.precio',
                'nota_servicio_medicamentos.cantidad',
                'nota_servicio_medicamentos.subtotal'
            )
            ->leftJoin('nota_servicio_medicamentos', 'nota_servicio_medicamentos.id_notaservicio', '=', 'nota_servicios.id')
            ->leftJoin('medicamentos', 'medicamentos.id', '=', 'nota_servicio_medicamentos.id_medicamento')
            ->where('nota_servicios.id', $id)
            ->get();

        return $results;
    }
    public static function allData(){
        $results = DB::table('nota_servicios')
        ->select(
            'nota_servicios.*',
            'personals.nombre as personal',
            'clientes.nombre as cliente',
            'clientes.ci as clienteci',
            'estado_pacientes.descripcion as estado'
        )
        ->leftJoin('personals', 'personals.id', '=', 'nota_servicios.id_personal')
        ->leftJoin('clientes', 'clientes.id', '=', 'nota_servicios.id_cliente')
        ->leftJoin('estado_pacientes', 'estado_pacientes.id', '=', 'nota_servicios.id_estado')
        ->get();

        return $results;
    }
    public static function allDuenos(){
        $results = DB::table('nota_servicios')
            ->select(
                'clientes.nombre',
                'clientes.ci',
                'pacientes.id as id_paciente'
            )
            ->leftJoin('clientes', 'clientes.id', '=', 'nota_servicios.id_cliente')
            ->leftJoin('pacientes', 'pacientes.id', '=', 'nota_servicios.id_paciente')
            ->groupBy('clientes.nombre', 'clientes.ci', 'pacientes.id')
            ->get();
    
        return $results;
    }
    
}
