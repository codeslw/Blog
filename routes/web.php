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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia\Inertia::render('Dashboard');
})->name('dashboard');
Route::get('/', [\App\Http\Controllers\PostController::class, 'index'])->name('posts');
Route::middleware('auth')->name('post')->group(
    function (){
        Route::get('post/create', [\App\Http\Controllers\PostController::class, 'create'])->name('.create');
        Route::post('post/store', [\App\Http\Controllers\PostController::class, 'store'])->name('.store');
        Route::post('post/{post}/', [\App\Http\Controllers\PostController::class, 'update'])->name('.update');
        Route::get('post/{post}/edit', [\App\Http\Controllers\PostController::class, 'edit'])->name('.edit');
        Route::delete('/post/{id}', [\App\Http\Controllers\PostController::class, 'destroy'])->name('.destroy');

        Route::post('like/{id}',[\App\Http\Controllers\PostController::class,'like'])->name('.like');
        Route::delete('delete/{id}/',[\App\Http\Controllers\PostController::class,'dislike'])->name('.dislike');

    }
);
Route::middleware('auth')->name('user')->group(
    function (){
        Route::get('users/{user}',[
            \App\Http\Controllers\UserController::class,'show'
        ])->name('.details');
        Route::post('subscribe/{id}',[\App\Http\Controllers\UserController::class, 'subscribe'])->name('.subscribe');

        Route::post('unsubscribe/{id}',[\App\Http\Controllers\UserController::class, 'unsubscribe'])->name('.unsubscribe');
        Route::get('user/',[\App\Http\Controllers\UserController::class,'index'])->name('.index');
    }

);
Route::middleware('auth')->name('comment')->group(
    function (){
        Route::delete('comment/{id}',[\App\Http\Controllers\CommentController::class,'delete'])->name('.delete');
        Route::get('/comment/edit/{id}/post/{postId}',[\App\Http\Controllers\CommentController::class, 'edit'])->name('.edit');
        Route::post('/comment/{id}',[\App\Http\Controllers\CommentController::class,'update'])->name('.update');
        Route::post('comment/{id}', [\App\Http\Controllers\CommentController::class, 'comment'])->name('.store');
        Route::get('post/edit/{id}/',[\App\Http\Controllers\CommentController::class, 'getComment'])->name('.getComment');

    }
);
