<?php

use App\Http\Controllers\ChatsController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\UsersController;
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

Route::middleware('auth:sanctum')->group(function () {

    // chats
    Route::get('/allChats', [ChatsController::class, 'index']);
    Route::post('/chat/create', [ChatsController::class, 'create']);
    Route::get('/chat/{id}/delete', [ChatsController::class, 'destroy']);
    Route::post('/chat/{id}/edit', [ChatsController::class, 'editName']);

    // messages
    Route::get('/chat/{id}/messages', [ChatsController::class, 'show']);
    Route::post('/chat/{id}/messages', [MessageController::class, 'store']);

    // search
    Route::post('/chat/users/search', [UsersController::class, 'find']);

    // chat members
    Route::post('/chat/{id}/add-member', [ChatsController::class, 'addMember']);
    Route::post('/chat/{id}/remove-member', [ChatsController::class, 'removeMember']);
});

//Broadcast::routes(['middleware' => ['auth:sanctum']]);
