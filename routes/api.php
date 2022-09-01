<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\CartController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->get('/products', [ProductsController::class, 'index']);

Route::middleware('auth:sanctum')->get('/collect', [CartController::class, 'collect']);
Route::middleware('auth:sanctum')->get('/total', [CartController::class, 'total']);
Route::middleware('auth:sanctum')->post('/scan', [CartController::class, 'scan']);
Route::middleware('auth:sanctum')->post('/clear', [CartController::class, 'clear']);


Route::post('/auth/register', [AuthController::class, 'createUser']);
Route::post('/auth/login', [AuthController::class, 'loginUser']);
Route::post('/auth/signout', [AuthController::class, 'signOut']);
