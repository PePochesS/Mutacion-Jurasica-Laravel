<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Pantalla de Juego - DinoDice</title>
  <link rel="icon" type="image/png" href="{{ asset('Fotos Equipo/LogoFinal.png') }}" sizes="32x32"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link rel="stylesheet" href="{{ asset('stylejuego.css') }}"/>
</head>
<body>
  <div class="panel-dinosaurios">
    <h2>Dinosaurios</h2>
    <img src="{{ asset('assets juego/Dinosaurio 1.png') }}" alt="dinosaurio 1" draggable="true">
    <img src="{{ asset('assets juego/Dinosaurio 2.png') }}" alt="dinosaurio 2" draggable="true">
    <img src="{{ asset('assets juego/Dinosaurio 3.png') }}" alt="dinosaurio 3" draggable="true">
    <img src="{{ asset('assets juego/Dinosaurio 4.png') }}" alt="dinosaurio 4" draggable="true">
    <img src="{{ asset('assets juego/Dinosaurio 5.png') }}" alt="dinosaurio 5" draggable="true">
    <img src="{{ asset('assets juego/Dinosaurio 6.png') }}" alt="dinosaurio 6" draggable="true">
  </div>

  <div class="zona-juego">
    <div class="recinto" id="recinto1">
      <h3>Recinto 1</h3>
      <div class="dropzone"></div>
      <div class="acciones">
        <button onclick="limpiarRecinto('recinto1')" class="btn btn-danger btn-sm">Limpiar Recinto</button>
      </div>
    </div>

    <div class="recinto" id="recinto2">
      <h3>Recinto 2</h3>
      <div class="dropzone"></div>
      <div class="acciones">
        <button onclick="limpiarRecinto('recinto2')" class="btn btn-danger btn-sm">Limpiar Recinto</button>
      </div>
    </div>

    <div class="recinto" id="recinto3">
      <h3>Recinto 3</h3>
      <div class="dropzone"></div>
      <div class="acciones">
        <button onclick="limpiarRecinto('recinto3')" class="btn btn-danger btn-sm">Limpiar Recinto</button>
      </div>
    </div>

    <div class="recinto" id="recinto4">
      <h3>Recinto 4</h3>
      <div class="dropzone"></div>
      <div class="acciones">
        <button onclick="limpiarRecinto('recinto4')" class="btn btn-danger btn-sm">Limpiar Recinto</button>
      </div>
    </div>

    <div class="recinto" id="recinto5">
      <h3>Recinto 5</h3>
      <div class="dropzone"></div>
      <div class="acciones">
        <button onclick="limpiarRecinto('recinto5')" class="btn btn-danger btn-sm">Limpiar Recinto</button>
      </div>
    </div>

    <div class="recinto" id="recinto6">
      <h3>Recinto 6</h3>
      <div class="dropzone"></div>
      <div class="acciones">
        <button onclick="limpiarRecinto('recinto6')" class="btn btn-danger btn-sm">Limpiar Recinto</button>
      </div>
    </div>

    <div class="recinto" id="recinto7">
      <h3>Recinto 7</h3>
      <div class="dropzone"></div>
      <div class="acciones">
        <button onclick="limpiarRecinto('recinto7')" class="btn btn-danger btn-sm">Limpiar Recinto</button>
      </div>
    </div>
  </div>

  <div class="puntaje">
    <span class="fw-bold">Puntaje Total</span>
    <p id="puntos">0</p>
  </div>

  <a href="{{ route('ranking') }}" class="btn-ranking btn btn-warning">Ver Ranking</a>
  <a href="{{ route('home') }}" class="btn-volver btn btn-warning">Volver</a>

  <script src="{{ asset('script.js') }}"></script>
</body>
</html>
