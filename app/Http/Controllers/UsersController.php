<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Mail;
use Auth;

class UsersController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth',[
            'except'    =>  ['show','create','store','index','confirmEmail']
        ]);
        $this->middleware('guest',[
            'only'  =>  ['create','confirmEmail']
        ]);
    }

    public function confirmEmail($token)
    {
        $user = User::where('activation_token',$token)->firstOrFail();
        $user->activated = true;
        $user->activation_token = null;
        $user->save();
        Auth::login($user);
        session()->flash('success','恭喜你，激活成功！');
        return redirect()->route('users.show',$user);
    }

    public function index()
    {
        $users = User::paginate(30);
        return view('users.index',compact('users'));
    }

    public function show(User $user)
    {
        return view('users.show',compact('user'));
    }

    //
    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required|max:50',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|confirmed|min:6'
        ]);
        $user = User::create([
            'name'  =>  $request->name,
            'email' =>  $request->email,
            'password'  =>  bcrypt($request->password)
        ]);
        // Auth::login($user);
        $this->sendEmailConfirm($user);
        session()->flash('success','验证邮件已发送到你的注册邮箱上，请注意查收。');
        return redirect()->route('users.show',$user);
    }

    public function edit(User $user)
    {
        $this->authorize('update',$user);
        return view('users.edit',compact('user'));
    }

    public function update(User $user,Request $request)
    {
        $this->authorize('update',$user);
        $this->validate($request,[
            'name'  =>  'required|max:50',
            'password'  =>  'nullable|confirmed|min:6'
        ]);
        $data = [];
        $data['name'] = $request->name;
        if($request->password){
            $data['password'] = bcrypt($request->password);
        }
        $user->update($data);
        session()->flash('success','你的信息更改已成功！');
        return redirect()->route('users.show',$user);
    }

    public function destroy(User $user)
    {
        $this->authorize('delete',$user);
        $user->delete();
        session()->flash('success','删除用户成功');
        return back();
    }

    protected function sendEmailConfirm($user)
    {
        $view = 'emails.confirm';
        $data = compact('user');
        $from = 'dianshichengjin@foxmail.com';
        $name = 'hehuan';
        $to = $user->email;
        $subject = '感谢你的注册，请确认你的邮箱';
        Mail::send($view, $data, function($message)use($from, $name, $to, $subject){
            $message->from($from, $name)->to($to)->subject($subject);
        });
    }
}
