<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Traits\AuthResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\PostResource;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use App\Http\Resources\FollowingResources;

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
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $test = password_verify($request->old_password, $user->password);


        $email = DB::table('users')->where('email', $request->email)->get();
        //   dd(count($email)); 
        if (count($email) > 1) {
            return $this->error('', 'invalid email', 405);
        }
        if (!$test)  return $this->error('', 'incorrect Password', 405);

        $request->validate(
            [
                'name' => 'string',
                'gender' => 'string',
                'bio' => 'string',
                'major' => 'string',
                'password' => [Password::defaults()],
                'phone_number' => 'digits:10|numeric',
            ]
        );

        $user->update([
            'name' => $request->full_name,
            'gender' => $request->gender,
            'major' => $request->major,
            'bio' => $request->bio,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone_number' => $request->phone_number,
            'address' => $request->address,

        ]);

        return $this->success('', 'user data updated successfully', 200);
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


    // public function addFollowers(User $weddingPlanner)
    // {
    //     $user = User::find(10); //Auth::user();
    //     $weddingPlanner->followers()->attach($user->id);

    //     return response()->json('add to followers');
    // }


    // update profile picture
    public function updateProfilePic(Request $request)
    {
        // dd($request);
        // $request->validate([
        //     'profile_Img' => 'required|mimes:jpeg,png,jpg,gif,svg|max:2048'
        // ]);
        $image = base64_encode(file_get_contents($request->file('profile_Img')));
        Auth::user()->update([
            'profile_Img' => $image
        ]);

        return $this->success('', 'profile image updated successfully', 200);
    }


    // update cover picture
    public function updateCoverPic(Request $request)
    {
        // dd($request);
        // $request->validate([
        //     'profile_Img' => 'required|mimes:jpeg,png,jpg,gif,svg|max:2048'
        // ]);
        $image = base64_encode(file_get_contents($request->file('cover_Img')));
        Auth::user()->update([
            'cover_Img' => $image
        ]);

        return $this->success('', 'cover image updated successfully', 200);
    }








    public function getFollowing(User $user)
    {

        return PostResource::collection(Post::whereIn('weddingP_id', $user->following->modelKeys())->get());
    }
    public function getFollowers(User $user)
    {

        return UserResource::collection(User::whereIn('id', $user->followers->modelKeys())->get());
    }


    // public function getFavorite(User $user)
    // {

    //     return ['fav' => $user->favorites()->get()];
    // }







    public function follow(User $user)
    {

        Auth::user()->following()->attach($user);

        return response()->json('follow');
    }
    public function unFollow(User $user)
    {

        Auth::user()->following()->detach($user);
        return response()->json('unfollow');
    }
}
