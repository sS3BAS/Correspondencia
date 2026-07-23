@extends('layouts.app')

@section('title', 'Módulo de Seguimiento')

@section('content')
<div class="max-w-[1440px] mx-auto space-y-6">
    <!-- Page Title -->
    <div>
        <h2 class="font-headline-lg-mobile md:font-headline-lg text-2xl md:text-3xl font-bold text-slate-900">Módulo de Seguimiento</h2>
        <p class="font-body-lg text-sm text-slate-600 mt-1">Localice y supervise el estado de la correspondencia oficial en tiempo real.</p>
    </div>

    <!-- Buscador y Filtros Avanzados (Hero Style) -->
    <section class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 relative overflow-hidden">
        <!-- Subtle decorative background pattern to look 'institutional premium' -->
        <div class="absolute inset-0 bg-[radial-gradient(#e5e7eb_1px,transparent_1px)] [background-size:16px_16px] opacity-30 pointer-events-none"></div>
        
        <div class="relative z-10 max-w-4xl mx-auto space-y-4">
            <div class="text-center mb-6">
                <h3 class="font-headline-md text-xl font-semibold text-slate-800">Rastreo de Documento</h3>
                <p class="text-slate-500 text-sm mt-1">Ingrese los criterios de búsqueda para localizar su envío.</p>
            </div>

            <form action="{{ route('seguimiento.index') }}" method="GET" class="space-y-4">
                
                <!-- Main Search Bar -->
                <div class="flex flex-col sm:flex-row gap-4 w-full">
                    <div class="relative flex-1">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">
                            <span class="material-symbols-outlined">search</span>
                        </span>
                        <input type="text" name="numero_control" value="{{ request('numero_control') }}" class="w-full pl-12 pr-4 py-3 rounded-lg border border-slate-200 bg-white font-body-lg text-base text-slate-900 placeholder:text-slate-400 focus:outline-none focus:border-secondary focus:ring-1 focus:ring-secondary transition-all shadow-sm" placeholder="ID de Seguimiento / Número de Control (ej. UCC-2024-1042)">
                    </div>
                    <button type="submit" class="px-8 py-3 bg-slate-900 text-white rounded-lg font-medium text-sm hover:bg-slate-800 transition-colors shadow-sm whitespace-nowrap flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined text-[20px]">manage_search</span>
                        Rastrear
                    </button>
                </div>

                <!-- Advanced Filters -->
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 pt-2">
                    <div>
                        <label class="block text-xs font-medium text-slate-600 mb-1">Número de Ficha</label>
                        <input type="text" name="numero_ficha" value="{{ request('numero_ficha') }}" class="w-full px-3 py-2 border border-slate-200 rounded-lg bg-white focus:border-secondary focus:ring-1 focus:ring-secondary outline-none text-sm" placeholder="Ej. EXT-001">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-slate-600 mb-1">Fecha de Registro</label>
                        <input type="date" name="fecha" value="{{ request('fecha') }}" class="w-full px-3 py-2 border border-slate-200 rounded-lg bg-white focus:border-secondary focus:ring-1 focus:ring-secondary outline-none text-sm text-slate-700">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-slate-600 mb-1">Área Remitente/Destino</label>
                        <select name="area_id" class="w-full px-3 py-2 border border-slate-200 rounded-lg bg-white focus:border-secondary focus:ring-1 focus:ring-secondary outline-none text-sm text-slate-700">
                            <option value="">Todas las áreas</option>
                            @foreach($areas as $area)
                                <option value="{{ $area->id }}" {{ request('area_id') == $area->id ? 'selected' : '' }}>{{ $area->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-slate-600 mb-1">Estatus</label>
                        <select name="estado" class="w-full px-3 py-2 border border-slate-200 rounded-lg bg-white focus:border-secondary focus:ring-1 focus:ring-secondary outline-none text-sm text-slate-700">
                            <option value="">Todos</option>
                            <option value="pendiente" {{ request('estado') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                            <option value="registrada" {{ request('estado') == 'registrada' ? 'selected' : '' }}>Registrada</option>
                            <option value="en transito" {{ request('estado') == 'en transito' ? 'selected' : '' }}>En Tránsito</option>
                            <option value="entregada" {{ request('estado') == 'entregada' ? 'selected' : '' }}>Entregada</option>
                        </select>
                    </div>
                </div>

                @if(request()->anyFilled(['numero_ficha', 'numero_control', 'fecha', 'area_id', 'estado']))
                    <div class="flex justify-center pt-2">
                        <a href="{{ route('seguimiento.index') }}" class="text-slate-500 hover:text-red-600 text-sm font-medium transition-colors flex items-center gap-1">
                            <span class="material-symbols-outlined text-[16px]">clear</span> Limpiar Búsqueda
                        </a>
                    </div>
                @endif
            </form>
        </div>
    </section>

    <!-- Módulo de Detalle y Línea de Tiempo -->
    @if(request()->anyFilled(['numero_ficha', 'numero_control', 'fecha', 'area_id', 'estado']))
        @if($correspondencia)
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                
                <!-- Columna Izquierda: Ficha Resumen (Span 7) -->
                <div class="lg:col-span-7 space-y-6">
                    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
                        <div class="flex flex-wrap justify-between items-start gap-4 border-b border-slate-100 pb-4 mb-4">
                            <div>
                                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">ID / Número de Control</p>
                                <h3 class="font-headline-sm text-xl font-bold text-slate-900">{{ $correspondencia->numero_control ?? 'S/N' }}</h3>
                                @if($correspondencia->numero_ficha)
                                    <p class="text-sm text-slate-400 mt-0.5">Ficha: {{ $correspondencia->numero_ficha }}</p>
                                @endif
                            </div>
                            
                            <!-- Badge Estatus Actual -->
                            @if($correspondencia->estado == 'entregada')
                                <div class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-emerald-50 border border-emerald-200 text-emerald-700">
                                    <span class="material-symbols-outlined text-[16px]">check_circle</span>
                                    <span class="text-xs font-bold uppercase">Entregada</span>
                                </div>
                            @elseif($correspondencia->estado == 'en transito')
                                <div class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-blue-50 border border-blue-200 text-blue-700">
                                    <span class="material-symbols-outlined text-[16px]">local_shipping</span>
                                    <span class="text-xs font-bold uppercase">En Tránsito</span>
                                </div>
                            @else
                                <div class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-slate-100 border border-slate-200 text-slate-700">
                                    <span class="material-symbols-outlined text-[16px]">pending</span>
                                    <span class="text-xs font-bold uppercase">{{ $correspondencia->estado }}</span>
                                </div>
                            @endif
                        </div>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-4 gap-x-8">
                            <div>
                                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Remitente</p>
                                <p class="text-sm text-slate-800 font-medium">{{ $correspondencia->nombre_remitente ?? ($correspondencia->tipo == 'salida' ? $correspondencia->area->nombre ?? 'Interno' : 'N/A') }}</p>
                                <p class="text-xs text-slate-500">{{ $correspondencia->institucion }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Destinatario</p>
                                <p class="text-sm text-slate-800 font-medium">{{ $correspondencia->nombre_destinatario }}</p>
                                @if($correspondencia->tipo == 'entrada')
                                    <p class="text-xs text-slate-500">{{ $correspondencia->area->nombre ?? 'Sin Área' }}</p>
                                @endif
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Tipo de Documento</p>
                                <p class="text-sm text-slate-800">{{ $correspondencia->tipo_documento ?? $correspondencia->tipo_contenido ?? 'Documento' }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Fecha de Ingreso</p>
                                <p class="text-sm text-slate-800">{{ \Carbon\Carbon::parse($correspondencia->fecha_registro)->format('d M Y, H:i') }} hrs</p>
                            </div>
                        </div>
                    </div>

                    <!-- Resumen del Asunto -->
                    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
                        <h4 class="font-headline-sm text-lg font-semibold text-slate-800 mb-4">Resumen del Asunto</h4>
                        <p class="text-sm text-slate-700 leading-relaxed p-4 bg-slate-50 rounded-lg border border-slate-100">
                            {{ $correspondencia->asunto ?? 'Sin descripción de asunto proporcionada.' }}
                        </p>
                        
                        <div class="mt-4 flex flex-wrap gap-3">
                            <button class="flex items-center gap-2 px-4 py-2 bg-white border border-slate-200 rounded-md font-medium text-sm text-slate-700 hover:bg-slate-50 transition-colors">
                                <span class="material-symbols-outlined text-[18px]">print</span> Imprimir Ficha
                            </button>
                        </div>
                    </div>

                    <!-- Auditoría / Historial de Estados (Tabla) -->
                    @if($correspondencia->historial && $correspondencia->historial->count() > 0)
                        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
                            <h4 class="font-headline-sm text-lg font-semibold text-slate-800 mb-4 flex items-center gap-2">
                                <span class="material-symbols-outlined text-slate-400">history</span>
                                Auditoría de Cambios
                            </h4>
                            <div class="overflow-x-auto">
                                <table class="w-full text-left text-sm">
                                    <thead class="bg-slate-50 border-y border-slate-200">
                                        <tr>
                                            <th class="px-4 py-2 font-semibold text-slate-600">Fecha/Hora</th>
                                            <th class="px-4 py-2 font-semibold text-slate-600">Estado Anterior</th>
                                            <th class="px-4 py-2 font-semibold text-slate-600">Nuevo Estado</th>
                                            <th class="px-4 py-2 font-semibold text-slate-600">Usuario</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-100">
                                        @foreach($correspondencia->historial as $registro)
                                            <tr class="hover:bg-slate-50">
                                                <td class="px-4 py-2 text-slate-600">{{ \Carbon\Carbon::parse($registro->created_at)->format('d/m/Y H:i') }}</td>
                                                <td class="px-4 py-2 text-slate-500">{{ $registro->estado_anterior }}</td>
                                                <td class="px-4 py-2 font-medium text-slate-800">{{ $registro->estado_nuevo }}</td>
                                                <td class="px-4 py-2 text-slate-600">{{ $registro->usuario->nombre ?? 'Sistema' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Columna Derecha: Timeline Vertical (Span 5) -->
                <div class="lg:col-span-5">
                    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 h-full">
                        <h4 class="font-headline-sm text-lg font-semibold text-slate-800 mb-6 border-b border-slate-100 pb-4">Línea de Tiempo Logística</h4>
                        
                        <!-- Stepper Container -->
                        <div class="relative pl-4 border-l-2 space-y-8 pb-4 border-slate-200">
                            
                            <!-- Hito 1: Registro Inicial -->
                            <div class="relative">
                                <div class="absolute -left-[25px] top-1 w-4 h-4 rounded-full border-4 border-white bg-slate-900 shadow-sm"></div>
                                <div class="ml-4">
                                    <div class="flex justify-between items-start mb-1">
                                        <h5 class="text-sm font-bold text-slate-800">Capturado en Sistema</h5>
                                        <span class="text-xs text-slate-400">{{ \Carbon\Carbon::parse($correspondencia->fecha_registro)->format('H:i') }} hrs</span>
                                    </div>
                                    <p class="text-xs text-slate-400 mb-2">{{ \Carbon\Carbon::parse($correspondencia->fecha_registro)->format('d M Y') }}</p>
                                    <p class="text-sm text-slate-600">Ingresado al sistema UCC.</p>
                                </div>
                            </div>

                            <!-- Hito 2: Despacho Logístico (Si es Salida y tiene Reparto) -->
                            @if($correspondencia->tipo == 'salida' && $correspondencia->reparto)
                                <div class="relative">
                                    <div class="absolute -left-[25px] top-1 w-4 h-4 rounded-full border-4 border-white {{ $correspondencia->estado != 'pendiente' ? 'bg-slate-900' : 'bg-slate-300' }} shadow-sm"></div>
                                    <div class="ml-4">
                                        <div class="flex justify-between items-start mb-1">
                                            <h5 class="text-sm font-bold {{ $correspondencia->estado != 'pendiente' ? 'text-slate-800' : 'text-slate-500' }}">Asignado a Reparto</h5>
                                            @if($correspondencia->reparto->fecha_envio)
                                                <span class="text-xs text-slate-400">{{ \Carbon\Carbon::parse($correspondencia->reparto->fecha_envio)->format('H:i') }} hrs</span>
                                            @endif
                                        </div>
                                        @if($correspondencia->reparto->fecha_envio)
                                            <p class="text-xs text-slate-400 mb-2">{{ \Carbon\Carbon::parse($correspondencia->reparto->fecha_envio)->format('d M Y') }}</p>
                                        @endif
                                        <p class="text-sm {{ $correspondencia->estado != 'pendiente' ? 'text-slate-600' : 'text-slate-400' }}">
                                            Servicio: {{ $correspondencia->reparto->tipo_servicio }}
                                        </p>
                                        @if($correspondencia->reparto->mensajero)
                                            <div class="flex items-center gap-1 mt-1 text-slate-500">
                                                <span class="material-symbols-outlined text-[14px]">person</span>
                                                <span class="text-xs">Resp: {{ $correspondencia->reparto->mensajero }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                
                                <!-- Hito 3: En Tránsito -->
                                @if($correspondencia->reparto->estado == 'En tránsito' || $correspondencia->reparto->estado == 'Entregado')
                                    <div class="relative">
                                        <!-- Active State if currently in transit -->
                                        @if($correspondencia->reparto->estado == 'En tránsito')
                                            <div class="absolute -left-[25px] top-1 w-4 h-4 rounded-full bg-blue-600 border-4 border-white shadow-sm ring-2 ring-blue-200"></div>
                                        @else
                                            <div class="absolute -left-[25px] top-1 w-4 h-4 rounded-full border-4 border-white bg-slate-900 shadow-sm"></div>
                                        @endif
                                        <div class="ml-4">
                                            <div class="flex justify-between items-start mb-1">
                                                <h5 class="text-sm font-bold {{ $correspondencia->reparto->estado == 'En tránsito' ? 'text-blue-700' : 'text-slate-800' }}">En Tránsito</h5>
                                            </div>
                                            <div class="bg-slate-50 p-3 rounded-md border border-slate-100 mt-2">
                                                <p class="text-xs text-slate-600">El documento se encuentra en ruta hacia su destino final.</p>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endif

                            <!-- Hito Final: Entregado / Recibido -->
                            <div class="relative">
                                @if($correspondencia->estado == 'entregada')
                                    <div class="absolute -left-[25px] top-1 w-4 h-4 rounded-full bg-emerald-500 border-4 border-white shadow-sm ring-2 ring-emerald-200"></div>
                                    <div class="ml-4">
                                        <div class="flex justify-between items-start mb-1">
                                            <h5 class="text-sm font-bold text-emerald-700">Entregado Exitosamente</h5>
                                            @if($correspondencia->reparto && $correspondencia->reparto->fecha_entrega)
                                                <span class="text-xs text-slate-400">{{ \Carbon\Carbon::parse($correspondencia->reparto->fecha_entrega)->format('H:i') }} hrs</span>
                                            @endif
                                        </div>
                                        @if($correspondencia->reparto && $correspondencia->reparto->fecha_entrega)
                                            <p class="text-xs text-slate-400 mb-2">{{ \Carbon\Carbon::parse($correspondencia->reparto->fecha_entrega)->format('d M Y') }}</p>
                                        @endif
                                        <div class="flex items-center gap-1 mt-1 text-emerald-600">
                                            <span class="material-symbols-outlined text-[14px]">task_alt</span>
                                            <span class="text-xs font-medium">Acuse generado.</span>
                                        </div>
                                    </div>
                                @else
                                    <div class="absolute -left-[25px] top-1 w-4 h-4 rounded-full border-4 border-white bg-slate-200 shadow-sm"></div>
                                    <div class="ml-4">
                                        <div class="flex justify-between items-start mb-1">
                                            <h5 class="text-sm font-semibold text-slate-400">Recepción / Entrega</h5>
                                        </div>
                                        <p class="text-xs text-slate-400">Aún pendiente de confirmar entrega final.</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <!-- Estado Vacío (Búsqueda sin resultados) -->
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-12 text-center">
                <span class="material-symbols-outlined text-6xl text-slate-300 mb-4">search_off</span>
                <h4 class="font-headline-sm text-xl font-semibold text-slate-800 mb-2">Sin Resultados</h4>
                <p class="text-slate-600 text-sm max-w-md mx-auto">
                    No se encontró ninguna correspondencia con los criterios especificados. Verifique el Número de Control o los filtros e intente nuevamente.
                </p>
            </div>
        @endif
    @else
        <!-- Tarjeta Limpia de Inicio -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-12 text-center">
            <span class="material-symbols-outlined text-6xl text-slate-300 mb-4">manage_search</span>
            <h4 class="font-headline-sm text-xl font-semibold text-slate-800 mb-2">Sistema de Rastreo</h4>
            <p class="text-slate-600 text-sm max-w-md mx-auto">
                Ingrese un número de ficha, control o utilice los filtros superiores para rastrear la línea de tiempo completa de un documento oficial en el sistema.
            </p>
        </div>
    @endif
</div>
@endsection
