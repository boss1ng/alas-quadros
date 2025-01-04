<?php

use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
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
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/order/', [OrderController::class, 'index'])->name('order');
    Route::get('/order/new-order', [OrderController::class, 'orderForm'])->name('placeOrder');
    Route::post('/order/new-order/create', [OrderController::class, 'store'])->name('createOrder');
    Route::post('/order/update-payment/{id}', [OrderController::class, 'updatePayment'])->name('updatePayment');
    Route::get('order/edit/{id}', [OrderController::class, 'edit'])->name('editOrder');

    Route::get('/sales', function () {
        return view('sales');
    })->name('sales');

    Route::get('/menu-management', [MenuController::class, 'index'])->name('menu-management');
    Route::post('/menu-management/create', [MenuController::class, 'createMenu'])->name('store');
    Route::delete('/menu-management/delete/{id}', [MenuController::class, 'deleteMenu'])->name('delete');
    Route::get('menu-management/edit/{id}', [MenuController::class, 'editMenu'])->name('edit');
    Route::post('menu-management/update/{id}', [MenuController::class, 'updateMenu'])->name('update');

    Route::get('/user-management', function () {
        return view('user-management');
    })->name('user-management');
});
