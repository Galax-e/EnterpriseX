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
        <div class="row">
            <div class="col-lg-12">
                <div class="wrapper wrapper-content animated fadeInUp">
                    @if (session('message'))
                        <div class="alert alert-info alert-dismissible">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <strong>{{ session('message') }}</strong>
                        </div>
                    @endif
                    <div class="ibox">
                        <div class="ibox-title">
                            <h5>All projects assigned to this account</h5>
                            <div class="ibox-tools">
                                <a data-toggle="modal" data-target="#myModal5" class="btn btn-primary btn-xs">Create new team</a>
                            </div>
                             <div class="modal inmodal fade" id="myModal5" tabindex="-1" role="dialog"  aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                            <i class="fa fa-users modal-icon"></i>
                                            <h4 class="modal-title">Create new team</h4>
                                            <small class="font-bold">Enterprise-X is the leading support Software.</small>
                                        </div>
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
                                       </div>
                                         <div class="modal-footer">
                                        <input type="submit" value="Submit" class="btn btn-primary">
                                            </form>
                                             <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
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

                            <div class="project-list">

                                <table class="table table-hover">
                                    <tbody>
                            <?php $teams = DB::table('teams')->where('project_id', $id)->orderBy('created_at', 'DESC')->get() or die(); ?>
                            @if($teams->count() === 0)
                                <div class="panel panel-info">
                                    <div class="panel-heading">Status</div>
                                    <div class="panel-body"><b>No Teams in your project, create one</b></div>
                                </div>
                            @endif
                            @foreach($teams as $team)
                                    <tr>
                                        <td class="project-status">
                                            <span class="label label-primary">Active</span>
                                        </td>
                                        <td class="project-title">
                                            <a href="#">{{$team->name}}</a>
                                            <br/>
                                            <small>Created:  {{ date('M d, Y h:i:s A', strtotime($team->created_at)) }}</small>
                                        </td>
                                        <td class="project-completion">
                                                <small>Completion with: 48%</small>
                                                <div class="progress progress-mini">
                                                    <div style="width: 48%;" class="progress-bar"></div>
                                                </div>
                                        </td>
                                        <td class="project-people">
                                            <?php $members = DB::table('team_members')->where('team_id', $team->id)->get(); ?>
                                            @foreach($members as $member)
                                                 <a href="#"><img alt="image" class="img-circle" src="{{asset('img/a3.jpg')}}"></a>
                                            @endforeach
                                        </td>
                                        <td class="project-actions">
                                            {{--  <a href="#" class="btn btn-white btn-sm"><i class="fa fa-pencil"></i> Edit </a>  --}}
                                            <form method="get" action="{{url('project/'.$id.'/team/'.$team->id.'/team_detail')}}" >
                                                <input type="hidden" name="id" value="{{$team->id}}">
                                                <button class="btn btn-white btn-sm" title="View team progress"><i class="fa fa-folder"></i> Team Detail </button>
                                            </form>
                                        </td>
                                    </tr>
                    @endforeach
                                    {{--  <tr>
                                        <td class="project-status">
                                            <span class="label label-primary">Active</span>
                                        </td>
                                        <td class="project-title">
                                            <a href="project_detail.html">Contract with Zender Company</a>
                                            <br/>
                                            <small>Created 14.08.2014</small>
                                        </td>
                                        <td class="project-completion">
                                                <small>Completion with: 48%</small>
                                                <div class="progress progress-mini">
                                                    <div style="width: 48%;" class="progress-bar"></div>
                                                </div>
                                        </td>
                                        <td class="project-people">
                                            <a href="#"><img alt="image" class="img-circle" src="{{ asset('img/a3.jpg')}}"></a>
                                            <a href="#"><img alt="image" class="img-circle" src="{{ asset('img/a1.jpg')}}"></a>
                                            <a href="#"><img alt="image" class="img-circle" src="{{ asset('img/a2.jpg')}}"></a>
                                            <a href="#"><img alt="image" class="img-circle" src="{{ asset('img/a4.jpg')}}"></a>
                                            <a href="#"><img alt="image" class="img-circle" src="{{ asset('img/a5.jpg')}}"></a>
                                        </td>
                                        <td class="project-actions">
                                            <a href="#" class="btn btn-white btn-sm"><i class="fa fa-folder"></i> View </a>
                                            <a href="#" class="btn btn-white btn-sm"><i class="fa fa-pencil"></i> Edit </a>
                                        </td>
                                    </tr>        --}}
                                </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
        
    </script>
@endsection