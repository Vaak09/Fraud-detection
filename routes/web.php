<?php

use App\Http\Controllers\ScanController;
use App\Http\Controllers\CustomerController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ScanController::class, 'index'])->name('view.index');
Route::prefix('view')->group(function () {
    Route::get('/', [ScanController::class, 'index'])->name('view.index');
    Route::post('/scan/perform', [ScanController::class, 'perform'])->name('scan.perform');    
    Route::get('/scan/history', [ScanController::class, 'history'])->name('view.scan.history');
});
Route::prefix('api')->group(function () {
    Route::get('/scans', [ScanController::class, 'getAllScans']); // Fetch all scans
    Route::get('/scans/{id}', [ScanController::class, 'getScanById']); // Fetch scan by ID

    // Define API routes for customer data
    Route::get('/customers', [CustomerController::class, 'getAllCustommers']); // Fetch all customers
    Route::get('/customers/{id}', [CustomerController::class, 'getOneCustommer']); // Fetch customer by ID
});


