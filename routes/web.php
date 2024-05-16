<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return Redirect::to('/logout');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/vendor', [App\Http\Controllers\HomeController::class, 'vendor'])->name('endor');
Route::get('/user', [App\Http\Controllers\HomeController::class, 'user'])->name('user');

Route::group(['prefix' => 'admin',  'middleware' => 'isAdmin','auth'], function()
{
    //All the routes that belongs to the group goes here
    Route::get('/dashboard', [App\Http\Controllers\UserController::class, 'blogs'])->name('add_blogs');
    Route::post('/save-blog', [App\Http\Controllers\UserController::class, 'save_blog'])->name('save_blog');
   

});
Route::group([  'middleware' => 'auth'], function()
{
    Route::get('/blogs', [App\Http\Controllers\UserController::class, 'list'])->name('list');
    Route::post('/blog/like', [App\Http\Controllers\UserController::class, 'blog_like'])->name('blog_like');
    Route::post('/blog/comment', [App\Http\Controllers\UserController::class, 'blog_comment'])->name('blog_comment');
    Route::get('/blog/detail/{id}', [App\Http\Controllers\UserController::class, 'blog_detail'])->name('blog_detail');
});

Route::get('logout', function ()
{
    auth()->logout();
    Session()->flush();

    return Redirect::to('/login');
})->name('logout');
