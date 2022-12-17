<?php

use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Resources\PostResource;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Route;
use App\Http\Resources\CommentResource;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CommentController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});





//Add New Post
Route::post('addPost', [PostController::class, 'store']);
Route::get('getPosts', [PostController::class, 'index']);
Route::get('getPost/{post}', [PostController::class, 'show']);
//post Using Resources
Route::get('/allPosts', function () {
    return PostResource::collection(Post::all());
});



//Add New Comments
Route::post('addComment', [CommentController::class, 'store']);
Route::get('getComments', [CommentController::class, 'index']);
Route::get('getComment/{comment}', [CommentController::class, 'show']);
Route::get('CommentsByPost/{post}', [CommentController::class, 'getCommentByPost']);

//comments using Resources
Route::get('comments', function () {
    return  CommentResource::collection(Comment::all());
});

Route::get('comment/{id}', function ($id) {
    return  new CommentResource(Comment::findOrFail($id));
});





//users
Route::get('/users', function () {
    return UserResource::collection(User::all());
});
Route::get('/user/{id}', function ($id) {
    return new UserResource(User::findOrFail($id));
});


//add Favorite
Route::post('addFavorite/{post}', [PostController::class, 'addFavorite']);



//add Followers
Route::post('addFollowers/{weddingPlanner}', [UserController::class, 'addFollowers']);


// Route::post('register', [AuthController::class, 'register'])
//     ->name('register');


// Route::post('login', [AuthController::class, 'login'])
//     ->name('login');

//following
Route::get('/following/{user}', [UserController::class, 'getFollowing']);
