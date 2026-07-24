@extends('layouts.app')

@section('title', 'Consulta de Entradas')

@section('content')
<div class="max-w-[1440px] mx-auto">
    @if(session('success'))
    <div id="successAlert" class="mb-6 p-4 text-sm text-emerald-800 bg-emerald-50 rounded-lg border border-emerald-200/50 flex items-center transition-all duration-500 ease-in-out" role="alert">
        <span class="material-symbols-outlined mr-2 text-emerald-500">check_circle</span>
        <span class="font-medium">{{ session('success') }}</span>
    </div>
    @endif

    <!-- Page Header -->
    <div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="font-headline-lg text-2xl md:text-3xl font-bold text-on-surface mb-1 flex items-center gap-2">
                <span class="material-symbols-outlined text-primary text-[32px]">inbox</span>
                Módulo de Consulta de Entradas
            </h1>
            <p class="font-body-md text-sm text-on-surface-variant">Gestione y revise la correspondencia entrante y sus IDs de seguimiento.</p>
        </div>
    </div>

    <!-- Filters Section -->
    <div class="bg-surface-lowest border border-outline-variant rounded-xl shadow-sm p-4 mb-6">
        <form action="{{ route('entradas.index') }}" method="GET" class="flex flex-wrap items-center gap-4">
            <div class="flex-1 min-w-[200px] relative flex items-center">
                <span class="material-symbols-outlined absolute left-3 text-on-surface-variant/60 text-[20px] pointer-events-none select-none">search</span>
                <input type="text" name="numero_ficha" value="{{ request('numero_ficha') }}" class="w-full pl-10 pr-4 py-2.5 bg-surface-variant/10 border border-outline-variant rounded-lg text-sm text-on-surface placeholder:text-on-surface-variant/40 focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 transition-all" placeholder="Buscar por Ficha o ID Control...">
            </div>
            
            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-2">
                <label class="text-xs font-semibold text-on-surface-variant uppercase tracking-wider">Fecha:</label>
                <input type="date" name="fecha_registro" value="{{ request('fecha_registro') }}" class="px-3 py-2 bg-surface-variant/10 border border-outline-variant rounded-lg text-sm text-on-surface focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 transition-all cursor-pointer">
            </div>

            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-2">
                <label class="text-xs font-semibold text-on-surface-variant uppercase tracking-wider">Área:</label>
                <select name="area_id" class="px-3 py-2 bg-surface-lowest border border-outline-variant rounded-lg text-sm text-on-surface focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 transition-all cursor-pointer min-w-[150px]">
                    <option value="">Todas las Áreas</option>
                    @foreach($areas as $area)
                        <option value="{{ $area->id }}" {{ request('area_id') == $area->id ? 'selected' : '' }}>{{ $area->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-2">
                <label class="text-xs font-semibold text-on-surface-variant uppercase tracking-wider">Tipo:</label>
                <select name="tipo_documento" class="px-3 py-2 bg-surface-lowest border border-outline-variant rounded-lg text-sm text-on-surface focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 transition-all cursor-pointer min-w-[130px]">
                    <option value="">Todos</option>
                    <option value="Oficio" {{ request('tipo_documento') == 'Oficio' ? 'selected' : '' }}>Oficio</option>
                    <option value="Solicitud" {{ request('tipo_documento') == 'Solicitud' ? 'selected' : '' }}>Solicitud</option>
                    <option value="Circular" {{ request('tipo_documento') == 'Circular' ? 'selected' : '' }}>Circular</option>
                    <option value="Memorándum" {{ request('tipo_documento') == 'Memorándum' ? 'selected' : '' }}>Memorándum</option>
                    <option value="Informe" {{ request('tipo_documento') == 'Informe' ? 'selected' : '' }}>Informe</option>
                </select>
            </div>
            
            <div class="flex items-center gap-2 ml-auto">
                <button type="submit" class="bg-primary hover:bg-primary/95 text-on-primary font-semibold text-sm px-5 py-2 rounded-lg shadow-sm transition-colors flex items-center gap-2 cursor-pointer">
                    <span class="material-symbols-outlined text-[18px]">search</span>
                    Filtrar
                </button>
                @if(request()->anyFilled(['numero_ficha', 'fecha_registro', 'area_id', 'tipo_documento']))
                    <a href="{{ route('entradas.index') }}" class="bg-surface-variant/20 text-on-surface-variant hover:text-error hover:bg-error/10 border border-outline-variant rounded-lg p-2 transition-colors flex items-center justify-center" title="Limpiar Filtros">
                        <span class="material-symbols-outlined text-[20px]">clear</span>
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Actions Bar -->
    @if(auth()->user()->role_id === 2)
    <div class="mb-4 flex justify-end">
        <a href="{{ route('entradas.create') }}" class="inline-flex items-center gap-2 bg-primary hover:bg-primary/95 text-on-primary font-semibold text-sm px-5 py-2.5 rounded-lg shadow-sm hover:shadow transition-all cursor-pointer scale-95 hover:scale-100 duration-150">
            <span class="material-symbols-outlined text-[18px]">add</span>
            Nueva Entrada
        </a>
    </div>
    @endif

    <!-- Table Card -->
    <div class="bg-surface-lowest border border-outline-variant rounded-2xl shadow-sm overflow-hidden flex flex-col transition-shadow hover:shadow-md">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-surface-variant/40 border-b border-outline-variant">
                        <th class="px-6 py-4 font-label-caps text-label-caps text-on-surface-variant uppercase tracking-wider font-semibold">ID / Control</th>
                        <th class="px-6 py-4 font-label-caps text-label-caps text-on-surface-variant uppercase tracking-wider font-semibold">Fecha y Hora</th>
                        <th class="px-6 py-4 font-label-caps text-label-caps text-on-surface-variant uppercase tracking-wider font-semibold">Origen / Remitente</th>
                        <th class="px-6 py-4 font-label-caps text-label-caps text-on-surface-variant uppercase tracking-wider font-semibold">Destino / Asunto</th>
                        <th class="px-6 py-4 font-label-caps text-label-caps text-on-surface-variant uppercase tracking-wider font-semibold text-center">Prioridad / Estatus</th>
                        <th class="px-6 py-4 font-label-caps text-label-caps text-on-surface-variant uppercase tracking-wider font-semibold text-center">Acción</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant/30 font-body-md text-body-md text-on-surface">
                    @forelse($correspondencias as $item)
                        <tr class="hover:bg-surface-variant/15 transition-colors group">
                            <td class="px-6 py-4">
                                <div class="flex flex-col gap-1">
                                    <span class="inline-flex font-mono bg-primary/5 text-primary border border-primary/10 px-2.5 py-1 rounded-lg text-xs font-semibold w-max">
                                        {{ $item->numero_control ?? $item->numero_ficha ?? 'Sin Ficha' }}
                                    </span>
                                    <span class="text-xs text-on-surface-variant/60 font-medium pl-1">{{ $item->tipo_documento }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2 text-on-surface-variant/80">
                                    <span class="material-symbols-outlined text-[18px]">calendar_today</span>
                                    <div class="text-sm">
                                        <p class="font-medium text-on-surface">{{ \Carbon\Carbon::parse($item->fecha_registro)->format('d/m/Y') }}</p>
                                        <p class="text-xs text-on-surface-variant/50">{{ \Carbon\Carbon::parse($item->fecha_registro)->format('H:i') }} hrs</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-start gap-2">
                                    <span class="material-symbols-outlined text-on-surface-variant/60 text-[18px] mt-0.5">person</span>
                                    <div>
                                        <p class="font-semibold text-on-surface group-hover:text-primary transition-colors">{{ $item->nombre_remitente }}</p>
                                        <p class="text-xs text-on-surface-variant/80">{{ $item->institucion }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-start gap-2">
                                    <span class="material-symbols-outlined text-on-surface-variant/60 text-[18px] mt-0.5">domain</span>
                                    <div class="max-w-[280px]">
                                        <p class="font-medium text-on-surface">{{ $item->nombre_destinatario }}</p>
                                        <p class="text-xs text-on-surface-variant/80 font-medium">{{ $item->area->nombre ?? 'Sin Área' }}</p>
                                        <p class="text-xs text-on-surface-variant/50 line-clamp-1 mt-1" title="{{ $item->asunto }}">{{ $item->asunto }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-col items-center gap-2">
                                    <!-- Prioridad Badge -->
                                    <div>
                                        @if($item->prioridad == 'urgente')
                                            <span class="inline-flex items-center justify-center px-2.5 py-0.5 rounded-full bg-rose-50 text-rose-700 text-[10px] font-bold border border-rose-200/50 gap-1 w-[100px]">
                                                <span class="material-symbols-outlined text-[12px] animate-pulse">priority_high</span> Urgente
                                            </span>
                                        @elseif($item->prioridad == 'confidencial')
                                            <span class="inline-flex items-center justify-center px-2.5 py-0.5 rounded-full bg-amber-50 text-amber-700 text-[10px] font-bold border border-amber-200/50 gap-1 w-[100px]">
                                                <span class="material-symbols-outlined text-[12px]">lock</span> Confidencial
                                            </span>
                                        @elseif($item->prioridad == 'con valores')
                                            <span class="inline-flex items-center justify-center px-2.5 py-0.5 rounded-full bg-blue-50 text-blue-700 text-[10px] font-bold border border-blue-200/50 gap-1 w-[100px]">
                                                <span class="material-symbols-outlined text-[12px]">diamond</span> Valores
                                            </span>
                                        @else
                                            <span class="inline-flex items-center justify-center px-2.5 py-0.5 rounded-full bg-slate-50 text-slate-600 text-[10px] font-semibold border border-slate-200 gap-1 w-[100px]">
                                                Ordinaria
                                            </span>
                                        @endif
                                    </div>
                                    
                                    <!-- Estado Badge -->
                                    <div>
                                        @if($item->estado == 'pendiente' || $item->estado == 'registrada')
                                            <span class="inline-flex items-center justify-center px-2.5 py-0.5 rounded-full bg-sky-50 text-sky-700 text-[10px] font-bold border border-sky-200/50 gap-1 w-[100px]">
                                                <span class="material-symbols-outlined text-[12px]">fiber_new</span> Registrada
                                            </span>
                                        @elseif($item->estado == 'entregada')
                                            <span class="inline-flex items-center justify-center px-2.5 py-0.5 rounded-full bg-emerald-50 text-emerald-700 text-[10px] font-bold border border-emerald-200/50 gap-1 w-[100px]">
                                                <span class="material-symbols-outlined text-[12px]">check_circle</span> Entregada
                                            </span>
                                        @else
                                            <span class="inline-flex items-center justify-center px-2.5 py-0.5 rounded-full bg-slate-100 text-slate-600 text-[10px] font-semibold border border-slate-200 gap-1 w-[100px]">
                                                {{ ucfirst($item->estado) }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex items-center justify-center gap-1">
                                    <a href="{{ route('seguimiento.index', ['numero_control' => $item->numero_control]) }}" class="p-2 text-on-surface-variant hover:text-primary hover:bg-surface-variant/60 rounded-full transition-all cursor-pointer" title="Ver Detalle">
                                        <span class="material-symbols-outlined text-[20px] block">visibility</span>
                                    </a>
                                    
                                    @if(($item->estado == 'pendiente' || $item->estado == 'registrada') && auth()->user()->role_id === 2)
                                        <!-- Enlace para Registrar Entrega -->
                                        <a href="{{ route('entradas.entrega', $item->id) }}" class="p-2 text-on-surface-variant hover:text-primary hover:bg-surface-variant/60 rounded-full transition-all cursor-pointer" title="Registrar Entrega">
                                            <span class="material-symbols-outlined text-[20px] block">local_shipping</span>
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-on-surface-variant/60">
                                <div class="flex flex-col items-center justify-center">
                                    <span class="material-symbols-outlined text-4xl mb-2 text-on-surface-variant/30">inbox</span>
                                    <p class="font-semibold text-on-surface-variant">No se encontraron registros de correspondencia</p>
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
            <div class="px-6 py-4 border-t border-outline-variant bg-surface-variant/10">
                {{ $correspondencias->links() }}
            </div>
        @elseif($correspondencias->isNotEmpty())
            <div class="px-6 py-4 border-t border-outline-variant bg-surface-variant/10 flex items-center justify-between text-xs text-on-surface-variant/60 font-medium">
                Mostrando todos los {{ $correspondencias->count() }} registros
            </div>
        @endif
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    // Auto-dismiss success alert
    const successAlert = document.getElementById('successAlert');
    if (successAlert) {
        setTimeout(() => {
            successAlert.style.opacity = '0';
            setTimeout(() => {
                successAlert.remove();
            }, 500);
        }, 2500); // 2.5 seconds
    }
});
</script>
@endsection
