<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

use App\Task;
use App\Models\Organization;
use App\Models\Client;
use App\Models\Team;
use App\Models\Project;
use App\Member;
use App\Issue;
use App\TeamMember;
use App\Document;
use App\Activity;
use Auth;
use DB;
use Propaganistas\LaravelIntl\Facades\Country;
use Illuminate\Validation\Rule;

class TaskController extends Controller
{
    //
    public function createTask(Request $request, $p_id, $t_id) {
        
        $this->validate($request, [
            'description' => 'required',
            'team_id' => 'required',
            'project_id' => 'required'
        ]); 

        $user = Auth::user();
        $task = new Task;
        $task->description = $request->input('description'); // get task description ...
        $task->created_by = $user->id;
        $task->team_id = $request->input('team_id');
        $task->save();

        $team_members = \App\TeamMember::where('team_id', $t_id)->get();
        $users = [];
        foreach($team_members as $team_member) {
            $member = \App\Member::find($team_member->member_id);
            $users[] = $member->user;
        }

        $created_user = \App\User::find($task->created_by);
        $fNameInitial = explode(" ", $created_user->name)[0][0];
        $lNameInitial = explode(" ", $created_user->name)[1][0];                                                      

        $html = "<p>
                    <label>$task->description</label>
                    <span class='pull-right'>
                        <i class='fa fa-clock-o clock_icon' id='date_clock-$task->id' title='click to view date task was created'></i> 
                        <small id='task_date-$task->id'>".date('M d, Y - h:iA', strtotime($task->created_at))."</small>
                    </span>
                </p>
                <div class='agile-detail row' style='padding: 0 10px 0 10px'>";
                    if($task->created_by === Auth::user()->id) {
                        $html .= "<a href='#' class='pull-right btn btn-sm btn-white delete_task' id='delete_task-$task->id'><i class='trash_task fa fa-trash'></i> Delete</a>";
                    }
                    $html .= "<a href='#' data-toggle='modal' data-target='#taskBoardModal' class='pull-right btn btn-sm btn-white task_info' id='task_info-$task->id'><i class='trash_task fa fa-info'></i> Info</a>                 
                    <span><small>Created by</small>
                        <img title='$created_user->name' src='https://placehold.it/37x37/1ab394/ffffff/&text=$fNameInitial $lNameInitial' class='img-circle' alt='User Image'></span>
                    </span>
                </div>";

        $data = ["id"=>$task->id, "html"=>$html];
        return response()->json($data);
    }

    public function deleteTask(Request $request) {

        $id = $request->input('task_id');
        // $todo = DB::table('agile_boards')->where('id', $id)->get();
        // apply condition
    
        DB::table('tasks')->where('id', $id)->delete();    
        $data = ["id"=>$id];
        return response()->json($data);
    }

    public function updateTaskStatus(Request $request) {

        $task_id = $request->input('task_id');
        $task_id = explode("-", $task_id)[1];
        $status = $request->input('status');

        $task_status = ["todo"=>'todo', "inprogress"=>'inprogress', "completed"=>'done'];
        $status = $task_status[$status];

        DB::table('tasks')->where('id', $task_id)->update(['status' => $status, 'updated_by' => Auth::user()->id]);
        // $todo = DB::table('agile_boards')->where('id', $id)->get();
        // apply condition
    
        // DB::table('agile_boards')->where('id', $id)->delete();    
        $data = ["id"=>$task_id, "status"=>$status];
        return response()->json($data);
    }

    public function issueTracker(){
        $count = Issue::where('created_by','=',Auth::user()->id)->count();
        return view('jobs.issues.index', compact('count'));
    }

    public function createIssue(Request $request, $p_id, $t_id){

        $user = Auth::user();
        $issue = new Issue;
        $issue->description = $request->input('description'); // get task description ...
        $issue->created_by = $user->id;
        $issue->team_id = $t_id;

        // create a corresponding task for the issue.
        $task = new Task;
        $task->description = $request->input('description'); // get task description ...
        $task->created_by = $user->id;
        $task->team_id = $t_id; // $request->input('team_id');
        $task->from_issue = 1;
        $task->save();

        // attach task to issue
        $issue->task_id = $task->id;
        $issue->save();
        return redirect()->back();
    }

    public function deleteIssue(Request $request){
        $id = $request->input('id');
        DB::table('issues')->where('id', $id)->delete();  
        return redirect()->back();
    } 

    public function task_board(Request $request, Project $p_id, Team $t_id) {

        $team_id = $t_id->id; //$request->query('id');
        $project_id = $p_id->id;
        $user = Auth::user();
        // $team = Team::find($t_id);

        $org = $p_id->organization;
        $member_id = $user->user_org_member_id($org);
        $team_member = TeamMember::where('team_id', $team_id)
                        ->where('member_id', $member_id);

        $tasks = DB::table('tasks')->where('team_id', $team_id)->orderBy('created_at', 'DESC')->get();
        
        $team_members = \App\TeamMember::where('team_id', $team_id)->get();
        $users = [];
        foreach($team_members as $team_member) {
            $member = \App\Member::find($team_member->member_id);
            $users[] = $member->user;
        }

        if ($user->hasRole('owner')) {                
            return view('jobs.tasks.index', compact('tasks', 'project_id', 'team_id', 'user', 'users'));
        }else{
            if ($team_member) {
                return view('jobs.tasks.index', compact('tasks', 'project_id', 'team_id', 'user', 'users'));
            }
            return redirect()->back(); // user is not a member of that team
        }  
    }

    public function issue_board (Request $request, $p_id, $t_id) {

        $team_id = $t_id; //$request->query('id');
        $project_id = $p_id;
        $user = Auth::user();
        // $team = Team::find($t_id);        
        $team_member = TeamMember::where('team_id', $team_id)
                        ->where('member_id', optional($user->member)->id);
        
        $issues = DB::table('issues')->where('team_id', $team_id)->orderBy('created_at', 'DESC')->get();
        $count = Issue::where('created_by','=',Auth::user()->id)->count();
        if ($user->is_executive()) {                
            return view('jobs.issues.index', compact('issues', 'project_id', 'team_id', 'count', 'user'));
        }else{
            if ($team_member) {
                return view('jobs.issues.index', compact('issues', 'project_id', 'team_id', 'count', 'user'));
            }
            return redirect()->back(); // user is not a member of that team
        }           
    }
}
