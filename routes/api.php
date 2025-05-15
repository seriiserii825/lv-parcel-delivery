<?php

use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json(['message' => 'Welcome to the API']);
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
// Route::post('/admin/login', [AuthController::class, 'loginAdmin']);
Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);



Route::get('/test-email', function () {
    Mail::raw('Test email from Laravel', function ($message) {
        $message->to('seriiburduja@gmail.com')
                ->subject('Test Email');
    });
    return 'Sent!';
});

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::group(['middleware' => ['admin'], 'prefix' => 'admin'], function () {
        Route::get('/users', [UserController::class, 'index']);
        Route::post('/upload-image', [UserController::class, 'uploadImage']);

        Route::apiResource('/clients', ClientController::class);
    });
});
