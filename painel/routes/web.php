<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LabelController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ConfigurationController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PostCommentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LogController;
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

//Medias
Route::get('Medias', [MediaController::class, 'index']);
Route::get('Medias/page/{pageId}', [MediaController::class, 'indexPage']);
Route::get('Medias/create', [MediaController::class, 'create']);
Route::post('Medias/create', [MediaController::class, 'doCreation']);
Route::get('Medias/edit/{id}', [MediaController::class, 'edit']);
Route::post('Medias/edit/{id}', [MediaController::class, 'update']);
Route::delete('Medias/delete/{id}', [MediaController::class, 'delete']);

//Posts
Route::get('Posts', [PostController::class, 'index']);
Route::get('Posts/page/{pageId}', [PostController::class, 'indexPage']);
Route::get('Posts/create', [PostController::class, 'create']);
Route::post('Posts/create', [PostController::class, 'doCreation']);
Route::get('Posts/edit/{id}', [PostController::class, 'edit']);
Route::post('Posts/edit/{id}', [PostController::class, 'update']);
Route::delete('Posts/delete/{id}', [PostController::class, 'delete']);

//Users
Route::get('Users', [UserController::class, 'index']);
Route::get('Users/page/{pageId}', [UserController::class, 'indexPage']);
Route::get('Users/create', [UserController::class, 'create']);
Route::post('Users/create', [UserController::class, 'doCreation']);
Route::get('Users/edit/{id}', [UserController::class, 'edit']);
Route::post('Users/edit/{id}', [UserController::class, 'update']);
Route::delete('Users/delete/{id}', [UserController::class, 'delete']);

//Logs
Route::get('Logs', [LogController::class, 'index']);
Route::get('Logs/page/{pageId}', [LogController::class, 'indexPage']);

//Configurations
Route::get('Configurations', [ConfigurationController::class, 'index']);
Route::get('Configurations/page/{pageId}', [ConfigurationController::class, 'indexPage']);
Route::get('Configurations/edit/{id}', [ConfigurationController::class, 'edit']);
Route::post('Configurations/edit/{id}', [ConfigurationController::class, 'update']);

//Post Comments
Route::get('PostComments/{postId}', [PostCommentController::class, 'index']);
Route::get('PostComments/{postId}/page/{pageId}', [PostCommentController::class, 'indexPage']);
Route::post('PostComments/approve-comment/{commentId}/fromPost/{postId}', [PostCommentController::class, 'approveComment']);
Route::post('PostComments/reject-comment/{commentId}/fromPost/{postId}', [PostCommentController::class, 'rejectComment']);
Route::delete('PostComments/delete/{id}', [PostCommentController::class, 'delete']);