<?php
session_start();
if (!isset($_SESSION['id'])) {
    header('Location: /CixEventos/views/login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preparar Pedido | CIX Eventos</title>
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
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'DM Sans', sans-serif; background: var(--bg); color: var(--text); min-height: 100vh; }

        /* ── NAVBAR ── */
        .navbar-cix { background: var(--azul); padding: 0.75rem 2rem; display: flex; align-items: center; justify-content: space-between; box-shadow: 0 2px 12px rgba(26,86,219,.18); }
        .navbar-brand-cix { display: flex; align-items: center; gap: 10px; }
        .navbar-brand-cix img { height: 42px; width: auto; border-radius: 50%; box-shadow: 0 0 0 2px rgba(255,255,255,.35); }
        .navbar-brand-cix span { color: #fff; font-family: 'DM Serif Display', serif; font-size: 1.2rem; }
        .navbar-brand-cix small { display: block; color: rgba(255,255,255,.65); font-size: .68rem; font-weight: 300; letter-spacing: 1.5px; text-transform: uppercase; }
        .navbar-nav-cix { display: flex; align-items: center; gap: 1rem; }
        .btn-back { background: rgba(255,255,255,.15); border: 1.5px solid rgba(255,255,255,.4); color: #fff; border-radius: 8px; padding: .4rem 1rem; font-size: .85rem; font-weight: 500; text-decoration: none; transition: all .2s; }
        .btn-back:hover { background: rgba(255,255,255,.25); color: #fff; }
        .btn-logout { background: transparent; border: 1.5px solid rgba(255,255,255,.5); color: #fff; border-radius: 8px; padding: .4rem 1rem; font-size: .85rem; font-weight: 500; text-decoration: none; transition: all .2s; }
        .btn-logout:hover { background: rgba(255,255,255,.15); color: #fff; }

        /* ── HERO ── */
        .hero { background: linear-gradient(135deg, var(--azul) 0%, #3b82f6 100%); color: #fff; padding: 2.5rem 2rem 3.5rem; }
        .hero h1 { font-family: 'DM Serif Display', serif; font-size: 2.2rem; font-weight: 400; margin-bottom: .2rem; }
        .hero p { opacity: .7; font-size: .95rem; font-weight: 300; }

        /* ── CONTENIDO ── */
        .contenido { max-width: 960px; margin: -2rem auto 3rem; padding: 0 1.5rem; display: flex; flex-direction: column; gap: 1.25rem; }

        .panel { background: var(--card); border-radius: 16px; box-shadow: 0 4px 24px rgba(0,0,0,.07); overflow: hidden; }
        .panel-header { padding: 1.25rem 1.5rem; border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; gap: 1rem; flex-wrap: wrap; }
        .panel-header h2 { font-family: 'DM Serif Display', serif; font-size: 1.2rem; font-weight: 400; color: var(--text); margin: 0; }
        .panel-body { padding: 1.5rem; }

        /* ── SELECTOR EVENTO ── */
        .select-evento { border: 1.5px solid var(--border); border-radius: 10px; padding: .6rem .9rem; font-size: .9rem; font-family: 'DM Sans', sans-serif; width: 100%; outline: none; background: #fafbff; color: var(--text); transition: border-color .2s, box-shadow .2s; cursor: pointer; }
        .select-evento:focus { border-color: var(--azul); box-shadow: 0 0 0 3px rgba(26,86,219,.1); }

        /* ── INFO EVENTO ── */
        .evento-info-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 1rem; }
        .info-chip { background: #f8faff; border: 1.5px solid var(--border); border-radius: 12px; padding: .75rem 1rem; }
        .info-chip .label { font-size: .68rem; font-weight: 600; letter-spacing: 1px; text-transform: uppercase; color: var(--muted); margin-bottom: .2rem; }
        .info-chip .valor { font-size: .92rem; font-weight: 600; color: var(--text); }
        .notas-box { background: #fffbeb; border: 1.5px solid #fde68a; border-radius: 12px; padding: .85rem 1rem; margin-top: 1rem; font-size: .88rem; color: #92400e; }
        .notas-box strong { display: block; font-size: .68rem; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; margin-bottom: .2rem; color: #b45309; }

        /* ── TABLA ARTÍCULOS ── */
        .tabla-wrap { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; font-size: .88rem; }
        thead tr { background: #f1f5ff; }
        th { padding: .75rem 1rem; text-align: left; font-size: .7rem; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; color: var(--muted); border-bottom: 1.5px solid var(--border); }
        td { padding: .8rem 1rem; border-bottom: 1px solid var(--border); vertical-align: middle; }
        tr:last-child td { border-bottom: none; }
        tr:hover td { background: #f8faff; }

        .nombre-item { font-weight: 600; color: var(--text); }
        .desc-item   { font-size: .75rem; color: var(--muted); margin-top: .1rem; }

        .cant-solicitada { font-family: 'DM Serif Display', serif; font-size: 1.4rem; color: var(--azul); }
        .cant-disponible { font-family: 'DM Serif Display', serif; font-size: 1.4rem; }
        .cant-disponible.ok   { color: var(--verde); }
        .cant-disponible.bajo { color: var(--rojo); }

        .badge-ok      { background: #f0fdf4; color: var(--verde); border: 1px solid #bbf7d0; border-radius: 8px; padding: .2rem .6rem; font-size: .7rem; font-weight: 700; }
        .badge-falta   { background: #fef2f2; color: var(--rojo); border: 1px solid #fca5a5; border-radius: 8px; padding: .2rem .6rem; font-size: .7rem; font-weight: 700; }

        /* ── ALERTA STOCK ── */
        .alerta-stock { background: #fef2f2; border: 1.5px solid #fca5a5; border-radius: 12px; padding: .85rem 1rem; margin-bottom: 1rem; font-size: .88rem; color: var(--rojo); display: none; }
        .alerta-stock strong { font-weight: 700; }

        /* ── BOTÓN LISTO ── */
        .btn-listo { background: var(--verde); color: #fff; border: none; border-radius: 12px; padding: .75rem 2rem; font-size: 1rem; font-weight: 700; font-family: 'DM Sans', sans-serif; cursor: pointer; transition: background .2s, transform .1s; width: 100%; margin-top: 1rem; }
        .btn-listo:hover:not(:disabled) { background: #15803d; transform: translateY(-1px); }
        .btn-listo:disabled { background: #9ca3af; cursor: not-allowed; transform: none; }

        /* ── ESTADOS VACÍOS ── */
        .sin-items { text-align: center; padding: 2.5rem 1rem; color: var(--muted); }
        .sin-items .icono { font-size: 2rem; margin-bottom: .5rem; }

        /* ── CONFIRMACIÓN ── */
        .modal-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,.45); display: flex; justify-content: center; align-items: center; z-index: 1000; }
        .modal-box { background: #fff; border-radius: 16px; padding: 2rem; width: 90%; max-width: 420px; box-shadow: 0 8px 40px rgba(0,0,0,.15); text-align: center; }
        .modal-box .icono-modal { font-size: 2.8rem; margin-bottom: .75rem; }
        .modal-box h3 { font-family: 'DM Serif Display', serif; font-size: 1.3rem; font-weight: 400; margin-bottom: .5rem; }
        .modal-box p { font-size: .88rem; color: var(--muted); margin-bottom: 1.5rem; }
        .modal-btns { display: flex; gap: .75rem; justify-content: center; }
        .btn-confirmar { background: var(--verde); color: #fff; border: none; border-radius: 10px; padding: .55rem 1.4rem; font-size: .9rem; font-weight: 700; cursor: pointer; font-family: 'DM Sans', sans-serif; transition: background .2s; }
        .btn-confirmar:hover { background: #15803d; }
        .btn-cancelar-modal { background: #f3f4f6; color: var(--muted); border: none; border-radius: 10px; padding: .55rem 1.2rem; font-size: .9rem; font-weight: 500; cursor: pointer; font-family: 'DM Sans', sans-serif; transition: background .2s; }
        .btn-cancelar-modal:hover { background: #e5e7eb; }

        /* ── ÉXITO ── */
        .modal-exito .icono-modal { color: var(--verde); }

        @media (max-width: 600px) {
            .hero h1 { font-size: 1.7rem; }
            .evento-info-grid { grid-template-columns: 1fr 1fr; }
        }
    </style>
</head>
<body>

<nav class="navbar-cix">
    <div class="navbar-brand-cix">
        <img src="../../../assets/content/logotype.png" alt="CIX Logo">
        <div><span>CIX Eventos</span><small>Empleado</small></div>
    </div>
    <div class="navbar-nav-cix">
        <a href="/CixEventos/views/WORKER/worker.php" class="btn-back">← Regresar</a>
        <a href="../../../controllers/logout.php" class="btn-logout">Cerrar Sesión</a>
    </div>
</nav>

<div class="hero">
    <h1>🚚 Preparar Pedido</h1>
    <p>Revisa la mobiliaria del evento y márcalo como listo para entregar.</p>
</div>

<div class="contenido">

    <!-- PASO 1: Seleccionar evento -->
    <div class="panel">
        <div class="panel-header">
            <h2>1. Selecciona el Evento</h2>
        </div>
        <div class="panel-body">
            <select class="select-evento" id="select-evento" onchange="cargarEvento()">
                <option value="">— Cargando eventos pendientes… —</option>
            </select>
        </div>
    </div>

    <!-- PASO 2: Info del evento -->
    <div class="panel" id="panel-info" style="display:none;">
        <div class="panel-header">
            <h2>2. Información del Evento</h2>
        </div>
        <div class="panel-body">
            <div class="evento-info-grid" id="evento-info-grid"></div>
            <div class="notas-box" id="notas-box" style="display:none;">
                <strong>📝 Notas adicionales</strong>
                <span id="notas-texto"></span>
            </div>
        </div>
    </div>

    <!-- PASO 3: Artículos -->
    <div class="panel" id="panel-articulos" style="display:none;">
        <div class="panel-header">
            <h2>3. Mobiliaria del Evento</h2>
            <span id="resumen-items" style="font-size:.82rem;color:var(--muted);"></span>
        </div>
        <div class="panel-body">
            <div class="alerta-stock" id="alerta-stock">
                ⚠️ <strong>Atención:</strong> uno o más artículos no tienen stock suficiente. Revisa antes de confirmar.
            </div>
            <div class="tabla-wrap">
                <table id="tabla-items">
                    <thead>
                        <tr>
                            <th>Artículo</th>
                            <th style="text-align:center;">Solicitado</th>
                            <th style="text-align:center;">Disponible</th>
                            <th style="text-align:center;">Estado</th>
                        </tr>
                    </thead>
                    <tbody id="tbody-items"></tbody>
                </table>
            </div>
            <button class="btn-listo" id="btn-listo" onclick="abrirConfirmacion()">
                ✅ Marcar como Listo para Entregar
            </button>
        </div>
    </div>

</div>

<!-- MODAL CONFIRMACIÓN -->
<div id="modal-confirm" class="modal-overlay" style="display:none;">
    <div class="modal-box">
        <div class="icono-modal">📦</div>
        <h3>¿Confirmar pedido?</h3>
        <p id="modal-confirm-texto"></p>
        <div class="modal-btns">
            <button class="btn-cancelar-modal" onclick="cerrarConfirmacion()">Cancelar</button>
            <button class="btn-confirmar" onclick="confirmarListo()">Sí, marcar listo</button>
        </div>
    </div>
</div>

<!-- MODAL ÉXITO -->
<div id="modal-exito" class="modal-overlay modal-exito" style="display:none;">
    <div class="modal-box">
        <div class="icono-modal">🎉</div>
        <h3>¡Pedido listo!</h3>
        <p>El evento ha sido marcado como <strong>Listo para entregar</strong> correctamente.</p>
        <div class="modal-btns">
            <button class="btn-confirmar" onclick="cerrarExito()">Aceptar</button>
        </div>
    </div>
</div>

<script>
let eventoActual  = null;
let itemsActuales = [];

// ── CARGAR LISTA DE EVENTOS ──────────────────────────────
fetch('/CixEventos/controllers/get_eventos_pendientes.php')
    .then(r => r.json())
    .then(data => {
        const sel = document.getElementById('select-evento');
        if (!data.length) {
            sel.innerHTML = '<option value="">— No hay eventos pendientes —</option>';
            return;
        }
        sel.innerHTML = '<option value="">— Selecciona un evento —</option>' +
            data.map(e => `<option value="${e.id_evento}" data-info='${JSON.stringify(e).replace(/'/g,"&apos;")}'>
                ${e.nombre_evento} · ${formatFecha(e.fecha_evento)}
            </option>`).join('');
    })
    .catch(() => {
        document.getElementById('select-evento').innerHTML =
            '<option value="">— Error al cargar eventos —</option>';
    });

// ── CARGAR EVENTO SELECCIONADO ───────────────────────────
function cargarEvento() {
    const sel    = document.getElementById('select-evento');
    const opt    = sel.options[sel.selectedIndex];
    const id     = sel.value;

    // Ocultar paneles
    document.getElementById('panel-info').style.display      = 'none';
    document.getElementById('panel-articulos').style.display = 'none';

    if (!id) { eventoActual = null; return; }

    eventoActual = JSON.parse(opt.getAttribute('data-info'));
    renderInfoEvento(eventoActual);

    // Cargar artículos
    document.getElementById('tbody-items').innerHTML = '';
    document.getElementById('alerta-stock').style.display = 'none';

    fetch(`/CixEventos/controllers/get_items_evento.php?id_evento=${id}`)
        .then(r => r.json())
        .then(items => {
            itemsActuales = items;
            renderItems(items);
        });
}

// ── RENDER INFO EVENTO ───────────────────────────────────
function renderInfoEvento(e) {
    document.getElementById('panel-info').style.display = '';

    const grid = document.getElementById('evento-info-grid');
    grid.innerHTML = `
        <div class="info-chip"><div class="label">Cliente</div><div class="valor">${e.cliente}</div></div>
        <div class="info-chip"><div class="label">Fecha</div><div class="valor">${formatFecha(e.fecha_evento)}</div></div>
        <div class="info-chip"><div class="label">Horario</div><div class="valor">${e.hora_inicio} – ${e.hora_fin}</div></div>
        <div class="info-chip"><div class="label">Dirección</div><div class="valor">${e.direccion}</div></div>
    `;

    const notasBox   = document.getElementById('notas-box');
    const notasTexto = document.getElementById('notas-texto');
    if (e.notas_adicionales) {
        notasTexto.textContent = e.notas_adicionales;
        notasBox.style.display = '';
    } else {
        notasBox.style.display = 'none';
    }
}

// ── RENDER ARTÍCULOS ─────────────────────────────────────
function renderItems(items) {
    const tbody   = document.getElementById('tbody-items');
    const panel   = document.getElementById('panel-articulos');
    const alerta  = document.getElementById('alerta-stock');
    const btnListo = document.getElementById('btn-listo');
    const resumen = document.getElementById('resumen-items');

    panel.style.display = '';

    if (!items.length) {
        tbody.innerHTML = `<tr><td colspan="4"><div class="sin-items"><div class="icono">📋</div><p>Este evento no tiene artículos registrados.</p></div></td></tr>`;
        btnListo.disabled = true;
        resumen.textContent = '';
        return;
    }

    const hayFaltantes = items.some(i => !i.suficiente);
    alerta.style.display  = hayFaltantes ? '' : 'none';
    btnListo.disabled     = false;

    const total     = items.length;
    const listos    = items.filter(i => i.suficiente).length;
    resumen.textContent = `${listos}/${total} artículos con stock suficiente`;

    tbody.innerHTML = items.map(item => `
        <tr>
            <td>
                <div class="nombre-item">${item.nombre_item}</div>
                <div class="desc-item">${item.descripcion || '—'}</div>
            </td>
            <td style="text-align:center;">
                <span class="cant-solicitada">${item.cantidad_solicitada}</span>
            </td>
            <td style="text-align:center;">
                <span class="cant-disponible ${item.suficiente ? 'ok' : 'bajo'}">${item.stock_total}</span>
            </td>
            <td style="text-align:center;">
                ${item.suficiente
                    ? '<span class="badge-ok">✓ Suficiente</span>'
                    : '<span class="badge-falta">✗ Insuficiente</span>'}
            </td>
        </tr>
    `).join('');
}

function abrirConfirmacion() {
    if (!eventoActual) return;
    document.getElementById('modal-confirm-texto').textContent =
        `Esto marcará "${eventoActual.nombre_evento}" como Listo para Entregar. Esta acción no se puede deshacer.`;
    document.getElementById('modal-confirm').style.display = 'flex';
}

function cerrarConfirmacion() {
    document.getElementById('modal-confirm').style.display = 'none';
}

function confirmarListo() {
    cerrarConfirmacion();
    fetch('/CixEventos/controllers/marcar_listo.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ id_evento: eventoActual.id_evento })
    })
    .then(r => r.json())
    .then(res => {
        if (res.ok) {
            document.getElementById('modal-exito').style.display = 'flex';
        } else {
            alert('Error: ' + res.msg);
        }
    });
}

function cerrarExito() {
    document.getElementById('modal-exito').style.display = 'none';
    location.reload();
}

function formatFecha(f) {
    if (!f) return '—';
    const [y, m, d] = f.split('-');
    return `${d}/${m}/${y}`;
}
</script>

</body>
</html>