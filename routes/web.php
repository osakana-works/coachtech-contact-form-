<?php

use App\Http\Controllers\ContactController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TagController;
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

Route::get('/', [ContactController::class, 'index']);
Route::post('/contacts', [ContactController::class, 'store']);
Route::post('/contacts/confirm', [ContactController::class, 'confirm']);
Route::get('/thanks', [ContactController::class, 'thanks']);

Route::middleware('auth')->group(function () {
    Route::get('/admin', [AdminController::class,'index']);
    Route::get('/admin/contacts/{id}', [AdminController::class,'show']);
    Route::DELETE('/admin/contacts/{id}', [AdminController::class,'destroy']);

    Route::POST('/admin/tags', [TagController::class,'store']);
    Route::GET('admin/tags/{tag}/edit',[TagController::class,'edit']);
    Route::PUT('admin/tags/{tag}',[TagController::class,'update']);
    Route::DELETE('admin/tags/{tag}',[TagController::class,'destroy']);
});
