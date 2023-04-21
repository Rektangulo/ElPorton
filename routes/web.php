<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontController;

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

Route::get('/', [FrontController::class, 'landing']);
Route::get('/menu', [FrontController::class, 'menu']);
Route::get('/contact', [FrontController::class, 'contact']);

Route::get('/test', function () {
    //return view('dashboard.test');
	return view('test');
});

Route::group(['prefix' => 'admin', 'as' => 'admin.', /*'middleware' => 'admin'*/ ], function () {
    Route::resource('menus', 'App\Http\Controllers\MenuController');
	Route::resource('images', 'App\Http\Controllers\ImageController');
	Route::resource('tags', 'App\Http\Controllers\TagController');
	Route::resource('categories', 'App\Http\Controllers\CategoryController');
});
