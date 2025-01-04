<?php

use App\Http\Controllers\MenuController;
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

    Route::get('/order', function () {
        return view('order');
    })->name('order');

    Route::get('/sales', function () {
        return view('sales');
    })->name('sales');

    Route::get('/menu-management', [MenuController::class, 'index'])->name('menu-management');
    Route::post('/menu-management/create', [MenuController::class, 'createMenu'])->name('store');
    Route::delete('/menu-management/delete/{id}', [MenuController::class, 'deleteMenu'])->name('delete');
    // Route::get('menu-management/edit/{id}', [MenuController::class, 'editMenu'])->name('edit');
    Route::put('menu-management/update/{id}', [MenuController::class, 'updateMenu'])->name('update');


    Route::get('/user-management', function () {
        return view('user-management');
    })->name('user-management');
});
