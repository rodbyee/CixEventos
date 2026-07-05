<?php
session_start();
$nombreUsuario = $_SESSION['nombre'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Revisión de Mercancía | CIX Eventos</title>
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
            --danger:    #dc2626;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'DM Sans', sans-serif; background: var(--bg); color: var(--text); min-height: 100vh; }

        /* NAVBAR */
        .navbar-cix {
            background: var(--azul); padding: 0.75rem 2rem;
            display: flex; align-items: center; justify-content: space-between;
            box-shadow: 0 2px 12px rgba(26,86,219,.18);
        }
        .navbar-brand-cix { display: flex; align-items: center; gap: 10px; }
        .navbar-brand-cix img { height: 42px; width: auto; border-radius: 50%; box-shadow: 0 0 0 2px rgba(255,255,255,.35); }
        .navbar-brand-cix span { color: #fff; font-family: 'DM Serif Display', serif; font-size: 1.2rem; }
        .navbar-brand-cix small { display: block; color: rgba(255,255,255,.65); font-size: .68rem; font-weight: 300; letter-spacing: 1.5px; text-transform: uppercase; }
        .navbar-nav-cix { display: flex; align-items: center; gap: 1rem; }
        .btn-back { background: rgba(255,255,255,.15); border: 1.5px solid rgba(255,255,255,.4); color: #fff; border-radius: 8px; padding: .4rem 1rem; font-size: .85rem; font-weight: 500; text-decoration: none; transition: all .2s; }
        .btn-back:hover { background: rgba(255,255,255,.25); color: #fff; }
        .btn-logout { background: transparent; border: 1.5px solid rgba(255,255,255,.5); color: #fff; border-radius: 8px; padding: .4rem 1rem; font-size: .85rem; font-weight: 500; text-decoration: none; transition: all .2s; }
        .btn-logout:hover { background: rgba(255,255,255,.15); color: #fff; }

        /* HERO */
        .hero { background: linear-gradient(135deg, var(--azul) 0%, #3b82f6 100%); color: #fff; padding: 2.5rem 2rem 3.5rem; }
        .hero h1 { font-family: 'DM Serif Display', serif; font-size: 2.2rem; font-weight: 400; margin-bottom: .2rem; }
        .hero p { opacity: .7; font-size: .95rem; font-weight: 300; }

        /* CONTENIDO */
        .contenido { max-width: 1100px; margin: -2rem auto 3rem; padding: 0 1.5rem; display: flex; flex-direction: column; gap: 1.5rem; }

        /* PANEL */
        .panel { background: var(--card); border-radius: 16px; box-shadow: 0 4px 24px rgba(0,0,0,.07); overflow: hidden; }
        .panel-header { padding: 1.25rem 1.5rem; border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: .75rem; }
        .panel-header h2 { font-family: 'DM Serif Display', serif; font-size: 1.2rem; font-weight: 400; color: var(--text); margin: 0; }
        .panel-body { padding: 1.5rem; }

        /* LINK STOCK */
        .btn-ver-stock { display: inline-flex; align-items: center; gap: .4rem; background: #eff6ff; color: var(--azul); border: 1.5px solid #93c5fd; border-radius: 8px; padding: .35rem .85rem; font-size: .8rem; font-weight: 600; text-decoration: none; transition: background .2s; }
        .btn-ver-stock:hover { background: #dbeafe; color: var(--azul); }

        /* CARDS APARTADO */
        .apartado-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 1rem; }
        .apartado-card { border: 1.5px solid var(--border); border-radius: 12px; padding: 1rem 1.1rem; transition: box-shadow .2s, border-color .2s; }
        .apartado-card:hover { box-shadow: 0 4px 16px rgba(26,86,219,.08); border-color: #93c5fd; }
        .apartado-top { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: .5rem; }
        .apartado-evento { font-weight: 600; font-size: .95rem; }
        .badge-ap { background: #fef3c7; color: var(--pendiente); font-size: .7rem; font-weight: 600; padding: .2rem .6rem; border-radius: 999px; }
        .apartado-meta { font-size: .78rem; color: var(--muted); line-height: 1.6; margin-bottom: .6rem; }
        .apartado-items { display: flex; flex-wrap: wrap; gap: .3rem; }
        .apartado-items span { background: #eff6ff; color: var(--azul); font-size: .72rem; font-weight: 500; padding: .15rem .5rem; border-radius: 999px; }

        /* EVENTOS PASADOS */
        .evento-pasado-card { border: 1.5px solid var(--border); border-radius: 12px; padding: 1rem 1.2rem; margin-bottom: .85rem; display: flex; align-items: center; justify-content: space-between; gap: 1rem; flex-wrap: wrap; transition: border-color .2s; }
        .evento-pasado-card:hover { border-color: #93c5fd; }
        .evento-pasado-card:last-child { margin-bottom: 0; }
        .ep-info { flex: 1; }
        .ep-nombre { font-weight: 600; font-size: .95rem; margin-bottom: .2rem; }
        .ep-meta { font-size: .78rem; color: var(--muted); line-height: 1.6; }
        .ep-actions { display: flex; gap: .5rem; flex-shrink: 0; }

        .btn-notificar { background: #fef3c7; color: #92400e; border: 1.5px solid #fcd34d; border-radius: 8px; padding: .35rem .8rem; font-size: .78rem; font-weight: 600; cursor: pointer; transition: background .2s; }
        .btn-notificar:hover { background: #fde68a; }
        .btn-iniciar-dev { background: var(--azul); color: #fff; border: none; border-radius: 8px; padding: .35rem .8rem; font-size: .78rem; font-weight: 600; cursor: pointer; transition: background .2s; }
        .btn-iniciar-dev:hover { background: var(--azul-dark); }

        /* MODAL DEVOLUCIÓN */
        .modal-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,.5); display: flex; justify-content: center; align-items: center; z-index: 1000; }
        .modal-box { background: #fff; border-radius: 16px; padding: 2rem; width: 95%; max-width: 600px; max-height: 90vh; overflow-y: auto; box-shadow: 0 8px 40px rgba(0,0,0,.15); }
        .modal-box h3 { font-family: 'DM Serif Display', serif; font-size: 1.3rem; font-weight: 400; margin-bottom: .5rem; }
        .modal-box .sub { font-size: .82rem; color: var(--muted); margin-bottom: 1.25rem; }

        /* TABLA DEVOLUCIÓN */
        .dev-tabla { width: 100%; border-collapse: collapse; font-size: .85rem; }
        .dev-tabla th { text-align: left; font-size: .7rem; font-weight: 600; letter-spacing: 1px; text-transform: uppercase; color: var(--muted); padding: .5rem .75rem; border-bottom: 2px solid var(--border); }
        .dev-tabla td { padding: .65rem .75rem; border-bottom: 1px solid var(--border); vertical-align: middle; }
        .dev-tabla tr:last-child td { border-bottom: none; }

        .input-cant-dev { border: 1.5px solid var(--border); border-radius: 8px; padding: .3rem .6rem; font-size: .85rem; width: 65px; font-family: 'DM Sans', sans-serif; outline: none; transition: border-color .2s; }
        .input-cant-dev:focus { border-color: var(--azul); }

        .select-estado-dev { border: 1.5px solid var(--border); border-radius: 8px; padding: .3rem .6rem; font-size: .82rem; font-family: 'DM Sans', sans-serif; outline: none; cursor: pointer; background: #fafbff; transition: border-color .2s; }
        .select-estado-dev:focus { border-color: var(--azul); }
        .select-estado-dev.danado { border-color: var(--danger); background: #fef2f2; color: var(--danger); }

        .modal-actions { display: flex; justify-content: space-between; align-items: center; margin-top: 1.5rem; gap: 1rem; }
        .btn-confirmar-dev { background: var(--azul); color: #fff; border: none; border-radius: 10px; padding: .65rem 1.5rem; font-size: .92rem; font-weight: 600; font-family: 'DM Sans', sans-serif; cursor: pointer; transition: background .2s; }
        .btn-confirmar-dev:hover { background: var(--azul-dark); }
        .btn-cancelar-modal { background: #f3f4f6; color: var(--muted); border: none; border-radius: 10px; padding: .65rem 1.2rem; font-size: .92rem; font-weight: 500; font-family: 'DM Sans', sans-serif; cursor: pointer; }
        .btn-cancelar-modal:hover { background: #e5e7eb; }

        /* ALERT */
        .alert-cix { padding: .75rem 1rem; border-radius: 10px; font-size: .85rem; margin-bottom: 1rem; }
        .alert-success { background: #dcfce7; color: #15803d; }
        .alert-danger  { background: #fee2e2; color: #dc2626; }
        .alert-info    { background: #eff6ff; color: var(--azul); }

        .sin-items { text-align: center; padding: 2.5rem 1rem; color: var(--muted); }
        .sin-items .icono { font-size: 2rem; margin-bottom: .5rem; }

        @media (max-width: 700px) {
            .hero h1 { font-size: 1.7rem; }
            .apartado-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

<nav class="navbar-cix">
    <div class="navbar-brand-cix">
        <img src="../../../assets/content/logotype.png" alt="CIX Logo">
        <div><span>CIX Eventos</span><small>Encargado Inventario</small></div>
    </div>
    <div class="navbar-nav-cix">
        <a href="../inventario.php" class="btn-back">← Regresar</a>
        <a href="../../../controllers/logout.php" class="btn-logout">Cerrar Sesión</a>
    </div>
</nav>

<div class="hero">
    <h1>🔍 Revisión de Mercancía</h1>
    <p>Gestiona el mobiliario en uso, devoluciones y reportes de daños.</p>
</div>

<div class="contenido">

    <!-- SECCIÓN 1: MOBILIARIO APARTADO -->
    <div class="panel">
        <div class="panel-header">
            <h2>📦 Mobiliario Actualmente Apartado</h2>
            <a href="inv_general.php" class="btn-ver-stock">📋 Ver Stock Actual →</a>
        </div>
        <div class="panel-body">
            <div id="msg-seccion1"></div>
            <div class="apartado-grid" id="lista-apartados">
                <div class="sin-items"><div class="icono">⏳</div><p>Cargando...</p></div>
            </div>
        </div>
    </div>

    <!-- SECCIÓN 2: EVENTOS CON FECHA PASADA -->
    <div class="panel">
        <div class="panel-header">
            <h2>📅 Eventos Pendientes de Devolución</h2>
            <span id="contador-pasados" style="font-size:.8rem;color:var(--muted);"></span>
        </div>
        <div class="panel-body">
            <div id="msg-seccion2"></div>
            <div id="lista-pasados">
                <div class="sin-items"><div class="icono">📅</div><p>Cargando...</p></div>
            </div>
        </div>
    </div>

</div>

<!-- MODAL DEVOLUCIÓN -->
<div id="modal-devolucion" class="modal-overlay" style="display:none;">
    <div class="modal-box">
        <h3>📋 Registro de Devolución</h3>
        <p class="sub" id="modal-evento-nombre"></p>
        <div id="msg-modal"></div>
        <table class="dev-tabla">
            <thead>
                <tr>
                    <th>Artículo</th>
                    <th>Apartado</th>
                    <th>Entregado</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody id="tabla-devolucion"></tbody>
        </table>
        <div class="modal-actions">
            <button class="btn-cancelar-modal" onclick="cerrarModal()">Cancelar</button>
            <button class="btn-confirmar-dev" onclick="confirmarDevolucion()">Confirmar Devolución</button>
        </div>
    </div>
</div>

<script>
let eventoActual = null;
let articulosActuales = [];

// ── SECCIÓN 1: APARTADOS ────────────────────────────
function cargarApartados() {
    fetch('/CixEventos/controllers/get_apartados.php')
        .then(r => r.json())
        .then(data => renderApartados(data))
        .catch(() => {
            document.getElementById('lista-apartados').innerHTML =
                `<div class="sin-items"><div class="icono">⚠️</div><p>Error al cargar.</p></div>`;
        });
}

function renderApartados(grupos) {
    const lista = document.getElementById('lista-apartados');
    if (!grupos.length) {
        lista.innerHTML = `<div class="sin-items"><div class="icono">✅</div><p>No hay mobiliario apartado actualmente.</p></div>`;
        return;
    }
    lista.innerHTML = grupos.map(g => `
        <div class="apartado-card">
            <div class="apartado-top">
                <span class="apartado-evento">${g.nombre_evento}</span>
                <span class="badge-ap">Apartado</span>
            </div>
            <div class="apartado-meta">
                👤 ${g.nombre_usuario} · ✉️ ${g.email_usuario}<br>
                📅 ${g.fecha_evento} &nbsp;·&nbsp; 📍 ${g.direccion}<br>
                ⏱ Apartado: ${g.fecha_apartado}
            </div>
            <div class="apartado-items">
                ${g.articulos.map(a => `<span>${a.nombre_item} x${a.cantidad}</span>`).join('')}
            </div>
        </div>`).join('');
}

// ── SECCIÓN 2: EVENTOS PASADOS ──────────────────────
function cargarPasados() {
    fetch('/CixEventos/controllers/get_eventos_pasados.php')
        .then(r => r.json())
        .then(data => renderPasados(data))
        .catch(() => {
            document.getElementById('lista-pasados').innerHTML =
                `<div class="sin-items"><div class="icono">⚠️</div><p>Error al cargar.</p></div>`;
        });
}

function renderPasados(eventos) {
    const lista = document.getElementById('lista-pasados');
    const contador = document.getElementById('contador-pasados');

    if (!eventos.length) {
        lista.innerHTML = `<div class="sin-items"><div class="icono">✅</div><p>No hay eventos pendientes de devolución.</p></div>`;
        contador.textContent = '';
        return;
    }

    contador.textContent = `· ${eventos.length} pendientes`;

    lista.innerHTML = eventos.map(ev => `
        <div class="evento-pasado-card">
            <div class="ep-info">
                <div class="ep-nombre">${ev.nombre_evento}</div>
                <div class="ep-meta">
                    👤 ${ev.nombre_usuario} · ✉️ ${ev.email_usuario}<br>
                    📅 ${ev.fecha_evento} · 📍 ${ev.direccion}
                </div>
            </div>
            <div class="ep-actions">
                <button class="btn-notificar" onclick="notificarCliente(${ev.id_evento}, ${ev.id_usuario}, '${ev.nombre_evento}')">
                    🔔 Notificar Cliente
                </button>
                <button class="btn-iniciar-dev" onclick="abrirDevolucion(${ev.id_evento}, '${ev.nombre_evento}')">
                    📋 Registrar Devolución
                </button>
            </div>
        </div>`).join('');
}

// ── NOTIFICAR CLIENTE ───────────────────────────────
function notificarCliente(id_evento, id_usuario, nombre_evento) {
    fetch('/CixEventos/controllers/notificar_cliente.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
            id_usuario,
            mensaje: `Tu evento "${nombre_evento}" ya pasó. Por favor confirma la devolución del mobiliario.`
        })
    })
    .then(r => r.json())
    .then(res => {
        const msg = document.getElementById('msg-seccion2');
        if (res.ok) {
            msg.innerHTML = `<div class="alert-cix alert-success">✅ Notificación enviada al cliente.</div>`;
        } else {
            msg.innerHTML = `<div class="alert-cix alert-danger">❌ Error al notificar.</div>`;
        }
        setTimeout(() => msg.innerHTML = '', 3000);
    });
}

// ── MODAL DEVOLUCIÓN ────────────────────────────────
function abrirDevolucion(id_evento, nombre_evento) {
    eventoActual = id_evento;
    document.getElementById('modal-evento-nombre').textContent = `Evento: ${nombre_evento}`;
    document.getElementById('msg-modal').innerHTML = '';

    fetch(`/CixEventos/controllers/get_detalle_evento.php?id_evento=${id_evento}`)
        .then(r => r.json())
        .then(arts => {
            articulosActuales = arts;
            const tbody = document.getElementById('tabla-devolucion');
            tbody.innerHTML = arts.map(art => `
                <tr>
                    <td><strong>${art.nombre_item}</strong></td>
                    <td style="text-align:center;">${art.cantidad}</td>
                    <td>
                        <input type="number" class="input-cant-dev"
                               id="entregado-${art.id_item}"
                               value="${art.cantidad}" min="0" max="${art.cantidad}">
                    </td>
                    <td>
                        <select class="select-estado-dev" id="estado-${art.id_item}"
                                onchange="this.className='select-estado-dev'+(this.value==='danado'?' danado':'')">
                            <option value="bueno">✅ Bueno</option>
                            <option value="danado">⚠️ Dañado</option>
                        </select>
                    </td>
                </tr>`).join('');

            document.getElementById('modal-devolucion').style.display = 'flex';
        });
}

function cerrarModal() {
    document.getElementById('modal-devolucion').style.display = 'none';
    eventoActual = null;
    articulosActuales = [];
}

// ── CONFIRMAR DEVOLUCIÓN ────────────────────────────
function confirmarDevolucion() {
    const detalles = articulosActuales.map(art => ({
        id_item:    art.id_item,
        id_detalle: art.id_detalle,
        cantidad_apartada:  art.cantidad,
        cantidad_entregada: parseInt(document.getElementById(`entregado-${art.id_item}`).value) || 0,
        estado: document.getElementById(`estado-${art.id_item}`).value
    }));

    fetch('/CixEventos/controllers/confirmar_devolucion.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ id_evento: eventoActual, detalles })
    })
    .then(r => r.json())
    .then(res => {
        if (res.ok) {
            cerrarModal();
            cargarApartados();
            cargarPasados();
            const msg = document.getElementById('msg-seccion2');
            msg.innerHTML = `<div class="alert-cix alert-success">✅ Devolución registrada y stock actualizado.</div>`;
            setTimeout(() => msg.innerHTML = '', 4000);
        } else {
            document.getElementById('msg-modal').innerHTML =
                `<div class="alert-cix alert-danger">❌ ${res.msg || 'Error al registrar.'}</div>`;
        }
    });
}

cargarApartados();
cargarPasados();
</script>

</body>
</html>