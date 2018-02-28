<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

use App\AgileBoard;
use App\Team;
use App\Member;
use App\Document;
use App\Activity;
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

    public function updateTodoStatus(Request $request) {

        $task_id = $request->input('task_id');
        $status = $request->input('status');
        // $todo = DB::table('agile_boards')->where('id', $id)->get();
        // apply condition
    
        // DB::table('agile_boards')->where('id', $id)->delete();    
        $data = ["id"=>$task_id];
        return response()->json($data);
    }

    public function issueTracker(){
        $count = AgileBoard::where('created_by','=',Auth::user()->id)->count();
        return view('agile_board.issuetracker', compact('count'));
    }

    public function createTicket(){
        $todo = new AgileBoard;
        $todo->description = Input::get('description'); // get task description ...
        $todo->created_by = Auth::user()->id;
        $todo->save();
        return redirect()->back();
    }

    public function deleteTicket(){
        $id = Input::get('id');
        DB::table('agile_boards')->where('id', $id)->delete();  
        return redirect()->back();
    }

// Team or Module
    public function team()
    {
        return view('team');
    }

    public function team_detail()
    {
        $teamid = Input::get('id');
        $count = Member::where('teamid','=', $teamid)->count();
        return view('team_detail', compact('teamid', 'count'));
    }
    
    public function create_team()
    {
        $team = new Team;
        $team->name = Input::get('name'); 
        $team->client = Input::get('client'); 
        $team->description = Input::get('description');
        $team->project = Input::get('project');
        $team->priority = Input::get('priority');
        $team->updateprogress = Input::get('updateprogress');
        $team->created_by = Auth::user()->id;
        $team->save();
        return redirect()->back();
    }

    public function new_member()
    {
        $member = new Member;
        $member->teamid = Input::get('teamid');
        $member->member_id = Input::get('email'); 
        $member->added_by = Auth::user()->id;
        $member->save();
        return redirect()->back();
    }

        public function add_file()
        {
            $uploaded_images = array();
            foreach($_FILES['upload_images']['name'] as $key=>$val)
                {
                    $upload_dir = "files/";
                    $upload_file = $upload_dir.time().$_FILES['upload_images']['name'][$key];
                    if(move_uploaded_file($_FILES['upload_images']['tmp_name'][$key],$upload_file))
                        {
                            $upload = new Document;
                            $upload->teamid = Input::get('teamid');
                            $upload->file_name = Input::get('file_name');
                            $upload->file = time().$_FILES['upload_images']['name'][$key];
                            $upload->uploaded_by = Auth::user()->id;
                            $upload->save();
                            
                            $activity = new Activity;
                            $activity->teamid = Input::get('teamid');
                            $activity->title = 'Added new file';
                            $activity->comment = Auth::user()->name.' Added <b>'.Input::get('file_name').'</b> file';
                            $activity->status = 'Added';
                            $activity->activity_by = Auth::user()->id;
                            $activity->save();
                    }
                }
            return redirect()->back();
        }

    public function teams_board()
    {
        return view('teams_board');
    }
    
}
