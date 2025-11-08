@extends('layouts.app')
@section('title','Juego')

@push('page_vite')
  @vite(['resources/css/styleJuego.css','resources/js/script.js'])
@endpush

@section('content')

<div class="game-header">
  <div class="gh-left">
    <div id="turno-label" class="gh-title">
      Partida #{{ $gameId }} — Jugadores: {{ $playerCount }} — Turno del Jugador {{ $turn }}
    </div>
    <div id="ronda-label" class="gh-subtitle">Ronda 1/6</div>
  </div>

  <div class="gh-actions">
    {{-- Dado --}}
    <div class="dice-wrap">
      <div id="die-face" class="die-face">—</div>
      <button type="button" class="btn btn-sm btn-secondary" onclick="rollDie()">
        Lanzar dado
      </button>
    </div>

    {{-- Reglas (abre modal por hash) --}}
    <a href="#rules-modal" class="btn btn-sm btn-info">Reglas</a>

    {{-- Siguiente turno / Finalizar --}}
    <button id="btn-next-turn" type="button" class="btn btn-sm btn-outline-light" onclick="siguienteTurno()">
      Siguiente turno
    </button>

    <form id="end-game-form" method="POST" action="{{ route('juego.end') }}" class="d-inline">
      @csrf
      <input type="hidden" name="game_id" value="{{ $gameId }}">
      <input type="hidden" name="scores_json" id="scores_json">
      <button type="button" class="btn btn-sm btn-danger" onclick="finalizarPartida()">
        Finalizar partida
      </button>
    </form>
  </div>
</div>

{{-- CONTENEDOR PRINCIPAL --}}
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

<a href="{{ route('home') }}" class="btn-volver btn btn-warning">Volver</a>

{{-- Modal REGLAS (ES) --}}
<div id="rules-modal" class="modal-auth rules-modal" role="dialog" aria-modal="true" aria-labelledby="rules-title">
  <div class="rules-card" role="document">
    <div class="rules-head">
      <div>
        <h2 id="rules-title" class="rules-title">Reglas de Recintos</h2>
        <p class="rules-sub">Resumen rápido de puntajes y restricciones</p>
      </div>
      <a href="#" class="rules-close" aria-label="Cerrar">×</a>
    </div>

    <div class="rules-body" id="rules-body">
      <ul class="rules-list">
        <li><b>Recinto 1:</b> Misma especie. Máx 6. Puntos: 2, 4, 8, 12, 18, 24.</li>
        <li><b>Recinto 2:</b> Cualquier especie. Máx 3. Puntos: 7 si hay 3.</li>
        <li><b>Recinto 3:</b> Misma especie. Máx 2. Puntos: 5 si las 2 son iguales.</li>
        <li><b>Recinto 4:</b> Solo 1 dino. +7 si es la especie más común del tablero.</li>
        <li><b>Recinto 5:</b> Cualquier especie. Máx 6. Puntos: 1, 3, 6, 10, 15, 21.</li>
        <li><b>Recinto 6:</b> Solo 1 dino. +7 si esa especie aparece solo 1 vez en todo el tablero.</li>
        <li><b>Recinto 7:</b> Solo 1 dino. +1 si hay uno.</li>
      </ul>
      <div class="rules-note">
        <b>Turnos:</b> la partida dura <b>6 rondas</b>. Tras completar la ronda 6 se desactiva “Siguiente turno”.<br>
        <b>Dado:</b> caras posibles: Hueso, Poción, Plantas, Rocas y DINODICE!.
      </div>
    </div>
  </div>
</div>

{{-- Variables JS --}}
<script>
  window.playerCount  = {{ (int) $playerCount }};
  window.currentTurn  = {{ (int) $turn }};
  window.gameIdFront  = {{ (int) $gameId }};
  window.isEn         = false;
</script>
@endsection
