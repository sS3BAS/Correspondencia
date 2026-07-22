<!DOCTYPE html>
<html class="light" lang="es">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Plataforma UCC - @yield('title', 'Panel')</title>
    
    <!-- Scripts/Styles generados por Stitch -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@400;500;600;700&amp;display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "secondary-fixed": "#dbe1ff",
                        "surface-container": "#e5eeff",
                        "on-secondary-fixed": "#00174b",
                        "tertiary-fixed": "#fcdeb5",
                        "surface-container-low": "#eff4ff",
                        "on-tertiary-fixed": "#271901",
                        "on-surface": "#0b1c30",
                        "on-tertiary-container": "#98805d",
                        "error": "#ba1a1a",
                        "on-error": "#ffffff",
                        "on-primary": "#ffffff",
                        "surface-bright": "#f8f9ff",
                        "surface-container-high": "#dce9ff",
                        "on-secondary-container": "#fefcff",
                        "on-secondary-fixed-variant": "#003ea8",
                        "on-primary-fixed": "#131b2e",
                        "secondary-fixed-dim": "#b4c5ff",
                        "background": "#f8f9ff",
                        "surface-variant": "#d3e4fe",
                        "surface-dim": "#cbdbf5",
                        "on-tertiary-fixed-variant": "#574425",
                        "error-container": "#ffdad6",
                        "tertiary": "#000000",
                        "on-surface-variant": "#45464d",
                        "surface-container-highest": "#d3e4fe",
                        "secondary-container": "#316bf3",
                        "on-tertiary": "#ffffff",
                        "on-primary-fixed-variant": "#3f465c",
                        "on-primary-container": "#7c839b",
                        "surface-tint": "#565e74",
                        "primary": "#000000",
                        "outline-variant": "#c6c6cd",
                        "outline": "#76777d",
                        "tertiary-container": "#271901",
                        "inverse-primary": "#bec6e0",
                        "inverse-on-surface": "#eaf1ff",
                        "primary-container": "#131b2e",
                        "on-secondary": "#ffffff",
                        "surface": "#f8f9ff",
                        "primary-fixed-dim": "#bec6e0",
                        "primary-fixed": "#dae2fd",
                        "tertiary-fixed-dim": "#dec29a",
                        "secondary": "#0051d5",
                        "surface-container-lowest": "#ffffff",
                        "inverse-surface": "#213145",
                        "on-error-container": "#93000a",
                        "on-background": "#0b1c30"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                    "spacing": {
                        "margin-desktop": "32px",
                        "stack-lg": "24px",
                        "gutter": "24px",
                        "sidebar-width": "280px",
                        "stack-md": "16px",
                        "margin-mobile": "16px",
                        "container-max": "1440px",
                        "stack-sm": "8px"
                    },
                    "fontFamily": {
                        "headline-lg": ["Public Sans"],
                        "headline-lg-mobile": ["Public Sans"],
                        "body-md": ["Public Sans"],
                        "label-caps": ["Public Sans"],
                        "headline-sm": ["Public Sans"],
                        "headline-md": ["Public Sans"],
                        "label-sm": ["Public Sans"],
                        "body-lg": ["Public Sans"]
                    },
                    "fontSize": {
                        "headline-lg": ["30px", { "lineHeight": "38px", "letterSpacing": "-0.02em", "fontWeight": "700" }],
                        "headline-lg-mobile": ["24px", { "lineHeight": "32px", "fontWeight": "700" }],
                        "body-md": ["14px", { "lineHeight": "20px", "fontWeight": "400" }],
                        "label-caps": ["12px", { "lineHeight": "16px", "letterSpacing": "0.05em", "fontWeight": "600" }],
                        "headline-sm": ["20px", { "lineHeight": "28px", "fontWeight": "600" }],
                        "headline-md": ["24px", { "lineHeight": "32px", "letterSpacing": "-0.01em", "fontWeight": "600" }],
                        "label-sm": ["12px", { "lineHeight": "16px", "fontWeight": "500" }],
                        "body-lg": ["16px", { "lineHeight": "24px", "fontWeight": "400" }]
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Public Sans', sans-serif; }
    </style>

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-background text-on-background antialiased flex">
    
    <!-- Sidebar -->
    @include('layouts.sidebar')

    <!-- Main Content Wrapper -->
    <div class="flex-1 ml-0 md:ml-[280px] min-h-screen flex flex-col bg-background">
        
        <!-- Header -->
        @include('layouts.header')

        <!-- Main Dashboard Canvas -->
        <main class="flex-1 p-margin-mobile md:p-margin-desktop overflow-x-hidden">
            @yield('content')
        </main>

    </div>
</body>
</html>
