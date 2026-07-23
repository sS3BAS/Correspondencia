<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Correspondencia;
use App\Models\Area;

class SalidaController extends Controller
{
    public function index(Request $request)
    {
        $query = Correspondencia::where('tipo', 'salida')->with('area');

        if ($request->filled('numero_control')) {
            $query->where('numero_control', 'like', '%' . $request->numero_control . '%');
        }
        if ($request->filled('fecha')) {
            $query->whereDate('fecha_registro', $request->fecha);
        }
        if ($request->filled('area_id')) {
            $query->where('area_id', $request->area_id);
        }
        if ($request->filled('nombre_destinatario')) {
            $query->where('nombre_destinatario', 'like', '%' . $request->nombre_destinatario . '%');
        }
        if ($request->filled('tipo_entrega')) {
            $query->where('prioridad', $request->tipo_entrega);
        }

        $salidas = $query->orderBy('fecha_registro', 'desc')->paginate(10);
        $areas = Area::all();

        return view('salidas.index', compact('salidas', 'areas'));
    }

    public function create()
    {
        $areas = Area::all();
        return view('salidas.create', compact('areas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tipo' => 'required|in:salida',
            'prioridad' => 'required|in:ordinario,urgente',
            'fecha_limite_entrega' => 'nullable|date',
            'area_id' => 'required|exists:areas,id',
            'numero_ficha' => 'nullable|string|max:20',
            'tipo_contenido' => 'required|in:documento,paquete',
            'caracter_especial' => 'required|in:ninguno,confidencial,con valores,con riesgo',
            'nombre_destinatario' => 'required|max:30',
            'cargo_destinatario' => 'nullable|max:50',
            'institucion' => 'required|max:80',
            'domicilio' => 'required|max:100',
            'fecha_hora_envio' => 'required|date',
            'nombre_empresa' => 'nullable|max:80',
            'nombre_mensajero' => 'nullable|max:50',
            'asunto' => 'nullable|string',
        ], [
            'prioridad.required' => 'La prioridad es obligatoria.',
            'area_id.required' => 'Debe seleccionar el área que envía.',
            'tipo_contenido.required' => 'Debe especificar el tipo de contenido.',
            'caracter_especial.required' => 'Especifique si tiene algún carácter especial.',
            'nombre_destinatario.required' => 'El nombre del destinatario es obligatorio.',
            'institucion.required' => 'La institución es obligatoria.',
            'domicilio.required' => 'El domicilio es obligatorio.',
            'fecha_hora_envio.required' => 'Especifique la fecha y hora de envío.',
        ]);

        $validated['estado'] = 'pendiente';
        $validated['numero_control'] = 'UCC-SAL-' . date('Y') . '-' . rand(1000, 9999);
        $validated['fecha_registro'] = now();
        $validated['asunto'] = $validated['asunto'] ?? 'Sin Asunto';

        Correspondencia::create($validated);

        return redirect()->route('home')->with('success', 'Correspondencia de salida registrada exitosamente.');
    }
}
