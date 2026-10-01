<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\posts\PostsController;
use App\Http\Controllers\categories\CategoriesController;
use App\Http\Controllers\Users\UsersController;
use App\Http\Controllers\Admins\AdminsController;


// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/', [PostsController::class, 'index'])
    ->name('welcome');

Route::get('/home', [PostsController::class, 'index'])
    ->name('home');

Route::get('/contact', [PostsController::class, 'contact'])
    ->name('contact');

Route::get('/about', [PostsController::class, 'about'])
    ->name('about');


//Cleanup

Route::group(['prefix' =>'posts'], function(){
    
    Route::get('/index', [PostsController::class, 'index'])
    ->middleware('auth')
    ->name('posts.index');

    Route::get('/single/{id}', [PostsController::class, 'single'])
        ->name('posts.single');
        
    Route::post('/comment-store', [PostsController::class, 'storeComment'])
        ->middleware('auth')
        ->name('comment.store');

    Route::get('/create-post', [PostsController::class, 'CreatePost'])
        ->middleware('auth')
        ->name('posts.create');

    Route::post('/post-store', [PostsController::class, 'storePost'])
        ->middleware('auth')
        ->name('posts.store');

    Route::post('/post-delete/{id}', [PostsController::class, 'deletePost'])
        ->middleware('auth')
        ->name('posts.delete');

    //update
    Route::get('/post-edit/{id}', [PostsController::class, 'editPost'])
        ->middleware('auth')
        ->name('posts.edit');

    Route::post('/post-update/{id}', [PostsController::class, 'updatePost'])
        ->middleware('auth')
        ->name('posts.update');

    //search
    Route::any('/search', [PostsController::class, 'search'])
        ->middleware('auth')
        ->name('posts.search');
});


Route::group(['prefix' => 'categories'], function(){
    Route::get('/category/{name}', [CategoriesController::class, 'category'])
        ->name('category.single');
});


Route::group(['prefix' => 'users'], function () {

    Route::get('/edit/{id}', [UsersController::class, 'editProfile'])
        ->name('users.edit');

    Route::any('/update/{id}', [UsersController::class, 'updateProfile']);

    Route::get('/profile/{id}', [UsersController::class, 'profile'])
        ->name('users.profile');
});


Route::get('admin/login', [AdminsController::class, 'viewLogin'])
        ->name('admins.login')->middleware('CheckForAuth');

Route::post('admin/login', [AdminsController::class, 'checkLogin'])
            ->name('admins.check.login');        

Route::group(['prefix' => 'admin', 'middleware' => ['auth:admin', 'CheckForAuth']], function () {
    //admins
    Route::get('/', [AdminsController::class, 'index'])
            ->name('admins.dashboard');

    Route::get('/show-admins', [AdminsController::class, 'admins'])
            ->name('admins.show');

    Route::get('/create-admins', [AdminsController::class, 'createAdmins'])
            ->name('admins.create');

    Route::post('/create-admins', [AdminsController::class, 'storeAdmins'])
            ->name('admins.store');

    //categories            
    Route::get('/show-categories', [AdminsController::class, 'categories'])
            ->name('categories.show');
    
    Route::get('/create-categories', [AdminsController::class, 'createCategories'])
            ->name('categories.create');

    Route::post('/create-categories', [AdminsController::class, 'storeCategories'])
        ->name('categories.store');

    Route::get('/delete-categories/{id}', [AdminsController::class, 'deleteCategories'])
            ->name('categories.delete');
            
    Route::get('/edit-categories/{id}', [AdminsController::class, 'editCategories'])
        ->name('categories.edit');

    Route::get('logout', [AdminsController::class, 'logout'])
        ->name('admins.logout');
    
    Route::post('/update-categories/{id}', [AdminsController::class, 'updateCategories'])
        ->name('categories.update');

    // Route::post('/create-admins', [AdminsController::class, 'storeAdmins'])
    //         ->name('admins.store');

    //posts
    Route::get('/show-posts', [AdminsController::class, 'posts'])
            ->name('posts.show');

    Route::get('/delete-posts/{id}', [AdminsController::class, 'deletePosts'])
            ->name('admins.posts.delete');  
});
