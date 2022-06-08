<?php

use App\Http\Controllers\Post\PostController;
use App\Http\Controllers\Post\EditorController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use \App\Http\Controllers\AjaxController;
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

//Опубликованые статьи пользователя
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

//Черновые статьи пользователя
Route::get('/dashboard/draft', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard/draft');

//На проверке у админа
Route::get('/dashboard/check', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard/check');

//Страница автора со статьями
Route::get('/profile/{user_id}', [UserController::class, 'index']);

//Редактирование профиля
Route::get('/profile/{user_id}/edit', [UserController::class, 'edit'])->middleware(['user.has.access']);
Route::get('/{post_id}-{slug}', [PostController::class, 'index']);

//Редактор статей
Route::get('/editor', [EditorController::class, 'index'])->middleware(['auth'])->name('editor');
Route::get('/editor/{post_id}', [EditorController::class, 'index'])->middleware(['auth']);

//Админка
Route::get('/admin', [AdminController::class, 'index'])->middleware(['admin'])->name('admin');
Route::get('/admin/posts', [AdminController::class, 'posts'])->middleware(['admin']);
Route::get('/admin/users', [AdminController::class, 'users'])->middleware(['admin']);
Route::get('/admin/users/{id}', [AdminController::class, 'edit_user'])->middleware(['admin']);
Route::get('/admin/users/create', [AdminController::class, 'create_user'])->middleware(['admin']);
Route::get('/admin/comments', [AdminController::class, 'comments'])->middleware(['admin']);
Route::get('/admin/comments/{id}', [AdminController::class, 'edit_comment'])->middleware(['admin']);

Route::post('/admin/users/{id}', [AdminController::class, 'save_user'])->middleware(['admin']);
Route::post('/admin/users/create', [AdminController::class, 'save_user'])->middleware(['admin']);
Route::post('/admin/comments/{id}', [AdminController::class, 'save_comment'])->middleware(['admin']);

//
// POST
//
Route::post('/editor', [EditorController::class, 'save'])->middleware(['auth']);
Route::post('/editor/{post_id}', [EditorController::class, 'save'])->middleware(['auth']);
Route::post('/profile/{user_id}/edit', [UserController::class, 'update'])->middleware(['user.has.access']);

//AJAX пагинация
Route::post('/page/{num}', [AjaxController::class, 'query']);

//AJAX переход
Route::post('/ajax', [AjaxController::class, 'ajax_page']);

require __DIR__.'/auth.php';
