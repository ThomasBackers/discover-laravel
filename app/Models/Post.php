<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Post extends Model
{
    use HasFactory;
    use Sluggable;

    // here we pass the table columns that need to be filled in
    protected $fillable = [
        'title',
        'slug',
        'description',
        'image_path',
        'user_id'
    ];

    public function user()
    {
        // this goes hand in hand with the User model post function
        // one post belongs to one user
        return $this->belongsTo(User::class);
    }

    public function sluggable(): array //<- this means that the method must return an array
    {
        return [
            'slug' => [
                // it grabs the title and makes a slug outta it
                'source' => 'title'
            ]
        ];
    }
}
