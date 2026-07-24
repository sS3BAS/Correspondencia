<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Entrega extends Model
{
    protected $fillable = [
        'correspondencia_id',
        'usuario_recibe',
        'area_recibe',
        'fecha_entrega',
        'observaciones',
    ];
}
