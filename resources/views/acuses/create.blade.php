@extends('layouts.app')

@section('title', 'Registro de Acuse de Recibido')

@section('content')
<div class="max-w-[1440px] mx-auto h-full overflow-y-auto">
    <!-- Page Header -->
    <div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="font-headline-lg-mobile md:font-headline-lg text-2xl md:text-3xl font-bold text-slate-900 mb-1">Registrar Acuse de Recibido</h2>
            <p class="font-body-md text-sm text-slate-600 mt-1">Capture los datos finales de la entrega para cerrar el ciclo logístico de la correspondencia saliente.</p>
        </div>
        <div class="flex items-center gap-2">
            <span class="inline-flex items-center px-3 py-1 rounded-full font-medium text-xs bg-blue-50 text-blue-700 border border-blue-200">
                <span class="w-1.5 h-1.5 rounded-full bg-blue-500 mr-1.5"></span>
                Estado Actual: En Tránsito
            </span>
        </div>
    </div>

    @if($errors->any())
        <div class="mb-6 px-4 py-3 bg-red-50 text-red-800 border border-red-200 rounded-lg text-sm">
            <strong>Error:</strong> Por favor revise los campos del formulario.
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        <!-- Resumen de Envío (Card) -->
        <div class="lg:col-span-4 flex flex-col gap-6">
            <div class="bg-white border border-slate-200 rounded-xl shadow-sm p-6">
                <div class="flex items-center gap-3 mb-6 pb-4 border-b border-slate-100">
                    <div class="w-10 h-10 rounded-full bg-slate-50 border border-slate-100 flex items-center justify-center text-slate-500">
                        <span class="material-symbols-outlined">inventory_2</span>
                    </div>
                    <div>
                        <h3 class="font-headline-sm text-lg font-semibold text-slate-800">Resumen de Envío</h3>
                        <p class="font-label-sm text-xs text-slate-500">Detalles de la salida original</p>
                    </div>
                </div>
                
                <dl class="flex flex-col gap-5">
                    <div>
                        <dt class="font-label-caps text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Número de Control</dt>
                        <dd class="font-body-md text-sm font-bold text-slate-900 font-mono">{{ $correspondencia->numero_control }}</dd>
                    </div>
                    <div>
                        <dt class="font-label-caps text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Destinatario e Institución</dt>
                        <dd class="font-body-md text-sm flex flex-col text-slate-800">
                            <span class="font-semibold">{{ $correspondencia->nombre_destinatario }}</span>
                            <span class="text-slate-500">{{ $correspondencia->institucion }}</span>
                        </dd>
                    </div>
                    <div>
                        <dt class="font-label-caps text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Domicilio de Entrega</dt>
                        <dd class="font-body-md text-sm text-slate-700 flex gap-2 items-start bg-slate-50 p-3 rounded-lg border border-slate-100 mt-1">
                            <span class="material-symbols-outlined text-[18px] text-slate-400 mt-0.5 shrink-0">location_on</span>
                            <span>{{ $correspondencia->domicilio }}</span>
                        </dd>
                    </div>
                    <div>
                        <dt class="font-label-caps text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Servicio de Reparto</dt>
                        <dd class="font-body-md text-sm text-slate-800 font-medium">
                            {{ $correspondencia->reparto->tipo_servicio ?? 'Servicio Estándar' }}
                            @if($correspondencia->reparto && $correspondencia->reparto->mensajero)
                                <span class="block text-xs font-normal text-slate-500 mt-0.5">Resp: {{ $correspondencia->reparto->mensajero }}</span>
                            @endif
                        </dd>
                    </div>
                </dl>
            </div>
        </div>
        
        <!-- Formulario de Captura -->
        <div class="lg:col-span-8">
            <form action="{{ route('acuses.store') }}" method="POST" class="bg-white border border-slate-200 rounded-xl shadow-sm p-6 lg:p-8 flex flex-col h-full relative overflow-hidden">
                @csrf
                <input type="hidden" name="correspondencia_id" value="{{ $correspondencia->id }}">
                
                <div class="mb-8 relative z-10">
                    <h3 class="font-headline-sm text-xl font-semibold text-slate-800 mb-2">Datos de Recepción</h3>
                    <p class="font-body-md text-sm text-slate-600">Por favor, complete los datos obligatorios marcados con asterisco (*) basados en el acuse físico.</p>
                </div>
                
                <div class="flex flex-col gap-6 flex-grow relative z-10">
                    <!-- Fecha y Hora -->
                    <div class="w-full md:w-2/3">
                        <label class="block text-sm font-medium text-slate-700 mb-2" for="fecha_acuse">Fecha y Hora de Recepción <span class="text-red-500">*</span></label>
                        <input type="datetime-local" class="w-full bg-white border border-slate-300 rounded-lg py-2.5 px-3 text-sm focus:outline-none focus:ring-2 focus:ring-secondary/20 focus:border-secondary transition-all shadow-sm" id="fecha_acuse" name="fecha_acuse" value="{{ old('fecha_acuse') }}" required>
                        @error('fecha_acuse') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                    
                    <!-- Nombre quien recibe -->
                    <div class="w-full">
                        <label class="block text-sm font-medium text-slate-700 mb-2" for="nombre_recibe">Nombre de quien firmó/recibió <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-[20px] pointer-events-none">person_edit</span>
                            <input type="text" class="w-full bg-white border border-slate-300 rounded-lg py-2.5 pl-10 pr-3 text-sm focus:outline-none focus:ring-2 focus:ring-secondary/20 focus:border-secondary transition-all shadow-sm" id="nombre_recibe" name="nombre_recibe" value="{{ old('nombre_recibe') }}" placeholder="Ej. María Sánchez (Recepción)" required>
                        </div>
                        <p class="mt-1.5 text-xs text-slate-500">Si el destinatario no recibió personalmente, indique el nombre y cargo de la persona que firmó el acuse en la institución destino.</p>
                        @error('nombre_recibe') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    
                    <!-- Observaciones -->
                    <div class="w-full">
                        <label class="block text-sm font-medium text-slate-700 mb-2" for="observaciones">Observaciones Generales</label>
                        <textarea class="w-full bg-white border border-slate-300 rounded-lg py-3 px-3 text-sm focus:outline-none focus:ring-2 focus:ring-secondary/20 focus:border-secondary transition-all shadow-sm resize-y" id="observaciones" name="observaciones" placeholder="Cualquier incidencia, sello visible, condición del paquete, o nota adicional relevante para el registro..." rows="3">{{ old('observaciones') }}</textarea>
                        @error('observaciones') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                    
                    <!-- Digital Evidence Placeholder -->
                    <div class="w-full mt-2 p-4 rounded-lg border-2 border-dashed border-slate-200 bg-slate-50 flex flex-col items-center justify-center gap-2 cursor-pointer hover:bg-slate-100 hover:border-slate-300 transition-colors group">
                        <span class="material-symbols-outlined text-slate-400 group-hover:text-secondary text-3xl transition-colors">upload_file</span>
                        <span class="text-sm font-medium text-slate-600 text-center">Adjuntar foto/PDF del Acuse Firmado (Opcional)</span>
                        <span class="text-xs text-slate-400 text-center">Formatos soportados: JPG, PNG, PDF. Máx 5MB.</span>
                    </div>
                </div>
                
                <!-- Actions -->
                <div class="mt-10 pt-6 border-t border-slate-100 flex flex-col sm:flex-row justify-end gap-4 relative z-10">
                    <a href="{{ route('repartos.index') }}" class="px-6 py-2.5 rounded-lg border border-slate-200 text-slate-600 font-medium text-sm bg-white hover:bg-slate-50 transition-colors shadow-sm text-center order-2 sm:order-1">
                        Cancelar
                    </a>
                    <!-- Destacada en verde usando Tailwind nativo -->
                    <button type="submit" class="px-6 py-2.5 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white font-medium text-sm flex items-center justify-center gap-2 transition-colors shadow-sm order-1 sm:order-2">
                        <span class="material-symbols-outlined text-[18px]">check_circle</span>
                        Marcar Envío como RECIBIDO
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Set current datetime for the input if not set via old()
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
