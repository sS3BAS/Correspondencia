@extends('layouts.app')

@section('title', 'Consulta de Entradas')

@section('content')
<div class="max-w-[1440px] mx-auto">
    <!-- Page Header & Filters -->
    <div class="mb-6 flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
        <div>
            <h1 class="font-headline-lg text-2xl md:text-3xl font-bold text-slate-900 mb-1">Módulo de Consulta de Entradas</h1>
            <p class="font-body-md text-sm text-slate-600">Gestione y revise la correspondencia entrante y sus IDs de seguimiento.</p>
        </div>
        
        <!-- Filter Bar -->
        <form action="{{ route('entradas.index') }}" method="GET" class="flex flex-wrap items-center gap-3 bg-white p-2 rounded-lg border border-slate-200 shadow-sm">
            <div class="relative">
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm" data-icon="filter_list">filter_list</span>
                <input type="text" name="numero_ficha" value="{{ request('numero_ficha') }}" class="pl-9 pr-3 py-1.5 bg-transparent border-none text-sm focus:ring-0 w-[160px] placeholder:text-slate-400 border-r border-slate-200" placeholder="Ficha o Control...">
            </div>
            
            <div class="flex items-center gap-2 px-2 border-r border-slate-200">
                <span class="text-xs font-medium text-slate-500">Fecha:</span>
                <input type="date" name="fecha_registro" value="{{ request('fecha_registro') }}" class="py-1.5 px-2 bg-transparent border-none text-sm focus:ring-0 text-slate-700 cursor-pointer">
            </div>

            <div class="flex items-center gap-2 px-2 border-r border-slate-200">
                <span class="text-xs font-medium text-slate-500">Área:</span>
                <select name="area_id" class="py-1.5 px-2 bg-transparent border-none text-sm focus:ring-0 text-slate-700 cursor-pointer max-w-[120px]">
                    <option value="">Todas</option>
                    @foreach($areas as $area)
                        <option value="{{ $area->id }}" {{ request('area_id') == $area->id ? 'selected' : '' }}>{{ $area->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex items-center gap-2 px-2">
                <span class="text-xs font-medium text-slate-500">Tipo:</span>
                <select name="tipo_documento" class="py-1.5 px-2 bg-transparent border-none text-sm focus:ring-0 text-slate-700 cursor-pointer">
                    <option value="">Todos</option>
                    <option value="Oficio" {{ request('tipo_documento') == 'Oficio' ? 'selected' : '' }}>Oficio</option>
                    <option value="Solicitud" {{ request('tipo_documento') == 'Solicitud' ? 'selected' : '' }}>Solicitud</option>
                    <option value="Circular" {{ request('tipo_documento') == 'Circular' ? 'selected' : '' }}>Circular</option>
                    <option value="Memorándum" {{ request('tipo_documento') == 'Memorándum' ? 'selected' : '' }}>Memorándum</option>
                    <option value="Informe" {{ request('tipo_documento') == 'Informe' ? 'selected' : '' }}>Informe</option>
                </select>
            </div>
            
            <div class="flex items-center gap-1 ml-2">
                <button type="submit" class="bg-primary text-on-primary font-medium text-sm px-4 py-1.5 rounded-md hover:bg-slate-800 transition-colors flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">search</span>
                    Buscar
                </button>
                @if(request()->anyFilled(['numero_ficha', 'fecha_registro', 'area_id', 'tipo_documento']))
                    <a href="{{ route('entradas.index') }}" class="text-slate-500 hover:text-red-600 p-1.5 rounded-md transition-colors" title="Limpiar Filtros">
                        <span class="material-symbols-outlined text-[18px]">clear</span>
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Table Card -->
    <div class="rounded-xl border border-slate-200 bg-white shadow-sm overflow-hidden flex flex-col">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-4 font-semibold text-xs text-slate-500 uppercase tracking-wider">ID / Control</th>
                        <th class="px-6 py-4 font-semibold text-xs text-slate-500 uppercase tracking-wider">Fecha/Hora</th>
                        <th class="px-6 py-4 font-semibold text-xs text-slate-500 uppercase tracking-wider">Origen / Remitente</th>
                        <th class="px-6 py-4 font-semibold text-xs text-slate-500 uppercase tracking-wider">Destino / Asunto</th>
                        <th class="px-6 py-4 font-semibold text-xs text-slate-500 uppercase tracking-wider text-center">Prioridad / Estatus</th>
                        <th class="px-6 py-4 font-semibold text-xs text-slate-500 uppercase tracking-wider text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-slate-700 divide-y divide-slate-100">
                    @forelse($correspondencias as $item)
                        <tr class="hover:bg-slate-50 transition-colors group">
                            <td class="px-6 py-4">
                                <span class="font-semibold text-secondary">{{ $item->numero_control ?? $item->numero_ficha ?? 'Sin Ficha' }}</span>
                                <p class="text-xs text-slate-500 mt-0.5">{{ $item->tipo_documento }}</p>
                            </td>
                            <td class="px-6 py-4 text-slate-600 whitespace-nowrap">
                                {{ \Carbon\Carbon::parse($item->fecha_registro)->format('d/m/Y') }}
                                <br>
                                <span class="text-xs text-slate-400">{{ \Carbon\Carbon::parse($item->fecha_registro)->format('H:i') }} hrs</span>
                            </td>
                            <td class="px-6 py-4">
                                <p class="font-medium text-slate-800">{{ $item->nombre_remitente }}</p>
                                <p class="text-xs text-slate-500">{{ $item->institucion }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <p class="font-medium text-slate-800">{{ $item->nombre_destinatario }} <span class="font-normal text-slate-500">- {{ $item->area->nombre ?? 'Sin Área' }}</span></p>
                                <p class="text-xs text-slate-500 line-clamp-1 mt-0.5" title="{{ $item->asunto }}">{{ $item->asunto }}</p>
                            </td>
                            <td class="px-6 py-4 text-center space-y-2">
                                <!-- Prioridad Badge -->
                                <div>
                                    @if($item->prioridad == 'urgente')
                                        <span class="inline-flex items-center justify-center px-2 py-0.5 rounded-full bg-amber-50 text-amber-700 text-[10px] font-semibold border border-amber-200/50 gap-1 w-full max-w-[100px]">
                                            <span class="material-symbols-outlined text-[12px]">priority_high</span> Urgente
                                        </span>
                                    @elseif($item->prioridad == 'confidencial')
                                        <span class="inline-flex items-center justify-center px-2 py-0.5 rounded-full bg-red-50 text-red-700 text-[10px] font-semibold border border-red-200/50 gap-1 w-full max-w-[100px]">
                                            <span class="material-symbols-outlined text-[12px]">lock</span> Confidencial
                                        </span>
                                    @elseif($item->prioridad == 'con valores')
                                        <span class="inline-flex items-center justify-center px-2 py-0.5 rounded-full bg-blue-50 text-blue-700 text-[10px] font-semibold border border-blue-200/50 gap-1 w-full max-w-[100px]">
                                            <span class="material-symbols-outlined text-[12px]">diamond</span> Con Valores
                                        </span>
                                    @else
                                        <span class="inline-flex items-center justify-center px-2 py-0.5 rounded-full bg-slate-50 text-slate-600 text-[10px] font-semibold border border-slate-200 gap-1 w-full max-w-[100px]">
                                            Ordinaria
                                        </span>
                                    @endif
                                </div>
                                
                                <!-- Estado Badge -->
                                <div>
                                    @if($item->estado == 'pendiente' || $item->estado == 'registrada')
                                        <span class="inline-flex items-center justify-center px-2 py-0.5 rounded-full bg-blue-50 text-blue-700 text-[10px] font-semibold border border-blue-200/50 gap-1 w-full max-w-[100px]">
                                            <span class="material-symbols-outlined text-[12px]">fiber_new</span> Registrada
                                        </span>
                                    @elseif($item->estado == 'entregada')
                                        <span class="inline-flex items-center justify-center px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700 text-[10px] font-semibold border border-emerald-200/50 gap-1 w-full max-w-[100px]">
                                            <span class="material-symbols-outlined text-[12px]">check_circle</span> Entregada
                                        </span>
                                    @else
                                        <span class="inline-flex items-center justify-center px-2 py-0.5 rounded-full bg-slate-100 text-slate-600 text-[10px] font-semibold border border-slate-200 gap-1 w-full max-w-[100px]">
                                            {{ ucfirst($item->estado) }}
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="#" class="p-1.5 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-md transition-colors" title="Ver Detalle">
                                        <span class="material-symbols-outlined text-[20px]">visibility</span>
                                    </a>
                                    
                                    @if($item->estado == 'pendiente' || $item->estado == 'registrada')
                                        <!-- Enlace para Registrar Entrega (HU-06) -->
                                        <a href="#" class="p-1.5 text-slate-400 hover:text-emerald-600 hover:bg-emerald-50 rounded-md transition-colors" title="Registrar Entrega (HU-06)">
                                            <span class="material-symbols-outlined text-[20px]">local_shipping</span>
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-slate-500">
                                <div class="flex flex-col items-center justify-center">
                                    <span class="material-symbols-outlined text-4xl mb-2 text-slate-300">inbox</span>
                                    <p class="font-medium text-slate-600">No se encontraron registros</p>
                                    <p class="text-sm mt-1">Intente ajustar los filtros de búsqueda o registre una nueva entrada.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Table Pagination -->
        @if($correspondencias->hasPages())
            <div class="px-6 py-4 border-t border-slate-200 bg-slate-50">
                {{ $correspondencias->links() }}
            </div>
        @elseif($correspondencias->isNotEmpty())
            <div class="px-6 py-4 border-t border-slate-200 bg-slate-50 flex items-center justify-between text-sm text-slate-500">
                Mostrando todos los {{ $correspondencias->count() }} registros
            </div>
        @endif
    </div>
</div>
@endsection
