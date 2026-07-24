@extends('layouts.app')

@section('title', 'Bitácora Logística')

@section('content')
<div class="max-w-[1440px] mx-auto space-y-6">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <div>
            <h1 class="font-headline-lg text-2xl md:text-3xl font-bold text-on-surface flex items-center gap-2">
                <span class="material-symbols-outlined text-primary text-[32px]">local_shipping</span>
                Bitácora de Salidas y Reparto
            </h1>
            <p class="font-body-md text-sm text-on-surface-variant mt-1">Gestión y seguimiento logístico de correspondencia saliente.</p>
        </div>
    </div>

    @if(session('success'))
    <div id="successAlert" class="p-4 mb-4 text-sm text-emerald-800 bg-emerald-50 rounded-lg border border-emerald-200/50 flex items-center transition-all duration-500 ease-in-out" role="alert">
        <span class="material-symbols-outlined mr-2 text-emerald-500">check_circle</span>
        <span class="font-medium">{{ session('success') }}</span>
    </div>
    @endif
    
    @if($errors->any())
    <div class="p-4 mb-4 text-sm text-rose-700 bg-rose-50 border border-rose-200/50 rounded-lg flex items-center gap-2" role="alert">
        <span class="material-symbols-outlined text-rose-500 text-[20px]">error</span>
        <span class="font-medium">{{ $errors->first() }}</span>
    </div>
    @endif

    <!-- Filters Section -->
    <div class="bg-surface-lowest border border-outline-variant rounded-xl shadow-sm p-4 mb-6">
        <form action="{{ route('repartos.index') }}" method="GET" class="flex flex-wrap items-center gap-4">
            <div class="flex-1 min-w-[200px] relative flex items-center">
                <span class="material-symbols-outlined absolute left-3 text-on-surface-variant/60 text-[20px] pointer-events-none select-none">search</span>
                <input type="text" name="numero_control" value="{{ request('numero_control') }}" class="w-full pl-10 pr-4 py-2.5 bg-surface-variant/10 border border-outline-variant rounded-lg text-sm text-on-surface placeholder:text-on-surface-variant/40 focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 transition-all" placeholder="Buscar por ID Control...">
            </div>
            
            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-2">
                <label class="text-xs font-semibold text-on-surface-variant uppercase tracking-wider">Inicio:</label>
                <input type="date" name="fecha_inicio" value="{{ request('fecha_inicio') }}" class="px-3 py-2 bg-surface-variant/10 border border-outline-variant rounded-lg text-sm text-on-surface focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 transition-all cursor-pointer">
            </div>

            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-2">
                <label class="text-xs font-semibold text-on-surface-variant uppercase tracking-wider">Fin:</label>
                <input type="date" name="fecha_fin" value="{{ request('fecha_fin') }}" class="px-3 py-2 bg-surface-variant/10 border border-outline-variant rounded-lg text-sm text-on-surface focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 transition-all cursor-pointer">
            </div>

            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-2">
                <label class="text-xs font-semibold text-on-surface-variant uppercase tracking-wider">Estatus:</label>
                <select name="estado" class="px-3 py-2 bg-surface-variant/10 border border-outline-variant rounded-lg text-sm text-on-surface focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 transition-all cursor-pointer">
                    <option value="">Todos los Estatus</option>
                    <option value="pendiente" {{ request('estado') == 'pendiente' ? 'selected' : '' }}>Pendiente de Asignar</option>
                    <option value="En preparación" {{ request('estado') == 'En preparación' ? 'selected' : '' }}>En Preparación</option>
                    <option value="En tránsito" {{ request('estado') == 'En tránsito' ? 'selected' : '' }}>En Tránsito</option>
                    <option value="Entregado" {{ request('estado') == 'Entregado' ? 'selected' : '' }}>Entregado</option>
                    <option value="Devuelto" {{ request('estado') == 'Devuelto' ? 'selected' : '' }}>Devuelto</option>
                    <option value="Incidencia" {{ request('estado') == 'Incidencia' ? 'selected' : '' }}>Incidencia</option>
                </select>
            </div>

            <div class="flex items-center gap-2 ml-auto">
                <button type="submit" class="inline-flex items-center gap-2 bg-primary hover:bg-primary/95 text-on-primary font-semibold text-sm px-4 py-2 rounded-lg shadow-sm transition-all cursor-pointer focus:outline-none">
                    <span class="material-symbols-outlined text-[18px]">filter_alt</span> Filtrar
                </button>
                @if(request()->anyFilled(['numero_control', 'fecha_inicio', 'fecha_fin', 'estado']))
                    <a href="{{ route('repartos.index') }}" class="inline-flex items-center justify-center p-2 text-on-surface-variant/60 hover:text-error hover:bg-error/10 rounded-lg transition-colors cursor-pointer" title="Limpiar Filtros">
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
                        <th class="px-6 py-4 font-label-caps text-label-caps text-on-surface-variant uppercase tracking-wider font-semibold">ID / Ficha</th>
                        <th class="px-6 py-4 font-label-caps text-label-caps text-on-surface-variant uppercase tracking-wider font-semibold">Destinatario</th>
                        <th class="px-6 py-4 font-label-caps text-label-caps text-on-surface-variant uppercase tracking-wider font-semibold">Mensajero/Servicio</th>
                        <th class="px-6 py-4 font-label-caps text-label-caps text-on-surface-variant uppercase tracking-wider font-semibold">Fechas Logística</th>
                        <th class="px-6 py-4 font-label-caps text-label-caps text-on-surface-variant uppercase tracking-wider font-semibold text-center">Estatus</th>
                        <th class="px-6 py-4 font-label-caps text-label-caps text-on-surface-variant uppercase tracking-wider font-semibold text-center">Acción</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant/30 font-body-md text-body-md text-on-surface">
                    @forelse($correspondencias as $item)
                        @php
                            $reparto = $item->reparto;
                        @endphp
                        <tr class="hover:bg-surface-variant/15 transition-colors group">
                            <td class="px-6 py-4">
                                <span class="inline-flex font-mono bg-primary/5 text-primary border border-primary/10 px-2.5 py-1 rounded-lg text-xs font-semibold">
                                    {{ $item->numero_control ?? 'S/N' }}
                                </span>
                                @if($item->numero_ficha)
                                    <span class="block text-xs text-on-surface-variant/60 mt-1">Ref: {{ $item->numero_ficha }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <span class="block font-semibold text-on-surface group-hover:text-primary transition-colors">{{ $item->nombre_destinatario }}</span>
                                <span class="text-xs text-on-surface-variant/60">{{ $item->institucion }}</span>
                            </td>
                            <td class="px-6 py-4 text-on-surface-variant/80">
                                @if($reparto)
                                    <span class="block text-on-surface font-medium">{{ $reparto->tipo_servicio }}</span>
                                    <span class="text-xs text-on-surface-variant/60">{{ $reparto->empresa }} {{ $reparto->mensajero ? '/ '.$reparto->mensajero : '' }}</span>
                                @else
                                    <span class="text-on-surface-variant/40 italic text-xs">Sin asignar</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-on-surface-variant/80">
                                <div class="text-xs">
                                    <span class="font-bold text-on-surface-variant">Envío:</span> 
                                    {{ $reparto && $reparto->fecha_envio ? \Carbon\Carbon::parse($reparto->fecha_envio)->format('d/m/Y H:i') : 'Pendiente' }}
                                </div>
                                <div class="text-xs mt-1">
                                    <span class="font-bold text-on-surface-variant">Entrega:</span> 
                                    {{ $reparto && $reparto->fecha_entrega ? \Carbon\Carbon::parse($reparto->fecha_entrega)->format('d/m/Y') : 'Pendiente' }}
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($item->estado == 'registrada')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full bg-slate-50 text-slate-600 text-xs font-semibold border border-slate-200" title="Pendiente de entregar física de UCC">
                                        <span class="w-1.5 h-1.5 rounded-full bg-slate-400 mr-1.5"></span> Por recibir en RM
                                    </span>
                                @elseif(!$reparto)
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full bg-amber-50 text-amber-700 text-xs font-bold border border-amber-200/50">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500 mr-1.5"></span> Pendiente Envío
                                    </span>
                                @else
                                    @if($reparto->estado == 'Entregado')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-700 text-xs font-bold border border-emerald-200/50">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1.5"></span> Entregado
                                        </span>
                                    @elseif($reparto->estado == 'En tránsito')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full bg-blue-50 text-blue-700 text-xs font-bold border border-blue-200/50">
                                            <span class="w-1.5 h-1.5 rounded-full bg-blue-500 mr-1.5"></span> En Tránsito
                                        </span>
                                    @elseif($reparto->estado == 'Devuelto')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full bg-rose-50 text-rose-700 text-xs font-bold border border-rose-200/50">
                                            <span class="w-1.5 h-1.5 rounded-full bg-rose-500 mr-1.5"></span> Devuelto
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full bg-amber-50 text-amber-700 text-xs font-bold border border-amber-200/50">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500 mr-1.5"></span> {{ $reparto->estado }}
                                        </span>
                                    @endif
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center whitespace-nowrap">
                                <div class="flex items-center justify-center gap-1">
                                    @if($item->estado == 'registrada')
                                        <button disabled class="p-2 text-on-surface-variant/20 cursor-not-allowed" title="Esperando entrega física de UCC">
                                            <span class="material-symbols-outlined text-[20px] block">edit_location_alt</span>
                                        </button>
                                    @elseif($item->estado == 'entregada' || ($reparto && $reparto->estado == 'Entregado'))
                                        <a href="{{ route('seguimiento.index', ['numero_control' => $item->numero_control]) }}" class="p-2 text-on-surface-variant hover:text-primary hover:bg-surface-variant/60 rounded-full transition-all cursor-pointer" title="Ver detalles y rastreo">
                                            <span class="material-symbols-outlined text-[20px] block">visibility</span>
                                        </a>
                                    @else
                                        @if(auth()->user()->role_id === 3)
                                            @php
                                                $fechaEnvioFormat = ($reparto && $reparto->fecha_envio) ? \Carbon\Carbon::parse($reparto->fecha_envio)->format('Y-m-d\TH:i') : '';
                                                $fechaEntregaFormat = ($reparto && $reparto->fecha_entrega) ? \Carbon\Carbon::parse($reparto->fecha_entrega)->format('Y-m-d') : '';
                                            @endphp
                                            <button onclick="openRepartoModal({{ $item->id }}, '{{ $item->numero_control }}', '{{ addslashes($reparto->tipo_servicio ?? '') }}', '{{ addslashes($reparto->empresa ?? '') }}', '{{ addslashes($reparto->mensajero ?? '') }}', '{{ addslashes($reparto->estado ?? 'En preparación') }}', '{{ addslashes(str_replace(array("\r", "\n"), ' ', $reparto->observaciones ?? '')) }}', '{{ $fechaEnvioFormat }}', '{{ $fechaEntregaFormat }}')" class="p-2 text-on-surface-variant hover:text-primary hover:bg-surface-variant/60 rounded-full transition-all cursor-pointer focus:outline-none" title="Asignar / Actualizar Logística">
                                                <span class="material-symbols-outlined text-[20px] block">edit_location_alt</span>
                                            </button>
                                        @else
                                            <a href="{{ route('seguimiento.index', ['numero_control' => $item->numero_control]) }}" class="p-2 text-on-surface-variant hover:text-primary hover:bg-surface-variant/60 rounded-full transition-all cursor-pointer" title="Ver detalles y rastreo">
                                                <span class="material-symbols-outlined text-[20px] block">visibility</span>
                                            </a>
                                        @endif

                                        @if($reparto && $reparto->estado == 'En tránsito' && auth()->user()->role_id === 4)
                                            <a href="{{ route('acuses.create', $item->id) }}" class="p-2 text-on-surface-variant hover:text-primary hover:bg-surface-variant/60 rounded-full transition-all cursor-pointer" title="Registrar Acuse">
                                                <span class="material-symbols-outlined text-[20px] block">receipt_long</span>
                                            </a>
                                        @endif
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-on-surface-variant/60">
                                <div class="flex flex-col items-center justify-center gap-2">
                                    <span class="material-symbols-outlined text-4xl text-on-surface-variant/30">local_shipping</span>
                                    <p class="font-semibold text-on-surface-variant">No hay correspondencia saliente registrada</p>
                                    <p class="text-xs">Intente ajustar los filtros de búsqueda o registre una nueva salida.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
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

<!-- Modal Formulario Actualizar Reparto -->
<div id="repartoModal" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-[#46959f]/50 backdrop-blur-sm transition-opacity">
    <div class="bg-surface-lowest rounded-2xl border border-outline-variant shadow-xl w-full max-w-lg mx-4 overflow-hidden flex flex-col max-h-[90vh]">
        <div class="px-6 py-4 border-b border-outline-variant/30 flex justify-between items-center bg-primary/10">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-primary">local_shipping</span>
                <h3 class="font-bold text-lg text-on-surface">Asignar / Actualizar Reparto</h3>
            </div>
            <button onclick="closeRepartoModal()" class="text-on-surface-variant/60 hover:text-on-surface hover:bg-surface-variant/60 p-1.5 rounded-full transition-all cursor-pointer focus:outline-none">
                <span class="material-symbols-outlined text-[20px] block">close</span>
            </button>
        </div>
        
        <div class="p-6 overflow-y-auto space-y-4">
            <form id="repartoForm" action="{{ route('repartos.store') }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="correspondencia_id" id="modal_correspondencia_id">
                
                <div class="flex flex-col gap-1.5">
                    <div class="flex items-center justify-between">
                        <label class="text-xs font-semibold text-on-surface-variant uppercase tracking-wider">Número de Control</label>
                        <span class="text-xs font-semibold text-rose-500">* datos obligatorios</span>
                    </div>
                    <input type="text" id="modal_numero_control" class="w-full px-4 py-2.5 bg-primary/5 border border-outline-variant rounded-lg text-sm text-primary font-mono font-semibold outline-none cursor-not-allowed select-none" disabled>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="flex flex-col gap-1.5">
                        <label class="text-xs font-semibold text-on-surface-variant uppercase tracking-wider">Tipo de Servicio <span class="text-rose-500">*</span></label>
                        <select name="tipo_servicio" id="modal_tipo_servicio" class="w-full bg-surface-lowest border border-outline-variant rounded-lg px-3 py-2 text-sm text-on-surface focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 transition-all cursor-pointer" required>
                            <option value="Mensajero interno">Mensajero Interno</option>
                            <option value="Mensajería especializada">Mensajería Especializada</option>
                        </select>
                    </div>
                    <div class="flex flex-col gap-1.5">
                        <label class="text-xs font-semibold text-on-surface-variant uppercase tracking-wider">Estatus <span class="text-rose-500">*</span></label>
                        <select name="estado" id="modal_estado" class="w-full bg-surface-lowest border border-outline-variant rounded-lg px-3 py-2 text-sm text-on-surface focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 transition-all cursor-pointer" required>
                            <option value="En preparación">En Preparación</option>
                            <option value="En tránsito">En Tránsito</option>
                            <option value="Entregado">Entregado</option>
                            <option value="Devuelto">Devuelto</option>
                            <option value="Incidencia">Incidencia</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="flex flex-col gap-1.5">
                        <label class="text-xs font-semibold text-on-surface-variant uppercase tracking-wider">Empresa / Paquetería</label>
                        <input type="text" name="empresa" id="modal_empresa" maxlength="80" class="w-full bg-surface-lowest border border-outline-variant rounded-lg px-4 py-2 text-sm text-on-surface placeholder:text-on-surface-variant/40 focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 transition-all" placeholder="Ej. DHL, FedEx">
                    </div>
                    <div class="flex flex-col gap-1.5">
                        <label class="text-xs font-semibold text-on-surface-variant uppercase tracking-wider">Nombre del Mensajero</label>
                        <select name="mensajero" id="modal_mensajero" class="w-full bg-surface-lowest border border-outline-variant rounded-lg px-3 py-2 text-sm text-on-surface focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 transition-all cursor-pointer">
                            <option value="">Seleccione mensajero...</option>
                            @foreach($mensajeros ?? [] as $m)
                                @php
                                    $nombreCompleto = trim($m->nombre . ' ' . $m->apellido_paterno . ' ' . $m->apellido_materno);
                                @endphp
                                <option value="{{ $nombreCompleto }}">{{ $nombreCompleto }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="flex flex-col gap-1.5">
                        <label class="text-xs font-semibold text-on-surface-variant uppercase tracking-wider">Fecha/Hora de Envío <span class="text-rose-500">*</span></label>
                        <input type="datetime-local" name="fecha_envio" id="modal_fecha_envio" class="w-full bg-surface-lowest border border-outline-variant rounded-lg px-3 py-2 text-sm text-on-surface focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 transition-all cursor-pointer" required>
                    </div>
                    <div class="flex flex-col gap-1.5">
                        <label class="text-xs font-semibold text-on-surface-variant uppercase tracking-wider">Fecha de Entrega <span class="text-rose-500">*</span></label>
                        <input type="date" name="fecha_entrega" id="modal_fecha_entrega" class="w-full bg-surface-lowest border border-outline-variant rounded-lg px-3 py-2 text-sm text-on-surface focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 transition-all cursor-pointer" required>
                    </div>
                </div>

                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-semibold text-on-surface-variant uppercase tracking-wider">Observaciones</label>
                    <textarea name="observaciones" id="modal_observaciones" rows="2" class="w-full bg-surface-lowest border border-outline-variant rounded-lg px-4 py-2 text-sm text-on-surface placeholder:text-on-surface-variant/40 focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 transition-all resize-none" placeholder="Incidencias o detalles del reparto..."></textarea>
                </div>
                
                <div class="pt-4 flex justify-end gap-3 border-t border-outline-variant/30">
                    <button type="button" onclick="closeRepartoModal()" class="bg-rose-500/10 hover:bg-rose-500/20 text-rose-600 border border-rose-200/40 px-5 py-2.5 text-sm font-semibold rounded-lg transition-colors cursor-pointer focus:outline-none">
                        Cancelar
                    </button>
                    <button type="submit" class="bg-primary hover:bg-primary/95 text-on-primary px-6 py-2.5 text-sm font-semibold rounded-lg transition-all shadow-sm hover:shadow active:scale-[0.98] cursor-pointer focus:outline-none">
                        Guardar Logística
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openRepartoModal(id, control, tipo, empresa, mensajero, estado, observaciones, fechaEnvio, fechaEntrega) {
        document.getElementById('repartoModal').classList.remove('hidden');
        document.getElementById('modal_correspondencia_id').value = id;
        document.getElementById('modal_numero_control').value = control;
        document.getElementById('modal_tipo_servicio').value = tipo || 'Mensajero interno';
        document.getElementById('modal_empresa').value = empresa || '';
        document.getElementById('modal_mensajero').value = mensajero || '';
        document.getElementById('modal_estado').value = estado || 'En preparación';
        document.getElementById('modal_observaciones').value = observaciones || '';
        document.getElementById('modal_fecha_envio').value = fechaEnvio || '';
        document.getElementById('modal_fecha_entrega').value = fechaEntrega || '';
    }

    function closeRepartoModal() {
        document.getElementById('repartoModal').classList.add('hidden');
    }

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
