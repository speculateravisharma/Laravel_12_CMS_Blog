<?php

namespace App\Models\Post;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PostModel extends Model
{
    protected $table = 'posts';

    protected $fillable = [
        'title',
        'category',
        'user_id',
        'user_name',
        'description',
        'image',
    ];
}