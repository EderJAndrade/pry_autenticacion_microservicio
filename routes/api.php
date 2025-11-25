<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

Route::post('register',[AuthController::class,'register']);
Route::post('login',[AuthController::class,'login']);

// validate-token protegido por sanctum
Route::middleware('auth:sanctum')->get('validate-token',[AuthController::class,'validateToken']);
Route::middleware('auth:sanctum')->post('logout',[AuthController::class,'logout']);
