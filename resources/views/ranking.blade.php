<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Tabla de puntajes</title>
  <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;600;700&family=Luckiest+Guy&display=swap" rel="stylesheet">
  <link rel="icon" type="image/png" href="{{ asset('Fotos Equipo/LogoFinal.png') }}" sizes="32x32">
  <link rel="stylesheet" href="{{ asset('styleR.css') }}">
</head>
<body>
  <div class="bg"></div>

  <main class="container">
    <section class="hero">
      <h1 class="page-title">Tabla de puntajes</h1>
    </section>

    <section class="scoreboard">
      <ul class="score-grid" id="score-list"></ul>
    </section>

     <section class="scoreboard">
      <ul class="score-grid">
        <li class="score-card" data-rank="1">
          <span class="rank">1</span>
          <div class="who"><h3>Dante</h3></div>
          <span class="points">128</span>
        </li>
        <li class="score-card" data-rank="2">
          <span class="rank">2</span>
          <div class="who"><h3>Romi</h3></div>
          <span class="points">121</span>
        </li>
        <li class="score-card" data-rank="3">
          <span class="rank">3</span>
          <div class="who"><h3>Vicky</h3></div>
          <span class="points">109</span>
        </li>
        <li class="score-card">
          <span class="rank">4</span>
          <div class="who"><h3>Santi</h3></div>
          <span class="points">96</span>
        </li>
      </ul>
    </section>

    <div class="menu-btn-container">
      <a class="back-menu" href="{{ route('home') }}">← Volver al menú</a>
    </div>
  </main>

  <footer class="footer">
    <small>© 2025 DinoDiceTeam</small>
  </footer>

  <script src="{{ asset('scriptR.js') }}"></script>

</body>
</html>
