<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ApiController;

/*
| ---- ---------------------------------------------------------- ----- -------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::get('get-categories', [ApiController::class, 'getCategories'])->name('get-categories');
Route::get('get-blogs', [ApiController::class, 'getBlogs'])->name('get-blogs');
