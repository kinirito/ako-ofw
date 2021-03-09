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

// Front Page
Route::redirect('/', '/home');

// Auth Routes
Auth::routes();
Route::get('/register-id', [App\Http\Controllers\Auth\RegisterIDController::class, 'index'])->name('register.id');
Route::get('/verify', [App\Http\Controllers\Auth\RegisterController::class, 'verifyUser'])->name('verify.user');

// Home
Route::get('/home', [App\Http\Controllers\User\HomeController::class, 'index'])->name('home');
Route::post('/mabuti-kabayan', [App\Http\Controllers\User\HomeController::class, 'mabutiStatus'])->name('mabuti.status');

// Profile
Route::get('/profile', [App\Http\Controllers\User\ProfileController::class, 'index'])->name('profile');
Route::post('/profile', [App\Http\Controllers\User\ProfileController::class, 'updateProfile'])->name('update.profile');
Route::post('/change-password', [App\Http\Controllers\User\ProfileController::class, 'changePassword'])->name('change.password');

//Print ID
Route::get('/print-id', [App\Http\Controllers\User\PrintIDController::class, 'index'])->name('print');

//Discounts
Route::get('/discounts', [App\Http\Controllers\User\DiscountController::class, 'index'])->name('discounts');
Route::post('/add-discount', [App\Http\Controllers\User\DiscountController::class, 'addDiscount'])->name('add.discount');
Route::post('/edit-discount', [App\Http\Controllers\User\DiscountController::class, 'editDiscount'])->name('edit.discount');
Route::post('/delete-discount', [App\Http\Controllers\User\DiscountController::class, 'deleteDiscount'])->name('delete.discount');

// Members List
Route::get('/members-list', [App\Http\Controllers\User\MemberController::class, 'index'])->name('members');
Route::post('/kumustahin', [App\Http\Controllers\User\MemberController::class, 'kumustahin'])->name('kumustahin');
Route::post('/kumustahin-lahat', [App\Http\Controllers\User\MemberController::class, 'kumustahinAll'])->name('kumustahin.lahat');

// Kumusta Kabayan
Route::get('/kumusta-kabayan', [App\Http\Controllers\User\KumustaController::class, 'index'])->name('kumusta');

// Welcome Greetings
Route::get('/welcome-greetings', [App\Http\Controllers\User\GreetingController::class, 'index'])->name('greetings');
Route::post('/add-greeting', [App\Http\Controllers\User\GreetingController::class, 'addGreeting'])->name('add.greeting');
Route::post('/edit-greeting', [App\Http\Controllers\User\GreetingController::class, 'editGreeting'])->name('edit.greeting');
Route::post('/delete-greeting', [App\Http\Controllers\User\GreetingController::class, 'deleteGreeting'])->name('delete.greeting');

// Saklolo
Route::get('/saklolo', [App\Http\Controllers\User\SakloloController::class, 'index'])->name('saklolo');
Route::post('/hindi-mabuti-kabayan', [App\Http\Controllers\User\SakloloController::class, 'hindiMabutiStatus'])->name('hindi.mabuti.status');