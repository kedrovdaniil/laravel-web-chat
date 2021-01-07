<?php

use App\Http\Controllers\ChatsController;
use App\Http\Controllers\MessageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Broadcast;
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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/allChats', [ChatsController::class, 'index']);
Route::get('/chat/{id}', [ChatsController::class, 'show']);
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/chat/{id}', [MessageController::class, 'store']);
});

Broadcast::routes();

