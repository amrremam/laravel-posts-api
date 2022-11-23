<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PostControlller;
use App\Http\Controllers\api\AuthController;


// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group([
        'middleware' => 'api',
        'prefix' => 'auth'
    ], function ($router) {
        Route::post('/login', [AuthController::class, 'login']);
        Route::post('/register', [AuthController::class, 'register']);
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::post('/refresh', [AuthController::class, 'refresh']);
        Route::get('/user-profile', [AuthController::class, 'userProfile']);    
    });
    
    

Route::middleware(['jwt.verify'])->group(function(){
    Route::get('/mosts',[PostControlller::class,'index']);
    Route::post('/mosts',[PostControlller::class,'store']);
    Route::get('/mosts/{id}',[PostControlller::class,'show']);
    Route::post('/most/{id}',[PostControlller::class,'update']);
    Route::post('/mosts/{id}',[PostControlller::class,'destroy']);
});


