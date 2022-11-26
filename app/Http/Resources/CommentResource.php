<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
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
         'comment_id' => $this->id,
            'comment_content' => $this->comment,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'user_info' => ['id'=>$this->user->id,'name'=>$this->user->name,'cover_image'=>$this->user->cover_Img,"profile_image"=>$this->user->profile_Img],
            'post' => ['id'=>$this->Post->id,'content'=>$this->post->content],
        
        ];
        // return parent::toArray($request);
    }
}
