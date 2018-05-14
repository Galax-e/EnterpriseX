@extends('layouts.master')

@section('header')
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-sm-4">
                    <h2>Project detail</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a href="index-2.html">Home</a>
                        </li>
                        <li class="active">
                            <strong>Project detail</strong>
                        </li>
                    </ol>
                </div>
            </div>
@endsection

@section('content')
        <div class="row">
           <?php #$teams = DB::table('teams')->where('id', $t_id)->get();
            #dd($team);
            ?>
            {{--  @foreach($teams as $team)  --}}
            <div class="col-lg-9">
                <div class="wrapper wrapper-content animated fadeInUp">
                    <div class="ibox">
                        <div class="ibox-content">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="m-b-md">
                                        <a href="#" class="btn btn-white btn-xs pull-right">Edit project</a>
                                        <h2>{{$team->name}}</h2>
                                    </div>
                                    <dl class="dl-horizontal">
                                        <dt>Status:</dt> <dd><span class="label label-primary">Active</span></dd>
                                    </dl>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-5">
                                    <dl class="dl-horizontal">

                                        <dt>Created by:</dt> 
                                        <dd>
                                            <?php $user = DB::table('teams')->whereNotNull('created_by', $team->created_by)->first(); ?>
                                            {{--  @foreach($users as $user)   --}}
                                                {{optional($user)->name}}
                                            {{--  @endforeach  --}}
                                        </dd>
                                        <dt>Messages:</dt> <dd>  162</dd>
                                        <dt>Client:</dt> <dd><a href="#" class="text-navy"> {{$project->client->name or "Name"}}</a> </dd>
                                        <dt>Members:</dt> 
                                        <dd>{{$count}}</dd>
                                    </dl>
                                </div>
                                <div class="col-lg-7" id="cluster_info">
                                    <dl class="dl-horizontal" >

                                        <dt>Last Updated:</dt> <dd>{{ date('d.m.y h:i:s A', strtotime($team->updated_at)) }}</dd>
                                        <dt>Created:</dt> <dd> 	{{ date('d.m.y h:i:s A', strtotime($team->created_at)) }} </dd>
                                        <dt>Participants:</dt>
                                        <dd class="project-people">
                                        <?php $members = DB::table('team_members')->where('team_id', $team->id)->get(); ?>
                                            @foreach($members as $member)
                                                 <a href="#"><img alt="image" class="img-circle" src="{{asset('img/a3.jpg')}}"></a>
                                            @endforeach
                                        </dd>
                                    </dl>
                                </div>
                            </div>
                            <div class="row">
                              <?php
                                    //if (strpos($team->progress_update, 'yes') !== false) {
                                    echo '<div class="col-lg-12">
                                    <dl class="dl-horizontal">
                                        <dt>Completed:</dt>
                                        <dd>
                                            <div class="progress progress-striped active m-b-sm">
                                                <div style="width: 60%;" class="progress-bar"></div>
                                            </div>
                                            <small>Project completed in <strong>60%</strong>. Remaining close the project.</small>
                                        </dd>
                                    </dl>
                                </div>';
                                    //}
                                ?>
                            </div>
                            <div class="row m-t-sm">
                                <div class="col-lg-12">
                                <div class="panel blank-panel">
                                <div class="panel-heading">
                                    <div class="panel-options">
                                        <ul class="nav nav-tabs">
                                            <li class="active"><a href="#tab-1" data-toggle="tab">Users messages</a></li>
                                            <li class=""><a href="#tab-2" data-toggle="tab">Last activity</a></li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="panel-body">

                                <div class="tab-content">
                                <div class="tab-pane active" id="tab-1">
                                    <div class="feed-activity-list">
                                        <div class="feed-element">
                                            <a href="#" class="pull-left">
                                                <img alt="image" class="img-circle" src="{{asset('img/a2.jpg')}}">
                                            </a>
                                            <div class="media-body ">
                                                <small class="pull-right">2h ago</small>
                                                <strong>Mark Johnson</strong> posted message on <strong>Monica Smith</strong> site. <br>
                                                <small class="text-muted">Today 2:10 pm - 12.06.2014</small>
                                                <div class="well">
                                                    Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.
                                                    Over the years, sometimes by accident, sometimes on purpose (injected humour and the like).
                                                </div>
                                            </div>
                                        </div>
                                        <div class="feed-element">
                                            <a href="#" class="pull-left">
                                                <img alt="image" class="img-circle" src="{{asset('img/a3.jpg')}}">
                                            </a>
                                            <div class="media-body ">
                                                <small class="pull-right">2h ago</small>
                                                <strong>Janet Rosowski</strong> add 1 photo on <strong>Monica Smith</strong>. <br>
                                                <small class="text-muted">2 days ago at 8:30am</small>
                                            </div>
                                        </div>
                                        <div class="feed-element">
                                            <a href="#" class="pull-left">
                                                <img alt="image" class="img-circle" src="{{asset('img/a4.jpg')}}">
                                            </a>
                                            <div class="media-body ">
                                                <small class="pull-right text-navy">5h ago</small>
                                                <strong>Chris Johnatan Overtunk</strong> started following <strong>Monica Smith</strong>. <br>
                                                <small class="text-muted">Yesterday 1:21 pm - 11.06.2014</small>
                                                <div class="actions">
                                                    <a class="btn btn-xs btn-white"><i class="fa fa-thumbs-up"></i> Like </a>
                                                    <a class="btn btn-xs btn-white"><i class="fa fa-heart"></i> Love</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="feed-element">
                                            <a href="#" class="pull-left">
                                                <img alt="image" class="img-circle" src="{{asset('img/a5.jpg')}}">
                                            </a>
                                            <div class="media-body ">
                                                <small class="pull-right">2h ago</small>
                                                <strong>Kim Smith</strong> posted message on <strong>Monica Smith</strong> site. <br>
                                                <small class="text-muted">Yesterday 5:20 pm - 12.06.2014</small>
                                                <div class="well">
                                                    Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.
                                                    Over the years, sometimes by accident, sometimes on purpose (injected humour and the like).
                                                </div>
                                            </div>
                                        </div>
                                        <div class="feed-element">
                                            <a href="#" class="pull-left">
                                                <img alt="image" class="img-circle" src="{{asset('img/profile.jpg')}}">
                                            </a>
                                            <div class="media-body ">
                                                <small class="pull-right">23h ago</small>
                                                <strong>Monica Smith</strong> love <strong>Kim Smith</strong>. <br>
                                                <small class="text-muted">2 days ago at 2:30 am - 11.06.2014</small>
                                            </div>
                                        </div>
                                        <div class="feed-element">
                                            <a href="#" class="pull-left">
                                                <img alt="image" class="img-circle" src="{{asset('img/a7.jpg')}}">
                                            </a>
                                            <div class="media-body ">
                                                <small class="pull-right">46h ago</small>
                                                <strong>Mike Loreipsum</strong> started following <strong>Monica Smith</strong>. <br>
                                                <small class="text-muted">3 days ago at 7:58 pm - 10.06.2014</small>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="tab-pane" id="tab-2">

                                    <table class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th>Status</th>
                                            <th>Title</th>
                                            <th>Created at</th>
                                            <th>Activity by</th>
                                            <th>Comments</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php $activities = DB::table('activities')->where('team_id', $team->id)->orderBy('created_at', 'DESC')->get(); ?>
                                        @foreach($activities as $activity)
                                        <tr>
                                            <td>
                                                <span class="label label-primary">
                                                <?php
                                                if (strpos($activity->title, 'file') !== false) {
                                                echo '<i class="fa fa-file"></i> ';
                                                }
                                                else {
                                                echo '<i class="fa fa-check"></i> ';
                                                }
                                            ?> {{$activity->status}}</span>
                                            </td>
                                            <td>
                                               {{$activity->title}}
                                            </td>
                                            <td>
                                               {{ date('M d, Y h:i:s A', strtotime($team->created_at)) }}
                                            </td>
                                            <td>
                                                    <?php $users = DB::table('users')->where('id', $activity->activity_by)->get(); ?>
                                                    @foreach($users as $user)
                                                        {{$user->name}}
                                                    @endforeach
                                            </td>
                                            <td>
                                            <p class="small">
                                                 {!!$activity->comment!!}
                                            </p>
                                            </td>

                                        </tr>
                                        @endforeach
                                       </tbody>
                                    </table>

                                </div>
                                </div>

                                </div>

                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{--  @endforeach  --}}
            <div class="col-lg-3">
                <div class="wrapper wrapper-content project-manager">
                    <h4>Project description</h4>
                     <h2><dt>{{$project->title}}</dt></h2>
                    <p class="small">
                        {{ str_limit($project->description, 500) }}
                    </p>
                    <p class="small font-bold">
                        <span><i class="fa fa-circle text-warning"></i> {{$project->priority }} priority</span>
                    </p>
                    </br>
                    <h5>Project files</h5>
                    <ul class="list-unstyled project-files">
                        <?php $files = DB::table('documents')->where('team_id', $team->id)->get(); ?>
                            @foreach($files as $file)
                                <li><a href="files/{{$file->file}}" target="_blank">
                                <?php
                                    if (strpos($file->file, '.jpg') !== false) {
                                    echo '<i class="fa fa-file-image-o"></i>';
                                    }
                                    elseif (strpos($file->file, '.pdf') !== false) {
                                    echo '<i class="fa fa-file-pdf-o"></i>';
                                    }
                                    elseif (strpos($file->file, '.xlsx') !== false) {
                                    echo '<i class="fa fa-file-excel-o"></i>';
                                    }
                                    elseif (strpos($file->file, '.docx') !== false) {
                                    echo '<i class="fa fa-file"></i>';
                                    }
                                    elseif (strpos($file->file, '.mp4') !== false) {
                                    echo '<i class="fa fa-file-video-o"></i>';
                                    }
                                ?>                                    
                                    {{$file->file_name}}</a>
                                </li>
                            @endforeach
                        <li><a href="#"><i class="fa fa-file"></i> Project_document.docx</a></li>
                        <li><a href="#"><i class="fa fa-file-picture-o"></i> Logo_zender_company.jpg</a></li>
                        <li><a href="#"><i class="fa fa-stack-exchange"></i> Email_from_Alex.mln</a></li>
                        <li><a href="#"><i class="fa fa-file"></i> Contract_20_11_2014.docx</a></li>
                    </ul>
                    
                    <div class="text-center m-t-md">
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
                        
                        <a href="{{url('project/'.$p_id.'/team/'.$t_id.'/'.$board)}}" class="btn btn-xs btn-primary pull-left">Board</a>
                        <a data-toggle="modal" data-target="#myModa16" class="btn btn-xs btn-primary">Add files</a>
                        <a data-toggle="modal" data-target="#myModal5" class="btn btn-xs btn-primary">Add member(s)</a>
                        <div class="modal inmodal fade" id="myModa16" tabindex="-1" role="dialog"  aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                        <i class="fa fa-file modal-icon"></i>
                                        <h4 class="modal-title">Add file</h4>
                                        <small class="font-bold">Enterprise-X is the leading support Software.</small>
                                    </div>
                                    <div class="modal-body">
                                        <form id="image_upload_form" method="post" enctype="multipart/form-data" action='add_file' autocomplete="off">
                                            {!! csrf_field() !!}
                                            <input type="hidden" name="team_id" value="{{$team->id}}">
                                                        <div class="form-group has-feedback">
                                                        <input type="text" name="file_name" class="form-control" placeholder="File title" value="" required autofocus/>
                                                        
                                                    </div> 
                                                    <div class="form-group has-feedback">
                                                        <input type="file" name="upload_images[]" id="image_file" class="form-control" multiple >
                                                        
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
                        <div class="modal inmodal fade" id="myModal5" tabindex="-1" role="dialog"  aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                        <i class="fa fa-users modal-icon"></i>
                                        <h4 class="modal-title">Add new member(s)</h4>
                                        <small class="font-bold">Enterprise-X is the leading support Software.</small>
                                    </div>
                                    <div class="modal-body">
                                        <form method="GET" action="new_member" >
                                            <div class="form-group has-feedback">
                                                <input type="hidden" name="team_id" value="{{$team->id}}"/>
                                                <input type="text" name="email" class="form-control" placeholder="Email" value="" required autofocus/>
                                                <span class="glyphicon glyphicon-user form-control-feedback"></span>
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
                        <br/>
                    </div>
                </div>
            </div>
        </div>
@endsection