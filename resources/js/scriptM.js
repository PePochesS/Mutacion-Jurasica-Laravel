window.addEventListener("DOMContentLoaded", () => {
  const musica = document.getElementById("background-music");
  if (musica) musica.volume = 0.2;
});

// Click sonido simple
window.playClick = function () {
  const s = document.getElementById('click-sound');
  if (!s) return;
  s.currentTime = 0;
  s.volume = 0.5;
  s.play();
};

// Click con redirección
window.playClickAndGo = function (event, url) {
  event.preventDefault();
  const s = document.getElementById('click-sound');
  if (!s) {
    window.location.href = url;
    return;
  }
  s.currentTime = 0;
  s.volume = 0.5;
  s.play();
  const go = () => window.location.href = url;
  s.onended = go;
  setTimeout(go, 1000); // fallback si no se dispara 'onended'
};

// Autoplay música después de cualquier clic
document.addEventListener('click', function iniciarMusica() {
  const m = document.getElementById("background-music");
  if (m && m.paused) m.play();
  document.removeEventListener('click', iniciarMusica);
});

// Modal de login / registro
window.abrirModalLogin = function () {
  document.getElementById('modal-auth').style.display = 'flex';
  mostrarLogin();
};
window.abrirModalRegistro = function () {
  document.getElementById('modal-auth').style.display = 'flex';
  mostrarRegistro();
};
window.cerrarModalAuth = function () {
  document.getElementById('modal-auth').style.display = 'none';
};

window.mostrarLogin = function () {
  document.getElementById('login-form').style.display = 'block';
  document.getElementById('registro-form').style.display = 'none';
};
window.mostrarRegistro = function () {
  document.getElementById('login-form').style.display = 'none';
  document.getElementById('registro-form').style.display = 'block';
};

// Lógica fake de login / registro (para testing)
window.loginUsuario = function () {
  const u = document.getElementById('login-usuario').value;
  const p = document.getElementById('login-password').value;
  console.log('Login:', u, p);
  cerrarModalAuth();
};
window.registrarUsuario = function () {
  const u = document.getElementById('registro-usuario').value;
  const p = document.getElementById('registro-password').value;
  console.log('Registro:', u, p);
  cerrarModalAuth();
};
