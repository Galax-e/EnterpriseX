<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Team;
use App\Models\Project;
use App\TeamMember;
use App\Task;
use App\Issue;
use DB;
use Auth;

class TeamController extends Controller
{
    //
    
    public function teams(Request $request)
    {
        return view('project_team.teams');
    }

    public function project_teams(Request $request, Project $p_id) {
        
        $project = $p_id;
        $id = $p_id->id;
        $teams = $project->teams;

        return view('project_team.teams', compact('teams', 'id'));
    }

    public function team_detail(Request $request, Project $p_id, Team $t_id)
    {
        $team = $t_id; //Input::get('id');
        $count = TeamMember::where('team_id','=', $t_id->id)->count();
        // $task = Task::where('team_id', $t_id)->get();
        $project = $p_id;
        // dd( $project);
        return view('team_detail', compact('team', 'count', 'project', 'p_id', 't_id'));
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
