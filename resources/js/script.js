document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('.panel-dinosaurios img').forEach(img => {
    img.addEventListener('dragstart', (e) => {
  // Solo guarda el nombre de archivo para compatibilidad con asset()
  const srcName = e.target.src.split('/').pop();
  e.dataTransfer.setData("src", srcName);
  e.dataTransfer.setData("alt", e.target.alt);
    });
  });

  document.querySelectorAll('.dropzone').forEach((zone, i) => {
    zone.addEventListener('dragover', e => e.preventDefault());
    zone.addEventListener('drop', e => {
      e.preventDefault();
  const srcName = e.dataTransfer.getData("src");
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

      // Busca la imagen original en el panel y usa su src completo
      const panelImgs = document.querySelectorAll('.panel-dinosaurios img');
      let fullSrc = '';
      for (const img of panelImgs) {
        if (img.src.split('/').pop() === srcName) {
          fullSrc = img.src;
          break;
        }
      }
      const newDino = document.createElement('img');
      newDino.src = fullSrc || srcName;
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

window.limpiarRecinto = function(recintoId) {
  const dropzone = document.querySelector(`#${recintoId} .dropzone`);
  if (dropzone) {
    // Elimina solo los <img> dentro del recinto
    const imgs = dropzone.querySelectorAll('img');
    imgs.forEach(img => img.remove());
  }
  const num = recintoId.replace('recinto','');
  const puntosSpan = document.getElementById(`puntos-recinto${num}`);
  if (puntosSpan) puntosSpan.innerText = '0';
  updateScore();
}

function updateScore() {
  
  let total = 0;
  // Recinto 1
  const r1 = document.querySelector('#recinto1 .dropzone');
  const r1Dinos = Array.from(r1.querySelectorAll('img'));
  let puntosR1 = 0;
  if (
    r1Dinos.length > 0 &&
    r1Dinos.length <= 6 &&
    r1Dinos.every(img => img.alt === r1Dinos[0].alt)
  ) {
    const arr = [0, 2, 4, 8, 12, 18, 24];
    puntosR1 = arr[r1Dinos.length];
  }
  document.getElementById('puntos-recinto1').innerText = puntosR1;
  total += puntosR1;

  // Recinto 2
  const r2 = document.querySelector('#recinto2 .dropzone');
  const r2Dinos = Array.from(r2.querySelectorAll('img'));
  let puntosR2 = 0;
  if (r2Dinos.length === 3) {
    puntosR2 = 7;
  }

  document.getElementById('puntos-recinto2').innerText = puntosR2;
  total += puntosR2;

  // Recinto 3
  const r3 = document.querySelector('#recinto3 .dropzone');
  const r3Dinos = Array.from(r3.querySelectorAll('img'));
  let puntosR3 = 0;
  if (
    r3Dinos.length === 2 &&
    r3Dinos[0].alt === r3Dinos[1].alt
  ) {
    puntosR3 = 5;
  }
  document.getElementById('puntos-recinto3').innerText = puntosR3;
  total += puntosR3;

  // Recinto 4
  const r4 = document.querySelector('#recinto4 .dropzone');
  const r4Dinos = Array.from(r4.querySelectorAll('img'));
  let puntosR4 = 0;
  if (r4Dinos.length === 1) {
    const especie = r4Dinos[0].alt;
    const allDinos = getAllDinos();
    const especieMasComun = getEspecieMasComun(allDinos);
    if (especie === especieMasComun) {
      puntosR4 = 7;
    }
  }
  document.getElementById('puntos-recinto4').innerText = puntosR4;
  total += puntosR4;

  // Recinto 5
  const r5 = document.querySelector('#recinto5 .dropzone');
  const r5Dinos = Array.from(r5.querySelectorAll('img'));
  let puntosR5 = 0;
  if (
    r5Dinos.length > 0 &&
    r5Dinos.length <= 6
  ) {
    const arr = [0, 1, 3, 6, 10, 15, 21];
    puntosR5 = arr[r5Dinos.length];
  }
  document.getElementById('puntos-recinto5').innerText = puntosR5;
  total += puntosR5;

  // Recinto 6
  const r6 = document.querySelector('#recinto6 .dropzone');
  const r6Dinos = Array.from(r6.querySelectorAll('img'));
  let puntosR6 = 0;
  if (r6Dinos.length === 1) {
    const especie = r6Dinos[0].alt;
    const allDinos = getAllDinos();
    const count = allDinos.filter(img => img.alt === especie).length;
    if (count === 1) {
      puntosR6 = 7;
    }
  }
  document.getElementById('puntos-recinto6').innerText = puntosR6;
  total += puntosR6;

  // Recinto 7
  const r7 = document.querySelector('#recinto7 .dropzone');
  const r7Dinos = Array.from(r7.querySelectorAll('img'));
  let puntosR7 = 0;
  if (r7Dinos.length === 1) {
    puntosR7 = 1;
  }
  document.getElementById('puntos-recinto7').innerText = puntosR7;
  total += puntosR7;

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

// Adaptar drag & drop móvil a los nuevos estilos responsivos
document.querySelectorAll('.panel-dinosaurios img').forEach(img => {
  img.addEventListener('touchstart', function(e) {
    document.querySelectorAll('.panel-dinosaurios img').forEach(i => i.classList.remove('dragging'));
    img.classList.add('dragging');
    touchDino = img;
    e.preventDefault();
  });
});

document.querySelectorAll('.dropzone').forEach(zone => {
  zone.addEventListener('touchmove', function(e) {
    e.preventDefault();
  });
  zone.addEventListener('touchend', function(e) {
    if (touchDino) {
      // Usar srcName para compatibilidad con los estilos y lógica
      const srcName = touchDino.src.split('/').pop();
      agregarDinoADropzone(srcName, zone);
      touchDino.classList.remove('dragging');
      touchDino = null;
    }
    e.preventDefault();
  });
});

// Quitar la clase 'dragging' si no se suelta el dinosaurio en un recinto
document.querySelectorAll('.panel-dinosaurios img').forEach(img => {
  img.addEventListener('dragend', function() {
    img.classList.remove('dragging');
  });
  img.addEventListener('touchend', function() {
    setTimeout(() => img.classList.remove('dragging'), 100);
  });
  img.addEventListener('touchcancel', function() {
    img.classList.remove('dragging');
  });
});

function agregarDinoADropzone(srcName, dropzone) {
  // Busca el alt y src completo en el panel de dinosaurios
  let alt = "";
  let fullSrc = "";
  const panelImgs = document.querySelectorAll('.panel-dinosaurios img');
  for (const img of panelImgs) {
    if (img.src.split('/').pop() === srcName) {
      alt = img.alt;
      fullSrc = img.src;
      break;
    }
  }
  if (!alt) alt = srcName;

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
  img.src = fullSrc || srcName;
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