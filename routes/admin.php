<?php

use App\Http\Controllers\Admin\AdsVedioController;
use App\Http\Controllers\Admin\BankController;
use App\Http\Controllers\Admin\BannerAdsController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\BannerTextController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductCategoryController;
use App\Http\Controllers\Admin\PromotionController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes - Phone Shop Management System
|--------------------------------------------------------------------------
|
| Admin routes for the phone shop customer and general management
|
*/

Route::group([
    'prefix' => 'admin',
    'as' => 'admin.',
    'middleware' => ['auth', 'checkBanned'],
], function () {

    // Dashboard and Profile
    Route::get('logs/{id}', [HomeController::class, 'logs'])->name('logs');
    Route::get('/changePassword/{user}', [HomeController::class, 'changePassword'])->name('changePassword');
    Route::post('/updatePassword/{user}', [HomeController::class, 'updatePassword'])->name('updatePassword');

    // Customer Management (Phone Shop Core)
    Route::resource('customers', CustomerController::class);
    Route::post('customers/{customer}/regenerate-qr', [CustomerController::class, 'regenerateQRCode'])->name('customers.regenerate-qr');
    Route::get('customers/{customer}/warranty-card', [CustomerController::class, 'warrantyCard'])->name('customers.warranty-card');
    Route::get('customers/{customer}/vouchers', [CustomerController::class, 'vouchers'])->name('customers.vouchers');
    Route::post('customers/{customer}/generate-voucher', [CustomerController::class, 'generateVoucher'])->name('customers.generate-voucher');

    // Product Management (Phone Shop Core)
    Route::resource('products', ProductController::class);
    Route::patch('products/{product}/update-stock', [ProductController::class, 'updateStock'])->name('products.update-stock');
    
    // Product Categories Management
    Route::resource('product-categories', ProductCategoryController::class);

    // General Settings (Useful for Phone Shop)
    Route::resource('video-upload', AdsVedioController::class);
    Route::resource('banners', BannerController::class);
    Route::resource('adsbanners', BannerAdsController::class);
    Route::resource('text', BannerTextController::class);
    Route::resource('promotions', PromotionController::class);
    Route::resource('contact', ContactController::class);
    Route::resource('bank', BankController::class);

    // Reports & Analytics
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/', [ReportController::class, 'index'])->name('index');
        Route::get('/sales', [ReportController::class, 'sales'])->name('sales');
        Route::get('/export-sales', [ReportController::class, 'exportSales'])->name('export-sales');
    });

});
