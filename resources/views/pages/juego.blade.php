@extends('layouts.app')
@section('title','Juego')

@push('page_vite')
  @vite(['resources/css/styleJuego.css','resources/js/script.js'])
@endpush

@section('content')

<div class="game-header">
  <div id="turno-label" class="gh-title">
    Partida #{{ $gameId }} — Jugadores: {{ $playerCount }} — Turno del Jugador {{ $turn }}
  </div>

  <div class="gh-actions">
    <button type="button" class="btn btn-sm btn-outline-light" onclick="siguienteTurno()">
      Siguiente turno
    </button>

    <form id="end-game-form" method="POST" action="{{ route('juego.end') }}">
      @csrf
      <input type="hidden" name="game_id" value="{{ $gameId }}">
      <input type="hidden" name="scores_json" id="scores_json">
      <button type="button" class="btn btn-sm btn-danger" onclick="finalizarPartida()">
        Finalizar partida
      </button>
    </form>
  </div>
</div>

{{-- CONTENEDOR PRINCIPAL (mantiene tus tres columnas originales) --}}
<div class="game-row">
  <div class="panel-dinosaurios">
    <h2>Dinosaurios</h2>
    <img src="{{ asset('images/game-assets/Dinosaurio 1.png') }}" alt="dinosaurio 1" draggable="true">
    <img src="{{ asset('images/game-assets/Dinosaurio 2.png') }}" alt="dinosaurio 2" draggable="true">
    <img src="{{ asset('images/game-assets/Dinosaurio 3.png') }}" alt="dinosaurio 3" draggable="true">
    <img src="{{ asset('images/game-assets/Dinosaurio 4.png') }}" alt="dinosaurio 4" draggable="true">
    <img src="{{ asset('images/game-assets/Dinosaurio 5.png') }}" alt="dinosaurio 5" draggable="true">
    <img src="{{ asset('images/game-assets/Dinosaurio 6.png') }}" alt="dinosaurio 6" draggable="true">
  </div>

  <div class="zona-juego">
    @for ($i = 1; $i <= 7; $i++)
      <div class="recinto" id="recinto{{ $i }}">
        <h3>Recinto {{ $i }}</h3>
        <div class="dropzone"></div>
        <div class="acciones">
          <button type="button" onclick="limpiarRecinto('recinto{{ $i }}')" class="btn btn-danger btn-sm">Limpiar Recinto</button>
        </div>
        <div class="puntaje-recinto"><span>Puntos: <span id="puntos-recinto{{ $i }}">0</span></span></div>
      </div>
    @endfor
  </div>

  <div class="puntaje">
    <span class="fw-bold">Puntaje Total</span>
    <p id="puntos">0</p>
  </div>
</div>

{{-- Botones inferiores --}}
<a href="{{ route('home') }}" class="btn-volver btn btn-warning">Volver</a>

{{-- Variables para script.js --}}
<script>
  window.playerCount  = {{ (int) $playerCount }};
  window.currentTurn  = {{ (int) $turn }};
  window.gameIdFront  = {{ (int) $gameId }};
</script>

@endsection
