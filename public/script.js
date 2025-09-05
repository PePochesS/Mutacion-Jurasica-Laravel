document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('.panel-dinosaurios img').forEach(img => {
    img.addEventListener('dragstart', (e) => {
      e.dataTransfer.setData("src", e.target.src);
      e.dataTransfer.setData("alt", e.target.alt);
    });
  });

  document.querySelectorAll('.dropzone').forEach((zone, i) => {
    zone.addEventListener('dragover', e => e.preventDefault());
    zone.addEventListener('drop', e => {
      e.preventDefault();
      const src = e.dataTransfer.getData("src");
      const alt = e.dataTransfer.getData("alt");
      const recintoIndex = getRecintoIndex(zone);

      // Lógica de validación por recinto
      if (!puedeAgregarDinosaurio(zone, recintoIndex, alt)) {
        alert("No se puede agregar ese dinosaurio en este recinto según las reglas.");
        return;
      }

      // No permitir más dinosaurios de los permitidos
      if (getMaxDinosPorRecinto(recintoIndex) !== null && zone.children.length >= getMaxDinosPorRecinto(recintoIndex)) {
        alert("Este recinto ya está lleno.");
        return;
      }

      const newDino = document.createElement('img');
      newDino.src = src;
      newDino.alt = alt;
      newDino.draggable = false;
      newDino.style.height = '50px';
      newDino.style.cursor = 'pointer';

      newDino.addEventListener('click', () => {
        newDino.remove();
        updateScore();
      });

      zone.appendChild(newDino);
      updateScore();
    });
  });

  updateScore();
});

function getRecintoIndex(zone) {
  // Devuelve el índice del recinto (1 a 7)
  return parseInt(zone.parentElement.id.replace('recinto', ''), 10);
}

function getMaxDinosPorRecinto(recinto) {
  // Devuelve el máximo de dinosaurios permitidos por recinto
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
    case 1: // Solo misma especie
      return imgs.length === 0 || imgs.every(img => img.alt === alt);
    case 2: // Cualquier especie, hasta 3
      return true;
    case 3: // Solo misma especie, hasta 2
      return imgs.length === 0 || imgs.every(img => img.alt === alt);
    case 4: // Solo uno
      return imgs.length === 0;
    case 5: // Cualquier especie, hasta 6
      return true;
    case 6: // Solo uno
      return imgs.length === 0;
    case 7: // Solo uno
      return imgs.length === 0;
    default:
      return false;
  }
}

function limpiarRecinto(recintoId) {
  const dropzone = document.querySelector(`#${recintoId} .dropzone`);
  dropzone.innerHTML = '';
  updateScore();
}

function updateScore() {
  let total = 0;

  // Recinto 1
  const r1 = document.querySelector('#recinto1 .dropzone');
  const r1Dinos = Array.from(r1.querySelectorAll('img'));
  if (
    r1Dinos.length > 0 &&
    r1Dinos.length <= 6 &&
    r1Dinos.every(img => img.alt === r1Dinos[0].alt)
  ) {
    const puntosR1 = [0, 2, 4, 8, 12, 18, 24]; // índice = cantidad de dinosaurios
    total += puntosR1[r1Dinos.length];
  }

  // Recinto 2
  const r2 = document.querySelector('#recinto2 .dropzone');
  const r2Dinos = Array.from(r2.querySelectorAll('img'));
  if (r2Dinos.length === 3) {
    total += 7;
  }

  // Recinto 3
  const r3 = document.querySelector('#recinto3 .dropzone');
  const r3Dinos = Array.from(r3.querySelectorAll('img'));
  if (
    r3Dinos.length === 2 &&
    r3Dinos[0].alt === r3Dinos[1].alt
  ) {
    total += 5;
  }

  // Recinto 4
  const r4 = document.querySelector('#recinto4 .dropzone');
  const r4Dinos = Array.from(r4.querySelectorAll('img'));
  if (r4Dinos.length === 1) {
    // Especie más común en el tablero
    const especie = r4Dinos[0].alt;
    const allDinos = getAllDinos();
    const especieMasComun = getEspecieMasComun(allDinos);
    if (especie === especieMasComun) {
      total += 7;
    }
  }

  // Recinto 5
  const r5 = document.querySelector('#recinto5 .dropzone');
  const r5Dinos = Array.from(r5.querySelectorAll('img'));
  if (
    r5Dinos.length > 0 &&
    r5Dinos.length <= 6
  ) {
    const puntosR5 = [0, 1, 3, 6, 10, 15, 21];
    total += puntosR5[r5Dinos.length];
  }

  // Recinto 6
  const r6 = document.querySelector('#recinto6 .dropzone');
  const r6Dinos = Array.from(r6.querySelectorAll('img'));
  if (r6Dinos.length === 1) {
    const especie = r6Dinos[0].alt;
    const allDinos = getAllDinos();
    const count = allDinos.filter(img => img.alt === especie).length;
    if (count === 1) {
      total += 7;
    }
  }

  // Recinto 7
  const r7 = document.querySelector('#recinto7 .dropzone');
  const r7Dinos = Array.from(r7.querySelectorAll('img'));
  if (r7Dinos.length === 1) {
    total += 1;
  }

  document.getElementById("puntos").innerText = total;
}

function getAllDinos() {
  // Devuelve todos los dinosaurios en todos los recintos
  return Array.from(document.querySelectorAll('.zona-juego .dropzone img'));
}

function getEspecieMasComun(imgs) {
  // Devuelve la especie (alt) más común
  const counts = {};
  imgs.forEach(img => {
    counts[img.alt] = (counts[img.alt] || 0) + 1;
  });
  let max = 0;
  let especie = null;
  for (const alt in counts) {
    if (counts[alt] > max) {
      max = counts[alt];
      especie = alt;
    }
  }
  return especie;
}

// Drag & Drop tradicional (escritorio)
function drag(ev) {
  ev.dataTransfer.setData("src", ev.target.src);
}

function drop(ev, dropzone) {
  ev.preventDefault();
  const src = ev.dataTransfer.getData("src");
  if (src) {
    agregarDinoADropzone(src, dropzone);
  }
}

// Touch Drag & Drop (móvil)
let touchDino = null;

document.querySelectorAll('.panel-dinosaurios img').forEach(img => {
  img.addEventListener('touchstart', function(e) {
    // Quitar 'dragging' de todos antes de marcar el nuevo
    document.querySelectorAll('.panel-dinosaurios img').forEach(i => i.classList.remove('dragging'));
    img.classList.add('dragging');
    touchDino = img;
    e.preventDefault();
  });
});

document.querySelectorAll('.dropzone').forEach(zone => {
  zone.addEventListener('touchmove', function(e) {
    e.preventDefault(); // Evita scroll mientras arrastras
  });
  zone.addEventListener('touchend', function(e) {
    if (touchDino) {
      agregarDinoADropzone(touchDino.src, zone);
      touchDino.classList.remove('dragging');
      touchDino = null;
    }
    e.preventDefault();
  });
});

// Quitar la clase 'dragging' si no se suelta el dinosaurio en un recinto

// Para drag & drop de escritorio
document.querySelectorAll('.panel-dinosaurios img').forEach(img => {
  img.addEventListener('dragend', function() {
    img.classList.remove('dragging');
  });
});

// Para touch en móvil
document.querySelectorAll('.panel-dinosaurios img').forEach(img => {
  img.addEventListener('touchend', function() {
    setTimeout(() => img.classList.remove('dragging'), 100);
  });
  img.addEventListener('touchcancel', function() {
    img.classList.remove('dragging');
  });
});

function agregarDinoADropzone(src, dropzone) {
  // Obtener alt del dinosaurio (especie)
  let alt = "";
  // Busca el alt en el panel de dinosaurios
  const panelImgs = document.querySelectorAll('.panel-dinosaurios img');
  for (const img of panelImgs) {
    if (img.src === src || img.src.endsWith(src)) {
      alt = img.alt;
      break;
    }
  }
  // Si no se encontró, intenta extraerlo del src
  if (!alt) alt = src.split('/').pop();

  const recintoIndex = getRecintoIndex(dropzone);

  // Validación de reglas
  if (!puedeAgregarDinosaurio(dropzone, recintoIndex, alt)) {
    alert("No se puede agregar ese dinosaurio en este recinto según las reglas.");
    return;
  }
  if (getMaxDinosPorRecinto(recintoIndex) !== null && dropzone.children.length >= getMaxDinosPorRecinto(recintoIndex)) {
    alert("Este recinto ya está lleno.");
    return;
  }

  // Agregar dinosaurio
  const img = document.createElement("img");
  img.src = src;
  img.alt = alt;
  img.draggable = false;
  img.className = "dropped-dino";
  img.style.height = '50px';
  img.style.cursor = 'pointer';
  img.addEventListener('click', () => {
    img.remove();
    updateScore();
  });
  dropzone.appendChild(img);
  updateScore();
}