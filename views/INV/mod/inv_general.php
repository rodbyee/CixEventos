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

        .articulo-item { display: flex; align-items: center; justify-content: space-between; padding: 1rem 1.1rem; border: 1.5px solid var(--border); border-radius: 12px; margin-bottom: .75rem; transition: box-shadow .2s, border-color .2s; gap: 1rem; }
        .articulo-item:hover { box-shadow: 0 4px 16px rgba(26,86,219,.08); border-color: #93c5fd; }
        .articulo-item:last-child { margin-bottom: 0; }

        .art-icono { width: 48px; height: 48px; border-radius: 12px; background: #eff6ff; display: flex; align-items: center; justify-content: center; font-size: 1.4rem; flex-shrink: 0; }
        .art-info { flex: 1; min-width: 0; }
        .art-nombre { font-weight: 600; font-size: .95rem; color: var(--text); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .art-desc { font-size: .78rem; color: var(--muted); margin-top: .1rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .art-precio { font-size: .78rem; color: var(--azul); font-weight: 600; margin-top: .2rem; }

        .art-stock-wrap { display: flex; flex-direction: column; align-items: flex-end; gap: .4rem; flex-shrink: 0; }
        .art-stock { text-align: right; }
        .stock-num { font-family: 'DM Serif Display', serif; font-size: 1.8rem; line-height: 1; color: var(--text); }
        .stock-num.bajo { color: #dc2626; }
        .stock-label { font-size: .7rem; color: var(--muted); display: block; }
        .stock-bajo-tag { font-size: .65rem; font-weight: 600; color: #dc2626; display: block; }

        .stock-danado-badge { background: #fef2f2; color: #dc2626; border: 1px solid #fca5a5; border-radius: 8px; padding: .2rem .55rem; font-size: .72rem; font-weight: 600; cursor: pointer; transition: background .2s; }
        .stock-danado-badge:hover { background: #fee2e2; }

        .btn-editar-art { background: #f5f3ff; color: #7c3aed; border: 1.5px solid #c4b5fd; border-radius: 8px; padding: .35rem .8rem; font-size: .78rem; font-weight: 600; cursor: pointer; transition: background .2s; white-space: nowrap; flex-shrink: 0; }
        .btn-editar-art:hover { background: #ede9fe; border-color: #7c3aed; }

        .sin-items { text-align: center; padding: 3rem 1rem; color: var(--muted); }
        .sin-items .icono { font-size: 2.5rem; margin-bottom: .75rem; }

        .modal-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,.45); display: flex; justify-content: center; align-items: center; z-index: 1000; }
        .modal-box { background: #fff; border-radius: 16px; padding: 2rem; width: 90%; max-width: 480px; box-shadow: 0 8px 40px rgba(0,0,0,.15); }
        .modal-box h3 { font-family: 'DM Serif Display', serif; font-size: 1.3rem; font-weight: 400; margin-bottom: 1.25rem; }
        .form-label-cix { font-size: .72rem; font-weight: 600; letter-spacing: 1px; text-transform: uppercase; color: var(--muted); margin-bottom: .35rem; display: block; }
        .form-control-cix { border: 1.5px solid var(--border); border-radius: 10px; padding: .6rem .9rem; font-size: .9rem; font-family: 'DM Sans', sans-serif; width: 100%; outline: none; transition: border-color .2s, box-shadow .2s; background: #fafbff; color: var(--text); }
        .form-control-cix:focus { border-color: var(--azul); box-shadow: 0 0 0 3px rgba(26,86,219,.1); background: #fff; }
        textarea.form-control-cix { resize: vertical; min-height: 75px; }
        .form-group { margin-bottom: 1rem; }
        .form-row-modal { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
        .modal-actions { display: flex; justify-content: space-between; align-items: center; margin-top: 1.5rem; }
        .btn-guardar { background: var(--azul); color: #fff; border: none; border-radius: 10px; padding: .55rem 1.3rem; font-size: .9rem; font-weight: 600; cursor: pointer; font-family: 'DM Sans', sans-serif; transition: background .2s; }
        .btn-guardar:hover { background: var(--azul-dark); }
        .btn-cancelar { background: #f3f4f6; color: var(--muted); border: none; border-radius: 10px; padding: .55rem 1.1rem; font-size: .9rem; font-weight: 500; cursor: pointer; font-family: 'DM Sans', sans-serif; transition: background .2s; margin-right: .5rem; }
        .btn-cancelar:hover { background: #e5e7eb; }
        .btn-eliminar { background: #fee2e2; color: #dc2626; border: none; border-radius: 10px; padding: .55rem 1.1rem; font-size: .9rem; font-weight: 600; cursor: pointer; font-family: 'DM Sans', sans-serif; transition: background .2s; }
        .btn-eliminar:hover { background: #fca5a5; }

        @media (max-width: 600px) {
            .hero h1 { font-size: 1.7rem; }
            .form-row-modal { grid-template-columns: 1fr; }
            .articulo-item { flex-wrap: wrap; }
        }
    </style>
</head>
<body>

<nav class="navbar-cix">
    <div class="navbar-brand-cix">
        <img src="../../../assets/content/logotype.png" alt="CIX Logo">
        <div><span>CIX Eventos</span><small><?php echo $_SESSION['rol'] == 1 ? 'Admin' : ($_SESSION['rol'] == 2 ? 'Encargado Inventario' : 'Empleado'); ?></small></div>
    </div>
    <div class="navbar-nav-cix">
       <a href="<?php $rol = $_SESSION['rol']; 
       if ($rol == 1)      echo '/CixEventos/views/ADMIN/admin.php';
       elseif ($rol == 2)  echo '/CixEventos/views/INV/inventario.php';
       else                echo '/CixEventos/views/WORKER/worker.php'; ?>" class="btn-back">← Regresar</a>
        <a href="../../../controllers/logout.php" class="btn-logout">Cerrar Sesión</a>
    </div>
</nav>

<div class="hero">
    <h1>📦 Inventario General</h1>
    <p>Consulta, busca y edita todos los artículos registrados.</p>
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

<!-- MODAL EDITAR -->
<div id="modal-editar" class="modal-overlay" style="display:none;">
    <div class="modal-box">
        <h3>✏️ Editar Artículo</h3>
        <form id="form-editar">
            <input type="hidden" id="edit-id">
            <div class="form-group">
                <label class="form-label-cix">Nombre del Artículo</label>
                <input type="text" id="edit-nombre" class="form-control-cix" required>
            </div>
            <div class="form-group">
                <label class="form-label-cix">Descripción</label>
                <textarea id="edit-descripcion" class="form-control-cix"></textarea>
            </div>
            <div class="form-row-modal">
                <div class="form-group">
                    <label class="form-label-cix">Stock Total</label>
                    <input type="number" id="edit-stock" class="form-control-cix" min="0" required>
                </div>
                <div class="form-group">
                    <label class="form-label-cix">Precio de Renta</label>
                    <input type="number" id="edit-precio" class="form-control-cix" min="0" step="0.01" required>
                </div>
            </div>
            <div class="form-group" style="margin-top:.5rem;">
                <label class="form-label-cix">Imagen del Artículo</label>
                <div id="edit-img-preview" style="margin-bottom:.6rem;display:none;">
                    <img id="edit-img-actual" src="" alt="Imagen actual" style="width:100%;max-height:140px;object-fit:cover;border-radius:10px;border:1.5px solid var(--border);">
                    <p style="font-size:.72rem;color:var(--muted);margin-top:.3rem;">Imagen actual</p>
                </div>
                <input type="file" id="edit-imagen" class="form-control-cix" accept="image/png, image/jpeg, image/webp" onchange="previewNuevaImagen(this)">
                <small style="color:var(--muted);font-size:.75rem;">Opcional · Solo si deseas cambiarla</small>
    
                <img id="edit-img-nueva" src="" alt="" style="display:none;width:100%;max-height:140px;object-fit:cover;border-radius:10px;margin-top:.5rem;border:1.5px solid #93c5fd;">
            </div>
            <div class="modal-actions">
                <button type="button" class="btn-eliminar" onclick="eliminarArticulo()">🗑 Eliminar</button>
                <div>
                    <button type="button" class="btn-cancelar" onclick="cerrarModal()">Cancelar</button>
                    <button type="button" class="btn-guardar" onclick="guardarCambios()">Guardar Cambios</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- MODAL VENTA DAÑADO -->
<div id="modal-venta" class="modal-overlay" style="display:none;">
    <div class="modal-box">
        <h3>💰 Vender Artículo Dañado</h3>
        <p style="font-size:.85rem;color:var(--muted);margin-bottom:1.25rem;" id="venta-subtitulo"></p>
        <div id="msg-venta"></div>
        <div class="form-group">
            <label class="form-label-cix">Cantidad a vender</label>
            <input type="number" id="venta-cantidad" class="form-control-cix" min="1" value="1">
            <p style="font-size:.75rem;color:var(--muted);margin-top:.3rem;" id="venta-max"></p>
        </div>
        <div class="modal-actions">
            <button type="button" class="btn-eliminar" onclick="cerrarModalVenta()">Cancelar</button>
            <div>
                <button type="button" class="btn-guardar" onclick="confirmarVenta()">Confirmar Venta</button>
            </div>
        </div>
    </div>
</div>

<script>
let todosLosArticulos = [];
let artVenta = null;

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
    const lista = document.getElementById('lista-articulos');
    const contador = document.getElementById('contador');

    if (!articulos.length) {
        lista.innerHTML = `<div class="sin-items"><div class="icono">📦</div><p>No hay artículos registrados.</p></div>`;
        contador.textContent = '';
        return;
    }

    contador.textContent = `· ${articulos.length} ${articulos.length === 1 ? 'artículo' : 'artículos'}`;

    lista.innerHTML = articulos.map(art => {
        const stockBajo = art.stock_total <= 10;
        const danado = parseInt(art.stock_danado) > 0;
        const artJson = JSON.stringify(art).replace(/'/g, "&apos;");

        return `
        <div class="articulo-item">
            <div class="art-icono">📋</div>
            <div class="art-info">
                <div class="art-nombre">${art.nombre_item}</div>
                <div class="art-desc">${art.descripcion || '—'}</div>
                <div class="art-precio">$${parseFloat(art.precio_renta).toFixed(2)} / renta</div>
            </div>
            <div class="art-stock-wrap">
                <div class="art-stock">
                    <span class="stock-num ${stockBajo ? 'bajo' : ''}">${art.stock_total}</span>
                    <span class="stock-label">disponibles</span>
                    ${stockBajo ? '<span class="stock-bajo-tag">⚠ Stock Bajo</span>' : ''}
                </div>
                ${danado ? `
                <button class="stock-danado-badge" onclick='abrirVenta(this)' data-art='${artJson}'>
                    ⚠️ ${art.stock_danado} dañado(s) — Vender
                </button>` : ''}
            </div>
            <button class="btn-editar-art" onclick='abrirEditar(this)' data-art='${artJson}'>✏️ Editar</button>
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

function abrirEditar(btn) {
    const art = JSON.parse(btn.getAttribute('data-art'));
    document.getElementById('edit-id').value          = art.id_item;
    document.getElementById('edit-nombre').value      = art.nombre_item;
    document.getElementById('edit-descripcion').value = art.descripcion || '';
    document.getElementById('edit-stock').value       = art.stock_total;
    document.getElementById('edit-precio').value      = art.precio_renta;

    // Imagen actual
    const preview = document.getElementById('edit-img-preview');
    const imgActual = document.getElementById('edit-img-actual');
    const imgNueva = document.getElementById('edit-img-nueva');
    document.getElementById('edit-imagen').value = '';
    imgNueva.style.display = 'none';

    if (art.imagen) {
        imgActual.src = `/CixEventos/assets/content/mobiliario/${art.imagen}`;
        preview.style.display = 'block';
    } else {
        preview.style.display = 'none';
    }

    document.getElementById('modal-editar').style.display = 'flex';
}
function cerrarModal() {
    document.getElementById('modal-editar').style.display = 'none';
}
function previewNuevaImagen(input) {
    const img = document.getElementById('edit-img-nueva');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => { img.src = e.target.result; img.style.display = 'block'; };
        reader.readAsDataURL(input.files[0]);
    } else {
        img.style.display = 'none';
    }
}

function guardarCambios() {
    const formData = new FormData();
    formData.append('id_item',      document.getElementById('edit-id').value);
    formData.append('nombre_item',  document.getElementById('edit-nombre').value);
    formData.append('descripcion',  document.getElementById('edit-descripcion').value);
    formData.append('stock_total',  document.getElementById('edit-stock').value);
    formData.append('precio_renta', document.getElementById('edit-precio').value);

    const imgFile = document.getElementById('edit-imagen').files[0];
    if (imgFile) formData.append('imagen', imgFile);

    fetch('/CixEventos/controllers/actualizar_articulo.php', {
        method: 'POST',
        body: formData
    })
    .then(r => r.json())
    .then(res => {
        if (res.ok) {
            cerrarModal();
            cargarArticulos();
        } else {
            alert('Error: ' + res.msg);
        }
    })
    .catch(err => alert('Error de conexión: ' + err));
}

function eliminarArticulo() {
    const id = document.getElementById('edit-id').value;
    if (confirm('¿Seguro que quieres eliminar este artículo? Esta acción no se puede deshacer.')) {
        fetch(`/CixEventos/controllers/eliminar_articulo.php?id=${id}`)
        .then(r => r.json())
        .then(res => { if (res.ok) { cerrarModal(); cargarArticulos(); } });
    }
}

// ── VENTA DAÑADO ────────────────────────────────────
function abrirVenta(btn) {
    artVenta = JSON.parse(btn.getAttribute('data-art'));
    document.getElementById('venta-subtitulo').textContent =
        `${artVenta.nombre_item} · ${artVenta.stock_danado} unidad(es) dañada(s) disponibles`;
    document.getElementById('venta-cantidad').value = 1;
    document.getElementById('venta-cantidad').max   = artVenta.stock_danado;
    document.getElementById('venta-max').textContent = `Máximo: ${artVenta.stock_danado}`;
    document.getElementById('msg-venta').innerHTML  = '';
    document.getElementById('modal-venta').style.display = 'flex';
}

function cerrarModalVenta() {
    document.getElementById('modal-venta').style.display = 'none';
    artVenta = null;
}

function confirmarVenta() {
    const cantidad = parseInt(document.getElementById('venta-cantidad').value);
    if (!artVenta || cantidad <= 0) return;

    const formData = new FormData();
    formData.append('id_item',  artVenta.id_item);
    formData.append('cantidad', cantidad);

    fetch('/CixEventos/controllers/vender_danado.php', {
        method: 'POST',
        body: formData
    })
    .then(r => r.json())
    .then(res => {
        if (res.ok) {
            cerrarModalVenta();
            cargarArticulos();
        } else {
            document.getElementById('msg-venta').innerHTML =
                `<div style="background:#fee2e2;color:#dc2626;padding:.6rem;border-radius:8px;font-size:.85rem;margin-bottom:.75rem;">
                    ❌ ${res.msg}
                </div>`;
        }
    });
}

cargarArticulos();
</script>

</body>
</html>