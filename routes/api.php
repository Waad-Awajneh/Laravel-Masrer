<?php

use App\Models\Post;
use App\Models\User;
use App\Models\Video;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Resources\PostResource;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\VideoResource;
use Illuminate\Support\Facades\Route;
use App\Http\Resources\CommentResource;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Resources\FavoriteResource;
use App\Http\Controllers\VideoController;
use App\Http\Resources\PostSearchResource;
use App\Http\Resources\UserSearchResource;
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
Route::middleware('auth:sanctum')->group(
    function () {
        Route::post('addPost', [PostController::class, 'store']);
        Route::post('addVideo', [VideoController::class, 'storeVideo']);
    }
);
Route::get('getPosts', [PostController::class, 'index']);
Route::get('getPost/{post}', [PostController::class, 'show']);
//post Using Resources
Route::get('/allPosts', function () {
    return PostResource::collection(Post::all());
});

Route::get('getVideo/{video}', [VideoController::class, 'show']);
Route::get('/allVideos', function () {
    return response(VideoResource::collection(Video::all()))->header('Content-Type', 'video/mp4');
});



//Add New Comments
Route::middleware('auth:sanctum')->group(
    function () {
        Route::post('addComment', [CommentController::class, 'store']);
        Route::delete('deleteComment/{comment}', [CommentController::class, 'destroy']);
        Route::put('editComment/{comment}', [CommentController::class, 'update']);
    }
);

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


Route::get('/userProfile/{id}', function ($id) {
    return new UserResource(User::findOrFail($id));
});


//add Favorite
Route::middleware('auth:sanctum')->group(
    function () {
        Route::post('addFavorite/{post}', [PostController::class, 'addFavorite']);
        Route::get('/getFavorite', function () {
            return  FavoriteResource::collection(Auth::user()->favorites);
        });
        Route::delete('deleteFavorite/{post}', [PostController::class, 'deleteFavorite']);
    }
);
// Follow
Route::middleware('auth:sanctum')->group(
    function () {
        Route::post('follow/{user}', [UserController::class, 'follow']);
        // Route::get('/getfollower/{}', function () {
        //     return  FavoriteResource::collection(Auth::user()->favorites);
        // });
        Route::delete('unFollow/{user}', [UserController::class, 'unFollow']);
    }
);
//following
Route::get('/following/{user}', [UserController::class, 'getFollowing']);
Route::get('/getFollowers/{user}', [UserController::class, 'getFollowers']);




// Route::get('/favorites/{users}', [UserController::class, 'getFavorite']);

// //add Followers
// Route::post('addFollowers/{weddingPlanner}', [UserController::class, 'addFollowers']);


// Route::post('register', [AuthController::class, 'register'])
//     ->name('register');


// Route::post('login', [AuthController::class, 'login'])
//     ->name('login');


//profile
// Route::get('/profile/{user}', [UserController::class, 'getProfile']);


Route::middleware('auth:sanctum')->group(function () {

    Route::post('/editProfilePic', [UserController::class, 'updateProfilePic']);

    Route::get('/profile', function () {
        return new UserResource(Auth::user());
    });
});


//search data 
Route::get('/search', function () {
    return ["users" => UserSearchResource::collection(User::all()), "posts" => PostSearchResource::collection(Post::all())];
});
