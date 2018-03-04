<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

use App\AgileBoard;
use App\Team;
use App\Model\Project;
use App\Member;
use App\Document;
use App\Activity;
use Auth;
use DB;

class AgileBoardController extends Controller
{
    //
    public function index(Request $request, $p_id, $t_id) {

        $team_id = $t_id; //$request->query('id');
        $user = Auth::user();
        $todos = DB::table('agile_boards')->where('team_id', $team_id)->orderBy('created_at', 'DESC')->get();
        return view('agile_board.index', compact('todos', 'p_id', 't_id', 'user'));
    }

    public function createTodo(Request $request) {

        $this->validate($request, [
            'description' => 'required',
            'team_id' => 'required',
            'project_id' => 'required'
        ]); 

        $user = Auth::user();
        $todo = new AgileBoard;
        $todo->description = $request->input('description'); // get task description ...
        $todo->created_by = $user->id;
        $todo->team_id = $request->input('team_id');
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
        $task_id = explode("-", $task_id)[1];
        $status = $request->input('status');

        $todo_status = ["todo"=>0, "inprogress"=>1, "completed"=>2];

        $status = $todo_status[$status];

        DB::table('agile_boards')->where('id', $task_id)->update(['status' => $status, 'updated_by' => Auth::user()->id]);
        // $todo = DB::table('agile_boards')->where('id', $id)->get();
        // apply condition
    
        // DB::table('agile_boards')->where('id', $id)->delete();    
        $data = ["id"=>$task_id, "status"=>$status];
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

    public function projects(Request $request)
    {
        return view('project_team.projects');
    }

    public function create_project(Request $request)
    {
        $project = new Project;
        $project->title = Input::get('name'); 
        $project->client = Input::get('client');
        $project->description = Input::get('description');
        // $project->project = Input::get('project');
        $project->priority = Input::get('priority');
        // $project->progress_update = 'no';// Input::get('progress_update');
        $project->created_by = Auth::user()->id;
        $project->save();
        return redirect()->back();
    }

    public function teams(Request $request)
    {
        return view('project_team.teams');
    }

    public function project_teams(Request $request, $id)
    {
        // dd($request->get('id'));
        // $project_teams = DB::table('teams')->where('project_id', $id)->get();
        return view('project_team.teams', compact('id'));
    }

    public function team_detail(Request $request, $p_id, $t_id)
    {
        $teamid = $t_id; //Input::get('id');
        $count = Member::where('team_id','=', $teamid)->count();
        $agile_board = AgileBoard::where('team_id', $t_id)->get();
        $project = DB::table('projects')->where('id', $p_id)->get()[0];
        // dd( $project);
        return view('team_detail', compact('teamid', 'count', 'project', 'p_id', 't_id'));
    }
    
    public function create_team(Request $request, $id)
    {
        $team = new Team;
        $team->name = $request->input('name'); 
        // $team->client = Input::get('client'); 
        // $team->description = Input::get('description');
        // $team->project = Input::get('project');
        // $team->priority = Input::get('priority');
        $team->project_id = $id; //  $request->input('project_id');
        $team->updateprogress = $request->input('updateprogress');
        $team->created_by = Auth::user()->id;
        $team->save();
        return redirect()->back();
    }

    public function new_member()
    {
        $newMember_email = Input::get('email');
        $newMember_userID = DB::table('users')->where('email', $newMember_email);

        $member = new Member;
        $member->team_id = Input::get('teamid');
        $member->user_id = $newMember_userID;
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
