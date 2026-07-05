<?php
include("controllers/login_proc.php");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CixEventos - Login</title>
    <link rel="icon" type="image/png" href="assets/content/logotip-cix.png"> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        :root {
            --isa: #0077ff;
            --max: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
        }

        body {
            height: 100%;
         margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;

            justify-content: center;
    
            align-items: center;
            background:linear-gradient(
            rgba(0, 102, 255, 0.55),
            rgba(0, 102, 255, 0.55) ),url("assets/content/fondo-login.png");
            background-size: cover;
             background-position: center;
             background-repeat: no-repeat;
             background-attachment: fixed;
             position: relative;
            }

        .cix-card {
            background: #fff;
            border-radius: 18px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            padding: 28px 32px 32px;
            width: 100%;
            max-width: 420px;
        }

        #logoytpe-cix {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            box-shadow: 0 0 10px var(--isa);
            display: block;
            margin: 0 auto 10px;
        }

        .cix-titulo {
            display: flex;
            justify-content: center;
            align-items: baseline;
            gap: 8px;
            margin-bottom: 2px;
        }
        .cix-titulo h1 {
            font-family: var(--max);
            font-size: 2rem;
            line-height: 1;
            color: #222;
        }
        .cix-titulo h1.azul { color: var(--isa); }

        .cix-sub {
            text-align: center;
            font-family: var(--max);
            font-size: 0.68rem;
            color: #999;
            letter-spacing: 0.07em;
            margin-bottom: 20px;
        }

        .cix-form-title {
            text-align: center;
            font-size: 0.8rem;
            font-weight: 700;
            letter-spacing: 0.12em;
            color: var(--isa);
            margin-bottom: 16px;
        }

        .cix-form .form-label {
            font-size: 0.78rem;
            font-family: var(--max);
            color: #444;
            margin-bottom: 2px;
        }

        .cix-form .form-control {
            font-size: 0.82rem;
            padding: 5px 10px;
            border-radius: 8px;
            border: 1px solid #ccc;
            height: 36px;
        }

        .cix-form .form-control:focus {
            border-color: var(--isa);
            box-shadow: 0 0 0 2px rgba(0,119,255,0.15);
        }

        .cix-form .mb-3 {
            margin-bottom: 10px !important;
        }

        .cix-form .btn-primary {
            background-color: var(--isa);
            border: none;
            border-radius: 9px;
            padding: 9px;
            font-size: 0.9rem;
            font-weight: 600;
            margin-top: 8px;
            transition: background 0.2s, transform 0.1s;
        }
        .cix-form .btn-primary:hover {
            background-color: #005fcc;
            transform: translateY(-1px);
        }

        .cix-register-link {
            text-align: center;
            font-size: 0.75rem;
            color: #888;
            margin-top: 10px;
            margin-bottom: 0;
        }
        .cix-register-link a {
            color: var(--isa);
            font-weight: 600;
            text-decoration: none;
        }
        .cix-register-link a:hover { text-decoration: underline; }
    </style>
</head>
<body>

    <div class="cix-card">

        <img id="logoytpe-cix" src="assets/content/logotype.png" alt="Logo CIX">

        <div class="cix-titulo">
            <h1>CIX</h1>
            <h1 class="azul">Eventos</h1>
        </div>

        <p class="cix-sub">RENTA DE INMOBILIARIO · FIESTAS TEMÁTICAS</p>

        <form class="cix-form" action="" method="POST">

            <p class="cix-form-title">LOGIN</p>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" name="usuario" required placeholder="Ingresa tu correo registrado">
            </div>

            <div class="mb-3">
                <label class="form-label">Contraseña</label>
                <input type="password" class="form-control" name="password" required placeholder="Ingresa tu contraseña">
            </div>

            <button type="submit" name="btn_ingresar" value="ok" class="btn btn-primary w-100">Iniciar Sesión</button>

            <p class="cix-register-link">¿No tienes una cuenta? <a href="index.php">¡Regístrate!</a></p>

        </form>
    </div>

    <script src="config/DBconnect.js" defer></script>
</body>
</html>