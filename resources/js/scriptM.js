// Initialize small behaviors and accessible eye toggles
window.addEventListener('DOMContentLoaded', () => {
  const musica = document.getElementById('background-music');
  if (musica) musica.volume = 0.2;

  // tiny helper to initialize an eye toggle for an input
  function initEyeToggle(toggleId, inputId) {
    const btn = document.getElementById(toggleId);
    const input = document.getElementById(inputId);
    if (!btn || !input) return;

    // idempotent guard
    if (btn.__eyeInit) return;
    btn.__eyeInit = true;

    btn.setAttribute('aria-pressed', input.type === 'text' ? 'true' : 'false');
    btn.setAttribute('aria-label', btn.getAttribute('aria-label') || 'Mostrar contraseña');
    btn.tabIndex = 0;

    const toggle = () => {
      const showing = input.type === 'text';
      input.type = showing ? 'password' : 'text';
      const nowShowing = input.type === 'text';
      btn.classList.toggle('active', nowShowing);
      btn.setAttribute('aria-pressed', nowShowing ? 'true' : 'false');
      try { btn.focus(); } catch (e) {}
    };

    btn.addEventListener('click', (e) => { e.preventDefault(); toggle(); });
    btn.addEventListener('keydown', (e) => {
      if (e.key === 'Enter' || e.key === ' ' || e.key === 'Spacebar') {
        e.preventDefault();
        toggle();
      }
    });

    // ensure visual state matches input on init
    btn.classList.toggle('active', input.type === 'text');
  }

  // OJITOS (IDs de tu markup actual)
  initEyeToggle('toggle-registro-password', 'registro-password');
  initEyeToggle('toggle-registro-password-confirm', 'registro-password-confirm');

  // Re-init si el modal cambia de display/clase
  const modal = document.getElementById('modal-auth');
  if (modal) {
    const obs = new MutationObserver(() => {
      if (getComputedStyle(modal).display !== 'none') {
        initEyeToggle('toggle-registro-password', 'registro-password');
        initEyeToggle('toggle-registro-password-confirm', 'registro-password-confirm');
      }
    });
    obs.observe(modal, { attributes: true, attributeFilter: ['style', 'class'] });
  }

  // ABRIR AUTOMÁTICO SI HAY ERRORES DE LARAVEL (fallback sin Blade)
  // Si hay .form-error visible en el DOM, abrimos el modal correspondiente
  const anyError = document.querySelector('.form-error');
  if (anyError && anyError.textContent.trim().length > 0) {
    // heurística: si hay campo name/email en registro, mostramos registro; si no, login
    const regName = document.getElementById('registro-usuario');
    if (regName) abrirModalRegistro(); else abrirModalLogin();
  }
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

// === MODAL LOGIN/REGISTRO ===
// Nota: tu CSS deja .modal-auth con display:flex SIEMPRE,
// pero el HTML trae style="display:none". Por eso acá cambiamos el style inline:
window.abrirModalLogin = function () {
  const modal = document.getElementById('modal-auth');
  if (!modal) return;
  modal.style.display = 'flex';
  mostrarLogin();
  document.body.classList.add('modal-open'); // opcional: bloquear scroll
};
window.abrirModalRegistro = function () {
  const modal = document.getElementById('modal-auth');
  if (!modal) return;
  modal.style.display = 'flex';
  mostrarRegistro();
  document.body.classList.add('modal-open');
};
window.cerrarModalAuth = function () {
  const modal = document.getElementById('modal-auth');
  if (!modal) return;
  modal.style.display = 'none';
  document.body.classList.remove('modal-open');
};

window.mostrarLogin = function () {
  const l = document.getElementById('login-form');
  const r = document.getElementById('registro-form');
  if (l) l.style.display = 'block';
  if (r) r.style.display = 'none';
  // foco al email de login (ID nuevo)
  const i = document.getElementById('login-email');
  if (i) setTimeout(()=>i.focus(), 50);
};
window.mostrarRegistro = function () {
  const l = document.getElementById('login-form');
  const r = document.getElementById('registro-form');
  if (l) l.style.display = 'none';
  if (r) r.style.display = 'block';
  const i = document.getElementById('registro-usuario') || document.getElementById('registro-email');
  if (i) setTimeout(()=>i.focus(), 50);
};


// === MODAL "¿CUÁNTOS JUGADORES?" ===
window.abrirModalJugadores = function () {
  const m = document.getElementById('modal-players');
  if (!m) {
    console.warn('No se encontró #modal-players en el DOM');
    alert('No se encontró el modal de jugadores. Verifica el HTML.');
    return;
  }
  m.style.display = 'flex';           // mostrar modal
  document.body.classList.add('modal-open');
};

window.cerrarModalJugadores = function () {
  const m = document.getElementById('modal-players');
  if (!m) return;
  m.style.display = 'none';           // ocultar modal
  document.body.classList.remove('modal-open');
};

// opcional: cerrar con ESC
document.addEventListener('keydown', (e) => {
  if (e.key === 'Escape') {
    const m = document.getElementById('modal-players');
    if (m && getComputedStyle(m).display !== 'none') cerrarModalJugadores();
  }
});


// === BORRAR/INUTILIZAR handlers FAKE ===
// Ya NO usés estas funciones; ahora el <form> hace POST a Laravel.
// Las dejo vacías por si quedaron en algún onclick residual (no deberían).
window.loginUsuario = function () {};
window.registrarUsuario = function () {};
