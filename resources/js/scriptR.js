
const partidas = [
  { jugador: "Romina", puntos: 20, fecha: "2025-06-20" },
  { jugador: "Dante", puntos: 31, fecha: "2025-06-19" },
  { jugador: "Victoria", puntos: 19, fecha: "2025-06-18" },
];

partidas.sort((a, b) => b.puntos - a.puntos);

const scoreList = document.getElementById("score-list");
if (scoreList) {
  partidas.forEach((p, i) => {
    const li = document.createElement("li");
    li.className = "score-card";
    li.setAttribute("data-rank", i + 1);
    li.innerHTML = `
      <span class="rank">${i + 1}</span>
      <span class="who"><h3>${p.jugador}</h3></span>
      <span class="points">${p.puntos} pts</span>
      <span class="date">${p.fecha}</span>
    `;
    scoreList.appendChild(li);
  });
}

function volverAlInicio() {
  window.location.href = "/";
}