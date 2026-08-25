<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GranjaController;
use App\Http\Controllers\AnimalController;
use App\Http\Controllers\PajillaController;
use App\Http\Controllers\ReproduccionController;
use App\Http\Controllers\AlimentacionController;
use App\Http\Controllers\ProduccionController;
use App\Http\Controllers\SanidadController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\ReporteExportController;
use App\Http\Controllers\DashboardController;


/*
|--------------------------------------------------------------------------
| PRINCIPAL
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('login');
});


/*
|--------------------------------------------------------------------------
| LOGIN
|--------------------------------------------------------------------------
*/

Route::get('/login', [LoginController::class, 'index'])
    ->name('login');

Route::post('/login', [LoginController::class, 'login'])
    ->name('login.procesar');

Route::post('/logout', [LoginController::class, 'logout'])
    ->name('logout');


/*
|--------------------------------------------------------------------------
| RUTAS PARA USUARIOS LOGUEADOS
| ADMIN + OPERARIO
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD
    |--------------------------------------------------------------------------
    */

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');


    /*
    |--------------------------------------------------------------------------
    | MÓDULOS
    |--------------------------------------------------------------------------
    */

    Route::resource('granjas', GranjaController::class);

    Route::resource('animales', AnimalController::class);

    Route::resource('pajillas', PajillaController::class);

    Route::resource('reproducciones', ReproduccionController::class);

    Route::resource('alimentaciones', AlimentacionController::class);


    /*
    |--------------------------------------------------------------------------
    | AJUSTE DE ALIMENTACIÓN
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/alimentaciones/ajuste/{id}/edit',
        [AlimentacionController::class, 'editarAjuste']
    )->name('alimentaciones.ajuste.edit');

    Route::put(
        '/alimentaciones/ajuste/{id}',
        [AlimentacionController::class, 'actualizarAjuste']
    )->name('alimentaciones.ajuste.update');


    /*
    |--------------------------------------------------------------------------
    | MÓDULOS RESTANTES
    |--------------------------------------------------------------------------
    */

    Route::resource('producciones', ProduccionController::class);

    Route::resource('sanidades', SanidadController::class);

    Route::resource('ventas', VentaController::class);

});


/*
|--------------------------------------------------------------------------
| SOLO ADMINISTRADOR
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'rol:Administrador'])->group(function () {


    /*
    |--------------------------------------------------------------------------
    | USUARIOS
    |--------------------------------------------------------------------------
    */

    Route::resource('usuarios', UserController::class);


    /*
    |--------------------------------------------------------------------------
    | REPORTES
    |--------------------------------------------------------------------------
    */

    Route::get('/reportes', [ReporteController::class, 'index'])
        ->name('reportes.index');


    /*
    |--------------------------------------------------------------------------
    | REPORTE DE ANIMALES
    |--------------------------------------------------------------------------
    */

    Route::get('/reportes/animales', [ReporteController::class, 'animales'])
        ->name('reportes.animales');


    /*
    |--------------------------------------------------------------------------
    | REPORTE DE GRANJAS
    |--------------------------------------------------------------------------
    */

    Route::get('/reportes/granjas', [ReporteController::class, 'granjas'])
        ->name('reportes.granjas');


    /*
    |--------------------------------------------------------------------------
    | REPORTE DE ALIMENTACIÓN
    |--------------------------------------------------------------------------
    */

    Route::get('/reportes/alimentacion', [ReporteController::class, 'alimentacion'])
        ->name('reportes.alimentacion');


    /*
    |--------------------------------------------------------------------------
    | REPORTE DE SANIDAD
    |--------------------------------------------------------------------------
    */

    Route::get('/reportes/sanidad', [ReporteController::class, 'sanidad'])
        ->name('reportes.sanidad');


    /*
    |--------------------------------------------------------------------------
    | REPORTE DE PRODUCCIÓN
    |--------------------------------------------------------------------------
    */

    Route::get('/reportes/produccion', [ReporteController::class, 'produccion'])
        ->name('reportes.produccion');


    /*
    |--------------------------------------------------------------------------
    | REPORTE DE VENTAS
    |--------------------------------------------------------------------------
    */

    Route::get('/reportes/ventas', [ReporteController::class, 'ventas'])
        ->name('reportes.ventas');


    /*
    |--------------------------------------------------------------------------
    | REPORTE DE REPRODUCCIÓN
    |--------------------------------------------------------------------------
    */

    Route::get('/reportes/reproduccion', [ReporteController::class, 'reproduccion'])
        ->name('reportes.reproduccion');


    /*
    |--------------------------------------------------------------------------
    | ANÁLISIS DE CERDAS
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/reportes/analisis-cerdas',
        [ReporteController::class, 'analisisCerdas']
    )->name('reportes.analisis');


    /*
    |--------------------------------------------------------------------------
    | EXPORTACIÓN PDF
    |--------------------------------------------------------------------------
    */

    Route::get('/reportes/animales/pdf', [ReporteExportController::class, 'animalesPDF'])
        ->name('reportes.animales.pdf');

    Route::get('/reportes/granjas/pdf', [ReporteExportController::class, 'granjasPDF'])
        ->name('reportes.granjas.pdf');

    Route::get('/reportes/alimentacion/pdf', [ReporteExportController::class, 'alimentacionPDF'])
        ->name('reportes.alimentacion.pdf');

    Route::get('/reportes/sanidad/pdf', [ReporteExportController::class, 'sanidadPDF'])
        ->name('reportes.sanidad.pdf');

    Route::get('/reportes/produccion/pdf', [ReporteExportController::class, 'produccionPDF'])
        ->name('reportes.produccion.pdf');

    Route::get('/reportes/ventas/pdf', [ReporteExportController::class, 'ventasPDF'])
        ->name('reportes.ventas.pdf');

    Route::get('/reportes/reproduccion/pdf', [ReporteExportController::class, 'reproduccionPDF'])
        ->name('reportes.reproduccion.pdf');

    Route::get(
        '/reportes/analisis-cerdas/pdf',
        [ReporteExportController::class, 'analisisCerdasPDF']
    )->name('reportes.analisis.pdf');


    /*
    |--------------------------------------------------------------------------
    | EXPORTACIÓN EXCEL
    |--------------------------------------------------------------------------
    */

    Route::get('/reportes/animales/excel', [ReporteExportController::class, 'animalesExcel'])
        ->name('reportes.animales.excel');

    Route::get('/reportes/granjas/excel', [ReporteExportController::class, 'granjasExcel'])
        ->name('reportes.granjas.excel');

    Route::get('/reportes/alimentacion/excel', [ReporteExportController::class, 'alimentacionExcel'])
        ->name('reportes.alimentacion.excel');

    Route::get('/reportes/sanidad/excel', [ReporteExportController::class, 'sanidadExcel'])
        ->name('reportes.sanidad.excel');

    Route::get('/reportes/produccion/excel', [ReporteExportController::class, 'produccionExcel'])
        ->name('reportes.produccion.excel');

    Route::get('/reportes/ventas/excel', [ReporteExportController::class, 'ventasExcel'])
        ->name('reportes.ventas.excel');

    Route::get('/reportes/reproduccion/excel', [ReporteExportController::class, 'reproduccionExcel'])
        ->name('reportes.reproduccion.excel');

    Route::get(
        '/reportes/analisis-cerdas/excel',
        [ReporteExportController::class, 'analisisCerdasExcel']
    )->name('reportes.analisis.excel');

});