<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FavoriteController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Authentication Routes (Guest Only)
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'show'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])->name('login.store');
    Route::get('/register', [RegisterController::class, 'index'])->name('register');
    Route::post('/register', [RegisterController::class, 'store'])->name('register.store');
});

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');

Route::get('/dashboard', function () {
    $students = User::where('id', '!=', auth()->id())->take(3)->get(); 
    
    // Grabs an array of just the IDs you have already favorited (e.g., [2, 3])
    $favoritedIds = auth()->user()->favorites->pluck('id')->toArray();
    
    // Pass both variables to the view
    return view('dashboard', compact('students', 'favoritedIds'));
})->name('dashboard');

    Route::post('/favorite/toggle', [FavoriteController::class, 'toggleFavorite'])->name('favorite.toggle');
    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');    
    Route::view('/swap', 'swap')->name('swap');
    Route::view('/schedule', 'schedule')->name('schedule');
    Route::view('/messages', 'messages')->name('messages');
    Route::view('/history', 'history')->name('history');

    Route::view('/profile', 'profile.edit')->name('profile.edit');
    Route::put('/profile', [UserController::class, 'update'])->name('profile.update');


});
/*
|--------------------------------------------------------------------------
| Root Redirect
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
});
