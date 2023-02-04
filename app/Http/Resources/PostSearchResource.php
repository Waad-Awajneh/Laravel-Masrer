<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PostSearchResource extends JsonResource
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
            'images' => ImageResource::collection($this->images),
            'comments' => CommentResource::collection($this->comments),
            'videos' => VideoResource::collection($this->videos),
        ];
    }
}
