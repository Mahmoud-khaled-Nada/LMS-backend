<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:View User|Edit User', ['only' => ['index', 'store']]);
        $this->middleware('permission:Edit User', ['only' => ['edit', 'update']]);
        $this->middleware('permission:Send Email', ['only' => ['sendEmail']]);
    }

    public function index()
    {
        $users = User::all();
        return view('AdminPanel.users.index',get_defined_vars());
    }

    // public function create()
    // {
    //     //
    // }


    // public function store(Request $request)
    // {
    //     //
    // }


    // public function show($id)
    // {
    //     //
    // }


    public function edit($id)
    {
        $user = User::findOrFail($id);
        $user->status = ($user->status == 1)? 2:1;
        $user->save();
        return redirect()->route('users.index')->with('success', __('lang.updated'));
    }


    // public function update(Request $request, $id)
    // {
    //     //
    // }


    // public function destroy($id)
    // {
    //     //
    // }

    public function sendEmail(Request $request){
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'subject' => 'required|string',
            'message' => 'required|string',
        ]);
        $user = User::findOrFail($request->user_id);
        Mail::to($user->email)->send( new \App\Mail\UserEmail($request->subject,$request->message));
        return redirect()->back()->with('success',__('lang.sended'));
    }
}