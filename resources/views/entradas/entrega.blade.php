@extends('layouts.app')

@section('title', 'Registrar Entrega Interna')

@section('content')
<div class="max-w-[1440px] mx-auto space-y-6">
    <!-- Page Header -->
    <div class="mb-6 flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
        <div>
            <h2 class="font-headline-lg-mobile md:font-headline-lg text-2xl md:text-3xl font-bold text-slate-900 mb-1">Registrar Entrega de Correspondencia</h2>
            <p class="font-body-md text-sm text-slate-600">Confirme los detalles y registre la entrega formal al área destinataria interna.</p>
        </div>
        <a href="{{ route('entradas.index') }}" class="flex items-center gap-2 px-4 py-2 bg-white border border-slate-200 text-slate-700 rounded-lg hover:bg-slate-50 transition-colors font-medium text-sm shadow-sm">
            <span class="material-symbols-outlined text-[18px]">arrow_back</span>
            Volver a Entradas
        </a>
    </div>

    @if($errors->any())
        <div class="mb-6 px-4 py-3 bg-red-50 text-red-800 border border-red-200 rounded-lg text-sm">
            <strong>Error:</strong> Por favor revise los campos del formulario.
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        <!-- Resumen Card -->
        <div class="lg:col-span-12 bg-white rounded-xl border border-slate-200 shadow-sm p-6">
            <div class="flex items-center gap-3 mb-6 pb-4 border-b border-slate-100">
                <div class="w-8 h-8 rounded-full bg-blue-50 flex items-center justify-center text-secondary">
                    <span class="material-symbols-outlined text-[20px]" style="font-variation-settings: 'FILL' 1;">description</span>
                </div>
                <h3 class="font-headline-sm text-lg font-semibold text-slate-800">Resumen de Correspondencia</h3>
                <span class="ml-auto px-2 py-1 bg-amber-50 border border-amber-200 rounded-md font-medium text-xs text-amber-700 flex items-center gap-1">
                    <span class="material-symbols-outlined text-[14px]">pending_actions</span>
                    Pendiente de Entrega
                </span>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div>
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Número de Ficha</p>
                    <p class="font-body-lg text-base text-slate-900 font-bold">{{ $entrada->numero_ficha ?? 'S/N' }}</p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Remitente</p>
                    <p class="font-body-lg text-base text-slate-800">{{ $entrada->nombre_remitente }}</p>
                </div>
                <div class="lg:col-span-2">
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Asunto</p>
                    <p class="font-body-lg text-base text-slate-800 truncate" title="{{ $entrada->asunto }}">{{ $entrada->asunto }}</p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Área Destino Asignada</p>
                    <div class="flex items-center gap-2 mt-1">
                        <span class="w-2 h-2 rounded-full bg-secondary"></span>
                        <p class="font-body-lg text-base text-slate-800 font-medium">{{ $entrada->area->nombre ?? 'Sin Asignar' }}</p>
                    </div>
                </div>
                <div>
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Fecha de Ingreso</p>
                    <p class="font-body-lg text-base text-slate-800">{{ \Carbon\Carbon::parse($entrada->fecha_registro)->format('d M Y, H:i') }}</p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Prioridad</p>
                    @if($entrada->prioridad == 'urgente' || $entrada->prioridad == 'con riesgos')
                        <span class="inline-flex items-center gap-1 px-2 py-1 bg-red-50 border border-red-200 text-red-700 rounded-md text-xs font-medium">
                            <span class="material-symbols-outlined text-[14px]">error</span> {{ ucfirst($entrada->prioridad) }}
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1 px-2 py-1 bg-slate-100 border border-slate-200 text-slate-700 rounded-md text-xs font-medium">
                            {{ ucfirst($entrada->prioridad) }}
                        </span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Delivery Form Card -->
        <div class="lg:col-span-12 bg-white rounded-xl border border-slate-200 shadow-sm p-6 relative overflow-hidden">
            <!-- Decorative background element for premium feel -->
            <div class="absolute top-0 right-0 w-64 h-64 bg-secondary/5 rounded-full blur-3xl -mr-20 -mt-20 pointer-events-none"></div>
            
            <div class="flex items-center gap-3 mb-6 pb-4 border-b border-slate-100 relative z-10">
                <div class="w-8 h-8 rounded-full bg-secondary/10 flex items-center justify-center text-secondary">
                    <span class="material-symbols-outlined text-[20px]" style="font-variation-settings: 'FILL' 1;">how_to_reg</span>
                </div>
                <h3 class="font-headline-sm text-lg font-semibold text-slate-800">Información de Recepción Interna</h3>
            </div>
            
            <form action="{{ route('entradas.entrega.store') }}" method="POST" class="space-y-6 relative z-10">
                @csrf
                <input type="hidden" name="correspondencia_id" value="{{ $entrada->id }}">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Área que recibe -->
                    <div class="flex flex-col">
                        <label class="text-xs font-medium text-slate-600 mb-2" for="area-recibe">Área que recibe <span class="text-red-500">*</span></label>
                        <select name="area_recibe" id="area-recibe" class="w-full bg-white border border-slate-200 rounded-lg px-4 py-3 text-sm text-slate-800 focus:outline-none focus:border-secondary focus:ring-1 focus:ring-secondary transition-all">
                            <option value="">Seleccione el área</option>
                            @foreach($areas as $area)
                                <option value="{{ $area->nombre }}" {{ old('area_recibe', $entrada->area->nombre ?? '') == $area->nombre ? 'selected' : '' }}>
                                    {{ $area->nombre }}
                                </option>
                            @endforeach
                        </select>
                        @error('area_recibe') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                    
                    <!-- Nombre de quien recibe -->
                    <div class="flex flex-col">
                        <label class="text-xs font-medium text-slate-600 mb-2" for="nombre-recibe">Nombre completo de quien recibe <span class="text-red-500">*</span></label>
                        <input type="text" name="usuario_recibe" id="nombre-recibe" value="{{ old('usuario_recibe') }}" class="w-full bg-white border border-slate-200 rounded-lg px-4 py-3 text-sm text-slate-800 focus:outline-none focus:border-secondary focus:ring-1 focus:ring-secondary transition-all" placeholder="Ej. Juan Pérez">
                        @error('usuario_recibe') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                    
                    <!-- Fecha y Hora -->
                    <div class="flex flex-col md:col-span-2 lg:col-span-1">
                        <label class="text-xs font-medium text-slate-600 mb-2" for="fecha-hora">Fecha y Hora de entrega <span class="text-red-500">*</span></label>
                        <input type="datetime-local" name="fecha_entrega" id="fecha-hora" value="{{ old('fecha_entrega') }}" class="w-full bg-white border border-slate-200 rounded-lg px-4 py-3 text-sm text-slate-800 focus:outline-none focus:border-secondary focus:ring-1 focus:ring-secondary transition-all">
                        @error('fecha_entrega') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                    
                    <!-- Observaciones -->
                    <div class="flex flex-col md:col-span-2">
                        <label class="text-xs font-medium text-slate-600 mb-2" for="observaciones">Observaciones (Opcional)</label>
                        <textarea name="observaciones" id="observaciones" rows="3" class="w-full bg-white border border-slate-200 rounded-lg px-4 py-3 text-sm text-slate-800 focus:outline-none focus:border-secondary focus:ring-1 focus:ring-secondary transition-all resize-y" placeholder="Añada cualquier comentario o incidencia durante la entrega...">{{ old('observaciones') }}</textarea>
                        @error('observaciones') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>
                
                <!-- Actions -->
                <div class="pt-6 mt-6 border-t border-slate-100 flex justify-end gap-4">
                    <a href="{{ route('entradas.index') }}" class="px-6 py-3 bg-white border border-slate-200 text-slate-700 text-sm font-medium rounded-lg hover:bg-slate-50 transition-colors">
                        Cancelar
                    </a>
                    <button type="submit" class="flex items-center gap-2 px-8 py-3 bg-secondary text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-all shadow-sm active:scale-[0.98]">
                        <span class="material-symbols-outlined text-[18px]">done_all</span>
                        Confirmar Entrega y Marcar como Entregada
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Set current datetime for the input if not already set by old()
    document.addEventListener('DOMContentLoaded', () => {
        const datetimeInput = document.getElementById('fecha-hora');
        if (!datetimeInput.value) {
            const now = new Date();
            now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
            datetimeInput.value = now.toISOString().slice(0,16);
        }
    });
</script>
@endsection
