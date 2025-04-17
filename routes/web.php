<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {

    $posts = [];

    //if the user is logged in
    if (auth()->check()) {
        // This is the "bad example" given by the tutorial. I'm keeping this for posterity
        //$posts = Post::where('user_id', auth()->id())->get();

        //get the blog posts from that user
        $posts = auth()->user()->userPostInteraction()->latest()->get();

    }

    return view('home', ['posts' => $posts]);
});

Route::post('/register', [UserController::class, 'register']);
Route::post('/logout', [UserController::class, 'logout']);
Route::post('/login', [UserController::class, 'login']);

//Blog Post related routes
Route::post('/create-post', [PostController::class, 'createPost']);
Route::get('/edit-post/{post}', [PostController::class, 'showEditScreen']);
Route::put('/edit-post/{post}', [PostController::class, 'updatePostFromEditScreen']);
Route::delete('/delete-post/{post}', [PostController::class, 'deletePost']);
