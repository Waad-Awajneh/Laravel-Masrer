<?php

namespace App\Http\Controllers;

use App\Http\Resources\FollowingResources;
use App\Http\Resources\PostResource;
use App\Http\Traits\AuthResponse;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use AuthResponse;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    //    public function addFollowing(User $user)
    //     {
    //         $user=Auth::user();
    //         $user->favorites()->attach($post->id);

    //         return response()->json('add to favorites');
    //     }


    public function addFollowers(User $weddingPlanner)
    {
        $user = User::find(10); //Auth::user();
        $weddingPlanner->followers()->attach($user->id);

        return response()->json('add to followers');
    }


    public function getFollowing(User $user)
    {

        return PostResource::collection(Post::whereIn('id', $user->following->modelKeys())->get());
    }
}
