@extends('layouts.app')

@section('title', 'Panel de Control')

@section('content')
<div class="max-w-container-max mx-auto">
    @if(session('success'))
    <div id="successAlert" class="mb-6 p-4 text-sm text-emerald-800 bg-emerald-50 rounded-lg border border-emerald-200/50 flex items-center transition-all duration-500 ease-in-out" role="alert">
        <span class="material-symbols-outlined mr-2 text-emerald-500">check_circle</span>
        <span class="font-medium">{{ session('success') }}</span>
    </div>
    @endif

    <!-- Page Header -->
    <div class="mb-stack-lg flex flex-col sm:flex-row sm:items-end justify-between gap-4">
        <div>
            <h1 class="font-headline-lg-mobile md:font-headline-lg text-headline-lg-mobile md:text-headline-lg text-on-surface mb-1">Panel Principal</h1>
            <p class="font-body-md text-body-md text-on-surface-variant">Resumen de la correspondencia diaria y acciones pendientes.</p>
        </div>
    </div>

    <!-- Resumen de Correspondencia (Bento-style KPI Cards) -->
    <section class="mb-stack-lg">
        <h3 class="font-headline-sm text-headline-sm text-on-surface mb-stack-md font-semibold">Resumen de Correspondencia</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-gutter">
            <!-- Total Entradas -->
            <div class="bg-surface-lowest border border-outline-variant rounded-xl p-5 shadow-sm relative overflow-hidden group">
                <div class="absolute right-0 top-0 w-24 h-24 bg-secondary/5 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
                <div class="flex justify-between items-start mb-4 relative z-10">
                    <div class="p-2 bg-surface-variant text-secondary rounded-lg">
                        <span class="material-symbols-outlined">inventory_2</span>
                    </div>
                    <span class="bg-secondary-fixed/50 text-on-secondary-fixed font-label-caps text-label-caps px-2 py-1 rounded-full text-[10px]">REGISTRADAS</span>
                </div>
                <div class="relative z-10">
                    <p class="font-label-sm text-label-sm text-on-surface-variant mb-1">Total Entradas</p>
                    <div class="flex items-end gap-3">
                        <h4 class="font-headline-lg text-headline-lg text-on-surface leading-none">{{ number_format($totalEntradas) }}</h4>
                    </div>
                </div>
            </div>

            <!-- Pendientes de Entrega -->
            <div class="bg-surface-lowest border border-outline-variant rounded-xl p-5 shadow-sm relative overflow-hidden group">
                <div class="absolute right-0 top-0 w-24 h-24 bg-tertiary-fixed/30 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
                <div class="flex justify-between items-start mb-4 relative z-10">
                    <div class="p-2 bg-tertiary-fixed/50 text-on-tertiary-container rounded-lg">
                        <span class="material-symbols-outlined">schedule</span>
                    </div>
                    @if($pendientesEntrega > 0)
                        <span class="bg-amber-100 text-amber-800 font-label-caps text-label-caps px-2 py-1 rounded-full text-[10px]">EN PROCESO</span>
                    @endif
                </div>
                <div class="relative z-10">
                    <p class="font-label-sm text-label-sm text-on-surface-variant mb-1">Pendientes de Entrega</p>
                    <div class="flex items-end gap-3">
                        <h4 class="font-headline-lg text-headline-lg text-on-surface leading-none">{{ number_format($pendientesEntrega) }}</h4>
                    </div>
                </div>
            </div>

            <!-- Urgentes -->
            <div class="bg-surface-lowest border border-outline-variant rounded-xl p-5 shadow-sm relative overflow-hidden group">
                <div class="absolute right-0 top-0 w-24 h-24 bg-error-container/30 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
                <div class="flex justify-between items-start mb-4 relative z-10">
                    <div class="p-2 bg-error-container/50 text-error rounded-lg">
                        <span class="material-symbols-outlined">warning</span>
                    </div>
                    @if($urgentes > 0)
                        <span class="bg-error/10 text-error font-label-caps text-label-caps px-2 py-1 rounded-full text-[10px] animate-pulse">ATENCIÓN</span>
                    @endif
                </div>
                <div class="relative z-10">
                    <p class="font-label-sm text-label-sm text-on-surface-variant mb-1">Urgentes</p>
                    <div class="flex items-end gap-3">
                        <h4 class="font-headline-lg text-headline-lg text-on-surface leading-none">{{ number_format($urgentes) }}</h4>
                    </div>
                </div>
            </div>

            <!-- Entregados Hoy -->
            <div class="bg-surface-lowest border border-outline-variant rounded-xl p-5 shadow-sm relative overflow-hidden group">
                <div class="absolute right-0 top-0 w-24 h-24 bg-primary-fixed-dim/30 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
                <div class="flex justify-between items-start mb-4 relative z-10">
                    <div class="p-2 bg-primary-fixed/50 text-on-primary-fixed-variant rounded-lg">
                        <span class="material-symbols-outlined">check_circle</span>
                    </div>
                    <span class="bg-emerald-100 text-emerald-800 font-label-caps text-label-caps px-2 py-1 rounded-full text-[10px]">HOY</span>
                </div>
                <div class="relative z-10">
                    <p class="font-label-sm text-label-sm text-on-surface-variant mb-1">Entregados Hoy</p>
                    <div class="flex items-end gap-3">
                        <h4 class="font-headline-lg text-headline-lg text-on-surface leading-none">{{ number_format($entregadosHoy) }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Data Table Section -->
    <section>
        <div class="mb-stack-md flex justify-between items-center">
            <h3 class="font-headline-sm text-headline-sm text-on-surface font-semibold flex items-center gap-2">
                <span class="material-symbols-outlined text-primary text-[24px]">history</span>
                Entradas Recientes
            </h3>
        </div>
        <div class="bg-surface-lowest border border-outline-variant rounded-xl shadow-sm overflow-hidden transition-all hover:shadow-md">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-surface-variant/40 border-b border-outline-variant">
                            <th class="px-6 py-4 font-label-caps text-label-caps text-on-surface-variant uppercase tracking-wider font-semibold">ID Rastreo</th>
                            <th class="px-6 py-4 font-label-caps text-label-caps text-on-surface-variant uppercase tracking-wider font-semibold">Remitente</th>
                            <th class="px-6 py-4 font-label-caps text-label-caps text-on-surface-variant uppercase tracking-wider font-semibold">Departamento</th>
                            <th class="px-6 py-4 font-label-caps text-label-caps text-on-surface-variant uppercase tracking-wider font-semibold">Estado</th>
                            <th class="px-6 py-4 font-label-caps text-label-caps text-on-surface-variant uppercase tracking-wider font-semibold text-right">Acción</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-outline-variant/30 font-body-md text-body-md text-on-surface">
                        @forelse($entradasRecientes ?? [] as $item)
                            <tr class="hover:bg-surface-variant/15 transition-colors group">
                                <td class="px-6 py-4">
                                    <span class="inline-flex font-mono bg-primary/5 text-primary border border-primary/10 px-2.5 py-1 rounded-lg text-xs font-semibold">
                                        {{ $item->numero_control ?? $item->numero_ficha ?? 'Sin Ficha' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2 font-medium text-on-surface group-hover:text-primary transition-colors">
                                        <span class="material-symbols-outlined text-on-surface-variant/60 text-[18px]">domain</span>
                                        {{ $item->nombre_remitente }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-on-surface-variant/80">
                                    {{ $item->area->nombre ?? 'Sin Área' }}
                                </td>
                                <td class="px-6 py-4">
                                    @if($item->estado == 'pendiente' || $item->estado == 'registrada')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-sky-50 text-sky-700 border border-sky-200/50">
                                            <span class="w-1.5 h-1.5 rounded-full bg-sky-500 mr-1.5"></span> Registrada
                                        </span>
                                    @elseif($item->estado == 'entregada')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200/50">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1.5"></span> Entregada
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-slate-50 text-slate-700 border border-slate-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-slate-500 mr-1.5"></span> {{ ucfirst($item->estado) }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('seguimiento.index', ['numero_control' => $item->numero_control]) }}" class="text-on-surface-variant hover:text-primary hover:bg-surface-variant/60 p-1.5 rounded-full transition-all inline-block cursor-pointer" title="Ver Detalle">
                                        <span class="material-symbols-outlined text-[20px] block">visibility</span>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-on-surface-variant/60">
                                    <div class="flex flex-col items-center justify-center gap-2">
                                        <span class="material-symbols-outlined text-4xl text-on-surface-variant/30">inbox</span>
                                        <p class="font-semibold text-on-surface-variant">No hay correspondencia reciente registrada</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>
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
