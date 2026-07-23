<!-- SideNavBar -->
<nav class="hidden md:flex flex-col h-screen w-[280px] fixed left-0 top-0 bg-primary-container border-r border-outline-variant z-20">
    <!-- Brand/Header -->
    <div class="px-6 py-8 border-b border-outline-variant/30 flex flex-col items-center text-center gap-3">
        <div class="w-12 h-12 bg-on-primary-fixed/10 text-on-primary-fixed rounded-xl flex items-center justify-center shadow-inner">
            <span class="material-symbols-outlined text-2xl">account_balance</span>
        </div>
        <div>
            <h1 class="font-headline-md text-headline-md font-bold text-on-primary-fixed">Plataforma UCC</h1>
            <p class="font-label-sm text-label-sm text-on-primary-container">Sistema de Gestión de Correspondencia</p>
        </div>
    </div>
    
    <!-- Navigation Links -->
    <div class="flex-1 py-6 flex flex-col gap-2 px-2 overflow-y-auto">
        
        <!-- Dashboard -->
        <a class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('home') ? 'bg-secondary-container text-on-secondary-container border-l-2 border-secondary font-semibold' : 'text-on-primary-container hover:bg-on-primary-fixed-variant/10' }} rounded-r-md transition-colors scale-95 duration-150 shadow-sm" href="{{ route('home') }}">
            <span class="material-symbols-outlined">dashboard</span>
            <span class="font-body-md text-body-md font-medium">Panel Principal</span>
        </a>
        
        <!-- Seguridad (HU-1) -->
        @if(auth()->user()->isAdmin())
        <a class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('admin.users.*') ? 'bg-secondary-container text-on-secondary-container border-l-2 border-secondary font-semibold' : 'text-on-primary-container hover:bg-on-primary-fixed-variant/10' }} rounded-md transition-colors scale-95 hover:scale-100 duration-150" href="{{ route('admin.users.index') }}">
            <span class="material-symbols-outlined">security</span>
            <span class="font-body-md text-body-md font-medium">Gestión de Usuarios</span>
        </a>
        @endif
        
        <!-- Consulta Entradas (HU-05) y Captura Entrada (HU-04) -->
        @if(auth()->user()->role_id !== 3)
        <a class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('entradas.*') ? 'bg-secondary-container text-on-secondary-container border-l-2 border-secondary font-semibold' : 'text-on-primary-container hover:bg-on-primary-fixed-variant/10' }} rounded-md transition-colors scale-95 hover:scale-100 duration-150" href="{{ route('entradas.index') }}">
            <span class="material-symbols-outlined">inbox</span>
            <span class="font-body-md text-body-md font-medium">Entradas</span>
        </a>
        @endif
        
        <!-- Captura Salidas (HU-07) -->
        @if(auth()->user()->role_id !== 3)
        <a class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('salidas.*') ? 'bg-secondary-container text-on-secondary-container border-l-2 border-secondary font-semibold' : 'text-on-primary-container hover:bg-on-primary-fixed-variant/10' }} rounded-md transition-colors scale-95 hover:scale-100 duration-150" href="{{ route('salidas.index') }}">
            <span class="material-symbols-outlined">send</span>
            <span class="font-body-md text-body-md font-medium">Salidas</span>
        </a>
        @endif

        <!-- Bitácora Logística (HU-09) -->
        @if(auth()->user()->role_id !== 2)
        <a class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('repartos.*') ? 'bg-secondary-container text-on-secondary-container border-l-2 border-secondary font-semibold' : 'text-on-primary-container hover:bg-on-primary-fixed-variant/10' }} rounded-md transition-colors scale-95 hover:scale-100 duration-150" href="{{ route('repartos.index') }}">
            <span class="material-symbols-outlined">local_shipping</span>
            <span class="font-body-md text-body-md font-medium">Control de Reparto</span>
        </a>
        @endif
        
        <!-- Seguimiento (HU-11) -->
        <a class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('seguimiento.*') ? 'bg-secondary-container text-on-secondary-container border-l-2 border-secondary font-semibold' : 'text-on-primary-container hover:bg-on-primary-fixed-variant/10' }} rounded-md transition-colors scale-95 hover:scale-100 duration-150" href="{{ route('seguimiento.index') }}">
            <span class="material-symbols-outlined">location_searching</span>
            <span class="font-body-md text-body-md font-medium">Rastreo</span>
        </a>
    </div>

    <!-- Footer Links -->
    <div class="p-4 border-t border-outline-variant/30 flex flex-col gap-2">
        <!-- Cerrar Sesión -->
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 text-on-primary-container hover:bg-red-500/10 hover:text-red-400 rounded-md transition-colors scale-95 hover:scale-100 duration-150">
                <span class="material-symbols-outlined">logout</span>
                <span class="font-body-md text-body-md font-medium">Cerrar Sesión</span>
            </button>
        </form>
    </div>
</nav>
