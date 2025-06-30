<?php
declare(strict_types=1);

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TransferController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('api')->group(function () {

    //TODO REFACTORING
    Route::post('/register', [AuthController::class, 'register']);

    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::group(['prefix' => 'user'], function () {
            //TODO REFACTORING
            Route::post('/logout', [AuthController::class, 'logout']);
            Route::put('/update', [AuthController::class, 'update']);
            //TODO REFACTORING
            Route::get('/profile', function (Request $request) {
                return $request->user();
            });
        });

        Route::group(['prefix' => 'transfer'], function () {
            Route::post('/create', [TransferController::class, 'create']);
        });
    });
});


