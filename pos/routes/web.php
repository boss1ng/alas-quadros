<?php

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

    Route::get('/menu-management', function () {
        return view('menu-management');
    })->name('menu-management');

    Route::get('/user-management', function () {
        return view('user-management');
    })->name('user-management');
});
