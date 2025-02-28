<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\UserController;
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
    Route::post('/order/update-payment-cash/{id}', [OrderController::class, 'updatePaymentCash']);
    Route::post('/order/update-payment-gcash/{id}', [OrderController::class, 'updatePaymentGCash']);
    Route::post('/order/update-cooking/{id}', [OrderController::class, 'updateCookingStatus'])->name('updateCookingStatus');
    Route::post('/order/update-served/{id}', [OrderController::class, 'updateServingStatus'])->name('updateServingStatus');
    Route::get('/order/edit/{id}', [OrderController::class, 'edit'])->name('editOrder');
    Route::post('/order/update/{id}', [OrderController::class, 'update'])->name('updateOrder');
    Route::delete('/order/delete/{id}', [OrderController::class, 'destroy'])->name('deleteOrder');

    // Discount Management
    Route::get('/discount', [DiscountController::class, 'index'])->name('discount');
    Route::get('/discount/new-discount', [DiscountController::class, 'newDiscount'])->name('newDiscount');
    Route::post('/discount/new-discount/create', [DiscountController::class, 'store'])->name('createDiscount');
    Route::get('/discount/edit-discount/{id}', [DiscountController::class, 'edit'])->name('editDiscount');
    Route::post('/discount/update/{id}', [DiscountController::class, 'update'])->name('updateDiscount');
    Route::delete('/discount/delete/{id}', [DiscountController::class, 'destroy'])->name('deleteDiscount');

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
    Route::get('/inventory-management', [InventoryController::class, 'index'])->name('inventory-management');
    Route::post('/inventory-management/in-out', [InventoryController::class, 'inOut'])->name('inventoryInOut');
    Route::delete('/inventory-management/delete/{id}', [InventoryController::class, 'destroy'])->name('deleteItem');

    // User Management
    Route::get('/user-management', [UserController::class, 'index'])->name('user-management');
    Route::get('/user-management/new-user', [UserController::class, 'newUser'])->name('newUser');
    Route::post('/user-management/new-user/create', [UserController::class, 'store'])->name('createUser');
    Route::get('/user-management/edit-user/{id}', [UserController::class, 'edit'])->name('editUser');
    Route::post('/user-management/update/{id}', [UserController::class, 'update'])->name('updateUser');
    Route::delete('/user-management/delete/{id}', [UserController::class, 'destroy'])->name('deleteUser');
});
