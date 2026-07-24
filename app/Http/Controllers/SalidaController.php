<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Correspondencia;
use App\Models\Area;

class SalidaController extends Controller
{
    public function index(Request $request)
    {
        if (in_array(auth()->user()->role_id, [3, 4])) {
            abort(403, 'Acceso no autorizado.');
        }

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
        if (auth()->user()->role_id !== 2) {
            abort(403, 'Acceso no autorizado.');
        }

        $areas = Area::all();
        $nextControlNumber = 'UCC-SAL-' . date('Y') . '-' . rand(1000, 9999);
        return view('salidas.create', compact('areas', 'nextControlNumber'));
    }

    public function store(Request $request)
    {
        if (auth()->user()->role_id !== 2) {
            abort(403, 'Acceso no autorizado.');
        }

        $validated = $request->validate([
            'tipo' => 'required|in:salida',
            'prioridad' => 'required|in:ordinario,urgente',
            'fecha_limite_entrega' => 'required|date',
            'area_id' => 'required|exists:areas,id',
            'numero_control' => 'required|string|max:20',
            'tipo_contenido' => 'required|in:documento,paquete',
            'caracter_especial' => 'required|in:ninguno,confidencial,con valores,con riesgo',
            'nombre_destinatario' => 'required|max:40',
            'cargo_destinatario' => 'nullable|max:50',
            'institucion' => 'required|max:80',
            'domicilio' => 'required|max:100',
            'asunto' => 'nullable|string',
        ], [
            'prioridad.required' => 'La prioridad es obligatoria.',
            'fecha_limite_entrega.required' => 'La fecha límite de entrega es obligatoria.',
            'area_id.required' => 'Debe seleccionar el área que envía.',
            'numero_control.required' => 'El número de control es obligatorio.',
            'tipo_contenido.required' => 'Debe especificar el tipo de contenido.',
            'caracter_especial.required' => 'Especifique si tiene algún carácter especial.',
            'nombre_destinatario.required' => 'El nombre del destinatario es obligatorio.',
            'institucion.required' => 'La institución es obligatoria.',
            'domicilio.required' => 'El domicilio es obligatorio.',
        ]);

        $validated['estado'] = 'pendiente';
        $validated['fecha_registro'] = now();
        $validated['asunto'] = $validated['asunto'] ?? 'Sin Asunto';

        Correspondencia::create($validated);

        return redirect()->route('salidas.index')->with('success', 'Correspondencia de salida registrada correctamente.');
    }

    public function entregarRM(Correspondencia $correspondencia)
    {
        if (auth()->user()->role_id !== 2) {
            abort(403, 'Acceso no autorizado.');
        }

        $correspondencia->estado = 'en_recursos_materiales';
        $correspondencia->save();

        \App\Models\HistorialEstado::create([
            'correspondencia_id' => $correspondencia->id,
            'estado' => 'En Recursos Materiales',
            'usuario_id' => auth()->id(),
            'fecha' => now(),
            'comentario' => 'Entrega física realizada al departamento de Recursos Materiales.',
        ]);

        return redirect()->route('salidas.index')->with('success', 'Correspondencia entregada a Recursos Materiales correctamente.');
    }
}
