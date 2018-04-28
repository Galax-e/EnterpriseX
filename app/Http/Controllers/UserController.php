<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    //
    public function index() {

    }
    
    public function new_member()
    {
        $newMember_email = Input::get('email');
        $newMember_userID = DB::table('users')->where('email', $newMember_email);

        $member = new Member;
        $member->team_id = Input::get('team_id');
        $member->user_id = $newMember_userID;
        $member->added_by = Auth::user()->id;
        $member->save();
        return redirect()->back();
    }
}
