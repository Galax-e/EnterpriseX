<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

use App\AgileBoard;
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

class AgileBoardController extends Controller
{
    //
    public function index(Request $request, $p_id, $t_id) {

        $team_id = $t_id; //$request->query('id');
        $user = Auth::user();
        $todos = DB::table('agile_boards')->where('team_id', $team_id)->orderBy('created_at', 'DESC')->get();
        return view('agile_board.index', compact('todos', 'p_id', 't_id', 'user'));
    }

    public function create_client(Request $request) {

        $country_obj = country()->all();
        // "AC,IC,EA,DG,TA"
        unset($country_obj['AC']);
        unset($country_obj['IC']);
        unset($country_obj['EA']);
        unset($country_obj['DG']);
        unset($country_obj['TA']);

        $countries_codes = array_keys($country_obj);
        $country_names = array_values($country_obj);

        $this->validate($request, [
            'name' => 'required',
            'address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'country' => Rule::country($country_names),
            'phone_number' => Rule::phone()->country($countries_codes),
        ]);

        $client = Client::create($request->except('_token'))->fresh();

        $client->organization_id = Auth::user()->organization()->id;
        $client->save();
        dd($client);
        // $client->country = $request->country
        Auth::user()->assignRole('client');
        return redirect()->back()->with('message', 'New client created');
    }

    public function create_organization(Request $request)
    {

        $country_obj = country()->all();

        // "AC,IC,EA,DG,TA"
        unset($country_obj['AC']);
        unset($country_obj['IC']);
        unset($country_obj['EA']);
        unset($country_obj['DG']);
        unset($country_obj['TA']);

        $countries_codes = array_keys($country_obj);
        $country_names = array_values($country_obj);
        //dd($countries_codes);
        // https://github.com/Propaganistas/Laravel-Phone
        $this->validate($request, [
            'name' => 'required',
            'address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'country' => Rule::country($country_names),
            'phone_number' => Rule::phone()->country($countries_codes),
        ]);
        
        $organization = Organization::create($request->except('_token'))->fresh();
       
        // $zip = $request->input('zip');
        // $organization->zip = isset($zip) ?  $zip: null; 
        // $desc= $request->input('description');
        // $organization->description = isset($desc) ?  $desc: null; 
        // $industry = $request->input('industry');
        // $organization->industry = isset($industry) ?  $industry: null; 
        
        $organization->user_id = Auth::user()->id;
        $organization->save();
        dd($organization);
        // $organization->country = $request->country
        Auth::user()->assignRole('owner');

        return redirect()->back()->with('message', 'Your organization created');
    }

    public function create_team_member(Request $request) {

        $this->validate($request, [
            'name' => 'required',
            'address' => 'required',
            'city' => 'required',
            'state' => 'required',
        ]);
    }

    public function createTodo(Request $request, $p_id, $t_id) {
        
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
                    <a href='#' class='pull-right btn btn-xs btn-white delete_todo' id='delete_todo-".$todo->id."'><i class='trash_todo fa fa-trash'></i> Delete</a>
                    <a href='#' data-toggle='modal' data-target='#agileBoardModal' class='pull-right btn btn-xs btn-white todo_info' id='todo_info-".$todo->id."'><i class='trash_todo fa fa-info'></i> Info</a>
                    <i class='fa fa-clock-o'></i> ".date('M d, Y - h:i:s A', strtotime($todo->created_at))."
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
        $agile_board = AgileBoard::where('team_id', $t_id)->get();
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

    public function new_member()
    {
        $newMember_email = Input::get('email');
        $newMember_userID = DB::table('users')->where('email', $newMember_email);

        $member = new Member;
        $member->team_id = Input::get('team_id');
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
                $upload->teamid = Input::get('team_id');
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
