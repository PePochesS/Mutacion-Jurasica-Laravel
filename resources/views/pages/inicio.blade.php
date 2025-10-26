@extends('layouts.app')
@section('title','Inicio')

@section('vite')
@vite(['resources/css/style.css', 'resources/js/scriptM.js'])
@endsection

@push('page_head')
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
@endpush

@section('content')
  @include('partials.audio')
  @include('partials.navbar')

  <div class="container py-4">
    <div class="row justify-content-center">
      <div class="col-12 text-center">
        <img src="{{ asset('images/menu-icons/Titulo.png') }}" alt="Mutación Jurásica" class="titulo img-fluid mb-3">
      </div>
    </div>

    <div class="row justify-content-center">
      <div class="col-12">
        <div class="menu">
          <a href="#" onclick="playClick(); return false;" class="btn p-0" aria-label="Extra">
            <img src="{{ asset('images/menu-icons/Extra-2.png') }}" alt="Extra" class="boton-img img-fluid">
          </a>

          @php($urlJuego = route('juego'))
          <a href="{{ $urlJuego }}" onclick="playClickAndGo(event, '{{ $urlJuego }}')" class="btn p-0" aria-label="Jugar">
            <img src="{{ asset('images/menu-icons/JugarBoton.png') }}" alt="Jugar" class="boton-img img-fluid">
          </a>

          <a href="#" onclick="playClick(); return false;" class="btn p-0" aria-label="Opciones">
            <img src="{{ asset('images/menu-icons/OpcionesBoton.png') }}" alt="Opciones" class="boton-img img-fluid">
          </a>
        </div>
      </div>
    </div>
  </div>

  <div id="modal-auth" class="modal-auth" style="display:none;" role="dialog" aria-modal="true" aria-labelledby="auth-title">
    <div class="modal-content">
      <button class="close" type="button" aria-label="Cerrar" onclick="cerrarModalAuth()">&times;</button>

      <div id="login-form">
        <div class="modal-panel">
          <h2 id="auth-title">Iniciar Sesión</h2>
          <div class="modal-form">
            <input type="text" id="login-usuario" placeholder="Usuario" required>
            <input type="password" id="login-password" placeholder="Contraseña" required>
            <button class="btn-primary-hero" type="button" onclick="loginUsuario()">Entrar</button>
            <p class="mt-2">¿No tienes cuenta? <a href="#" onclick="mostrarRegistro(); return false;">Regístrate</a></p>
            <div id="login-error" class="form-error"></div>
          </div>
        </div>
      </div>

      <div id="registro-form" style="display:none;">
        <div class="modal-panel">
          <h2>Registrarse</h2>
          <div class="modal-form">
            <p class="form-note" style="margin-bottom:8px; font-size:0.95rem;">Todos los campos son obligatorios</p>
            <input type="text" id="registro-email" placeholder="@gmail" required>
            <input type="text" id="registro-usuario" placeholder="Usuario" required>

            <div class="input-with-eye" style="margin-top:6px;">
              <input type="password" id="registro-password" placeholder="Contraseña" required>
              <button id="toggle-registro-password" class="eye-toggle" type="button" aria-label="Mostrar contraseña">
                <!-- two states: .eye-open (visible by default) and .eye-closed (shown when .active) -->
                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                  <!-- click-box: indicate where to click to toggle password visibility -->
                  <rect class="click-box" x="5" y="5" width="14" height="14" rx="3" ry="3" fill="none" stroke="#fff" stroke-width="1.5"></rect>
                  <!-- eye-open: visible by default (before click) -->
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
              <input type="password" id="registro-password-confirm" placeholder="Confirmar Contraseña" required>
              <button id="toggle-registro-password-confirm" class="eye-toggle" type="button" aria-label="Mostrar confirmar contraseña">
                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                  <rect class="click-box" x="5" y="5" width="14" height="14" rx="3" ry="3" fill="none" stroke="#fff" stroke-width="1.5"></rect>
                  <!-- eye-open: visible by default (before click) -->
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

            <button class="btn-primary-hero btn-registro" type="button" onclick="registrarUsuario()">Crear cuenta</button>
            <p class="mt-2">¿Ya tienes cuenta? <a href="#" onclick="mostrarLogin(); return false;">Inicia sesión</a></p>
            <div id="registro-error" class="form-error"></div>
          </div>
        </div>
      </div>
    </div>
  </div>

  @include('partials.footer')
  @include('partials.scripts')
@endsection
