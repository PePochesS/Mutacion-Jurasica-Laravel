@extends('layouts.app')

@section('vite')
  @vite(['resources/css/StyleOpciones.css'])
@endsection

@section('content')
<main class="options-wrap">
  <section class="options-container">
    <h1 class="options-title">Settings</h1>
    <h2 class="options-subtitle">Language</h2>

    <div class="options-buttons">
      
      <a href="{{ route('settings.index') }}" class="lang-btn" aria-label="Cambiar a Español">Español</a>

      <button type="button" class="lang-btn is-active" aria-pressed="true" disabled>English</button>

    </div>

    <a href="{{ route('en.home') }}" class="options-back-btn">Back to home</a>
  </section>
</main>
@endsection
