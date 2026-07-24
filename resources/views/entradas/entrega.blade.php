@extends('layouts.app')

@section('title', 'Registrar Entrega Interna')

@section('content')
<div class="max-w-[1440px] mx-auto space-y-6">
    <!-- Page Header -->
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="font-headline-lg text-2xl md:text-3xl font-bold text-on-surface mb-1 flex items-center gap-2">
                <span class="material-symbols-outlined text-primary text-[32px]">local_shipping</span>
                Registrar Entrega de Correspondencia
            </h2>
            <p class="font-body-md text-sm text-on-surface-variant">Confirme los detalles y registre la entrega formal al área destinataria interna.</p>
        </div>
        <div>
            <a href="{{ route('entradas.index') }}" class="inline-flex items-center gap-2 bg-surface-variant/20 hover:bg-surface-variant/40 border border-outline-variant text-on-surface font-semibold text-sm px-4 py-2.5 rounded-lg shadow-sm transition-all cursor-pointer">
                <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                Volver a Entradas
            </a>
        </div>
    </div>

    @if($errors->any())
        <div class="mb-6 px-4 py-3 bg-rose-50 text-rose-800 border border-rose-200/50 rounded-lg text-sm flex items-center gap-2">
            <span class="material-symbols-outlined text-rose-500 text-[20px]">error</span>
            <strong>Error:</strong> Por favor revise los campos del formulario.
        </div>
    @endif

    <div class="grid grid-cols-1 gap-6">
        <!-- Resumen Card -->
        <div class="bg-surface-lowest rounded-2xl border border-outline-variant shadow-sm p-6 md:p-8 transition-shadow hover:shadow-md">
            <div class="flex items-center gap-3 mb-6 pb-4 border-b border-outline-variant/30">
                <div class="w-10 h-10 rounded-xl bg-primary/10 flex items-center justify-center text-primary">
                    <span class="material-symbols-outlined text-[22px]">description</span>
                </div>
                <h3 class="font-headline-sm text-lg font-bold text-on-surface">Resumen de Correspondencia</h3>
                <span class="ml-auto px-2.5 py-1 bg-amber-50 border border-amber-200/50 rounded-lg font-semibold text-xs text-amber-700 flex items-center gap-1">
                    <span class="material-symbols-outlined text-[14px]">pending_actions</span>
                    Pendiente de Entrega
                </span>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <div>
                    <p class="text-xs font-semibold text-on-surface-variant uppercase tracking-wider mb-1">Número de Control</p>
                    <p class="font-body-lg text-base text-primary font-mono font-bold bg-primary/5 border border-primary/10 px-2.5 py-1 rounded-lg w-max mt-1">
                        {{ $entrada->numero_control ?? 'S/N' }}
                    </p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-on-surface-variant uppercase tracking-wider mb-1">Remitente</p>
                    <p class="font-body-lg text-base text-on-surface font-medium mt-1">{{ $entrada->nombre_remitente }}</p>
                    <p class="text-xs text-on-surface-variant">{{ $entrada->institucion }}</p>
                </div>
                <div class="lg:col-span-2">
                    <p class="text-xs font-semibold text-on-surface-variant uppercase tracking-wider mb-1">Asunto</p>
                    <p class="font-body-lg text-base text-on-surface font-medium mt-1 truncate" title="{{ $entrada->asunto }}">{{ $entrada->asunto }}</p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-on-surface-variant uppercase tracking-wider mb-1">Destinatario</p>
                    <p class="font-body-lg text-base text-on-surface font-medium mt-1">{{ $entrada->nombre_destinatario }}</p>
                    <p class="text-xs text-on-surface-variant">{{ $entrada->puesto->nombre ?? '' }}</p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-on-surface-variant uppercase tracking-wider mb-1">Área Destino Asignada</p>
                    <div class="flex items-center gap-2 mt-1">
                        <span class="w-2.5 h-2.5 rounded-full bg-primary"></span>
                        <p class="font-body-lg text-base text-on-surface font-semibold">{{ $entrada->area->nombre ?? 'Sin Asignar' }}</p>
                    </div>
                </div>
                <div>
                    <p class="text-xs font-semibold text-on-surface-variant uppercase tracking-wider mb-1">Fecha de Ingreso</p>
                    <p class="font-body-lg text-base text-on-surface font-medium mt-1">{{ \Carbon\Carbon::parse($entrada->fecha_registro)->format('d M Y, H:i') }} hrs</p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-on-surface-variant uppercase tracking-wider mb-1">Prioridad</p>
                    <div class="mt-1">
                        @if($entrada->prioridad == 'urgente')
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-rose-50 border border-rose-200/50 text-rose-700 rounded-lg text-xs font-bold">
                                <span class="material-symbols-outlined text-[14px]">error</span> Urgente
                            </span>
                        @elseif($entrada->prioridad == 'confidencial')
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-amber-50 border border-amber-200/50 text-amber-700 rounded-lg text-xs font-bold">
                                <span class="material-symbols-outlined text-[14px]">lock</span> Confidencial
                            </span>
                        @elseif($entrada->prioridad == 'con valores')
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-blue-50 border border-blue-200/50 text-blue-700 rounded-lg text-xs font-bold">
                                <span class="material-symbols-outlined text-[14px]">diamond</span> Valores
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-slate-50 border border-slate-200 text-slate-700 rounded-lg text-xs font-semibold">
                                {{ ucfirst($entrada->prioridad) }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Delivery Form Card -->
        <div class="bg-surface-lowest rounded-2xl border border-outline-variant shadow-sm p-6 md:p-8 relative overflow-hidden transition-shadow hover:shadow-md">
            <!-- Decorative background element for premium feel -->
            <div class="absolute top-0 right-0 w-64 h-64 bg-primary/5 rounded-full blur-3xl -mr-20 -mt-20 pointer-events-none"></div>
            
            <div class="flex items-center justify-between mb-6 pb-4 border-b border-outline-variant/30 relative z-10">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-primary/10 flex items-center justify-center text-primary">
                        <span class="material-symbols-outlined text-[22px]">how_to_reg</span>
                    </div>
                    <h3 class="font-headline-sm text-lg font-bold text-on-surface">Información de Recepción Interna</h3>
                </div>
                <span class="text-xs font-semibold text-rose-500">* datos obligatorios</span>
            </div>
            
            <form action="{{ route('entradas.entrega.store') }}" method="POST" class="space-y-6 relative z-10">
                @csrf
                <input type="hidden" name="correspondencia_id" value="{{ $entrada->id }}">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Área que recibe -->
                    <div class="flex flex-col gap-1.5">
                        <label class="text-sm font-medium text-on-surface-variant" for="area-recibe">Área que recibe <span class="text-rose-500">*</span></label>
                        <select name="area_recibe" id="area-recibe" class="w-full bg-surface-lowest border border-outline-variant rounded-lg px-4 py-2.5 text-sm text-on-surface focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 transition-all cursor-pointer" required>
                            <option value="">Seleccione el área</option>
                            @foreach($areas as $area)
                                <option value="{{ $area->nombre }}" {{ old('area_recibe', $entrada->area->nombre ?? '') == $area->nombre ? 'selected' : '' }}>
                                    {{ $area->nombre }}
                                </option>
                            @endforeach
                        </select>
                        @error('area_recibe') <span class="text-rose-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                    
                    <!-- Nombre de quien recibe -->
                    <div class="flex flex-col gap-1.5">
                        <label class="text-sm font-medium text-on-surface-variant" for="nombre-recibe">Nombre completo de quien recibe <span class="text-rose-500">*</span></label>
                        <input type="text" name="usuario_recibe" id="nombre-recibe" value="{{ old('usuario_recibe') }}" class="w-full bg-surface-lowest border border-outline-variant rounded-lg px-4 py-2.5 text-sm text-on-surface focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 transition-all placeholder-on-surface-variant/40" placeholder="Ej. Juan Pérez" required>
                        @error('usuario_recibe') <span class="text-rose-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                    
                    <!-- Fecha y Hora -->
                    <div class="flex flex-col gap-1.5 md:col-span-2 lg:col-span-1">
                        <label class="text-sm font-medium text-on-surface-variant" for="fecha-hora">Fecha y Hora de entrega <span class="text-rose-500">*</span></label>
                        <input type="datetime-local" name="fecha_entrega" id="fecha-hora" value="{{ old('fecha_entrega') }}" class="w-full bg-surface-lowest border border-outline-variant rounded-lg px-4 py-2.5 text-sm text-on-surface focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 transition-all cursor-pointer" required>
                        @error('fecha_entrega') <span class="text-rose-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                    
                    <!-- Observaciones -->
                    <div class="flex flex-col gap-1.5 md:col-span-2">
                        <label class="text-sm font-medium text-on-surface-variant" for="observaciones">Observaciones <span class="text-on-surface-variant/50 font-normal">(Opcional)</span></label>
                        <textarea name="observaciones" id="observaciones" rows="3" class="w-full bg-surface-lowest border border-outline-variant rounded-lg px-4 py-2.5 text-sm text-on-surface focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 transition-all resize-y placeholder-on-surface-variant/40" placeholder="Añada cualquier comentario o incidencia durante la entrega...">{{ old('observaciones') }}</textarea>
                        @error('observaciones') <span class="text-rose-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>
                
                <!-- Actions -->
                <div class="pt-6 mt-6 border-t border-outline-variant flex flex-col-reverse sm:flex-row justify-end gap-3">
                    <a href="{{ route('entradas.index') }}" class="bg-rose-500/10 hover:bg-rose-500/20 text-rose-600 border border-rose-200/40 px-6 py-3 text-sm font-semibold rounded-lg transition-colors flex items-center justify-center focus:outline-none cursor-pointer">
                        Cancelar
                    </a>
                    <button type="submit" class="flex items-center justify-center gap-2 px-8 py-3 bg-primary hover:bg-primary/95 text-on-primary text-sm font-semibold rounded-lg transition-all shadow-sm hover:shadow active:scale-[0.98] cursor-pointer focus:outline-none">
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
