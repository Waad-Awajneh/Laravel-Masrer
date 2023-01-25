<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserSearchResource extends JsonResource
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
            'major' => $this->major,
            'bio' => $this->bio,
            'profile_Img' => $this->profile_Img,
            'following_count' => $this->followingW == null ? 0 : count($this->followingW), //count
            'gender' => $this->gender,
        ];
    }
}
