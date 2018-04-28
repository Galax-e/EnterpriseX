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

        $html = "$task->description
                <div class='agile-detail'>
                    <a href='#' class='pull-right btn btn-xs btn-white delete_task' id='delete_task-".$task->id."'><i class='trash_task fa fa-trash'></i> Delete</a>
                    <a href='#' data-toggle='modal' data-target='#taskBoardModal' class='pull-right btn btn-xs btn-white task_info' id='task_info-".$task->id."'><i class='trash_task fa fa-info'></i> Info</a>
                    <i class='fa fa-clock-o'></i> ".date('M d, Y - h:i:s A', strtotime($task->created_at))."
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

    public function createIssue(Request $request, $t_id){
        $issue = new Issue;
        $issue->description = $request->input('description'); // get task description ...
        $issue->created_by = Auth::user()->id;
        $issue->team_id = $t_id;

        // create a corresponding task for the issue.
        $task = new Task;
        $task->description = $request->input('description'); // get task description ...
        $task->created_by = $user->id;
        $task->team_id = $request->input('team_id');
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
}
