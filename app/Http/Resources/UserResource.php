<?php

namespace App\Http\Resources;

use App\Http\Resources\PostResource;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'user_id' => $this->id,
            'full_name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
            'profile_Img' => $this->profile_Img,
            'cover_Img' => $this->cover_Img,
            'address' => $this->address,
            'role' => $this->role,
            'gender' => $this->gender,
            'phone_number' => $this->phone_number,
            'follower_info' => $this->followers, //data
            'following_info' => $this->following, //data
            'following_count' => $this->followingW == null ? 0 : count($this->followingW), //count
            'follower_count' =>  $this->followingU == null ? 0 : count($this->followingU), //count 
            //  'follower_count' =>$this->loadCount('followingU'), //data
            'major' => $this->major,
            'bio' => $this->bio,
            'posts' => PostResource::collection($this->posts),
            'comments' => $this->comments,

        ];
        // return parent::toArray($request);
    }
}
