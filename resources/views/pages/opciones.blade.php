@extends('layouts.app')

@section('vite')
  @vite(['resources/css/StyleOpciones.css'])
@endsection

@section('content')
<main class="options-wrap">
  <section class="options-container">
    <h1 class="options-title">Opciones</h1>
    <h2 class="options-subtitle">Idioma</h2>

    <div class="options-buttons">
      <button type="button" class="lang-btn is-active" aria-pressed="true" disabled>Español</button>

      <a href="{{ route('en.options') }}" class="lang-btn" aria-label="Switch to English">English</a>
    </div>

    <a href="{{ route('home') }}" class="options-back-btn">Volver al inicio</a>
  </section>
</main>
@endsection
