<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Connect_msg extends Model
{
    use HasFactory;
    protected $fillable=[
        "user_id","weddingP_id","name",
        "email","phone_number","event_date","message","address","contact_method"
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'weddingP_id');
    }
}
