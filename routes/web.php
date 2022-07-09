<?php

use App\Http\Controllers\Admin\AdminCommentsController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminPostsController;
use App\Http\Controllers\Admin\AdminRolesController;
use App\Http\Controllers\Admin\AdminUsersController;
use App\Http\Controllers\AjaxController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\Post\PostCommentsController;
use App\Http\Controllers\Post\PostController;
use App\Http\Controllers\Profile\ProfileCommentsController;
use App\Http\Controllers\Profile\ProfileController;
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
// Index page
//

Route::get('/', [IndexController::class, 'index']);

//
// User's Profile
//

Route::group(['prefix' => 'profile', 'middleware' => ['auth']], function () {
    Route::get('/', [ProfileController::class, 'index'])->name('ProfileIndex');
    Route::post('/', [ProfileController::class, 'store']);
    Route::get('{id}', [ProfileController::class, 'show']);
    Route::get('{id}/edit', [ProfileController::class, 'edit'])->middleware(['user.has.access']);
    Route::post('{id}', [ProfileController::class, 'update'])->middleware(['user.has.access']);

    //User's Posts
    Route::get('draft', [ProfileController::class, 'draft']);

    //Comments Browser
    Route::group(['prefix' => 'comments'], function () {
        Route::get('/', [ProfileCommentsController::class, 'index']);
        Route::get('create', [ProfileCommentsController::class, 'create']);
        Route::post('/', [ProfileCommentsController::class, 'store']);
        Route::get('{comment_id}', [ProfileCommentsController::class, 'show'])->middleware(['user.has.access']);
        Route::get('{comment_id}/edit', [ProfileCommentsController::class, 'edit'])->middleware(['user.has.access']);
        Route::post('{comment_id}', [ProfileCommentsController::class, 'update'])->middleware(['user.has.access']);
        Route::delete('{comment_id}', [ProfileCommentsController::class, 'destroy'])->middleware(['user.has.access']);
    });
});

//
// Post
//

Route::group(['prefix' => '{id}-{slug}', 'middleware' => ['auth']], function () {
    Route::get('/', [PostController::class, 'index']);
    Route::post('/', [PostController::class, 'store']);
    Route::get('edit', [PostController::class, 'edit']);
    Route::post('/', [PostController::class, 'update']);
    Route::delete('/', [PostController::class, 'destroy']);

    //Comments
    Route::group(['prefix' => 'comments'], function () {
        Route::get('/', [PostCommentsController::class, 'index']);
        Route::get('create', [PostCommentsController::class, 'create']);
        Route::post('/', [PostCommentsController::class, 'store']);
        Route::get('{comment_id}', [PostCommentsController::class, 'show']);
        Route::get('{comment_id}/edit', [PostCommentsController::class, 'edit']);
        Route::post('{comment_id}', [PostCommentsController::class, 'update']);
        Route::delete('{comment_id}', [PostCommentsController::class, 'destroy']);
    });
});

Route::get('writing', [PostController::class, 'create'])->name('writing');

//Админка
Route::group(['prefix' => 'admin', 'middleware' => ['admin']], function () {
    Route::get('/', [AdminController::class, 'index']);

    Route::group(['prefix' => 'users'], function () {
        Route::get('/', [AdminUsersController::class, 'index']);
        Route::get('create', [AdminUsersController::class, 'create']);
        Route::post('/', [AdminUsersController::class, 'store']);
        Route::get('{id}', [AdminUsersController::class, 'show']);
        Route::get('{id}/edit', [AdminUsersController::class, 'edit']);
        Route::post('{id}', [AdminUsersController::class, 'update']);
        Route::delete('{id}', [AdminUsersController::class, 'destroy']);

        Route::group(['prefix' => 'roles'], function () {
            Route::get('/', [AdminRolesController::class, 'index']);
            Route::get('create', [AdminRolesController::class, 'create']);
            Route::post('/', [AdminRolesController::class, 'store']);
            Route::get('{id}', [AdminRolesController::class, 'show']);
            Route::get('{id}/edit', [AdminRolesController::class, 'edit']);
            Route::post('{id}', [AdminRolesController::class, 'update']);
            Route::delete('{id}', [AdminRolesController::class, 'destroy']);
        });
    });


    Route::group(['prefix' => 'comments'], function () {
        Route::get('/', [AdminCommentsController::class, 'index']);
        Route::get('create', [AdminCommentsController::class, 'create']);
        Route::post('/', [AdminCommentsController::class, 'store']);
        Route::get('{id}', [AdminCommentsController::class, 'show']);
        Route::get('{id}/edit', [AdminCommentsController::class, 'edit']);
        Route::post('{id}', [AdminCommentsController::class, 'update']);
        Route::delete('{id}', [AdminCommentsController::class, 'destroy']);
    });

    Route::group(['prefix' => 'posts'], function () {
        Route::get('/', [AdminPostsController::class, 'index']);
        Route::get('create', [AdminPostsController::class, 'create']);
        Route::post('/', [AdminPostsController::class, 'store']);
        Route::get('{id}', [AdminPostsController::class, 'show']);
        Route::get('{id}/edit', [AdminPostsController::class, 'edit']);
        Route::post('{id}', [AdminPostsController::class, 'update']);
        Route::delete('{id}', [AdminPostsController::class, 'destroy']);
    });

});

//AJAX переход
Route::post('/ajax', [AjaxController::class, 'index']);

require __DIR__.'/auth.php';
