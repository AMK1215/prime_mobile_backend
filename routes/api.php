<?php

use App\Http\Controllers\Api\ChatController;
use App\Http\Controllers\Api\V1\Auth\AuthController;
use App\Http\Controllers\Api\V1\Bank\BankController;
use App\Http\Controllers\Api\V1\BannerController;
use App\Http\Controllers\Api\V1\ContactController;
use App\Http\Controllers\Api\V1\Game\GSCPlusProviderController;
use App\Http\Controllers\Api\V1\Player\AutoPlayerCreateController;
use App\Http\Controllers\Api\V1\ProductCategoryController;
use App\Http\Controllers\Api\V1\ProductController;
use App\Http\Controllers\Api\V1\ProductStatusController;
use App\Http\Controllers\Api\V1\PromotionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/player-change-password', [AuthController::class, 'playerChangePassword']);
Route::post('/logout', [AuthController::class, 'logout']);

// auto player create route
Route::post('/guest-register', [AutoPlayerCreateController::class, 'register']);

Route::group(['middleware' => ['auth:sanctum']], function () {

    // user api
    Route::get('user', [AuthController::class, 'getUser']);
    Route::get('/banks', [GSCPlusProviderController::class, 'banks']);
    // Chat System APIs
    Route::get('/chat/global-info', [ChatController::class, 'getGlobalChatInfo']);
    Route::post('/chat/join', [ChatController::class, 'joinGlobalChat']);
    Route::post('/chat/leave', [ChatController::class, 'leaveGlobalChat']);
    Route::post('/chat/send-message', [ChatController::class, 'sendMessage']);
    Route::get('/chat/messages', [ChatController::class, 'getMessages']);
    Route::post('/chat/update-status', [ChatController::class, 'updateOnlineStatus']);
    Route::get('/chat/online-users', [ChatController::class, 'getOnlineUsers']);
});

// Public API routes for client site
Route::get('winnerText', [BannerController::class, 'winnerText']);
Route::get('banner_Text', [BannerController::class, 'bannerText']);
Route::get('popup-ads-banner', [BannerController::class, 'AdsBannerIndex']);
Route::get('banner', [BannerController::class, 'index']);
Route::get('videoads', [BannerController::class, 'ApiVideoads']);
Route::get('promotion', [PromotionController::class, 'index']);

// Product API routes for client site
Route::prefix('products')->group(function () {
    Route::get('/', [ProductController::class, 'index']);
    Route::get('/featured', [ProductController::class, 'featured']);
    Route::get('/latest', [ProductController::class, 'latest']);
    Route::get('/best-sellers', [ProductController::class, 'bestSellers']);
    Route::get('/new-arrivals', [ProductController::class, 'newArrivals']);
    Route::get('/search', [ProductController::class, 'search']);
    Route::get('/category/{categoryId}', [ProductController::class, 'byCategory']);
    Route::get('/{id}', [ProductController::class, 'show']);
});

// Product Category API routes
Route::prefix('categories')->group(function () {
    Route::get('/', [ProductCategoryController::class, 'index']);
    Route::get('/all', [ProductCategoryController::class, 'all']);
    Route::get('/{id}', [ProductCategoryController::class, 'show']);
});

// Warranty API Routes (Public - for QR code scanning)
Route::prefix('warranty')->group(function () {
    Route::get('/customer/{customer_id}', [\App\Http\Controllers\Api\V1\WarrantyController::class, 'getWarrantyByCustomerId']);
    Route::get('/status/{customer_id}', [\App\Http\Controllers\Api\V1\WarrantyController::class, 'getWarrantyStatus']);
});

// Voucher API Routes (Public - for QR code scanning)
Route::prefix('vouchers')->group(function () {
    Route::get('/{voucher_code}', [\App\Http\Controllers\Api\V1\VoucherController::class, 'getVoucherByCode']);
    Route::get('/validate/{voucher_code}', [\App\Http\Controllers\Api\V1\VoucherController::class, 'validateVoucher']);
    Route::post('/use', [\App\Http\Controllers\Api\V1\VoucherController::class, 'useVoucher']);
    Route::get('/customer/{customer_id}', [\App\Http\Controllers\Api\V1\VoucherController::class, 'getCustomerVouchers']);
    Route::get('/customer/{customer_id}/stats', [\App\Http\Controllers\Api\V1\VoucherController::class, 'getVoucherStats']);
});

// Product Status API routes
Route::prefix('statuses')->group(function () {
    Route::get('/', [ProductStatusController::class, 'index']);
    Route::get('/available', [ProductStatusController::class, 'available']);
    Route::get('/{id}', [ProductStatusController::class, 'show']);
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::post('/change-password', [AuthController::class, 'changePassword']);
});
