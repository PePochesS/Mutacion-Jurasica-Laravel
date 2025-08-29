<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Tabla de puntajes</title>
  <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;600;700&family=Luckiest+Guy&display=swap" rel="stylesheet">
  <link rel="icon" type="image/png" href="{{ asset('Fotos Equipo/LogoFinal.png') }}" sizes="32x32">
  <style>
    :root{
      --bg-overlay: rgba(18,18,18,.45);
      --panel: rgba(255,255,255,.08);
      --panel-2: rgba(255,255,255,.12);
      --border: rgba(255,255,255,.15);
      --text: #f2f6f8;
      --shadow: 0 10px 30px rgba(0,0,0,.35);
      --gold: #ffd66e; --silver: #dfe6f1; --bronze: #e8b08c;
    }

    *{ box-sizing: border-box }
    html,body{ height:100% }
    body{
      margin:0; color:var(--text);
      font-family:'Fredoka','Segoe UI',system-ui,-apple-system,sans-serif;
      background:#0d1b1e; overflow-x:hidden;
      display:flex; flex-direction:column; min-height:100vh;
    }
    main.container{ width:min(1100px,92%); margin:0 auto; flex:1; padding-top:40px }

    .bg{
      position:fixed; inset:0;
      background:
        linear-gradient(var(--bg-overlay),var(--bg-overlay)),
        url("{{ asset('ICONOS MENU/FondodePantallaR.png') }}") center center / cover no-repeat;
      background-attachment: fixed; /* Parallax sutil al hacer scroll */
      filter:saturate(110%); z-index:-1;
    }

    .back-menu{
      display:inline-flex; align-items:center; gap:8px; text-decoration:none;
      background:rgba(0,0,0,.5); color:#fff; padding:12px 20px; border-radius:14px;
      font-weight:700; backdrop-filter: blur(6px); box-shadow: 0 4px 12px rgba(0,0,0,.4);
      transition: background .2s, transform .08s ease;
    }
    .back-menu:hover{ background:rgba(0,0,0,.7) }
    .back-menu:active{ transform: translateY(1px) }

    .menu-btn-container{ display:flex; justify-content:center; margin:40px 0 60px; gap:16px }

    .scoreboard{ margin: 10px 0 60px }
    .score-grid{
      list-style:none; padding:0; margin:0;
      display:grid; grid-template-columns: repeat(auto-fit, minmax(230px, 1fr)); gap:18px;
    }
    .score-card{
      position:relative; isolation:isolate;
      background: linear-gradient(180deg, var(--panel-2), var(--panel));
      border:1px solid var(--border); border-radius:22px; box-shadow: var(--shadow);
      padding:18px 16px 16px;
      display:grid; grid-template-columns: auto 1fr auto; align-items:center; gap:14px;
      backdrop-filter: blur(8px); overflow:hidden;
    }
    .score-card::before{
      content:"";
      position:absolute; inset:-30% -10% auto auto; height:160px; width:160px;
      background:
        radial-gradient(circle at 40% 60%, rgba(255,255,255,.06) 0 48%, transparent 50%),
        radial-gradient(circle at 70% 30%, rgba(255,255,255,.06) 0 40%, transparent 42%);
      transform: rotate(-15deg);
      pointer-events:none; z-index:-1;
      /* Brillo decorativo con dos gradientes radiales superpuestos */
    }
    .rank{
      width:44px; height:44px; display:grid; place-items:center;
      font: 800 18px/1 'Fredoka', system-ui; color:#1b1b1b;
      background:#fff; border-radius:50%;
      box-shadow: 0 6px 14px rgba(0,0,0,.25) inset, 0 6px 12px rgba(0,0,0,.25);
    }
    /* Medallero: el atributo data-rank (1–3) colorea el círculo automáticamente */
    .score-card[data-rank="1"] .rank{ background:var(--gold) }
    .score-card[data-rank="2"] .rank{ background:var(--silver) }
    .score-card[data-rank="3"] .rank{ background:var(--bronze) }

    .who{ display:flex; align-items:center; gap:10px }
    .who h3{ margin:0; font:700 18px/1.1 'Fredoka', system-ui; letter-spacing:.2px }

    .points{
      font: 900 26px/1 'Luckiest Guy', system-ui;
      padding:8px 12px; border-radius:12px;
      background: linear-gradient(180deg,#fff,#dff6ff);
      color:#0b2230; min-width:70px; text-align:center;
      box-shadow: 0 8px 20px rgba(0,0,0,.25);
    }

    .footer{
      padding:20px; text-align:center; color:#e6f1f5;
      background: linear-gradient(to top, rgba(0,0,0,.55), rgba(0,0,0,0));
    }

    .hero{ text-align:center; margin: 14vh 0 5vh; }
    .page-title{
      margin:0; font: 900 clamp(40px,7vw,80px)/1 'Luckiest Guy', system-ui;
      letter-spacing:.5px; text-shadow: 0 6px 20px rgba(0,0,0,.35);
      color:#fff; background: rgba(0,0,0,0.3); padding: 12px 24px; border-radius: 14px; display:inline-block;
    }
  </style>
</head>
<body>
  <div class="bg"></div>

  <main class="container">
    <section class="hero">
      <h1 class="page-title">Tabla de puntajes</h1>
    </section>

    <section class="scoreboard">
      <ul class="score-grid" id="score-list"></ul>
    </section>

    <div class="menu-btn-container">
      <a class="back-menu" href="{{ route('home') }}">← Volver al menú</a>
    </div>
  </main>

  <footer class="footer">
    <small>© 2025 DinoDiceTeam</small>
  </footer>

  <script>
    const partidas = [
      { jugador: "Dante", puntos: 128, fecha: "2025-06-19" },
      { jugador: "Romi",  puntos: 121, fecha: "2025-06-20" },
      { jugador: "Vicky", puntos: 109, fecha: "2025-06-18" },
      { jugador: "Santi", puntos:  96, fecha: "2025-06-17" }
    ];

    partidas.sort((a, b) => b.puntos - a.puntos); // Orden descendente por puntos (ranking)

    const scoreList = document.getElementById("score-list");
    partidas.forEach((p, idx) => {
      const li = document.createElement("li");
      li.className = "score-card";
      if (idx < 3) li.setAttribute("data-rank", idx + 1); // Top-3: se marca para estilos oro/plata/bronce
      li.innerHTML = `
        <span class="rank">${idx + 1}</span>
        <div class="who"><h3>${p.jugador}</h3></div>
        <span class="points">${p.puntos}</span>
      `;
      scoreList.appendChild(li);
    });
  </script>
</body>
</html>
