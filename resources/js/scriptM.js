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
      // keep focus on the button for keyboard users
      try { btn.focus(); } catch (e) {}
    };

    btn.addEventListener('click', (e) => { e.preventDefault(); toggle(); });

    // support Enter and Space
    btn.addEventListener('keydown', (e) => {
      if (e.key === 'Enter' || e.key === ' ' || e.key === 'Spacebar') {
        e.preventDefault();
        toggle();
      }
    });

    // ensure visual state matches input on init
    btn.classList.toggle('active', input.type === 'text');
  }

  initEyeToggle('toggle-registro-password', 'registro-password');
  initEyeToggle('toggle-registro-password-confirm', 'registro-password-confirm');

  // If modal HTML is injected later or toggled, re-init when modal becomes visible
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
  const pc = document.getElementById('registro-password-confirm') ? document.getElementById('registro-password-confirm').value : null;
  const err = document.getElementById('registro-error');
  const email = document.getElementById('registro-email') ? document.getElementById('registro-email').value : '';

  // Basic required fields validation
  if (!email || !u || !p || !pc) {
    if (err) err.textContent = 'Todos los campos son obligatorios.';
    return;
  }

  // Basic email format check
  const emailRe = /^[^@\s]+@[^@\s]+\.[^@\s]+$/;
  if (!emailRe.test(email)) {
    if (err) err.textContent = 'Por favor ingresa un correo electrónico válido.';
    return;
  }
  if (pc === null) {
    // campo de confirmación no presente; fallback a comportamiento previo
    console.log('Registro:', u, p);
    cerrarModalAuth();
    return;
  }
  if (p !== pc) {
    if (err) err.textContent = 'Las contraseñas no coinciden. Por favor, verifica.';
    return; // no cerrar el modal ni guardar nada
  }
  if (err) err.textContent = '';
  // passwords coinciden -> comportamiento de registro (fake)
  console.log('Registro:', u, p);
  cerrarModalAuth();
};
