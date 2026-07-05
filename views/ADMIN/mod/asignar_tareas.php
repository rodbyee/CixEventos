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
    <title>Asignar Tareas | CIX Eventos</title>
    <link rel="icon" type="image/png" href="../../../assets/content/logotip-cix.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --azul: #1a56db; --azul-dark: #1341b0;
            --bg: #f4f6fb; --card: #ffffff;
            --text: #1a1d2e; --muted: #6b7280; --border: #e5e7ef;
            --verde: #16a34a; --rojo: #dc2626; --amarillo: #d97706;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'DM Sans', sans-serif; background: var(--bg); color: var(--text); min-height: 100vh; }

        .navbar-cix {
            background: var(--azul); padding: 0.75rem 2rem;
            display: flex; align-items: center; justify-content: space-between;
            box-shadow: 0 2px 12px rgba(26,86,219,.18);
        }
        .navbar-brand-cix { display: flex; align-items: center; gap: 10px; }
        .navbar-brand-cix img { height: 42px; border-radius: 50%; box-shadow: 0 0 0 2px rgba(255,255,255,.35); }
        .navbar-brand-cix span { color: #fff; font-family: 'DM Serif Display', serif; font-size: 1.2rem; }
        .navbar-brand-cix small { display: block; color: rgba(255,255,255,.65); font-size: .68rem; font-weight: 300; letter-spacing: 1.5px; text-transform: uppercase; }
        .navbar-right { display: flex; align-items: center; gap: .75rem; }
        .btn-back {
            background: rgba(255,255,255,.15); border: 1.5px solid rgba(255,255,255,.4);
            color: #fff; border-radius: 8px; padding: .4rem 1rem;
            font-size: .85rem; font-weight: 500; text-decoration: none; transition: all .2s;
        }
        .btn-back:hover { background: rgba(255,255,255,.25); color: #fff; }
        .btn-logout {
            background: transparent; border: 1.5px solid rgba(255,255,255,.5);
            color: #fff; border-radius: 8px; padding: .4rem 1rem;
            font-size: .85rem; font-weight: 500; text-decoration: none; transition: all .2s;
        }
        .btn-logout:hover { background: rgba(255,255,255,.15); color: #fff; }

        .hero {
            background: linear-gradient(135deg, var(--azul) 0%, #3b82f6 100%);
            color: #fff; padding: 2rem 2rem 3rem;
        }
        .hero h1 { font-family: 'DM Serif Display', serif; font-size: 2rem; font-weight: 400; margin-bottom: .2rem; }
        .hero p { opacity: .7; font-size: .9rem; font-weight: 300; }

        /* LAYOUT */
        .contenido {
            max-width: 1200px;
            margin: -1.5rem auto 3rem;
            padding: 0 1.5rem;
            display: grid;
            grid-template-columns: 1fr 380px;
            gap: 1.5rem;
            align-items: start;
        }

        /* PANEL IZQUIERDO - BANDEJA */
        .bandeja {
            background: var(--card); border-radius: 16px;
            border: 1.5px solid var(--border);
            box-shadow: 0 4px 24px rgba(0,0,0,.07);
            overflow: hidden;
        }
        .bandeja-header {
            padding: 1.1rem 1.4rem;
            border-bottom: 1.5px solid var(--border);
            display: flex; align-items: center; justify-content: space-between;
            background: #fafbff;
        }
        .bandeja-header h2 { font-family: 'DM Serif Display', serif; font-size: 1.15rem; font-weight: 400; margin: 0; }

        .tabs-bandeja {
            display: flex; border-bottom: 1.5px solid var(--border);
        }
        .tab-band {
            flex: 1; padding: .7rem; text-align: center;
            font-size: .82rem; font-weight: 600; cursor: pointer;
            color: var(--muted); border: none; background: none;
            font-family: 'DM Sans', sans-serif;
            border-bottom: 2.5px solid transparent;
            transition: all .2s;
        }
        .tab-band.active { color: var(--azul); border-bottom-color: var(--azul); }

        .tarea-item {
            padding: 1rem 1.4rem;
            border-bottom: 1px solid var(--border);
            cursor: pointer; transition: background .15s;
            display: flex; gap: 1rem; align-items: flex-start;
        }
        .tarea-item:last-child { border-bottom: none; }
        .tarea-item:hover { background: #f8faff; }
        .tarea-item.seleccionada { background: #eff6ff; border-left: 3px solid var(--azul); }
        .tarea-item.leida { opacity: .7; }

        .tarea-avatar {
            width: 38px; height: 38px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: .9rem; font-weight: 700; color: #fff; flex-shrink: 0;
        }
        .tarea-meta { flex: 1; min-width: 0; }
        .tarea-usuario { font-weight: 600; font-size: .88rem; }
        .tarea-titulo-prev {
            font-size: .82rem; color: var(--muted);
            white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
        }
        .tarea-fecha-prev { font-size: .75rem; color: var(--muted); flex-shrink: 0; }

        .badge-prioridad {
            padding: .18rem .6rem; border-radius: 20px;
            font-size: .68rem; font-weight: 700; margin-left: .4rem;
        }
        .p-alta   { background: #fee2e2; color: var(--rojo); }
        .p-media  { background: #fef3c7; color: var(--amarillo); }
        .p-baja   { background: #dcfce7; color: var(--verde); }

        .empty-band { text-align: center; padding: 3rem 1rem; color: var(--muted); font-size: .88rem; }
        .spinner-band { text-align: center; padding: 2rem; color: var(--muted); font-size: .85rem; }

        /* PANEL DERECHO */
        .panel-der { display: flex; flex-direction: column; gap: 1.5rem; }

        /* DETALLE TAREA */
        .detalle-tarea {
            background: var(--card); border-radius: 16px;
            border: 1.5px solid var(--border);
            box-shadow: 0 4px 24px rgba(0,0,0,.07);
            padding: 1.5rem; display: none;
        }
        .detalle-tarea.show { display: block; }
        .det-titulo { font-family: 'DM Serif Display', serif; font-size: 1.25rem; margin-bottom: 1rem; }
        .det-fila { display: flex; gap: .5rem; align-items: flex-start; margin-bottom: .7rem; font-size: .85rem; }
        .det-fila .icono { flex-shrink: 0; margin-top: .1rem; }
        .det-fila .label { color: var(--muted); font-size: .75rem; display: block; }
        .det-fila .valor { font-weight: 500; }
        .det-desc {
            background: #f8faff; border-radius: 10px;
            padding: .9rem 1rem; font-size: .85rem;
            color: var(--text); margin: 1rem 0; line-height: 1.6;
            border: 1px solid var(--border);
        }
        .btn-completar {
            width: 100%; padding: .65rem; border-radius: 10px;
            border: none; font-size: .88rem; font-weight: 600;
            font-family: 'DM Sans', sans-serif; cursor: pointer; transition: all .2s;
            background: #dcfce7; color: var(--verde);
        }
        .btn-completar:hover { background: #bbf7d0; }
        .btn-completar.completada { background: #f3f4f6; color: var(--muted); cursor: default; }

        /* FORMULARIO NUEVA TAREA */
        .form-tarea {
            background: var(--card); border-radius: 16px;
            border: 1.5px solid var(--border);
            box-shadow: 0 4px 24px rgba(0,0,0,.07);
            overflow: hidden;
        }
        .form-header {
            padding: 1rem 1.4rem; border-bottom: 1.5px solid var(--border);
            background: #fafbff;
        }
        .form-header h3 { font-family: 'DM Serif Display', serif; font-size: 1.1rem; font-weight: 400; margin: 0; }
        .form-body { padding: 1.4rem; }

        .form-label-cix { font-size: .7rem; font-weight: 600; letter-spacing: 1px; text-transform: uppercase; color: var(--muted); margin-bottom: .3rem; display: block; }
        .form-control-cix {
            border: 1.5px solid var(--border); border-radius: 10px;
            padding: .55rem .85rem; font-size: .87rem;
            font-family: 'DM Sans', sans-serif; width: 100%; outline: none;
            transition: border-color .2s; background: #fafbff; color: var(--text);
        }
        .form-control-cix:focus { border-color: var(--azul); background: #fff; }
        textarea.form-control-cix { resize: vertical; min-height: 80px; }
        .form-group { margin-bottom: 1rem; }
        .form-row2 { display: grid; grid-template-columns: 1fr 1fr; gap: .75rem; }

        /* Sugerencias de usuario */
        .input-wrap { position: relative; }
        .sugerencias {
            position: absolute; top: 100%; left: 0; right: 0;
            background: var(--card); border: 1.5px solid var(--border);
            border-radius: 10px; box-shadow: 0 8px 24px rgba(0,0,0,.1);
            z-index: 100; max-height: 200px; overflow-y: auto; display: none;
        }
        .sugerencia-item {
            padding: .6rem .9rem; cursor: pointer; font-size: .85rem;
            display: flex; align-items: center; gap: .6rem;
        }
        .sugerencia-item:hover { background: #eff6ff; }
        .sug-avatar {
            width: 28px; height: 28px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: .75rem; font-weight: 700; color: #fff; flex-shrink: 0;
        }
        .sug-info .sug-nombre { font-weight: 600; font-size: .83rem; }
        .sug-info .sug-email { font-size: .73rem; color: var(--muted); }

        .btn-enviar-tarea {
            width: 100%; padding: .7rem; border-radius: 10px;
            border: none; background: var(--azul); color: #fff;
            font-size: .9rem; font-weight: 600;
            font-family: 'DM Sans', sans-serif; cursor: pointer; transition: all .2s;
        }
        .btn-enviar-tarea:hover { background: var(--azul-dark); }
        .btn-enviar-tarea:disabled { opacity: .6; cursor: not-allowed; }

        /* TOAST */
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

        @media (max-width: 900px) {
            .contenido { grid-template-columns: 1fr; }
            .panel-der { order: -1; }
        }
        @media (max-width: 600px) {
            .form-row2 { grid-template-columns: 1fr; }
            .hero h1 { font-size: 1.6rem; }
        }
    </style>
</head>
<body>

<nav class="navbar-cix">
    <div class="navbar-brand-cix">
        <img src="../../../assets/content/logotype.png" alt="CIX Logo">
        <div><span>CIX Eventos</span><small>Admin</small></div>
    </div>
    <div class="navbar-right">
        <a href="../admin.php" class="btn-back">← Regresar</a>
        <a href="/CixEventos/controllers/logout.php" class="btn-logout">Cerrar Sesión</a>
    </div>
</nav>

<div class="hero">
    <h1>🔧 Asignar Tareas</h1>
    <p>Envía y gestiona tareas a trabajadores y encargados de inventario.</p>
</div>

<div class="contenido">

    <!-- BANDEJA -->
    <div class="bandeja">
        <div class="bandeja-header">
            <h2>📬 Bandeja</h2>
        </div>
        <div class="tabs-bandeja">
            <button class="tab-band active" onclick="cambiarTab('enviadas')">📤 Enviadas</button>
            <button class="tab-band" onclick="cambiarTab('recibidas')">📥 Recibidas</button>
        </div>
        <div id="lista-tareas">
            <div class="spinner-band">Cargando tareas...</div>
        </div>
    </div>

    <!-- PANEL DERECHO -->
    <div class="panel-der">

        <!-- DETALLE -->
        <div class="detalle-tarea" id="detalle-tarea">
            <div class="det-titulo" id="det-titulo"></div>
            <div class="det-fila">
                <span class="icono">👤</span>
                <div><span class="label" id="det-dir-label"></span><span class="valor" id="det-usuario"></span></div>
            </div>
            <div class="det-fila">
                <span class="icono">📅</span>
                <div><span class="label">Fecha límite</span><span class="valor" id="det-fecha"></span></div>
            </div>
            <div class="det-fila">
                <span class="icono">🚦</span>
                <div><span class="label">Prioridad</span><span class="valor" id="det-prioridad"></span></div>
            </div>
            <div class="det-desc" id="det-desc"></div>
            <button class="btn-completar" id="btn-completar" onclick="marcarCompletada()">✓ Marcar como completada</button>
        </div>

        <!-- FORMULARIO -->
        <div class="form-tarea">
            <div class="form-header">
                <h3>✉️ Nueva Tarea</h3>
            </div>
            <div class="form-body">
                <div class="form-group">
                    <label class="form-label-cix">Para (correo del usuario)</label>
                    <div class="input-wrap">
                        <input type="text" id="input-destinatario" class="form-control-cix"
                            placeholder="correo@ejemplo.com" autocomplete="off"
                            oninput="buscarUsuario(this.value)">
                        <div class="sugerencias" id="sugerencias"></div>
                    </div>
                    <input type="hidden" id="id-destinatario">
                </div>

                <div class="form-group">
                    <label class="form-label-cix">Título de la tarea</label>
                    <input type="text" id="tarea-titulo" class="form-control-cix" placeholder="Ej. Acomodar sillas del salón B">
                </div>

                <div class="form-group">
                    <label class="form-label-cix">Descripción</label>
                    <textarea id="tarea-desc" class="form-control-cix" placeholder="Detalla la tarea..."></textarea>
                </div>

                <div class="form-row2">
                    <div class="form-group">
                        <label class="form-label-cix">Fecha límite</label>
                        <input type="date" id="tarea-fecha" class="form-control-cix">
                    </div>
                    <div class="form-group">
                        <label class="form-label-cix">Prioridad</label>
                        <select id="tarea-prioridad" class="form-control-cix">
                            <option value="alta">🔴 Alta</option>
                            <option value="media" selected>🟡 Media</option>
                            <option value="baja">🟢 Baja</option>
                        </select>
                    </div>
                </div>

                <button class="btn-enviar-tarea" onclick="enviarTarea()">📤 Enviar Tarea</button>
            </div>
        </div>

    </div>
</div>

<div class="toast-cix" id="toast"></div>

<script>
let tabActual = 'enviadas';
let tareaSeleccionada = null;
let usuariosCache = [];
const avatarColor = { 1: '#dc2626', 2: '#16a34a', 3: '#d97706', 4: '#1a56db' };

// ── TABS
function cambiarTab(tab) {
    tabActual = tab;
    document.querySelectorAll('.tab-band').forEach((b, i) => {
        b.classList.toggle('active', (i === 0 && tab === 'enviadas') || (i === 1 && tab === 'recibidas'));
    });
    cargarTareas();
}

// ── CARGAR TAREAS
async function cargarTareas() {
    document.getElementById('lista-tareas').innerHTML = '<div class="spinner-band">Cargando...</div>';
    document.getElementById('detalle-tarea').classList.remove('show');
    try {
        const res  = await fetch(`/CixEventos/controllers/get_tareas.php?tipo=${tabActual}`);
        const data = await res.json();
        renderTareas(data);
    } catch(e) {
        document.getElementById('lista-tareas').innerHTML = '<div class="empty-band">⚠️ Error de conexión.</div>';
    }
}

function renderTareas(tareas) {
    const cont = document.getElementById('lista-tareas');
    if (!tareas.length) {
        cont.innerHTML = `<div class="empty-band">📭 No hay tareas ${tabActual === 'enviadas' ? 'enviadas' : 'recibidas'}.</div>`;
        return;
    }
    cont.innerHTML = tareas.map(t => {
        const rol   = parseInt(t.rol_contraparte);
        const color = avatarColor[rol] || '#6b7280';
        const ini   = t.nombre_contraparte.charAt(0).toUpperCase();
        const fecha = t.fecha_creacion ? t.fecha_creacion.split(' ')[0] : '';
        return `
        <div class="tarea-item ${t.estado === 'completada' ? 'leida' : ''}"
             id="tarea-item-${t.id_tarea}"
             onclick="verDetalle(${t.id_tarea})">
            <div class="tarea-avatar" style="background:${color}">${ini}</div>
            <div class="tarea-meta">
                <div class="tarea-usuario">
                    ${ucwords(t.nombre_contraparte)}
                    <span class="badge-prioridad p-${t.prioridad}">${t.prioridad}</span>
                    ${t.estado === 'completada' ? '<span class="badge-prioridad" style="background:#f3f4f6;color:#6b7280">✓</span>' : ''}
                </div>
                <div class="tarea-titulo-prev">${t.titulo}</div>
            </div>
            <div class="tarea-fecha-prev">${fecha}</div>
        </div>`;
    }).join('');
}

// ── VER DETALLE
async function verDetalle(idTarea) {
    document.querySelectorAll('.tarea-item').forEach(el => el.classList.remove('seleccionada'));
    document.getElementById(`tarea-item-${idTarea}`)?.classList.add('seleccionada');

    try {
        const res  = await fetch(`/CixEventos/controllers/get_tareas.php?tipo=${tabActual}&id=${idTarea}`);
        const t    = await res.json();
        tareaSeleccionada = t;

        document.getElementById('det-titulo').textContent  = t.titulo;
        document.getElementById('det-desc').textContent    = t.descripcion || 'Sin descripción.';
        document.getElementById('det-fecha').textContent   = t.fecha_limite || 'Sin fecha límite';
        document.getElementById('det-dir-label').textContent = tabActual === 'enviadas' ? 'Para' : 'De';
        document.getElementById('det-usuario').textContent = ucwords(t.nombre_contraparte);

        const prioEl = document.getElementById('det-prioridad');
        const cls = { alta: 'p-alta', media: 'p-media', baja: 'p-baja' };
        prioEl.innerHTML = `<span class="badge-prioridad ${cls[t.prioridad]}">${t.prioridad}</span>`;

        const btnComp = document.getElementById('btn-completar');
        if (t.estado === 'completada') {
            btnComp.textContent = '✓ Completada';
            btnComp.classList.add('completada');
        } else {
            btnComp.textContent = '✓ Marcar como completada';
            btnComp.classList.remove('completada');
            // Solo el destinatario puede marcarla
            btnComp.style.display = tabActual === 'recibidas' ? 'block' : 'none';
        }

        document.getElementById('detalle-tarea').classList.add('show');
    } catch(e) {
        mostrarToast('Error al cargar el detalle.');
    }
}

// ── MARCAR COMPLETADA
async function marcarCompletada() {
    if (!tareaSeleccionada || tareaSeleccionada.estado === 'completada') return;
    try {
        const res  = await fetch('/CixEventos/controllers/completar_tarea.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id_tarea: tareaSeleccionada.id_tarea })
        });
        const data = await res.json();
        if (data.success) {
            mostrarToast('Tarea marcada como completada.');
            cargarTareas();
            document.getElementById('detalle-tarea').classList.remove('show');
        }
    } catch(e) { mostrarToast('Error de conexión.'); }
}

// ── BUSCAR USUARIO (autocompletado)
async function buscarUsuario(valor) {
    const sug = document.getElementById('sugerencias');
    document.getElementById('id-destinatario').value = '';

    if (valor.length < 2) { sug.style.display = 'none'; return; }

    if (!usuariosCache.length) {
        const res = await fetch('/CixEventos/controllers/get_usuarios.php');
        usuariosCache = await res.json();
    }

    // Solo roles 1, 2, 3 (admin, inv, worker)
    const filtrados = usuariosCache.filter(u =>
        u.id_rol <= 3 &&
        (u.email_usuario.toLowerCase().includes(valor.toLowerCase()) ||
         u.nombre_usuario.toLowerCase().includes(valor.toLowerCase()))
    );

    if (!filtrados.length) { sug.style.display = 'none'; return; }

    sug.innerHTML = filtrados.map(u => {
        const color = avatarColor[u.id_rol];
        const ini   = u.nombre_usuario.charAt(0).toUpperCase();
        return `
        <div class="sugerencia-item" onclick="seleccionarUsuario(${u.id_usuario}, '${u.email_usuario}', '${u.nombre_usuario}')">
            <div class="sug-avatar" style="background:${color}">${ini}</div>
            <div class="sug-info">
                <div class="sug-nombre">${ucwords(u.nombre_usuario)}</div>
                <div class="sug-email">${u.email_usuario}</div>
            </div>
        </div>`;
    }).join('');
    sug.style.display = 'block';
}

function seleccionarUsuario(id, email, nombre) {
    document.getElementById('input-destinatario').value = email;
    document.getElementById('id-destinatario').value    = id;
    document.getElementById('sugerencias').style.display = 'none';
}

// ── ENVIAR TAREA
async function enviarTarea() {
    const idDest   = document.getElementById('id-destinatario').value;
    const titulo   = document.getElementById('tarea-titulo').value.trim();
    const desc     = document.getElementById('tarea-desc').value.trim();
    const fecha    = document.getElementById('tarea-fecha').value;
    const prioridad = document.getElementById('tarea-prioridad').value;

    if (!idDest)  { mostrarToast('⚠️ Selecciona un destinatario válido.'); return; }
    if (!titulo)  { mostrarToast('⚠️ El título no puede estar vacío.'); return; }
    if (!fecha)   { mostrarToast('⚠️ Selecciona una fecha límite.'); return; }

    const btn = document.querySelector('.btn-enviar-tarea');
    btn.disabled = true; btn.textContent = 'Enviando...';

    try {
        const res  = await fetch('/CixEventos/controllers/crear_tarea.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id_destinatario: idDest, titulo, descripcion: desc, fecha_limite: fecha, prioridad })
        });
        const data = await res.json();
        if (data.success) {
            mostrarToast('✅ Tarea enviada correctamente.');
            // Limpiar form
            document.getElementById('input-destinatario').value = '';
            document.getElementById('id-destinatario').value    = '';
            document.getElementById('tarea-titulo').value       = '';
            document.getElementById('tarea-desc').value         = '';
            document.getElementById('tarea-fecha').value        = '';
            document.getElementById('tarea-prioridad').value    = 'media';
            if (tabActual === 'enviadas') cargarTareas();
        } else {
            mostrarToast('❌ Error al enviar la tarea.');
        }
    } catch(e) { mostrarToast('Error de conexión.'); }

    btn.disabled = false; btn.textContent = '📤 Enviar Tarea';
}

function ucwords(str) {
    return str.toLowerCase().replace(/\b\w/g, l => l.toUpperCase());
}
function mostrarToast(msg) {
    const t = document.getElementById('toast');
    t.textContent = msg; t.classList.add('show');
    setTimeout(() => t.classList.remove('show'), 3000);
}

// Cerrar sugerencias al click fuera
document.addEventListener('click', e => {
    if (!e.target.closest('.input-wrap')) {
        document.getElementById('sugerencias').style.display = 'none';
    }
});

cargarTareas();
</script>
</body>
</html>