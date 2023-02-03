<?php

namespace App\Http\Controllers;

use App\Http\Traits\AuthResponse;
use App\Models\Post;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    use AuthResponse;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::all();
        //foreach
        return response()->json(['post' => $posts]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //   $post = Post::create($request->all());
        //   return response()->json(['post' => $post,]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string',
            'title' => 'required|string',
            'image' => 'required'
        ]);
        $post = Post::create([
            'weddingP_id' => Auth::user()->id,
            'content' => $request->content,
            'title' => $request->title,
        ]);
        $image = base64_encode(file_get_contents($request->file('image')));
        Image::create([
            'post_id' => $post->id,
            'post_img' => $image
        ]);


        // // Save the video file
        // $file = $request->file('image');
        // $path = $file->store('public/images');
        // $image = new Image;
        // // $image = Image::create([
        // //     'post_id' => $post->id,
        // //     'post_img' => $path
        // // ]);
        // $image->post_id = $post->id;
        // $image->post_img = $path;
        // $image->save();

        return $this->success('', 'post created successfully', 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        // dd($post);
        $image = Image::where('post_id', $post->id)->get();

        return response()->json(['post' => $post, 'image' => $image]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
// dd($request);

            if (!$this->isAuthorize($post)) {
                return $this->error('', 'you are not authorize to update this post ', 403);
            }
            $request->validate([
                'content' => 'string',
                'title' => 'string',
            ]);

            $post->update([
                'content' => $request->content,
                'title'=>$request->title,

            ]);
            $image = base64_encode(file_get_contents($request->file('post_img')));
            Image::where('post_id', $post->id)->
           update([
                'post_id' => $post->id,
                'post_img' => $image
            ]);

            return $this->success('', 'post updated successfully', 200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        return $this->isAuthorize($post) ? $post->delete() : $this->error('', 'you are not authorize to delete this post', 403);
    }
    public function addFavorite(Post $post)
    {

        Auth::user()->favorites()->attach($post);

        return response()->json('add to favorites');
    }

    public function deleteFavorite(Post $post)
    {

        Auth::user()->favorites()->detach($post);
        return response()->json('remove from favorites');
    }

    protected function isAuthorize($post)
    {
        return Auth::user()->id == $post->weddingP_id ? true : false;
    }
}
