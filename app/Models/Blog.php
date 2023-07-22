<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $fillable = ['title', 'content', 'image', 'user_id', 'view_count'];

   

    // Define the relationship with the user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
