@extends('layouts.app')

@section('title', 'Captura de Correspondencia de Entrada')

@section('content')
<div class="max-w-[1440px] mx-auto">
    <!-- Page Header -->
    <div class="mb-6 flex flex-col md:flex-row md:items-end justify-between gap-4">
        <div>
            <h2 class="font-headline-lg-mobile md:font-headline-lg text-2xl md:text-3xl font-bold text-slate-900 mb-1">Módulo de Captura de Entradas</h2>
            <p class="font-body-md text-sm text-slate-600">Registre un nuevo documento entrante en el sistema institucional.</p>
        </div>
        <div class="flex items-center gap-2 text-slate-500 font-label-sm text-xs font-medium">
            <span class="material-symbols-outlined" style="font-size: 16px;">calendar_today</span>
            <span>{{ now()->isoFormat('D \d\e MMMM, YYYY') }}</span>
        </div>
    </div>

    <!-- Form Container (Institutional Card) -->
    <div class="bg-white border border-slate-200 rounded-xl shadow-sm p-6 md:p-8">
        <form action="{{ route('entradas.store') }}" method="POST" class="space-y-8">
            @csrf
            
            <input type="hidden" name="tipo" value="entrada">

            <!-- Section: Información del Destino (Interno) -->
            <div>
                <h3 class="font-headline-sm text-lg font-semibold text-slate-800 border-b border-slate-100 pb-2 mb-4 flex items-center gap-2">
                    <span class="material-symbols-outlined text-slate-400">domain</span>
                    Destino Interno
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Fecha de Registro -->
                    <div class="flex flex-col gap-1.5">
                        <label class="text-sm font-medium text-slate-600" for="fecha_registro">Fecha y Hora de Registro</label>
                        <input class="px-3 py-2 bg-slate-50 border @error('fecha_registro') border-red-500 @else border-slate-200 @enderror rounded-md focus:outline-none focus:ring-2 focus:ring-blue-50 focus:border-blue-600 transition-colors text-sm text-slate-800" 
                            id="fecha_registro" name="fecha_registro" type="datetime-local" value="{{ old('fecha_registro', now()->format('Y-m-d\TH:i')) }}" required/>
                        @error('fecha_registro') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Nombre Destinatario -->
                    <div class="flex flex-col gap-1.5">
                        <label class="text-sm font-medium text-slate-600" for="nombre_destinatario">Nombre del Destinatario</label>
                        <input class="px-3 py-2 bg-white border @error('nombre_destinatario') border-red-500 @else border-slate-200 @enderror rounded-md focus:outline-none focus:ring-2 focus:ring-blue-50 focus:border-blue-600 transition-colors text-sm text-slate-800 placeholder-slate-400" 
                            id="nombre_destinatario" name="nombre_destinatario" type="text" value="{{ old('nombre_destinatario') }}" maxlength="30" placeholder="Ej. Juan Pérez" required/>
                        @error('nombre_destinatario') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Área -->
                    <div class="flex flex-col gap-1.5">
                        <label class="text-sm font-medium text-slate-600" for="area_id">Área de Destino</label>
                        <select class="px-3 py-2 bg-white border @error('area_id') border-red-500 @else border-slate-200 @enderror rounded-md focus:outline-none focus:ring-2 focus:ring-blue-50 focus:border-blue-600 transition-colors text-sm text-slate-800" 
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
                        <label class="text-sm font-medium text-slate-600" for="puesto_id">Puesto del Destinatario</label>
                        <select class="px-3 py-2 bg-white border @error('puesto_id') border-red-500 @else border-slate-200 @enderror rounded-md focus:outline-none focus:ring-2 focus:ring-blue-50 focus:border-blue-600 transition-colors text-sm text-slate-800" 
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
                <h3 class="font-headline-sm text-lg font-semibold text-slate-800 border-b border-slate-100 pb-2 mb-4 flex items-center gap-2">
                    <span class="material-symbols-outlined text-slate-400">person</span>
                    Información del Origen
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Nombre Remitente -->
                    <div class="flex flex-col gap-1.5">
                        <label class="text-sm font-medium text-slate-600" for="nombre_remitente">Nombre del Remitente</label>
                        <input class="px-3 py-2 bg-white border @error('nombre_remitente') border-red-500 @else border-slate-200 @enderror rounded-md focus:outline-none focus:ring-2 focus:ring-blue-50 focus:border-blue-600 transition-colors text-sm text-slate-800 placeholder-slate-400" 
                            id="nombre_remitente" name="nombre_remitente" type="text" value="{{ old('nombre_remitente') }}" maxlength="30" placeholder="Ej. María Gómez" required/>
                        @error('nombre_remitente') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    <!-- Cargo Remitente -->
                    <div class="flex flex-col gap-1.5">
                        <label class="text-sm font-medium text-slate-600" for="cargo_remitente">Cargo del Remitente</label>
                        <input class="px-3 py-2 bg-white border @error('cargo_remitente') border-red-500 @else border-slate-200 @enderror rounded-md focus:outline-none focus:ring-2 focus:ring-blue-50 focus:border-blue-600 transition-colors text-sm text-slate-800 placeholder-slate-400" 
                            id="cargo_remitente" name="cargo_remitente" type="text" value="{{ old('cargo_remitente') }}" placeholder="Ej. Director General" required/>
                        @error('cargo_remitente') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Institución -->
                    <div class="flex flex-col gap-1.5">
                        <label class="text-sm font-medium text-slate-600" for="institucion">Institución o Dependencia</label>
                        <input class="px-3 py-2 bg-white border @error('institucion') border-red-500 @else border-slate-200 @enderror rounded-md focus:outline-none focus:ring-2 focus:ring-blue-50 focus:border-blue-600 transition-colors text-sm text-slate-800 placeholder-slate-400" 
                            id="institucion" name="institucion" type="text" value="{{ old('institucion') }}" placeholder="Ej. Secretaría de Educación" required/>
                        @error('institucion') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <!-- Section: Detalles del Documento -->
            <div>
                <h3 class="font-headline-sm text-lg font-semibold text-slate-800 border-b border-slate-100 pb-2 mb-4 flex items-center gap-2">
                    <span class="material-symbols-outlined text-slate-400">description</span>
                    Detalles del Documento
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Tipo de Documento -->
                    <div class="flex flex-col gap-1.5">
                        <label class="text-sm font-medium text-slate-600" for="tipo_documento">Tipo de Documento</label>
                        <select class="px-3 py-2 bg-white border @error('tipo_documento') border-red-500 @else border-slate-200 @enderror rounded-md focus:outline-none focus:ring-2 focus:ring-blue-50 focus:border-blue-600 transition-colors text-sm text-slate-800" 
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
                        <label class="text-sm font-medium text-slate-600" for="numero_fojas">Número de Fojas</label>
                        <input class="px-3 py-2 bg-white border @error('numero_fojas') border-red-500 @else border-slate-200 @enderror rounded-md focus:outline-none focus:ring-2 focus:ring-blue-50 focus:border-blue-600 transition-colors text-sm text-slate-800" 
                            id="numero_fojas" name="numero_fojas" type="number" min="1" value="{{ old('numero_fojas') }}" placeholder="Cantidad de hojas" required/>
                        @error('numero_fojas') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Nivel de Prioridad -->
                    <div class="flex flex-col gap-1.5 md:col-span-2">
                        <label class="text-sm font-medium text-slate-600">Nivel de Prioridad</label>
                        <div class="flex flex-wrap gap-4 mt-2">
                            <label class="flex items-center gap-2 cursor-pointer bg-slate-50 px-3 py-2 rounded-md border border-slate-200 hover:bg-slate-100 transition-colors">
                                <input type="radio" name="prioridad" value="ordinaria" class="text-blue-600 focus:ring-blue-600" {{ old('prioridad', 'ordinaria') == 'ordinaria' ? 'checked' : '' }} required/>
                                <span class="text-sm text-slate-700">Ordinaria</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer bg-amber-50 px-3 py-2 rounded-md border border-amber-200 hover:bg-amber-100 transition-colors">
                                <input type="radio" name="prioridad" value="urgente" class="text-amber-600 focus:ring-amber-600" {{ old('prioridad') == 'urgente' ? 'checked' : '' }}/>
                                <span class="text-sm text-amber-700 flex items-center gap-1"><span class="material-symbols-outlined text-[16px]">priority_high</span> Urgente</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer bg-red-50 px-3 py-2 rounded-md border border-red-200 hover:bg-red-100 transition-colors">
                                <input type="radio" name="prioridad" value="confidencial" class="text-red-600 focus:ring-red-600" {{ old('prioridad') == 'confidencial' ? 'checked' : '' }}/>
                                <span class="text-sm text-red-700 flex items-center gap-1"><span class="material-symbols-outlined text-[16px]">lock</span> Confidencial</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer bg-blue-50 px-3 py-2 rounded-md border border-blue-200 hover:bg-blue-100 transition-colors">
                                <input type="radio" name="prioridad" value="con valores" class="text-blue-600 focus:ring-blue-600" {{ old('prioridad') == 'con valores' ? 'checked' : '' }}/>
                                <span class="text-sm text-blue-700 flex items-center gap-1"><span class="material-symbols-outlined text-[16px]">diamond</span> Con Valores</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer bg-orange-50 px-3 py-2 rounded-md border border-orange-200 hover:bg-orange-100 transition-colors">
                                <input type="radio" name="prioridad" value="con riesgos" class="text-orange-600 focus:ring-orange-600" {{ old('prioridad') == 'con riesgos' ? 'checked' : '' }}/>
                                <span class="text-sm text-orange-700 flex items-center gap-1"><span class="material-symbols-outlined text-[16px]">warning</span> Con Riesgos</span>
                            </label>
                        </div>
                        @error('prioridad') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Asunto -->
                    <div class="flex flex-col gap-1.5 md:col-span-2">
                        <label class="text-sm font-medium text-slate-600" for="asunto">Asunto</label>
                        <textarea class="px-3 py-2 bg-white border @error('asunto') border-red-500 @else border-slate-200 @enderror rounded-md focus:outline-none focus:ring-2 focus:ring-blue-50 focus:border-blue-600 transition-colors text-sm text-slate-800 placeholder-slate-400 resize-y" 
                            id="asunto" name="asunto" rows="3" placeholder="Describa brevemente el asunto del documento..." required>{{ old('asunto') }}</textarea>
                        @error('asunto') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Anexos -->
                    <div class="flex flex-col gap-1.5 md:col-span-2">
                        <label class="text-sm font-medium text-slate-600" for="anexos">Anexos <span class="text-slate-400 font-normal">(Opcional)</span></label>
                        <textarea class="px-3 py-2 bg-white border @error('anexos') border-red-500 @else border-slate-200 @enderror rounded-md focus:outline-none focus:ring-2 focus:ring-blue-50 focus:border-blue-600 transition-colors text-sm text-slate-800 placeholder-slate-400 resize-y" 
                            id="anexos" name="anexos" rows="2" placeholder="Describa los anexos incluidos (ej. 1 CD, 2 folders, etc.)">{{ old('anexos') }}</textarea>
                        @error('anexos') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="pt-6 border-t border-slate-100 flex flex-col-reverse md:flex-row justify-end gap-3">
                <button type="reset" class="px-6 py-2.5 bg-white border border-slate-200 text-slate-700 font-medium text-sm rounded-md hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-slate-200 transition-colors">
                    Limpiar Formulario
                </button>
                <button type="submit" class="px-6 py-2.5 bg-secondary hover:bg-blue-800 text-white font-medium text-sm rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600 focus:ring-offset-2 transition-colors flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">save</span>
                    Registrar Entrada
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
