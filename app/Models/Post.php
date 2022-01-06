<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    public function user()
    {
        // this goes hand in hand with the User model post function
        // one post belongs to one user
        return $this->belongsTo(User::class);
    }
}
