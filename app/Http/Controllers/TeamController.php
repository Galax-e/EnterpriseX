<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Team;
use App\TeamMember;
use App\Task;
use App\Issue;
use DB;
use Auth;

class TeamController extends Controller
{
    //
    public function team_board(Request $request, $p_id, $t_id) {
        $team_id = $t_id; //$request->query('id');
        $project_id = $p_id;
        $user = Auth::user();
        // $team = Team::find($t_id);        
        $team_member = TeamMember::where('team_id', $team_id)
                        ->where('member_id', optional($user->member)->id);

        $tasks = DB::table('tasks')->where('team_id', $team_id)->orderBy('created_at', 'DESC')->get();
        
        if ($user->hasRole('owner')) {                
            return view('jobs.tasks.index', compact('tasks', 'project_id', 'team_id', 'user'));
        }else{
            if ($team_member) {
                return view('jobs.tasks.index', compact('tasks', 'project_id', 'team_id', 'user'));
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
        $team_id = $t_id; //Input::get('id');
        $count = TeamMember::where('team_id','=', $team_id)->count();
        // $task = Task::where('team_id', $t_id)->get();
        $project = DB::table('projects')->where('id', $p_id)->get()[0];
        // dd( $project);
        return view('team_detail', compact('team_id', 'count', 'project', 'p_id', 't_id'));
    }
    
    public function create_team(Request $request, $id)
    {
        $team = new Team;
        $team->name = $request->input('name'); 
        // $team->client = Input::get('client'); 
        // $team->description = Input::get('description');
        // $team->project = Input::get('project');
        // $team->priority = Input::get('priority');
        $team->belongs_to = $request->input('belongs_to');
        $team->project_id = $id; //  $request->input('project_id');
        // $team->progress_update = $request->input('update_progress');
        $team->created_by = Auth::user()->id;
        $team->save();

        // \Alert::success('New team created.');
        return redirect()->back()->with('message', 'New team created');
    }

    public function teams_board()
    {
        return view('teams_board');
    }
}
