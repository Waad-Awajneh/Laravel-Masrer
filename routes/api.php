<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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



// Route::get('/index', [BooksController::class, 'index']);
// Route::post('custom-registration', [CustomAuthController::class, 'customRegistration']);

// $books = Books::all();

// return response()->json($books);


// $u = User::create($request->all());

// return response()->json($u);


//Add New Post
Route::post('addPost', [PostController::class, 'store']);
Route::get('getPosts', [PostController::class, 'index']);
Route::get('getPost/{post}', [PostController::class, 'show']);



//Add New Comments
Route::post('addComment', [CommentController::class, 'store']);
Route::get('getComments', [CommentController::class, 'index']);
Route::get('getComment/{comment}', [CommentController::class, 'show']);
