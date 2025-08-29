<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Mutación Jurásica - Inicio</title>
  <link rel="icon" type="image/png" href="/Fotos Equipo/LogoFinal.png" sizes="32x32">
  <style>
    html, body {
      height: 100%;
      min-height: 100vh;
      margin: 0;
      padding: 0;
      overflow-x: hidden;
    }
    body {
      display: flex; flex-direction: column;
      min-height: 100vh; width: 100vw;
      background: url('/ICONOS MENU/Fondo.jpg') no-repeat center center fixed;
      background-size: cover;
      font-family: Arial, Helvetica, sans-serif;
      position: relative;
      animation: pageFade 500ms ease-out;
    }
    @keyframes pageFade { from{opacity:0} to{opacity:1} }
    body::before {
      content: ""; position: fixed; inset: 0;
      background: rgba(0,0,0,.25); z-index: 0;
      pointer-events: none;
    }

    :root { --hero: #28d36a; --hero-dark: #1ebc5c; }

    .container {
      flex: 1 0 auto; position: relative; z-index: 1;
      margin: 0 auto; width: 100%; max-width: 100vw;
    }

    .titulo {
      max-width: 90vw; width: 90vw; min-width: 120px;
      margin: 70px auto 18px;
      display: block; text-align: center;
      animation: zoomTambaleo 3s ease-in-out infinite;
      transform-origin: center;
      filter: drop-shadow(0 0 5px #000);
    }
    @keyframes zoomTambaleo {
      0%{transform:scale(1) rotate(0deg)}
      10%{transform:scale(1.05)}
      20%{transform:scale(1)}
      30%{transform:scale(1) rotate(-2deg)}
      40%{transform:scale(1) rotate(2deg)}
      50%{transform:scale(1) rotate(-2deg)}
      60%{transform:scale(1) rotate(2deg)}
      70%{transform:scale(1) rotate(-1deg)}
      80%{transform:scale(1) rotate(1deg)}
      100%{transform:scale(1) rotate(0deg)}
    }

    .menu {
      display: flex; justify-content: center; gap: 2.5vw;
      margin-top: 10px; flex-wrap: wrap;
    }
    .boton-img {
      width: 210px; max-width: 60vw; min-width: 120px;
      margin: 14px 0; transition: transform .3s, filter .3s;
      cursor: pointer; filter: drop-shadow(0 0 5px #000);
    }
    .boton-img:hover {
      transform: scale(1.08);
      filter: brightness(1.3) drop-shadow(0 0 12px #6aff9f);
    }

    .auth-bar {
      position: fixed; top: 16px; right: 20px; z-index: 1100;
      display: flex; gap: 22px; align-items: center;
    }
    .auth-btn {
      background: linear-gradient(180deg, var(--hero), var(--hero-dark));
      color: #0d1b12; font-weight: 800; border: none;
      border-radius: 12px; padding: 12px 28px; font-size: 1.1rem;
      cursor: pointer; box-shadow: 0 6px 16px rgba(40,211,106,.25);
      transition: transform .15s, filter .15s, box-shadow .15s;
      filter: drop-shadow(0 0 6px #000a);
    }
    .auth-btn:hover, .auth-btn:focus {
      transform: scale(1.07);
      filter: brightness(1.12) drop-shadow(0 0 12px #6aff9f);
      box-shadow: 0 8px 22px rgba(40,211,106,.35);
    }

    .modal-auth {
      position: fixed; inset: 0; z-index: 2000;
      display: flex; align-items: center; justify-content: center;
      background: rgba(0,0,0,0.55); backdrop-filter: blur(2px);
    }
    .modal-content {
      position: relative; width: 100%; max-width: 340px; min-width: 220px;
      border-radius: 18px; overflow: hidden;
      box-shadow: 0 12px 48px #000c;
      background: linear-gradient(rgba(0,0,0,.35), rgba(0,0,0,.35)),
                  url('/ICONOS MENU/pabntallaLogin.png') center center / cover no-repeat,
                  #1f1f1f;
      animation: modalPop 220ms ease-out;
      padding: 28px 20px 22px; display: flex; flex-direction: column; align-items: center;
    }
    @keyframes modalPop{ from{transform:scale(.96);opacity:0} to{transform:scale(1);opacity:1} }
    .close {
      position:absolute; right:10px; top:6px;
      font-size:28px; color:#fff; cursor:pointer;
      text-shadow:0 2px 8px #000a;
    }

    .modal-panel {
      width: 100%; padding: 18px 10px 14px;
      border-radius: 16px; background: rgba(0,0,0,.55);
      box-shadow: 0 10px 30px #0007, inset 0 1px 0 rgba(255,255,255,.08);
      backdrop-filter: blur(3px); color: #fff;
    }
    .modal-panel h2 { margin: 0 0 10px; font-weight: 800; text-shadow: 0 2px 10px #0009; }

    .modal-form { margin-top: 6px; }
    .modal-content input, .modal-content button {
      width: 100%; margin: 8px 0; padding: 12px 14px;
      border-radius: 12px; border: none;
    }
    .btn-primary-hero {
      background: linear-gradient(180deg, var(--hero), var(--hero-dark));
      color: #0d1b12; font-weight: 800;
      box-shadow: 0 6px 16px rgba(40,211,106,.35);
      cursor: pointer; transition: transform .12s, filter .12s, box-shadow .12s;
    }
    .btn-primary-hero:hover {
      transform: translateY(-1px);
      filter: brightness(1.03);
      box-shadow: 0 8px 22px rgba(40,211,106,.45);
    }
    .form-error { color:#ff6b6b; }

    .site-footer {
      position: static; width: 100vw; margin-top: 24px;
      font-size: 13px; padding: 8px 5px;
      background: rgba(0,0,0,0.4); color: #ddd; text-align: center;
      backdrop-filter: blur(2px); pointer-events: auto;
      z-index: 1200;
    }
    .site-footer .social {
      margin: 6px 0; display: flex; justify-content: center; gap: 14px;
    }
    .site-footer .social img {
      width: 28px; height: 28px; object-fit: contain;
      transition: transform .2s, filter .2s;
      filter: brightness(0.95);
    }
    .site-footer .social img:hover {
      transform: scale(1.1); filter: brightness(1.2);
    }
    .site-footer a { color: #fff; text-decoration: none; }
    .site-footer a:hover { text-decoration: underline; }
    .site-footer .copyright { font-size: 11px; color: #aaa; margin-top: 4px; }

    @media (max-width: 700px) {
      .titulo { max-width: 60vw; width: 60vw; margin: auto; text-align: center; }
      .boton-img { max-width: 32vw; width: 32vw; min-width: 70px; margin: 10px 0; }
      .auth-bar { top:16px; right:16px; gap:10px; justify-content:flex-end; }
      .auth-btn { max-width:110px; min-width:90px; font-size:1rem; padding:10px 0; }
      .menu { margin-top:18px; flex-direction: row!important; justify-content:center; gap:2vw; flex-wrap:nowrap; }
      .site-footer { position: fixed; left:0; bottom:0; width:100vw; z-index:1200; }
    }

    @media (min-width: 1000px) {
      .container {
        max-width: min(1100px, 92vw); margin: 0 auto;
        padding-top: clamp(8px, 2vh, 24px); padding-bottom: clamp(8px, 2vh, 24px);
        min-height: calc(100vh - 80px);
        display: flex; flex-direction: column; justify-content: center;
      }
      .titulo {
        width: clamp(360px, 32vw, 700px); max-width: none;
        margin-top: clamp(10px, 6vh, 40px); margin-bottom: clamp(12px, 3vh, 24px);
      }
      .menu { margin-top: clamp(8px, 2vh, 24px); gap: clamp(20px, 3vw, 56px); }
      .boton-img { width: clamp(140px, 12vw, 240px); max-width: none; min-width: 120px; margin: 14px 0; }
      .site-footer { position: fixed; left:0; right:0; bottom:0; width:100vw; margin:0; z-index:1200; }
      html, body { overflow-y: hidden; }
    }
  </style>
  <link rel="icon" type="image/png" href="{{ asset('ICONOS MENU/Titulo.png') }}" sizes="32x32">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <audio id="background-music" src="{{ asset('Sonidos/lounge-jazz-elevator-music-324902.mp3') }}" preload="auto" autoplay loop></audio>
  <audio id="click-sound" src="{{ asset('Sonidos/dinosaur-2-86565.mp3') }}" preload="auto"></audio>

  <div class="auth-bar">
    <button class="auth-btn" onclick="abrirModalLogin()">Iniciar sesión</button>
    <button class="auth-btn" onclick="abrirModalRegistro()">Registrarse</button>
  </div>

  <div class="container py-4">
    <div class="row justify-content-center">
      <div class="col-12 text-center">
        <img src="{{ asset('ICONOS MENU/Titulo.png') }}" alt="Mutación Jurásica" class="titulo img-fluid mb-3">
      </div>
    </div>
    <div class="row justify-content-center">
      <div class="col-12">
        <div class="menu">
          <a href="#" onclick="playClick()" class="btn p-0">
            <img src="{{ asset('ICONOS MENU/Extra-2.png') }}" alt="Extra" class="boton-img img-fluid">
          </a>
          <a href="{{ route('juego') }}" onclick="playClickAndGo(event, '{{ route('juego') }}')" class="btn p-0">
            <img src="{{ asset('ICONOS MENU/JugarBoton.png') }}" alt="Jugar" class="boton-img img-fluid">
          </a>
          <a href="#" onclick="playClick()" class="btn p-0">
            <img src="{{ asset('ICONOS MENU/OpcionesBoton.png') }}" alt="Opciones" class="boton-img img-fluid">
          </a>
        </div>
      </div>
    </div>
  </div>

  <div id="modal-auth" class="modal-auth" style="display:none;">
    <div class="modal-content">
      <span class="close" onclick="cerrarModalAuth()">&times;</span>
      <div id="login-form">
        <div class="modal-panel">
          <h2>Iniciar Sesión</h2>
          <div class="modal-form">
            <input type="text" id="login-usuario" placeholder="Usuario" required>
            <input type="password" id="login-password" placeholder="Contraseña" required>
            <button class="btn-primary-hero" onclick="loginUsuario()">Entrar</button>
            <p class="mt-2">¿No tienes cuenta? <a href="#" onclick="mostrarRegistro();return false;">Regístrate</a></p>
            <div id="login-error" class="form-error"></div>
          </div>
        </div>
      </div>
      <div id="registro-form" style="display:none;">
        <div class="modal-panel">
          <h2>Registrarse</h2>
          <div class="modal-form">
            <input type="text" id="registro-usuario" placeholder="Usuario" required>
            <input type="password" id="registro-password" placeholder="Contraseña" required>
            <button class="btn-primary-hero btn-registro" onclick="registrarUsuario()">Crear cuenta</button>
            <p class="mt-2">¿Ya tienes cuenta? <a href="#" onclick="mostrarLogin();return false;">Inicia sesión</a></p>
            <div id="registro-error" class="form-error"></div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <footer class="site-footer">
    <p>Seguinos en nuestras redes:</p>
    <div class="social">
      <a href="https://www.instagram.com/dinodiceteam?igsh=MTAyNXU0MTh2c3A4eQ==" target="_blank">
        <img src="{{ asset('ICONOS MENU/Instagram-Logo-2016.png') }}" alt="Instagram">
      </a>
      <a href="https://twitter.com" target="_blank">
        <img src="{{ asset('ICONOS MENU/Logo_of_Twitter.svg.png') }}" alt="Twitter" class="twitter">
      </a>
      <a href="https://facebook.com" target="_blank">
        <img src="{{ asset('ICONOS MENU/Facebook-Logo-2013.png') }}" alt="Facebook">
      </a>
    </div>
    <p><a href="#" target="_blank" class="link-light">Ir a nuestro sitio web</a></p>
    <p class="copyright">© 2025 DINODICE. Todos los derechos reservados.</p>
  </footer>

  <script>
    window.addEventListener("DOMContentLoaded", () => {
      const musica = document.getElementById("background-music");
      if (musica) musica.volume = 0.2; // volumen bajo por defecto
    });

    function playClick(){
      const s = document.getElementById('click-sound');
      if(!s) return;
      s.currentTime = 0; s.volume = 0.5; s.play();
    }
    function playClickAndGo(event, url){
      event.preventDefault();
      const s = document.getElementById('click-sound');
      if(!s){ window.location.href = url; return; } // fallback sin sonido
      s.currentTime = 0; s.volume = 0.5; s.play();
      const go = ()=> window.location.href = url;
      s.onended = go; setTimeout(go, 1000);
    }
    document.addEventListener('click', function iniciarMusica(){
      const m = document.getElementById("background-music");
      if (m && m.paused) m.play(); // autoplay bloqueado en algunos navegadores → inicia al primer click
      document.removeEventListener('click', iniciarMusica);
    });

    function abrirModalLogin(){ document.getElementById('modal-auth').style.display='flex'; mostrarLogin(); }
    function abrirModalRegistro(){ document.getElementById('modal-auth').style.display='flex'; mostrarRegistro(); }
    function cerrarModalAuth(){ document.getElementById('modal-auth').style.display='none'; }
    function mostrarLogin(){
      document.getElementById('login-form').style.display='block';
      document.getElementById('registro-form').style.display='none';
    }
    function mostrarRegistro(){
      document.getElementById('login-form').style.display='none';
      document.getElementById('registro-form').style.display='block';
    }
    function loginUsuario(){
      const u = document.getElementById('login-usuario').value;
      const p = document.getElementById('login-password').value;
      console.log('Login:', u, p);
      cerrarModalAuth();
    }
    function registrarUsuario(){
      const u = document.getElementById('registro-usuario').value;
      const p = document.getElementById('registro-password').value;
      console.log('Registro:', u, p);
      cerrarModalAuth();
    }
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
