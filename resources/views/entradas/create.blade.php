@extends('layouts.app')

@section('title', 'Captura de Correspondencia de Entrada')

@section('content')
<div class="max-w-[1440px] mx-auto">
    <!-- Page Header -->
    <div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="font-headline-lg text-2xl md:text-3xl font-bold text-on-surface mb-1 flex items-center gap-2">
                <span class="material-symbols-outlined text-primary text-[32px]">edit_note</span>
                Módulo de Captura de Entradas
            </h2>
            <p class="font-body-md text-sm text-on-surface-variant">Registre un nuevo documento entrante en el sistema institucional.</p>
        </div>
        <div class="flex items-center gap-2 bg-primary/10 text-primary px-4 py-1.5 rounded-full font-label-sm text-xs font-semibold w-max">
            <span class="material-symbols-outlined text-sm" style="font-size: 16px;">calendar_today</span>
            <span>{{ now()->isoFormat('D \d\e MMMM, YYYY') }}</span>
        </div>
    </div>

    <!-- Form Container (Institutional Card) -->
    <div class="bg-surface-lowest border border-outline-variant rounded-2xl shadow-sm p-6 md:p-10 transition-shadow hover:shadow-md">
        <form action="{{ route('entradas.store') }}" method="POST" class="space-y-10">
            @csrf
            
            <input type="hidden" name="tipo" value="entrada">

            <!-- Section: Información del Destino (Interno) -->
            <div>
                <h3 class="font-headline-sm text-lg font-bold text-on-surface mb-6 border-l-4 border-primary pl-3">
                    Destino Interno
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Fecha de Registro -->
                    <div class="flex flex-col gap-1.5">
                        <label class="text-sm font-medium text-on-surface-variant" for="fecha_registro">Fecha y Hora de Registro</label>
                        <input class="px-4 py-2.5 bg-surface-variant/20 border @error('fecha_registro') border-error @else border-outline-variant @enderror rounded-lg focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 transition-all text-sm text-on-surface" 
                            id="fecha_registro" name="fecha_registro" type="datetime-local" value="{{ old('fecha_registro', now()->format('Y-m-d\TH:i')) }}" required/>
                        @error('fecha_registro') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Nombre Destinatario -->
                    <div class="flex flex-col gap-1.5">
                        <label class="text-sm font-medium text-on-surface-variant" for="nombre_destinatario">Nombre del Destinatario</label>
                        <input class="px-4 py-2.5 bg-surface-lowest border @error('nombre_destinatario') border-error @else border-outline-variant @enderror rounded-lg focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 transition-all text-sm text-on-surface placeholder-on-surface-variant/40" 
                            id="nombre_destinatario" name="nombre_destinatario" type="text" value="{{ old('nombre_destinatario') }}" maxlength="30" placeholder="Ej. Juan Pérez" required/>
                        @error('nombre_destinatario') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Área -->
                    <div class="flex flex-col gap-1.5">
                        <label class="text-sm font-medium text-on-surface-variant" for="area_id">Área de Destino</label>
                        <select class="px-4 py-2.5 bg-surface-lowest border @error('area_id') border-error @else border-outline-variant @enderror rounded-lg focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 transition-all text-sm text-on-surface" 
                            id="area_id" name="area_id" required>
                            <option value="" disabled selected>Seleccione área...</option>
                            @foreach($areas ?? [] as $area)
                                <option value="{{ $area->id }}" {{ old('area_id') == $area->id ? 'selected' : '' }}>{{ $area->nombre }}</option>
                            @endforeach
                        </select>
                        @error('area_id') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Puesto -->
                    <div class="flex flex-col gap-1.5">
                        <label class="text-sm font-medium text-on-surface-variant" for="puesto_id">Puesto del Destinatario</label>
                        <select class="px-4 py-2.5 bg-surface-lowest border @error('puesto_id') border-error @else border-outline-variant @enderror rounded-lg focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 transition-all text-sm text-on-surface" 
                            id="puesto_id" name="puesto_id" required>
                            <option value="" disabled selected>Seleccione puesto...</option>
                            @foreach($puestos ?? [] as $puesto)
                                <option value="{{ $puesto->id }}" {{ old('puesto_id') == $puesto->id ? 'selected' : '' }}>{{ $puesto->nombre }}</option>
                            @endforeach
                        </select>
                        @error('puesto_id') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <!-- Section: Información del Remitente -->
            <div>
                <h3 class="font-headline-sm text-lg font-bold text-on-surface mb-6 border-l-4 border-primary pl-3">
                    Información del Origen
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Nombre Remitente -->
                    <div class="flex flex-col gap-1.5">
                        <label class="text-sm font-medium text-on-surface-variant" for="nombre_remitente">Nombre del Remitente</label>
                        <input class="px-4 py-2.5 bg-surface-lowest border @error('nombre_remitente') border-error @else border-outline-variant @enderror rounded-lg focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 transition-all text-sm text-on-surface placeholder-on-surface-variant/40" 
                            id="nombre_remitente" name="nombre_remitente" type="text" value="{{ old('nombre_remitente') }}" maxlength="30" placeholder="Ej. María Gómez" required/>
                        @error('nombre_remitente') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    <!-- Cargo Remitente -->
                    <div class="flex flex-col gap-1.5">
                        <label class="text-sm font-medium text-on-surface-variant" for="cargo_remitente">Cargo del Remitente</label>
                        <input class="px-4 py-2.5 bg-surface-lowest border @error('cargo_remitente') border-error @else border-outline-variant @enderror rounded-lg focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 transition-all text-sm text-on-surface placeholder-on-surface-variant/40" 
                            id="cargo_remitente" name="cargo_remitente" type="text" value="{{ old('cargo_remitente') }}" placeholder="Ej. Director General" required/>
                        @error('cargo_remitente') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Institución -->
                    <div class="flex flex-col gap-1.5">
                        <label class="text-sm font-medium text-on-surface-variant" for="institucion">Institución o Dependencia</label>
                        <input class="px-4 py-2.5 bg-surface-lowest border @error('institucion') border-error @else border-outline-variant @enderror rounded-lg focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 transition-all text-sm text-on-surface placeholder-on-surface-variant/40" 
                            id="institucion" name="institucion" type="text" value="{{ old('institucion') }}" placeholder="Ej. Secretaría de Educación" required/>
                        @error('institucion') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <!-- Section: Detalles del Documento -->
            <div>
                <h3 class="font-headline-sm text-lg font-bold text-on-surface mb-6 border-l-4 border-primary pl-3">
                    Detalles del Documento
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Tipo de Documento -->
                    <div class="flex flex-col gap-1.5">
                        <label class="text-sm font-medium text-on-surface-variant" for="tipo_documento">Tipo de Documento</label>
                        <select class="px-4 py-2.5 bg-surface-lowest border @error('tipo_documento') border-error @else border-outline-variant @enderror rounded-lg focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 transition-all text-sm text-on-surface" 
                            id="tipo_documento" name="tipo_documento" required>
                            <option value="" disabled selected>Seleccione tipo...</option>
                            <option value="Oficio" {{ old('tipo_documento') == 'Oficio' ? 'selected' : '' }}>Oficio</option>
                            <option value="Solicitud" {{ old('tipo_documento') == 'Solicitud' ? 'selected' : '' }}>Solicitud</option>
                            <option value="Recurso" {{ old('tipo_documento') == 'Recurso' ? 'selected' : '' }}>Recurso</option>
                            <option value="Circular" {{ old('tipo_documento') == 'Circular' ? 'selected' : '' }}>Circular</option>
                            <option value="Memorándum" {{ old('tipo_documento') == 'Memorándum' ? 'selected' : '' }}>Memorándum</option>
                            <option value="Informe" {{ old('tipo_documento') == 'Informe' ? 'selected' : '' }}>Informe</option>
                            <option value="Otro" {{ old('tipo_documento') == 'Otro' ? 'selected' : '' }}>Otro</option>
                        </select>
                        @error('tipo_documento') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Número de Fojas -->
                    <div class="flex flex-col gap-1.5">
                        <label class="text-sm font-medium text-on-surface-variant" for="numero_fojas">Número de Fojas</label>
                        <input class="px-4 py-2.5 bg-surface-lowest border @error('numero_fojas') border-error @else border-outline-variant @enderror rounded-lg focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 transition-all text-sm text-on-surface placeholder-on-surface-variant/40" 
                            id="numero_fojas" name="numero_fojas" type="number" min="1" value="{{ old('numero_fojas') }}" placeholder="Cantidad de hojas" required/>
                        @error('numero_fojas') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Nivel de Prioridad -->
                    <div class="flex flex-col gap-1.5 md:col-span-2">
                        <label class="text-sm font-medium text-on-surface-variant">Nivel de Prioridad</label>
                        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3 mt-2">
                            <label class="flex items-center gap-2.5 cursor-pointer bg-slate-50/50 hover:bg-slate-100/60 px-4 py-3 rounded-xl border border-slate-200 transition-all">
                                <input type="radio" name="prioridad" value="ordinaria" class="w-4 h-4 text-primary focus:ring-primary/30 border-slate-300" {{ old('prioridad', 'ordinaria') == 'ordinaria' ? 'checked' : '' }} required/>
                                <span class="text-sm font-medium text-slate-700">Ordinaria</span>
                            </label>
                            <label class="flex items-center gap-2.5 cursor-pointer bg-rose-50/40 hover:bg-rose-50/80 px-4 py-3 rounded-xl border border-rose-200/50 transition-all">
                                <input type="radio" name="prioridad" value="urgente" class="w-4 h-4 text-rose-600 focus:ring-rose-500/30 border-rose-300" {{ old('prioridad') == 'urgente' ? 'checked' : '' }}/>
                                <span class="text-sm font-semibold text-rose-700 flex items-center gap-1"><span class="material-symbols-outlined text-[18px]">priority_high</span> Urgente</span>
                            </label>
                            <label class="flex items-center gap-2.5 cursor-pointer bg-amber-50/40 hover:bg-amber-50/80 px-4 py-3 rounded-xl border border-amber-200/50 transition-all">
                                <input type="radio" name="prioridad" value="confidencial" class="w-4 h-4 text-amber-600 focus:ring-amber-500/30 border-amber-300" {{ old('prioridad') == 'confidencial' ? 'checked' : '' }}/>
                                <span class="text-sm font-semibold text-amber-700 flex items-center gap-1"><span class="material-symbols-outlined text-[18px]">lock</span> Confidencial</span>
                            </label>
                            <label class="flex items-center gap-2.5 cursor-pointer bg-blue-50/40 hover:bg-blue-50/80 px-4 py-3 rounded-xl border border-blue-200/50 transition-all">
                                <input type="radio" name="prioridad" value="con valores" class="w-4 h-4 text-blue-600 focus:ring-blue-500/30 border-blue-300" {{ old('prioridad') == 'con valores' ? 'checked' : '' }}/>
                                <span class="text-sm font-semibold text-blue-700 flex items-center gap-1"><span class="material-symbols-outlined text-[18px]">diamond</span> Valores</span>
                            </label>
                            <label class="flex items-center gap-2.5 cursor-pointer bg-orange-50/40 hover:bg-orange-50/80 px-4 py-3 rounded-xl border border-orange-200/50 transition-all col-span-2 sm:col-span-1">
                                <input type="radio" name="prioridad" value="con riesgos" class="w-4 h-4 text-orange-600 focus:ring-orange-500/30 border-orange-300" {{ old('prioridad') == 'con riesgos' ? 'checked' : '' }}/>
                                <span class="text-sm font-semibold text-orange-700 flex items-center gap-1"><span class="material-symbols-outlined text-[18px]">warning</span> Riesgos</span>
                            </label>
                        </div>
                        @error('prioridad') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Asunto -->
                    <div class="flex flex-col gap-1.5 md:col-span-2">
                        <label class="text-sm font-medium text-on-surface-variant" for="asunto">Asunto</label>
                        <textarea class="px-4 py-3 bg-surface-lowest border @error('asunto') border-error @else border-outline-variant @enderror rounded-lg focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 transition-all text-sm text-on-surface placeholder-on-surface-variant/40 resize-y" 
                            id="asunto" name="asunto" rows="3" placeholder="Describa brevemente el asunto del documento..." required>{{ old('asunto') }}</textarea>
                        @error('asunto') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Anexos -->
                    <div class="flex flex-col gap-1.5 md:col-span-2">
                        <label class="text-sm font-medium text-on-surface-variant" for="anexos">Anexos <span class="text-on-surface-variant/50 font-normal">(Opcional)</span></label>
                        <textarea class="px-4 py-3 bg-surface-lowest border @error('anexos') border-error @else border-outline-variant @enderror rounded-lg focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 transition-all text-sm text-on-surface placeholder-on-surface-variant/40 resize-y" 
                            id="anexos" name="anexos" rows="2" placeholder="Describa los anexos incluidos (ej. 1 CD, 2 folders, etc.)">{{ old('anexos') }}</textarea>
                        @error('anexos') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="pt-6 border-t border-outline-variant flex flex-col-reverse md:flex-row justify-end gap-3">
                <button type="reset" class="px-6 py-3 bg-surface-variant/20 hover:bg-surface-variant/40 text-on-surface font-medium text-sm rounded-lg transition-colors cursor-pointer focus:outline-none">
                    Limpiar Formulario
                </button>
                <button type="submit" class="px-6 py-3 bg-primary hover:bg-primary/95 text-on-primary font-medium text-sm rounded-lg shadow-sm hover:shadow transition-all flex items-center justify-center gap-2 cursor-pointer focus:outline-none">
                    <span class="material-symbols-outlined text-[18px]">save</span>
                    Registrar Entrada
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
