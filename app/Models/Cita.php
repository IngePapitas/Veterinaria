<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Cita extends Model
{
    use HasFactory;

    public static function getCitaAnterior($id_paciente, $id_personal = '') {
        $query = DB::table('citas')
            ->select('citas.*','personals.nombre as personal')
            ->leftJoin('pacientes', 'pacientes.id', '=', 'citas.id_paciente')
            ->leftJoin('personals', 'personals.id', '=', 'citas.id_personal')
            ->where('citas.id_paciente', '=', $id_paciente);
    
        if (!empty($id_personal)) {
            $query->where('citas.id_personal', '=', $id_personal);
        }
    
        $results = $query->where(function ($query) {
                $query->where('citas.estado', '=', '0')
                    ->orWhere('citas.estado', '=', '2');
            })
            ->first();
    
        return $results;
    }

    public static function allData($personal = '', $paciente = ''){
        $query = DB::table('citas')
            ->select('citas.*','personals.nombre as personal','pacientes.nombre as paciente')
            ->leftJoin('pacientes', 'pacientes.id', '=', 'citas.id_paciente')
            ->leftJoin('personals', 'personals.id', '=', 'citas.id_personal');
    
        if (!empty($personal)) {
            $query->where('personals.id', '=', $personal);
        }
        if (!empty($paciente)) {
            $query->where('pacientes.id', '=', $paciente);
        }
    
        $results = $query
            ->get();
    
        return $results;
    }
    
}
