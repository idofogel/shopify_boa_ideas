<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

use App\Http\Controllers\DataController;
use App\Http\Controllers\ProdController;
use App\Http\Controllers\ProductDetailsController;

Route::get('/proddets/{id}', [ProductDetailsController::class, 'show']);
Route::get('/proddetr', [ProductDetailsController::class, 'ert']);
Route::get('/collections', [DataController::class, 'show']);
Route::get('/collectionsload/{offset}', [DataController::class, 'fetchMoreCollections']);
Route::get('/products', [ProductDetailsController::class, 'products']);
Route::get('/productsload/{offset}', [ProductDetailsController::class, 'fetchMoreproducts']);
Route::get('/prdct/{id}', [ProdController::class, 'show']);
Route::get('/', function () {
    return view('welcome');
});
