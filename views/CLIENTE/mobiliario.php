<?php
session_start();
$id_evento = $_GET['id_evento'] ?? null;
if (!$id_evento) { header('Location: index.php'); exit; }

$nombreUsuario = $_SESSION['nombre'] ?? 'Cliente';
$genero = $_SESSION['genero'] ?? 'Hombre';
$saludo = ($genero == "Mujer") ? "Bienvenida" : "Bienvenido";
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Catálogo de Mobiliario | CIX Eventos</title>
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
    --gold:      #f59e0b;
    --gold-dark: #d97706;
}
* { margin:0; padding:0; box-sizing:border-box; }
body { font-family:'DM Sans',sans-serif; background:var(--bg); color:var(--text); min-height:100vh; }

/* NAVBAR */
.navbar-cix {
    background:var(--azul);
    padding:.75rem 2rem;
    display:flex; align-items:center; justify-content:space-between;
    box-shadow:0 2px 12px rgba(26,86,219,.18);
}
.navbar-brand-cix { display:flex; align-items:center; gap:10px; }
.navbar-brand-cix img { height:42px; border-radius:50%; box-shadow:0 0 0 2px rgba(255,255,255,.35); }
.navbar-brand-cix span { color:#fff; font-family:'DM Serif Display',serif; font-size:1.2rem; }
.navbar-brand-cix small { display:block; color:rgba(255,255,255,.65); font-size:.68rem; font-weight:300; letter-spacing:1.5px; text-transform:uppercase; }
.btn-back {
    background:rgba(255,255,255,.15); border:1.5px solid rgba(255,255,255,.4);
    color:#fff; border-radius:8px; padding:.4rem 1rem; font-size:.85rem; font-weight:500;
    text-decoration:none; transition:all .2s;
}
.btn-back:hover { background:rgba(255,255,255,.25); color:#fff; }

/* HERO */
.hero {
    background:linear-gradient(135deg,var(--azul) 0%,#3b82f6 100%);
    color:#fff; padding:2rem 2rem 3rem;
}
.hero h1 { font-family:'DM Serif Display',serif; font-size:2rem; font-weight:400; margin-bottom:.2rem; }
.hero p { opacity:.75; font-size:.9rem; }
.evento-pill {
    display:inline-block; background:rgba(255,255,255,.2); border:1px solid rgba(255,255,255,.35);
    border-radius:999px; padding:.3rem .9rem; font-size:.8rem; margin-top:.6rem;
}

/* LAYOUT */
.page-wrap {
    max-width:1280px; margin:-1.5rem auto 3rem;
    padding:0 1.5rem;
    display:grid; grid-template-columns:1fr 360px; gap:1.5rem;
}

/* CATÁLOGO */
.catalog-panel {
    background:var(--card); border-radius:16px;
    box-shadow:0 4px 24px rgba(0,0,0,.07); overflow:hidden;
}
.catalog-header {
    padding:1.25rem 1.5rem; border-bottom:1px solid var(--border);
    display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:.5rem;
}
.catalog-header h2 { font-family:'DM Serif Display',serif; font-size:1.3rem; font-weight:400; }
.search-box {
    border:1.5px solid var(--border); border-radius:10px;
    padding:.45rem .9rem; font-size:.875rem; font-family:'DM Sans',sans-serif;
    width:220px; outline:none; transition:border-color .2s;
}
.search-box:focus { border-color:var(--azul); }

.catalog-grid {
    display:grid; grid-template-columns:repeat(auto-fill,minmax(200px,1fr));
    gap:1.25rem; padding:1.5rem;
}

/* TARJETA PRODUCTO */
.product-card {
    border:1.5px solid var(--border); border-radius:14px;
    overflow:hidden; transition:box-shadow .2s,border-color .2s,transform .2s;
    cursor:default; background:#fff; position:relative;
}
.product-card:hover {
    box-shadow:0 8px 28px rgba(26,86,219,.13);
    border-color:#93c5fd; transform:translateY(-3px);
}
.product-img-wrap {
    height:160px; background:linear-gradient(135deg,#eff6ff,#dbeafe);
    display:flex; align-items:center; justify-content:center;
    position:relative; overflow:hidden;
}
.product-img-wrap img {
    width:100%; height:100%; object-fit:cover;
    transition:transform .3s;
}
.product-card:hover .product-img-wrap img { transform:scale(1.05); }
.product-img-placeholder {
    font-size:3.5rem; opacity:.4; user-select:none;
}
.stock-badge {
    position:absolute; top:8px; right:8px;
    background:rgba(255,255,255,.9); border:1px solid var(--border);
    border-radius:999px; font-size:.68rem; font-weight:600;
    padding:.18rem .55rem; color:var(--muted);
}
.stock-badge.low { background:#fef3c7; border-color:#fcd34d; color:#92400e; }
.stock-badge.out { background:#fee2e2; border-color:#fca5a5; color:#991b1b; }

.product-info { padding:.9rem 1rem 1rem; }
.product-name { font-weight:600; font-size:.92rem; margin-bottom:.2rem; }
.product-desc { font-size:.75rem; color:var(--muted); margin-bottom:.6rem; line-height:1.5; min-height:2.2em; }
.product-price {
    font-family:'DM Serif Display',serif; font-size:1.15rem;
    color:var(--azul); margin-bottom:.75rem;
}
.product-price small { font-family:'DM Sans',sans-serif; font-size:.7rem; color:var(--muted); font-weight:400; }

.qty-row { display:flex; align-items:center; gap:.5rem; margin-bottom:.65rem; }
.qty-btn {
    width:28px; height:28px; border-radius:8px; border:1.5px solid var(--border);
    background:#fff; color:var(--text); font-size:1rem; font-weight:600;
    display:flex; align-items:center; justify-content:center; cursor:pointer;
    transition:background .15s,border-color .15s;
}
.qty-btn:hover { background:#eff6ff; border-color:var(--azul); color:var(--azul); }
.qty-input {
    width:44px; text-align:center; border:1.5px solid var(--border);
    border-radius:8px; padding:.25rem; font-size:.9rem; outline:none;
    font-family:'DM Sans',sans-serif;
}
.qty-label { font-size:.72rem; color:var(--muted); }

.btn-agregar {
    width:100%; background:var(--azul); color:#fff; border:none;
    border-radius:10px; padding:.5rem; font-size:.85rem; font-weight:600;
    font-family:'DM Sans',sans-serif; cursor:pointer; transition:background .2s,transform .15s;
}
.btn-agregar:hover { background:var(--azul-dark); transform:translateY(-1px); }
.btn-agregar:disabled { background:#93c5fd; cursor:not-allowed; transform:none; }
.btn-agregar.en-carrito { background:#16a34a; }
.btn-agregar.en-carrito:hover { background:#15803d; }

/* PANEL CARRITO / PAGO */
.side-panel { display:flex; flex-direction:column; gap:1.5rem; }

.cart-panel, .pay-panel {
    background:var(--card); border-radius:16px;
    box-shadow:0 4px 24px rgba(0,0,0,.07); overflow:hidden;
}
.panel-hdr {
    padding:1rem 1.25rem; border-bottom:1px solid var(--border);
    font-family:'DM Serif Display',serif; font-size:1.1rem; font-weight:400;
    display:flex; align-items:center; justify-content:space-between;
}
.cart-count {
    background:var(--azul); color:#fff;
    font-family:'DM Sans',sans-serif; font-size:.72rem; font-weight:700;
    padding:.15rem .5rem; border-radius:999px;
}
.cart-body { padding:1rem 1.25rem; }

.cart-item {
    display:flex; justify-content:space-between; align-items:center;
    padding:.55rem 0; border-bottom:1px solid var(--border); font-size:.85rem;
}
.cart-item:last-child { border-bottom:none; }
.cart-item-name { font-weight:500; flex:1; }
.cart-item-qty { color:var(--muted); font-size:.78rem; margin:0 .5rem; }
.cart-item-price { font-weight:600; color:var(--azul); white-space:nowrap; }
.cart-item-del {
    background:none; border:none; color:#ef4444; font-size:.95rem;
    cursor:pointer; padding:0 0 0 .5rem; line-height:1;
}
.cart-empty { text-align:center; padding:2rem 1rem; color:var(--muted); font-size:.85rem; }
.cart-empty .ico { font-size:2rem; margin-bottom:.5rem; }

.cart-total {
    border-top:2px solid var(--border); margin-top:.75rem;
    padding-top:.75rem; font-weight:700; font-size:1rem;
    display:flex; justify-content:space-between; align-items:center;
}
.cart-total span { color:var(--azul); font-family:'DM Serif Display',serif; font-size:1.3rem; }

.timer-row {
    background:#fef3c7; border:1px solid #fcd34d; border-radius:10px;
    padding:.6rem .9rem; font-size:.8rem; color:#92400e;
    display:flex; align-items:center; gap:.5rem; margin-top:.75rem;
}
#timer-display { font-weight:700; font-variant-numeric:tabular-nums; }

/* FORMULARIO PAGO */
.pay-panel { display:none; }
.pay-panel.visible { display:block; }

.form-lbl {
    font-size:.7rem; font-weight:600; letter-spacing:1px;
    text-transform:uppercase; color:var(--muted); display:block; margin-bottom:.3rem;
}
.form-inp {
    border:1.5px solid var(--border); border-radius:10px;
    padding:.55rem .85rem; font-size:.9rem; font-family:'DM Sans',sans-serif;
    width:100%; outline:none; transition:border-color .2s,box-shadow .2s;
    background:#fafbff; color:var(--text);
}
.form-inp:focus { border-color:var(--azul); box-shadow:0 0 0 3px rgba(26,86,219,.1); background:#fff; }
.fg { margin-bottom:.9rem; }
.form-row2 { display:grid; grid-template-columns:1fr 1fr; gap:.75rem; }

.card-preview {
    background:linear-gradient(135deg,#1a56db,#3b82f6);
    border-radius:14px; padding:1.2rem 1.4rem; color:#fff;
    margin-bottom:1.1rem; position:relative; overflow:hidden;
    min-height:110px;
}
.card-preview::before {
    content:''; position:absolute; top:-20px; right:-20px;
    width:100px; height:100px; background:rgba(255,255,255,.08);
    border-radius:50%;
}
.card-preview::after {
    content:''; position:absolute; bottom:-30px; right:30px;
    width:140px; height:140px; background:rgba(255,255,255,.05);
    border-radius:50%;
}
.card-number-preview {
    font-size:1.05rem; letter-spacing:3px; font-weight:500;
    font-variant-numeric:tabular-nums; margin-bottom:.9rem; opacity:.95;
}
.card-meta { display:flex; justify-content:space-between; font-size:.72rem; opacity:.75; }
.card-meta strong { display:block; font-size:.82rem; font-weight:600; opacity:1; }

.chip { width:36px; height:28px; background:rgba(255,215,100,.6); border-radius:5px; margin-bottom:.75rem; }

.btn-pagar {
    width:100%; background:linear-gradient(135deg,#16a34a,#15803d);
    color:#fff; border:none; border-radius:12px; padding:.8rem;
    font-size:1rem; font-weight:700; font-family:'DM Sans',sans-serif;
    cursor:pointer; transition:opacity .2s,transform .15s;
    display:flex; align-items:center; justify-content:center; gap:.5rem;
}
.btn-pagar:hover { opacity:.9; transform:translateY(-1px); }
.btn-pagar:disabled { opacity:.5; cursor:not-allowed; transform:none; }

.btn-iniciar-pago {
    width:100%; background:var(--azul); color:#fff; border:none;
    border-radius:12px; padding:.75rem; font-size:.95rem; font-weight:700;
    font-family:'DM Sans',sans-serif; cursor:pointer; transition:background .2s;
    margin-top:.75rem;
}
.btn-iniciar-pago:hover { background:var(--azul-dark); }
.btn-iniciar-pago:disabled { background:#93c5fd; cursor:not-allowed; }

/* VOUCHER MODAL */
.modal-overlay {
    position:fixed; inset:0; background:rgba(0,0,0,.55);
    display:flex; align-items:center; justify-content:center;
    z-index:1000; padding:1rem;
}
.voucher-modal {
    background:#fff; border-radius:20px;
    width:100%; max-width:480px; overflow:hidden;
    box-shadow:0 20px 60px rgba(0,0,0,.25);
    animation:slideUp .35s cubic-bezier(.16,1,.3,1);
}
@keyframes slideUp { from{opacity:0;transform:translateY(30px)} to{opacity:1;transform:translateY(0)} }

.voucher-top {
    background:linear-gradient(135deg,var(--azul),#3b82f6);
    color:#fff; padding:2rem; text-align:center;
}
.voucher-check { font-size:3rem; margin-bottom:.5rem; }
.voucher-top h2 { font-family:'DM Serif Display',serif; font-size:1.6rem; font-weight:400; margin-bottom:.25rem; }
.voucher-top p { opacity:.75; font-size:.88rem; }

.voucher-body { padding:1.5rem 2rem; }
.voucher-ref {
    background:#f4f6fb; border-radius:10px; padding:.75rem 1rem;
    text-align:center; font-family:monospace; font-size:1.05rem;
    font-weight:700; color:var(--azul); letter-spacing:2px; margin-bottom:1.25rem;
}

.voucher-divider {
    border:none; border-top:2px dashed var(--border); margin:1.25rem 0;
}
.v-row { display:flex; justify-content:space-between; font-size:.85rem; padding:.3rem 0; }
.v-row .v-label { color:var(--muted); }
.v-row .v-val { font-weight:600; }
.v-total { font-size:1rem; font-weight:700; border-top:2px solid var(--border); padding-top:.75rem; margin-top:.25rem; }
.v-total .v-val { color:var(--azul); font-family:'DM Serif Display',serif; font-size:1.2rem; }

.voucher-items { margin:1rem 0; }
.voucher-items .vi { 
    display:flex; justify-content:space-between; font-size:.82rem;
    padding:.35rem 0; border-bottom:1px solid var(--border); color:var(--text);
}
.voucher-items .vi:last-child { border-bottom:none; }

.btn-cerrar-voucher {
    width:100%; background:var(--azul); color:#fff; border:none;
    border-radius:12px; padding:.75rem; font-size:.95rem; font-weight:700;
    font-family:'DM Sans',sans-serif; cursor:pointer; transition:background .2s;
}
.btn-cerrar-voucher:hover { background:var(--azul-dark); }

.security-note {
    display:flex; align-items:center; gap:.4rem;
    font-size:.72rem; color:var(--muted); margin-top:.6rem; justify-content:center;
}

/* ESTADOS */
.alert-cix { padding:.75rem 1rem; border-radius:10px; font-size:.88rem; margin-bottom:1rem; }
.alert-success { background:#dcfce7; color:#15803d; }
.alert-danger { background:#fee2e2; color:#dc2626; }

@media(max-width:900px) {
    .page-wrap { grid-template-columns:1fr; }
    .catalog-grid { grid-template-columns:repeat(auto-fill,minmax(160px,1fr)); }
}
</style>
</head>
<body>

<nav class="navbar-cix">
    <div class="navbar-brand-cix">
        <img src="../../assets/content/logotype.png" alt="CIX Logo">
        <div>
            <span>CIX Eventos</span>
            <small>Mobiliario</small>
        </div>
    </div>
    <a href="cliente.php" class="btn-back">← Mis Eventos</a>
</nav>

<div class="hero">
    <h1>Catálogo de Mobiliario</h1>
    <p>Elige los artículos para tu evento y apártalos al instante.</p>
    <div class="evento-pill" id="evento-nombre-pill">📅 Evento #<?= htmlspecialchars($id_evento) ?></div>
</div>

<div class="page-wrap">

    <!-- ── CATÁLOGO ── -->
    <div class="catalog-panel">
        <div class="catalog-header">
            <h2>Mobiliario disponible</h2>
            <input type="text" class="search-box" placeholder="🔍 Buscar artículo..." id="buscador" oninput="filtrarCatalogo()">
        </div>
        <div class="catalog-grid" id="catalog-grid">
            <!-- JS lo llena -->
            <p style="padding:2rem;color:var(--muted);grid-column:1/-1;text-align:center">Cargando catálogo...</p>
        </div>
    </div>

    <!-- ── LADO DERECHO ── -->
    <div class="side-panel">

        <!-- CARRITO -->
        <div class="cart-panel">
            <div class="panel-hdr">
                🛒 Mi selección
                <span class="cart-count" id="cart-count">0</span>
            </div>
            <div class="cart-body">
                <div id="cart-items">
                    <div class="cart-empty">
                        <div class="ico">📦</div>
                        <p>Agrega artículos del catálogo</p>
                    </div>
                </div>
                <div id="cart-total-wrap" style="display:none;">
                    <div class="cart-total">
                        <span style="font-size:.9rem;font-weight:600;font-family:'DM Sans',sans-serif;">Total:</span>
                        <span id="cart-total-val">$0.00</span>
                    </div>
                    <div class="timer-row">
                        ⏱ Tiempo para confirmar: <span id="timer-display">02:00:00</span>
                    </div>
                    <button class="btn-iniciar-pago" id="btn-iniciar-pago" onclick="mostrarPago()">
                        💳 Proceder al Pago
                    </button>
                </div>
            </div>
        </div>

        <!-- FORMULARIO PAGO -->
        <div class="pay-panel" id="pay-panel">
            <div class="panel-hdr">💳 Datos de Pago</div>
            <div class="cart-body">
                <div id="pay-msg"></div>

                <!-- Preview tarjeta -->
                <div class="card-preview" id="card-preview">
                    <div class="chip"></div>
                    <div class="card-number-preview" id="prev-number">•••• •••• •••• ••••</div>
                    <div class="card-meta">
                        <div><span>Titular</span><strong id="prev-name">NOMBRE APELLIDO</strong></div>
                        <div style="text-align:right"><span>Vence</span><strong id="prev-exp">MM/AA</strong></div>
                    </div>
                </div>

                <div class="fg">
                    <label class="form-lbl">Nombre del Titular</label>
                    <input type="text" class="form-inp" id="pay-nombre" placeholder="Como aparece en la tarjeta"
                           oninput="actualizarPreview()" maxlength="26">
                </div>

                <div class="fg">
                    <label class="form-lbl">Número de Tarjeta</label>
                    <input type="text" class="form-inp" id="pay-numero" placeholder="1234 5678 9012 3456"
                           oninput="formatearTarjeta(this)" maxlength="19">
                </div>

                <div class="form-row2">
                    <div class="fg">
                        <label class="form-lbl">Vencimiento</label>
                        <input type="text" class="form-inp" id="pay-exp" placeholder="MM/AA"
                               oninput="formatearExp(this)" maxlength="5">
                    </div>
                    <div class="fg">
                        <label class="form-lbl">CVV</label>
                        <input type="text" class="form-inp" id="pay-cvv" placeholder="•••"
                               oninput="soloNumeros(this,3)" maxlength="3">
                    </div>
                </div>

                <div class="fg">
                    <label class="form-lbl">Teléfono de contacto</label>
                    <input type="tel" class="form-inp" id="pay-tel" placeholder="833 000 0000" maxlength="15">
                </div>

                <div class="fg">
                    <label class="form-lbl">Método de Pago</label>
                    <select class="form-inp" id="pay-metodo">
                        <option value="credito">Tarjeta de Crédito</option>
                        <option value="debito">Tarjeta de Débito</option>
                        <option value="transferencia">Transferencia Bancaria</option>
                    </select>
                </div>

                <button class="btn-pagar" id="btn-pagar" onclick="procesarPago()">
                    🔒 Pagar <span id="pagar-monto"></span>
                </button>
                <div class="security-note">🔒 Pago seguro simulado — datos ficticios</div>
            </div>
        </div>

    </div><!-- /side-panel -->
</div><!-- /page-wrap -->

<!-- MODAL VOUCHER -->
<div class="modal-overlay" id="voucher-overlay" style="display:none;">
    <div class="voucher-modal">
        <div class="voucher-top">
            <div class="voucher-check">✅</div>
            <h2>¡Pago Confirmado!</h2>
            <p>Tu mobiliario ha sido apartado con éxito</p>
        </div>
        <div class="voucher-body">
            <div class="voucher-ref" id="v-ref">CIX-000000</div>

            <div class="v-row">
                <span class="v-label">Evento</span>
                <span class="v-val" id="v-evento">—</span>
            </div>
            <div class="v-row">
                <span class="v-label">Pagador</span>
                <span class="v-val" id="v-pagador">—</span>
            </div>
            <div class="v-row">
                <span class="v-label">Método</span>
                <span class="v-val" id="v-metodo">—</span>
            </div>
            <div class="v-row">
                <span class="v-label">Fecha</span>
                <span class="v-val" id="v-fecha">—</span>
            </div>

            <hr class="voucher-divider">

            <strong style="font-size:.78rem;color:var(--muted);text-transform:uppercase;letter-spacing:1px;">Artículos</strong>
            <div class="voucher-items" id="v-items"></div>

            <div class="v-row v-total">
                <span class="v-label">Total pagado</span>
                <span class="v-val" id="v-total">$0.00</span>
            </div>

            <hr class="voucher-divider">
            <button class="btn-cerrar-voucher" onclick="cerrarVoucher()">Ver mis eventos →</button>
        </div>
    </div>
</div>

<script>
const ID_EVENTO = <?= (int)$id_evento ?>;
let catalogo  = [];
let carrito   = {}; // { id_item: { item, cantidad } }
let timerInterval = null;
let segundos  = 7200; // 2 horas
let timerIniciado = false;

// ── CARGAR CATÁLOGO ──────────────────────────────────
function cargarCatalogo() {
    fetch(`/CixEventos/controllers/get_inventario.php`)
        .then(r => r.json())
        .then(data => {
            catalogo = data;
            renderCatalogo(data);
            cargarApartados(); // revisa si ya hay apartados previos
        })
        .catch(() => {
            document.getElementById('catalog-grid').innerHTML =
                `<p style="padding:2rem;color:#dc2626;grid-column:1/-1;text-align:center">⚠️ Error al cargar el catálogo.</p>`;
        });
}

function renderCatalogo(items) {
    const grid = document.getElementById('catalog-grid');
    if (!items.length) {
        grid.innerHTML = `<p style="padding:2rem;color:var(--muted);grid-column:1/-1;text-align:center">Sin artículos disponibles.</p>`;
        return;
    }
    grid.innerHTML = items.map(item => {
        const stockDisp = item.stock_disponible ?? (item.stock_total - item.stock_danado - item.stock_reparacion);
        const stockClass = stockDisp <= 0 ? 'out' : stockDisp <= 5 ? 'low' : '';
        const stockTxt   = stockDisp <= 0 ? 'Sin stock' : `Stock: ${stockDisp}`;
        const agotado    = stockDisp <= 0;

        // Imagen: si existe usa la ruta, si no placeholder emoji
        const imgHtml = item.imagen
            ? `<img src="../../assets/content/mobiliario/${item.imagen}" alt="${item.nombre_item}" onerror="this.style.display='none';this.nextElementSibling.style.display='flex'">`
            : '';
        const placeholderHtml = `<div class="product-img-placeholder" ${item.imagen ? 'style="display:none"' : ''}>🪑</div>`;

        return `
        <div class="product-card" id="card-${item.id_item}" data-nombre="${item.nombre_item.toLowerCase()}">
            <div class="product-img-wrap">
                ${imgHtml}
                ${placeholderHtml}
                <span class="stock-badge ${stockClass}">${stockTxt}</span>
            </div>
            <div class="product-info">
                <div class="product-name">${item.nombre_item}</div>
                <div class="product-desc">${item.descripcion || 'Sin descripción'}</div>
                <div class="product-price">$${parseFloat(item.precio_renta).toFixed(2)} <small>/ evento</small></div>
                <div class="qty-row">
                    <button class="qty-btn" onclick="cambiarQty(${item.id_item},-1)">−</button>
                    <input type="number" class="qty-input" id="qty-${item.id_item}" value="1" min="1" max="${stockDisp}">
                    <button class="qty-btn" onclick="cambiarQty(${item.id_item},+1)">+</button>
                    <span class="qty-label">uds.</span>
                </div>
                <button class="btn-agregar" id="btn-${item.id_item}" 
                    onclick="agregarAlCarrito(${item.id_item})"
                    ${agotado ? 'disabled' : ''}>
                    ${agotado ? 'Sin stock' : '+ Agregar al evento'}
                </button>
            </div>
        </div>`;
    }).join('');
}

function filtrarCatalogo() {
    const q = document.getElementById('buscador').value.toLowerCase();
    document.querySelectorAll('.product-card').forEach(card => {
        card.style.display = card.dataset.nombre.includes(q) ? '' : 'none';
    });
}

function cambiarQty(id, delta) {
    const input = document.getElementById(`qty-${id}`);
    let val = parseInt(input.value) + delta;
    const max = parseInt(input.max) || 99;
    input.value = Math.max(1, Math.min(max, val));
}

// ── CARRITO ──────────────────────────────────────────
function agregarAlCarrito(id_item) {
    const item = catalogo.find(i => i.id_item == id_item);
    if (!item) return;
    const qty  = parseInt(document.getElementById(`qty-${id_item}`).value) || 1;

    if (carrito[id_item]) {
        carrito[id_item].cantidad += qty;
    } else {
        carrito[id_item] = { item, cantidad: qty };
    }

    const btn = document.getElementById(`btn-${id_item}`);
    btn.textContent = '✓ En tu selección';
    btn.classList.add('en-carrito');

    renderCarrito();
    if (!timerIniciado) iniciarTimer();
}

function quitarDelCarrito(id_item) {
    delete carrito[id_item];
    const btn = document.getElementById(`btn-${id_item}`);
    if (btn) { btn.textContent = '+ Agregar al evento'; btn.classList.remove('en-carrito'); }
    renderCarrito();
    if (!Object.keys(carrito).length) {
        detenerTimer();
        document.getElementById('pay-panel').classList.remove('visible');
    }
}

function renderCarrito() {
    const items = Object.values(carrito);
    const itemsDiv = document.getElementById('cart-items');
    const totalWrap = document.getElementById('cart-total-wrap');
    const countEl  = document.getElementById('cart-count');

    countEl.textContent = items.reduce((a,c) => a+c.cantidad, 0);

    if (!items.length) {
        itemsDiv.innerHTML = `<div class="cart-empty"><div class="ico">📦</div><p>Agrega artículos del catálogo</p></div>`;
        totalWrap.style.display = 'none';
        return;
    }

    itemsDiv.innerHTML = items.map(({item, cantidad}) => {
        const sub = (parseFloat(item.precio_renta) * cantidad).toFixed(2);
        return `<div class="cart-item">
            <span class="cart-item-name">${item.nombre_item}</span>
            <span class="cart-item-qty">×${cantidad}</span>
            <span class="cart-item-price">$${sub}</span>
            <button class="cart-item-del" onclick="quitarDelCarrito(${item.id_item})" title="Quitar">✕</button>
        </div>`;
    }).join('');

    const total = items.reduce((a,{item,cantidad}) => a + parseFloat(item.precio_renta)*cantidad, 0);
    document.getElementById('cart-total-val').textContent = `$${total.toFixed(2)}`;
    document.getElementById('pagar-monto').textContent = `$${total.toFixed(2)}`;
    totalWrap.style.display = 'block';
}

function calcularTotal() {
    return Object.values(carrito).reduce((a,{item,cantidad}) => a + parseFloat(item.precio_renta)*cantidad, 0);
}

// ── TIMER ─────────────────────────────────────────────
function iniciarTimer() {
    timerIniciado = true;
    segundos = 7200;
    timerInterval = setInterval(() => {
        segundos--;
        const h = String(Math.floor(segundos/3600)).padStart(2,'0');
        const m = String(Math.floor((segundos%3600)/60)).padStart(2,'0');
        const s = String(segundos%60).padStart(2,'0');
        document.getElementById('timer-display').textContent = `${h}:${m}:${s}`;
        if (segundos <= 0) {
            clearInterval(timerInterval);
            alert('⏰ Tiempo expirado. Tu selección fue liberada.');
            carrito = {};
            timerIniciado = false;
            renderCarrito();
            document.getElementById('pay-panel').classList.remove('visible');
        }
    }, 1000);
}
function detenerTimer() {
    clearInterval(timerInterval);
    timerIniciado = false;
    document.getElementById('timer-display').textContent = '02:00:00';
}

// ── PAGO ─────────────────────────────────────────────
function mostrarPago() {
    document.getElementById('pay-panel').classList.add('visible');
    document.getElementById('pay-panel').scrollIntoView({behavior:'smooth', block:'start'});
}

// Preview de tarjeta live
function actualizarPreview() {
    const nombre = document.getElementById('pay-nombre').value.trim().toUpperCase() || 'NOMBRE APELLIDO';
    document.getElementById('prev-name').textContent = nombre;
}
function formatearTarjeta(input) {
    let v = input.value.replace(/\D/g,'').substring(0,16);
    input.value = v.replace(/(.{4})/g,'$1 ').trim();
    const masked = (v+'').padEnd(16,'•');
    const display = masked.replace(/(.{4})/g,'$1 ').trim();
    document.getElementById('prev-number').textContent = display;
}
function formatearExp(input) {
    let v = input.value.replace(/\D/g,'');
    if (v.length >= 3) v = v.substring(0,2)+'/'+v.substring(2,4);
    input.value = v;
    document.getElementById('prev-exp').textContent = v || 'MM/AA';
}
function soloNumeros(input, max) {
    input.value = input.value.replace(/\D/g,'').substring(0,max);
}

function procesarPago() {
    const nombre = document.getElementById('pay-nombre').value.trim();
    const numero = document.getElementById('pay-numero').value.replace(/\s/g,'');
    const exp    = document.getElementById('pay-exp').value.trim();
    const cvv    = document.getElementById('pay-cvv').value.trim();
    const tel    = document.getElementById('pay-tel').value.trim();
    const metodo = document.getElementById('pay-metodo').value;

    const msg = document.getElementById('pay-msg');
    msg.innerHTML = '';

    if (!nombre || numero.length < 15 || exp.length < 5 || cvv.length < 3 || !tel) {
        msg.innerHTML = `<div class="alert-cix alert-danger">⚠️ Completa todos los datos correctamente.</div>`;
        return;
    }

    const btn = document.getElementById('btn-pagar');
    btn.disabled = true;
    btn.textContent = '⏳ Procesando...';

    const itemsCarrito = Object.values(carrito).map(({item, cantidad}) => ({
        id_item:  item.id_item,
        cantidad: cantidad,
        precio:   item.precio_renta
    }));

    const payload = {
        id_evento: ID_EVENTO,
        nombre_pagador: nombre,
        telefono: tel,
        metodo_pago: metodo,
        monto_total: calcularTotal(),
        items: itemsCarrito
    };

    fetch('/CixEventos/controllers/procesar_pago.php', {
        method: 'POST',
        headers: {'Content-Type':'application/json'},
        body: JSON.stringify(payload)
    })
    .then(r => r.json())
    .then(res => {
        if (res.ok) {
            mostrarVoucher(res, payload, metodo);
            detenerTimer();
        } else {
            msg.innerHTML = `<div class="alert-cix alert-danger">❌ ${res.mensaje || 'Error al procesar el pago.'}</div>`;
            btn.disabled = false;
            btn.textContent = '🔒 Pagar';
        }
    })
    .catch(() => {
        msg.innerHTML = `<div class="alert-cix alert-danger">❌ Error de conexión. Intenta de nuevo.</div>`;
        btn.disabled = false;
        btn.innerHTML = '🔒 Pagar';
    });
}

// ── VOUCHER ───────────────────────────────────────────
function mostrarVoucher(res, payload, metodo) {
    const ref = 'CIX-' + String(res.id_pago || Math.floor(Math.random()*999999)).padStart(6,'0');
    const metodosLabel = {
        credito:'Tarjeta de Crédito',
        debito:'Tarjeta de Débito',
        transferencia:'Transferencia Bancaria'
    };

    document.getElementById('v-ref').textContent = ref;
    document.getElementById('v-evento').textContent = document.getElementById('evento-nombre-pill').textContent.replace('📅 ','');
    document.getElementById('v-pagador').textContent = payload.nombre_pagador;
    document.getElementById('v-metodo').textContent = metodosLabel[metodo] || metodo;
    document.getElementById('v-fecha').textContent = new Date().toLocaleString('es-MX');

    const itemsHtml = Object.values(carrito).map(({item,cantidad}) => `
        <div class="vi">
            <span>${item.nombre_item} ×${cantidad}</span>
            <span>$${(parseFloat(item.precio_renta)*cantidad).toFixed(2)}</span>
        </div>`).join('');
    document.getElementById('v-items').innerHTML = itemsHtml;
    document.getElementById('v-total').textContent = `$${payload.monto_total.toFixed(2)}`;

    document.getElementById('voucher-overlay').style.display = 'flex';
}

function cerrarVoucher() {
    window.location.href = 'cliente.php';
}

// ── CARGAR APARTADOS YA EXISTENTES (opcional) ─────────
function cargarApartados() {
    fetch(`/CixEventos/controllers/get_apartados.php?id_evento=${ID_EVENTO}`)
        .then(r => r.json())
        .then(data => {
            if (data.length) {
                // Marcar botones ya en carrito si ya están apartados
                data.forEach(ap => {
                    const btn = document.getElementById(`btn-${ap.id_item}`);
                    if (btn) { btn.textContent = '✓ Ya apartado'; btn.disabled = true; }
                });
            }
        }).catch(() => {});
}

// ── NOMBRE DEL EVENTO ─────────────────────────────────
fetch(`/CixEventos/controllers/get_eventos.php`)
    .then(r => r.json())
    .then(data => {
        const ev = data.find(e => e.id_evento == ID_EVENTO);
        if (ev) document.getElementById('evento-nombre-pill').textContent = `📅 ${ev.nombre_evento}`;
    }).catch(() => {});

cargarCatalogo();
</script>
</body>
</html>