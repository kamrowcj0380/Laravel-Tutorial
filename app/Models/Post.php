<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'title',
        'body',
        'user_id'
    ];

    public function user() {
        //Laravel will write an sql statement to get the username using the user_id
        return $this->belongsTo(User::class, 'user_id');
    }
}
