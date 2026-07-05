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
    <title>Panel de Cliente | CIX Eventos</title>
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
        .btn-logout {
            background: transparent;
            border: 1.5px solid rgba(255,255,255,.5);
            color: #fff;
            border-radius: 8px;
            padding: .4rem 1rem;
            font-size: .85rem;
            font-weight: 500;
            transition: all .2s;
        }
        .btn-logout:hover {
            background: rgba(255,255,255,.15);
            border-color: #fff;
        }

        /* ── HERO SALUDO ── */
        .hero {
            background: linear-gradient(135deg, var(--azul) 0%, #3b82f6 100%);
            color: #fff;
            padding: 2.5rem 2rem 3.5rem;
        }
        .hero h1 {
            font-family: 'DM Serif Display', serif;
            font-size: 2.4rem;
            font-weight: 400;
            margin-bottom: .2rem;
        }
        .hero h1 span { opacity: .75; }
        .hero p {
            opacity: .7;
            font-size: .95rem;
            font-weight: 300;
        }

        /* ── LAYOUT PRINCIPAL ── */
        .main-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
            max-width: 1200px;
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
        }
        .panel-header h2 {
            font-family: 'DM Serif Display', serif;
            font-size: 1.25rem;
            font-weight: 400;
            color: var(--text);
        }
        .panel-body { padding: 1.5rem; }

        /* ── EVENTO CARD ── */
        .evento-card {
            border: 1.5px solid var(--border);
            border-radius: 12px;
            padding: 1rem 1.1rem;
            margin-bottom: 1rem;
            transition: box-shadow .2s, border-color .2s;
            cursor: default;
        }
        .evento-card:hover {
            box-shadow: 0 4px 16px rgba(26,86,219,.1);
            border-color: #93c5fd;
        }
        .evento-card:last-child { margin-bottom: 0; }
        .evento-top {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: .4rem;
        }
        .evento-nombre {
            font-weight: 600;
            font-size: 1rem;
            color: var(--text);
        }
        .badge-estado {
            font-size: .72rem;
            font-weight: 600;
            padding: .25rem .6rem;
            border-radius: 999px;
        }
        .badge-confirmado {
            background: #dcfce7;
            color: var(--confirmado);
        }
        .badge-pendiente {
            background: #fef3c7;
            color: var(--pendiente);
        }
        .evento-meta {
            font-size: .8rem;
            color: var(--muted);
            margin-bottom: .5rem;
            line-height: 1.6;
        }
        .evento-tags span {
            display: inline-block;
            background: #eff6ff;
            color: var(--azul);
            font-size: .72rem;
            font-weight: 500;
            padding: .15rem .55rem;
            border-radius: 999px;
            margin-right: .3rem;
        }
        .sin-eventos {
            text-align: center;
            padding: 2.5rem 1rem;
            color: var(--muted);
        }
        .sin-eventos .icono { font-size: 2.5rem; margin-bottom: .75rem; }

        /* ── FORMULARIO REGISTRO ── */
        .form-label-cix {
            font-size: .72rem;
            font-weight: 600;
            letter-spacing: 1px;
            text-transform: uppercase;
            color: var(--muted);
            margin-bottom: .35rem;
        }
        .form-control-cix {
            border: 1.5px solid var(--border);
            border-radius: 10px;
            padding: .6rem .9rem;
            font-size: .9rem;
            font-family: 'DM Sans', sans-serif;
            width: 100%;
            outline: none;
            transition: border-color .2s, box-shadow .2s;
            background: #fafbff;
            color: var(--text);
        }
        .form-control-cix:focus {
            border-color: var(--azul);
            box-shadow: 0 0 0 3px rgba(26,86,219,.1);
            background: #fff;
        }
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }
        .form-group { margin-bottom: 1.1rem; }

        /* Textarea */
        textarea.form-control-cix { resize: vertical; min-height: 80px; }

        .btn-mobiliario {
            display: inline-block;
            background: #eff6ff;
            color: var(--azul);
            border: 1.5px solid #93c5fd;
            border-radius: 8px;
            padding: .35rem .85rem;
            font-size: .8rem;
            font-weight: 600;
            text-decoration: none;
            transition: background .2s, border-color .2s;
        }
        .btn-mobiliario:hover {
            background: #dbeafe;
            border-color: var(--azul);
        }

        .btn-enviar {
            background: var(--azul);
            color: #fff;
            border: none;
            border-radius: 12px;
            padding: .75rem 1.5rem;
            font-size: 1rem;
            font-weight: 600;
            font-family: 'DM Sans', sans-serif;
            width: 100%;
            cursor: pointer;
            transition: background .2s, transform .15s;
        }
        .btn-enviar:hover {
            background: var(--azul-dark);
            transform: translateY(-1px);
        }
        .btn-enviar:active { transform: translateY(0); }

        .btn-editar{
             background: #f5f3ff;
             color: #7c3aed;
             border: 1.5px solid #c4b5fd;
             border-radius: 8px;
             padding: .35rem .85rem;
             font-size: .8rem;
             font-weight: 600;
             cursor: pointer;
             transition: background .2s, border-color .2s;
            }
            .btn-editar:hover {
                background: #ede9fe;
                border-color: #7c3aed;
            }

        /* ── ALERT ── */
        .alert-cix {
            padding: .75rem 1rem;
            border-radius: 10px;
            font-size: .88rem;
            margin-bottom: 1rem;
        }
        .alert-success { background: #dcfce7; color: #15803d; }
        .alert-danger   { background: #fee2e2; color: #dc2626; }

        .form-group-hora{
            display: flex;
            flex-direction: row;
            gap: 10px;
        }
        .modal-overlay {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0,0,0,0.5); display: flex; justify-content: center; align-items: center; z-index: 1000;
        }
        .modal-content {
            background: white; padding: 2rem; border-radius: 10px; width: 90%; max-width: 500px;
        }

        /* ── CAMPANA NOTIFICACIONES ── */
.notif-wrap { position: relative; }
.btn-campana {
    background: rgba(255,255,255,.15);
    border: 1.5px solid rgba(255,255,255,.4);
    color: #fff; border-radius: 8px;
    width: 38px; height: 38px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.1rem; cursor: pointer; position: relative;
    transition: background .2s;
}
.btn-campana:hover { background: rgba(255,255,255,.25); }
.notif-badge {
    position: absolute; top: -5px; right: -5px;
    background: #ef4444; color: #fff;
    font-size: .65rem; font-weight: 700;
    width: 18px; height: 18px;
    border-radius: 50%; display: none;
    align-items: center; justify-content: center;
}
.notif-dropdown {
    position: absolute; top: calc(100% + 8px); right: 0;
    width: 300px; background: #fff;
    border-radius: 12px; box-shadow: 0 8px 32px rgba(0,0,0,.15);
    z-index: 999; display: none; overflow: hidden;
}
.notif-dropdown.open { display: block; }
.notif-header {
    padding: .75rem 1rem;
    border-bottom: 1px solid var(--border);
    font-size: .82rem; font-weight: 600; color: var(--text);
    display: flex; justify-content: space-between; align-items: center;
}
.notif-marcar { font-size: .75rem; color: var(--azul); cursor: pointer; font-weight: 500; }
.notif-item {
    padding: .75rem 1rem;
    border-bottom: 1px solid var(--border);
    font-size: .82rem; line-height: 1.5;
    transition: background .15s;
}
.notif-item:last-child { border-bottom: none; }
.notif-item.nueva { background: #eff6ff; }
.notif-item .notif-fecha { font-size: .72rem; color: var(--muted); margin-top: .2rem; }
.notif-vacia { padding: 1.5rem; text-align: center; color: var(--muted); font-size: .85rem; }

        @media (max-width: 900px) {
            .main-grid { grid-template-columns: 1fr; }
            .hero h1 { font-size: 1.8rem; }
        }
    </style>
</head>
<body>

<nav class="navbar-cix">
    <div class="navbar-brand-cix">
        <img src="../../assets/content/logotype.png" alt="CIX Logo">
        <div>
            <span>CIX Eventos</span>
            <small>Cliente</small>
        </div>
    </div>
    <div style="display:flex;align-items:center;gap:1rem;">
        <div class="notif-wrap">
            <button class="btn-campana" id="btn-campana" onclick="toggleNotif()">
                🔔
                <span class="notif-badge" id="notif-badge"></span>
            </button>
            <div class="notif-dropdown" id="notif-dropdown">
                <div class="notif-header">
                    Notificaciones
                    <span class="notif-marcar" onclick="marcarLeidas()">Marcar todas como leídas</span>
                </div>
                <div id="notif-lista"></div>
            </div>
        </div>
        <a href="../../controllers/logout.php" class="btn-logout">Cerrar Sesión</a>
    </div>
</nav>

<div class="hero">
    <h1><?php echo $saludo; ?>, <span><?php echo ucwords(strtolower($nombreUsuario)); ?></span></h1>
    <p>Gestiona tus eventos y solicita mobiliario desde aquí.</p>
</div>

<div class="main-grid">

    <!-- ── COLUMNA IZQUIERDA: MIS EVENTOS ── -->
    <div class="panel">
        <div class="panel-header">
            <h2>Mis Eventos</h2>
            <span style="font-size:.8rem;color:var(--muted)" id="contador-eventos"></span>
        </div>
        <div class="panel-body" id="lista-eventos">
            <!-- JS carga los eventos aquí -->
            <div class="sin-eventos">
                <div class="icono">📅</div>
                <p>Cargando eventos...</p>
            </div>
        </div>
    </div>

    <div class="panel">
        <div class="panel-header">
            <h2>Registrar Evento</h2>
        </div>
        <div class="panel-body">

            <div id="mensaje-form"></div>

            <form id="form-evento" method="POST" action="../../controllers/registro_eventos.php">

                <div class="form-group">
                    <label class="form-label-cix">Nombre del Evento</label>
                    <input type="text" name="nombre_evento" class="form-control-cix"
                           placeholder="Ej. Boda García, XV Morales..." required>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label-cix">Fecha</label>
                        <input type="date" name="fecha_evento" class="form-control-cix" required>
                    </div>
                </div>
                <div class="form-group-hora">
                    <div class="col-md-3 mb-3">
                      <label>Hora Inicio</label>
                      <input type="time" name="hora_inicio" class="form-control" required>
                    </div>
                    <div class="col-md-3 mb-3">
                     <label>Hora Fin</label>
                      <input type="time" name="hora_fin" class="form-control" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label-cix">Lugar</label>
                    <input type="text" name="direccion" class="form-control-cix"
                           placeholder="Salón, jardín, auditorio...">
                </div>

                <div class="form-group">
                    <label class="form-label-cix">Notas adicionales</label>
                    <textarea name="notas_evento" class="form-control-cix"
                              rows="3" placeholder="Indicaciones especiales, número de invitados..."></textarea>
                </div>

                <button type="submit" class="btn-enviar">Guardar Evento</button>

                <p style="font-size:.78rem;color:var(--muted);text-align:center;margin-top:.75rem;">
                    📦 Podrás seleccionar el mobiliario desde la tarjeta del evento una vez guardado.
                </p>
            </form>
        </div>
    </div>

</div><!-- /main-grid -->
<div id="modal-editar" class="modal-overlay" style="display:none;">
    <div class="modal-content">
        <h3>Editar Evento</h3>
        <hr>
        <form id="form-editar">
            <input type="hidden" name="id_evento" id="edit-id">
            
            <div class="mb-3">
                <label>Nombre del Evento</label>
                <input type="text" name="nombre_evento" id="edit-nombre" class="form-control" required>
            </div>
            
            <div class="mb-3">
                <label>Fecha</label>
                <input type="date" name="fecha_evento" id="edit-fecha" class="form-control" required>
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Hora Inicio</label>
                    <input type="time" name="hora_inicio" id="edit-inicio" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Hora Fin</label>
                    <input type="time" name="hora_fin" id="edit-fin" class="form-control" required>
                </div>
            </div>

            <div class="mb-3">
                <label>Dirección</label>
                <input type="text" name="direccion" id="edit-direccion" class="form-control" required>
            </div>

            <div class="modal-actions d-flex justify-content-between mt-4">
                <button type="button" onclick="eliminarEvento()" class="btn btn-danger">Eliminar Evento</button>
                <div>
                    <button type="button" onclick="cerrarModal()" class="btn btn-secondary">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
// ── CARGAR EVENTOS (fetch al controller) ─────────────
function cargarEventos() {
    // Usamos la ruta desde la raíz del proyecto
    fetch('/CixEventos/controllers/get_eventos.php') 
        .then(r => {
            if (!r.ok) throw new Error("Archivo no encontrado en la ruta");
            return r.json();
        })
        .then(data => renderEventos(data))
        .catch((error) => {
            console.error("Error en fetch:", error);
            document.getElementById('lista-eventos').innerHTML =
                `<div class="sin-eventos">
                    <div class="icono">⚠️</div>
                    <p>Error al conectar: ${error.message}</p>
                </div>`;
        });
}
function renderEventos(eventos) {
    const lista = document.getElementById('lista-eventos');
    const contador = document.getElementById('contador-eventos');

    if (!eventos.length) {
        lista.innerHTML = `<div class="sin-eventos"><div class="icono">📅</div><p>Aún no tienes eventos registrados.</p></div>`;
        contador.textContent = '';
        return;
    }

    contador.textContent = eventos.length + (eventos.length === 1 ? ' evento' : ' eventos');

    lista.innerHTML = eventos.map(ev => {
        const estadoClass = ev.estado === 'Confirmado' ? 'badge-confirmado' : 'badge-pendiente';
        
        // --- AQUÍ ESTÁ LA CORRECCIÓN ---
        // Declaramos la variable 'horario' antes de usarla abajo
        const horaIn = ev.hora_evento ? ev.hora_evento.substring(0, 5) : '--:--';
        const horaOut = ev.hora_fin ? ev.hora_fin.substring(0, 5) : '--:--';
        const horario = `${horaIn} - ${horaOut}`; 
        // -------------------------------

        const fecha = ev.fecha_evento; // O el formato de fecha que prefieras
        return `
        <div class="evento-card">
        <div class="evento-top">
        <span class="evento-nombre">${ev.nombre_evento}</span>
        <span class="badge-estado ${estadoClass}">${ev.estado}</span>
        </div>
        <div class="evento-meta">
        📅 ${fecha} &nbsp;·&nbsp; 🕐 ${horario}<br>
        📍 ${ev.lugar_evento ?? '—'}
        </div>
        <div style="margin-top:.7rem; display:flex; gap:.5rem;">
        <a href="mobiliario.php?id_evento=${ev.id_evento}" class="btn-mobiliario">
            📦 Seleccionar Mobiliario
        </a>
        <button onclick='abrirEditar(${JSON.stringify(ev)})' class="btn-editar">
            ✏️ Editar
        </button>
        </div>
        </div>`;
    }).join('');
}

cargarEventos();

// ── FEEDBACK FORM (si viene con ?ok o ?error) ────────
const params = new URLSearchParams(window.location.search);
const msg = document.getElementById('mensaje-form');
if (params.get('ok')) {
    msg.innerHTML = `<div class="alert-cix alert-success">✅ Evento registrado con éxito. Te avisaremos cuando sea confirmado.</div>`;
} else if (params.get('error')) {
    msg.innerHTML = `<div class="alert-cix alert-danger">❌ Hubo un error al registrar el evento. Intenta de nuevo.</div>`;
}
function abrirEditar(ev) {
    document.getElementById('edit-id').value = ev.id_evento;
    document.getElementById('edit-nombre').value = ev.nombre_evento;
    document.getElementById('edit-fecha').value = ev.fecha_evento;
    document.getElementById('edit-inicio').value = ev.hora_evento;
    document.getElementById('edit-fin').value = ev.hora_fin;
    document.getElementById('edit-direccion').value = ev.lugar_evento;
    
    document.getElementById('modal-editar').style.display = 'flex';
}

function cerrarModal() {
    document.getElementById('modal-editar').style.display = 'none';
}

// Lógica para GUARDAR cambios
document.getElementById('form-editar').onsubmit = function(e) {
    e.preventDefault();
    const formData = new FormData(this);

    fetch('../../controllers/actualizar_evento.php', {
        method: 'POST',
        body: formData
    })
    .then(r => r.json())
    .then(res => {
        if(res.ok) {
            cerrarModal();
            cargarEventos(); // Recarga las tarjetas
            alert("¡Evento actualizado con éxito!");
        }
    });
};

// Lógica para ELIMINAR
function eliminarEvento() {
    const id = document.getElementById('edit-id').value;
    if(confirm("¿Seguro que quieres borrar este evento? No se puede deshacer.")) {
        fetch(`../../controllers/eliminar_evento.php?id=${id}`)
        .then(r => r.json())
        .then(res => {
            if(res.ok) {
                cerrarModal();
                cargarEventos();
            }
        });
    }
}

// ── NOTIFICACIONES ────────────────────────────────
function cargarNotificaciones() {
    fetch('/CixEventos/controllers/get_notificaciones.php')
        .then(r => r.json())
        .then(data => {
            const badge = document.getElementById('notif-badge');
            const lista = document.getElementById('notif-lista');

            if (data.no_leidas > 0) {
                badge.style.display = 'flex';
                badge.textContent = data.no_leidas;
            } else {
                badge.style.display = 'none';
            }

            if (!data.notificaciones.length) {
                lista.innerHTML = `<div class="notif-vacia">Sin notificaciones nuevas.</div>`;
                return;
            }

            lista.innerHTML = data.notificaciones.map(n => `
                <div class="notif-item ${n.leida == 0 ? 'nueva' : ''}">
                    ${n.mensaje}
                    <div class="notif-fecha">${n.fecha}</div>
                </div>`).join('');
        });
}

function toggleNotif() {
    const dd = document.getElementById('notif-dropdown');
    dd.classList.toggle('open');
    if (dd.classList.contains('open')) cargarNotificaciones();
}

function marcarLeidas() {
    fetch('/CixEventos/controllers/get_notificaciones.php?action=marcar_leidas')
        .then(r => r.json())
        .then(() => cargarNotificaciones());
}

// Cerrar dropdown al hacer click fuera
document.addEventListener('click', e => {
    if (!document.getElementById('btn-campana').contains(e.target) &&
        !document.getElementById('notif-dropdown').contains(e.target)) {
        document.getElementById('notif-dropdown').classList.remove('open');
    }
});

cargarNotificaciones();
setInterval(cargarNotificaciones, 30000); // Revisa cada 30 segundos
</script>

</body>
</html>