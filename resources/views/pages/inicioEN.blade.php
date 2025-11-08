@extends('layouts.app')
@section('title','Home')

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
    <span>Session of <strong>{{ auth()->user()->name }}</strong></span>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="logout-btn">Log out</button>
    </form>
</div>
@endauth

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-12 text-center">
            <img src="{{ asset('images/menu-icons/Titulo.png') }}"
                 alt="Mutation Jurassic"
                 class="titulo img-fluid mb-3">
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-12">
            <div class="menu">

               {{-- EXTRA EN --}}
<a href="{{ route('en.extras') }}"
   onclick="playClickAndGo(event, '{{ route('en.extras') }}')"
   class="btn p-0"
   aria-label="Extras">
    <img src="{{ asset('images/menu-icons/Extra-2.png') }}"
         alt="Extras"
         class="boton-img img-fluid">
</a>

{{-- PLAY EN --}}
@auth
<a href="#"
   onclick="playClick(); abrirModalJugadores(); return false;"
   class="btn p-0" aria-label="Play">
    <img src="{{ asset('images/menu-icons/PlayBoton.png') }}"
         alt="Play"
         class="boton-img img-fluid"
         draggable="false">
</a>
@else
<a href="#"
   onclick="playClick(); abrirModalLogin(); return false;"
   class="btn p-0"
   aria-label="Play (Login required)">
    <img src="{{ asset('images/menu-icons/PlayBoton.png') }}"
         alt="Play (Login required)"
         class="boton-img img-fluid"
         draggable="false">
</a>
@endauth

{{-- SETTINGS EN --}}
<a href="{{ route('en.options') }}"
   onclick="playClickAndGo(event, '{{ route('en.options') }}')"
   class="btn p-0"
   aria-label="Settings">
    <img src="{{ asset('images/menu-icons/botonSettings.png') }}"
         alt="Settings"
         class="boton-img img-fluid">
</a>

            </div>
        </div>
    </div>
</div>


{{-- AUTH MODAL EN --}}
<div id="modal-auth" class="modal-auth" style="display:none;" role="dialog" aria-modal="true">
  <div class="modal-content">
    <button class="close" type="button" aria-label="Close" onclick="cerrarModalAuth()">&times;</button>

    {{-- LOGIN --}}
    <div id="login-form">
      <div class="modal-panel">
        <h2>Sign In</h2>
        <div class="modal-form">
          <form method="POST" action="{{ route('login.post') }}" novalidate>
            @csrf
            <input type="email" name="email" placeholder="Email address" required>
            <input type="password" name="password" placeholder="Password" required>

            <button class="btn-primary-hero" type="submit">Enter</button>

            <p class="mt-2">Don’t have an account?
              <a href="#" onclick="mostrarRegistro(); return false;">Create one</a>
            </p>
          </form>
        </div>
      </div>
    </div>

    {{-- REGISTER --}}
    <div id="registro-form" style="display:none;">
      <div class="modal-panel">
        <h2>Sign Up</h2>
        <div class="modal-form">
          <form method="POST" action="{{ route('register.post') }}" novalidate>
            @csrf
            <input type="text" name="name" placeholder="Name" required>
            <input type="email" name="email" placeholder="you@example.com" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="password" name="password_confirmation" placeholder="Confirm Password" required>

            <button class="btn-primary-hero" type="submit">Create account</button>

            <p class="mt-2">Already have an account?
              <a href="#" onclick="mostrarLogin(); return false;">Sign in</a>
            </p>
          </form>
        </div>
      </div>
    </div>

  </div>
</div>


{{-- PLAYERS MODAL --}}
<div id="modal-players" class="modal-auth" style="display:none;" role="dialog" aria-modal="true">
  <div class="modal-content">
    <button class="close" type="button" onclick="cerrarModalJugadores()">&times;</button>
    <div class="modal-panel">
      <h2>How many players?</h2>

      <form method="POST" action="{{ route('en.game.start') }}">
        @csrf
        <input type="hidden" name="_lang" value="en">

        <select name="player_count" class="form-select my-2" required>
          <option value="1">1 player</option>
          <option value="2">2 players</option>
          <option value="3">3 players</option>
          <option value="4">4 players</option>
        </select>

        <button type="submit" class="btn btn-success w-100 mt-2">Start</button>
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
