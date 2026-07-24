<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Correspondencia;
use App\Models\Acuse;
use App\Models\Reparto;

class AcuseController extends Controller
{
    public function create(Correspondencia $correspondencia)
    {
        if (auth()->user()->role_id !== 4) {
            abort(403, 'El registro de acuse es exclusivo del rol Mensajero.');
        }

        // Verificar que sea tipo salida y que tenga un reparto (opcional, pero buena práctica)
        if ($correspondencia->tipo !== 'salida') {
            return redirect()->route('home')->withErrors('Sólo se puede registrar acuse para salidas.');
        }

        return view('acuses.create', compact('correspondencia'));
    }

    public function store(Request $request)
    {
        if (auth()->user()->role_id !== 4) {
            abort(403, 'El registro de acuse es exclusivo del rol Mensajero.');
        }

        $validated = $request->validate([
            'correspondencia_id' => 'required|exists:correspondencias,id',
            'fecha_acuse' => 'required|date',
            'nombre_recibe' => 'required|string|max:255',
            'observaciones' => 'nullable|string',
        ]);

        Acuse::create($validated);

        // Actualizar la correspondencia principal a 'entregada'
        $correspondencia = Correspondencia::find($validated['correspondencia_id']);
        $correspondencia->estado = 'entregada';
        $correspondencia->save();

        // Actualizar el reparto asociado a 'Entregado'
        if ($correspondencia->reparto) {
            $correspondencia->reparto->estado = 'Entregado';
            $correspondencia->reparto->fecha_entrega = $validated['fecha_acuse'];
            $correspondencia->reparto->save();
        }

        // Registrar en el historial de estados
        \App\Models\HistorialEstado::create([
            'correspondencia_id' => $correspondencia->id,
            'estado' => 'Entregada',
            'usuario_id' => auth()->id(),
            'fecha' => now(),
            'comentario' => 'Acuse de recibido registrado.',
        ]);

        if (auth()->user()->role_id === 4) {
            return redirect()->route('mensajero.entregas')->with('success', 'Acuse registrado correctamente');
        }

        return redirect()->route('repartos.index')->with('success', 'Acuse registrado correctamente');
    }
}
