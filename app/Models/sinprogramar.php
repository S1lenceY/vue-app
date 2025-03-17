<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class sinprogramar extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'id_poliza',
        'poliza',
        'cultivo',
        'contratante',
        'asegurado',
        'departamento',
        'provincia',
        'distrito',
        'direccion',
        'tipo_evento',
        'inspector',
        'user_id',
        'created_at',
        'updated_at'
    ];
}
