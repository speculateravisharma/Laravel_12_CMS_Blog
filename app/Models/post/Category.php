<?php

namespace App\Models\post;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //

    protected $table = 'categories';

    protected $fillable = [
        'id',
        'name',
        'created_at',
        'updated_at'
    ];    
}
