@extends('layouts.master')

@section('header')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-4">
            <h2>Team list</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="index-2.html">Home</a>
                </li>
                <li class="active">
                    <strong>Team list</strong>
                </li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <?php ?>
    @if($teams->count() === 0)
        <div class="row panel panel-info">
            <div class="panel-heading">Status</div>
            <div class="panel-body"><b>No Teams in your project, create one</b></div>
        </div>
    @endif
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-title">
                        <h5>Project teams</h5>
                        <div class="ibox-tools">
                            <a data-toggle="modal" data-target="#myModal5" class="btn btn-primary btn-xs">Create new team</a>
                        </div>
                        <!-- Modal located in partials.modals -->
                    </div>
                    <div class="ibox-content">
                        <div class="row m-b-sm m-t-sm">
                            <div class="col-md-1">
                                <button type="button" id="loading-example-btn" class="btn btn-white btn-sm" ><i class="fa fa-refresh"></i> Refresh</button>
                            </div>
                            <div class="col-md-11">
                                <div class="input-group"><input type="text" placeholder="Search" class="input-sm form-control"> <span class="input-group-btn">
                                    <button type="button" class="btn btn-sm btn-primary"> Go!</button> </span></div>
                            </div>
                        </div>
                    </div>
                </div>    
            </div>
            <div class="project-list">
            <?php 
            
            $project = \App\Models\Project::find($id);
            $project_org = $project->organization;
                
            ?>
            @foreach($teams as $team)
                <div class="col-lg-4">
                    <div class="ibox">
                        <div class="ibox-title">
                            {{--  <span class="label label-primary pull-right">NEW</span>  h:i:s A  --}}
                            <h5>{{$team->name}}</h5>
                            <span class="label label-primary pull-right">Created:  {{ date('M d, Y', strtotime($team->created_at)) }}</span>
                        </div>
                        <div class="ibox-content">
                            <div class="team-members">
                                <?php $team_members = DB::table('team_members')->where('team_id', $team->id)->get(); ?>
                                @foreach($team_members as $member)
                                        <a href="#"><img alt="member" class="img-circle" src="{{asset('img/a'.($loop->index+1).'.jpg')}}"></a>
                                @endforeach
                            </div>
                            <h4>Info about Design Team</h4>
                            <p>
                                It is a long established fact that a reader will be distracted by the readable content
                                of a page when looking at its layout. The point of using Lorem Ipsum is that it has.
                            </p>
                            <div>
                                <span>Status of current project:</span>
                                <div class="stat-percent">48%</div>
                                <div class="progress progress-mini">
                                    <div style="width: 48%;" class="progress-bar"></div>
                                </div>
                            </div>
                            <div class="row  m-t-sm">
                                <div class="col-sm-3">
                                    <div class="font-bold">PROJECTS</div>
                                    12
                                </div>
                                <div class="col-sm-3">
                                    <div class="font-bold">RANKING</div>
                                    4th
                                </div>
                                <div class="col-sm-3">
                                    <?php 
                                        $user = Auth::user();
                                        if ($user->hasRole('owner') || $user->hasRole('manager')) {
                                            $board = 'task_board';
                                        }if ($user->hasRole('client') || $user->hasRole('client-manager')) {
                                            $board = 'issue_board';
                                        }
                                        #$member = Auth::user()->member; 
                                        #$team = \App\Models\Team::find($member->id);
                                        #$board = $team->type === 'organization'? 'team_board':'issue_board';
                                        
                                    ?>                                        
                                    <a href="{{url('project/'.$id.'/team/'.$team->id.'/'.$board)}}" class="btn btn-xs btn-primary pull-left">Board</a>
                                </div>
                                <div class="col-sm-3 text-right">
                                    @if( optional(auth()->user()->organization)->id === $project_org->id || auth()->user()->is_client($project_org))
                                        <form method="get" action="{{url('project/'.$id.'/team/'.$team->id.'/team_detail')}}" >
                                            <input type="hidden" name="id" value="{{$team->id}}">
                                            <button class="btn btn-white btn-sm" title="View team details"><i class="fa fa-folder"></i> Team Detail </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- col -->
            @endforeach     
            </div>
        </div> <!-- row -->
    </div> <!-- wrapper -->    
    <script>
    </script>
    <div class="modal inmodal fade" id="myModal5" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <i class="fa fa-users modal-icon"></i>
                    <h4 class="modal-title">Create new team</h4>
                    <small class="font-bold">Enterprise-X is the leading support Software.</small>
                </div> <!-- end modal header -->
                <div class="modal-body">
                    <form method="post" action="{{url('project/'.$id.'/create_team')}}" >
                        <div class="form-group has-feedback">
                            <input type="text" name="name" class="form-control" placeholder="Team name" required autofocus/>
                            <span class="glyphicon glyphicon-user form-control-feedback"></span>
                        </div>
                        {{--  <div class="form-group has-feedback" hidden>
                            <input type="text" name="project_id" value="{{$id}}" class="form-control" required autofocus/>
                        </div>  --}}
                        {{csrf_field()}}
                        {{--  <div class="form-group has-feedback">
                            <input type="text" name="client" class="form-control" placeholder="Client" required autofocus/>
                        </div>
                        <div class="form-group has-feedback">
                            <input type="text" name="project" class="form-control" placeholder="Project title" required autofocus/>
                        </div>
                        <div class="form-group has-feedback">
                            <input type="text" name="description" class="form-control" placeholder="Project description" required autofocus/>
                        </div>  --}}
                        <div class="form-group has-feedback">
                            <table style="width:100%">
                                <tr>
                                    {{--  <td>
                                        <select name="priority" class="form-control" placeholder="City" required>
                                        <option value="">-- Set priority --</option>
                                        <option value="High"> High </option>
                                        <option value="Medium"> Medium </option>
                                        <option value="Low"> Low </option>
                                        </select>
                                    </td>  --}}
                                    {{--  <td>
                                        <select name="updateprogress" class="form-control" placeholder="City" required>
                                        <option value="">-- Update Progress --</option>
                                        <option value="yes"> Yes</option>
                                        <option value="no"> No</option>
                                        </select>
                                    </td>   --}}
                                    <td>
                                        <select name="belongs_to" class="form-control" placeholder="Team belongs to" required>
                                            <option value="">-- Team belongs to --</option>
                                            <option value="organization"> Organization</option>
                                            <option value="client"> Client</option>
                                        </select>
                                    </td> 
                                    {{--  <td>
                                        <select name="priority" class="form-control" placeholder="City" required>
                                        <option value="">-- Select --</option>
                                        </select>
                                    </td>   --}}
                                </tr>
                            </table>
                        </div>
                    </div> <!-- end modal body -->
                    <div class="modal-footer">
                            <input type="submit" value="Submit" class="btn btn-primary">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button> 
                    </form>                                                                                   
                </div> <!-- end modal footer -->
            </div> <!-- end modal content -->
        </div> <!-- end modal dialog -->
    </div> <!-- end modal modal -->
@endsection