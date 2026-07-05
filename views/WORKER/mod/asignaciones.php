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
    <title>Mis Asignaciones | CIX Eventos</title>
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
        body { font-family: 'DM Sans', sans-serif; background: var(--bg); color: var(--text); min-height: 100vh; }

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

        .hero { background: linear-gradient(135deg, var(--azul) 0%, #3b82f6 100%); color: #fff; padding: 2.5rem 2rem 3.5rem; }
        .hero h1 { font-family: 'DM Serif Display', serif; font-size: 2.2rem; font-weight: 400; margin-bottom: .2rem; }
        .hero p { opacity: .7; font-size: .95rem; font-weight: 300; }

        .contenido { max-width: 1100px; margin: -2rem auto 3rem; padding: 0 1.5rem; display: grid; grid-template-columns: 340px 1fr; gap: 1.25rem; align-items: start; }

        .panel { background: var(--card); border-radius: 16px; box-shadow: 0 4px 24px rgba(0,0,0,.07); overflow: hidden; }
        .panel-header { padding: 1.1rem 1.4rem; border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; gap: .75rem; flex-wrap: wrap; }
        .panel-header h2 { font-family: 'DM Serif Display', serif; font-size: 1.1rem; font-weight: 400; color: var(--text); margin: 0; }
        .panel-body { padding: 1.25rem; }

        .buscador-wrap { position: relative; width: 100%; margin-bottom: 1rem; }
        .buscador-wrap span { position: absolute; left: .75rem; top: 50%; transform: translateY(-50%); font-size: .9rem; pointer-events: none; }
        .buscador { border: 1.5px solid var(--border); border-radius: 10px; padding: .5rem .9rem .5rem 2.1rem; font-size: .85rem; font-family: 'DM Sans', sans-serif; width: 100%; outline: none; background: #fafbff; transition: border-color .2s, box-shadow .2s; }
        .buscador:focus { border-color: var(--azul); box-shadow: 0 0 0 3px rgba(26,86,219,.1); }

        .filtros { display: flex; gap: .4rem; flex-wrap: wrap; margin-bottom: 1rem; }
        .filtro-btn { border: 1.5px solid var(--border); background: #fafbff; color: var(--muted); border-radius: 8px; padding: .3rem .75rem; font-size: .75rem; font-weight: 600; cursor: pointer; font-family: 'DM Sans', sans-serif; transition: all .2s; }
        .filtro-btn.activo { border-color: var(--azul); background: #eff6ff; color: var(--azul); }

        .lista-eventos { display: flex; flex-direction: column; gap: .6rem; max-height: 620px; overflow-y: auto; padding-right: .25rem; }
        .lista-eventos::-webkit-scrollbar { width: 4px; }
        .lista-eventos::-webkit-scrollbar-track { background: transparent; }
        .lista-eventos::-webkit-scrollbar-thumb { background: var(--border); border-radius: 4px; }

        .evento-card { border: 1.5px solid var(--border); border-radius: 12px; padding: .85rem 1rem; cursor: pointer; transition: all .2s; }
        .evento-card:hover { border-color: #93c5fd; box-shadow: 0 2px 12px rgba(26,86,219,.08); }
        .evento-card.activo { border-color: var(--azul); background: #eff6ff; box-shadow: 0 2px 12px rgba(26,86,219,.12); }
        .evento-card-nombre { font-weight: 600; font-size: .88rem; color: var(--text); margin-bottom: .2rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .evento-card-meta { font-size: .75rem; color: var(--muted); }
        .evento-card-footer { display: flex; align-items: center; justify-content: space-between; margin-top: .45rem; }

        .badge-estado { border-radius: 8px; padding: .18rem .55rem; font-size: .68rem; font-weight: 700; letter-spacing: .3px; }
        .badge-pendiente   { background: #fef3c7; color: var(--amarillo); border: 1px solid #fde68a; }
        .badge-listo       { background: #f0fdf4; color: var(--verde);    border: 1px solid #bbf7d0; }
        .badge-entregado   { background: #eff6ff; color: var(--azul);     border: 1px solid #bfdbfe; }
        .badge-cancelado   { background: #fef2f2; color: var(--rojo);     border: 1px solid #fca5a5; }
        .badge-otro        { background: #f3f4f6; color: var(--muted);    border: 1px solid var(--border); }

        .detalle-placeholder { text-align: center; padding: 4rem 1.5rem; color: var(--muted); }
        .detalle-placeholder .icono { font-size: 2.5rem; margin-bottom: .75rem; }

        .detalle-titulo { font-family: 'DM Serif Display', serif; font-size: 1.5rem; font-weight: 400; margin-bottom: .25rem; }
        .detalle-cliente { font-size: .85rem; color: var(--muted); margin-bottom: 1.25rem; }

        .info-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(160px, 1fr)); gap: .85rem; margin-bottom: 1.25rem; }
        .info-chip { background: #f8faff; border: 1.5px solid var(--border); border-radius: 12px; padding: .7rem .9rem; }
        .info-chip .label { font-size: .65rem; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; color: var(--muted); margin-bottom: .15rem; }
        .info-chip .valor { font-size: .88rem; font-weight: 600; color: var(--text); }

        .notas-box { background: #fffbeb; border: 1.5px solid #fde68a; border-radius: 12px; padding: .8rem 1rem; margin-bottom: 1.25rem; font-size: .86rem; color: #92400e; }
        .notas-box strong { display: block; font-size: .65rem; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; margin-bottom: .2rem; color: #b45309; }

        .seccion-titulo { font-family: 'DM Serif Display', serif; font-size: 1rem; font-weight: 400; margin-bottom: .85rem; color: var(--text); }
        .tabla-wrap { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; font-size: .86rem; }
        thead tr { background: #f1f5ff; }
        th { padding: .65rem .9rem; text-align: left; font-size: .67rem; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; color: var(--muted); border-bottom: 1.5px solid var(--border); }
        td { padding: .75rem .9rem; border-bottom: 1px solid var(--border); vertical-align: middle; }
        tr:last-child td { border-bottom: none; }
        tr:hover td { background: #f8faff; }

        .nombre-item { font-weight: 600; color: var(--text); }
        .desc-item   { font-size: .73rem; color: var(--muted); margin-top: .1rem; }
        .cant-num    { font-family: 'DM Serif Display', serif; font-size: 1.3rem; }
        .cant-azul   { color: var(--azul); }
        .cant-verde  { color: var(--verde); }
        .cant-rojo   { color: var(--rojo); }

        .badge-ok    { background: #f0fdf4; color: var(--verde); border: 1px solid #bbf7d0; border-radius: 8px; padding: .18rem .55rem; font-size: .68rem; font-weight: 700; }
        .badge-falta { background: #fef2f2; color: var(--rojo);  border: 1px solid #fca5a5; border-radius: 8px; padding: .18rem .55rem; font-size: .68rem; font-weight: 700; }

        .sin-items { text-align: center; padding: 2rem 1rem; color: var(--muted); font-size: .88rem; }

        @media (max-width: 768px) {
            .contenido { grid-template-columns: 1fr; }
            .lista-eventos { max-height: 300px; }
            .hero h1 { font-size: 1.7rem; }
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
    <h1>📋 Asignaciones</h1>
    <p>Consulta todos los eventos y su mobiliaria asignada.</p>
</div>

<div class="contenido">

    <div class="panel">
        <div class="panel-header">
            <h2>Eventos <span id="contador" style="font-size:.78rem;color:var(--muted);font-family:'DM Sans',sans-serif;"></span></h2>
        </div>
        <div class="panel-body">
            <div class="buscador-wrap">
                <span>🔍</span>
                <input type="text" class="buscador" id="buscador" placeholder="Buscar evento..." oninput="filtrar()">
            </div>
            <div class="filtros" id="filtros">
                <button class="filtro-btn activo" onclick="setFiltro('todos', this)">Todos</button>
                <button class="filtro-btn" onclick="setFiltro('Pendiente', this)">Pendiente</button>
                <button class="filtro-btn" onclick="setFiltro('Listo para entregar', this)">Listo</button>
            </div>
            <div class="lista-eventos" id="lista-eventos">
                <div style="text-align:center;padding:2rem;color:var(--muted);font-size:.85rem;">Cargando…</div>
            </div>
        </div>
    </div>

    <div class="panel" id="panel-detalle">
        <div class="panel-body">
            <div class="detalle-placeholder">
                <div class="icono">👈</div>
                <p>Selecciona un evento de la lista para ver su detalle.</p>
            </div>
        </div>
    </div>

</div>

<script>
let todosEventos  = [];
let filtroActual  = 'todos';
let eventoActivo  = null;

fetch('/CixEventos/controllers/get_todos_eventos.php')
    .then(r => r.json())
    .then(data => {
        todosEventos = data;
        renderLista(data);
    })
    .catch(() => {
        document.getElementById('lista-eventos').innerHTML =
            '<div style="text-align:center;padding:2rem;color:var(--rojo);font-size:.85rem;">⚠️ Error al cargar eventos.</div>';
    });

function renderLista(eventos) {
    const lista    = document.getElementById('lista-eventos');
    const contador = document.getElementById('contador');

    if (!eventos.length) {
        lista.innerHTML = '<div style="text-align:center;padding:2rem;color:var(--muted);font-size:.85rem;">Sin eventos.</div>';
        contador.textContent = '';
        return;
    }

    contador.textContent = `· ${eventos.length}`;
    lista.innerHTML = eventos.map(e => `
        <div class="evento-card ${eventoActivo === e.id_evento ? 'activo' : ''}"
             onclick="seleccionarEvento(${e.id_evento})">
            <div class="evento-card-nombre">${e.nombre_evento}</div>
            <div class="evento-card-meta">👤 ${e.cliente} · 📅 ${formatFecha(e.fecha_evento)}</div>
            <div class="evento-card-footer">
                <span class="evento-card-meta">🕐 ${e.hora_inicio} – ${e.hora_fin}</span>
                <span class="badge-estado ${badgeClase(e.estado)}">${e.estado}</span>
            </div>
        </div>
    `).join('');
}

function seleccionarEvento(id) {
    eventoActivo = id;
    document.querySelectorAll('.evento-card').forEach(c => c.classList.remove('activo'));
    event.currentTarget.classList.add('activo');

    const panel = document.getElementById('panel-detalle');
    panel.querySelector('.panel-body').innerHTML =
        '<div style="text-align:center;padding:3rem;color:var(--muted);">Cargando detalle…</div>';

    fetch(`/CixEventos/controllers/get_detalle_evento.php?id_evento=${id}`)
        .then(r => r.json())
        .then(data => renderDetalle(data));
}

function renderDetalle(e) {
    if (!e) return;

    const hayFaltantes = e.items.some(i => !i.suficiente);
    const totalItems   = e.items.length;
    const okItems      = e.items.filter(i => i.suficiente).length;

    const itemsHTML = totalItems === 0
        ? '<div class="sin-items">📋 Este evento no tiene artículos registrados.</div>'
        : `<div class="tabla-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Artículo</th>
                        <th style="text-align:center;">Solicitado</th>
                        <th style="text-align:center;">Disponible</th>
                        <th style="text-align:center;">Estado</th>
                    </tr>
                </thead>
                <tbody>
                    ${e.items.map(item => `
                    <tr>
                        <td>
                            <div class="nombre-item">${item.nombre_item}</div>
                            <div class="desc-item">${item.descripcion || '—'}</div>
                        </td>
                        <td style="text-align:center;">
                            <span class="cant-num cant-azul">${item.cantidad_solicitada}</span>
                        </td>
                        <td style="text-align:center;">
                            <span class="cant-num ${item.suficiente ? 'cant-verde' : 'cant-rojo'}">${item.stock_total}</span>
                        </td>
                        <td style="text-align:center;">
                            ${item.suficiente
                                ? '<span class="badge-ok">✓ Suficiente</span>'
                                : '<span class="badge-falta">✗ Insuficiente</span>'}
                        </td>
                    </tr>`).join('')}
                </tbody>
            </table>
           </div>`;

    const notasHTML = e.notas_adicionales
        ? `<div class="notas-box"><strong>📝 Notas adicionales</strong>${e.notas_adicionales}</div>`
        : '';

    const alertaHTML = hayFaltantes
        ? `<div style="background:#fef2f2;border:1.5px solid #fca5a5;border-radius:12px;padding:.75rem 1rem;margin-bottom:1rem;font-size:.85rem;color:var(--rojo);">
               ⚠️ <strong>Stock insuficiente</strong> en ${totalItems - okItems} artículo(s).
           </div>`
        : '';

    const resumenItems = totalItems > 0
        ? `<span style="font-size:.78rem;color:var(--muted);margin-left:.5rem;">${okItems}/${totalItems} con stock suficiente</span>`
        : '';

    document.getElementById('panel-detalle').querySelector('.panel-body').innerHTML = `
        <div style="display:flex;align-items:flex-start;justify-content:space-between;flex-wrap:wrap;gap:.5rem;margin-bottom:.25rem;">
            <div>
                <div class="detalle-titulo">${e.nombre_evento}</div>
                <div class="detalle-cliente">👤 ${e.cliente}</div>
            </div>
            <span class="badge-estado ${badgeClase(e.estado)}" style="font-size:.8rem;padding:.3rem .8rem;">${e.estado}</span>
        </div>

        <div class="info-grid">
            <div class="info-chip"><div class="label">Fecha</div><div class="valor">📅 ${formatFecha(e.fecha_evento)}</div></div>
            <div class="info-chip"><div class="label">Horario</div><div class="valor">🕐 ${e.hora_inicio} – ${e.hora_fin}</div></div>
            <div class="info-chip"><div class="label">Dirección</div><div class="valor">📍 ${e.direccion}</div></div>
            <div class="info-chip"><div class="label">Estado</div><div class="valor">${e.estado}</div></div>
        </div>

        ${notasHTML}
        ${alertaHTML}

        <div class="seccion-titulo">Mobiliaria asignada ${resumenItems}</div>
        ${itemsHTML}
    `;
}

function setFiltro(valor, btn) {
    filtroActual = valor;
    document.querySelectorAll('.filtro-btn').forEach(b => b.classList.remove('activo'));
    btn.classList.add('activo');
    aplicarFiltros();
}

function filtrar() { aplicarFiltros(); }

function aplicarFiltros() {
    const q = document.getElementById('buscador').value.toLowerCase();
    let resultado = todosEventos;

    if (filtroActual !== 'todos') {
        resultado = resultado.filter(e => e.estado === filtroActual);
    }
    if (q) {
        resultado = resultado.filter(e =>
            e.nombre_evento.toLowerCase().includes(q) ||
            e.cliente.toLowerCase().includes(q) ||
            e.direccion.toLowerCase().includes(q)
        );
    }
    renderLista(resultado);
}

function formatFecha(f) {
    if (!f) return '—';
    const [y, m, d] = f.split('-');
    return `${d}/${m}/${y}`;
}

function badgeClase(estado) {
    if (!estado) return 'badge-otro';
    const e = estado.toLowerCase();
    if (e.includes('pendiente'))  return 'badge-pendiente';
    if (e.includes('listo'))      return 'badge-listo';
    if (e.includes('entregado'))  return 'badge-entregado';
    if (e.includes('cancelado'))  return 'badge-cancelado';
    return 'badge-otro';
}
</script>

</body>
</html>