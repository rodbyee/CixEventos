<?php 
    $id_valido = $_SESSION['id_usuario'] ?? null;
    if (!$id_valido) {
        $res = mysqli_query($conexion, "SELECT id_usuario FROM usuarios LIMIT 1");
        $user = mysqli_fetch_assoc($res);
        $id_valido = $user['id_usuario'];
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro Directo | Inventario CIX</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        :root { --azul-inv: #2563eb; --bg-inv: #f8fafc; }
        body { font-family: 'DM Sans', sans-serif; background: var(--bg-inv); color: #1e293b; }
        
        /* Header con estilo único para Inventario */
        .header-inv { background: var(--azul-inv); padding: 2rem 2rem 6rem; color: white; position: relative; }
        .btn-regresar { position: absolute; top: 1.5rem; right: 2rem; border: 1px solid rgba(255,255,255,0.4); color: white; text-decoration: none; padding: 0.5rem 1rem; border-radius: 8px; font-size: 0.85rem; }

        .container-form { max-width: 700px; margin: -4rem auto 4rem; position: relative; }
        .card-inv { background: white; border-radius: 20px; box-shadow: 0 10px 25px rgba(0,0,0,0.05); padding: 2.5rem; border: 1px solid #e2e8f0; }
        
        .section-title { font-size: 0.75rem; font-weight: 700; text-transform: uppercase; color: #64748b; letter-spacing: 1px; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 8px; }
        .section-title::after { content: ""; height: 1px; background: #e2e8f0; flex: 1; }

        .input-group-inv { margin-bottom: 1.5rem; }
        .label-inv { display: block; font-weight: 500; font-size: 0.9rem; margin-bottom: 0.5rem; color: #334155; }
        .input-inv { width: 100%; padding: 0.75rem 1rem; border: 1.5px solid #e2e8f0; border-radius: 12px; transition: 0.2s; font-size: 0.95rem; }
        .input-inv:focus { border-color: var(--azul-inv); outline: none; box-shadow: 0 0 0 4px rgba(37,99,235,0.1); }

        .btn-save { background: #1e293b; color: white; width: 100%; padding: 1rem; border: none; border-radius: 12px; font-weight: 600; font-size: 1rem; cursor: pointer; transition: 0.3s; margin-top: 1rem; }
        .btn-save:hover { background: #0f172a; transform: translateY(-2px); }
    </style>
</head>
<body>

<div class="header-inv">
    <a href="../inventario.php" class="btn-regresar">← Regresar</a>
    <div class="container">
        <h1 style="font-weight: 600;">Nuevo Registro de Evento</h1>
        <p style="opacity: 0.8;">Módulo de control de inventario y logística</p>
    </div>
</div>

<div class="container-form">
    <div class="card-inv">
        <form action="../../../controllers/registro_eventos_inv_proc.php" method="POST">
            
            <div class="section-title">Información General</div>
            
            <div class="input-group-inv">
                <label class="label-inv">Nombre Identificador del Evento</label>
                <input type="text" name="nombre_evento" class="input-inv" placeholder="Ej. Boda Civil - Salón Principal" required>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="input-group-inv">
                        <label class="label-inv">Fecha de Ejecución</label>
                        <input type="date" name="fecha_evento" class="input-inv" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="input-group-inv">
                        <label class="label-inv">Ubicación / Destino</label>
                        <input type="text" name="direccion" class="input-inv" placeholder="Dirección del evento">
                    </div>
                </div>
            </div>

            <div class="section-title">Horarios Programados</div>

            <div class="row">
                <div class="col-md-6">
                    <div class="input-group-inv">
                        <label class="label-inv">Hora de Inicio</label>
                        <input type="time" name="hora_inicio" class="input-inv" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="input-group-inv">
                        <label class="label-inv">Hora de Finalización</label>
                        <input type="time" name="hora_fin" class="input-inv" required>
                    </div>
                </div>
            </div>

            <input type="hidden" name="id_usuario" value="<?php echo (isset($_SESSION['id_usuario'])) ? $_SESSION['id_usuario'] : '1'; ?>">

            <div class="mt-3">
                <button type="submit" class="btn-save">Finalizar y Registrar Evento</button>
                <input type="hidden" name="id_usuario" value="<?php echo $id_valido; ?>">
            </div>
        </form>
    </div>
</div>
        </form>
    </div>
</div>

</body>
</html>