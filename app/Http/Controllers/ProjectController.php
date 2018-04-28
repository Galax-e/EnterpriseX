<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProjectController extends Controller
{
    //

    public function index() {
        
    }

    public function projects(Request $request)
    {
        return view('project_team.projects');
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
