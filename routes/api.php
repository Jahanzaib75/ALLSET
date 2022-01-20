<?php

use App\Http\Controllers\Api\AdminAuthController;
use App\Http\Controllers\Api\UserAuthController;
use App\Http\Controllers\Controller;
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
////////Admin Auth Api//////////////////////
Route::prefix('/admin')->group(function () {

    Route::post('/register', [AdminAuthController::class, 'register']);
    Route::post('/login', [AdminAuthController::class, 'auth']);

    Route::group(['middleware' => 'auth:adminapi'], function () {
        Route::post('/logout', [AdminAuthController::class, 'indexlogout']);
    });
});

//////User Auth Api/////////////////////
Route::prefix('/user')->group(function () {

    Route::post('/register', [UserAuthController::class, 'register']);
    Route::post('/login', [UserAuthController::class, 'auth']);

    Route::group(['middleware' => 'auth:webapi'], function () {
        Route::post('/logout', [UserAuthController::class, 'indexlogout']);
    });
});
