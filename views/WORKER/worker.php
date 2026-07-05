<?php
session_start();

$nombreUsuario = $_SESSION['nombre'];
$genero = $_SESSION['genero'] ?? 'Hombre';
$saludo = ($genero == "Mujer") ? "Bienvenida" : "Bienvenido";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Empleado | CIX Eventos</title>
    <link rel="icon" type="image/png" href="../../assets/content/logotip-cix.png">
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
            --verde:     #16a34a;
            --amarillo:  #d97706;
            --rojo:      #dc2626;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'DM Sans', sans-serif; background: var(--bg); color: var(--text); min-height: 100vh; }

        .navbar-cix {
            background: var(--azul); padding: 0.75rem 2rem;
            display: flex; align-items: center; justify-content: space-between;
            box-shadow: 0 2px 12px rgba(26,86,219,.18);
        }
        .navbar-brand-cix { display: flex; align-items: center; gap: 10px; }
        .navbar-brand-cix img { height: 42px; width: auto; border-radius: 50%; box-shadow: 0 0 0 2px rgba(255,255,255,.35); }
        .navbar-brand-cix span { color: #fff; font-family: 'DM Serif Display', serif; font-size: 1.2rem; letter-spacing: .5px; }
        .navbar-brand-cix small { display: block; color: rgba(255,255,255,.65); font-size: .68rem; font-weight: 300; letter-spacing: 1.5px; text-transform: uppercase; line-height: 1; }
        .btn-logout { background: transparent; border: 1.5px solid rgba(255,255,255,.5); color: #fff; border-radius: 8px; padding: .4rem 1rem; font-size: .85rem; font-weight: 500; transition: all .2s; text-decoration: none; }
        .btn-logout:hover { background: rgba(255,255,255,.15); border-color: #fff; color: #fff; }

        .hero { background: linear-gradient(135deg, var(--azul) 0%, #3b82f6 100%); color: #fff; padding: 2.5rem 2rem 3.5rem; }
        .hero h1 { font-family: 'DM Serif Display', serif; font-size: 2.4rem; font-weight: 400; margin-bottom: .2rem; }
        .hero h1 span { opacity: .75; }
        .hero p { opacity: .7; font-size: .95rem; font-weight: 300; }

        .layout {
            display: grid;
            grid-template-columns: 1fr 300px;
            gap: 1.5rem;
            max-width: 1150px;
            margin: -2rem auto 3rem;
            padding: 0 1.5rem;
            align-items: start;
        }

        .main-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; }

        .modulo-card {
            background: var(--card); border-radius: 16px;
            box-shadow: 0 4px 24px rgba(0,0,0,.07);
            padding: 2rem 1.75rem;
            display: flex; flex-direction: column;
            align-items: flex-start; gap: 1rem;
            border: 1.5px solid var(--border);
            transition: box-shadow .2s, border-color .2s, transform .2s;
            text-decoration: none; color: var(--text);
        }
        .modulo-card:hover {
            box-shadow: 0 8px 32px rgba(26,86,219,.13);
            border-color: #93c5fd; transform: translateY(-3px); color: var(--text);
        }
        .modulo-icono { width: 52px; height: 52px; border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 1.6rem; }
        .modulo-card:nth-child(1) .modulo-icono { background: #eff6ff; }
        .modulo-card:nth-child(2) .modulo-icono { background: #f0fdf4; }
        .modulo-card:nth-child(3) .modulo-icono { background: #fefce8; }
        .modulo-card:nth-child(4) .modulo-icono { background: #fdf4ff; }

        .modulo-titulo { font-family: 'DM Serif Display', serif; font-size: 1.2rem; font-weight: 400; color: var(--text); margin: 0; }
        .modulo-desc { font-size: .85rem; color: var(--muted); margin: 0; line-height: 1.5; }
        .modulo-arrow { margin-top: auto; font-size: .82rem; font-weight: 600; color: var(--azul); display: flex; align-items: center; gap: .3rem; }

        .aside-tareas {
            background: var(--card); border-radius: 16px;
            border: 1.5px solid var(--border);
            box-shadow: 0 4px 24px rgba(0,0,0,.07);
            overflow: hidden; position: sticky; top: 1.5rem;
        }
        .aside-header {
            padding: 1.1rem 1.3rem; border-bottom: 1.5px solid var(--border);
            display: flex; align-items: center; justify-content: space-between;
        }
        .aside-header-left { display: flex; align-items: center; gap: .55rem; }
        .aside-titulo { font-family: 'DM Serif Display', serif; font-size: 1rem; color: var(--text); }
        .aside-count {
            background: #eff6ff; color: var(--azul);
            font-size: .68rem; font-weight: 700;
            border-radius: 20px; padding: .12rem .5rem; display: none;
        }

        .aside-body { max-height: 520px; overflow-y: auto; }
        .aside-body::-webkit-scrollbar { width: 3px; }
        .aside-body::-webkit-scrollbar-thumb { background: var(--border); border-radius: 4px; }

        .tarea-item {
            padding: .9rem 1.3rem;
            border-left: 3px solid transparent;
            transition: background .15s;
            position: relative;
            border-bottom: 1px solid var(--border);
            cursor: pointer;
        }
        .tarea-item:last-child { border-bottom: none; }
        .tarea-item.pendiente { border-left-color: var(--azul); background: #f8fbff; }
        .tarea-item.completada { opacity: .55; }
        .tarea-item:hover { background: #f4f6fb; }

        .tarea-punto { width: 7px; height: 7px; border-radius: 50%; background: var(--azul); position: absolute; top: 1rem; right: 1rem; }
        .tarea-item.completada .tarea-punto { display: none; }

        .tarea-msg { font-size: .82rem; color: var(--text); line-height: 1.45; margin-bottom: .3rem; padding-right: 1rem; }
        .tarea-item.pendiente .tarea-msg { font-weight: 500; }

        .tarea-meta { font-size: .7rem; color: var(--muted); display: flex; align-items: center; justify-content: space-between; }
        .tarea-accion { color: var(--azul); font-weight: 600; }

        .btn-completar-tarea {
            margin-top: .6rem; width: 100%;
            background: #dcfce7; color: var(--verde);
            border: none; border-radius: 7px;
            padding: .3rem .6rem; font-size: .75rem;
            font-weight: 600; cursor: pointer;
            font-family: 'DM Sans', sans-serif;
            transition: background .2s;
        }
        .btn-completar-tarea:hover { background: #bbf7d0; }

        .aside-empty { padding: 2.5rem 1.3rem; text-align: center; color: var(--muted); }
        .aside-empty .icono { font-size: 2rem; margin-bottom: .6rem; }
        .aside-empty p { font-size: .82rem; }
        .aside-spinner { padding: 2rem; text-align: center; color: var(--muted); font-size: .85rem; }

        .toast-cix {
            position: fixed; bottom: 1.5rem; right: 1.5rem;
            background: var(--text); color: #fff;
            padding: .8rem 1.3rem; border-radius: 12px;
            font-size: .85rem; font-weight: 500;
            box-shadow: 0 8px 24px rgba(0,0,0,.2);
            opacity: 0; transform: translateY(10px);
            transition: all .3s; z-index: 9999; pointer-events: none;
        }
        .toast-cix.show { opacity: 1; transform: translateY(0); }

        @media (max-width: 900px) { .layout { grid-template-columns: 1fr; } .aside-tareas { position: static; } }
        @media (max-width: 600px) { .main-grid { grid-template-columns: 1fr; } .hero h1 { font-size: 1.8rem; } }
    </style>
</head>
<body>

<nav class="navbar-cix">
    <div class="navbar-brand-cix">
        <img src="../../assets/content/logotype.png" alt="CIX Logo">
        <div><span>CIX Eventos</span><small>Empleado</small></div>
    </div>
    <a href="../../controllers/logout.php" class="btn-logout">Cerrar Sesión</a>
</nav>

<div class="hero">
    <h1><?php echo $saludo; ?>, <span><?php echo ucwords(strtolower($nombreUsuario)); ?></span></h1>
    <p>Consulta tus tareas, eventos próximos y el inventario disponible.</p>
</div>

<div class="layout">

    <div class="main-grid">

        <a href="../INV/mod/revisar_eventos.php" class="modulo-card">
            <div class="modulo-icono">📋</div>
            <div>
                <p class="modulo-titulo">Revisar Eventos</p>
                <p class="modulo-desc">Consulta los eventos próximos y el mobiliario que se necesita preparar.</p>
            </div>
            <span class="modulo-arrow">Ir al módulo →</span>
        </a>

        <a href="mod/inv_general_worker.php" class="modulo-card">
            <div class="modulo-icono">📦</div>
            <div>
                <p class="modulo-titulo">Inventario General</p>
                <p class="modulo-desc">Consulta el stock disponible de todos los artículos registrados.</p>
            </div>
            <span class="modulo-arrow">Ir al módulo →</span>
        </a>

        <a href="mod/preparar_pedido.php" class="modulo-card">
            <div class="modulo-icono">🚚</div>
            <div>
                <p class="modulo-titulo">Preparar Pedido</p>
                <p class="modulo-desc">Revisa el mobiliario de cada evento y márcalo como listo para entregar.</p>
            </div>
            <span class="modulo-arrow">Ir al módulo →</span>
        </a>

    </div>

    <aside class="aside-tareas">
        <div class="aside-header">
            <div class="aside-header-left">
                <span style="font-size:1rem">🗂️</span>
                <span class="aside-titulo">Mis Tareas</span>
                <span class="aside-count" id="aside-count"></span>
            </div>
        </div>
        <div class="aside-body" id="aside-body">
            <div class="aside-spinner">Cargando...</div>
        </div>
    </aside>

</div>

<div class="toast-cix" id="toast"></div>

<script>
let tareasData = [];
const prioColor = { alta: '#dc2626', media: '#d97706', baja: '#16a34a' };

async function cargarTareas() {
    try {
        const res  = await fetch('/CixEventos/controllers/get_tareas.php?tipo=recibidas');
        const data = await res.json();
        tareasData = data;
        renderTareas(data);
    } catch(e) {
        document.getElementById('aside-body').innerHTML = `
            <div class="aside-empty">
                <div class="icono">⚠️</div>
                <p>No se pudieron cargar las tareas.</p>
            </div>`;
    }
}

function renderTareas(tareas) {
    const body  = document.getElementById('aside-body');
    const count = document.getElementById('aside-count');

    if (!tareas || tareas.length === 0) {
        body.innerHTML = `
            <div class="aside-empty">
                <div class="icono">✅</div>
                <p>Sin tareas asignadas por ahora.</p>
            </div>`;
        count.style.display = 'none';
        return;
    }

    const pendientes = tareas.filter(t => t.estado !== 'completada');
    count.textContent   = pendientes.length > 0 ? pendientes.length : '';
    count.style.display = pendientes.length > 0 ? 'inline-flex' : 'none';

    const ordenadas = [
        ...tareas.filter(t => t.estado !== 'completada'),
        ...tareas.filter(t => t.estado === 'completada')
    ];

    body.innerHTML = ordenadas.map(t => itemHTML(t)).join('');
}

function itemHTML(t) {
    const completada = t.estado === 'completada';
    const clase  = completada ? 'completada' : 'pendiente';
    const fecha  = formatFecha(t.fecha_creacion);
    const color  = prioColor[t.prioridad] || '#6b7280';
    const limite = t.fecha_limite ? ` · Límite: ${t.fecha_limite}` : '';

    return `
        <div class="tarea-item ${clase}" id="tarea-${t.id_tarea}">
            <div class="tarea-punto"></div>
            <div class="tarea-msg">
                <span style="display:inline-block;width:8px;height:8px;border-radius:50%;
                      background:${color};margin-right:.4rem;vertical-align:middle;"></span>
                ${t.titulo}
            </div>
            <div class="tarea-meta">
                <span>${fecha}${limite}</span>
                <span>${completada ? '✓ Lista' : '⏳'}</span>
            </div>
            ${!completada ? `
            <button class="btn-completar-tarea" onclick="completarTarea(${t.id_tarea}, this)">
                ✓ Marcar como completada
            </button>` : ''}
        </div>`;
}

async function completarTarea(id, btn) {
    btn.disabled = true;
    btn.textContent = 'Guardando...';
    try {
        const res  = await fetch('/CixEventos/controllers/completar_tarea.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id_tarea: id })
        });
        const data = await res.json();
        if (data.success) {
            mostrarToast('✅ Tarea completada.');
            cargarTareas();
        }
    } catch(e) { mostrarToast('Error de conexión.'); }
}

function formatFecha(fechaStr) {
    if (!fechaStr) return '';
    const d    = new Date(fechaStr);
    const diff = Math.floor((new Date() - d) / 60000);
    if (diff < 1)    return 'Ahora';
    if (diff < 60)   return `Hace ${diff} min`;
    if (diff < 1440) return `Hace ${Math.floor(diff / 60)}h`;
    return d.toLocaleDateString('es-MX', { day: '2-digit', month: 'short' });
}

function mostrarToast(msg) {
    const t = document.getElementById('toast');
    t.textContent = msg;
    t.classList.add('show');
    setTimeout(() => t.classList.remove('show'), 2800);
}

cargarTareas();
setInterval(cargarTareas, 60000);
</script>

</body>
</html>