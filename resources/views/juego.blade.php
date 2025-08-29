<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pantalla de Juego - DinoDice</title>
  <link rel="icon" type="image/png" href="/Fotos Equipo/LogoFinal.png" sizes="32x32">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
  body {
    margin: 0;
    padding: 0;
    font-family: 'Segoe UI', sans-serif;
    background-color: #222;
    color: #fff;
    display: flex;
    flex-direction: row;
    height: 100vh;
  }

  .panel-dinosaurios {
    width: 220px;
    background-color: #111;
    padding: 20px;
    overflow-y: auto;
    border-right: 2px solid #444;
  }

  .panel-dinosaurios h2 {
    text-align: center;
    font-size: 18px;
  }

  .panel-dinosaurios img {
    width: 100%;
    margin-bottom: 15px;
    cursor: grab;
  }

  .panel-dinosaurios img.dragging {
    opacity: 0.5;
    outline: 2px dashed #7ed957;
  }

  .zona-juego {
    flex: 1;
    padding: 20px;
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    align-items: flex-start;
    gap: 20px;
    overflow-y: auto;
  }

  .recinto {
    width: 220px;
    min-height: 120px;
    background: rgba(30,30,30,0.7);
    border: none;
    box-shadow: 0 2px 8px #0008;
    border-radius: 16px;
    margin-bottom: 16px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: flex-start;
    padding: 10px 0 16px 0;
    overflow: visible;
  }

  .recinto h3 {
    margin: 8px 0 4px 0;
    font-size: 14px;
    color: #fff;
    background: rgba(0,0,0,0.7);
    width: 90%;
    align-self: center;
    border-radius: 4px;
  }

  .dropzone {
    width: 100%;
    min-height: 90px;
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    align-items: flex-start;
    gap: 12px;
    background: none;
    box-sizing: border-box;
    overflow: visible;
    padding: 0;
  }

  .recinto button {
    margin-top: 6px;
    font-size: 12px;
    background-color: #922e00;
    color: white;
    border: none;
    padding: 5px 10px;
    cursor: pointer;
    border-radius: 3px;
    width: 90%;
    align-self: center;
  }

  .dropzone img {
    height: 44px;
    max-width: 44px;
    object-fit: contain;
    cursor: pointer;
    margin: 0;
  }

  .puntaje {
    width: 220px;
    padding: 20px;
    background-color: #111;
    border-left: 2px solid #444;
  }

  .puntaje h2 {
    font-size: 18px;
  }

  .btn-volver {
    position: fixed;
    bottom: 24px;
    right: 32px;
    background: #922e00;
    color: #fff;
    padding: 12px 28px;
    border-radius: 8px;
    font-size: 16px;
    text-decoration: none;
    box-shadow: 0 2px 8px #0008;
    transition: background 0.2s;
    z-index: 1000;
    margin-left: 12px;
  }

  .btn-volver:hover { background: #c13c00; }
  .btn-volver + .btn-volver { right: 180px; }

  .btn-ranking {
    position: fixed;
    bottom: 80px;
    right: 32px;
    background: #922e00;
    color: #fff;
    padding: 12px 28px;
    border-radius: 8px;
    font-size: 16px;
    text-decoration: none;
    box-shadow: 0 2px 8px #0008;
    transition: background 0.2s;
    z-index: 1000;
  }

  .btn-ranking:hover { background: #c13c00; }

  @media (max-width: 700px) {
    body {
      flex-direction: column;
      height: 100vh;
      overflow-x: hidden;
    }
    .panel-dinosaurios {
      width: 100vw;
      min-width: 0;
      max-width: 100vw;
      height: auto;
      border-right: none;
      border-bottom: 2px solid #444;
      display: flex;
      flex-direction: row;
      align-items: center;
      justify-content: flex-start;
      overflow-x: auto;
      overflow-y: hidden;
      padding: 14px 0 14px 8px;
      gap: 12px;
      background: #111;
      /* Mejora el área de scroll para el dedo */
      scrollbar-width: thin;
      scrollbar-color: #7ed957 #222;
    }
    .panel-dinosaurios img {
      width: 56px; min-width: 56px; height: 56px;
      margin: 0 8px 0 0; border-radius: 10px;
      box-shadow: 0 2px 8px #0004; background: #fff;
      touch-action: pan-x;
    }
    /* Scrollbar visible en navegadores compatibles */
    .panel-dinosaurios::-webkit-scrollbar {
      height: 8px; background: #222;
    }
    .panel-dinosaurios::-webkit-scrollbar-thumb {
      background: #7ed957; border-radius: 4px;
    }
    .zona-juego {
      flex: unset; width: 100vw; padding: 10px 0 0 0;
      flex-wrap: wrap; gap: 10px; justify-content: center; align-items: flex-start;
      overflow-y: auto; padding-bottom: 150px !important;
    }
    .recinto {
      width: 44vw; min-width: 120px; max-width: 150px;
      min-height: 70px; margin: 0 2vw 10px 2vw; padding: 6px 2px 10px 2px;
      font-size: 0.97rem;
    }
    .recinto h3 { font-size: 1rem; margin-bottom: 4px; }
    .dropzone { min-height: 32px; min-width: 40px; gap: 4px; }
    .dropzone img { height: 28px; max-width: 28px; }
    .puntaje {
      position: fixed; left: 8px; bottom: 56px;
      width: auto; min-width: 90px; max-width: 60vw;
      padding: 10px 12px; background: #111; border-left: none;
      border-top: 2px solid #444; border-radius: 10px; z-index: 1100;
    }
    .puntaje span { font-size: 1rem; margin-bottom: 2px; display: block; }
    .puntaje p { font-size: 1.2rem; margin: 0; font-weight: bold; color: #7ed957; }
    .btn-ranking {
      position: fixed; left: 8px; bottom: 8px; right: auto;
      width: auto; font-size: 1rem; padding: 8px 14px; border-radius: 10px;
      margin: 0; z-index: 1101;
    }
    .btn-volver {
      position: fixed; left: 140px; bottom: 8px; right: auto;
      width: auto; font-size: 1rem; padding: 8px 14px; border-radius: 10px;
      margin: 0; z-index: 1101;
    }
  }
  </style>
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
      <div class="acciones"><button onclick="limpiarRecinto('recinto1')" class="btn btn-danger btn-sm">Limpiar Recinto</button></div>
    </div>
    <div class="recinto" id="recinto2">
      <h3>Recinto 2</h3>
      <div class="dropzone"></div>
      <div class="acciones"><button onclick="limpiarRecinto('recinto2')" class="btn btn-danger btn-sm">Limpiar Recinto</button></div>
    </div>
    <div class="recinto" id="recinto3">
      <h3>Recinto 3</h3>
      <div class="dropzone"></div>
      <div class="acciones"><button onclick="limpiarRecinto('recinto3')" class="btn btn-danger btn-sm">Limpiar Recinto</button></div>
    </div>
    <div class="recinto" id="recinto4">
      <h3>Recinto 4</h3>
      <div class="dropzone"></div>
      <div class="acciones"><button onclick="limpiarRecinto('recinto4')" class="btn btn-danger btn-sm">Limpiar Recinto</button></div>
    </div>
    <div class="recinto" id="recinto5">
      <h3>Recinto 5</h3>
      <div class="dropzone"></div>
      <div class="acciones"><button onclick="limpiarRecinto('recinto5')" class="btn btn-danger btn-sm">Limpiar Recinto</button></div>
    </div>
    <div class="recinto" id="recinto6">
      <h3>Recinto 6</h3>
      <div class="dropzone"></div>
      <div class="acciones"><button onclick="limpiarRecinto('recinto6')" class="btn btn-danger btn-sm">Limpiar Recinto</button></div>
    </div>
    <div class="recinto" id="recinto7">
      <h3>Recinto 7</h3>
      <div class="dropzone"></div>
      <div class="acciones"><button onclick="limpiarRecinto('recinto7')" class="btn btn-danger btn-sm">Limpiar Recinto</button></div>
    </div>
  </div>

  <div class="puntaje">
    <span class="fw-bold">Puntaje Total</span>
    <p id="puntos">0</p>
  </div>

  <a href="{{ route('ranking') }}" class="btn-ranking btn btn-warning">Ver Ranking</a>
  <a href="{{ route('home') }}" class="btn-volver btn btn-warning">Volver</a>

  <script>
  /**
   * ============================
   *  LÓGICA DEL JUEGO (overview)
   * ============================
   * - El tablero tiene 7 recintos. Cada recinto tiene reglas de colocación (cantidad máxima y/o especies permitidas).
   * - Se arrastran dinos desde el panel lateral a una dropzone (por mouse/drag nativo o por touch en móviles).
   * - Al soltar un dino: se valida contra las reglas del recinto -> si pasa, se agrega; si no, se alert(a).
   * - Cada click sobre un dino ya colocado lo elimina.
   * - El puntaje total se recalcula en cada cambio según reglas de cada recinto.
   *
   * Puntos clave:
   * - El "alt" de la imagen es el identificador de especie (p.ej. "dinosaurio 1").
   * - Soportamos dos flujos de DnD: Desktop (HTML5 Drag&Drop) y Móvil (touchstart/touchend manual).
   * - Utilidades: getRecintoIndex, getMaxDinosPorRecinto, puedeAgregarDinosaurio, getAllDinos, getEspecieMasComun.
   */

  // ============ INICIALIZACIÓN DE EVENTOS ============
  document.addEventListener('DOMContentLoaded', () => {
    // 1) Habilitar arrastre (desktop) desde el panel: almacenamos src y alt en el dataTransfer.
    document.querySelectorAll('.panel-dinosaurios img').forEach(img => {
      img.addEventListener('dragstart', (e) => {
        e.dataTransfer.setData("src", e.target.src);
        e.dataTransfer.setData("alt", e.target.alt);
      });
    });

    // 2) Configurar las dropzones (desktop): permitir soltar y procesar la validación/alta.
    document.querySelectorAll('.dropzone').forEach(zone => {
      zone.addEventListener('dragover', e => e.preventDefault()); // necesario para permitir drop
      zone.addEventListener('drop', e => {
        e.preventDefault();
        const src = e.dataTransfer.getData("src");
        const alt = e.dataTransfer.getData("alt");
        const recintoIndex = getRecintoIndex(zone);

        // Validación de reglas por recinto (especie / capacidad / etc.)
        if (!puedeAgregarDinosaurio(zone, recintoIndex, alt)) {
          alert("No se puede agregar ese dinosaurio en este recinto según las reglas.");
          return;
        }

        // Chequeo de capacidad máxima (si aplica)
        const max = getMaxDinosPorRecinto(recintoIndex);
        if (max !== null && zone.children.length >= max) {
          alert("Este recinto ya está lleno.");
          return;
        }

        // Crear la imagen del dino colocado en el recinto
        const newDino = document.createElement('img');
        newDino.src = src;
        newDino.alt = alt;             // Alt = especie (clave para reglas)
        newDino.draggable = false;     // Los colocados no se vuelven a arrastrar (se remueven con click)
        newDino.style.height = '50px';
        newDino.style.cursor = 'pointer';

        // Eliminar con click (permite corregir jugadas rápido)
        newDino.addEventListener('click', () => {
          newDino.remove();
          updateScore();
        });

        zone.appendChild(newDino);
        updateScore();
      });
    });

    // 3) Primera evaluación de puntaje (por si hay estado previo)
    updateScore();
  });

  // ============ MAPEO DE RECINTOS/REGLAS ============
  function getRecintoIndex(zone) {
    // Obtiene el índice numérico 1..7 a partir del id del contenedor padre (p.ej. "recinto3" -> 3)
    return parseInt(zone.parentElement.id.replace('recinto', ''), 10);
  }

  function getMaxDinosPorRecinto(recinto) {
    // Capacidad máxima por recinto (null = sin límite explícito, aplican otras reglas)
    switch (recinto) {
      case 1: return 6;  // solo una especie, hasta 6
      case 2: return 3;  // cualquiera, hasta 3
      case 3: return 2;  // solo una especie, hasta 2
      case 4: return 1;  // solo uno
      case 5: return 6;  // cualquiera, hasta 6 (escala de puntos triangular)
      case 6: return 1;  // solo uno (bonus si es especie única en todo el tablero)
      case 7: return 1;  // solo uno (1 punto fijo)
      default: return null;
    }
  }

  function puedeAgregarDinosaurio(zone, recinto, alt) {
    // Reglas de aceptación: definen compatibilidad de especie y/o cantidad adicional
    const imgs = Array.from(zone.querySelectorAll('img'));
    switch (recinto) {
      case 1: // Solo misma especie (monoespecífico)
        return imgs.length === 0 || imgs.every(img => img.alt === alt);
      case 2: // Cualquier especie (capacidad controlada aparte)
        return true;
      case 3: // Solo misma especie (duo)
        return imgs.length === 0 || imgs.every(img => img.alt === alt);
      case 4: // Solo uno
        return imgs.length === 0;
      case 5: // Cualquier especie (capacidad controlada aparte)
        return true;
      case 6: // Solo uno (luego se evalúa si es especie única en el tablero)
        return imgs.length === 0;
      case 7: // Solo uno
        return imgs.length === 0;
      default:
        return false;
    }
  }

  // ============ ACCIONES DE UI ============
  function limpiarRecinto(recintoId) {
    // Borra todos los dinos del recinto indicado y recalcula puntaje
    const dropzone = document.querySelector(`#${recintoId} .dropzone`);
    dropzone.innerHTML = '';
    updateScore();
  }

  // ============ CÁLCULO DE PUNTAJE ============
  function updateScore() {
    let total = 0;

    // Recinto 1: Monoespecífico hasta 6 — tabla de puntuación discreta
    const r1 = document.querySelector('#recinto1 .dropzone');
    const r1Dinos = Array.from(r1.querySelectorAll('img'));
    if (
      r1Dinos.length > 0 &&
      r1Dinos.length <= 6 &&
      r1Dinos.every(img => img.alt === r1Dinos[0].alt)
    ) {
      // Índice = cantidad de dinos (0..6). Ej.: 3 dinos → puntosR1[3] = 8
      const puntosR1 = [0, 2, 4, 8, 12, 18, 24];
      total += puntosR1[r1Dinos.length];
    }

    // Recinto 2: Cualquier especie, solo si hay exactamente 3 → +7
    const r2 = document.querySelector('#recinto2 .dropzone');
    const r2Dinos = Array.from(r2.querySelectorAll('img'));
    if (r2Dinos.length === 3) total += 7;

    // Recinto 3: Dúo monoespecífico exacto → +5
    const r3 = document.querySelector('#recinto3 .dropzone');
    const r3Dinos = Array.from(r3.querySelectorAll('img'));
    if (r3Dinos.length === 2 && r3Dinos[0].alt === r3Dinos[1].alt) total += 5;

    // Recinto 4: Si el único dino pertenece a la especie MÁS COMÚN del tablero → +7
    const r4 = document.querySelector('#recinto4 .dropzone');
    const r4Dinos = Array.from(r4.querySelectorAll('img'));
    if (r4Dinos.length === 1) {
      const especie = r4Dinos[0].alt;
      const allDinos = getAllDinos();
      const especieMasComun = getEspecieMasComun(allDinos);
      if (especie === especieMasComun) total += 7;
    }

    // Recinto 5: Escala triangular (1,3,6,10,15,21) con tope 6 dinos
    const r5 = document.querySelector('#recinto5 .dropzone');
    const r5Dinos = Array.from(r5.querySelectorAll('img'));
    if (r5Dinos.length > 0 && r5Dinos.length <= 6) {
      const puntosR5 = [0, 1, 3, 6, 10, 15, 21]; // T(n) = n(n+1)/2
      total += puntosR5[r5Dinos.length];
    }

    // Recinto 6: ÚNICO dino y además su especie aparece SOLO UNA VEZ en TODO el tablero → +7
    const r6 = document.querySelector('#recinto6 .dropzone');
    const r6Dinos = Array.from(r6.querySelectorAll('img'));
    if (r6Dinos.length === 1) {
      const especie = r6Dinos[0].alt;
      const allDinos = getAllDinos();
      const count = allDinos.filter(img => img.alt === especie).length;
      if (count === 1) total += 7;
    }

    // Recinto 7: Único dino → +1 (fijo)
    const r7 = document.querySelector('#recinto7 .dropzone');
    const r7Dinos = Array.from(r7.querySelectorAll('img'));
    if (r7Dinos.length === 1) total += 1;

    // Refresco de UI
    document.getElementById("puntos").innerText = total;
  }

  // ============ UTILIDADES ============
  function getAllDinos() {
    // Retorna TODAS las imágenes de dinos actualmente colocadas en el tablero
    return Array.from(document.querySelectorAll('.zona-juego .dropzone img'));
  }

  function getEspecieMasComun(imgs) {
    // Cuenta apariciones por "alt" y devuelve el alt con mayor frecuencia
    const counts = {};
    imgs.forEach(img => { counts[img.alt] = (counts[img.alt] || 0) + 1; });
    let max = 0, especie = null;
    for (const alt in counts) {
      if (counts[alt] > max) { max = counts[alt]; especie = alt; }
    }
    return especie;
  }

  // ============ DRAG & DROP (DESKTOP LEGACY) ============
  // Nota: funciones compatibles si quisieras usar ondragstart/ondrop inline.
  // El flujo principal ya está manejado por addEventListener arriba.
  function drag(ev) {
    ev.dataTransfer.setData("src", ev.target.src);
  }
  function drop(ev, dropzone) {
    ev.preventDefault();
    const src = ev.dataTransfer.getData("src");
    if (src) agregarDinoADropzone(src, dropzone);
  }

  // ============ TOUCH DRAG & DROP (MÓVIL) ============
  // En móviles no hay DataTransfer: simulamos "pick & drop" con touchstart/touchend.
  let touchDino = null;

  // Seleccionar dino (touchstart) y marcar visualmente cuál se está "arrastrando".
  document.querySelectorAll('.panel-dinosaurios img').forEach(img => {
    img.addEventListener('touchstart', function(e) {
      // Quita marcas previas y aplica la actual
      document.querySelectorAll('.panel-dinosaurios img').forEach(i => i.classList.remove('dragging'));
      img.classList.add('dragging');
      touchDino = img;
      e.preventDefault(); // evita que el navegador intente hacer zoom/scroll inesperado
    });
  });

  // Cada dropzone escucha touchmove/touchend para aceptar el "drop" manual
  document.querySelectorAll('.dropzone').forEach(zone => {
    zone.addEventListener('touchmove', function(e) {
      e.preventDefault(); // Bloquea el scroll mientras "arrastras"
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

  // Limpiar la marca 'dragging' si el gesto termina fuera de una dropzone
  document.querySelectorAll('.panel-dinosaurios img').forEach(img => {
    // Desktop
    img.addEventListener('dragend', function() { img.classList.remove('dragging'); });
    // Móvil
    img.addEventListener('touchend', function() {
      setTimeout(() => img.classList.remove('dragging'), 100);
    });
    img.addEventListener('touchcancel', function() { img.classList.remove('dragging'); });
  });

  // ============ INSERCIÓN DE DINO (UTILIDAD COMÚN) ============
  function agregarDinoADropzone(src, dropzone) {
    // 1) Resolver la "especie" (alt) a partir del panel, usando src como clave.
    //    Importante: en Laravel el asset() puede resolver a URLs absolutas,
    //    por eso comparamos tanto igualdad completa como endsWith().
    let alt = "";
    const panelImgs = document.querySelectorAll('.panel-dinosaurios img');
    for (const img of panelImgs) {
      if (img.src === src || img.src.endsWith(src)) { alt = img.alt; break; }
    }
    if (!alt) alt = src.split('/').pop(); // Fallback: usa el nombre del archivo

    const recintoIndex = getRecintoIndex(dropzone);

    // 2) Validaciones de reglas y capacidad
    if (!puedeAgregarDinosaurio(dropzone, recintoIndex, alt)) {
      alert("No se puede agregar ese dinosaurio en este recinto según las reglas.");
      return;
    }
    const max = getMaxDinosPorRecinto(recintoIndex);
    if (max !== null && dropzone.children.length >= max) {
      alert("Este recinto ya está lleno.");
      return;
    }

    // 3) Crear/insertar el dino y habilitar borrado por click
    const img = document.createElement("img");
    img.src = src;
    img.alt = alt;
    img.draggable = false;
    img.className = "dropped-dino";
    img.style.height = '50px';
    img.style.cursor = 'pointer';
    img.addEventListener('click', () => { img.remove(); updateScore(); });

    dropzone.appendChild(img);
    updateScore();
  }
  </script>
</body>
</html>
