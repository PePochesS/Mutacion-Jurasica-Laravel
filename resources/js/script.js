/*ESTADO GLOBAL*/
const DIE_FACES_ES = ['HUESO', 'POCIÓN', 'PLANTAS', 'ROCAS', 'DINODICE!'];
const DIE_FACES_EN = ['BONE', 'POTION', 'PLANTS', 'ROCKS', 'DINODICE!'];

let ultimaCara = null;     // cara actual del dado (string en mayúsculas) o null
let dadoLanzado = false;   // habilita colocar dinosaurios solo si true

// Datos de la partida inyectados por Blade
window.playerCount  = Number(window.playerCount || 1);
window.currentTurn  = Number(window.currentTurn || 1);
window.gameIdFront  = String(window.gameIdFront || 'local');

const TURN_KEY   = `turn:${window.gameIdFront}`;
const ROUND_KEY  = `round:${window.gameIdFront}`;
const BOARD_KEY  = `boards:${window.gameIdFront}`; 

let boardsByPlayer = {};


/* HELPERS RECINTOS / ÁREAS  */
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
      return imgs.length === 0 || imgs.every(img => (img.alt || '') === alt);
    case 2: // cualquiera
      return true;
    case 3: // misma especie
      return imgs.length === 0 || imgs.every(img => (img.alt || '') === alt);
    case 4: 
    case 6: 
    case 7: 
      return imgs.length === 0;
    case 5:
      return true;
    default:
      return false;
  }
}


/* PUNTAJE */
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

  // Recinto 6 (7 si la especie aparece solo 1 vez en todo el tablero)
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


/* DADO: Mapeo, UI y restricciones */
function recintosPorCara(face) {
  switch ((face || '').toUpperCase()) {
    case 'HUESO': case 'BONE': return [1,2,3];
    case 'ROCAS': case 'ROCKS': case 'ROCA': case 'ROCK': return [3,5,6];
    case 'PLANTAS': case 'PLANTS': return [1,2,4];
    case 'POCIÓN': case 'POTION': return [4,5,6];
    case 'DINODICE!': return 'ANY_EMPTY';
    default: return [];
  }
}

function resaltarRecintosPorDado(face) {
  document.querySelectorAll('.recinto').forEach(r => {
    r.classList.remove('glow-allowed', 'glow-blocked');
  });

  const recintos = recintosPorCara(face);
  if (!recintos || (Array.isArray(recintos) && recintos.length === 0)) return;

  document.querySelectorAll('.recinto').forEach(r => {
    const id = parseInt(r.id.replace('recinto',''),10);
    const tieneDinos = r.querySelectorAll('.dropzone img').length > 0;

    if (recintos === 'ANY_EMPTY') {
      if (!tieneDinos) r.classList.add('glow-allowed');
      else r.classList.add('glow-blocked');
    } else if (recintos.includes(id)) {
      r.classList.add('glow-allowed');
    } else {
      r.classList.add('glow-blocked');
    }
  });
}

function recintoPermitidoPorDado(index) {
  if (!dadoLanzado || !ultimaCara) return false; // bloqueado hasta tirar dado
  const recintos = recintosPorCara(ultimaCara);
  if (recintos === 'ANY_EMPTY') {
    const rec = document.querySelector(`#recinto${index} .dropzone`);
    return rec && rec.children.length === 0;
  }
  return recintos.includes(index);
}

function resetDieUI() {
  dadoLanzado = false;
  ultimaCara = null;
  const el = document.getElementById('die-face');
  if (el) el.textContent = '—';
  resaltarRecintosPorDado(''); 
}

window.rollDie = function () {
  const faces = window.isEn ? DIE_FACES_EN : DIE_FACES_ES;
  const i = Math.floor(Math.random() * faces.length);
  const face = faces[i];
  const el = document.getElementById('die-face');
  if (!el) return;

  // Mostrar cara visualmente
  el.textContent = face;
  el.style.transform = 'scale(1.1)';
  setTimeout(() => el.style.transform = 'scale(1)', 120);

  // Guardar resultado
  ultimaCara = face.toUpperCase();
  dadoLanzado = true; // ahora sí se puede colocar
  resaltarRecintosPorDado(ultimaCara);
};


/* Estilos de brillo */
(() => {
  const style = document.createElement('style');
  style.textContent = `
  .glow-allowed {
    box-shadow: 0 0 12px 4px rgba(126,217,87,0.6) !important;
    transition: box-shadow 0.2s ease, opacity 0.2s ease, filter 0.2s ease;
  }
  .glow-blocked {
    opacity: 0.5;
    filter: grayscale(0.8);
    transition: opacity 0.2s ease, filter 0.2s ease;
  }`;
  document.head.appendChild(style);
})();


/* MODAL REGLAS */
window.openRulesModal = function () {
  const m = document.getElementById('rules-modal');
  if (m) m.style.display = 'flex';
};
window.closeRulesModal = function () {
  const m = document.getElementById('rules-modal');
  if (m) m.style.display = 'none';
};


/* STORAGE / TABLERO */
function serializeBoard() {
  const data = {};
  document.querySelectorAll('.recinto').forEach(rec => {
    const rid = rec.id;
    const imgs = Array.from(rec.querySelectorAll('.dropzone img')).map(img => ({
      src: img.getAttribute('src'),
      alt: (img.getAttribute('alt') || speciesKeyFromSrc(img.getAttribute('src')))
    }));
    data[rid] = imgs;
  });
  return data;
}

function clearBoardUI() {
  document.querySelectorAll('.recinto .dropzone').forEach(dz => dz.innerHTML = '');
  for (let i = 1; i <= 7; i++) {
    const span = document.getElementById(`puntos-recinto${i}`);
    if (span) span.textContent = '0';
  }
}

function renderBoard(boardSnapshot) {
  clearBoardUI();
  if (!boardSnapshot) { updateScore(); return; }

  Object.entries(boardSnapshot).forEach(([recintoId, list]) => {
    const dz = document.querySelector(`#${recintoId} .dropzone`);
    if (!dz) return;

    (list || []).forEach(item => {
      const src = typeof item === 'string' ? item : item.src;
      const alt = typeof item === 'string' ? speciesKeyFromSrc(item) : (item.alt || speciesKeyFromSrc(item.src));

      const img = document.createElement('img');
      img.src = src;
      img.alt = alt;
      img.draggable = false;
      img.style.height = '50px';
      img.style.cursor = 'pointer';
      img.addEventListener('click', () => { img.remove(); updateScore(); });
      dz.appendChild(img);
    });
  });

  updateScore();
}

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
function loadRoundFromStorage() {
  const stored = Number(sessionStorage.getItem(ROUND_KEY));
  if (stored && stored >= 1 && stored <= 6) window.currentRound = stored;
  else window.currentRound = 1;
}
function saveRoundToStorage() {
  sessionStorage.setItem(ROUND_KEY, String(window.currentRound));
}


/* HEADER / TURNOS */
function updateHeaderTexts() {
  const lbl = document.getElementById('turno-label');
  const roundLbl = document.getElementById('ronda-label');
  if (lbl) {
    lbl.textContent = window.isEn
      ? `Game #${window.gameIdFront} — Players: ${window.playerCount} — Player ${window.currentTurn}'s turn`
      : `Partida #${window.gameIdFront} — Jugadores: ${window.playerCount} — Turno del Jugador ${window.currentTurn}`;
  }
  if (roundLbl) {
    roundLbl.textContent = window.isEn
      ? `Round ${window.currentRound}/6`
      : `Ronda ${window.currentRound}/6`;
  }
  const btn = document.getElementById('btn-next-turn');
  if (btn) btn.disabled = window.currentRound > 6;
}

window.siguienteTurno = function () {
  if (window.currentRound > 6) return;

  // Guardar tablero del jugador saliente
  const leaving = window.currentTurn;
  boardsByPlayer[leaving] = serializeBoard();
  saveBoardsToStorage();

  // ¿era el último jugador de la ronda?
  const isLastOfRound = (window.currentTurn === window.playerCount);

  // Rotar al siguiente jugador
  window.currentTurn = (window.currentTurn % window.playerCount) + 1;

  // Si era el último, avanzamos la ronda
  if (isLastOfRound) {
    window.currentRound = (window.currentRound || 1) + 1;
    saveRoundToStorage();
  }

  saveTurnToStorage();
  renderBoard(boardsByPlayer[window.currentTurn]);
  updateHeaderTexts();

  // Obliga a tirar el dado nuevamente en cada turno
  resetDieUI();

  if (window.currentRound > 6) {
    const btn = document.getElementById('btn-next-turn');
    if (btn) btn.disabled = true;
    const msg = window.isEn
      ? '6 rounds completed. You can finish the game.'
      : 'Se completaron las 6 rondas. Podés finalizar la partida.';
    alert(msg);
  }
};


/* FINALIZAR PARTIDA */
function speciesKeyFromSrc(src) {
  if (!src) return '';
  const file = src.split('/').pop().toLowerCase();
  return file.split('?')[0];
}

function computeTotalFromSnapshot(snapshot) {
  const getImgs = (recId) => (snapshot?.[recId] || []).map(item => {
    if (typeof item === 'string') return { alt: speciesKeyFromSrc(item) };
    return { alt: (item.alt || speciesKeyFromSrc(item.src)) };
  });

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

window.finalizarPartida = function () {
  // Guardar tablero del jugador actual
  boardsByPlayer[window.currentTurn] = serializeBoard();
  saveBoardsToStorage();

  const pc = window.playerCount || 1;
  const payload = [];
  for (let p = 1; p <= pc; p++) {
    const snap = boardsByPlayer[p] || {};
    const points = computeTotalFromSnapshot(snap);
    payload.push({ player_number: p, points });
  }

  const input = document.getElementById('scores_json');
  if (input) input.value = JSON.stringify(payload);

  const form = document.getElementById('end-game-form');
  if (form) form.submit();
};


/* MODO MÓVIL: */
(function addTapToPlace(){
  const isTouch = ('ontouchstart' in window) || (navigator.maxTouchPoints > 0);
  if (!isTouch) return;

  let sel = null; // 
  const panelImgs = Array.from(document.querySelectorAll('.panel-dinosaurios img'));
  if (!panelImgs.length) return;

  function clearSelection() {
    if (sel && sel.img) sel.img.classList.remove('selected');
    sel = null;
  }

  panelImgs.forEach(img => {
    img.addEventListener('click', () => {
      if (sel && sel.img === img) { clearSelection(); return; }
      clearSelection();
      sel = {
        img,
        fullSrc: img.src,
        srcName: (img.src || '').split('/').pop(),
        alt: img.alt || ''
      };
      img.classList.add('selected');
    }, { passive: true });
  });

  document.querySelectorAll('.dropzone').forEach(zone => {
    zone.addEventListener('click', () => {
      if (!sel) return;
      const recintoIndex = getRecintoIndex(zone);

      if (!dadoLanzado) {
        alert(window.isEn ? "You must roll the die before placing a dinosaur." : "Tenés que tirar el dado antes de colocar un dinosaurio.");
        clearSelection(); return;
      }
      if (!recintoPermitidoPorDado(recintoIndex)) {
        alert(window.isEn ? "You can’t place a dinosaur there based on the die result." : "No podés colocar un dinosaurio en ese recinto según el dado.");
        clearSelection(); return;
      }
      if (!puedeAgregarDinosaurio(zone, recintoIndex, sel.alt)) {
        alert(window.isEn ? "You can’t add that dinosaur here by the rules." : "No se puede agregar ese dinosaurio en este recinto según las reglas.");
        clearSelection(); return;
      }
      if (getMaxDinosPorRecinto(recintoIndex) !== null &&
          zone.children.length >= getMaxDinosPorRecinto(recintoIndex)) {
        alert(window.isEn ? "This area is already full." : "Este recinto ya está lleno.");
        clearSelection(); return;
      }

      const newDino = document.createElement('img');
      newDino.src = sel.fullSrc;
      newDino.alt = sel.alt;
      newDino.draggable = false;
      newDino.style.height = '50px';
      newDino.style.cursor  = 'pointer';
      newDino.addEventListener('click', () => { newDino.remove(); updateScore(); });

      zone.appendChild(newDino);
      updateScore();
      clearSelection();
    }, { passive: true });
  });

  document.addEventListener('click', (e) => {
    if (!sel) return;
    if (e.target.closest('.panel-dinosaurios') || e.target.closest('.dropzone')) return;
    clearSelection();
  }, { passive: true });
})();


/* INICIALIZACIÓN */
document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('.panel-dinosaurios img').forEach(img => {
    img.addEventListener('dragstart', (e) => {
      const srcName = e.target.src.split('/').pop();
      e.dataTransfer.setData("src", srcName);
      e.dataTransfer.setData("alt", e.target.alt || '');
    });
  });

  // Dropzones (desktop)
  document.querySelectorAll('.dropzone').forEach(zone => {
    zone.addEventListener('dragover', e => e.preventDefault());
    zone.addEventListener('drop', e => {
      e.preventDefault();
      const srcName = e.dataTransfer.getData("src");
      const alt = e.dataTransfer.getData("alt") || '';
      const recintoIndex = getRecintoIndex(zone);

      if (!dadoLanzado) {
        alert(window.isEn ? "You must roll the die before placing a dinosaur." : "Tenés que tirar el dado antes de colocar un dinosaurio.");
        return;
      }
      if (!recintoPermitidoPorDado(recintoIndex)) {
        alert(window.isEn ? "You can’t place a dinosaur there based on the die result." : "No podés colocar un dinosaurio en ese recinto según el dado.");
        return;
      }
      if (!puedeAgregarDinosaurio(zone, recintoIndex, alt)) {
        alert(window.isEn ? "You can’t add that dinosaur here by the rules." : "No se puede agregar ese dinosaurio en este recinto según las reglas.");
        return;
      }
      if (getMaxDinosPorRecinto(recintoIndex) !== null &&
          zone.children.length >= getMaxDinosPorRecinto(recintoIndex)) {
        alert(window.isEn ? "This area is already full." : "Este recinto ya está lleno.");
        return;
      }

    
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

  // Carga de estado y UI inicial
  loadTurnFromStorage();
  loadRoundFromStorage();
  if (!window.currentRound) window.currentRound = 1;
  loadBoardsFromStorage();
  renderBoard(boardsByPlayer[window.currentTurn]);
  updateHeaderTexts();

  // Bloquear colocación hasta tirar el dado y limpiar brillos
  resetDieUI();

  // Puntaje inicial
  updateScore();
});
