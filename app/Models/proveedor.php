<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class proveedor extends Model
{
    use HasFactory;
    protected $fillable = ['nombre', 'telefono', 'marca_id'];

    public function marca()
    {
        return $this->belongsTo(Marca::class, 'marca_id');
    }
}
