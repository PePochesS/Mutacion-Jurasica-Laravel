
document.addEventListener('DOMContentLoaded', () => {
  // Dragstart: guardamos nombre de archivo (compat. con asset())
  document.querySelectorAll('.panel-dinosaurios img').forEach(img => {
    img.addEventListener('dragstart', (e) => {
      const srcName = e.target.src.split('/').pop();
      e.dataTransfer.setData("src", srcName);
      e.dataTransfer.setData("alt", e.target.alt || '');
    });
  });

  // Dropzones
  document.querySelectorAll('.dropzone').forEach(zone => {
    zone.addEventListener('dragover', e => e.preventDefault());
    zone.addEventListener('drop', e => {
      e.preventDefault();
      const srcName = e.dataTransfer.getData("src");
      const alt = e.dataTransfer.getData("alt") || '';
      const recintoIndex = getRecintoIndex(zone);

      // Reglas
      if (!puedeAgregarDinosaurio(zone, recintoIndex, alt)) {
        alert("No se puede agregar ese dinosaurio en este recinto según las reglas.");
        return;
      }
      if (getMaxDinosPorRecinto(recintoIndex) !== null &&
          zone.children.length >= getMaxDinosPorRecinto(recintoIndex)) {
        alert("Este recinto ya está lleno.");
        return;
      }

      // Resolver src completo desde el panel
      const panelImgs = document.querySelectorAll('.panel-dinosaurios img');
      let fullSrc = '';
      for (const img of panelImgs) {
        if (img.src.split('/').pop() === srcName) { fullSrc = img.src; break; }
      }

      const newDino = document.createElement('img');
      newDino.src = fullSrc || srcName;
      newDino.alt = alt;
      newDino.draggable = false;
      newDino.style.height = '50px';
      newDino.style.cursor = 'pointer';
      newDino.addEventListener('click', () => { newDino.remove(); updateScore(); });

      zone.appendChild(newDino);
      updateScore();
    });
  });

  updateScore();
});

function getRecintoIndex(zone) {
  return parseInt(zone.parentElement.id.replace('recinto', ''), 10);
}

function getMaxDinosPorRecinto(recinto) {
  switch (recinto) {
    case 1: return 6;
    case 2: return 3;
    case 3: return 2;
    case 4: return 1;
    case 5: return 6;
    case 6: return 1;
    case 7: return 1;
    default: return null;
  }
}

function puedeAgregarDinosaurio(zone, recinto, alt) {
  const imgs = Array.from(zone.querySelectorAll('img'));
  switch (recinto) {
    case 1: // misma especie
      return imgs.length === 0 || imgs.every(img => img.alt === alt);
    case 2: // cualquiera (hasta 3 por max)
      return true;
    case 3: // misma especie (hasta 2)
      return imgs.length === 0 || imgs.every(img => img.alt === alt);
    case 4: // solo uno
    case 6:
    case 7:
      return imgs.length === 0;
    case 5: // cualquiera (hasta 6 por max)
      return true;
    default:
      return false;
  }
}

window.limpiarRecinto = function(recintoId) {
  const dropzone = document.querySelector(`#${recintoId} .dropzone`);
  if (dropzone) dropzone.querySelectorAll('img').forEach(img => img.remove());
  const num = recintoId.replace('recinto','');
  const puntosSpan = document.getElementById(`puntos-recinto${num}`);
  if (puntosSpan) puntosSpan.innerText = '0';
  updateScore();
};

function updateScore() {
  let total = 0;

  // Recinto 1
  const r1Dinos = Array.from(document.querySelector('#recinto1 .dropzone').querySelectorAll('img'));
  let puntosR1 = 0;
  if (r1Dinos.length > 0 && r1Dinos.length <= 6 && r1Dinos.every(img => img.alt === r1Dinos[0].alt)) {
    const arr = [0, 2, 4, 8, 12, 18, 24];
    puntosR1 = arr[r1Dinos.length];
  }
  document.getElementById('puntos-recinto1').innerText = puntosR1; total += puntosR1;

  // Recinto 2
  const r2Dinos = Array.from(document.querySelector('#recinto2 .dropzone').querySelectorAll('img'));
  const puntosR2 = (r2Dinos.length === 3) ? 7 : 0;
  document.getElementById('puntos-recinto2').innerText = puntosR2; total += puntosR2;

  // Recinto 3
  const r3Dinos = Array.from(document.querySelector('#recinto3 .dropzone').querySelectorAll('img'));
  const puntosR3 = (r3Dinos.length === 2 && r3Dinos[0]?.alt === r3Dinos[1]?.alt) ? 5 : 0;
  document.getElementById('puntos-recinto3').innerText = puntosR3; total += puntosR3;

  // Recinto 4 (7 si es especie más común en el tablero completo)
  const r4Dinos = Array.from(document.querySelector('#recinto4 .dropzone').querySelectorAll('img'));
  let puntosR4 = 0;
  if (r4Dinos.length === 1) {
    const especie = r4Dinos[0].alt;
    const allDinos = getAllDinos();
    const especieMasComun = getEspecieMasComun(allDinos);
    if (especie === especieMasComun) puntosR4 = 7;
  }
  document.getElementById('puntos-recinto4').innerText = puntosR4; total += puntosR4;

  // Recinto 5 (triangular 1,3,6,10,15,21)
  const r5Dinos = Array.from(document.querySelector('#recinto5 .dropzone').querySelectorAll('img'));
  let puntosR5 = 0;
  if (r5Dinos.length > 0 && r5Dinos.length <= 6) {
    const arr = [0, 1, 3, 6, 10, 15, 21];
    puntosR5 = arr[r5Dinos.length];
  }
  document.getElementById('puntos-recinto5').innerText = puntosR5; total += puntosR5;

  // Recinto 6 (7 si la especie aparece sólo 1 vez en todo el tablero)
  const r6Dinos = Array.from(document.querySelector('#recinto6 .dropzone').querySelectorAll('img'));
  let puntosR6 = 0;
  if (r6Dinos.length === 1) {
    const especie = r6Dinos[0].alt;
    const allDinos = getAllDinos();
    const count = allDinos.filter(img => img.alt === especie).length;
    if (count === 1) puntosR6 = 7;
  }
  document.getElementById('puntos-recinto6').innerText = puntosR6; total += puntosR6;

  // Recinto 7 (1 si hay uno)
  const r7Dinos = Array.from(document.querySelector('#recinto7 .dropzone').querySelectorAll('img'));
  const puntosR7 = (r7Dinos.length === 1) ? 1 : 0;
  document.getElementById('puntos-recinto7').innerText = puntosR7; total += puntosR7;

  document.getElementById("puntos").innerText = total;
}

// Atajo Ctrl+D para mostrar especificaciones de recintos
document.addEventListener('keydown', function(e) {
  if (e.ctrlKey && e.key.toLowerCase() === 'd') {
    e.preventDefault();
    toggleEspecificacionesRecintos();
  }
});

function toggleEspecificacionesRecintos() {
  const specs = [
    '<b>Recinto 1:</b> Solo permite dinosaurios de la misma especie. Máximo 6. Puntos: 2, 4, 8, 12, 18, 24 según cantidad.',
    '<b>Recinto 2:</b> Permite cualquier especie. Máximo 3. Puntos: 7 si hay 3.',
    '<b>Recinto 3:</b> Solo permite dinosaurios de la misma especie. Máximo 2. Puntos: 5 si hay 2 iguales.',
    '<b>Recinto 4:</b> Solo uno. Puntos: 7 si es la especie más común en el tablero.',
    '<b>Recinto 5:</b> Permite cualquier especie. Máximo 6. Puntos: 1, 3, 6, 10, 15, 21 según cantidad.',
    '<b>Recinto 6:</b> Solo uno. Puntos: 7 si es la única vez que aparece esa especie en el tablero.',
    '<b>Recinto 7:</b> Solo uno. Puntos: 1 si hay uno.'
  ];
  const div = document.getElementById('especificaciones-recintos');
  if (div.style.display === 'block') {
    div.style.display = 'none';
    div.innerHTML = '';
  } else {
    div.innerHTML = specs.map(s => `<div style='margin-bottom:8px;'>${s}</div>`).join('');
    div.style.display = 'block';
  }
}

function getAllDinos() {
  return Array.from(document.querySelectorAll('.zona-juego .dropzone img'));
}

function getEspecieMasComun(imgs) {
  const counts = {};
  imgs.forEach(img => { counts[img.alt] = (counts[img.alt] || 0) + 1; });
  let max = 0, especie = null;
  for (const alt in counts) {
    if (counts[alt] > max) { max = counts[alt]; especie = alt; }
  }
  return especie;
}

// Drag & Drop helpers (desktop)
function drag(ev) { ev.dataTransfer.setData("src", ev.target.src); }
function drop(ev, dropzone) {
  ev.preventDefault();
  const src = ev.dataTransfer.getData("src");
  if (src) agregarDinoADropzone(src, dropzone);
}

// Touch Drag & Drop (móvil)
let touchDino = null;
document.querySelectorAll('.panel-dinosaurios img').forEach(img => {
  img.addEventListener('touchstart', function(e) {
    document.querySelectorAll('.panel-dinosaurios img').forEach(i => i.classList.remove('dragging'));
    img.classList.add('dragging');
    touchDino = img;
    e.preventDefault();
  });
});
document.querySelectorAll('.dropzone').forEach(zone => {
  zone.addEventListener('touchmove', e => e.preventDefault());
  zone.addEventListener('touchend', function(e) {
    if (touchDino) {
      const srcName = touchDino.src.split('/').pop();
      agregarDinoADropzone(srcName, zone);
      touchDino.classList.remove('dragging');
      touchDino = null;
    }
    e.preventDefault();
  });
});
document.querySelectorAll('.panel-dinosaurios img').forEach(img => {
  img.addEventListener('dragend', () => img.classList.remove('dragging'));
  img.addEventListener('touchend', () => setTimeout(() => img.classList.remove('dragging'), 100));
  img.addEventListener('touchcancel', () => img.classList.remove('dragging'));
});

function agregarDinoADropzone(srcName, dropzone) {
  // Buscar alt + src completo en el panel
  let alt = "", fullSrc = "";
  const panelImgs = document.querySelectorAll('.panel-dinosaurios img');
  for (const img of panelImgs) {
    if (img.src.split('/').pop() === srcName) { alt = img.alt || ''; fullSrc = img.src; break; }
  }
  if (!alt) alt = srcName;

  const recintoIndex = getRecintoIndex(dropzone);
  if (!puedeAgregarDinosaurio(dropzone, recintoIndex, alt)) {
    alert("No se puede agregar ese dinosaurio en este recinto según las reglas.");
    return;
  }
  if (getMaxDinosPorRecinto(recintoIndex) !== null &&
      dropzone.children.length >= getMaxDinosPorRecinto(recintoIndex)) {
    alert("Este recinto ya está lleno.");
    return;
  }

  const img = document.createElement("img");
  img.src = fullSrc || srcName;
  img.alt = alt;
  img.draggable = false;
  img.className = "dropped-dino";
  img.style.height = '50px';
  img.style.cursor = 'pointer';
  img.addEventListener('click', () => { img.remove(); updateScore(); });
  dropzone.appendChild(img);
  updateScore();
}

/* =========================
   TURNOS: persistencia por partida (SessionStorage) y tableros por jugador
   ========================= */

// Variables inyectadas desde Blade:
// window.playerCount, window.currentTurn, window.gameIdFront
window.playerCount  = Number(window.playerCount || 1);
window.currentTurn  = Number(window.currentTurn || 1);
window.gameIdFront  = String(window.gameIdFront || 'local');

// Claves para storage
const TURN_KEY  = `turn:${window.gameIdFront}`;
const BOARD_KEY = `boards:${window.gameIdFront}`;

// Estructura: { "1": {recinto1:[...], recinto2:[...]}, "2": {...}, ... }
let boardsByPlayer = {};

// Helpers tablero ↔ objeto
function serializeBoard() {
  const data = {};
  document.querySelectorAll('.recinto').forEach(rec => {
    const rid = rec.id;
    const imgs = Array.from(rec.querySelectorAll('.dropzone img')).map(img => img.getAttribute('src'));
    data[rid] = imgs;
  });
  return data;
}

function clearBoardUI() {
  document.querySelectorAll('.recinto .dropzone').forEach(dz => dz.innerHTML = '');
  // Asegurar puntos por recinto en 0
  for (let i = 1; i <= 7; i++) {
    const span = document.getElementById(`puntos-recinto${i}`);
    if (span) span.textContent = '0';
  }
}

function renderBoard(boardSnapshot) {
  clearBoardUI();
  if (!boardSnapshot) { updateScore(); return; }

  Object.entries(boardSnapshot).forEach(([recintoId, srcList]) => {
    const dz = document.querySelector(`#${recintoId} .dropzone`);
    if (!dz) return;
    srcList.forEach(src => {
      const img = document.createElement('img');
      img.src = src;
      img.draggable = false;
      img.style.height = '50px';
      img.style.cursor = 'pointer';
      img.addEventListener('click', () => { img.remove(); updateScore(); });
      dz.appendChild(img);
    });
  });

  updateScore();
}

// Storage helpers
function loadBoardsFromStorage() {
  try { boardsByPlayer = JSON.parse(sessionStorage.getItem(BOARD_KEY) || '{}') || {}; }
  catch { boardsByPlayer = {}; }
}
function saveBoardsToStorage() {
  sessionStorage.setItem(BOARD_KEY, JSON.stringify(boardsByPlayer));
}
function loadTurnFromStorage() {
  const stored = Number(sessionStorage.getItem(TURN_KEY));
  if (stored && stored >= 1 && stored <= window.playerCount) window.currentTurn = stored;
}
function saveTurnToStorage() {
  sessionStorage.setItem(TURN_KEY, String(window.currentTurn));
}

function updateTurnHeader() {
  const lbl = document.getElementById('turno-label');
  if (!lbl) return;
  const text = `Partida #${window.gameIdFront} — Jugadores: ${window.playerCount} — Turno del Jugador ${window.currentTurn}`;
  lbl.textContent = text;
}

// Botón “Siguiente turno”
window.siguienteTurno = function () {
  const leaving = window.currentTurn;

  // Guardar tablero del jugador saliente
  boardsByPlayer[leaving] = serializeBoard();
  saveBoardsToStorage();

  // Rotar turno
  window.currentTurn = (window.currentTurn % window.playerCount) + 1;
  saveTurnToStorage();
  updateTurnHeader();

  // Render del jugador entrante (si no hay snapshot => limpio + 0 puntos)
  renderBoard(boardsByPlayer[window.currentTurn]);
};

// Bootstrap /juego
document.addEventListener('DOMContentLoaded', () => {
  loadTurnFromStorage();
  updateTurnHeader();
  loadBoardsFromStorage();
  renderBoard(boardsByPlayer[window.currentTurn]); // vacío si no hay snapshot
});

/* =========================
   FINALIZAR PARTIDA: calcular puntos y enviar form
   ========================= */

// Normaliza un src a una clave de especie (filename)
function speciesKeyFromSrc(src) {
  if (!src) return '';
  const file = src.split('/').pop().toLowerCase();
  return file.split('?')[0];
}

// Calcula puntos totales a partir de un snapshot { recinto1:[src,...], ... }
function computeTotalFromSnapshot(snapshot) {
  const getImgs = (recId) => (snapshot?.[recId] || []).map(s => ({ alt: speciesKeyFromSrc(s) }));
  let total = 0;

  { const imgs = getImgs('recinto1');
    if (imgs.length > 0 && imgs.length <= 6 && imgs.every(i => i.alt === imgs[0].alt)) {
      const arr = [0,2,4,8,12,18,24]; total += arr[imgs.length];
    }
  }
  { const imgs = getImgs('recinto2'); total += (imgs.length === 3) ? 7 : 0; }
  { const imgs = getImgs('recinto3'); total += (imgs.length === 2 && imgs[0]?.alt === imgs[1]?.alt) ? 5 : 0; }
  { const imgs4 = getImgs('recinto4');
    if (imgs4.length === 1) {
      const all = []
        .concat(getImgs('recinto1'), getImgs('recinto2'), getImgs('recinto3'),
                getImgs('recinto4'), getImgs('recinto5'), getImgs('recinto6'),
                getImgs('recinto7'));
      const counts = {}; all.forEach(i => { counts[i.alt] = (counts[i.alt] || 0) + 1; });
      let max = 0, common = null;
      Object.keys(counts).forEach(k => { if (counts[k] > max) { max = counts[k]; common = k; }});
      if (imgs4[0].alt === common) total += 7;
    }
  }
  { const imgs = getImgs('recinto5');
    if (imgs.length > 0 && imgs.length <= 6) {
      const arr = [0,1,3,6,10,15,21]; total += arr[imgs.length];
    }
  }
  { const imgs6 = getImgs('recinto6');
    if (imgs6.length === 1) {
      const all = []
        .concat(getImgs('recinto1'), getImgs('recinto2'), getImgs('recinto3'),
                getImgs('recinto4'), getImgs('recinto5'), getImgs('recinto6'),
                getImgs('recinto7'));
      const especie = imgs6[0].alt;
      const count = all.filter(i => i.alt === especie).length;
      if (count === 1) total += 7;
    }
  }
  { const imgs = getImgs('recinto7'); total += (imgs.length === 1) ? 1 : 0; }

  return total;
}

// Recolecta puntajes por jugador y envía el form
window.finalizarPartida = function () {
  // Asegurar que el tablero del jugador actual se guarde
  boardsByPlayer[window.currentTurn] = serializeBoard();
  saveBoardsToStorage();

  const pc = window.playerCount || 1;
  const payload = [];

  for (let p = 1; p <= pc; p++) {
    const snap = boardsByPlayer[p] || {}; // si no jugó, 0 puntos
    const points = computeTotalFromSnapshot(snap);
    payload.push({ player_number: p, points });
  }

  const input = document.getElementById('scores_json');
  if (input) input.value = JSON.stringify(payload);

  const form = document.getElementById('end-game-form');
  if (form) form.submit();
};
