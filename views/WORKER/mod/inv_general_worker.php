<?php
session_start();
$nombreUsuario = $_SESSION['nombre'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventario General | CIX Eventos</title>
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

        .contenido { max-width: 900px; margin: -2rem auto 3rem; padding: 0 1.5rem; }

        .panel { background: var(--card); border-radius: 16px; box-shadow: 0 4px 24px rgba(0,0,0,.07); overflow: hidden; }
        .panel-header { padding: 1.25rem 1.5rem; border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; gap: 1rem; flex-wrap: wrap; }
        .panel-header h2 { font-family: 'DM Serif Display', serif; font-size: 1.25rem; font-weight: 400; color: var(--text); margin: 0; }
        .panel-body { padding: 1.5rem; }

        .buscador-wrap { position: relative; max-width: 320px; width: 100%; }
        .buscador-wrap span { position: absolute; left: .75rem; top: 50%; transform: translateY(-50%); font-size: .95rem; pointer-events: none; }
        .buscador { border: 1.5px solid var(--border); border-radius: 10px; padding: .5rem .9rem .5rem 2.2rem; font-size: .88rem; font-family: 'DM Sans', sans-serif; width: 100%; outline: none; background: #fafbff; transition: border-color .2s, box-shadow .2s; }
        .buscador:focus { border-color: var(--azul); box-shadow: 0 0 0 3px rgba(26,86,219,.1); }

        .articulo-item { display: flex; align-items: center; padding: 1rem 1.1rem; border: 1.5px solid var(--border); border-radius: 12px; margin-bottom: .75rem; transition: box-shadow .2s, border-color .2s; gap: 1rem; }
        .articulo-item:hover { box-shadow: 0 4px 16px rgba(26,86,219,.08); border-color: #93c5fd; }
        .articulo-item:last-child { margin-bottom: 0; }

        .art-icono { width: 48px; height: 48px; border-radius: 12px; background: #eff6ff; display: flex; align-items: center; justify-content: center; font-size: 1.4rem; flex-shrink: 0; }
        .art-info { flex: 1; min-width: 0; }
        .art-nombre { font-weight: 600; font-size: .95rem; color: var(--text); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .art-desc { font-size: .78rem; color: var(--muted); margin-top: .1rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .art-precio { font-size: .78rem; color: var(--azul); font-weight: 600; margin-top: .2rem; }

        .art-stocks { display: flex; flex-direction: column; align-items: flex-end; gap: .4rem; flex-shrink: 0; }

        .art-stock { text-align: right; }
        .stock-num { font-family: 'DM Serif Display', serif; font-size: 1.8rem; line-height: 1; color: var(--text); }
        .stock-num.bajo { color: #dc2626; }
        .stock-label { font-size: .7rem; color: var(--muted); display: block; }
        .stock-bajo-tag { font-size: .65rem; font-weight: 600; color: #dc2626; display: block; }

        .stock-danado-info { background: #fef2f2; color: #dc2626; border: 1px solid #fca5a5; border-radius: 8px; padding: .2rem .55rem; font-size: .72rem; font-weight: 600; }

        .badge-readonly { background: #f0fdf4; color: #16a34a; border: 1px solid #bbf7d0; border-radius: 8px; padding: .25rem .65rem; font-size: .7rem; font-weight: 600; letter-spacing: .5px; text-transform: uppercase; flex-shrink: 0; user-select: none; }

        .sin-items { text-align: center; padding: 3rem 1rem; color: var(--muted); }
        .sin-items .icono { font-size: 2.5rem; margin-bottom: .75rem; }

        @media (max-width: 600px) {
            .hero h1 { font-size: 1.7rem; }
            .articulo-item { flex-wrap: wrap; }
        }
    </style>
</head>
<body>

<nav class="navbar-cix">
    <div class="navbar-brand-cix">
        <img src="../../../assets/content/logotype.png" alt="CIX Logo">
        <div>
            <span>CIX Eventos</span>
            <small>Empleado</small>
        </div>
    </div>
    <div class="navbar-nav-cix">
        <a href="/CixEventos/views/WORKER/worker.php" class="btn-back">← Regresar</a>
        <a href="../../../controllers/logout.php" class="btn-logout">Cerrar Sesión</a>
    </div>
</nav>

<div class="hero">
    <h1>📦 Inventario General</h1>
    <p>Consulta el stock disponible de todos los artículos.</p>
</div>

<div class="contenido">
    <div class="panel">
        <div class="panel-header">
            <h2>Artículos <span id="contador" style="font-size:.85rem;color:var(--muted);font-family:'DM Sans',sans-serif;"></span></h2>
            <div class="buscador-wrap">
                <span>🔍</span>
                <input type="text" class="buscador" id="buscador"
                       placeholder="Buscar artículo..." oninput="filtrarArticulos()">
            </div>
        </div>
        <div class="panel-body">
            <div id="lista-articulos">
                <div class="sin-items">
                    <div class="icono">📦</div>
                    <p>Cargando inventario...</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
let todosLosArticulos = [];

function cargarArticulos() {
    fetch('/CixEventos/controllers/get_inventario.php')
        .then(r => r.json())
        .then(data => {
            todosLosArticulos = data;
            renderArticulos(data);
        })
        .catch(() => {
            document.getElementById('lista-articulos').innerHTML =
                `<div class="sin-items"><div class="icono">⚠️</div><p>Error al cargar el inventario.</p></div>`;
        });
}

function renderArticulos(articulos) {
    const lista    = document.getElementById('lista-articulos');
    const contador = document.getElementById('contador');

    if (!articulos.length) {
        lista.innerHTML = `<div class="sin-items"><div class="icono">📦</div><p>No hay artículos registrados.</p></div>`;
        contador.textContent = '';
        return;
    }

    contador.textContent = `· ${articulos.length} ${articulos.length === 1 ? 'artículo' : 'artículos'}`;

    lista.innerHTML = articulos.map(art => {
        const stockBajo = art.stock_total <= 10;
        const danado    = parseInt(art.stock_danado) > 0;

        return `
        <div class="articulo-item">
            <div class="art-icono">📋</div>
            <div class="art-info">
                <div class="art-nombre">${art.nombre_item}</div>
                <div class="art-desc">${art.descripcion || '—'}</div>
                <div class="art-precio">$${parseFloat(art.precio_renta).toFixed(2)} / renta</div>
            </div>
            <div class="art-stocks">
                <div class="art-stock">
                    <span class="stock-num ${stockBajo ? 'bajo' : ''}">${art.stock_total}</span>
                    <span class="stock-label">disponibles</span>
                    ${stockBajo ? '<span class="stock-bajo-tag">⚠ Stock Bajo</span>' : ''}
                </div>
                ${danado ? `<span class="stock-danado-info">⚠️ ${art.stock_danado} dañado(s)</span>` : ''}
            </div>
            <span class="badge-readonly">✓ Solo lectura</span>
        </div>`;
    }).join('');
}

function filtrarArticulos() {
    const q = document.getElementById('buscador').value.toLowerCase();
    const filtrados = todosLosArticulos.filter(a =>
        a.nombre_item.toLowerCase().includes(q) ||
        (a.descripcion && a.descripcion.toLowerCase().includes(q))
    );
    renderArticulos(filtrados);
}

cargarArticulos();
</script>

</body>
</html>