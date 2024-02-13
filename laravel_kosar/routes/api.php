<?php

use App\Http\Controllers\BasketController;
use App\Http\Controllers\UserController;
use App\Models\Basket;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth.basic')->group(function () {
    Route::get('user_basket', [BasketController::class, 'userBasket']);
});

Route::get('baskets', [BasketController::class, 'index']);
Route::get('baskets/{user_id}/{item_id}', [BasketController::class, 'show']);
Route::post('baskets', [BasketController::class, 'store']);


Route::get('baskets/{user_id}/{type_id}', [BasketController::class, 'bizonyosTermektipus']);
Route::delete('basket_today_delete', [BasketController::class, 'basketTodayDelete']);
