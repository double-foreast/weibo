<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class SessionsController extends Controller
{

    public function __construct()
    {
        $this->middleware('guest',[
            'only'  =>  ['create']
        ]);
    }

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
        if(Auth::attempt($credentials,$request->has('remember'))){
            //是否已激活
            if(Auth::user()->activated){
                session()->flash('success','欢迎你！');
                return redirect()->intended(route('users.show',Auth::user()));
            }else{
                Auth::logout();
                session()->flash('warning','账号还未激活，请检查邮箱中的邮件进行激活后再操作');
                return redirect('/');
            }
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
