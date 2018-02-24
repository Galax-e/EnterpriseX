<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\AgileBoard;
use Auth;
use DB;

class AgileBoardController extends Controller
{
    //
    public function index(Request $request) {

        $todos = DB::table('agile_boards')->orderBy('created_at', 'DESC')->get();
        return view('agile_board.index', compact('todos'));
    }

    public function createTodo(Request $request) {

        $this->validate($request, [
            'description' => 'required',

        ]);        
        $user = Auth::user();
        $todo = new AgileBoard;
        $todo->description = $request->input('description'); // get task description ...
        $todo->created_by = $user->id;
        $todo->save();


        $html = "$todo->description
                <div class='agile-detail'>
                    <a href='#' class='pull-right btn btn-xs btn-white'>Tag</a>
                    <i class='fa fa-clock-o'></i> ".date('M d, Y', strtotime($todo->created_at))."
                </div>
        ";
        $data = ["description"=>$todo->description, "created_at"=>$todo->created_at, "updated_at" =>$todo->updated_at, "html"=>$html];
        return response()->json($data);
    }
    
}
