@php($isEn = request()->is('en') || request()->is('en/*'))

<footer class="site-footer">

  {{-- Título --}}
  <p>
    {{ $isEn ? 'Follow us on our networks:' : 'Seguinos en nuestras redes:' }}
  </p>

  {{-- Redes sociales (se mantienen EXACTAS, no se toca nada) --}}
  <div class="social">
    <a href="https://www.instagram.com/dinodiceteam?igsh=MTAyNXU0MTh2c3A4eQ==" target="_blank" rel="noopener">
      <img src="{{ asset('images/menu-icons/Instagram-Logo-2016.png') }}" alt="Instagram">
    </a>
    <a href="https://twitter.com" target="_blank" rel="noopener">
      <img src="{{ asset('images/menu-icons/Logo_of_Twitter.svg.png') }}" alt="Twitter" class="twitter">
    </a>
    <a href="https://facebook.com" target="_blank" rel="noopener">
      <img src="{{ asset('images/menu-icons/Facebook-Logo-2013.png') }}" alt="Facebook">
    </a>
  </div>

  {{-- Link sitio web --}}
  <p>
    <a href="https://pepochess.github.io/Pagina-Web-DinoDiceTeam"
       target="_blank"
       class="link-light"
       rel="noopener">
      {{ $isEn ? 'Go to our website' : 'Ir a nuestro sitio web' }}
    </a>
  </p>

  {{-- Copyright --}}
  <p class="copyright">
    © 2025 DINODICE.
    {{ $isEn ? 'All rights reserved.' : 'Todos los derechos reservados.' }}
  </p>

</footer>
