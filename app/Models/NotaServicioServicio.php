<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class NotaServicioServicio extends Model
{
    use HasFactory;

    public static function getDetalles($id){

        $results = DB::table('nota_servicio_servicios')
            ->select(
                'nota_servicio_servicios.*',
                'servicios.descripcion as servicio',
                'tipo_servicios.nombre as tipo',
                'tipo_servicios.id as id_tipo',
            )
            ->leftJoin('servicios', 'servicios.id', '=', 'nota_servicio_servicios.id_servicio')
            ->leftJoin('tipo_servicios', 'tipo_servicios.id', '=', 'servicios.id_tipo_servicio')
            ->where('nota_servicio_servicios.id', '=', $id)
            ->first();

        return $results;
    }
     public static function historialServicios($id){

        $results = DB::table('nota_servicio_servicios')
            ->select(
                'nota_servicio_servicios.*',
                'servicios.descripcion as servicio',
                'tipo_servicios.nombre as tipo',
                'tipo_servicios.id as id_tipo',
            )
            ->leftJoin('servicios', 'servicios.id', '=', 'nota_servicio_servicios.id_servicio')
            ->leftJoin('tipo_servicios', 'tipo_servicios.id', '=', 'servicios.id_tipo_servicio')
            ->leftJoin('nota_servicios', 'nota_servicios.id', '=', 'nota_servicio_servicios.id_notaservicio')
            ->where('nota_servicios.id_paciente', '=', $id)
            ->groupBy('nota_servicio_servicios.id')
            ->get();

        return $results;
    }


}
