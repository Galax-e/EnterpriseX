<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\AgileBoard;
use App\Auth;

class AgileBoardController extends Controller
{
    //

    public function createTodo(Request $request) {

        // $this->validate($request, [
        //     'description' => 'required',

        // ]);        
        // $user = Auth::user();
        // $todo = new AgileBoard;
        // $todo->description = $request->input('description'); // get task description ...
        // $todo->created_by = $user->id;
        // $todo->save();

        $data = ['success'];
        return "false";
    }
}
