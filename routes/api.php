<?php

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\TagsController;
use App\Http\Controllers\Api\Auth\AuthController;

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

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);


Route::group(['middleware' => 'auth:sanctum'], function () {

    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('verified', [AuthController::class, 'verified']);

    Route::group(['middleware' => 'verified.user'], function () {
        Route::get('tags', [TagsController::class, 'index']);
        Route::get('tags/{tag}/show', [TagsController::class, 'show']);
        Route::post('tags/store', [TagsController::class, 'store']);
        Route::put('tags/{tag}/update', [TagsController::class, 'update']);
        Route::delete('tags/{tag}/delete', [TagsController::class, 'destroy']);

        Route::get('posts', [PostController::class, 'index']);
        Route::get('posts/{post}/show', [PostController::class, 'show']);
        Route::post('posts/store', [PostController::class, 'store']);
        Route::put('posts/{post}/update', [PostController::class, 'update']);
        Route::delete('posts/{post}/delete', [PostController::class, 'destroy']);
        Route::post('posts/onlyTrashed', [PostController::class, 'onlyTrashed']);
        Route::post('posts/{id}/restore', [PostController::class, 'restore']);
        Route::post('posts/{id}/forceDelete', [PostController::class, 'forceDelete']);


        Route::get('stats', [StatusController::class, 'index']);
    });
});
