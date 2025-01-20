<?php

use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\MunicipalityController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    Route::get('/producto/crear', [ProductController::class, 'create'])->name('product.create');
    Route::post('/producto', [ProductController::class, 'store'])->name('product.store');
    Route::get('/facturacion/crear', [InvoiceController::class, 'create'])->name('invoice.create');
    Route::get('/facturacion/descargar/{number}', [InvoiceController::class, 'download'])->name('invoice.download');
    Route::get('/facturacion', [InvoiceController::class, 'index'])->name('invoice.index');
    Route::post('/facturacion', [InvoiceController::class, 'store'])->name('invoice.store');

    Route::get('/municipalities', [MunicipalityController::class, 'search'])->name('municipalities.search');

});

require __DIR__.'/auth.php';
