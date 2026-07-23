@extends('layouts.app')

@section('title', 'Captura de Salida')

@section('content')
<div class="max-w-[1440px] mx-auto">
    <!-- Page Header -->
    <div class="mb-6 flex justify-between items-end">
        <div>
            <h2 class="font-headline-lg text-2xl md:text-3xl font-bold text-slate-900 mb-2">Captura de Salida UCC</h2>
            <p class="font-body-md text-sm text-slate-600">Registrar nueva correspondencia de salida oficial.</p>
        </div>
    </div>

    <!-- Formulario Principal -->
    <form action="{{ route('salidas.store') }}" method="POST" class="space-y-6">
        @csrf
        
        <input type="hidden" name="tipo" value="salida">

        <!-- Sección 1: Información de Salida / Envia -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
            <h3 class="font-headline-sm text-lg font-semibold text-slate-800 border-b border-slate-100 pb-3 mb-5 flex items-center gap-2">
                <span class="material-symbols-outlined text-secondary">domain</span>
                Información del Remitente (Interno)
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Área que envía -->
                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-medium text-slate-700">Área que envía <span class="text-red-500">*</span></label>
                    <select name="area_id" class="px-4 py-2 bg-white border @error('area_id') border-red-500 @else border-slate-300 @enderror rounded-md focus:border-secondary focus:ring-1 focus:ring-secondary outline-none text-sm text-slate-700 transition-colors" required>
                        <option value="" disabled selected>Seleccione área emisora...</option>
                        @foreach($areas ?? [] as $area)
                            <option value="{{ $area->id }}" {{ old('area_id') == $area->id ? 'selected' : '' }}>{{ $area->nombre }}</option>
                        @endforeach
                    </select>
                    @error('area_id') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                </div>
                
                <!-- Número de Ficha (Opcional, vínculo de entrada) -->
                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-medium text-slate-700">Folio Vinculado (Opcional)</label>
                    <input type="text" name="numero_ficha" value="{{ old('numero_ficha') }}" class="px-4 py-2 bg-white border @error('numero_ficha') border-red-500 @else border-slate-300 @enderror rounded-md focus:border-secondary focus:ring-1 focus:ring-secondary outline-none text-sm text-slate-700 transition-colors" placeholder="Vincular con ficha de entrada (ej. EXT-001)">
                    @error('numero_ficha') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        <!-- Sección 2: Información del Destinatario -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
            <h3 class="font-headline-sm text-lg font-semibold text-slate-800 border-b border-slate-100 pb-3 mb-5 flex items-center gap-2">
                <span class="material-symbols-outlined text-secondary">person</span>
                Información del Destinatario
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nombre Destinatario -->
                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-medium text-slate-700">Nombre del Destinatario <span class="text-red-500">*</span></label>
                    <input type="text" name="nombre_destinatario" value="{{ old('nombre_destinatario') }}" maxlength="30" class="px-4 py-2 bg-white border @error('nombre_destinatario') border-red-500 @else border-slate-300 @enderror rounded-md focus:border-secondary focus:ring-1 focus:ring-secondary outline-none text-sm text-slate-700 transition-colors" placeholder="Ej. Juan Pérez" required>
                    @error('nombre_destinatario') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                </div>
                
                <!-- Cargo Destinatario -->
                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-medium text-slate-700">Cargo del Destinatario (Opcional)</label>
                    <input type="text" name="cargo_destinatario" value="{{ old('cargo_destinatario') }}" maxlength="50" class="px-4 py-2 bg-white border @error('cargo_destinatario') border-red-500 @else border-slate-300 @enderror rounded-md focus:border-secondary focus:ring-1 focus:ring-secondary outline-none text-sm text-slate-700 transition-colors" placeholder="Ej. Director General">
                    @error('cargo_destinatario') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Institución -->
                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-medium text-slate-700">Departamento / Institución <span class="text-red-500">*</span></label>
                    <input type="text" name="institucion" value="{{ old('institucion') }}" maxlength="80" class="px-4 py-2 bg-white border @error('institucion') border-red-500 @else border-slate-300 @enderror rounded-md focus:border-secondary focus:ring-1 focus:ring-secondary outline-none text-sm text-slate-700 transition-colors" placeholder="Ej. Secretaría de Finanzas" required>
                    @error('institucion') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                </div>
                
                <!-- Domicilio -->
                <div class="flex flex-col gap-1.5 md:col-span-2">
                    <label class="text-sm font-medium text-slate-700">Dirección Física / Domicilio <span class="text-red-500">*</span></label>
                    <textarea name="domicilio" maxlength="100" rows="2" class="px-4 py-2 bg-white border @error('domicilio') border-red-500 @else border-slate-300 @enderror rounded-md focus:border-secondary focus:ring-1 focus:ring-secondary outline-none text-sm text-slate-700 transition-colors resize-y" placeholder="Calle, Número, Colonia, C.P., Ciudad" required>{{ old('domicilio') }}</textarea>
                    @error('domicilio') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        <!-- Sección 3: Detalles del Envío / Contenido -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
            <h3 class="font-headline-sm text-lg font-semibold text-slate-800 border-b border-slate-100 pb-3 mb-5 flex items-center gap-2">
                <span class="material-symbols-outlined text-secondary">description</span>
                Detalles del Contenido y Envío
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
                <!-- Tipo Contenido -->
                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-medium text-slate-700 mb-1">Tipo de Contenido <span class="text-red-500">*</span></label>
                    <div class="flex gap-4">
                        <label class="cursor-pointer">
                            <input type="radio" name="tipo_contenido" value="documento" class="peer sr-only" {{ old('tipo_contenido', 'documento') == 'documento' ? 'checked' : '' }}>
                            <span class="inline-flex items-center px-4 py-1.5 rounded border border-slate-200 bg-slate-50 text-slate-600 text-sm peer-checked:bg-blue-50 peer-checked:text-blue-700 peer-checked:border-blue-300 transition-colors">
                                Documento
                            </span>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" name="tipo_contenido" value="paquete" class="peer sr-only" {{ old('tipo_contenido') == 'paquete' ? 'checked' : '' }}>
                            <span class="inline-flex items-center px-4 py-1.5 rounded border border-slate-200 bg-slate-50 text-slate-600 text-sm peer-checked:bg-blue-50 peer-checked:text-blue-700 peer-checked:border-blue-300 transition-colors">
                                Paquete
                            </span>
                        </label>
                    </div>
                    @error('tipo_contenido') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Caracter Especial -->
                <div class="flex flex-col gap-1.5 lg:col-span-2">
                    <label class="text-sm font-medium text-slate-700 mb-1">Carácter Especial <span class="text-red-500">*</span></label>
                    <div class="flex flex-wrap gap-2">
                        <label class="cursor-pointer">
                            <input type="radio" name="caracter_especial" value="ninguno" class="peer sr-only" {{ old('caracter_especial', 'ninguno') == 'ninguno' ? 'checked' : '' }}>
                            <span class="inline-flex items-center px-3 py-1 rounded-full border border-slate-200 bg-slate-50 text-slate-600 text-xs font-medium peer-checked:bg-slate-200 peer-checked:text-slate-800 peer-checked:border-slate-300 transition-colors">
                                Ninguno
                            </span>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" name="caracter_especial" value="confidencial" class="peer sr-only" {{ old('caracter_especial') == 'confidencial' ? 'checked' : '' }}>
                            <span class="inline-flex items-center px-3 py-1 rounded-full border border-red-200 bg-red-50 text-red-600 text-xs font-medium peer-checked:bg-red-100 peer-checked:text-red-800 peer-checked:border-red-300 transition-colors">
                                Confidencial
                            </span>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" name="caracter_especial" value="con valores" class="peer sr-only" {{ old('caracter_especial') == 'con valores' ? 'checked' : '' }}>
                            <span class="inline-flex items-center px-3 py-1 rounded-full border border-amber-200 bg-amber-50 text-amber-600 text-xs font-medium peer-checked:bg-amber-100 peer-checked:text-amber-800 peer-checked:border-amber-300 transition-colors">
                                Con Valores
                            </span>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" name="caracter_especial" value="con riesgo" class="peer sr-only" {{ old('caracter_especial') == 'con riesgo' ? 'checked' : '' }}>
                            <span class="inline-flex items-center px-3 py-1 rounded-full border border-orange-200 bg-orange-50 text-orange-600 text-xs font-medium peer-checked:bg-orange-100 peer-checked:text-orange-800 peer-checked:border-orange-300 transition-colors">
                                Con Riesgo
                            </span>
                        </label>
                    </div>
                    @error('caracter_especial') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                </div>
                
                <!-- Nivel de Prioridad -->
                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-medium text-slate-700 mb-1">Prioridad de Envío <span class="text-red-500">*</span></label>
                    <div class="flex gap-2">
                        <label class="cursor-pointer">
                            <input type="radio" name="prioridad" value="ordinario" class="peer sr-only" {{ old('prioridad', 'ordinario') == 'ordinario' ? 'checked' : '' }}>
                            <span class="inline-flex items-center px-3 py-1 rounded-full border border-slate-200 bg-slate-50 text-slate-600 text-xs font-medium peer-checked:bg-blue-50 peer-checked:text-blue-700 peer-checked:border-blue-300 transition-colors">
                                Ordinario
                            </span>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" name="prioridad" value="urgente" class="peer sr-only" {{ old('prioridad') == 'urgente' ? 'checked' : '' }}>
                            <span class="inline-flex items-center px-3 py-1 rounded-full border border-red-200 bg-red-50 text-red-600 text-xs font-medium peer-checked:bg-red-100 peer-checked:text-red-800 peer-checked:border-red-300 transition-colors">
                                Urgente
                            </span>
                        </label>
                    </div>
                    @error('prioridad') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Fecha Límite de Entrega -->
                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-medium text-slate-700">Fecha Límite (Opcional)</label>
                    <input type="date" name="fecha_limite_entrega" value="{{ old('fecha_limite_entrega') }}" class="px-4 py-2 bg-white border @error('fecha_limite_entrega') border-red-500 @else border-slate-300 @enderror rounded-md focus:border-secondary focus:ring-1 focus:ring-secondary outline-none text-sm text-slate-700 transition-colors">
                    @error('fecha_limite_entrega') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- Asunto -->
            <div class="flex flex-col gap-1.5 mt-2">
                <label class="text-sm font-medium text-slate-700">Asunto / Resumen (Opcional)</label>
                <textarea name="asunto" rows="2" class="px-4 py-2 bg-white border @error('asunto') border-red-500 @else border-slate-300 @enderror rounded-md focus:border-secondary focus:ring-1 focus:ring-secondary outline-none text-sm text-slate-700 resize-none transition-colors" placeholder="Describa brevemente el contenido del documento...">{{ old('asunto') }}</textarea>
                @error('asunto') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <!-- Sección 4: Método y Logística de Envío -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
            <h3 class="font-headline-sm text-lg font-semibold text-slate-800 border-b border-slate-100 pb-3 mb-5 flex items-center gap-2">
                <span class="material-symbols-outlined text-secondary">local_shipping</span>
                Método y Logística de Envío
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Fecha y Hora de Envío -->
                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-medium text-slate-700">Fecha y Hora de Envío <span class="text-red-500">*</span></label>
                    <input type="datetime-local" name="fecha_hora_envio" value="{{ old('fecha_hora_envio', now()->format('Y-m-d\TH:i')) }}" class="px-4 py-2 bg-slate-50 border @error('fecha_hora_envio') border-red-500 @else border-slate-300 @enderror rounded-md focus:border-secondary focus:ring-1 focus:ring-secondary outline-none text-sm text-slate-700 transition-colors" required>
                    @error('fecha_hora_envio') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Empresa de Mensajería -->
                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-medium text-slate-700">Empresa de Mensajería (Opcional)</label>
                    <input type="text" name="nombre_empresa" value="{{ old('nombre_empresa') }}" maxlength="80" class="px-4 py-2 bg-white border @error('nombre_empresa') border-red-500 @else border-slate-300 @enderror rounded-md focus:border-secondary focus:ring-1 focus:ring-secondary outline-none text-sm text-slate-700 transition-colors" placeholder="Ej. DHL, Fedex, Sepomex">
                    @error('nombre_empresa') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Mensajero Local -->
                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-medium text-slate-700">Nombre del Mensajero Local (Opcional)</label>
                    <input type="text" name="nombre_mensajero" value="{{ old('nombre_mensajero') }}" maxlength="50" class="px-4 py-2 bg-white border @error('nombre_mensajero') border-red-500 @else border-slate-300 @enderror rounded-md focus:border-secondary focus:ring-1 focus:ring-secondary outline-none text-sm text-slate-700 transition-colors" placeholder="Ej. Carlos Martínez">
                    @error('nombre_mensajero') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        <!-- Acciones Formulario -->
        <div class="flex justify-end gap-3 pt-2">
            <button type="reset" class="px-6 py-2 bg-white border border-slate-300 text-slate-700 font-medium text-sm rounded hover:bg-slate-50 transition-colors">
                Limpiar Formulario
            </button>
            <button type="submit" class="px-6 py-2 bg-primary text-white font-medium text-sm rounded shadow-sm hover:bg-slate-800 transition-colors flex items-center gap-2">
                <span class="material-symbols-outlined text-[18px]">send</span>
                Registrar Salida
            </button>
        </div>
    </form>
</div>
@endsection
