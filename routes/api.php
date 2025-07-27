<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\TransactionController;
use App\Http\Controllers\API\CategoryBannerController;
use App\Http\Controllers\API\ForgotPasswordController;
use App\Http\Controllers\API\DashboardBannerController;
use App\Http\Controllers\API\ProductCategoryController;

Route::get('products', [ProductController::class, 'all']);
Route::get('categories', [ProductCategoryController::class, 'all']);

Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);

Route::post('/forgot-password', [ForgotPasswordController::class, 'forgot']);
Route::post('/forgot-password', [ForgotPasswordController::class, 'forgot']);
Route::post('/reset-password', [ForgotPasswordController::class, 'reset']);

Route::get('/dashboard-banners', [DashboardBannerController::class, 'all']);
Route::get('/category-banners', [CategoryBannerController::class, 'all']);

Route::middleware('auth:sanctum')->group(function (){
    Route::get('user', [UserController::class, 'fetch']);
    Route::post('user', [UserController::class, 'updateProfile']);
    Route::post('logout', [UserController::class, 'logout']);
    
    Route::get('transaction',[ TransactionController::class, 'all']);
    Route::post('checkout',[ TransactionController::class, 'checkout']);
});