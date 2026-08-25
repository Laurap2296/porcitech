<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login - PorciTech</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            background: linear-gradient(135deg, #0b6623, #1b8f3a);
            overflow: hidden;
        }

        /* 🐷 fondo de cerdos */
        body::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('/images/cerdos.jpg') no-repeat center center/cover;
            opacity: 0.18;
            z-index: 0;
        }

        .login-card {
            width: 100%;
            max-width: 420px;
            border-radius: 15px;
            padding: 30px;
            background: #fff;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            position: relative;
            z-index: 1;
            border-top: 6px solid #0b6623;
        }

        .logo-img {
            width: 80px;
            display: block;
            margin: 0 auto 10px auto;
        }

        .title {
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            color: #0b6623;
        }

        .btn-login {
            background: #0b6623;
            color: white;
        }

        .btn-login:hover {
            background: #095a1c;
            color: white;
        }

        label {
            color: #0b6623;
            font-weight: 500;
        }
    </style>
</head>

<body>

<div class="login-card">

    <!-- 🟢 LOGO ARRIBA -->
    <img src="/images/logo.png" class="logo-img">

    <div class="title">PorciTech</div>

    <p class="text-center text-muted">Inicia sesión en el sistema</p>

    @if($errors->any())
        <div class="alert alert-danger">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('login.procesar') }}">
        @csrf

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Contraseña</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-login w-100">
            Iniciar sesión
        </button>
       
    </form>

</div>

</body>
</html>