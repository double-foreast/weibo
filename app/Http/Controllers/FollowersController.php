<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Auth;

class FollowersController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(User $user)
    {
        $this->authorize('follow',$user);
        if(Auth::user()->isFollowing($user->id) == false){
            Auth::user()->follow($user->id);
        }
        return redirect()->route('users.show',$user);
    }

    public function destroy(User $user)
    {
        $this->authorize('follow',$user);
        if(Auth::user()->isFollowing($user->id) == true){
            Auth::user()->unfollow($user->id);
        }
        return redirect()->route('users.show',$user);
    }
}
