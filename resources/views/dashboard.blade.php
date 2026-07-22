@extends('layouts.app')

@section('title', 'Panel de Control')

@section('content')
<div class="max-w-container-max mx-auto">
    <!-- Page Header -->
    <div class="mb-stack-lg flex flex-col sm:flex-row sm:items-end justify-between gap-4">
        <div>
            <h1 class="font-headline-lg-mobile md:font-headline-lg text-headline-lg-mobile md:text-headline-lg text-on-surface mb-1">Panel Principal</h1>
            <p class="font-body-md text-body-md text-on-surface-variant">Resumen de la correspondencia diaria y acciones pendientes.</p>
        </div>
        <div class="flex gap-3">
            <button class="bg-surface-lowest border border-outline-variant text-on-surface px-4 py-2 rounded-md font-label-sm text-label-sm font-medium hover:bg-surface-variant/50 transition-colors flex items-center gap-2 shadow-sm">
                <span class="material-symbols-outlined" style="font-size: 18px;">download</span>
                Exportar Reporte
            </button>
            <button class="bg-primary text-on-primary px-4 py-2 rounded-md font-label-sm text-label-sm font-medium hover:bg-primary/90 transition-colors flex items-center gap-2 shadow-sm">
                <span class="material-symbols-outlined" style="font-size: 18px;">add</span>
                Nueva Entrada
            </button>
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
                    <span class="bg-secondary-fixed/50 text-on-secondary-fixed font-label-caps text-label-caps px-2 py-1 rounded-full text-[10px]">HOY</span>
                </div>
                <div class="relative z-10">
                    <p class="font-label-sm text-label-sm text-on-surface-variant mb-1">Total Entradas</p>
                    <div class="flex items-end gap-3">
                        <h4 class="font-headline-lg text-headline-lg text-on-surface leading-none">1,248</h4>
                        <span class="text-secondary font-label-sm text-label-sm flex items-center mb-1">
                            <span class="material-symbols-outlined" style="font-size: 14px;">arrow_upward</span>
                            12%
                        </span>
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
                </div>
                <div class="relative z-10">
                    <p class="font-label-sm text-label-sm text-on-surface-variant mb-1">Pendientes de Entrega</p>
                    <div class="flex items-end gap-3">
                        <h4 class="font-headline-lg text-headline-lg text-on-surface leading-none">342</h4>
                        <span class="text-outline font-label-sm text-label-sm flex items-center mb-1">
                            Acción Req.
                        </span>
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
                    <span class="bg-error/10 text-error font-label-caps text-label-caps px-2 py-1 rounded-full text-[10px] animate-pulse">CRÍTICO</span>
                </div>
                <div class="relative z-10">
                    <p class="font-label-sm text-label-sm text-on-surface-variant mb-1">Urgentes</p>
                    <div class="flex items-end gap-3">
                        <h4 class="font-headline-lg text-headline-lg text-on-surface leading-none">28</h4>
                        <span class="text-error font-label-sm text-label-sm flex items-center mb-1">
                            <span class="material-symbols-outlined" style="font-size: 14px;">arrow_upward</span>
                            5%
                        </span>
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
                </div>
                <div class="relative z-10">
                    <p class="font-label-sm text-label-sm text-on-surface-variant mb-1">Entregados Hoy</p>
                    <div class="flex items-end gap-3">
                        <h4 class="font-headline-lg text-headline-lg text-on-surface leading-none">891</h4>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Data Table Section Placeholder -->
    <section>
        <div class="flex justify-between items-center mb-stack-md">
            <h3 class="font-headline-sm text-headline-sm text-on-surface font-semibold">Entradas Recientes</h3>
            <a class="font-label-sm text-label-sm text-secondary hover:underline flex items-center gap-1" href="#">
                Ver Todo <span class="material-symbols-outlined" style="font-size: 16px;">arrow_forward</span>
            </a>
        </div>
        <div class="bg-surface-lowest border border-outline-variant rounded-xl shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-surface-container-low border-b border-outline-variant">
                            <th class="px-4 py-3 font-label-caps text-label-caps text-on-surface-variant uppercase tracking-wider">ID Rastreo</th>
                            <th class="px-4 py-3 font-label-caps text-label-caps text-on-surface-variant uppercase tracking-wider">Remitente</th>
                            <th class="px-4 py-3 font-label-caps text-label-caps text-on-surface-variant uppercase tracking-wider">Departamento</th>
                            <th class="px-4 py-3 font-label-caps text-label-caps text-on-surface-variant uppercase tracking-wider">Estado</th>
                            <th class="px-4 py-3 font-label-caps text-label-caps text-on-surface-variant uppercase tracking-wider text-right">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-b border-surface-variant hover:bg-surface-bright/50 transition-colors">
                            <td class="px-4 py-3 font-body-md text-body-md font-medium text-on-surface">UCC-2023-8901</td>
                            <td class="px-4 py-3 font-body-md text-body-md text-on-surface-variant">Ministerio de Defensa</td>
                            <td class="px-4 py-3 font-body-md text-body-md text-on-surface-variant">Logística</td>
                            <td class="px-4 py-3">
                                <span class="inline-flex items-center px-2 py-1 rounded-full bg-secondary-fixed/50 text-on-secondary-fixed font-label-sm text-[11px]">Procesando</span>
                            </td>
                            <td class="px-4 py-3 text-right">
                                <button class="text-outline hover:text-secondary p-1 rounded transition-colors"><span class="material-symbols-outlined" style="font-size: 20px;">more_vert</span></button>
                            </td>
                        </tr>
                        <tr class="border-b border-surface-variant hover:bg-surface-bright/50 transition-colors">
                            <td class="px-4 py-3 font-body-md text-body-md font-medium text-on-surface">UCC-2023-8902</td>
                            <td class="px-4 py-3 font-body-md text-body-md text-on-surface-variant">Depto. de Educación</td>
                            <td class="px-4 py-3 font-body-md text-body-md text-on-surface-variant">Recursos Humanos</td>
                            <td class="px-4 py-3">
                                <span class="inline-flex items-center px-2 py-1 rounded-full bg-error-container text-on-error-container font-label-sm text-[11px]">Urgente</span>
                            </td>
                            <td class="px-4 py-3 text-right">
                                <button class="text-outline hover:text-secondary p-1 rounded transition-colors"><span class="material-symbols-outlined" style="font-size: 20px;">more_vert</span></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>
@endsection
