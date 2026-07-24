@extends('layouts.app')

@section('title', 'Mis Entregas Asignadas')

@section('content')
<div class="max-w-[1440px] mx-auto space-y-6">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-2">
        <div>
            <h1 class="font-headline-lg text-2xl md:text-3xl font-bold text-on-surface mb-1 flex items-center gap-2">
                <span class="material-symbols-outlined text-primary text-[32px]">two_wheeler</span>
                Mis Entregas Asignadas
            </h1>
            <p class="font-body-md text-sm text-on-surface-variant">Paquetes y correspondencia saliente asignada a su nombre para entrega física y registro de acuse.</p>
        </div>
    </div>

    <!-- Success Message Alert -->
    @if(session('success'))
    <div id="successAlert" class="p-4 mb-4 text-sm text-emerald-800 bg-emerald-50 rounded-lg border border-emerald-200/50 flex items-center transition-all duration-500 ease-in-out" role="alert">
        <span class="material-symbols-outlined mr-2 text-emerald-500">check_circle</span>
        <span class="font-medium">{{ session('success') }}</span>
    </div>
    @endif

    <!-- Filters Section -->
    <div class="bg-surface-lowest border border-outline-variant rounded-xl shadow-sm p-4 mb-6">
        <form action="{{ route('mensajero.entregas') }}" method="GET" class="flex flex-wrap items-center gap-4">
            <div class="flex-1 min-w-[240px] relative flex items-center">
                <span class="material-symbols-outlined absolute left-3 text-on-surface-variant/60 text-[20px] pointer-events-none select-none">search</span>
                <input type="text" name="numero_control" value="{{ request('numero_control') }}" class="w-full pl-10 pr-4 py-2.5 bg-surface-variant/10 border border-outline-variant rounded-lg text-sm text-on-surface placeholder:text-on-surface-variant/40 focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 transition-all" placeholder="Buscar por Número de Control...">
            </div>

            <div class="flex items-center gap-2 ml-auto">
                <button type="submit" class="inline-flex items-center gap-2 bg-primary hover:bg-primary/95 text-on-primary font-semibold text-sm px-4 py-2.5 rounded-lg shadow-sm transition-all cursor-pointer focus:outline-none">
                    <span class="material-symbols-outlined text-[18px]">filter_alt</span> Buscar
                </button>
                @if(request()->filled('numero_control'))
                    <a href="{{ route('mensajero.entregas') }}" class="inline-flex items-center justify-center p-2.5 text-on-surface-variant/60 hover:text-error hover:bg-error/10 rounded-lg transition-colors cursor-pointer" title="Limpiar Filtro">
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
                        <th class="px-6 py-4 font-label-caps text-label-caps text-on-surface-variant uppercase tracking-wider font-semibold">Destinatario / Domicilio</th>
                        <th class="px-6 py-4 font-label-caps text-label-caps text-on-surface-variant uppercase tracking-wider font-semibold">Servicio / Fechas</th>
                        <th class="px-6 py-4 font-label-caps text-label-caps text-on-surface-variant uppercase tracking-wider font-semibold text-center">Estatus</th>
                        <th class="px-6 py-4 font-label-caps text-label-caps text-on-surface-variant uppercase tracking-wider font-semibold text-center">Acción</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant/30 font-body-md text-body-md text-on-surface">
                    @forelse($entregas as $item)
                        @php
                            $reparto = $item->reparto;
                        @endphp
                        <tr class="hover:bg-surface-variant/15 transition-colors group">
                            <td class="px-6 py-4">
                                <span class="inline-flex font-mono bg-primary/5 text-primary border border-primary/10 px-2.5 py-1 rounded-lg text-xs font-semibold">
                                    {{ $item->numero_control }}
                                </span>
                                @if($item->numero_ficha)
                                    <span class="block text-xs text-on-surface-variant/60 mt-1">Ref: {{ $item->numero_ficha }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 max-w-xs">
                                <span class="block font-semibold text-on-surface group-hover:text-primary transition-colors">{{ $item->nombre_destinatario }}</span>
                                <span class="text-xs text-on-surface-variant/60 block mb-1">{{ $item->institucion }}</span>
                                <span class="text-xs text-on-surface-variant/80 flex items-start gap-1 bg-surface-variant/20 p-2 rounded border border-outline-variant/20">
                                    <span class="material-symbols-outlined text-[14px] text-primary shrink-0 mt-0.5">location_on</span>
                                    <span>{{ $item->domicilio }}</span>
                                </span>
                            </td>
                            <td class="px-6 py-4 text-on-surface-variant/80 whitespace-nowrap">
                                <div class="text-xs font-semibold text-on-surface">{{ $reparto->tipo_servicio ?? 'Servicio Estándar' }}</div>
                                <div class="text-xs mt-1"><span class="font-bold text-on-surface-variant">Envío:</span> {{ $reparto && $reparto->fecha_envio ? \Carbon\Carbon::parse($reparto->fecha_envio)->format('d/m/Y H:i') : 'N/A' }}</div>
                                <div class="text-xs text-rose-600 font-medium mt-0.5"><span class="font-bold">Límite:</span> {{ $item->fecha_limite_entrega ? \Carbon\Carbon::parse($item->fecha_limite_entrega)->format('d/m/Y') : 'N/A' }}</div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($item->estado == 'entregada' || ($reparto && $reparto->estado == 'Entregado'))
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200/50">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1.5"></span> Entregado
                                    </span>
                                @elseif($reparto && $reparto->estado == 'En tránsito')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-blue-50 text-blue-700 border border-blue-200/50">
                                        <span class="w-1.5 h-1.5 rounded-full bg-blue-500 mr-1.5 animate-pulse"></span> En Tránsito
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200/50">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500 mr-1.5"></span> {{ $reparto->estado ?? 'Asignado' }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center whitespace-nowrap">
                                @if($item->estado != 'entregada' && ($reparto && $reparto->estado == 'En tránsito'))
                                    <a href="{{ route('acuses.create', $item->id) }}" class="inline-flex items-center gap-1.5 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-xs px-3.5 py-2 rounded-lg shadow-sm hover:shadow transition-all cursor-pointer">
                                        <span class="material-symbols-outlined text-[16px]">receipt_long</span>
                                        Registrar Acuse
                                    </a>
                                @elseif($item->estado == 'entregada')
                                    <span class="inline-flex items-center gap-1 text-xs text-emerald-600 font-semibold bg-emerald-50 px-3 py-1.5 rounded-lg border border-emerald-200/50">
                                        <span class="material-symbols-outlined text-[16px]">check_circle</span>
                                        Completado
                                    </span>
                                @else
                                    <span class="text-xs text-on-surface-variant/40 italic">Pendiente de despacho</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-on-surface-variant/60">
                                <div class="flex flex-col items-center justify-center gap-2">
                                    <span class="material-symbols-outlined text-4xl text-on-surface-variant/30">two_wheeler</span>
                                    <p class="font-semibold text-on-surface-variant">No tiene entregas asignadas actualmente</p>
                                    <p class="text-xs">Los paquetes asignados a su nombre por Recursos Materiales aparecerán en este panel.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($entregas->hasPages())
            <div class="px-6 py-4 border-t border-outline-variant bg-surface-variant/10">
                {{ $entregas->links() }}
            </div>
        @elseif($entregas->isNotEmpty())
            <div class="px-6 py-4 border-t border-outline-variant bg-surface-variant/10 flex items-center justify-between text-xs text-on-surface-variant/60 font-medium">
                Mostrando todos los {{ $entregas->count() }} registros asignados
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
