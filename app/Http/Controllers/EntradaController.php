<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Correspondencia;
use App\Models\Area;
use App\Models\Puesto;

class EntradaController extends Controller
{
    public function index(Request $request)
    {
        if (in_array(auth()->user()->role_id, [3, 4])) {
            abort(403, 'Acceso no autorizado.');
        }

        $query = Correspondencia::with('area')->where('tipo', 'entrada');

        // Filtros
        if ($request->filled('numero_ficha')) {
            $query->where(function ($q) use ($request) {
                $q->where('numero_ficha', 'like', '%' . $request->numero_ficha . '%')
                  ->orWhere('numero_control', 'like', '%' . $request->numero_ficha . '%');
            });
        }
        if ($request->filled('fecha_registro')) {
            $query->whereDate('fecha_registro', $request->fecha_registro);
        }
        if ($request->filled('area_id')) {
            $query->where('area_id', $request->area_id);
        }
        if ($request->filled('tipo_documento')) {
            $query->where('tipo_documento', $request->tipo_documento);
        }

        $correspondencias = $query->orderBy('fecha_registro', 'desc')->paginate(10);
        $areas = Area::all();

        return view('entradas.index', compact('correspondencias', 'areas'));
    }

    public function create()
    {
        if (auth()->user()->role_id !== 2) {
            abort(403, 'Acceso no autorizado.');
        }

        $areas = Area::all();
        $puestos = Puesto::all();
        
        return view('entradas.create', compact('areas', 'puestos'));
    }

    public function store(Request $request)
    {
        if (auth()->user()->role_id !== 2) {
            abort(403, 'Acceso no autorizado.');
        }
        if (auth()->user()->role_id === 3) {
            abort(403, 'Acceso no autorizado.');
        }

        $validated = $request->validate([
            'tipo' => 'required|in:entrada',
            'fecha_registro' => 'required|date',
            'nombre_destinatario' => 'required|max:30',
            'area_id' => 'required|exists:areas,id',
            'puesto_id' => 'required|exists:puestos,id',
            'nombre_remitente' => 'required|max:30',
            'cargo_remitente' => 'required|string',
            'institucion' => 'required|string',
            'tipo_documento' => 'required|string',
            'numero_fojas' => 'required|integer|min:1',
            'prioridad' => 'required|in:ordinaria,urgente,confidencial,con valores,con riesgos',
            'asunto' => 'required|string',
            'anexos' => 'nullable|string',
        ], [
            'nombre_destinatario.required' => 'El destinatario es obligatorio.',
            'nombre_destinatario.max' => 'El nombre no puede exceder 30 caracteres.',
            'area_id.required' => 'Debe seleccionar un área.',
            'puesto_id.required' => 'Debe seleccionar un puesto.',
            'nombre_remitente.required' => 'El remitente es obligatorio.',
            'cargo_remitente.required' => 'El cargo del remitente es obligatorio.',
            'institucion.required' => 'La institución es obligatoria.',
            'tipo_documento.required' => 'Debe seleccionar el tipo de documento.',
            'numero_fojas.required' => 'Especifique el número de fojas.',
            'prioridad.required' => 'Seleccione una prioridad.',
            'asunto.required' => 'El asunto es obligatorio.',
            'fecha_registro.required' => 'La fecha de registro es obligatoria.',
        ]);

        $validated['estado'] = 'pendiente';
        // Generar un número de folio o control automáticamente (esto puede requerir ajustes según la lógica del negocio)
        $validated['numero_control'] = 'UCC-' . date('Y') . '-' . rand(1000, 9999);

        Correspondencia::create($validated);

        return redirect()->route('entradas.index')->with('success', 'Correspondencia registrada correctamente.');
    }

    public function entrega(Correspondencia $entrada)
    {
        if (auth()->user()->role_id !== 2) {
            abort(403, 'Acceso no autorizado.');
        }

        $areas = Area::all();
        return view('entradas.entrega', compact('entrada', 'areas'));
    }

    public function storeEntrega(Request $request)
    {
        if (auth()->user()->role_id !== 2) {
            abort(403, 'Acceso no autorizado.');
        }

        $validated = $request->validate([
            'correspondencia_id' => 'required|exists:correspondencias,id',
            'area_recibe' => 'required|string',
            'usuario_recibe' => 'required|string|max:50',
            'fecha_entrega' => 'required|date',
            'observaciones' => 'nullable|string',
        ]);

        \App\Models\Entrega::create($validated);

        $entrada = Correspondencia::find($validated['correspondencia_id']);
        $entrada->estado = 'entregada';
        $entrada->save();

        return redirect()->route('entradas.index')->with('success', 'Entrega registrada correctamente.');
    }
}
