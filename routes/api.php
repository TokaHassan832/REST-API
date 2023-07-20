<?php

use App\Http\Controllers\Api\V1\CategoryController;
use App\Http\Controllers\Api\V1\ProductController;
use App\Http\Controllers\AuthController;
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

//public routes
Route::post('/register',[AuthController::class,'register']);

Route::post('/login',[AuthController::class,'login']);

Route::get('/products/search/{name}',[ProductController::class,'search']);

Route::group(['middleware'=>'throttle:2,1'],function (){
    Route::get('/products',[ProductController::class,'index']);
    Route::get('/products/{product}',[ProductController::class,'show']);
    Route::get('/categories',[CategoryController::class,'index']);
    Route::get('/categories/{category}',[CategoryController::class,'show']);
});



//protected routes
Route::group(['middleware'=>['auth:sanctum']], function () {

    Route::apiResource('products',ProductController::class)->except('index','show');

    Route::apiResource('categories',CategoryController::class)->except('index','show');

    Route::post('/logout',[AuthController::class,'logout']);
});



