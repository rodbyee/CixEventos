<?php
session_start();

$nombreUsuario = $_SESSION['nombre'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Revisar Eventos | CIX Eventos</title>
    <link rel="icon" type="image/png" href="../../../assets/content/logotip-cix.png"> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --azul:      #1a56db;
            --azul-dark: #1341b0;
            --bg:        #f4f6fb;
            --card:      #ffffff;
            --text:      #1a1d2e;
            --muted:     #6b7280;
            --border:    #e5e7ef;
            --confirmado:#16a34a;
            --pendiente: #d97706;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
        }

        /* ── NAVBAR ── */
        .navbar-cix {
            background: var(--azul);
            padding: 0.75rem 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 2px 12px rgba(26,86,219,.18);
        }
        .navbar-brand-cix {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .navbar-brand-cix img {
            height: 42px;
            width: auto;
            border-radius: 50%;
            box-shadow: 0 0 0 2px rgba(255,255,255,.35);
        }
        .navbar-brand-cix span {
            color: #fff;
            font-family: 'DM Serif Display', serif;
            font-size: 1.2rem;
            letter-spacing: .5px;
        }
        .navbar-brand-cix small {
            display: block;
            color: rgba(255,255,255,.65);
            font-size: .68rem;
            font-weight: 300;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            line-height: 1;
        }
        .navbar-nav-cix {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        .btn-back {
            background: rgba(255,255,255,.15);
            border: 1.5px solid rgba(255,255,255,.4);
            color: #fff;
            border-radius: 8px;
            padding: .4rem 1rem;
            font-size: .85rem;
            font-weight: 500;
            text-decoration: none;
            transition: all .2s;
        }
        .btn-back:hover {
            background: rgba(255,255,255,.25);
            color: #fff;
        }
        .btn-logout {
            background: transparent;
            border: 1.5px solid rgba(255,255,255,.5);
            color: #fff;
            border-radius: 8px;
            padding: .4rem 1rem;
            font-size: .85rem;
            font-weight: 500;
            text-decoration: none;
            transition: all .2s;
        }
        .btn-logout:hover {
            background: rgba(255,255,255,.15);
            border-color: #fff;
            color: #fff;
        }

        /* ── HERO ── */
        .hero {
            background: linear-gradient(135deg, var(--azul) 0%, #3b82f6 100%);
            color: #fff;
            padding: 2.5rem 2rem 3.5rem;
        }
        .hero h1 {
            font-family: 'DM Serif Display', serif;
            font-size: 2.2rem;
            font-weight: 400;
            margin-bottom: .2rem;
        }
        .hero p {
            opacity: .7;
            font-size: .95rem;
            font-weight: 300;
        }

        /* ── CONTENIDO ── */
        .contenido {
            max-width: 1100px;
            margin: -2rem auto 3rem;
            padding: 0 1.5rem;
        }

        /* ── PANEL ── */
        .panel {
            background: var(--card);
            border-radius: 16px;
            box-shadow: 0 4px 24px rgba(0,0,0,.07);
            overflow: hidden;
        }
        .panel-header {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: .75rem;
        }
        .panel-header h2 {
            font-family: 'DM Serif Display', serif;
            font-size: 1.25rem;
            font-weight: 400;
            color: var(--text);
            margin: 0;
        }
        .panel-body { padding: 1.5rem; }

        /* ── FILTROS ── */
        .filtros {
            display: flex;
            gap: .75rem;
            flex-wrap: wrap;
            align-items: center;
        }
        .filtro-btn {
            background: var(--bg);
            border: 1.5px solid var(--border);
            border-radius: 999px;
            padding: .3rem .9rem;
            font-size: .8rem;
            font-weight: 600;
            cursor: pointer;
            transition: all .2s;
            color: var(--muted);
        }
        .filtro-btn:hover, .filtro-btn.activo {
            background: var(--azul);
            border-color: var(--azul);
            color: #fff;
        }

        /* ── GRID DE EVENTOS ── */
        .eventos-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.1rem;
        }

        /* ── EVENTO CARD ── */
        .evento-card {
            border: 1.5px solid var(--border);
            border-radius: 12px;
            padding: 1.1rem 1.2rem;
            transition: box-shadow .2s, border-color .2s;
            background: #fff;
        }
        .evento-card:hover {
            box-shadow: 0 4px 16px rgba(26,86,219,.1);
            border-color: #93c5fd;
        }
        .evento-top {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: .6rem;
        }
        .evento-nombre {
            font-weight: 600;
            font-size: 1rem;
            color: var(--text);
        }
        .badge-estado {
            font-size: .7rem;
            font-weight: 600;
            padding: .25rem .65rem;
            border-radius: 999px;
            white-space: nowrap;
        }
        .badge-confirmado { background: #dcfce7; color: var(--confirmado); }
        .badge-pendiente  { background: #fef3c7; color: var(--pendiente); }

        .evento-meta {
            font-size: .8rem;
            color: var(--muted);
            line-height: 1.7;
            margin-bottom: .75rem;
        }

        /* ── CLIENTE INFO ── */
        .cliente-info {
            background: #f8faff;
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: .6rem .8rem;
            margin-bottom: .75rem;
        }
        .cliente-info p {
            margin: 0;
            font-size: .78rem;
            color: var(--muted);
            line-height: 1.6;
        }
        .cliente-info strong {
            color: var(--text);
            font-weight: 600;
        }

        /* ── SELECT ESTADO ── */
        .select-estado {
            border: 1.5px solid var(--border);
            border-radius: 8px;
            padding: .3rem .6rem;
            font-size: .78rem;
            font-family: 'DM Sans', sans-serif;
            cursor: pointer;
            background: #fafbff;
            color: var(--text);
            width: 100%;
            transition: border-color .2s;
        }
        .select-estado:focus {
            outline: none;
            border-color: var(--azul);
        }

        /* ── SIN EVENTOS ── */
        .sin-eventos {
            text-align: center;
            padding: 3rem 1rem;
            color: var(--muted);
            grid-column: 1 / -1;
        }
        .sin-eventos .icono { font-size: 2.5rem; margin-bottom: .75rem; }

        @media (max-width: 700px) {
            .hero h1 { font-size: 1.7rem; }
            .eventos-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar-cix">
    <div class="navbar-brand-cix">
        <img src="../../../assets/content/logotype.png" alt="CIX Logo">
        <div>
            <span>CIX Eventos</span>
            <small><?php echo $_SESSION['rol'] == 1 ? 'Admin' : ($_SESSION['rol'] == 2 ? 'Encargado Inventario' : 'Empleado'); ?></small>
        </div>
    </div>
    <div class="navbar-nav-cix">
        <a href="<?php $rol = $_SESSION['rol']; 
       if ($rol == 1)      echo '/CixEventos/views/ADMIN/admin.php';
       elseif ($rol == 2)  echo '/CixEventos/views/INV/inventario.php';
       else                echo '/CixEventos/views/WORKER/worker.php'; ?>" class="btn-back">← Regresar</a>
        <a href="../../../controllers/logout.php" class="btn-logout">Cerrar Sesión</a>
    </div>
</nav>

<!-- HERO -->
<div class="hero">
    <h1>📋 Revisar Eventos</h1>
    <p>Consulta todos los eventos registrados por los clientes.</p>
</div>

<!-- CONTENIDO -->
<div class="contenido">
    <div class="panel">
        <div class="panel-header">
            <h2>Todos los Eventos <span id="contador" style="font-size:.85rem;color:var(--muted);font-family:'DM Sans',sans-serif;"></span></h2>
            <div class="filtros">
                <button class="filtro-btn activo" onclick="filtrar('todos', this)">Todos</button>
                <button class="filtro-btn" onclick="filtrar('Pendiente', this)">Pendientes</button>
                <button class="filtro-btn" onclick="filtrar('Confirmado', this)">Confirmados</button>
            </div>
        </div>
        <div class="panel-body">
            <div class="eventos-grid" id="lista-eventos">
                <div class="sin-eventos">
                    <div class="icono">📅</div>
                    <p>Cargando eventos...</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
let todosLosEventos = [];

function cargarEventos() {
    fetch('/CixEventos/controllers/get_all_ev.php')
        .then(r => r.json())
        .then(data => {
            todosLosEventos = data;
            renderEventos(data);
        })
        .catch(() => {
            document.getElementById('lista-eventos').innerHTML =
                `<div class="sin-eventos"><div class="icono">⚠️</div><p>Error al cargar los eventos.</p></div>`;
        });
}

function filtrar(estado, btn) {
    document.querySelectorAll('.filtro-btn').forEach(b => b.classList.remove('activo'));
    btn.classList.add('activo');

    const filtrados = estado === 'todos'
        ? todosLosEventos
        : todosLosEventos.filter(e => e.estado === estado);

    renderEventos(filtrados);
}

function renderEventos(eventos) {
    const lista = document.getElementById('lista-eventos');
    const contador = document.getElementById('contador');

    if (!eventos.length) {
        lista.innerHTML = `<div class="sin-eventos"><div class="icono">📅</div><p>No hay eventos para mostrar.</p></div>`;
        contador.textContent = '';
        return;
    }

    contador.textContent = `· ${eventos.length} ${eventos.length === 1 ? 'evento' : 'eventos'}`;

    lista.innerHTML = eventos.map(ev => {
        const estadoClass = ev.estado === 'Confirmado' ? 'badge-confirmado' : 'badge-pendiente';
        const horaIn  = ev.hora_inicio ? ev.hora_inicio.substring(0, 5) : '--:--';
        const horaOut = ev.hora_fin    ? ev.hora_fin.substring(0, 5)    : '--:--';

        return `
        <div class="evento-card">
            <div class="evento-top">
                <span class="evento-nombre">${ev.nombre_evento}</span>
                <span class="badge-estado ${estadoClass}">${ev.estado}</span>
            </div>
            <div class="evento-meta">
                📅 ${ev.fecha_evento} &nbsp;·&nbsp; 🕐 ${horaIn} - ${horaOut}<br>
                📍 ${ev.direccion ?? '—'}
            </div>
            <div class="cliente-info">
                <p>👤 <strong>${ev.nombre_usuario}</strong></p>
                <p>✉️ ${ev.email_usuario}</p>
            </div>
            <select class="select-estado" onchange="cambiarEstado(${ev.id_evento}, this.value)">
                <option value="Pendiente"  ${ev.estado === 'Pendiente'  ? 'selected' : ''}>⏳ Pendiente</option>
                <option value="Confirmado" ${ev.estado === 'Confirmado' ? 'selected' : ''}>✅ Confirmado</option>
                <option value="Cancelado"  ${ev.estado === 'Cancelado'  ? 'selected' : ''}>❌ Cancelado</option>
            </select>
            <div style="margin-top:.7rem;">
                <a href="mobiliario_evento.php?id_evento=${ev.id_evento}" class="btn-mobiliario">
                    📦 Ver Mobiliario
                </a>
            </div>
        </div>`;
    }).join('');
}

function cambiarEstado(id_evento, nuevoEstado) {
    const formData = new FormData();
    formData.append('id_evento', id_evento);
    formData.append('estado', nuevoEstado);

    fetch('/CixEventos/controllers/chstev.php', {
        method: 'POST',
        body: formData
    })
    .then(r => r.json())
    .then(res => {
        if (res.ok) cargarEventos();
    });
}

cargarEventos();
</script>

</body>
</html>