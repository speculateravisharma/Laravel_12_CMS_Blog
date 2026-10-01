<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Models\Admin\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post\PostModel;
use App\Models\Post\Category;
use Illuminate\Support\Facades\Hash;


class AdminsController extends Controller
{
    //

    public function viewLogin(){
        return view('admins.login-admins');
    }

    public function checkLogin(Request $request){

        $request->validate([
            'email' => 'required',
            'password' => 'required',            
        ]);

        $remember_me = $request->has('remember_me') ? true : false;

        if (auth()->guard('admin')->attempt(['email' => $request->input("email"), 'password' => $request->input("password")], $remember_me)) {
            
            return redirect() -> route('admins.dashboard');
        }
        return redirect()->back()->with(['error' => 'error logging in']);
    }

    public function logout()
    {
        Auth::guard('admin')->logout();

        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect()->route('admins.login');
    }

    public function index(){

        $posts = PostModel::all();
        $postCount = $posts->count();

        $categories = Category::all();
        $categoriesCount = $categories->count();

        $admins = Admin::all();
        $adminsCount = $admins->count();

        return view('admins.index',compact('postCount','categoriesCount','adminsCount'));
    }

    //admins section

    public function admins(){
        $admins = Admin::all();

        return view('admins.admins',compact('admins'));
    }

    public function createAdmins(){
        return view('admins.create-admins');
    }

    public function storeAdmins(Request $request){

        $request->validate([
            'email' => 'required|max:80',
            'name' => 'required',
            'password' => 'required',
        ]);

        $insertAdmin = Admin::create([
            "email" => $request->email,
            "name" => $request->name,
            "password" => Hash::make($request->password),
        ]);        

        return redirect('/admin/show-admins')
            ->with('success', 'Admin Created Successfully');
    }
    

    public function categories(){
        $categories = Category::all();

        return view('admins.categories',compact('categories'));
    }
    

    public function createCategories(){       

        return view('admins.create-Categories');

    }
    

    public function storeCategories(Request $request){
        $request->validate([
            'name' => 'required|max:40'
        ]);

        $insertCategory = Category::create([     
            "name" => $request->name,            
        ]);        

        return redirect('/admin/show-categories')
            ->with('success', 'Category Created Successfully');
    }

    public function deleteCategories(int $id){
        $category = Category::find($id);
        $category->delete();

        return redirect('/admin/show-categories')
            ->with('delete', 'Category Deleted Successfully');
    }


    public function editCategories(int $id){
        $category = Category::find($id);

        return view('admins.edit-categories', compact('category'));
    }


    public function updateCategories(Request $request,int $id){

        $request->validate([
            'name' => 'required|max:40'
        ]);

        $updateCategory = Category::findOrFail($id);

        $updateCategory->update($request->all());        

        return redirect('/admin/show-categories')
            ->with('update', 'Category Updated Successfully');
    }

    //posts

    public function posts(){
        $posts = PostModel::all();

        return view('admins.posts', compact('posts'));
    }


    public function deletePosts(int $id){
        $post = PostModel::find($id);
        
        $file_path = public_path('assets/images/'.$post->image);
        unlink($file_path);
        
        $post->delete();

        return redirect('/admin/show-posts')
            ->with('delete', 'Post Deleted Successfully');
    }

    
    

    
    
}
