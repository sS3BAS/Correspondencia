<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Correspondencia;
use App\Models\Reparto;

class RepartoController extends Controller
{
    public function index(Request $request)
    {
        $query = Correspondencia::where('tipo', 'salida')->with('reparto');

        if ($request->filled('numero_control')) {
            $query->where('numero_control', 'like', '%' . $request->numero_control . '%');
        }
        
        if ($request->filled('fecha_inicio') && $request->filled('fecha_fin')) {
            $query->whereBetween('fecha_registro', [$request->fecha_inicio, $request->fecha_fin]);
        }

        if ($request->filled('estado')) {
            $query->whereHas('reparto', function ($q) use ($request) {
                $q->where('estado', $request->estado);
            });
            if ($request->estado == 'pendiente') {
                $query->orWhereDoesntHave('reparto');
            }
        }

        $correspondencias = $query->orderBy('fecha_registro', 'desc')->paginate(10);

        return view('repartos.index', compact('correspondencias'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'correspondencia_id' => 'required|exists:correspondencias,id',
            'tipo_servicio' => 'required|string',
            'empresa' => 'nullable|string|max:80',
            'mensajero' => 'nullable|string|max:50',
            'fecha_envio' => 'nullable|date',
            'fecha_entrega' => 'nullable|date',
            'estado' => 'required|string|in:En preparación,En tránsito,Entregado,Devuelto,Incidencia',
            'observaciones' => 'nullable|string',
        ]);

        $reparto = Reparto::updateOrCreate(
            ['correspondencia_id' => $validated['correspondencia_id']],
            $validated
        );

        // Update the correspondencia status as well
        $correspondencia = Correspondencia::find($validated['correspondencia_id']);
        if ($validated['estado'] == 'Entregado') {
            $correspondencia->estado = 'entregada';
        } else {
            $correspondencia->estado = 'en transito';
        }
        $correspondencia->save();

        return redirect()->route('repartos.index')->with('success', 'Registro de reparto actualizado correctamente.');
    }
}
