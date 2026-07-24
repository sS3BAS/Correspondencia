<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reparto extends Model
{
    protected $fillable = [
        'correspondencia_id',
        'tipo_servicio',
        'mensajero',
        'empresa',
        'estado',
        'fecha_envio',
        'fecha_entrega',
        'observaciones',
    ];
}
