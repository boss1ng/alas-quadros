<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\SalesController;
use App\Models\Menu;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    // Dashboard
    Route::get('/dashboard/', [DashboardController::class, 'index'])->name('dashboard');

    // Order Management
    Route::get('/order/', [OrderController::class, 'index'])->name('order');
    Route::get('/order/new-order', [OrderController::class, 'orderForm'])->name('placeOrder');
    Route::post('/order/new-order/create', [OrderController::class, 'store'])->name('createOrder');
    Route::post('/order/update-payment/{id}', [OrderController::class, 'updatePayment'])->name('updatePayment');
    Route::post('/order/update-cooking/{id}', [OrderController::class, 'updateCookingStatus'])->name('updateCookingStatus');
    Route::post('/order/update-served/{id}', [OrderController::class, 'updateServingStatus'])->name('updateServingStatus');
    Route::get('/order/edit/{id}', [OrderController::class, 'edit'])->name('editOrder');
    Route::post('/order/update/{id}', [OrderController::class, 'update'])->name('updateOrder');
    Route::delete('/order/delete/{id}', [OrderController::class, 'destroy'])->name('deleteOrder');

    // Sales
    Route::get('/sales/', [SalesController::class, 'index'])->name('sales');
    // Report
    Route::get('/sales/pdf', [SalesController::class, 'exportPdf'])->name('sales.pdf');

    // Menu Management
    Route::get('/menu-management', [MenuController::class, 'index'])->name('menu-management');
    Route::post('/menu-management/create', [MenuController::class, 'createMenu'])->name('store');
    Route::delete('/menu-management/delete/{id}', [MenuController::class, 'deleteMenu'])->name('delete');
    Route::get('menu-management/edit/{id}', [MenuController::class, 'editMenu'])->name('edit');
    Route::post('menu-management/update/{id}', [MenuController::class, 'updateMenu'])->name('update');

    // Inventory Management
    Route::get('/inventory-management', function () {
        return view('inventory.inventory-management');
    })->name('inventory-management');

    // User Management
    Route::get('/user-management', function () {
        return view('user.user-management');
    })->name('user-management');
});
