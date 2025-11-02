<!DOCTYPE html>
<html lang="es">
<head>
  @include('partials.head')
  {{-- Stack para links o metas por página (fonts, css adicionales) --}}
  @stack('page_head')
  {{-- Stack para que las páginas inyecten sus @vite assets (CSS/JS) cuando sea necesario --}}
  @stack('page_vite')
  {{-- Compatibilidad con vistas que usaban @section('vite') --}}
  @yield('vite')
</head>
<body>
  {{-- Contenido específico de cada página --}}
  @yield('content')

  {{-- Scripts globales (cargados una vez) --}}
  @includeWhen(View::exists('partials.scripts'), 'partials.scripts')

  {{-- Scripts por página (stack opcional para código inline o inicializadores) --}}
  @stack('page_scripts')
</body>
</html>
