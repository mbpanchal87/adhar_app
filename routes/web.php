<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdharController;

/*Route::get('/', function () {
    return view('welcome');
});*/
//Route::get('/', fn() => view('login'));
Route::get('/', [AuthController::class, 'showLoginForm']);
Route::get('/signup', fn() => view('signup'))->name('signup');
Route::post('/signup', [AuthController::class, 'signUp']);

Route::get('/login', fn() => view('login'))->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [AuthController::class, 'dashboard']);
    Route::get('/update-adhar', [AdharController::class, 'updateAdharView'])->name('update-adhar');
    Route::post('/update-adhar', [AdharController::class, 'updateAdhar']);
});
