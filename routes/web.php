<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\ContactMessageController;
use App\Http\Controllers\Admin\ReservationController;

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
Route::get('/reservation', [FrontController::class, 'showCalendar']);
Route::post('/check-date', [FrontController::class, 'checkDate']);
Route::get('/reservations', [FrontController::class, 'reservation']);
Route::post('/reservation', [FrontController::class, 'submitReservation']);
Route::get('/reservation-success', [FrontController::class, 'reservationSuccess']);
Route::get('/menu', [FrontController::class, 'menu']);
Route::get('/contact', [FrontController::class, 'contact']);
Route::post('/contact', [FrontController::class, 'submitContactForm']);
Route::get('/cookie-consent', [FrontController::class, 'cookie']);

Route::get('/language/{locale}', function ($locale) {
    App::setLocale($locale);
    session()->put('locale', $locale);
    return redirect()->back();
})->name('language.switch');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'admin' ], function () {
    Route::resource('menus', 'App\Http\Controllers\Admin\MenuController');
    Route::resource('images', 'App\Http\Controllers\Admin\ImageController');
    Route::resource('tags', 'App\Http\Controllers\Admin\TagController');
    Route::resource('categories', 'App\Http\Controllers\Admin\CategoryController');
	
	Route::get('/', [AdminDashboardController::class, 'landing']);
	
	/*messages*/
	Route::get('/messages', [ContactMessageController::class, 'index']);
	Route::post('/toggle-important', [ContactMessageController::class, 'toggleImportant']);
	Route::post('/toggle-read', [ContactMessageController::class, 'toggleRead']);
	Route::post('/toggle-delete', [ContactMessageController::class, 'toggleDelete']);
	Route::get('/show-all', [ContactMessageController::class, 'showAll']);
	Route::get('/show-read', [ContactMessageController::class, 'showRead']);
	Route::get('/show-important', [ContactMessageController::class, 'showImportant']);
	Route::get('/show-deleted', [ContactMessageController::class, 'showDeleted']);
	
	/*reservations*/
	Route::get('/reservations', [ReservationController::class, 'index']);
	Route::post('/reservations/{id}/accept', [ReservationController::class, 'acceptReservation']);
	Route::post('/reservations/{id}/cancel', [ReservationController::class, 'cancelReservation']);
	Route::get('/reservations/all', [ReservationController::class, 'showAllReservations']);
	Route::get('/reservations/{status}', [ReservationController::class, 'showReservationsByStatus']);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
