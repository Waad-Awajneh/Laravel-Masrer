<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Video;
use Illuminate\Http\Request;
use App\Http\Traits\AuthResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class VideoController extends Controller
{
    use AuthResponse;
    public function storeVideo(Request $request)
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
        $video = new Video;
        $video->post_id = $post->id;
        // $video->description = 'A description of my video';

        // Save the video file
        $file = $request->file('image');
        $path = $file->store('videos');

        $video->path = $path;
        $video->save();

        return $this->success('', 'post created successfully', 201);
    }

    public function show(Video $video)
    {
        // Get the video file path
        $path = $video->path;

        // Read the file contents
        $contents = Storage::get($path);

        // Return the file to the user
        return response($contents)
            ->header('Content-Type', 'video/mp4');
    }
}
