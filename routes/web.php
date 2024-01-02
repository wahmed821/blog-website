<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AppController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController as UserAuthController;
use App\Http\Controllers\Admin\AppController as AdminAppController;
use App\Http\Controllers\Admin\StaffController;
use App\Http\Controllers\Admin\AuthController;

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
Route::post('submit-comment', [AppController::class, 'submitComment'])->name("submit-comment");

# User auth routes
Route::group(['prefix' => 'auth'], function () {
    Route::get('signup', [UserAuthController::class, 'signup'])->name('user.signup');
    Route::post('register', [UserAuthController::class, 'register'])->name('user.register');

    Route::get('email-verification', [UserAuthController::class, 'emailVerification'])->name("user.email-verification");
    Route::post('email-verification', [UserAuthController::class, 'emailVerificationSubmit'])->name("user.email-verification-submit");

    Route::get('login', [UserAuthController::class, 'login'])->name("user.login");
    Route::post('login-submit', [UserAuthController::class, 'loginSubmit'])->name("user.login-submit");

    Route::get('forgot-password', [UserAuthController::class, 'forgotPassword'])->name("user.forgot-password");
    Route::post('forgot-password-submit', [UserAuthController::class, 'forgotPasswordSubmit'])->name("user.forgot-password-submit");

    Route::get('reset-password', [UserAuthController::class, 'resetPassword'])->name("user.reset-password");
    Route::post('reset-password-submit', [UserAuthController::class, 'resetPasswordSubmit'])->name("user.reset-password-submit");

    Route::post('logout', [UserAuthController::class, 'logout'])->name('user.logout');
});

# User dashboard routes
Route::middleware(['user'])->prefix('user')->group(function () {
    Route::get('dashboard', [UserController::class, 'dashboard'])->name('user.dashboard');
});

/*
 * ##### ADMIN ROUTES #####
 */

//Route::group(['prefix' => 'admin'], function () {
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
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

    # Staff Rotues
    Route::get('staffs', [StaffController::class, 'staffs'])->name('staffs');
    Route::get('add-staff', [StaffController::class, 'addStaff'])->name('staffs.add');
    Route::get('edit-staff/{id}', [StaffController::class, 'editStaff'])->name("staffs.edit");
    Route::post('store-staff', [StaffController::class, 'storeStaff'])->name('staffs.store');
});

## Staff Routes
Route::middleware(['auth', 'staff'])->prefix('admin')->group(function () {
    Route::get('staff-profile', [AdminAppController::class, 'staffProfile'])->name('staff-profile');
});

# Auth routes
//Auth::routes();
//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

# Custom Auth
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'loginSubmit'])->name('login-submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
