<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistorialEstado extends Model
{
    protected $fillable = ['correspondencia_id', 'estado', 'usuario_id', 'fecha', 'comentario'];

    public function usuario() {
        return $this->belongsTo(User::class, 'usuario_id');
    }
}
