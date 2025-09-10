<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Tabla de puntajes</title>
  <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;600;700&family=Luckiest+Guy&display=swap" rel="stylesheet">
  <link rel="icon" type="image/png" href="{{ asset('images/game-assets/LogoFinal.png') }}" sizes="32x32">
    
  @vite([
    'resources/css/styleR.css',
    'resources/js/scriptR.js'
  ])

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

    <div class="menu-btn-container">
      <a class="back-menu" href="{{ route('home') }}">← Volver al menú</a>
    </div>
  </main>

  <footer class="footer">
    <small>© 2025 DinoDiceTeam</small>
  </footer>
</body>
</html>
