<?php

namespace App\Http\Controllers\Categories;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\post\Category;
use App\Models\post\PostModel;
use Illuminate\Support\Facades\DB;

class CategoriesController extends Controller
{
    public function category(string $name)
    {
        $posts = PostModel::where('category', $name)
            ->take(5)
            ->orderBy('created_at','desc')
            ->get();

        $pupPosts = PostModel::take(3)->orderBy('id','desc')->get();

        $categories = DB::table('categories')
                        ->join('posts','posts.category','=','categories.name')
                        ->select(
                                'categories.name AS name',
                                'categories.id AS id',
                                'posts.user_id AS user_id',
                                DB::raw('COUNT(categories.id) AS total')
                            )
                        ->groupBy('posts.category')
                        ->get();

        return view('categories.category', compact('name', 'posts', 'pupPosts', 'categories'));
    }
}