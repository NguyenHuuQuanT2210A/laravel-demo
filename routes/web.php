<?php

use Illuminate\Support\Facades\Route;


Route::get('/', [\App\Http\Controllers\HomeController::class,"home"])->middleware("auth");
Route::get("/category/{category:slug}",[\App\Http\Controllers\HomeController::class,"category"]); //?id la tham so gan lien vs url, id la ten bien
Route::get("about-us",[\App\Http\Controllers\HomeController::class,"aboutUs"]);
Route::get('/detail/{product:slug}', [\App\Http\Controllers\HomeController::class,"product"]);

Route::middleware("auth")->group(function (){
Route::get("/add-to-cart/{product}",[\App\Http\Controllers\HomeController::class,"addToCart"]);
Route::get('/cart', [\App\Http\Controllers\HomeController::class,"cart"]);
Route::get('/checkout', [\App\Http\Controllers\HomeController::class,"checkout"]);
Route::post('/checkout', [\App\Http\Controllers\HomeController::class,"placeOrder"]);
Route::get('/thank-you/{order}', [\App\Http\Controllers\HomeController::class,"thankYou"]);
Route::get('/paypal-success/{order}',[\App\Http\Controllers\HomeController::class,"paypalSuccess"]);
Route::get('/paypal-cancel/{order}',[\App\Http\Controllers\HomeController::class,"paypalCancel"]);
});

//muon dat nhieu middleware thi dung mang nhu o duoi
Route::middleware(["auth","is_admin"])->prefix("admin")->group(function (){
include_once "admin.php";
});


Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
