<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Post\PostModel;

class UsersController extends Controller
{
    public function editProfile(int $id)
    {
        $user = User::findOrFail($id);

        if (Auth::check()) {

            if (Auth::user()->id == $user->id) {

                return view('users.update-profile', compact('user'));

            } else {

                abort(404);

            }

        } else {

            abort(404);

        }
    }

    public function updateProfile(Request $request, int $id)
    {
        $updateProfile = User::findOrFail($id);

        Request()->validate([
            'name' => 'required|max:20',
            'email' => 'required|max:20',
            'bio' => 'required|max:300',
        ]);

        $updateProfile->update($request->all());

        return redirect('posts/index')
            ->with('update.user', 'User Info Updated Successfully');
    }


    public function profile(int $id){
        $profile = User::find($id);
        
        $latestPosts = PostModel::where('user_id', $id)
        ->take(4)
        ->orderBy('created_at','desc')
        ->get();

        return view('users.profile', compact('profile','latestPosts'));
    }
}