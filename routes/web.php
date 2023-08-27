<?php

use App\Models\Message;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ChatController;
use Illuminate\Support\Facades\Route;



Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/index', function(){
    return view('index');
})->middleware(['auth', 'verified'])->name('index');


Route::controller(PostController::class)->middleware(['auth'])->group(function(){
    Route::get('/', 'index')->name('index');
    Route::post('/posts', 'store')->name('store');
    Route::get('/posts/create', 'create')->name('create');
    Route::get('/posts/{post}', 'show')->name('show');
    Route::put('/posts/{post}', 'update')->name('update');
    Route::delete('/posts/{post}', 'delete')->name('delete');
    Route::get('/posts/{post}/edit', 'edit')->name('edit');
//    Route::get('/posts/{post}/chat', 'chat')->name('chat');
});

Route::get('/categories/{category}', [CategoryController::class,'index'])->middleware("auth");

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::controller(ChatController::class)->middleware(['auth'])->group(function(){
    Route::get('/posts/{post}/message', 'getMessage')->name('getMessage');
    Route::get('/posts/{post}/chat', 'showGroupChat')->name('showGroupChat');
    Route::post('/posts/{post}/chat', 'sendMessage')->name('sendMessage');
    Route::post('/posts/{post}/api/message')->name('getMessages');
    //Route::get('/posts/{post}/group/{groupId}', [ChatController::class, 'showGroupChat'])
});
require __DIR__.'/auth.php';
