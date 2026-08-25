<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PorciTech</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- 🔥 ICONOS BOOTSTRAP -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        body{
            margin:0;
            background:#f4f6f9;
        }

        .sidebar{
            width:250px;
            height:100vh;
            background:#198754;
            position:fixed;
            left:0;
            top:0;
            color:white;
            overflow-y:auto;
        }

        .sidebar h3{
            text-align:center;
            padding:20px;
            margin:0;
        }

        .sidebar a{
            display:block;
            color:white;
            text-decoration:none;
            padding:12px 20px;
            font-size:15px;
        }

        .sidebar a i{
            margin-right:8px;
        }

        .sidebar a:hover{
            background:#146c43;
        }

        .content{
            margin-left:250px;
            padding:20px;
        }

        .topbar{
            background:white;
            padding:15px;
            border-radius:10px;
            margin-bottom:20px;
        }
    </style>

</head>

<body>

<div class="sidebar">

    <h3>🐖 PorciTech</h3>

    <a href="{{ route('dashboard') }}"><i class="bi bi-house-door"></i> Dashboard</a>

    <a href="{{ url('/granjas') }}"><i class="bi bi-building"></i> Granjas</a>

    <a href="{{ url('/animales') }}"><i class="bi bi-piggy-bank"></i> Animales</a>

    <a href="{{ url('/reproducciones') }}"><i class="bi bi-arrow-repeat"></i> Reproducción</a>

    <a href="{{ url('/pajillas') }}"><i class="bi bi-droplet"></i> Pajillas</a>

    <a href="{{ url('/alimentaciones') }}"><i class="bi bi-egg-fried"></i> Alimentación</a>

    <a href="{{ url('/producciones') }}"><i class="bi bi-box-seam"></i> Producción</a>

    <a href="{{ url('/sanidades') }}"><i class="bi bi-capsule"></i> Sanidad</a>

    <a href="{{ url('/ventas') }}"><i class="bi bi-cash-coin"></i> Ventas</a>

    <a href="{{ url('/usuarios') }}"><i class="bi bi-people"></i> Usuarios</a>

    <a href="{{ url('/reportes') }}"><i class="bi bi-bar-chart"></i> Reportes</a>

</div>

<div class="content">

    <!-- 🔥 TOPBAR -->
    <div class="topbar d-flex justify-content-between align-items-center">

        <h4>Sistema de Gestión Porcina PorciTech</h4>

        <div class="d-flex align-items-center gap-2">

            <span>
                👋 Bienvenido, <strong>{{ auth()->user()->name }}</strong>
            </span>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="btn btn-danger btn-sm">
                    Cerrar sesión
                </button>
            </form>

        </div>

    </div>

    <!-- CONTENIDO DINÁMICO -->
    @yield('content')

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>