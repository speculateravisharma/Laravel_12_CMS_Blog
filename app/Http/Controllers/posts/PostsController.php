<?php

namespace App\Http\Controllers\posts;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\post\PostModel;
use App\Models\post\Comment;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\post\Category;

class PostsController extends Controller
{
    public function index()
    {
        // Left side - 2 posts
        $posts = PostModel::orderBy('id', 'asc')
            ->take(2)
            ->get();

        // Middle - latest post
        $postOne = PostModel::orderBy('id', 'desc')
            ->first();

        // Right side - next 2 posts
        $postTwo = PostModel::orderBy('id', 'desc')
            ->skip(1)
            ->take(2)
            ->get();

        
        // $postBus = PostModel::where('category', 'Business')
        //     ->take(2)
        //     ->get();


        // Business section
        $postBus = PostModel::where('category', 'Business')
                    ->orderBy('id', 'desc')
                    ->take(2)
                    ->get();

        $postBusTwo = PostModel::where('category', 'Business')
                    -> orderBy('title', 'desc')
                    ->take(3)
                    ->get();

        // Random Post Section
        $randomPosts = PostModel::take(4)->orderBy('category','desc')->get();

        //culture section
        $postCulture = PostModel::where('category','Culture')->orderBy('id', 'desc')->take(2)->get();
        $postCultureTwo = PostModel::where('category','Culture')->orderBy('category', 'desc')->take(3)->get();

        //Politics section
        $postPolitics = PostModel::where('category','Politics')->take(9)->orderBy('created_at', 'desc')->get();

        // Travel section
        $postTravel = PostModel::where('category', 'Travel')
            ->orderBy('id', 'desc')
            ->take(1)
            ->get();

        $postTravelOne = PostModel::where('category', 'Travel')
            ->orderBy('id', 'desc')
            ->skip(1)
            ->take(1)
            ->get();

        $postTravelTwo = PostModel::where('category', 'Travel')
            ->orderBy('description', 'desc')
            ->skip(1)
            ->take(2)
            ->get();    

        return view('posts.index', compact(
            'posts',
            'postOne',
            'postTwo',
            'postBus',
            'postBusTwo',
            'randomPosts',
            'postCulture',
            'postCultureTwo',
            'postPolitics',
            'postTravel',
            'postTravelOne',
            'postTravelTwo'
        ));
    }

    public function single(int $id){
        $single = PostModel::find($id);
        $user = User::find($single->user_id);
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
        
        //print_r($categories);


        //grabbing comments
        $comments = Comment::where('post_id', $id)->get();
        $commentNum = $comments->count();

        $moreBlogs = PostModel::where('category',$single->category)
            ->where('id','!=', $id)
            ->take(4)
            ->get();

        //print_r($moreBlogs);

        return view('posts.single', compact('single','user','pupPosts','categories','comments','moreBlogs','commentNum'));        
    }

    public function storeComment(Request $request)
    {
        $insertComment = Comment::create([
            "comment" => $request->comment,
            "user_id" => Auth::user()->id,
            "user_name" => Auth::user()->name,
            "post_id" => $request->post_id,
        ]);

        return redirect('/posts/single/'.$request->post_id)
            ->with('success', 'comment inserted successfully');
    }


    public function CreatePost(){
        $categories = Category::all();
        if (!Auth::check()) { 
            return view("posts.create-post",compact('categories'));
        } else {
            return abort('404');
        }
    }

    public function storePost(Request $request){

        $destinationPath = 'assets/images/';
        $myimage = $request->image->getClientOriginalName();
        $request->image->move(public_path($destinationPath),$myimage);
    
        $insertPost = PostModel::create([
            "title" => $request->title,
            "category" => $request->category,
            "user_id" => Auth::user()->id,
            "user_name" => Auth::user()->name,
            "description" => $request->description,
            "image" => $myimage
        ]);        

        return redirect('/posts/create-post')
            ->with('success', 'Post Inserted Successfully');
    }

    public function deletePost(int $id){
        $deletePost = PostModel::find($id);
        
        $file_path = public_path('assets/images/'.$deletePost->image);
        unlink($file_path);


        $deletePost->delete();

        return redirect('/posts/index')
            ->with('delete', 'Post Deleted Successfully');
    }

    
    public function editPost(int $id)
    {
        $single = PostModel::find($id);
        $categories = Category::all();


        if (!Auth::check()) {
            return abort(404);
        }

        if (Auth::id() == $single->user_id) {
            return view("posts.edit-post", compact('single', 'categories'));
        }

        return abort(404);
    }


    public function updatePost(Request $request, int $id)
    {
        // 1. Validate first
        $request->validate([
            'title' => 'required|max:140',
            'category' => 'required',
            'description' => 'required|max:1300',
        ]);

        // 2. Find post
        $updatePost = PostModel::findOrFail($id);

        // 3. Update post
        $updatePost->update([
            'title' => $request->title,
            'category' => $request->category,
            'description' => $request->description,
        ]);

        // 4. Redirect
        return redirect('/posts/single/' . $updatePost->id)
            ->with('update', 'Post Updated Successfully');
    }

    public function search(Request $request)
    {
        $search = $request->get('search');

         $results = PostModel::where('title', 'like', "%$search%")->get();

        return view('posts.search', compact('results'));
    }    


    public function contact()
    {
        return view('pages.contact');
    }


    public function about()
    {
        return view('pages.about');
    }
}