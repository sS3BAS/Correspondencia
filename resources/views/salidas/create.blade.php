@extends('layouts.app')

@section('title', 'Captura de Salida')

@section('content')
<div class="max-w-[1440px] mx-auto space-y-6">
    <!-- Page Header -->
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="font-headline-lg text-2xl md:text-3xl font-bold text-on-surface mb-1 flex items-center gap-2">
                <span class="material-symbols-outlined text-primary text-[32px]">outbox</span>
                Captura de Salida UCC
            </h2>
            <p class="font-body-md text-sm text-on-surface-variant">Registrar nueva correspondencia de salida oficial.</p>
        </div>
        <div>
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2 bg-surface-variant/20 hover:bg-surface-variant/40 border border-outline-variant text-on-surface font-semibold text-sm px-4 py-2.5 rounded-lg shadow-sm transition-all cursor-pointer">
                <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                Volver al Panel
            </a>
        </div>
    </div>

    @if($errors->any())
        <div class="mb-6 px-4 py-3 bg-rose-50 text-rose-800 border border-rose-200/50 rounded-lg text-sm flex items-center gap-2">
            <span class="material-symbols-outlined text-rose-500 text-[20px]">error</span>
            <strong>Error:</strong> Por favor revise los campos del formulario.
        </div>
    @endif

    <!-- Formulario Principal -->
    <form action="{{ route('salidas.store') }}" method="POST" class="space-y-6">
        @csrf
        
        <input type="hidden" name="tipo" value="salida">

        <!-- Sección 1: Información de Salida / Envia -->
        <div class="bg-surface-lowest rounded-2xl border border-outline-variant shadow-sm p-6 md:p-8 relative overflow-hidden transition-shadow hover:shadow-md">
            <div class="absolute top-0 right-0 w-64 h-64 bg-primary/5 rounded-full blur-3xl -mr-20 -mt-20 pointer-events-none"></div>
            
            <div class="flex items-center justify-between mb-6 pb-4 border-b border-outline-variant/30 relative z-10">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary text-[22px]">domain</span>
                    <h3 class="font-headline-sm text-lg font-bold text-on-surface">Información del Remitente (Interno)</h3>
                </div>
                <span class="text-xs font-semibold text-rose-500">* datos obligatorios</span>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 relative z-10">
                <!-- Área que envía -->
                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-medium text-on-surface-variant">Área que envía <span class="text-rose-500">*</span></label>
                    <select name="area_id" class="w-full bg-surface-lowest border @error('area_id') border-rose-500 @else border-outline-variant @enderror rounded-lg px-4 py-2.5 text-sm text-on-surface focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 transition-all cursor-pointer" required>
                        <option value="" disabled selected>Seleccione área emisora...</option>
                        @foreach($areas ?? [] as $area)
                            <option value="{{ $area->id }}" {{ old('area_id') == $area->id ? 'selected' : '' }}>{{ $area->nombre }}</option>
                        @endforeach
                    </select>
                    @error('area_id') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                </div>
                
                <!-- Número de Control (Autogenerado, No editable) -->
                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-medium text-on-surface-variant">Número de Control</label>
                    <input type="text" name="numero_control" value="{{ $nextControlNumber }}" readonly class="w-full px-4 py-2.5 bg-surface-variant/30 border border-outline-variant rounded-lg text-sm text-primary font-mono font-semibold outline-none cursor-not-allowed select-none transition-all shadow-inner">
                    @error('numero_control') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        <!-- Sección 2: Información del Destinatario -->
        <div class="bg-surface-lowest rounded-2xl border border-outline-variant shadow-sm p-6 md:p-8 relative overflow-hidden transition-shadow hover:shadow-md">
            <div class="absolute top-0 right-0 w-64 h-64 bg-primary/5 rounded-full blur-3xl -mr-20 -mt-20 pointer-events-none"></div>
            
            <div class="flex items-center justify-between mb-6 pb-4 border-b border-outline-variant/30 relative z-10">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary text-[22px]">person</span>
                    <h3 class="font-headline-sm text-lg font-bold text-on-surface">Información del Destinatario</h3>
                </div>
                <span class="text-xs font-semibold text-rose-500">* datos obligatorios</span>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 relative z-10">
                <!-- Nombre Destinatario -->
                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-medium text-on-surface-variant">Nombre del Destinatario <span class="text-rose-500">*</span></label>
                    <input type="text" name="nombre_destinatario" value="{{ old('nombre_destinatario') }}" maxlength="40" class="w-full bg-surface-lowest border @error('nombre_destinatario') border-rose-500 @else border-outline-variant @enderror rounded-lg px-4 py-2.5 text-sm text-on-surface placeholder:text-on-surface-variant/40 focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 transition-all" placeholder="Ej. Juan Pérez" required>
                    @error('nombre_destinatario') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                </div>
                
                <!-- Cargo Destinatario -->
                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-medium text-on-surface-variant">Cargo del Destinatario <span class="text-on-surface-variant/50 font-normal">(Opcional)</span></label>
                    <input type="text" name="cargo_destinatario" value="{{ old('cargo_destinatario') }}" maxlength="50" class="w-full bg-surface-lowest border @error('cargo_destinatario') border-rose-500 @else border-outline-variant @enderror rounded-lg px-4 py-2.5 text-sm text-on-surface placeholder:text-on-surface-variant/40 focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 transition-all" placeholder="Ej. Director General">
                    @error('cargo_destinatario') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Institución -->
                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-medium text-on-surface-variant">Departamento / Institución <span class="text-rose-500">*</span></label>
                    <input type="text" name="institucion" value="{{ old('institucion') }}" maxlength="80" class="w-full bg-surface-lowest border @error('institucion') border-rose-500 @else border-outline-variant @enderror rounded-lg px-4 py-2.5 text-sm text-on-surface placeholder:text-on-surface-variant/40 focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 transition-all" placeholder="Ej. Secretaría de Finanzas" required>
                    @error('institucion') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                </div>
                
                <!-- Domicilio -->
                <div class="flex flex-col gap-1.5 md:col-span-2">
                    <label class="text-sm font-medium text-on-surface-variant">Dirección Física / Domicilio <span class="text-rose-500">*</span></label>
                    <textarea name="domicilio" maxlength="100" rows="2" class="w-full bg-surface-lowest border @error('domicilio') border-rose-500 @else border-outline-variant @enderror rounded-lg px-4 py-2.5 text-sm text-on-surface placeholder:text-on-surface-variant/40 focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 transition-all resize-y" placeholder="Calle, Número, Colonia, C.P., Ciudad" required>{{ old('domicilio') }}</textarea>
                    @error('domicilio') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        <!-- Sección 3: Detalles del Envío / Contenido -->
        <div class="bg-surface-lowest rounded-2xl border border-outline-variant shadow-sm p-6 md:p-8 relative overflow-hidden transition-shadow hover:shadow-md">
            <div class="absolute top-0 right-0 w-64 h-64 bg-primary/5 rounded-full blur-3xl -mr-20 -mt-20 pointer-events-none"></div>
            
            <div class="flex items-center justify-between mb-6 pb-4 border-b border-outline-variant/30 relative z-10">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary text-[22px]">description</span>
                    <h3 class="font-headline-sm text-lg font-bold text-on-surface">Detalles del Contenido y Envío</h3>
                </div>
                <span class="text-xs font-semibold text-rose-500">* datos obligatorios</span>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6 relative z-10">
                <!-- Tipo Contenido -->
                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-medium text-on-surface-variant mb-1">Tipo de Contenido <span class="text-rose-500">*</span></label>
                    <div class="flex gap-4">
                        <label class="cursor-pointer">
                            <input type="radio" name="tipo_contenido" value="documento" class="peer sr-only" {{ old('tipo_contenido', 'documento') == 'documento' ? 'checked' : '' }}>
                            <span class="inline-flex items-center px-4 py-2 rounded-lg border border-outline-variant bg-surface-lowest text-on-surface-variant text-sm font-semibold peer-checked:bg-primary/15 peer-checked:text-primary peer-checked:border-primary transition-colors cursor-pointer select-none">
                                Documento
                            </span>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" name="tipo_contenido" value="paquete" class="peer sr-only" {{ old('tipo_contenido') == 'paquete' ? 'checked' : '' }}>
                            <span class="inline-flex items-center px-4 py-2 rounded-lg border border-outline-variant bg-surface-lowest text-on-surface-variant text-sm font-semibold peer-checked:bg-primary/15 peer-checked:text-primary peer-checked:border-primary transition-colors cursor-pointer select-none">
                                Paquete
                            </span>
                        </label>
                    </div>
                    @error('tipo_contenido') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Caracter Especial -->
                <div class="flex flex-col gap-1.5 lg:col-span-2">
                    <label class="text-sm font-medium text-on-surface-variant mb-1">Carácter Especial <span class="text-rose-500">*</span></label>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mt-1">
                        <label class="flex items-center gap-2.5 cursor-pointer bg-slate-50/50 hover:bg-slate-100/60 px-4 py-3 rounded-xl border border-slate-200 transition-all select-none">
                            <input type="radio" name="caracter_especial" value="ninguno" class="w-4 h-4 text-primary focus:ring-primary/30 border-slate-300 cursor-pointer" {{ old('caracter_especial', 'ninguno') == 'ninguno' ? 'checked' : '' }} required/>
                            <span class="text-sm font-medium text-slate-700 flex items-center gap-1">
                                <span class="material-symbols-outlined text-[18px]">block</span> Ninguno
                            </span>
                        </label>
                        <label class="flex items-center gap-2.5 cursor-pointer bg-rose-50/40 hover:bg-rose-50/80 px-4 py-3 rounded-xl border border-rose-200/50 transition-all select-none">
                            <input type="radio" name="caracter_especial" value="confidencial" class="w-4 h-4 text-rose-600 focus:ring-rose-500/30 border-rose-300 cursor-pointer" {{ old('caracter_especial') == 'confidencial' ? 'checked' : '' }}/>
                            <span class="text-sm font-semibold text-rose-700 flex items-center gap-1">
                                <span class="material-symbols-outlined text-[18px]">lock</span> Confidencial
                            </span>
                        </label>
                        <label class="flex items-center gap-2.5 cursor-pointer bg-blue-50/40 hover:bg-blue-50/80 px-4 py-3 rounded-xl border border-blue-200/50 transition-all select-none">
                            <input type="radio" name="caracter_especial" value="con valores" class="w-4 h-4 text-blue-600 focus:ring-blue-500/30 border-blue-300 cursor-pointer" {{ old('caracter_especial') == 'con valores' ? 'checked' : '' }}/>
                            <span class="text-sm font-semibold text-blue-700 flex items-center gap-1">
                                <span class="material-symbols-outlined text-[18px]">diamond</span> Valores
                            </span>
                        </label>
                        <label class="flex items-center gap-2.5 cursor-pointer bg-orange-50/40 hover:bg-orange-50/80 px-4 py-3 rounded-xl border border-orange-200/50 transition-all select-none">
                            <input type="radio" name="caracter_especial" value="con riesgo" class="w-4 h-4 text-orange-600 focus:ring-orange-500/30 border-orange-300 cursor-pointer" {{ old('caracter_especial') == 'con riesgo' ? 'checked' : '' }}/>
                            <span class="text-sm font-semibold text-orange-700 flex items-center gap-1">
                                <span class="material-symbols-outlined text-[18px]">warning</span> Riesgo
                            </span>
                        </label>
                    </div>
                    @error('caracter_especial') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                </div>
                
                <!-- Nivel de Prioridad -->
                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-medium text-on-surface-variant mb-1">Prioridad de Envío <span class="text-rose-500">*</span></label>
                    <div class="grid grid-cols-2 gap-3 mt-1">
                        <label class="flex items-center gap-2.5 cursor-pointer bg-slate-50/50 hover:bg-slate-100/60 px-4 py-3 rounded-xl border border-slate-200 transition-all select-none">
                            <input type="radio" name="prioridad" value="ordinario" class="w-4 h-4 text-primary focus:ring-primary/30 border-slate-300 cursor-pointer" {{ old('prioridad', 'ordinario') == 'ordinario' ? 'checked' : '' }} required/>
                            <span class="text-sm font-medium text-slate-700 flex items-center gap-1">
                                <span class="material-symbols-outlined text-[18px]">mail</span> Ordinario
                            </span>
                        </label>
                        <label class="flex items-center gap-2.5 cursor-pointer bg-rose-50/40 hover:bg-rose-50/80 px-4 py-3 rounded-xl border border-rose-200/50 transition-all select-none">
                            <input type="radio" name="prioridad" value="urgente" class="w-4 h-4 text-rose-600 focus:ring-rose-500/30 border-rose-300 cursor-pointer" {{ old('prioridad') == 'urgente' ? 'checked' : '' }}/>
                            <span class="text-sm font-semibold text-rose-700 flex items-center gap-1">
                                <span class="material-symbols-outlined text-[18px]">priority_high</span> Urgente
                            </span>
                        </label>
                    </div>
                    @error('prioridad') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Fecha Límite de Entrega -->
                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-medium text-on-surface-variant">Fecha límite de entrega <span class="text-rose-500">*</span></label>
                    <input type="date" name="fecha_limite_entrega" value="{{ old('fecha_limite_entrega') }}" class="w-full px-4 py-2.5 bg-surface-lowest border @error('fecha_limite_entrega') border-rose-500 @else border-outline-variant @enderror rounded-lg focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 transition-all text-sm text-on-surface cursor-pointer" required>
                    @error('fecha_limite_entrega') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- Asunto -->
            <div class="flex flex-col gap-1.5 mt-2 relative z-10">
                <label class="text-sm font-medium text-on-surface-variant">Asunto / Resumen <span class="text-on-surface-variant/50 font-normal">(Opcional)</span></label>
                <textarea name="asunto" rows="2" class="w-full bg-surface-lowest border @error('asunto') border-rose-500 @else border-outline-variant @enderror rounded-lg px-4 py-2.5 text-sm text-on-surface placeholder:text-on-surface-variant/40 focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 resize-none transition-colors" placeholder="Describa brevemente el contenido del documento...">{{ old('asunto') }}</textarea>
                @error('asunto') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <!-- Acciones Formulario -->
        <div class="flex justify-end gap-3 pt-2">
            <button type="reset" class="px-6 py-3 bg-surface-variant/20 hover:bg-surface-variant/40 text-on-surface text-sm font-semibold rounded-lg transition-colors cursor-pointer focus:outline-none">
                Limpiar Formulario
            </button>
            <button type="submit" class="flex items-center justify-center gap-2 px-8 py-3 bg-primary hover:bg-primary/95 text-on-primary text-sm font-semibold rounded-lg transition-all shadow-sm hover:shadow active:scale-[0.98] cursor-pointer focus:outline-none">
                <span class="material-symbols-outlined text-[18px]">send</span>
                Registrar Salida
            </button>
        </div>
    </form>
</div>
@endsection
