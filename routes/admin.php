<?php

use App\Http\Controllers\Admin\auth\AdminAuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\SearchController;
use App\Http\Controllers\Admin\MaintenanceController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\DealController;
use App\Http\Controllers\Admin\VideoSettingController;

use Illuminate\Support\Facades\Route;


//login
Route::middleware('guest:admin')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.submit');
});



Route::middleware('auth:admin')->prefix('admin')->name('admin.')->group(function () {
    
   //dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

    //categories
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

    //products
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

    //orders
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::put('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.update-status');

    //search
    Route::get('/search', [SearchController::class, 'search'])->name('search');

    //maintenance
    Route::get('/maintenance', [MaintenanceController::class, 'index'])->name('maintenance.index');
    Route::post('/maintenance', [MaintenanceController::class, 'update'])->name('maintenance.update');

    //slides
    Route::get('/slides', [SliderController::class, 'index'])->name('slides.index');
    Route::get('/slides/create', [SliderController::class, 'create'])->name('slides.create');
    Route::post('/slides', [SliderController::class, 'store'])->name('slides.store');
    Route::get('/slides/{slide}/edit', [SliderController::class, 'edit'])->name('slides.edit');
    Route::put('/slides/{slide}', [SliderController::class, 'update'])->name('slides.update');
    Route::delete('/slides/{slide}', [SliderController::class, 'destroy'])->name('slides.destroy');

    //deals
    Route::get('/deals', [DealController::class, 'index'])->name('deals.index');
    Route::get('/deals/create', [DealController::class, 'create'])->name('deals.create');
    Route::post('/deals', [DealController::class, 'store'])->name('deals.store');
    Route::get('/deals/{deal}/edit', [DealController::class, 'edit'])->name('deals.edit');
    Route::put('/deals/{deal}', [DealController::class, 'update'])->name('deals.update');
    Route::delete('/deals/{deal}', [DealController::class, 'destroy'])->name('deals.destroy');

    //video settings
    Route::get('/video-settings', [VideoSettingController::class, 'index'])->name('video-settings.index');
    Route::post('/video-settings', [VideoSettingController::class, 'update'])->name('video-settings.update');

});
