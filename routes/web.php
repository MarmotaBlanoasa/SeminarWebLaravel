<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\SpeakerController;
use App\Http\Controllers\SponsorController;
use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Auth;
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
Route::get('/', [App\Http\Controllers\EventController::class, 'index']);
Route::get('/contact', function () {
    return view('contact');
})->name('contact');
Route::get('/about', function () {
    return view('about');
})->name('about');

Auth::routes();

Route::post('/contact/submit', [App\Http\Controllers\ContactController::class, 'submit'])->name('contact.submit');
Route::resource('sponsors', SponsorController::class);
Route::resource('speakers', SpeakerController::class);
Route::resource('events', EventController::class);
Route::middleware(['auth'])->group(function () {
    Route::resource('tickets', TicketController::class);
    Route::post('/create-checkout-session', [TicketController::class, 'createCheckoutSession']);
    Route::get('/success', [TicketController::class, 'paymentSuccess']);
    Route::get('/cancel', [TicketController::class, 'paymentCancel']);
});



