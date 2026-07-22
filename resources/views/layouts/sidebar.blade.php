<!-- SideNavBar -->
<nav class="hidden md:flex flex-col h-screen w-[280px] fixed left-0 top-0 bg-primary-container border-r border-outline-variant z-20">
<!-- Brand/Header -->
<div class="px-6 py-8 border-b border-outline-variant/30 flex items-center gap-4">
<div class="w-10 h-10 bg-on-primary-fixed text-primary-container rounded-lg flex items-center justify-center font-bold text-lg">
                UCC
            </div>
<div>
<h1 class="font-headline-md text-headline-md font-bold text-on-primary-fixed">Plataforma UCC</h1>
<p class="font-label-sm text-label-sm text-on-primary-container">Correspondencia Gov</p>
</div>
</div>
<!-- Navigation Links -->
<div class="flex-1 py-6 flex flex-col gap-2 px-2 overflow-y-auto">
<a class="flex items-center gap-3 px-4 py-3 bg-secondary-container text-on-secondary-container border-l-2 border-secondary font-semibold rounded-r-md transition-colors scale-95 duration-150 shadow-sm" href="{{ route('home') ?? '#' }}">
<span class="material-symbols-outlined">dashboard</span>
<span class="font-body-md text-body-md font-medium">Panel Principal</span>
</a>
<a class="flex items-center gap-3 px-4 py-3 text-on-primary-container hover:bg-on-primary-fixed-variant/10 rounded-md transition-colors scale-95 hover:scale-100 duration-150" href="#">
<span class="material-symbols-outlined">security</span>
<span class="font-body-md text-body-md font-medium">Seguridad</span>
</a>
<a class="flex items-center gap-3 px-4 py-3 text-on-primary-container hover:bg-on-primary-fixed-variant/10 rounded-md transition-colors scale-95 hover:scale-100 duration-150" href="#">
<span class="material-symbols-outlined">inbox</span>
<span class="font-body-md text-body-md font-medium">Entradas</span>
</a>
<a class="flex items-center gap-3 px-4 py-3 text-on-primary-container hover:bg-on-primary-fixed-variant/10 rounded-md transition-colors scale-95 hover:scale-100 duration-150" href="#">
<span class="material-symbols-outlined">send</span>
<span class="font-body-md text-body-md font-medium">Salidas/Entregas</span>
</a>
<a class="flex items-center gap-3 px-4 py-3 text-on-primary-container hover:bg-on-primary-fixed-variant/10 rounded-md transition-colors scale-95 hover:scale-100 duration-150" href="#">
<span class="material-symbols-outlined">location_searching</span>
<span class="font-body-md text-body-md font-medium">Rastreo</span>
</a>
</div>
<!-- Footer Links -->
<div class="p-4 border-t border-outline-variant/30 flex flex-col gap-2">
<a class="flex items-center gap-3 px-4 py-3 text-on-primary-container hover:bg-on-primary-fixed-variant/10 rounded-md transition-colors scale-95 hover:scale-100 duration-150" href="#">
<span class="material-symbols-outlined">settings</span>
<span class="font-body-md text-body-md font-medium">Configuración</span>
</a>
<a class="flex items-center gap-3 px-4 py-3 text-on-primary-container hover:bg-on-primary-fixed-variant/10 rounded-md transition-colors scale-95 hover:scale-100 duration-150" href="#">
<span class="material-symbols-outlined">help</span>
<span class="font-body-md text-body-md font-medium">Soporte</span>
</a>
</div>
</nav>
