<?php

use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\RoleController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('login', [LoginController::class, 'login']);
    Route::post('logout', [LoginController::class, 'logout']);
});

Route::middleware('auth:sanctum')->group(function () {

    Route::prefix('employee')->group(function () {
        Route::get('/find-all', [EmployeeController::class, 'index'])->middleware('can:employee.read');
        Route::post('/', [EmployeeController::class, 'insert'])->middleware('can:employee.create');
        Route::patch('/{id}', [EmployeeController::class, 'update'])->middleware('can:employee.update');
        Route::delete('/', [EmployeeController::class, 'delete'])->middleware('can:employee.delete');
    });

    Route::prefix('role')->group(function () {
        Route::get('/find-all', [RoleController::class, 'findAll'])->middleware('can:role.create');
        Route::post('/', [RoleController::class, 'insert'])->middleware('can:role.create');
        Route::patch('/{id}', [RoleController::class, 'update'])->middleware('can:role.update');
        Route::delete('/', [RoleController::class, 'delete'])->middleware('can:role.delete');
        Route::post('/assign', [RoleController::class, 'assignToEmployee'])->middleware('can:role.assign');
    });
});
