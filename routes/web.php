<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\ContactMessageController;

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
Route::post('/contact', [FrontController::class, 'submitContactForm']);

Route::get('/language/{locale}', function ($locale) {
    App::setLocale($locale);
    session()->put('locale', $locale);
    return redirect()->back();
})->name('language.switch');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'admin' ], function () {
    Route::resource('menus', 'App\Http\Controllers\MenuController');
    Route::resource('images', 'App\Http\Controllers\ImageController');
    Route::resource('tags', 'App\Http\Controllers\TagController');
    Route::resource('categories', 'App\Http\Controllers\CategoryController');
	
	/*messages*/
	Route::get('/', [AdminDashboardController::class, 'landing']);
	Route::get('/messages', [ContactMessageController::class, 'index']);
	Route::post('/toggle-important', [ContactMessageController::class, 'toggleImportant']);
	Route::post('/toggle-read', [ContactMessageController::class, 'toggleRead']);
	Route::post('/toggle-delete', [ContactMessageController::class, 'toggleDelete']);
	Route::get('/show-all', [ContactMessageController::class, 'showAll']);
	Route::get('/show-read', [ContactMessageController::class, 'showRead']);
	Route::get('/show-important', [ContactMessageController::class, 'showImportant']);
	Route::get('/show-deleted', [ContactMessageController::class, 'showDeleted']);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
