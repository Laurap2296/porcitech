@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <!-- 🔥 BANNER PRINCIPAL -->
    <div class="p-4 mb-4 rounded shadow text-white"
         style="background: linear-gradient(135deg, #28a745, #218838);">
        <h2 class="mb-1">🐖 PorciTech - Finca la marias</h2>
        <p class="mb-0">Gestión inteligente de producción porcina</p>
    </div>

    <!-- 🎠 CARRUSEL DE FINCA -->
    <div class="container-fluid mb-4">

        <div id="fincaCarousel" class="carousel slide shadow rounded overflow-hidden"
             data-bs-ride="carousel"
             data-bs-interval="3000">

            <div class="carousel-inner">

                <!-- 🐷 finca1 -->
                <div class="carousel-item active">
                    <img src="/images/finca1.jpg" class="d-block w-100"
                         style="height: 350px; object-fit: cover; filter: brightness(65%);">
                    <div class="carousel-caption">
                        <h3>🐖 Área de Cerdos</h3>
                        <p>Control de crecimiento y producción</p>
                    </div>
                </div>

                <!-- 🌾 finca2 -->
                <div class="carousel-item">
                    <img src="/images/finca2.jpg" class="d-block w-100"
                         style="height: 350px; object-fit: cover; filter: brightness(65%);">
                    <div class="carousel-caption">
                        <h3>🌾 Alimentación</h3>
                        <p>Control de dieta y nutrición</p>
                    </div>
                </div>

                <!-- 💉 finca3 -->
                <div class="carousel-item">
                    <img src="/images/finca3.jpg" class="d-block w-100"
                         style="height: 350px; object-fit: cover; filter: brightness(65%);">
                    <div class="carousel-caption">
                        <h3>💉 Salud Animal</h3>
                        <p>Vacunación y control sanitario</p>
                    </div>
                </div>

                <!-- 🏡 finca4 -->
                <div class="carousel-item">
                    <img src="/images/finca4.jpg" class="d-block w-100"
                         style="height: 350px; object-fit: cover; filter: brightness(65%);">
                    <div class="carousel-caption">
                        <h3>🏡 Instalaciones</h3>
                        <p>Infraestructura de la finca</p>
                    </div>
                </div>

                <!-- 🌿 finca5 -->
                <div class="carousel-item">
                    <img src="/images/finca5.jpg" class="d-block w-100"
                         style="height: 350px; object-fit: cover; filter: brightness(65%);">
                    <div class="carousel-caption">
                        <h3>🌿 Producción Natural</h3>
                        <p>Ambiente controlado y sostenible</p>
                    </div>
                </div>

                <!-- 🚜 finca6 -->
                <div class="carousel-item">
                    <img src="/images/finca6.jpg" class="d-block w-100"
                         style="height: 350px; object-fit: cover; filter: brightness(60%);">
                    <div class="carousel-caption">
                        <h2>🐖 Bienvenido a PorciTech</h2>
                        <p>Sistema integral de gestión porcina moderna</p>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- 📈 MENSAJE FINAL -->
    <div class="card shadow border-0">
        <div class="card-body text-center">
            <h4>📊 Sistema PorciTech</h4>
            <p class="text-muted mb-0">
                Plataforma diseñada para la gestión eficiente de granjas porcinas,
                control de producción, salud y alimentación en tiempo real.
            </p>
        </div>
    </div>

</div>

@endsection