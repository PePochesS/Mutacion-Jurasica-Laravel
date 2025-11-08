@extends('layouts.app')
@section('title','Game')

@push('page_vite')
  @vite(['resources/css/styleJuego.css','resources/js/script.js'])
@endpush

@section('content')

<div class="game-header">
  <div class="gh-left">
    <div id="turno-label" class="gh-title">
      Game #{{ $gameId }} — Players: {{ $playerCount }} — Player {{ $turn }}’s turn
    </div>
    <div id="ronda-label" class="gh-subtitle">Round 1/6</div>
  </div>

  <div class="gh-actions">
    {{-- Dice --}}
    <div class="dice-wrap">
      <div id="die-face" class="die-face">—</div>
      <button type="button" class="btn btn-sm btn-secondary" onclick="rollDie()">
        Roll die
      </button>
    </div>

    {{-- Rules (open by hash) --}}
    <a href="#rules-modal" class="btn btn-sm btn-info">Rules</a>

    {{-- Next turn / Finish --}}
    <button id="btn-next-turn" type="button" class="btn btn-sm btn-outline-light" onclick="siguienteTurno()">
      Next turn
    </button>

    <form id="end-game-form" method="POST" action="{{ route('juego.end') }}" class="d-inline">
      @csrf
      <input type="hidden" name="_lang" value="en">
      <input type="hidden" name="game_id" value="{{ $gameId }}">
      <input type="hidden" name="scores_json" id="scores_json">
      <button type="button" class="btn btn-sm btn-danger" onclick="finalizarPartida()">
        Finish game
      </button>
    </form>
  </div>
</div>

<div class="game-row">
  <div class="panel-dinosaurios">
    <h2>Dinosaurs</h2>
    <img src="{{ asset('images/game-assets/Dinosaurio 1.png') }}" alt="dinosaur 1" draggable="true">
    <img src="{{ asset('images/game-assets/Dinosaurio 2.png') }}" alt="dinosaur 2" draggable="true">
    <img src="{{ asset('images/game-assets/Dinosaurio 3.png') }}" alt="dinosaur 3" draggable="true">
    <img src="{{ asset('images/game-assets/Dinosaurio 4.png') }}" alt="dinosaur 4" draggable="true">
    <img src="{{ asset('images/game-assets/Dinosaurio 5.png') }}" alt="dinosaur 5" draggable="true">
    <img src="{{ asset('images/game-assets/Dinosaurio 6.png') }}" alt="dinosaur 6" draggable="true">
  </div>

  <div class="zona-juego">
    @for ($i = 1; $i <= 7; $i++)
      <div class="recinto" id="recinto{{ $i }}">
        <h3>Area {{ $i }}</h3>
        <div class="dropzone"></div>
        <div class="acciones">
          <button type="button" onclick="limpiarRecinto('recinto{{ $i }}')" class="btn btn-danger btn-sm">Clear Area</button>
        </div>
        <div class="puntaje-recinto"><span>Points: <span id="puntos-recinto{{ $i }}">0</span></span></div>
      </div>
    @endfor
  </div>

  <div class="puntaje">
    <span class="fw-bold">Total Score</span>
    <p id="puntos">0</p>
  </div>
</div>

<a href="{{ route('en.home') }}" class="btn-volver btn btn-warning">Back</a>

{{-- Rules Modal (EN) --}}
<div id="rules-modal" class="modal-auth rules-modal" role="dialog" aria-modal="true" aria-labelledby="rules-title">
  <div class="rules-card" role="document">
    <div class="rules-head">
      <div>
        <h2 id="rules-title" class="rules-title">Area Rules</h2>
        <p class="rules-sub">Quick summary of scoring and restrictions</p>
      </div>
      {{-- Close (remove hash) --}}
      <a href="#" class="rules-close" aria-label="Close">×</a>
    </div>

    <div class="rules-body" id="rules-body">
      <ul class="rules-list">
        <li><b>Area 1:</b> Same species. Max 6. Points: 2, 4, 8, 12, 18, 24.</li>
        <li><b>Area 2:</b> Any species. Max 3. Points: 7 if there are 3.</li>
        <li><b>Area 3:</b> Same species. Max 2. Points: 5 if both match.</li>
        <li><b>Area 4:</b> Only 1 dino. +7 if it’s the most common species on the board.</li>
        <li><b>Area 5:</b> Any species. Max 6. Points: 1, 3, 6, 10, 15, 21.</li>
        <li><b>Area 6:</b> Only 1 dino. +7 if that species appears only once on the whole board.</li>
        <li><b>Area 7:</b> Only 1 dino. +1 if there is one.</li>
      </ul>
      <div class="rules-note">
        <b>Turns:</b> the match lasts for <b>6 rounds</b>. After round 6, “Next turn” is disabled.<br>
        <b>Die:</b> faces: Bone, Potion, Plants, Rocks and DINODICE!.
      </div>
    </div>
  </div>
</div>

<script>
  window.playerCount  = {{ (int) $playerCount }};
  window.currentTurn  = {{ (int) $turn }};
  window.gameIdFront  = {{ (int) $gameId }};
  window.isEn         = true;
</script>
@endsection
