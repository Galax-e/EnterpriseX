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
                    <a href='#' class='pull-right btn btn-xs btn-white delete_todo' id='delete_todo-".$todo->id."'><i class='trash_todo fa fa-trash'></i></a>
                    <i class='fa fa-clock-o'></i> ".date('M d, Y', strtotime($todo->created_at))."
                </div>";
        $data = ["id"=>$todo->id, "html"=>$html];
        return response()->json($data);
    }

    public function deleteTodo(Request $request) {

        $id = $request->input('todo_id');
        // $todo = DB::table('agile_boards')->where('id', $id)->get();
        // apply condition
    
        DB::table('agile_boards')->where('id', $id)->delete();    
        $data = ["id"=>$id];
        return response()->json($data);
    }

    public function moveTodo(Request $request) {

        $id = $request->input('todo_id');
        // $todo = DB::table('agile_boards')->where('id', $id)->get();
        // apply condition
    
        DB::table('agile_boards')->where('id', $id)->delete();    
        $data = ["id"=>$id];
        return response()->json($data);
    }
    
}
