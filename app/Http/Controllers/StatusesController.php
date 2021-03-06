<?php

namespace App\Http\Controllers;

use App\Models\Status;
use Illuminate\Http\Request;
use Auth;

class StatusesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'content'   =>  'required|max:140'
        ]);
        $user = Auth::user();
        $user->createStatus($request->input('content'));
        session()->flash('success','发布成功');
        return redirect()->back();
    }

    public function destroy(Status $status)
    {
        $this->authorize('delete',$status);
        $status->delete();
        session()->flash('success','删除成功');
        return redirect()->back();
    }

}
