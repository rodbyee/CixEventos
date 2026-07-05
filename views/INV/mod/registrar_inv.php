<?php
session_start();

$nombreUsuario = $_SESSION['nombre'];
$id_usuario = $_SESSION['id'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Inventario | CIX Eventos</title>
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
        .navbar-brand-cix { display: flex; align-items: center; gap: 10px; }
        .navbar-brand-cix img {
            height: 42px; width: auto; border-radius: 50%;
            box-shadow: 0 0 0 2px rgba(255,255,255,.35);
        }
        .navbar-brand-cix span {
            color: #fff;
            font-family: 'DM Serif Display', serif;
            font-size: 1.2rem;
        }
        .navbar-brand-cix small {
            display: block; color: rgba(255,255,255,.65);
            font-size: .68rem; font-weight: 300;
            letter-spacing: 1.5px; text-transform: uppercase;
        }
        .navbar-nav-cix { display: flex; align-items: center; gap: 1rem; }
        .btn-back {
            background: rgba(255,255,255,.15);
            border: 1.5px solid rgba(255,255,255,.4);
            color: #fff; border-radius: 8px;
            padding: .4rem 1rem; font-size: .85rem;
            font-weight: 500; text-decoration: none; transition: all .2s;
        }
        .btn-back:hover { background: rgba(255,255,255,.25); color: #fff; }
        .btn-logout {
            background: transparent;
            border: 1.5px solid rgba(255,255,255,.5);
            color: #fff; border-radius: 8px;
            padding: .4rem 1rem; font-size: .85rem;
            font-weight: 500; text-decoration: none; transition: all .2s;
        }
        .btn-logout:hover { background: rgba(255,255,255,.15); color: #fff; }

        .hero {
            background: linear-gradient(135deg, var(--azul) 0%, #3b82f6 100%);
            color: #fff; padding: 2.5rem 2rem 3.5rem;
        }
        .hero h1 {
            font-family: 'DM Serif Display', serif;
            font-size: 2.2rem; font-weight: 400; margin-bottom: .2rem;
        }
        .hero p { opacity: .7; font-size: .95rem; font-weight: 300; }

        .contenido {
            max-width: 700px;
            margin: -2rem auto 3rem;
            padding: 0 1.5rem;
        }

        .panel {
            background: var(--card);
            border-radius: 16px;
            box-shadow: 0 4px 24px rgba(0,0,0,.07);
            overflow: hidden;
        }
        .panel-header {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid var(--border);
        }
        .panel-header h2 {
            font-family: 'DM Serif Display', serif;
            font-size: 1.25rem; font-weight: 400;
            color: var(--text); margin: 0;
        }
        .panel-body { padding: 1.75rem; }

        .form-label-cix {
            font-size: .72rem; font-weight: 600;
            letter-spacing: 1px; text-transform: uppercase;
            color: var(--muted); margin-bottom: .35rem; display: block;
        }
        .form-control-cix {
            border: 1.5px solid var(--border);
            border-radius: 10px; padding: .6rem .9rem;
            font-size: .9rem; font-family: 'DM Sans', sans-serif;
            width: 100%; outline: none;
            transition: border-color .2s, box-shadow .2s;
            background: #fafbff; color: var(--text);
        }
        .form-control-cix:focus {
            border-color: var(--azul);
            box-shadow: 0 0 0 3px rgba(26,86,219,.1);
            background: #fff;
        }
        textarea.form-control-cix { resize: vertical; min-height: 90px; }
        .form-group { margin-bottom: 1.2rem; }
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .registrado-por {
            background: #f0f7ff;
            border: 1px solid #bfdbfe;
            border-radius: 10px;
            padding: .65rem .9rem;
            font-size: .85rem;
            color: var(--azul);
            font-weight: 500;
            margin-bottom: 1.4rem;
        }

        .btn-enviar {
            background: var(--azul); color: #fff;
            border: none; border-radius: 12px;
            padding: .75rem 1.5rem; font-size: 1rem;
            font-weight: 600; font-family: 'DM Sans', sans-serif;
            width: 100%; cursor: pointer;
            transition: background .2s, transform .15s;
        }
        .btn-enviar:hover { background: var(--azul-dark); transform: translateY(-1px); }
        .btn-enviar:active { transform: translateY(0); }

        .alert-cix {
            padding: .75rem 1rem; border-radius: 10px;
            font-size: .88rem; margin-bottom: 1.2rem;
        }
        .alert-success { background: #dcfce7; color: #15803d; }
        .alert-danger  { background: #fee2e2; color: #dc2626; }

        @media (max-width: 600px) {
            .form-row { grid-template-columns: 1fr; }
            .hero h1  { font-size: 1.7rem; }
        }
    </style>
</head>
<body>

<nav class="navbar-cix">
    <div class="navbar-brand-cix">
        <img src="../../../assets/content/logotype.png" alt="CIX Logo">
        <div>
            <span>CIX Eventos</span>
            <small><?php echo $_SESSION['rol'] == 1 ? 'Admin' : 'Encargado Inventario'; ?></small>
        </div>
    </div>
    <div class="navbar-nav-cix">
        <a href="<?php echo $_SESSION['rol'] == 1 ? '/CixEventos/views/ADMIN/admin.php' : '/CixEventos/views/INV/inventario.php'; ?>" class="btn-back">← Regresar</a>
        <a href="../../controllers/logout.php" class="btn-logout">Cerrar Sesión</a>
    </div>
</nav>

<div class="hero">
    <h1>➕ Registrar Inventario</h1>
    <p>Agrega nuevos artículos al inventario de mobiliario.</p>
</div>

<div class="contenido">
    <div class="panel">
        <div class="panel-header">
            <h2>Agregar Artículo</h2>
        </div>
        <div class="panel-body">

            <div id="mensaje"></div>

            <div class="registrado-por">
                🧾 Registrado por: <strong><?php echo ucwords(strtolower($nombreUsuario)); ?></strong>
            </div>

            <form method="POST" action="/CixEventos/controllers/save_art.php" enctype="multipart/form-data">
                <input type="hidden" name="id_usuario_inv" value="<?php echo $id_usuario; ?>">

                <div class="form-group">
                    <label class="form-label-cix">Nombre del Artículo</label>
                    <input type="text" name="nombre_item" class="form-control-cix"
                           placeholder="Ej. Silla Thonet, Mesa redonda..." required>
                </div>

                <div class="form-group">
                    <label class="form-label-cix">Descripción</label>
                    <textarea name="descripcion" class="form-control-cix"
                              placeholder="Material, color, dimensiones..."></textarea>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label-cix">Stock Total</label>
                        <input type="number" name="stock_total" class="form-control-cix"
                               placeholder="0" min="1" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label-cix">Precio de Renta</label>
                        <input type="number" name="precio_renta" class="form-control-cix"
                               placeholder="0.00" min="0" step="0.01" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label-cix">Imagen del Artículo</label>
                    <input type="file" name="imagen" class="form-control-cix" accept="image/png, image/jpeg, image/webp">
                    <small style="color:var(--muted);font-size:.75rem;">Opcional · JPG, PNG o WEBP</small>
                </div>

                <button type="submit" class="btn-enviar">Guardar Artículo</button>
            </form>

        </div>
    </div>
</div>

<script>
const params = new URLSearchParams(window.location.search);
const msg = document.getElementById('mensaje');
if (params.get('ok')) {
    msg.innerHTML = `<div class="alert-cix alert-success">✅ Artículo registrado con éxito.</div>`;
} else if (params.get('error')) {
    msg.innerHTML = `<div class="alert-cix alert-danger">❌ Error al registrar el artículo. Intenta de nuevo.</div>`;
}
</script>

</body>
</html>