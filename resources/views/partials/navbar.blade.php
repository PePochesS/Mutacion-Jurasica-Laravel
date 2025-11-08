@php($isEn = request()->is('en') || request()->is('en/*'))

<div class="auth-bar">
  @guest
    <a href="#" class="auth-btn auth-btn--sm" onclick="abrirModalLogin(); return false;">
      {{ $isEn ? 'Sign In' : 'Iniciar sesión' }}
    </a>
    <a href="#" class="auth-btn auth-btn--sm" onclick="abrirModalRegistro(); return false;">
      {{ $isEn ? 'Sign Up' : 'Registrarse' }}
    </a>
  @endguest
</div>
