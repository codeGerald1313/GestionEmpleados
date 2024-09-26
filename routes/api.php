<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmpleadoController;

// Ruta para filtrar empleados
Route::get('empleados/filtrar', [EmpleadoController::class, 'filtrar'])->name('api.empleados.filtrar');
