@extends('layouts.app')
@section('title','Juego')

@push('page_vite')
  @vite(['resources/css/styleJuego.css','resources/js/script.js'])
@endpush

@section('content')

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
    <div class="recinto" id="recinto1">
      <h3>Recinto 1</h3>
      <div class="dropzone"></div>
      <div class="acciones">
        <button type="button" onclick="limpiarRecinto('recinto1')" class="btn btn-danger btn-sm">Limpiar Recinto</button>
      </div>
      <div class="puntaje-recinto"><span>Puntos: <span id="puntos-recinto1">0</span></span></div>
    </div>

    <div class="recinto" id="recinto2">
      <h3>Recinto 2</h3>
      <div class="dropzone"></div>
      <div class="acciones">
        <button type="button" onclick="limpiarRecinto('recinto2')" class="btn btn-danger btn-sm">Limpiar Recinto</button>
      </div>
      <div class="puntaje-recinto"><span>Puntos: <span id="puntos-recinto2">0</span></span></div>
    </div>

    <div class="recinto" id="recinto3">
      <h3>Recinto 3</h3>
      <div class="dropzone"></div>
      <div class="acciones">
        <button type="button" onclick="limpiarRecinto('recinto3')" class="btn btn-danger btn-sm">Limpiar Recinto</button>
      </div>
      <div class="puntaje-recinto"><span>Puntos: <span id="puntos-recinto3">0</span></span></div>
    </div>

    <div class="recinto" id="recinto4">
      <h3>Recinto 4</h3>
      <div class="dropzone"></div>
      <div class="acciones">
        <button type="button" onclick="limpiarRecinto('recinto4')" class="btn btn-danger btn-sm">Limpiar Recinto</button>
      </div>
      <div class="puntaje-recinto"><span>Puntos: <span id="puntos-recinto4">0</span></span></div>
    </div>

    <div class="recinto" id="recinto5">
      <h3>Recinto 5</h3>
      <div class="dropzone"></div>
      <div class="acciones">
        <button type="button" onclick="limpiarRecinto('recinto5')" class="btn btn-danger btn-sm">Limpiar Recinto</button>
      </div>
      <div class="puntaje-recinto"><span>Puntos: <span id="puntos-recinto5">0</span></span></div>
    </div>

    <div class="recinto" id="recinto6">
      <h3>Recinto 6</h3>
      <div class="dropzone"></div>
      <div class="acciones">
        <button type="button" onclick="limpiarRecinto('recinto6')" class="btn btn-danger btn-sm">Limpiar Recinto</button>
      </div>
      <div class="puntaje-recinto"><span>Puntos: <span id="puntos-recinto6">0</span></span></div>
    </div>

    <div class="recinto" id="recinto7">
      <h3>Recinto 7</h3>
      <div class="dropzone"></div>
      <div class="acciones">
        <button type="button" onclick="limpiarRecinto('recinto7')" class="btn btn-danger btn-sm">Limpiar Recinto</button>
      </div>
      <div class="puntaje-recinto"><span>Puntos: <span id="puntos-recinto7">0</span></span></div>
    </div>
  </div>

  <div class="puntaje">
    <span class="fw-bold">Puntaje Total</span>
    <p id="puntos">0</p>
  </div>

  <div id="especificaciones-recintos" style="display:none; margin:32px 0 0 0;"></div>

  <a href="{{ route('ranking') }}" class="btn-ranking btn btn-warning">Ver Ranking</a>
  <a href="{{ route('home') }}" class="btn-volver btn btn-warning">Volver</a>
@endsection
