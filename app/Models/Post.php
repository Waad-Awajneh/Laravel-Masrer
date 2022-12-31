<?php

namespace App\Models;

use App\Models\User;
use App\Models\Image;
use App\Models\Video;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;
    protected $fillable = [
        "weddingP_id",
        "content", "title"

    ];

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    public function Images()
    {
        return $this->hasMany(Image::class);
    }
    public function videos()
    {
        return $this->hasMany(Video::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'weddingP_id');
    }
}
