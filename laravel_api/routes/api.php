<?php

use App\Http\Controllers\BrandController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\UnitController;

Route::prefix('foysal')->group(function(){
    Route::resource('Category',CategoryController::class)->names('Category');
    Route::resource('sub_category',SubCategoryController::class)->names('sub_category');
    Route::resource('brand',BrandController::class)->names('brand');
    Route::resource('unit',UnitController::class)->names('unit');
    Route::resource('product',ProductController::class)->names('product');
});

Route::post('login',[LoginController::class,'login']);
Route::post('logout',[LoginController::class,'logout'])->middleware('auth:sanctum');

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
