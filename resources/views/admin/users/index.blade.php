@extends('layouts.app')

@section('title', 'Gestión de Usuarios')

@section('content')
<div class="flex justify-between items-end mb-stack-lg">
    <div>
        <h2 class="font-headline-lg text-headline-lg text-slate-900 mb-1">Gestión de Usuarios</h2>
        <p class="font-body-md text-body-md text-slate-600">Administra el acceso, roles y estados de los usuarios en la plataforma.</p>
    </div>
</div>

<!-- Formulario para Registrar Nuevo Usuario -->
<div class="bg-white rounded-xl border border-slate-200/80 shadow-sm mb-6 flex flex-col">
    <div class="p-4 border-b border-slate-100 bg-slate-50/50">
        <h3 class="font-headline-sm text-lg text-slate-800 font-semibold flex items-center gap-2">
            <span class="material-symbols-outlined text-secondary">person_add</span>
            Registrar Nuevo Usuario
        </h3>
    </div>
    <div class="p-5">
        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5 mb-5">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Nombre</label>
                    <input type="text" name="nombre" value="{{ old('nombre') }}" maxlength="20" required class="w-full px-4 py-2 border @error('nombre') border-red-500 @else border-slate-300 @enderror rounded-lg text-sm focus:border-blue-600 focus:ring-1 focus:ring-blue-50 outline-none transition-colors" placeholder="Ej. Juan">
                    @error('nombre') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Apellido Paterno</label>
                    <input type="text" name="apellido_paterno" value="{{ old('apellido_paterno') }}" maxlength="10" required class="w-full px-4 py-2 border @error('apellido_paterno') border-red-500 @else border-slate-300 @enderror rounded-lg text-sm focus:border-blue-600 focus:ring-1 focus:ring-blue-50 outline-none transition-colors" placeholder="Ej. Pérez">
                    @error('apellido_paterno') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Apellido Materno <span class="text-slate-400 font-normal">(Opcional)</span></label>
                    <input type="text" name="apellido_materno" value="{{ old('apellido_materno') }}" maxlength="10" class="w-full px-4 py-2 border @error('apellido_materno') border-red-500 @else border-slate-300 @enderror rounded-lg text-sm focus:border-blue-600 focus:ring-1 focus:ring-blue-50 outline-none transition-colors" placeholder="Ej. López">
                    @error('apellido_materno') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Correo Institucional</label>
                    <input type="email" name="email" value="{{ old('email') }}" required class="w-full px-4 py-2 border @error('email') border-red-500 @else border-slate-300 @enderror rounded-lg text-sm focus:border-blue-600 focus:ring-1 focus:ring-blue-50 outline-none transition-colors" placeholder="usuario@ucc.gov">
                    @error('email') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Contraseña</label>
                    <input type="password" name="password" minlength="8" required class="w-full px-4 py-2 border @error('password') border-red-500 @else border-slate-300 @enderror rounded-lg text-sm focus:border-blue-600 focus:ring-1 focus:ring-blue-50 outline-none transition-colors" placeholder="Mínimo 8 caracteres">
                    @error('password') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Rol en el Sistema</label>
                    <select name="role_id" required class="w-full px-4 py-2 border @error('role_id') border-red-500 @else border-slate-300 @enderror rounded-lg text-sm focus:border-blue-600 focus:ring-1 focus:ring-blue-50 outline-none bg-white transition-colors">
                        <option value="">Selecciona un rol...</option>
                        @foreach($roles ?? [] as $role)
                            <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>{{ $role->nombre ?? $role->name }}</option>
                        @endforeach
                    </select>
                    @error('role_id') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Área de Trabajo</label>
                    <select name="area_id" required class="w-full px-4 py-2 border @error('area_id') border-red-500 @else border-slate-300 @enderror rounded-lg text-sm focus:border-blue-600 focus:ring-1 focus:ring-blue-50 outline-none bg-white transition-colors">
                        <option value="">Selecciona un área...</option>
                        @foreach($areas ?? [] as $area)
                            <option value="{{ $area->id }}" {{ old('area_id') == $area->id ? 'selected' : '' }}>{{ $area->nombre }}</option>
                        @endforeach
                    </select>
                    @error('area_id') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="flex justify-end pt-2 border-t border-slate-100">
                <button type="submit" class="bg-primary text-on-primary px-5 py-2.5 rounded-lg font-label-sm text-sm font-medium flex items-center space-x-2 hover:bg-primary-container transition-colors shadow-sm">
                    <span class="material-symbols-outlined text-[18px]">add_circle</span>
                    <span>Guardar Usuario</span>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Table Container -->
<div class="bg-white rounded-xl border border-slate-200/80 shadow-sm overflow-hidden flex flex-col">
    <div class="p-4 border-b border-slate-100 flex justify-between items-center bg-white">
        <div class="relative w-72">
            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-[18px]">search</span>
            <input class="w-full pl-9 pr-4 py-2 border border-slate-300 rounded-lg text-sm focus:border-blue-600 focus:ring-1 focus:ring-blue-50 outline-none transition-colors" placeholder="Filtrar usuarios..." type="text"/>
        </div>
        <button class="text-slate-500 hover:text-slate-700 flex items-center space-x-1 border border-slate-300 px-3 py-1.5 rounded-lg text-sm bg-white transition-colors">
            <span class="material-symbols-outlined text-[18px]">filter_list</span>
            <span>Filtrar</span>
        </button>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-slate-50 border-b border-slate-200">
                <tr>
                    <th class="px-4 py-3 font-label-caps text-[11px] text-slate-500 uppercase tracking-wider font-semibold">Detalles del Usuario</th>
                    <th class="px-4 py-3 font-label-caps text-[11px] text-slate-500 uppercase tracking-wider font-semibold">Rol y Área</th>
                    <th class="px-4 py-3 font-label-caps text-[11px] text-slate-500 uppercase tracking-wider font-semibold">Estado</th>
                    <th class="px-4 py-3 font-label-caps text-[11px] text-slate-500 uppercase tracking-wider font-semibold text-right">Acciones</th>
                </tr>
            </thead>
            <tbody class="font-body-md text-sm text-slate-700">
                @forelse($users ?? [] as $user)
                <tr class="border-b border-slate-100 hover:bg-slate-50/80 transition-colors group">
                    <td class="px-4 py-3">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center font-headline-sm text-[14px] font-bold">
                                {{ strtoupper(substr($user->nombre, 0, 1) . substr($user->apellido_paterno, 0, 1)) }}
                            </div>
                            <div>
                                <p class="font-semibold text-slate-900">{{ $user->nombre }} {{ $user->apellido_paterno }} {{ $user->apellido_materno }}</p>
                                <p class="text-[13px] text-slate-500">{{ $user->email }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-4 py-3">
                        <p class="font-medium text-slate-800">{{ $user->role->nombre ?? 'Sin Rol' }}</p>
                        <p class="text-[12px] text-slate-500">{{ $user->area->nombre ?? 'N/A' }}</p>
                    </td>
                    <td class="px-4 py-3">
                        @if($user->estado == 'activo')
                            <span class="inline-flex items-center px-2 py-1 rounded-md text-[11px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200/50">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1.5"></span> Activo
                            </span>
                        @else
                            <span class="inline-flex items-center px-2 py-1 rounded-md text-[11px] font-semibold bg-rose-50 text-rose-700 border border-rose-200/50">
                                <span class="w-1.5 h-1.5 rounded-full bg-rose-500 mr-1.5"></span> Inactivo
                            </span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-right">
                        <div class="flex items-center justify-end space-x-2">
                            <button class="text-slate-400 hover:text-blue-600 p-1 rounded transition-colors" title="Editar">
                                <span class="material-symbols-outlined text-[20px]">edit</span>
                            </button>
                            
                            <!-- Formulario para Activar / Desactivar (Soft Delete) -->
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline m-0 p-0">
                                @csrf
                                @method('DELETE')
                                <label class="relative inline-flex items-center cursor-pointer ml-2" title="{{ $user->estado == 'activo' ? 'Bloquear / Desactivar' : 'Activar' }}">
                                    <!-- El checkbox hace submit al cambiar su valor -->
                                    <input type="checkbox" class="sr-only peer" onchange="this.form.submit()" {{ $user->estado == 'activo' ? 'checked' : '' }}>
                                    <div class="w-9 h-5 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-blue-600"></div>
                                </label>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-4 py-8 text-center text-slate-500">
                        No hay usuarios registrados en el sistema.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <!-- Paginación -->
    @if(isset($users) && method_exists($users, 'links'))
    <div class="p-4 border-t border-slate-100 flex items-center justify-between text-sm text-slate-500 bg-slate-50/50">
        {{ $users->links() }}
    </div>
    @endif
</div>
@endsection
