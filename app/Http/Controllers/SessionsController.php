<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class SessionsController extends Controller
{

    public function create()
    {
        return view('sessions.create');
    }

    public function store(Request $request)
    {
        $credentials = $this->validate($request,[
            'email' =>  'required|email|max:255',
            'password'  =>  'required'
        ]);
        if(Auth::attempt($credentials)){
            session()->flash('success','欢迎你！');
            return redirect()->route('users.show',Auth::user());
        }else{
            session()->flash('danger','你输入的邮箱和密码不匹配');
            return redirect()->back()->withInput();
        }
        return;
    }

    public function destory()
    {
        Auth::logout();
        session()->flash('success','你已退出');
        return redirect('login');
    }

}
