<?php
session_start();
if (!isset($_SESSION['id']) || $_SESSION['rol'] != 1) {
    header('Location: ../../login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendario | CIX Eventos</title>
    <link rel="icon" type="image/png" href="../../../assets/content/logotip-cix.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --azul:      #1a56db;
            --bg:        #f4f6fb;
            --card:      #ffffff;
            --text:      #1a1d2e;
            --muted:     #6b7280;
            --border:    #e5e7ef;
            --verde:     #16a34a;
            --amarillo:  #d97706;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'DM Sans', sans-serif; background: var(--bg); color: var(--text); min-height: 100vh; }

        .navbar-cix {
            background: var(--azul);
            padding: 0.75rem 2rem;
            display: flex; align-items: center; justify-content: space-between;
            box-shadow: 0 2px 12px rgba(26,86,219,.18);
        }
        .navbar-brand-cix { display: flex; align-items: center; gap: 10px; }
        .navbar-brand-cix img { height: 42px; border-radius: 50%; box-shadow: 0 0 0 2px rgba(255,255,255,.35); }
        .navbar-brand-cix span { color: #fff; font-family: 'DM Serif Display', serif; font-size: 1.2rem; }
        .navbar-brand-cix small { display: block; color: rgba(255,255,255,.65); font-size: .68rem; font-weight: 300; letter-spacing: 1.5px; text-transform: uppercase; }
        .navbar-right { display: flex; align-items: center; gap: .75rem; }
        .btn-back, .btn-logout {
            border: 1.5px solid rgba(255,255,255,.5); color: #fff; border-radius: 8px;
            padding: .4rem 1rem; font-size: .85rem; font-weight: 500; text-decoration: none; transition: all .2s;
        }
        .btn-back { background: rgba(255,255,255,.15); }
        .btn-back:hover, .btn-logout:hover { background: rgba(255,255,255,.25); color: #fff; }
        .btn-logout { background: transparent; }

        .hero {
            background: linear-gradient(135deg, var(--azul) 0%, #3b82f6 100%);
            color: #fff; padding: 2rem 2rem 3rem;
        }
        .hero h1 { font-family: 'DM Serif Display', serif; font-size: 2rem; font-weight: 400; margin-bottom: .2rem; }
        .hero p { opacity: .7; font-size: .9rem; font-weight: 300; }

        .contenido {
            max-width: 1100px;
            margin: -1.5rem auto 3rem;
            padding: 0 1.5rem;
        }
        .cal-wrap {
            background: var(--card);
            border-radius: 16px;
            border: 1.5px solid var(--border);
            box-shadow: 0 4px 24px rgba(0,0,0,.07);
            padding: 1.5rem;
        }
        .fc .fc-toolbar-title {
            font-family: 'DM Serif Display', serif;
            font-size: 1.3rem; color: var(--text);
        }
        .fc .fc-button {
            background: var(--azul) !important;
            border-color: var(--azul) !important;
            font-family: 'DM Sans', sans-serif;
            font-size: .82rem; border-radius: 8px !important;
        }
        .fc .fc-button:hover { background: #1341b0 !important; }
        .fc-event {
            border-radius: 6px !important; border: none !important;
            font-size: .8rem !important; padding: 2px 6px !important; cursor: pointer;
        }
        .fc-day-today { background: #eff6ff !important; }

        .modal-cix {
            display: none; position: fixed; inset: 0;
            background: rgba(0,0,0,.45); z-index: 9999;
            align-items: center; justify-content: center; padding: 1rem;
        }
        .modal-cix.show { display: flex; }
        .modal-box {
            background: var(--card); border-radius: 18px;
            box-shadow: 0 16px 48px rgba(0,0,0,.18);
            padding: 2rem; width: 100%; max-width: 520px;
            position: relative; animation: slideUp .2s ease;
        }
        @keyframes slideUp {
            from { transform: translateY(20px); opacity: 0; }
            to   { transform: translateY(0);    opacity: 1; }
        }
        .modal-close {
            position: absolute; top: 1rem; right: 1.2rem;
            font-size: 1.4rem; cursor: pointer; color: var(--muted);
            background: none; border: none; line-height: 1;
        }
        .modal-close:hover { color: var(--text); }
        .modal-titulo { font-family: 'DM Serif Display', serif; font-size: 1.4rem; margin-bottom: 1.2rem; padding-right: 1.5rem; }
        .modal-fila { display: flex; gap: .6rem; align-items: flex-start; margin-bottom: .75rem; font-size: .88rem; }
        .modal-fila .icono { font-size: 1rem; flex-shrink: 0; margin-top: .1rem; }
        .modal-fila .label { color: var(--muted); font-size: .78rem; display: block; }
        .modal-fila .valor { color: var(--text); font-weight: 500; }
        .badge-estado { display: inline-block; padding: .25rem .75rem; border-radius: 20px; font-size: .75rem; font-weight: 600; }
        .badge-confirmado { background: #dcfce7; color: var(--verde); }
        .badge-pendiente  { background: #fef3c7; color: var(--amarillo); }
        .mob-lista { margin-top: .4rem; border: 1.5px solid var(--border); border-radius: 10px; overflow: hidden; }
        .mob-item { display: flex; justify-content: space-between; padding: .55rem .85rem; font-size: .84rem; border-bottom: 1px solid var(--border); }
        .mob-item:last-child { border-bottom: none; }
        .mob-item span:last-child { color: var(--muted); font-size: .8rem; }
        .seccion-mob { margin-top: 1rem; font-size: .72rem; font-weight: 600; letter-spacing: 1.5px; text-transform: uppercase; color: var(--muted); margin-bottom: .5rem; }

        @media (max-width: 700px) {
            .hero h1 { font-size: 1.6rem; }
            .cal-wrap { padding: 1rem; }
        }
    </style>
</head>
<body>

<nav class="navbar-cix">
    <div class="navbar-brand-cix">
        <img src="../../../assets/content/logotype.png" alt="CIX Logo">
        <div>
            <span>CIX Eventos</span>
            <small>Admin</small>
        </div>
    </div>
    <div class="navbar-right">
        <a href="../admin.php" class="btn-back">← Volver</a>
        <a href="/CixEventos/controllers/logout.php" class="btn-logout">Cerrar Sesión</a>
    </div>
</nav>

<div class="hero">
    <h1>🗓️ Calendario de Eventos</h1>
    <p>Visualiza todos los eventos activos y próximos de manera interactiva.</p>
</div>

<div class="contenido">
    <div class="cal-wrap">
        <div id="calendario"></div>
    </div>
</div>

<div class="modal-cix" id="modal">
    <div class="modal-box">
        <button class="modal-close" onclick="cerrarModal()">✕</button>
        <div class="modal-titulo" id="modal-titulo"></div>
        <div class="modal-fila">
            <span class="icono">📅</span>
            <div><span class="label">Fecha y hora</span><span class="valor" id="modal-fecha"></span></div>
        </div>
        <div class="modal-fila">
            <span class="icono">📍</span>
            <div><span class="label">Dirección</span><span class="valor" id="modal-direccion"></span></div>
        </div>
        <div class="modal-fila">
            <span class="icono">👤</span>
            <div><span class="label">Cliente</span><span class="valor" id="modal-cliente"></span></div>
        </div>
        <div class="modal-fila">
            <span class="icono">🔖</span>
            <div><span class="label">Estado</span><span class="valor" id="modal-estado"></span></div>
        </div>
        <div class="seccion-mob">Mobiliario apartado</div>
        <div id="modal-mob"></div>
    </div>
</div>

<!-- ✅ FullCalendar solo UNA vez, al final del body -->
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const calEl = document.getElementById('calendario');
    const calendar = new FullCalendar.Calendar(calEl, {
        locale: 'es',
        initialView: 'dayGridMonth',
        headerToolbar: {
            left:   'prev,next today',
            center: 'title',
            right:  'dayGridMonth,timeGridWeek,listWeek'
        },
        buttonText: {
            today: 'Hoy',
            month: 'Mes',
            week:  'Semana',
            list:  'Lista'
        },
        height: 'auto',
        events: '/CixEventos/controllers/get_eventos_calendario.php',
        eventColor: '#1a56db',
        eventClick: function(info) {
            abrirModal(info.event);
        }
    });
    calendar.render();
});

function abrirModal(evento) {
    const p = evento.extendedProps;
    document.getElementById('modal-titulo').textContent = evento.title;

    const inicio = evento.start;
    const fin    = evento.end;
    const opcFecha = { weekday:'long', year:'numeric', month:'long', day:'numeric' };
    const opcHora  = { hour:'2-digit', minute:'2-digit' };
    const fechaStr = inicio.toLocaleDateString('es-MX', opcFecha);
    const horaStr  = inicio.toLocaleTimeString('es-MX', opcHora) + ' – ' + (fin ? fin.toLocaleTimeString('es-MX', opcHora) : '');
    document.getElementById('modal-fecha').textContent = fechaStr + ' · ' + horaStr;
    document.getElementById('modal-direccion').textContent = p.direccion;
    document.getElementById('modal-cliente').textContent   = p.cliente;

    const estadoEl = document.getElementById('modal-estado');
    const esConf   = p.estado?.toLowerCase() === 'confirmado';
    estadoEl.innerHTML = `<span class="badge-estado ${esConf ? 'badge-confirmado' : 'badge-pendiente'}">${p.estado}</span>`;

    const mobEl = document.getElementById('modal-mob');
    if (p.mobiliario && p.mobiliario.length > 0) {
        mobEl.innerHTML = `
            <div class="mob-lista">
                ${p.mobiliario.map(m => `
                    <div class="mob-item">
                        <span>${m.nombre_item}</span>
                        <span>${m.cantidad} pza${m.cantidad > 1 ? 's' : ''}</span>
                    </div>
                `).join('')}
            </div>`;
    } else {
        mobEl.innerHTML = `<p style="font-size:.85rem;color:var(--muted)">Sin mobiliario apartado.</p>`;
    }

    document.getElementById('modal').classList.add('show');
}

function cerrarModal() {
    document.getElementById('modal').classList.remove('show');
}

document.getElementById('modal').addEventListener('click', function(e) {
    if (e.target === this) cerrarModal();
});
</script>

</body>
</html>