<?php

use App\Models\Message;
use App\Models\Post;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\EventController; 
use Illuminate\Support\Facades\Route;



Route::get('/dashboard', function (Post $post) {
    return view('dashboard')->with(['posts' => $post->getPaginateByLimit(8)]);
})->middleware(['auth'])->name('dashboard');
/*
Route::get('/index', function(){
    return view('index');
})->middleware(['auth', 'verified'])->name('index');
*/

Route::controller(PostController::class)->middleware(['auth'])->group(function(){
    Route::get('/', 'index')->name('index');
//    Route::get('/posts', 'display')->name('display');
    Route::post('/posts/create', 'store')->name('store');
    Route::get('/posts/create', 'create')->name('create');
    Route::get('/posts/{post}', 'show')->name('show');
    Route::put('/posts/{post}', 'update')->name('update');
    Route::post('/posts/{post}/join', 'joinGroup')->name('joinGroup');
    Route::delete('/posts/{post}', 'quit')->name('quit');
//    Route::delete('/posts/{post}', 'delete')->name('delete');
    Route::get('/posts/{post}/edit', 'edit')->name('edit');
    Route::get('/posts/{post}/invite', 'invite')->name('invite');
    Route::post('/posts/{post}/invite', 'register')->name('register');
//    Route::get('/posts/{post}/chat', 'chat')->name('chat');
});

Route::get('/categories/{category}', [CategoryController::class,'index'])->middleware("auth");

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [ProfileController::class, 'schedule'])->name('schedule.update');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::controller(ChatController::class)->middleware(['auth'])->group(function(){
    Route::get('/posts/{post}/message', 'getMessage')->name('getMessage');
    Route::get('/posts/{post}/chat', 'showGroupChat')->name('showGroupChat');
    Route::post('/posts/{post}/chat', 'sendMessage')->name('sendMessage');
    //Route::post('/posts/{post}/api/message')->name('getMessages');
    //Route::get('/posts/{post}/group/{groupId}', [ChatController::class, 'showGroupChat'])
});

Route::controller(EventController::class)->middleware(['auth'])->group(function(){
    Route::post('/posts/{post}', 'add')->name('add');
    Route::get('/posts/{post}/api/get-users-count-by-day', 'getUsersCountByDay')->name('getUsersCountByDay');
});
require __DIR__.'/auth.php';
