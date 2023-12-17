<?php

use App\Http\Controllers\SpeakerController;
use App\Http\Controllers\SponsorController;
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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/events', function () {
    return view('events.events');
})->name('events');
Route::get('/speakers', function () {
    return view('speakers.speakers');
})->name('speakers');
Route::get('/sponsors', function () {
    return view('sponsors.sponsors');
})->name('sponsors');
Route::get('/contact', function () {
    return view('contact');
})->name('contact');
Route::get('/tickets', function () {
    return view('tickets.tickets');
})->name('tickets');
Route::get('/about', function () {
    return view('about');
})->name('about');
// Do the same for the other routes

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::post('/contact/submit', [App\Http\Controllers\ContactController::class, 'submit'])->name('contact.submit');
Route::resource('sponsors', SponsorController::class);
Route::resource('speakers', SpeakerController::class);
