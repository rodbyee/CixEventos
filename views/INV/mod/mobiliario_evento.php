<?php
session_start();

$id_evento = intval($_GET['id_evento'] ?? 0);
if (!$id_evento) {
    header("Location: revisar_eventos.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mobiliario del Evento | CIX Eventos</title>
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
        .navbar-brand-cix span { color: #fff; font-family: 'DM Serif Display', serif; font-size: 1.2rem; letter-spacing: .5px; }
        .navbar-brand-cix small { display: block; color: rgba(255,255,255,.65); font-size: .68rem; font-weight: 300; letter-spacing: 1.5px; text-transform: uppercase; line-height: 1; }
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
        .contenido { max-width: 750px; margin: -2rem auto 3rem; padding: 0 1.5rem; display: flex; flex-direction: column; gap: 1.5rem; }

        /* PANEL INFO EVENTO */
        .panel { background: var(--card); border-radius: 16px; box-shadow: 0 4px 24px rgba(0,0,0,.07); overflow: hidden; }
        .panel-header { padding: 1.1rem 1.5rem; border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; }
        .panel-header h2 { font-family: 'DM Serif Display', serif; font-size: 1.15rem; font-weight: 400; color: var(--text); margin: 0; }
        .panel-body { padding: 1.5rem; }

        /* INFO EVENTO */
        .evento-info { display: grid; grid-template-columns: 1fr 1fr; gap: .75rem; margin-bottom: 1rem; }
        .info-item { background: #f8faff; border: 1px solid var(--border); border-radius: 10px; padding: .65rem .9rem; }
        .info-label { font-size: .68rem; font-weight: 600; letter-spacing: 1px; text-transform: uppercase; color: var(--muted); display: block; margin-bottom: .2rem; }
        .info-valor { font-size: .88rem; font-weight: 500; color: var(--text); }

        /* LISTA MOBILIARIO */
        .art-row {
            display: flex; align-items: center; gap: 1rem;
            padding: .9rem 1rem; border: 1.5px solid var(--border);
            border-radius: 12px; margin-bottom: .65rem;
            transition: border-color .2s;
        }
        .art-row:hover { border-color: #93c5fd; }
        .art-row:last-child { margin-bottom: 0; }

        .art-icono { width: 44px; height: 44px; background: #eff6ff; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1.3rem; flex-shrink: 0; }
        .art-info { flex: 1; }
        .art-nombre { font-weight: 600; font-size: .92rem; }
        .art-id { font-size: .73rem; color: var(--muted); }

        .art-cantidad {
            background: var(--azul); color: #fff;
            border-radius: 999px; padding: .25rem .75rem;
            font-size: .82rem; font-weight: 700;
            flex-shrink: 0;
        }

        /* TOTALES */
        .resumen-total {
            background: #f0f7ff; border: 1.5px solid #bfdbfe;
            border-radius: 12px; padding: 1rem 1.2rem;
            display: flex; justify-content: space-between; align-items: center;
        }
        .resumen-total span { font-size: .88rem; color: var(--azul); font-weight: 500; }
        .resumen-total strong { font-family: 'DM Serif Display', serif; font-size: 1.5rem; color: var(--azul); }

        /* SIN ITEMS */
        .sin-items { text-align: center; padding: 2.5rem 1rem; color: var(--muted); }
        .sin-items .icono { font-size: 2rem; margin-bottom: .5rem; }

        @media (max-width: 600px) {
            .evento-info { grid-template-columns: 1fr; }
            .hero h1 { font-size: 1.7rem; }
        }
    </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar-cix">
    <div class="navbar-brand-cix">
        <img src="../../../assets/content/logotype.png" alt="CIX Logo">
        <div><span>CIX Eventos</span><small>Encargado Inventario</small></div>
    </div>
    <div class="navbar-nav-cix">
        <a href="revisar_eventos.php" class="btn-back">← Regresar</a>
        <a href="../../../controllers/logout.php" class="btn-logout">Cerrar Sesión</a>
    </div>
</nav>

<!-- HERO -->
<div class="hero">
    <h1>📦 Mobiliario del Evento</h1>
    <p id="hero-sub">Cargando información del evento...</p>
</div>

<!-- CONTENIDO -->
<div class="contenido">

    <!-- INFO DEL EVENTO -->
    <div class="panel" id="panel-info" style="display:none;">
        <div class="panel-header">
            <h2 id="info-nombre-evento">—</h2>
            <span id="info-badge" style="font-size:.75rem;font-weight:600;padding:.25rem .65rem;border-radius:999px;"></span>
        </div>
        <div class="panel-body">
            <div class="evento-info">
                <div class="info-item">
                    <span class="info-label">Cliente</span>
                    <span class="info-valor" id="info-cliente">—</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Correo</span>
                    <span class="info-valor" id="info-email">—</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Fecha</span>
                    <span class="info-valor" id="info-fecha">—</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Horario</span>
                    <span class="info-valor" id="info-horario">—</span>
                </div>
                <div class="info-item" style="grid-column: 1 / -1;">
                    <span class="info-label">Lugar</span>
                    <span class="info-valor" id="info-lugar">—</span>
                </div>
            </div>
        </div>
    </div>

    <!-- LISTA DE MOBILIARIO -->
    <div class="panel">
        <div class="panel-header">
            <h2>Artículos Solicitados</h2>
            <span id="contador-arts" style="font-size:.82rem;color:var(--muted);"></span>
        </div>
        <div class="panel-body">
            <div id="lista-mobiliario">
                <div class="sin-items"><div class="icono">⏳</div><p>Cargando...</p></div>
            </div>
            <div id="resumen-total" class="resumen-total" style="margin-top:1rem;display:none;">
                <span>Total de piezas solicitadas</span>
                <strong id="total-piezas">0</strong>
            </div>
        </div>
    </div>

</div>

<script>
const ID_EVENTO = <?php echo $id_evento; ?>;

async function cargarDatos() {
    try {
        // Cargar info del evento y mobiliario en paralelo
        const [resEv, resMob] = await Promise.all([
            fetch(`/CixEventos/controllers/get_all_ev.php`),
            fetch(`/CixEventos/controllers/get_detalle_evento.php?id_evento=${ID_EVENTO}`)
        ]);

        const eventos = await resEv.json();
        const mobiliario = await resMob.json();

        // Buscar el evento específico
        const ev = eventos.find(e => parseInt(e.id_evento) === ID_EVENTO);

        if (ev) {
            // Mostrar info del evento
            document.getElementById('panel-info').style.display = 'block';
            document.getElementById('info-nombre-evento').textContent = ev.nombre_evento;
            document.getElementById('info-cliente').textContent  = ev.nombre_usuario;
            document.getElementById('info-email').textContent    = ev.email_usuario;
            document.getElementById('info-fecha').textContent    = ev.fecha_evento;
            document.getElementById('info-lugar').textContent    = ev.direccion || '—';
            document.getElementById('hero-sub').textContent      = ev.nombre_evento;

            const horaIn  = ev.hora_inicio ? ev.hora_inicio.substring(0,5) : '--:--';
            const horaOut = ev.hora_fin    ? ev.hora_fin.substring(0,5)    : '--:--';
            document.getElementById('info-horario').textContent = `${horaIn} - ${horaOut}`;

            const badge = document.getElementById('info-badge');
            badge.textContent = ev.estado;
            badge.style.background = ev.estado === 'Confirmado' ? '#dcfce7' : '#fef3c7';
            badge.style.color      = ev.estado === 'Confirmado' ? '#16a34a' : '#d97706';
        }

        renderMobiliario(mobiliario);

    } catch(e) {
        document.getElementById('lista-mobiliario').innerHTML =
            `<div class="sin-items"><div class="icono">⚠️</div><p>Error al cargar los datos.</p></div>`;
    }
}

function renderMobiliario(arts) {
    const lista    = document.getElementById('lista-mobiliario');
    const contador = document.getElementById('contador-arts');
    const resumen  = document.getElementById('resumen-total');
    const total    = document.getElementById('total-piezas');

    if (!arts.length) {
        lista.innerHTML = `<div class="sin-items"><div class="icono">📦</div><p>Este evento no tiene mobiliario apartado.</p></div>`;
        contador.textContent = '';
        resumen.style.display = 'none';
        return;
    }

    const totalPiezas = arts.reduce((sum, a) => sum + parseInt(a.cantidad), 0);
    contador.textContent = `· ${arts.length} ${arts.length === 1 ? 'artículo' : 'artículos'}`;
    total.textContent = totalPiezas;
    resumen.style.display = 'flex';

    lista.innerHTML = arts.map(art => `
        <div class="art-row">
            <div class="art-icono">📋</div>
            <div class="art-info">
                <div class="art-nombre">${art.nombre_item}</div>
                <div class="art-id">ID artículo: #${art.id_item}</div>
            </div>
            <span class="art-cantidad">x${art.cantidad}</span>
        </div>`).join('');
}

cargarDatos();
</script>

</body>
</html>