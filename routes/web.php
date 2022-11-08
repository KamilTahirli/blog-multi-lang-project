<?php

use App\Http\Middleware\isAdmin;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LanguageController;

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


Auth::routes();
Route::get('lang/{lang}', [LanguageController::class, 'switchLang'])->name('lang.switch');


//ADMIN ROUTES

Route::prefix('panel')->middleware('auth')->group(function()
{

  Route::middleware('isModer')->group(function(){
    Route::get('/out', [AdminController::class, 'logout'])->name('user.logout');
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::resource('/posts', PostController::class)->except(['show', 'create', 'store', 'edit', 'update', 'destroy']);
    Route::get('/posts/list/', [PostController::class, 'posts_list'])->name('posts.list');
    Route::post('/posts/update/{post}', [PostController::class, 'update'])->name('posts.update');
    Route::post('/posts/store/{lang?}/{post_id?}', [PostController::class, 'store'])->name('posts.store');
    Route::get('/posts/edit/{lang?}/{post_id?}', [PostController::class, 'edit'])->name('posts.edit');
    Route::delete('/posts/delete/{lang?}/{post_id?}', [PostController::class, 'destroy'])->name('posts.destroy');
    Route::get('/posts/show/{lang?}/{post_id?}', [PostController::class, 'show'])->name('posts.show');
    Route::get('/posts/get_translate/{lang?}/{post_id?}', [PostController::class, 'getTranslate'])->name('posts.get.translate');
    Route::get('/users/profile', [UserController::class, 'profile'])->name('users.profile');
    Route::get('/users/profile-data/{user}', [UserController::class, 'profile_data'])->name('users.profile.data');
    Route::post('/users/profile-update/{user}', [UserController::class, 'profile_update'])->name('users.profile.update');
    Route::put('/users/photo-delete/{user}', [UserController::class, 'photo_delete'])->name('users.photo.delete');
});

      Route::middleware('admin')->group(function(){
        Route::resource('/categories', CategoryController::class)->except(['show', 'edit', 'create']);
        Route::get('/categories/list', [CategoryController::class, 'categories_list'])->name('categories.list');
        Route::get('/categories/all', [CategoryController::class, 'all_categories'])->name('all.categories');
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::get('/users/list', [UserController::class, 'user_list'])->name('users.list');
        Route::delete('/users/delete/{user}', [UserController::class, 'user_delete'])->name('users.delete');
        Route::put('/users/rank/{user}', [UserController::class, 'rank_update'])->name('users.rank.update');

      });

});



        //PUBLIC ROUTES
        Route::get('/', [MainController::class, 'index'])->name('home.page');
        Route::any('/search', [PostController::class, 'search'])->name('post.search');
        Route::get('/{category_slug}/{post_slug}', [PostController::class, 'post_detail']);
        Route::get('/{category_slug}', [CategoryController::class, 'category_detail']);




