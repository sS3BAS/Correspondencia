<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Correspondencia extends Model
{
    protected $table = 'correspondencias';

    protected $fillable = [
        'tipo', 'numero_ficha', 'numero_control', 'fecha_registro',
        'area_id', 'puesto_id', 'nombre_remitente', 'cargo_remitente',
        'institucion', 'nombre_destinatario', 'cargo_destinatario',
        'domicilio', 'tipo_documento', 'numero_fojas', 'anexos',
        'asunto', 'prioridad', 'estado',
        'tipo_contenido', 'caracter_especial', 'fecha_limite_entrega',
        'fecha_hora_envio', 'nombre_empresa', 'nombre_mensajero'
    ];

    public function area() {
        return $this->belongsTo(Area::class);
    }

    public function puesto() {
        return $this->belongsTo(Puesto::class);
    }

    public function entrega() {
        return $this->hasOne(Entrega::class);
    }

    public function reparto() {
        return $this->hasOne(Reparto::class);
    }

    public function acuse() {
        return $this->hasOne(Acuse::class);
    }

    public function historial() {
        return $this->hasMany(HistorialEstado::class);
    }
}