<?php

use App\Http\Controllers\Post\PostController;
use App\Http\Controllers\Post\EditorController;
use App\Http\Controllers\UserController;
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

//
// GET
//

Route::get('/', function () {
    return view('index');
});

Route::get('/welcome', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::get('/dashboard/draft', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard/draft');

Route::get('/profile/{user_id}', [UserController::class, 'index']);
Route::get('/profile/{user_id}/edit', [UserController::class, 'edit'])->middleware(['user.has.access']);
Route::get('/{post_id}-{slug}', [PostController::class, 'index']);
Route::get('/editor', [EditorController::class, 'index'])->middleware(['auth'])->name('editor');
Route::get('/editor/{post_id}', [EditorController::class, 'index'])->middleware(['auth']);

//
// POST
//
Route::post('/editor', [EditorController::class, 'save'])->middleware(['auth']);
Route::post('/editor/{post_id}', [EditorController::class, 'save'])->middleware(['auth']);
Route::post('/profile/{user_id}/edit', [UserController::class, 'update'])->middleware(['user.has.access']);
require __DIR__.'/auth.php';
