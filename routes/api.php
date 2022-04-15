<?php

use App\Http\Controllers\ApprovalController;
use App\Http\Controllers\ApprovePendingRequestController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\DeclinePendingRequestController;
use App\Http\Controllers\PendingRequestController;
use App\Http\Controllers\UserController;
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

//\Illuminate\Support\Facades\Auth::loginUsingId(1);

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::prefix('auth')->group(function () {
    Route::post('login', [AuthenticationController::class, 'login'])->name('login');
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('register', [AuthenticationController::class, 'register'])->name('register');
        Route::post('logout', [AuthenticationController::class, 'logout'])->name('logout');
    });
});
Route::middleware('auth:sanctum')->group(function () {
    Route::name('requests.')->prefix('requests')->group(function () {
        Route::get('pending', [PendingRequestController::class, 'index'])->name('index');
        Route::get('pending/{approval}', [PendingRequestController::class, 'show'])->name('show');
        Route::patch('approve/{approval}', ApprovePendingRequestController::class)->name('approve');
        Route::patch('decline/{approval}', DeclinePendingRequestController::class)->name('decline');
    });
    Route::apiResource('users', UserController::class)->except('index');
});
