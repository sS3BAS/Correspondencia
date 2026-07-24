@extends('layouts.app')

@section('title', 'Registrar Acuse de Recibido')

@section('content')
<div class="max-w-[1440px] mx-auto space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-2">
        <div>
            <h1 class="font-headline-lg text-2xl md:text-3xl font-bold text-on-surface mb-1 flex items-center gap-2">
                <span class="material-symbols-outlined text-primary text-[32px]">receipt_long</span>
                Registrar Acuse de Recibido
            </h1>
            <p class="font-body-md text-sm text-on-surface-variant">Capture los datos finales de la entrega para cerrar el ciclo logístico de la correspondencia saliente.</p>
        </div>
        <div class="flex items-center gap-2">
            <span class="inline-flex items-center px-3.5 py-1.5 rounded-full font-bold text-xs bg-blue-50 text-blue-700 border border-blue-200/60 shadow-sm">
                <span class="w-2 h-2 rounded-full bg-blue-500 mr-2 animate-pulse"></span>
                Estado Actual: En Tránsito
            </span>
        </div>
    </div>

    @if($errors->any())
        <div class="p-4 text-sm text-rose-800 bg-rose-50 rounded-xl border border-rose-200 flex items-center gap-2">
            <span class="material-symbols-outlined text-rose-500 text-[20px]">error</span>
            <span class="font-medium">Por favor revise los campos obligatorios del formulario.</span>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        <!-- Resumen de Envío (Card Lateral) -->
        <div class="lg:col-span-4 flex flex-col gap-6">
            <div class="bg-surface-lowest border border-outline-variant rounded-2xl shadow-sm p-6 space-y-5">
                <div class="flex items-center gap-3 pb-4 border-b border-outline-variant/30">
                    <div class="w-10 h-10 rounded-xl bg-primary/10 border border-primary/20 flex items-center justify-center text-primary">
                        <span class="material-symbols-outlined">mark_email_read</span>
                    </div>
                    <div>
                        <h3 class="font-headline-sm text-lg font-bold text-on-surface">Resumen de Envío</h3>
                        <p class="font-label-sm text-xs text-on-surface-variant">Detalles de la salida original</p>
                    </div>
                </div>
                
                <dl class="flex flex-col gap-4 text-sm">
                    <div>
                        <dt class="text-xs font-semibold text-on-surface-variant uppercase tracking-wider mb-1">Número de Control</dt>
                        <dd class="font-mono bg-primary/5 text-primary border border-primary/10 px-3 py-1.5 rounded-lg text-xs font-bold inline-block">
                            {{ $correspondencia->numero_control }}
                        </dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold text-on-surface-variant uppercase tracking-wider mb-1">Destinatario e Institución</dt>
                        <dd class="flex flex-col text-on-surface">
                            <span class="font-bold text-base">{{ $correspondencia->nombre_destinatario }}</span>
                            <span class="text-xs text-on-surface-variant font-medium">{{ $correspondencia->institucion }}</span>
                        </dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold text-on-surface-variant uppercase tracking-wider mb-1">Domicilio de Entrega</dt>
                        <dd class="text-xs text-on-surface-variant/90 flex gap-2 items-start bg-surface-variant/20 p-3 rounded-xl border border-outline-variant/30">
                            <span class="material-symbols-outlined text-[18px] text-primary shrink-0 mt-0.5">location_on</span>
                            <span>{{ $correspondencia->domicilio }}</span>
                        </dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold text-on-surface-variant uppercase tracking-wider mb-1">Servicio de Reparto</dt>
                        <dd class="text-on-surface font-medium text-xs">
                            <span class="font-semibold text-sm block text-on-surface">{{ $correspondencia->reparto->tipo_servicio ?? 'Servicio Estándar' }}</span>
                            @if($correspondencia->reparto && $correspondencia->reparto->mensajero)
                                <span class="inline-flex items-center gap-1 text-xs text-on-surface-variant/70 mt-1">
                                    <span class="material-symbols-outlined text-[14px]">person</span>
                                    <span>Resp: {{ $correspondencia->reparto->mensajero }}</span>
                                </span>
                            @endif
                        </dd>
                    </div>
                </dl>
            </div>
        </div>
        
        <!-- Formulario de Captura -->
        <div class="lg:col-span-8">
            <form action="{{ route('acuses.store') }}" method="POST" class="bg-surface-lowest border border-outline-variant rounded-2xl shadow-sm p-6 lg:p-8 flex flex-col h-full relative overflow-hidden">
                @csrf
                <input type="hidden" name="correspondencia_id" value="{{ $correspondencia->id }}">
                
                <div class="flex items-center justify-between pb-4 mb-6 border-b border-outline-variant/30">
                    <div>
                        <h3 class="font-headline-sm text-xl font-bold text-on-surface">Datos de Recepción</h3>
                        <p class="font-body-md text-xs text-on-surface-variant mt-0.5">Complete la información de acuse asentada en el documento físico.</p>
                    </div>
                    <span class="text-xs font-semibold text-rose-500">* datos obligatorios</span>
                </div>
                
                <div class="flex flex-col gap-5 flex-grow">
                    <!-- Fecha y Hora -->
                    <div class="w-full md:w-2/3">
                        <label class="block text-xs font-semibold text-on-surface-variant uppercase tracking-wider mb-1.5" for="fecha_acuse">
                            Fecha y Hora de Recepción <span class="text-rose-500">*</span>
                        </label>
                        <input type="datetime-local" class="w-full bg-surface-lowest border border-outline-variant rounded-lg py-2.5 px-3 text-sm text-on-surface focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 transition-all cursor-pointer shadow-sm" id="fecha_acuse" name="fecha_acuse" value="{{ old('fecha_acuse') }}" required>
                        @error('fecha_acuse') <span class="text-rose-500 text-xs mt-1 block font-medium">{{ $message }}</span> @enderror
                    </div>
                    
                    <!-- Nombre quien recibe -->
                    <div class="w-full">
                        <label class="block text-xs font-semibold text-on-surface-variant uppercase tracking-wider mb-1.5" for="nombre_recibe">
                            Nombre de quien firmó/recibió <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant/40 text-[20px] pointer-events-none">person_edit</span>
                            <input type="text" class="w-full bg-surface-lowest border border-outline-variant rounded-lg py-2.5 pl-10 pr-3 text-sm text-on-surface placeholder:text-on-surface-variant/40 focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 transition-all shadow-sm" id="nombre_recibe" name="nombre_recibe" value="{{ old('nombre_recibe') }}" placeholder="Ej. María Sánchez (Recepción)" required>
                        </div>
                        <p class="mt-1 text-xs text-on-surface-variant/60">Si el destinatario no recibió personalmente, indique el nombre y cargo de la persona que firmó el acuse.</p>
                        @error('nombre_recibe') <span class="text-rose-500 text-xs mt-1 block font-medium">{{ $message }}</span> @enderror
                    </div>
                    
                    <!-- Observaciones -->
                    <div class="w-full">
                        <label class="block text-xs font-semibold text-on-surface-variant uppercase tracking-wider mb-1.5" for="observaciones">
                            Observaciones Generales
                        </label>
                        <textarea class="w-full bg-surface-lowest border border-outline-variant rounded-lg py-2.5 px-3 text-sm text-on-surface placeholder:text-on-surface-variant/40 focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 transition-all shadow-sm resize-y" id="observaciones" name="observaciones" placeholder="Cualquier incidencia, sello visible, condición del paquete, o nota adicional relevante..." rows="3">{{ old('observaciones') }}</textarea>
                        @error('observaciones') <span class="text-rose-500 text-xs mt-1 block font-medium">{{ $message }}</span> @enderror
                    </div>
                </div>
                
                <!-- Actions -->
                <div class="mt-8 pt-6 border-t border-outline-variant/30 flex flex-col sm:flex-row justify-end gap-3">
                    <a href="{{ auth()->user()->role_id === 4 ? route('mensajero.entregas') : route('repartos.index') }}" class="px-5 py-2.5 rounded-lg bg-rose-50 text-rose-700 hover:bg-rose-100/80 border border-rose-200/80 hover:border-rose-300 font-semibold text-sm transition-all shadow-sm text-center order-2 sm:order-1 cursor-pointer flex items-center justify-center gap-1.5">
                        <span class="material-symbols-outlined text-[18px]">cancel</span>
                        Cancelar
                    </a>
                    <button type="submit" class="px-6 py-2.5 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm flex items-center justify-center gap-2 transition-all shadow-md hover:shadow-lg order-1 sm:order-2 cursor-pointer">
                        <span class="material-symbols-outlined text-[18px]">check_circle</span>
                        Marcar envío como RECIBIDO
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const datetimeInput = document.getElementById('fecha_acuse');
        if (!datetimeInput.value) {
            const now = new Date();
            now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
            datetimeInput.value = now.toISOString().slice(0,16);
        }
    });
</script>
@endsection
