<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Llamada extends Model
{
    protected $fillable = [
        'contact_date',
        'program_date',
        'is_success',
        'comment',
        'audio_path',
        'sinprogramar_id',
    ];

    public function sinProgramar()
    {
        return $this->belongsTo(sinprogramar::class);
    }

}
