<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppController;
use App\Http\Controllers\Admin\AppController as AdminAppController;
use App\Http\Controllers\HomeController;


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

## Website Routes
Route::get('/', [AppController::class, 'index'])->name("index");
Route::get('/about-us', [AppController::class, 'aboutUs'])->name("about-us");
Route::get('/contact-us', [AppController::class, 'contactUs'])->name("contact-us");

Route::get('/blogs/{slug}', [AppController::class, 'blogs'])->name("website.blogs");
Route::get('/blog/{slug}', [AppController::class, 'blog'])->name("website.blog");
Route::get('/category/{slug}', [AppController::class, 'category'])->name("website.category");
Route::post('submit-comment', [AppController::class, 'submitComment'])->name("submit-comment");


/*
 * ##### ADMIN ROUTES #####
 */

Route::group(['prefix' => 'admin'], function () {
    Route::get('dashboard', [AdminAppController::class, 'dashboard'])->name('dashboard');

    # Categories routes
    Route::get('categories', [AdminAppController::class, 'categories'])->name('categories');
    Route::get('add-category', [AdminAppController::class, 'addCategory'])->name('categories.add');
    Route::get('edit-category/{id}', [AdminAppController::class, 'editCategory'])->name("category.edit");
    Route::post('store-category', [AdminAppController::class, 'storeCategory'])->name('categories.store');

    # Blog routes
    Route::get('blogs', [AdminAppController::class, 'blogs'])->name('blogs');
    Route::get('add-blog', [AdminAppController::class, 'addBlog'])->name('blogs.add');
    Route::get('edit-blog/{id}', [AdminAppController::class, 'editBlog'])->name("blogs.edit");
    Route::post('store-blog', [AdminAppController::class, 'storeBlog'])->name('blogs.store');
    Route::get('blog/{id}', [AdminAppController::class, 'blog'])->name('blog');

    # Common routes
    Route::get('update-status/{table}/{id}/{value}', [AdminAppController::class, 'updateStatus'])->name("update-status");

    # Change Password route
    Route::get('change-password', [HomeController::class, 'changePassword'])->name("change-password");
    Route::post('update-password', [HomeController::class, 'updatePassword'])->name("update-password");
});

# Auth routes
Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
