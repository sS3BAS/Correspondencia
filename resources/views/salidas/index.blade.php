@extends('layouts.app')

@section('title', 'Consulta de Correspondencia de Salida')

@section('content')
<div class="max-w-[1440px] mx-auto space-y-6">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-2">
        <div>
            <h1 class="font-headline-lg-mobile md:font-headline-lg text-2xl md:text-3xl font-bold text-slate-900 mb-1">Consulta de Correspondencia de Salida</h1>
            <p class="font-body-lg text-sm text-slate-600">Administre y supervise la correspondencia enviada por la institución.</p>
        </div>
        <a href="{{ route('salidas.create') }}" class="bg-primary text-on-primary px-4 py-2 rounded-lg font-medium text-sm hover:bg-slate-800 transition-colors shadow-sm flex items-center gap-2">
            <span class="material-symbols-outlined text-[18px]">add</span>
            Nueva Salida
        </a>
    </div>

    <!-- Filter Bar -->
    <form action="{{ route('salidas.index') }}" method="GET" class="bg-white border border-slate-200 rounded-xl p-6 shadow-sm">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 items-end">
            <div class="flex flex-col gap-1">
                <label class="font-label-sm text-xs font-medium text-slate-600">Número de Control</label>
                <input name="numero_control" value="{{ request('numero_control') }}" class="w-full bg-white border border-slate-200 rounded-md px-3 py-2 text-sm focus:outline-none focus:border-secondary focus:ring-1 focus:ring-secondary/20 transition-all" placeholder="Ej. UCC-SAL-..." type="text">
            </div>
            
            <div class="flex flex-col gap-1">
                <label class="font-label-sm text-xs font-medium text-slate-600">Fecha Límite/Envío</label>
                <input name="fecha" value="{{ request('fecha') }}" class="w-full bg-white border border-slate-200 rounded-md px-3 py-2 text-sm focus:outline-none focus:border-secondary focus:ring-1 focus:ring-secondary/20 transition-all text-slate-700" type="date">
            </div>
            
            <div class="flex flex-col gap-1">
                <label class="font-label-sm text-xs font-medium text-slate-600">Área Remitente</label>
                <select name="area_id" class="w-full bg-white border border-slate-200 rounded-md px-3 py-2 text-sm focus:outline-none focus:border-secondary focus:ring-1 focus:ring-secondary/20 transition-all text-slate-700">
                    <option value="">Todas las áreas</option>
                    @foreach($areas as $area)
                        <option value="{{ $area->id }}" {{ request('area_id') == $area->id ? 'selected' : '' }}>{{ $area->nombre }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="flex flex-col gap-1">
                <label class="font-label-sm text-xs font-medium text-slate-600">Destinatario</label>
                <input name="nombre_destinatario" value="{{ request('nombre_destinatario') }}" class="w-full bg-white border border-slate-200 rounded-md px-3 py-2 text-sm focus:outline-none focus:border-secondary focus:ring-1 focus:ring-secondary/20 transition-all" placeholder="Nombre o entidad" type="text">
            </div>
            
            <div class="flex flex-col gap-1">
                <label class="font-label-sm text-xs font-medium text-slate-600">Prioridad</label>
                <div class="flex gap-2">
                    <select name="tipo_entrega" class="w-full bg-white border border-slate-200 rounded-md px-3 py-2 text-sm focus:outline-none focus:border-secondary focus:ring-1 focus:ring-secondary/20 transition-all text-slate-700">
                        <option value="">Todos</option>
                        <option value="ordinario" {{ request('tipo_entrega') == 'ordinario' ? 'selected' : '' }}>Ordinario</option>
                        <option value="urgente" {{ request('tipo_entrega') == 'urgente' ? 'selected' : '' }}>Urgente</option>
                    </select>
                    <button type="submit" class="bg-primary text-on-primary px-4 py-2 rounded-md font-medium text-sm hover:bg-slate-800 transition-colors flex items-center justify-center min-w-[100px]">
                        Filtrar
                    </button>
                </div>
            </div>
        </div>
        
        @if(request()->anyFilled(['numero_control', 'fecha', 'area_id', 'nombre_destinatario', 'tipo_entrega']))
            <div class="mt-4 flex justify-end">
                <a href="{{ route('salidas.index') }}" class="text-xs font-medium text-slate-500 hover:text-red-600 flex items-center gap-1 transition-colors">
                    <span class="material-symbols-outlined text-[16px]">clear</span> Limpiar Búsqueda
                </a>
            </div>
        @endif
    </form>

    <!-- Main Table -->
    <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200">
                        <th class="px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">No. Control</th>
                        <th class="px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Fechas</th>
                        <th class="px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Área que envía</th>
                        <th class="px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Destinatario</th>
                        <th class="px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider text-center">Prioridad</th>
                        <th class="px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider text-center">Estado</th>
                        <th class="px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    @forelse($salidas as $item)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-4 py-4">
                                <span class="font-medium text-slate-900 block">{{ $item->numero_control }}</span>
                                @if($item->numero_ficha)
                                    <span class="text-xs text-slate-500">Ref: {{ $item->numero_ficha }}</span>
                                @endif
                            </td>
                            <td class="px-4 py-4 text-slate-600 whitespace-nowrap">
                                <div class="text-xs"><span class="font-medium">Reg:</span> {{ \Carbon\Carbon::parse($item->fecha_registro)->format('d/m/Y') }}</div>
                                @if($item->fecha_limite_entrega)
                                    <div class="text-xs text-red-600 mt-0.5"><span class="font-medium">Límite:</span> {{ \Carbon\Carbon::parse($item->fecha_limite_entrega)->format('d/m/Y') }}</div>
                                @endif
                            </td>
                            <td class="px-4 py-4 text-slate-600">
                                {{ $item->area->nombre ?? 'Interno' }}
                            </td>
                            <td class="px-4 py-4">
                                <span class="block text-slate-800 font-medium">{{ $item->nombre_destinatario }}</span>
                                <span class="text-xs text-slate-500">{{ $item->institucion }}</span>
                            </td>
                            <td class="px-4 py-4 text-center">
                                @if($item->prioridad == 'urgente')
                                    <span class="inline-flex items-center px-2 py-1 rounded-md bg-red-50 text-red-700 text-xs font-medium border border-red-200">
                                        Urgente
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-1 rounded-md bg-slate-100 text-slate-700 text-xs font-medium border border-slate-200">
                                        Ordinario
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-4 text-center">
                                @if($item->estado == 'entregada')
                                    <span class="inline-flex items-center px-2 py-1 rounded-md bg-emerald-50 text-emerald-700 text-xs font-medium border border-emerald-200">
                                        Entregada
                                    </span>
                                @elseif($item->estado == 'en transito')
                                    <span class="inline-flex items-center px-2 py-1 rounded-md bg-blue-50 text-blue-700 text-xs font-medium border border-blue-200">
                                        En Tránsito
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-1 rounded-md bg-slate-100 text-slate-700 text-xs font-medium border border-slate-200">
                                        Registrada
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-4 text-right whitespace-nowrap">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('seguimiento.index', ['numero_control' => $item->numero_control]) }}" class="text-slate-400 hover:text-secondary transition-colors p-1" title="Ver Rastreo / Detalle">
                                        <span class="material-symbols-outlined text-[20px]">visibility</span>
                                    </a>
                                    @if($item->estado == 'pendiente' || $item->estado == 'registrada')
                                        <a href="{{ route('repartos.index', ['numero_control' => $item->numero_control]) }}" class="inline-flex items-center gap-1 bg-secondary text-on-secondary px-3 py-1.5 rounded-md text-xs font-medium hover:bg-secondary/90 transition-colors">
                                            <span class="material-symbols-outlined text-[16px]">local_shipping</span>
                                            Registrar
                                        </a>
                                    @else
                                        <a href="{{ route('repartos.index', ['numero_control' => $item->numero_control]) }}" class="inline-flex items-center gap-1 bg-slate-100 text-slate-500 border border-slate-200 px-3 py-1.5 rounded-md text-xs font-medium hover:bg-slate-200 transition-colors">
                                            <span class="material-symbols-outlined text-[16px]">local_shipping</span>
                                            Logística
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-12 text-center text-slate-500">
                                <div class="flex flex-col items-center justify-center">
                                    <span class="material-symbols-outlined text-4xl mb-2 text-slate-300">search_off</span>
                                    <p class="font-medium text-slate-600">No se encontraron salidas registradas</p>
                                    <p class="text-xs mt-1">Intente ajustar los filtros de búsqueda o registre una nueva correspondencia.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($salidas->hasPages())
            <div class="border-t border-slate-200 bg-slate-50 px-6 py-3">
                {{ $salidas->links() }}
            </div>
        @elseif($salidas->isNotEmpty())
            <div class="border-t border-slate-200 bg-slate-50 px-6 py-3 flex items-center justify-between text-xs text-slate-500">
                Mostrando todos los {{ $salidas->count() }} registros
            </div>
        @endif
    </div>
</div>
@endsection
