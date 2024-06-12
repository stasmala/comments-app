<?php

use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('comments');
});

Route::post('/add-comment', [CommentController::class, 'addComment'])->name('add-comment');
Route::get('/comments', [CommentController::class, 'getComments'])->name('get-comments');
Route::get('/captcha-image', [CommentController::class, 'generateCaptcha']);
