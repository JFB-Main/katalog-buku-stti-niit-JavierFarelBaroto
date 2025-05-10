<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AdminController;

//Below is the Route Resources:

Route::resource('books', BookController::class);

Route::resource('categories', CategoryController::class);

Route::resource('administration', AdminController::class);

//Below is the Route For index routing:
Route::get('/', [BookController::class, 'index'])->name('books.index');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//Below is the Route For the admin pages:
Route::get('/crudBook', [BookController::class, 'create'])->name('books.crudBook');
Route::get('/editBook', [BookController::class, 'edit'],)->name('books.editBook');

Route::delete('/books/{book}', [BookController::class, 'destroy'])->name('books.destroy');

Route::get('/crudCategory', [CategoryController::class, 'create'])->name('category.crudCategory');
Route::get('/editCategory', [CategoryController::class, 'edit'],)->name('categories.edit');


Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->middleware(['auth', 'verified'])->name('admin.dashboard');


Route::get('/books', [BookController::class, 'index'])->name('books.index');

Route::get('/bookDetails', [BookController::class, 'show'])->name('books.bookDetails');

require __DIR__.'/auth.php';
    