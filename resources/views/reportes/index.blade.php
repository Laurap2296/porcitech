@extends('layouts.app')

@section('title', 'Reportes')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-success">
            <i class="fas fa-chart-bar"></i> Centro de Reportes
        </h2>
    </div>

    <div class="row">

        <!-- Animales -->
        <div class="col-md-4 mb-4">
            <div class="card shadow border-success h-100">
                <div class="card-body text-center">
                    <i class="fas fa-paw fa-3x text-success mb-3"></i>

                    <h4>Inventario de Animales</h4>

                    <p class="text-muted">
                        Consulta el inventario general de animales.
                    </p>

                    <a href="{{ route('reportes.animales') }}" class="btn btn-success">
                        <i class="fas fa-eye"></i> Ver Reporte
                    </a>
                </div>
            </div>
        </div>

        <!-- Granjas -->
        <div class="col-md-4 mb-4">
            <div class="card shadow border-primary h-100">
                <div class="card-body text-center">
                    <i class="fas fa-warehouse fa-3x text-primary mb-3"></i>

                    <h4>Granjas</h4>

                    <p class="text-muted">
                        Información de todas las granjas registradas.
                    </p>

                    <a href="{{ route('reportes.granjas') }}" class="btn btn-primary">
                        <i class="fas fa-eye"></i> Ver Reporte
                    </a>
                </div>
            </div>
        </div>

        <!-- Alimentación -->
        <div class="col-md-4 mb-4">
            <div class="card shadow border-warning h-100">
                <div class="card-body text-center">
                    <i class="fas fa-seedling fa-3x text-warning mb-3"></i>

                    <h4>Alimentación</h4>

                    <p class="text-muted">
                        Historial de alimentación de los animales.
                    </p>

                    <a href="{{ route('reportes.alimentacion') }}" class="btn btn-warning text-white">
                        <i class="fas fa-eye"></i> Ver Reporte
                    </a>
                </div>
            </div>
        </div>

        <!-- Sanidad -->
        <div class="col-md-4 mb-4">
            <div class="card shadow border-danger h-100">
                <div class="card-body text-center">
                    <i class="fas fa-syringe fa-3x text-danger mb-3"></i>

                    <h4>Sanidad</h4>

                    <p class="text-muted">
                        Vacunas, tratamientos y controles sanitarios.
                    </p>

                    <a href="{{ route('reportes.sanidad') }}" class="btn btn-danger">
                        <i class="fas fa-eye"></i> Ver Reporte
                    </a>
                </div>
            </div>
        </div>

        <!-- Producción -->
        <div class="col-md-4 mb-4">
            <div class="card shadow border-info h-100">
                <div class="card-body text-center">
                    <i class="fas fa-chart-line fa-3x text-info mb-3"></i>

                    <h4>Producción</h4>

                    <p class="text-muted">
                        Historial de producción por animal.
                    </p>

                    <a href="{{ route('reportes.produccion') }}" class="btn btn-info text-white">
                        <i class="fas fa-eye"></i> Ver Reporte
                    </a>
                </div>
            </div>
        </div>

        <!-- Ventas -->
        <div class="col-md-4 mb-4">
            <div class="card shadow border-secondary h-100">
                <div class="card-body text-center">
                    <i class="fas fa-dollar-sign fa-3x text-secondary mb-3"></i>

                    <h4>Ventas</h4>

                    <p class="text-muted">
                        Historial de ventas realizadas.
                    </p>

                    <a href="{{ route('reportes.ventas') }}" class="btn btn-secondary">
                        <i class="fas fa-eye"></i> Ver Reporte
                    </a>
                </div>
            </div>
        </div>

        <!-- Reproducción -->
        <div class="col-md-6 mb-4">
            <div class="card shadow border-success h-100">
                <div class="card-body text-center">

                    <i class="fas fa-heart fa-3x text-success mb-3"></i>

                    <h4>Historial de Reproducción</h4>

                    <p class="text-muted">
                        Servicios, montas, inseminaciones y partos registrados.
                    </p>

                    <a href="{{ route('reportes.reproduccion') }}" class="btn btn-success">
                        <i class="fas fa-eye"></i> Ver Historial
                    </a>

                </div>
            </div>
        </div>

        <!-- Análisis -->
        <div class="col-md-6 mb-4">
            <div class="card shadow border-dark h-100">
                <div class="card-body text-center">

                    <i class="fas fa-award fa-3x text-dark mb-3"></i>

                    <h4>Análisis de Cerdas</h4>

                    <p class="text-muted">
                        Ranking de productividad, partos y desempeño reproductivo.
                    </p>

                    <a href="{{ route('reportes.analisis') }}" class="btn btn-dark">
                        <i class="fas fa-chart-bar"></i> Ver Análisis
                    </a>

                </div>
            </div>
        </div>

    </div>

</div>

@endsection