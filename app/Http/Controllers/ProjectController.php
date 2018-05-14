<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Organization;
use App\Models\Project;
use App\TeamMember;

class ProjectController extends Controller
{
    //

    public function index() {
        
    }

    public function projects(Request $request, Organization $org)
    {
        
        $projects = auth()->user()->user_org_projects($org);

        return view('project_team.projects', compact('projects', 'org'));
    }

    public function members_projects(Request $request, Organization $org)
    {

        $projects = $org->projects()->paginate(10);

        // dd($projects);

        // if (Auth::user()->isAdmin()) {
        //     $projects = App\Models\Project::paginate(10);
        // }else{
        //     $projects = DB::table('projects')->where('organization_id', Auth::user()->organization->id)->orderBy('created_at', 'DESC')->paginate(10);
        // }
        return view('project_team.member.projects', compact('projects', 'org'));
    }

    public function create_project(Request $request)
    {
        $project = new Project;
        $project->title = $request->input('name'); 
        $project->description = $request->input('description');
        // $project->project = $request->input('project');
        $project->priority = $request->input('priority');
        // $project->progress_update = 'no';// $request->input('progress_update');
        $project->internal = $request->input('internal');
        $org_id = Auth::user()->organization()->id;
        $project->organization_id = $org_id;
        if ($request->has('client')) {
            $client = DB::table('clients')
                ->where('name', $request->input('client'))
                ->where('organization_id', $org_id)->get();
            $project->client_id = $client->id;
        }
        $project->save();

        // \Alert::success('New project created.');
        return redirect()->back()->with('message', 'New project created');
    }
}
