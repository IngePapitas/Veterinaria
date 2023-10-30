<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class NotaServicio extends Model
{
    use HasFactory;

    public static function getServicios($id)
    {
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
    public static function getMedicamentos($id)
    {
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
    public static function allData()
    {
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
    public static function allDuenos()
    {
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

    public static function obtenerIngresosServicios($fechaIni, $fechaFin, $servicio)
    {
        $filter = [];
        if ($fechaIni != "") {
            $filter[] = [
                'nota_servicios.created_at', '>=', $fechaIni . '-01',
            ];
        }
        if ($fechaFin != "") {
            $filter[] = [
                'nota_servicios.created_at', '<=', $fechaFin . '-31',
            ];
        }

        if ($servicio != "") {
            $filter['nota_servicio_servicios.id_servicio'] = $servicio;
        }

        $results = DB::table('nota_servicios')
            ->select(DB::raw('MONTH(nota_servicios.created_at) as mes'), DB::raw('YEAR(nota_servicios.created_at) as ano'), DB::raw('SUM(servicios.precio) as suma'))
            ->leftJoin('nota_servicio_servicios', 'nota_servicios.id', '=', 'nota_servicio_servicios.id_notaservicio')
            ->leftJoin('servicios', 'servicios.id', '=', 'nota_servicio_servicios.id_servicio')
            ->where($filter)
            ->groupby('mes', 'ano')
            ->orderby('mes')
            ->get();
        return $results;
    }
    public static function obtenerIngresosMedicamentos($fechaIni, $fechaFin, $medicamento)
    {
        $filter = [];
        if ($fechaIni != "") {
            $filter[] = [
                'nota_servicios.created_at', '>=', $fechaIni . '-01',
            ];
        }
        if ($fechaFin != "") {
            $filter[] = [
                'nota_servicios.created_at', '<=', $fechaFin . '-31',
            ];
        }

        if ($medicamento != "") {
            $filter['nota_servicio_servicios.id_mediamento'] = $medicamento;
        }

        $results = DB::table('nota_servicios')
            ->select(DB::raw('MONTH(nota_servicios.created_at) as mes'), DB::raw('YEAR(nota_servicios.created_at) as ano'), DB::raw('SUM(nota_servicio_medicamentos.subtotal) as suma'))
            ->leftJoin('nota_servicio_medicamentos', 'nota_servicio_medicamentos.id_notaservicio', '=', 'nota_servicios.id')
            ->leftJoin('medicamentos', 'medicamentos.id', '=', 'nota_servicio_medicamentos.id_medicamento')
            ->where($filter)
            ->groupby('mes', 'ano')
            ->orderby('mes')
            ->get();
        return $results;
    }
}
