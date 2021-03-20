<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;

class PasswordController extends Controller
{

    public function __construct()
    {
        $this->middleware('guest',['getEmail','postEmail','getReset','postReset']);
    }

    public function getEmail()
    {
        return view('auth.email');
    }

    public function postEmail(Request $request)
    {
        $this->validate($request,['email'=>'required|email|exists:users']);
        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
                    ? back()->with(['status' => __($status)])
                    : back()->withErrors(['email' => __($status)]);
        /*$email = $request->get('email');
        $user = User::where('email',$email)->first();
        //生成password_resets
        $this->sendEmailReset($user);
        session()->flash('success','重置密码邮件已发送！');
        return redirect()->back();*/
    }

    public function getReset(Request $request)
    {
        $token = $request->route('token');
        return view('auth.reset-password', ['token' => $token,'request'=>$request]);
    }

    public function postReset(Request $request)
    {
        $this->validate($request,[
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
        ]);
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );
        return $status == Password::PASSWORD_RESET
                ? redirect()->route('login')->with('status', __($status))
                : back()->withErrors(['email' => [__($status)]]);
    }

    protected function sendEmailReset($user)
    {
        $view = 'emails.reset';
        $data = compact('user');
        $from = 'dianshichengjin@foxmail.com';
        $name = 'hehuan';
        $to = $user->email;
        $subject = '重置密码';
        Mail::send($view, $data, function($message)use($from, $name, $to, $subject){
            $message->from($from, $name)->to($to)->subject($subject);
        });
    }

}
