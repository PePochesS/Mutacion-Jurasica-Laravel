@extends('layouts.app')
@section('title','Inicio')

@section('vite')
@vite(['resources/css/style.css', 'resources/js/scriptM.js'])
@endsection

@push('page_head')
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
  @include('partials.audio')
  @include('partials.navbar')

  @auth
  <div class="session-banner">
    <span>Sesión de <strong>{{ auth()->user()->name }}</strong></span>
    <form method="POST" action="{{ route('logout') }}">
      @csrf
      <button type="submit" class="logout-btn">Cerrar sesión</button>
    </form>
  </div>
  @endauth

  <div class="container py-4">
    <div class="row justify-content-center">
      <div class="col-12 text-center">
        <img src="{{ asset('images/menu-icons/Titulo.png') }}" alt="Mutación Jurásica" class="titulo img-fluid mb-3">
      </div>
    </div>

    <div class="row justify-content-center">
      <div class="col-12">
        <div class="menu">
       <a href="{{ route('extras.index') }}" 
   onclick="playClickAndGo(event, '{{ route('extras.index') }}')" 
   class="btn p-0" aria-label="Extra">
  <img src="{{ asset('images/menu-icons/Extra-2.png') }}" alt="Extra" class="boton-img img-fluid">
</a>

@php($urlJuego = route('juego'))
@auth
  <a href="#"
     onclick="playClick(); abrirModalJugadores(); return false;"
     class="btn p-0" aria-label="Jugar">
    <img src="{{ asset('images/menu-icons/JugarBoton.png') }}" alt="Jugar" class="boton-img img-fluid" draggable="false">
  </a>
@else
  <a href="#"
     onclick="playClick(); abrirModalLogin(); return false;"
     class="btn p-0" aria-label="Jugar (requiere login)">
    <img src="{{ asset('images/menu-icons/JugarBoton.png') }}" alt="Jugar (requiere login)" class="boton-img img-fluid" draggable="false">
  </a>
@endauth

<a href="{{ route('settings.index') }}" 
   onclick="playClickAndGo(event, '{{ route('settings.index') }}')" 
   class="btn p-0" aria-label="Opciones">
  <img src="{{ asset('images/menu-icons/OpcionesBoton.png') }}" alt="Opciones" class="boton-img img-fluid">
</a>

        </div>
      </div>
    </div>
  </div>

  <div id="modal-auth" class="modal-auth" style="display:none;" role="dialog" aria-modal="true" aria-labelledby="auth-title">
    <div class="modal-content">
      <button class="close" type="button" aria-label="Cerrar" onclick="cerrarModalAuth()">&times;</button>

      {{-- Login --}}
      <div id="login-form">
        <div class="modal-panel">
          <h2 id="auth-title">Iniciar Sesión</h2>
          <div class="modal-form">
            <form method="POST" action="{{ route('login.post') }}" novalidate>
              @csrf
              <input type="email" name="email" id="login-email" placeholder="Correo electrónico" required>
              <input type="password" name="password" id="login-password" placeholder="Contraseña" required>

              <button class="btn-primary-hero" type="submit">Entrar</button>

              <p class="mt-2">
                ¿No tienes cuenta?
                <a href="#" onclick="mostrarRegistro(); return false;">Regístrate</a>
              </p>

              @error('email')    <div class="form-error">{{ $message }}</div> @enderror
              @error('password') <div class="form-error">{{ $message }}</div> @enderror
            </form>
          </div>
        </div>
      </div>

      {{-- Registro --}}
      <div id="registro-form" style="display:none;">
        <div class="modal-panel">
          <h2>Registrarse</h2>
          <div class="modal-form">
            <p class="form-note" style="margin-bottom:8px; font-size:0.95rem;">Todos los campos son obligatorios</p>

            <form method="POST" action="{{ route('register.post') }}" novalidate>
              @csrf

              <input type="text"  name="name"  id="registro-usuario" placeholder="Nombre" value="{{ old('name') }}" required>
              <input type="email" name="email" id="registro-email" placeholder="correo@ejemplo.com" value="{{ old('email') }}" required>

              <div class="input-with-eye" style="margin-top:6px;">
                <input type="password" name="password" id="registro-password" placeholder="Contraseña" required>
                <button id="toggle-registro-password" class="eye-toggle" type="button" aria-label="Mostrar contraseña">
                  <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <rect class="click-box" x="5" y="5" width="14" height="14" rx="3" ry="3" fill="none" stroke="#fff" stroke-width="1.5"></rect>
                    <g class="eye-open">
                      <path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7S1 12 1 12z" fill="none" stroke="#fff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                      <circle cx="12" cy="12" r="3" fill="none" stroke="#fff" stroke-width="1.5"></circle>
                    </g>
                    <g class="eye-closed">
                      <path d="M2 12s4-7 10-7c3 0 6 2 8 5" fill="none" stroke="#fff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                      <path d="M22 12s-4 7-11 7c-5 0-8-4-9-6" fill="none" stroke="#fff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                      <line x1="3" y1="3" x2="21" y2="21" stroke="#fff" stroke-width="1.5" stroke-linecap="round"></line>
                    </g>
                  </svg>
                </button>
              </div>

              <div class="input-with-eye" style="margin-top:6px;">
                <input type="password" name="password_confirmation" id="registro-password-confirm" placeholder="Confirmar Contraseña" required>
                <button id="toggle-registro-password-confirm" class="eye-toggle" type="button" aria-label="Mostrar confirmar contraseña">
                  <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <rect class="click-box" x="5" y="5" width="14" height="14" rx="3" ry="3" fill="none" stroke="#fff" stroke-width="1.5"></rect>
                    <g class="eye-open">
                      <path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7S1 12 1 12z" fill="none" stroke="#fff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                      <circle cx="12" cy="12" r="3" fill="none" stroke="#fff" stroke-width="1.5"></circle>
                    </g>
                    <g class="eye-closed">
                      <path d="M2 12s4-7 10-7c3 0 6 2 8 5" fill="none" stroke="#fff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                      <path d="M22 12s-4 7-11 7c-5 0-8-4-9-6" fill="none" stroke="#fff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                      <line x1="3" y1="3" x2="21" y2="21" stroke="#fff" stroke-width="1.5" stroke-linecap="round"></line>
                    </g>
                  </svg>
                </button>
              </div>

              <button class="btn-primary-hero btn-registro" type="submit">Crear cuenta</button>
              <p class="mt-2">¿Ya tienes cuenta? <a href="#" onclick="mostrarLogin(); return false;">Inicia sesión</a></p>

              @error('name')     <div class="form-error">{{ $message }}</div> @enderror
              @error('email')    <div class="form-error">{{ $message }}</div> @enderror
              @error('password') <div class="form-error">{{ $message }}</div> @enderror
            </form>
          </div>
        </div>
      </div>

    </div>
  </div>

  {{-- modal: cantidad de jugadores --}}
  <div id="modal-players" class="modal-auth" style="display:none;" role="dialog" aria-modal="true">
    <div class="modal-content">
      <button class="close" type="button" aria-label="Cerrar" onclick="cerrarModalJugadores()">&times;</button>
      <div class="modal-panel">
        <h2>¿Cuántos jugadores?</h2>
        <form method="POST" action="{{ route('juego.start') }}">
          @csrf
          <select name="player_count" class="form-select my-2" required>
            <option value="1">1 jugador</option>
            <option value="2">2 jugadores</option>
            <option value="3">3 jugadores</option>
            <option value="4">4 jugadores</option>
          </select>
          <button type="submit" class="btn btn-success w-100 mt-2">Empezar</button>
        </form>
      </div>
    </div>
  </div>

  @include('partials.footer')

  @if (session('status'))
    <div id="toast-status" class="toast-status">{{ session('status') }}</div>
  @endif

  @include('partials.scripts')
@endsection
