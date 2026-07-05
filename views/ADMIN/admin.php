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
    <title>Panel Admin | CIX Eventos</title>
    <link rel="icon" type="image/png" href="../../assets/content/logotip-cix.png"> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
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

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
        }

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
            text-decoration: none;
        }
        .btn-logout:hover {
            background: rgba(255,255,255,.15);
            border-color: #fff;
            color: #fff;
        }

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

        .stats-bar {
            display: flex;
            gap: 1rem;
            max-width: 1000px;
            margin: -2rem auto 0;
            padding: 0 1.5rem;
            z-index: 10;
            position: relative;
        }
        .stat-card {
            background: var(--card);
            border-radius: 14px;
            box-shadow: 0 4px 20px rgba(0,0,0,.08);
            border: 1.5px solid var(--border);
            padding: 1.1rem 1.4rem;
            flex: 1;
            display: flex;
            align-items: center;
            gap: .9rem;
        }
        .stat-icono {
            font-size: 1.5rem;
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .stat-card:nth-child(1) .stat-icono { background: #eff6ff; }
        .stat-card:nth-child(2) .stat-icono { background: #f0fdf4; }
        .stat-card:nth-child(3) .stat-icono { background: #fefce8; }
        .stat-card:nth-child(4) .stat-icono { background: #fdf4ff; }
        .stat-num {
            font-family: 'DM Serif Display', serif;
            font-size: 1.6rem;
            color: var(--text);
            line-height: 1;
        }
        .stat-label {
            font-size: .75rem;
            color: var(--muted);
            margin-top: .15rem;
        }

        .seccion-label {
            max-width: 1000px;
            margin: 2rem auto .75rem;
            padding: 0 1.5rem;
            font-size: .72rem;
            font-weight: 600;
            letter-spacing: 1.8px;
            text-transform: uppercase;
            color: var(--muted);
        }

        .main-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
            max-width: 1000px;
            margin: 0 auto;
            padding: 0 1.5rem;
        }
        .main-grid.three-col {
            grid-template-columns: 1fr 1fr 1fr;
        }
        .main-grid:last-of-type {
            margin-bottom: 3rem;
        }

        .modulo-card {
            background: var(--card);
            border-radius: 16px;
            box-shadow: 0 4px 24px rgba(0,0,0,.07);
            padding: 2rem 1.75rem;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
            border: 1.5px solid var(--border);
            transition: box-shadow .2s, border-color .2s, transform .2s;
            text-decoration: none;
            color: var(--text);
        }
        .modulo-card:hover {
            box-shadow: 0 8px 32px rgba(26,86,219,.13);
            border-color: #93c5fd;
            transform: translateY(-3px);
            color: var(--text);
        }
        .modulo-icono {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.6rem;
        }

        .eventos-grid .modulo-card:nth-child(1) .modulo-icono { background: #eff6ff; }
        .eventos-grid .modulo-card:nth-child(2) .modulo-icono { background: #fefce8; }
        .eventos-grid .modulo-card:nth-child(3) .modulo-icono { background: #fdf4ff; }

        .inv-grid .modulo-card:nth-child(1) .modulo-icono { background: #f0fdf4; }
        .inv-grid .modulo-card:nth-child(2) .modulo-icono { background: #eff6ff; }

        .usuarios-grid .modulo-card:nth-child(1) .modulo-icono { background: #fff7ed; }
        .usuarios-grid .modulo-card:nth-child(2) .modulo-icono { background: #fdf4ff; }
        .usuarios-grid .modulo-card:nth-child(3) .modulo-icono { background: #f0fdf4; }

        .modulo-titulo {
            font-family: 'DM Serif Display', serif;
            font-size: 1.2rem;
            font-weight: 400;
            color: var(--text);
            margin: 0;
        }
        .modulo-desc {
            font-size: .85rem;
            color: var(--muted);
            margin: 0;
            line-height: 1.5;
        }
        .modulo-arrow {
            margin-top: auto;
            font-size: .82rem;
            font-weight: 600;
            color: var(--azul);
            display: flex;
            align-items: center;
            gap: .3rem;
        }

        @media (max-width: 850px) {
            .stats-bar { flex-wrap: wrap; }
            .main-grid, .main-grid.three-col { grid-template-columns: 1fr 1fr; }
        }
        @media (max-width: 600px) {
            .main-grid, .main-grid.three-col { grid-template-columns: 1fr; }
            .hero h1 { font-size: 1.8rem; }
            .stats-bar { flex-direction: column; }
        }
    </style>
</head>
<body>

<nav class="navbar-cix">
    <div class="navbar-brand-cix">
        <img src="../../assets/content/logotype.png" alt="CIX Logo">
        <div>
            <span>CIX Eventos</span>
            <small>Admin</small>
        </div>
    </div>
    <a href="../../controllers/logout.php" class="btn-logout">Cerrar Sesión</a>
</nav>

<div class="hero">
    <h1><?php echo $saludo; ?>, <span><?php echo ucwords(strtolower($nombreUsuario)); ?></span></h1>
    <p>Administra eventos, inventario y usuarios.</p>
</div>

<div class="stats-bar" id="stats-bar">
    <div class="stat-card">
        <div class="stat-icono">📋</div>
        <div>
            <div class="stat-num" id="stat-eventos">--</div>
            <div class="stat-label">Eventos activos</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icono">📦</div>
        <div>
            <div class="stat-num" id="stat-articulos">--</div>
            <div class="stat-label">Artículos en stock</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icono">👥</div>
        <div>
            <div class="stat-num" id="stat-usuarios">--</div>
            <div class="stat-label">Usuarios registrados</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icono">⏳</div>
        <div>
            <div class="stat-num" id="stat-pendientes">--</div>
            <div class="stat-label">Eventos pendientes</div>
        </div>
    </div>
</div>

<div class="seccion-label">Eventos</div>
<div class="main-grid three-col eventos-grid">

    <a href="mod/revisar_eventos.php" class="modulo-card">
        <div class="modulo-icono">📋</div>
        <div>
            <p class="modulo-titulo">Revisar Eventos</p>
            <p class="modulo-desc">Consulta los eventos activos registrados por los clientes y su estado actual.</p>
        </div>
        <span class="modulo-arrow">Ir al módulo →</span>
    </a>

    <a href="mod/eventos_pasados.php" class="modulo-card">
        <div class="modulo-icono">📅</div>
        <div>
            <p class="modulo-titulo">Eventos Pasados</p>
            <p class="modulo-desc">Historial completo de eventos ya realizados y cerrados.</p>
        </div>
        <span class="modulo-arrow">Ir al módulo →</span>
    </a>

    <a href="mod/calendario.php" class="modulo-card">
        <div class="modulo-icono">🗓️</div>
        <div>
            <p class="modulo-titulo">Calendario</p>
            <p class="modulo-desc">Visualiza todos los eventos y asignaciones en un calendario interactivo.</p>
        </div>
        <span class="modulo-arrow">Ir al módulo →</span>
    </a>

</div>

<div class="seccion-label">Inventario</div>
<div class="main-grid inv-grid">

    <a href="../INV/mod/registrar_inv.php" class="modulo-card"" class="modulo-card">
        <div class="modulo-icono">➕</div>
        <div>
            <p class="modulo-titulo">Registrar Inventario</p>
            <p class="modulo-desc">Agrega nuevos artículos o actualiza las existencias del inventario.</p>
        </div>
        <span class="modulo-arrow">Ir al módulo →</span>
    </a>

    <a href="../INV/mod/inv_general.php" class="modulo-card"" class="modulo-card">
        <div class="modulo-icono">📦</div>
        <div>
            <p class="modulo-titulo">Inventario General</p>
            <p class="modulo-desc">Vista completa de todo el mobiliario disponible, en uso y en reparación.</p>
        </div>
        <span class="modulo-arrow">Ir al módulo →</span>
    </a>

</div>

<div class="seccion-label">Usuarios y Asignaciones</div>
<div class="main-grid three-col usuarios-grid">

    <a href="mod/registrar_usuario.php" class="modulo-card">
        <div class="modulo-icono">➕👤</div>
        <div>
            <p class="modulo-titulo">Registrar Usuario</p>
            <p class="modulo-desc">Crea nuevos usuarios y asígnales un rol desde el panel de administrador.</p>
        </div>
        <span class="modulo-arrow">Ir al módulo →</span>
    </a>

    <a href="mod/gestionar_usuarios.php" class="modulo-card">
        <div class="modulo-icono">👥</div>
        <div>
            <p class="modulo-titulo">Gestionar Usuarios</p>
            <p class="modulo-desc">Consulta, edita el rol y elimina usuarios clasificados por tipo.</p>
        </div>
        <span class="modulo-arrow">Ir al módulo →</span>
    </a>

    <a href="mod/asignar_tareas.php" class="modulo-card">
        <div class="modulo-icono">🔧</div>
        <div>
            <p class="modulo-titulo">Asignar Tareas</p>
            <p class="modulo-desc">Asigna trabajadores a eventos y gestiona el estado de cada asignación.</p>
        </div>
        <span class="modulo-arrow">Ir al módulo →</span>
    </a>

</div>

<script>
fetch('../../controllers/get_stats_admin.php')
    .then(r => r.json())
    .then(data => {
        document.getElementById('stat-eventos').textContent   = data.eventos_activos  ?? '--';
        document.getElementById('stat-articulos').textContent = data.articulos_stock  ?? '--';
        document.getElementById('stat-usuarios').textContent  = data.usuarios_total   ?? '--';
        document.getElementById('stat-pendientes').textContent = data.eventos_pendientes ?? '--';
    })
    .catch(() => {}); 
</script>

</body>
</html>