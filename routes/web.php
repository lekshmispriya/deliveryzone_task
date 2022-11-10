<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::any('/ajaxForm', [App\Http\Controllers\API\ProductController::class, 'ajaxForm']);

Route::any('/createView', [App\Http\Controllers\API\ProductController::class, 'createView']);
Route::any('/addProduct', [App\Http\Controllers\API\ProductController::class, 'addProduct_Web']);
Route::any('/editView/{id}', [App\Http\Controllers\API\ProductController::class, 'editView']);
Route::any('/editProduct', [App\Http\Controllers\API\ProductController::class, 'editProduct_Web']);
//Route::any('/getProduct', [App\Http\Controllers\API\ProductController::class, 'getProduct_Web']);
Route::any('/deleteProduct', [App\Http\Controllers\API\ProductController::class, 'deleteProduct_Web']);
