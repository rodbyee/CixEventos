<?php
session_start();
if (!isset($_SESSION['id']) || $_SESSION['rol'] != 1) {
    header('Location: ../../login.php');
    exit;
}
$nombreAdmin = $_SESSION['nombre'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Usuario | CIX Eventos</title>
    <link rel="icon" type="image/png" href="../../../assets/content/logotip-cix.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --azul: #1a56db; --azul-dark: #1341b0;
            --bg: #f4f6fb; --card: #ffffff;
            --text: #1a1d2e; --muted: #6b7280; --border: #e5e7ef;
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
            color: #fff; padding: 2.5rem 2rem 3.5rem;
        }
        .hero h1 { font-family: 'DM Serif Display', serif; font-size: 2.2rem; font-weight: 400; margin-bottom: .2rem; }
        .hero p { opacity: .7; font-size: .95rem; font-weight: 300; }

        .contenido { max-width: 700px; margin: -2rem auto 3rem; padding: 0 1.5rem; }

        .panel { background: var(--card); border-radius: 16px; box-shadow: 0 4px 24px rgba(0,0,0,.07); overflow: hidden; }
        .panel-header { padding: 1.25rem 1.5rem; border-bottom: 1px solid var(--border); }
        .panel-header h2 { font-family: 'DM Serif Display', serif; font-size: 1.25rem; font-weight: 400; color: var(--text); margin: 0; }
        .panel-body { padding: 1.75rem; }

        .form-label-cix { font-size: .72rem; font-weight: 600; letter-spacing: 1px; text-transform: uppercase; color: var(--muted); margin-bottom: .35rem; display: block; }
        .form-control-cix {
            border: 1.5px solid var(--border); border-radius: 10px;
            padding: .6rem .9rem; font-size: .9rem;
            font-family: 'DM Sans', sans-serif; width: 100%; outline: none;
            transition: border-color .2s, box-shadow .2s;
            background: #fafbff; color: var(--text);
        }
        .form-control-cix:focus { border-color: var(--azul); box-shadow: 0 0 0 3px rgba(26,86,219,.1); background: #fff; }
        .form-group { margin-bottom: 1.2rem; }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }

        .registrado-por {
            background: #f0f7ff; border: 1px solid #bfdbfe;
            border-radius: 10px; padding: .65rem .9rem;
            font-size: .85rem; color: var(--azul);
            font-weight: 500; margin-bottom: 1.4rem;
        }

        /* Selector de rol visual */
        .rol-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: .75rem; margin-top: .35rem; }
        .rol-option input { display: none; }
        .rol-label {
            display: flex; align-items: center; gap: .75rem;
            border: 1.5px solid var(--border); border-radius: 12px;
            padding: .85rem 1rem; cursor: pointer;
            transition: all .2s; background: #fafbff;
        }
        .rol-label:hover { border-color: #93c5fd; background: #eff6ff; }
        .rol-option input:checked + .rol-label {
            border-color: var(--azul); background: #eff6ff;
            box-shadow: 0 0 0 3px rgba(26,86,219,.1);
        }
        .rol-icono { font-size: 1.4rem; }
        .rol-info .rol-nombre { font-weight: 600; font-size: .88rem; color: var(--text); }
        .rol-info .rol-desc { font-size: .75rem; color: var(--muted); }

        .btn-enviar {
            background: var(--azul); color: #fff; border: none;
            border-radius: 12px; padding: .75rem 1.5rem;
            font-size: 1rem; font-weight: 600;
            font-family: 'DM Sans', sans-serif; width: 100%;
            cursor: pointer; transition: background .2s, transform .15s;
        }
        .btn-enviar:hover { background: var(--azul-dark); transform: translateY(-1px); }

        .alert-cix { padding: .75rem 1rem; border-radius: 10px; font-size: .88rem; margin-bottom: 1.2rem; }
        .alert-success { background: #dcfce7; color: #15803d; }
        .alert-danger  { background: #fee2e2; color: #dc2626; }
        .alert-warning { background: #fef3c7; color: #92400e; }

        @media (max-width: 600px) {
            .form-row { grid-template-columns: 1fr; }
            .rol-grid  { grid-template-columns: 1fr; }
            .hero h1   { font-size: 1.7rem; }
        }
    </style>
</head>
<body>

<nav class="navbar-cix">
    <div class="navbar-brand-cix">
        <img src="../../../assets/content/logotype.png" alt="CIX Logo">
        <div>
            <span>CIX Eventos</span>
            <small>Admin</small>
        </div>
    </div>
    <div class="navbar-right">
        <a href="../admin.php" class="btn-back">← Regresar</a>
        <a href="/CixEventos/controllers/logout.php" class="btn-logout">Cerrar Sesión</a>
    </div>
</nav>

<div class="hero">
    <h1>➕ Registrar Usuario</h1>
    <p>Crea nuevos usuarios y asígnales un rol desde el panel de administrador.</p>
</div>

<div class="contenido">
    <div class="panel">
        <div class="panel-header">
            <h2>Nuevo Usuario</h2>
        </div>
        <div class="panel-body">

            <div id="mensaje"></div>

            <div class="registrado-por">
                🛡️ Registrado por: <strong><?php echo ucwords(strtolower($nombreAdmin)); ?></strong>
            </div>

            <form method="POST" action="/CixEventos/controllers/admin_registro_usuario.php">

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label-cix">Nombre de Usuario</label>
                        <input type="text" name="nombre" class="form-control-cix" placeholder="Nombre completo" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label-cix">Género</label>
                        <select name="genero" class="form-control-cix" required>
                            <option value="" disabled selected>Selecciona...</option>
                            <option value="Hombre">Hombre</option>
                            <option value="Mujer">Mujer</option>
                            <option value="Otro">Otro</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label-cix">Email</label>
                    <input type="email" name="email" class="form-control-cix" placeholder="correo@ejemplo.com" required>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label-cix">Contraseña</label>
                        <input type="password" name="password" class="form-control-cix" placeholder="Mínimo 8 caracteres" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label-cix">Confirmar Contraseña</label>
                        <input type="password" name="password_confirm" class="form-control-cix" placeholder="Repite la contraseña" required>
                    </div>
                </div>

                <!-- Selector de rol visual -->
                <div class="form-group">
                    <label class="form-label-cix">Rol del Usuario</label>
                    <div class="rol-grid">
                        <div class="rol-option">
                            <input type="radio" name="id_rol" id="rol-admin" value="1">
                            <label class="rol-label" for="rol-admin">
                                <span class="rol-icono">🔴</span>
                                <div class="rol-info">
                                    <div class="rol-nombre">Administrador</div>
                                    <div class="rol-desc">Acceso total al sistema</div>
                                </div>
                            </label>
                        </div>
                        <div class="rol-option">
                            <input type="radio" name="id_rol" id="rol-inv" value="2">
                            <label class="rol-label" for="rol-inv">
                                <span class="rol-icono">🟢</span>
                                <div class="rol-info">
                                    <div class="rol-nombre">Inventario</div>
                                    <div class="rol-desc">Gestión de mobiliario</div>
                                </div>
                            </label>
                        </div>
                        <div class="rol-option">
                            <input type="radio" name="id_rol" id="rol-worker" value="3">
                            <label class="rol-label" for="rol-worker">
                                <span class="rol-icono">🟡</span>
                                <div class="rol-info">
                                    <div class="rol-nombre">Trabajador</div>
                                    <div class="rol-desc">Recibe y gestiona asignaciones</div>
                                </div>
                            </label>
                        </div>
                        <div class="rol-option">
                            <input type="radio" name="id_rol" id="rol-cliente" value="4" checked>
                            <label class="rol-label" for="rol-cliente">
                                <span class="rol-icono">🔵</span>
                                <div class="rol-info">
                                    <div class="rol-nombre">Cliente</div>
                                    <div class="rol-desc">Registra eventos y aparta mobiliario</div>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                <button type="submit" name="btn_registrar" value="ok" class="btn-enviar">Crear Usuario</button>
            </form>

        </div>
    </div>
</div>

<script>
const params = new URLSearchParams(window.location.search);
const msg = document.getElementById('mensaje');
if (params.get('ok')) {
    msg.innerHTML = `<div class="alert-cix alert-success">✅ Usuario creado con éxito.</div>`;
} else if (params.get('error')) {
    msg.innerHTML = `<div class="alert-cix alert-danger">❌ El correo ya está registrado.</div>`;
} else if (params.get('pass')) {
    msg.innerHTML = `<div class="alert-cix alert-warning">⚠️ Las contraseñas no coinciden.</div>`;
} else if (params.get('short')) {
    msg.innerHTML = `<div class="alert-cix alert-warning">⚠️ La contraseña debe tener al menos 8 caracteres.</div>`;
}
</script>

</body>
</html>