<?php

use App\Http\Controllers\PrincipalController;
use App\Http\Controllers\IngresoController;
use App\Http\Controllers\EstudianteController;
use App\Http\Controllers\UsuarioController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Route;


// Auth::routes();
Auth::routes(['register' => false]);

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function(){    
    // Rutas de sistema
    Route::get('/', [PrincipalController::class, 'index']);
    Route::get('principal', [PrincipalController::class, 'index']);
    
    Route::get('ingreso', [IngresoController::class, 'index']);
    Route::get('ingreso/search', [IngresoController::class, 'search'])->name('search');

    Route::middleware([AdminMiddleware::class])->group(function(){    
        Route::get('estudiantes', [EstudianteController::class, 'index'])->name('students.index');
        Route::get('estudiantes/search', [EstudianteController::class, 'search'])->name('searchStudent');
        Route::get('estudiantes/create', [EstudianteController::class, 'create']);
        Route::post('estudiantes', [EstudianteController::class, 'store'])->name('students.store');
        Route::get('estudiantes/{id}/edit', [EstudianteController::class, 'edit'])->name('students.edit');
        Route::put('estudiantes/{id}', [EstudianteController::class, 'update'])->name('students.update');
    
        Route::get('usuarios', [UsuarioController::class, 'index'])->name('user.index');
        Route::get('usuarios/search', [UsuarioController::class, 'search'])->name('user.search');
        Route::get('usuarios/create', [UsuarioController::class, 'create'])->name('user.create');
        Route::post('usuarios', [UsuarioController::class, 'store'])->name('user.store');
        Route::get('usuarios/{id}/edit', [UsuarioController::class, 'edit'])->name('user.edit');
        Route::put('usuarios/{id}', [UsuarioController::class, 'update'])->name('user.update');
    });
});
