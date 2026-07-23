@extends('layouts.app')

@section('title', 'Gestión de Usuarios')

@section('content')
<div class="max-w-container-max mx-auto space-y-6">
    <!-- Session Success Alert -->
    @if(session('success'))
    <div id="successAlert" class="p-4 mb-6 text-sm text-emerald-800 bg-emerald-50 rounded-lg border border-emerald-200/50 flex items-center gap-2 transition-all duration-500 transform translate-y-0 opacity-100" role="alert">
        <span class="material-symbols-outlined text-emerald-500 text-[20px]">check_circle</span>
        <span class="font-medium">{{ session('success') }}</span>
    </div>
    @endif

    <!-- Page Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="font-headline-lg-mobile md:font-headline-lg text-headline-lg-mobile md:text-headline-lg text-on-surface mb-1 flex items-center gap-2">
                <span class="material-symbols-outlined text-primary text-3xl" style="font-size: 32px;">group</span>
                Gestión de Usuarios
            </h1>
            <p class="font-body-md text-body-md text-on-surface-variant">Administra los accesos, roles y departamentos del personal en la plataforma.</p>
        </div>
    </div>

    <!-- Formulario para Registrar Nuevo Usuario -->
    <div class="bg-surface-lowest rounded-xl border border-outline-variant shadow-sm transition-all hover:shadow-md flex flex-col overflow-hidden">
        <div class="px-6 py-4 border-b border-outline-variant bg-gradient-to-r from-surface-variant/30 to-surface-variant/5">
            <h3 class="font-headline-sm text-headline-sm text-on-surface font-semibold flex items-center gap-2">
                <span class="material-symbols-outlined text-primary" style="font-size: 22px;">person_add</span>
                Registrar Nuevo Usuario
            </h3>
        </div>
        <div class="p-6">
            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5 mb-6">
                    <div>
                        <label class="block font-label-sm text-label-sm text-on-surface-variant mb-1.5" for="nombre">Nombre</label>
                        <input type="text" id="nombre" name="nombre" value="{{ old('nombre') }}" maxlength="20" required class="w-full px-4 py-2.5 border @error('nombre') border-error @else border-outline-variant @enderror rounded-lg text-body-md text-on-surface bg-surface-lowest placeholder-on-surface-variant/40 focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 transition-all" placeholder="Ej. Juan">
                        @error('nombre') <span class="text-xs text-error mt-1 block font-medium">{{ $message }}</span> @enderror
                    </div>
                    
                    <div>
                        <label class="block font-label-sm text-label-sm text-on-surface-variant mb-1.5" for="apellido_paterno">Primer Apellido</label>
                        <input type="text" id="apellido_paterno" name="apellido_paterno" value="{{ old('apellido_paterno') }}" maxlength="10" required class="w-full px-4 py-2.5 border @error('apellido_paterno') border-error @else border-outline-variant @enderror rounded-lg text-body-md text-on-surface bg-surface-lowest placeholder-on-surface-variant/40 focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 transition-all" placeholder="Ej. Pérez">
                        @error('apellido_paterno') <span class="text-xs text-error mt-1 block font-medium">{{ $message }}</span> @enderror
                    </div>
                    
                    <div>
                        <label class="block font-label-sm text-label-sm text-on-surface-variant mb-1.5" for="apellido_materno">Segundo Apellido <span class="text-on-surface-variant/50 font-normal">(Opcional)</span></label>
                        <input type="text" id="apellido_materno" name="apellido_materno" value="{{ old('apellido_materno') }}" maxlength="10" class="w-full px-4 py-2.5 border @error('apellido_materno') border-error @else border-outline-variant @enderror rounded-lg text-body-md text-on-surface bg-surface-lowest placeholder-on-surface-variant/40 focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 transition-all" placeholder="Ej. López">
                        @error('apellido_materno') <span class="text-xs text-error mt-1 block font-medium">{{ $message }}</span> @enderror
                    </div>
                    
                    <div>
                        <label class="block font-label-sm text-label-sm text-on-surface-variant mb-1.5" for="email">Correo Institucional</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required class="w-full px-4 py-2.5 border @error('email') border-error @else border-outline-variant @enderror rounded-lg text-body-md text-on-surface bg-surface-lowest placeholder-on-surface-variant/40 focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 transition-all" placeholder="usuario@ucc.gov">
                        @error('email') <span class="text-xs text-error mt-1 block font-medium">{{ $message }}</span> @enderror
                    </div>
                    
                    <div>
                        <label class="block font-label-sm text-label-sm text-on-surface-variant mb-1.5" for="password">Contraseña</label>
                        <div class="relative">
                            <input type="password" id="password" name="password" minlength="8" required class="w-full pl-4 pr-10 py-2.5 border @error('password') border-error @else border-outline-variant @enderror rounded-lg text-body-md text-on-surface bg-surface-lowest placeholder-on-surface-variant/40 focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 transition-all" placeholder="Mínimo 8 caracteres">
                            <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 pr-3 flex items-center text-on-surface-variant hover:text-on-surface focus:outline-none transition-colors" aria-label="Mostrar u ocultar contraseña">
                                <span class="material-symbols-outlined text-xl select-none" id="togglePasswordIcon">visibility</span>
                            </button>
                        </div>
                        @error('password') <span class="text-xs text-error mt-1 block font-medium">{{ $message }}</span> @enderror
                    </div>
                    
                    <div>
                        <label class="block font-label-sm text-label-sm text-on-surface-variant mb-1.5" for="role_id">Rol en el Sistema</label>
                        <select id="role_id" name="role_id" required class="w-full px-4 py-2.5 border @error('role_id') border-error @else border-outline-variant @enderror rounded-lg text-body-md text-on-surface bg-surface-lowest focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 transition-all">
                            <option value="">Selecciona un rol...</option>
                            @foreach($roles ?? [] as $role)
                                <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>{{ $role->nombre ?? $role->name }}</option>
                            @endforeach
                        </select>
                        @error('role_id') <span class="text-xs text-error mt-1 block font-medium">{{ $message }}</span> @enderror
                    </div>
                    
                    <div>
                        <label class="block font-label-sm text-label-sm text-on-surface-variant mb-1.5" for="area_id">Área de Trabajo</label>
                        <select id="area_id" name="area_id" required class="w-full px-4 py-2.5 border @error('area_id') border-error @else border-outline-variant @enderror rounded-lg text-body-md text-on-surface bg-surface-lowest focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 transition-all">
                            <option value="">Selecciona un área...</option>
                            @foreach($areas ?? [] as $area)
                                <option value="{{ $area->id }}" {{ old('area_id') == $area->id ? 'selected' : '' }}>{{ $area->nombre }}</option>
                            @endforeach
                        </select>
                        @error('area_id') <span class="text-xs text-error mt-1 block font-medium">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="flex justify-end pt-4 border-t border-outline-variant">
                    <button type="submit" class="bg-primary text-on-primary px-5 py-2.5 rounded-lg font-label-sm text-sm font-medium flex items-center gap-2 hover:bg-primary-container transition-colors shadow-sm cursor-pointer">
                        <span class="material-symbols-outlined text-[18px]">add_circle</span>
                        <span>Guardar Usuario</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Contenedor de la Tabla -->
    <div class="bg-surface-lowest rounded-xl border border-outline-variant shadow-sm overflow-hidden flex flex-col transition-all hover:shadow-md">
        <!-- Buscador -->
        <div class="p-4 border-b border-outline-variant flex flex-col sm:flex-row gap-3 justify-between items-center bg-surface-lowest">
            <div class="relative w-full sm:w-72">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-on-surface-variant/60">
                    <span class="material-symbols-outlined text-[18px]">search</span>
                </div>
                <input id="searchUsers" class="w-full pl-10 pr-4 py-2 border border-outline-variant rounded-lg text-body-md text-on-surface placeholder:text-on-surface-variant/50 focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 transition-all" placeholder="Buscar por nombre, correo..." type="text"/>
            </div>
        </div>

        <!-- Tabla -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-surface-variant/40 border-b border-outline-variant">
                        <th class="px-6 py-3.5 font-label-caps text-label-caps text-on-surface-variant uppercase tracking-wider font-semibold">Detalles del Usuario</th>
                        <th class="px-6 py-3.5 font-label-caps text-label-caps text-on-surface-variant uppercase tracking-wider font-semibold">Rol y Área</th>
                        <th class="px-6 py-3.5 font-label-caps text-label-caps text-on-surface-variant uppercase tracking-wider font-semibold">Estado</th>
                        <th class="px-6 py-3.5 font-label-caps text-label-caps text-on-surface-variant uppercase tracking-wider font-semibold text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="font-body-md text-body-md text-on-surface divide-y divide-outline-variant/30">
                    <tr id="emptyRow" class="hidden">
                        <td colspan="4" class="px-6 py-10 text-center text-on-surface-variant/60 font-body-md">
                            <span class="material-symbols-outlined text-4xl mb-2 text-on-surface-variant/40 block">search_off</span>
                            No se encontraron usuarios que coincidan con la búsqueda.
                        </td>
                    </tr>
                    @forelse($users ?? [] as $user)
                    <tr class="hover:bg-surface-variant/20 transition-colors group">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-primary-container/10 text-primary-container flex items-center justify-center font-headline-sm text-sm font-bold shadow-inner border border-primary/10">
                                    {{ strtoupper(substr($user->nombre, 0, 1) . substr($user->apellido_paterno, 0, 1)) }}
                                </div>
                                <div class="flex flex-col">
                                    <span class="font-semibold text-on-surface group-hover:text-primary transition-colors">{{ $user->nombre }} {{ $user->apellido_paterno }} {{ $user->apellido_materno }}</span>
                                    <span class="text-xs text-on-surface-variant/70">{{ $user->email }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex flex-col">
                                <span class="font-medium text-on-surface">{{ $user->role->nombre ?? 'Sin Rol' }}</span>
                                <span class="text-xs text-on-surface-variant/70">{{ $user->area->nombre ?? 'N/A' }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            @if($user->estado == 'activo')
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200/50">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1.5"></span> Activo
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-rose-50 text-rose-700 border border-rose-200/50">
                                    <span class="w-1.5 h-1.5 rounded-full bg-rose-500 mr-1.5"></span> Inactivo
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-3">
                                <button type="button" class="text-on-surface-variant hover:text-primary p-1.5 hover:bg-surface-variant rounded-full transition-all cursor-pointer" 
                                        title="Editar"
                                        onclick="openEditModal(this)"
                                        data-id="{{ $user->id }}"
                                        data-nombre="{{ $user->nombre }}"
                                        data-paterno="{{ $user->apellido_paterno }}"
                                        data-materno="{{ $user->apellido_materno }}"
                                        data-email="{{ $user->email }}"
                                        data-role="{{ $user->role_id }}"
                                        data-area="{{ $user->area_id }}">
                                    <span class="material-symbols-outlined text-[20px]">edit</span>
                                </button>
                                
                                <!-- Formulario para Activar / Desactivar (Soft Delete) -->
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline m-0 p-0">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1.5 rounded-full transition-all cursor-pointer {{ $user->estado == 'activo' ? 'text-error hover:bg-error-container/20' : 'text-primary hover:bg-primary-container/25' }}" title="{{ $user->estado == 'activo' ? 'Bloquear / Desactivar' : 'Activar' }}">
                                        @if($user->estado == 'activo')
                                            <span class="material-symbols-outlined text-[20px]">person_off</span>
                                        @else
                                            <span class="material-symbols-outlined text-[20px]">how_to_reg</span>
                                        @endif
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-10 text-center text-on-surface-variant/60 font-body-md">
                            <span class="material-symbols-outlined text-4xl mb-2 text-on-surface-variant/40 block">group_off</span>
                            No hay usuarios registrados en el sistema.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Paginación -->
        @if(isset($users) && method_exists($users, 'links'))
        <div class="p-4 border-t border-outline-variant flex items-center justify-between text-body-md text-on-surface-variant bg-surface-variant/20">
            {{ $users->links() }}
        </div>
        @endif
    </div>
</div>

<!-- Modal de Edición de Usuario -->
<div id="editUserModal" class="fixed inset-0 z-50 hidden bg-[#46959f]/50 flex items-center justify-center p-4 backdrop-blur-sm transition-all duration-300">
    <div class="bg-surface-lowest rounded-xl border border-outline-variant shadow-2xl w-full max-w-lg overflow-hidden transform scale-95 opacity-0 transition-all duration-300" id="editModalContent">
        <div class="px-6 py-4 border-b border-outline-variant bg-gradient-to-r from-surface-variant/30 to-surface-variant/5 flex justify-between items-center">
            <h3 class="font-headline-sm text-headline-sm text-on-surface font-semibold flex items-center gap-2">
                <span class="material-symbols-outlined text-primary" style="font-size: 22px;">edit</span>
                Editar Usuario
            </h3>
            <button type="button" class="text-on-surface-variant/75 hover:text-on-surface p-1 rounded-full hover:bg-surface-variant transition-colors cursor-pointer" onclick="closeEditModal()">
                <span class="material-symbols-outlined text-[20px]">close</span>
            </button>
        </div>
        <div class="p-6">
            <form id="editUserForm" method="POST">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
                    <div>
                        <label class="block font-label-sm text-label-sm text-on-surface-variant mb-1.5" for="edit_nombre">Nombre</label>
                        <input type="text" id="edit_nombre" name="nombre" required class="w-full px-4 py-2 border border-outline-variant rounded-lg text-body-md text-on-surface bg-surface-lowest focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 transition-all" placeholder="Ej. Juan">
                    </div>
                    
                    <div>
                        <label class="block font-label-sm text-label-sm text-on-surface-variant mb-1.5" for="edit_apellido_paterno">Primer Apellido</label>
                        <input type="text" id="edit_apellido_paterno" name="apellido_paterno" required class="w-full px-4 py-2 border border-outline-variant rounded-lg text-body-md text-on-surface bg-surface-lowest focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 transition-all" placeholder="Ej. Pérez">
                    </div>
                    
                    <div>
                        <label class="block font-label-sm text-label-sm text-on-surface-variant mb-1.5" for="edit_apellido_materno">Segundo Apellido <span class="text-on-surface-variant/50 font-normal">(Opcional)</span></label>
                        <input type="text" id="edit_apellido_materno" name="apellido_materno" class="w-full px-4 py-2 border border-outline-variant rounded-lg text-body-md text-on-surface bg-surface-lowest focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 transition-all" placeholder="Ej. López">
                    </div>
                    
                    <div>
                        <label class="block font-label-sm text-label-sm text-on-surface-variant mb-1.5" for="edit_email">Correo Institucional</label>
                        <input type="email" id="edit_email" name="email" required class="w-full px-4 py-2 border border-outline-variant rounded-lg text-body-md text-on-surface bg-surface-lowest focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 transition-all" placeholder="usuario@ucc.gov">
                    </div>
                    
                    <div class="sm:col-span-2">
                        <label class="block font-label-sm text-label-sm text-on-surface-variant mb-1.5" for="edit_password">Nueva Contraseña <span class="text-on-surface-variant/50 font-normal">(Opcional)</span></label>
                        <div class="relative">
                            <input type="password" id="edit_password" name="password" minlength="8" class="w-full pl-4 pr-10 py-2.5 border border-outline-variant rounded-lg text-body-md text-on-surface bg-surface-lowest placeholder-on-surface-variant/40 focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 transition-all" placeholder="Dejar en blanco si no se cambia">
                            <button type="button" id="toggleEditPassword" class="absolute inset-y-0 right-0 pr-3 flex items-center text-on-surface-variant hover:text-on-surface focus:outline-none transition-colors" aria-label="Mostrar u ocultar contraseña">
                                <span class="material-symbols-outlined text-xl select-none" id="toggleEditPasswordIcon">visibility</span>
                            </button>
                        </div>
                    </div>
                    
                    <div>
                        <label class="block font-label-sm text-label-sm text-on-surface-variant mb-1.5" for="edit_role_id">Rol en el Sistema</label>
                        <select id="edit_role_id" name="role_id" required class="w-full px-4 py-2.5 border border-outline-variant rounded-lg text-body-md text-on-surface bg-surface-lowest focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 transition-all">
                            @foreach($roles ?? [] as $role)
                                <option value="{{ $role->id }}">{{ $role->nombre ?? $role->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div>
                        <label class="block font-label-sm text-label-sm text-on-surface-variant mb-1.5" for="edit_area_id">Área de Trabajo</label>
                        <select id="edit_area_id" name="area_id" required class="w-full px-4 py-2.5 border border-outline-variant rounded-lg text-body-md text-on-surface bg-surface-lowest focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 transition-all">
                            @foreach($areas ?? [] as $area)
                                <option value="{{ $area->id }}">{{ $area->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="flex justify-end gap-3 pt-4 border-t border-outline-variant">
                    <button type="button" class="bg-rose-500/10 hover:bg-rose-500/20 text-rose-600 border border-rose-200/40 px-5 py-2.5 rounded-lg font-label-sm text-sm font-medium transition-colors cursor-pointer" onclick="closeEditModal()">
                        Cancelar
                    </button>
                    <button type="submit" class="bg-primary text-on-primary px-5 py-2.5 rounded-lg font-label-sm text-sm font-medium hover:bg-primary-container transition-colors shadow-sm cursor-pointer">
                        Actualizar Usuario
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    // Edit Modal elements
    const editModal = document.getElementById('editUserModal');
    const editModalContent = document.getElementById('editModalContent');
    const editForm = document.getElementById('editUserForm');

    // Password visibility toggle helpers
    const setupPasswordToggle = (btnId, inputId, iconId) => {
        const btn = document.getElementById(btnId);
        const input = document.getElementById(inputId);
        const icon = document.getElementById(iconId);
        if (btn && input && icon) {
            btn.addEventListener('click', () => {
                const isPassword = input.type === 'password';
                input.type = isPassword ? 'text' : 'password';
                icon.textContent = isPassword ? 'visibility_off' : 'visibility';
            });
        }
    };
    setupPasswordToggle('togglePassword', 'password', 'togglePasswordIcon');
    setupPasswordToggle('toggleEditPassword', 'edit_password', 'toggleEditPasswordIcon');

    // Auto-dismiss success alert
    const successAlert = document.getElementById('successAlert');
    if (successAlert) {
        setTimeout(() => {
            successAlert.classList.add('opacity-0', '-translate-y-2');
            setTimeout(() => successAlert.remove(), 500);
        }, 4000);
    }

    // Dynamic search filtering in real time
    const searchInput = document.getElementById('searchUsers');
    if (searchInput) {
        searchInput.addEventListener('input', (e) => {
            const query = e.target.value.toLowerCase().trim();
            const rows = document.querySelectorAll('tbody tr');
            let hasResults = false;
            
            rows.forEach(row => {
                if (row.id === 'emptyRow') return;
                
                const content = row.textContent.toLowerCase();
                if (content.includes(query)) {
                    row.style.display = '';
                    hasResults = true;
                } else {
                    row.style.display = 'none';
                }
            });

            // Show or hide empty rows dynamically
            const emptyRow = document.getElementById('emptyRow');
            if (emptyRow) {
                emptyRow.style.display = hasResults ? 'none' : '';
            }
        });
    }

    // Open Edit Modal event handler
    window.openEditModal = (btn) => {
        const id = btn.getAttribute('data-id');
        const nombre = btn.getAttribute('data-nombre');
        const paterno = btn.getAttribute('data-paterno');
        const materno = btn.getAttribute('data-materno') || '';
        const email = btn.getAttribute('data-email');
        const role = btn.getAttribute('data-role');
        const area = btn.getAttribute('data-area');

        // Fill form fields
        document.getElementById('edit_nombre').value = nombre;
        document.getElementById('edit_apellido_paterno').value = paterno;
        document.getElementById('edit_apellido_materno').value = materno;
        document.getElementById('edit_email').value = email;
        document.getElementById('edit_password').value = '';
        document.getElementById('edit_role_id').value = role;
        document.getElementById('edit_area_id').value = area;

        // Set action url
        editForm.action = `/admin/users/${id}`;

        // Show Modal
        editModal.classList.remove('hidden');
        setTimeout(() => {
            editModalContent.classList.remove('scale-95', 'opacity-0');
            editModalContent.classList.add('scale-100', 'opacity-100');
        }, 50);
    };

    window.closeEditModal = () => {
        editModalContent.classList.remove('scale-100', 'opacity-100');
        editModalContent.classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            editModal.classList.add('hidden');
        }, 300);
    };

    // Close modal on background click
    editModal.addEventListener('click', (e) => {
        if (e.target === editModal) {
            closeEditModal();
        }
    });
});
</script>
@endsection
