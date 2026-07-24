@extends('layouts.app')

@section('title', 'Consulta de Correspondencia de Salida')

@section('content')
<div class="max-w-[1440px] mx-auto space-y-6">
    <!-- Success Message Alert -->
    @if(session('success'))
    <div id="successAlert" class="p-4 mb-4 text-sm text-emerald-800 bg-emerald-50 rounded-lg border border-emerald-200/50 flex items-center transition-all duration-500 ease-in-out" role="alert">
        <span class="material-symbols-outlined mr-2 text-emerald-500">check_circle</span>
        <span class="font-medium">{{ session('success') }}</span>
    </div>
    @endif

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-2">
        <div>
            <h1 class="font-headline-lg text-2xl md:text-3xl font-bold text-on-surface mb-1 flex items-center gap-2">
                <span class="material-symbols-outlined text-primary text-[32px]">outbox</span>
                Consulta de Correspondencia de Salida
            </h1>
            <p class="font-body-md text-sm text-on-surface-variant">Administre y supervise la correspondencia enviada por la institución.</p>
        </div>
        @if(auth()->user()->role_id === 2)
        <div class="self-end sm:self-auto">
            <a href="{{ route('salidas.create') }}" class="inline-flex items-center gap-2 bg-primary hover:bg-primary/95 text-on-primary font-semibold text-sm px-4 py-2.5 rounded-lg shadow-sm hover:shadow transition-all cursor-pointer">
                <span class="material-symbols-outlined text-[18px]">add</span>
                Nueva Salida
            </a>
        </div>
        @endif
    </div>

    <!-- Filters Section -->
    <div class="bg-surface-lowest border border-outline-variant rounded-xl shadow-sm p-4 mb-6">
        <form action="{{ route('salidas.index') }}" method="GET" class="flex flex-wrap items-center gap-4">
            <div class="flex-1 min-w-[200px] relative flex items-center">
                <span class="material-symbols-outlined absolute left-3 text-on-surface-variant/60 text-[20px] pointer-events-none select-none">search</span>
                <input type="text" name="numero_control" value="{{ request('numero_control') }}" class="w-full pl-10 pr-4 py-2.5 bg-surface-variant/10 border border-outline-variant rounded-lg text-sm text-on-surface placeholder:text-on-surface-variant/40 focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 transition-all" placeholder="Buscar por ID Control...">
            </div>
            
            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-2">
                <label class="text-xs font-semibold text-on-surface-variant uppercase tracking-wider">Fecha:</label>
                <input type="date" name="fecha" value="{{ request('fecha') }}" class="px-3 py-2 bg-surface-variant/10 border border-outline-variant rounded-lg text-sm text-on-surface focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 transition-all cursor-pointer">
            </div>

            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-2">
                <label class="text-xs font-semibold text-on-surface-variant uppercase tracking-wider">Área:</label>
                <select name="area_id" class="px-3 py-2 bg-surface-variant/10 border border-outline-variant rounded-lg text-sm text-on-surface focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 transition-all cursor-pointer">
                    <option value="">Todas las áreas</option>
                    @foreach($areas as $area)
                        <option value="{{ $area->id }}" {{ request('area_id') == $area->id ? 'selected' : '' }}>{{ $area->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-2">
                <label class="text-xs font-semibold text-on-surface-variant uppercase tracking-wider">Destinatario:</label>
                <input type="text" name="nombre_destinatario" value="{{ request('nombre_destinatario') }}" class="px-3 py-2 bg-surface-variant/10 border border-outline-variant rounded-lg text-sm text-on-surface placeholder:text-on-surface-variant/40 focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 transition-all" placeholder="Buscar Destinatario...">
            </div>

            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-2">
                <label class="text-xs font-semibold text-on-surface-variant uppercase tracking-wider">Prioridad:</label>
                <select name="tipo_entrega" class="px-3 py-2 bg-surface-variant/10 border border-outline-variant rounded-lg text-sm text-on-surface focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 transition-all cursor-pointer">
                    <option value="">Todas</option>
                    <option value="ordinario" {{ request('tipo_entrega') == 'ordinario' ? 'selected' : '' }}>Ordinario</option>
                    <option value="urgente" {{ request('tipo_entrega') == 'urgente' ? 'selected' : '' }}>Urgente</option>
                </select>
            </div>

            <div class="flex items-center gap-2 ml-auto">
                <button type="submit" class="inline-flex items-center gap-2 bg-primary hover:bg-primary/95 text-on-primary font-semibold text-sm px-4 py-2 rounded-lg shadow-sm transition-all cursor-pointer focus:outline-none">
                    <span class="material-symbols-outlined text-[18px]">filter_alt</span> Filtrar
                </button>
                @if(request()->anyFilled(['numero_control', 'fecha', 'area_id', 'nombre_destinatario', 'tipo_entrega']))
                    <a href="{{ route('salidas.index') }}" class="inline-flex items-center justify-center p-2 text-on-surface-variant/60 hover:text-error hover:bg-error/10 rounded-lg transition-colors cursor-pointer" title="Limpiar Filtros">
                        <span class="material-symbols-outlined text-[20px]">clear</span>
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Main Table Card -->
    <div class="bg-surface-lowest border border-outline-variant rounded-xl shadow-sm overflow-hidden transition-all hover:shadow-md">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-surface-variant/40 border-b border-outline-variant">
                        <th class="px-6 py-4 font-label-caps text-label-caps text-on-surface-variant uppercase tracking-wider font-semibold">No. Control</th>
                        <th class="px-6 py-4 font-label-caps text-label-caps text-on-surface-variant uppercase tracking-wider font-semibold">Fechas</th>
                        <th class="px-6 py-4 font-label-caps text-label-caps text-on-surface-variant uppercase tracking-wider font-semibold">Área Emisora</th>
                        <th class="px-6 py-4 font-label-caps text-label-caps text-on-surface-variant uppercase tracking-wider font-semibold">Destinatario</th>
                        <th class="px-6 py-4 font-label-caps text-label-caps text-on-surface-variant uppercase tracking-wider font-semibold text-center">Prioridad</th>
                        <th class="px-6 py-4 font-label-caps text-label-caps text-on-surface-variant uppercase tracking-wider font-semibold text-center">Estado</th>
                        <th class="px-6 py-4 font-label-caps text-label-caps text-on-surface-variant uppercase tracking-wider font-semibold text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant/30 font-body-md text-body-md text-on-surface">
                    @forelse($salidas as $item)
                        <tr class="hover:bg-surface-variant/15 transition-colors group">
                            <td class="px-6 py-4">
                                <span class="inline-flex font-mono bg-primary/5 text-primary border border-primary/10 px-2.5 py-1 rounded-lg text-xs font-semibold">
                                    {{ $item->numero_control }}
                                </span>
                                @if($item->numero_ficha)
                                    <span class="block text-xs text-on-surface-variant/60 mt-1">Ref: {{ $item->numero_ficha }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-on-surface-variant/80 whitespace-nowrap">
                                <div class="text-xs"><span class="font-bold text-on-surface-variant">Reg:</span> {{ \Carbon\Carbon::parse($item->fecha_registro)->format('d/m/Y') }}</div>
                                @if($item->fecha_limite_entrega)
                                    <div class="text-xs text-rose-600 mt-1"><span class="font-bold">Límite:</span> {{ \Carbon\Carbon::parse($item->fecha_limite_entrega)->format('d/m/Y') }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-on-surface-variant/80">
                                {{ $item->area->nombre ?? 'Interno' }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="block text-on-surface font-semibold group-hover:text-primary transition-colors">{{ $item->nombre_destinatario }}</span>
                                <span class="text-xs text-on-surface-variant/60">{{ $item->institucion }}</span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($item->prioridad == 'urgente')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-rose-50 text-rose-700 border border-rose-200/50">
                                        <span class="w-1.5 h-1.5 rounded-full bg-rose-500 mr-1.5"></span> Urgente
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-slate-50 text-slate-700 border border-slate-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-slate-500 mr-1.5"></span> Ordinario
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($item->estado == 'entregada')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200/50">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1.5"></span> Entregada
                                    </span>
                                @elseif($item->estado == 'en transito')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-200/50">
                                        <span class="w-1.5 h-1.5 rounded-full bg-blue-500 mr-1.5 animate-pulse"></span> En Tránsito
                                    </span>
                                @elseif($item->estado == 'en_recursos_materiales')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-700 border border-slate-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-slate-500 mr-1.5"></span> En Rec. Mat.
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-sky-50 text-sky-700 border border-sky-200/50">
                                        <span class="w-1.5 h-1.5 rounded-full bg-sky-500 mr-1.5"></span> Registrada
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center whitespace-nowrap">
                                <div class="flex items-center justify-center gap-1">
                                    <a href="{{ route('seguimiento.index', ['numero_control' => $item->numero_control]) }}" class="p-2 text-on-surface-variant hover:text-primary hover:bg-surface-variant/60 rounded-full transition-all cursor-pointer" title="Ver Rastreo / Detalle">
                                        <span class="material-symbols-outlined text-[20px] block">visibility</span>
                                    </a>
                                    @if(($item->estado == 'pendiente' || $item->estado == 'registrada') && auth()->user()->role_id === 2)
                                        <form action="{{ route('salidas.entregarRM', $item->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="p-2 text-on-surface-variant hover:text-primary hover:bg-surface-variant/60 rounded-full transition-all cursor-pointer focus:outline-none" title="Entregar a Recursos Materiales">
                                                <span class="material-symbols-outlined text-[20px] block">move_to_inbox</span>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-on-surface-variant/60">
                                <div class="flex flex-col items-center justify-center gap-2">
                                    <span class="material-symbols-outlined text-4xl text-on-surface-variant/30">search_off</span>
                                    <p class="font-semibold text-on-surface-variant">No se encontraron salidas registradas</p>
                                    <p class="text-xs">Intente ajustar los filtros de búsqueda o registre una nueva correspondencia.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($salidas->hasPages())
            <div class="px-6 py-4 border-t border-outline-variant bg-surface-variant/10">
                {{ $salidas->links() }}
            </div>
        @elseif($salidas->isNotEmpty())
            <div class="px-6 py-4 border-t border-outline-variant bg-surface-variant/10 flex items-center justify-between text-xs text-on-surface-variant/60 font-medium">
                Mostrando todos los {{ $salidas->count() }} registros
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
