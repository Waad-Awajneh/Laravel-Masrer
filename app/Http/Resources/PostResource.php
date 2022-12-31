<?php

namespace App\Http\Resources;

use App\Models\Post;
use App\Models\User;
use App\Http\Resources\UserResource;
use App\Http\Resources\ImageResource;
use App\Http\Resources\CommentResource;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'post_id' => $this->id,
            'post_content' => $this->content,
            'post_owner' => ['id' => $this->user->id, 'name' => $this->user->name, 'cover_image' => $this->user->cover_Img, "profile_image" => $this->user->profile_Img, "gender" => $this->user->gender],
            'date' => $this->created_at,
            'title' => $this->title,
            // 'updated_at' => $this->updated_at,
            'comments' => CommentResource::collection($this->comments),
            'images' => ImageResource::collection($this->images),
            'videos' => VideoResource::collection($this->videos),
        ];
        // return parent::toArray($request);

    }
}
