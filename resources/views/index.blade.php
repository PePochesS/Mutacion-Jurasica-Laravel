<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Mutación Jurásica - Inicio</title>

  <link rel="icon" type="image/png" href="{{ asset('images/game-assets/LogoFinal.png') }}" sizes="32x32">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  @vite(['resources/css/style.css', 'resources/js/scriptM.js'])
</head>

<body>
  <audio id="background-music" src="{{ asset('sounds/lounge-jazz-elevator-music-324902.mp3') }}" preload="auto" autoplay loop></audio>
  <audio id="click-sound" src="{{ asset('sounds/dinosaur-2-86565.mp3') }}" preload="auto"></audio>

  <div class="auth-bar">
    <button class="auth-btn" type="button" onclick="abrirModalLogin()">Iniciar sesión</button>
    <button class="auth-btn" type="button" onclick="abrirModalRegistro()">Registrarse</button>
  </div>

  <div class="container py-4">
    <div class="row justify-content-center">
      <div class="col-12 text-center">
        <img src="{{ asset('images/menu-icons/Titulo.png') }}" alt="Mutación Jurásica" class="titulo img-fluid mb-3">
      </div>
    </div>

    <div class="row justify-content-center">
      <div class="col-12">
        <div class="menu">
          <a href="#" onclick="playClick(); return false;" class="btn p-0" aria-label="Extra">
            <img src="{{ asset('images/menu-icons/Extra-2.png') }}" alt="Extra" class="boton-img img-fluid">
          </a>

          @php($urlJuego = route('juego'))
          <a href="{{ $urlJuego }}" onclick="playClickAndGo(event, '{{ $urlJuego }}')" class="btn p-0" aria-label="Jugar">
            <img src="{{ asset('images/menu-icons/JugarBoton.png') }}" alt="Jugar" class="boton-img img-fluid">
          </a>

          <a href="#" onclick="playClick(); return false;" class="btn p-0" aria-label="Opciones">
            <img src="{{ asset('images/menu-icons/OpcionesBoton.png') }}" alt="Opciones" class="boton-img img-fluid">
          </a>
        </div>
      </div>
    </div>
  </div>

  <div id="modal-auth" class="modal-auth" style="display:none;" role="dialog" aria-modal="true" aria-labelledby="auth-title">
    <div class="modal-content">
      <button class="close" type="button" aria-label="Cerrar" onclick="cerrarModalAuth()">&times;</button>

      <div id="login-form">
        <div class="modal-panel">
          <h2 id="auth-title">Iniciar Sesión</h2>
          <div class="modal-form">
            <input type="text" id="login-usuario" placeholder="Usuario" required>
            <input type="password" id="login-password" placeholder="Contraseña" required>
            <button class="btn-primary-hero" type="button" onclick="loginUsuario()">Entrar</button>
            <p class="mt-2">¿No tienes cuenta? <a href="#" onclick="mostrarRegistro(); return false;">Regístrate</a></p>
            <div id="login-error" class="form-error"></div>
          </div>
        </div>
      </div>

      <div id="registro-form" style="display:none;">
        <div class="modal-panel">
          <h2>Registrarse</h2>
          <div class="modal-form">
            <input type="text" id="registro-email" placeholder="@gmail" required>
            <input type="text" id="registro-usuario" placeholder="Usuario" required>
            <input type="password" id="registro-password" placeholder="Contraseña" required>
            <button class="btn-primary-hero btn-registro" type="button" onclick="registrarUsuario()">Crear cuenta</button>
            <p class="mt-2">¿Ya tienes cuenta? <a href="#" onclick="mostrarLogin(); return false;">Inicia sesión</a></p>
            <div id="registro-error" class="form-error"></div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <footer class="site-footer">
    <p>Seguinos en nuestras redes:</p>
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
    <p><a href="https://pepochess.github.io/Pagina-Web-DinoDiceTeam" target="_blank" class="link-light" rel="noopener">Ir a nuestro sitio web</a></p>
    <p class="copyright">© 2025 DINODICE. Todos los derechos reservados.</p>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
