<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Correspondencia;
use App\Models\Reparto;
use App\Models\User;

class RepartoController extends Controller
{
    public function index(Request $request)
    {
        if (in_array(auth()->user()->role_id, [2, 4])) {
            abort(403, 'Acceso no autorizado.');
        }

        $query = Correspondencia::where('tipo', 'salida')->with('reparto');

        // Si el usuario autenticado tiene el rol de Mensajero (role_id = 4), filtrar solo los asignados a él
        $user = auth()->user();
        if ($user->role_id === 4) {
            $query->whereHas('reparto', function ($q) use ($user) {
                $q->where('mensajero', 'like', '%' . $user->nombre . '%')
                  ->where('mensajero', 'like', '%' . $user->apellido_paterno . '%');
            });
        }

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
        $mensajeros = User::where('role_id', 4)->where('estado', 'activo')->get();

        return view('repartos.index', compact('correspondencias', 'mensajeros'));
    }

    public function store(Request $request)
    {
        if (auth()->user()->role_id !== 3) {
            abort(403, 'Acceso no autorizado.');
        }

        $validated = $request->validate([
            'correspondencia_id' => 'required|exists:correspondencias,id',
            'tipo_servicio' => 'required|string',
            'empresa' => 'nullable|string|max:80',
            'mensajero' => 'nullable|string|max:50',
            'fecha_envio' => 'required|date',
            'fecha_entrega' => 'required|date',
            'estado' => 'required|string|in:En preparación,En tránsito,Entregado,Devuelto,Incidencia',
            'observaciones' => 'nullable|string',
        ], [
            'fecha_envio.required' => 'La fecha/hora de envío es obligatoria.',
            'fecha_entrega.required' => 'La fecha de entrega es obligatoria.',
        ]);

        $correspondencia = Correspondencia::findOrFail($validated['correspondencia_id']);
        if ($correspondencia->estado === 'registrada') {
            return back()->withErrors(['error' => 'No se puede registrar el reparto de una correspondencia que no ha sido entregada a Recursos Materiales.']);
        }

        if (auth()->user()->role_id === 3 && ($correspondencia->estado === 'entregada' || ($correspondencia->reparto && $correspondencia->reparto->estado === 'Entregado'))) {
            return back()->withErrors(['error' => 'No se puede editar la información logística de una correspondencia que ya fue entregada.']);
        }

        $reparto = Reparto::updateOrCreate(
            ['correspondencia_id' => $validated['correspondencia_id']],
            $validated
        );

        $estadoAnterior = $correspondencia->estado;
        if ($validated['estado'] == 'Entregado') {
            $correspondencia->estado = 'entregada';
        } else {
            $correspondencia->estado = 'en transito';
        }
        $correspondencia->save();

        if ($estadoAnterior !== $correspondencia->estado) {
            \App\Models\HistorialEstado::create([
                'correspondencia_id' => $correspondencia->id,
                'estado' => $correspondencia->estado == 'entregada' ? 'Entregada' : 'En Tránsito',
                'usuario_id' => auth()->id(),
                'fecha' => now(),
                'comentario' => 'Información logística de envío registrada por Recursos Materiales.',
            ]);
        }

        return redirect()->route('repartos.index')->with('success', 'Control de reparto registrado correctamente.');
    }

    public function misEntregas(Request $request)
    {
        $user = auth()->user();
        if ($user->role_id !== 4) {
            abort(403, 'Acceso no autorizado.');
        }

        $query = Correspondencia::where('tipo', 'salida')
            ->whereHas('reparto', function ($q) use ($user) {
                if ($user->role_id === 4) {
                    $q->where('mensajero', 'like', '%' . $user->nombre . '%')
                      ->where('mensajero', 'like', '%' . $user->apellido_paterno . '%');
                }
            })
            ->with(['reparto', 'area']);

        if ($request->filled('numero_control')) {
            $query->where('numero_control', 'like', '%' . $request->numero_control . '%');
        }

        $entregas = $query->orderBy('fecha_registro', 'desc')->paginate(10);

        return view('mensajero.entregas', compact('entregas'));
    }
}
