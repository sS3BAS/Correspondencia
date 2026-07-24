@extends('layouts.app')

@section('title', 'Módulo de Seguimiento')

@section('content')
<div class="max-w-[1440px] mx-auto space-y-6">
    <!-- Page Title -->
    <div>
        <h2 class="font-headline-lg text-2xl md:text-3xl font-bold text-on-surface flex items-center gap-2">
            <span class="material-symbols-outlined text-primary text-[32px]">location_searching</span>
            Módulo de Seguimiento
        </h2>
        <p class="font-body-md text-sm text-on-surface-variant mt-1">Localice y supervise el estado de la correspondencia oficial en tiempo real.</p>
    </div>

    <!-- Buscador y Filtros Avanzados (Hero Style) -->
    <section class="bg-surface-lowest rounded-2xl border border-outline-variant shadow-sm p-6 md:p-8 relative overflow-hidden transition-shadow hover:shadow-md">
        <!-- Decorative background element for premium feel -->
        <div class="absolute top-0 right-0 w-64 h-64 bg-primary/5 rounded-full blur-3xl -mr-20 -mt-20 pointer-events-none"></div>
        <div class="absolute inset-0 bg-[radial-gradient(#e5e7eb_1px,transparent_1px)] [background-size:16px_16px] opacity-20 pointer-events-none"></div>
        
        <div class="relative z-10 max-w-4xl mx-auto space-y-6">
            <div class="text-center">
                <h3 class="font-headline-sm text-xl font-bold text-on-surface">Rastreo de Documento</h3>
                <p class="text-on-surface-variant/70 text-sm mt-1">Ingrese los criterios de búsqueda para localizar su envío.</p>
            </div>

            <form action="{{ route('seguimiento.index') }}" method="GET" class="space-y-6">
                
                <!-- Main Search Bar -->
                <div class="flex flex-col sm:flex-row gap-3 w-full">
                    <div class="relative flex-1 flex items-center">
                        <span class="absolute left-4 text-on-surface-variant/60 pointer-events-none select-none">
                            <span class="material-symbols-outlined text-[22px]">search</span>
                        </span>
                        <input type="text" name="numero_control" value="{{ request('numero_control') }}" class="w-full pl-12 pr-4 py-3 rounded-xl border border-outline-variant bg-surface-lowest font-body-lg text-base text-on-surface placeholder:text-on-surface-variant/40 focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 transition-all shadow-sm" placeholder="ID de Seguimiento / Número de Control (ej. UCC-2024-1042)">
                    </div>
                    <button type="submit" class="px-8 py-3 bg-primary hover:bg-primary/95 text-on-primary rounded-xl font-semibold text-sm shadow-sm hover:shadow transition-all whitespace-nowrap flex items-center justify-center gap-2 cursor-pointer focus:outline-none">
                        <span class="material-symbols-outlined text-[20px]">manage_search</span>
                        Rastrear
                    </button>
                </div>

                <!-- Advanced Filters -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-2">
                    <div class="flex flex-col gap-1">
                        <label class="text-xs font-semibold text-on-surface-variant uppercase tracking-wider">Fecha de Registro</label>
                        <input type="date" name="fecha" value="{{ request('fecha') }}" class="w-full px-3 py-2 border border-outline-variant rounded-lg bg-surface-lowest text-on-surface focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 transition-all text-sm cursor-pointer">
                    </div>
                    <div class="flex flex-col gap-1">
                        <label class="text-xs font-semibold text-on-surface-variant uppercase tracking-wider">Área Destinataria</label>
                        <select name="area_id" class="w-full px-3 py-2 border border-outline-variant rounded-lg bg-surface-lowest text-on-surface focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 transition-all text-sm cursor-pointer">
                            <option value="">Todas las áreas</option>
                            @foreach($areas as $area)
                                <option value="{{ $area->id }}" {{ request('area_id') == $area->id ? 'selected' : '' }}>{{ $area->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex flex-col gap-1">
                        <label class="text-xs font-semibold text-on-surface-variant uppercase tracking-wider">Estatus</label>
                        <select name="estado" class="w-full px-3 py-2 border border-outline-variant rounded-lg bg-surface-lowest text-on-surface focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 transition-all text-sm cursor-pointer">
                            <option value="">Todos</option>
                            <option value="pendiente" {{ request('estado') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                            <option value="registrada" {{ request('estado') == 'registrada' ? 'selected' : '' }}>Registrada</option>
                            <option value="en transito" {{ request('estado') == 'en transito' ? 'selected' : '' }}>En Tránsito</option>
                            <option value="entregada" {{ request('estado') == 'entregada' ? 'selected' : '' }}>Entregada</option>
                        </select>
                    </div>
                </div>

                @if(request()->anyFilled(['numero_control', 'fecha', 'area_id', 'estado']))
                    <div class="flex justify-center pt-2">
                        <a href="{{ route('seguimiento.index') }}" class="text-on-surface-variant/60 hover:text-error text-sm font-semibold transition-colors flex items-center gap-1">
                            <span class="material-symbols-outlined text-[18px]">clear</span> Limpiar Búsqueda
                        </a>
                    </div>
                @endif
            </form>
        </div>
    </section>

    <!-- Módulo de Detalle y Línea de Tiempo -->
    @if(request()->anyFilled(['numero_control', 'fecha', 'area_id', 'estado']))
        @if($correspondencia)
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                
                <!-- Columna Izquierda: Ficha Resumen (Span 7) -->
                <div class="lg:col-span-7 space-y-6">
                    <div class="bg-surface-lowest rounded-2xl border border-outline-variant shadow-sm p-6">
                        <div class="flex flex-wrap justify-between items-start gap-4 border-b border-outline-variant/30 pb-4 mb-4">
                            <div>
                                <p class="text-xs font-semibold text-on-surface-variant uppercase tracking-wider mb-1">ID / Número de Control</p>
                                <h3 class="font-headline-sm text-xl font-bold text-primary font-mono">{{ $correspondencia->numero_control ?? 'S/N' }}</h3>
                                @if($correspondencia->numero_ficha)
                                    <p class="text-sm text-on-surface-variant/60 mt-0.5">Ficha: {{ $correspondencia->numero_ficha }}</p>
                                @endif
                            </div>
                            
                            <!-- Badge Estatus Actual -->
                            @if($correspondencia->estado == 'entregada')
                                <div class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-emerald-50 border border-emerald-200/50 text-emerald-700">
                                    <span class="material-symbols-outlined text-[16px]">check_circle</span>
                                    <span class="text-xs font-bold uppercase">Entregada</span>
                                </div>
                            @elseif($correspondencia->estado == 'en transito')
                                <div class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-blue-50 border border-blue-200/50 text-blue-700">
                                    <span class="material-symbols-outlined text-[16px]">local_shipping</span>
                                    <span class="text-xs font-bold uppercase">En Tránsito</span>
                                </div>
                            @else
                                <div class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-sky-50 border border-sky-200/50 text-sky-700">
                                    <span class="material-symbols-outlined text-[16px]">fiber_new</span>
                                    <span class="text-xs font-bold uppercase">{{ ucfirst($correspondencia->estado) }}</span>
                                </div>
                            @endif
                        </div>
                                   <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-4 gap-x-8">
                            <div>
                                <p class="text-xs font-semibold text-on-surface-variant uppercase tracking-wider mb-1">Remitente</p>
                                <p class="text-sm text-on-surface font-semibold">{{ $correspondencia->nombre_remitente ?? ($correspondencia->tipo == 'salida' ? $correspondencia->area->nombre ?? 'Interno' : 'N/A') }}</p>
                                <p class="text-xs text-on-surface-variant">{{ $correspondencia->institucion }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-on-surface-variant uppercase tracking-wider mb-1">Destinatario</p>
                                <p class="text-sm text-on-surface font-semibold">{{ $correspondencia->nombre_destinatario }}</p>
                                @if($correspondencia->tipo == 'entrada')
                                    <p class="text-xs text-on-surface-variant">{{ $correspondencia->area->nombre ?? 'Sin Área' }}</p>
                                @endif
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-on-surface-variant uppercase tracking-wider mb-1">Tipo de Documento</p>
                                <p class="text-sm text-on-surface font-medium">{{ $correspondencia->tipo_documento ?? $correspondencia->tipo_contenido ?? 'Documento' }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-on-surface-variant uppercase tracking-wider mb-1">Fecha de Ingreso</p>
                                <p class="text-sm text-on-surface font-medium">{{ \Carbon\Carbon::parse($correspondencia->fecha_registro)->format('d M Y, H:i') }} hrs</p>
                            </div>

                            @if($correspondencia->estado == 'entregada')
                                @php
                                    $recibidoPor = null;
                                    $areaRecibe = null;
                                    $observacionesEntrega = null;
                                    if ($correspondencia->reparto && $correspondencia->reparto->fecha_entrega) {
                                        $recibidoPor = $correspondencia->reparto->mensajero;
                                        $observacionesEntrega = $correspondencia->reparto->observaciones;
                                    } elseif ($correspondencia->entrega && $correspondencia->entrega->fecha_entrega) {
                                        $recibidoPor = $correspondencia->entrega->usuario_recibe;
                                        $observacionesEntrega = $correspondencia->entrega->observaciones;
                                        $areaRecibe = $correspondencia->entrega->area_recibe;
                                    }
                                @endphp
                                @if($recibidoPor)
                                    <div>
                                        <p class="text-xs font-semibold text-on-surface-variant uppercase tracking-wider mb-1">Recibido Por</p>
                                        <p class="text-sm text-on-surface font-semibold">{{ $recibidoPor }}</p>
                                    </div>
                                @endif
                                @if($areaRecibe)
                                    <div>
                                        <p class="text-xs font-semibold text-on-surface-variant uppercase tracking-wider mb-1">Área que Recibe</p>
                                        <p class="text-sm text-on-surface font-semibold">{{ $areaRecibe }}</p>
                                    </div>
                                @endif
                                @if(!empty($observacionesEntrega))
                                    <div class="sm:col-span-2 border-t border-outline-variant/30 pt-3 mt-1">
                                        <p class="text-xs font-semibold text-on-surface-variant uppercase tracking-wider mb-1">Observaciones de la Entrega</p>
                                        <p class="text-sm text-on-surface bg-surface-variant/30 p-3 rounded-lg border border-outline-variant/20 italic">"{{ $observacionesEntrega }}"</p>
                                    </div>
                                @endif
                            @endif

                            <!-- Resumen del Asunto integrado en la Ficha -->
                            <div class="sm:col-span-2 border-t border-outline-variant/30 pt-3 mt-1">
                                <p class="text-xs font-semibold text-on-surface-variant uppercase tracking-wider mb-1">Resumen del Asunto</p>
                                <p class="text-sm text-on-surface-variant leading-relaxed bg-surface-variant/30 p-3.5 rounded-xl border border-outline-variant/20">
                                    {{ $correspondencia->asunto ?? 'Sin descripción de asunto proporcionada.' }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Detalles del Acuse de Recibido (Registrado por el Mensajero) -->
                    @if($correspondencia->acuse)
                        <div class="bg-surface-lowest rounded-2xl border border-emerald-200/60 shadow-sm p-6 bg-emerald-50/20">
                            <div class="flex items-center justify-between mb-4 pb-3 border-b border-emerald-100">
                                <h4 class="font-headline-sm text-lg font-bold text-emerald-900 flex items-center gap-2">
                                    <span class="material-symbols-outlined text-emerald-600">receipt_long</span>
                                    Datos del Acuse de Recibido
                                </h4>
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800 border border-emerald-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1.5"></span> Registrado
                                </span>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                                <div class="bg-white/80 p-3 rounded-xl border border-emerald-100/80">
                                    <p class="text-xs font-semibold text-emerald-700 uppercase tracking-wider mb-1">Fecha y Hora de Recepción</p>
                                    <p class="text-sm font-bold text-emerald-950 flex items-center gap-1.5">
                                        <span class="material-symbols-outlined text-[16px] text-emerald-600">event</span>
                                        {{ \Carbon\Carbon::parse($correspondencia->acuse->fecha_acuse)->format('d/m/Y H:i') }} hrs
                                    </p>
                                </div>
                                <div class="bg-white/80 p-3 rounded-xl border border-emerald-100/80">
                                    <p class="text-xs font-semibold text-emerald-700 uppercase tracking-wider mb-1">Nombre de Quien Recibió / Firmó</p>
                                    <p class="text-sm font-bold text-emerald-950 flex items-center gap-1.5">
                                        <span class="material-symbols-outlined text-[16px] text-emerald-600">person_check</span>
                                        {{ $correspondencia->acuse->nombre_recibe }}
                                    </p>
                                </div>
                            </div>
                            @if(!empty($correspondencia->acuse->observaciones))
                                <div class="bg-white/80 p-4 rounded-xl border border-emerald-100/80">
                                    <p class="text-xs font-semibold text-emerald-700 uppercase tracking-wider mb-1">Observaciones / Condición del Envío</p>
                                    <p class="text-sm text-emerald-900 italic font-medium">"{{ $correspondencia->acuse->observaciones }}"</p>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>

                <!-- Columna Derecha: Timeline Vertical (Span 5) -->
                <div class="lg:col-span-5">
                    <div class="bg-surface-lowest rounded-2xl border border-outline-variant shadow-sm p-6 relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-64 h-64 bg-primary/5 rounded-full blur-3xl -mr-20 -mt-20 pointer-events-none"></div>
                        <h4 class="font-headline-sm text-lg font-bold text-on-surface mb-6 border-b border-outline-variant/30 pb-4 relative z-10">Línea de Tiempo Logística</h4>
                        
                        <!-- Stepper Container -->
                        <div class="relative pl-4 border-l-2 space-y-8 pb-4 border-outline-variant/50 relative z-10">
                            
                            <!-- Hito 1: Registro Inicial -->
                            <div class="relative">
                                <div class="absolute -left-[25px] top-1 w-4 h-4 rounded-full border-4 border-surface-lowest bg-primary shadow-sm"></div>
                                <div class="ml-4">
                                    <div class="flex justify-between items-start mb-1">
                                        <h5 class="text-sm font-bold text-on-surface">Capturado en Sistema</h5>
                                        <span class="text-xs text-on-surface-variant/50 font-semibold">{{ \Carbon\Carbon::parse($correspondencia->fecha_registro)->format('H:i') }} hrs</span>
                                    </div>
                                    <p class="text-xs text-on-surface-variant/50 font-semibold mb-2">{{ \Carbon\Carbon::parse($correspondencia->fecha_registro)->format('d M Y') }}</p>
                                    <p class="text-sm text-on-surface-variant/80">Ingresado al sistema UCC.</p>
                                </div>
                            </div>

                            <!-- Hito Nuevo: Entregado a Recursos Materiales (Solo si es Salida) -->
                            @if($correspondencia->tipo == 'salida')
                                @php
                                    $hasRM = in_array($correspondencia->estado, ['en_recursos_materiales', 'en transito', 'entregada']);
                                    $rmLog = $correspondencia->historial->where('estado', 'En Recursos Materiales')->first();
                                @endphp
                                <div class="relative">
                                    <div class="absolute -left-[25px] top-1 w-4 h-4 rounded-full border-4 border-surface-lowest {{ $hasRM ? 'bg-primary' : 'bg-outline-variant' }} shadow-sm"></div>
                                    <div class="ml-4">
                                        <div class="flex justify-between items-start mb-1">
                                            <h5 class="text-sm font-bold {{ $hasRM ? 'text-on-surface' : 'text-on-surface-variant/50' }}">Entregado a Recursos Materiales</h5>
                                            @if($rmLog)
                                                <span class="text-xs text-on-surface-variant/50 font-semibold">{{ \Carbon\Carbon::parse($rmLog->fecha ?? $rmLog->created_at)->format('H:i') }} hrs</span>
                                            @endif
                                        </div>
                                        @if($rmLog)
                                            <p class="text-xs text-on-surface-variant/50 font-semibold mb-2">{{ \Carbon\Carbon::parse($rmLog->fecha ?? $rmLog->created_at)->format('d M Y') }}</p>
                                        @endif
                                        <p class="text-sm {{ $hasRM ? 'text-on-surface-variant/80' : 'text-on-surface-variant/40' }}">
                                            Entrega física y traspaso de custodia para envío.
                                        </p>
                                    </div>
                                </div>
                            @endif

                            <!-- Hito 2: Despacho Logístico (Si es Salida y tiene Reparto) -->
                            @if($correspondencia->tipo == 'salida' && $correspondencia->reparto)
                                <div class="relative">
                                    <div class="absolute -left-[25px] top-1 w-4 h-4 rounded-full border-4 border-surface-lowest {{ $correspondencia->estado != 'pendiente' ? 'bg-primary' : 'bg-outline-variant' }} shadow-sm"></div>
                                    <div class="ml-4">
                                        <div class="flex justify-between items-start mb-1">
                                            <h5 class="text-sm font-bold {{ $correspondencia->estado != 'pendiente' ? 'text-on-surface' : 'text-on-surface-variant/50' }}">Asignado a Reparto</h5>
                                            @if($correspondencia->reparto->fecha_envio)
                                                <span class="text-xs text-on-surface-variant/50 font-semibold">{{ \Carbon\Carbon::parse($correspondencia->reparto->fecha_envio)->format('H:i') }} hrs</span>
                                            @endif
                                        </div>
                                        @if($correspondencia->reparto->fecha_envio)
                                            <p class="text-xs text-on-surface-variant/50 font-semibold mb-2">{{ \Carbon\Carbon::parse($correspondencia->reparto->fecha_envio)->format('d M Y') }}</p>
                                        @endif
                                        <p class="text-sm {{ $correspondencia->estado != 'pendiente' ? 'text-on-surface-variant/80' : 'text-on-surface-variant/40' }}">
                                            Servicio: {{ $correspondencia->reparto->tipo_servicio }}
                                        </p>
                                        @if($correspondencia->reparto->mensajero)
                                            <div class="flex items-center gap-1 mt-1 text-on-surface-variant/60">
                                                <span class="material-symbols-outlined text-[14px]">person</span>
                                                <span class="text-xs font-semibold">Resp: {{ $correspondencia->reparto->mensajero }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                
                                <!-- Hito 3: En Tránsito -->
                                @if($correspondencia->reparto->estado == 'En tránsito' || $correspondencia->reparto->estado == 'Entregado')
                                    <div class="relative">
                                        <!-- Active State if currently in transit -->
                                        @if($correspondencia->reparto->estado == 'En tránsito')
                                            <div class="absolute -left-[25px] top-1 w-4 h-4 rounded-full bg-primary border-4 border-surface-lowest shadow-sm ring-2 ring-primary/20"></div>
                                        @else
                                            <div class="absolute -left-[25px] top-1 w-4 h-4 rounded-full border-4 border-surface-lowest bg-primary shadow-sm"></div>
                                        @endif
                                        <div class="ml-4">
                                            <div class="flex justify-between items-start mb-1">
                                                <h5 class="text-sm font-bold {{ $correspondencia->reparto->estado == 'En tránsito' ? 'text-primary' : 'text-on-surface' }}">En Tránsito</h5>
                                            </div>
                                            <div class="bg-surface-variant/40 p-3 rounded-lg border border-outline-variant/20 mt-2">
                                                <p class="text-xs text-on-surface-variant/80">El documento se encuentra en ruta hacia su destino final.</p>
                                                @if($correspondencia->reparto->estado == 'En tránsito' && auth()->user()->role_id === 4)
                                                    <div class="mt-3">
                                                        <a href="{{ route('acuses.create', $correspondencia->id) }}" class="inline-flex items-center gap-2 bg-primary hover:bg-primary/95 text-on-primary text-xs font-semibold px-3 py-2 rounded-lg shadow-sm transition-all cursor-pointer">
                                                            <span class="material-symbols-outlined text-[16px]">receipt_long</span>
                                                            Registrar Acuse
                                                        </a>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endif

                            <!-- Hito Final: Entregado / Recibido -->
                            @php
                                $fechaEntrega = null;
                                $recibidoPor = null;
                                $observacionesEntrega = null;
                                $areaRecibe = null;
                                if ($correspondencia->reparto && $correspondencia->reparto->fecha_entrega) {
                                    $fechaEntrega = \Carbon\Carbon::parse($correspondencia->reparto->fecha_entrega);
                                    $recibidoPor = $correspondencia->reparto->mensajero;
                                    $observacionesEntrega = $correspondencia->reparto->observaciones;
                                } elseif ($correspondencia->entrega && $correspondencia->entrega->fecha_entrega) {
                                    $fechaEntrega = \Carbon\Carbon::parse($correspondencia->entrega->fecha_entrega);
                                    $recibidoPor = $correspondencia->entrega->usuario_recibe;
                                    $observacionesEntrega = $correspondencia->entrega->observaciones;
                                    $areaRecibe = $correspondencia->entrega->area_recibe;
                                }
                            @endphp
                            <div class="relative">
                                @if($correspondencia->estado == 'entregada')
                                    <div class="absolute -left-[25px] top-1 w-4 h-4 rounded-full bg-emerald-500 border-4 border-surface-lowest shadow-sm ring-2 ring-emerald-200"></div>
                                    <div class="ml-4">
                                        <div class="flex justify-between items-start mb-1">
                                            <h5 class="text-sm font-bold text-emerald-700">Entregado Exitosamente</h5>
                                            @if($fechaEntrega)
                                                <span class="text-xs text-on-surface-variant/60 font-semibold">{{ $fechaEntrega->format('H:i') }} hrs</span>
                                            @endif
                                        </div>
                                        @if($fechaEntrega)
                                            <p class="text-xs text-on-surface-variant/60 font-semibold mb-2">{{ $fechaEntrega->format('d M Y') }}</p>
                                        @endif
                                        <p class="text-sm text-on-surface-variant/80">Ciclo completado y acuse registrado.</p>
                                    </div>
                                @else
                                    <div class="absolute -left-[25px] top-1 w-4 h-4 rounded-full border-4 border-surface-lowest bg-outline-variant shadow-sm"></div>
                                    <div class="ml-4">
                                        <h5 class="text-sm font-bold text-on-surface-variant/40 mb-1">Pendiente de Entrega</h5>
                                        <p class="text-xs text-on-surface-variant/40">El paquete no ha sido entregado en su destino final.</p>
                                    </div>
                                @endif
                            </div>

                        </div>
                    </div>
                </div>

                <!-- Sección Ancha de Detalles / Historial de Estados (Span 12) -->
                @if($correspondencia->historial && $correspondencia->historial->count() > 0)
                    <div class="lg:col-span-12">
                        <div class="bg-surface-lowest rounded-2xl border border-outline-variant shadow-sm p-6">
                            <h4 class="font-headline-sm text-lg font-bold text-on-surface mb-4 flex items-center gap-2">
                                <span class="material-symbols-outlined text-primary">history</span>
                                Detalles del Historial
                            </h4>
                            <div class="overflow-x-auto">
                                <table class="w-full text-left text-sm border-collapse">
                                    <thead class="bg-surface-variant/40 border-y border-outline-variant">
                                        <tr>
                                            <th class="px-4 py-3 font-semibold text-on-surface-variant uppercase tracking-wider text-xs">Fecha/Hora</th>
                                            <th class="px-4 py-3 font-semibold text-on-surface-variant uppercase tracking-wider text-xs">Estado</th>
                                            <th class="px-4 py-3 font-semibold text-on-surface-variant uppercase tracking-wider text-xs">Descripción</th>
                                            <th class="px-4 py-3 font-semibold text-on-surface-variant uppercase tracking-wider text-xs">Usuario</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-outline-variant/20 font-body-md text-body-md text-on-surface">
                                        @foreach($correspondencia->historial as $registro)
                                            <tr class="hover:bg-surface-variant/10 transition-colors">
                                                <td class="px-4 py-2.5 text-on-surface-variant/80 font-medium whitespace-nowrap">{{ \Carbon\Carbon::parse($registro->fecha ?? $registro->created_at)->format('d/m/Y H:i') }} hrs</td>
                                                <td class="px-4 py-2.5 font-semibold text-on-surface text-primary whitespace-nowrap">{{ $registro->estado }}</td>
                                                <td class="px-4 py-2.5 text-on-surface-variant/70">{{ str_replace('(HU-10) ', '', str_replace('(HU-10)', '', $registro->comentario ?? '-')) }}</td>
                                                <td class="px-4 py-2.5 text-on-surface-variant/80 whitespace-nowrap">{{ $registro->usuario->nombre ?? 'Sistema' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        @else
            <!-- Estado Vacío (Búsqueda sin resultados) -->
            <div class="bg-surface-lowest rounded-xl border border-outline-variant shadow-sm p-12 text-center">
                <span class="material-symbols-outlined text-6xl text-on-surface-variant/30 mb-4">search_off</span>
                <h4 class="font-headline-sm text-xl font-bold text-on-surface mb-2">Sin Resultados</h4>
                <p class="text-on-surface-variant/70 text-sm max-w-md mx-auto">
                    No se encontró ninguna correspondencia con los criterios especificados. Verifique el Número de Control o los filtros e intente nuevamente.
                </p>
            </div>
        @endif
    @else
        <!-- Tarjeta Limpia de Inicio -->
        <div class="bg-surface-lowest rounded-xl border border-outline-variant shadow-sm p-12 text-center">
            <span class="material-symbols-outlined text-6xl text-primary mb-4">manage_search</span>
            <h4 class="font-headline-sm text-xl font-bold text-on-surface mb-2">Sistema de Rastreo</h4>
            <p class="text-on-surface-variant/70 text-sm max-w-md mx-auto">
                Ingrese un número de ficha, control o utilice los filtros superiores para rastrear la línea de tiempo completa de un documento oficial en el sistema.
            </p>
        </div>
    @endif
</div>
@endsection
