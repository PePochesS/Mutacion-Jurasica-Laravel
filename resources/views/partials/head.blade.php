  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Mutación Jurásica - @yield('title','Inicio')</title>

  <link rel="icon" type="image/png" href="{{ asset('images/game-assets/LogoFinal.png') }}" sizes="32x32">

  {{-- Cargar Bootstrap GLOBAL una sola vez aquí (mantener versión establecida) --}}
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  {{-- Lugar para que cada página inyecte links específicos (fonts, css extra) --}}
  @stack('page_head')

  {{-- Stack para que las páginas inyecten sus assets Vite (CSS/JS) --}}
  @stack('page_vite')

  {{-- Compatibilidad con @section('vite') en vistas migradas --}}
  @yield('vite')
