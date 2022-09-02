<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\DiscountsController;
use App\Http\Controllers\ProductsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->group( function() {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::get('/products', [ProductsController::class, 'index']);
    Route::get('/collect', [CartController::class, 'collect']);
    Route::get('/total', [CartController::class, 'total']);
    Route::post('/scan', [CartController::class, 'scan']);
    Route::post('/clear', [CartController::class, 'clear']);
    Route::get('/discounts', [DiscountsController::class, 'index']);
    Route::post('/discounts/set', [DiscountsController::class, 'setDiscount']);
});

// Authentication routes

Route::post('/auth/register', [AuthController::class, 'createUser']);
Route::post('/auth/login', [AuthController::class, 'loginUser']);
Route::post('/auth/signout', [AuthController::class, 'signOut']);
