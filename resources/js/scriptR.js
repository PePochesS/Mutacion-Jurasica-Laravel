
const partidas = [
  { jugador: "Romina", puntos: 65, fecha: "2025-06-20" },
  { jugador: "Dante", puntos: 78, fecha: "2025-06-19" },
  { jugador: "Victoria", puntos: 59, fecha: "2025-06-18" },
];

partidas.sort((a, b) => b.puntos - a.puntos);

const tabla = document.getElementById("tabla-puntajes");

partidas.forEach(p => {
  const fila = document.createElement("tr");
  fila.innerHTML = `<td>${p.jugador}</td><td>${p.puntos}</td><td>${p.fecha}</td>`;
  tabla.appendChild(fila);
});

function volverAlInicio() {
  window.location.href = "index.html"; 
}