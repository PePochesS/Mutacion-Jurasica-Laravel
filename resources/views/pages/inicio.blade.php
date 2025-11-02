@extends('layouts.app')
@section('title','Inicio')

@section('vite')
@vite(['resources/css/style.css', 'resources/js/scriptM.js'])
@endsection

@push('page_head')
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<<<<<<< HEAD
=======
  <meta name="csrf-token" content="{{ csrf_token() }}">
>>>>>>> mi-trabajo-local
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

 {{-- MODAL AUTH (overlay + contenido + paneles) --}}
<div id="modal-auth" class="modal-auth" style="display:none;" role="dialog" aria-modal="true" aria-labelledby="auth-title">
  <div class="modal-content">
    <button class="close" type="button" aria-label="Cerrar" onclick="cerrarModalAuth()">&times;</button>

    {{-- LOGIN --}}
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

    {{-- REGISTRO --}}
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
                {{-- tu SVG del ojo aquí --}}
              </button>
            </div>

            <div class="input-with-eye" style="margin-top:6px;">
              <input type="password" name="password_confirmation" id="registro-password-confirm" placeholder="Confirmar Contraseña" required>
              <button id="toggle-registro-password-confirm" class="eye-toggle" type="button" aria-label="Mostrar confirmar contraseña">
                {{-- tu SVG del ojo aquí --}}
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

  @include('partials.footer')
  @include('partials.scripts')
@endsection
