<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Hash;
use Validator;

class UserController extends Controller
{
    //
    public function showEdit()
    {
      return view('admin.edituser');
    }

    public function edit(Request $req)
    {
      $oldpassword = $req->oldpassword;
      if ($oldpassword==Hash::check($oldpassword, auth()->user()->password)) {
        $user = User::where('user_id', auth()->user()->user_id)->first();
        $user->username = $req->username;
        if (isset($req->newpassword)) {
          Validator::make($req->all(),[
              'newpassword' => 'required|string|confirmed'
            ])->validate();

          $user->password = Hash::make($req->newpassword);
          
        }
        $user->save();

        return redirect()->back()->with('status', 'User Saved');
      }else{
        return redirect()->back()->with('error', 'Wrong Password');
      }
      // $user = auth()->user()->user_id;
      // $user = $req->username;
    }
}
