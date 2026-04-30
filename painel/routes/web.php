<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LabelController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index']);

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'doLogin']);
Route::get('/logout', [LoginController::class, 'logout']);

//Labels
Route::get('Labels', [LabelController::class, 'index']);
Route::get('Labels/page/{pageId}', [LabelController::class, 'indexPage']);
Route::get('Labels/create', [LabelController::class, 'create']);
Route::post('Labels/create', [LabelController::class, 'doCreation']);
Route::get('Labels/edit/{id}', [LabelController::class, 'edit']);
Route::post('Labels/edit/{id}', [LabelController::class, 'update']);
Route::delete('Labels/delete/{id}', [LabelController::class, 'delete']);
Route::get('Labels/view/{id}', [LabelController::class, 'view']);

//Categories
Route::get('Categories', [CategoryController::class, 'index']);
Route::get('Categories/page/{pageId}', [CategoryController::class, 'indexPage']);
Route::get('Categories/create', [CategoryController::class, 'create']);
Route::post('Categories/create', [CategoryController::class, 'doCreation']);
Route::get('Categories/edit/{id}', [CategoryController::class, 'edit']);
Route::post('Categories/edit/{id}', [CategoryController::class, 'update']);
Route::delete('Categories/delete/{id}', [CategoryController::class, 'delete']);
Route::get('Categories/view/{id}', [CategoryController::class, 'view']);
//Posts
Route::get('Posts', [PostController::class, 'index']);
Route::get('Posts/page/{pageId}', [PostController::class, 'indexPage']);
Route::get('Posts/create', [PostController::class, 'create']);
Route::post('Posts/create', [PostController::class, 'doCreation']);
Route::get('Posts/edit/{id}', [PostController::class, 'edit']);
Route::post('Posts/edit/{id}', [PostController::class, 'update']);
Route::delete('Posts/delete/{id}', [PostController::class, 'delete']);
