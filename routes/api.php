<?php

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\InstallmentController;
use App\Http\Controllers\ValidationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::prefix('auth')->group(function () {
        Route::post('login', [AuthController::class, 'login']);
        Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
    });

    Route::middleware('auth:sanctum')->group(function () {
        // validation
        Route::post('validation', [ValidationController::class, 'store']);
        Route::get('validation', [ValidationController::class, 'index']);

        // installment
        Route::get('instalment_cars', [InstallmentController::class, 'index']);
        Route::get('instalment_cars/{id}', [InstallmentController::class, 'show']);

        // application
        Route::post('applications', [ApplicationController::class, 'store']);
        Route::get('applications', [ApplicationController::class, 'index']);
    });
});
