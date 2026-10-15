<?php

use App\Http\Controllers\BookController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('books.index');
});

// Добавляем маршрут dashboard, куда Breeze перенаправляет после логина
Route::get('/dashboard', function () {
    return redirect()->route('books.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::resource('books', BookController::class);
    
    Route::get('/profile', function () {
        return view('profile.edit');
    })->name('profile.edit');
});

require __DIR__.'/auth.php';