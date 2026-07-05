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
    <title>Eventos Pasados | CIX Eventos</title>
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
            --verde:     #16a34a;
            --rojo:      #dc2626;
            --amarillo:  #d97706;
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
        .navbar-brand-cix { display: flex; align-items: center; gap: 10px; }
        .navbar-brand-cix img {
            height: 42px; width: auto; border-radius: 50%;
            box-shadow: 0 0 0 2px rgba(255,255,255,.35);
        }
        .navbar-brand-cix span {
            color: #fff;
            font-family: 'DM Serif Display', serif;
            font-size: 1.2rem;
        }
        .navbar-brand-cix small {
            display: block; color: rgba(255,255,255,.65);
            font-size: .68rem; font-weight: 300;
            letter-spacing: 1.5px; text-transform: uppercase; line-height: 1;
        }
        .navbar-right { display: flex; align-items: center; gap: .75rem; }
        .btn-back {
            background: rgba(255,255,255,.15);
            border: 1.5px solid rgba(255,255,255,.4);
            color: #fff; border-radius: 8px;
            padding: .4rem 1rem; font-size: .85rem;
            font-weight: 500; text-decoration: none; transition: all .2s;
        }
        .btn-back:hover { background: rgba(255,255,255,.25); color: #fff; }
        .btn-logout {
            background: transparent;
            border: 1.5px solid rgba(255,255,255,.5);
            color: #fff; border-radius: 8px;
            padding: .4rem 1rem; font-size: .85rem;
            font-weight: 500; text-decoration: none; transition: all .2s;
        }
        .btn-logout:hover { background: rgba(255,255,255,.15); border-color: #fff; color: #fff; }

        /* ── HERO ── */
        .hero {
            background: linear-gradient(135deg, var(--azul) 0%, #3b82f6 100%);
            color: #fff;
            padding: 2rem 2rem 3rem;
        }
        .hero h1 {
            font-family: 'DM Serif Display', serif;
            font-size: 2rem; font-weight: 400; margin-bottom: .2rem;
        }
        .hero p { opacity: .7; font-size: .9rem; font-weight: 300; }

        /* ── CONTENIDO ── */
        .contenido {
            max-width: 1100px;
            margin: -1.5rem auto 3rem;
            padding: 0 1.5rem;
        }

        /* ── FILTROS ── */
        .filtros {
            background: var(--card);
            border-radius: 14px;
            border: 1.5px solid var(--border);
            box-shadow: 0 4px 16px rgba(0,0,0,.06);
            padding: 1.1rem 1.4rem;
            display: flex;
            gap: 1rem;
            align-items: center;
            flex-wrap: wrap;
            margin-bottom: 1.5rem;
        }
        .filtros label { font-size: .8rem; font-weight: 600; color: var(--muted); margin-bottom: .2rem; display: block; }
        .filtros select, .filtros input {
            border: 1.5px solid var(--border);
            border-radius: 8px;
            padding: .4rem .8rem;
            font-size: .85rem;
            font-family: 'DM Sans', sans-serif;
            color: var(--text);
            background: var(--bg);
            outline: none;
        }
        .filtros select:focus, .filtros input:focus { border-color: var(--azul); }

        /* ── EVENTO CARD ── */
        .evento-card {
            background: var(--card);
            border-radius: 16px;
            border: 1.5px solid var(--border);
            box-shadow: 0 4px 20px rgba(0,0,0,.06);
            margin-bottom: 1.2rem;
            overflow: hidden;
            transition: box-shadow .2s;
        }
        .evento-card:hover { box-shadow: 0 6px 28px rgba(0,0,0,.1); }

        .evento-header {
            padding: 1.2rem 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            cursor: pointer;
            user-select: none;
        }
        .evento-header:hover { background: #f8faff; }

        .evento-info { flex: 1; }
        .evento-nombre {
            font-family: 'DM Serif Display', serif;
            font-size: 1.15rem;
            color: var(--text);
            margin-bottom: .25rem;
        }
        .evento-meta {
            font-size: .8rem;
            color: var(--muted);
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }
        .evento-meta span { display: flex; align-items: center; gap: .3rem; }

        .evento-badges { display: flex; gap: .5rem; align-items: center; flex-shrink: 0; }

        .badge-estado {
            padding: .3rem .8rem;
            border-radius: 20px;
            font-size: .75rem;
            font-weight: 600;
            letter-spacing: .3px;
        }
        .badge-devuelto    { background: #dcfce7; color: var(--verde); }
        .badge-pendiente   { background: #fef3c7; color: var(--amarillo); }
        .badge-sin-mob     { background: #f3f4f6; color: var(--muted); }

        .chevron {
            color: var(--muted);
            font-size: 1.1rem;
            transition: transform .2s;
        }
        .evento-card.open .chevron { transform: rotate(180deg); }

        /* ── DETALLE MOBILIARIO ── */
        .evento-detalle {
            display: none;
            border-top: 1.5px solid var(--border);
            padding: 1.2rem 1.5rem;
            background: #fafbff;
        }
        .evento-card.open .evento-detalle { display: block; }

        .detalle-titulo {
            font-size: .72rem;
            font-weight: 600;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: var(--muted);
            margin-bottom: .9rem;
        }

        .mob-tabla {
            width: 100%;
            border-collapse: collapse;
            font-size: .85rem;
        }
        .mob-tabla th {
            text-align: left;
            font-weight: 600;
            font-size: .75rem;
            color: var(--muted);
            padding: .5rem .75rem;
            border-bottom: 1.5px solid var(--border);
            text-transform: uppercase;
            letter-spacing: .8px;
        }
        .mob-tabla td {
            padding: .7rem .75rem;
            border-bottom: 1px solid var(--border);
            vertical-align: middle;
        }
        .mob-tabla tr:last-child td { border-bottom: none; }

        .estado-devuelto { color: var(--verde); font-weight: 600; font-size: .82rem; }
        .estado-pendiente { color: var(--amarillo); font-weight: 600; font-size: .82rem; }

        /* ── BOTÓN NOTIFICAR ── */
        .btn-notificar {
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            background: #fff7ed;
            color: #c2410c;
            border: 1.5px solid #fed7aa;
            border-radius: 8px;
            padding: .35rem .85rem;
            font-size: .8rem;
            font-weight: 600;
            cursor: pointer;
            transition: all .2s;
            font-family: 'DM Sans', sans-serif;
        }
        .btn-notificar:hover { background: #ffedd5; border-color: #c2410c; }
        .btn-notificar:disabled { opacity: .5; cursor: not-allowed; }
        .btn-notificar.enviado {
            background: #dcfce7; color: var(--verde);
            border-color: #86efac; cursor: default;
        }

        .acciones-footer {
            margin-top: 1rem;
            padding-top: .9rem;
            border-top: 1px dashed var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: .75rem;
        }
        .acciones-footer-txt { font-size: .8rem; color: var(--muted); }

        /* ── EMPTY STATE ── */
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            color: var(--muted);
        }
        .empty-state .icono { font-size: 3rem; margin-bottom: 1rem; }
        .empty-state p { font-size: .9rem; }

        /* ── TOAST ── */
        .toast-cix {
            position: fixed;
            bottom: 1.5rem; right: 1.5rem;
            background: var(--text);
            color: #fff;
            padding: .8rem 1.3rem;
            border-radius: 12px;
            font-size: .85rem;
            font-weight: 500;
            box-shadow: 0 8px 24px rgba(0,0,0,.2);
            opacity: 0;
            transform: translateY(10px);
            transition: all .3s;
            z-index: 9999;
            pointer-events: none;
        }
        .toast-cix.show { opacity: 1; transform: translateY(0); }

        /* ── LOADING ── */
        .spinner {
            text-align: center;
            padding: 3rem;
            color: var(--muted);
            font-size: .9rem;
        }

        @media (max-width: 700px) {
            .hero h1 { font-size: 1.6rem; }
            .filtros { flex-direction: column; align-items: stretch; }
            .evento-badges { flex-wrap: wrap; }
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
            <small>Admin</small>
        </div>
    </div>
    <div class="navbar-right">
        <a href="../admin.php" class="btn-back">← Volver</a>
        <a href="../../../../controllers/logout.php" class="btn-logout">Cerrar Sesión</a>
    </div>
</nav>

<!-- HERO -->
<div class="hero">
    <h1>📅 Eventos Pasados</h1>
    <p>Historial de eventos realizados y estado de devolución del mobiliario.</p>
</div>

<!-- CONTENIDO -->
<div class="contenido">

    <!-- FILTROS -->
    <div class="filtros">
        <div>
            <label>Buscar evento</label>
            <input type="text" id="buscador" placeholder="Nombre del evento o cliente..." style="width:220px;">
        </div>
        <div>
            <label>Filtrar por devolución</label>
            <select id="filtro-devolucion">
                <option value="todos">Todos</option>
                <option value="pendiente">Con pendientes</option>
                <option value="completo">Completamente devueltos</option>
                <option value="sin">Sin mobiliario</option>
            </select>
        </div>
        <div>
            <label>Ordenar por</label>
            <select id="filtro-orden">
                <option value="reciente">Más reciente</option>
                <option value="antiguo">Más antiguo</option>
            </select>
        </div>
    </div>

    <!-- LISTA DE EVENTOS -->
    <div id="lista-eventos">
        <div class="spinner">Cargando eventos pasados...</div>
    </div>

</div>

<!-- TOAST -->
<div class="toast-cix" id="toast"></div>

<script>
let eventosData = [];

// ── Cargar eventos pasados
async function cargarEventos() {
    try {
        const res = await fetch('/CixEventos/controllers/get_eventos_pasados.php');
        const data = await res.json();
        eventosData = data;
        renderEventos(data);
    } catch (e) {
        document.getElementById('lista-eventos').innerHTML = `
            <div class="empty-state">
                <div class="icono">⚠️</div>
                <p>No se pudo conectar con el servidor.</p>
            </div>`;
    }
}

// ── Render de eventos
function renderEventos(eventos) {
    const contenedor = document.getElementById('lista-eventos');

    if (!eventos || eventos.length === 0) {
        contenedor.innerHTML = `
            <div class="empty-state">
                <div class="icono">📭</div>
                <p>No hay eventos pasados registrados aún.</p>
            </div>`;
        return;
    }

    contenedor.innerHTML = eventos.map(ev => {
        const tieneMob = ev.mobiliario && ev.mobiliario.length > 0;
        const pendientes = tieneMob ? ev.mobiliario.filter(m => m.devuelto == 0) : [];
        const todosDevueltos = tieneMob && pendientes.length === 0;

        // Badge del evento
        let badgeHTML = '';
        if (!tieneMob) {
            badgeHTML = `<span class="badge-estado badge-sin-mob">Sin mobiliario</span>`;
        } else if (todosDevueltos) {
            badgeHTML = `<span class="badge-estado badge-devuelto">✓ Devuelto</span>`;
        } else {
            badgeHTML = `<span class="badge-estado badge-pendiente">⏳ ${pendientes.length} pendiente${pendientes.length > 1 ? 's' : ''}</span>`;
        }

        // Tabla de mobiliario
        let tablaHTML = '';
        if (tieneMob) {
            tablaHTML = `
                <table class="mob-tabla">
                    <thead>
                        <tr>
                            <th>Artículo</th>
                            <th>Cantidad</th>
                            <th>Estado</th>
                            <th>Fecha devolución</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${ev.mobiliario.map(m => `
                            <tr id="fila-${ev.id_evento}-${m.id_item}">
                                <td>${m.nombre_item}</td>
                                <td>${m.cantidad}</td>
                                <td>
                                    ${m.devuelto == 1
                                        ? `<span class="estado-devuelto">✓ Devuelto</span>`
                                        : `<span class="estado-pendiente">⏳ Pendiente</span>`
                                    }
                                </td>
                                <td>${m.fecha_devolucion ? m.fecha_devolucion : '—'}</td>
                                <td>
                                    ${m.devuelto == 1
                                        ? `<span style="font-size:.8rem;color:var(--muted)">—</span>`
                                        : `<button 
                                                class="btn-notificar" 
                                                id="btn-${ev.id_evento}-${m.id_item}"
                                                onclick="notificarDevolucion(${ev.id_evento}, ${m.id_item}, '${m.nombre_item}', '${ev.nombre_evento}', this)">
                                                📢 Notificar encargado
                                            </button>`
                                    }
                                </td>
                            </tr>
                        `).join('')}
                    </tbody>
                </table>`;
        } else {
            tablaHTML = `<p style="font-size:.85rem;color:var(--muted)">Este evento no tuvo mobiliario apartado.</p>`;
        }

        // Footer con botón de notificar todo si hay pendientes
        let footerHTML = '';
        if (pendientes.length > 1) {
            footerHTML = `
                <div class="acciones-footer">
                    <span class="acciones-footer-txt">${pendientes.length} artículos pendientes de devolución</span>
                    <button class="btn-notificar" onclick="notificarTodo(${ev.id_evento}, '${ev.nombre_evento}', this)">
                        📢 Notificar todo al encargado
                    </button>
                </div>`;
        }

        return `
            <div class="evento-card" id="card-${ev.id_evento}">
                <div class="evento-header" onclick="toggleCard(${ev.id_evento})">
                    <div class="evento-info">
                        <div class="evento-nombre">${ev.nombre_evento}</div>
                        <div class="evento-meta">
                            <span>📅 ${ev.fecha_evento}</span>
                            <span>🕐 ${ev.hora_inicio} – ${ev.hora_fin}</span>
                            <span>📍 ${ev.direccion}</span>
                            <span>👤 ${ev.nombre_cliente}</span>
                        </div>
                    </div>
                    <div class="evento-badges">
                        ${badgeHTML}
                        <span class="chevron">▼</span>
                    </div>
                </div>
                <div class="evento-detalle">
                    <div class="detalle-titulo">Mobiliario del evento</div>
                    ${tablaHTML}
                    ${footerHTML}
                </div>
            </div>`;
    }).join('');
}

// ── Toggle expandir/colapsar card
function toggleCard(id) {
    const card = document.getElementById('card-' + id);
    card.classList.toggle('open');
}

// ── Notificar devolución de un artículo
async function notificarDevolucion(idEvento, idItem, nombreItem, nombreEvento, btn) {
    btn.disabled = true;
    btn.textContent = 'Enviando...';

    try {
        const res = await fetch('/CixEventos/controllers/notificar_devolucion.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id_evento: idEvento, id_item: idItem, nombre_item: nombreItem, nombre_evento: nombreEvento })
        });
        const data = await res.json();

        if (data.success) {
            btn.classList.add('enviado');
            btn.textContent = '✓ Notificado';
            mostrarToast('Notificación enviada al encargado de inventario.');
        } else {
            btn.disabled = false;
            btn.textContent = '📢 Notificar encargado';
            mostrarToast('Error al enviar la notificación.');
        }
    } catch (e) {
        btn.disabled = false;
        btn.textContent = '📢 Notificar encargado';
        mostrarToast('Error de conexión.');
    }
}

// ── Notificar todos los pendientes de un evento
async function notificarTodo(idEvento, nombreEvento, btn) {
    btn.disabled = true;
    btn.textContent = 'Enviando...';

    try {
        const res = await fetch('/CixEventos/controllers/notificar_devolucion.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id_evento: idEvento, nombre_evento: nombreEvento, notificar_todo: true })
        });
        const data = await res.json();

        if (data.success) {
            btn.classList.add('enviado');
            btn.textContent = '✓ Todo notificado';
            mostrarToast('Se notificó al encargado de inventario sobre todos los pendientes.');
        } else {
            btn.disabled = false;
            btn.textContent = '📢 Notificar todo al encargado';
            mostrarToast('Error al enviar las notificaciones.');
        }
    } catch (e) {
        btn.disabled = false;
        btn.textContent = '📢 Notificar todo al encargado';
        mostrarToast('Error de conexión.');
    }
}

// ── Toast
function mostrarToast(msg) {
    const toast = document.getElementById('toast');
    toast.textContent = msg;
    toast.classList.add('show');
    setTimeout(() => toast.classList.remove('show'), 3000);
}

// ── Filtros
function aplicarFiltros() {
    const busqueda = document.getElementById('buscador').value.toLowerCase();
    const devolucion = document.getElementById('filtro-devolucion').value;
    const orden = document.getElementById('filtro-orden').value;

    let filtrados = [...eventosData];

    // Filtro búsqueda
    if (busqueda) {
        filtrados = filtrados.filter(ev =>
            ev.nombre_evento.toLowerCase().includes(busqueda) ||
            ev.nombre_cliente.toLowerCase().includes(busqueda)
        );
    }

    // Filtro devolución
    if (devolucion === 'pendiente') {
        filtrados = filtrados.filter(ev =>
            ev.mobiliario && ev.mobiliario.some(m => m.devuelto == 0)
        );
    } else if (devolucion === 'completo') {
        filtrados = filtrados.filter(ev =>
            ev.mobiliario && ev.mobiliario.length > 0 && ev.mobiliario.every(m => m.devuelto == 1)
        );
    } else if (devolucion === 'sin') {
        filtrados = filtrados.filter(ev => !ev.mobiliario || ev.mobiliario.length === 0);
    }

    // Orden
    filtrados.sort((a, b) => {
        const da = new Date(a.fecha_evento), db = new Date(b.fecha_evento);
        return orden === 'reciente' ? db - da : da - db;
    });

    renderEventos(filtrados);
}

document.getElementById('buscador').addEventListener('input', aplicarFiltros);
document.getElementById('filtro-devolucion').addEventListener('change', aplicarFiltros);
document.getElementById('filtro-orden').addEventListener('change', aplicarFiltros);

cargarEventos();
</script>

</body>
</html>