<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmpleadoController;

// Ruta principal
Route::get('/', function () {
    return view('empleados'); // Vista principal de empleados
});

// Rutas de empleados
Route::prefix('empleados')->group(function () {
    Route::get('/', [EmpleadoController::class, 'index'])->name('empleados.index');
    Route::get('create', [EmpleadoController::class, 'create'])->name('empleados.create');
    Route::post('/', [EmpleadoController::class, 'saveOrUpdate'])->name('empleados.store');
    Route::get('{empleado}', [EmpleadoController::class, 'show'])->name('empleados.show');
    Route::get('{empleado}/edit', [EmpleadoController::class, 'edit'])->name('empleados.edit');
    Route::put('{empleado}', [EmpleadoController::class, 'saveOrUpdate'])->name('empleados.update');
    Route::delete('{empleado}', [EmpleadoController::class, 'destroy'])->name('empleados.destroy');
    Route::post('darDeBaja/{id}', [EmpleadoController::class, 'darDeBaja'])->name('empleados.darDeBaja');
    Route::post('activar/{id}', [EmpleadoController::class, 'activar'])->name('empleados.activar');
});
