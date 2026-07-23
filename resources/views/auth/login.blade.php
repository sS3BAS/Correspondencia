<!DOCTYPE html>
<html class="h-full bg-surface" lang="es">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Plataforma UCC - Iniciar Sesión</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@400;500;600;700&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "tertiary-fixed": "#fcdeb5",
                        "primary-container": "#387c85",
                        "on-primary-container": "#7c839b",
                        "inverse-primary": "#bec6e0",
                        "inverse-surface": "#213145",
                        "surface-variant": "#d3e4fe",
                        "surface-tint": "#565e74",
                        "on-surface": "#0b1c30",
                        "on-error": "#ffffff",
                        "surface": "#f8f9ff",
                        "background": "#f8f9ff",
                        "error": "#ba1a1a",
                        "surface-dim": "#cbdbf5",
                        "on-tertiary": "#ffffff",
                        "on-primary-fixed": "#131b2e",
                        "tertiary": "#000000",
                        "tertiary-fixed-dim": "#dec29a",
                        "primary-fixed-dim": "#bec6e0",
                        "outline-variant": "#c6c6cd",
                        "on-secondary-container": "#fefcff",
                        "on-tertiary-container": "#98805d",
                        "primary": "#46959f",
                        "secondary-fixed-dim": "#b4c5ff",
                        "on-error-container": "#93000a",
                        "secondary": "#0051d5",
                        "surface-bright": "#f8f9ff",
                        "surface-container-high": "#dce9ff",
                        "inverse-on-surface": "#eaf1ff",
                        "on-surface-variant": "#45464d",
                        "on-background": "#0b1c30",
                        "tertiary-container": "#271901",
                        "on-secondary-fixed": "#00174b",
                        "surface-container": "#e5eeff",
                        "on-primary-fixed-variant": "#3f465c",
                        "outline": "#76777d",
                        "on-secondary-fixed-variant": "#003ea8",
                        "primary-fixed": "#dae2fd",
                        "on-secondary": "#ffffff",
                        "on-tertiary-fixed": "#271901",
                        "on-tertiary-fixed-variant": "#574425",
                        "secondary-container": "#316bf3",
                        "secondary-fixed": "#dbe1ff",
                        "error-container": "#ffdad6",
                        "surface-container-low": "#eff4ff",
                        "on-primary": "#ffffff",
                        "surface-container-lowest": "#ffffff",
                        "surface-container-highest": "#d3e4fe"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                    "spacing": {
                        "stack-md": "16px",
                        "container-max": "1440px",
                        "stack-lg": "24px",
                        "margin-desktop": "32px",
                        "sidebar-width": "280px",
                        "stack-sm": "8px",
                        "gutter": "24px",
                        "margin-mobile": "16px"
                    },
                    "fontFamily": {
                        "headline-sm": ["Public Sans"],
                        "label-caps": ["Public Sans"],
                        "headline-md": ["Public Sans"],
                        "headline-lg": ["Public Sans"],
                        "headline-lg-mobile": ["Public Sans"],
                        "label-sm": ["Public Sans"],
                        "body-md": ["Public Sans"],
                        "body-lg": ["Public Sans"]
                    },
                    "fontSize": {
                        "headline-sm": ["20px", { "lineHeight": "28px", "fontWeight": "600" }],
                        "label-caps": ["12px", { "lineHeight": "16px", "letterSpacing": "0.05em", "fontWeight": "600" }],
                        "headline-md": ["24px", { "lineHeight": "32px", "letterSpacing": "-0.01em", "fontWeight": "600" }],
                        "headline-lg": ["30px", { "lineHeight": "38px", "letterSpacing": "-0.02em", "fontWeight": "700" }],
                        "headline-lg-mobile": ["24px", { "lineHeight": "32px", "fontWeight": "700" }],
                        "label-sm": ["12px", { "lineHeight": "16px", "fontWeight": "500" }],
                        "body-md": ["14px", { "lineHeight": "20px", "fontWeight": "400" }],
                        "body-lg": ["16px", { "lineHeight": "24px", "fontWeight": "400" }]
                    }
                }
            }
        }
    </script>
</head>
<body class="h-full flex items-center justify-center p-4">
<!-- Login Container -->
<div class="w-full max-w-md bg-surface-container-lowest rounded-xl border border-outline-variant shadow-sm p-8 flex flex-col items-center">
<!-- Logo Area -->
<div class="mb-8 flex flex-col items-center text-center">
<div class="w-16 h-16 bg-primary rounded-lg flex items-center justify-center mb-4 text-on-primary">
<span class="material-symbols-outlined text-4xl" data-icon="account_balance">account_balance</span>
</div>
<h1 class="font-headline-md text-headline-md text-on-surface mb-2">Plataforma UCC</h1>
<p class="font-body-md text-body-md text-on-surface-variant">Sistema de Gestión de Correspondencia</p>
</div>

<!-- Form -->
<form method="POST" action="{{ route('login') }}" class="w-full space-y-6">
@csrf

<!-- Validation Errors -->
@if($errors->any())
<div class="p-4 mb-4 text-sm text-rose-700 bg-rose-50 border border-rose-200/50 rounded-lg" role="alert">
    <div class="flex items-center">
        <span class="material-symbols-outlined text-rose-500 mr-2 text-[20px]">error</span>
        <span class="font-medium">{{ $errors->first() }}</span>
    </div>
</div>
@endif

<!-- Email Field -->
<div class="space-y-2">
<label class="block font-label-sm text-label-sm text-on-surface-variant" for="email">Correo Institucional</label>
<div class="relative">
<div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-on-surface-variant">
<span class="material-symbols-outlined text-xl" data-icon="mail">mail</span>
</div>
<input class="block w-full pl-10 pr-3 py-2 border @error('email') border-error @else border-outline-variant @enderror rounded-md text-on-surface font-body-md text-body-md placeholder-on-surface-variant/50 focus:outline-none focus:ring-1 focus:ring-secondary focus:border-secondary transition-colors" id="email" name="email" value="{{ old('email') }}" placeholder="admin@gov.org" required autofocus type="email"/>
</div>
</div>
<!-- Password Field -->
<div class="space-y-2">
<div class="flex items-center justify-between">
<label class="block font-label-sm text-label-sm text-on-surface-variant" for="password">Contraseña</label>
</div>
<div class="relative">
<div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-on-surface-variant">
<span class="material-symbols-outlined text-xl" data-icon="lock">lock</span>
</div>
<input class="block w-full pl-10 pr-10 py-2 border @error('password') border-error @else border-outline-variant @enderror rounded-md text-on-surface font-body-md text-body-md placeholder-on-surface-variant/50 focus:outline-none focus:ring-1 focus:ring-secondary focus:border-secondary transition-colors" id="password" name="password" placeholder="••••••••" required type="password"/>
<button type="button" id="togglePassword" class="absolute inset-y-0 right-0 pr-3 flex items-center text-on-surface-variant hover:text-on-surface focus:outline-none transition-colors" aria-label="Mostrar u ocultar contraseña">
<span class="material-symbols-outlined text-xl select-none" id="togglePasswordIcon">visibility</span>
</button>
</div>
</div>
<!-- Submit Button -->
<button class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm font-label-caps text-label-caps text-on-primary bg-primary hover:bg-primary-container focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-colors mt-8" type="submit">
                Iniciar Sesión
            </button>
<!-- Security Notice -->
<div class="mt-6 flex items-center justify-center gap-2 text-on-surface-variant">
<span class="material-symbols-outlined text-sm" data-icon="gpp_good">gpp_good</span>
<span class="font-label-sm text-label-sm">Sesión cifrada de extremo a extremo</span>
</div>
</form>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const togglePasswordBtn = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');
    const togglePasswordIcon = document.getElementById('togglePasswordIcon');

    if (togglePasswordBtn && passwordInput && togglePasswordIcon) {
        togglePasswordBtn.addEventListener('click', () => {
            const isPassword = passwordInput.type === 'password';
            passwordInput.type = isPassword ? 'text' : 'password';
            togglePasswordIcon.textContent = isPassword ? 'visibility_off' : 'visibility';
        });
    }
});
</script>
</body>
</html>
