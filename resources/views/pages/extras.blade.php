@extends('layouts.app')

@section('vite')
  @vite(['resources/css/StyleExtra.css'])
@endsection

@section('content')
<main class="extras-wrap">
  <section class="extras-container">
    <span class="bolt b1"></span>
    <span class="bolt b2"></span>
    <span class="bolt b3"></span>
    <span class="bolt b4"></span>

    <h1 class="extras-title">Información del Juego</h1>

    <h2 class="extras-subtitle">Reglas</h2>
    <ul class="extras-list">
      <li>Colocá un dinosaurio por turno en el recinto permitido.</li>
      <li>El dado determina restricciones o zonas especiales.</li>
      <li>Los recintos tienen condiciones que modifican los puntos.</li>
      <li>Al finalizar los turnos se cuentan los puntos totales.</li>
      <li>Gana quien tenga la puntuación más alta.</li>
    </ul>

    <a href="{{ route('home') }}" class="extras-back-btn">Volver al inicio</a>
  </section>
</main>
@endsection
