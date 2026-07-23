<!-- TopNavBar -->
<header class="flex justify-between items-center h-16 w-full px-margin-desktop bg-surface-lowest border-b border-outline-variant shadow-sm z-10 transition-all duration-200">
<!-- Mobile Menu Toggle (Visible only on mobile) -->
<button class="md:hidden text-on-surface hover:text-secondary p-2 -ml-2 rounded-full focus:outline-none focus:ring-2 focus:ring-secondary">
<span class="material-symbols-outlined">menu</span>
</button>
<div class="hidden md:flex items-center gap-4 text-on-surface">
<h2 class="font-headline-sm text-headline-sm font-bold">Sistema de Gestión de Correspondencia</h2>
</div>
<div class="flex items-center gap-6 flex-1 justify-end">
<!-- Actions -->
<form method="POST" action="{{ route('logout') }}" class="inline">
    @csrf
    <button type="submit" class="p-2 text-on-surface-variant hover:text-error hover:bg-surface-variant/50 rounded-full transition-colors" title="Cerrar sesión">
        <span class="material-symbols-outlined">logout</span>
    </button>
</form>

<!-- Profile -->
<div class="flex items-center gap-3 pl-4 border-l border-outline-variant">
<div class="hidden sm:block text-right">
<p class="font-label-sm text-label-sm font-semibold text-on-surface">{{ auth()->user()->nombre ?? 'Usuario Admin' }}</p>
<p class="font-label-sm text-[10px] text-on-surface-variant">Depto. de Registros</p>
</div>
<img class="w-9 h-9 rounded-full object-cover border border-outline-variant" alt="Foto de perfil" src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->nombre ?? 'Admin') }}&background=131b2e&color=fff"/>
</div>
</div>
</header>
