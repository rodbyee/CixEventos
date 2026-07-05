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
    <title>Gestionar Usuarios | CIX Eventos</title>
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

        .contenido { max-width: 1100px; margin: -1.5rem auto 3rem; padding: 0 1.5rem; }

        /* FILTRO TABS */
        .tabs {
            display: flex; gap: .5rem; margin-bottom: 1.25rem; flex-wrap: wrap;
        }
        .tab-btn {
            padding: .45rem 1.1rem; border-radius: 20px;
            border: 1.5px solid var(--border); background: var(--card);
            font-size: .82rem; font-weight: 600; cursor: pointer;
            font-family: 'DM Sans', sans-serif; color: var(--muted);
            transition: all .2s;
        }
        .tab-btn:hover { border-color: #93c5fd; color: var(--azul); }
        .tab-btn.active { background: var(--azul); color: #fff; border-color: var(--azul); }

        /* BUSCADOR */
        .buscador-wrap { margin-bottom: 1.25rem; }
        .buscador-wrap input {
            border: 1.5px solid var(--border); border-radius: 10px;
            padding: .55rem 1rem; font-size: .88rem;
            font-family: 'DM Sans', sans-serif; width: 100%; max-width: 340px;
            outline: none; background: var(--card); color: var(--text);
        }
        .buscador-wrap input:focus { border-color: var(--azul); }

        /* TABLA */
        .tabla-wrap {
            background: var(--card); border-radius: 16px;
            border: 1.5px solid var(--border);
            box-shadow: 0 4px 24px rgba(0,0,0,.07);
            overflow: hidden;
        }
        .usuarios-tabla { width: 100%; border-collapse: collapse; font-size: .875rem; }
        .usuarios-tabla th {
            text-align: left; font-weight: 600; font-size: .72rem;
            color: var(--muted); padding: .85rem 1.2rem;
            border-bottom: 1.5px solid var(--border);
            text-transform: uppercase; letter-spacing: .8px;
            background: #fafbff;
        }
        .usuarios-tabla td { padding: .9rem 1.2rem; border-bottom: 1px solid var(--border); vertical-align: middle; }
        .usuarios-tabla tr:last-child td { border-bottom: none; }
        .usuarios-tabla tr:hover td { background: #f8faff; }

        .usuario-avatar {
            width: 36px; height: 36px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: .9rem; font-weight: 700; color: #fff; flex-shrink: 0;
        }
        .usuario-info { display: flex; align-items: center; gap: .75rem; }
        .usuario-nombre { font-weight: 600; font-size: .88rem; }
        .usuario-email { font-size: .78rem; color: var(--muted); }

        .badge-rol {
            padding: .28rem .75rem; border-radius: 20px;
            font-size: .72rem; font-weight: 700; letter-spacing: .3px;
        }
        .rol-1 { background: #fee2e2; color: var(--rojo); }
        .rol-2 { background: #dcfce7; color: var(--verde); }
        .rol-3 { background: #fef3c7; color: var(--amarillo); }
        .rol-4 { background: #eff6ff; color: var(--azul); }

        /* SELECT ROL */
        .select-rol {
            border: 1.5px solid var(--border); border-radius: 8px;
            padding: .3rem .6rem; font-size: .82rem;
            font-family: 'DM Sans', sans-serif; color: var(--text);
            background: var(--bg); outline: none; cursor: pointer;
        }
        .select-rol:focus { border-color: var(--azul); }

        /* BOTONES ACCION */
        .btn-guardar-rol {
            background: var(--azul); color: #fff; border: none;
            border-radius: 7px; padding: .3rem .75rem;
            font-size: .78rem; font-weight: 600;
            font-family: 'DM Sans', sans-serif; cursor: pointer;
            transition: all .2s; display: none;
        }
        .btn-guardar-rol:hover { background: var(--azul-dark); }
        .btn-guardar-rol.visible { display: inline-block; }
        .btn-guardar-rol.guardado { background: var(--verde); }

        .btn-eliminar {
            background: #fee2e2; color: var(--rojo);
            border: 1.5px solid #fecaca; border-radius: 7px;
            padding: .3rem .75rem; font-size: .78rem; font-weight: 600;
            font-family: 'DM Sans', sans-serif; cursor: pointer; transition: all .2s;
        }
        .btn-eliminar:hover { background: #fecaca; }

        /* EMPTY */
        .empty-state { text-align: center; padding: 3rem; color: var(--muted); font-size: .9rem; }

        /* SPINNER */
        .spinner { text-align: center; padding: 2.5rem; color: var(--muted); font-size: .9rem; }

        /* MODAL CONFIRMAR */
        .modal-cix {
            display: none; position: fixed; inset: 0;
            background: rgba(0,0,0,.45); z-index: 9999;
            align-items: center; justify-content: center; padding: 1rem;
        }
        .modal-cix.show { display: flex; }
        .modal-box {
            background: var(--card); border-radius: 18px;
            box-shadow: 0 16px 48px rgba(0,0,0,.18);
            padding: 2rem; width: 100%; max-width: 400px;
            text-align: center; animation: slideUp .2s ease;
        }
        @keyframes slideUp {
            from { transform: translateY(20px); opacity: 0; }
            to   { transform: translateY(0); opacity: 1; }
        }
        .modal-icono { font-size: 2.5rem; margin-bottom: .75rem; }
        .modal-titulo { font-family: 'DM Serif Display', serif; font-size: 1.3rem; margin-bottom: .5rem; }
        .modal-desc { font-size: .88rem; color: var(--muted); margin-bottom: 1.5rem; }
        .modal-btns { display: flex; gap: .75rem; justify-content: center; }
        .btn-cancelar {
            background: var(--bg); border: 1.5px solid var(--border);
            color: var(--text); border-radius: 10px; padding: .55rem 1.3rem;
            font-size: .88rem; font-weight: 600; cursor: pointer;
            font-family: 'DM Sans', sans-serif; transition: all .2s;
        }
        .btn-cancelar:hover { background: var(--border); }
        .btn-confirmar-elim {
            background: var(--rojo); color: #fff; border: none;
            border-radius: 10px; padding: .55rem 1.3rem;
            font-size: .88rem; font-weight: 600; cursor: pointer;
            font-family: 'DM Sans', sans-serif; transition: all .2s;
        }
        .btn-confirmar-elim:hover { background: #b91c1c; }

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

        @media (max-width: 700px) {
            .hero h1 { font-size: 1.6rem; }
            .usuarios-tabla th:nth-child(3),
            .usuarios-tabla td:nth-child(3) { display: none; }
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
    <h1>👥 Gestionar Usuarios</h1>
    <p>Consulta, edita el rol y elimina usuarios clasificados por tipo.</p>
</div>

<div class="contenido">

    <div class="buscador-wrap">
        <input type="text" id="buscador" placeholder="🔍 Buscar por nombre o correo...">
    </div>

    <div class="tabs">
        <button class="tab-btn active" onclick="filtrarRol('todos')">Todos</button>
        <button class="tab-btn" onclick="filtrarRol(1)">🔴 Admin</button>
        <button class="tab-btn" onclick="filtrarRol(2)">🟢 Inventario</button>
        <button class="tab-btn" onclick="filtrarRol(3)">🟡 Trabajador</button>
        <button class="tab-btn" onclick="filtrarRol(4)">🔵 Cliente</button>
    </div>

    <div class="tabla-wrap">
        <table class="usuarios-tabla">
            <thead>
                <tr>
                    <th>Usuario</th>
                    <th>Género</th>
                    <th>Rol actual</th>
                    <th>Cambiar rol</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="tabla-body">
                <tr><td colspan="5"><div class="spinner">Cargando usuarios...</div></td></tr>
            </tbody>
        </table>
    </div>

</div>

<!-- MODAL CONFIRMAR ELIMINACIÓN -->
<div class="modal-cix" id="modal-eliminar">
    <div class="modal-box">
        <div class="modal-icono">🗑️</div>
        <div class="modal-titulo">¿Eliminar usuario?</div>
        <div class="modal-desc" id="modal-desc">Esta acción no se puede deshacer.</div>
        <div class="modal-btns">
            <button class="btn-cancelar" onclick="cerrarModal()">Cancelar</button>
            <button class="btn-confirmar-elim" id="btn-confirmar">Eliminar</button>
        </div>
    </div>
</div>

<div class="toast-cix" id="toast"></div>

<script>
let todosLosUsuarios = [];
let rolFiltro = 'todos';
let usuarioAEliminar = null;

const rolesNombre = { 1: 'Admin', 2: 'Inventario', 3: 'Trabajador', 4: 'Cliente' };
const rolesClase  = { 1: 'rol-1', 2: 'rol-2', 3: 'rol-3', 4: 'rol-4' };
const avatarColor = { 1: '#dc2626', 2: '#16a34a', 3: '#d97706', 4: '#1a56db' };

async function cargarUsuarios() {
    try {
        const res  = await fetch('/CixEventos/controllers/get_usuarios.php');
        const data = await res.json();
        todosLosUsuarios = data;
        renderTabla();
    } catch(e) {
        document.getElementById('tabla-body').innerHTML =
            `<tr><td colspan="5"><div class="empty-state">⚠️ No se pudo conectar con el servidor.</div></td></tr>`;
    }
}

function renderTabla() {
    const busqueda = document.getElementById('buscador').value.toLowerCase();
    let usuarios = [...todosLosUsuarios];

    if (rolFiltro !== 'todos') {
        usuarios = usuarios.filter(u => u.id_rol == rolFiltro);
    }
    if (busqueda) {
        usuarios = usuarios.filter(u =>
            u.nombre_usuario.toLowerCase().includes(busqueda) ||
            u.email_usuario.toLowerCase().includes(busqueda)
        );
    }

    const tbody = document.getElementById('tabla-body');
    if (usuarios.length === 0) {
        tbody.innerHTML = `<tr><td colspan="5"><div class="empty-state">No se encontraron usuarios.</div></td></tr>`;
        return;
    }

    tbody.innerHTML = usuarios.map(u => {
        const inicial = u.nombre_usuario.charAt(0).toUpperCase();
        const color   = avatarColor[u.id_rol] || '#6b7280';
        return `
        <tr id="fila-${u.id_usuario}">
            <td>
                <div class="usuario-info">
                    <div class="usuario-avatar" style="background:${color}">${inicial}</div>
                    <div>
                        <div class="usuario-nombre">${ucwords(u.nombre_usuario)}</div>
                        <div class="usuario-email">${u.email_usuario}</div>
                    </div>
                </div>
            </td>
            <td>${u.genero}</td>
            <td>
                <span class="badge-rol ${rolesClase[u.id_rol]}" id="badge-${u.id_usuario}">
                    ${rolesNombre[u.id_rol]}
                </span>
            </td>
            <td>
                <div style="display:flex;align-items:center;gap:.5rem;">
                    <select class="select-rol" id="select-${u.id_usuario}"
                        onchange="mostrarGuardar(${u.id_usuario}, ${u.id_rol})">
                        <option value="1" ${u.id_rol==1?'selected':''}>🔴 Admin</option>
                        <option value="2" ${u.id_rol==2?'selected':''}>🟢 Inventario</option>
                        <option value="3" ${u.id_rol==3?'selected':''}>🟡 Trabajador</option>
                        <option value="4" ${u.id_rol==4?'selected':''}>🔵 Cliente</option>
                    </select>
                    <button class="btn-guardar-rol" id="btn-rol-${u.id_usuario}"
                        onclick="guardarRol(${u.id_usuario})">
                        Guardar
                    </button>
                </div>
            </td>
            <td>
                <button class="btn-eliminar" onclick="confirmarEliminar(${u.id_usuario}, '${ucwords(u.nombre_usuario)}')">
                    🗑️ Eliminar
                </button>
            </td>
        </tr>`;
    }).join('');
}

function mostrarGuardar(idUsuario, rolOriginal) {
    const select = document.getElementById(`select-${idUsuario}`);
    const btn    = document.getElementById(`btn-rol-${idUsuario}`);
    if (parseInt(select.value) !== rolOriginal) {
        btn.classList.add('visible');
    } else {
        btn.classList.remove('visible');
    }
}

async function guardarRol(idUsuario) {
    const select  = document.getElementById(`select-${idUsuario}`);
    const nuevoRol = parseInt(select.value);
    const btn     = document.getElementById(`btn-rol-${idUsuario}`);

    btn.textContent = 'Guardando...';
    btn.disabled = true;

    try {
        const res  = await fetch('/CixEventos/controllers/actualizar_rol.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id_usuario: idUsuario, id_rol: nuevoRol })
        });
        const data = await res.json();

        if (data.success) {
            // Actualizar badge y datos locales
            const badge = document.getElementById(`badge-${idUsuario}`);
            badge.textContent = rolesNombre[nuevoRol];
            badge.className = `badge-rol ${rolesClase[nuevoRol]}`;

            // Actualizar color del avatar
            const fila = document.getElementById(`fila-${idUsuario}`);
            fila.querySelector('.usuario-avatar').style.background = avatarColor[nuevoRol];

            // Actualizar en el array local
            const u = todosLosUsuarios.find(x => x.id_usuario == idUsuario);
            if (u) u.id_rol = nuevoRol;

            btn.classList.add('guardado');
            btn.textContent = '✓ Guardado';
            setTimeout(() => {
                btn.classList.remove('visible', 'guardado');
                btn.textContent = 'Guardar';
                btn.disabled = false;
            }, 1500);

            mostrarToast('Rol actualizado correctamente.');
        } else {
            btn.textContent = 'Guardar';
            btn.disabled = false;
            mostrarToast('Error al actualizar el rol.');
        }
    } catch(e) {
        btn.textContent = 'Guardar';
        btn.disabled = false;
        mostrarToast('Error de conexión.');
    }
}

function confirmarEliminar(idUsuario, nombre) {
    usuarioAEliminar = idUsuario;
    document.getElementById('modal-desc').textContent = `¿Seguro que quieres eliminar a ${nombre}? Esta acción no se puede deshacer.`;
    document.getElementById('modal-eliminar').classList.add('show');
    document.getElementById('btn-confirmar').onclick = () => eliminarUsuario(idUsuario);
}

function cerrarModal() {
    document.getElementById('modal-eliminar').classList.remove('show');
}

async function eliminarUsuario(idUsuario) {
    cerrarModal();
    try {
        const res  = await fetch('/CixEventos/controllers/eliminar_usuario.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id_usuario: idUsuario })
        });
        const data = await res.json();

        if (data.success) {
            // Quitar fila con animación
            const fila = document.getElementById(`fila-${idUsuario}`);
            fila.style.transition = 'opacity .3s';
            fila.style.opacity = '0';
            setTimeout(() => {
                todosLosUsuarios = todosLosUsuarios.filter(u => u.id_usuario != idUsuario);
                renderTabla();
            }, 300);
            mostrarToast('Usuario eliminado correctamente.');
        } else {
            mostrarToast('Error al eliminar el usuario.');
        }
    } catch(e) {
        mostrarToast('Error de conexión.');
    }
}

function filtrarRol(rol) {
    rolFiltro = rol;
    document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
    event.target.classList.add('active');
    renderTabla();
}

function ucwords(str) {
    return str.toLowerCase().replace(/\b\w/g, l => l.toUpperCase());
}

function mostrarToast(msg) {
    const t = document.getElementById('toast');
    t.textContent = msg;
    t.classList.add('show');
    setTimeout(() => t.classList.remove('show'), 3000);
}

document.getElementById('buscador').addEventListener('input', renderTabla);
document.getElementById('modal-eliminar').addEventListener('click', function(e) {
    if (e.target === this) cerrarModal();
});

cargarUsuarios();
</script>

</body>
</html>