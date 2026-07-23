<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Correspondencia;
use App\Models\Area;

class SeguimientoController extends Controller
{
    public function index(Request $request)
    {
        $areas = Area::all();
        $correspondencia = null;

        if ($request->anyFilled(['numero_ficha', 'numero_control', 'fecha', 'area_id', 'estado'])) {
            $query = Correspondencia::with(['area', 'reparto', 'historial.usuario']);

            if ($request->filled('numero_control')) {
                $query->where('numero_control', $request->numero_control);
            }
            if ($request->filled('numero_ficha')) {
                $query->where('numero_ficha', $request->numero_ficha);
            }
            if ($request->filled('fecha')) {
                $query->whereDate('fecha_registro', $request->fecha);
            }
            if ($request->filled('area_id')) {
                $query->where('area_id', $request->area_id);
            }
            if ($request->filled('estado')) {
                $query->where('estado', $request->estado);
            }

            $correspondencia = $query->first();
        }

        return view('seguimiento.index', compact('areas', 'correspondencia'));
    }
}
