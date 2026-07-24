<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Acuse extends Model
{
    protected $fillable = [
        'correspondencia_id',
        'fecha_acuse',
        'nombre_recibe',
        'observaciones',
    ];

    public function correspondencia()
    {
        return $this->belongsTo(Correspondencia::class);
    }
}
