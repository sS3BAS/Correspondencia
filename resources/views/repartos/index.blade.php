@extends('layouts.app')

@section('title', 'Bitácora Logística')

@section('content')
<div class="max-w-[1440px] mx-auto">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
        <div>
            <h1 class="font-headline-lg text-2xl md:text-3xl font-bold text-slate-900">Bitácora de Salidas y Reparto</h1>
            <p class="font-body-lg text-sm text-slate-600 mt-1">Gestión y seguimiento logístico de correspondencia saliente.</p>
        </div>
        <button class="bg-primary text-on-primary px-4 py-2 rounded-lg font-medium text-sm flex items-center gap-2 hover:bg-slate-800 transition-colors shadow-sm">
            <span class="material-symbols-outlined text-[18px]">description</span>
            Generar Reporte de Envío
        </button>
    </div>

    @if(session('success'))
        <div class="mb-4 px-4 py-3 bg-emerald-50 text-emerald-800 border border-emerald-200 rounded-lg text-sm">
            {{ session('success') }}
        </div>
    @endif
    @if($errors->any())
        <div class="mb-4 px-4 py-3 bg-red-50 text-red-800 border border-red-200 rounded-lg text-sm">
            <strong>Error:</strong> Por favor revise los campos del formulario.
        </div>
    @endif

    <!-- Filters -->
    <form action="{{ route('repartos.index') }}" method="GET" class="bg-white border border-slate-200 rounded-xl p-4 shadow-sm flex flex-col md:flex-row gap-4 items-end mb-6">
        <div class="flex-1 w-full space-y-1">
            <label class="text-xs font-medium text-slate-600">ID de Seguimiento / Control</label>
            <input type="text" name="numero_control" value="{{ request('numero_control') }}" class="w-full px-3 py-2 border border-slate-200 rounded-lg bg-white focus:border-secondary focus:ring-1 focus:ring-secondary/20 outline-none text-sm transition-colors" placeholder="Ej. UCC-SAL-...">
        </div>
        <div class="flex-1 w-full space-y-1">
            <label class="text-xs font-medium text-slate-600">Fecha Inicio</label>
            <input type="date" name="fecha_inicio" value="{{ request('fecha_inicio') }}" class="w-full px-3 py-2 border border-slate-200 rounded-lg bg-white focus:border-secondary focus:ring-1 focus:ring-secondary/20 outline-none text-sm transition-colors text-slate-700">
        </div>
        <div class="flex-1 w-full space-y-1">
            <label class="text-xs font-medium text-slate-600">Fecha Fin</label>
            <input type="date" name="fecha_fin" value="{{ request('fecha_fin') }}" class="w-full px-3 py-2 border border-slate-200 rounded-lg bg-white focus:border-secondary focus:ring-1 focus:ring-secondary/20 outline-none text-sm transition-colors text-slate-700">
        </div>
        <div class="flex-1 w-full space-y-1">
            <label class="text-xs font-medium text-slate-600">Estatus Logístico</label>
            <select name="estado" class="w-full px-3 py-2 border border-slate-200 rounded-lg bg-white focus:border-secondary focus:ring-1 focus:ring-secondary/20 outline-none text-sm transition-colors text-slate-700">
                <option value="">Todos los Estatus</option>
                <option value="pendiente" {{ request('estado') == 'pendiente' ? 'selected' : '' }}>Pendiente de Asignar</option>
                <option value="En preparación" {{ request('estado') == 'En preparación' ? 'selected' : '' }}>En Preparación</option>
                <option value="En tránsito" {{ request('estado') == 'En tránsito' ? 'selected' : '' }}>En Tránsito</option>
                <option value="Entregado" {{ request('estado') == 'Entregado' ? 'selected' : '' }}>Entregado</option>
                <option value="Devuelto" {{ request('estado') == 'Devuelto' ? 'selected' : '' }}>Devuelto</option>
                <option value="Incidencia" {{ request('estado') == 'Incidencia' ? 'selected' : '' }}>Incidencia</option>
            </select>
        </div>
        <button type="submit" class="bg-slate-100 text-slate-700 px-4 py-2 rounded-lg font-medium text-sm border border-slate-200 hover:bg-slate-200 transition-colors flex items-center justify-center gap-2 h-[38px] min-w-[120px]">
            <span class="material-symbols-outlined text-[18px]">filter_list</span>
            Filtrar
        </button>
        @if(request()->anyFilled(['numero_control', 'fecha_inicio', 'fecha_fin', 'estado']))
            <a href="{{ route('repartos.index') }}" class="bg-white text-slate-500 px-3 py-2 rounded-lg font-medium text-sm border border-slate-200 hover:text-red-600 hover:border-red-200 hover:bg-red-50 transition-colors flex items-center justify-center h-[38px]">
                <span class="material-symbols-outlined text-[18px]">clear</span>
            </a>
        @endif
    </form>

    <!-- Table -->
    <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden flex flex-col">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200">
                        <th class="px-6 py-3 font-semibold text-xs text-slate-500 uppercase tracking-wider">ID / Ficha</th>
                        <th class="px-6 py-3 font-semibold text-xs text-slate-500 uppercase tracking-wider">Destinatario</th>
                        <th class="px-6 py-3 font-semibold text-xs text-slate-500 uppercase tracking-wider">Mensajero/Servicio</th>
                        <th class="px-6 py-3 font-semibold text-xs text-slate-500 uppercase tracking-wider">Fechas Logística</th>
                        <th class="px-6 py-3 font-semibold text-xs text-slate-500 uppercase tracking-wider text-center">Estatus</th>
                        <th class="px-6 py-3 font-semibold text-xs text-slate-500 uppercase tracking-wider text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    @forelse($correspondencias as $item)
                        @php
                            $reparto = $item->reparto;
                        @endphp
                        <tr class="hover:bg-slate-50 transition-colors group">
                            <td class="px-6 py-3">
                                <span class="font-medium text-secondary block">{{ $item->numero_control ?? 'S/N' }}</span>
                                @if($item->numero_ficha)
                                    <span class="text-xs text-slate-400">Ref: {{ $item->numero_ficha }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-3">
                                <span class="block font-medium text-slate-800">{{ $item->nombre_destinatario }}</span>
                                <span class="text-xs text-slate-500">{{ $item->institucion }}</span>
                            </td>
                            <td class="px-6 py-3">
                                @if($reparto)
                                    <span class="block text-slate-700">{{ $reparto->tipo_servicio }}</span>
                                    <span class="text-xs text-slate-500">{{ $reparto->empresa }} {{ $reparto->mensajero ? '/ '.$reparto->mensajero : '' }}</span>
                                @else
                                    <span class="text-slate-400 italic text-xs">Sin asignar</span>
                                @endif
                            </td>
                            <td class="px-6 py-3 whitespace-nowrap">
                                <div class="text-xs text-slate-600">
                                    <span class="font-medium">Envío:</span> 
                                    {{ $reparto && $reparto->fecha_envio ? \Carbon\Carbon::parse($reparto->fecha_envio)->format('d/m/Y H:i') : 'Pendiente' }}
                                </div>
                                <div class="text-xs text-slate-600 mt-0.5">
                                    <span class="font-medium">Entrega:</span> 
                                    {{ $reparto && $reparto->fecha_entrega ? \Carbon\Carbon::parse($reparto->fecha_entrega)->format('d/m/Y') : 'Pendiente' }}
                                </div>
                            </td>
                            <td class="px-6 py-3 text-center">
                                @if(!$reparto)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full bg-slate-100 border border-slate-200 text-slate-600 text-[11px] font-medium gap-1">
                                        <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span> Pendiente
                                    </span>
                                @else
                                    @if($reparto->estado == 'Entregado')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full bg-emerald-50 border border-emerald-200 text-emerald-700 text-[11px] font-medium gap-1">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Entregado
                                        </span>
                                    @elseif($reparto->estado == 'En tránsito')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full bg-blue-50 border border-blue-200 text-blue-700 text-[11px] font-medium gap-1">
                                            <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span> En Tránsito
                                        </span>
                                    @elseif($reparto->estado == 'Devuelto')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full bg-red-50 border border-red-200 text-red-700 text-[11px] font-medium gap-1">
                                            <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> Devuelto
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full bg-amber-50 border border-amber-200 text-amber-700 text-[11px] font-medium gap-1">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> {{ $reparto->estado }}
                                        </span>
                                    @endif
                                @endif
                            </td>
                            <td class="px-6 py-3 text-right">
                                <div class="flex items-center justify-end gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <button onclick="openRepartoModal({{ $item->id }}, '{{ $item->numero_control }}', '{{ $reparto->tipo_servicio ?? '' }}', '{{ $reparto->empresa ?? '' }}', '{{ $reparto->mensajero ?? '' }}', '{{ $reparto->estado ?? 'En preparación' }}', '{{ $reparto->observaciones ?? '' }}')" class="p-1.5 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded transition-colors" title="Actualizar Logística">
                                        <span class="material-symbols-outlined text-[20px]">edit_location_alt</span>
                                    </button>
                                    @if($reparto && $reparto->estado == 'Entregado')
                                        <a href="{{ route('acuses.create', $item->id) }}" class="p-1.5 text-slate-400 hover:text-emerald-600 hover:bg-emerald-50 rounded transition-colors" title="Registrar Acuse (HU-10)">
                                            <span class="material-symbols-outlined text-[20px]">receipt_long</span>
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-slate-500">
                                <div class="flex flex-col items-center justify-center">
                                    <span class="material-symbols-outlined text-4xl mb-2 text-slate-300">local_shipping</span>
                                    <p class="font-medium text-slate-600">No hay correspondencia saliente registrada</p>
                                    <p class="text-xs mt-1">Intente ajustar los filtros de búsqueda o registre una nueva salida.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($correspondencias->hasPages())
            <div class="border-t border-slate-200 bg-slate-50 px-6 py-3">
                {{ $correspondencias->links() }}
            </div>
        @elseif($correspondencias->isNotEmpty())
            <div class="border-t border-slate-200 bg-slate-50 px-6 py-3 flex items-center justify-between text-xs text-slate-500">
                Mostrando todos los {{ $correspondencias->count() }} registros
            </div>
        @endif
    </div>
</div>

<!-- Modal Formulario Actualizar Reparto -->
<div id="repartoModal" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-slate-900/50 backdrop-blur-sm transition-opacity">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-lg mx-4 overflow-hidden flex flex-col max-h-[90vh]">
        <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50">
            <h3 class="font-semibold text-lg text-slate-800 flex items-center gap-2">
                <span class="material-symbols-outlined text-secondary">local_shipping</span>
                Asignar / Actualizar Reparto
            </h3>
            <button onclick="closeRepartoModal()" class="text-slate-400 hover:text-slate-600 transition-colors">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        
        <div class="p-6 overflow-y-auto">
            <form id="repartoForm" action="{{ route('repartos.store') }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="correspondencia_id" id="modal_correspondencia_id">
                
                <div>
                    <label class="block text-xs font-medium text-slate-600 mb-1">ID de Correspondencia</label>
                    <input type="text" id="modal_numero_control" class="w-full px-3 py-2 bg-slate-100 border border-slate-200 rounded-md text-sm text-slate-500 cursor-not-allowed" disabled>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-slate-600 mb-1">Tipo de Servicio <span class="text-red-500">*</span></label>
                        <select name="tipo_servicio" id="modal_tipo_servicio" class="w-full px-3 py-2 bg-white border border-slate-300 rounded-md text-sm focus:border-secondary focus:ring-1 focus:ring-secondary outline-none" required>
                            <option value="Mensajero interno">Mensajero Interno</option>
                            <option value="Mensajería especializada">Mensajería Especializada</option>
                            <option value="Servicio postal">Servicio Postal</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-slate-600 mb-1">Estatus <span class="text-red-500">*</span></label>
                        <select name="estado" id="modal_estado" class="w-full px-3 py-2 bg-white border border-slate-300 rounded-md text-sm focus:border-secondary focus:ring-1 focus:ring-secondary outline-none" required>
                            <option value="En preparación">En Preparación</option>
                            <option value="En tránsito">En Tránsito</option>
                            <option value="Entregado">Entregado</option>
                            <option value="Devuelto">Devuelto</option>
                            <option value="Incidencia">Incidencia</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-slate-600 mb-1">Empresa</label>
                        <input type="text" name="empresa" id="modal_empresa" maxlength="80" class="w-full px-3 py-2 bg-white border border-slate-300 rounded-md text-sm focus:border-secondary focus:ring-1 focus:ring-secondary outline-none" placeholder="Ej. DHL">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-slate-600 mb-1">Nombre del Mensajero</label>
                        <input type="text" name="mensajero" id="modal_mensajero" maxlength="50" class="w-full px-3 py-2 bg-white border border-slate-300 rounded-md text-sm focus:border-secondary focus:ring-1 focus:ring-secondary outline-none" placeholder="Ej. Juan Pérez">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-slate-600 mb-1">Fecha/Hora Envío</label>
                        <input type="datetime-local" name="fecha_envio" id="modal_fecha_envio" class="w-full px-3 py-2 bg-white border border-slate-300 rounded-md text-sm focus:border-secondary focus:ring-1 focus:ring-secondary outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-slate-600 mb-1">Fecha Entrega</label>
                        <input type="date" name="fecha_entrega" id="modal_fecha_entrega" class="w-full px-3 py-2 bg-white border border-slate-300 rounded-md text-sm focus:border-secondary focus:ring-1 focus:ring-secondary outline-none">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-medium text-slate-600 mb-1">Observaciones</label>
                    <textarea name="observaciones" id="modal_observaciones" rows="2" class="w-full px-3 py-2 bg-white border border-slate-300 rounded-md text-sm focus:border-secondary focus:ring-1 focus:ring-secondary outline-none resize-none" placeholder="Incidencias o detalles del reparto..."></textarea>
                </div>
                
                <div class="pt-4 flex justify-end gap-3 border-t border-slate-100">
                    <button type="button" onclick="closeRepartoModal()" class="px-4 py-2 text-slate-600 bg-white border border-slate-300 rounded text-sm font-medium hover:bg-slate-50 transition-colors">
                        Cancelar
                    </button>
                    <button type="submit" class="px-4 py-2 text-white bg-primary rounded text-sm font-medium hover:bg-slate-800 transition-colors">
                        Guardar Logística
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openRepartoModal(id, control, tipo, empresa, mensajero, estado, observaciones) {
        document.getElementById('repartoModal').classList.remove('hidden');
        document.getElementById('modal_correspondencia_id').value = id;
        document.getElementById('modal_numero_control').value = control;
        document.getElementById('modal_tipo_servicio').value = tipo || 'Mensajero interno';
        document.getElementById('modal_empresa').value = empresa || '';
        document.getElementById('modal_mensajero').value = mensajero || '';
        document.getElementById('modal_estado').value = estado || 'En preparación';
        document.getElementById('modal_observaciones').value = observaciones || '';
    }

    function closeRepartoModal() {
        document.getElementById('repartoModal').classList.add('hidden');
    }
</script>
@endsection
